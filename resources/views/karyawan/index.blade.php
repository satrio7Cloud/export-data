@extends('layouts.app')

@section('title', 'Daftar Karyawan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Daftar Karyawan</h2>
    <a href="{{ route('karyawan.create') }}" class="btn btn-primary">Tambah Karyawan</a>
</div>

<!-- Import Excel Form (aligned to the right) -->
<div class="d-flex justify-content-end mb-4">
    <form action="{{ route('karyawan.import.excel') }}" method="POST" enctype="multipart/form-data" class="d-inline-flex align-items-center gap-2">
        @csrf
        <label for="excelFile" class="form-label mb-0">Import Excel:</label>
        <input type="file" name="file" id="excelFile" accept=".xlsx, .xls" required>
        <button type="submit" class="btn btn-success">Impor Excel</button>
    </form>
</div>


<!-- Karyawan Table -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Tanggal Masuk</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($karyawans as $karyawan)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $karyawan->nama }}</td>
            <td>{{ $karyawan->jabatan }}</td>
            <td>{{ $karyawan->tanggal_masuk }}</td>
            <td>{{ $karyawan->notelp }}</td>
            <td>
                <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-warning">Edit</a>
                
                <!-- Delete Form -->
                <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
                
                <a href="{{ route('karyawan.show', $karyawan->id) }}" class="btn btn-info">Detail</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
