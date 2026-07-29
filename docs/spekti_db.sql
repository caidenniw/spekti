-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 02, 2026 at 06:16 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.29

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
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
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
(10, '2026_07_02_000003_create_student_answers_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prediction_results`
--

CREATE TABLE `prediction_results` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `student_variable_id` bigint UNSIGNED NOT NULL,
  `total_cf_score` decimal(5,4) NOT NULL,
  `persentase_keyakinan` int UNSIGNED NOT NULL,
  `hasil_prediksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_prediksi` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_rule` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_rule` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cf_pakar` decimal(3,2) NOT NULL,
  `status_prediksi` enum('Lulus','Tidak Lulus') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `kode_rule`, `deskripsi_rule`, `cf_pakar`, `status_prediksi`, `created_at`, `updated_at`) VALUES
(1, 'R1', 'IF IPK Tinggi THEN Lulus 3,5 Tahun', '0.80', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(2, 'R2', 'IF IPK Tinggi AND Proses Pengerjaan Skripsi Lancar THEN Lulus 3,5 Tahun', '1.00', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(3, 'R3', 'IF IPK Tinggi AND Dukungan Keluarga Tinggi THEN Lulus 3,5 Tahun', '0.60', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(4, 'R4', 'IF IPK Tinggi AND Kualitas Dosen Pembimbing Baik THEN Lulus 3,5 Tahun', '0.80', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(5, 'R5', 'IF IPK Tinggi AND Administrasi Perkuliahan Lengkap THEN Lulus 3,5 Tahun', '0.40', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(6, 'R6', 'IF IPK Tinggi AND Motivasi Diri Tinggi THEN Lulus 3,5 Tahun', '0.40', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(7, 'R7', 'IF IPK Tinggi AND Referensi Belajar Memadai THEN Lulus 3,5 Tahun', '0.40', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(8, 'R8', 'IF Proses Pengerjaan Skripsi Terlambat THEN Tidak Lulus 3,5 Tahun', '0.80', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(9, 'R9', 'IF Proses Pengerjaan Skripsi Terlambat AND IPK Rendah THEN Tidak Lulus 3,5 Tahun', '0.20', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(10, 'R10', 'IF Proses Pengerjaan Skripsi Terlambat AND Dukungan Keluarga Rendah THEN Tidak Lulus 3,5 Tahun', '0.60', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(11, 'R11', 'IF Proses Pengerjaan Skripsi Terlambat AND Kualitas Dosen Pembimbing Kurang Baik THEN Tidak Lulus 3,5 Tahun', '0.40', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(12, 'R12', 'IF Proses Pengerjaan Skripsi Terlambat AND Administrasi Tidak Lengkap THEN Tidak Lulus 3,5 Tahun', '0.20', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(13, 'R13', 'IF Proses Pengerjaan Skripsi Terlambat AND Motivasi Diri Rendah THEN Tidak Lulus 3,5 Tahun', '0.40', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(14, 'R14', 'IF Proses Pengerjaan Skripsi Terlambat AND Referensi Belajar Tidak Memadai THEN Tidak Lulus 3,5 Tahun', '0.40', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(15, 'R15', 'IF Dukungan Keluarga Tinggi THEN Lulus 3,5 Tahun', '0.80', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(16, 'R16', 'IF Dukungan Keluarga Tinggi AND IPK Tinggi THEN Lulus 3,5 Tahun', '0.80', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(17, 'R17', 'IF Dukungan Keluarga Tinggi AND Proses Pengerjaan Skripsi Lancar THEN Lulus 3,5 Tahun', '0.80', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(18, 'R18', 'IF Dukungan Keluarga Tinggi AND Kualitas Dosen Pembimbing Baik THEN Lulus 3,5 Tahun', '1.00', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(19, 'R19', 'IF Dukungan Keluarga Tinggi AND Administrasi Perkuliahan Lengkap THEN Lulus 3,5 Tahun', '0.60', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(20, 'R20', 'IF Dukungan Keluarga Tinggi AND Motivasi Diri Tinggi THEN Lulus 3,5 Tahun', '0.40', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(21, 'R21', 'IF Dukungan Keluarga Tinggi AND Referensi Belajar Memadai THEN Lulus 3,5 Tahun', '0.40', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(22, 'R22', 'IF Kualitas Dosen Pembimbing Kurang Baik THEN Tidak Lulus 3,5 Tahun', '0.80', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(23, 'R23', 'IF Kualitas Dosen Pembimbing Kurang Baik AND IPK Rendah THEN Tidak Lulus 3,5 Tahun', '0.40', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(24, 'R24', 'IF Kualitas Dosen Pembimbing Kurang Baik AND Proses Pengerjaan Skripsi Terlambat THEN Tidak Lulus 3,5 Tahun', '0.20', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(25, 'R25', 'IF Kualitas Dosen Pembimbing Kurang Baik AND Dukungan Keluarga Rendah THEN Tidak Lulus 3,5 Tahun', '0.60', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(26, 'R26', 'IF Kualitas Dosen Pembimbing Kurang Baik AND Administrasi Tidak Lengkap THEN Tidak Lulus 3,5 Tahun', '0.40', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(27, 'R27', 'IF Kualitas Dosen Pembimbing Kurang Baik AND Motivasi Diri Rendah THEN Tidak Lulus 3,5 Tahun', '0.20', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(28, 'R28', 'IF Kualitas Dosen Pembimbing Kurang Baik AND Referensi Belajar Tidak Memadai THEN Tidak Lulus 3,5 Tahun', '0.40', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(29, 'R29', 'IF Administrasi Perkuliahan Lengkap THEN Lulus 3,5 Tahun', '0.60', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(30, 'R30', 'IF Administrasi Perkuliahan Lengkap AND IPK Tinggi THEN Lulus 3,5 Tahun', '0.40', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(31, 'R31', 'IF Administrasi Perkuliahan Lengkap AND Proses Pengerjaan Skripsi Lancar THEN Lulus 3,5 Tahun', '0.20', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(32, 'R32', 'IF Administrasi Perkuliahan Lengkap AND Dukungan Keluarga Tinggi THEN Lulus 3,5 Tahun', '0.40', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(33, 'R33', 'IF Administrasi Perkuliahan Lengkap AND Kualitas Dosen Pembimbing Baik THEN Lulus 3,5 Tahun', '0.60', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(34, 'R34', 'IF Administrasi Perkuliahan Lengkap AND Motivasi Diri Tinggi THEN Lulus 3,5 Tahun', '0.40', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(35, 'R35', 'IF Administrasi Perkuliahan Lengkap AND Referensi Belajar Memadai THEN Lulus 3,5 Tahun', '0.60', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(36, 'R36', 'IF Motivasi Diri Rendah THEN Tidak Lulus 3,5 Tahun', '0.80', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(37, 'R37', 'IF Motivasi Diri Rendah AND IPK Rendah THEN Tidak Lulus 3,5 Tahun', '0.80', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(38, 'R38', 'IF Motivasi Diri Rendah AND Proses Pengerjaan Skripsi Terlambat THEN Tidak Lulus 3,5 Tahun', '0.80', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(39, 'R39', 'IF Motivasi Diri Rendah AND Dukungan Keluarga Rendah THEN Tidak Lulus 3,5 Tahun', '0.80', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(40, 'R40', 'IF Motivasi Diri Rendah AND Kualitas Dosen Pembimbing Kurang Baik THEN Tidak Lulus 3,5 Tahun', '0.60', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(41, 'R41', 'IF Motivasi Diri Rendah AND Administrasi Tidak Lengkap THEN Tidak Lulus 3,5 Tahun', '0.40', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(42, 'R42', 'IF Motivasi Diri Rendah AND Referensi Belajar Tidak Memadai THEN Tidak Lulus 3,5 Tahun', '0.60', 'Tidak Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(43, 'R43', 'IF Referensi Belajar Memadai THEN Lulus 3,5 Tahun', '0.60', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(44, 'R44', 'IF Referensi Belajar Memadai AND IPK Tinggi THEN Lulus 3,5 Tahun', '0.80', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(45, 'R45', 'IF Referensi Belajar Memadai AND Proses Pengerjaan Skripsi Lancar THEN Lulus 3,5 Tahun', '1.00', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(46, 'R46', 'IF Referensi Belajar Memadai AND Dukungan Keluarga Tinggi THEN Lulus 3,5 Tahun', '0.60', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(47, 'R47', 'IF Referensi Belajar Memadai AND Kualitas Dosen Pembimbing Baik THEN Lulus 3,5 Tahun', '0.60', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(48, 'R48', 'IF Referensi Belajar Memadai AND Administrasi Perkuliahan Lengkap THEN Lulus 3,5 Tahun', '0.40', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37'),
(49, 'R49', 'IF Referensi Belajar Memadai AND Motivasi Diri Tinggi THEN Lulus 3,5 Tahun', '0.40', 'Lulus', '2026-07-02 09:15:37', '2026-07-02 09:15:37');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('dFMA6P4ITj6bMN4SGU6mlXcRQTWaBF3sPSwKAdoU', NULL, '127.0.0.1', 'curl/8.17.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidDRxcTNNQTdZclhyU0VESnV5OFhxV0NIWXJGZlBIS21Ud3JXY211MCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL21haGFzaXN3YS9yaXdheWF0Ijt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYWhhc2lzd2Evcml3YXlhdCI7czo1OiJyb3V0ZSI7czoxNzoibWFoYXNpc3dhLnJpd2F5YXQiO319', 1783008971),
('ekEX8U6coq2pLXZKr11Qm44vZMOjW63Yy5PE1ulN', NULL, '127.0.0.1', 'curl/8.17.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicUZYYkszVzNHS0NPOEtna3dDSkxWUTVFaXIzcDNFOG5jdUZSOWRDayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1783008967),
('n2vNoSX2t4iIy1sWH0DETJgUGRTXTgc1LfeH1n1T', NULL, '127.0.0.1', 'curl/8.17.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ3ZDT0FyS0tMS3l3bDc2b3AzYk5jN2NYVEJzT1dJeHJiUnVyMVAxQSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL21haGFzaXN3YS9yaXdheWF0Ijt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYWhhc2lzd2Evcml3YXlhdCI7czo1OiJyb3V0ZSI7czoxNzoibWFoYXNpc3dhLnJpd2F5YXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1783009008),
('OWjjkERXkVuyXnCUx44w2oaJwCw2aqLAVvuurdQZ', NULL, '127.0.0.1', 'curl/8.17.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTFpIbklFblQwWFFJOFpaMkpDNnIwT0dYV2lWT0ljTnYxRnB1dVpWZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1783008964),
('PSFb5M141hks1Vd82FPLryD4UJkD425x3jxfsWdt', NULL, '127.0.0.1', 'curl/8.17.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNm9qdmVjTXdkS2JVOVd0UlZvanNjTHNSMjF2U1dPWXBZWk1lRXRLTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYWhhc2lzd2EvY3JlYXRlIjtzOjU6InJvdXRlIjtzOjIyOiJhZG1pbi5tYWhhc2lzd2EuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL21haGFzaXN3YS9jcmVhdGUiO319', 1783008969),
('QDNH9xQ9v0KcblRjG8Km9GsW43Xq0CLPHSY9QqAw', NULL, '127.0.0.1', 'curl/8.17.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibGJRbFc0c3JTWWdaRDNaNzQzc1ptSGhIWEkxUkY3cnAxYWZGNWdLZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7czo1OiJyb3V0ZSI7czo4OiJyZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1783008967),
('ssuhwxvgia3KkIYVdlp69t0tIwlgdgnX7zMBgLhm', NULL, '127.0.0.1', 'curl/8.17.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnl5Vkx1WGJWSlNoTjBORUdaeWhpWHg1bXFjMFVjY3dBN0c2TU1KayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1783008966),
('UUqW0UUTpHrkxpMw0NEUD4cMM1QbhoyVvZ3gv3CD', 1, '127.0.0.1', 'curl/8.17.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS2xpZlpjWHhUSk1sVTV3QWhyVXdVamlMaHUwb0pLMm1BaUlObDRSVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYWhhc2lzd2EvY3JlYXRlIjtzOjU6InJvdXRlIjtzOjIyOiJhZG1pbi5tYWhhc2lzd2EuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1783008987),
('yTg4gmUYHSqeh3aIKOH6rYVHiAR7v68CkpWk3PbY', 2, '127.0.0.1', 'curl/8.17.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWmtmd2tQejJSajUwMFlFSDlOb3VpZWlxalNhQWxiQmtLQ2VSUkkzZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYWhhc2lzd2Evcml3YXlhdCI7czo1OiJyb3V0ZSI7czoxNzoibWFoYXNpc3dhLnJpd2F5YXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1783008990);

-- --------------------------------------------------------

--
-- Table structure for table `student_answers`
--

CREATE TABLE `student_answers` (
  `id` bigint UNSIGNED NOT NULL,
  `student_variable_id` bigint UNSIGNED NOT NULL,
  `variable_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `variable_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cf_user` decimal(3,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_variables`
--

CREATE TABLE `student_variables` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ipk_status` enum('tinggi','rendah') COLLATE utf8mb4_unicode_ci NOT NULL,
  `skripsi_status` enum('lancar','terlambat') COLLATE utf8mb4_unicode_ci NOT NULL,
  `dukungan_keluarga` enum('tinggi','rendah') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kualitas_dosen` enum('baik','kurang_baik') COLLATE utf8mb4_unicode_ci NOT NULL,
  `administrasi` enum('lengkap','tidak_lengkap') COLLATE utf8mb4_unicode_ci NOT NULL,
  `motivasi_diri` enum('tinggi','rendah') COLLATE utf8mb4_unicode_ci NOT NULL,
  `referensi_belajar` enum('memadai','tidak_memadai') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','mahasiswa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mahasiswa',
  `username_nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `angkatan` int DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `username_nim`, `angkatan`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'admin', NULL, '$2y$12$Lswhv.BJHEyG/nZ6Lm0GDeHrVQFJ.zGewRfDZSrdpKIHbM6H2lZHS', NULL, '2026-07-02 09:15:36', '2026-07-02 09:15:36'),
(2, 'Andi Pratama', 'mahasiswa', '2022001', 2022, '$2y$12$qk7qvtoZ44iUMZykDt/9m.sonqLZRKqLiP7s.fnGUxkbXh1PFqdcS', NULL, '2026-07-02 09:15:36', '2026-07-02 09:15:36'),
(3, 'Siti Nurhaliza', 'mahasiswa', '2022002', 2022, '$2y$12$thyNBNh.QVljJsuJoLBW1OEXPVczEDjsQXgvO6o2p5tnWgK/0Iy36', NULL, '2026-07-02 09:15:36', '2026-07-02 09:15:36'),
(4, 'Rizki Ramadhan', 'mahasiswa', '2023001', 2023, '$2y$12$WHlckvkfhwIxTJ.8XDnkKu2vqlbj3bCRI/ZwIDr1WF9gga0liw89m', NULL, '2026-07-02 09:15:36', '2026-07-02 09:15:36'),
(5, 'Maya Putri', 'mahasiswa', '2023002', 2023, '$2y$12$qKRbfhBeGuAUmGIE1Hxg9umNxsnytZrT0NVqs.nQUKOEbqj3dasVi', NULL, '2026-07-02 09:15:37', '2026-07-02 09:15:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `prediction_results`
--
ALTER TABLE `prediction_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prediction_results_user_id_foreign` (`user_id`),
  ADD KEY `prediction_results_student_variable_id_foreign` (`student_variable_id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rules_kode_rule_unique` (`kode_rule`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_answers_student_variable_id_foreign` (`student_variable_id`);

--
-- Indexes for table `student_variables`
--
ALTER TABLE `student_variables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_variables_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_nim_unique` (`username_nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `prediction_results`
--
ALTER TABLE `prediction_results`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `student_answers`
--
ALTER TABLE `student_answers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_variables`
--
ALTER TABLE `student_variables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `prediction_results`
--
ALTER TABLE `prediction_results`
  ADD CONSTRAINT `prediction_results_student_variable_id_foreign` FOREIGN KEY (`student_variable_id`) REFERENCES `student_variables` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prediction_results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD CONSTRAINT `student_answers_student_variable_id_foreign` FOREIGN KEY (`student_variable_id`) REFERENCES `student_variables` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_variables`
--
ALTER TABLE `student_variables`
  ADD CONSTRAINT `student_variables_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
