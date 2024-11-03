<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftJadwal extends Model
{
    protected $table = 'shift_jadwal';

    protected $fillable = [
        'shift_nama',
        'jam_masuk',
        'jam_keluar',
        'id_karyawan',
        'hari'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
