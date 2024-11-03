@extends('layouts.app')

@section('title', 'Detail Hari Libur')

@section('content')
    <h2>Detail Hari Libur</h2>

    <!-- Menampilkan detail hari libur -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tanggal: {{ $libur->tanggal }}</h5>
            <p class="card-text">Keterangan: {{ $libur->keterangan }}</p>
        </div>
    </div>

    <a href="{{ route('libur.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
