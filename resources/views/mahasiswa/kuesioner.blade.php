@extends('layouts.app')

@section('title', $editMode ? 'Edit Kuesioner' : 'Kuesioner Prediksi')

@section('content')
<div class="page-header">
    <h1>{{ $editMode ? 'Edit Kuesioner' : 'Form Kuesioner' }}</h1>
    <p>
        @if($editMode)
            <span class="badge-success-custom" style="font-size:12px;">Mode Edit</span> Edit data kuesioner Anda. Perubahan akan memperbarui prediksi yang sudah ada (bukan prediksi baru).
        @else
            Pilih kondisi akademik Anda dan tentukan tingkat keyakinan untuk setiap variabel. Data akan dianalisis menggunakan metode Certainty Factor.
        @endif
    </p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('mahasiswa.prediksi') }}" id="kuesionerForm">
            @csrf

            @if($editMode)
                <div class="alert alert-warning mb-3" style="font-size:13px;">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Catatan:</strong> Data yang Anda edit akan <strong>memperbarui</strong> prediksi yang sudah ada (ID tetap sama). Admin telah menyetujui permintaan edit Anda.
                </div>
            @endif

            @foreach($variables as $varName => $varConfig)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:36px;height:36px;border-radius:8px;background:var(--primary-tint);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span style="color:var(--primary);font-weight:700;font-size:14px;">{{ $loop->iteration }}</span>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label" style="font-weight:600;color:var(--on-surface);font-size:14px;">
                                {{ $varConfig['label'] }}
                            </label>

                            {{-- Dropdown status variabel --}}
                            <select name="{{ $varName }}" class="form-select @error($varName) is-invalid @enderror mb-2" required>
                                <option value="">-- Pilih Kondisi --</option>
                                @foreach($varConfig['options'] as $value => $label)
                                    <option value="{{ $value }}" {{ old($varName, $lastVariable->{$varName} ?? '') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error($varName)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Dropdown CF User --}}
                            <div class="mt-2">
                                <label style="font-size:12px;color:var(--on-surface-variant);font-weight:400;line-height:1.4;margin-bottom:6px;">{{ $varConfig['description'] }}</label>
                                <select name="cf_{{ $varName }}" class="form-select form-select-sm @error('cf_'.$varName) is-invalid @enderror" required style="max-width:100%;">
                                    <option value="">-- Pilih Keyakinan --</option>
                                    @foreach($cfScale as $value => $label)
                                        <option value="{{ $value }}" {{ old('cf_'.$varName, $lastVariable && $lastVariable->answers->where('variable_name', $varName)->first() ? $lastVariable->answers->where('variable_name', $varName)->first()->cf_user : '') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <small style="color:var(--outline);font-size:11px;">Seberapa yakin Anda dengan kondisi di atas</small>
                                @error('cf_'.$varName)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Skala Referensi --}}
            <div class="card mb-3" style="background:var(--bg);border:1px dashed var(--outline-variant);">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-info-circle" style="color:var(--primary);"></i>
                        <span style="font-size:13px;font-weight:600;color:var(--on-surface);">Skala Keyakinan</span>
                    </div>
                    <div class="d-flex flex-wrap gap-3" style="font-size:12px;color:var(--on-surface-variant);">
                        <span><strong>SY</strong> = Sangat Yakin (1.0)</span>
                        <span><strong>Y</strong> = Yakin (0.8)</span>
                        <span><strong>C</strong> = Cukup Yakin (0.6)</span>
                        <span><strong>K</strong> = Kurang Yakin (0.4)</span>
                        <span><strong>TY</strong> = Tidak Yakin (0.2)</span>
                    </div>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="card mb-4">
                <div class="card-body text-center">
                    <p style="font-size:13px;color:var(--on-surface-variant);margin-bottom:1rem;">
                        <i class="bi bi-info-circle me-1"></i>
                        @if($editMode)
                            Data yang diubah akan langsung memperbarui prediksi Anda. Pastikan semua data sudah benar.
                        @else
                            Pastikan semua data yang dimasukkan sudah benar. Sistem akan memproses prediksi menggunakan 49 aturan Certainty Factor dari pakar.
                        @endif
                    </p>
                    <button type="submit" class="btn btn-primary-custom btn-lg px-5" id="submitBtn">
                        <i class="bi bi-calculator me-2"></i>{{ $editMode ? 'Simpan Perubahan & Hitung Ulang' : 'Proses Prediksi' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Loading state saat form dikirim
    document.getElementById('kuesionerForm').addEventListener('submit', function() {
        var btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
    });
</script>
@endpush
