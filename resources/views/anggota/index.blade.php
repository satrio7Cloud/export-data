<!-- resources/views/anggota/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-5 text-primary">Daftar Anggota</h1>
            {{-- {{-- <div> --}}
            <a href="{{ route('anggota.create') }}" class="btn btn-success shadow-sm">+ Tambah Anggota</a>
            <a href="{{ route('anggota.exportExcel') }}" class="btn btn-success shadow-sm">Ekspor Excel</a>
            <form action="{{ route('anggota.importExcel') }}" method="POST" enctype="multipart/form-data"
                style="display:inline-block;">
                @csrf
                <input type="file" name="file" class="form-control-file" required
                    onchange="document.getElementById('file-name').textContent = this.files[0].name;">
                <small id="file-format-info" class="form-text text-muted">Format: .xlsx, .csv, atau .xls (Maks 5MB)</small>
                <span id="file-name" class="text-muted"></span>
                <button type="submit" class="btn btn-warning shadow-sm mt-2">Impor Excel</button>
            </form>

            <div id="loader" style="display:none;">Loading...</div>

            <script>
                function showLoader() {
                    document.getElementById('loader').style.display = 'block';
                    document.getElementById('import-form').style.display = 'none'; // Menyembunyikan form
                }
            </script>

        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Anggota Table -->
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered shadow-sm">
            <thead class="thead-dark">
                <tr>
                    {{-- <th>No.</th> --}}
                    <th>Nama Lengkap</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Kota</th>
                    <th>No Telp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($anggota as $data)
                    <tr>
                        {{-- <td>{{ $loop->iteration }}</td> --}}
                        <td>{{ $data->nama_lengkap }}</td>
                        <td>{{ $data->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->tgl_lahir)->format('d M Y') }}</td>
                        <td>{{ $data->alamat }}</td>
                        <td>{{ $data->kota }}</td>
                        <td>{{ $data->notelp }}</td>
                        <td>
                            <a href="{{ route('anggota.edit', $data->id) }}"
                                class="btn btn-warning btn-sm text-white mr-1">Edit</a>
                            <a href="{{ route('anggota.print', $data->id) }}" class="btn btn-info btn-sm text-white">Cetak
                                PDF</a>
                            <form action="{{ route('anggota.destroy', $data->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endsection
