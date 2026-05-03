<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Transaction;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function bookings()
    {
        $bookings = Booking::where('user_id', auth()->id())->get();
        return view('admin.bookings.customer', compact('bookings'));
    }

    public function transactions()
    {
        $transactions = Transaction::where('user_id', auth()->id())->get();
        return view('admin.transactions.customer', compact('transactions'));
    }
}
