<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.login');
    }

    /**
     * Proses login menggunakan NIM/username + password.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username_nim' => 'required|string',
            'password' => 'required|string',
        ], [
            'username_nim.required' => 'NIM/Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Cari user berdasarkan username_nim
        $user = User::where('username_nim', $request->username_nim)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'username_nim' => 'NIM atau Password salah.',
            ])->onlyInput('username_nim');
        }

        Auth::login($user);

        return $this->redirectByRole();
    }

    /**
     * Tampilkan form register (khusus mahasiswa).
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi mahasiswa baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username_nim' => 'required|string|unique:users,username_nim',
            'angkatan' => 'required|integer|min:2018|max:' . (date('Y') + 1),
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username_nim.required' => 'NIM wajib diisi.',
            'username_nim.unique' => 'NIM sudah terdaftar.',
            'angkatan.required' => 'Tahun angkatan wajib diisi.',
            'angkatan.min' => 'Tahun angkatan minimal 2018.',
            'angkatan.max' => 'Tahun angkatan maksimal ' . (date('Y') + 1) . '.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Buat akun mahasiswa baru
        $user = User::create([
            'name' => $request->name,
            'role' => 'mahasiswa',
            'username_nim' => $request->username_nim,
            'angkatan' => $request->angkatan,
            'password' => Hash::make($request->password),
        ]);

        // Langsung login setelah register
        Auth::login($user);

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name);
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Redirect ke dashboard berdasarkan role user.
     */
    private function redirectByRole()
    {
        $role = Auth::user()->role;

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            default => redirect()->route('login'),
        };
    }
}
