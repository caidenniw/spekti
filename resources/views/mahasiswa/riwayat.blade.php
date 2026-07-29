@extends('layouts.app')

@section('title', 'Riwayat Prediksi')

@section('content')
<div class="page-header">
    <h1>Riwayat Prediksi</h1>
    <p>Semua hasil prediksi kelulusan yang pernah Anda lakukan.</p>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($predictions->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>IPK</th>
                        <th>CF Score</th>
                        <th>Persentase</th>
                        <th>Hasil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($predictions as $index => $pred)
                    <tr>
                        <td>{{ $predictions->firstItem() + $index }}</td>
                        <td>{{ $pred->tanggal_prediksi->format('d M Y') }}</td>
                        <td>{{ $pred->studentVariable ? ucfirst(str_replace('_', ' ', $pred->studentVariable->ipk_status)) : '-' }}</td>
                        <td style="font-weight:600;color:var(--primary);">{{ number_format($pred->total_cf_score, 4) }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:60px;height:6px;background:var(--border);border-radius:3px;overflow:hidden;">
                                    <div style="height:100%;width:{{ $pred->persentase_keyakinan }}%;background:{{ $pred->hasil_prediksi === 'Lulus 3,5 Tahun' ? '#155724' : '#721c24' }};border-radius:3px;"></div>
                                </div>
                                <span style="font-weight:600;">{{ $pred->persentase_keyakinan }}%</span>
                            </div>
                        </td>
                        <td>
                            <span class="{{ $pred->hasil_prediksi === 'Lulus 3,5 Tahun' ? 'badge-success-custom' : 'badge-danger-custom' }}">
                                {{ $pred->hasil_prediksi }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('mahasiswa.hasil', $pred->id) }}" class="btn btn-sm btn-outline-custom">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('mahasiswa.export.pdf', $pred->id) }}" class="btn btn-sm btn-outline-custom" title="Export PDF">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-3 pb-3 pt-2">
            {{ $predictions->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size:48px;color:var(--outline-variant);"></i>
            <p style="color:var(--on-surface-variant);margin-top:1rem;">Belum ada riwayat prediksi.</p>
            <a href="{{ route('mahasiswa.kuesioner') }}" class="btn btn-primary-custom mt-2">
                <i class="bi bi-clipboard-check me-2"></i>Mulai Prediksi
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
