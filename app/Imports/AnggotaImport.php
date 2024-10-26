<?php

namespace App\Imports;

use App\Models\DataAnggota;
use Maatwebsite\Excel\Concerns\ToModel;

class AnggotaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DataAnggota([
            'nama_lengkap'   => $row[0], // Kolom Nama Lengkap
            'jenis_kelamin'  => $row[1], // Kolom Jenis Kelamin
            'tgl_lahir'      => \Carbon\Carbon::parse($row[2]), // Kolom Tanggal Lahir
            'alamat'         => $row[3], // Kolom Alamat
            'kota'           => $row[4], // Kolom Kota
            'notelp'         => $row[5], // Kolom No Telepon
            'aktif'          => $row[6], // Kolom Status Aktif
        ]);
    }
}
