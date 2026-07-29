@extends('layouts.app')

@section('title', 'Edit Rule ' . $rule->kode_rule)

@section('content')
<div class="page-header">
    <h1>Edit Rule {{ $rule->kode_rule }}</h1>
    <p>Perbarui aturan IF-THEN pada Knowledge Base.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.rules.update', $rule->id) }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Kode Rule</label>
                        <input type="text" class="form-control" value="{{ $rule->kode_rule }}" readonly
                               style="background:#f0f4ff;font-weight:600;color:var(--primary);">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Rule (IF-THEN)</label>
                        <textarea name="deskripsi_rule" class="form-control @error('deskripsi_rule') is-invalid @enderror"
                                  rows="3" required>{{ old('deskripsi_rule', $rule->deskripsi_rule) }}</textarea>
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
                                    <option value="{{ $value }}" {{ old('cf_pakar', number_format($rule->cf_pakar, 1)) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cf_pakar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Prediksi</label>
                            <select name="status_prediksi" class="form-select @error('status_prediksi') is-invalid @enderror" required>
                                <option value="Lulus" {{ old('status_prediksi', $rule->status_prediksi) == 'Lulus' ? 'selected' : '' }}>Lulus 3,5 Tahun</option>
                                <option value="Tidak Lulus" {{ old('status_prediksi', $rule->status_prediksi) == 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus 3,5 Tahun</option>
                            </select>
                            @error('status_prediksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-check-lg me-2"></i>Perbarui Rule
                        </button>
                        <a href="{{ route('admin.rules.index') }}" class="btn btn-outline-custom">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
