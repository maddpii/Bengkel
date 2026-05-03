<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Sparepart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()?->role === 'customer', 403);

        $transactions = Transaction::query()
            ->whereHas('booking', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with(['booking.vehicle', 'mekanik', 'payment'])
            ->orderByDesc('id')
            ->get();

        return view('transactions.index', compact('transactions'));
    }

    public function create($id)
    {
        abort_unless(auth()->user()?->role === 'mekanik', 403);

        $booking = Booking::with('services')->findOrFail($id);
        $total = $booking->services->sum('pivot.price');

        $transaction = Transaction::firstOrCreate(
            ['booking_id' => $id],
            [
                'mekanik_id' => auth()->id(),
                'total_service' => $total,
                'grand_total' => $total,
            ]
        );

        return redirect('/transactions/' . $transaction->id);
    }

    public function show($id)
    {
        $transaction = Transaction::with(['booking.services', 'booking.vehicle', 'spareparts', 'mekanik', 'payment', 'kasir', 'review'])
            ->findOrFail($id);

        $role = auth()->user()?->role;

        if ($role === 'customer') {
            abort_unless($transaction->booking && $transaction->booking->user_id === auth()->id(), 403);
        }

        $availableSpareparts = collect();

        if (in_array($role, ['mekanik', 'kasir'], true)) {
            $availableSpareparts = Sparepart::query()
                ->where('stock', '>', 0)
                ->orderBy('name')
                ->get();
        }

        return view('transactions.show', compact('transaction', 'availableSpareparts'));
    }

    public function storeReview(Request $request, Transaction $transaction)
    {
        abort_unless(auth()->user()?->role === 'customer', 403);

        $transaction->load(['booking', 'payment', 'review']);

        abort_unless($transaction->booking && $transaction->booking->user_id === auth()->id(), 403);
        abort_unless($transaction->payment?->payment_status === 'paid', 403, 'Ulasan hanya bisa dikirim setelah pembayaran lunas.');

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $transaction->review()->updateOrCreate(
            ['transaction_id' => $transaction->id],
            [
                'user_id' => auth()->id(),
                'rating' => $validated['rating'],
                'review_text' => trim($validated['review_text']),
            ]
        );

        return back()->with('success', 'Ulasan berhasil disimpan.');
    }

    public function invoice($id)
    {
        $transaction = Transaction::with(['booking.user', 'booking.services', 'booking.vehicle', 'spareparts', 'mekanik', 'payment', 'kasir'])
            ->findOrFail($id);

        $role = auth()->user()?->role;

        if ($role === 'customer') {
            abort_unless($transaction->booking && $transaction->booking->user_id === auth()->id(), 403);
        } else {
            abort_unless(in_array($role, ['admin', 'mekanik', 'kasir', 'owner'], true), 403);
        }

        abort_unless($transaction->payment || $transaction->processed_at, 404);

        $serviceItems = collect($transaction->booking?->services ?? [])
            ->map(function ($service) {
                return [
                    'name' => $service->service_name,
                    'qty' => 1,
                    'price' => (float) $service->pivot->price,
                    'subtotal' => (float) $service->pivot->price,
                ];
            });

        if (($transaction->manual_service_price ?? 0) > 0 || filled($transaction->manual_service_name)) {
            $serviceItems->push([
                'name' => $transaction->manual_service_name ?: 'Biaya jasa tambahan',
                'qty' => 1,
                'price' => (float) $transaction->manual_service_price,
                'subtotal' => (float) $transaction->manual_service_price,
            ]);
        }

        $sparepartItems = $transaction->spareparts->map(function ($sparepart) {
            return [
                'name' => $sparepart->name,
                'qty' => (int) $sparepart->pivot->qty,
                'price' => (float) $sparepart->pivot->price,
                'subtotal' => (float) $sparepart->pivot->subtotal,
            ];
        });

        return view('transactions.invoice', compact('transaction', 'serviceItems', 'sparepartItems'));
    }

    public function addSparepart(Request $request)
    {
        abort_unless(in_array(auth()->user()?->role, ['mekanik', 'kasir'], true), 403);

        $validated = $request->validate([
            'transaction_id' => ['required', 'exists:transactions,id'],
            'sparepart_id' => ['required', 'exists:spareparts,id'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($validated) {
            $transaction = Transaction::with(['booking', 'payment'])->findOrFail($validated['transaction_id']);

            if (
                auth()->user()?->role === 'mekanik'
                && ($transaction->booking?->status === 'completed' || $transaction->payment?->payment_status === 'paid')
            ) {
                abort(403, 'Booking yang sudah selesai tidak bisa ditambah sparepart lagi oleh mekanik.');
            }

            $sparepart = Sparepart::lockForUpdate()->findOrFail($validated['sparepart_id']);

            abort_if($sparepart->stock < $validated['qty'], 422, 'Stok sparepart tidak mencukupi.');

            $subtotal = $sparepart->price * $validated['qty'];
            $existing = $transaction->spareparts()
                ->where('sparepart_id', $sparepart->id)
                ->first();

            if ($existing) {
                $newQty = $existing->pivot->qty + $validated['qty'];
                $newSubtotal = $sparepart->price * $newQty;

                $transaction->spareparts()->updateExistingPivot($sparepart->id, [
                    'qty' => $newQty,
                    'price' => $sparepart->price,
                    'purchase_price' => $sparepart->purchase_price,
                    'subtotal' => $newSubtotal,
                ]);
            } else {
                $transaction->spareparts()->attach($sparepart->id, [
                    'qty' => $validated['qty'],
                    'price' => $sparepart->price,
                    'purchase_price' => $sparepart->purchase_price,
                    'subtotal' => $subtotal,
                ]);
            }

            $sparepart->decrement('stock', $validated['qty']);

            $transaction->load('spareparts');
            $transaction->total_sparepart = $transaction->spareparts->sum('pivot.subtotal');
            $transaction->grand_total = $transaction->total_service + $transaction->total_sparepart;
            $transaction->save();
        });

        return back()->with('success', 'Sparepart berhasil ditambahkan.');
    }
}
