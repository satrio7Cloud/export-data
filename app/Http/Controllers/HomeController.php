<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
     // Menampilkan halaman utama setelah login
     public function index()
     {
         // Cek jika pengguna sudah login
         if (Auth::check()) {
             // Mengambil data pengguna yang sudah login
             $user = Auth::user();
             // Menampilkan halaman utama dengan data pengguna
             return view('home', compact('user'));
         } else {
             // Jika pengguna belum login, arahkan ke halaman login
             return redirect()->route('login');
         }
     }
}
