<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);

        // Insert data karyawan dummy
        DB::table('m_karyawan')->insert([
            [
                'id_karyawan' => 'KRY001',
                'nama_karyawan' => 'Budi Santoso',
                'jabatan' => 'operator',
                'gaji_harian' => 120000,
                'email' => 'budi@ikm.com',
                'password' => Hash::make('password123'),
                'no_telp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 1',
                'status_karyawan' => 'aktif',
                'jml_target' => 500,
                'total_hadir' => 20,
            ],
            [
                'id_karyawan' => 'KRY002',
                'nama_karyawan' => 'Siti Aminah',
                'jabatan' => 'supervisor',
                'gaji_harian' => 150000,
                'email' => 'siti@ikm.com',
                'password' => Hash::make('password123'),
                'no_telp' => '081234567891',
                'alamat' => 'Jl. Sudirman No. 2',
                'status_karyawan' => 'aktif',
                'jml_target' => 500,
                'total_hadir' => 25,
            ],
            [
                'id_karyawan' => 'KRY003',
                'nama_karyawan' => 'Ahmad Wijaya',
                'jabatan' => 'operator',
                'gaji_harian' => 110000,
                'email' => 'ahmad@ikm.com',
                'password' => Hash::make('password123'),
                'no_telp' => '081234567892',
                'alamat' => 'Jl. Gatot Subroto No. 3',
                'status_karyawan' => 'aktif',
                'jml_target' => 500,
                'total_hadir' => 18,
            ],
        ]);

        // Insert data produk dummy
        DB::table('m_produk')->insert([
            [
                'id_produk' => 'PRD001',
                'nama_produk' => 'Kampas Rem',
                'status_produk' => 'aktif',
                'satuan' => 'pcs',
            ],
            [
                'id_produk' => 'PRD002',
                'nama_produk' => 'Filter Oli',
                'status_produk' => 'aktif',
                'satuan' => 'pcs',
            ],
            [
                'id_produk' => 'PRD003',
                'nama_produk' => 'Busi Motor',
                'status_produk' => 'aktif',
                'satuan' => 'pcs',
            ],
        ]);

        // Insert data absensi dummy
        DB::table('m_absensi')->insert([
            [
                'id_absensi' => 'ABS20231217001',
                'tanggal' => '2023-12-17',
                'jam_masuk' => '08:00:00',
                'jam_keluar' => '16:00:00',
                'id_karyawan' => 'KRY001',
                'total_gaji' => 120000,
                'bonus_lembur' => 0,
                'potongan' => 0,
                'total_aktual' => 1,
                'status_absensi' => 'hadir',
            ],
            [
                'id_absensi' => 'ABS20231217002',
                'tanggal' => '2023-12-17',
                'jam_masuk' => '08:30:00',
                'jam_keluar' => '17:00:00',
                'id_karyawan' => 'KRY002',
                'total_gaji' => 150000,
                'bonus_lembur' => 15000,
                'potongan' => 0,
                'total_aktual' => 1,
                'status_absensi' => 'hadir',
            ],
        ]);
    }
}
