@extends('layouts.app')

@section('title', 'Daftar Absensi')

@section('content')
<h2>Daftar Absensi - {{ date('F Y') }}</h2>


<!-- Tombol Tambah Data -->
<a href="{{ route('absensi.create') }}" class="btn btn-success mb-3">Tambah Data</a>

<table class="table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Karyawan</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Shift</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absensis as $absensi)
            <tr>
                <td>{{ $loop->iteration + ($absensis->currentPage() - 1) * $absensis->perPage() }}</td>
                <td>{{ $absensi->karyawan->nama ?? 'Tidak Ada' }}</td>
                <td>{{ $absensi->tanggal }}</td>
                <td>{{ $absensi->jam_masuk }}</td>
                <td>{{ $absensi->jam_pulang }}</td>
                <td>{{ $absensi->shift->shift_nama ?? '-' }}</td>
                <td>
                    <a href="{{ route('absensi.show', $absensi->id) }}" class="btn btn-info">Lihat</a>
                    <a href="{{ route('absensi.edit', $absensi->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('absensi.destroy', $absensi->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination Links -->
<div class="mt-3">
    {{ $absensis->links('vendor.pagination.bootstrap-5') }}
</div>
@endsection
