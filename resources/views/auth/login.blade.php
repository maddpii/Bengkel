<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Bengkel Mobil</title>
    <link rel="icon" type="image/png" href="{{ asset('pato/images/icons/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('pato/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('pato/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <style>
        :root {
            --bg: #08131f;
            --bg-soft: #112033;
            --panel: rgba(11, 24, 38, 0.82);
            --panel-border: rgba(255, 255, 255, 0.08);
            --text: #f4f7fb;
            --muted: #9fb2c9;
            --accent: #ff6b2c;
            --accent-strong: #ff8a3d;
            --track: #1e3248;
            --success: #2fd3a1;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(255, 107, 44, 0.24), transparent 28%),
                radial-gradient(circle at bottom right, rgba(47, 211, 161, 0.16), transparent 24%),
                linear-gradient(135deg, #06101a 0%, #0d1b2a 52%, #13283d 100%);
            overflow-x: hidden;
        }

        body::before,
        body::after {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
        }

        body::before {
            background-image:
                linear-gradient(115deg, transparent 0 46%, rgba(255,255,255,0.04) 46% 47%, transparent 47% 100%),
                linear-gradient(115deg, transparent 0 58%, rgba(255,255,255,0.03) 58% 59%, transparent 59% 100%);
            opacity: .45;
        }

        body::after {
            background:
                radial-gradient(circle, rgba(255,255,255,0.12) 1px, transparent 1px);
            background-size: 26px 26px;
            mask-image: linear-gradient(180deg, rgba(0,0,0,0.45), transparent 78%);
            opacity: .24;
        }

        .auth-shell {
            position: relative;
            min-height: 100vh;
            padding: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-shell::before {
            content: "";
            position: absolute;
            left: 4%;
            bottom: 8%;
            width: 460px;
            height: 160px;
            background:
                radial-gradient(circle at 22% 76%, rgba(8, 19, 31, 0.95) 0 18px, transparent 19px),
                radial-gradient(circle at 78% 76%, rgba(8, 19, 31, 0.95) 0 18px, transparent 19px),
                linear-gradient(180deg, transparent 0 52%, rgba(255, 255, 255, 0.08) 52% 58%, transparent 58% 100%),
                linear-gradient(90deg, transparent 0 8%, rgba(255, 255, 255, 0.08) 8% 82%, transparent 82% 100%);
            clip-path: polygon(5% 72%, 15% 54%, 30% 46%, 40% 28%, 66% 28%, 77% 45%, 91% 54%, 96% 72%, 100% 72%, 100% 82%, 0 82%, 0 72%);
            filter: drop-shadow(0 18px 30px rgba(0, 0, 0, 0.25));
            opacity: .9;
        }

        .auth-grid {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1220px;
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            gap: 28px;
            align-items: stretch;
        }

        .brand-panel,
        .auth-panel {
            border: 1px solid var(--panel-border);
            border-radius: 32px;
            backdrop-filter: blur(18px);
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.32);
        }

        .brand-panel {
            background:
                linear-gradient(145deg, rgba(15, 31, 48, 0.92) 0%, rgba(7, 18, 29, 0.88) 100%);
            padding: 42px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 700px;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: #ffd7c4;
            font-size: .82rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .brand-title {
            margin: 22px 0 16px;
            font-size: clamp(2.5rem, 4.2vw, 4.6rem);
            line-height: .96;
            font-weight: 800;
            letter-spacing: -.04em;
            max-width: 700px;
        }

        .brand-title span {
            color: var(--accent-strong);
        }

        .brand-copy {
            max-width: 540px;
            color: var(--muted);
            font-size: 1.02rem;
            line-height: 1.75;
            margin-bottom: 28px;
        }

        .brand-highlights {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-top: 26px;
        }

        .highlight-card {
            padding: 18px 18px 20px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .highlight-card small {
            display: block;
            color: #9eb2c8;
            font-size: .76rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 10px;
        }

        .highlight-card strong {
            display: block;
            font-size: 1.32rem;
            margin-bottom: 6px;
        }

        .highlight-card span {
            color: var(--muted);
            font-size: .92rem;
            line-height: 1.55;
        }

        .brand-lane {
            margin-top: 34px;
            padding: 24px;
            border-radius: 26px;
            background:
                linear-gradient(135deg, rgba(255, 107, 44, 0.16), rgba(255, 138, 61, 0.05)),
                rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-lane-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 16px;
        }

        .brand-lane-header strong {
            font-size: 1.05rem;
        }

        .brand-lane-header span {
            color: #ffd7c4;
            font-size: .84rem;
        }

        .lane-track {
            position: relative;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(255,255,255,0.08), rgba(255,255,255,0.16));
            overflow: hidden;
        }

        .lane-track::before {
            content: "";
            position: absolute;
            inset: 0;
            width: 72%;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--accent), #ffb25b);
            box-shadow: 0 0 24px rgba(255, 107, 44, 0.35);
        }

        .lane-labels {
            margin-top: 14px;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            color: var(--muted);
            font-size: .88rem;
        }

        .auth-panel {
            background: var(--panel);
            padding: 36px 34px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 26px;
        }

        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #dce7f6;
            text-decoration: none;
            font-weight: 600;
        }

        .back-home:hover {
            color: #fff;
            text-decoration: none;
        }

        .auth-switch {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 7px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 999px;
        }

        .auth-switch a {
            text-decoration: none;
            color: #c3d2e5;
            padding: 10px 18px;
            border-radius: 999px;
            font-weight: 700;
            font-size: .92rem;
        }

        .auth-switch .is-active {
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            color: #fff;
            box-shadow: 0 12px 24px rgba(255, 107, 44, 0.22);
        }

        .auth-card {
            padding: 12px 0 0;
        }

        .auth-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #ffd7c4;
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .auth-card h1 {
            margin: 0 0 10px;
            font-size: clamp(2rem, 3vw, 2.8rem);
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .auth-card p {
            color: var(--muted);
            line-height: 1.75;
            margin-bottom: 26px;
        }

        .alert-box {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255, 107, 44, 0.12);
            border: 1px solid rgba(255, 107, 44, 0.24);
            color: #ffe4d8;
        }

        .alert-box ul {
            margin: 0;
            padding-left: 18px;
        }

        .input-grid {
            display: grid;
            gap: 18px;
        }

        .field-label {
            display: block;
            margin-bottom: 10px;
            color: #f4f7fb;
            font-weight: 700;
            font-size: .92rem;
        }

        .input-shell {
            position: relative;
        }

        .input-shell i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #8ea4bc;
            font-size: 1rem;
        }

        .input-shell .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            min-width: 40px;
            min-height: 40px;
            border: 0;
            border-radius: 12px;
            background: transparent;
            color: #c7d5e5;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color .2s ease, color .2s ease;
        }

        .input-shell .password-toggle:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .input-shell input {
            width: 100%;
            min-height: 58px;
            border: 1px solid rgba(255, 255, 255, 0.09);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.06);
            color: #fff;
            padding: 0 52px 0 50px;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
        }

        .input-shell input::placeholder {
            color: #8ea4bc;
        }

        .input-shell input:focus {
            border-color: rgba(255, 138, 61, 0.9);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(255, 107, 44, 0.14);
        }

        .auth-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .remember-check {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #d7e2ef;
            font-size: .92rem;
        }

        .remember-check input {
            width: 18px;
            height: 18px;
            accent-color: var(--accent);
        }

        .auth-submit {
            width: 100%;
            min-height: 58px;
            border: 0;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            color: #fff;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: .02em;
            box-shadow: 0 20px 36px rgba(255, 107, 44, 0.24);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .auth-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 24px 42px rgba(255, 107, 44, 0.32);
        }

        .auth-footer-note {
            margin-top: 20px;
            color: #9fb2c9;
            font-size: .92rem;
            line-height: 1.7;
        }

        .auth-footer-note a {
            color: #fff;
            font-weight: 700;
            text-decoration: none;
        }

        .verification-help {
            margin-top: 18px;
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .verification-help p {
            margin: 0 0 12px;
            color: #dce7f6;
            font-size: .92rem;
            line-height: 1.65;
        }

        .verification-help a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 0 18px;
            border-radius: 999px;
            background: rgba(255, 107, 44, 0.16);
            border: 1px solid rgba(255, 107, 44, 0.26);
            color: #fff;
            font-weight: 700;
            text-decoration: none;
        }

        @media (max-width: 991.98px) {
            .auth-shell {
                padding: 18px;
            }

            .auth-shell::before {
                display: none;
            }

            .auth-grid {
                grid-template-columns: 1fr;
            }

            .brand-panel {
                min-height: auto;
                padding: 28px;
            }

            .brand-highlights {
                grid-template-columns: 1fr;
            }

            .auth-panel {
                padding: 24px 20px 26px;
            }

            .auth-topbar {
                flex-direction: column;
                align-items: stretch;
            }

            .auth-switch {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <main class="auth-shell">
        <div class="auth-grid">
            <section class="brand-panel">
                <div>
                    <span class="brand-badge">
                        <i class="fa fa-car"></i>
                        Bengkel Mobil
                    </span> 
                    <h1 class="brand-title">Digitalisasi Bengkel Anda untuk <span>Layanan yang Lebih </span> Maksimal.</h1>
                    <p class="brand-copy">
                        Kelola booking, progres servis, penggunaan sparepart, dan transaksi pelanggan dalam satu sistem yang ringkas, jelas, dan siap dipakai setiap hari.
                    </p>

                    <div class="brand-highlights">
                        <div class="highlight-card">
                            <small>Booking & Servis</small>
                            <strong>Terpantau</strong>
                            <span>Status pekerjaan lebih mudah diikuti dari antrean masuk sampai kendaraan selesai.</span>
                        </div>
                        <div class="highlight-card">
                            <small>Sparepart</small>
                            <strong>Tercatat</strong>
                            <span>Pemakaian komponen tersimpan rapi sehingga stok dan biaya lebih mudah dicek.</span>
                        </div>
                        <div class="highlight-card">
                            <small>Akses Akun</small>
                            <strong>Lebih Nyaman</strong>
                            <span>Form login dibuat lebih jelas agar cepat dipahami dan minim kesalahan input.</span>
                        </div>
                    </div>
                </div>

                <div class="brand-lane">
                    <div class="brand-lane-header">
                        <strong>Alur Servis Bengkel</strong>
                        <span>Tersusun dengan jelas</span>
                    </div>
                    <div class="lane-track"></div>
                    <div class="lane-labels">
                        <span>Booking</span>
                        <span>Pengerjaan</span>
                        <span>Sparepart</span>
                        <span>Pembayaran</span>
                    </div>
                </div>
            </section>

            <section class="auth-panel">
                <div class="auth-topbar">
                    <a href="{{ route('home') }}" class="back-home">
                        <i class="fa fa-arrow-left"></i>
                        Kembali ke beranda
                    </a>
                    <div class="auth-switch">
                        <a href="{{ route('login') }}" class="is-active">Login</a>
                        <a href="{{ route('register') }}">Daftar</a>
                    </div>
                </div>

                <div class="auth-card">
                    <div class="auth-kicker">
                        <i class="fa fa-wrench"></i>
                        Akses akun bengkel
                    </div>
                    <h1>Masuk ke akun Anda.</h1>
                    <p>Gunakan email dan password yang terdaftar untuk membuka booking, riwayat kendaraan, dan status servis.</p>

                    @if ($errors->any())
                        <div class="alert-box">
                            <ul>
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/login') }}">
                        @csrf
                        <div class="input-grid">
                            <div>
                                <label class="field-label" for="email">Email</label>
                                <div class="input-shell">
                                    <i class="fa fa-envelope-o"></i>
                                    <input id="email" type="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div>
                                <label class="field-label" for="password">Password</label>
                                <div class="input-shell">
                                    <i class="fa fa-lock"></i>
                                    <input id="password" type="password" name="password" placeholder="Masukkan password" required>
                                    <button type="button" class="password-toggle" data-toggle-password="password" aria-label="Lihat password">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="auth-row">
                                <label class="remember-check" for="remember">
                                    <input id="remember" type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                                    <span>Ingat saya di perangkat ini</span>
                                </label>
                            </div>

                            <button type="submit" class="auth-submit">Masuk ke Bengkel Mobil</button>
                        </div>
                    </form>

                    @if (session('pending_verification_email'))
                        <div class="verification-help">
                            <p>Akun ini belum aktif karena masih menunggu verifikasi OTP dari proses pendaftaran akun baru.</p>
                            <a href="{{ route('verification.otp.notice', ['email' => session('pending_verification_email')]) }}">
                                Lanjutkan Verifikasi OTP
                            </a>
                        </div>
                    @endif

                    <p class="auth-footer-note">
                        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                    </p>
                </div>
            </section>
        </div>
    </main>
    <script>
        document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
            button.addEventListener('click', function () {
                var input = document.getElementById(button.getAttribute('data-toggle-password'));

                if (!input) {
                    return;
                }

                var isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                button.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Lihat password');
                button.innerHTML = '<i class="fa ' + (isHidden ? 'fa-eye-slash' : 'fa-eye') + '"></i>';
            });
        });
    </script>
</body>
</html>
