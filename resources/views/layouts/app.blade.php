<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SIP-PB') }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
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
        }
        
        .content-wrapper {
            padding: 2rem;
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
                <i class="fas fa-file-signature text-primary"></i>
                SIP-PB
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
        </div>

        <div class="sidebar-footer">
            <div class="text-center text-muted small">
                &copy; {{ date('Y') }} SIP-PB<br><small>Created by RAH</small>
            </div>
        </div>
    </nav>

    <!-- Mobile Topbar -->
    <div id="mobile-nav">
        <a href="#" class="sidebar-logo fs-4 text-decoration-none">
            <i class="fas fa-file-signature text-primary"></i> SIP-PB
        </a>
        <div class="d-flex align-items-center gap-2">
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
    <div id="{{ auth()->check() ? 'main-content' : '' }}">
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

        <div class="{{ auth()->check() ? 'content-wrapper' : 'container-fluid p-4' }}">
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

            @yield('content')
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Sidebar Toggle Logic
            $('#sidebarToggle, #sidebarOverlay').on('click', function() {
                $('#sidebar').toggleClass('show');
                $('#sidebarOverlay').toggleClass('show');
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
