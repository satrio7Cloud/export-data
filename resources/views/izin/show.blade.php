@extends('layouts.app')

@section('title', 'Detail Izin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Izin</h2>

    <div class="card">
        <div class="card-header">
            Informasi Izin
        </div>
        <div class="card-body">
            {{-- <div class="form-group">
                <label>ID Izin:</label>
                <p class="form-control-plaintext">{{ $izin->id }}</p>
            </div> --}}
            <div class="form-group">
                <label>Nama Karyawan:</label>
                <p class="form-control-plaintext">{{ $izin->karyawan ? $izin->karyawan->nama : 'Karyawan tidak ditemukan' }}</p>
            </div>
            <div class="form-group">
                <label>Tanggal Izin:</label>
                <p class="form-control-plaintext">{{ $izin->tanggal }}</p>
            </div>
            <div class="form-group">
                <label>Alasan:</label>
                <p class="form-control-plaintext">{{ $izin->alasan }}</p>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('izin.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
