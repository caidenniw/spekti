@extends('layouts.app')

@section('title', 'Hasil Prediksi')

@section('content')
<div class="page-header">
    <h1>Hasil Prediksi</h1>
    <p>Hasil analisis Certainty Factor berdasarkan data kuesioner Anda.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        {{-- Kartu Hasil Utama --}}
        @php
            $isLulus = $prediction->hasil_prediksi === 'Lulus 3,5 Tahun';
            $warnaUtama = $isLulus ? '#155724' : '#721c24';
            $badgeClass = $isLulus ? 'badge-success-custom' : 'badge-danger-custom';
        @endphp
        <div class="card mb-4" style="border-top: 4px solid {{ $warnaUtama }};">
            <div class="card-body text-center py-5">
                {{-- Persentase Besar --}}
                <div style="font-size:64px;font-weight:700;color:{{ $warnaUtama }};line-height:1;">
                    {{ $prediction->persentase_keyakinan }}%
                </div>
                <div style="font-size:16px;color:var(--on-surface-variant);margin:0.5rem 0 1.5rem;">
                    Tingkat Keyakinan Prediksi
                </div>

                {{-- Badge Hasil --}}
                <span class="{{ $badgeClass }}"
                      style="font-size:16px;padding:0.5rem 1.5rem;">
                    {{ $prediction->hasil_prediksi }}
                </span>

                {{-- Progress Bar --}}
                <div class="mt-4 mx-auto" style="max-width:400px;">
                    <div style="height:12px;background:var(--border);border-radius:6px;overflow:hidden;">
                        <div style="height:100%;width:{{ $prediction->persentase_keyakinan }}%;background:{{ $warnaUtama }};border-radius:6px;transition:width 0.5s;"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small style="color:var(--outline);">0%</small>
                        <small style="color:var(--outline);">100%</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Perhitungan --}}
        <div class="card mb-4">
            <div class="card-header">Detail Perhitungan</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small style="color:var(--outline);font-weight:500;display:block;">Tanggal Prediksi</small>
                        <span style="font-weight:600;">{{ $prediction->tanggal_prediksi->format('d M Y') }}</span>
                    </div>
                    <div class="col-md-6">
                        <small style="color:var(--outline);font-weight:500;display:block;">Nilai CF Combined</small>
                        <span style="font-weight:600;color:var(--primary);">{{ number_format($prediction->total_cf_score, 4) }}</span>
                    </div>
                    <div class="col-md-6">
                        <small style="color:var(--outline);font-weight:500;display:block;">Mahasiswa</small>
                        <span style="font-weight:600;">{{ $user->name }} ({{ $user->username_nim }})</span>
                    </div>
                    <div class="col-md-6">
                        <small style="color:var(--outline);font-weight:500;display:block;">Angkatan</small>
                        <span style="font-weight:600;">{{ $user->angkatan ?? '-' }}</span>
                    </div>
                    <div class="col-md-6">
                        <small style="color:var(--outline);font-weight:500;display:block;">Jumlah Rule Terpenuhi</small>
                        <span style="font-weight:600;color:var(--primary);">{{ count($matchedRules) }} dari 49 rule</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Input --}}
        @if($prediction->studentVariable)
        <div class="card mb-4">
            <div class="card-header">Data Input Kuesioner</div>
            <div class="card-body">
                <div class="row g-3">
                    @php
                        $labels = [
                            'ipk_status' => 'IPK',
                            'skripsi_status' => 'Proses Skripsi',
                            'dukungan_keluarga' => 'Dukungan Keluarga',
                            'kualitas_dosen' => 'Kualitas Dosen',
                            'administrasi' => 'Administrasi',
                            'motivasi_diri' => 'Motivasi Diri',
                            'referensi_belajar' => 'Referensi Belajar',
                        ];
                    @endphp
                    @foreach($labels as $field => $label)
                    <div class="col-md-6">
                        <small style="color:var(--outline);font-weight:500;display:block;">{{ $label }}</small>
                        <span style="font-weight:600;text-transform:capitalize;">
                            {{ str_replace('_', ' ', $prediction->studentVariable->$field) }}
                        </span>
                        @if($prediction->studentVariable->answers->where('variable_name', $field)->first())
                            <small style="color:var(--primary);display:block;">
                                CF User: {{ $prediction->studentVariable->answers->where('variable_name', $field)->first()->cf_user }}
                            </small>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Rules yang Terpenuhi --}}
        @if(count($matchedRules) > 0)
        <div class="card mb-4">
            <div class="card-header">Rule yang Terpenuhi ({{ count($matchedRules) }})</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Deskripsi</th>
                                <th>CF Pakar</th>
                                <th>CF User</th>
                                <th>CF Evidence</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matchedRules as $mr)
                            <tr>
                                <td><span style="font-weight:600;color:var(--primary);">{{ $mr['kode_rule'] }}</span></td>
                                <td style="max-width:300px;font-size:13px;">{{ $mr['deskripsi'] }}</td>
                                <td>{{ number_format($mr['cf_pakar'], 2) }}</td>
                                <td>{{ number_format($mr['cf_user'], 2) }}</td>
                                <td style="font-weight:600;">{{ number_format($mr['cf_evidence'], 4) }}</td>
                                <td>
                                    <span class="{{ $mr['status'] === 'Lulus' ? 'badge-success-custom' : 'badge-danger-custom' }}">
                                        {{ $mr['status'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="card mb-4">
            <div class="card-body text-center py-4">
                <i class="bi bi-exclamation-triangle" style="font-size:32px;color:var(--outline);"></i>
                <p style="color:var(--on-surface-variant);margin-top:0.5rem;">Tidak ada rule yang terpenuhi berdasarkan input Anda.</p>
            </div>
        </div>
        @endif

        {{-- Saran --}}
        @if(count($saran) > 0)
        <div class="card mb-4" style="border-left: 4px solid var(--primary);">
            <div class="card-header">
                <i class="bi bi-lightbulb me-2" style="color:var(--primary);"></i>Saran
            </div>
            <div class="card-body">
                <ul style="margin:0;padding-left:1.25rem;">
                    @foreach($saran as $item)
                        <li style="font-size:14px;color:var(--on-surface-variant);margin-bottom:0.5rem;">{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- Aksi --}}
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-custom">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
            <a href="{{ route('mahasiswa.export.pdf', $prediction->id) }}" class="btn btn-primary-custom">
                <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF
            </a>
            <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-outline-custom">
                <i class="bi bi-clock-history me-2"></i> Lihat Riwayat
            </a>
        </div>
    </div>
</div>
@endsection
