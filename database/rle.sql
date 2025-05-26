-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 04:43 AM
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
-- Database: `rle`
--

-- --------------------------------------------------------

--
-- Table structure for table `atasan`
--

CREATE TABLE `atasan` (
  `atasan_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `atasan`
--

INSERT INTO `atasan` (`atasan_id`, `nama`, `jabatan`, `email`, `password`, `no_hp`, `created_at`, `updated_at`) VALUES
(1, 'kunedi', 'Manajer', 'kunedi@gmail.com', '$2y$12$nUP3Ds8JynbsizQj2AaATe3dD/Pmu6DNwhzYtcGYEiDzVTGoEDUhC', 0, NULL, '2025-04-24 23:17:09'),
(2, 'nur jalil', 'manager', 'jalil@gmail.com', '$2y$12$/OsOUfEmQJ6UXrn8cyAGO./.re/MlmHeBZOQ8d2wbH5zYCGV9KixS', NULL, '2025-04-30 21:41:09', '2025-04-30 21:41:27');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3', 'i:1;', 1748160020),
('laravel_cache_livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1748160020;', 1748160020);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `izin`
--

CREATE TABLE `izin` (
  `izin_id` bigint(20) UNSIGNED NOT NULL,
  `pegawai_id` bigint(20) UNSIGNED NOT NULL,
  `atasan_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pengajuan` date DEFAULT NULL,
  `tanggal_izin` date NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `status` enum('menunggu','disetujui','ditolak') NOT NULL,
  `alasan_ditolak` text DEFAULT NULL,
  `tanggal_persetujuan` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `izin`
--

INSERT INTO `izin` (`izin_id`, `pegawai_id`, `atasan_id`, `tanggal_pengajuan`, `tanggal_izin`, `alasan`, `status`, `alasan_ditolak`, `tanggal_persetujuan`, `created_at`, `updated_at`, `jam_mulai`, `jam_selesai`) VALUES
(9, 4, 2, '2025-05-19', '2025-05-20', 'cabut', 'disetujui', NULL, NULL, '2025-05-18 20:38:18', '2025-05-18 20:39:02', '10:38:00', '12:38:00'),
(10, 4, 2, '2025-05-19', '2025-05-19', 'ngopi', 'ditolak', 'terlalu lama', NULL, '2025-05-18 20:46:51', '2025-05-21 22:14:30', '10:46:00', '14:46:00'),
(11, 4, 2, '2025-05-19', '2025-05-19', 'sakit', 'disetujui', NULL, NULL, '2025-05-18 20:51:07', '2025-05-23 18:24:35', '10:50:00', '23:51:00'),
(12, 4, 2, '2025-05-19', '2025-05-19', 'sakit', 'ditolak', 'bohong', NULL, '2025-05-18 20:54:15', '2025-05-23 18:21:47', '10:53:00', '13:55:00'),
(13, 5, 2, '2025-05-19', '2025-05-19', 'cabut', 'disetujui', NULL, NULL, '2025-05-18 20:58:45', '2025-05-18 20:59:34', '14:58:00', '19:00:00'),
(14, 4, 2, '2025-05-19', '2025-05-19', 'sakit', 'disetujui', NULL, NULL, '2025-05-18 21:07:12', '2025-05-23 18:28:28', '11:06:00', '11:18:00'),
(15, 4, 2, '2025-05-20', '2025-05-20', 'beli makan', 'ditolak', NULL, NULL, '2025-05-19 21:46:58', '2025-05-19 21:48:34', '11:46:00', '13:46:00'),
(16, 5, 2, '2025-05-20', '2025-05-20', 'beli bolpoin', 'disetujui', NULL, NULL, '2025-05-19 22:04:10', '2025-05-20 18:19:39', '12:03:00', '12:13:00'),
(17, 5, 2, '2025-05-24', '2025-05-24', 'cabut', 'ditolak', 'bohong', NULL, '2025-05-23 18:32:45', '2025-05-23 18:33:30', '08:32:00', '09:32:00'),
(18, 5, 2, '2025-05-24', '2025-05-24', 'cabut', 'disetujui', NULL, NULL, '2025-05-23 18:48:53', '2025-05-23 19:19:34', '08:48:00', '09:48:00'),
(19, 5, 2, '2025-05-24', '2025-05-24', 'makan', 'disetujui', NULL, NULL, '2025-05-23 21:50:14', '2025-05-23 22:12:08', '11:50:00', '11:51:00'),
(20, 5, 2, '2025-05-24', '2025-05-24', 'makan', 'disetujui', NULL, NULL, '2025-05-23 21:50:15', '2025-05-25 00:02:40', '11:50:00', '11:51:00'),
(21, 5, 2, '2025-05-25', '2025-05-25', 'kelas', 'disetujui', NULL, NULL, '2025-05-25 00:03:44', '2025-05-25 02:09:44', '14:03:00', '15:03:00'),
(22, 5, 2, '2025-05-25', '2025-05-25', 'testttt', 'disetujui', NULL, NULL, '2025-05-25 02:12:27', '2025-05-25 02:31:36', '16:12:00', '17:12:00'),
(23, 5, 2, '2025-05-25', '2025-05-25', 'malas', 'ditolak', 'bohong', NULL, '2025-05-25 02:21:59', '2025-05-25 02:37:35', '16:21:00', '17:21:00'),
(24, 5, 2, '2025-05-25', '2025-05-25', 'malas', 'disetujui', NULL, NULL, '2025-05-25 02:24:49', '2025-05-25 02:32:56', '16:21:00', '17:21:00'),
(25, 5, 2, '2025-05-25', '2025-05-25', 'malas', 'ditolak', 'malas', NULL, '2025-05-25 02:30:12', '2025-05-25 02:41:25', '16:21:00', '17:21:00'),
(26, 5, 2, '2025-05-25', '2025-05-25', 'test', 'ditolak', 'kelamaaan', NULL, '2025-05-25 03:18:38', '2025-05-25 03:19:38', '17:18:00', '18:18:00');

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
(1, '2025_04_25_021913_create_pegawai_table', 1),
(2, '2025_04_25_022711_create_atasan_table', 1),
(3, '2025_04_25_031527_create_table_atasan', 2),
(4, '2025_04_25_031624_create_pegawai_table', 3),
(5, '2025_04_25_031733_create_notifikasi_table', 4),
(6, '2025_04_25_031859_create_notifikasi_table', 5),
(7, '2025_04_25_033642_add_password_to_pegawai_table', 6),
(8, '2025_04_25_033814_add_password_to_atasan_table', 7),
(9, '2025_05_01_040120_create_users_table', 8),
(10, '2025_05_01_040718_create_cache_table', 9),
(11, '2025_05_06_035519_add_jabatan_to_users_table', 10),
(12, '2025_05_15_033401_add_jam_mulai_dan_selesai_to_izin_table', 11),
(13, '2025_05_21_062749_add_biodata_fields_to_users_table', 12),
(14, '2025_05_22_044925_add_alasan_ditolak_to_izin_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `notifikasi_id` bigint(20) UNSIGNED NOT NULL,
  `izin_id` bigint(20) UNSIGNED NOT NULL,
  `waktu_kirim` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status_kirim` enum('berhasil','gagal') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `pegawai_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` int(11) NOT NULL,
  `jenis_lembaga` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`pegawai_id`, `nama`, `email`, `password`, `no_hp`, `jenis_lembaga`, `created_at`, `updated_at`) VALUES
(1, 'nabil', 'nabil@gmail.com', '$2y$12$z7rqdrcaQ/PsyhRTxexaF.ujaWchrRjKxqh6gHsuJ7rUFQojRc8/m', 0, '', NULL, '2025-04-24 23:44:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_wa` varchar(255) DEFAULT NULL,
  `umur` int(11) DEFAULT NULL,
  `tanggal_bergabung` date DEFAULT NULL,
  `gender` enum('L','P') DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `no_wa`, `umur`, `tanggal_bergabung`, `gender`, `password`, `jabatan`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$m9NgBStqvnExHkVNmaVw0.9eGPjkwKYMOIVDNw1gIHmXadMWqai0m', 'pegawai', NULL, NULL, '2025-04-30 21:09:06'),
(2, 'kunedi', 'kunedi@gmail.com', '6285172142148', NULL, NULL, 'L', '$2y$12$fV/LIN4q8Q6BXxJp7sZyd.BKX.fWLLZbn0pNtK476qVJxwK.kkFru', 'atasan', NULL, '2025-05-05 21:20:29', '2025-05-23 19:05:38'),
(4, 'ibas', 'ibas@gmail.com', '6285172142148', NULL, NULL, 'L', '$2y$12$x91g6SMp4NaFoDNQMNNQHOtV.Fyd8r3Z6usej.WLaVC4MSrVsHUT.', 'pegawai', NULL, '2025-05-14 18:33:26', '2025-05-25 01:01:22'),
(5, 'daffa', 'daffa@gmail.com', '085172142148', NULL, NULL, 'L', '$2y$12$I6TTW7xXBENvjQZTUoqK.eBWraBKwzmHkgR/VneOHLASaK/JhUkQ6', 'pegawai', NULL, '2025-05-18 20:57:10', '2025-05-25 01:02:39'),
(6, 'sunarti', 'sunarti@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$2F9r1yvIC0lHHs//pK3knOmmu02.nwqIADn1YAnt3cUABmjttkuAS', 'atasan', NULL, '2025-05-19 00:03:35', '2025-05-19 00:03:35'),
(7, 'Ahmad Istakim', 'istakim@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$e6.SU75BSjd7xSJniy03puca6dS6vMtR5s.kUJROSD25QWDuRar36', 'atasan', NULL, '2025-05-19 21:55:53', '2025-05-19 21:55:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atasan`
--
ALTER TABLE `atasan`
  ADD PRIMARY KEY (`atasan_id`),
  ADD UNIQUE KEY `atasan_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `izin`
--
ALTER TABLE `izin`
  ADD PRIMARY KEY (`izin_id`),
  ADD KEY `izin_ibfk_1` (`atasan_id`),
  ADD KEY `izin_ibfk_2` (`pegawai_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`notifikasi_id`),
  ADD KEY `notifikasi_izin_id_foreign` (`izin_id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`pegawai_id`),
  ADD UNIQUE KEY `pegawai_email_unique` (`email`);

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
-- AUTO_INCREMENT for table `atasan`
--
ALTER TABLE `atasan`
  MODIFY `atasan_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `izin`
--
ALTER TABLE `izin`
  MODIFY `izin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `notifikasi_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `pegawai_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `izin`
--
ALTER TABLE `izin`
  ADD CONSTRAINT `izin_ibfk_1` FOREIGN KEY (`atasan_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `izin_ibfk_2` FOREIGN KEY (`pegawai_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_izin_id_foreign` FOREIGN KEY (`izin_id`) REFERENCES `izin` (`izin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
