<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'jabatan',
        'tanggal_masuk',
        'notelp'
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_karyawan'); // Relasi satu ke banyak dengan model Absensi
    }

    public function izin()
    {
        return $this->hasMany(Izin::class, 'id_karyawan'); // Relasi satu ke banyak dengan model Izin
    }

    public function shift()
    {
        return $this->belongsTo(ShiftJadwal::class, 'shift_id');
    }

    public function libur(){
        return $this->hasMany(Libur::class, 'id_karyawan');
    }
}
