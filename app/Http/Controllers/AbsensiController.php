<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Karyawan;
use App\Models\Libur;
use App\Models\ShiftJadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */ // Menampilkan daftar absensi
    public function index()
    {
        // $absensis = Absensi::with('karyawan')->get(); // Mengambil semua absensi beserta data karyawan
        $absensis = Absensi::with('karyawan', 'shift')->paginate(10); // Mengambil semua absensi beserta data karyawan

        return view('absensi.index', compact('absensis'));
    }


    /**
     * Show the form for creating a new resource.
     */ // Menampilkan form untuk menambah absensi
    public function create()
    {
        $karyawan = Karyawan::all(); // Mengambil semua data karyawan
        $shifts = ShiftJadwal::all();

        return view('absensi.create', compact('karyawan', 'shifts'));
    }

    /**
     * Store a newly created resource in storage.
     */ // Menyimpan absensi baru
    // public function store(Request $request)
    // {
    //     Log::info($request->all());
    //     $request->validate([
    //         'id_karyawan' => 'required|exists:karyawan,id',
    //         'tanggal' => 'required|date',
    //         'jam_masuk' => 'nullable|date_format:H:i',
    //         'jam_pulang' => 'nullable|date_format:H:i',
    //         'shift_id' => 'required|exists:shift_jadwal,id'
    //     ]);

    //     // Cek apakah karyawan sedang cuti
    //     $isCuti = Cuti::where('id_karyawan', $request->id_karyawan)
    //         ->where('tanggal_mulai', '<=', $request->tanggal)
    //         ->where('tanggal_selesai', '>=', $request->tanggal)
    //         ->exists();

    //     // Cek apakah hari tersebut adalah hari libur
    //     $isLibur = Libur::where('tanggal', $request->tanggal)->exists();

    //     // Cek apakah karyawan memiliki izin pada tanggal yang sama
    //     $isIzin = Izin::where('id_karyawan', $request->id_karyawan)
    //         ->where('tanggal', $request->tanggal)
    //         ->exists();

    //     // Mengatur error messages
    //     $errors = [];

    //     if ($isCuti) {
    //         $errors['tanggal'] = 'Karyawan tidak dapat melakukan absensi pada hari ini karena sedang cuti.';
    //     }

    //     if ($isLibur) {
    //         $errors['tanggal'] = 'Karyawan tidak dapat melakukan absensi pada hari ini karena hari ini adalah hari libur.';
    //     }

    //     if ($isIzin) {
    //         $errors['tanggal'] = 'Karyawan tidak dapat melakukan absensi pada hari ini karena memiliki izin.';
    //     }

    //     // Jika ada error, kembalikan dengan error messages
    //     if (!empty($errors)) {
    //         return redirect()->back()->withErrors($errors);
    //     }

    //     // // Jika karyawan cuti atau hari libur, tampilkan error
    //     // if ($isCuti || $isLibur || $isIzin) {
    //     //     return redirect()->back()->withErrors(['tanggal' => 'Karyawan tidak dapat melakukan absensi pada hari ini (cuti/libur).']);
    //     // }


    //     Absensi::create($request->all());
    //     return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dibuat');
    // }

    public function store(Request $request)
    {
        Log::info($request->all());
    
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
            'shift_id' => 'required|exists:shift_jadwal,id'
        ]);
    
        $karyawanId = $request->id_karyawan;
        $tanggal = $request->tanggal;
    
        // Check if the employee is on leave on the given date
        $isCuti = Cuti::where('id_karyawan', $karyawanId)
            ->where('tanggal_mulai', '<=', $tanggal)
            ->where('tanggal_selesai', '>=', $tanggal)
            ->exists();
    
        // Check if the given date is a global holiday or a holiday for this employee
        $isLibur = Libur::where('tanggal', $tanggal)
            ->where(function ($query) use ($karyawanId) {
                $query->whereNull('id_karyawan')
                      ->orWhere('id_karyawan', $karyawanId);
            })
            ->exists();
    
        // Check if the employee has permission on the given date
        $isIzin = Izin::where('id_karyawan', $karyawanId)
            ->where('tanggal', $tanggal)
            ->exists();
    
        // Prepare error messages if necessary
        $errors = [];
        
        if ($isCuti) {
            $errors['tanggal'] = 'Karyawan tidak dapat melakukan absensi pada hari ini karena sedang cuti.';
        }
        
        if ($isLibur) {
            $errors['tanggal'] = 'Karyawan tidak dapat melakukan absensi pada hari ini karena hari ini adalah hari libur.';
        }
        
        if ($isIzin) {
            $errors['tanggal'] = 'Karyawan tidak dapat melakukan absensi pada hari ini karena memiliki izin.';
        }
    
        // Return with error messages if any condition is met
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }
    
        // If all conditions pass, proceed to create the attendance record
        Absensi::create($request->all());
        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */ // Menampilkan detail absensi
    public function show($id)
    {

        $absensi = Absensi::findOrFail($id);
        return view('absensi.show', compact('absensi'));
    }

    /**
     * Show the form for editing the specified resource.
     */ // Menampilkan form untuk mengedit absensi
    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        $karyawan = Karyawan::all();

        return view('absensi.edit', compact('absensi', 'karyawan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi hanya pada field yang diisi
        $request->validate([
            'id_karyawan' => 'nullable|exists:karyawan,id',
            'tanggal' => 'nullable|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
            'shift_id' => 'nullable|exists:shift_jadwal,id'
        ]);

        $absensi = Absensi::findOrFail($id);

        // Update field yang diisi
        if ($request->has('id_karyawan')) {
            $absensi->id_karyawan = $request->id_karyawan;
        }

        if ($request->has('tanggal')) {
            $absensi->tanggal = $request->tanggal;
        }

        if ($request->has('jam_masuk')) {
            $absensi->jam_masuk = $request->jam_masuk;
        }

        if ($request->has('jam_pulang')) {
            $absensi->jam_pulang = $request->jam_pulang;
        }

        if ($request->has('shift_id')) {
            $absensi->shift_id = $request->shift_id; // Menambahkan update untuk shift_id
        }

        $absensi->save();

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil di hapus');
    }
}
