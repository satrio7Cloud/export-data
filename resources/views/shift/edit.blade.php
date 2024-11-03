@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Shift</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('shift.update', $shift->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="shift_nama" class="form-label">Nama Shift</label>
            <input type="text" class="form-control" id="shift_nama" name="shift_nama" value="{{ $shift->shift_nama }}" required>
        </div>

        <div class="mb-3">
            <label for="jam_masuk" class="form-label">Jam Masuk</label>
            <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" value="{{ $shift->jam_masuk }}" required>
        </div>

        <div class="mb-3">
            <label for="jam_keluar" class="form-label">Jam Keluar</label>
            <input type="time" class="form-control" id="jam_keluar" name="jam_keluar" value="{{ $shift->jam_keluar }}" required>
        </div>

        <select class="form-select mb-3" id="id_karyawan" name="id_karyawan" required>
            <option value="">Pilih Karyawan</option>
            @foreach($karyawans as $karyawan)
                <option value="{{ $karyawan->id }}" {{ $karyawan->id == $shift->id_karyawan ? 'selected' : '' }}>
                    {{ $karyawan->nama }}
                </option>
            @endforeach
        </select>

        <div class="mb-3">
            <label for="hari" class="form-label">Hari</label>
            <input type="date" class="form-control" id="hari" name="hari" value="{{ $shift->hari }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Shift</button>
        <a href="{{ route('shift.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
