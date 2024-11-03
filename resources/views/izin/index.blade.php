@extends('layouts.app')

@section('title', 'Daftar Izin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Daftar Izin</h2>
    <a href="{{ route('izin.create') }}" class="btn btn-primary">Tambah Izin</a>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Karyawan</th>
            <th>Tanggal Izin</th>
            <th>Alasan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($izins as $izin)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $izin->karyawan->nama ?? 'Tidak Diketahui' }}</td>
            <td>{{ $izin->tanggal }}</td>
            <td>{{ $izin->alasan }}</td>
            <td>
                <a href="{{ route('izin.edit', $izin->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('izin.destroy', $izin->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
                <a href="{{ route('izin.show', $izin->id) }}" class="btn btn-info">Detail</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
