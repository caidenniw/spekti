-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 30 Jul 2026 pada 10.46
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spekti_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_31_142540_add_role_and_nim_to_users_table', 1),
(5, '2026_05_31_142540_create_rules_table', 1),
(6, '2026_05_31_142540_create_student_variables_table', 1),
(7, '2026_05_31_142541_create_prediction_results_table', 1),
(8, '2026_07_02_000001_remove_mb_md_from_rules_table', 1),
(9, '2026_07_02_000002_update_student_variables_table', 1),
(10, '2026_07_02_000003_create_student_answers_table', 1),
(11, '2026_07_18_000001_add_revision_fields_to_prediction_results', 2),
(12, '2026_07_18_000002_add_revision_rejected_to_prediction_results', 2),
(13, '2026_07_18_000003_create_variables_table', 2),
(14, '2026_07_21_190202_create_pre_screenings_table', 3),
(15, '2026_07_22_162838_add_description_to_variables_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `prediction_results`
--

CREATE TABLE `prediction_results` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `student_variable_id` bigint UNSIGNED NOT NULL,
  `total_cf_score` decimal(5,4) NOT NULL,
  `persentase_keyakinan` int UNSIGNED NOT NULL,
  `hasil_prediksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_prediksi` date NOT NULL,
  `status` enum('active','pending','revision_allowed','revision_rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `revision_requested_at` timestamp NULL DEFAULT NULL,
  `revision_approved_at` timestamp NULL DEFAULT NULL,
  `revision_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `prediction_results`
--

INSERT INTO `prediction_results` (`id`, `user_id`, `student_variable_id`, `total_cf_score`, `persentase_keyakinan`, `hasil_prediksi`, `tanggal_prediksi`, `status`, `revision_requested_at`, `revision_approved_at`, `revision_notes`, `created_at`, `updated_at`) VALUES
(7, 12, 7, 1.0000, 100, 'Lulus 3,5 Tahun', '2026-07-19', 'revision_allowed', '2026-07-22 20:17:45', '2026-07-22 20:18:07', 'salah isi harusnya ada data yang saya isi tingkat keyakinanya', '2026-07-19 06:55:29', '2026-07-22 20:18:07'),
(11, 18, 11, 1.0000, 100, 'Lulus 3,5 Tahun', '2026-07-24', 'active', NULL, NULL, NULL, '2026-07-23 22:06:41', '2026-07-23 22:06:41'),
(12, 19, 12, 0.9999, 100, 'Lulus 3,5 Tahun', '2026-07-24', 'active', NULL, NULL, NULL, '2026-07-23 22:08:58', '2026-07-23 22:08:58'),
(13, 20, 13, 1.0000, 100, 'Lulus 3,5 Tahun', '2026-07-24', 'active', NULL, NULL, NULL, '2026-07-23 22:10:15', '2026-07-23 22:10:15'),
(14, 21, 14, 1.0000, 100, 'Lulus 3,5 Tahun', '2026-07-24', 'active', NULL, NULL, NULL, '2026-07-23 22:11:24', '2026-07-23 22:11:24'),
(15, 22, 15, 1.0000, 100, 'Lulus 3,5 Tahun', '2026-07-24', 'active', NULL, NULL, NULL, '2026-07-23 22:12:30', '2026-07-23 22:12:30'),
(16, 23, 16, 1.0000, 100, 'Lulus 3,5 Tahun', '2026-07-24', 'active', NULL, NULL, NULL, '2026-07-23 22:13:47', '2026-07-23 22:13:47'),
(17, 27, 17, 1.0000, 100, 'Lulus 3,5 Tahun', '2026-07-24', 'active', NULL, NULL, NULL, '2026-07-23 22:15:09', '2026-07-23 22:15:09'),
(18, 24, 18, 1.0000, 100, 'Lulus 3,5 Tahun', '2026-07-24', 'active', NULL, NULL, NULL, '2026-07-23 22:16:35', '2026-07-23 22:16:35'),
(19, 25, 19, 1.0000, 100, 'Lulus 3,5 Tahun', '2026-07-24', 'active', NULL, NULL, NULL, '2026-07-23 22:18:07', '2026-07-23 22:18:07'),
(20, 26, 20, 1.0000, 100, 'Lulus 3,5 Tahun', '2026-07-24', 'active', NULL, NULL, NULL, '2026-07-23 22:19:37', '2026-07-23 22:19:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pre_screenings`
--

CREATE TABLE `pre_screenings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nilai_ab_only` tinyint(1) NOT NULL COMMENT 'true = nilai A/B saja, false = ada C/D/E',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pre_screenings`
--

INSERT INTO `pre_screenings` (`id`, `user_id`, `nilai_ab_only`, `created_at`, `updated_at`) VALUES
(2, 12, 1, '2026-07-22 20:18:32', '2026-07-22 20:18:32'),
(5, 18, 1, '2026-07-23 22:05:35', '2026-07-23 22:05:35'),
(6, 19, 1, '2026-07-23 22:07:34', '2026-07-23 22:07:34'),
(7, 20, 1, '2026-07-23 22:09:35', '2026-07-23 22:09:35'),
(8, 21, 1, '2026-07-23 22:10:39', '2026-07-23 22:10:39'),
(9, 22, 1, '2026-07-23 22:11:56', '2026-07-23 22:11:56'),
(10, 23, 1, '2026-07-23 22:12:58', '2026-07-23 22:12:58'),
(11, 27, 1, '2026-07-23 22:14:25', '2026-07-23 22:14:25'),
(12, 24, 1, '2026-07-23 22:15:45', '2026-07-23 22:15:45'),
(13, 25, 1, '2026-07-23 22:17:19', '2026-07-23 22:17:19'),
(14, 26, 1, '2026-07-23 22:18:41', '2026-07-23 22:18:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rules`
--

CREATE TABLE `rules` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_rule` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_rule` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cf_pakar` decimal(3,2) NOT NULL,
  `status_prediksi` enum('Lulus','Tidak Lulus') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rules`
--

INSERT INTO `rules` (`id`, `kode_rule`, `deskripsi_rule`, `cf_pakar`, `status_prediksi`, `created_at`, `updated_at`) VALUES
(1, 'R1', 'IF IPK Tinggi THEN Lulus 3,5 Tahun', 0.80, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(2, 'R2', 'IF IPK Tinggi AND Proses Pengerjaan Skripsi Lancar THEN Lulus 3,5 Tahun', 1.00, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(3, 'R3', 'IF IPK Tinggi AND Dukungan Keluarga Tinggi THEN Lulus 3,5 Tahun', 0.60, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(4, 'R4', 'IF IPK Tinggi AND Kualitas Dosen Pembimbing Baik THEN Lulus 3,5 Tahun', 0.80, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(5, 'R5', 'IF IPK Tinggi AND Administrasi Perkuliahan Lengkap THEN Lulus 3,5 Tahun', 0.40, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(6, 'R6', 'IF IPK Tinggi AND Motivasi Diri Tinggi THEN Lulus 3,5 Tahun', 0.40, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(7, 'R7', 'IF IPK Tinggi AND Referensi Belajar Memadai THEN Lulus 3,5 Tahun', 0.40, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(8, 'R8', 'IF Proses Pengerjaan Skripsi Terlambat THEN Tidak Lulus 3,5 Tahun', 0.80, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(9, 'R9', 'IF Proses Pengerjaan Skripsi Terlambat AND IPK Rendah THEN Tidak Lulus 3,5 Tahun', 0.20, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(10, 'R10', 'IF Proses Pengerjaan Skripsi Terlambat AND Dukungan Keluarga Rendah THEN Tidak Lulus 3,5 Tahun', 0.60, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(11, 'R11', 'IF Proses Pengerjaan Skripsi Terlambat AND Kualitas Dosen Pembimbing Kurang Baik THEN Tidak Lulus 3,5 Tahun', 0.40, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(12, 'R12', 'IF Proses Pengerjaan Skripsi Terlambat AND Administrasi Tidak Lengkap THEN Tidak Lulus 3,5 Tahun', 0.20, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(13, 'R13', 'IF Proses Pengerjaan Skripsi Terlambat AND Motivasi Diri Rendah THEN Tidak Lulus 3,5 Tahun', 0.40, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(14, 'R14', 'IF Proses Pengerjaan Skripsi Terlambat AND Referensi Belajar Tidak Memadai THEN Tidak Lulus 3,5 Tahun', 0.40, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(15, 'R15', 'IF Dukungan Keluarga Tinggi THEN Lulus 3,5 Tahun', 0.80, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(16, 'R16', 'IF Dukungan Keluarga Tinggi AND IPK Tinggi THEN Lulus 3,5 Tahun', 0.80, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(17, 'R17', 'IF Dukungan Keluarga Tinggi AND Proses Pengerjaan Skripsi Lancar THEN Lulus 3,5 Tahun', 0.80, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(18, 'R18', 'IF Dukungan Keluarga Tinggi AND Kualitas Dosen Pembimbing Baik THEN Lulus 3,5 Tahun', 1.00, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(19, 'R19', 'IF Dukungan Keluarga Tinggi AND Administrasi Perkuliahan Lengkap THEN Lulus 3,5 Tahun', 0.60, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(20, 'R20', 'IF Dukungan Keluarga Tinggi AND Motivasi Diri Tinggi THEN Lulus 3,5 Tahun', 0.40, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(21, 'R21', 'IF Dukungan Keluarga Tinggi AND Referensi Belajar Memadai THEN Lulus 3,5 Tahun', 0.40, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(22, 'R22', 'IF Kualitas Dosen Pembimbing Kurang Baik THEN Tidak Lulus 3,5 Tahun', 0.80, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(23, 'R23', 'IF Kualitas Dosen Pembimbing Kurang Baik AND IPK Rendah THEN Tidak Lulus 3,5 Tahun', 0.40, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(24, 'R24', 'IF Kualitas Dosen Pembimbing Kurang Baik AND Proses Pengerjaan Skripsi Terlambat THEN Tidak Lulus 3,5 Tahun', 0.20, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(25, 'R25', 'IF Kualitas Dosen Pembimbing Kurang Baik AND Dukungan Keluarga Rendah THEN Tidak Lulus 3,5 Tahun', 0.60, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(26, 'R26', 'IF Kualitas Dosen Pembimbing Kurang Baik AND Administrasi Tidak Lengkap THEN Tidak Lulus 3,5 Tahun', 0.40, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(27, 'R27', 'IF Kualitas Dosen Pembimbing Kurang Baik AND Motivasi Diri Rendah THEN Tidak Lulus 3,5 Tahun', 0.20, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(28, 'R28', 'IF Kualitas Dosen Pembimbing Kurang Baik AND Referensi Belajar Tidak Memadai THEN Tidak Lulus 3,5 Tahun', 0.40, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(29, 'R29', 'IF Administrasi Perkuliahan Lengkap THEN Lulus 3,5 Tahun', 0.60, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(30, 'R30', 'IF Administrasi Perkuliahan Lengkap AND IPK Tinggi THEN Lulus 3,5 Tahun', 0.40, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(31, 'R31', 'IF Administrasi Perkuliahan Lengkap AND Proses Pengerjaan Skripsi Lancar THEN Lulus 3,5 Tahun', 0.20, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(32, 'R32', 'IF Administrasi Perkuliahan Lengkap AND Dukungan Keluarga Tinggi THEN Lulus 3,5 Tahun', 0.40, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(33, 'R33', 'IF Administrasi Perkuliahan Lengkap AND Kualitas Dosen Pembimbing Baik THEN Lulus 3,5 Tahun', 0.60, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(34, 'R34', 'IF Administrasi Perkuliahan Lengkap AND Motivasi Diri Tinggi THEN Lulus 3,5 Tahun', 0.40, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(35, 'R35', 'IF Administrasi Perkuliahan Lengkap AND Referensi Belajar Memadai THEN Lulus 3,5 Tahun', 0.60, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(36, 'R36', 'IF Motivasi Diri Rendah THEN Tidak Lulus 3,5 Tahun', 0.80, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(37, 'R37', 'IF Motivasi Diri Rendah AND IPK Rendah THEN Tidak Lulus 3,5 Tahun', 0.80, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(38, 'R38', 'IF Motivasi Diri Rendah AND Proses Pengerjaan Skripsi Terlambat THEN Tidak Lulus 3,5 Tahun', 0.80, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(39, 'R39', 'IF Motivasi Diri Rendah AND Dukungan Keluarga Rendah THEN Tidak Lulus 3,5 Tahun', 0.80, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(40, 'R40', 'IF Motivasi Diri Rendah AND Kualitas Dosen Pembimbing Kurang Baik THEN Tidak Lulus 3,5 Tahun', 0.60, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(41, 'R41', 'IF Motivasi Diri Rendah AND Administrasi Tidak Lengkap THEN Tidak Lulus 3,5 Tahun', 0.40, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(42, 'R42', 'IF Motivasi Diri Rendah AND Referensi Belajar Tidak Memadai THEN Tidak Lulus 3,5 Tahun', 0.60, 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(43, 'R43', 'IF Referensi Belajar Memadai THEN Lulus 3,5 Tahun', 0.60, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(44, 'R44', 'IF Referensi Belajar Memadai AND IPK Tinggi THEN Lulus 3,5 Tahun', 0.80, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(45, 'R45', 'IF Referensi Belajar Memadai AND Proses Pengerjaan Skripsi Lancar THEN Lulus 3,5 Tahun', 1.00, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(46, 'R46', 'IF Referensi Belajar Memadai AND Dukungan Keluarga Tinggi THEN Lulus 3,5 Tahun', 0.60, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(47, 'R47', 'IF Referensi Belajar Memadai AND Kualitas Dosen Pembimbing Baik THEN Lulus 3,5 Tahun', 0.60, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(48, 'R48', 'IF Referensi Belajar Memadai AND Administrasi Perkuliahan Lengkap THEN Lulus 3,5 Tahun', 0.40, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(49, 'R49', 'IF Referensi Belajar Memadai AND Motivasi Diri Tinggi THEN Lulus 3,5 Tahun', 0.40, 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('tmL1dzleO62c9HHFWf7fvbwciWeaHs9ClY0zZqvz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRzB1SkFNYkVFa3V1MEFGTmV0OHNxNXpocG5jdU9OWmROMXNUZGJRYiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1785381336);

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_answers`
--

CREATE TABLE `student_answers` (
  `id` bigint UNSIGNED NOT NULL,
  `student_variable_id` bigint UNSIGNED NOT NULL,
  `variable_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `variable_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cf_user` decimal(3,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `student_answers`
--

INSERT INTO `student_answers` (`id`, `student_variable_id`, `variable_name`, `variable_value`, `cf_user`, `created_at`, `updated_at`) VALUES
(43, 7, 'ipk_status', 'tinggi', 1.00, '2026-07-19 06:55:29', '2026-07-19 06:55:29'),
(44, 7, 'skripsi_status', 'terlambat', 1.00, '2026-07-19 06:55:29', '2026-07-19 06:55:29'),
(45, 7, 'dukungan_keluarga', 'tinggi', 0.80, '2026-07-19 06:55:29', '2026-07-19 06:55:29'),
(46, 7, 'kualitas_dosen', 'baik', 0.80, '2026-07-19 06:55:29', '2026-07-19 06:55:29'),
(47, 7, 'administrasi', 'lengkap', 0.60, '2026-07-19 06:55:29', '2026-07-19 06:55:29'),
(48, 7, 'motivasi_diri', 'tinggi', 0.80, '2026-07-19 06:55:29', '2026-07-19 06:55:29'),
(49, 7, 'referensi_belajar', 'memadai', 0.60, '2026-07-19 06:55:29', '2026-07-19 06:55:29'),
(71, 11, 'ipk_status', 'tinggi', 1.00, '2026-07-23 22:06:41', '2026-07-23 22:06:41'),
(72, 11, 'skripsi_status', 'lancar', 0.60, '2026-07-23 22:06:41', '2026-07-23 22:06:41'),
(73, 11, 'dukungan_keluarga', 'tinggi', 0.60, '2026-07-23 22:06:41', '2026-07-23 22:06:41'),
(74, 11, 'kualitas_dosen', 'baik', 0.40, '2026-07-23 22:06:41', '2026-07-23 22:06:41'),
(75, 11, 'administrasi', 'lengkap', 0.80, '2026-07-23 22:06:41', '2026-07-23 22:06:41'),
(76, 11, 'motivasi_diri', 'tinggi', 0.60, '2026-07-23 22:06:41', '2026-07-23 22:06:41'),
(77, 11, 'referensi_belajar', 'memadai', 0.80, '2026-07-23 22:06:41', '2026-07-23 22:06:41'),
(78, 12, 'ipk_status', 'tinggi', 1.00, '2026-07-23 22:08:58', '2026-07-23 22:08:58'),
(79, 12, 'skripsi_status', 'lancar', 0.60, '2026-07-23 22:08:58', '2026-07-23 22:08:58'),
(80, 12, 'dukungan_keluarga', 'tinggi', 0.60, '2026-07-23 22:08:58', '2026-07-23 22:08:58'),
(81, 12, 'kualitas_dosen', 'baik', 0.40, '2026-07-23 22:08:58', '2026-07-23 22:08:58'),
(82, 12, 'administrasi', 'lengkap', 0.80, '2026-07-23 22:08:58', '2026-07-23 22:08:58'),
(83, 12, 'motivasi_diri', 'tinggi', 0.60, '2026-07-23 22:08:58', '2026-07-23 22:08:58'),
(84, 12, 'referensi_belajar', 'tidak_memadai', 0.60, '2026-07-23 22:08:58', '2026-07-23 22:08:58'),
(85, 13, 'ipk_status', 'tinggi', 0.80, '2026-07-23 22:10:15', '2026-07-23 22:10:15'),
(86, 13, 'skripsi_status', 'lancar', 0.80, '2026-07-23 22:10:15', '2026-07-23 22:10:15'),
(87, 13, 'dukungan_keluarga', 'tinggi', 1.00, '2026-07-23 22:10:15', '2026-07-23 22:10:15'),
(88, 13, 'kualitas_dosen', 'baik', 0.80, '2026-07-23 22:10:15', '2026-07-23 22:10:15'),
(89, 13, 'administrasi', 'lengkap', 0.80, '2026-07-23 22:10:15', '2026-07-23 22:10:15'),
(90, 13, 'motivasi_diri', 'tinggi', 0.80, '2026-07-23 22:10:15', '2026-07-23 22:10:15'),
(91, 13, 'referensi_belajar', 'memadai', 1.00, '2026-07-23 22:10:15', '2026-07-23 22:10:15'),
(92, 14, 'ipk_status', 'tinggi', 1.00, '2026-07-23 22:11:24', '2026-07-23 22:11:24'),
(93, 14, 'skripsi_status', 'lancar', 0.80, '2026-07-23 22:11:24', '2026-07-23 22:11:24'),
(94, 14, 'dukungan_keluarga', 'tinggi', 1.00, '2026-07-23 22:11:24', '2026-07-23 22:11:24'),
(95, 14, 'kualitas_dosen', 'baik', 0.60, '2026-07-23 22:11:24', '2026-07-23 22:11:24'),
(96, 14, 'administrasi', 'lengkap', 0.80, '2026-07-23 22:11:24', '2026-07-23 22:11:24'),
(97, 14, 'motivasi_diri', 'tinggi', 1.00, '2026-07-23 22:11:24', '2026-07-23 22:11:24'),
(98, 14, 'referensi_belajar', 'tidak_memadai', 0.60, '2026-07-23 22:11:24', '2026-07-23 22:11:24'),
(99, 15, 'ipk_status', 'tinggi', 1.00, '2026-07-23 22:12:30', '2026-07-23 22:12:30'),
(100, 15, 'skripsi_status', 'lancar', 1.00, '2026-07-23 22:12:30', '2026-07-23 22:12:30'),
(101, 15, 'dukungan_keluarga', 'tinggi', 1.00, '2026-07-23 22:12:30', '2026-07-23 22:12:30'),
(102, 15, 'kualitas_dosen', 'baik', 1.00, '2026-07-23 22:12:30', '2026-07-23 22:12:30'),
(103, 15, 'administrasi', 'lengkap', 1.00, '2026-07-23 22:12:30', '2026-07-23 22:12:30'),
(104, 15, 'motivasi_diri', 'tinggi', 1.00, '2026-07-23 22:12:30', '2026-07-23 22:12:30'),
(105, 15, 'referensi_belajar', 'memadai', 1.00, '2026-07-23 22:12:30', '2026-07-23 22:12:30'),
(106, 16, 'ipk_status', 'tinggi', 0.60, '2026-07-23 22:13:47', '2026-07-23 22:13:47'),
(107, 16, 'skripsi_status', 'lancar', 0.60, '2026-07-23 22:13:47', '2026-07-23 22:13:47'),
(108, 16, 'dukungan_keluarga', 'tinggi', 0.40, '2026-07-23 22:13:47', '2026-07-23 22:13:47'),
(109, 16, 'kualitas_dosen', 'baik', 0.60, '2026-07-23 22:13:47', '2026-07-23 22:13:47'),
(110, 16, 'administrasi', 'lengkap', 0.60, '2026-07-23 22:13:47', '2026-07-23 22:13:47'),
(111, 16, 'motivasi_diri', 'tinggi', 0.60, '2026-07-23 22:13:47', '2026-07-23 22:13:47'),
(112, 16, 'referensi_belajar', 'memadai', 0.60, '2026-07-23 22:13:47', '2026-07-23 22:13:47'),
(113, 17, 'ipk_status', 'tinggi', 0.60, '2026-07-23 22:15:09', '2026-07-23 22:15:09'),
(114, 17, 'skripsi_status', 'lancar', 0.60, '2026-07-23 22:15:09', '2026-07-23 22:15:09'),
(115, 17, 'dukungan_keluarga', 'tinggi', 0.40, '2026-07-23 22:15:09', '2026-07-23 22:15:09'),
(116, 17, 'kualitas_dosen', 'baik', 0.80, '2026-07-23 22:15:09', '2026-07-23 22:15:09'),
(117, 17, 'administrasi', 'lengkap', 0.60, '2026-07-23 22:15:09', '2026-07-23 22:15:09'),
(118, 17, 'motivasi_diri', 'tinggi', 0.60, '2026-07-23 22:15:09', '2026-07-23 22:15:09'),
(119, 17, 'referensi_belajar', 'memadai', 1.00, '2026-07-23 22:15:09', '2026-07-23 22:15:09'),
(120, 18, 'ipk_status', 'tinggi', 1.00, '2026-07-23 22:16:35', '2026-07-23 22:16:35'),
(121, 18, 'skripsi_status', 'lancar', 0.60, '2026-07-23 22:16:35', '2026-07-23 22:16:35'),
(122, 18, 'dukungan_keluarga', 'tinggi', 0.80, '2026-07-23 22:16:35', '2026-07-23 22:16:35'),
(123, 18, 'kualitas_dosen', 'baik', 0.60, '2026-07-23 22:16:35', '2026-07-23 22:16:35'),
(124, 18, 'administrasi', 'lengkap', 0.80, '2026-07-23 22:16:35', '2026-07-23 22:16:35'),
(125, 18, 'motivasi_diri', 'tinggi', 0.60, '2026-07-23 22:16:35', '2026-07-23 22:16:35'),
(126, 18, 'referensi_belajar', 'memadai', 0.20, '2026-07-23 22:16:35', '2026-07-23 22:16:35'),
(127, 19, 'ipk_status', 'tinggi', 1.00, '2026-07-23 22:18:07', '2026-07-23 22:18:07'),
(128, 19, 'skripsi_status', 'lancar', 0.60, '2026-07-23 22:18:07', '2026-07-23 22:18:07'),
(129, 19, 'dukungan_keluarga', 'tinggi', 1.00, '2026-07-23 22:18:07', '2026-07-23 22:18:07'),
(130, 19, 'kualitas_dosen', 'baik', 0.60, '2026-07-23 22:18:07', '2026-07-23 22:18:07'),
(131, 19, 'administrasi', 'tidak_lengkap', 0.40, '2026-07-23 22:18:07', '2026-07-23 22:18:07'),
(132, 19, 'motivasi_diri', 'tinggi', 0.60, '2026-07-23 22:18:07', '2026-07-23 22:18:07'),
(133, 19, 'referensi_belajar', 'memadai', 0.40, '2026-07-23 22:18:07', '2026-07-23 22:18:07'),
(134, 20, 'ipk_status', 'tinggi', 1.00, '2026-07-23 22:19:37', '2026-07-23 22:19:37'),
(135, 20, 'skripsi_status', 'lancar', 0.40, '2026-07-23 22:19:37', '2026-07-23 22:19:37'),
(136, 20, 'dukungan_keluarga', 'tinggi', 1.00, '2026-07-23 22:19:37', '2026-07-23 22:19:37'),
(137, 20, 'kualitas_dosen', 'baik', 0.60, '2026-07-23 22:19:37', '2026-07-23 22:19:37'),
(138, 20, 'administrasi', 'tidak_lengkap', 0.80, '2026-07-23 22:19:37', '2026-07-23 22:19:37'),
(139, 20, 'motivasi_diri', 'tinggi', 0.60, '2026-07-23 22:19:37', '2026-07-23 22:19:37'),
(140, 20, 'referensi_belajar', 'memadai', 0.60, '2026-07-23 22:19:37', '2026-07-23 22:19:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_variables`
--

CREATE TABLE `student_variables` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ipk_status` enum('tinggi','rendah') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `skripsi_status` enum('lancar','terlambat') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dukungan_keluarga` enum('tinggi','rendah') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kualitas_dosen` enum('baik','kurang_baik') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `administrasi` enum('lengkap','tidak_lengkap') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `motivasi_diri` enum('tinggi','rendah') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `referensi_belajar` enum('memadai','tidak_memadai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `student_variables`
--

INSERT INTO `student_variables` (`id`, `user_id`, `ipk_status`, `skripsi_status`, `dukungan_keluarga`, `kualitas_dosen`, `administrasi`, `motivasi_diri`, `referensi_belajar`, `created_at`, `updated_at`) VALUES
(7, 12, 'tinggi', 'terlambat', 'tinggi', 'baik', 'lengkap', 'tinggi', 'memadai', '2026-07-19 06:55:29', '2026-07-19 06:55:29'),
(11, 18, 'tinggi', 'lancar', 'tinggi', 'baik', 'lengkap', 'tinggi', 'memadai', '2026-07-23 22:06:41', '2026-07-23 22:06:41'),
(12, 19, 'tinggi', 'lancar', 'tinggi', 'baik', 'lengkap', 'tinggi', 'tidak_memadai', '2026-07-23 22:08:58', '2026-07-23 22:08:58'),
(13, 20, 'tinggi', 'lancar', 'tinggi', 'baik', 'lengkap', 'tinggi', 'memadai', '2026-07-23 22:10:15', '2026-07-23 22:10:15'),
(14, 21, 'tinggi', 'lancar', 'tinggi', 'baik', 'lengkap', 'tinggi', 'tidak_memadai', '2026-07-23 22:11:24', '2026-07-23 22:11:24'),
(15, 22, 'tinggi', 'lancar', 'tinggi', 'baik', 'lengkap', 'tinggi', 'memadai', '2026-07-23 22:12:30', '2026-07-23 22:12:30'),
(16, 23, 'tinggi', 'lancar', 'tinggi', 'baik', 'lengkap', 'tinggi', 'memadai', '2026-07-23 22:13:47', '2026-07-23 22:13:47'),
(17, 27, 'tinggi', 'lancar', 'tinggi', 'baik', 'lengkap', 'tinggi', 'memadai', '2026-07-23 22:15:09', '2026-07-23 22:15:09'),
(18, 24, 'tinggi', 'lancar', 'tinggi', 'baik', 'lengkap', 'tinggi', 'memadai', '2026-07-23 22:16:35', '2026-07-23 22:16:35'),
(19, 25, 'tinggi', 'lancar', 'tinggi', 'baik', 'tidak_lengkap', 'tinggi', 'memadai', '2026-07-23 22:18:07', '2026-07-23 22:18:07'),
(20, 26, 'tinggi', 'lancar', 'tinggi', 'baik', 'tidak_lengkap', 'tinggi', 'memadai', '2026-07-23 22:19:37', '2026-07-23 22:19:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','mahasiswa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mahasiswa',
  `username_nim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `angkatan` int DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `username_nim`, `angkatan`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'admin', NULL, '$2y$12$Lswhv.BJHEyG/nZ6Lm0GDeHrVQFJ.zGewRfDZSrdpKIHbM6H2lZHS', NULL, '2026-07-02 09:15:36', '2026-07-02 09:15:36'),
(12, 'Tiwi', 'mahasiswa', '2522105', 2022, '$2y$12$LZqHHadnDKBCcDjd2FVccuuNuc4T/j31KVRZTdY/ZDGw9MykfhVfq', NULL, '2026-07-19 06:53:25', '2026-07-19 06:53:25'),
(18, 'Mutiara Rahmadina', 'mahasiswa', '2523197', 2023, '$2y$12$9cvnECn4vUZIkqKKdmnmkOMkXyDziyAvoXBIZ37dWlEiGqNOaEe9q', NULL, '2026-07-23 21:57:24', '2026-07-23 21:57:24'),
(19, 'Achmad Syafi\'i Hasibuan', 'mahasiswa', '2523188', 2023, '$2y$12$HSMe8Um6sOIR84qkvX/oue3P4rpCmooCUVbz/sagBOJg/XWesqPwq', NULL, '2026-07-23 21:58:22', '2026-07-23 21:58:22'),
(20, 'Ahmad Zidan Aulia', 'mahasiswa', '2523185', 2023, '$2y$12$xZx9iaDi/pWPtKCigIVIT.b4/r83ukG4cMwT9g/.sTmLI3rMNl6mO', NULL, '2026-07-23 21:59:11', '2026-07-23 21:59:11'),
(21, 'Husnul Khotimah', 'mahasiswa', '2523186', 2023, '$2y$12$yp7/QFgKUUY2qRkP0ad5xOccd.lwbMZ/.PgQluAqy.ohNZFF3nNta', NULL, '2026-07-23 21:59:59', '2026-07-23 21:59:59'),
(22, 'Putri Fajriani Salsabila', 'mahasiswa', '2523110', 2023, '$2y$12$CcaOmvN7POLaipNG.yrEludncFmOI4CtUHhS2sockK/5BxmaAYsOm', NULL, '2026-07-23 22:00:50', '2026-07-23 22:01:06'),
(23, 'Muhammad Alfiz Aziz', 'mahasiswa', '2523114', 2023, '$2y$12$qrodltqjySSTVdsUnsGEPOajtUhEFYEBRYyPy/wgF2Jv.XvFSc1U6', NULL, '2026-07-23 22:01:49', '2026-07-23 22:01:49'),
(24, 'Azka Khalillah Umah', 'mahasiswa', '2523010', 2023, '$2y$12$GnAF.Z9CZaiu0gFvzqzdL.zT66/4T04mTjl/NTjI/zocC8WEYdE76', NULL, '2026-07-23 22:02:32', '2026-07-23 22:02:32'),
(25, 'Suci Nurhaliza', 'mahasiswa', '2523102', 2023, '$2y$12$A09mJ9GhYRTUE.ICd27gO.SjAAWnhRIO0o8ts.yLvdBOGeAym54Xu', NULL, '2026-07-23 22:03:14', '2026-07-23 22:03:14'),
(26, 'Mutiara Delvia', 'mahasiswa', '2523289', 2023, '$2y$12$YJA3IJZqk9QQIonLqvSh9eKnW7E6TTNVB3Cf9PseCorVYGkNk3pQm', NULL, '2026-07-23 22:04:01', '2026-07-23 22:04:01'),
(27, 'Irma Yolanda', 'mahasiswa', '2523141', 2023, '$2y$12$4ROkfmMhzPHcgmLM.njM8e5nVx2JXn8mssvkzo2.q5ahYim.9R2pS', NULL, '2026-07-23 22:04:52', '2026-07-23 22:04:52'),
(30, 'Rahmi Hidayati', 'mahasiswa', '2523279', 2023, '$2y$12$eyL1MVsqGeZhl8x1i.j3L.9OCVSucWlNOK0xnuyUX6BYL9TOzpSIG', NULL, '2026-07-29 19:41:57', '2026-07-29 19:41:57'),
(31, 'Salsabila', 'mahasiswa', '2523254', 2023, '$2y$12$z/UkoHxDBOkEZ0jMhhUVbemrZ39ibDNd3cygbDkW5zT4CA7iNFOkO', NULL, '2026-07-29 19:42:39', '2026-07-29 19:42:39'),
(32, 'Anisa Azahra', 'mahasiswa', '2523202', 2023, '$2y$12$whTCVmxbOkTfLzWwee9EuuW2qsVOX1NcxOk3cy3MQ39vwmPfVwlqC', NULL, '2026-07-29 19:45:41', '2026-07-29 19:45:41'),
(33, 'Irhaz Salim', 'mahasiswa', '2523119', 2023, '$2y$12$TopGzIVgRpnnCwnBk2XCIOrWw2LA058AofN/oh/3DubhXvqF2iUum', NULL, '2026-07-29 19:46:25', '2026-07-29 19:46:25'),
(34, 'Ori Rahman Tanjung', 'mahasiswa', '2523113', 2023, '$2y$12$4YKVXBpLe7fdDL/RmFog6.LDsqau2LDp3sL8zr66YGU0fmDeIADLO', NULL, '2026-07-29 19:47:08', '2026-07-29 19:47:08'),
(35, 'Kayla Syafira', 'mahasiswa', '2523123', 2023, '$2y$12$4PBpDLXCdsvPxzd.4CXlsOVD2PcbgaL.AIEf6/CsXWnVS5TaHMBke', NULL, '2026-07-29 19:48:11', '2026-07-29 19:48:11'),
(36, 'Fadhil Hafizurrahman', 'mahasiswa', '2523145', 2023, '$2y$12$J8Oio0XN5.y7pGCSC6jK1.euCzHVa3ivnQfP0Zr.ReZOzfeRxu7RK', NULL, '2026-07-29 19:49:16', '2026-07-29 19:49:16'),
(37, 'Hayati Harahap', 'mahasiswa', '2523200', 2023, '$2y$12$fm/c2eQAFtlSEzVwXKVoNeyIVldE.APt.WaokJw8F6Yz4taIrRWzS', NULL, '2026-07-29 19:51:08', '2026-07-29 19:51:08'),
(38, 'Mei Yugita Ningsih', 'mahasiswa', '2523284', 2023, '$2y$12$lhKrmPsFjiERoO5XTdOTReBp1fgPNT2HOJSREDaNGXE/atqc2/Ld2', NULL, '2026-07-29 19:51:49', '2026-07-29 19:51:49'),
(39, 'Azizah Wulandari', 'mahasiswa', '2523142', 2023, '$2y$12$m8uXjD7tIV9.XV1Iv5iJJ.QHqzfsU/YCxBkhOg7u7g3P64rnn4.2i', NULL, '2026-07-29 19:52:26', '2026-07-29 19:52:26'),
(40, 'Regina', 'mahasiswa', '2523214', 2023, '$2y$12$1nq8M5TXZJE7eUnJMWhnkek4C2LksMgICacYZ2vdYxCEZ20hyim.G', NULL, '2026-07-29 19:53:09', '2026-07-29 19:53:09'),
(41, 'Lailatul Zikri', 'mahasiswa', '2523054', 2023, '$2y$12$waWLZ1LFILrnXHeIszLAs.e5kssgatHUe0WyKNpC3C.Uc2cagL/Cu', NULL, '2026-07-29 19:54:34', '2026-07-29 19:54:34'),
(42, 'Al Hadia', 'mahasiswa', '2523271', 2023, '$2y$12$Kj3H6FaGwZxp/dzN2Pchgu/PrjWM.oJTANMmSQ8z//JYdOXovQ3Aa', NULL, '2026-07-29 19:55:09', '2026-07-29 19:55:09'),
(43, 'Aisya Nailussalamah', 'mahasiswa', '2523220', 2023, '$2y$12$9ma4/XdzQvpAY8wQsUDLGuXhCetGT8GVuFXKEfvaOv5F3eFJyvCpy', NULL, '2026-07-29 19:55:52', '2026-07-29 19:55:52'),
(44, 'Raisyafa Ihsan', 'mahasiswa', '2523187', 2023, '$2y$12$3PE7dzYJF5hp4M1BIsMnbO3Ygj0reOjTvhcSABza.qRVxSiCOSfom', NULL, '2026-07-29 19:56:43', '2026-07-29 19:56:43'),
(45, 'Lutfia Dwi Yanti', 'mahasiswa', '2523179', 2023, '$2y$12$8KwhtGoFrlfPkiRd3GoNPewmZx9bnOQM5FadXGAnkFfMRQoyRjnT6', NULL, '2026-07-29 19:57:30', '2026-07-29 19:57:30'),
(46, 'Aulia', 'mahasiswa', '2523156', 2023, '$2y$12$U2hxbNtT6VPbaYSzUg8ECOxgsNGROXIyobsPFx3.wtbx5ZrwOPAta', NULL, '2026-07-29 19:58:01', '2026-07-29 19:58:01'),
(47, 'Muhammad Fauzi', 'mahasiswa', '2523201', 2023, '$2y$12$1VFpUXh7rqhDRkwPuKNkl.pqrSk.cXH0DRj86lLiizOOSFv3UwKYe', NULL, '2026-07-29 19:59:21', '2026-07-29 19:59:21'),
(48, 'Dzikra Pinapsika', 'mahasiswa', '2523215', 2023, '$2y$12$cvDH/dznU3Je0OVNbpC23eG4e7bndJEnGxgvo5oVBO1mGbk8c2PGG', NULL, '2026-07-29 20:00:02', '2026-07-29 20:00:02'),
(49, 'Hudzaifi Arvan Hasibuan', 'mahasiswa', '2523213', 2023, '$2y$12$nDCHfnlGr8arGqun5IdPduki2RcQDoSJYiUIUdn.Ud90i8Sr9WlQ6', NULL, '2026-07-29 20:01:14', '2026-07-29 20:01:14'),
(50, 'Apris Zulyan', 'mahasiswa', '2523130', 2023, '$2y$12$PcxLMRAMyPmdG1iYtssE1usSWNCrtST41fxhaTWqmEFRwSzhd0LYa', NULL, '2026-07-29 20:01:49', '2026-07-29 20:01:49'),
(51, 'Ongky Isginanda', 'mahasiswa', '2523204', 2023, '$2y$12$Xq5eK9BR7ZpxsFdIJy9XFOr6lii5GOoECzzAQd9HHC9GA47Z.Eot6', NULL, '2026-07-29 20:02:28', '2026-07-29 20:02:28'),
(52, 'Nabila Rahayu Fitri', 'mahasiswa', '2523143', 2023, '$2y$12$lABUGmh6n7hozJz.Km7s1.ZX7vESetvsYEAX8xeUMZjElBNk1aGHK', NULL, '2026-07-29 20:03:12', '2026-07-29 20:03:12'),
(53, 'Nadia Firmanda', 'mahasiswa', '2523135', 2023, '$2y$12$2bk3gTYgTkx2Het4Bz9Kouh9hX7LWRHuJ7YfMD2q84UWs2zCynNgy', NULL, '2026-07-29 20:03:46', '2026-07-29 20:03:46'),
(54, 'Mhd Afria Noldi', 'mahasiswa', '2523134', 2023, '$2y$12$DGOdQCDLE2Eie6n5hntH2u/D05icIgjZscqi6nCa2iTrAHdoHV5Ka', NULL, '2026-07-29 20:04:29', '2026-07-29 20:04:29'),
(55, 'Rezki', 'mahasiswa', '2523132', 2023, '$2y$12$ymVZawYzxNzyyeFyYoxn.O3JwKO.w7/5mUfRxMtEdbLp38Q90Voi.', NULL, '2026-07-29 20:05:02', '2026-07-29 20:05:02'),
(56, 'Muhammad Iqbal', 'mahasiswa', '2523098', 2023, '$2y$12$f542luxsUJtC15I51BHl1uHPKTSSIF.hcOKvRtwV0mePku6qEKoju', NULL, '2026-07-29 20:05:35', '2026-07-29 20:05:35'),
(57, 'Trissa Desila', 'mahasiswa', '2523181', 2023, '$2y$12$y6wnvMTezPDGLM97gTZK0uqTPdMu7htlSxIEZ8C6mcxq7gbrU7YU2', NULL, '2026-07-29 20:06:12', '2026-07-29 20:06:12'),
(58, 'Najla Sabillillah', 'mahasiswa', '2523157', 2023, '$2y$12$Og4/ss0pKHlB5BhEL/2C8OFUTAqxFdW6ONZ1jOQCLpMJAn5OUxRGG', NULL, '2026-07-29 20:06:52', '2026-07-29 20:06:52'),
(59, 'Lovely Bunga Mellaty', 'mahasiswa', '2523176', 2023, '$2y$12$lh4OWNHa.gfQ1S8HSIaqqe3JCOKXNUgCl1Hc7uHoY3v0bGYDtGdpS', NULL, '2026-07-29 20:07:31', '2026-07-29 20:07:31'),
(60, 'Kamelia Amanda', 'mahasiswa', '2523155', 2023, '$2y$12$FTrkzkSmq07Ug7TM9XR8p.puKRTr.yIRxTaqq/DN57AbbArMa71OC', NULL, '2026-07-29 20:08:14', '2026-07-29 20:08:14'),
(61, 'Zike Farhani', 'mahasiswa', '2523172', 2023, '$2y$12$zqX/Y2w/PeiiycZsKkAtZOf5hC8QlTVMG.RF9SoAP7TOB1Uid3tYC', NULL, '2026-07-29 20:08:50', '2026-07-29 20:08:50'),
(62, 'Muhammad Farhan', 'mahasiswa', '2523160', 2023, '$2y$12$DWWG5D2y279X7oMvlNuB..Mphu8yhfeQu.2TLn.GSGQp8gYf.NGW6', NULL, '2026-07-29 20:09:28', '2026-07-29 20:09:28'),
(63, 'Ibnu Mutsaqqaf', 'mahasiswa', '2523175', 2023, '$2y$12$d5P5P34ODaMffaEIdNb0UewteOO/PiLlW/s1.bpaGPKc46qIAjGBy', NULL, '2026-07-29 20:10:03', '2026-07-29 20:10:03'),
(64, 'Amirul Lathief', 'mahasiswa', '2523121', 2023, '$2y$12$CwcK63RpR187B1ZTocbl4uFjG0g1xEVbZFdW7Ln1tTGRSKv.eFq8a', NULL, '2026-07-29 20:10:34', '2026-07-29 20:10:34'),
(65, 'Zainul Piqri H', 'mahasiswa', '2523174', 2023, '$2y$12$Hri2MkdSe0ZmiBYlF17WKeXlhQEnI8chiNwfgRxy2hgsDqX1MuSOa', NULL, '2026-07-29 20:11:10', '2026-07-29 20:11:10'),
(66, 'M Dzaky Hafizuddin', 'mahasiswa', '2523177', 2023, '$2y$12$Jko/iMeab91/EeFgg4lf/O9uEfXfqlb7hH.wyZLPU7ZcAXD53X3LW', NULL, '2026-07-29 20:11:57', '2026-07-29 20:11:57'),
(67, 'Arifin Heldia', 'mahasiswa', '2523008', 2023, '$2y$12$OZiRsVNczNnyrombBvqkMeuaAJDYny3GTs8ZZvyUdiJAGBLU8qcf6', NULL, '2026-07-29 20:12:27', '2026-07-29 20:12:27'),
(68, 'M Arbinnahar Rizki', 'mahasiswa', '2523034', 2023, '$2y$12$hO/EEV1NqHmbPlCcmDn9turZJHUjt2YfLeOpXs/Na8uLNTbXKYyZ2', NULL, '2026-07-29 20:13:16', '2026-07-29 20:13:16'),
(69, 'Miftahul Khairani', 'mahasiswa', '2523287', 2023, '$2y$12$dw35kWMcp70OWTjBDYGNX.CgAJ6nSCpqmhh6c3CBE0QtQXQ1AiHq6', NULL, '2026-07-29 20:14:29', '2026-07-29 20:14:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `variables`
--

CREATE TABLE `variables` (
  `id` bigint UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `variable_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `positif_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `positif_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `negatif_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `negatif_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `variables`
--

INSERT INTO `variables` (`id`, `label`, `description`, `variable_name`, `positif_value`, `positif_label`, `negatif_value`, `negatif_label`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 'Indeks Prestasi Kumulatif (IPK)', NULL, 'ipk_status', 'tinggi', 'Tinggi (3.51 - 4.00)', 'rendah', 'Rendah (2.76 - 3.50)', 1, '2026-07-19 06:25:44', '2026-07-19 06:25:44'),
(2, 'Proses Pengerjaan Skripsi', NULL, 'skripsi_status', 'lancar', 'Lancar', 'terlambat', 'Terlambat', 2, '2026-07-19 06:25:44', '2026-07-19 06:25:44'),
(3, 'Dukungan Keluarga', NULL, 'dukungan_keluarga', 'tinggi', 'Tinggi', 'rendah', 'Rendah', 3, '2026-07-19 06:25:44', '2026-07-19 06:25:44'),
(4, 'Kualitas Dosen Pembimbing', NULL, 'kualitas_dosen', 'baik', 'Baik', 'kurang_baik', 'Kurang Baik', 4, '2026-07-19 06:25:44', '2026-07-19 06:25:44'),
(5, 'Kelengkapan Administrasi Perkuliahan', NULL, 'administrasi', 'lengkap', 'Lengkap', 'tidak_lengkap', 'Tidak Lengkap', 5, '2026-07-19 06:25:44', '2026-07-19 06:25:44'),
(6, 'Motivasi Diri', NULL, 'motivasi_diri', 'tinggi', 'Tinggi', 'rendah', 'Rendah', 6, '2026-07-19 06:25:44', '2026-07-19 06:25:44'),
(7, 'Referensi atau Sumber Belajar', NULL, 'referensi_belajar', 'memadai', 'Memadai', 'tidak_memadai', 'Tidak Memadai', 7, '2026-07-19 06:25:44', '2026-07-19 06:25:44');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `prediction_results`
--
ALTER TABLE `prediction_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prediction_results_user_id_foreign` (`user_id`),
  ADD KEY `prediction_results_student_variable_id_foreign` (`student_variable_id`);

--
-- Indeks untuk tabel `pre_screenings`
--
ALTER TABLE `pre_screenings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pre_screenings_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rules_kode_rule_unique` (`kode_rule`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `student_answers`
--
ALTER TABLE `student_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_answers_student_variable_id_foreign` (`student_variable_id`);

--
-- Indeks untuk tabel `student_variables`
--
ALTER TABLE `student_variables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_variables_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_nim_unique` (`username_nim`);

--
-- Indeks untuk tabel `variables`
--
ALTER TABLE `variables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `variables_variable_name_unique` (`variable_name`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `prediction_results`
--
ALTER TABLE `prediction_results`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `pre_screenings`
--
ALTER TABLE `pre_screenings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `rules`
--
ALTER TABLE `rules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `student_answers`
--
ALTER TABLE `student_answers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT untuk tabel `student_variables`
--
ALTER TABLE `student_variables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT untuk tabel `variables`
--
ALTER TABLE `variables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `prediction_results`
--
ALTER TABLE `prediction_results`
  ADD CONSTRAINT `prediction_results_student_variable_id_foreign` FOREIGN KEY (`student_variable_id`) REFERENCES `student_variables` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prediction_results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pre_screenings`
--
ALTER TABLE `pre_screenings`
  ADD CONSTRAINT `pre_screenings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `student_answers`
--
ALTER TABLE `student_answers`
  ADD CONSTRAINT `student_answers_student_variable_id_foreign` FOREIGN KEY (`student_variable_id`) REFERENCES `student_variables` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `student_variables`
--
ALTER TABLE `student_variables`
  ADD CONSTRAINT `student_variables_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
