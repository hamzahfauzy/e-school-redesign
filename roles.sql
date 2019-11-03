-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 03, 2019 at 08:50 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ztechno_eschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Admin Sistem Informasi', 'admin_sistem_informasi', 'admin sistem informasi', '2019-11-02 00:47:13', '2019-11-02 09:18:02'),
(3, 'Guru', 'guru', 'guru', '2019-11-02 00:47:31', '2019-11-02 09:19:53'),
(4, 'Siswa', 'siswa', 'siswa', '2019-11-02 00:47:36', '2019-11-02 09:20:00'),
(7, 'Administrasi Umum', 'admin_umum', 'administrasi untuk surat menyurat', '2019-11-02 00:49:17', '2019-11-02 09:20:17'),
(8, 'Administrasi Bendahara', 'bendahara', 'administrasi bendahara', '2019-11-02 00:49:35', '2019-11-02 09:20:26'),
(9, 'Administrasi Kesiswaan', 'admin_kesiswaan', 'administrasi kesiswaan', '2019-11-02 00:51:17', '2019-11-02 09:20:34'),
(10, 'Administrasi Sarana dan Prasarana', 'admin_sarana_prasarana', 'administrasi sarana dan prasarana', '2019-11-02 00:51:37', '2019-11-02 09:20:45'),
(11, 'Administrasi Humas', 'admin_humas', 'administrasi humas', '2019-11-02 00:51:51', '2019-11-02 09:20:53'),
(13, 'Administrator', 'admin', 'administrator', '2019-11-02 01:41:40', '2019-11-02 01:41:40'),
(14, 'Administrasi Kurikulum', 'admin_kurikulum', 'admin kurikulum', '2019-11-02 09:32:30', '2019-11-02 09:32:30'),
(15, 'Wali Kelas', 'wali_kelas', 'wali kelas', '2019-11-03 06:06:32', '2019-11-03 06:06:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
