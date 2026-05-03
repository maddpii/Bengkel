@extends('layout.app')

@push('styles')
<style>
    .booking-form-shell {
        margin-top: 40px;
        margin-bottom: 60px;
    }

    .booking-hero-card,
    .booking-form-card {
        border: 0;
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(25, 39, 52, 0.08);
    }

    .booking-hero-card {
        background: linear-gradient(135deg, #fff3ef 0%, #ffffff 100%);
    }

    .booking-note {
        border: 1px solid #f4ded8;
        border-radius: 18px;
        background: linear-gradient(135deg, #fff7f5 0%, #ffffff 100%);
        color: #6a5a58;
        padding: 16px 18px;
    }
</style>
@endpush

@section('content')
<div class="container booking-form-shell">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 m-0">Buat Booking</h1>
            <p class="text-muted mb-0 mt-2">Isi data kendaraan dan pilih layanan servis yang dibutuhkan.</p>
        </div>
        <a href="{{ url('/bookings') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
    </div>

    <div class="card booking-hero-card mb-4">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="text-muted">Langkah 1</div>
                    <div class="fw-semibold">Pilih merek kendaraan</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted">Langkah 2</div>
                    <div class="fw-semibold">Isi identitas mobil Anda</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted">Langkah 3</div>
                    <div class="fw-semibold">Tentukan layanan dan jadwal</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card booking-form-card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/bookings') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Merek Mobil</label>
                    <select class="form-select" name="vehicle_id" required>
                        <option value="">Pilih Jenis Kendaraan</option>
                        @foreach($vehicles as $v)
                            <option value="{{ $v->id }}" @selected(old('vehicle_id') == $v->id)>
                                {{ $v->brand }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Pilihan ini diambil dari master kendaraan yang diinput admin.</small>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Model Mobil</label>
                        <input type="text" name="customer_vehicle_model" class="form-control" value="{{ old('customer_vehicle_model') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Warna Mobil</label>
                        <input type="text" name="customer_vehicle_color" class="form-control" value="{{ old('customer_vehicle_color') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nomor Plat</label>
                        <input type="text" name="customer_license_plate" class="form-control" value="{{ old('customer_license_plate') }}" required>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Booking</label>
                        <input type="date" name="booking_date" class="form-control" required min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Waktu Booking</label>
                        <input type="time" name="booking_time" class="form-control" required value="{{ old('booking_time') }}">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Keluhan / Catatan</label>
                    <textarea name="complaint" rows="4" class="form-control" placeholder="Contoh: suara mesin kasar, rem kurang pakem, ganti oli berkala">{{ old('complaint') }}</textarea>
                </div>

                <div class="booking-note mt-3">
                    Layanan servis tidak perlu dipilih dari sisi client. Tim bengkel akan mengecek kendaraan lebih dulu lalu menentukan tindakan servis saat proses berjalan.
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">Buat Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
