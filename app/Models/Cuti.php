<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $table = 'cuti';

    protected $fillable = [
        'id_karyawan',  // ID karyawan yang mengajukan cuti
        'tanggal_mulai', // Tanggal mulai cuti
        'tanggal_selesai' // Tanggal selesai cuti
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
