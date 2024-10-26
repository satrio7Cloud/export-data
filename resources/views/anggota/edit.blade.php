<!-- resources/views/anggota/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Anggota</h1>

    <form action="{{ route('anggota.update', $anggota->id_anggota) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="{{ $anggota->nama_lengkap }}" required>
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="L" {{ $anggota->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $anggota->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" class="form-control" value="{{ $anggota->tgl_lahir }}" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ $anggota->alamat }}" required>
        </div>
        <div class="form-group">
            <label>Kota</label>
            <input type="text" name="kota" class="form-control" value="{{ $anggota->kota }}" required>
        </div>
        <div class="form-group">
            <label>No Telp</label>
            <input type="text" name="notelp" class="form-control" value="{{ $anggota->notelp }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
