<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'nip' => 'required',
            'password' => 'required'
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.'
        ]);

        // Cek apakah login berhasil
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            session()->flash('loginSuccess', 'Selamat Datang ' . Auth::user()->nama . '!!');
            return redirect('/dashboard'); // Redirect tetap diperlukan untuk memuat session di Blade
        }

        // Jika login gagal
        return back()->with('loginError', 'Kode Operator atau password salah.');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
