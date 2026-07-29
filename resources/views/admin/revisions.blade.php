@extends('layouts.app')

@section('title', 'Kelola Revisi')

@section('content')
<div class="page-header">
    <h1>Kelola Revisi Prediksi</h1>
    <p>Permintaan edit data kuesioner dari mahasiswa yang perlu diproses.</p>
</div>

{{-- Pending Requests --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-hourglass-split me-2" style="color:var(--primary);"></i>Permintaan Edit</span>
        @if($revisions->count() > 0)
            <span class="badge-danger-custom">{{ $revisions->count() }} pending</span>
        @endif
    </div>
    <div class="card-body p-0">
        @if($revisions->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>NIM</th>
                        <th>Angkatan</th>
                        <th>Alasan Revisi</th>
                        <th>Tanggal Request</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($revisions as $rev)
                    <tr>
                        <td style="font-weight:600;">{{ $rev->user->name ?? '-' }}</td>
                        <td>{{ $rev->user->username_nim ?? '-' }}</td>
                        <td>{{ $rev->user->angkatan ?? '-' }}</td>
                        <td style="font-size:13px;max-width:300px;">
                            <p style="margin:0;">{{ $rev->revision_notes ?? '-' }}</p>
                        </td>
                        <td>
                            <small>{{ $rev->revision_requested_at ? $rev->revision_requested_at->format('d M Y H:i') : '-' }}</small>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                {{-- Approve --}}
                                <form method="POST" action="{{ route('admin.revisions.approve', $rev->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary-custom" title="Setujui Edit">
                                        <i class="bi bi-check-lg"></i> Setujui
                                    </button>
                                </form>
                                {{-- Reject --}}
                                <form method="POST" action="{{ route('admin.revisions.reject', $rev->id) }}" class="d-inline"
                                      onsubmit="return confirm('Tolak permintaan edit dari {{ $rev->user->name ?? 'mahasiswa' }} ini?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-custom" style="color:var(--danger-text);border-color:var(--danger-text);" title="Tolak Edit">
                                        <i class="bi bi-x-lg"></i> Tolak
                                    </button>
                                </form>
                                <a href="{{ route('admin.mahasiswa.detail', $rev->user_id) }}" class="btn btn-sm btn-outline-custom" title="Lihat Data Prediksi Mahasiswa">
                                    <i class="bi bi-eye me-1"></i>Lihat Data
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-3 pb-3 pt-2">
            {{ $revisions->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size:48px;color:var(--outline-variant);"></i>
            <p style="color:var(--on-surface-variant);margin-top:1rem;">Tidak ada permintaan edit yang pending.</p>
        </div>
        @endif
    </div>
</div>

{{-- Riwayat Revision --}}
@if($historyRevisions->count() > 0)
<div class="card">
    <div class="card-header">
        <i class="bi bi-clock-history me-2"></i>Riwayat Revisi
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>NIM</th>
                        <th>Alasan</th>
                        <th>Tanggal Request</th>
                        <th>Tanggal Proses</th>
                        <th>Hasil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historyRevisions as $rev)
                    <tr>
                        <td style="font-weight:500;">{{ $rev->user->name ?? '-' }}</td>
                        <td>{{ $rev->user->username_nim ?? '-' }}</td>
                        <td style="font-size:13px;max-width:200px;">{{ Str::limit($rev->revision_notes, 40) }}</td>
                        <td><small>{{ $rev->revision_requested_at?->format('d M Y H:i') ?? '-' }}</small></td>
                        <td><small>{{ $rev->revision_approved_at?->format('d M Y H:i') ?? '-' }}</small></td>
                        <td>
                            @if($rev->status === 'active')
                                <span class="badge-success-custom" style="font-size:10px;">
                                    <i class="bi bi-check-circle me-1"></i>Sudah Diedit
                                </span>
                            @elseif($rev->status === 'revision_allowed')
                                <span style="background:#dbeafe;color:#1e40af;font-weight:600;font-size:10px;padding:0.25rem 0.75rem;border-radius:9999px;">
                                    <i class="bi bi-pencil-square me-1"></i>Revisi Diizinkan
                                </span>
                            @elseif($rev->status === 'revision_rejected')
                                <span class="badge-danger-custom" style="font-size:10px;">
                                    <i class="bi bi-x-circle me-1"></i>Ditolak
                                </span>
                            @elseif($rev->status === 'pending')
                                <span style="background:#fef3c7;color:#92400e;font-weight:600;font-size:10px;padding:0.25rem 0.75rem;border-radius:9999px;">
                                    <i class="bi bi-hourglass me-1"></i>Menunggu
                                </span>
                            @else
                                <small style="color:var(--outline);">{{ $rev->status }}</small>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.mahasiswa.detail', $rev->user_id) }}" class="btn btn-sm btn-outline-custom">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection
