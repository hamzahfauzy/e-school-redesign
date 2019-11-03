-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 03, 2019 at 03:06 PM
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
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordered_number` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `role_id`, `name`, `route`, `ordered_number`, `created_at`, `updated_at`) VALUES
(2, 2, 'Data Peran', 'sistem-informasi.roles.index', 2, '2019-11-02 01:05:48', '2019-11-02 09:28:10'),
(4, 2, 'Data Sekolah', 'sistem-informasi.schools.index', 1, '2019-11-02 01:43:12', '2019-11-02 09:28:15'),
(5, 2, 'Data Pengguna', 'sistem-informasi.users.index', 3, '2019-11-02 03:26:11', '2019-11-02 09:26:40'),
(6, 2, 'Data Mata Pelajaran', 'sistem-informasi.studies.index', 4, '2019-11-02 09:26:19', '2019-11-02 09:27:02'),
(7, 2, 'Data Jurusan', 'sistem-informasi.majors.index', 5, '2019-11-02 09:30:33', '2019-11-02 09:31:10'),
(8, 2, 'Data Kelas', 'sistem-informasi.classrooms.index', 6, '2019-11-02 09:30:55', '2019-11-02 09:30:55'),
(9, 2, 'Data Guru', 'sistem-informasi.teachers.index', 7, '2019-11-02 10:41:06', '2019-11-02 10:41:06'),
(10, 2, 'Data Siswa', 'sistem-informasi.students.index', 8, '2019-11-02 10:41:29', '2019-11-02 10:41:29'),
(11, 4, 'Pesan', 'students.chats.index', 1, '2019-11-03 00:52:00', '2019-11-03 00:53:14'),
(12, 4, 'Kelas Virtual', 'students.virtual-class.index', 4, '2019-11-03 00:55:40', '2019-11-03 00:58:56'),
(13, 4, 'Tugas', 'students.assignments.index', 2, '2019-11-03 00:58:33', '2019-11-03 00:58:33'),
(14, 4, 'Kuis', 'students.exams.index', 3, '2019-11-03 00:58:51', '2019-11-03 00:58:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
