<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */// Menampilkan daftar izin
    public function index()
    {
        $izins = Izin::with('karyawan')->get();

        return view('izin.index', compact('izins'));
    }

    /**
     * Show the form for creating a new resource.
     */// Menampilkan form untuk menambah izin
    public function create()
    {
        $karyawan = Karyawan::all();
        return view('izin.create', compact('karyawan'));
    }

    /**
     * Store a newly created resource in storage.
     */// Menyimpan izin baru
    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date',
            'alasan' => 'required|string|max:255',
            'status' => 'required|in:pending,disetujui,ditolak'
        ]);

        // Ambil hanya data yang relevan untuk disimpan
        $data = $request->only(['id_karyawan', 'tanggal', 'alasan', 'status']);
        // Menyimpan izin baru
        Izin::create($data);
        // Izin::create($request->all());
        return redirect()->route('izin.index')->with('success', 'Izin Berhasil ditambahkan'); // Perbaiki 'izin.index' menjadi 'route('izin.index')'
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $izin = Izin::with('karyawan')->findOrFail($id);
        return view('izin.show', compact('izin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $izin = Izin::findOrFail($id);
        $karyawan = Karyawan::all();

        return view('izin.edit', compact('izin', 'karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date',
            'alasan' => 'required|string|max:255',
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        $izin = Izin::findOrFail($id);
        $izin->update($request->all());

        return redirect()->route('izin.index')->with('success', 'Izin berhasil di perbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $izin = Izin::findOrFail($id);
        $izin->delete();

        return redirect()->route('izin.index')->with('success', 'Izin berhasil di hapus');
    }
}
