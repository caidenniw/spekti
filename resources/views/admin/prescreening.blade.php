@extends('layouts.app')

@section('title', 'Pre-screening Log')

@section('content')
<div class="page-header">
    <h1>Ditolak Pre-screening</h1>
    <p>Daftar mahasiswa yang tidak lolos pre-screening karena memiliki nilai C/D/E.</p>
</div>

<div class="card">
    <div class="card-body">
        @if($rejections->isEmpty())
            <div class="text-center py-4">
                <div style="width:64px;height:64px;border-radius:50%;background:var(--success-bg);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <i class="bi bi-check-circle" style="font-size:28px;color:var(--success-text);"></i>
                </div>
                <h6 style="font-weight:600;margin-bottom:0.25rem;">Tidak Ada Data</h6>
                <p style="font-size:14px;color:var(--on-surface-variant);margin:0;">
                    Belum ada mahasiswa yang ditolak pre-screening.
                </p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Angkatan</th>
                            <th>Tanggal Screening</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rejections as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td style="font-weight:600;">{{ $item->user->name }}</td>
                            <td>{{ $item->user->username_nim }}</td>
                            <td>{{ $item->user->angkatan ?? '-' }}</td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.prescreening.export.pdf', $item->user_id) }}" class="btn btn-sm btn-outline-custom">
                                    <i class="bi bi-download"></i> PDF
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
