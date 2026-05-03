@extends('layout.app')

@push('styles')
<style>
    .client-shell {
        margin-top: 40px;
        margin-bottom: 60px;
    }

    .soft-panel {
        border: 0;
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(25, 39, 52, 0.08);
        overflow: hidden;
    }

    .soft-stat {
        border-radius: 20px;
        background: linear-gradient(135deg, #fff8f1 0%, #ffffff 100%);
        border: 1px solid rgba(231, 76, 60, 0.08);
        padding: 20px 22px;
        height: 100%;
    }

    .soft-stat h3 {
        margin: 10px 0 0;
        font-size: 1.85rem;
        font-weight: 700;
        color: #2e2e2e;
    }

    .booking-table thead th {
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #8f8f8f;
        border-bottom: 0;
        padding: 18px 20px;
    }

    .booking-table tbody td {
        padding: 20px;
        vertical-align: middle;
        border-color: #f1f1f1;
    }

    .vehicle-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 999px;
        background: #fff2ee;
        color: #d14b2f;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 0.84rem;
        font-weight: 700;
    }

    .status-pill.status-warning { background: #fff1c7; color: #946200; }
    .status-pill.status-success { background: #dff7ea; color: #16794f; }
    .status-pill.status-primary { background: #e5efff; color: #2457c5; }
    .status-pill.status-info { background: #e4f9fb; color: #11707d; }
    .status-pill.status-danger { background: #ffe3e0; color: #b43f35; }
    .status-pill.status-secondary { background: #efefef; color: #666; }

    .empty-booking {
        padding: 42px 28px;
        text-align: center;
        background: linear-gradient(180deg, #fff 0%, #fff7f5 100%);
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(25, 39, 52, 0.08);
    }
</style>
@endpush

@section('content')
<div class="container client-shell">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 m-0">Booking Anda</h1>
            <p class="text-muted mb-0 mt-2">Pantau jadwal servis, status pengerjaan, dan akses rekap kendaraan Anda.</p>
        </div>
        <a href="{{ url('/bookings/create') }}" class="btn btn-danger rounded-pill px-4">
            Buat Booking
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="soft-stat">
                <div class="text-muted">Total Booking</div>
                <h3>{{ $bookings->count() }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="soft-stat">
                <div class="text-muted">Sedang Berjalan</div>
                <h3>{{ $bookings->whereIn('status', ['pending', 'confirmed', 'in_progress'])->count() }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="soft-stat">
                <div class="text-muted">Servis Selesai</div>
                <h3>{{ $bookings->where('status', 'completed')->count() }}</h3>
            </div>
        </div>
    </div>

    @if ($bookings->isEmpty())
        <div class="empty-booking">
            <h4 class="mb-2">Belum ada booking servis</h4>
            <p class="text-muted mb-3">Jadwalkan servis pertama Anda dan pilih kendaraan yang ingin ditangani.</p>
            <a href="{{ url('/bookings/create') }}" class="btn btn-danger rounded-pill px-4">Buat booking baru</a>
        </div>
    @else
        <div class="card soft-panel">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover m-0 booking-table">
                        <thead class="table-light">
                            <tr>
                                <th>Kendaraan</th>
                                <th>Tanggal & Waktu</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $b)
                                <tr>
                                    <td>
                                        @if($b->vehicle)
                                            <div class="vehicle-badge mb-2">{{ $b->vehicle->brand }}</div>
                                            <div class="fw-bold">{{ $b->customer_vehicle_model }}</div>
                                            <small class="text-muted">{{ $b->customer_license_plate }} • {{ $b->customer_vehicle_color }}</small>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($b->booking_date)->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $b->booking_time }}</small>
                                    </td>
                                    <td>
                                        @if($b->services->count() > 0)
                                            <div class="fw-semibold">{{ $b->services->first()->service_name }}</div>
                                            @if($b->services->count() > 1)
                                                <small class="text-muted">+{{ $b->services->count() - 1 }} layanan lain</small>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match($b->status) {
                                                'confirmed' => 'success',
                                                'pending' => 'warning',
                                                'in_progress' => 'primary',
                                                'completed' => 'info',
                                                'cancelled' => 'danger',
                                                default => 'secondary'
                                            };
                                            $statusText = match($b->status) {
                                                'confirmed' => 'Dikonfirmasi',
                                                'pending' => 'Menunggu',
                                                'in_progress' => 'Sedang Dikerjakan',
                                                'completed' => 'Selesai',
                                                'cancelled' => 'Dibatalkan',
                                                default => ucfirst($b->status)
                                            };
                                        @endphp
                                        <span class="status-pill status-{{ $statusClass }}">{{ $statusText }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ url('/bookings/' . $b->id) }}" class="btn btn-outline-primary btn-sm rounded-pill me-2">Detail</a>
                                        @if($b->transaction)
                                            <a href="{{ url('/transactions/'.$b->transaction->id) }}" class="btn btn-outline-success btn-sm rounded-pill">Servis</a>
                                        @else
                                            <span class="text-muted small">Belum ada transaksi</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
