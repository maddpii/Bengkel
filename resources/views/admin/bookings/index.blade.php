@extends('layout.admin')

@section('title', 'Booking')
@section('page_title', 'Daftar Booking')

@section('content')
<div class="row">
    <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Bulan</label>
                        <input type="number" min="1" max="12" name="month" class="form-control" value="{{ request('month') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" min="2024" name="year" class="form-control" value="{{ request('year', now()->year) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            @foreach (['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>

                <h5 class="card-title">Monitoring Booking Servis</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Booking</th>
                                <th>Client</th>
                                <th>Kendaraan</th>
                                <th>Jadwal</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Mekanik</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>
                                    {{ $booking->user?->name }}<br>
                                    <small class="text-muted">{{ $booking->user?->email }}</small>
                                </td>
                                <td>{{ $booking->vehicle?->brand }} {{ $booking->vehicle?->model }}<br><small class="text-muted">{{ $booking->vehicle?->license_plate }}</small></td>
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}<br><small class="text-muted">{{ $booking->booking_time }}</small></td>
                                <td>
                                    @foreach ($booking->services as $service)
                                        <div>{{ $service->service_name }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning text-dark' : ($booking->status == 'completed' ? 'info' : 'primary')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                </td>
                                <td>{{ $booking->transaction?->mekanik?->name ?? '-' }}</td>
                                <td>
                                    @if ($booking->status === 'pending')
                                        <a href="{{ route('admin.bookings.confirm', $booking->id) }}" class="btn btn-outline-success btn-sm">
                                            Konfirmasi
                                        </a>
                                    @else
                                        <span class="text-muted small">Sudah diproses</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="table-empty">
  Tidak ada booking
</td>
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
