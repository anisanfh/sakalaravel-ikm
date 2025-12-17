<?php
// app/Models/Karyawan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'm_karyawan'; // Nama tabel dari SQL
    protected $primaryKey = 'id_karyawan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_karyawan',
        'nama_karyawan',
        'jabatan',
        'gaji_harian',
        'email',
        'password',
        'no_telp',
        'alamat',
        'status_karyawan',
        'jml_target',
        'total_hadir'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'gaji_harian' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate ID otomatis saat membuat data baru
        static::creating(function ($karyawan) {
            if (!$karyawan->id_karyawan) {
                $karyawan->id_karyawan = 'KRY-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            }

            // Hash password jika diisi
            if ($karyawan->password && !Hash::needsRehash($karyawan->password)) {
                $karyawan->password = Hash::make($karyawan->password);
            }
        });

        // Hash password saat update jika diisi
        static::updating(function ($karyawan) {
            if ($karyawan->isDirty('password') && $karyawan->password) {
                $karyawan->password = Hash::make($karyawan->password);
            }
        });
    }

    // Scope untuk karyawan aktif
    public function scopeAktif($query)
    {
        return $query->where('status_karyawan', 'aktif');
    }

    // Helper methods untuk role
    public function isPemilik()
    {
        return $this->jabatan === 'pemilik';
    }

    public function isSupervisor()
    {
        return $this->jabatan === 'supervisor';
    }

    public function isOperator()
    {
        return $this->jabatan === 'operator';
    }
}
