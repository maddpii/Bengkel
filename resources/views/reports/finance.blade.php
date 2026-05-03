@extends('layout.admin')

@section('title', 'Laporan Keuangan')
@section('page_title', 'Laporan Keuangan')

@section('breadcrumb_right')
    <span class="badge badge-light px-3 py-2">Periode {{ $months[$month] ?? $month }} {{ $year }}</span>
@endsection

@push('styles')
    <style>
        .finance-card{height:100%}
        .finance-card .card-body{padding:1.5rem}
        .finance-metric{color:#fff;border:0}
        .finance-metric .metric-kicker{font-size:.74rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;opacity:.9}
        .finance-metric .metric-value{font-size:1.85rem;font-weight:800;letter-spacing:-.03em;margin:.55rem 0 .35rem}
        .finance-metric .metric-copy{font-size:.88rem;line-height:1.5;opacity:.92}
        .finance-table{margin-bottom:0}
        .finance-table th,.finance-table td{vertical-align:middle}
        .finance-table thead th{font-size:.76rem;letter-spacing:.07em;text-transform:uppercase}
        .finance-table .meta-text{display:block;color:#7b879d;font-size:.82rem;margin-top:.25rem}
        .finance-filter-card{border-style:solid}
        .finance-summary-list{display:grid;gap:.9rem}
        .finance-summary-item{align-items:center;border-bottom:1px solid #edf1f5;display:flex;justify-content:space-between;gap:1rem;padding-bottom:.9rem}
        .finance-summary-item:last-child{border-bottom:0;padding-bottom:0}
        .finance-summary-label{color:#5f6b7a;font-weight:600}
        .finance-summary-value{color:#22303c;font-weight:800}
        .finance-table-shell{border:1px solid #edf1f5;border-radius:18px;overflow:hidden}
        .finance-table-footer th{background:#f8fafc}
        .finance-empty{border:1px dashed #d8e2eb;border-radius:16px;padding:1rem 1.1rem;color:#7d8a97;background:#fbfcfe}
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card finance-filter-card">
            <div class="card-body">
                <h5 class="card-title">Filter Laporan Keuangan</h5>
                <p class="text-muted mb-4">Pilih bulan dan tahun untuk melihat ringkasan pemasukan dan pengeluaran bengkel.</p>
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Bulan</label>
                        <select name="month" class="form-control">
                            @foreach ($months as $number => $label)
                                <option value="{{ $number }}" @selected($month === $number)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tahun</label>
                        <input type="number" min="2024" name="year" class="form-control" value="{{ $year }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-block">Tampilkan Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card finance-card finance-metric" style="background:linear-gradient(135deg,#1c7ed6 0%,#1971c2 100%);">
            <div class="card-body">
                <div class="metric-kicker">Jumlah Booking</div>
                <div class="metric-value">{{ $summary['booking_count'] }}</div>
                <div class="metric-copy">{{ $summary['completed_count'] }} booking selesai di periode ini</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card finance-card finance-metric" style="background:linear-gradient(135deg,#12b886 0%,#0ca678 100%);">
            <div class="card-body">
                <div class="metric-kicker">Pemasukan</div>
                <div class="metric-value">Rp {{ number_format($summary['revenue_total'], 0, ',', '.') }}</div>
                <div class="metric-copy">Total nilai transaksi servis pada periode terpilih</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card finance-card finance-metric" style="background:linear-gradient(135deg,#e03131 0%,#c92a2a 100%);">
            <div class="card-body">
                <div class="metric-kicker">Pengeluaran</div>
                <div class="metric-value">Rp {{ number_format($summary['expense_total'], 0, ',', '.') }}</div>
                <div class="metric-copy">Berdasarkan harga beli sparepart yang dipakai</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card finance-card finance-metric" style="background:linear-gradient(135deg,#7048e8 0%,#5f3dc4 100%);">
            <div class="card-body">
                <div class="metric-kicker">Laba Kotor</div>
                <div class="metric-value">Rp {{ number_format($summary['gross_profit'], 0, ',', '.') }}</div>
                <div class="metric-copy">Pemasukan dikurangi pengeluaran sparepart</div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card finance-card">
            <div class="card-body">
                <h5 class="card-title">Ringkasan Tahunan</h5>
                <div class="finance-summary-list">
                    <div class="finance-summary-item">
                        <span class="finance-summary-label">Total Booking {{ $year }}</span>
                        <span class="finance-summary-value">{{ $yearSummary['booking_count'] }}</span>
                    </div>
                    <div class="finance-summary-item">
                        <span class="finance-summary-label">Total Pemasukan {{ $year }}</span>
                        <span class="finance-summary-value">Rp {{ number_format($yearSummary['revenue_total'], 0, ',', '.') }}</span>
                    </div>
                    <div class="finance-summary-item">
                        <span class="finance-summary-label">Total Pengeluaran {{ $year }}</span>
                        <span class="finance-summary-value">Rp {{ number_format($yearSummary['expense_total'], 0, ',', '.') }}</span>
                    </div>
                    <div class="finance-summary-item">
                        <span class="finance-summary-label">Total Laba Kotor {{ $year }}</span>
                        <span class="finance-summary-value">Rp {{ number_format($yearSummary['revenue_total'] - $yearSummary['expense_total'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card finance-card">
            <div class="card-body">
                <h5 class="card-title">Sorotan Periode</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small text-uppercase">Rata-rata tiket</div>
                            <div class="h5 mb-1 mt-2">Rp {{ number_format($summary['average_ticket'], 0, ',', '.') }}</div>
                            <div class="text-muted small">Nilai transaksi rata-rata tiap booking servis.</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small text-uppercase">Kendaraan aktif</div>
                            <div class="h5 mb-1 mt-2">{{ $summary['vehicle_count'] }}</div>
                            <div class="text-muted small">Jumlah kendaraan unik yang tercatat masuk pada periode ini.</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small text-uppercase">Margin kasar</div>
                            <div class="h5 mb-1 mt-2">
                                {{ $summary['revenue_total'] > 0 ? number_format(($summary['gross_profit'] / $summary['revenue_total']) * 100, 1, ',', '.') : '0,0' }}%
                            </div>
                            <div class="text-muted small">Persentase laba kotor terhadap total pemasukan servis.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card finance-card">
            <div class="card-body">
                <h5 class="card-title">Detail Pemasukan dan Pengeluaran per Transaksi</h5>
                <p class="text-muted mb-3">Gunakan tabel ini untuk melihat transaksi mana yang menghasilkan pemasukan, pengeluaran sparepart, dan laba kotor.</p>
                @if ($financialRows->isEmpty())
                    <div class="finance-empty">Belum ada data transaksi pada periode ini.</div>
                @else
                <div class="table-responsive finance-table-shell">
                    <table class="table table-hover finance-table">
                        <thead>
                            <tr>
                                <th>Booking</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Mekanik</th>
                                <th>Pemasukan</th>
                                <th>Pengeluaran</th>
                                <th>Laba Kotor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($financialRows as $row)
                                <tr>
                                    <td>#{{ $row['booking_id'] ?? '-' }}</td>
                                    <td>{{ $row['date'] ? \Carbon\Carbon::parse($row['date'])->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $row['customer'] }}</td>
                                    <td>
                                        {{ $row['vehicle'] ?: '-' }}
                                        <span class="meta-text">{{ $row['license_plate'] }}</span>
                                    </td>
                                    <td>{{ $row['mechanic'] }}</td>
                                    <td class="text-success font-weight-bold">Rp {{ number_format($row['revenue'], 0, ',', '.') }}</td>
                                    <td class="text-danger font-weight-bold">Rp {{ number_format($row['expense'], 0, ',', '.') }}</td>
                                    <td class="font-weight-bold">Rp {{ number_format($row['profit'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                            <tfoot class="finance-table-footer">
                                <tr>
                                    <th colspan="5" class="text-right">Total</th>
                                    <th class="text-success">Rp {{ number_format($financialRows->sum('revenue'), 0, ',', '.') }}</th>
                                    <th class="text-danger">Rp {{ number_format($financialRows->sum('expense'), 0, ',', '.') }}</th>
                                    <th>Rp {{ number_format($financialRows->sum('profit'), 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
