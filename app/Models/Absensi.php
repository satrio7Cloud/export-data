<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'id_karyawan',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'shift_id'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan'); // Relasi ke model Karyawan
    }

    public function shift()
    {
        return $this->belongsTo(ShiftJadwal::class, 'shift_id');
    }
}
