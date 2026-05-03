@extends('layout.app')

@section('title', 'Detail Kendaraan')

@section('content')
<div class="container p-t-120 p-b-60">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 m-0">Detail Kendaraan</h1>
        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-3">{{ $vehicle->brand }}</h4>
            <p class="mb-4">Merek mobil ini tersedia untuk booking servis di bengkel.</p>

            <a href="{{ route('bookings.create') }}" class="btn btn-primary">Pilih untuk Booking</a>
        </div>
    </div>
</div>
@endsection
