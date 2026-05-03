@extends($layout)

@section('title', 'Profil Saya')
@section('page_title', 'Profil Saya')

@push('styles')
<style>
    .profile-page{padding-top:30px;padding-bottom:60px}
    .profile-card{border:0;border-radius:24px;box-shadow:0 18px 44px rgba(15,23,42,.08);overflow:hidden}
    .profile-hero{background:linear-gradient(135deg,#10213a 0%,#1f4b7a 52%,#c2571a 100%);color:#fff;padding:32px}
    .profile-badge{align-items:center;background:rgba(255,255,255,.14);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,.16);border-radius:24px;display:flex;gap:20px;padding:18px 20px}
    .profile-photo{background:rgba(255,255,255,.14);border:2px solid rgba(255,255,255,.25);border-radius:50%;height:84px;object-fit:cover;width:84px}
    .profile-photo-fallback{align-items:center;background:linear-gradient(135deg,#ffb86b 0%,#ff7b54 100%);border-radius:50%;display:inline-flex;font-size:1.6rem;font-weight:800;height:84px;justify-content:center;width:84px}
    .profile-role{font-size:.78rem;font-weight:700;letter-spacing:.14em;opacity:.76;text-transform:uppercase}
    .profile-name{font-size:1.7rem;font-weight:800;line-height:1.1;margin-top:4px}
    .profile-contact{font-size:.95rem;opacity:.88;margin-top:8px}
    .profile-body{padding:28px}
    .profile-section-title{color:#223047;font-size:1.02rem;font-weight:800;margin-bottom:18px}
    .profile-hint{color:#7d889d;font-size:.9rem}
</style>
@endpush

@section('content')
<div class="container profile-page">
    <div class="card profile-card">
        <div class="profile-hero">
            <div class="profile-badge">
                @if ($user->profile_photo_url)
                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="profile-photo">
                @else
                    <div class="profile-photo-fallback">{{ $user->initials }}</div>
                @endif
                <div>
                    <div class="profile-role">{{ strtoupper($user->role) }}</div>
                    <div class="profile-name">{{ $user->name }}</div>
                    <div class="profile-contact">{{ $user->email }}{{ $user->phone ? ' | ' . $user->phone : '' }}</div>
                </div>
            </div>
        </div>

        <div class="profile-body">
            <div class="row g-4">
                <div class="col-lg-8">
                    <h5 class="profile-section-title">Data Diri</h5>
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="photo" class="form-control" accept="image/*">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" rows="4" class="form-control">{{ old('address', $user->address) }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="profile-section-title">Ganti Password</h5>
                        <p class="profile-hint mb-3">Kosongkan bagian ini kalau tidak ingin mengganti password.</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="mt-4 d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4">Kembali</a>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4">
                    <h5 class="profile-section-title">Ringkasan Akun</h5>
                    <div class="card mb-0">
                        <div class="card-body">
                            <p class="mb-2"><strong>Role:</strong> {{ strtoupper($user->role) }}</p>
                            <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                            <p class="mb-2"><strong>Telepon:</strong> {{ $user->phone ?: '-' }}</p>
                            <p class="mb-0"><strong>Alamat:</strong> {{ $user->address ?: '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

