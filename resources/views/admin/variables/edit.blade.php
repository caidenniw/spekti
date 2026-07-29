@extends('layouts.app')

@section('title', 'Edit Variabel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 style="font-size:24px;font-weight:700;">Edit Variabel</h1>
        <p style="font-size:14px;color:var(--on-surface-variant);">Perbarui data variabel penelitian.</p>
    </div>
    <a href="{{ route('admin.variables.index') }}" class="btn btn-outline-custom">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('admin.variables.update', $variable->id) }}">
            @csrf
            @method('PUT')

            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2" style="color:var(--primary);"></i>Informasi Variabel
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;">Nama Variabel</label>
                        <input type="text" name="label" class="form-control @error('label') is-invalid @enderror"
                               value="{{ old('label', $variable->label) }}" required>
                        @error('label')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small style="color:var(--outline);">Nama yang ditampilkan di kuesioner mahasiswa.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;">Kode Variabel</label>
                        <input type="text" name="variable_name" class="form-control @error('variable_name') is-invalid @enderror"
                               value="{{ old('variable_name', $variable->variable_name) }}" required pattern="[a-z_]+">
                        @error('variable_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small style="color:var(--outline);">Kode unik (huruf kecil & underscore). Digunakan sistem untuk identifikasi.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;">Urutan</label>
                        <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror"
                               value="{{ old('urutan', $variable->urutan) }}" min="1" required style="max-width:100px;">
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-toggle-on me-2" style="color:var(--primary);"></i>Opsi Jawaban
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight:600;color:var(--success-text);">
                                <i class="bi bi-check-circle me-1"></i>Opsi Positif
                            </label>
                            <input type="text" name="positif_value" class="form-control @error('positif_value') is-invalid @enderror mb-2"
                                   value="{{ old('positif_value', $variable->positif_value) }}" required>
                            @error('positif_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <input type="text" name="positif_label" class="form-control @error('positif_label') is-invalid @enderror"
                                   value="{{ old('positif_label', $variable->positif_label) }}" required>
                            @error('positif_label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight:600;color:var(--danger-text);">
                                <i class="bi bi-x-circle me-1"></i>Opsi Negatif
                            </label>
                            <input type="text" name="negatif_value" class="form-control @error('negatif_value') is-invalid @enderror mb-2"
                                   value="{{ old('negatif_value', $variable->negatif_value) }}" required>
                            @error('negatif_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <input type="text" name="negatif_label" class="form-control @error('negatif_label') is-invalid @enderror"
                                   value="{{ old('negatif_label', $variable->negatif_label) }}" required>
                            @error('negatif_label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('admin.variables.index') }}" class="btn btn-outline-custom">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
