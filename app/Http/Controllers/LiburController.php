<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Libur;
use Illuminate\Http\Request;

class LiburController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $liburs = Libur::with('karyawan')->get();

        return view('libur.index', compact('liburs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('libur.create', compact('karyawan'));

        // Ambil semua data karyawan
        $karyawan = Karyawan::all(); // Pastikan ini adalah Karyawan bukan karyawans

        // Kirim data karyawan ke view
        return view('libur.create', compact('karyawan')); // Perbaiki di sini
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date|unique:libur,tanggal',
            'keterangan' => 'required|string|max:255',
        ]);

        Libur::create($request->all());

        return redirect()->route('libur.index')->with('success', 'Data libur berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //  ambil data libur berdasarkan ID
        $libur = Libur::findOrFail($id);

        return view('libur.show', compact('libur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // tampilkan form for edit 
        $libur = Libur::findOrFail($id);

        return view('libur.edit', compact('libur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date|unique:libur,tanggal' . $id,
            'keterangan' => 'required|string|max:255'
        ]);

        Libur::create($request->all());

        return redirect()->route('libur.index')->with('success', 'data libur berhasil di perbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $libur = Libur::findOrFail($id);
        $libur->delete();

        return redirect()->route('libur.index')->with('success', 'data libur berhasil di hapus');
    }
}
