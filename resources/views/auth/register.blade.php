<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | Bengkel Mobil</title>
    <link rel="icon" type="image/png" href="{{ asset('pato/images/icons/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('pato/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('pato/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <style>
        :root {
            --bg: #07131f;
            --panel: rgba(10, 22, 35, 0.84);
            --panel-border: rgba(255, 255, 255, 0.08);
            --text: #f4f7fb;
            --muted: #a3b5ca;
            --accent: #ff6b2c;
            --accent-strong: #ff9957;
            --line: rgba(255, 255, 255, 0.06);
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
                radial-gradient(circle at top right, rgba(255, 107, 44, 0.18), transparent 26%),
                linear-gradient(135deg, #06101a 0%, #0d1b2a 50%, #152b40 100%);
        }

        .register-shell {
            min-height: 100vh;
            padding: 30px 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-card {
            width: 100%;
            max-width: 1120px;
            display: grid;
            grid-template-columns: .92fr 1.08fr;
            border-radius: 32px;
            overflow: hidden;
            border: 1px solid var(--panel-border);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.34);
            backdrop-filter: blur(16px);
        }

        .register-side,
        .register-form {
            padding: 36px;
        }

        .register-side {
            background:
                linear-gradient(160deg, rgba(255, 107, 44, 0.18), rgba(255, 153, 87, 0.04)),
                rgba(255, 255, 255, 0.04);
            border-right: 1px solid var(--line);
        }

        .register-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            border-radius: 999px;
            background: rgba(255,255,255,0.08);
            font-size: .82rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .register-side h1 {
            margin: 22px 0 14px;
            font-size: clamp(2.2rem, 4vw, 4rem);
            line-height: 1;
            letter-spacing: -.04em;
        }

        .register-side p {
            color: #d9e5f1;
            line-height: 1.8;
            margin-bottom: 22px;
        }

        .register-side ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 14px;
        }

        .register-overview {
            position: relative;
            margin-top: 18px;
            padding: 22px;
            border-radius: 28px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.07), rgba(255, 255, 255, 0.03));
            border: 1px solid rgba(255,255,255,0.08);
            overflow: hidden;
        }

        .register-overview::after {
            content: "";
            position: absolute;
            left: auto;
            right: -50px;
            bottom: -55px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 107, 44, 0.24), transparent 70%);
            pointer-events: none;
        }

        .register-stats {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 18px;
        }

        .register-stat {
            padding: 16px 18px;
            border-radius: 20px;
            background: rgba(6, 16, 26, 0.32);
            border: 1px solid rgba(255,255,255,0.06);
        }

        .register-stat strong {
            display: block;
            font-size: 1.15rem;
            margin-bottom: 4px;
        }

        .register-stat span {
            color: var(--muted);
            font-size: .88rem;
            line-height: 1.55;
        }

        .register-side li {
            position: relative;
            z-index: 1;
            padding: 15px 16px;
            border-radius: 18px;
            background: rgba(6, 16, 26, 0.28);
            border: 1px solid rgba(255,255,255,0.06);
            color: #dce6f2;
        }

        .register-side li strong {
            display: block;
            margin-bottom: 4px;
        }

        .register-form {
            background: var(--panel);
        }

        .form-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .form-topbar a {
            color: #dce6f2;
            text-decoration: none;
            font-weight: 600;
        }

        .switch-tabs {
            display: inline-flex;
            gap: 10px;
            padding: 6px;
            border-radius: 999px;
            background: rgba(255,255,255,0.06);
        }

        .switch-tabs a {
            padding: 10px 18px;
            border-radius: 999px;
        }

        .switch-tabs .is-active {
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            color: #fff;
        }

        .register-form h2 {
            margin: 0 0 10px;
            font-size: clamp(2rem, 3vw, 2.6rem);
            letter-spacing: -.03em;
        }

        .register-form p {
            color: var(--muted);
            line-height: 1.75;
            margin-bottom: 24px;
        }

        .alert-box {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255, 107, 44, 0.12);
            border: 1px solid rgba(255, 107, 44, 0.24);
        }

        .alert-box ul {
            margin: 0;
            padding-left: 18px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-grid .full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
            font-size: .92rem;
        }

        .field-shell {
            position: relative;
        }

        .field-shell i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #8ea4bc;
        }

        .field-shell .password-toggle {
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

        .field-shell .password-toggle:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .field-shell input {
            width: 100%;
            min-height: 58px;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.05);
            color: #fff;
            padding: 0 52px 0 50px;
            outline: none;
            transition: .2s ease;
        }

        .field-shell input::placeholder {
            color: #8ea4bc;
        }

        .field-shell input:focus {
            border-color: rgba(255, 153, 87, 0.9);
            box-shadow: 0 0 0 4px rgba(255, 107, 44, 0.14);
            background: rgba(255,255,255,0.08);
        }

        .submit-btn {
            width: 100%;
            min-height: 58px;
            border: 0;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            color: #fff;
            font-weight: 800;
            letter-spacing: .02em;
            box-shadow: 0 20px 36px rgba(255, 107, 44, 0.24);
        }

        .helper-text {
            margin-top: 18px;
            color: var(--muted);
        }

        .helper-text a {
            color: #fff;
            text-decoration: none;
            font-weight: 700;
        }

        @media (max-width: 991.98px) {
            .register-card {
                grid-template-columns: 1fr;
            }

            .register-side,
            .register-form {
                padding: 24px 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .register-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <main class="register-shell">
        <section class="register-card">
            <div class="register-side">
                <span class="register-badge">
                    <i class="fa fa-tachometer"></i>
                    Bengkel Mobil
                </span>
                <h1>Buat akun untuk akses servis yang lebih rapi.</h1>
                <p>Pendaftaran pelanggan dirapikan agar proses masuk ke sistem terasa sederhana, aman, dan mudah dipahami sejak awal.</p>
                <div class="register-overview">
                    <div class="register-stats">
                        <div class="register-stat">
                            <strong>Akun</strong>
                            <span>Data pelanggan dikumpulkan lewat form yang lebih fokus.</span>
                        </div>
                        <div class="register-stat">
                            <strong>OTP</strong>
                            <span>Aktivasi email tetap dipakai untuk menjaga keamanan akun.</span>
                        </div>
                        <div class="register-stat">
                            <strong>Akses</strong>
                            <span>Setelah aktif, pelanggan bisa lanjut ke booking dan servis.</span>
                        </div>
                    </div>
                    <ul>
                        <li>
                            <strong>Form lebih tenang</strong>
                            Informasi samping dikurangi agar pengguna fokus ke data yang perlu diisi.
                        </li>
                        <li>
                            <strong>Password bisa dicek</strong>
                            Tombol lihat password membantu menghindari salah input saat daftar.
                        </li>
                        <li>
                            <strong>Tampilan lebih rapi</strong>
                            Nuansa visual tetap otomotif, tetapi lebih bersih dan tidak terasa seperti contoh dummy.
                        </li>
                    </ul>
                </div>
            </div>

            <div class="register-form">
                <div class="form-topbar">
                    <a href="{{ route('home') }}"><i class="fa fa-arrow-left"></i> Kembali ke beranda</a>
                    <div class="switch-tabs">
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}" class="is-active">Daftar</a>
                    </div>
                </div>

                <h2>Buat akun customer.</h2>
                <p>Isi data di bawah ini dengan email asli Anda. Setelah daftar, sistem akan mengirim kode OTP ke email tersebut untuk aktivasi akun baru.</p>

                @if ($errors->any())
                    <div class="alert-box">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('/register') }}">
                    @csrf
                    <div class="form-grid">
                        <div class="full">
                            <label for="name">Nama Lengkap</label>
                            <div class="field-shell">
                                <i class="fa fa-user-o"></i>
                                <input id="name" type="text" name="name" placeholder="Nama lengkap" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <div class="full">
                            <label for="email">Email</label>
                            <div class="field-shell">
                                <i class="fa fa-envelope-o"></i>
                                <input id="email" type="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="full">
                            <label for="phone">Nomor Telepon</label>
                            <div class="field-shell">
                                <i class="fa fa-phone"></i>
                                <input id="phone" type="text" name="phone" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
                            </div>
                        </div>

                        <div>
                            <label for="password">Password</label>
                            <div class="field-shell">
                                <i class="fa fa-lock"></i>
                                <input id="password" type="password" name="password" placeholder="Minimal 8 karakter" required>
                                <button type="button" class="password-toggle" data-toggle-password="password" aria-label="Lihat password">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <div class="field-shell">
                                <i class="fa fa-shield"></i>
                                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi password" required>
                                <button type="button" class="password-toggle" data-toggle-password="password_confirmation" aria-label="Lihat konfirmasi password">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="full">
                            <button type="submit" class="submit-btn">Buat Akun dan Kirim OTP</button>
                        </div>
                    </div>
                </form>

                <p class="helper-text">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
            </div>
        </section>
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
