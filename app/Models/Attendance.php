<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'id_karyawan',
        'tanggal',
        'status'
    ];

    public function karyawan(){
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
