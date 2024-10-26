<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAnggota extends Model
{
    use HasFactory;

    protected $table = 'tbl_anggota';

    protected $primaryKey = 'id_anggota';

    protected $timestamp = true;

    protected $fillable = [
        'nama_lengkap',
        'jenis_kelamin',
        'tgl_lahir',
        'alamat',
        'kota',
        'notelp',
        'aktif',
    ];
}
