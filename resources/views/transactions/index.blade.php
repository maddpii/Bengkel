@extends('layout.app')

@push('styles')
<style>
    .service-shell {
        margin-top: 40px;
        margin-bottom: 60px;
    }

    .history-card {
        border: 0;
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(25, 39, 52, 0.08);
        overflow: hidden;
    }

    .history-table thead th {
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #8f8f8f;
        border-bottom: 0;
        padding: 18px 20px;
    }

    .history-table tbody td {
        padding: 20px;
        vertical-align: middle;
        border-color: #f3f3f3;
    }

    .history-summary {
        border-radius: 20px;
        background: linear-gradient(135deg, #fff5f2 0%, #ffffff 100%);
        border: 1px solid rgba(231, 76, 60, 0.08);
        padding: 20px 22px;
    }
</style>
@endpush

@section('content')
<div class="container service-shell">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 m-0">Riwayat Servis Anda</h1>
            <p class="text-muted mb-0 mt-2">Lihat ringkasan pekerjaan, mekanik yang menangani, dan total biaya setiap servis.</p>
        </div>
    </div>

    @if ($transactions->isEmpty())
        <div class="alert alert-info">
            Belum ada transaksi untuk akun ini.
        </div>
    @else
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="history-summary">
                    <div class="text-muted">Total Servis</div>
                    <div class="h3 mb-0 mt-2">{{ $transactions->count() }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="history-summary">
                    <div class="text-muted">Sudah Ditangani Mekanik</div>
                    <div class="h3 mb-0 mt-2">{{ $transactions->whereNotNull('mekanik')->count() }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="history-summary">
                    <div class="text-muted">Total Pengeluaran</div>
                    <div class="h3 mb-0 mt-2">Rp {{ number_format($transactions->sum('grand_total'), 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <div class="card history-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover m-0 history-table">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Kendaraan</th>
                                <th>Tanggal Booking</th>
                                <th>Total</th>
                                <th>Mekanik</th>
                                <th>Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $t)
                                <tr>
                                    <td>#{{ $t->id }}</td>
                                    <td>
                                        @if($t->booking && $t->booking->vehicle)
                                            <div class="fw-semibold">{{ $t->booking->vehicle->brand }} {{ $t->booking->customer_vehicle_model }}</div>
                                            <small class="text-muted">{{ $t->booking->customer_license_plate }}</small>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $t->booking?->booking_date }}</td>
                                    <td class="fw-bold text-danger">Rp {{ number_format($t->grand_total, 0, ',', '.') }}</td>
                                    <td>{{ $t->mekanik?->name ?? '-' }}</td>
                                    <td>
                                        @if ($t->payment)
                                            <span class="status-pill status-{{ $t->payment->payment_status === 'paid' ? 'success' : ($t->payment->payment_status === 'partial' ? 'warning' : 'secondary') }}">
                                                {{ strtoupper($t->payment->payment_status) }}
                                            </span>
                                        @else
                                            <span class="status-pill status-secondary">MENUNGGU KASIR</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ url('/transactions/'.$t->id) }}" class="btn btn-outline-danger btn-sm rounded-pill">Lihat Detail</a>
                                            @if ($t->payment || $t->processed_at)
                                                <a href="{{ route('transactions.invoice', $t->id) }}" target="_blank" class="btn btn-danger btn-sm rounded-pill">Invoice</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
