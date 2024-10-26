<?php

namespace App\Http\Controllers;

use App\Exports\AnggotaExport;
use App\Imports\AnggotaImport;
use App\Models\DataAnggota;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class DataAnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Menampilkan semua anggota
    public function index()
    {
        $anggota = DataAnggota::all();

        return view('anggota.index', compact('anggota'));
    }

    public function collection()
    {
        return DataAnggota::all();
    }

    // for export pdf or download per 1 data
    public function print($id)
    {
        $anggota = DataAnggota::findOrFail($id);
        $pdf = Pdf::loadView('anggota.pdf', compact('anggota'));

        return $pdf->download('anggota-' . $anggota->nama_lengakp . '.pdf');
    }

    // Metode untuk mengekspor data anggota ke file Excel
    public function exportExcel()
    {
        return Excel::download(new AnggotaExport, 'data_anggota.xlsx');
    }

    // Metode untuk mengimpor data anggota dari file Excel
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new AnggotaImport, $request->file('file'));

        return redirect()->back()->with('Success', 'Data anggota berhasil di impor.');
    }

    public function create()
    {
        return view('anggota.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // Menyimpan data anggota baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => "required|date",
            'alamat' => 'required|string',
            'kota' => 'required|string',
            'notelp' => 'required|string',
            'aktif' => 'boolean'
        ]);

        $anggota = DataAnggota::create($request->all());

        return redirect()->route('anggota.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $anggota = DataAnggota::findOrFail($id);

        return view('anggota.show', compact('anggota'));
    }

    public function edit($id_anggota)
    {
        $anggota = DataAnggota::findOrFail($id_anggota);
        return view('anggota.edit', compact('anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $anggota = DataAnggota::findOrFail($id);
        $anggota->update($request->all());

        return redirect()->route('anggota.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggota = DataAnggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggota.index');
    }
}
