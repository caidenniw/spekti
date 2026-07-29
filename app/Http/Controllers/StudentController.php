<?php

namespace App\Http\Controllers;

use App\Models\StudentVariable;
use App\Models\StudentAnswer;
use App\Models\PredictionResult;
use App\Models\PreScreening;
use App\Models\Variable;
use App\Services\CFEngineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Skala CF sesuai angket pakar.
     */
    private array $cfScale = [
        '1.0' => 'Sangat Yakin (1.0)',
        '0.8' => 'Yakin (0.8)',
        '0.6' => 'Cukup Yakin (0.6)',
        '0.4' => 'Kurang Yakin (0.4)',
        '0.2' => 'Tidak Yakin (0.2)',
    ];

    /**
     * Dashboard mahasiswa — ringkasan data + akses prediksi.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $latestPrediction = PredictionResult::where('user_id', $user->id)
            ->latest('tanggal_prediksi')
            ->first();

        $totalPrediksi = PredictionResult::where('user_id', $user->id)->count();

        return view('mahasiswa.dashboard', compact('user', 'latestPrediction', 'totalPrediksi'));
    }

    /**
     * Tampilkan halaman pre-screening — cek kelayakan nilai.
     */
    public function preScreening()
    {
        $user = Auth::user();

        // Cek sudah isi pre-screening
        $existing = PreScreening::where('user_id', $user->id)->first();
        if ($existing) {
            // Jika sudah ditolak sebelumnya, tetap di halaman ditolak
            if (!$existing->nilai_ab_only) {
                return view('mahasiswa.prescreening-rejected');
            }
            // Jika lolos, redirect ke kuesioner
            return redirect()->route('mahasiswa.kuesioner');
        }

        return view('mahasiswa.prescreening');
    }

    /**
     * Proses jawaban pre-screening.
     */
    public function prosesPreScreening(Request $request)
    {
        $validated = $request->validate([
            'nilai_ab_only' => 'required|boolean',
        ]);

        $user = Auth::user();

        // Cek sudah isi — jangan double submit
        if (PreScreening::where('user_id', $user->id)->exists()) {
            return redirect()->route('mahasiswa.dashboard');
        }

        PreScreening::create([
            'user_id' => $user->id,
            'nilai_ab_only' => $validated['nilai_ab_only'],
        ]);

        if ($validated['nilai_ab_only']) {
            return redirect()->route('mahasiswa.kuesioner')
                ->with('success', 'Seluruh nilai Anda A dan B. Silakan lanjutkan mengisi kuesioner.');
        }

        return view('mahasiswa.prescreening-rejected');
    }

    /**
     * Tampilkan form kuesioner.
     *
     * - Jika belum ada prediksi → form kosong (baru)
     * - Jika sudah ada prediksi & status 'revision_allowed' → form edit (pre-filled)
     * - Jika sudah ada prediksi & status 'active' / 'pending' → redirect + flash message
     */
    public function kuesioner()
    {
        $user = Auth::user();

        // Pre-screening check: harus lolos pre-screening (A/B saja) dulu
        $preScreen = PreScreening::where('user_id', $user->id)->first();
        if (!$preScreen) {
            return redirect()->route('mahasiswa.prescreening')
                ->with('info', 'Silakan isi pre-screening terlebih dahulu.');
        }
        if (!$preScreen->nilai_ab_only) {
            return view('mahasiswa.prescreening-rejected');
        }

        // Cek prediksi existing milik user
        $prediction = PredictionResult::where('user_id', $user->id)
            ->latest('tanggal_prediksi')
            ->first();

        // Jika sudah punya prediksi yang aktif, blokir akses
        if ($prediction && $prediction->isActive()) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('warning', 'Anda sudah memiliki prediksi aktif. Ajukan permintaan edit jika ingin mengubah data.');
        }

        // Jika sedang menunggu approval admin, blokir akses
        if ($prediction && $prediction->isPending()) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('warning', 'Permintaan edit Anda sedang menunggu persetujuan admin. Silakan tunggu.');
        }

        // Mode edit: ambil data existing
        $lastVariable = null;
        $editMode = false;

        if ($prediction && $prediction->isRevisionAllowed()) {
            $editMode = true;
            $lastVariable = StudentVariable::where('user_id', $user->id)
                ->with('answers')
                ->latest()
                ->first();
        }

        return view('mahasiswa.kuesioner', compact('user', 'lastVariable', 'editMode', 'prediction'))
            ->with('variables', Variable::getFormFormat())
            ->with('cfScale', $this->cfScale);
    }

    /**
     * Proses kuesioner → hitung CF → simpan/tupdate → tampilkan hasil.
     */
    public function prosesPrediksi(Request $request, CFEngineService $cfService)
    {
        // Validasi input 7 variabel + 7 CF_User
        $validated = $request->validate([
            // Status variabel
            'ipk_status'        => 'required|in:tinggi,rendah',
            'skripsi_status'    => 'required|in:lancar,terlambat',
            'dukungan_keluarga' => 'required|in:tinggi,rendah',
            'kualitas_dosen'    => 'required|in:baik,kurang_baik',
            'administrasi'      => 'required|in:lengkap,tidak_lengkap',
            'motivasi_diri'     => 'required|in:tinggi,rendah',
            'referensi_belajar' => 'required|in:memadai,tidak_memadai',

            // CF User per variabel
            'cf_ipk_status'        => 'required|numeric|in:1.0,0.8,0.6,0.4,0.2',
            'cf_skripsi_status'    => 'required|numeric|in:1.0,0.8,0.6,0.4,0.2',
            'cf_dukungan_keluarga' => 'required|numeric|in:1.0,0.8,0.6,0.4,0.2',
            'cf_kualitas_dosen'    => 'required|numeric|in:1.0,0.8,0.6,0.4,0.2',
            'cf_administrasi'      => 'required|numeric|in:1.0,0.8,0.6,0.4,0.2',
            'cf_motivasi_diri'     => 'required|numeric|in:1.0,0.8,0.6,0.4,0.2',
            'cf_referensi_belajar' => 'required|numeric|in:1.0,0.8,0.6,0.4,0.2',
        ]);

        $user = Auth::user();

        // Cek apakah ini mode edit (revision_allowed)
        $existingPrediction = PredictionResult::where('user_id', $user->id)
            ->where('status', PredictionResult::STATUS_REVISION_ALLOWED)
            ->first();

        if ($existingPrediction) {
            // Mode edit: update existing record
            $result = DB::transaction(function () use ($validated, $cfService, $existingPrediction, $user) {
                // Hapus data lama
                $oldVariable = $existingPrediction->studentVariable;
                if ($oldVariable) {
                    $oldVariable->answers()->delete();
                    $oldVariable->delete();
                }

                // Simpan data input variabel baru
                $variable = StudentVariable::create([
                    'user_id'            => $user->id,
                    'ipk_status'         => $validated['ipk_status'],
                    'skripsi_status'     => $validated['skripsi_status'],
                    'dukungan_keluarga'  => $validated['dukungan_keluarga'],
                    'kualitas_dosen'     => $validated['kualitas_dosen'],
                    'administrasi'       => $validated['administrasi'],
                    'motivasi_diri'      => $validated['motivasi_diri'],
                    'referensi_belajar'  => $validated['referensi_belajar'],
                ]);

                // Simpan CF_User per variabel
                $variableNames = array_keys(Variable::getFormFormat());
                foreach ($variableNames as $varName) {
                    StudentAnswer::create([
                        'student_variable_id' => $variable->id,
                        'variable_name'       => $varName,
                        'variable_value'      => $validated[$varName],
                        'cf_user'             => $validated['cf_' . $varName],
                    ]);
                }

                // Load relasi answers
                $variable->load('answers');

                // Hitung ulang CF
                $statusMap = $variable->getStatusMap();
                $cfUserMap = $variable->getCFUserMap();
                $rules = \App\Models\Rule::all()->keyBy('kode_rule');

                $cfLulus = [];
                $cfTidakLulus = [];

                foreach ($rules as $kodeRule => $rule) {
                    if ($cfService->isRuleMatched($kodeRule, $statusMap)) {
                        $cfUser = $cfService->getCFUserForRule($kodeRule, $cfUserMap);
                        $cfEvidence = $cfService->calculateCFEvidence((float) $rule->cf_pakar, $cfUser);

                        if ($rule->status_prediksi === 'Lulus') {
                            $cfLulus[] = $cfEvidence;
                        } else {
                            $cfTidakLulus[] = $cfEvidence;
                        }
                    }
                }

                $cfLulusCombined = empty($cfLulus) ? 0.0 : $cfService->combineCF($cfLulus);
                $cfTidakLulusCombined = empty($cfTidakLulus) ? 0.0 : $cfService->combineCF($cfTidakLulus);
                $cfLulusCombined > $cfTidakLulusCombined
                    ? $hasilPrediksi = 'Lulus 3,5 Tahun'
                    : $hasilPrediksi = 'Tidak Lulus 3,5 Tahun';
                $cfDominan = max($cfLulusCombined, $cfTidakLulusCombined);
                $persentase = $cfService->getPercentage($cfDominan);

                // Update prediction_result yang SAMA
                $existingPrediction->update([
                    'student_variable_id'    => $variable->id,
                    'total_cf_score'         => $cfDominan,
                    'persentase_keyakinan'   => $persentase,
                    'hasil_prediksi'         => $hasilPrediksi,
                    'tanggal_prediksi'       => now()->toDateString(),
                    'status'                 => PredictionResult::STATUS_ACTIVE,
                    'revision_approved_at'   => null,
                    'revision_requested_at'  => null,
                    'revision_notes'         => null,
                ]);

                return [
                    'prediction' => $existingPrediction,
                    'matchedRules' => [],
                ];
            });

            return redirect()->route('mahasiswa.hasil', $result['prediction']->id)
                ->with('success', 'Data prediksi berhasil diperbarui!');
        }

        // Mode baru: cek apakah sudah punya prediksi aktif
        $hasActive = PredictionResult::where('user_id', $user->id)
            ->whereIn('status', [PredictionResult::STATUS_ACTIVE, PredictionResult::STATUS_PENDING])
            ->exists();

        if ($hasActive) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('warning', 'Anda sudah memiliki prediksi aktif. Ajukan permintaan edit jika ingin mengubah data.');
        }

        // Submit prediksi baru
        $result = DB::transaction(function () use ($validated, $cfService) {
            // Simpan data input variabel (7 status)
            $variable = StudentVariable::create([
                'user_id'            => Auth::id(),
                'ipk_status'         => $validated['ipk_status'],
                'skripsi_status'     => $validated['skripsi_status'],
                'dukungan_keluarga'  => $validated['dukungan_keluarga'],
                'kualitas_dosen'     => $validated['kualitas_dosen'],
                'administrasi'       => $validated['administrasi'],
                'motivasi_diri'      => $validated['motivasi_diri'],
                'referensi_belajar'  => $validated['referensi_belajar'],
            ]);

            // Simpan CF_User per variabel
            $variableNames = array_keys(Variable::getFormFormat());
            foreach ($variableNames as $varName) {
                StudentAnswer::create([
                    'student_variable_id' => $variable->id,
                    'variable_name'       => $varName,
                    'variable_value'      => $validated[$varName],
                    'cf_user'             => $validated['cf_' . $varName],
                ]);
            }

            // Load relasi answers agar helper methods bisa jalan
            $variable->load('answers');

            // Proses prediksi CF
            return $cfService->predict($variable);
        });

        // Redirect ke halaman hasil
        return redirect()->route('mahasiswa.hasil', $result['prediction']->id)
            ->with('success', 'Prediksi berhasil diproses!');
    }

    /**
     * Mahasiswa mengajukan permintaan edit ke admin.
     */
    public function requestEdit(Request $request, $id)
    {
        $user = Auth::user();
        $prediction = PredictionResult::where('user_id', $user->id)
            ->where('id', $id)
            ->whereIn('status', [PredictionResult::STATUS_ACTIVE, PredictionResult::STATUS_REVISION_REJECTED])
            ->firstOrFail();

        $request->validate([
            'revision_notes' => 'required|string|max:500|min:10',
        ], [
            'revision_notes.required' => 'Alasan revisi wajib diisi.',
            'revision_notes.min' => 'Alasan revisi minimal 10 karakter.',
        ]);

        $prediction->update([
            'status' => PredictionResult::STATUS_PENDING,
            'revision_requested_at' => now(),
            'revision_notes' => $request->revision_notes,
        ]);

        return redirect()->route('mahasiswa.dashboard');
    }

    /**
     * Tampilkan hasil prediksi beserta detail rule yang match.
     */
    public function hasil($id)
    {
        $user = Auth::user();
        $prediction = PredictionResult::with(['studentVariable.answers'])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        // Re-hitung matched rules untuk ditampilkan
        $cfService = app(CFEngineService::class);
        $variable = $prediction->studentVariable;
        $statusMap = $variable->getStatusMap();
        $cfUserMap = $variable->getCFUserMap();

        // Ambil semua rules
        $rules = \App\Models\Rule::all()->keyBy('kode_rule');
        $matchedRules = [];

        foreach ($rules as $kodeRule => $rule) {
            if ($cfService->isRuleMatched($kodeRule, $statusMap)) {
                $cfUser = $cfService->getCFUserForRule($kodeRule, $cfUserMap);
                $cfEvidence = $cfService->calculateCFEvidence((float) $rule->cf_pakar, $cfUser);
                $matchedRules[] = [
                    'kode_rule'   => $kodeRule,
                    'deskripsi'   => $rule->deskripsi_rule,
                    'cf_pakar'    => (float) $rule->cf_pakar,
                    'cf_user'     => $cfUser,
                    'cf_evidence' => $cfEvidence,
                    'status'      => $rule->status_prediksi,
                ];
            }
        }

        // Generate saran berdasarkan input variabel
        $saran = $this->generateSaran($statusMap);

        return view('mahasiswa.hasil', compact('user', 'prediction', 'matchedRules', 'saran'));
    }

    /**
     * Export PDF keterangan tidak lulus pre-screening (nilai C/D/E).
     */
    public function exportPreScreeningPdf()
    {
        $user = Auth::user();
        $preScreen = PreScreening::where('user_id', $user->id)->first();

        if (!$preScreen || $preScreen->nilai_ab_only) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('warning', 'Anda tidak memiliki akses ke laporan ini.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.prescreening-rejected', compact('user'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download(
            'Surat_Keterangan_Tidak_Lulus_3.5_Tahun_'
            . $user->username_nim . '_'
            . now()->format('Y-m-d') . '.pdf'
        );
    }

    /**
     * Riwayat semua prediksi mahasiswa.
     */
    public function riwayat()
    {
        $user = Auth::user();
        $predictions = PredictionResult::where('user_id', $user->id)
            ->with('studentVariable')
            ->latest('tanggal_prediksi')
            ->paginate(10);

        return view('mahasiswa.riwayat', compact('user', 'predictions'));
    }

    /**
     * Export hasil prediksi ke PDF.
     */
    public function exportPdf($id)
    {
        $user = Auth::user();
        $prediction = PredictionResult::with(['studentVariable.answers'])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        $cfService = app(CFEngineService::class);
        $variable = $prediction->studentVariable;
        $statusMap = $variable->getStatusMap();
        $cfUserMap = $variable->getCFUserMap();

        $rules = \App\Models\Rule::all()->keyBy('kode_rule');
        $matchedRules = [];

        foreach ($rules as $kodeRule => $rule) {
            if ($cfService->isRuleMatched($kodeRule, $statusMap)) {
                $cfUser = $cfService->getCFUserForRule($kodeRule, $cfUserMap);
                $cfEvidence = $cfService->calculateCFEvidence((float) $rule->cf_pakar, $cfUser);
                $matchedRules[] = [
                    'kode_rule'   => $kodeRule,
                    'deskripsi'   => $rule->deskripsi_rule,
                    'cf_pakar'    => (float) $rule->cf_pakar,
                    'cf_user'     => $cfUser,
                    'cf_evidence' => $cfEvidence,
                    'status'      => $rule->status_prediksi,
                ];
            }
        }

        $saran = $this->generateSaran($statusMap);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.prediksi', compact('user', 'prediction', 'matchedRules', 'saran'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Laporan_Prediksi_' . $user->username_nim . '_' . $prediction->tanggal_prediksi->format('Y-m-d') . '.pdf');
    }

    /**
     * Generate saran berdasarkan kondisi variabel mahasiswa.
     * Saran bersifat personal — mempertahankan yang baik, memperbaiki yang kurang.
     */
    private function generateSaran(array $statusMap): array
    {
        $saran = [];

        // IPK
        if (($statusMap['ipk_status'] ?? '') === 'tinggi') {
            $saran[] = 'Pertahankan IPK di atas 3,51.';
        } else {
            $saran[] = 'Tingkatkan IPK minimal 3,51 dengan fokus pada mata kuliah bernilai rendah.';
        }

        // Skripsi
        if (($statusMap['skripsi_status'] ?? '') === 'lancar') {
            $saran[] = 'Selesaikan skripsi sesuai target yang telah ditetapkan.';
        } else {
            $saran[] = 'Percepat penyelesaian skripsi dan lakukan bimbingan secara rutin dengan dosen pembimbing.';
        }

        // Dukungan Keluarga
        if (($statusMap['dukungan_keluarga'] ?? '') === 'tinggi') {
            $saran[] = 'Manfaatkan dukungan keluarga untuk menjaga semangat studi.';
        } else {
            $saran[] = 'Bangun komunikasi yang baik dengan keluarga dan sampaikan target kelulusan Anda.';
        }

        // Kualitas Dosen
        if (($statusMap['kualitas_dosen'] ?? '') === 'baik') {
            $saran[] = 'Lakukan bimbingan secara rutin dengan dosen pembimbing.';
        } else {
            $saran[] = 'Komunikasikan kendala bimbingan dengan dosen atau cari alternatif dosen penguji yang lebih responsif.';
        }

        // Administrasi
        if (($statusMap['administrasi'] ?? '') === 'lengkap') {
            $saran[] = 'Pastikan administrasi perkuliahan tetap lengkap hingga akhir studi.';
        } else {
            $saran[] = 'Segera urus administrasi perkuliahan yang belum lengkap (KHS, KRS, nilai, dll).';
        }

        // Motivasi
        if (($statusMap['motivasi_diri'] ?? '') === 'tinggi') {
            $saran[] = 'Pertahankan motivasi belajar dan fokus pada target lulus 3,5 tahun.';
        } else {
            $saran[] = 'Tingkatkan motivasi diri dengan menetapkan target semester yang terukur dan bergabung dengan lingkungan belajar yang positif.';
        }

        // Referensi
        if (($statusMap['referensi_belajar'] ?? '') === 'memadai') {
            $saran[] = 'Manfaatkan referensi ilmiah yang relevan untuk memperkuat kualitas skripsi.';
        } else {
            $saran[] = 'Perbanyak referensi dari jurnal ilmiah, buku, dan sumber akademik yang relevan dengan topik skripsi.';
        }

        return $saran;
    }
}
