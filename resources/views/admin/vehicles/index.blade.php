@extends('layout.admin')

@section('title', 'Kendaraan')
@section('page_title', 'Daftar Kendaraan')

@section('breadcrumb_right')
    <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary btn-sm">
        Tambah Kendaraan
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Master Kendaraan</h5>
                <p class="text-muted">Data kendaraan ini akan dipilih oleh client saat melakukan booking servis.</p>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Merek Mobil</th>
                                <th>Diinput Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehicles as $vehicle)
                            <tr>
                                <td>{{ $vehicle->id }}</td>
                                <td>{{ $vehicle->brand }}</td>
                                <td>{{ $vehicle->user?->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-outline-primary btn-sm">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.vehicles.destroy', $vehicle) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus kendaraan ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Tidak ada merek kendaraan</td>
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
