@extends('layout.admin')

@section('title', $pageTitle)
@section('page_title', $pageTitle)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ $sparepart->exists ? route('admin.spareparts.update', $sparepart) : route('admin.spareparts.store') }}">
                    @csrf
                    @if ($sparepart->exists)
                        @method('PUT')
                    @endif

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Nama Sparepart</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $sparepart->name) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stok</label>
                            <input type="number" min="0" name="stock" class="form-control" value="{{ old('stock', $sparepart->stock) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga Beli</label>
                            <input type="number" min="0" step="0.01" name="purchase_price" class="form-control" value="{{ old('purchase_price', $sparepart->purchase_price) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga Jual</label>
                            <input type="number" min="0" step="0.01" name="price" class="form-control" value="{{ old('price', $sparepart->price) }}" required>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.spareparts.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
