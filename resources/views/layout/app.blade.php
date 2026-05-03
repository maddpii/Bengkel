<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Bengkel Mobil')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Pato Master CSS (from public/pato/*) -->
    <link rel="icon" type="image/png" href="{{ asset('pato/images/icons/favicon.png') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('pato/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pato/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pato/fonts/themify/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pato/vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pato/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pato/vendor/animsition/css/animsition.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pato/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pato/vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pato/vendor/slick/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pato/vendor/lightbox2/css/lightbox.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('pato/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pato/css/main.css') }}">

    @stack('styles')
    <style>
        .button2{
           font-family: Montserrat;
           font-weight: 400;
	       font-size: 15px;
	       line-height: 1.7;
	       color: #000000;
	       margin: 0px;
	    transition: all 0.4s;
	    -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        -moz-transition: all 0.4s;
        }
        
        .button2:hover {
           text-decoration: none;
	        color: #ec1d25;
        }

        body.has-fixed-header-offset {
            padding-top: 150px;
        }

        .form-label {
            display: inline-block;
            margin-bottom: 0.65rem;
            font-weight: 700;
            color: #2f2a26;
            letter-spacing: 0.01em;
        }

        .form-control,
        .form-select {
            min-height: 54px;
            border: 1px solid #eadfd8;
            border-radius: 16px;
            background: #fffdfc;
            padding: 0.85rem 1rem;
            color: #2d2a27;
            box-shadow: inset 0 1px 2px rgba(31, 24, 21, 0.03);
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        textarea.form-control {
            min-height: 140px;
            padding-top: 1rem;
            resize: vertical;
        }

        .form-control::placeholder,
        .form-select,
        .form-text,
        .text-muted {
            color: #8b7f76;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #e74c3c;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.12);
            outline: none;
        }

        .form-check {
            padding-left: 2rem;
        }

        .form-check-input {
            width: 1.15rem;
            height: 1.15rem;
            margin-top: 0.2rem;
            border: 1px solid #d8c5bc;
            box-shadow: none;
        }

        .form-check-input:checked {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.12);
        }

        .btn,
        button[type="submit"] {
            border-radius: 999px;
            font-weight: 700;
            letter-spacing: 0.01em;
        }

        .alert {
            border: 0;
            border-radius: 18px;
            padding: 1rem 1.1rem;
        }

        .nav-badge {
            align-items: center;
            background: #e74c3c;
            border-radius: 999px;
            color: #fff;
            display: inline-flex;
            font-size: 0.72rem;
            font-weight: 700;
            justify-content: center;
            line-height: 1;
            margin-left: 0.45rem;
            min-width: 1.35rem;
            padding: 0.3rem 0.45rem;
        }

        .app-user-menu {
            position: relative;
            margin-left: 14px;
        }

        .app-user-trigger {
            align-items: center;
            background: #ffffff;
            border: 1px solid rgba(31, 41, 55, 0.08);
            border-radius: 999px;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.08);
            color: #1f2937;
            display: inline-flex;
            gap: 0.85rem;
            max-width: 260px;
            min-height: 52px;
            padding: 0.35rem 0.45rem 0.35rem 0.95rem;
            transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .app-user-trigger:hover,
        .app-user-trigger:focus {
            color: #1f2937;
            text-decoration: none;
            transform: translateY(-1px);
            background: #ffffff;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
        }

        .app-user-meta {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-width: 0;
        }

        .app-user-role {
            color: #8b7f76;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .app-user-name {
            color: #1f2937;
            font-size: 0.95rem;
            font-weight: 700;
            line-height: 1.1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .app-user-avatar {
            align-items: center;
            background: linear-gradient(135deg,#ffb36b 0%,#f04d4d 100%);
            border-radius: 50%;
            color: #fff;
            display: inline-flex;
            font-size: 0.86rem;
            font-weight: 700;
            height: 40px;
            justify-content: center;
            object-fit: cover;
            overflow: hidden;
            width: 40px;
        }

        .app-user-dropdown {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 22px 44px rgba(16, 24, 40, 0.18);
            display: none;
            min-width: 240px;
            overflow: hidden;
            position: absolute;
            right: 0;
            top: calc(100% + 12px);
            z-index: 120;
        }

        .app-user-menu.is-open .app-user-dropdown {
            display: block;
        }

        .app-user-summary {
            background: #fff8f5;
            padding: 1rem 1.05rem;
        }

        .app-user-summary strong {
            color: #312620;
            display: block;
            font-size: 0.95rem;
        }

        .app-user-summary span {
            color: #8b7f76;
            display: block;
            font-size: 0.82rem;
            margin-top: 0.2rem;
        }

        .app-user-link,
        .app-user-logout {
            align-items: center;
            background: #fff;
            border: 0;
            color: #4b413a;
            display: flex;
            gap: 0.75rem;
            padding: 0.9rem 1.05rem;
            text-align: left;
            width: 100%;
        }

        .app-user-link:hover,
        .app-user-logout:hover {
            background: #fff3ed;
            color: #e74c3c;
            text-decoration: none;
        }

        .app-user-logout {
            border-top: 1px solid #f0e6e1;
            font-weight: 700;
        }

        @media (max-width: 991.98px) {
            body.has-fixed-header-offset {
                padding-top: 120px;
            }

            .form-control,
            .form-select {
                min-height: 50px;
            }

            .app-user-menu {
                margin-left: 0;
                width: 100%;
            }

            .app-user-trigger {
                max-width: none;
                width: 100%;
            }

            .app-user-dropdown {
                left: 0;
                right: 0;
                min-width: 100%;
            }
        }
    </style>
</head>

<body class="animsition {{ request()->routeIs('home') ? '' : 'has-fixed-header-offset' }}">
    @php
        $currentUser = auth()->user();
        $currentRole = $currentUser->role ?? null;
        $pendingPaymentCount = 0;

        if ($currentRole === 'customer') {
            $pendingPaymentCount = \App\Models\Transaction::query()
                ->whereHas('booking', function ($query) use ($currentUser) {
                    $query->where('user_id', $currentUser->id);
                })
                ->whereHas('payment', function ($query) {
                    $query->where('payment_status', 'unpaid');
                })
                ->count();
        }
    @endphp
    <!-- Header -->
    <header>
        <!-- Header desktop -->
        <div class="wrap-menu-header gradient1 trans-0-4">
            <div class="container h-full">
                <div class="wrap_header trans-0-3">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img
                                src="{{ asset('pato/images/icons/image.png') }}" style="width: 150px; height: auto;"
                                alt="Logo Bengkel Mobil"
                                data-logofixed="{{ asset('pato/images/icons/image.png') }}"
                            >
                        </a>
                    </div>

                    <!-- Menu -->
                    <div class="wrap_menu p-l-45 p-l-0-xl">
                        <nav class="menu">
                            <ul class="main_menu">
                                @auth
                                    @if($currentRole === 'customer')
                                        <li>
                                            <a href="{{ route('home') }}">Beranda</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/bookings') }}">Booking</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/transactions') }}">Riwayat Servis</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('payments.index') }}">
                                                Pembayaran
                                                @if ($pendingPaymentCount > 0)
                                                    <span class="nav-badge">{{ $pendingPaymentCount }}</span>
                                                @endif
                                            </a>
                                        </li>
                                    @elseif($currentRole === 'admin')
                                        <li>
                                            <a href="{{ route('admin.site-content.edit') }}">Panel Admin</a>
                                        </li>
                                    @elseif($currentRole === 'mekanik')
                                        <li>
                                            <a href="{{ route('mechanic.bookings.index') }}">Pekerjaan Servis</a>
                                        </li>
                                    @elseif($currentRole === 'owner')
                                        <li>
                                            <a href="{{ route('owner.reports.index') }}">Laporan</a>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <a href="{{ route('home') }}">Beranda</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/bookings') }}">Booking</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('login') }}">Riwayat Servis</a>
                                    </li>
                                @endauth

                                @auth
                                @else
                                    <li>
                                        <a href="{{ route('login') }}">Masuk</a>
                                    </li>
                                @endauth
                            </ul>
                        </nav>
                    </div>

                    <!-- Social -->
                    <div class="social flex-w flex-l-m p-r-20">
                        @auth
                            <div class="app-user-menu" id="appUserMenu">
                                <a href="#" class="app-user-trigger" id="appUserToggle">
                                    <span class="app-user-meta">
                                        <span class="app-user-role">{{ $currentRole ?? 'guest' }}</span>
                                        <span class="app-user-name">{{ $currentUser->name }}</span>
                                    </span>
                                    @if ($currentUser->profile_photo_url)
                                        <img src="{{ $currentUser->profile_photo_url }}" alt="{{ $currentUser->name }}" class="app-user-avatar">
                                    @else
                                        <span class="app-user-avatar">{{ $currentUser->initials }}</span>
                                    @endif
                                </a>
                                <div class="app-user-dropdown">
                                    <div class="app-user-summary">
                                        <strong>{{ $currentUser->name }}</strong>
                                        <span>{{ $currentUser->email }}</span>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="app-user-link" ><i class="fa fa-user"></i> Profil Saya</a>
                                    <form method="post" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="app-user-logout"><i class="fa fa-sign-out"></i> Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-facebook m-l-21" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-youtube m-l-21" aria-hidden="true"></i></a>
                        @endauth
                        <button class="btn-show-sidebar m-l-33 trans-0-4" aria-label="Open sidebar"></button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar trans-0-4">
        <!-- Button Hide sidebar -->
        <button class="btn-hide-sidebar ti-close color0-hov trans-0-4" aria-label="Close sidebar"></button>

        <ul class="menu-sidebar p-t-95 p-b-70">
            @auth
                @if($currentRole === 'customer')
                    <li class="t-center m-b-13">
                        <a href="{{ route('home') }}" class="txt19">Beranda</a>
                    </li>
                    <li class="t-center m-b-13">
                        <a href="{{ url('/bookings') }}" class="txt19">Booking</a>
                    </li>
                    <li class="t-center m-b-13">
                        <a href="{{ route('payments.index') }}" class="txt19">
                            Pembayaran
                            @if ($pendingPaymentCount > 0)
                                <span class="nav-badge">{{ $pendingPaymentCount }}</span>
                            @endif
                        </a>
                    </li>
                @elseif($currentRole === 'admin')
                    <li class="t-center m-b-13">
                        <a href="{{ route('admin.site-content.edit') }}" class="txt19">Panel Admin</a>
                    </li>
                @elseif($currentRole === 'mekanik')
                    <li class="t-center m-b-13">
                        <a href="{{ route('mechanic.bookings.index') }}" class="txt19">Pekerjaan Servis</a>
                    </li>
                @elseif($currentRole === 'owner')
                    <li class="t-center m-b-13">
                        <a href="{{ route('owner.reports.index') }}" class="txt19">Laporan</a>
                    </li>
                @endif
            @else
                <li class="t-center m-b-13">
                    <a href="{{ route('home') }}" class="txt19">Beranda</a>
                </li>
                <li class="t-center m-b-13">
                    <a href="{{ url('/bookings') }}" class="txt19">Booking</a>
                </li>
            @endauth
            <li class="t-center m-b-13">
                <a href="{{ route('home') }}#gallery" class="txt19">Galeri</a>
            </li>
            @auth
                <li class="t-center m-b-13">
                    <a href="{{ route('profile.edit') }}" class="txt19">Profil Saya</a>
                </li>
                @if($currentRole === 'customer')
                    <li class="t-center m-b-13">
                        <a href="{{ url('/transactions') }}" class="txt19">Riwayat Servis</a>
                    </li>
                @endif
            @else
                <li class="t-center m-b-13">
                    <a href="{{ route('login') }}" class="txt19">Riwayat Servis</a>
                </li>
            @endauth
            <li class="t-center m-b-33">
                <a href="{{ route('home') }}#about" class="txt19">Tentang</a>
            </li>

            <li class="t-center">
                @if($currentRole === 'admin')
                    <a href="{{ route('admin.site-content.edit') }}" class="btn3 flex-c-m size13 txt11 trans-0-4 m-l-r-auto">
                        Panel Admin
                    </a>
                @elseif($currentRole === 'mekanik')
                    <a href="{{ route('mechanic.bookings.index') }}" class="btn3 flex-c-m size13 txt11 trans-0-4 m-l-r-auto">
                        Booking Servis
                    </a>
                @elseif($currentRole === 'owner')
                    <a href="{{ route('owner.reports.index') }}" class="btn3 flex-c-m size13 txt11 trans-0-4 m-l-r-auto">
                        Lihat Laporan
                    </a>
                @elseif($currentRole === 'customer')
                    <a href="{{ route('payments.index') }}" class="btn3 flex-c-m size13 txt11 trans-0-4 m-l-r-auto">
                        Pembayaran
                    </a>
                @else
                    <a href="{{ url('/bookings') }}" class="btn3 flex-c-m size13 txt11 trans-0-4 m-l-r-auto">
                        Booking
                    </a>
                @endif
            </li>
        </ul>

         <div class="gallery-sidebar t-center p-l-60 p-r-60 p-b-40">
            <h4 class="txt20 m-b-33">Gallery</h4>
            @php $site = \App\Models\SiteContent::current(); $gallery = $site->gallery_images ?? []; @endphp
            @if (!empty($gallery) && count($gallery) > 0)
                <div class="wrap-gallery-sidebar flex-w">
                    @foreach ($gallery as $img)
                        <a class="item-gallery-footer wrap-pic-w" href="{{ asset('storage/'.$img) }}" data-lightbox="gallery-footer">
                            <img src="{{ asset('storage/'.$img) }}" alt="GALLERY">
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </aside>

    @yield('content')

    <!-- Footer (Pato Master) -->
    <footer class="bg1">
        <div class="container p-t-40 p-b-70">
            <div class="row">
                <div class="col-sm-6 col-md-4 p-t-50">
                    <h4 class="txt13 m-b-33">Contact Us</h4>
                    <ul class="m-b-70">
                        <li class="txt14 m-b-14">
                            <i class="fa fa-map-marker fs-16 dis-inline-block size19" aria-hidden="true"></i>
                            Bengkel Mobil Jl.raflesia No.77, Bogor
                        </li>
                        <li class="txt14 m-b-14">
                            <i class="fa fa-phone fs-16 dis-inline-block size19" aria-hidden="true"></i>
                            (021) 1234 5678
                        </li>
                        <li class="txt14 m-b-14">
                            <i class="fa fa-envelope fs-13 dis-inline-block size19" aria-hidden="true"></i>
                            bengkelmobilbogor@gmail.com
                        </li>
                    </ul>
                    <h4 class="txt13 m-b-32">Opening Times</h4>
                    <ul>
                        <li class="txt14">08:00 - 17:00</li>
                        <li class="txt14">Senin - Sabtu</li>
                    </ul>
                </div>

                <div class="col-sm-6 col-md-4 p-t-50">
                    <h4 class="txt13 m-b-33">Tentang Bengkel</h4>
                    <p class="txt14 m-b-18">
                        Kami melayani perawatan dan perbaikan kendaraan dengan mekanik berpengalaman dan alur booking yang terjadwal.
                    </p>
                    <p class="txt14 m-t-10">
                        Toko kami sudah terpecaya dan teramai di Bogor.
                    </p>
                </div>

                <div class="col-sm-6 col-md-4 p-t-50">
                    <h4 class="txt13 m-b-38">Galeri</h4>
                    <div class="wrap-gallery-footer flex-w">
                        @php $site = \App\Models\SiteContent::current(); $gallery = $site->gallery_images ?? []; @endphp
                        @foreach($gallery as $img)
                            <a class="item-gallery-footer wrap-pic-w" href="{{ asset('storage/'.$img) }}" data-lightbox="gallery-footer">
                                <img src="{{ asset('storage/'.$img) }}" alt="GALLERY">
                            </a>
                        @endforeach
                        @if (empty($gallery))
                            <a class="item-gallery-footer wrap-pic-w" href="{{ asset('pato/images/photo-gallery-01.jpg') }}" data-lightbox="gallery-footer">
                                <img src="{{ asset('pato/images/photo-gallery-thumb-01.jpg') }}" alt="GALLERY">
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="end-footer bg2">
            <div class="container">
                <div class="flex-sb-m flex-w p-t-22 p-b-22">
                    <div class="p-t-5 p-b-5">
                        <a href="#" class="fs-15 c-white"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        <a href="#" class="fs-15 c-white"><i class="fa fa-facebook m-l-18" aria-hidden="true"></i></a>
                        <a href="#" class="fs-15 c-white"><i class="fa fa-youtube m-l-18" aria-hidden="true"></i></a>
                    </div>
                    <div class="txt17 p-r-20 p-t-5 p-b-5">
                        Copyright &copy; {{ date('Y') }} Bengkel Mobil. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to top -->
    <div class="btn-back-to-top bg0-hov" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="fa fa-angle-double-up" aria-hidden="true"></i>
        </span>
    </div>
    <div id="dropDownSelect1"></div>

    <!-- Pato Master JS -->
    <script type="text/javascript" src="{{ asset('pato/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pato/vendor/animsition/js/animsition.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pato/vendor/bootstrap/js/popper.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pato/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pato/vendor/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pato/vendor/daterangepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pato/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pato/vendor/slick/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pato/js/slick-custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pato/vendor/parallax100/parallax100.js') }}"></script>
    <script type="text/javascript">
        $('.parallax100').parallax100();
    </script>
    <script type="text/javascript" src="{{ asset('pato/vendor/countdowntime/countdowntime.js') }}"></script>
    <script type="text/javascript" src="{{ asset('pato/vendor/lightbox2/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('pato/js/main.js') }}"></script>
    <script>
        (function () {
            var menu = document.getElementById('appUserMenu');
            var toggle = document.getElementById('appUserToggle');

            if (!menu || !toggle) {
                return;
            }

            toggle.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                menu.classList.toggle('is-open');
            });

            document.addEventListener('click', function (event) {
                if (!menu.contains(event.target)) {
                    menu.classList.remove('is-open');
                }
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>
