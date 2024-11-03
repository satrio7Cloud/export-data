@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Cuti</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cuti.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_karyawan" class="form-label">Karyawan</label>
            <select class="form-select" id="id_karyawan" name="id_karyawan" required>
                <option value="">Pilih Karyawan</option>
                @foreach ($karyawans as $karyawan)
                    <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Cuti</button>
        <a href="{{ route('cuti.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
