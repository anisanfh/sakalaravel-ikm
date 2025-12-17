<?php
// app/Http/Controllers/AbsensiController.php
namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AbsensiController extends Controller
{
    // TIDAK ADA CONSTRUCTOR

    public function index()
    {
        $absensi = Absensi::with('karyawan')->latest('tanggal')->get();
        return view('absensi.index', compact('absensi'));
    }

    public function create()
    {
        $karyawan = Karyawan::where('status_karyawan', 'aktif')->get();
        return view('absensi.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:m_karyawan,id_karyawan',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i|after:jam_masuk',
            'status_absensi' => 'required|in:hadir,tidak hadir,cuti',
        ]);

        // Generate ID Absensi
        $id_absensi = 'ABS-' . date('Ymd') . '-' . Str::random(4);

        // Cek apakah sudah ada absensi untuk karyawan di tanggal tersebut
        $existing = Absensi::where('id_karyawan', $request->id_karyawan)
            ->whereDate('tanggal', $request->tanggal)
            ->exists();

        if ($existing) {
            return back()->with('error', 'Karyawan sudah memiliki absensi pada tanggal ini.');
        }

        Absensi::create([
            'id_absensi' => $id_absensi,
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'status_absensi' => $request->status_absensi,
            'total_aktual' => $request->status_absensi === 'hadir' ? 1 : 0,
        ]);

        // Update total hadir karyawan jika hadir
        if ($request->status_absensi === 'hadir') {
            Karyawan::where('id_karyawan', $request->id_karyawan)
                ->increment('total_hadir');
        }

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dicatat');
    }

    public function show(Absensi $absensi)
    {
        return view('absensi.show', compact('absensi'));
    }

    public function edit(Absensi $absensi)
    {
        $karyawan = Karyawan::where('status_karyawan', 'aktif')->get();
        return view('absensi.edit', compact('absensi', 'karyawan'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:m_karyawan,id_karyawan',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i|after:jam_masuk',
            'status_absensi' => 'required|in:hadir,tidak hadir,cuti',
        ]);

        $old_status = $absensi->status_absensi;
        $new_status = $request->status_absensi;

        $absensi->update([
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'status_absensi' => $new_status,
            'total_aktual' => $new_status === 'hadir' ? 1 : 0,
        ]);

        // Update total hadir karyawan jika status berubah
        if ($old_status !== $new_status) {
            $karyawan = Karyawan::find($request->id_karyawan);

            if ($old_status === 'hadir' && $new_status !== 'hadir') {
                $karyawan->decrement('total_hadir');
            } elseif ($old_status !== 'hadir' && $new_status === 'hadir') {
                $karyawan->increment('total_hadir');
            }
        }

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil diupdate');
    }

    public function destroy(Absensi $absensi)
    {
        // Kurangi total hadir jika status hadir
        if ($absensi->status_absensi === 'hadir') {
            Karyawan::where('id_karyawan', $absensi->id_karyawan)
                ->decrement('total_hadir');
        }

        $absensi->delete();
        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dihapus');
    }
}
