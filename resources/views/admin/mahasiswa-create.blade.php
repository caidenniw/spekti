@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')
<div class="page-header">
    <h1>Tambah Mahasiswa Baru</h1>
    <p>Buat akun mahasiswa baru untuk mengakses sistem prediksi.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.mahasiswa.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="Contoh: Andi Pratama" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIM (Username)</label>
                        <input type="text" name="username_nim" class="form-control @error('username_nim') is-invalid @enderror"
                               value="{{ old('username_nim') }}" placeholder="Contoh: 2024001" required>
                        <small style="color:var(--outline);">NIM digunakan sebagai username untuk login</small>
                        @error('username_nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tahun Angkatan</label>
                        <input type="number" name="angkatan" class="form-control @error('angkatan') is-invalid @enderror"
                               value="{{ old('angkatan') }}" min="2018" max="{{ date('Y') + 1 }}" placeholder="Contoh: 2024" required>
                        @error('angkatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   minlength="6" required>
                            <small style="color:var(--outline);">Minimal 6 karakter</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-check-lg me-2"></i>Simpan Mahasiswa
                        </button>
                        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-custom">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
