@extends('layouts.app')

@section('title', 'Detail Absensi')

@section('content')
<h2>Detail Absensi</h2>
<div class="card">
    <div class="card-header">
        <h5>Absensi untuk {{ $absensi->karyawan->nama }}</h5>
    </div>
    <div class="card-body">
        <p><strong>ID:</strong> {{ $absensi->id }}</p>
        <p><strong>Shift:</strong> {{ $absensi->shift->shift_nama }}</p>
        <p><strong>Tanggal:</strong> {{ $absensi->tanggal }}</p>
        <p><strong>Jam Masuk:</strong> {{ $absensi->jam_masuk }}</p>
        <p><strong>Jam Pulang:</strong> {{ $absensi->jam_pulang }}</p>
    </div>
    <div class="card-footer">
        <a href="{{ route('absensi.edit', $absensi->id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
