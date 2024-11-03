<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\DataAnggota;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


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

    public function exportExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header row
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nama Lengkap');
        $sheet->setCellValue('C1', 'Jenis Kelamin');
        $sheet->setCellValue('D1', 'Tanggal Lahir');
        $sheet->setCellValue('E1', 'Alamat');
        $sheet->setCellValue('F1', 'Kota');
        $sheet->setCellValue('G1', 'No Telp');
        $sheet->setCellValue('H1', 'Aktif');

        // Retrieve data
        $anggota = DataAnggota::all();
        $row = 2;

        foreach ($anggota as $data) {
            $sheet->setCellValue("A{$row}", $data->id);
            $sheet->setCellValue("B{$row}", $data->nama_lengkap);
            $sheet->setCellValue("C{$row}", $data->jenis_kelamin);
            $sheet->setCellValue("D{$row}", $data->tgl_lahir);
            $sheet->setCellValue("E{$row}", $data->alamat);
            $sheet->setCellValue("F{$row}", $data->kota);
            $sheet->setCellValue("G{$row}", $data->notelp);
            $sheet->setCellValue("H{$row}", $data->aktif ? 'Yes' : 'No');
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'data_anggota.xlsx';

        // Store file temporarily in storage
        $filePath = 'exports/' . $fileName;
        Storage::disk('local')->put($filePath, '');
        $writer->save(storage_path("app/{$filePath}"));

        return response()->download(storage_path("app/{$filePath}"))->deleteFileAfterSend(true);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        foreach ($rows as $index => $row) {
            if ($index == 0) continue; // Skip header row

            // Check if record with the same 'id' exists
            $existingRecord = DataAnggota::find($row[0]);
            if (!$existingRecord) {
                // Only create a new record if it doesn't already exist
                DataAnggota::create([
                    'id' => $row[0], // Ensure the 'id' column is fillable in your model
                    'nama_lengkap' => $row[1],
                    'jenis_kelamin' => $row[2],
                    'tgl_lahir' => $row[3],
                    'alamat' => $row[4],
                    'kota' => $row[5],
                    'notelp' => $row[6],
                    'aktif' => $row[7] === 'Yes' ? true : false,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data anggota berhasil diimpor.');
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

    public function edit($id)
    {
        $anggota = DataAnggota::findOrFail($id);
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
