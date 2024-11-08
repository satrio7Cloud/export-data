@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Selamat datang, {{ $user->name }}!</h1>
        <p>Ini adalah halaman utama dari Absensi karyawan.</p>
        <p>Email: {{ $user->email }}</p>
        {{-- <p>Peran: {{ $user->role }}</p> --}}
    </div>
@endsection
