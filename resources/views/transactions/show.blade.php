@extends('layout.app')

@push('styles')
<style>
    .service-detail-shell {
        margin-top: 40px;
        margin-bottom: 60px;
    }

    .detail-card {
        border: 0;
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(25, 39, 52, 0.08);
    }

    .summary-card {
        border: 0;
        border-radius: 22px;
        box-shadow: 0 18px 40px rgba(25, 39, 52, 0.08);
        background: linear-gradient(135deg, #fff3ef 0%, #ffffff 100%);
    }

    .rating-select {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .rating-select input {
        display: none;
    }

    .rating-select label {
        border: 1px solid #f1d2c7;
        border-radius: 999px;
        padding: 10px 16px;
        cursor: pointer;
        transition: all .2s ease;
        background: #fff;
    }

    .rating-select input:checked + label {
        background: #d94f2b;
        color: #fff;
        border-color: #d94f2b;
    }
</style>
@endpush

@section('content')
<div class="container service-detail-shell">
    <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
        <div class="me-2">
            <h1 class="h3 m-0">Detail Transaksi #{{ $transaction->id }}</h1>

            @if ($transaction->booking && $transaction->booking->vehicle)
                <p class="text-muted mt-2 mb-0">
                    Kendaraan: {{ $transaction->booking->vehicle->brand }} {{ $transaction->booking->customer_vehicle_model }} ({{ $transaction->booking->customer_license_plate }})
                </p>
            @endif

            @if ($transaction->booking)
                <p class="text-muted mt-2 mb-0">
                    Tanggal booking: {{ $transaction->booking->booking_date }} ({{ $transaction->booking->booking_time }})
                </p>
            @endif

            @if ($transaction->mekanik)
                <p class="text-muted mt-2 mb-0">
                    Mekanik: {{ $transaction->mekanik->name }}
                </p>
            @endif
        </div>

        <div class="d-flex flex-column gap-2">
            <div class="card summary-card text-center" style="min-width: 220px;">
                <div class="card-body">
                    <div class="text-muted">Grand Total</div>
                    <div class="h4 text-danger fw-bold">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</div>
                </div>
            </div>
            @if ($transaction->payment || $transaction->processed_at)
                <a href="{{ route('transactions.invoice', $transaction->id) }}" target="_blank" class="btn btn-outline-danger rounded-pill">Lihat Invoice</a>
            @endif
        </div>
    </div>

    @if (auth()->check() && in_array(auth()->user()->role, ['mekanik', 'kasir'], true))
        <div class="card detail-card mb-4">
            <div class="card-body">
                <h2 class="h5 mb-3">Tambah Sparepart</h2>

                <form method="POST" action="{{ auth()->user()->role === 'mekanik' ? route('mechanic.transactions.add-sparepart') : '/transactions/add-sparepart' }}" class="row g-3 align-items-end">
                    @csrf
                    <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">

                    <div class="col-md-7">
                        <label class="form-label mb-1">Sparepart</label>
                        <select name="sparepart_id" class="form-select" required>
                            @foreach ($availableSpareparts as $s)
                                <option value="{{ $s->id }}">{{ $s->name }} | stok {{ $s->stock }} | Rp {{ number_format($s->price, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label mb-1">Qty</label>
                        <input type="number" name="qty" min="1" required class="form-control">
                    </div>

                    <div class="col-md-2 text-md-end">
                        <button type="submit" class="btn btn-danger w-100">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-12">
            <div class="card detail-card">
                <div class="card-body">
                    <h2 class="h5 mb-3">Rekap Pekerjaan Servis</h2>
                    <p class="mb-3">{{ $transaction->work_summary ?: 'Mekanik belum mengisi rekap pekerjaan.' }}</p>

                    @if ($transaction->work_recommendation)
                        <h3 class="h6 text-muted">Rekomendasi</h3>
                        <p class="mb-0">{{ $transaction->work_recommendation }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card detail-card">
                <div class="card-body">
                    <h2 class="h5 mb-3">Informasi Pembayaran</h2>
                    @if ($transaction->payment)
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <tbody>
                                    <tr>
                                        <th>Status Pembayaran</th>
                                        <td>{{ strtoupper($transaction->payment->payment_status) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Metode Pembayaran</th>
                                        <td>{{ strtoupper($transaction->payment->payment_method) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Dibayar</th>
                                        <td>Rp {{ number_format($transaction->payment->amount_paid, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Pembayaran</th>
                                        <td>{{ $transaction->payment->payment_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Diproses Kasir</th>
                                        <td>{{ $transaction->kasir?->name ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Tagihan Anda belum diproses kasir. Setelah kasir menyimpan perhitungan, detail pembayaran akan muncul di sini.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if (auth()->user()?->role === 'customer')
            <div class="col-12">
                <div class="card detail-card">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Ulasan Servis</h2>

                        @if (($transaction->payment?->payment_status ?? null) !== 'paid')
                            <div class="alert alert-info mb-0">
                                Ulasan akan tersedia setelah pembayaran selesai.
                            </div>
                        @else
                            <p class="text-muted">Bagikan pengalaman servis Anda. Ulasan ini akan tampil di halaman beranda.</p>

                            <form method="POST" action="{{ route('transactions.review.store', $transaction->id) }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label d-block">Rating</label>
                                    <div class="rating-select">
                                        @for ($rating = 5; $rating >= 1; $rating--)
                                            <input
                                                type="radio"
                                                name="rating"
                                                id="rating_{{ $rating }}"
                                                value="{{ $rating }}"
                                                @checked((int) old('rating', $transaction->review?->rating) === $rating)
                                            >
                                            <label for="rating_{{ $rating }}">{{ $rating }} Bintang</label>
                                        @endfor
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Ulasan</label>
                                    <textarea name="review_text" rows="5" class="form-control" placeholder="Ceritakan pengalaman servis Anda...">{{ old('review_text', $transaction->review?->review_text) }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-danger rounded-pill px-4">
                                    {{ $transaction->review ? 'Perbarui Ulasan' : 'Kirim Ulasan' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-6">
            <div class="card detail-card">
                <div class="card-body">
                    <h2 class="h5 mb-3">Service (dari booking)</h2>
                    @php($services = $transaction->booking?->services ?? collect())
                    @if ($services->isEmpty())
                        <div class="text-muted">Belum ada service.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $service->service_name }}</td>
                                        <td class="fw-bold">{{ $service->pivot->price }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card detail-card">
                <div class="card-body">
                    <h2 class="h5 mb-3">Sparepart</h2>
                    @if ($transaction->spareparts->isEmpty())
                        <div class="text-muted">Belum ada sparepart.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
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
                                        <td>{{ $sparepart->name }}</td>
                                        <td>{{ $sparepart->pivot->qty }}</td>
                                        <td class="fw-bold">{{ $sparepart->pivot->subtotal }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
