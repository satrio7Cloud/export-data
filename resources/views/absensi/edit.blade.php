@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<h2>Edit Absensi</h2>

<form action="{{ route('absensi.update', $absensi->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="id_karyawan">Karyawan</label>
        <select name="id_karyawan" class="form-control" required>
            <option value="">Pilih Karyawan</option>
            @foreach($karyawan as $k)
                <option value="{{ $k->id }}" {{ $k->id == $absensi->id_karyawan ? 'selected' : '' }}>
                    {{ $k->nama }}
                </option>
            @endforeach
        </select>
        @error('id_karyawan')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $absensi->tanggal) }}" required>
        @error('tanggal')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="jam_masuk">Jam Masuk</label>
        <input type="time" name="jam_masuk" class="form-control" value="{{ old('jam_masuk', $absensi->jam_masuk) }}">
    </div>
    
    <div class="form-group">
        <label for="jam_pulang">Jam Pulang</label>
        <input type="time" name="jam_pulang" class="form-control" value="{{ old('jam_pulang', $absensi->jam_pulang) }}">
    </div>    

    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
