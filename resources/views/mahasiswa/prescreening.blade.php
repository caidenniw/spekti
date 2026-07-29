@extends('layouts.app')

@section('title', 'Pre-screening')

@section('content')
<div class="page-header">
    <h1>Pre-screening</h1>
    <p>Sebelum mengisi kuesioner, jawab pertanyaan berikut terlebih dahulu.</p>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div style="width:64px;height:64px;border-radius:50%;background:var(--primary-tint);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                        <i class="bi bi-question-circle" style="font-size:28px;color:var(--primary);"></i>
                    </div>
                    <h5 style="font-weight:700;margin-bottom:0.5rem;">Cek Kelayakan Prediksi</h5>
                    <p style="font-size:14px;color:var(--on-surface-variant);margin:0;">
                        Mahasiswa yang dapat mengikuti prediksi kelulusan 3,5 tahun adalah yang<br>
                        <strong>tidak memiliki nilai C, D, atau E</strong> pada seluruh mata kuliah dari semester 1-7.
                    </p>
                </div>

                <div style="background:var(--bg);border-radius:8px;padding:1.25rem;margin-bottom:1.5rem;">
                    <p style="font-size:14px;font-weight:600;margin:0 0 0.75rem;">
                        Apakah seluruh nilai mata kuliah Anda dari semester 1-7 hanya bernilai A dan B (tanpa nilai C, D, atau E)?
                    </p>
                </div>

                <form method="POST" action="{{ route('mahasiswa.prescreening.proses') }}">
                    @csrf
                    <input type="hidden" name="nilai_ab_only" value="0" id="inputNilai">
                    <button type="submit" class="btn btn-primary-custom w-100 mb-2" id="btnYa"
                            onclick="document.getElementById('inputNilai').value='1'">
                        <i class="bi bi-check-lg me-2"></i>Ya, hanya A dan B
                    </button>
                    <button type="submit" class="btn btn-outline-custom w-100" id="btnTidak"
                            onclick="document.getElementById('inputNilai').value='0'">
                        <i class="bi bi-x-lg me-2"></i>Tidak, ada nilai C, D, atau E
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
