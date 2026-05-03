<?php

namespace App\Http\Controllers;

use App\Models\ServiceReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceReviewAdminController extends Controller
{
    public function index(Request $request): View
    {
        $query = ServiceReview::query()
            ->with(['user', 'transaction.booking.vehicle'])
            ->latest();

        if ($request->filled('keyword')) {
            $keyword = trim((string) $request->input('keyword'));

            $query->where(function ($builder) use ($keyword) {
                $builder->where('review_text', 'like', '%' . $keyword . '%')
                    ->orWhereHas('user', function ($userQuery) use ($keyword) {
                        $userQuery->where('name', 'like', '%' . $keyword . '%')
                            ->orWhere('email', 'like', '%' . $keyword . '%');
                    })
                    ->orWhereHas('transaction.booking', function ($bookingQuery) use ($keyword) {
                        $bookingQuery->where('customer_license_plate', 'like', '%' . $keyword . '%')
                            ->orWhere('customer_vehicle_model', 'like', '%' . $keyword . '%');
                    });
            });
        }

        $reviews = $query->paginate(10)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(ServiceReview $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', 'Ulasan client berhasil dihapus.');
    }
}
