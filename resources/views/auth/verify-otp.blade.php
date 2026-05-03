<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP | Bengkel Mobil</title>
    <link rel="icon" type="image/png" href="{{ asset('pato/images/icons/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('pato/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('pato/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <style>
        :root {
            --bg: #07131f;
            --panel: rgba(10, 22, 35, 0.88);
            --border: rgba(255,255,255,.08);
            --text: #f4f7fb;
            --muted: #a3b5ca;
            --accent: #ff6b2c;
            --accent-strong: #ff9957;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top right, rgba(255, 107, 44, 0.18), transparent 26%),
                linear-gradient(135deg, #06101a 0%, #0d1b2a 50%, #152b40 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .otp-card {
            width: 100%;
            max-width: 560px;
            border-radius: 30px;
            border: 1px solid var(--border);
            background: var(--panel);
            backdrop-filter: blur(16px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.32);
            padding: 34px 30px;
        }
        .otp-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.08);
            color: #ffd7c4;
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        h1 {
            margin: 18px 0 10px;
            font-size: clamp(2rem, 4vw, 2.8rem);
            letter-spacing: -.03em;
        }
        .lead {
            color: var(--muted);
            line-height: 1.75;
            margin-bottom: 24px;
        }
        .meta-box {
            border-radius: 18px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.06);
            padding: 16px 18px;
            margin-bottom: 22px;
        }
        .meta-box strong {
            display: block;
            margin-bottom: 6px;
            font-size: .92rem;
        }
        .meta-box span {
            color: var(--muted);
            font-size: .92rem;
        }
        .alert-box {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255, 107, 44, 0.12);
            border: 1px solid rgba(255, 107, 44, 0.24);
        }
        .alert-success-box {
            background: rgba(47, 211, 161, 0.14);
            border-color: rgba(47, 211, 161, 0.26);
            color: #dbfff2;
        }
        .field-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
        }
        .otp-input {
            width: 100%;
            min-height: 60px;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,.08);
            background: rgba(255,255,255,.05);
            color: #fff;
            padding: 0 18px;
            text-align: center;
            letter-spacing: .42em;
            font-size: 1.4rem;
            font-weight: 700;
            outline: none;
        }
        .otp-input:focus {
            border-color: rgba(255, 153, 87, 0.9);
            box-shadow: 0 0 0 4px rgba(255, 107, 44, 0.14);
            background: rgba(255,255,255,.08);
        }
        .action-btn, .ghost-btn {
            width: 100%;
            min-height: 56px;
            border-radius: 18px;
            font-weight: 800;
            letter-spacing: .02em;
        }
        .action-btn {
            border: 0;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            box-shadow: 0 20px 36px rgba(255, 107, 44, 0.24);
        }
        .ghost-btn {
            margin-top: 12px;
            border: 1px solid rgba(255,255,255,.1);
            background: rgba(255,255,255,.04);
            color: #e7eef8;
        }
        .helper {
            margin-top: 18px;
            color: var(--muted);
            font-size: .92rem;
            line-height: 1.7;
        }
        .helper a {
            color: #fff;
            font-weight: 700;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <main class="otp-card">
        <span class="otp-badge">
            <i class="fa fa-shield"></i>
            Verifikasi Akun Baru
        </span>

        <h1>Masukkan kode OTP.</h1>
        <p class="lead">Setelah daftar akun baru, kami kirim kode OTP ke email Anda. Masukkan 6 digit kode itu untuk mengaktifkan akun sebelum login.</p>

        @if (session('success'))
            <div class="alert-box alert-success-box">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-box">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="meta-box">
            <strong>Email Tujuan</strong>
            <span>{{ $email }}</span>
            @if ($expiresAt)
                <br><span>Kode berlaku sampai {{ $expiresAt->format('d-m-Y H:i') }}</span>
            @endif
        </div>

        <form method="POST" action="{{ route('verification.otp.verify') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <label class="field-label" for="otp">Kode OTP</label>
            <input id="otp" class="otp-input" type="text" name="otp" inputmode="numeric" maxlength="6" placeholder="000000" value="{{ old('otp') }}" required>

            <button type="submit" class="action-btn mt-4">Verifikasi dan Aktifkan Akun</button>
        </form>

        <form method="POST" action="{{ route('verification.otp.resend') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="ghost-btn">Kirim Ulang OTP</button>
        </form>

        <p class="helper">
            Sudah punya akun aktif? <a href="{{ route('login') }}">Kembali ke login</a>
        </p>
    </main>
</body>
</html>
