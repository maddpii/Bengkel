<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CashierTransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::query()
            ->with(['booking.user', 'booking.vehicle', 'mekanik', 'payment', 'spareparts'])
            ->whereHas('booking', function ($query) {
                $query->where('status', 'completed');
            })
            ->whereNotNull('work_summary')
            ->whereNotNull('cashier_ready_at')
            ->orderByDesc('id')
            ->get();

        return view('cashier.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['booking.user', 'booking.vehicle', 'booking.services', 'mekanik', 'spareparts', 'payment']);

        return view('cashier.transactions.show', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'manual_service_name' => ['nullable', 'string', 'max:255'],
            'manual_service_price' => ['nullable', 'numeric', 'min:0'],
            'cashier_notes' => ['nullable', 'string'],
        ]);

        $shouldNotifyCustomer = false;

        DB::transaction(function () use ($validated, $transaction, &$shouldNotifyCustomer) {
            $transaction->loadMissing(['booking.services', 'spareparts', 'payment']);

            $baseServiceTotal = $transaction->booking?->services?->sum('pivot.price') ?? 0;
            $manualServicePrice = (float) ($validated['manual_service_price'] ?? 0);
            $totalSparepart = $transaction->spareparts->sum('pivot.subtotal');
            $totalService = $baseServiceTotal + $manualServicePrice;
            $grandTotal = $totalService + $totalSparepart;
            $transaction->update([
                'kasir_id' => auth()->id(),
                'manual_service_name' => filled($validated['manual_service_name'] ?? null) ? trim($validated['manual_service_name']) : null,
                'manual_service_price' => $manualServicePrice,
                'cashier_notes' => filled($validated['cashier_notes'] ?? null) ? trim($validated['cashier_notes']) : null,
                'total_service' => $totalService,
                'total_sparepart' => $totalSparepart,
                'grand_total' => $grandTotal,
                'processed_at' => now(),
                'cashier_ready_at' => $transaction->cashier_ready_at ?? now(),
            ]);

            $payment = Payment::query()->updateOrCreate(
                ['transaction_id' => $transaction->id],
                [
                    'payment_date' => now()->toDateString(),
                    'amount_paid' => 0,
                    'payment_method' => 'transfer',
                    'payment_status' => 'unpaid',
                    'payer_name' => null,
                    'payer_notes' => null,
                    'submitted_at' => null,
                    'midtrans_order_id' => null,
                    'midtrans_transaction_id' => null,
                    'midtrans_status' => null,
                    'snap_token' => null,
                    'midtrans_response' => null,
                ]
            );

            $shouldNotifyCustomer = is_null($payment->payment_ready_notified_at);
        });

        $transaction->load(['booking.user', 'booking.vehicle', 'payment']);

        if ($shouldNotifyCustomer && $transaction->booking?->user?->email && $transaction->payment) {
            Mail::send('emails.payment-ready', [
                'transaction' => $transaction,
                'customer' => $transaction->booking->user,
                'payment' => $transaction->payment,
            ], function ($message) use ($transaction) {
                $message->to($transaction->booking->user->email, $transaction->booking->user->name)
                    ->subject('Servis Selesai - Tagihan Bengkel Mobil Siap Dibayar');
            });

            $transaction->payment->forceFill([
                'payment_ready_notified_at' => now(),
            ])->save();
        }

        return redirect()
            ->route('cashier.transactions.show', $transaction)
            ->with('success', 'Perhitungan kasir berhasil disimpan dan tagihan sudah dikirim ke client.');
    }
}
