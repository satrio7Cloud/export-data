@extends('layouts.app')

@section('title', 'Tambah Izin')

@section('content')
<h2>Tambah Izin</h2>
<form action="{{ route('izin.store') }}" method="POST">
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
        <label for="tanggal">Tanggal Izin</label>
        <input type="date" name="tanggal" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="alasan">Alasan</label>
        <textarea name="alasan" class="form-control" required></textarea>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" class="form-control" required>
            <option value="pending">Pending</option>
            <option value="disetujui">Disetujui</option>
            <option value="ditolak">Ditolak</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('izin.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
