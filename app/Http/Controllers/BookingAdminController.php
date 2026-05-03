<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'vehicle', 'services', 'transaction.mekanik'])
            ->latest();

        if ($request->filled('month')) {
            $query->whereMonth('booking_date', $request->integer('month'));
        }

        if ($request->filled('year')) {
            $query->whereYear('booking_date', $request->integer('year'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        $bookings = $query->get();

        return view('admin.bookings.index', compact('bookings'));
    }
}
