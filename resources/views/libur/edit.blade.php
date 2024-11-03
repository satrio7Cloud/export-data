@extends('layouts.app')

@section('title', 'Edit Hari Libur')

@section('content')
    <h2>Edit Hari Libur</h2>

    <!-- Form untuk mengedit hari libur -->
    <form action="{{ route('libur.update', $libur->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $libur->tanggal }}" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="{{ $libur->keterangan }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('libur.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
