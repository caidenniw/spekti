@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="page-header">
    <h1>Dashboard Admin</h1>
    <p>Ringkasan analitik prediksi kelulusan mahasiswa.</p>
</div>


{{-- Notifikasi Pending Revisions --}}
@if($pendingRevisionsCount > 0)
<div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-between" role="alert">
    <div class="d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill me-2" style="font-size:18px;"></i>
        <strong>{{ $pendingRevisionsCount }} permintaan edit</strong>&nbsp;dari mahasiswa menunggu persetujuan Anda.
    </div>
    <a href="{{ route('admin.revisions.index') }}" class="btn btn-sm btn-outline-custom" style="color:var(--warning-text);border-color:var(--warning-text);">
        <i class="bi bi-arrow-right me-1"></i>Lihat
    </a>
</div>
@endif

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card stat-card">
            <div class="stat-number">{{ $totalMahasiswa }}</div>
            <div class="stat-label">Total Mahasiswa</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card">
            <div class="stat-number">{{ $totalRules }}</div>
            <div class="stat-label">Rules CF</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card">
            <div class="stat-number">{{ $totalPrediksi }}</div>
            <div class="stat-label">Total Prediksi</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card">
            <div class="stat-number" style="color: var(--success-text);">{{ $persentaseLulus }}%</div>
            <div class="stat-label">Persentase Lulus</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Prediksi Terbaru -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">Prediksi Terbaru</div>
            <div class="card-body p-0">
                @if($recentPredictions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Tanggal</th>
                                <th>CF</th>
                                <th>Persentase</th>
                                <th>Hasil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPredictions as $pred)
                            <tr>
                                <td style="font-weight:500;">{{ $pred->user->name ?? '-' }}</td>
                                <td>{{ $pred->tanggal_prediksi->format('d M Y') }}</td>
                                <td>{{ number_format($pred->total_cf_score, 4) }}</td>
                                <td style="font-weight:600;color:var(--primary);">{{ $pred->persentase_keyakinan }}%</td>
                                <td>
                                    <span class="{{ $pred->hasil_prediksi === 'Lulus 3,5 Tahun' ? 'badge-success-custom' : 'badge-danger-custom' }}">
                                        {{ Str::limit($pred->hasil_prediksi, 8) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <p style="color:var(--outline);">Belum ada prediksi.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Pending Revisions (jika ada) --}}
        @if($pendingRevisions->count() > 0)
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Permintaan Edit Terbaru</span>
                <a href="{{ route('admin.revisions.index') }}" class="btn btn-sm btn-outline-custom">
                    <i class="bi bi-arrow-right"></i> Semua
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Alasan</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingRevisions as $rev)
                            <tr>
                                <td style="font-weight:500;">{{ $rev->user->name ?? '-' }}</td>
                                <td style="font-size:13px;max-width:200px;">{{ Str::limit($rev->revision_notes, 50) }}</td>
                                <td><small>{{ $rev->revision_requested_at?->format('d M Y') ?? '-' }}</small></td>
                                <td>
                                    <form method="POST" action="{{ route('admin.revisions.approve', $rev->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary-custom">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Prediksi per Angkatan + Aksi Cepat -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">Mahasiswa per Angkatan</div>
            <div class="card-body">
                @forelse($perAngkatan as $item)
                <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div>
                        <span style="font-weight:600;">Angkatan {{ $item->angkatan }}</span><br>
                        <small style="color:var(--outline);">{{ $item->jumlah_mahasiswa }} mahasiswa</small>
                    </div>
                    <div class="text-end">
                        <span style="font-weight:600;color:var(--primary);">{{ $item->jumlah_prediksi }}</span>
                        <small style="color:var(--outline);display:block;">prediksi</small>
                    </div>
                </div>
                @empty
                <p style="color:var(--outline);text-align:center;">Belum ada data.</p>
                @endforelse
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="card mt-3">
            <div class="card-body">
                <h6 style="font-weight:600;margin-bottom:0.75rem;">Aksi Cepat</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.revisions.index') }}" class="btn btn-sm btn-outline-custom text-start">
                        <i class="bi bi-pencil-square me-2"></i>Kelola Revisi
                        @if($pendingRevisionsCount > 0)
                            <span class="badge-danger-custom ms-2" style="font-size:10px;">{{ $pendingRevisionsCount }} pending</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.rules.create') }}" class="btn btn-sm btn-outline-custom text-start">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Rule Baru
                    </a>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-sm btn-outline-custom text-start">
                        <i class="bi bi-people me-2"></i>Lihat Semua Mahasiswa
                    </a>
                    <hr style="margin:0.25rem 0;">
                    <h6 style="font-weight:600;margin-bottom:0.25rem;font-size:0.8rem;color:var(--outline);">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Export Rekap PDF
                    </h6>
                    <a href="{{ route('admin.export.rekap', 'semua') }}" class="btn btn-sm btn-outline-custom text-start">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Semua Mahasiswa
                    </a>
                    <a href="{{ route('admin.export.rekap', 'lulus') }}" class="btn btn-sm btn-outline-custom text-start" style="color:var(--success-text);">
                        <i class="bi bi-check-circle me-2"></i>Lulus Saja
                    </a>
                    <a href="{{ route('admin.export.rekap', 'tidak-lulus') }}" class="btn btn-sm btn-outline-custom text-start" style="color:var(--danger-text);">
                        <i class="bi bi-x-circle me-2"></i>Tidak Lulus Saja
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
