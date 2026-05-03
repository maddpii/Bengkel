<?php

namespace App\Http\Controllers;

use App\Models\ServiceReview;
use App\Models\SiteContent;

class HomeController extends Controller
{
    public function index()
    {
        $site = SiteContent::current();
        $reviews = ServiceReview::query()
            ->with(['user', 'transaction.booking.vehicle'])
            ->latest()
            ->take(12)
            ->get();

        return view('home', compact('site', 'reviews'));
    }
}
