<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1"><i class="bi bi-speedometer2 me-2"></i>Dashboard IKM Otomotif</h2>
                        <p class="text-muted mb-0">Sistem Manajemen Terintegrasi</p>
                    </div>
                    <div class="text-end">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <small class="text-muted d-block">Tanggal</small>
                                <strong>{{ now()->translatedFormat('l, d F Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Stats Row -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-primary border-3 shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col me-2">
                                <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                    Total Karyawan
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $karyawanCount }}</div>
                                <div class="mt-2 mb-0">
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i> {{ $karyawanAktif }} aktif
                                    </span>
                                    <span class="badge bg-secondary ms-1">
                                        {{ $karyawanCount - $karyawanAktif }} nonaktif
                                    </span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-people text-primary" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-success border-3 shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col me-2">
                                <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                    Total Produk
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $produkCount }}</div>
                                <div class="mt-2 mb-0">
                                    @php
                                        $produkAktif = \App\Models\Produk::where('status_produk', 'aktif')->count();
                                        $produkNonAktif = \App\Models\Produk::where(
                                            'status_produk',
                                            'nonaktif',
                                        )->count();
                                    @endphp
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i> {{ $produkAktif }} aktif
                                    </span>
                                    <span class="badge bg-secondary ms-1">
                                        {{ $produkNonAktif }} nonaktif
                                    </span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-box-seam text-success" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-info border-3 shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col me-2">
                                <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                    Absensi Hari Ini
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $absensiToday }}</div>
                                <div class="mt-2 mb-0">
                                    @php
                                        $hadirToday = \App\Models\Absensi::whereDate('tanggal', today())
                                            ->where('status_absensi', 'hadir')
                                            ->count();
                                        $cutiToday = \App\Models\Absensi::whereDate('tanggal', today())
                                            ->where('status_absensi', 'cuti')
                                            ->count();
                                        $tidakHadirToday = \App\Models\Absensi::whereDate('tanggal', today())
                                            ->where('status_absensi', 'tidak hadir')
                                            ->count();
                                    @endphp
                                    <span class="badge bg-success me-1">
                                        {{ $hadirToday }} hadir
                                    </span>
                                    <span class="badge bg-warning me-1">
                                        {{ $cutiToday }} cuti
                                    </span>
                                    <span class="badge bg-danger">
                                        {{ $tidakHadirToday }} tidak hadir
                                    </span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-calendar-check text-info" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-warning border-3 shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col me-2">
                                <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                    Kehadiran Bulan Ini
                                </div>
                                @php
                                    $hadirBulanIni = \App\Models\Absensi::whereMonth('tanggal', now()->month)
                                        ->whereYear('tanggal', now()->year)
                                        ->where('status_absensi', 'hadir')
                                        ->count();
                                    $attendanceRate =
                                        $karyawanAktif > 0 ? round(($hadirToday / $karyawanAktif) * 100, 1) : 0;
                                @endphp
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $hadirBulanIni }}</div>
                                <div class="mt-2 mb-0">
                                    <span class="badge bg-info">
                                        {{ $attendanceRate }}% kehadiran hari ini
                                    </span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-graph-up text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Detailed Stats -->
        <div class="row mb-4">
            <!-- Left Column: Charts -->
            <div class="col-xl-8 col-lg-7">
                <!-- Attendance Chart Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="m-0 fw-bold"><i class="bi bi-bar-chart me-2"></i>Statistik Kehadiran 7 Hari Terakhir</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area" style="height: 300px;">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Recent Activity -->
            <div class="col-xl-4 col-lg-5">
                <!-- Recent Absensi Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Absensi Terbaru</h6>
                        <a href="{{ route('absensi.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @php
                                // Query tanpa order by created_at
                                $recentAbsensi = \App\Models\Absensi::with('karyawan')
                                    ->orderBy('tanggal', 'desc')
                                    ->limit(8)
                                    ->get();
                            @endphp

                            @if ($recentAbsensi->count() > 0)
                                @foreach ($recentAbsensi as $absensi)
                                    <div class="list-group-item border-0">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-sm">
                                                    <span
                                                        class="avatar-title rounded-circle bg-{{ $absensi->status_absensi == 'hadir' ? 'success' : ($absensi->status_absensi == 'cuti' ? 'warning' : 'danger') }}-subtle text-{{ $absensi->status_absensi == 'hadir' ? 'success' : ($absensi->status_absensi == 'cuti' ? 'warning' : 'danger') }}">
                                                        <i class="bi bi-person"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ $absensi->karyawan->nama_karyawan ?? 'N/A' }}</h6>
                                                <p class="text-muted mb-0 small">
                                                    {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}
                                                    @if ($absensi->jam_masuk)
                                                        • {{ $absensi->jam_masuk }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <span
                                                    class="badge bg-{{ $absensi->status_absensi == 'hadir' ? 'success' : ($absensi->status_absensi == 'cuti' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($absensi->status_absensi) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-calendar-x text-muted mb-3" style="font-size: 3rem;"></i>
                                    <p class="text-muted">Belum ada data absensi</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Top Performers Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-light py-3">
                        <h6 class="m-0 fw-bold"><i class="bi bi-trophy me-2"></i>Top Performers</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @php
                                // Query berdasarkan total_hadir tanpa created_at
                                $topPerformers = \App\Models\Karyawan::where('status_karyawan', 'aktif')
                                    ->orderBy('total_hadir', 'desc')
                                    ->limit(5)
                                    ->get();
                            @endphp

                            @if ($topPerformers->count() > 0)
                                @foreach ($topPerformers as $index => $karyawan)
                                    <div class="list-group-item border-0">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-sm">
                                                    <div
                                                        class="avatar-title bg-{{ $index < 3 ? 'warning' : 'light' }} text-{{ $index < 3 ? 'dark' : 'muted' }} rounded-circle">
                                                        {{ $index + 1 }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ $karyawan->nama_karyawan }}</h6>
                                                <p class="text-muted mb-0 small">
                                                    <span
                                                        class="badge bg-{{ $karyawan->jabatan == 'supervisor' ? 'info' : 'secondary' }}">
                                                        {{ ucfirst($karyawan->jabatan) }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i> {{ $karyawan->total_hadir }}
                                                    hari
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-people text-muted mb-3" style="font-size: 3rem;"></i>
                                    <p class="text-muted">Belum ada data karyawan</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Data Tables -->
        <div class="row">
            <!-- Recent Karyawan -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold"><i class="bi bi-people me-2"></i>Karyawan</h6>
                        <a href="{{ route('karyawan.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Query karyawan tanpa order by created_at
                                        $recentKaryawan = \App\Models\Karyawan::limit(6)->get();
                                    @endphp

                                    @if ($recentKaryawan->count() > 0)
                                        @foreach ($recentKaryawan as $karyawan)
                                            <tr>
                                                <td><code>{{ $karyawan->id_karyawan }}</code></td>
                                                <td>
                                                    <div class="fw-semibold">{{ $karyawan->nama_karyawan }}</div>
                                                    <small class="text-muted">{{ $karyawan->email }}</small>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $karyawan->jabatan == 'pemilik' ? 'warning' : ($karyawan->jabatan == 'supervisor' ? 'info' : 'secondary') }}">
                                                        {{ ucfirst($karyawan->jabatan) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $karyawan->status_karyawan == 'aktif' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($karyawan->status_karyawan) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center py-3">
                                                <i class="bi bi-people text-muted mb-2" style="font-size: 2rem;"></i>
                                                <p class="text-muted mb-0">Belum ada data karyawan</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Products -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold"><i class="bi bi-box-seam me-2"></i>Produk</h6>
                        <a href="{{ route('produk.index') }}" class="btn btn-sm btn-outline-success">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Produk</th>
                                        <th>Satuan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Query produk tanpa order by created_at
                                        $recentProduk = \App\Models\Produk::limit(6)->get();
                                    @endphp

                                    @if ($recentProduk->count() > 0)
                                        @foreach ($recentProduk as $produk)
                                            <tr>
                                                <td><code>{{ $produk->id_produk }}</code></td>
                                                <td>
                                                    <div class="fw-semibold">{{ $produk->nama_produk }}</div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $produk->satuan }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $produk->status_produk == 'aktif' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($produk->status_produk) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center py-3">
                                                <i class="bi bi-box-seam text-muted mb-2" style="font-size: 2rem;"></i>
                                                <p class="text-muted mb-0">Belum ada data produk</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border-radius: 0.5rem;
            transition: all 0.3s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        .border-start-primary {
            border-left-color: #4e73df !important;
        }

        .border-start-success {
            border-left-color: #1cc88a !important;
        }

        .border-start-info {
            border-left-color: #36b9cc !important;
        }

        .border-start-warning {
            border-left-color: #f6c23e !important;
        }

        .avatar-sm {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-area {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .list-group-item {
            border-left: 0;
            border-right: 0;
        }

        .list-group-item:first-child {
            border-top: 0;
        }

        .list-group-item:last-child {
            border-bottom: 0;
        }
    </style>
@endpush

@push('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Attendance Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');

            // Data dummy untuk chart
            const labels = [];
            const hadirData = [];
            const cutiData = [];
            const tidakHadirData = [];

            // Generate data untuk 7 hari terakhir
            for (let i = 6; i >= 0; i--) {
                const date = new Date();
                date.setDate(date.getDate() - i);
                labels.push(date.toLocaleDateString('id-ID', {
                    weekday: 'short',
                    day: 'numeric'
                }));

                // Data dummy
                hadirData.push(Math.floor(Math.random() * 10) + 5);
                cutiData.push(Math.floor(Math.random() * 3));
                tidakHadirData.push(Math.floor(Math.random() * 2));
            }

            const attendanceChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Hadir',
                        data: hadirData,
                        borderColor: '#1cc88a',
                        backgroundColor: 'rgba(28, 200, 138, 0.1)',
                        fill: true,
                        tension: 0.4
                    }, {
                        label: 'Cuti',
                        data: cutiData,
                        borderColor: '#f6c23e',
                        backgroundColor: 'rgba(246, 194, 62, 0.1)',
                        fill: true,
                        tension: 0.4
                    }, {
                        label: 'Tidak Hadir',
                        data: tidakHadirData,
                        borderColor: '#e74a3b',
                        backgroundColor: 'rgba(231, 74, 59, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 2
                            }
                        }
                    }
                }
            });

            // Auto refresh dashboard setiap 60 detik
            setTimeout(function() {
                window.location.reload();
            }, 60000);
        });
    </script>
@endpush
