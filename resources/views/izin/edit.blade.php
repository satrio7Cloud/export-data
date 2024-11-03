@extends('layouts.app')

@section('title', 'Edit Izin')

@section('content')
<h2>Edit Izin</h2>
<form action="{{ route('izin.update', $izin->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label for="id_karyawan">Karyawan</label>
        <select name="id_karyawan" class="form-control" required>
            <option value="">Pilih Karyawan</option>
            @foreach($karyawan as $k)
                <option value="{{ $k->id }}" {{ $k->id == $izin->id_karyawan ? 'selected' : '' }}>
                    {{ $k->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="tanggal">Tanggal Izin</label>
        <input type="date" name="tanggal" class="form-control" value="{{ $izin->tanggal }}" required>
    </div>

    <div class="form-group">
        <label for="alasan">Alasan</label>
        <textarea name="alasan" class="form-control" required>{{ $izin->alasan }}</textarea>
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('izin.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
