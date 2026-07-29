@extends('layouts.app')

@section('title', 'Tambah Rule')

@section('content')
<div class="page-header">
    <h1>Tambah Rule Baru</h1>
    <p>Tambah aturan IF-THEN baru ke Knowledge Base. Pilih CF Pakar langsung dari skala keyakinan.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.rules.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Kode Rule</label>
                        <input type="text" name="kode_rule" class="form-control @error('kode_rule') is-invalid @enderror"
                               value="{{ old('kode_rule', $nextCode) }}"
                               style="background:#f0f4ff;font-weight:600;color:var(--primary);">
                        @error('kode_rule')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Rule (IF-THEN)</label>
                        <textarea name="deskripsi_rule" class="form-control @error('deskripsi_rule') is-invalid @enderror"
                                  rows="3" placeholder="Contoh: IF IPK Tinggi AND Skripsi Lancar THEN Lulus 3,5 Tahun"
                                  required>{{ old('deskripsi_rule') }}</textarea>
                        @error('deskripsi_rule')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">CF Pakar (Tingkat Keyakinan)</label>
                            <select name="cf_pakar" class="form-select @error('cf_pakar') is-invalid @enderror" required>
                                <option value="">-- Pilih Keyakinan --</option>
                                @foreach($cfScale as $value => $label)
                                    <option value="{{ $value }}" {{ old('cf_pakar') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <small style="color:var(--outline);">Skala keyakinan pakar terhadap rule ini</small>
                            @error('cf_pakar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Prediksi</label>
                            <select name="status_prediksi" class="form-select @error('status_prediksi') is-invalid @enderror" required>
                                <option value="">-- Pilih --</option>
                                <option value="Lulus" {{ old('status_prediksi') == 'Lulus' ? 'selected' : '' }}>Lulus 3,5 Tahun</option>
                                <option value="Tidak Lulus" {{ old('status_prediksi') == 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus 3,5 Tahun</option>
                            </select>
                            @error('status_prediksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-check-lg me-2"></i>Simpan Rule
                        </button>
                        <a href="{{ route('admin.rules.index') }}" class="btn btn-outline-custom">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
