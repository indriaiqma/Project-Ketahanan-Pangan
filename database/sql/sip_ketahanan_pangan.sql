-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 08, 2026 at 12:34 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sip_ketahanan_pangan`
--

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
-- Table structure for table `kawasan_hutans`
--

CREATE TABLE `kawasan_hutans` (
  `id` bigint UNSIGNED NOT NULL,
  `kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kawasan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kawasan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `luas_ha` decimal(12,2) DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lahan_kritis`
--

CREATE TABLE `lahan_kritis` (
  `id` bigint UNSIGNED NOT NULL,
  `kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dalam_sangat_kritis` decimal(15,2) NOT NULL DEFAULT '0.00',
  `dalam_kritis` decimal(15,2) NOT NULL DEFAULT '0.00',
  `dalam_agak_kritis` decimal(15,2) NOT NULL DEFAULT '0.00',
  `dalam_potensial_kritis` decimal(15,2) NOT NULL DEFAULT '0.00',
  `dalam_tidak_kritis` decimal(15,2) NOT NULL DEFAULT '0.00',
  `luar_sangat_kritis` decimal(15,2) NOT NULL DEFAULT '0.00',
  `luar_kritis` decimal(15,2) NOT NULL DEFAULT '0.00',
  `luar_agak_kritis` decimal(15,2) NOT NULL DEFAULT '0.00',
  `luar_potensial_kritis` decimal(15,2) NOT NULL DEFAULT '0.00',
  `luar_tidak_kritis` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_ha` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lahan_kritis`
--

INSERT INTO `lahan_kritis` (`id`, `kabupaten`, `kecamatan`, `dalam_sangat_kritis`, `dalam_kritis`, `dalam_agak_kritis`, `dalam_potensial_kritis`, `dalam_tidak_kritis`, `luar_sangat_kritis`, `luar_kritis`, `luar_agak_kritis`, `luar_potensial_kritis`, `luar_tidak_kritis`, `total_ha`, `created_at`, `updated_at`) VALUES
(1, 'Malang', 'Ampelgading', '4713.95', '244.26', '5121.73', '57.36', '2043.86', '2704.39', '2129.20', '2469.29', '281.10', '1052.83', '20817.97', '2026-08-31 20:20:47', '2026-09-30 00:33:44'),
(2, 'Malang', 'Bantur', '135.08', '333.52', '1912.12', '885.28', '196.94', '127.42', '5941.67', '1744.28', '1481.00', '2129.49', '14886.80', '2026-08-31 20:20:47', '2026-09-30 00:33:45'),
(3, 'Malang', 'Dampit', '604.20', '392.14', '270.07', '157.46', '284.02', '768.08', '3176.28', '3012.05', '1709.20', '5171.02', '15544.53', '2026-08-31 20:20:47', '2026-09-30 00:33:45'),
(4, 'Malang', 'Donomulyo', '80.56', '697.83', '3201.69', '909.23', '208.38', '178.73', '4962.78', '4174.80', '1890.32', '2525.84', '18830.16', '2026-08-31 20:20:47', '2026-09-30 00:33:45'),
(6, 'Malang', 'Kalipare', '0.04', '45.80', '884.81', '689.72', '898.32', '22.22', '1094.89', '2701.61', '2519.97', '2315.11', '11172.49', '2026-08-31 20:20:47', '2026-09-30 00:33:45'),
(7, 'Malang', 'Pagak', '0.00', '13.73', '660.31', '260.58', '61.15', '0.00', '2640.12', '3040.30', '1447.33', '1703.46', '9826.98', '2026-08-31 20:20:47', '2026-09-30 00:33:45'),
(8, 'Malang', 'Sumbermanjing Wetan', '1686.77', '450.28', '5382.96', '661.20', '308.65', '990.42', '1852.14', '8678.90', '1165.37', '5145.85', '26322.54', '2026-08-31 20:20:47', '2026-09-30 00:33:45'),
(9, 'Malang', 'Tirtoyudo', '5485.26', '1276.58', '2792.06', '53.08', '817.32', '1243.25', '2063.11', '3242.58', '262.87', '1408.11', '18644.23', '2026-08-31 20:20:47', '2026-09-30 00:33:45'),
(10, 'Malang', 'Gedangan', '503.81', '2714.47', '680.66', '272.59', '225.95', '579.06', '4605.00', '4723.50', '1036.72', '1465.80', '16807.54', '2026-08-31 21:09:45', '2026-09-30 00:33:45');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_08_13_043621_create_kawasan_hutans_table', 2),
(6, '2026_09_01_011942_create_lahan_kritis_table', 3),
(7, '2026_09_07_012015_add_role_to_users_table', 4);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
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
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petugas',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@bakorwil.local', NULL, '$2y$10$toZRFfyz5Ea7a8UhaK3evO/fSle0nPlaA66kEvbKk.xe83a3CsuLC', 'admin', NULL, '2026-09-01 20:32:27', '2026-09-01 20:32:27'),
(2, 'Indri', 'indri@bakorwil.local', NULL, '$2y$10$itml.0R8F.ysBet.UXVFe.3ADVRO9lbPhmI.NsyivnNbvdDIsM9Ca', 'viewer', NULL, '2026-09-01 21:19:01', '2026-09-13 19:05:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kawasan_hutans`
--
ALTER TABLE `kawasan_hutans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lahan_kritis`
--
ALTER TABLE `lahan_kritis`
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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kawasan_hutans`
--
ALTER TABLE `kawasan_hutans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lahan_kritis`
--
ALTER TABLE `lahan_kritis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
