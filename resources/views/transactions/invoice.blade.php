<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #{{ $transaction->id }}</title>
    <style>
        body{background:#f4f6fb;color:#1f2937;font-family:Arial,sans-serif;margin:0;padding:24px}
        .invoice-actions{display:flex;gap:10px;justify-content:flex-end;margin:0 auto 18px;max-width:980px}
        .invoice-btn{background:#fff;border:1px solid #d5dde8;border-radius:999px;color:#1f2937;padding:10px 18px}
        .invoice-shell{background:#fff;border-radius:24px;box-shadow:0 24px 60px rgba(15,23,42,.12);margin:0 auto;max-width:980px;overflow:hidden}
        .invoice-head{background:linear-gradient(135deg,#0f2747 0%,#184f88 60%,#e16a2a 100%);color:#fff;padding:28px 32px}
        .invoice-top{align-items:flex-start;display:flex;gap:16px;justify-content:space-between}
        .invoice-brand{font-size:1.5rem;font-weight:800}
        .invoice-sub{font-size:.9rem;margin-top:6px;opacity:.85}
        .invoice-badge{background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.18);border-radius:18px;padding:14px 16px;text-align:right}
        .invoice-body{padding:28px 32px 34px}
        .invoice-grid{display:grid;gap:18px;grid-template-columns:repeat(2,minmax(0,1fr));margin-bottom:24px}
        .invoice-panel{background:#f8fafc;border:1px solid #e5ebf3;border-radius:18px;padding:18px}
        .invoice-panel h3{font-size:.82rem;font-weight:800;letter-spacing:.08em;margin:0 0 10px;text-transform:uppercase}
        .invoice-panel p{margin:0 0 6px}
        .invoice-table{border-collapse:collapse;width:100%}
        .invoice-table th,.invoice-table td{border-bottom:1px solid #e5ebf3;padding:12px 10px;text-align:left}
        .invoice-table th{color:#64748b;font-size:.8rem;text-transform:uppercase}
        .text-right{text-align:right!important}
        .invoice-total{display:flex;justify-content:flex-end;margin-top:24px}
        .invoice-total-card{background:#0f172a;border-radius:18px;color:#fff;min-width:320px;padding:20px 22px}
        .invoice-total-row{display:flex;justify-content:space-between;margin-bottom:10px}
        .invoice-total-row:last-child{border-top:1px solid rgba(255,255,255,.14);font-size:1.15rem;font-weight:800;margin-bottom:0;padding-top:12px}
        @media print{
            body{background:#fff;padding:0}
            .invoice-actions{display:none}
            .invoice-shell{border-radius:0;box-shadow:none;max-width:none}
        }
        @media (max-width:768px){
            body{padding:14px}
            .invoice-top{flex-direction:column}
            .invoice-grid{grid-template-columns:1fr}
            .invoice-body,.invoice-head{padding:22px}
            .invoice-total-card{min-width:0;width:100%}
        }
    </style>
</head>
<body>
    <div class="invoice-actions">
        <button type="button" onclick="window.history.back()" class="invoice-btn">Kembali</button>
        <button type="button" onclick="window.print()" class="invoice-btn">Print Invoice</button>
    </div>

    <div class="invoice-shell">
        <div class="invoice-head">
            <div class="invoice-top">
                <div>
                    <div class="invoice-brand">Bengkel Mobil</div>
                    <div class="invoice-sub">Invoice servis kendaraan</div>
                </div>
                <div class="invoice-badge">
                    <div><strong>Invoice #{{ $transaction->id }}</strong></div>
                    <div>{{ optional($transaction->processed_at ?? $transaction->updated_at)->format('d M Y H:i') }}</div>
                    <div>Status: {{ strtoupper($transaction->payment?->payment_status ?? 'UNPAID') }}</div>
                </div>
            </div>
        </div>

        <div class="invoice-body">
            <div class="invoice-grid">
                <div class="invoice-panel">
                    <h3>Invoice Untuk</h3>
                    <p><strong>{{ $transaction->booking?->user?->name ?? '-' }}</strong></p>
                    <p>{{ $transaction->booking?->user?->email ?? '-' }}</p>
                    <p>{{ $transaction->booking?->user?->phone ?? '-' }}</p>
                    <p>{{ $transaction->booking?->user?->address ?? '-' }}</p>
                </div>
                <div class="invoice-panel">
                    <h3>Informasi Servis</h3>
                    <p><strong>Kendaraan:</strong> {{ trim(($transaction->booking?->vehicle?->brand ?? '') . ' ' . ($transaction->booking?->customer_vehicle_model ?? '')) }}</p>
                    <p><strong>Plat:</strong> {{ $transaction->booking?->customer_license_plate ?? '-' }}</p>
                    <p><strong>Mekanik:</strong> {{ $transaction->mekanik?->name ?? '-' }}</p>
                    <p><strong>Kasir:</strong> {{ $transaction->kasir?->name ?? '-' }}</p>
                </div>
            </div>

            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($serviceItems as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td class="text-right">{{ $item['qty'] }}</td>
                            <td class="text-right">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    @foreach ($sparepartItems as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td class="text-right">{{ $item['qty'] }}</td>
                            <td class="text-right">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="invoice-total">
                <div class="invoice-total-card">
                    <div class="invoice-total-row">
                        <span>Total Jasa</span>
                        <span>Rp {{ number_format((float) $transaction->total_service, 0, ',', '.') }}</span>
                    </div>
                    <div class="invoice-total-row">
                        <span>Total Sparepart</span>
                        <span>Rp {{ number_format((float) $transaction->total_sparepart, 0, ',', '.') }}</span>
                    </div>
                    <div class="invoice-total-row">
                        <span>Grand Total</span>
                        <span>Rp {{ number_format((float) $transaction->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
