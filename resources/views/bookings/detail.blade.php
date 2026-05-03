@extends('layout.app')

@section('title', 'Detail Booking')

@push('styles')
<style>
    .booking-detail-shell {
        margin-top: 40px;
        margin-bottom: 60px;
    }

    .detail-panel {
        border: 0;
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(25, 39, 52, 0.08);
    }

    .detail-summary {
        border-radius: 20px;
        background: linear-gradient(135deg, #fff6f2 0%, #ffffff 100%);
        padding: 18px 20px;
        height: 100%;
    }
</style>
@endpush

@section('content')
<div class="container booking-detail-shell">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 m-0">Detail Booking</h1>
            <p class="text-muted mb-0 mt-2">Ringkasan kendaraan, layanan, dan progres servis Anda.</p>
        </div>
        <a href="{{ url('/bookings') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="detail-summary">
                <div class="text-muted">ID Booking</div>
                <div class="h4 mb-0 mt-2">#{{ $booking->id }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="detail-summary">
                <div class="text-muted">Status</div>
                <div class="h5 mb-0 mt-2">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="detail-summary">
                <div class="text-muted">Estimasi Biaya</div>
                <div class="h5 mb-0 mt-2">Rp {{ number_format($booking->services->sum('price'), 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="card detail-panel">
        <div class="card-header">
            <h5 class="mb-0">Booking #{{ $booking->id }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Kendaraan</h6>
                    <p>{{ $booking->vehicle->brand }} {{ $booking->customer_vehicle_model }} ({{ $booking->customer_license_plate }})</p>
                </div>
                <div class="col-md-6">
                    <h6>Tanggal & Waktu</h6>
                    <p>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }} pukul {{ $booking->booking_time }}</p>
                </div>
            </div>

            <div class="mt-3">
                <h6>Keluhan</h6>
                <p>{{ $booking->complaint ?: 'Tidak ada catatan tambahan.' }}</p>
                <p class="mb-0"><strong>Warna:</strong> {{ $booking->customer_vehicle_color }}</p>
            </div>

            <h6 class="mt-4">Layanan</h6>
            <ul class="list-group">
                @foreach($booking->services as $service)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $service->service_name }}
                        <span class="badge bg-primary rounded-pill">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                <strong>Total: Rp {{ number_format($booking->services->sum('price'), 0, ',', '.') }}</strong>
            </div>

            @if($booking->status === 'pending')
                <div class="mt-4">
                    <span class="badge bg-warning text-dark">Menunggu konfirmasi admin</span>
                </div>
            @endif

            @if($booking->transaction)
                <div class="mt-4">
                    <a href="{{ route('transactions.show', $booking->transaction->id) }}" class="btn btn-outline-primary btn-sm">
                        Lihat Rekap Servis
                    </a>
                </div>
            @endif

            @if($booking->transaction?->work_summary)
                <div class="mt-4">
                    <h6>Rekap Pekerjaan Mekanik</h6>
                    <p>{{ $booking->transaction->work_summary }}</p>

                    @if($booking->transaction->work_recommendation)
                        <h6>Rekomendasi Lanjutan</h6>
                        <p class="mb-0">{{ $booking->transaction->work_recommendation }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
