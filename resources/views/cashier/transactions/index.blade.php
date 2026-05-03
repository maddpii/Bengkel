@extends('layout.admin')

@section('title', 'Panel Kasir')
@section('page_title', 'Daftar Transaksi Kasir')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Transaksi Siap Diproses Kasir</h5>
                <p class="text-muted mb-3">Daftar ini berisi pekerjaan yang sudah diselesaikan mekanik. Kasir dapat menambahkan jasa layanan, menentukan harga, dan menyimpan pembayaran.</p>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Kendaraan</th>
                                <th>Mekanik</th>
                                <th>Dikirim</th>
                                <th>Total</th>
                                <th>Status Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $transaction)
                                <tr>
                                    <td>#{{ $transaction->id }}</td>
                                    <td>{{ $transaction->booking?->user?->name ?? '-' }}</td>
                                    <td>{{ trim(($transaction->booking?->vehicle?->brand ?? '') . ' ' . ($transaction->booking?->customer_vehicle_model ?? '')) }}</td>
                                    <td>{{ $transaction->mekanik?->name ?? '-' }}</td>
                                    <td>{{ optional($transaction->cashier_ready_at)->format('d-m-Y H:i') ?? '-' }}</td>
                                    <td>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                    <td>{{ strtoupper($transaction->payment?->payment_status ?? 'UNPAID') }}</td>
                                    <td>
                                        <a href="{{ route('cashier.transactions.show', $transaction) }}" class="btn btn-outline-primary btn-sm">
                                            Proses Kasir
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Belum ada transaksi selesai dari mekanik yang masuk ke kasir.</td>
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
