@extends('layout.admin')

@section('title', 'Booking Servis')
@section('page_title', 'Daftar Booking Servis')

@section('content')
<div class="row">
    <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-10">
                        <label class="form-label">Cari Nomor Plat</label>
                        <input type="text" name="plate" class="form-control" value="{{ request('plate') }}" placeholder="Contoh: B 1234 CD">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Plat</th>
                                <th>Kendaraan</th>
                                <th>Client</th>
                                <th>Jadwal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->customer_license_plate }}</td>
                                    <td>{{ $booking->vehicle?->brand }} {{ $booking->customer_vehicle_model }}</td>
                                    <td>{{ $booking->user?->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }} {{ $booking->booking_time }}</td>
                                    <td><span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span></td>
                                    <td>
                                        <a href="{{ route('mechanic.bookings.show', $booking) }}" class="btn btn-outline-primary btn-sm">
                                            Input Pekerjaan
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada booking servis yang cocok.</td>
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
