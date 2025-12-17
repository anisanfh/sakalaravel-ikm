<!-- resources/views/dashboard/supervisor.blade.php -->
@extends('layouts.app')
@section('content')
    <!-- Include supervisor dashboard content here -->
@endsection
<div class="row">
    <!-- Operational Stats -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6><i class="bi bi-gear"></i> Operasional Hari Ini</h6>
            </div>
            <div class="card-body">
                <p><strong>Karyawan yang hadir:</strong> {{ $hadirToday }}/{{ $karyawanAktif }}</p>
                <p><strong>Produksi target:</strong> {{ $produksiToday }}/500 unit</p>
                <p><strong>Absensi terlambat:</strong> {{ $terlambatToday }} orang</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions for Supervisor -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6><i class="bi bi-lightning"></i> Aksi Supervisor</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('absensi.create') }}" class="btn btn-warning w-100 mb-2">
                            <i class="bi bi-clock"></i> Input Absensi
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('karyawan.create') }}" class="btn btn-success w-100 mb-2">
                            <i class="bi bi-person-plus"></i> Tambah Karyawan
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('produk.create') }}" class="btn btn-info w-100 mb-2">
                            <i class="bi bi-plus-circle"></i> Tambah Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Production Monitoring -->
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h6><i class="bi bi-graph-up"></i> Monitoring Produksi</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Operator</th>
                            <th>Target Harian</th>
                            <th>Pencapaian</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($operatorPerformance as $operator)
                            <tr>
                                <td>{{ $operator->nama_karyawan }}</td>
                                <td>{{ $operator->jml_target }} unit</td>
                                <td>{{ $operator->total_produksi }} unit</td>
                                <td>
                                    <span
                                        class="badge bg-{{ ($operator->total_produksi / $operator->jml_target) * 100 >= 80 ? 'success' : 'warning' }}">
                                        {{ round(($operator->total_produksi / $operator->jml_target) * 100, 1) }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Summary -->
<div class="row mt-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-calendar-check"></i> Rekap Absensi Bulan Ini</h6>
            </div>
            <div class="card-body">
                <canvas id="monthlyAttendanceChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-list-check"></i> Tugas Harian</h6>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Input absensi pagi</span>
                        <span class="badge bg-{{ $absensiPagiDone ? 'success' : 'warning' }}">
                            {{ $absensiPagiDone ? 'Selesai' : 'Pending' }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Cek stok produk</span>
                        <span class="badge bg-success">Selesai</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Laporan produksi</span>
                        <span class="badge bg-warning">Pending</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
