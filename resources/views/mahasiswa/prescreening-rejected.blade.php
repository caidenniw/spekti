@extends('layouts.app')

@section('title', 'Pre-screening Tidak Memenuhi Syarat')

@section('content')
<div class="page-header">
    <h1>Pre-screening</h1>
    <p>Hasil pemeriksaan kelayakan prediksi</p>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <!-- Info Card -->
        <div class="card mb-4">
            <div class="card-body text-center">
                <div style="width:72px;height:72px;border-radius:50%;background:var(--danger-bg);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <i class="bi bi-exclamation-triangle" style="font-size:32px;color:var(--danger-text);"></i>
                </div>
                <h5 style="font-weight:700;color:var(--danger-text);margin-bottom:0.75rem;">
                    Belum Memenuhi Syarat
                </h5>
                <p style="font-size:14px;color:var(--on-surface-variant);margin:0;">
                    Anda belum memenuhi syarat untuk mengikuti prediksi kelulusan 3,5 tahun karena
                    terdapat nilai <strong>C, D, atau E</strong> pada beberapa mata kuliah.
                </p>
            </div>
        </div>

        <!-- Saran Card -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lightbulb me-2"></i>Saran & Motivasi
            </div>
            <div class="card-body">
                <div class="d-flex gap-3 mb-3">
                    <div style="width:36px;height:36px;min-width:36px;border-radius:50%;background:var(--primary-tint);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-emoji-smile" style="color:var(--primary);font-size:16px;"></i>
                    </div>
                    <div>
                        <p style="margin:0;font-size:14px;">
                            <strong>Tetap semangat!</strong> Nilai bukan akhir dari segalanya. Gunakan kesempatan ini untuk memperbaiki nilai di semester berikutnya.
                        </p>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-3">
                    <div style="width:36px;height:36px;min-width:36px;border-radius:50%;background:var(--primary-tint);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-journal-text" style="color:var(--primary);font-size:16px;"></i>
                    </div>
                    <div>
                        <p style="margin:0;font-size:14px;">
                            <strong>Fokus pada perbaikan nilai</strong> mata kuliah yang masih bernilai C, D, atau E agar IPK meningkat.
                        </p>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-3">
                    <div style="width:36px;height:36px;min-width:36px;border-radius:50%;background:var(--primary-tint);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-person-badge" style="color:var(--primary);font-size:16px;"></i>
                    </div>
                    <div>
                        <p style="margin:0;font-size:14px;">
                            <strong>Konsultasi dengan dosen PA</strong> untuk menyusun strategi akademik dan rencana perbaikan nilai yang lebih terarah.
                        </p>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <div style="width:36px;height:36px;min-width:36px;border-radius:50%;background:var(--primary-tint);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-flag" style="color:var(--primary);font-size:16px;"></i>
                    </div>
                    <div>
                        <p style="margin:0;font-size:14px;">
                            <strong>Jangan menyerah!</strong> Target kelulusan 3,5 tahun masih bisa dikejar dengan perencanaan yang matang dan kerja keras.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Dashboard -->
        <div class="text-center mt-3">
            <a href="{{ route('mahasiswa.export.prescreening.pdf') }}" class="btn btn-primary-custom mb-2 w-100">
                <i class="bi bi-download me-2"></i>Download Laporan Keterangan
            </a>
            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-custom w-100">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
