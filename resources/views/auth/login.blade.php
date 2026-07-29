@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background: var(--bg);">
    <div class="card" style="width: 100%; max-width: 400px;">
        <div class="card-body p-4">
            <!-- Logo & Judul -->
            <div class="text-center mb-4">
                <div style="width:56px;height:56px;border-radius:12px;background:var(--primary);display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                    <i class="bi bi-mortarboard-fill" style="color:white;font-size:24px;"></i>
                </div>
                <h4 style="font-weight:700;color:var(--on-surface);">SpekTi</h4>
                <p style="font-size:13px;color:var(--on-surface-variant);">Sistem Prediksi Tiga Setengah Tahun</p>
            </div>

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">NIM / Username</label>
                    <input type="text" name="username_nim" class="form-control @error('username_nim') is-invalid @enderror"
                           placeholder="Masukkan NIM atau Username"
                           value="{{ old('username_nim') }}" autofocus>
                    @error('username_nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Masukkan password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </button>
                </div>

                <div class="text-center">
                    <span style="font-size:13px;color:var(--on-surface-variant);">
                        Belum punya akun?
                        <a href="{{ route('register') }}" style="color:var(--primary);font-weight:600;text-decoration:none;">
                            Daftar di sini
                        </a>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
