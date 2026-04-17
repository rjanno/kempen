@extends('layouts.app')

@push('styles')
<style>
    .stat-card {
        border-radius: 16px;
        overflow: hidden;
        border: none;
        color: white;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        position: relative;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .stat-card::after {
        content: '';
        position: absolute;
        bottom: -20px;
        right: -20px;
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        font-size: 8rem;
        opacity: 0.1;
        z-index: 0;
        transition: all 0.3s;
    }
    .stat-card:hover::after {
        transform: scale(1.1);
    }
    .stat-card-1 {
        background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
    }
    .stat-card-1::after { content: '\f15c'; } /* fa-file-alt */
    
    .stat-card-2 {
        background: linear-gradient(135deg, #fd7e14 0%, #ffaa5b 100%);
    }
    .stat-card-2::after { content: '\f03d'; } /* fa-video */
    
    .stat-card-3 {
        background: linear-gradient(135deg, #20c997 0%, #4ae5b8 100%);
    }
    .stat-card-3::after { content: '\f0c0'; } /* fa-users */

    .stat-card-body {
        position: relative;
        z-index: 1;
        padding: 2rem;
    }
    .stat-card-footer {
        position: relative;
        z-index: 1;
        background: rgba(255, 255, 255, 0.15) !important;
        border-top: none;
        backdrop-filter: blur(5px);
        transition: background 0.3s;
    }
    .stat-card-footer:hover {
        background: rgba(255, 255, 255, 0.25) !important;
    }
    .stat-card-footer a {
        color: white;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .welcome-card {
        border-radius: 16px;
        background: white;
        border: 1px solid rgba(0,0,0,0.05);
    }
</style>
@endpush

@section('content')
<div class="mb-4">
    <h2 class="fw-bold text-gray-800">Overview Dashboard</h2>
    <p class="text-muted">Ringkasan statistik data Portal SK saat ini.</p>
</div>

<div class="row g-4 mb-5">
    <!-- Stat Card 1 -->
    <div class="col-md-4">
        <div class="card stat-card stat-card-1 shadow-sm h-100">
            <div class="card-body stat-card-body">
                <h6 class="text-white-50 text-uppercase fw-bold mb-2">Total Dokumen SK</h6>
                <h2 class="display-4 fw-bold mb-0">{{ $totalSK ?? 0 }}</h2>
            </div>
            <div class="card-footer stat-card-footer p-0">
                <a href="{{ route('admin.sk') }}" class="p-3">
                    Lihat Detail Dokumen <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Stat Card 2 -->
    <div class="col-md-4">
        <div class="card stat-card stat-card-2 shadow-sm h-100">
            <div class="card-body stat-card-body">
                <h6 class="text-white-50 text-uppercase fw-bold mb-2">Total Video / Sosialisasi</h6>
                <h2 class="display-4 fw-bold mb-0">{{ $totalVideo ?? 0 }}</h2>
            </div>
            <div class="card-footer stat-card-footer p-0">
                <a href="{{ route('admin.video') }}" class="p-3">
                    Lihat Detail Video <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Stat Card 3 -->
    <div class="col-md-4">
        <div class="card stat-card stat-card-3 shadow-sm h-100">
            <div class="card-body stat-card-body">
                <h6 class="text-white-50 text-uppercase fw-bold mb-2">Total Pengguna</h6>
                <h2 class="display-4 fw-bold mb-0">{{ $totalUsers ?? 0 }}</h2>
            </div>
            <div class="card-footer stat-card-footer p-0">
                <a href="{{ route('admin.users') }}" class="p-3">
                    Kelola Pengguna <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row align-items-stretch">
    <!-- Chart Section -->
    <div class="col-lg-8 mb-5">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold text-gray-800 mb-0"><i class="fas fa-chart-bar text-primary me-2"></i> Statistik Akses SK</h5>
                <p class="text-muted small">Top 5 Surat Keputusan yang paling sering diunduh/dilihat oleh pengguna.</p>
            </div>
            <div class="card-body px-4 pb-4" style="position: relative; height: 350px; width: 100%;">
                <canvas id="skChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Login Frequency Chart -->
    <div class="col-lg-12 mb-5">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h5 class="fw-bold text-gray-800 mb-0"><i class="fas fa-users text-primary me-2"></i> Frekuensi Login Pengguna</h5>
                    <p class="text-muted small">Top 10 pengguna yang paling sering login.</p>
                </div>
                <div>
                    <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex align-items-center">
                        <label for="days" class="me-2 small fw-bold">Filter Waktu:</label>
                        <select name="days" id="days" class="form-select form-select-sm shadow-sm" style="width: auto; border-radius: 8px;" onchange="this.form.submit()">
                            <option value="1" {{ $days == 1 ? 'selected' : '' }}>Hari Ini</option>
                            <option value="7" {{ $days == 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
                            <option value="30" {{ $days == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
                            <option value="90" {{ $days == 90 ? 'selected' : '' }}>3 Bulan Terakhir</option>
                            <option value="365" {{ $days == 365 ? 'selected' : '' }}>1 Tahun Terakhir</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="card-body px-4 pb-4" style="position: relative; height: 350px; width: 100%;">
                <canvas id="loginChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Info Section -->
    <div class="col-lg-4 mb-5">
        <div class="card welcome-card shadow-sm h-100">
            <div class="card-body p-4 d-flex flex-column justify-content-center">
                <h4 class="fw-bold mb-3">Selamat Datang, {{ auth()->user()->name }}! 👋</h4>
                <p class="text-muted mb-4">Anda login sebagai Administrator. Gunakan Navigasi disamping atau klik panel di atas untuk mulai mengelola sistem SK.</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.sk') }}" class="btn btn-primary rounded-pill py-2 fw-medium"><i class="fas fa-plus me-2"></i>Tambah SK Baru</a>
                    <a href="{{ route('admin.users') }}" class="btn btn-light border rounded-pill py-2 text-dark fw-medium"><i class="fas fa-user-plus me-2"></i>Undang User</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rawTitles = {!! json_encode($topPolicies->pluck('title') ?? []) !!};
    const rawViews = {!! json_encode($topPolicies->pluck('views_count') ?? []) !!};
    
    // Only render chart if there is data
    if (rawTitles.length === 0) {
        document.getElementById('skChart').parentElement.innerHTML = '<div class="text-center text-muted py-5"><i class="fas fa-chart-line fs-2 mb-3"></i><br>Belum ada data analitik.</div>';
        return;
    }

    const ctx = document.getElementById('skChart').getContext('2d');
    
    // Gradient styling for the bars
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(124, 58, 237, 0.8)');   // #7c3aed
    gradient.addColorStop(1, 'rgba(124, 58, 237, 0.2)');

    const chartData = {
        labels: rawTitles,
        datasets: [{
            label: 'Total Unduhan/Tayangan',
            data: rawViews,
            backgroundColor: gradient,
            borderColor: '#7c3aed',
            borderWidth: 1,
            borderRadius: 6,
            barPercentage: 0.6
        }]
    };

    new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12,
                    titleFont: { family: 'Inter', size: 13 },
                    bodyFont: { family: 'Inter', size: 14, weight: 'bold' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, font: { family: 'Inter' } },
                    grid: { borderDash: [5, 5], color: '#f0f0f0' }
                },
                x: {
                    ticks: {
                        font: { family: 'Inter' },
                        callback: function(value) {
                            // Truncate long titles
                            let title = this.getLabelForValue(value);
                            return title && title.length > 20 ? title.substr(0, 20) + '...' : title;
                        }
                    },
                    grid: { display: false }
                }
            }
        }
    });

    // Login Frequency Chart
    const rawLoginNames = {!! json_encode($loginStats->pluck('user.name') ?? []) !!};
    const rawLoginCounts = {!! json_encode($loginStats->pluck('total_logins') ?? []) !!};

    if (rawLoginNames.length === 0) {
        document.getElementById('loginChart').parentElement.innerHTML = '<div class="text-center text-muted py-4"><i class="fas fa-users-slash fs-3 mb-2"></i><br>Belum ada data login pengguna dalam rentang waktu ini.</div>';
    } else {
        const loginCtx = document.getElementById('loginChart').getContext('2d');
        
        const loginGradient = loginCtx.createLinearGradient(0, 0, 0, 400);
        loginGradient.addColorStop(0, 'rgba(32, 201, 151, 0.8)');   // #20c997
        loginGradient.addColorStop(1, 'rgba(32, 201, 151, 0.2)');

        new Chart(loginCtx, {
            type: 'bar',
            data: {
                labels: rawLoginNames,
                datasets: [{
                    label: 'Frekuensi Login',
                    data: rawLoginCounts,
                    backgroundColor: loginGradient,
                    borderColor: '#20c997',
                    borderWidth: 1,
                    borderRadius: 6,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        titleFont: { family: 'Inter', size: 13 },
                        bodyFont: { family: 'Inter', size: 14, weight: 'bold' }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, font: { family: 'Inter' } },
                        grid: { borderDash: [5, 5], color: '#f0f0f0' }
                    },
                    x: {
                        ticks: { font: { family: 'Inter' } },
                        grid: { display: false }
                    }
                }
            }
        });
    }
});
</script>
@endpush
