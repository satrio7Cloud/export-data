<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('karyawan.index', compact('karyawans'));
    }


    /**
     * Show the form for creating a new resource.
     */
    // menampilkan form untuk menambahkan karyawan
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:50',
            'tanggal_masuk' => 'required|date',
            'notelp' => 'nullable|string|max:15'
        ]);

        Karyawan::create($request->all());

        return redirect()->route('karyawan.index')->with('success', 'karyawan berhasil di tambahkan');
    }

    /**
     * Import Karyawan data from an Excel file.
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();

        foreach ($worksheet->getRowIterator(2) as $row) { // Start from row 2 to skip headers
            $cells = $row->getCellIterator();
            $cells->setIterateOnlyExistingCells(false);

            $data = [];
            foreach ($cells as $cell) {
                $data[] = $cell->getValue();
            }

            // Assuming columns in Excel match Karyawan fields (nama, jabatan, tanggal_masuk, notelp)
            Karyawan::create([
                'nama' => $data[0],
                'jabatan' => $data[1],
                'tanggal_masuk' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data[2]),
                'notelp' => $data[3],
            ]);
        }

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diimpor dari Excel.');
    }

    public function importPDF(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf'
        ]);

        $file = $request->file('file');
        $path = $file->storeAs('imports', $file->getClientOriginalName());

        // PDF parsing can be complex; generally, you would use additional tools like OCR
        // However, here we'll just save the PDF and notify the user
        // Parsing actual data from PDF would require a more specialized library or service

        return redirect()->route('karyawan.index')->with('success', 'File PDF berhasil diunggah, tetapi parsing belum didukung.');
    }

    /**
     * Display the specified resource.
     */
    // Menampilkan detail karyawan
    public function show($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('karyawan.show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('karyawan.edit', compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'notelp' => 'required|string|max:15'
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($request->all());

        return redirect()->route('karyawan.index')->with('success', 'karyawan berhasil di perbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'karyawan berhasil di hapus');
    }
}
