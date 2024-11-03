@extends('layouts.app')

@section('title', 'Tambah Absensi')

@section('content')
<h2>Tambah Absensi</h2>

<!-- Menampilkan pesan error jika ada -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('absensi.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="id_karyawan">Karyawan</label>
        <select name="id_karyawan" class="form-control" required>
            <option value="">Pilih Karyawan</option>
            @foreach($karyawan as $k)
                <option value="{{ $k->id }}">{{ $k->nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="shift_id">Pilih Shift</label>
        <select name="shift_id" id="shift_id" class="form-control" required>
            <option value="">Pilih Shift</option>
            @foreach($shifts as $shift)
                <option value="{{ $shift->id }}" {{ isset($absensi) && $absensi->shift_id == $shift->id ? 'selected' : '' }}>
                    {{ $shift->nama_shift }} ({{ $shift->jam_masuk }} - {{ $shift->jam_keluar }})
                </option>
            @endforeach
        </select>
    </div>
    

    <div class="form-group">
        <label for="jam_masuk">Jam Masuk</label>
        <input type="time" name="jam_masuk" class="form-control">
    </div>

    <div class="form-group">
        <label for="jam_pulang">Jam Pulang</label>
        <input type="time" name="jam_pulang" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
