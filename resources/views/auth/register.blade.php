@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background: var(--bg);">
    <div class="card" style="width: 100%; max-width: 420px;">
        <div class="card-body p-4">
            <!-- Logo & Judul -->
            <div class="text-center mb-4">
                <div style="width:56px;height:56px;border-radius:12px;background:var(--primary);display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                    <i class="bi bi-mortarboard-fill" style="color:white;font-size:24px;"></i>
                </div>
                <h4 style="font-weight:700;color:var(--on-surface);">Daftar Akun</h4>
                <p style="font-size:13px;color:var(--on-surface-variant);">Registrasi untuk mahasiswa baru</p>
            </div>

            <!-- Form Register -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           placeholder="Masukkan nama lengkap"
                           value="{{ old('name') }}" autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" name="username_nim" class="form-control @error('username_nim') is-invalid @enderror"
                           placeholder="Masukkan NIM Anda"
                           value="{{ old('username_nim') }}">
                    @error('username_nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun Angkatan</label>
                    <input type="number" name="angkatan" class="form-control @error('angkatan') is-invalid @enderror"
                           placeholder="Contoh: 2023"
                           value="{{ old('angkatan', date('Y')) }}" min="2018" max="{{ date('Y') + 1 }}">
                    @error('angkatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimal 6 karakter">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="Ulangi password">
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-person-plus me-2"></i>Daftar
                    </button>
                </div>

                <div class="text-center">
                    <span style="font-size:13px;color:var(--on-surface-variant);">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" style="color:var(--primary);font-weight:600;text-decoration:none;">
                            Masuk di sini
                        </a>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
