@extends('layouts.app')

@section('title', 'Edit ' . $mahasiswa->name)

@section('content')
<div class="page-header">
    <h1>Edit Data Mahasiswa</h1>
    <p>Perbarui data akun mahasiswa {{ $mahasiswa->name }}.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $mahasiswa->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIM (Username)</label>
                        <input type="text" name="username_nim" class="form-control @error('username_nim') is-invalid @enderror"
                               value="{{ old('username_nim', $mahasiswa->username_nim) }}" required>
                        @error('username_nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tahun Angkatan</label>
                        <input type="number" name="angkatan" class="form-control @error('angkatan') is-invalid @enderror"
                               value="{{ old('angkatan', $mahasiswa->angkatan) }}" min="2018" max="{{ date('Y') + 1 }}" required>
                        @error('angkatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Password Baru <small style="color:var(--outline);">(kosongkan jika tidak diubah)</small></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   minlength="6">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-check-lg me-2"></i>Perbarui Data
                        </button>
                        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-custom">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
