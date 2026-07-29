<?php

namespace App\Services;

use App\Models\Rule;
use App\Models\StudentVariable;
use App\Models\PredictionResult;

class CFEngineService
{
    /**
     * Definisi mapping kode_rule => kondisi yang harus dipenuhi.
     * Setiap rule punya 1 atau 2 kondisi.
     * Format: [variable_name => expected_value]
     *
     * Sesuai angket pakar — 49 rules (R1-R49).
     */
    private array $ruleConditions = [
        // ── R1-R7: IPK Tinggi + variabel lain → Lulus ──
        'R1'  => ['ipk_status' => 'tinggi'],
        'R2'  => ['ipk_status' => 'tinggi', 'skripsi_status' => 'lancar'],
        'R3'  => ['ipk_status' => 'tinggi', 'dukungan_keluarga' => 'tinggi'],
        'R4'  => ['ipk_status' => 'tinggi', 'kualitas_dosen' => 'baik'],
        'R5'  => ['ipk_status' => 'tinggi', 'administrasi' => 'lengkap'],
        'R6'  => ['ipk_status' => 'tinggi', 'motivasi_diri' => 'tinggi'],
        'R7'  => ['ipk_status' => 'tinggi', 'referensi_belajar' => 'memadai'],

        // ── R8-R14: Skripsi Terlambat + variabel lain → Tidak Lulus ──
        'R8'  => ['skripsi_status' => 'terlambat'],
        'R9'  => ['skripsi_status' => 'terlambat', 'ipk_status' => 'rendah'],
        'R10' => ['skripsi_status' => 'terlambat', 'dukungan_keluarga' => 'rendah'],
        'R11' => ['skripsi_status' => 'terlambat', 'kualitas_dosen' => 'kurang_baik'],
        'R12' => ['skripsi_status' => 'terlambat', 'administrasi' => 'tidak_lengkap'],
        'R13' => ['skripsi_status' => 'terlambat', 'motivasi_diri' => 'rendah'],
        'R14' => ['skripsi_status' => 'terlambat', 'referensi_belajar' => 'tidak_memadai'],

        // ── R15-R21: Dukungan Keluarga Tinggi + variabel lain → Lulus ──
        'R15' => ['dukungan_keluarga' => 'tinggi'],
        'R16' => ['dukungan_keluarga' => 'tinggi', 'ipk_status' => 'tinggi'],
        'R17' => ['dukungan_keluarga' => 'tinggi', 'skripsi_status' => 'lancar'],
        'R18' => ['dukungan_keluarga' => 'tinggi', 'kualitas_dosen' => 'baik'],
        'R19' => ['dukungan_keluarga' => 'tinggi', 'administrasi' => 'lengkap'],
        'R20' => ['dukungan_keluarga' => 'tinggi', 'motivasi_diri' => 'tinggi'],
        'R21' => ['dukungan_keluarga' => 'tinggi', 'referensi_belajar' => 'memadai'],

        // ── R22-R28: Kualitas Dosen Kurang Baik + variabel lain → Tidak Lulus ──
        'R22' => ['kualitas_dosen' => 'kurang_baik'],
        'R23' => ['kualitas_dosen' => 'kurang_baik', 'ipk_status' => 'rendah'],
        'R24' => ['kualitas_dosen' => 'kurang_baik', 'skripsi_status' => 'terlambat'],
        'R25' => ['kualitas_dosen' => 'kurang_baik', 'dukungan_keluarga' => 'rendah'],
        'R26' => ['kualitas_dosen' => 'kurang_baik', 'administrasi' => 'tidak_lengkap'],
        'R27' => ['kualitas_dosen' => 'kurang_baik', 'motivasi_diri' => 'rendah'],
        'R28' => ['kualitas_dosen' => 'kurang_baik', 'referensi_belajar' => 'tidak_memadai'],

        // ── R29-R35: Administrasi Lengkap + variabel lain → Lulus ──
        'R29' => ['administrasi' => 'lengkap'],
        'R30' => ['administrasi' => 'lengkap', 'ipk_status' => 'tinggi'],
        'R31' => ['administrasi' => 'lengkap', 'skripsi_status' => 'lancar'],
        'R32' => ['administrasi' => 'lengkap', 'dukungan_keluarga' => 'tinggi'],
        'R33' => ['administrasi' => 'lengkap', 'kualitas_dosen' => 'baik'],
        'R34' => ['administrasi' => 'lengkap', 'motivasi_diri' => 'tinggi'],
        'R35' => ['administrasi' => 'lengkap', 'referensi_belajar' => 'memadai'],

        // ── R36-R42: Motivasi Rendah + variabel lain → Tidak Lulus ──
        'R36' => ['motivasi_diri' => 'rendah'],
        'R37' => ['motivasi_diri' => 'rendah', 'ipk_status' => 'rendah'],
        'R38' => ['motivasi_diri' => 'rendah', 'skripsi_status' => 'terlambat'],
        'R39' => ['motivasi_diri' => 'rendah', 'dukungan_keluarga' => 'rendah'],
        'R40' => ['motivasi_diri' => 'rendah', 'kualitas_dosen' => 'kurang_baik'],
        'R41' => ['motivasi_diri' => 'rendah', 'administrasi' => 'tidak_lengkap'],
        'R42' => ['motivasi_diri' => 'rendah', 'referensi_belajar' => 'tidak_memadai'],

        // ── R43-R49: Referensi Belajar Memadai + variabel lain → Lulus ──
        'R43' => ['referensi_belajar' => 'memadai'],
        'R44' => ['referensi_belajar' => 'memadai', 'ipk_status' => 'tinggi'],
        'R45' => ['referensi_belajar' => 'memadai', 'skripsi_status' => 'lancar'],
        'R46' => ['referensi_belajar' => 'memadai', 'dukungan_keluarga' => 'tinggi'],
        'R47' => ['referensi_belajar' => 'memadai', 'kualitas_dosen' => 'baik'],
        'R48' => ['referensi_belajar' => 'memadai', 'administrasi' => 'lengkap'],
        'R49' => ['referensi_belajar' => 'memadai', 'motivasi_diri' => 'tinggi'],
    ];

    /**
     * Cek apakah satu rule terpenuhi berdasarkan input mahasiswa.
     */
    public function isRuleMatched(string $kodeRule, array $statusMap): bool
    {
        $conditions = $this->ruleConditions[$kodeRule] ?? null;

        if (!$conditions) {
            return false;
        }

        foreach ($conditions as $variable => $expectedValue) {
            if (($statusMap[$variable] ?? null) !== $expectedValue) {
                return false;
            }
        }

        return true;
    }

    /**
     * Ambil CF_User minimum dari variabel-variabel yang terlibat dalam rule.
     * Pendekatan standar CF theory: min() untuk AND combination.
     */
    public function getCFUserForRule(string $kodeRule, array $cfUserMap): float
    {
        $conditions = $this->ruleConditions[$kodeRule] ?? [];

        if (empty($conditions)) {
            return 0.5;
        }

        $cfValues = [];
        foreach (array_keys($conditions) as $variable) {
            $cfValues[] = $cfUserMap[$variable] ?? 0.5;
        }

        return min($cfValues);
    }

    /**
     * Hitung CF Evidence untuk satu rule.
     * CF_Evidence = CF_Pakar × CF_User
     */
    public function calculateCFEvidence(float $cfPakar, float $cfUser): float
    {
        return round($cfPakar * $cfUser, 4);
    }

    /**
     * Gabungkan beberapa nilai CF_Evidence menjadi satu CF Combined.
     * Rumus iteratif: CF_h = CF_h + CF_baru × (1 - CF_h)
     */
    public function combineCF(array $cfEvidences): float
    {
        $cfCombined = 0.0;

        foreach ($cfEvidences as $cfEvidence) {
            $cfCombined = $cfCombined + $cfEvidence * (1 - $cfCombined);
        }

        return round($cfCombined, 4);
    }

    /**
     * Proses prediksi lengkap.
     *
     * Logika:
     * - Rules Lulus (R1-R7, R15-R21, R29-R35, R43-R49) → CF_Lulus
     * - Rules Tidak Lulus (R8-R14, R22-R28, R36-R42) → CF_TidakLulus
     * - Jika CF_Lulus > CF_TidakLulus → "Lulus 3,5 Tahun"
     * - Jika CF_TidakLulus >= CF_Lulus → "Tidak Lulus 3,5 Tahun"
     * - Persentase = max(CF_Lulus, CF_TidakLulus) × 100
     *
     * @return array{prediction: PredictionResult, matchedRules: array}
     */
    public function predict(StudentVariable $variable): array
    {
        $statusMap = $variable->getStatusMap();
        $cfUserMap = $variable->getCFUserMap();

        $rules = Rule::all()->keyBy('kode_rule');

        // Pisahkan CF_Evidence berdasarkan status prediksi
        $cfLulus = [];
        $cfTidakLulus = [];
        $matchedRules = [];

        foreach ($rules as $kodeRule => $rule) {
            if ($this->isRuleMatched($kodeRule, $statusMap)) {
                $cfUser = $this->getCFUserForRule($kodeRule, $cfUserMap);
                $cfEvidence = $this->calculateCFEvidence((float) $rule->cf_pakar, $cfUser);

                if ($rule->status_prediksi === 'Lulus') {
                    $cfLulus[] = $cfEvidence;
                } else {
                    $cfTidakLulus[] = $cfEvidence;
                }

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

        // Combine masing-masing grup
        $cfLulusCombined = empty($cfLulus) ? 0.0 : $this->combineCF($cfLulus);
        $cfTidakLulusCombined = empty($cfTidakLulus) ? 0.0 : $this->combineCF($cfTidakLulus);

        // Tentukan hasil: bandingkan kedua CF
        $cfLulus > $cfTidakLulus
            ? $hasilPrediksi = 'Lulus 3,5 Tahun'
            : $hasilPrediksi = 'Tidak Lulus 3,5 Tahun';

        // Persentase dari CF yang dominan
        $cfDominan = max($cfLulusCombined, $cfTidakLulusCombined);
        $persentase = $this->getPercentage($cfDominan);

        // Simpan ke database
        $prediction = PredictionResult::create([
            'user_id' => $variable->user_id,
            'student_variable_id' => $variable->id,
            'total_cf_score' => $cfDominan,
            'persentase_keyakinan' => $persentase,
            'hasil_prediksi' => $hasilPrediksi,
            'tanggal_prediksi' => now()->toDateString(),
        ]);

        return [
            'prediction' => $prediction,
            'matchedRules' => $matchedRules,
        ];
    }

    /**
     * Konversi CF Combined ke persentase (0-100).
     */
    public function getPercentage(float $cfCombined): int
    {
        return (int) round($cfCombined * 100);
    }
}
