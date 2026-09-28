<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ───────────────────────────────────────────── LOGIN ──────

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Step 1: check username exists
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'Username tidak terdaftar!'])->withInput();
        }

        // Step 2: verify password
        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return back()->withErrors(['password' => 'Password salah!'])->withInput();
        }

        $request->session()->regenerate();

        return redirect('/dashboard')->with('success', 'Selamat datang di WIKRAMA-ORBIT.');
    }

    // ─────────────────────────────────────────── REGISTER ─────

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate(
            [
                'name'     => 'required|min:3',
                'email'    => 'required|email|unique:users,email|regex:/@smkwikrama\.sch\.id$/',
                'username' => 'required|min:4|max:8|unique:users,username',
                'password' => 'required|min:8|max:15|confirmed',
            ],
            [
                'email.regex' => 'Email harus menggunakan domain @smkwikrama.sch.id',
            ]
        );

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => 'warga',
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    // ──────────────────────────────────────── CHANGE PASSWORD ──

    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_kini' => 'required|min:8|max:15',
            'password_baru' => 'required|min:8|max:15|confirmed',
        ]);

        if (!Hash::check($request->password_kini, Auth::user()->password)) {
            return back()->withErrors(['password_kini' => 'Password saat ini tidak sesuai!']);
        }

        $user = Auth::user();
        $user->password = Hash::make($request->password_baru);
        $user->save();

        return redirect('/dashboard')->with('success', 'Password berhasil diperbarui!');
    }

    // ──────────────────────────────────────────────── LOGOUT ───

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}
