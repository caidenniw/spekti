@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Selamat datang, {{ $user->name }}! Kelola prediksi kelulusan Anda.</p>
</div>

<!-- Ringkasan -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="card stat-card">
            <div class="stat-number">{{ $totalPrediksi }}</div>
            <div class="stat-label">Total Prediksi</div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card stat-card">
            <div class="stat-number">{{ $user->angkatan ?? '-' }}</div>
            <div class="stat-label">Angkatan</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card stat-card">
            @if($latestPrediction)
                <div class="stat-number" style="color: {{ $latestPrediction->hasil_prediksi === 'Lulus 3,5 Tahun' ? 'var(--success-text)' : 'var(--danger-text)' }};">
                    {{ $latestPrediction->persentase_keyakinan }}%
                </div>
                <div class="stat-label">Prediksi Terakhir</div>
            @else
                <div class="stat-number" style="color: var(--outline);">-</div>
                <div class="stat-label">Belum Ada Prediksi</div>
            @endif
        </div>
    </div>
</div>

<!-- Aksi Cepat -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        @if($latestPrediction)
            @if($latestPrediction->isActive())
                {{-- Sudah ada prediksi aktif, tombol ajukan edit --}}
                <div class="card" style="border-left: 4px solid var(--warning-bg);">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div style="width:48px;height:48px;border-radius:12px;background:rgba(186,26,26,0.1);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-pencil-square" style="color:var(--danger-text);font-size:22px;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 style="margin:0;font-weight:600;">Prediksi Sudah Tersimpan</h6>
                            <p style="margin:0;font-size:13px;color:var(--on-surface-variant);">Ajukan permintaan edit jika ada kesalahan data</p>
                        </div>
                        {{-- Modal trigger --}}
                        <button type="button" class="btn btn-sm btn-outline-custom" data-bs-toggle="modal" data-bs-target="#requestEditModal">
                            <i class="bi bi-pencil me-1"></i>Ajukan Edit
                        </button>
                    </div>
                </div>
            @elseif($latestPrediction->isPending())
                {{-- Request sedang menunggu --}}
                <div class="card" style="border-left: 4px solid var(--primary);">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div style="width:48px;height:48px;border-radius:12px;background:var(--primary-tint);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-hourglass-split" style="color:var(--primary);font-size:22px;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 style="margin:0;font-weight:600;">Menunggu Persetujuan Admin</h6>
                            <p style="margin:0;font-size:13px;color:var(--on-surface-variant);">Alasan: {{ Str::limit($latestPrediction->revision_notes, 60) }}</p>
                        </div>
                        <span class="badge-warning-custom">Menunggu</span>
                    </div>
                </div>
            @elseif($latestPrediction->isRevisionAllowed())
                {{-- Admin sudah approve, bisa edit --}}
                <a href="{{ route('mahasiswa.kuesioner') }}" class="text-decoration-none">
                    <div class="card" style="border-left: 4px solid var(--success-text);">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div style="width:48px;height:48px;border-radius:12px;background:var(--success-bg);display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-check-circle" style="color:var(--success-text);font-size:22px;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 style="margin:0;font-weight:600;">Edit Diizinkan</h6>
                                <p style="margin:0;font-size:13px;color:var(--on-surface-variant);">Klik untuk memperbaiki data kuesioner</p>
                            </div>
                            <i class="bi bi-chevron-right ms-auto" style="color:var(--outline);"></i>
                        </div>
                    </div>
                </a>
            @elseif($latestPrediction->isRevisionRejected())
                {{-- Request ditolak --}}
                <div class="card" style="border-left: 4px solid var(--danger-text);">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div style="width:48px;height:48px;border-radius:12px;background:var(--danger-bg);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-x-circle" style="color:var(--danger-text);font-size:22px;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 style="margin:0;font-weight:600;">Permintaan Edit Ditolak</h6>
                            <p style="margin:0;font-size:13px;color:var(--on-surface-variant);">Ajukan kembali jika diperlukan</p>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-custom" data-bs-toggle="modal" data-bs-target="#requestEditModal">
                            <i class="bi bi-pencil me-1"></i>Ajukan Lagi
                        </button>
                    </div>
                </div>
            @endif
        @else
            {{-- Belum ada prediksi --}}
            <a href="{{ route('mahasiswa.kuesioner') }}" class="text-decoration-none">
                <div class="card" style="border-left: 4px solid var(--primary);">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div style="width:48px;height:48px;border-radius:12px;background:var(--primary-tint);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-clipboard-check" style="color:var(--primary);font-size:22px;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 style="margin:0;font-weight:600;">Isi Kuesioner</h6>
                            <p style="margin:0;font-size:13px;color:var(--on-surface-variant);">Masukkan data 7 variabel untuk prediksi</p>
                        </div>
                        <i class="bi bi-chevron-right ms-auto" style="color:var(--outline);"></i>
                    </div>
                </div>
            </a>
        @endif
    </div>
    <div class="col-12 col-md-6">
        <a href="{{ route('mahasiswa.riwayat') }}" class="text-decoration-none">
            <div class="card" style="border-left: 4px solid var(--primary-light);">
                <div class="card-body d-flex align-items-center gap-3">
                    <div style="width:48px;height:48px;border-radius:12px;background:rgba(37,99,235,0.1);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-clock-history" style="color:var(--primary-light);font-size:22px;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 style="margin:0;font-weight:600;">Riwayat Prediksi</h6>
                        <p style="margin:0;font-size:13px;color:var(--on-surface-variant);">Lihat semua hasil prediksi sebelumnya</p>
                    </div>
                    <i class="bi bi-chevron-right ms-auto" style="color:var(--outline);"></i>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Prediksi Terakhir -->
@if($latestPrediction)
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Prediksi Terakhir</span>
        <span class="{{ $latestPrediction->hasil_prediksi === 'Lulus 3,5 Tahun' ? 'badge-success-custom' : 'badge-danger-custom' }}">
            {{ $latestPrediction->hasil_prediksi }}
        </span>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <small style="color:var(--outline);font-weight:500;">Tanggal</small>
                <p style="font-weight:600;margin:0;">{{ $latestPrediction->tanggal_prediksi->format('d M Y') }}</p>
            </div>
            <div class="col-6 col-md-3">
                <small style="color:var(--outline);font-weight:500;">Nilai CF</small>
                <p style="font-weight:600;margin:0;">{{ number_format($latestPrediction->total_cf_score, 4) }}</p>
            </div>
            <div class="col-6 col-md-3">
                <small style="color:var(--outline);font-weight:500;">Persentase Keyakinan</small>
                <p style="font-weight:600;margin:0;color:var(--primary);">{{ $latestPrediction->persentase_keyakinan }}%</p>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('mahasiswa.hasil', $latestPrediction->id) }}" class="btn btn-sm btn-outline-custom">
                    <i class="bi bi-eye me-1"></i>Detail
                </a>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Modal Request Edit --}}
@if($latestPrediction && ($latestPrediction->isActive() || $latestPrediction->isRevisionRejected()))
<div class="modal fade" id="requestEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:8px;">
            <form method="POST" action="{{ route('mahasiswa.request.edit', $latestPrediction->id) }}">
                @csrf
                <div class="modal-header" style="border-bottom:1px solid var(--border);">
                    <h5 class="modal-title" style="font-weight:600;font-size:16px;">Ajukan Edit Prediksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p style="font-size:14px;color:var(--on-surface-variant);">
                        Ajukan permintaan edit kepada admin. Setelah disetujui, Anda dapat memperbaiki data kuesioner.
                    </p>
                    <div class="mb-3">
                        <label for="revision_notes" class="form-label" style="font-weight:600;">Alasan Revisi</label>
                        <textarea name="revision_notes" id="revision_notes" class="form-control" rows="4"
                                  placeholder="Contoh: Terdapat kesalahan input pada data IPK, saya memilih 'Rendah' seharusnya 'Tinggi'."
                                  required minlength="10" maxlength="500"></textarea>
                        <small style="color:var(--outline);">Minimal 10 karakter</small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid var(--border);">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-send me-2"></i>Kirim Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
