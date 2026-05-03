<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Sparepart;
use App\Models\Transaction;
use Illuminate\Http\Request;

class MechanicBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'vehicle', 'services', 'transaction'])
            ->whereIn('status', ['confirmed', 'in_progress', 'completed']);

        if ($request->filled('plate')) {
            $plate = $request->string('plate')->toString();
            $query->where('customer_license_plate', 'like', '%' . $plate . '%');
        }

        $bookings = $query
            ->orderByRaw("FIELD(status, 'in_progress', 'confirmed', 'completed')")
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->get();

        return view('mechanic.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'vehicle', 'services', 'transaction.spareparts', 'transaction.payment']);

        abort_unless(in_array($booking->status, ['confirmed', 'in_progress', 'completed'], true), 404);

        $transaction = Transaction::firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'mekanik_id' => auth()->id(),
                'total_service' => $booking->services->sum('pivot.price'),
                'grand_total' => $booking->services->sum('pivot.price'),
            ]
        );

        $transaction->load('spareparts');

        $availableSpareparts = Sparepart::query()
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        $isLockedForMechanic = $booking->status === 'completed'
            || ($transaction->payment?->payment_status === 'paid');

        return view('mechanic.bookings.show', compact('booking', 'transaction', 'availableSpareparts', 'isLockedForMechanic'));
    }

    public function update(Request $request, Booking $booking)
    {
        $booking->loadMissing('transaction.payment');

        abort_if(
            $booking->status === 'completed' || ($booking->transaction?->payment?->payment_status === 'paid'),
            403,
            'Booking yang sudah selesai tidak bisa diinput ulang oleh mekanik.'
        );

        $validated = $request->validate([
            'status' => ['required', 'in:in_progress,completed'],
            'work_summary' => ['required', 'string'],
            'work_recommendation' => ['nullable', 'string'],
        ]);

        $booking->loadMissing('services');

        $transaction = Transaction::firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'mekanik_id' => auth()->id(),
                'total_service' => $booking->services->sum('pivot.price'),
                'grand_total' => $booking->services->sum('pivot.price'),
            ]
        );

        $transaction->fill([
            'mekanik_id' => auth()->id(),
            'total_service' => $booking->services->sum('pivot.price'),
            'grand_total' => $booking->services->sum('pivot.price') + $transaction->total_sparepart,
            'work_summary' => $validated['work_summary'],
            'work_recommendation' => $validated['work_recommendation'] ?? null,
            'completed_at' => $validated['status'] === 'completed' ? now() : null,
            'cashier_ready_at' => $validated['status'] === 'completed' ? now() : null,
        ]);
        $transaction->save();

        $booking->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('mechanic.bookings.show', $booking)
            ->with('success', $validated['status'] === 'completed'
                ? 'Rekap pekerjaan servis berhasil disimpan dan sudah siap diproses kasir.'
                : 'Rekap pekerjaan servis berhasil disimpan.'
            );
    }
}
