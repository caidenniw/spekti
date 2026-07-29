<?php

namespace Database\Seeders;

use App\Models\Rule;
use Illuminate\Database\Seeder;

class RuleSeeder extends Seeder
{
    /**
     * Seed 49 rules sesuai angket pakar.
     * CF_Pakar langsung dari skala keyakinan (SY=1.0, Y=0.8, C=0.6, K=0.4, TY=0.2).
     * Tidak ada MB/MD — CF_Pakar dipilih langsung oleh pakar.
     */
    public function run(): void
    {
        $rules = [
            // ── R1-R7: IPK Tinggi + variabel lain → Lulus ──
            ['kode_rule' => 'R1',  'deskripsi_rule' => 'IF IPK Tinggi THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.80, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R2',  'deskripsi_rule' => 'IF IPK Tinggi AND Proses Pengerjaan Skripsi Lancar THEN Lulus 3,5 Tahun', 'cf_pakar' => 1.00, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R3',  'deskripsi_rule' => 'IF IPK Tinggi AND Dukungan Keluarga Tinggi THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.60, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R4',  'deskripsi_rule' => 'IF IPK Tinggi AND Kualitas Dosen Pembimbing Baik THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.80, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R5',  'deskripsi_rule' => 'IF IPK Tinggi AND Administrasi Perkuliahan Lengkap THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R6',  'deskripsi_rule' => 'IF IPK Tinggi AND Motivasi Diri Tinggi THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R7',  'deskripsi_rule' => 'IF IPK Tinggi AND Referensi Belajar Memadai THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Lulus'],

            // ── R8-R14: Skripsi Terlambat + variabel lain → Tidak Lulus ──
            ['kode_rule' => 'R8',  'deskripsi_rule' => 'IF Proses Pengerjaan Skripsi Terlambat THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.80, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R9',  'deskripsi_rule' => 'IF Proses Pengerjaan Skripsi Terlambat AND IPK Rendah THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.20, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R10', 'deskripsi_rule' => 'IF Proses Pengerjaan Skripsi Terlambat AND Dukungan Keluarga Rendah THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.60, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R11', 'deskripsi_rule' => 'IF Proses Pengerjaan Skripsi Terlambat AND Kualitas Dosen Pembimbing Kurang Baik THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R12', 'deskripsi_rule' => 'IF Proses Pengerjaan Skripsi Terlambat AND Administrasi Tidak Lengkap THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.20, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R13', 'deskripsi_rule' => 'IF Proses Pengerjaan Skripsi Terlambat AND Motivasi Diri Rendah THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R14', 'deskripsi_rule' => 'IF Proses Pengerjaan Skripsi Terlambat AND Referensi Belajar Tidak Memadai THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Tidak Lulus'],

            // ── R15-R21: Dukungan Keluarga Tinggi + variabel lain → Lulus ──
            ['kode_rule' => 'R15', 'deskripsi_rule' => 'IF Dukungan Keluarga Tinggi THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.80, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R16', 'deskripsi_rule' => 'IF Dukungan Keluarga Tinggi AND IPK Tinggi THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.80, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R17', 'deskripsi_rule' => 'IF Dukungan Keluarga Tinggi AND Proses Pengerjaan Skripsi Lancar THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.80, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R18', 'deskripsi_rule' => 'IF Dukungan Keluarga Tinggi AND Kualitas Dosen Pembimbing Baik THEN Lulus 3,5 Tahun', 'cf_pakar' => 1.00, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R19', 'deskripsi_rule' => 'IF Dukungan Keluarga Tinggi AND Administrasi Perkuliahan Lengkap THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.60, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R20', 'deskripsi_rule' => 'IF Dukungan Keluarga Tinggi AND Motivasi Diri Tinggi THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R21', 'deskripsi_rule' => 'IF Dukungan Keluarga Tinggi AND Referensi Belajar Memadai THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Lulus'],

            // ── R22-R28: Kualitas Dosen Kurang Baik + variabel lain → Tidak Lulus ──
            ['kode_rule' => 'R22', 'deskripsi_rule' => 'IF Kualitas Dosen Pembimbing Kurang Baik THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.80, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R23', 'deskripsi_rule' => 'IF Kualitas Dosen Pembimbing Kurang Baik AND IPK Rendah THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R24', 'deskripsi_rule' => 'IF Kualitas Dosen Pembimbing Kurang Baik AND Proses Pengerjaan Skripsi Terlambat THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.20, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R25', 'deskripsi_rule' => 'IF Kualitas Dosen Pembimbing Kurang Baik AND Dukungan Keluarga Rendah THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.60, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R26', 'deskripsi_rule' => 'IF Kualitas Dosen Pembimbing Kurang Baik AND Administrasi Tidak Lengkap THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R27', 'deskripsi_rule' => 'IF Kualitas Dosen Pembimbing Kurang Baik AND Motivasi Diri Rendah THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.20, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R28', 'deskripsi_rule' => 'IF Kualitas Dosen Pembimbing Kurang Baik AND Referensi Belajar Tidak Memadai THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Tidak Lulus'],

            // ── R29-R35: Administrasi Lengkap + variabel lain → Lulus ──
            ['kode_rule' => 'R29', 'deskripsi_rule' => 'IF Administrasi Perkuliahan Lengkap THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.60, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R30', 'deskripsi_rule' => 'IF Administrasi Perkuliahan Lengkap AND IPK Tinggi THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R31', 'deskripsi_rule' => 'IF Administrasi Perkuliahan Lengkap AND Proses Pengerjaan Skripsi Lancar THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.20, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R32', 'deskripsi_rule' => 'IF Administrasi Perkuliahan Lengkap AND Dukungan Keluarga Tinggi THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R33', 'deskripsi_rule' => 'IF Administrasi Perkuliahan Lengkap AND Kualitas Dosen Pembimbing Baik THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.60, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R34', 'deskripsi_rule' => 'IF Administrasi Perkuliahan Lengkap AND Motivasi Diri Tinggi THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R35', 'deskripsi_rule' => 'IF Administrasi Perkuliahan Lengkap AND Referensi Belajar Memadai THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.60, 'status_prediksi' => 'Lulus'],

            // ── R36-R42: Motivasi Rendah + variabel lain → Tidak Lulus ──
            ['kode_rule' => 'R36', 'deskripsi_rule' => 'IF Motivasi Diri Rendah THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.80, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R37', 'deskripsi_rule' => 'IF Motivasi Diri Rendah AND IPK Rendah THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.80, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R38', 'deskripsi_rule' => 'IF Motivasi Diri Rendah AND Proses Pengerjaan Skripsi Terlambat THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.80, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R39', 'deskripsi_rule' => 'IF Motivasi Diri Rendah AND Dukungan Keluarga Rendah THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.80, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R40', 'deskripsi_rule' => 'IF Motivasi Diri Rendah AND Kualitas Dosen Pembimbing Kurang Baik THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.60, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R41', 'deskripsi_rule' => 'IF Motivasi Diri Rendah AND Administrasi Tidak Lengkap THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Tidak Lulus'],
            ['kode_rule' => 'R42', 'deskripsi_rule' => 'IF Motivasi Diri Rendah AND Referensi Belajar Tidak Memadai THEN Tidak Lulus 3,5 Tahun', 'cf_pakar' => 0.60, 'status_prediksi' => 'Tidak Lulus'],

            // ── R43-R49: Referensi Belajar Memadai + variabel lain → Lulus ──
            ['kode_rule' => 'R43', 'deskripsi_rule' => 'IF Referensi Belajar Memadai THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.60, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R44', 'deskripsi_rule' => 'IF Referensi Belajar Memadai AND IPK Tinggi THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.80, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R45', 'deskripsi_rule' => 'IF Referensi Belajar Memadai AND Proses Pengerjaan Skripsi Lancar THEN Lulus 3,5 Tahun', 'cf_pakar' => 1.00, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R46', 'deskripsi_rule' => 'IF Referensi Belajar Memadai AND Dukungan Keluarga Tinggi THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.60, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R47', 'deskripsi_rule' => 'IF Referensi Belajar Memadai AND Kualitas Dosen Pembimbing Baik THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.60, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R48', 'deskripsi_rule' => 'IF Referensi Belajar Memadai AND Administrasi Perkuliahan Lengkap THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Lulus'],
            ['kode_rule' => 'R49', 'deskripsi_rule' => 'IF Referensi Belajar Memadai AND Motivasi Diri Tinggi THEN Lulus 3,5 Tahun', 'cf_pakar' => 0.40, 'status_prediksi' => 'Lulus'],
        ];

        foreach ($rules as $rule) {
            Rule::create($rule);
        }
    }
}
