@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<h2>Tambah Karyawan</h2>
<form action="{{ route('karyawan.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="jabatan">Jabatan</label>
        <input type="text" name="jabatan" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="tanggal_masuk">Tanggal Masuk</label>
        <input type="date" name="tanggal_masuk" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="notelp">No Telepon</label>
        <input type="text" name="notelp" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
