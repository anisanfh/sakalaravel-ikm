<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Produk;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $karyawanCount = Karyawan::count();
        $produkCount = Produk::count();
        $absensiToday = Absensi::whereDate('tanggal', today())->count();
        $karyawanAktif = Karyawan::where('status_karyawan', 'aktif')->count();

        // Data umum untuk semua role
        $commonData = compact(
            'karyawanCount',
            'produkCount',
            'absensiToday',
            'karyawanAktif'
        );

        // Data khusus berdasarkan role
        if ($user->isSupervisor()) {
            return $this->supervisorDashboard($commonData);
        } else if ($user->isPemilik()) {
            return $this->pemilikDashboard($commonData);
        }

        // Fallback ke dashboard umum
        return view('dashboard', $commonData);
    }

    private function supervisorDashboard($commonData)
    {
        // Data khusus supervisor
        $hadirToday = Absensi::whereDate('tanggal', today())
            ->where('status_absensi', 'hadir')->count();

        $operatorPerformance = Karyawan::where('jabatan', 'operator')
            ->where('status_karyawan', 'aktif')
            ->get()
            ->map(function ($karyawan) {
                $karyawan->total_produksi = rand(300, 600); // Data dummy
                return $karyawan;
            });

        $absensiPagiDone = Absensi::whereDate('tanggal', today())
            ->whereTime('jam_masuk', '<', '09:00:00')
            ->exists();

        $additionalData = [
            'hadirToday' => $hadirToday,
            'operatorPerformance' => $operatorPerformance,
            'absensiPagiDone' => $absensiPagiDone,
            'terlambatToday' => Absensi::whereDate('tanggal', today())
                ->whereTime('jam_masuk', '>', '08:00:00')
                ->count(),
            'produksiToday' => rand(2000, 5000), // Data dummy
        ];

        return view('dashboard.supervisor', array_merge($commonData, $additionalData));
    }

    private function pemilikDashboard($commonData)
    {
        // Data khusus pemilik
        $totalPengeluaran = Absensi::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('total_gaji') + (rand(5000000, 15000000)); // Tambah biaya operasional

        $estimasiPendapatan = $produkCount * rand(50000, 200000); // Data dummy

        $profitMargin = $estimasiPendapatan > 0
            ? round(($estimasiPendapatan - $totalPengeluaran) / $estimasiPendapatan * 100, 1)
            : 0;

        $productivityRate = $karyawanAktif > 0
            ? round(($commonData['absensiToday'] / ($karyawanAktif * now()->day)) * 100, 1)
            : 0;

        $growthRate = rand(5, 20); // Data dummy
        $retentionRate = 100 - (rand(0, 10)); // Data dummy

        $additionalData = [
            'totalPengeluaran' => $totalPengeluaran,
            'estimasiPendapatan' => $estimasiPendapatan,
            'profitMargin' => max(0, $profitMargin),
            'productivityRate' => $productivityRate,
            'growthRate' => $growthRate,
            'retentionRate' => $retentionRate,
        ];

        return view('dashboard.pemilik', array_merge($commonData, $additionalData));
    }
}
