<?php
// app/Models/Absensi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'm_absensi';

    // Note: Tabel ini punya composite primary key, tapi Laravel tidak support composite primary key
    // Kita akan gunakan id sebagai primary key
    protected $primaryKey = 'id_absensi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_absensi',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'id_karyawan',
        'total_gaji',
        'bonus_lembur',
        'potongan',
        'total_aktual',
        'status_absensi'
    ];

    protected $casts = [
        'total_gaji' => 'decimal:2',
        'bonus_lembur' => 'decimal:2',
        'potongan' => 'decimal:2',
        'tanggal' => 'date',
    ];

    // Relationship dengan karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}
