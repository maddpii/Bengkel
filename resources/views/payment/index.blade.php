@extends('layout.app')

@push('styles')
<style>
    .payment-shell{margin-top:40px;margin-bottom:60px}
    .payment-card{border:0;border-radius:24px;box-shadow:0 18px 40px rgba(25,39,52,.08)}
    .payment-status{display:inline-flex;align-items:center;border-radius:999px;font-size:.8rem;font-weight:700;padding:8px 14px}
    .payment-status.unpaid{background:#fff1c7;color:#946200}
    .payment-status.paid{background:#dff7ea;color:#16794f}
    .payment-status.partial{background:#e5efff;color:#2457c5}
</style>
@endpush

@section('title', 'Pembayaran')

@section('content')
<div class="container payment-shell">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 m-0">Pembayaran</h1>
            <!-- <p class="text-muted mb-0 mt-2">Tagihan dari kasir akan muncul di sini. Klik tombol bayar untuk membuka popup default Midtrans Snap dan pilih metode pembayaran yang tersedia.</p> -->
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($transactions->isEmpty())
        <div class="alert alert-info">Belum ada tagihan pembayaran dari kasir.</div>
    @else
        <div class="row g-4">
            @foreach ($transactions as $transaction)
                <div class="col-12">
                    <div class="card payment-card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-3">
                                <div>
                                    <h5 class="mb-1">Transaksi #{{ $transaction->id }}</h5>
                                    <div class="text-muted">
                                        {{ trim(($transaction->booking?->vehicle?->brand ?? '') . ' ' . ($transaction->booking?->customer_vehicle_model ?? '')) }}
                                        ({{ $transaction->booking?->customer_license_plate ?? '-' }})
                                    </div>
                                    <div class="text-muted mt-1">Kasir: {{ $transaction->kasir?->name ?? '-' }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-muted">Total Tagihan</div>
                                    <div class="h4 text-danger fw-bold">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</div>
                                    @php $status = $transaction->payment?->payment_status ?? 'unpaid'; @endphp
                                    <span class="payment-status {{ $status }}">{{ strtoupper($status) }}</span>
                                </div>
                            </div>

                            @if ($transaction->payment && $transaction->payment->payment_status === 'paid')
                                <div class="alert alert-success mb-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                        <span>
                                            Pembayaran sudah diterima pada {{ $transaction->payment->payment_date }} dengan metode {{ strtoupper($transaction->payment->payment_method) }}.
                                        </span>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ url('/transactions/'.$transaction->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                                Beri Ulasan
                                            </a>
                                            <a href="{{ route('transactions.invoice', $transaction->id) }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3">
                                                Lihat Invoice
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <div class="text-muted small">Atas Nama</div>
                                        <div class="fw-semibold">{{ auth()->user()->name }}</div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="text-muted small">Metode</div>
                                        <div class="fw-semibold">Midtrans Snap</div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="text-muted small">Jumlah Bayar</div>
                                        <div class="fw-semibold">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="button" class="btn btn-danger rounded-pill px-4 js-midtrans-pay" data-transaction="{{ $transaction->id }}">
                                                Bayar Sekarang
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 js-midtrans-refresh" data-transaction="{{ $transaction->id }}">
                                                Cek Status
                                            </button>
                                            @if ($transaction->payment || $transaction->processed_at)
                                                <a href="{{ route('transactions.invoice', $transaction->id) }}" target="_blank" class="btn btn-outline-danger rounded-pill px-4">
                                                    Invoice
                                                </a>
                                            @endif
                                        </div>
                                        <!-- <div class="text-muted small mt-2">
                                            Popup Midtrans akan menampilkan metode default yang aktif di akun Anda, seperti QRIS, virtual account, kartu, dan e-wallet.
                                        </div> -->
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
    @if (config('services.midtrans.client_key'))
        <script
            src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ config('services.midtrans.client_key') }}">
        </script>
    @endif
    <script>
        (function () {
            function postJson(url, payload) {
                return fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload || {})
                }).then(function (response) {
                    return response.json().catch(function () {
                        return {};
                    }).then(function (data) {
                        if (!response.ok) {
                            throw new Error(data.message || 'Request gagal diproses.');
                        }

                        return data;
                    });
                });
            }

            function reloadSoon() {
                window.setTimeout(function () {
                    window.location.reload();
                }, 700);
            }

            document.querySelectorAll('.js-midtrans-pay').forEach(function (button) {
                button.addEventListener('click', function () {
                    var transactionId = button.getAttribute('data-transaction');

                    postJson('/payments/' + transactionId + '/snap', {})
                        .then(function (data) {
                            if (!data.snap_token || !window.snap) {
                                throw new Error('snap token missing');
                            }

                            window.snap.pay(data.snap_token, {
                                onSuccess: function (result) {
                                    postJson('/payments/' + transactionId + '/midtrans-result', result).then(reloadSoon);
                                },
                                onPending: function (result) {
                                    postJson('/payments/' + transactionId + '/midtrans-result', result).then(reloadSoon);
                                },
                                onClose: function () {},
                                onError: function () {
                                    window.alert('Pembayaran Midtrans gagal diproses.');
                                }
                            });
                        })
                        .catch(function (error) {
                            window.alert(error.message || 'Gagal membuka popup Midtrans.');
                        });
                });
            });

            document.querySelectorAll('.js-midtrans-refresh').forEach(function (button) {
                button.addEventListener('click', function () {
                    var transactionId = button.getAttribute('data-transaction');

                    postJson('/payments/' + transactionId + '/refresh-status', {})
                        .then(reloadSoon)
                        .catch(function (error) {
                            window.alert(error.message || 'Gagal mengecek status pembayaran Midtrans.');
                        });
                });
            });
        })();
    </script>
@endpush
