@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Status Kehadiran pada Tanggal: {{ $tanggal }}</h1>

    <h2>Karyawan yang sedang Cuti</h2>
    <ul>
        @forelse ($cutiKaryawan as $cuti)
            <li>{{ $cuti->karyawan->nama }} (Cuti dari {{ $cuti->tanggal_mulai }} hingga {{ $cuti->tanggal_selesai }})</li>
        @empty
            <li>Tidak ada karyawan yang cuti pada tanggal ini.</li>
        @endforelse
    </ul>

    <h2>Karyawan yang sedang Izin</h2>
    <ul>
        @forelse ($izinKaryawan as $izin)
            <li>{{ $izin->karyawan->nama }} (Izin pada {{ $izin->tanggal }})</li>
        @empty
            <li>Tidak ada karyawan yang izin pada tanggal ini.</li>
        @endforelse
    </ul>

    <h2>Hari Libur</h2>
    <p>
        @if ($liburKaryawan)
            Hari ini adalah hari libur.
        @else
            Hari ini bukan hari libur.
        @endif
    </p>
</div>
@endsection
