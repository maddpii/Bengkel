<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode OTP Verifikasi Akun</title>
</head>
<body style="margin:0;padding:24px;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <div style="max-width:560px;margin:0 auto;background:#ffffff;border-radius:18px;padding:32px;border:1px solid #e5e7eb;">
        <div style="display:inline-block;padding:8px 14px;border-radius:999px;background:#fff3ed;color:#c2410c;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;">
            Bengkel Mobil
        </div>
        <h1 style="margin:18px 0 10px;font-size:28px;line-height:1.2;color:#111827;">Verifikasi akun baru Anda</h1>
        <p style="margin:0 0 18px;line-height:1.7;color:#4b5563;">
            Halo {{ $user->name }}, terima kasih sudah membuat akun baru di Bengkel Mobil.
            Gunakan kode OTP berikut untuk mengaktifkan akun Anda sebelum login.
        </p>

        <div style="margin:24px 0;padding:22px;border-radius:16px;background:#111827;text-align:center;">
            <div style="font-size:13px;color:#cbd5e1;letter-spacing:.08em;text-transform:uppercase;margin-bottom:8px;">Kode OTP</div>
            <div style="font-size:34px;font-weight:800;letter-spacing:.22em;color:#ffffff;">{{ $otp }}</div>
        </div>

        <p style="margin:0 0 10px;line-height:1.7;color:#4b5563;">
            Kode ini berlaku sampai <strong>{{ $expiresAt->format('d-m-Y H:i') }}</strong>.
        </p>
        <p style="margin:0;line-height:1.7;color:#4b5563;">
            Jika Anda tidak merasa membuat akun baru, abaikan email ini.
        </p>
    </div>
</body>
</html>
