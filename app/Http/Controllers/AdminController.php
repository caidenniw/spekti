<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rule;
use App\Models\PredictionResult;
use App\Models\PreScreening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Skala CF pakar (untuk dropdown form rules).
     */
    private array $cfScale = [
        '1.0' => 'Sangat Yakin (1.0)',
        '0.8' => 'Yakin (0.8)',
        '0.6' => 'Cukup Yakin (0.6)',
        '0.4' => 'Kurang Yakin (0.4)',
        '0.2' => 'Tidak Yakin (0.2)',
    ];

    /**
     * Dashboard admin — analitik ringkas + notifikasi revisi.
     */
    public function dashboard()
    {
        $totalMahasiswa = User::role('mahasiswa')->count();
        $totalRules = Rule::count();
        $totalPrediksi = PredictionResult::count();
        $lulusCount = PredictionResult::where('hasil_prediksi', 'Lulus 3,5 Tahun')->count();
        $persentaseLulus = $totalPrediksi > 0
            ? round(($lulusCount / $totalPrediksi) * 100, 1)
            : 0;

        // Prediksi terbaru (5 terakhir)
        $recentPredictions = PredictionResult::with('user')
            ->latest('tanggal_prediksi')
            ->limit(5)
            ->get();

        // Prediksi per angkatan
        $perAngkatan = \DB::select("
            SELECT
                u.angkatan,
                COUNT(DISTINCT u.id) AS jumlah_mahasiswa,
                COUNT(DISTINCT pr.id) AS jumlah_prediksi
            FROM users u
            LEFT JOIN prediction_results pr ON u.id = pr.user_id
            WHERE u.role = 'mahasiswa'
            GROUP BY u.angkatan
            ORDER BY u.angkatan ASC
        ");

        // Notifikasi revisi pending
        $pendingRevisionsCount = PredictionResult::where('status', PredictionResult::STATUS_PENDING)->count();
        $pendingRevisions = PredictionResult::with('user')
            ->where('status', PredictionResult::STATUS_PENDING)
            ->latest('revision_requested_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMahasiswa', 'totalRules', 'totalPrediksi', 'persentaseLulus',
            'recentPredictions', 'perAngkatan',
            'pendingRevisionsCount', 'pendingRevisions'
        ));
    }

    // ── CRUD Rules (Knowledge Base) ──

    /** Daftar semua rules. */
    public function rulesIndex()
    {
        $rules = Rule::orderByRaw('CAST(SUBSTRING(kode_rule, 2) AS UNSIGNED)')->paginate(10);
        return view('admin.rules', compact('rules'));
    }

    /** Form tambah rule baru. */
    public function rulesCreate()
    {
        $nextCode = $this->getNextRuleCode();
        $cfScale = $this->cfScale;
        return view('admin.rules-create', compact('nextCode', 'cfScale'));
    }

    /** Simpan rule baru. */
    public function rulesStore(Request $request)
    {
        $validated = $request->validate([
            'kode_rule'       => 'required|string|unique:rules,kode_rule',
            'deskripsi_rule'  => 'required|string',
            'cf_pakar'        => 'required|numeric|min:0|max:1',
            'status_prediksi' => 'required|in:Lulus,Tidak Lulus',
        ], [
            'kode_rule.required'       => 'Kode rule wajib diisi.',
            'kode_rule.unique'         => 'Kode rule sudah ada.',
            'deskripsi_rule.required'  => 'Deskripsi rule wajib diisi.',
            'cf_pakar.required'        => 'CF Pakar wajib diisi.',
            'cf_pakar.min'             => 'CF Pakar minimal 0.',
            'cf_pakar.max'             => 'CF Pakar maksimal 1.',
            'status_prediksi.required' => 'Status prediksi wajib dipilih.',
        ]);

        Rule::create($validated);

        return redirect()->route('admin.rules.index')
            ->with('success', "Rule {$validated['kode_rule']} berhasil ditambahkan.");
    }

    /** Form edit rule. */
    public function rulesEdit($id)
    {
        $rule = Rule::findOrFail($id);
        $cfScale = $this->cfScale;
        return view('admin.rules-edit', compact('rule', 'cfScale'));
    }

    /** Update rule. */
    public function rulesUpdate(Request $request, $id)
    {
        $rule = Rule::findOrFail($id);

        $validated = $request->validate([
            'deskripsi_rule'  => 'required|string',
            'cf_pakar'        => 'required|numeric|min:0|max:1',
            'status_prediksi' => 'required|in:Lulus,Tidak Lulus',
        ]);

        $rule->update($validated);

        return redirect()->route('admin.rules.index')
            ->with('success', "Rule {$rule->kode_rule} berhasil diperbarui.");
    }

    /** Hapus rule. */
    public function rulesDestroy($id)
    {
        $rule = Rule::findOrFail($id);
        $kode = $rule->kode_rule;
        $rule->delete();

        return redirect()->route('admin.rules.index')
            ->with('success', "Rule {$kode} berhasil dihapus.");
    }

    // ── Data Mahasiswa (Full CRUD) ──

    /** Daftar semua mahasiswa beserta hasil prediksi terakhir. */
    public function mahasiswaIndex()
    {
        $mahasiswas = User::role('mahasiswa')
            ->with(['predictionResults' => function ($query) {
                $query->latest('tanggal_prediksi')->limit(1);
            }])
            ->paginate(15);

        return view('admin.mahasiswa', compact('mahasiswas'));
    }

    /** Detail prediksi satu mahasiswa. */
    public function mahasiswaDetail($id)
    {
        $mahasiswa = User::role('mahasiswa')->findOrFail($id);
        $predictions = PredictionResult::where('user_id', $id)
            ->with('studentVariable')
            ->latest('tanggal_prediksi')
            ->paginate(10);

        return view('admin.mahasiswa-detail', compact('mahasiswa', 'predictions'));
    }

    /** Form tambah mahasiswa baru. */
    public function mahasiswaCreate()
    {
        return view('admin.mahasiswa-create');
    }

    /** Simpan mahasiswa baru. */
    public function mahasiswaStore(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'username_nim'  => 'required|string|unique:users,username_nim',
            'angkatan'      => 'required|integer|min:2018|max:' . (date('Y') + 1),
            'password'      => 'required|string|min:6|confirmed',
        ], [
            'name.required'             => 'Nama lengkap wajib diisi.',
            'username_nim.required'     => 'NIM wajib diisi.',
            'username_nim.unique'       => 'NIM sudah terdaftar.',
            'angkatan.required'         => 'Tahun angkatan wajib diisi.',
            'angkatan.min'              => 'Tahun angkatan minimal 2018.',
            'angkatan.max'              => 'Tahun angkatan maksimal ' . (date('Y') + 1) . '.',
            'password.required'         => 'Password wajib diisi.',
            'password.min'              => 'Password minimal 6 karakter.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'         => $validated['name'],
            'role'         => 'mahasiswa',
            'username_nim' => $validated['username_nim'],
            'angkatan'     => $validated['angkatan'],
            'password'     => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', "Mahasiswa {$validated['name']} ({$validated['username_nim']}) berhasil ditambahkan.");
    }

    /** Form edit mahasiswa. */
    public function mahasiswaEdit($id)
    {
        $mahasiswa = User::role('mahasiswa')->findOrFail($id);
        return view('admin.mahasiswa-edit', compact('mahasiswa'));
    }

    /** Update data mahasiswa. */
    public function mahasiswaUpdate(Request $request, $id)
    {
        $mahasiswa = User::role('mahasiswa')->findOrFail($id);

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'username_nim' => 'required|string|unique:users,username_nim,' . $mahasiswa->id,
            'angkatan'     => 'required|integer|min:2018|max:' . (date('Y') + 1),
            'password'     => 'nullable|string|min:6|confirmed',
        ], [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'username_nim.required' => 'NIM wajib diisi.',
            'username_nim.unique'   => 'NIM sudah terdaftar.',
            'angkatan.required'     => 'Tahun angkatan wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $updateData = [
            'name'         => $validated['name'],
            'username_nim' => $validated['username_nim'],
            'angkatan'     => $validated['angkatan'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $mahasiswa->update($updateData);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', "Data mahasiswa {$mahasiswa->name} berhasil diperbarui.");
    }

    /** Hapus mahasiswa beserta semua data terkait. */
    public function mahasiswaDestroy($id)
    {
        $mahasiswa = User::role('mahasiswa')->findOrFail($id);
        $nama = $mahasiswa->name;

        // Cascade delete: hapus semua data terkait (urut dari child ke parent)
        \DB::transaction(function () use ($mahasiswa) {
            $variableIds = \App\Models\StudentVariable::where('user_id', $mahasiswa->id)->pluck('id');
            \App\Models\StudentAnswer::whereIn('student_variable_id', $variableIds)->delete();
            \App\Models\PredictionResult::where('user_id', $mahasiswa->id)->delete();
            \App\Models\StudentVariable::where('user_id', $mahasiswa->id)->delete();
            $mahasiswa->delete();
        });

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', "Mahasiswa {$nama} beserta semua data prediksinya berhasil dihapus.");
    }

    /** Export prediksi mahasiswa ke PDF (untuk admin). */
    public function exportPdf($mahasiswaId, $predictionId)
    {
        $mahasiswa = User::role('mahasiswa')->findOrFail($mahasiswaId);
        $prediction = PredictionResult::with(['studentVariable.answers'])
            ->where('user_id', $mahasiswaId)
            ->findOrFail($predictionId);

        $cfService = app(\App\Services\CFEngineService::class);
        $variable = $prediction->studentVariable;
        $statusMap = $variable->getStatusMap();
        $cfUserMap = $variable->getCFUserMap();

        $rules = Rule::all()->keyBy('kode_rule');
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

        // Generate saran
        $saran = [];
        $saranMap = [
            'ipk_status'        => ['tinggi' => 'Pertahankan IPK di atas 3,51.', 'rendah' => 'Tingkatkan IPK minimal 3,51 dengan fokus pada mata kuliah bernilai rendah.'],
            'skripsi_status'    => ['lancar' => 'Selesaikan skripsi sesuai target yang telah ditetapkan.', 'terlambat' => 'Percepat penyelesaian skripsi dan lakukan bimbingan secara rutin.'],
            'dukungan_keluarga' => ['tinggi' => 'Manfaatkan dukungan keluarga untuk menjaga semangat studi.', 'rendah' => 'Bangun komunikasi yang baik dengan keluarga dan sampaikan target kelulusan Anda.'],
            'kualitas_dosen'    => ['baik' => 'Lakukan bimbingan secara rutin dengan dosen pembimbing.', 'kurang_baik' => 'Komunikasikan kendala bimbingan dengan dosen atau cari alternatif dosen penguji.'],
            'administrasi'      => ['lengkap' => 'Pastikan administrasi perkuliahan tetap lengkap hingga akhir studi.', 'tidak_lengkap' => 'Segera urus administrasi perkuliahan yang belum lengkap.'],
            'motivasi_diri'     => ['tinggi' => 'Pertahankan motivasi belajar dan fokus pada target lulus 3,5 tahun.', 'rendah' => 'Tingkatkan motivasi diri dengan menetapkan target semester yang terukur.'],
            'referensi_belajar' => ['memadai' => 'Manfaatkan referensi ilmiah yang relevan untuk memperkuat kualitas skripsi.', 'tidak_memadai' => 'Perbanyak referensi dari jurnal ilmiah, buku, dan sumber akademik yang relevan.'],
        ];
        foreach ($saranMap as $var => $options) {
            $saran[] = $options[$statusMap[$var]] ?? reset($options);
        }

        $user = $mahasiswa;
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.prediksi', compact('user', 'prediction', 'matchedRules', 'saran'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Laporan_Prediksi_' . $mahasiswa->username_nim . '_' . $prediction->tanggal_prediksi->format('Y-m-d') . '.pdf');
    }

    /** Export rekap prediksi semua mahasiswa ke PDF (dengan filter). */
    public function exportRekap($filter = 'semua')
    {
        $latestIds = PredictionResult::selectRaw('MAX(id) as id')
            ->groupBy('user_id');

        $predictions = PredictionResult::with('user')
            ->whereIn('id', $latestIds)
            ->orderBy('hasil_prediksi')
            ->orderBy('user_id')
            ->get();

        if ($filter === 'lulus') {
            $predictions = $predictions->where('hasil_prediksi', 'Lulus 3,5 Tahun');
        } elseif ($filter === 'tidak-lulus') {
            // Ambil prediksi dengan hasil tidak lulus
            $tidakLulusPred = $predictions->where('hasil_prediksi', 'Tidak Lulus 3,5 Tahun');

            // Ambil juga mahasiswa yang gagal pre-screening (nilai C/D/E)
            // Mereka tidak punya prediction_result, tapi harus muncul di rekap tidak lulus
            $preScreenRejects = PreScreening::with('user')
                ->where('nilai_ab_only', false)
                ->get()
                ->map(function ($ps) {
                    $obj = new \stdClass();
                    $obj->user = $ps->user;
                    $obj->total_cf_score = null;
                    $obj->persentase_keyakinan = null;
                    $obj->hasil_prediksi = 'Tidak Lulus 3,5 Tahun';
                    $obj->tanggal_prediksi = $ps->created_at;
                    return $obj;
                });

            // Hindari duplikasi: lewati user yang sudah ada di tidakLulusPred
            $existingUserIds = $tidakLulusPred->pluck('user_id')->toArray();
            $additionalRejects = $preScreenRejects->reject(function ($r) use ($existingUserIds) {
                return in_array($r->user->id, $existingUserIds);
            });

            // Gabung dan urutkan berdasarkan nama
            $predictions = $tidakLulusPred->concat($additionalRejects)
                ->sortBy(function ($p) { return $p->user->name; })
                ->values();
        }

        $totalMahasiswa = User::role('mahasiswa')->count();
        $lulusCount = PredictionResult::whereIn('id', $latestIds)
            ->where('hasil_prediksi', 'Lulus 3,5 Tahun')
            ->count();

        // Tidak lulus = prediksi tidak lulus + gagal pre-screening (user unik)
        $tidakLulusUserIds = PredictionResult::whereIn('id', $latestIds)
            ->where('hasil_prediksi', 'Tidak Lulus 3,5 Tahun')
            ->pluck('user_id')
            ->merge(
                PreScreening::where('nilai_ab_only', false)->pluck('user_id')
            )->unique();
        $tidakLulusCount = $tidakLulusUserIds->count();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.rekap', compact(
            'predictions', 'filter', 'totalMahasiswa', 'lulusCount', 'tidakLulusCount'
        ));
        $pdf->setPaper('A4', 'landscape');

        $filterLabel = match($filter) {
            'lulus'        => 'Lulus',
            'tidak-lulus'  => 'Tidak_Lulus',
            default        => 'Semua',
        };

        return $pdf->download('Rekap_Prediksi_' . $filterLabel . '_' . now()->format('Y-m-d') . '.pdf');
    }

    // ── Revision Management ──

    /** Daftar semua request revisi dari mahasiswa. */
    public function revisionRequests()
    {
        $revisions = PredictionResult::with('user')
            ->where('status', PredictionResult::STATUS_PENDING)
            ->latest('revision_requested_at')
            ->paginate(15);

        // Yang sudah pernah diproses (riwayat)
        $historyRevisions = PredictionResult::with('user')
            ->whereIn('status', [
                PredictionResult::STATUS_ACTIVE,
                PredictionResult::STATUS_REVISION_ALLOWED,
                PredictionResult::STATUS_REVISION_REJECTED,
            ])
            ->whereNotNull('revision_requested_at')
            ->latest('revision_approved_at')
            ->limit(20)
            ->get();

        return view('admin.revisions', compact('revisions', 'historyRevisions'));
    }

    /** Approve permintaan edit mahasiswa. */
    public function approveRevision($id)
    {
        $prediction = PredictionResult::with('user')
            ->where('status', PredictionResult::STATUS_PENDING)
            ->findOrFail($id);

        $prediction->update([
            'status' => PredictionResult::STATUS_REVISION_ALLOWED,
            'revision_approved_at' => now(),
        ]);

        return redirect()->route('admin.revisions.index')
            ->with('success', "Permintaan edit dari {$prediction->user->name} ({$prediction->user->username_nim}) telah disetujui. Mahasiswa dapat mengubah data kuesioner.");
    }

    /** Tolak permintaan edit mahasiswa. */
    public function rejectRevision($id)
    {
        $prediction = PredictionResult::with('user')
            ->where('status', PredictionResult::STATUS_PENDING)
            ->findOrFail($id);

        $prediction->update([
            'status' => PredictionResult::STATUS_REVISION_REJECTED,
        ]);

        return redirect()->route('admin.revisions.index')
            ->with('success', "Permintaan edit dari {$prediction->user->name} telah ditolak.");
    }

    /**
     * Tampilkan daftar mahasiswa yang ditolak pre-screening.
     */
    public function preScreeningIndex()
    {
        $rejections = PreScreening::with('user')
            ->where('nilai_ab_only', false)
            ->latest()
            ->get();

        return view('admin.prescreening', compact('rejections'));
    }

    /**
     * Export PDF keterangan tidak lulus pre-screening (untuk admin).
     */
    public function exportPreScreeningPdf($userId)
    {
        $mahasiswa = User::role('mahasiswa')->findOrFail($userId);
        $preScreen = PreScreening::where('user_id', $userId)
            ->where('nilai_ab_only', false)
            ->firstOrFail();

        $user = $mahasiswa;
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.prescreening-rejected', compact('user'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download(
            'Surat_Keterangan_Tidak_Lulus_3.5_Tahun_'
            . $mahasiswa->username_nim . '_'
            . now()->format('Y-m-d') . '.pdf'
        );
    }

    // ── Helper ──

    /** Generate kode rule berikutnya (R001, R002, ...). */
    private function getNextRuleCode(): string
    {
        $lastRule = Rule::orderBy('id', 'desc')->first();

        if (!$lastRule) {
            return 'R001';
        }

        $lastNumber = (int) substr($lastRule->kode_rule, 1);
        return 'R' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }
}
