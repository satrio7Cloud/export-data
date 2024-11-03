@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<h2>Edit Karyawan</h2>
<form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" name="nama" class="form-control" value="{{ $karyawan->nama }}" required>
    </div>
    <div class="form-group">
        <label for="jabatan">Jabatan</label>
        <input type="text" name="jabatan" class="form-control" value="{{ $karyawan->jabatan }}" required>
    </div>
    <div class="form-group">
        <label for="tanggal_masuk">Tanggal Masuk</label>
        <input type="date" name="tanggal_masuk" class="form-control" value="{{ $karyawan->tanggal_masuk }}" required>
    </div>
    <div class="form-group">
        <label for="notelp">No Telepon</label>
        <input type="text" name="notelp" class="form-control" value="{{ $karyawan->notelp }}">
    </div>
    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
