<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Servis Selesai - Tagihan Siap Dibayar</title>
</head>
<body style="margin:0;padding:24px;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <div style="max-width:600px;margin:0 auto;background:#ffffff;border-radius:18px;padding:32px;border:1px solid #e5e7eb;">
        <div style="display:inline-block;padding:8px 14px;border-radius:999px;background:#e8fff5;color:#047857;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;">
            Bengkel Mobil
        </div>

        <h1 style="margin:18px 0 10px;font-size:28px;line-height:1.2;color:#111827;">Servis kendaraan Anda sudah selesai</h1>

        <p style="margin:0 0 18px;line-height:1.7;color:#4b5563;">
            Halo {{ $customer->name }}, servis untuk kendaraan Anda sudah selesai diproses dan tagihan sekarang sudah siap dibayar.
        </p>

        <div style="margin:24px 0;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden;">
            <div style="padding:14px 18px;background:#f8fafc;font-weight:700;color:#111827;">
                Ringkasan Tagihan
            </div>
            <div style="padding:18px;">
                <p style="margin:0 0 12px;color:#4b5563;">
                    <strong>Booking:</strong> #{{ $transaction->booking?->id ?? '-' }}<br>
                    <strong>Kendaraan:</strong> {{ trim(($transaction->booking?->vehicle?->brand ?? '') . ' ' . ($transaction->booking?->customer_vehicle_model ?? '')) ?: '-' }}<br>
                    <strong>Plat Nomor:</strong> {{ $transaction->booking?->customer_license_plate ?? '-' }}<br>
                    <strong>Tanggal Servis:</strong> {{ $transaction->booking?->booking_date ? \Carbon\Carbon::parse($transaction->booking->booking_date)->format('d-m-Y') : '-' }}
                </p>

                <div style="padding:18px;border-radius:14px;background:#111827;text-align:center;">
                    <div style="font-size:13px;color:#cbd5e1;letter-spacing:.08em;text-transform:uppercase;margin-bottom:8px;">Total Tagihan</div>
                    <div style="font-size:32px;font-weight:800;color:#ffffff;">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <p style="margin:0 0 18px;line-height:1.7;color:#4b5563;">
            Silakan login ke akun Anda dan buka menu pembayaran untuk menyelesaikan tagihan servis ini.
        </p>

        <p style="margin:0 0 18px;line-height:1.7;color:#4b5563;">
            Jika Anda membuka email ini dari HP dan belum login, sistem akan meminta Anda masuk dulu ke akun customer, lalu Anda bisa lanjut ke halaman pembayaran.
        </p>

        <p style="margin:0;">
            <a href="{{ route('payments.index') }}" style="display:inline-block;padding:14px 22px;border-radius:999px;background:#f97316;color:#ffffff;text-decoration:none;font-weight:700;">
                Buka Halaman Pembayaran
            </a>
        </p>
    </div>
</body>
</html>
