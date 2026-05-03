@extends('layout.admin')

@section('title', 'Ulasan Client')
@section('page_title', 'Ulasan Client')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-10">
                        <label for="keyword" class="form-label">Cari Ulasan</label>
                        <input
                            type="text"
                            id="keyword"
                            name="keyword"
                            class="form-control"
                            value="{{ request('keyword') }}"
                            placeholder="Cari nama client, email, plat nomor, model kendaraan, atau isi ulasan"
                        >
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                    </div>
                </form>

                <h5 class="card-title">Daftar Ulasan Pelanggan</h5>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Kendaraan</th>
                                <th>Rating</th>
                                <th>Ulasan</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reviews as $review)
                                @php
                                    $booking = $review->transaction?->booking;
                                    $vehicleLabel = trim(($booking?->vehicle?->brand ?? '') . ' ' . ($booking?->customer_vehicle_model ?? ''));
                                @endphp
                                <tr>
                                    <td>{{ $review->id }}</td>
                                    <td>
                                        {{ $review->user?->name ?? 'Pelanggan tidak ditemukan' }}<br>
                                        <small class="text-muted">{{ $review->user?->email ?? '-' }}</small>
                                    </td>
                                    <td>
                                        {{ $vehicleLabel !== '' ? $vehicleLabel : 'Servis kendaraan' }}<br>
                                        <small class="text-muted">{{ $booking?->customer_license_plate ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <span class="text-warning">{{ str_repeat('★', (int) $review->rating) }}</span><span class="text-muted">{{ str_repeat('☆', max(0, 5 - (int) $review->rating)) }}</span>
                                    </td>
                                    <td style="min-width: 260px;">{{ $review->review_text }}</td>
                                    <td>{{ $review->created_at?->format('d-m-Y H:i') ?? '-' }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Hapus ulasan client ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada ulasan client.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($reviews->hasPages())
                    <div class="mt-3">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
