@extends('layout.admin')

@section('title', 'Input Pekerjaan Servis')
@section('page_title', 'Input Pekerjaan Servis')

@push('styles')
<style>
    .mechanic-panel-card {
        border: 0;
        border-radius: 20px;
        box-shadow: 0 14px 36px rgba(21, 32, 43, 0.08);
    }

    .mechanic-panel-card .card-body {
        padding: 1.5rem;
    }

    .mechanic-meta-list {
        display: grid;
        gap: .9rem;
    }

    .mechanic-meta-item {
        padding-bottom: .9rem;
        border-bottom: 1px solid #edf1f5;
    }

    .mechanic-meta-item:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .mechanic-meta-label {
        display: block;
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #7d8a97;
        margin-bottom: .2rem;
    }

    .mechanic-meta-value {
        margin: 0;
        color: #22303c;
    }

    .mechanic-tip-list {
        display: grid;
        gap: .75rem;
        padding-left: 0;
        list-style: none;
        margin-bottom: 0;
    }

    .mechanic-tip-list li {
        display: flex;
        align-items: flex-start;
        gap: .75rem;
        color: #506070;
    }

    .mechanic-tip-list li::before {
        content: "";
        width: 10px;
        height: 10px;
        border-radius: 999px;
        background: #00c292;
        margin-top: .4rem;
        flex-shrink: 0;
        box-shadow: 0 0 0 6px rgba(0, 194, 146, 0.12);
    }

    .sparepart-form-shell {
        border: 1px solid #e9f0f6;
        border-radius: 18px;
        background: linear-gradient(180deg, #fbfdff 0%, #f6f9fc 100%);
        padding: 1.2rem;
    }

    .sparepart-hint-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: .75rem;
        margin-bottom: 1rem;
    }

    .sparepart-hint-box {
        border-radius: 14px;
        background: #fff;
        border: 1px solid #edf1f5;
        padding: .85rem .95rem;
    }

    .sparepart-hint-box small {
        display: block;
        color: #7d8a97;
        margin-bottom: .2rem;
    }

    .sparepart-hint-box strong {
        color: #22303c;
        font-size: .95rem;
    }

    .sparepart-select option {
        white-space: normal;
    }

    .sparepart-table thead th {
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #7d8a97;
        border-bottom-width: 1px;
    }

    .sparepart-table tbody td {
        vertical-align: middle;
    }

    .sparepart-name {
        font-weight: 600;
        color: #22303c;
    }

    .sparepart-subtext {
        display: block;
        font-size: .8rem;
        color: #7d8a97;
        margin-top: .2rem;
    }

    .sparepart-empty-state {
        border: 1px dashed #d8e2eb;
        border-radius: 16px;
        padding: 1rem 1.1rem;
        color: #7d8a97;
        background: #fbfcfe;
    }

    .mechanic-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        padding: .78rem 1.35rem;
        line-height: 1.2;
        white-space: normal;
        text-align: center;
        border-width: 1px;
    }

    .mechanic-action-btn.w-100 {
        display: flex;
    }
</style>
@endpush

@section('content')
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card mechanic-panel-card">
            <div class="card-body">
                <h5 class="card-title">Data Booking</h5>
                <div class="mechanic-meta-list">
                    <div class="mechanic-meta-item">
                        <span class="mechanic-meta-label">Client</span>
                        <p class="mechanic-meta-value">{{ $booking->user?->name }}</p>
                    </div>
                    <div class="mechanic-meta-item">
                        <span class="mechanic-meta-label">Kendaraan</span>
                        <p class="mechanic-meta-value">{{ $booking->vehicle?->brand }} {{ $booking->customer_vehicle_model }}</p>
                    </div>
                    <div class="mechanic-meta-item">
                        <span class="mechanic-meta-label">Plat Nomor</span>
                        <p class="mechanic-meta-value">{{ $booking->customer_license_plate }}</p>
                    </div>
                    <div class="mechanic-meta-item">
                        <span class="mechanic-meta-label">Warna</span>
                        <p class="mechanic-meta-value">{{ $booking->customer_vehicle_color }}</p>
                    </div>
                    <div class="mechanic-meta-item">
                        <span class="mechanic-meta-label">Jadwal</span>
                        <p class="mechanic-meta-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }} {{ $booking->booking_time }}</p>
                    </div>
                    <div class="mechanic-meta-item">
                        <span class="mechanic-meta-label">Keluhan</span>
                        <p class="mechanic-meta-value">{{ $booking->complaint ?: 'Tidak ada catatan.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mechanic-panel-card mt-4">
            <div class="card-body">
                <h5 class="card-title">Tugas Mekanik</h5>
                <p class="mb-2 text-muted">Mekanik hanya perlu mencatat hasil pekerjaan dan sparepart yang dipakai. Jasa layanan dan penetapan harga akan diinput oleh kasir.</p>
                <ul class="mechanic-tip-list">
                    <li>Tulis ringkasan pekerjaan servis dengan jelas.</li>
                    <li>Tambahkan sparepart yang dipakai bila ada.</li>
                    <li>Set status ke <strong>Selesai</strong> agar transaksi masuk ke panel kasir.</li>
                </ul>
            </div>
        </div>

        @if ($isLockedForMechanic)
            <div class="alert alert-info mt-4 mb-0">
                Booking ini sudah selesai diproses mekanik
            </div>
        @endif

        <div class="card mechanic-panel-card mt-4">
            <div class="card-body">
                <h5 class="card-title">Sparepart Tersedia</h5>
                @if ($availableSpareparts->isEmpty())
                    <div class="sparepart-empty-state mb-0">Belum ada sparepart tersedia atau stok habis.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm sparepart-table mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($availableSpareparts as $sparepart)
                                    <tr>
                                        <td>
                                            <span class="sparepart-name">{{ $sparepart->name }}</span>
                                        </td>
                                        <td><span class="badge badge-info px-3 py-2">{{ $sparepart->stock }}</span></td>
                                        <td class="font-weight-bold">Rp {{ number_format($sparepart->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card mechanic-panel-card">
            <div class="card-body">
                <h5 class="card-title">Rekap Pekerjaan Mekanik</h5>

                @if ($isLockedForMechanic)
                    <div class="mb-3">
                        <label class="form-label">Status Pekerjaan</label>
                        <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $booking->status)) }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ringkasan Pekerjaan</label>
                        <textarea rows="6" class="form-control" readonly>{{ $booking->transaction?->work_summary }}</textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Rekomendasi Lanjutan</label>
                        <textarea rows="4" class="form-control" readonly>{{ $booking->transaction?->work_recommendation }}</textarea>
                    </div>
                @else
                    <form method="POST" action="{{ route('mechanic.bookings.update', $booking) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Status Pekerjaan</label>
                            <select name="status" class="form-select" required>
                                <option value="in_progress" @selected(old('status', $booking->status) === 'in_progress')>Sedang Dikerjakan</option>
                                <option value="completed" @selected(old('status', $booking->status) === 'completed')>Selesai dan Kirim ke Kasir</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ringkasan Pekerjaan</label>
                            <textarea name="work_summary" rows="6" class="form-control" required>{{ old('work_summary', $booking->transaction?->work_summary) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rekomendasi Lanjutan</label>
                            <textarea name="work_recommendation" rows="4" class="form-control">{{ old('work_recommendation', $booking->transaction?->work_recommendation) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary mechanic-action-btn">
                            Simpan Rekap Servis
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="card mechanic-panel-card mt-4">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-start justify-content-between gap-2 mb-3">
                    <div>
                        <h5 class="card-title mb-1">Tambahkan Sparepart</h5>
                        <p class="text-muted mb-0">Pilih sparepart yang dipakai agar total transaksi otomatis terakumulasi.</p>
                    </div>
                    <span class="badge badge-light px-3 py-2">Transaksi #{{ $transaction->id }}</span>
                </div>

                @if ($isLockedForMechanic)
                    <div class="sparepart-empty-state mb-0">Input sparepart dikunci karena booking ini sudah selesai diproses mekanik.</div>
                @elseif ($availableSpareparts->isEmpty())
                    <div class="sparepart-empty-state mb-0">Admin belum menambahkan sparepart atau stok saat ini habis.</div>
                @else
                    <div class="sparepart-form-shell">
                        @php($selectedSparepart = $availableSpareparts->firstWhere('id', (int) old('sparepart_id')) ?? $availableSpareparts->first())

                        <div class="sparepart-hint-grid">
                            <div class="sparepart-hint-box">
                                <small>Sparepart dipilih</small>
                                <strong>{{ $selectedSparepart?->name ?? '-' }}</strong>
                            </div>
                            <div class="sparepart-hint-box">
                                <small>Stok tersedia</small>
                                <strong>{{ $selectedSparepart?->stock ?? 0 }} pcs</strong>
                            </div>
                            <div class="sparepart-hint-box">
                                <small>Harga satuan</small>
                                <strong>Rp {{ number_format($selectedSparepart?->price ?? 0, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('mechanic.transactions.add-sparepart') }}" class="row g-3 align-items-end">
                            @csrf
                            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">

                            <div class="col-md-7">
                                <label class="form-label font-weight-bold">Sparepart</label>
                                <select name="sparepart_id" class="form-control sparepart-select" required>
                                    @foreach ($availableSpareparts as $sparepart)
                                        <option value="{{ $sparepart->id }}" @selected((int) old('sparepart_id', $selectedSparepart?->id) === $sparepart->id)>
                                            {{ $sparepart->name }} | stok {{ $sparepart->stock }} | Rp {{ number_format($sparepart->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Pilih item yang benar agar stok dan subtotal tercatat otomatis.</small>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label font-weight-bold">Qty</label>
                                <input type="number" name="qty" min="1" value="{{ old('qty', 1) }}" class="form-control" required>
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary mechanic-action-btn w-100">Tambah</button>
                            </div>
                        </form>
                    </div>
                @endif

                <hr>

                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <h6 class="mb-0">Sparepart Yang Dipakai</h6>
                    <span class="badge badge-secondary px-3 py-2">{{ $transaction->spareparts->count() }} item</span>
                </div>
                @if ($transaction->spareparts->isEmpty())
                    <div class="sparepart-empty-state mb-0">Belum ada sparepart yang ditambahkan ke transaksi ini.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm sparepart-table mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction->spareparts as $sparepart)
                                    <tr>
                                        <td>
                                            <span class="sparepart-name">{{ $sparepart->name }}</span>
                                            <span class="sparepart-subtext">Harga satuan Rp {{ number_format($sparepart->pivot->price, 0, ',', '.') }}</span>
                                        </td>
                                        <td><span class="badge badge-primary px-3 py-2">{{ $sparepart->pivot->qty }}</span></td>
                                        <td class="font-weight-bold">Rp {{ number_format($sparepart->pivot->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mechanic-panel-card mt-4">
            <div class="card-body">
                <h5 class="card-title">Ringkasan Transaksi</h5>
                <p class="mb-2"><strong>Status Kirim Kasir:</strong> {{ $transaction->cashier_ready_at ? 'Sudah dikirim ke kasir' : 'Belum dikirim' }}</p>
                <p class="mb-2"><strong>Jasa Servis:</strong> Ditentukan oleh kasir</p>
                <p class="mb-2"><strong>Total Sparepart:</strong> Rp {{ number_format($transaction->total_sparepart, 0, ',', '.') }}</p>
                <p class="mb-3"><strong>Grand Total:</strong> Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</p>
                <a href="{{ route('mechanic.transactions.show', $transaction->id) }}" class="btn btn-outline-primary btn-sm mechanic-action-btn">
                    Lihat Detail Transaksi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
