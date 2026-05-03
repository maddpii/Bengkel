<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\JenisVehicle;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['vehicle', 'transaction', 'services'])
            ->where('user_id', auth()->id())
            ->orderByDesc('booking_date')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $vehicles = JenisVehicle::query()
            ->select('id', 'brand')
            ->orderBy('brand')
            ->get();

        return view('bookings.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => ['required', 'exists:jenis_vehicles,id'],
            'customer_vehicle_model' => ['required', 'string', 'max:50'],
            'customer_license_plate' => ['required', 'string', 'max:20'],
            'customer_vehicle_color' => ['required', 'string', 'max:30'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'complaint' => ['nullable', 'string'],
        ]);

        $vehicleType = JenisVehicle::findOrFail($validated['vehicle_id']);

        DB::transaction(function () use ($validated, $vehicleType) {
            $customerVehicle = Vehicle::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'brand' => $vehicleType->brand,
                    'model' => trim($validated['customer_vehicle_model']),
                    'license_plate' => strtoupper(trim($validated['customer_license_plate'])),
                ],
                [
                    'year' => null,
                    'color' => trim($validated['customer_vehicle_color']),
                ]
            );

            if ($customerVehicle->color !== trim($validated['customer_vehicle_color'])) {
                $customerVehicle->update([
                    'color' => trim($validated['customer_vehicle_color']),
                ]);
            }

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'vehicle_id' => $customerVehicle->id,
                'customer_vehicle_model' => trim($validated['customer_vehicle_model']),
                'customer_license_plate' => strtoupper(trim($validated['customer_license_plate'])),
                'customer_vehicle_color' => trim($validated['customer_vehicle_color']),
                'booking_date' => $validated['booking_date'],
                'booking_time' => $validated['booking_time'],
                'complaint' => filled($validated['complaint'] ?? null) ? trim($validated['complaint']) : null,
                // Booking baru langsung masuk antrean mekanik.
                'status' => 'confirmed',
            ]);
        });

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking berhasil dibuat dan sudah masuk ke daftar kerja mekanik.');
    }

    public function show(Booking $booking)
    {
        abort_unless($booking->user_id === auth()->id(), 403);

        $booking->load(['vehicle', 'services', 'transaction']);

        return view('bookings.detail', compact('booking'));
    }
}
