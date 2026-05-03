@extends('layout.admin')

@section('title', 'Dashboard Bengkel')
@section('page_title', 'Dashboard Bengkel')

@section('breadcrumb_right')
    <span class="badge badge-light px-3 py-2">Periode {{ $months[$month] ?? $month }} {{ $year }}</span>
@endsection

@push('styles')
    <style>
        .dashboard-panel-card{height:100%}
        .dashboard-chart-card .card-body{min-height:360px}
        .dashboard-chart-card canvas{height:280px!important}
        .dashboard-table-card .card-body{display:flex;flex-direction:column}
        .dashboard-table-wrap{overflow:auto}
        .dashboard-table-wrap.table-tall{max-height:460px}
        .dashboard-table{margin-bottom:0;table-layout:fixed;width:100%}
        .dashboard-table th,.dashboard-table td{padding:.9rem .85rem;word-wrap:break-word}
        .dashboard-table td{font-size:.92rem}
        .dashboard-table .service-list{display:flex;flex-direction:column;gap:.35rem}
        .dashboard-table .service-chip{background:#eef6ff;border-radius:999px;color:#1f4b7a;display:inline-flex;font-size:.78rem;font-weight:700;padding:.28rem .65rem;width:max-content;max-width:100%}
        .dashboard-table .summary-row td{background:#f8fafc;font-size:.88rem;line-height:1.6}
        .dashboard-table .cell-muted{color:#7b879d;font-size:.84rem}
        .dashboard-card-accent{border:0;overflow:hidden;position:relative}
        .dashboard-card-accent::after{content:"";position:absolute;inset:auto -20% -35% auto;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.12)}
        @media (max-width:991.98px){
            .dashboard-chart-card .card-body{min-height:auto}
            .dashboard-chart-card canvas{height:240px!important}
            .dashboard-table{min-width:760px;table-layout:auto}
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Filter Dashboard</h5>
                <p class="text-muted mb-4">Pilih bulan dan tahun untuk melihat performa operasional bengkel pada periode tertentu.</p>
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Bulan</label>
                        <select name="month" class="form-control">
                            @foreach ($months as $number => $label)
                                <option value="{{ $number }}" @selected($month === $number)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tahun</label>
                        <input type="number" min="2024" name="year" class="form-control" value="{{ $year }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-block">Tampilkan Dashboard</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card dashboard-panel-card dashboard-card-accent text-white" style="background:linear-gradient(135deg,#1c7ed6 0%,#1971c2 100%);">
            <div class="card-body">
                <div class="small text-uppercase">Booking Periode Ini</div>
                <h3 class="mb-1 mt-2">{{ $summary['booking_count'] }}</h3>
                <div class="small">{{ $yearSummary['booking_count'] }} booking sepanjang {{ $year }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card dashboard-panel-card dashboard-card-accent text-white" style="background:linear-gradient(135deg,#12b886 0%,#0ca678 100%);">
            <div class="card-body">
                <div class="small text-uppercase">Servis Selesai</div>
                <h3 class="mb-1 mt-2">{{ $summary['completed_count'] }}</h3>
                <div class="small">{{ $summary['vehicle_count'] }} kendaraan unik masuk di periode ini</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card dashboard-panel-card dashboard-card-accent text-white" style="background:linear-gradient(135deg,#f59f00 0%,#f08c00 100%);">
            <div class="card-body">
                <div class="small text-uppercase">Booking Dikerjakan</div>
                <h3 class="mb-1 mt-2">{{ $bookings->where('status', 'in_progress')->count() }}</h3>
                <div class="small">Unit yang masih dalam proses pengerjaan saat periode ini</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card dashboard-panel-card dashboard-card-accent text-white" style="background:linear-gradient(135deg,#7048e8 0%,#5f3dc4 100%);">
            <div class="card-body">
                <div class="small text-uppercase">Total Nilai Servis</div>
                <h3 class="mb-1 mt-2">Rp {{ number_format($vehicleStats->sum('total_revenue'), 0, ',', '.') }}</h3>
                <div class="small">Akumulasi nilai servis kendaraan pada periode ini</div>
            </div>
        </div>
    </div>

    <div class="col-xl-7">
        <div class="card dashboard-chart-card">
            <div class="card-body">
                <h5 class="card-title">Tren Booking dan Pengeluaran Tahunan</h5>
                <p class="text-muted mb-3">Pergerakan jumlah booking dan pengeluaran sparepart tiap bulan sepanjang tahun {{ $year }}.</p>
                <canvas id="yearlyPerformanceChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-5">
        <div class="card dashboard-chart-card">
            <div class="card-body">
                <h5 class="card-title">Status Booking Periode Ini</h5>
                <p class="text-muted mb-3">Komposisi status booking untuk {{ $months[$month] ?? $month }} {{ $year }}.</p>
                <canvas id="bookingStatusChart" height="260"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card dashboard-chart-card">
            <div class="card-body">
                <h5 class="card-title">Merek Mobil Paling Sering Dipilih</h5>
                <p class="text-muted mb-3">Merek kendaraan yang paling sering masuk servis pada periode terpilih.</p>
                <canvas id="servicePerformanceChart" height="260"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card dashboard-table-card dashboard-panel-card">
            <div class="card-body">
                <h5 class="card-title">Kendaraan Servis Periode Ini</h5>
                <p class="text-muted mb-3">Daftar kendaraan yang masuk bengkel, jumlah kunjungan, dan nilai servisnya.</p>
                <div class="table-responsive dashboard-table-wrap">
                    <table class="table table-hover dashboard-table">
                        <thead>
                            <tr>
                                <th>Kendaraan</th>
                                <th>Plat</th>
                                <th>Jumlah Servis</th>
                                <th>Total Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($vehicleStats as $vehicle)
                                <tr>
                                    <td>{{ trim($vehicle->brand . ' ' . $vehicle->customer_vehicle_model) }}</td>
                                    <td>{{ $vehicle->license_plate }}</td>
                                    <td><span class="badge bg-primary">{{ $vehicle->service_count }}</span></td>
                                    <td>Rp {{ number_format($vehicle->total_revenue, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada kendaraan servis pada periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card dashboard-table-card">
            <div class="card-body">
                <h5 class="card-title">Detail Layanan Servis</h5>
                <p class="text-muted mb-3">Riwayat transaksi, mekanik yang menangani, dan rekap pekerjaan pada periode terpilih.</p>
                <div class="table-responsive dashboard-table-wrap table-tall">
                    <table class="table table-hover dashboard-table">
                        <thead>
                            <tr>
                                <th>Booking</th>
                                <th>Client</th>
                                <th>Kendaraan</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Mekanik</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $transaction)
                                <tr>
                                    <td>#{{ $transaction->booking?->id }}</td>
                                    <td>{{ $transaction->booking?->user?->name ?? '-' }}</td>
                                    <td>
                                        {{ trim(($transaction->booking?->vehicle?->brand ?? '') . ' ' . ($transaction->booking?->customer_vehicle_model ?? '')) }}
                                        <br><span class="cell-muted">{{ $transaction->booking?->customer_license_plate }}</span>
                                    </td>
                                    <td>
                                        <div class="service-list">
                                            @foreach ($transaction->booking?->services ?? [] as $service)
                                                <span class="service-chip">{{ $service->service_name }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match ($transaction->booking?->status) {
                                                'completed' => 'bg-success',
                                                'in_progress' => 'bg-warning',
                                                'confirmed' => 'bg-primary',
                                                'cancelled' => 'bg-danger',
                                                default => 'badge-light',
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $transaction->booking?->status ?? '-')) }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->mekanik?->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                </tr>
                                @if ($transaction->work_summary)
                                    <tr class="summary-row">
                                        <td colspan="7" class="text-muted">
                                            <strong>Rekap:</strong> {{ $transaction->work_summary }}
                                            @if ($transaction->work_recommendation)
                                                <br><strong>Rekomendasi:</strong> {{ $transaction->work_recommendation }}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada transaksi servis pada periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('materialdash/assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script>
        (function () {
            var chartData = @json($chartData);

            var yearlyCtx = document.getElementById('yearlyPerformanceChart');
            if (yearlyCtx) {
                new Chart(yearlyCtx, {
                    type: 'bar',
                    data: {
                        labels: chartData.monthLabels,
                        datasets: [
                            {
                                label: 'Booking',
                                data: chartData.bookingsByMonth,
                                backgroundColor: 'rgba(28, 126, 214, 0.82)',
                                borderRadius: 14,
                                maxBarThickness: 34
                            },
                            {
                                type: 'line',
                                label: 'Pengeluaran Sparepart',
                                data: chartData.expenseByMonth,
                                borderColor: '#e03131',
                                backgroundColor: 'rgba(224, 49, 49, 0.12)',
                                borderWidth: 3,
                                fill: false,
                                pointBackgroundColor: '#e03131',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                yAxisID: 'y-expense'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: { position: 'bottom' },
                        scales: {
                            yAxes: [
                                {
                                    id: 'y-booking',
                                    position: 'left',
                                    ticks: { beginAtZero: true, precision: 0 }
                                },
                                {
                                    id: 'y-expense',
                                    position: 'right',
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function (value) {
                                            return 'Rp ' + Number(value).toLocaleString('id-ID');
                                        }
                                    },
                                    gridLines: { drawOnChartArea: false }
                                }
                            ]
                        },
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var label = data.datasets[tooltipItem.datasetIndex].label + ': ';
                                    if (tooltipItem.datasetIndex === 1) {
                                        return label + 'Rp ' + Number(tooltipItem.yLabel).toLocaleString('id-ID');
                                    }

                                    return label + tooltipItem.yLabel;
                                }
                            }
                        }
                    }
                });
            }

            var statusCtx = document.getElementById('bookingStatusChart');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: chartData.statusLabels,
                        datasets: [{
                            data: chartData.statusValues,
                            backgroundColor: ['#1c7ed6', '#f59f00', '#12b886'],
                            borderWidth: 0
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, legend: { position: 'bottom' } }
                });
            }

            var serviceCtx = document.getElementById('servicePerformanceChart');
            if (serviceCtx) {
                new Chart(serviceCtx, {
                    type: 'horizontalBar',
                    data: {
                        labels: chartData.brandLabels,
                        datasets: [{
                            label: 'Jumlah Kendaraan',
                            data: chartData.brandValues,
                            backgroundColor: ['#1c7ed6', '#2f9e44', '#f59f00', '#7048e8', '#fa5252']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: { display: false },
                        scales: { xAxes: [{ ticks: { beginAtZero: true, precision: 0 } }] }
                    }
                });
            }
        })();
    </script>
@endpush
