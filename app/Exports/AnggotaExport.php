<?php

namespace App\Exports;

use App\Models\Anggota;
use App\Models\DataAnggota;
use Maatwebsite\Excel\Concerns\FromCollection;

class AnggotaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DataAnggota::all();
    }
}
