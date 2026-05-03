@extends('layout.admin')

@section('title', $pageTitle)
@section('page_title', $pageTitle)

@section('content')
<div class="row">
    <div class="col-lg-8">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ $vehicle->exists ? route('admin.vehicles.update', $vehicle) : route('admin.vehicles.store') }}">
                    @csrf
                    @if ($vehicle->exists)
                        @method('PUT')
                    @endif

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Merek</label>
                            <input type="text" name="brand" class="form-control" value="{{ old('brand', $vehicle->brand) }}" required>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-secondary">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
