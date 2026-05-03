<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->buildReportData($request);

        return view('reports.index', $data);
    }

    public function finance(Request $request)
    {
        $data = $this->buildReportData($request);

        $financialRows = collect($data['transactions'])
            ->map(function ($transaction) {
                $expense = (float) $transaction->spareparts->sum(function ($sparepart) {
                    return (float) $sparepart->pivot->purchase_price * (int) $sparepart->pivot->qty;
                });

                $revenue = (float) $transaction->grand_total;

                return [
                    'booking_id' => $transaction->booking?->id,
                    'date' => $transaction->booking?->booking_date,
                    'customer' => $transaction->booking?->user?->name ?? '-',
                    'vehicle' => trim(($transaction->booking?->vehicle?->brand ?? '') . ' ' . ($transaction->booking?->customer_vehicle_model ?? '')),
                    'license_plate' => $transaction->booking?->customer_license_plate ?? '-',
                    'mechanic' => $transaction->mekanik?->name ?? '-',
                    'revenue' => $revenue,
                    'expense' => $expense,
                    'profit' => $revenue - $expense,
                ];
            })
            ->values();

        return view('reports.finance', array_merge($data, [
            'financialRows' => $financialRows,
        ]));
    }

    protected function buildReportData(Request $request): array
    {
        $month = (int) ($request->input('month', now()->month));
        $year = (int) ($request->input('year', now()->year));
        $months = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $bookingQuery = Booking::query()
            ->whereMonth('booking_date', $month)
            ->whereYear('booking_date', $year);

        $bookings = (clone $bookingQuery)
            ->with(['user', 'vehicle', 'services', 'transaction.mekanik'])
            ->orderByDesc('booking_date')
            ->orderByDesc('booking_time')
            ->get();

        $transactions = Transaction::query()
            ->whereHas('booking', function ($query) use ($month, $year) {
                $query->whereMonth('booking_date', $month)
                    ->whereYear('booking_date', $year);
            })
            ->with(['booking.user', 'booking.vehicle', 'booking.services', 'mekanik', 'spareparts'])
            ->orderByDesc('id')
            ->get();

        $vehicleStats = DB::table('bookings')
            ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
            ->leftJoin('transactions', 'transactions.booking_id', '=', 'bookings.id')
            ->select(
                'vehicles.id',
                'vehicles.brand',
                'bookings.customer_vehicle_model',
                'bookings.customer_license_plate as license_plate',
                DB::raw('COUNT(bookings.id) as service_count'),
                DB::raw('SUM(COALESCE(transactions.grand_total, 0)) as total_revenue')
            )
            ->whereMonth('bookings.booking_date', $month)
            ->whereYear('bookings.booking_date', $year)
            ->groupBy('vehicles.id', 'vehicles.brand', 'bookings.customer_vehicle_model', 'bookings.customer_license_plate')
            ->orderByDesc('service_count')
            ->get();

        $monthlyBookingsRaw = Booking::query()
            ->selectRaw('MONTH(booking_date) as month_number, COUNT(*) as total')
            ->whereYear('booking_date', $year)
            ->groupBy(DB::raw('MONTH(booking_date)'))
            ->pluck('total', 'month_number');

        $monthlyRevenueRaw = Transaction::query()
            ->join('bookings', 'bookings.id', '=', 'transactions.booking_id')
            ->selectRaw('MONTH(bookings.booking_date) as month_number, SUM(transactions.grand_total) as total')
            ->whereYear('bookings.booking_date', $year)
            ->groupBy(DB::raw('MONTH(bookings.booking_date)'))
            ->pluck('total', 'month_number');

        $monthlyExpenseRaw = DB::table('transaction_spareparts')
            ->join('transactions', 'transactions.id', '=', 'transaction_spareparts.transaction_id')
            ->join('bookings', 'bookings.id', '=', 'transactions.booking_id')
            ->selectRaw('MONTH(bookings.booking_date) as month_number, SUM(transaction_spareparts.purchase_price * transaction_spareparts.qty) as total')
            ->whereYear('bookings.booking_date', $year)
            ->groupBy(DB::raw('MONTH(bookings.booking_date)'))
            ->pluck('total', 'month_number');

        $statusBreakdownRaw = Booking::query()
            ->selectRaw('status, COUNT(*) as total')
            ->whereMonth('booking_date', $month)
            ->whereYear('booking_date', $year)
            ->groupBy('status')
            ->pluck('total', 'status');

        $brandPerformance = DB::table('bookings')
            ->join('vehicles', 'vehicles.id', '=', 'bookings.vehicle_id')
            ->select('vehicles.brand', DB::raw('COUNT(bookings.id) as total'))
            ->whereMonth('bookings.booking_date', $month)
            ->whereYear('bookings.booking_date', $year)
            ->whereNotNull('vehicles.brand')
            ->groupBy('vehicles.brand')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $yearSummary = [
            'booking_count' => Booking::query()->whereYear('booking_date', $year)->count(),
            'revenue_total' => Transaction::query()
                ->join('bookings', 'bookings.id', '=', 'transactions.booking_id')
                ->whereYear('bookings.booking_date', $year)
                ->sum('transactions.grand_total'),
            'expense_total' => (float) DB::table('transaction_spareparts')
                ->join('transactions', 'transactions.id', '=', 'transaction_spareparts.transaction_id')
                ->join('bookings', 'bookings.id', '=', 'transactions.booking_id')
                ->whereYear('bookings.booking_date', $year)
                ->sum(DB::raw('transaction_spareparts.purchase_price * transaction_spareparts.qty')),
        ];

        $expenseTotal = (float) DB::table('transaction_spareparts')
            ->join('transactions', 'transactions.id', '=', 'transaction_spareparts.transaction_id')
            ->join('bookings', 'bookings.id', '=', 'transactions.booking_id')
            ->whereMonth('bookings.booking_date', $month)
            ->whereYear('bookings.booking_date', $year)
            ->sum(DB::raw('transaction_spareparts.purchase_price * transaction_spareparts.qty'));

        $summary = [
            'booking_count' => $bookings->count(),
            'completed_count' => $bookings->where('status', 'completed')->count(),
            'vehicle_count' => $bookings
                ->map(fn ($booking) => $booking->customer_license_plate ?: 'vehicle-'.$booking->vehicle_id)
                ->filter()
                ->unique()
                ->count(),
            'revenue_total' => $transactions->sum('grand_total'),
            'expense_total' => $expenseTotal,
            'gross_profit' => $transactions->sum('grand_total') - $expenseTotal,
            'average_ticket' => (float) $transactions->avg('grand_total'),
        ];

        $chartData = [
            'monthLabels' => array_values($months),
            'bookingsByMonth' => collect(array_keys($months))
                ->map(fn ($monthNumber) => (int) ($monthlyBookingsRaw[$monthNumber] ?? 0))
                ->values(),
            'revenueByMonth' => collect(array_keys($months))
                ->map(fn ($monthNumber) => (float) ($monthlyRevenueRaw[$monthNumber] ?? 0))
                ->values(),
            'expenseByMonth' => collect(array_keys($months))
                ->map(fn ($monthNumber) => (float) ($monthlyExpenseRaw[$monthNumber] ?? 0))
                ->values(),
            'statusLabels' => ['Dikonfirmasi', 'Dikerjakan', 'Selesai'],
            'statusValues' => [
                (int) ($statusBreakdownRaw['confirmed'] ?? 0),
                (int) ($statusBreakdownRaw['in_progress'] ?? 0),
                (int) ($statusBreakdownRaw['completed'] ?? 0),
            ],
            'brandLabels' => $brandPerformance->pluck('brand')->values(),
            'brandValues' => $brandPerformance->pluck('total')->map(fn ($total) => (int) $total)->values(),
        ];

        return compact('bookings', 'transactions', 'vehicleStats', 'summary', 'month', 'months', 'year', 'yearSummary', 'chartData');
    }
}
