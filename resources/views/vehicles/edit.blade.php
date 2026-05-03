@extends('layout.app')

@section('title', 'Edit Kendaraan')

@section('content')
<div class="container p-t-120 p-b-60">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 m-0">Edit Kendaraan</h1>
        <a href="{{ url('/vehicles') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ url('/vehicles/' . $vehicle->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Brand</label>
                        <input type="text" name="brand" required class="form-control" value="{{ $vehicle->brand }}" placeholder="Contoh: Toyota">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Model</label>
                        <input type="text" name="model" required class="form-control" value="{{ $vehicle->model }}" placeholder="Contoh: Avanza">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tahun</label>
                        <input type="number" name="year" required class="form-control" value="{{ $vehicle->year }}" placeholder="Contoh: 2020">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Warna</label>
                        <input type="text" name="color" required class="form-control" value="{{ $vehicle->color }}" placeholder="Contoh: Hitam">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Plat Nomor</label>
                        <input type="text" name="license_plate" required class="form-control" value="{{ $vehicle->license_plate }}" placeholder="Contoh: B 1234 ABC">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Kendaraan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
