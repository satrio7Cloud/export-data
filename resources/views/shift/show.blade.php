@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Shift</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Nama Shift: {{ $shift->shift_nama }}</h5>
            <p class="card-text"><strong>Jam Masuk:</strong> {{ $shift->jam_masuk }}</p>
            <p class="card-text"><strong>Jam Keluar:</strong> {{ $shift->jam_keluar }}</p>
            <p class="card-text"><strong>Karyawan:</strong> {{ $shift->karyawan->nama }}</p>
            <p class="card-text"><strong>Hari:</strong> {{ $shift->hari }}</p>
            <p class="card-text"><strong>Dibuat pada:</strong> {{ $shift->created_at }}</p>
            <p class="card-text"><strong>Diperbarui pada:</strong> {{ $shift->updated_at }}</p>
        </div>
    </div>

    <a href="{{ route('shift.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Shift</a>
</div>
@endsection
