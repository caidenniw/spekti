@extends('layouts.app')

@section('title', 'Detail ' . $mahasiswa->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 style="font-size:24px;font-weight:700;">{{ $mahasiswa->name }}</h1>
        <p style="font-size:14px;color:var(--on-surface-variant);">NIM: {{ $mahasiswa->username_nim }} · Angkatan {{ $mahasiswa->angkatan ?? '-' }}</p>
    </div>
    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-custom">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

{{-- Info Mahasiswa --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <small style="color:var(--outline);font-weight:500;display:block;">Nama</small>
                <span style="font-weight:600;">{{ $mahasiswa->name }}</span>
            </div>
            <div class="col-md-3">
                <small style="color:var(--outline);font-weight:500;display:block;">NIM</small>
                <span style="font-weight:600;">{{ $mahasiswa->username_nim }}</span>
            </div>
            <div class="col-md-3">
                <small style="color:var(--outline);font-weight:500;display:block;">Angkatan</small>
                <span style="font-weight:600;">{{ $mahasiswa->angkatan ?? '-' }}</span>
            </div>
            <div class="col-md-3">
                <small style="color:var(--outline);font-weight:500;display:block;">Total Prediksi</small>
                <span style="font-weight:600;color:var(--primary);">{{ $predictions->total() }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Riwayat Prediksi --}}
<div class="card">
    <div class="card-header">Riwayat Prediksi</div>
    <div class="card-body p-0">
        @if($predictions->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>IPK</th>
                        <th>Skripsi</th>
                        <th>CF Score</th>
                        <th>Persentase</th>
                        <th>Hasil</th>
                        <th>Status</th>
                        <th>PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($predictions as $pred)
                    <tr>
                        <td>{{ $pred->tanggal_prediksi->format('d M Y') }}</td>
                        <td>{{ $pred->studentVariable ? ucfirst($pred->studentVariable->ipk_status) : '-' }}</td>
                        <td>{{ $pred->studentVariable ? ucfirst(str_replace('_', ' ', $pred->studentVariable->skripsi_status)) : '-' }}</td>
                        <td style="font-weight:600;color:var(--primary);">{{ number_format($pred->total_cf_score, 4) }}</td>
                        <td style="font-weight:600;">{{ $pred->persentase_keyakinan }}%</td>
                        <td>
                            <span class="{{ $pred->hasil_prediksi === 'Lulus 3,5 Tahun' ? 'badge-success-custom' : 'badge-danger-custom' }}">
                                {{ $pred->hasil_prediksi }}
                            </span>
                        </td>
                        <td>
                            @if($pred->status === 'pending')
                                <span style="background:#fef3c7;color:#92400e;font-weight:600;font-size:10px;padding:0.25rem 0.75rem;border-radius:9999px;">
                                    <i class="bi bi-hourglass me-1"></i>Menunggu
                                </span>
                            @elseif($pred->status === 'revision_allowed')
                                <span style="background:#dbeafe;color:#1e40af;font-weight:600;font-size:10px;padding:0.25rem 0.75rem;border-radius:9999px;">
                                    <i class="bi bi-pencil-square me-1"></i>Revisi Diizinkan
                                </span>
                            @elseif($pred->status === 'revision_rejected')
                                <span class="badge-danger-custom" style="font-size:10px;">
                                    <i class="bi bi-x-circle me-1"></i>Ditolak
                                </span>
                            @else
                                <small style="color:var(--outline);">-</small>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.mahasiswa.export.pdf', [$mahasiswa->id, $pred->id]) }}" class="btn btn-sm btn-outline-custom" title="Export PDF">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-3 pb-3 pt-2">{{ $predictions->links() }}</div>
        @else
        <div class="text-center py-4">
            <p style="color:var(--outline);">Belum ada riwayat prediksi.</p>
        </div>
        @endif
    </div>
</div>
@endsection
