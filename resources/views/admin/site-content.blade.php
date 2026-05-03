@extends('layout.admin')

@section('title', 'Kelola Konten Situs')
@section('page_title', 'Konten Situs')

@section('content')
@php
    $site = $site ?? \App\Models\SiteContent::current();
@endphp

<div class="row">
    <div class="col-12 mb-3 d-flex align-items-center justify-content-between">
        <div>
            <h1 class="h4 mb-0">Konten beranda</h1>
        </div>
        <a href="{{ route('home') }}" class="btn btn-danger btn-sm text-white">
            Lihat beranda
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="post" action="{{ route('admin.site-content.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Konten Hero</h4>

                    <div class="form-group row mb-3">
                        <label for="hero_badge" class="col-sm-3 text-end control-label col-form-label">
                            Badge kecil
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="hero_badge" id="hero_badge" class="form-control"
                                value="{{ old('hero_badge', $site->hero_badge) }}"
                                placeholder="Contoh: Servis Mobil Tepercaya">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="hero_title" class="col-sm-3 text-end control-label col-form-label">
                            Judul
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="hero_title" id="hero_title" class="form-control"
                                value="{{ old('hero_title', $site->hero_title) }}"
                                placeholder="Masukkan judul hero">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="hero_subtitle" class="col-sm-3 text-end control-label col-form-label">
                            Subjudul
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="hero_subtitle" id="hero_subtitle" class="form-control"
                                value="{{ old('hero_subtitle', $site->hero_subtitle) }}"
                                placeholder="Kalimat singkat di bawah judul">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="hero_description" class="col-sm-3 text-end control-label col-form-label">
                            Deskripsi
                        </label>
                        <div class="col-sm-9">
                            <textarea name="hero_description" id="hero_description" rows="3" class="form-control"
                                placeholder="Deskripsi singkat untuk hero">{{ old('hero_description', $site->hero_description) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="hero_primary_cta_text" class="col-sm-3 text-end control-label col-form-label">
                            Tombol utama
                        </label>
                        <div class="col-sm-4">
                            <input type="text" name="hero_primary_cta_text" id="hero_primary_cta_text" class="form-control"
                                value="{{ old('hero_primary_cta_text', $site->hero_primary_cta_text) }}"
                                placeholder="Teks tombol">
                        </div>
                        <div class="col-sm-5 mt-2 mt-sm-0">
                            <input type="text" name="hero_primary_cta_link" class="form-control"
                                value="{{ old('hero_primary_cta_link', $site->hero_primary_cta_link) }}"
                                placeholder="Link tombol, misal /bookings/create">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 text-end control-label col-form-label">
                            Highlight hero
                        </label>
                        <div class="col-sm-9">
                            <div class="row g-2">
                                <div class="col-12">
                                    <input type="text" name="hero_highlight_1" class="form-control"
                                        value="{{ old('hero_highlight_1', $site->hero_highlight_1) }}"
                                        placeholder="Highlight 1">
                                </div>
                                <div class="col-12">
                                    <input type="text" name="hero_highlight_2" class="form-control"
                                        value="{{ old('hero_highlight_2', $site->hero_highlight_2) }}"
                                        placeholder="Highlight 2">
                                </div>
                                <div class="col-12">
                                    <input type="text" name="hero_highlight_3" class="form-control"
                                        value="{{ old('hero_highlight_3', $site->hero_highlight_3) }}"
                                        placeholder="Highlight 3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 text-end control-label col-form-label">
                            Gambar hero
                        </label>
                        <div class="col-sm-9">
                            @if ($site->hero_image)
                                <p class="text-muted mb-2">
                                    Saat ini:
                                    <a href="{{ asset('storage/'.$site->hero_image) }}" target="_blank">lihat</a>
                                </p>
                            @else
                                <p class="text-muted mb-2">Belum ada gambar hero saat ini.</p>
                            @endif
                            <input type="file" name="hero_image" accept="image/*" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="about_text" class="col-sm-3 text-end control-label col-form-label">
                            Tentang kami
                        </label>
                        <div class="col-sm-9">
                            <textarea name="about_text" id="about_text" rows="4" class="form-control"
                                placeholder="Tuliskan tentang bengkel Anda">{{ old('about_text', $site->about_text) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="extra_info" class="col-sm-3 text-end control-label col-form-label">
                            Info tambahan
                        </label>
                        <div class="col-sm-9">
                            <textarea name="extra_info" id="extra_info" rows="4" class="form-control"
                                placeholder="Tambahkan info tambahan">{{ old('extra_info', $site->extra_info) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="border-top">
                    <div class="card-body pt-3">
                        <button type="submit" class="btn btn-primary text-white">
                            Simpan konten
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-3 mt-lg-0">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Galeri</h4>

                    @php $gallery = $site->gallery_images ?? []; @endphp

                    @if (count($gallery) > 0)
                        <div class="row g-3 mb-3">
                            @foreach ($gallery as $idx => $path)
                                <div class="col-6">
                                    <img
                                        src="{{ asset('storage/'.$path) }}"
                                        alt=""
                                        class="img-fluid rounded"
                                        style="height: 120px; object-fit: cover;"
                                    >
                                    <div class="form-check mt-2">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            name="remove_gallery[]"
                                            value="{{ $idx }}"
                                            id="remove_gallery_{{ $idx }}"
                                        >
                                        <label class="form-check-label" for="remove_gallery_{{ $idx }}">
                                            Hapus
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-3">Belum ada gambar galeri.</p>
                    @endif

                    <label class="form-label">Tambah foto (bisa beberapa)</label>
                    <input type="file" name="gallery_images[]" accept="image/*" multiple class="form-control">
                </div>

                <div class="border-top">
                    <div class="card-body pt-3">
                        <button type="submit" class="btn btn-danger text-white">
                            Simpan galeri
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
