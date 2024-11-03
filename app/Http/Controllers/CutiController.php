<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function index()
    {
        $cutis = Cuti::with('karyawan')->get(); // Mengambil semua data cuti beserta relasi karyawan
        return view('cuti.index', compact('cutis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawans = Karyawan::all(); // Mengambil semua karyawan
        return view('cuti.create', compact('karyawans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|integer|exists:karyawan,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        Cuti::create($request->all());

        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil ditambahkan.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $cuti = Cuti::with('karyawan')->findOrFail($id);
        return view('cuti.show', compact('cuti'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cuti = Cuti::findOrFail($id);
        $karyawans = Karyawan::all(); // Mengambil semua karyawan untuk dipilih
        return view('cuti.edit', compact('cuti', 'karyawans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required|integer|exists:karyawan,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $cuti = Cuti::findOrFail($id);
        $cuti->update($request->all());

        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cuti = Cuti::findOrFail($id);
        $cuti->delete();

        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil dihapus.');
    }
}
