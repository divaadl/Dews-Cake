<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /* ================= USER ================= */

    public function loginForm()
    {
        return view('auth.login');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan'
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 1️⃣ CEK EMAIL TERDAFTAR ATAU TIDAK
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Akun belum terdaftar. Silakan daftar terlebih dahulu.'
            ]);
        }

        // 2️⃣ CEK PASSWORD
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password yang kamu masukkan salah.'
            ]);
        }

        // 3️⃣ LOGIN
        Auth::guard('web')->login($user);

        // 4️⃣ USER TIDAK BOLEH MASUK ADMIN
        if ($user->role === 'admin') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Gunakan halaman login admin.'
            ]);
        }

        return redirect('/menu');
    }

    /* ================= ADMIN ================= */

    public function showAdminLogin()
    {
        return view('admin.login');
    }

    public function adminLogin(Request $request)
    {
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {

            if (Auth::guard('admin')->user()->role !== 'admin') {
                Auth::guard('admin')->logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan admin'
                ]);
            }

            return redirect('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah'
        ]);
    }

    /* ================= LOGOUT ================= */

    public function logout(Request $request)
    {
        $isAdmin = Auth::guard('admin')->check();
        
        // Log out from all guards to be safe
        Auth::guard('admin')->logout();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // If it was an admin logout FROM admin area, go to admin login
        // Otherwise (even if admin but on user side, or regular user), go to beranda
        if ($isAdmin && str_contains(url()->previous(), '/admin')) {
            return redirect('/admin/login');
        }

        return redirect()->route('beranda');
    }
}
