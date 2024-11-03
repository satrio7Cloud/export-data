<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Karyawan;
use App\Models\Libur;
use App\Models\ShiftJadwal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ShiftJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shifts = ShiftJadwal::all();
        return view('shift.index', compact('shifts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawans = Karyawan::all(); // Ambil semua data karyawan
        // dd($karyawans);
        return view('shift.create', compact('karyawans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shift_nama' => 'required|string|max:255',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i',
            'id_karyawan' => 'required|integer|exists:karyawan,id',
            'hari' => 'required|string|max:255'
        ]);

        // Cek apakah hari tersebut adalah hari libur atau cuti
        $isLibur = Libur::where('tanggal', $request->hari)->exists(); // Ganti dengan logika yang sesuai
        $isCuti = Cuti::where('id_karyawan', $request->id_karyawan)
            ->where('tanggal_mulai', '<=', $request->hari)
            ->where('tanggal_selesai', '>=', $request->hari)
            ->exists();

        if ($isLibur || $isCuti) {
            return redirect()->back()->withErrors(['hari' => 'Karyawan tidak dapat dijadwalkan pada hari ini.']);
        }

        ShiftJadwal::create($request->all());

        return redirect()->route('shift.index')->with('success', 'Shift berhasil ditambahkan.');
    }
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();

        foreach ($worksheet->getRowIterator(2) as $row) {
            $cells = $row->getCellIterator();
            $cells->setIterateOnlyExistingCells(false);

            $data = [];
            foreach ($cells as $cell) {
                $data[] = $cell->getValue();
            }

            try {
                $idKaryawan = $data[0];
                $shiftNama = $data[1];
                
                if (!is_numeric($data[2])) {
                    throw new Exception("Invalid jam_masuk value: {$data[2]}");
                }
                $jamMasuk = Date::excelToDateTimeObject($data[2])->format('H:i');

                if (!is_numeric($data[3])) {
                    throw new Exception("Invalid jam_keluar value: {$data[3]}");
                }
                $jamKeluar = Date::excelToDateTimeObject($data[3])->format('H:i');

                if (!is_numeric($data[4])) {
                    throw new Exception("Invalid hari value: {$data[4]}");
                }
                $hari = Date::excelToDateTimeObject($data[4])->format('Y-m-d');

                // Cek apakah id_karyawan ada di tabel karyawan
                $karyawanExists = Karyawan::where('id', $idKaryawan)->exists();
                if (!$karyawanExists) {
                    throw new Exception("id_karyawan {$idKaryawan} tidak ditemukan di tabel karyawan.");
                }

                ShiftJadwal::create([
                    'id_karyawan' => $idKaryawan,
                    'shift_nama' => $shiftNama,
                    'jam_masuk' => $jamMasuk,
                    'jam_keluar' => $jamKeluar,
                    'hari' => $hari,
                ]);

            } catch (Exception $e) {
                Log::error("Error importing row: " . $e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data.');
            }
        }

        return redirect()->route('shift.index')->with('success', 'Data shift berhasil diimpor dari Excel.');
    }


    public function generatePDF()
    {
        $shifts = ShiftJadwal::all();
        $pdf = Pdf::loadView('shift_pdf', ['shifts' => $shifts]);

        return $pdf->download('shift_schedule.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $shift = ShiftJadwal::with('karyawan')->findOrFail($id); // Mengambil shift dan data karyawan terkait
        return view('shift.show', compact('shift'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $shift = ShiftJadwal::findOrFail($id);
        $karyawans = Karyawan::all(); // Ambil semua data karyawan
        return view('shift.edit', compact('shift', 'karyawans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'shift_nama' => 'required|string|max:255',  // Ganti 'nama_shift' menjadi 'shift_nama'
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i',  // Ubah 'jam_pulang' menjadi 'jam_keluar'
            'id_karyawan' => 'required|integer|exists:karyawan,id'
        ]);

        $shift = ShiftJadwal::findOrFail($id);
        $shift->update($request->all());

        return redirect()->route('shift.index')->with('success', 'Shift berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shift = ShiftJadwal::findOrFail($id);
        $shift->delete();

        return redirect()->route('shift.index')->with('success', 'Shift berhasil dihapus.');
    }
}
