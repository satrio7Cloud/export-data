<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menampilkan form registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Melakukan login dan menghasilkan token JWT
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Login sukses, redirect ke halaman yang diinginkan
            return redirect()->intended('/home');
        }

        // Login gagal, kembali dengan pesan error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Melakukan registrasi dan menghasilkan token JWT
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Menyimpan user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // Generate token JWT untuk user yang baru dibuat
            JWTAuth::fromUser($user);

            // Menambahkan pesan sukses ke session
            session()->flash('success', 'Akun berhasil dibuat!');

            return redirect()->route('login'); // Redirect ke halaman login
        } catch (\Exception $e) {
            // Jika ada error, tampilkan pesan error
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    // Melakukan logout
    public function logout(Request $request)
    {
        Auth::logout();  // Logout pengguna
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');  // Redirect ke halaman utama setelah logout
    }
}
