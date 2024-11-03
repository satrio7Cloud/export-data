@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Cuti</h1>
    <a href="{{ route('cuti.create') }}" class="btn btn-primary mb-3">Tambah Cuti</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Karyawan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cutis as $cuti)
                <tr>
                    <td>{{ $cuti->id }}</td>
                    <td>{{ $cuti->karyawan->nama }}</td>
                    <td>{{ $cuti->tanggal_mulai }}</td>
                    <td>{{ $cuti->tanggal_selesai }}</td>
                    <td>
                        <a href="{{ route('cuti.show', $cuti->id) }}" class="btn btn-info">Lihat</a>
                        <a href="{{ route('cuti.edit', $cuti->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('cuti.destroy', $cuti->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
