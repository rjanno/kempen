<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'sippb') }}</title>
    <!-- Favicon & PWA Icons -->
    <link rel="icon" type="image/png" href="{{ asset('images/icons/icon-96x96.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icons/apple-touch-icon.png') }}">
    <!-- PWA & Mobile Web Meta Tags -->
    <meta name="theme-color" content="#7c3aed">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="sippb">
    <meta name="application-name" content="sippb">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <script>
        // Check if skeleton should show immediately on page load
        if (sessionStorage.getItem('nav_skeleton') === '1') {
            document.documentElement.classList.add('nav-loading');
        }
    </script>
    <style>
        :root {
            --bs-primary: #7c3aed;
            --bs-primary-rgb: 124, 58, 237;
            --bs-btn-bg: #7c3aed;
            --bs-btn-border-color: #7c3aed;
            --bs-btn-hover-bg: #6d28d9;
            --bs-btn-hover-border-color: #6d28d9;
            --sidebar-width: 250px;
        }
        body { 
            background-color: #f4f6f9; 
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        .card { 
            border: none; 
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05); 
            border-radius: 12px;
        }

        /* PWA Install Banner Style */
        .pwa-install-banner {
            position: fixed;
            bottom: 20px;
            left: 16px;
            right: 16px;
            max-width: 480px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            padding: 12px 16px;
            border: 1px solid rgba(124, 58, 237, 0.25);
            z-index: 10000;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            animation: pwaSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes pwaSlideUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Mobile specific enhancements */
        @media (max-width: 991.98px) {
            .table-responsive {
                -webkit-overflow-scrolling: touch;
                border-radius: 12px;
            }
            .table-responsive table {
                min-width: 650px;
            }
            .sidebar-logo span {
                font-size: 1.25rem;
            }
        }

        /* Sidebar Styling */
        #sidebar {
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: #ffffff;
            box-shadow: 4px 0 15px rgba(0,0,0,0.03);
            z-index: 1000;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .sidebar-logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--bs-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar-user {
            padding: 1.5rem 1rem;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
            display: none; /* Hidden on desktop, moved to topbar */
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #eee;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--bs-primary);
            font-weight: bold;
        }

        .sidebar-nav {
            padding: 1rem 0;
            flex-grow: 1;
        }
        
        .sidebar-nav .nav-link {
            color: #555;
            padding: 0.8rem 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .sidebar-nav .nav-link:hover {
            background-color: rgba(124, 58, 237, 0.05);
            color: var(--bs-primary);
        }

        .sidebar-nav .nav-link.active {
            background-color: rgba(124, 58, 237, 0.08);
            color: var(--bs-primary);
            border-left-color: var(--bs-primary);
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid #f0f0f0;
        }

        /* Topbar Layout */
        #topbar {
            height: 70px;
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50px;
            transition: all 0.2s;
        }

        .topbar-user:hover {
            background-color: rgba(0,0,0,0.02);
        }

        .topbar-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--bs-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Main Content Layout */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background-color: #f4f6f9;
            transition: all 0.3s;
            width: calc(100% - var(--sidebar-width));
            display: flex;
            flex-direction: column;
        }
        
        .content-wrapper {
            padding: 1.75rem 2rem;
            width: 100%;
            flex-grow: 1;
        }

        /* Page Transition & Skeleton Loader */
        .skeleton-shimmer {
            background: linear-gradient(90deg, #e9ecef 25%, #f4f6f9 50%, #e9ecef 75%);
            background-size: 200% 100%;
            animation: skeleton-shimmer 1.5s infinite linear;
            border-radius: 8px;
        }
        @keyframes skeleton-shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        #page-skeleton {
            position: fixed;
            top: 70px;
            left: var(--sidebar-width);
            right: 0;
            bottom: 0;
            background: #f4f6f9;
            z-index: 998;
            overflow-y: auto;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease, visibility 0.25s ease;
            pointer-events: none;
        }

        #page-skeleton.active,
        html.nav-loading #page-skeleton {
            opacity: 1 !important;
            visibility: visible !important;
            display: block !important;
            pointer-events: auto;
        }

        /* Smooth page entrance animation */
        .page-fade-in {
            animation: pageFadeIn 0.3s ease-out forwards;
        }
        @keyframes pageFadeIn {
            from {
                opacity: 0.6;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Navbar Helper */
        #mobile-nav {
            display: none;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 1rem;
            align-items: center;
            justify-content: space-between;
        }

        /* Mobile Adjustments */
        @media (max-width: 991.98px) {
            #sidebar {
                transform: translateX(-100%);
            }
            #sidebar.show {
                transform: translateX(0);
            }
            #main-content {
                margin-left: 0;
                width: 100%;
            }
            .content-wrapper {
                padding: 1.25rem 1rem;
            }
            #page-skeleton {
                left: 0;
                top: 60px;
            }
            #mobile-nav {
                display: flex;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }
            .sidebar-overlay.show {
                display: block;
            }

            /* Mobile Form Consistency for Android */
            .modal-body .form-control, 
            .modal-body .form-select {
                height: 50px !important;
                min-height: 50px !important;
                padding: 12px 16px !important;
                font-size: 16px !important;
                line-height: 1.5 !important;
                border-radius: 8px !important;
                box-sizing: border-box !important;
                width: 100% !important;
            }
            .modal-body input[type="file"].form-control {
                padding: 10px 16px !important;
                line-height: 1.5 !important;
            }
            /* Menyamakan jarak antar flex/row di mobile */
            .modal-body .row > .col-md-6 {
                width: 100% !important;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body>
    @auth
    
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <nav id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-logo">
                
                <span>sippb</span>
            </a>
        </div>
        
        <div class="sidebar-user">
            <div class="user-avatar text-uppercase">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <h6 class="mb-0 fw-bold">{{ auth()->user()->name }}</h6>
            <small class="text-muted text-uppercase fw-semibold" style="letter-spacing: 1px; font-size: 0.7rem;">
                {{ auth()->user()->role }}
            </small>
        </div>

        <div class="sidebar-nav">
            @if(auth()->user()->role === 'admin')
            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-chart-line fa-fw"></i>
                Dashboard Admin
            </a>
            <a class="nav-link {{ request()->is('admin/sk*') ? 'active' : '' }}" href="{{ route('admin.sk') }}">
                <i class="fas fa-file-pdf fa-fw"></i>
                Administrasi SK & SOP
            </a>
            <a class="nav-link {{ request()->is('admin/pojk*') ? 'active' : '' }}" href="{{ route('admin.pojk') }}">
                <i class="fas fa-book fa-fw"></i>
                Manajemen POJK
            </a>
            <a class="nav-link {{ request()->is('admin/pks*') ? 'active' : '' }}" href="{{ route('admin.pks') }}">
                <i class="fas fa-handshake fa-fw"></i>
                Manajemen PKS
            </a>
            <a class="nav-link {{ request()->is('admin/video*') ? 'active' : '' }}" href="{{ route('admin.video') }}">
                <i class="fas fa-video fa-fw"></i>
                Manajemen Video / Sosialisasi
            </a>
            <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                <i class="fas fa-users-cog fa-fw"></i>
                Manajemen User
            </a>
            @else
            <a class="nav-link {{ request()->is('user/sk*') ? 'active' : '' }}" href="{{ route('user.sk') }}">
                <i class="fas fa-file-pdf fa-fw"></i>
                Direktori SK & SOP
            </a>
            <a class="nav-link {{ request()->is('user/pojk*') ? 'active' : '' }}" href="{{ route('user.pojk') }}">
                <i class="fas fa-book fa-fw"></i>
                Arsip POJK
            </a>
            <a class="nav-link {{ request()->is('user/pks*') ? 'active' : '' }}" href="{{ route('user.pks') }}">
                <i class="fas fa-handshake fa-fw"></i>
                Arsip PKS
            </a>
            <a class="nav-link {{ request()->is('user/video*') ? 'active' : '' }}" href="{{ route('user.video') }}">
                <i class="fas fa-video fa-fw"></i>
                Video Sosialisasi
            </a>
            @endif

            <div class="px-3 pt-3 mt-2 border-top">
                <button type="button" class="btn btn-outline-primary w-100 rounded-pill btn-sm py-2 d-flex align-items-center justify-content-center gap-2 btn-install-app">
                    <i class="fas fa-mobile-alt"></i> Pasang Aplikasi
                </button>
            </div>
        </div>

        <div class="sidebar-footer">
            <div class="text-center text-muted small">
                &copy; {{ date('Y') }} sippb<br><small>Created by RAH</small>
            </div>
        </div>
    </nav>

    <!-- Mobile Topbar -->
    <div id="mobile-nav">
        <a href="#" class="sidebar-logo fs-4 text-decoration-none d-flex align-items-center gap-2">
            
            <span>sippb</span>
        </a>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-2 py-1 d-flex align-items-center gap-1 shadow-sm btn-install-app" title="Pasang Aplikasi">
                <i class="fas fa-download"></i> <span class="small fw-semibold">Pasang</span>
            </button>
            <div class="dropdown">
                <a href="#" class="text-decoration-none text-dark d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="topbar-avatar text-uppercase shadow-sm" style="width: 38px; height: 38px; font-size: 14px;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 position-absolute" style="min-width: 200px; border-radius: 12px; margin-top: 10px;">
                    <li><h6 class="dropdown-header px-3 pb-2">{{ auth()->user()->name }}</h6></li>
                    @if(auth()->user()->role === 'user')
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2 fw-medium" href="{{ route('user.profile') }}">
                            <i class="fas fa-user-circle"></i> Profil Pengguna
                        </a>
                    </li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2 fw-medium">
                                <i class="fas fa-sign-out-alt"></i> Keluar Aplikasi
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            <button class="btn btn-light shadow-sm" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
    @endauth

    <!-- Main Content -->
    <div id="{{ auth()->check() ? 'main-content' : '' }}" class="{{ auth()->check() ? '' : 'd-flex flex-column justify-content-center min-vh-100' }}">
        @auth
        <!-- Desktop Topbar -->
        <div id="topbar" class="d-none d-lg-flex">
            <div class="dropdown">
                <div class="topbar-user" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="text-end d-none d-md-block">
                        <div class="fw-bold text-dark lh-1 mb-1">{{ auth()->user()->name }}</div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">{{ auth()->user()->role }}</small>
                    </div>
                    <div class="topbar-avatar text-uppercase">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <i class="fas fa-chevron-down text-muted ms-1 fs-xs"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="min-width: 200px; border-radius: 12px;">
                    <li><h6 class="dropdown-header">Akun Saya</h6></li>
                    @if(auth()->user()->role === 'user')
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 py-2 fw-medium" href="{{ route('user.profile') }}">
                            <i class="fas fa-user-circle"></i> Profil Pengguna
                        </a>
                    </li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2 fw-medium">
                                <i class="fas fa-sign-out-alt"></i> Keluar Aplikasi
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        @endauth

        @auth
        <!-- Page Skeleton Overlay -->
        <div id="page-skeleton">
            <div class="content-wrapper">
                <!-- Header Skeleton -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <div class="skeleton-shimmer mb-2" style="width: 240px; height: 32px;"></div>
                        <div class="skeleton-shimmer" style="width: 360px; height: 16px;"></div>
                    </div>
                    <div class="skeleton-shimmer" style="width: 140px; height: 38px; border-radius: 8px;"></div>
                </div>

                <!-- Stat Cards Skeleton -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; height: 130px;">
                            <div class="skeleton-shimmer mb-3" style="width: 50%; height: 16px;"></div>
                            <div class="skeleton-shimmer" style="width: 35%; height: 40px;"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; height: 130px;">
                            <div class="skeleton-shimmer mb-3" style="width: 55%; height: 16px;"></div>
                            <div class="skeleton-shimmer" style="width: 30%; height: 40px;"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; height: 130px;">
                            <div class="skeleton-shimmer mb-3" style="width: 45%; height: 16px;"></div>
                            <div class="skeleton-shimmer" style="width: 40%; height: 40px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area Skeleton -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; height: 350px;">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="skeleton-shimmer" style="width: 200px; height: 22px;"></div>
                                <div class="skeleton-shimmer" style="width: 80px; height: 20px;"></div>
                            </div>
                            <div class="d-flex align-items-end justify-content-around h-75 pt-3">
                                <div class="skeleton-shimmer" style="width: 12%; height: 85%;"></div>
                                <div class="skeleton-shimmer" style="width: 12%; height: 60%;"></div>
                                <div class="skeleton-shimmer" style="width: 12%; height: 50%;"></div>
                                <div class="skeleton-shimmer" style="width: 12%; height: 40%;"></div>
                                <div class="skeleton-shimmer" style="width: 12%; height: 35%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; height: 350px;">
                            <div class="skeleton-shimmer mb-3" style="width: 70%; height: 24px;"></div>
                            <div class="skeleton-shimmer mb-2" style="width: 95%; height: 16px;"></div>
                            <div class="skeleton-shimmer mb-4" style="width: 85%; height: 16px;"></div>
                            <div class="skeleton-shimmer mb-3 w-100" style="height: 44px; border-radius: 25px;"></div>
                            <div class="skeleton-shimmer w-100" style="height: 44px; border-radius: 25px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Table Rows Skeleton -->
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="skeleton-shimmer" style="width: 180px; height: 24px;"></div>
                        <div class="skeleton-shimmer" style="width: 120px; height: 32px; border-radius: 8px;"></div>
                    </div>
                    <div class="skeleton-shimmer mb-3 w-100" style="height: 42px;"></div>
                    <div class="skeleton-shimmer mb-3 w-100" style="height: 42px;"></div>
                    <div class="skeleton-shimmer mb-3 w-100" style="height: 42px;"></div>
                    <div class="skeleton-shimmer w-100" style="height: 42px;"></div>
                </div>
            </div>
        </div>
        @endauth

        <div class="{{ auth()->check() ? 'content-wrapper page-fade-in' : 'container-fluid px-3 px-md-4 py-4' }}">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Gagal memproses data:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Smoothly remove skeleton on page load
            if (sessionStorage.getItem('nav_skeleton') === '1') {
                sessionStorage.removeItem('nav_skeleton');
                setTimeout(function() {
                    $('#page-skeleton').removeClass('active');
                    $('html').removeClass('nav-loading');
                }, 160);
            } else {
                $('#page-skeleton').removeClass('active');
                $('html').removeClass('nav-loading');
            }

            // Navigation transition skeleton effect
            $(document).on('click', 'a[href]', function(e) {
                const $link = $(this);
                const href = $link.attr('href');
                const target = $link.attr('target');

                // Ignore anchors, JS, new tab, downloads, modal toggles, dropdown buttons
                if (!href || 
                    href.startsWith('#') || 
                    href.startsWith('javascript') || 
                    target === '_blank' || 
                    $link.attr('download') || 
                    $link.data('bs-toggle') || 
                    $link.hasClass('no-skeleton') ||
                    href.includes('/download') ||
                    href.includes('/view') ||
                    ($link.closest('.dropdown-menu').length && href === '#')) {
                    return;
                }

                try {
                    const targetUrl = new URL(href, window.location.origin);
                    if (targetUrl.origin === window.location.origin && 
                        (targetUrl.pathname !== window.location.pathname || targetUrl.search !== window.location.search)) {
                        sessionStorage.setItem('nav_skeleton', '1');
                        $('#page-skeleton').addClass('active');
                    }
                } catch(err) {}
            });

            // Form submit transition (e.g. filter or search forms)
            $(document).on('submit', 'form', function() {
                const $form = $(this);
                if (!$form.attr('target') && !$form.hasClass('no-skeleton')) {
                    sessionStorage.setItem('nav_skeleton', '1');
                    $('#page-skeleton').addClass('active');
                }
            });

            // Handle browser back/forward buttons (pageshow)
            window.addEventListener('pageshow', function(event) {
                $('#page-skeleton').removeClass('active');
                $('html').removeClass('nav-loading');
                sessionStorage.removeItem('nav_skeleton');
            });

            // Auto close mobile sidebar when link clicked
            $('#sidebar .nav-link').on('click', function() {
                if ($(window).width() < 992) {
                    $('#sidebar').removeClass('show');
                    $('#sidebarOverlay').removeClass('show');
                }
            });

            // PWA Service Worker Registration
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js').then(function(reg) {
                        console.log('sippb Service Worker registered:', reg.scope);
                    }).catch(function(err) {
                        console.warn('Service Worker registration failed:', err);
                    });
                });
            }

            // Android & Chrome PWA Install Prompt handling
            let deferredPrompt;
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;
                if (!localStorage.getItem('pwa_banner_closed')) {
                    $('#pwaInstallBanner').removeClass('d-none');
                }
            });

            $('#btnInstallPwa').on('click', async function() {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    console.log(`PWA choice: ${outcome}`);
                    deferredPrompt = null;
                    $('#pwaInstallBanner').addClass('d-none');
                }
            });

            $('#btnClosePwaBanner').on('click', function() {
                $('#pwaInstallBanner').addClass('d-none');
                localStorage.setItem('pwa_banner_closed', '1');
            });

            window.addEventListener('appinstalled', () => {
                $('#pwaInstallBanner').addClass('d-none');
                deferredPrompt = null;
                console.log('sippb successfully installed');
            });

            // Trigger install button from header or sidebar
            $(document).on('click', '.btn-install-app', function(e) {
                e.preventDefault();
                const isIos = /iphone|ipad|ipod/.test(window.navigator.userAgent.toLowerCase());
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then(() => {
                        deferredPrompt = null;
                        $('#pwaInstallBanner').addClass('d-none');
                    });
                } else if (isIos) {
                    const myModal = new bootstrap.Modal(document.getElementById('iosInstallModal'));
                    myModal.show();
                } else {
                    alert('Untuk memasang aplikasi SIP-BS:\n1. Buka menu browser (ikon titik tiga di kanan atas).\n2. Pilih "Install aplikasi" atau "Tambahkan ke Layar Utama".');
                }
            });

            // Sidebar Toggle Logic
            $('#sidebarToggle, #sidebarOverlay').on('click', function() {
                $('#sidebar').toggleClass('show');
                $('#sidebarOverlay').toggleClass('show');
            });

            // Client-side file size validation for uploads
            $(document).on('change', 'input[type="file"]', function() {
                const file = this.files[0];
                if (file) {
                    const maxSize = 100 * 1024 * 1024; // 100MB in bytes
                    if (file.size > maxSize) {
                        alert('Ukuran file terlalu besar! Maksimal ukuran file adalah 100MB.');
                        $(this).val(''); // Reset file input
                    }
                }
            });
        });
    </script>

    @if($errors->any() && old('modal_id'))
    <script>
        $(document).ready(function() {
            var modalId = "{{ old('modal_id') }}";
            var modalEl = document.getElementById(modalId);
            if (modalEl) {
                var myModal = new bootstrap.Modal(modalEl);
                myModal.show();
            }
        });
    </script>
    @endif

    <!-- PWA Install Banner (Android / Chrome) -->
    <div id="pwaInstallBanner" class="pwa-install-banner d-none">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('images/icons/icon-72x72.png') }}" alt="SIP-BS" class="rounded-3 shadow-sm" style="width: 44px; height: 44px;">
            <div class="flex-grow-1">
                <div class="fw-bold text-dark lh-sm" style="font-size: 0.95rem;">Pasang Aplikasi SIP-BS</div>
                <small class="text-muted" style="font-size: 0.78rem;">Akses cepat regulasi langsung di layar HP Anda</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" id="btnInstallPwa" class="btn btn-primary btn-sm px-3 rounded-pill fw-semibold shadow-sm">
                    Pasang
                </button>
                <button type="button" id="btnClosePwaBanner" class="btn btn-light btn-sm rounded-circle p-1" style="width: 28px; height: 28px;">
                    <i class="fas fa-times text-muted"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- iOS Install Guide Modal -->
    <div class="modal fade" id="iosInstallModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-primary text-white border-0 py-3">
                    <h5 class="modal-title fs-6 fw-bold"><i class="fab fa-apple me-2"></i>Pasang di iPhone / iPad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <img src="{{ asset('images/icons/icon-96x96.png') }}" alt="SIP-BS" class="rounded-4 shadow-sm mb-3" style="width: 64px; height: 64px;">
                    <h6 class="fw-bold text-dark">Pasang SIP-BS ke Layar Utama</h6>
                    <p class="text-muted small mb-4">Akses aplikasi dengan satu ketukan langsung dari layar utama iPhone/iPad Anda:</p>
                    <ol class="text-start small text-secondary ps-3 mb-4 d-flex flex-column gap-2">
                        <li>Tekan ikon <strong>Bagikan (Share)</strong> <i class="fas fa-share-square text-primary mx-1"></i> di bilah navigasi Safari.</li>
                        <li>Gulir ke bawah dan pilih <strong>"Tambah ke Layar Utama" (Add to Home Screen)</strong> <i class="fas fa-plus-square text-primary mx-1"></i>.</li>
                        <li>Tekan <strong>Tambah (Add)</strong> di pojok kanan atas.</li>
                    </ol>
                    <button type="button" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold" data-bs-dismiss="modal">Saya Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
