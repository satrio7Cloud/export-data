@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<h2>Detail Karyawan</h2>
<div class="card">
    <div class="card-header">
        <h5>{{ $karyawan->nama }}</h5>
    </div>
    <div class="card-body">
        <p><strong>ID:</strong> {{ $karyawan->id }}</p>
        <p><strong>Jabatan:</strong> {{ $karyawan->jabatan }}</p>
        <p><strong>Tanggal Masuk:</strong> {{ $karyawan->tanggal_masuk }}</p>
        <p><strong>No Telepon:</strong> {{ $karyawan->notelp }}</p>
    </div>
    <div class="card-footer">
        <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
