@extends('layout.admin')

@section('title', 'Sparepart')
@section('page_title', 'Stok Sparepart')

@section('breadcrumb_right')
    <a href="{{ route('admin.spareparts.create') }}" class="btn btn-primary btn-sm">
        Tambah Sparepart
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Master Sparepart</h5>
                <p class="text-muted">Kelola stok sparepart yang nanti bisa dipakai mekanik saat membuat laporan servis.</p>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Sparepart</th>
                                <th>Stok</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($spareparts as $sparepart)
                                <tr>
                                    <td>{{ $sparepart->id }}</td>
                                    <td>{{ $sparepart->name }}</td>
                                    <td>
                                        <span class="badge {{ $sparepart->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $sparepart->stock }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($sparepart->purchase_price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($sparepart->price, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('admin.spareparts.edit', $sparepart) }}" class="btn btn-outline-primary btn-sm">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.spareparts.destroy', $sparepart) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus sparepart ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada sparepart.</td>
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
