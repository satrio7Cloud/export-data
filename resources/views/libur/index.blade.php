@extends('layouts.app')

@section('title', 'Daftar Hari Libur')

@section('content')
    <h2>Daftar Hari Libur</h2>

    {{-- Tampilkan pesan sukses jika ada --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('libur.create') }}" class="btn btn-primary mb-3">Tambah Hari Libur</a>

    @if($liburs->isEmpty())
        <p>Tidak ada data hari libur.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($liburs as $index => $libur)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $libur->karyawan->nama ?? 'Tidak Ditemukan' }}</td>
                        <td>{{ $libur->tanggal }}</td>
                        <td>{{ $libur->keterangan }}</td>
                        <td>
                            <a href="{{ route('libur.show', $libur->id) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('libur.edit', $libur->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('libur.destroy', $libur->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- <a href="{{ route('libur.index') }}" class="btn btn-secondary">Kembali ke Halaman Utama</a> --}}
@endsection
