<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pembayaran Servis</title>
</head>
<body style="margin:0;padding:24px;background:#f4f6fb;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <div style="max-width:760px;margin:0 auto;background:#ffffff;border-radius:20px;overflow:hidden;border:1px solid #e5e7eb;">
        <div style="padding:28px 30px;background:linear-gradient(135deg,#0f2747 0%,#184f88 60%,#e16a2a 100%);color:#ffffff;">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                <tr>
                    <td>
                        <div style="font-size:28px;font-weight:800;line-height:1.2;">Invoice Pembayaran Servis</div>
                        <div style="margin-top:6px;font-size:14px;opacity:.88;">Bengkel Mobil</div>
                    </td>
                    <td style="text-align:right;vertical-align:top;">
                        <div style="display:inline-block;padding:12px 14px;border-radius:16px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.18);font-size:13px;line-height:1.6;">
                            <strong>Invoice #{{ $transaction->id }}</strong><br>
                            {{ optional($payment->payment_date)->format('d M Y') ?? now()->format('d M Y') }}<br>
                            Status: LUNAS
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div style="padding:28px 30px;">
            <p style="margin:0 0 18px;line-height:1.75;color:#4b5563;">
                Halo {{ $customer->name }}, pembayaran servis Anda sudah kami terima. Berikut invoice untuk transaksi kendaraan Anda.
            </p>

            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:separate;border-spacing:0 16px;">
                <tr>
                    <td style="width:50%;vertical-align:top;padding-right:8px;">
                        <div style="padding:18px;border-radius:18px;background:#f8fafc;border:1px solid #e5ebf3;height:100%;">
                            <div style="font-size:12px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:10px;">Invoice Untuk</div>
                            <div style="font-weight:700;margin-bottom:6px;">{{ $customer->name ?? '-' }}</div>
                            <div style="color:#4b5563;line-height:1.7;">{{ $customer->email ?? '-' }}</div>
                            <div style="color:#4b5563;line-height:1.7;">{{ $customer->phone ?? '-' }}</div>
                            <div style="color:#4b5563;line-height:1.7;">{{ $customer->address ?? '-' }}</div>
                        </div>
                    </td>
                    <td style="width:50%;vertical-align:top;padding-left:8px;">
                        <div style="padding:18px;border-radius:18px;background:#f8fafc;border:1px solid #e5ebf3;height:100%;">
                            <div style="font-size:12px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:10px;">Informasi Servis</div>
                            <div style="color:#4b5563;line-height:1.8;">
                                <strong>Kendaraan:</strong> {{ trim(($transaction->booking?->vehicle?->brand ?? '') . ' ' . ($transaction->booking?->customer_vehicle_model ?? '')) ?: '-' }}<br>
                                <strong>Plat:</strong> {{ $transaction->booking?->customer_license_plate ?? '-' }}<br>
                                <strong>Mekanik:</strong> {{ $transaction->mekanik?->name ?? '-' }}<br>
                                <strong>Metode Bayar:</strong> {{ strtoupper($payment->payment_method ?? '-') }}
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <div style="margin-top:8px;border:1px solid #e5ebf3;border-radius:18px;overflow:hidden;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th align="left" style="padding:14px 16px;font-size:12px;text-transform:uppercase;color:#64748b;border-bottom:1px solid #e5ebf3;">Item</th>
                            <th align="right" style="padding:14px 16px;font-size:12px;text-transform:uppercase;color:#64748b;border-bottom:1px solid #e5ebf3;">Qty</th>
                            <th align="right" style="padding:14px 16px;font-size:12px;text-transform:uppercase;color:#64748b;border-bottom:1px solid #e5ebf3;">Harga</th>
                            <th align="right" style="padding:14px 16px;font-size:12px;text-transform:uppercase;color:#64748b;border-bottom:1px solid #e5ebf3;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($serviceItems as $item)
                            <tr>
                                <td style="padding:14px 16px;border-bottom:1px solid #e5ebf3;">{{ $item['name'] }}</td>
                                <td align="right" style="padding:14px 16px;border-bottom:1px solid #e5ebf3;">{{ $item['qty'] }}</td>
                                <td align="right" style="padding:14px 16px;border-bottom:1px solid #e5ebf3;">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td align="right" style="padding:14px 16px;border-bottom:1px solid #e5ebf3;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        @foreach ($sparepartItems as $item)
                            <tr>
                                <td style="padding:14px 16px;border-bottom:1px solid #e5ebf3;">{{ $item['name'] }}</td>
                                <td align="right" style="padding:14px 16px;border-bottom:1px solid #e5ebf3;">{{ $item['qty'] }}</td>
                                <td align="right" style="padding:14px 16px;border-bottom:1px solid #e5ebf3;">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td align="right" style="padding:14px 16px;border-bottom:1px solid #e5ebf3;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top:22px;text-align:right;">
                <div style="display:inline-block;min-width:320px;padding:18px 20px;border-radius:18px;background:#0f172a;color:#ffffff;text-align:left;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                        <span>Total Jasa</span>
                        <span>Rp {{ number_format((float) $transaction->total_service, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                        <span>Total Sparepart</span>
                        <span>Rp {{ number_format((float) $transaction->total_sparepart, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding-top:12px;border-top:1px solid rgba(255,255,255,.14);font-size:18px;font-weight:800;">
                        <span>Grand Total</span>
                        <span>Rp {{ number_format((float) $transaction->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <p style="margin:24px 0 0;line-height:1.7;color:#4b5563;">
                Anda juga bisa membuka invoice dari akun customer untuk melihat versi halaman cetak.
            </p>

            <p style="margin:18px 0 0;">
                <a href="{{ route('transactions.invoice', $transaction->id) }}" style="display:inline-block;padding:14px 22px;border-radius:999px;background:#f97316;color:#ffffff;text-decoration:none;font-weight:700;">
                    Buka Invoice
                </a>
            </p>
        </div>
    </div>
</body>
</html>
