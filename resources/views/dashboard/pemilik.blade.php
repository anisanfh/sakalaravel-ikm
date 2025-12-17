<!-- resources/views/dashboard/pemilik.blade.php -->
@extends('layouts.app')
@section('content')
    <!-- Include pemilik dashboard content here -->
@endsection
<div class="row">
    <!-- Financial Overview -->
    <div class="col-md-6">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark">
                <h6><i class="bi bi-cash-stack"></i> Overview Keuangan</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h6>Pengeluaran Bulan Ini</h6>
                        <h3 class="text-danger">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                        <small class="text-muted">Gaji + Operasional</small>
                    </div>
                    <div class="col-6">
                        <h6>Estimasi Pendapatan</h6>
                        <h3 class="text-success">Rp {{ number_format($estimasiPendapatan, 0, ',', '.') }}</h3>
                        <small class="text-muted">Berdasarkan produksi</small>
                    </div>
                </div>
                <hr>
                <div class="mt-3">
                    <h6>Profit Margin</h6>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $profitMargin }}%;">
                            {{ $profitMargin }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Business Health -->
    <div class="col-md-6">
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <h6><i class="bi bi-heart-pulse"></i> Kesehatan Bisnis</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="mb-2">
                            <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <h5>{{ $productivityRate }}%</h5>
                        <small>Produktivitas</small>
                    </div>
                    <div class="col-4">
                        <div class="mb-2">
                            <i class="bi bi-arrow-up-circle text-success" style="font-size: 2rem;"></i>
                        </div>
                        <h5>{{ $growthRate }}%</h5>
                        <small>Pertumbuhan</small>
                    </div>
                    <div class="col-4">
                        <div class="mb-2">
                            <i class="bi bi-shield-check text-info" style="font-size: 2rem;"></i>
                        </div>
                        <h5>{{ $retentionRate }}%</h5>
                        <small>Retensi Karyawan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Strategic Reports -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h6><i class="bi bi-graph-up-arrow"></i> Laporan Strategis</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card border-info">
                            <div class="card-body text-center">
                                <i class="bi bi-currency-dollar text-info mb-2" style="font-size: 2rem;"></i>
                                <h5>Analisis Biaya</h5>
                                <p class="text-muted small">Breakdown pengeluaran per departemen</p>
                                <a href="#" class="btn btn-sm btn-outline-info">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <i class="bi bi-person-lines-fill text-primary mb-2" style="font-size: 2rem;"></i>
                                <h5>Analisis SDM</h5>
                                <p class="text-muted small">Performa dan retensi karyawan</p>
                                <a href="#" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <i class="bi bi-box-seam text-success mb-2" style="font-size: 2rem;"></i>
                                <h5>Analisis Produk</h5>
                                <p class="text-muted small">Produktivitas dan kualitas produk</p>
                                <a href="#" class="btn btn-sm btn-outline-success">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Key Performance Indicators -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-speedometer2"></i> Key Performance Indicators (KPI)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Indikator</th>
                                <th>Target</th>
                                <th>Aktual</th>
                                <th>Pencapaian</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Produktivitas Karyawan</td>
                                <td>85%</td>
                                <td>{{ $productivityRate }}%</td>
                                <td>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-{{ $productivityRate >= 85 ? 'success' : ($productivityRate >= 70 ? 'warning' : 'danger') }}"
                                            style="width: {{ $productivityRate }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $productivityRate >= 85 ? 'success' : ($productivityRate >= 70 ? 'warning' : 'danger') }}">
                                        {{ $productivityRate >= 85 ? 'Tercapai' : ($productivityRate >= 70 ? 'Perlu Perbaikan' : 'Kritis') }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Retensi Karyawan</td>
                                <td>90%</td>
                                <td>{{ $retentionRate }}%</td>
                                <td>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-{{ $retentionRate >= 90 ? 'success' : ($retentionRate >= 80 ? 'warning' : 'danger') }}"
                                            style="width: {{ $retentionRate }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $retentionRate >= 90 ? 'success' : ($retentionRate >= 80 ? 'warning' : 'danger') }}">
                                        {{ $retentionRate >= 90 ? 'Baik' : ($retentionRate >= 80 ? 'Cukup' : 'Buruk') }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Profit Margin</td>
                                <td>25%</td>
                                <td>{{ $profitMargin }}%</td>
                                <td>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-{{ $profitMargin >= 25 ? 'success' : ($profitMargin >= 15 ? 'warning' : 'danger') }}"
                                            style="width: {{ $profitMargin }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $profitMargin >= 25 ? 'success' : ($profitMargin >= 15 ? 'warning' : 'danger') }}">
                                        {{ $profitMargin >= 25 ? 'Optimal' : ($profitMargin >= 15 ? 'Wajar' : 'Rendah') }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
