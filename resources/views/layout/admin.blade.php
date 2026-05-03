<!doctype html>
<html class="no-js" lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Dashboard operasional Bengkel Mobil">
    <title>@yield('title', 'Admin') - Bengkel Mobil</title>
    <link rel="shortcut icon" href="{{ asset('sufee-master/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('sufee-master/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sufee-master/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sufee-master/vendors/themify-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('sufee-master/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sufee-master/vendors/selectFX/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('sufee-master/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('sufee-master/assets/css/custom-admin.css') }}">
    @stack('styles')
</head>
<body>
@php
    $adminUser = auth()->user();
    $roleLabels = ['admin' => 'Panel Admin', 'mekanik' => 'Panel Mekanik', 'kasir' => 'Panel Kasir', 'owner' => 'Panel Owner'];
    $panelHomeRoute = match ($adminUser->role ?? 'admin') {
        'mekanik' => 'mechanic.bookings.index',
        'kasir' => 'cashier.transactions.index',
        'owner' => 'owner.reports.index',
        default => 'admin.reports.index',
    };
    $profileSettingsRoute = route('profile.edit');
    $iconMap = [
        'dashboard' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 13h8V3H3z"/><path d="M13 21h8v-6h-8z"/><path d="M13 10h8V3h-8z"/><path d="M3 21h8v-4H3z"/></svg>',
        'booking' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4"/><path d="M16 2v4"/><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M3 10h18"/><path d="m9 16 2 2 4-4"/></svg>',
        'vehicle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 17h14l-1.5-5h-11z"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="16.5" cy="17.5" r="1.5"/><path d="M7 12 9 7h6l2 5"/></svg>',
        'user' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c1.8-3.2 5-5 8-5s6.2 1.8 8 5"/></svg>',
        'content' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 20h4l10-10-4-4L4 16z"/><path d="m13 7 4 4"/><path d="M4 20h16"/></svg>',
        'package' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 3 8 4-8 4-8-4 8-4Z"/><path d="m4 7 8 4 8-4"/><path d="M4 7v10l8 4 8-4V7"/><path d="M12 11v10"/></svg>',
        'wallet' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v1H5a2 2 0 1 0 0 4h13v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/><path d="M18 9h3v4h-3a2 2 0 1 1 0-4Z"/></svg>',
        'star' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 3 2.9 5.88 6.49.94-4.7 4.58 1.11 6.47L12 17.77 6.2 20.87l1.11-6.47-4.7-4.58 6.49-.94L12 3Z"/></svg>',
        'home' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 11 12 4l9 7"/><path d="M5 10v10h14V10"/></svg>',
        'wrench' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-3 3-2.4-2.4z"/></svg>',
        'chart' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 20V10"/><path d="M10 20V4"/><path d="M16 20v-7"/><path d="M22 20v-3"/></svg>',
    ];
    $menuItems = match ($adminUser->role ?? 'admin') {
        'mekanik' => [
            ['label' => 'Booking Servis', 'route' => 'mechanic.bookings.index', 'icon' => $iconMap['wrench'], 'active' => request()->routeIs('mechanic.bookings.*')],
            ['label' => 'Lihat Beranda', 'route' => 'home', 'icon' => $iconMap['home'], 'active' => request()->routeIs('home')],
        ],
        'owner' => [
            ['label' => 'Dashboard', 'route' => 'owner.reports.index', 'icon' => $iconMap['chart'], 'active' => request()->routeIs('owner.reports.*')],
            ['label' => 'Lihat Beranda', 'route' => 'home', 'icon' => $iconMap['home'], 'active' => request()->routeIs('home')],
        ],
        'kasir' => [
            ['label' => 'Transaksi Kasir', 'route' => 'cashier.transactions.index', 'icon' => $iconMap['package'], 'active' => request()->routeIs('cashier.transactions.*')],
            ['label' => 'Lihat Beranda', 'route' => 'home', 'icon' => $iconMap['home'], 'active' => request()->routeIs('home')],
        ],
        default => [
            ['label' => 'Dashboard', 'route' => 'admin.reports.index', 'icon' => $iconMap['dashboard'], 'active' => request()->routeIs('admin.reports.index')],
            ['label' => 'Laporan Keuangan', 'route' => 'admin.reports.finance', 'icon' => $iconMap['wallet'], 'active' => request()->routeIs('admin.reports.finance')],
            ['label' => 'Booking', 'route' => 'admin.bookings.index', 'icon' => $iconMap['booking'], 'active' => request()->routeIs('admin.bookings.*')],
            ['label' => 'Kendaraan', 'route' => 'admin.vehicles.index', 'icon' => $iconMap['vehicle'], 'active' => request()->routeIs('admin.vehicles.*')],
            ['label' => 'User', 'route' => 'admin.users.index', 'icon' => $iconMap['user'], 'active' => request()->routeIs('admin.users.*')],
            ['label' => 'Konten Situs', 'route' => 'admin.site-content.edit', 'icon' => $iconMap['content'], 'active' => request()->routeIs('admin.site-content.*')],
            ['label' => 'Sparepart', 'route' => 'admin.spareparts.index', 'icon' => $iconMap['package'], 'active' => request()->routeIs('admin.spareparts.*')],
            ['label' => 'Ulasan Client', 'route' => 'admin.reviews.index', 'icon' => $iconMap['star'], 'active' => request()->routeIs('admin.reviews.*')],
            ['label' => 'Lihat Beranda', 'route' => 'home', 'icon' => $iconMap['home'], 'active' => request()->routeIs('home')],
        ],
    };
@endphp
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div class="navbar-header align-items-center d-flex px-3 py-3">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a href="{{ route($panelHomeRoute) }}" class="navbar-brand d-flex align-items-center" style="gap:.75rem;">
                <span class="brand-mark">
                    {!! $iconMap['dashboard'] !!}
                </span>
                <span class="brand-text">
                    <span>Bengkel Mobil</span>
                    <span class="brand-caption">Admin Panel</span>
                </span>
            </a>
        </div>
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav w-100">
                <li class="menu-title">Menu Utama</li>
                @foreach ($menuItems as $item)
                    <li class="{{ $item['active'] ? 'active' : '' }}">
                        <a href="{{ route($item['route']) }}"><span class="sidebar-icon">{!! $item['icon'] !!}</span><span>{{ $item['label'] }}</span></a>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</aside>
<div id="right-panel" class="right-panel">
    <header id="header" class="header">
        <div class="header-menu">
            <div class="col-sm-7">
                <a id="adminSidebarToggle" class="menu-trigger-btn" href="#" aria-label="Toggle Sidebar">
                    <span class="bar-stack">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </a>
                <div class="header-left">
                    <div>
                        <span class="page-kicker">{{ $roleLabels[$adminUser->role ?? 'admin'] ?? 'Dashboard Staff' }}</span>
                        <h1 class="page-heading">@yield('page_title', 'Dashboard Bengkel')</h1>
                        <div class="header-meta">Pantau operasional bengkel, servis, dan penjualan dari satu panel.</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="user-area" id="adminUserMenu">
                    <a href="#" class="user-pill" id="adminUserToggle" aria-haspopup="true" aria-expanded="false">
                        <span class="user-meta">
                            <span class="user-role">{{ strtolower($roleLabels[$adminUser->role ?? 'admin'] ?? 'staff') }}</span>
                            <span class="user-name">{{ $adminUser->name ?? 'Admin' }}</span>
                        </span>
                        @if ($adminUser?->profile_photo_url)
                            <img src="{{ $adminUser->profile_photo_url }}" alt="{{ $adminUser->name }}" class="avatar-badge">
                        @else
                            <span class="avatar-badge">{{ $adminUser->initials ?? 'A' }}</span>
                        @endif
                        <span class="user-caret"><i class="fa fa-angle-down"></i></span>
                    </a>
                    <div class="user-menu profile-dropdown">
                        <div class="profile-summary">
                            <p class="profile-title">{{ $adminUser->name ?? 'Admin' }}</p>
                            <p class="profile-email">{{ $adminUser->email ?? 'hello@example.com' }}</p>
                        </div>
                        <div class="profile-actions">
                            <a class="nav-link profile-action" href="{{ $profileSettingsRoute }}">
                                <span class="profile-action-icon"><i class="fa fa-user"></i></span>
                                <span>Profil Saya</span>
                            </a>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="mb-0 profile-logout-form">
                            @csrf
                            <button type="submit" class="logout-button">
                                <span class="profile-action-icon"><i class="fa fa-power-off"></i></span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="breadcrumbs">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>@yield('page_title', 'Dashboard Bengkel')</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="page-header float-right w-100">
                    <div class="page-actions">
                        @yield('breadcrumb_right')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content mt-3">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa lagi input Anda.</strong>
                <ul class="mb-0 mt-2 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>
    <div class="footer-note">{{ now()->format('Y') }} Bengkel Mobil Admin Panel | Template Sufee</div>
</div>
<script src="{{ asset('sufee-master/vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('sufee-master/vendors/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('sufee-master/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('sufee-master/assets/js/main.js') }}"></script>
<script>
    (function () {
        var body = document.body;
        var sidebar = document.getElementById('left-panel');
        var userMenu = document.getElementById('adminUserMenu');
        var toggle = document.getElementById('adminUserToggle');
        var sidebarToggle = document.getElementById('adminSidebarToggle');

        function isMobileViewport() {
            return window.innerWidth <= 991.98;
        }

        function syncSidebarMode() {
            if (isMobileViewport()) {
                body.classList.remove('sidebar-mini');
            } else {
                body.classList.remove('sidebar-open');
            }
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (isMobileViewport()) {
                    body.classList.toggle('sidebar-open');
                    body.classList.remove('sidebar-mini');
                    return;
                }

                body.classList.toggle('sidebar-mini');
                body.classList.remove('sidebar-open');
            });
        }

        window.addEventListener('resize', syncSidebarMode);
        syncSidebarMode();

        document.addEventListener('click', function (event) {
            if (isMobileViewport() && body.classList.contains('sidebar-open') && sidebar && sidebarToggle && !sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                body.classList.remove('sidebar-open');
            }

            if (userMenu && !userMenu.contains(event.target)) {
                userMenu.classList.remove('is-open');
            }
        });

        if (userMenu && toggle) {
            toggle.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                userMenu.classList.toggle('is-open');
            });
        }
    })();
</script>
@stack('scripts')
</body>
</html>
