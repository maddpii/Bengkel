@extends('layout.admin')

@section('title', 'Proses Kasir')
@section('page_title', 'Proses Kasir')

@php
    $baseServiceTotal = $transaction->booking?->services?->sum('pivot.price') ?? 0;
    $sparepartTotal = $transaction->spareparts->sum('pivot.subtotal');
    $manualServicePrice = old('manual_service_price', $transaction->manual_service_price ?? 0);
    $estimatedGrandTotal = $baseServiceTotal + $sparepartTotal + (float) $manualServicePrice;
@endphp

@section('content')
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Ringkasan Dari Mekanik</h5>
                <p class="mb-2"><strong>Client:</strong> {{ $transaction->booking?->user?->name ?? '-' }}</p>
                <p class="mb-2"><strong>Kendaraan:</strong> {{ trim(($transaction->booking?->vehicle?->brand ?? '') . ' ' . ($transaction->booking?->customer_vehicle_model ?? '')) }}</p>
                <p class="mb-2"><strong>Plat:</strong> {{ $transaction->booking?->customer_license_plate ?? '-' }}</p>
                <p class="mb-2"><strong>Mekanik:</strong> {{ $transaction->mekanik?->name ?? '-' }}</p>
                <p class="mb-0"><strong>Rekap Mekanik:</strong> {{ $transaction->work_summary ?: 'Belum ada rekap.' }}</p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Komponen Biaya</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-striped mb-0">
                        <tbody>
                            <tr>
                                <th>Jasa layanan kasir</th>
                                <td class="text-right">Rp {{ number_format($baseServiceTotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Total sparepart</th>
                                <td class="text-right">Rp {{ number_format($sparepartTotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Jasa manual saat ini</th>
                                <td class="text-right">Rp {{ number_format((float) ($transaction->manual_service_price ?? 0), 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Grand total saat ini</th>
                                <td class="text-right"><strong>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Input Kasir</h5>

                <form method="POST" action="{{ route('cashier.transactions.update', $transaction) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Jasa Layanan</label>
                        <input type="text" name="manual_service_name" class="form-control" value="{{ old('manual_service_name', $transaction->manual_service_name) }}" placeholder="Contoh: Jasa servis umum, bongkar pasang, pengecekan tambahan">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga Jasa Layanan</label>
                        <input type="number" min="0" step="0.01" name="manual_service_price" class="form-control" value="{{ old('manual_service_price', $transaction->manual_service_price ?? 0) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan Kasir</label>
                        <textarea name="cashier_notes" rows="4" class="form-control">{{ old('cashier_notes', $transaction->cashier_notes) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Tagihan Ke Client</label>
                        <input type="number" min="0" step="0.01" class="form-control" value="{{ $estimatedGrandTotal }}" readonly>
                        <small class="text-muted">Setelah disimpan, tagihan ini otomatis muncul di menu pembayaran client.</small>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Perhitungan Kasir</button>
                        @if ($transaction->processed_at || $transaction->payment)
                            <a href="{{ route('cashier.transactions.invoice', $transaction->id) }}" target="_blank" class="btn btn-outline-primary">Lihat Invoice</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Status Pembayaran</h5>
                <p class="mb-2"><strong>Status:</strong> {{ strtoupper($transaction->payment?->payment_status ?? 'UNPAID') }}</p>
                <p class="mb-2"><strong>Dibayar:</strong> Rp {{ number_format((float) ($transaction->payment?->amount_paid ?? 0), 0, ',', '.') }}</p>
                <p class="mb-0"><strong>Diproses Kasir:</strong> {{ $transaction->kasir?->name ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
