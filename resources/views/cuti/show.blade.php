@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Cuti</h1>

    <div class="mb-3">
        <strong>ID:</strong> {{ $cuti->id }}
    </div>
    <div class="mb-3">
        <strong>Karyawan:</strong> {{ $cuti->karyawan->nama }}
    </div>
    <div class="mb-3">
        <strong>Tanggal Mulai:</strong> {{ $cuti->tanggal_mulai }}
    </div>
    <div class="mb-3">
        <strong>Tanggal Selesai:</strong> {{ $cuti->tanggal_selesai }}
    </div>

    <a href="{{ route('cuti.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
