@extends('layouts.app')

@section('title', 'Tambah Hari Libur')

@section('content')
    <h2>Tambah Hari Libur</h2>

    <!-- Form untuk menambah hari libur baru -->
    <form action="{{ route('libur.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_karyawan">Karyawan</label>
            <select name="id_karyawan" class="form-control" required>
                <option value="">Pilih Karyawan</option>
                @foreach($karyawan as $k) <!-- Gunakan $karyawan di sini -->
                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" placeholder="Misal: Libur Nasional" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('libur.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
