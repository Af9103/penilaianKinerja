-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2025 at 06:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pns`
--

-- --------------------------------------------------------

--
-- Table structure for table `bobot_kriteria`
--

CREATE TABLE `bobot_kriteria` (
  `id` int(11) NOT NULL,
  `Kriteria` varchar(20) DEFAULT NULL,
  `bobot` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bobot_kriteria`
--

INSERT INTO `bobot_kriteria` (`id`, `Kriteria`, `bobot`) VALUES
(1, 'absen', 0.30),
(2, 'prestasi', 0.30),
(3, 'kinerja', 0.40);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_08_23_112709_create_penilaian_table', 1),
(6, '2025_08_26_021929_create_tmt_pns_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tahun` int(11) DEFAULT NULL,
  `absen` decimal(5,2) NOT NULL,
  `prestasi` int(11) DEFAULT NULL,
  `kinerja` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id`, `user_id`, `tahun`, `absen`, `prestasi`, `kinerja`, `created_at`, `updated_at`) VALUES
(1, 2, 2025, 90.10, 8, 7, '2025-08-25 22:19:27', '2025-08-25 22:19:27'),
(2, 3, 2021, 99.19, 1, 7, '2025-08-25 22:26:57', '2025-08-25 22:26:57'),
(3, 3, 2022, 90.10, 9, 9, '2025-08-25 22:27:13', '2025-08-25 22:27:13'),
(4, 3, 2023, 91.10, 7, 7, '2025-08-25 22:27:46', '2025-08-25 22:27:46'),
(5, 3, 2024, 98.71, 7, 7, '2025-08-25 22:28:18', '2025-08-25 22:28:18'),
(6, 3, 2025, 99.19, 7, 7, '2025-08-25 22:28:30', '2025-08-25 22:28:30'),
(7, 4, 2021, 99.91, 7, 7, '2025-08-25 22:28:41', '2025-08-25 22:28:41'),
(8, 4, 2022, 98.99, 8, 6, '2025-08-25 22:28:57', '2025-08-25 22:28:57'),
(9, 4, 2023, 97.11, 7, 7, '2025-08-25 22:29:12', '2025-08-25 22:29:12'),
(10, 4, 2024, 98.00, 8, 8, '2025-08-25 22:29:24', '2025-08-25 22:29:24'),
(11, 4, 2025, 89.11, 1, 1, '2025-08-25 22:29:36', '2025-08-26 18:37:48'),
(12, 5, 2024, 98.91, 8, 8, '2025-08-25 22:32:55', '2025-08-25 22:32:55'),
(13, 5, 2025, 99.91, 9, 9, '2025-08-25 22:33:08', '2025-08-25 22:33:08');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tmt_pns`
--

CREATE TABLE `tmt_pns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tmt` date DEFAULT NULL,
  `golongan` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tmt_pns`
--

INSERT INTO `tmt_pns` (`id`, `user_id`, `tmt`, `golongan`, `created_at`, `updated_at`) VALUES
(4, 2, '2025-08-26', 'II/c', '2025-08-26 04:30:30', '2025-08-26 04:30:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `gelar_depan` varchar(7) DEFAULT NULL,
  `gelar_belakang` varchar(10) DEFAULT NULL,
  `tempat_lahir` varchar(20) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `agama` varchar(10) DEFAULT NULL,
  `status_pernikahan` varchar(15) DEFAULT NULL,
  `nik` varchar(17) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `status_pns` varchar(5) DEFAULT NULL,
  `no_sk_cpns` varchar(60) DEFAULT NULL,
  `tgl_sk_cpns` date DEFAULT NULL,
  `tmt_cpns` date DEFAULT NULL,
  `tmt_pns` date DEFAULT NULL,
  `gol` varchar(10) DEFAULT NULL,
  `jenis_jabatan` varchar(20) DEFAULT NULL,
  `jabatan_nama` varchar(70) DEFAULT NULL,
  `tingkat_pendidikan` varchar(7) DEFAULT NULL,
  `pend` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nip`, `nama`, `gelar_depan`, `gelar_belakang`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `status_pernikahan`, `nik`, `no_hp`, `status_pns`, `no_sk_cpns`, `tgl_sk_cpns`, `tmt_cpns`, `tmt_pns`, `gol`, `jenis_jabatan`, `jabatan_nama`, `tingkat_pendidikan`, `pend`, `email`, `password`, `role`, `foto`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, '123', 'Albin', NULL, 'S.Tr.Kom', 'Bekasi', '2003-01-09', 'L', 'Islam', 'Belum Menikah', '3216060901030026', '123', 'C', '100.3.3.2/895 TAHUN 2025', '2025-06-03', '2025-08-13', '2025-08-26', 'II/c', 'Struktural', 'FASILITATOR PEMERINTAHAN', 'D4', 'Sistem Informasi', 'albinf341@gmail.com', '$2y$10$A.Y5iQliYoUkwBccXJrf.ez5JsIE0m8.K0.o7AodNGA2SQ9dFlGSe', 'Admin', 'EoTOcpWK1mvuz0LFZU1k3cWNLpF1B0iZu16rGUFx.jpg', NULL, '2025-08-25 20:34:48', '2025-08-26 04:30:30'),
(3, '200004062025052006', 'RATNAWATI', NULL, 'S.Sos.', 'Wakatobi', '2000-04-06', 'P', 'Islam', 'Menikah', '7407084604000001', '081248282375', 'P', '100.3.3.2/895 TAHUN 2025', NULL, '2019-05-28', '2020-05-08', 'III/a', 'Pelaksana', 'Fasilitator', 'S1', 'Ilmu Politik', 'ratnawatirat49@gmail.com', '$2y$10$k7T2aoX/vLOkSB4jkfKQ6eOSjuZKL5AE6Y1Rh6LTprwm6ASlAG2K.', 'PNS', NULL, NULL, '2025-08-25 22:22:26', '2025-08-25 22:22:26'),
(4, '199805082025052003', 'WA ODE HEDIYATI MAHARANI', 'dr.', 'S.Ked', 'Wakatobi', '1998-05-08', 'P', 'Islam', 'Menikah', '7407014805980001', '081241920126', 'P', '01/BKDD/2014', NULL, '2014-10-01', '2019-08-08', 'I/c', 'Fungsional', 'Dokter Ahli Pertama', 'S2', 'Profesi Dokter', 'hedimhrn@gmail.com', '$2y$10$nQD9wyxDIIAT86plluEID.VI3b45P5aaPOaDYfeh85hc/QtdCmGBy', 'Atasan', NULL, NULL, '2025-08-25 22:26:05', '2025-08-25 22:26:05'),
(5, '200306102025051001', 'HIKMAL AKBAR', 'dr.', 'S.Ked', 'Wakatobi', '1999-04-01', 'L', 'Islam', 'Menikah', '7407060104950001', '085342724744', 'P', '100.3.3.2/895 TAHUN 2025', NULL, '2023-05-01', '2024-01-01', 'III/b', 'Struktural', 'Dokter Ahli Pertama', 'S2', 'Profesi Dokter', 'apriadinlaode@gmail.com', '$2y$10$jGSqRvvvJq/l8wAjD46O.uylzdAaMd5Z1JIayA3Qv9FOW4vUzVl4G', 'PNS', NULL, NULL, '2025-08-25 22:32:42', '2025-08-25 22:32:42'),
(6, '1272181', 'bmsdnmb', 'dr.', 'S.Ked', 'Wakatobi', '1999-04-01', 'L', 'Islam', 'Belum Menikah', '1111111111111111', '09189188', 'C', '100.3.3.2/895 TAHUN 2025', NULL, '2025-05-01', NULL, 'IV/c', 'Struktural', 'jsdwkd', 'SMA/SMK', 'adnnjads', 'gag@gmail.com', '$2y$10$qdqPIuPEkw/pJFAmDQ/F4uESqP22laVVAxjhEH5fqq7ncDjo9H6Zq', 'PNS', NULL, NULL, '2025-08-25 23:02:21', '2025-08-25 23:02:21'),
(7, '12721816161', 'bmsdnmb', 'dr.', 'S.Ked', 'Wakatobi', '1999-04-01', 'L', 'Hindu', 'Menikah', '1111111111111112', '09189188121', 'C', '100.3.3.2/895 TAHUN 2025', NULL, '2025-05-01', NULL, 'II/a', 'Struktural', 'jsdwkd', 'D3', 'adnnjads', 'gag11@gmail.com', '$2y$10$eYYGNc1CNo0cfl41G4LWyuovSV/qu/9oH2VGyVGk5YU.vF9CFFaHq', 'Admin', NULL, NULL, '2025-08-26 07:10:44', '2025-08-26 07:10:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tmt_pns`
--
ALTER TABLE `tmt_pns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_nik_unique` (`nik`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tmt_pns`
--
ALTER TABLE `tmt_pns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
