{{-- resources/views/karyawan/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan</title>

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

    <style>
        .badge {
            font-size: 0.85em;
            padding: 0.4em 0.8em;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .action-buttons .btn {
            margin-right: 5px;
        }

        .card {
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-users"></i> Sistem Manajemen Karyawan
            </a>
            <div class="navbar-nav ml-auto">
                <a class="nav-link text-white" href="#">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-user-tie text-primary"></i> Daftar Karyawan
                        </h4>
                        <a href="{{ route('karyawan.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Karyawan
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="karyawanTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Email</th>
                                        <th>No. Telp</th>
                                        <th>Gaji Harian</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($karyawans as $karyawan)
                                        <tr>
                                            <td><strong>{{ $karyawan->id_karyawan }}</strong></td>
                                            <td>{{ $karyawan->nama_karyawan }}</td>
                                            <td>
                                                @php
                                                    $badgeClass =
                                                        [
                                                            'pemilik' => 'danger',
                                                            'supervisor' => 'warning',
                                                            'operator' => 'info',
                                                        ][$karyawan->jabatan] ?? 'secondary';
                                                @endphp
                                                <span class="badge badge-{{ $badgeClass }}">
                                                    {{ strtoupper($karyawan->jabatan) }}
                                                </span>
                                            </td>
                                            <td>{{ $karyawan->email ?? '-' }}</td>
                                            <td>{{ $karyawan->no_telp ?? '-' }}</td>
                                            <td>Rp {{ number_format($karyawan->gaji_harian, 0, ',', '.') }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $karyawan->status_karyawan == 'aktif' ? 'success' : 'danger' }}">
                                                    {{ strtoupper($karyawan->status_karyawan) }}
                                                </span>
                                            </td>
                                            <td class="action-buttons">
                                                <a href="{{ route('karyawan.show', $karyawan->id_karyawan) }}"
                                                    class="btn btn-sm btn-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('karyawan.edit', $karyawan->id_karyawan) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('karyawan.destroy', $karyawan->id_karyawan) }}"
                                                    method="POST" class="d-inline" onsubmit="return confirmDelete()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Belum ada data karyawan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#karyawanTable').DataTable({
                "pageLength": 10,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });
        });

        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');
        }
    </script>
</body>

</html>
