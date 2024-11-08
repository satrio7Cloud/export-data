@extends('layouts.app')

@section('title', 'Daftar Shift')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Daftar Shift</h2>
    <a href="{{ route('shift.create') }}" class="btn btn-primary mb-3">Tambah Shift</a>

</div>


<!-- Tampilkan pesan sukses jika ada -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<div class="d-flex justify-content-end mb-4">
    <form action="{{ route('shift.import.excel') }}" method="POST" enctype="multipart/form-data" class="d-inline-flex align-items-center gap-2">
        @csrf
        <label for="excelFile" class="form-label mb-0">Import Excel:</label>
        <input type="file" name="file" id="excelFile" accept=".xlsx, .xls" required>
        <button type="submit" class="btn btn-success">Impor Excel</button>
    </form>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Nama Shift</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($shifts as $shift)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $shift->karyawan->nama }}</td>
                <td>{{ $shift->shift_nama }}</td>
                <td>{{ $shift->jam_masuk }}</td>
                <td>{{ $shift->jam_keluar }}</td>
                <td>
                    <a href="{{ route('shift.show', $shift->id) }}" class="btn btn-info">Lihat</a>
                    <a href="{{ route('shift.edit', $shift->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('shift.destroy', $shift->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus shift ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
