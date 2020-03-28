-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2020 at 07:23 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ekskul`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_09_12_143946_create_instrukturs_table', 1),
(5, '2019_09_12_163928_create_admins_table', 2),
(6, '2019_09_13_022055_add_column_to_users', 3),
(7, '2019_09_13_030049_add_column_to_users', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('pengurus@gmail.com', '$2y$10$EwFJygeXjMmIQdGUWy9qAuqYNHYYam3I0YkHyYqE8D/rH/k5rSMGe', '2019-10-30 20:55:02'),
('perempuan@gmail.com', '$2y$10$QbiiiQ9CB2qzPOr6xQjNv.dzXXUvKQQwRsFR8PJR/ZS7MyyTFHuPm', '2019-12-16 00:19:07');

-- --------------------------------------------------------

--
-- Table structure for table `tb_absen_ekskul_biasa`
--

CREATE TABLE `tb_absen_ekskul_biasa` (
  `id_absen_ekskul_biasa` int(11) NOT NULL,
  `ekskul_biasa_id_absen` int(100) NOT NULL,
  `users_absen_ekskul_biasa_id` int(100) NOT NULL,
  `tgl_absen_ekskul_biasa_detail` date NOT NULL,
  `keterangan_absen_ekskul_biasa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_absen_ekskul_biasa`
--

INSERT INTO `tb_absen_ekskul_biasa` (`id_absen_ekskul_biasa`, `ekskul_biasa_id_absen`, `users_absen_ekskul_biasa_id`, `tgl_absen_ekskul_biasa_detail`, `keterangan_absen_ekskul_biasa`) VALUES
(7, 6, 2, '2019-12-25', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `tb_absen_ekskul_produktif`
--

CREATE TABLE `tb_absen_ekskul_produktif` (
  `id_absen_ekskul_produktif` int(11) NOT NULL,
  `ekskul_produktif_id_absen` int(100) NOT NULL,
  `users_absen_ekskul_produktif_id` int(100) NOT NULL,
  `tgl_absen_ekskul_produktif_detail` date NOT NULL,
  `keterangan_absen_ekskul_produktif` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_absen_ekskul_produktif`
--

INSERT INTO `tb_absen_ekskul_produktif` (`id_absen_ekskul_produktif`, `ekskul_produktif_id_absen`, `users_absen_ekskul_produktif_id`, `tgl_absen_ekskul_produktif_detail`, `keterangan_absen_ekskul_produktif`) VALUES
(1, 1, 2, '2019-12-26', 'H');

-- --------------------------------------------------------

--
-- Table structure for table `tb_absen_instruktur_ekskul_biasa`
--

CREATE TABLE `tb_absen_instruktur_ekskul_biasa` (
  `id_absen_instruktur_ekskul_biasa` int(11) NOT NULL,
  `instruktur_absen_ekskul_biasa_id` int(11) NOT NULL,
  `ekskul_biasa_absen_instruktur_id` int(11) NOT NULL,
  `tgl_absen_instruktur_ekskul_biasa_detail` date NOT NULL,
  `keterangan_absen_instruktur_ekskul_biasa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_absen_instruktur_ekskul_biasa`
--

INSERT INTO `tb_absen_instruktur_ekskul_biasa` (`id_absen_instruktur_ekskul_biasa`, `instruktur_absen_ekskul_biasa_id`, `ekskul_biasa_absen_instruktur_id`, `tgl_absen_instruktur_ekskul_biasa_detail`, `keterangan_absen_instruktur_ekskul_biasa`) VALUES
(2, 5, 3, '2019-12-26', 'I');

-- --------------------------------------------------------

--
-- Table structure for table `tb_absen_instruktur_ekskul_produktif`
--

CREATE TABLE `tb_absen_instruktur_ekskul_produktif` (
  `id_absen_instruktur_ekskul_produktif` int(11) NOT NULL,
  `instruktur_absen_ekskul_produktif_id` int(11) NOT NULL,
  `ekskul_produktif_absen_instruktur_id` int(11) NOT NULL,
  `tgl_absen_instruktur_ekskul_produktif_detail` date NOT NULL,
  `keterangan_absen_instruktur_ekskul_produktif` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_absen_instruktur_keputrian`
--

CREATE TABLE `tb_absen_instruktur_keputrian` (
  `id_absen_instruktur_keputrian` int(11) NOT NULL,
  `instruktur_absen_keputrian_id` int(11) NOT NULL,
  `keputrian_absen_instruktur_id` int(11) NOT NULL,
  `tgl_absen_instruktur_keputrian_detail` date NOT NULL,
  `keterangan_absen_instruktur_keputrian` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_absen_instruktur_senbud`
--

CREATE TABLE `tb_absen_instruktur_senbud` (
  `id_absen_instruktur_senbud` int(11) NOT NULL,
  `instruktur_absen_senbud_id` int(11) NOT NULL,
  `senbud_absen_instruktur_id` int(11) NOT NULL,
  `tgl_absen_instruktur_senbud_detail` date NOT NULL,
  `keterangan_absen_instruktur_senbud` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_absen_instruktur_senbud`
--

INSERT INTO `tb_absen_instruktur_senbud` (`id_absen_instruktur_senbud`, `instruktur_absen_senbud_id`, `senbud_absen_instruktur_id`, `tgl_absen_instruktur_senbud_detail`, `keterangan_absen_instruktur_senbud`) VALUES
(7, 3, 4, '2019-12-26', 'S'),
(9, 5, 3, '2020-01-02', 'S'),
(10, 3, 4, '2020-01-02', 'H');

-- --------------------------------------------------------

--
-- Table structure for table `tb_absen_keputrian`
--

CREATE TABLE `tb_absen_keputrian` (
  `id_absen_keputrian` int(11) NOT NULL,
  `keputrian_id_absen` int(100) NOT NULL,
  `users_absen_keputrian_id` int(100) NOT NULL,
  `tgl_absen_keputrian_detail` date NOT NULL,
  `keterangan_absen_keputrian` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_absen_senbud`
--

CREATE TABLE `tb_absen_senbud` (
  `id_absen_senbud` int(11) NOT NULL,
  `senbud_id_absen` int(100) NOT NULL,
  `users_absen_senbud_id` int(100) NOT NULL,
  `tgl_absen_senbud_detail` date NOT NULL,
  `keterangan_absen_senbud` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_absen_senbud`
--

INSERT INTO `tb_absen_senbud` (`id_absen_senbud`, `senbud_id_absen`, `users_absen_senbud_id`, `tgl_absen_senbud_detail`, `keterangan_absen_senbud`) VALUES
(25, 3, 2, '2019-12-25', 'A'),
(26, 3, 4, '2019-12-25', 'I');

-- --------------------------------------------------------

--
-- Table structure for table `tb_ekskul_biasa`
--

CREATE TABLE `tb_ekskul_biasa` (
  `id_ekskul_biasa` int(11) NOT NULL,
  `instruktur_ekskul_biasa_id` int(11) NOT NULL,
  `nama_ekskul_biasa` varchar(100) NOT NULL,
  `hari_ekskul_biasa` varchar(100) NOT NULL,
  `kuota_ekskul_biasa` int(100) NOT NULL,
  `sisa_kuota_ekskul_biasa` int(11) NOT NULL DEFAULT '0',
  `foto_ekskul_biasa` varchar(100) NOT NULL DEFAULT 'catur.jpg',
  `deskripsi_kegiatan_ekskul_biasa` varchar(200) DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_ekskul_biasa`
--

INSERT INTO `tb_ekskul_biasa` (`id_ekskul_biasa`, `instruktur_ekskul_biasa_id`, `nama_ekskul_biasa`, `hari_ekskul_biasa`, `kuota_ekskul_biasa`, `sisa_kuota_ekskul_biasa`, `foto_ekskul_biasa`, `deskripsi_kegiatan_ekskul_biasa`) VALUES
(3, 5, 'Futsal', 'Sabtu', 37, 19, 'futsal.jpg', '-'),
(6, 3, 'Catur', 'Rabu', 37, 35, 'catur.jpg', '-'),
(7, 0, 'Bola', 'Sabtu', 37, 35, '1577287184_futsal.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_ekskul_produktif`
--

CREATE TABLE `tb_ekskul_produktif` (
  `id_ekskul_produktif` int(11) NOT NULL,
  `instruktur_ekskul_produktif_id` int(11) NOT NULL,
  `nama_ekskul_produktif` varchar(100) NOT NULL,
  `hari_ekskul_produktif` varchar(100) NOT NULL,
  `kuota_ekskul_produktif` int(100) NOT NULL,
  `sisa_kuota_ekskul_produktif` int(11) NOT NULL DEFAULT '0',
  `foto_ekskul_produktif` varchar(100) NOT NULL DEFAULT 'android.jpg',
  `deskripsi_kegiatan_ekskul_produktif` varchar(200) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_ekskul_produktif`
--

INSERT INTO `tb_ekskul_produktif` (`id_ekskul_produktif`, `instruktur_ekskul_produktif_id`, `nama_ekskul_produktif`, `hari_ekskul_produktif`, `kuota_ekskul_produktif`, `sisa_kuota_ekskul_produktif`, `foto_ekskul_produktif`, `deskripsi_kegiatan_ekskul_produktif`) VALUES
(1, 3, 'Android', 'Senin', 37, 20, '1577288746_android.jpg', '-'),
(2, 0, 'Pemrograman Web', 'Senin', 37, 35, 'pemrogramanweb.jpg', '-'),
(4, 0, 'tes', 'tes', 23, 23, 'android.jpg', '-');

-- --------------------------------------------------------

--
-- Table structure for table `tb_gambar_ekskul_biasa`
--

CREATE TABLE `tb_gambar_ekskul_biasa` (
  `id_gambar_ekskul_biasa` int(11) NOT NULL,
  `gambar_ekskul_biasa_id` int(11) NOT NULL,
  `gambar_nama_ekskul_biasa` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_gambar_ekskul_biasa`
--

INSERT INTO `tb_gambar_ekskul_biasa` (`id_gambar_ekskul_biasa`, `gambar_ekskul_biasa_id`, `gambar_nama_ekskul_biasa`) VALUES
(1, 3, 'futsal.jpg'),
(2, 6, 'catur.jpg'),
(4, 7, '1577285387_anderson.jpg'),
(5, 7, '1577285495_catur.jpg'),
(6, 7, '1577287193_android.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_gambar_ekskul_produktif`
--

CREATE TABLE `tb_gambar_ekskul_produktif` (
  `id_gambar_ekskul_produktif` int(11) NOT NULL,
  `gambar_ekskul_produktif_id` int(11) NOT NULL,
  `gambar_nama_ekskul_produktif` varchar(200) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_gambar_ekskul_produktif`
--

INSERT INTO `tb_gambar_ekskul_produktif` (`id_gambar_ekskul_produktif`, `gambar_ekskul_produktif_id`, `gambar_nama_ekskul_produktif`) VALUES
(1, 1, 'android.jpg'),
(2, 2, 'pemrogramanweb.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_gambar_keputrian`
--

CREATE TABLE `tb_gambar_keputrian` (
  `id_gambar_keputrian` int(11) NOT NULL,
  `gambar_keputrian_id` int(11) NOT NULL,
  `gambar_nama_keputrian` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_gambar_keputrian`
--

INSERT INTO `tb_gambar_keputrian` (`id_gambar_keputrian`, `gambar_keputrian_id`, `gambar_nama_keputrian`) VALUES
(2, 3, 'kerajinantangan.jpg'),
(6, 1, '1577095279_bis4.jpg'),
(7, 3, '1577289418_android.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_gambar_senbud`
--

CREATE TABLE `tb_gambar_senbud` (
  `id_gambar_senbud` int(11) NOT NULL,
  `gambar_senbud_id` int(11) NOT NULL,
  `gambar_nama_senbud` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_gambar_senbud`
--

INSERT INTO `tb_gambar_senbud` (`id_gambar_senbud`, `gambar_senbud_id`, `gambar_nama_senbud`) VALUES
(1, 3, 'angklung1.jpg'),
(2, 4, 'perkusi1.jpg'),
(3, 8, 'senitari1.jpg'),
(4, 9, 'senitari2.jpg'),
(5, 14, 'perkusi2.jpg'),
(8, 3, '1577286443_angklung2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurusan`
--

CREATE TABLE `tb_jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(100) NOT NULL,
  `status_jurusan` enum('aktif','non-aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jurusan`
--

INSERT INTO `tb_jurusan` (`id_jurusan`, `nama_jurusan`, `status_jurusan`) VALUES
(1, 'Rekayasa Perangkat Lunak', 'aktif'),
(2, 'Teknik Komputer dan Jaringan', 'aktif'),
(3, 'Bisnis Daring dan Pemasaran', 'aktif'),
(4, 'Multimedia', 'aktif'),
(5, 'Perhotelan', 'aktif'),
(6, 'Tata Boga', 'aktif'),
(7, 'Otomatisasi Tata Kelola Perkantoran', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_keputrian`
--

CREATE TABLE `tb_keputrian` (
  `id_keputrian` int(11) NOT NULL,
  `instruktur_keputrian_id` int(11) NOT NULL,
  `nama_keputrian` varchar(100) NOT NULL,
  `hari_keputrian` varchar(100) NOT NULL,
  `kuota_keputrian` int(100) NOT NULL,
  `sisa_kuota_keputrian` int(11) NOT NULL DEFAULT '0',
  `foto_keputrian` varchar(100) NOT NULL DEFAULT 'keputrian.jpg',
  `deskripsi_kegiatan_keputrian` varchar(200) DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_keputrian`
--

INSERT INTO `tb_keputrian` (`id_keputrian`, `instruktur_keputrian_id`, `nama_keputrian`, `hari_keputrian`, `kuota_keputrian`, `sisa_kuota_keputrian`, `foto_keputrian`, `deskripsi_kegiatan_keputrian`) VALUES
(1, 5, 'Menjahit', 'Jumat', 37, 33, '1577096027_bis5.jpg', '-'),
(3, 3, 'Kerajinan Tangan', 'Jumat', 37, 32, '1577289405_kerajinantangan.jpg', 'Halo'),
(7, 0, 'Tes Keputrian', 'jumat', 100, 100, 'keputrian.jpg', '-'),
(8, 0, 'tes', 'Jumat', 32, 32, 'keputrian.jpg', '-');

-- --------------------------------------------------------

--
-- Table structure for table `tb_keterangan_nilai_ekskul_biasa`
--

CREATE TABLE `tb_keterangan_nilai_ekskul_biasa` (
  `id_keterangan_nilai_ekskul_biasa` int(11) NOT NULL,
  `keterangan_nilai_ekskul_biasa_id` int(11) NOT NULL,
  `keterangan_nilai_ekskul_biasa` varchar(100) NOT NULL,
  `tgl_nilai_ekskul_biasa` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_keterangan_nilai_ekskul_biasa`
--

INSERT INTO `tb_keterangan_nilai_ekskul_biasa` (`id_keterangan_nilai_ekskul_biasa`, `keterangan_nilai_ekskul_biasa_id`, `keterangan_nilai_ekskul_biasa`, `tgl_nilai_ekskul_biasa`) VALUES
(7, 6, 'Semester 1', '2020-01-11');

-- --------------------------------------------------------

--
-- Table structure for table `tb_keterangan_nilai_ekskul_produktif`
--

CREATE TABLE `tb_keterangan_nilai_ekskul_produktif` (
  `id_keterangan_nilai_ekskul_produktif` int(11) NOT NULL,
  `keterangan_nilai_ekskul_produktif_id` int(11) NOT NULL,
  `keterangan_nilai_ekskul_produktif` varchar(100) NOT NULL,
  `tgl_nilai_ekskul_produktif` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_keterangan_nilai_ekskul_produktif`
--

INSERT INTO `tb_keterangan_nilai_ekskul_produktif` (`id_keterangan_nilai_ekskul_produktif`, `keterangan_nilai_ekskul_produktif_id`, `keterangan_nilai_ekskul_produktif`, `tgl_nilai_ekskul_produktif`) VALUES
(1, 1, 'Semester 1', '2020-01-11');

-- --------------------------------------------------------

--
-- Table structure for table `tb_keterangan_nilai_keputrian`
--

CREATE TABLE `tb_keterangan_nilai_keputrian` (
  `id_keterangan_nilai_keputrian` int(11) NOT NULL,
  `keterangan_nilai_keputrian_id` int(11) NOT NULL,
  `keterangan_nilai_keputrian` varchar(100) NOT NULL,
  `tgl_nilai_ekskul_keputrian` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_keterangan_nilai_senbud`
--

CREATE TABLE `tb_keterangan_nilai_senbud` (
  `id_keterangan_nilai_senbud` int(11) NOT NULL,
  `keterangan_nilai_senbud_id` int(11) NOT NULL,
  `keterangan_nilai_senbud` varchar(100) NOT NULL,
  `tgl_nilai_senbud` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_keterangan_nilai_senbud`
--

INSERT INTO `tb_keterangan_nilai_senbud` (`id_keterangan_nilai_senbud`, `keterangan_nilai_senbud_id`, `keterangan_nilai_senbud`, `tgl_nilai_senbud`) VALUES
(6, 3, 'Semester 1', '2020-01-11'),
(7, 3, 'Semester 2', '2020-01-11');

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai_ekskul_biasa`
--

CREATE TABLE `tb_nilai_ekskul_biasa` (
  `id_nilai_ekskul_biasa` int(11) NOT NULL,
  `ekskul_biasa_nilai_ekskul_biasa_id` int(11) NOT NULL,
  `users_nilai_ekskul_biasa_id` int(11) NOT NULL,
  `nilai_pengetahuan_ekskul_biasa` int(11) NOT NULL,
  `nilai_sikap_ekskul_biasa` varchar(100) NOT NULL,
  `keterangan_nilai_ekskul_biasa_detail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_nilai_ekskul_biasa`
--

INSERT INTO `tb_nilai_ekskul_biasa` (`id_nilai_ekskul_biasa`, `ekskul_biasa_nilai_ekskul_biasa_id`, `users_nilai_ekskul_biasa_id`, `nilai_pengetahuan_ekskul_biasa`, `nilai_sikap_ekskul_biasa`, `keterangan_nilai_ekskul_biasa_detail`) VALUES
(26, 6, 2, 80, 'Kurang', 'Semester 1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai_ekskul_produktif`
--

CREATE TABLE `tb_nilai_ekskul_produktif` (
  `id_nilai_ekskul_produktif` int(11) NOT NULL,
  `ekskul_produktif_nilai_ekskul_produktif_id` int(11) NOT NULL,
  `users_nilai_ekskul_produktif_id` int(11) NOT NULL,
  `nilai_pengetahuan_ekskul_produktif` int(11) NOT NULL,
  `nilai_sikap_ekskul_produktif` varchar(100) NOT NULL,
  `keterangan_nilai_ekskul_produktif_detail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_nilai_ekskul_produktif`
--

INSERT INTO `tb_nilai_ekskul_produktif` (`id_nilai_ekskul_produktif`, `ekskul_produktif_nilai_ekskul_produktif_id`, `users_nilai_ekskul_produktif_id`, `nilai_pengetahuan_ekskul_produktif`, `nilai_sikap_ekskul_produktif`, `keterangan_nilai_ekskul_produktif_detail`) VALUES
(25, 1, 2, 77, 'Baik', 'Semester 1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai_keputrian`
--

CREATE TABLE `tb_nilai_keputrian` (
  `id_nilai_keputrian` int(11) NOT NULL,
  `keputrian_nilai_keputrian_id` int(11) NOT NULL,
  `users_nilai_keputrian_id` int(11) NOT NULL,
  `nilai_pengetahuan_keputrian` int(11) NOT NULL,
  `nilai_sikap_keputrian` varchar(100) NOT NULL,
  `keterangan_nilai_keputrian_detail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai_senbud`
--

CREATE TABLE `tb_nilai_senbud` (
  `id_nilai_senbud` int(11) NOT NULL,
  `senbud_nilai_senbud_id` int(11) NOT NULL,
  `users_nilai_senbud_id` int(11) NOT NULL,
  `nilai_pengetahuan_senbud` int(11) NOT NULL,
  `nilai_sikap_senbud` varchar(100) NOT NULL,
  `keterangan_nilai_senbud_detail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_nilai_senbud`
--

INSERT INTO `tb_nilai_senbud` (`id_nilai_senbud`, `senbud_nilai_senbud_id`, `users_nilai_senbud_id`, `nilai_pengetahuan_senbud`, `nilai_sikap_senbud`, `keterangan_nilai_senbud_detail`) VALUES
(5, 3, 4, 80, 'Baik', 'Semester 1'),
(6, 3, 2, 80, 'Baik', 'Semester 1'),
(7, 3, 16, 80, 'Baik', 'Semester 1'),
(8, 3, 17, 75, 'Baik', 'Semester 1'),
(9, 3, 4, 75, 'Baik', 'Semester 2'),
(10, 3, 2, 75, 'Baik', 'Semester 2'),
(11, 3, 16, 75, 'Baik', 'Semester 2'),
(12, 3, 17, 75, 'Baik', 'Semester 2');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rayon`
--

CREATE TABLE `tb_rayon` (
  `id_rayon` int(11) NOT NULL,
  `nama_rayon` varchar(100) NOT NULL,
  `status_rayon` enum('aktif','non-aktif') NOT NULL,
  `inisial_rayon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_rayon`
--

INSERT INTO `tb_rayon` (`id_rayon`, `nama_rayon`, `status_rayon`, `inisial_rayon`) VALUES
(1, 'Cisarua 1', 'aktif', 'cis 1'),
(2, 'Cisarua 2', 'aktif', 'cis 2'),
(3, 'Cisarua 3', 'aktif', 'cis 3'),
(4, 'Cisarua 4', 'aktif', 'cis 4'),
(5, 'Cisarua 5', 'aktif', 'cis 5'),
(6, 'Cisarua 6', 'aktif', 'cis 6'),
(7, 'Cicurug 1', 'aktif', 'cic 1'),
(8, 'Cicurug 2', 'aktif', 'cic 2'),
(9, 'Cicurug 3', 'aktif', 'cic 3'),
(10, 'Cicurug 4', 'aktif', 'cic 4'),
(11, 'cibedug 1', 'aktif', 'cib 1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rombel`
--

CREATE TABLE `tb_rombel` (
  `id_rombel` int(11) NOT NULL,
  `nama_rombel` varchar(100) NOT NULL,
  `status_rombel` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_rombel`
--

INSERT INTO `tb_rombel` (`id_rombel`, `nama_rombel`, `status_rombel`) VALUES
(1, 'RPL X - 1', 'aktif'),
(2, 'TKJ X - 1', 'aktif'),
(3, 'MMD X - 1', 'aktif'),
(4, 'OTPK X - 1', 'aktif'),
(5, 'Perhotelan X - 1', 'aktif'),
(6, 'TBG X - 1', 'aktif'),
(7, 'BDP X - 1', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_senbud`
--

CREATE TABLE `tb_senbud` (
  `id_senbud` int(11) NOT NULL,
  `instruktur_senbud_id` int(200) NOT NULL DEFAULT '0',
  `nama_senbud` varchar(100) NOT NULL,
  `hari_senbud` varchar(100) NOT NULL,
  `kuota_senbud` int(100) NOT NULL,
  `sisa_kuota_senbud` int(11) NOT NULL DEFAULT '0',
  `foto_senbud` varchar(100) NOT NULL DEFAULT 'avatar.png',
  `deskripsi_kegiatan_senbud` varchar(255) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_senbud`
--

INSERT INTO `tb_senbud` (`id_senbud`, `instruktur_senbud_id`, `nama_senbud`, `hari_senbud`, `kuota_senbud`, `sisa_kuota_senbud`, `foto_senbud`, `deskripsi_kegiatan_senbud`) VALUES
(3, 3, 'Angklung 1', 'Selasa', 37, 30, '1585295758_1.png', 'Halo1'),
(4, 3, 'Perkusi 1', 'Rabu', 37, 35, 'perkusi1.jpg', '-'),
(8, 3, 'Seni Tari 1', 'Senin', 37, 28, 'senitari1.jpg', '-'),
(9, 3, 'Seni Tari 2', 'Selasa', 37, 36, 'senitari2.jpg', '-'),
(14, 3, 'Perkusi 2', 'Selasa', 37, 37, 'perkusi2.jpg', '-'),
(16, 0, 'tes', 'tes', 2323, 2323, 'avatar.png', '-');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tgl_absen_ekskul_biasa`
--

CREATE TABLE `tb_tgl_absen_ekskul_biasa` (
  `tgl_absen_ekskul_biasa` date NOT NULL,
  `tgl_absen_ekskul_biasa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_tgl_absen_ekskul_biasa`
--

INSERT INTO `tb_tgl_absen_ekskul_biasa` (`tgl_absen_ekskul_biasa`, `tgl_absen_ekskul_biasa_id`) VALUES
('2019-12-25', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tb_tgl_absen_ekskul_produktif`
--

CREATE TABLE `tb_tgl_absen_ekskul_produktif` (
  `tgl_absen_ekskul_produktif` date NOT NULL,
  `tgl_absen_ekskul_produktif_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_tgl_absen_ekskul_produktif`
--

INSERT INTO `tb_tgl_absen_ekskul_produktif` (`tgl_absen_ekskul_produktif`, `tgl_absen_ekskul_produktif_id`) VALUES
('2019-12-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_tgl_absen_keputrian`
--

CREATE TABLE `tb_tgl_absen_keputrian` (
  `tgl_absen_keputrian` date NOT NULL,
  `tgl_absen_keputrian_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tgl_absen_senbud`
--

CREATE TABLE `tb_tgl_absen_senbud` (
  `tgl_absen_senbud` date NOT NULL,
  `tgl_absen_senbud_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_tgl_absen_senbud`
--

INSERT INTO `tb_tgl_absen_senbud` (`tgl_absen_senbud`, `tgl_absen_senbud_id`) VALUES
('2019-12-25', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nis` varchar(191) NOT NULL DEFAULT '0',
  `nama` varchar(100) NOT NULL DEFAULT '-',
  `email` varchar(100) NOT NULL DEFAULT '-',
  `username` varchar(100) NOT NULL DEFAULT '-',
  `password` varchar(100) NOT NULL DEFAULT '-',
  `rombel_id` int(11) NOT NULL DEFAULT '0',
  `rayon_id` int(11) NOT NULL DEFAULT '0',
  `jurusan_id` int(11) NOT NULL DEFAULT '0',
  `senbud_id` int(11) NOT NULL DEFAULT '0',
  `ekskul_biasa_id` int(11) NOT NULL DEFAULT '0',
  `ekskul_produktif_id` int(11) NOT NULL DEFAULT '0',
  `keputrian_id` int(11) NOT NULL DEFAULT '0',
  `jk` enum('L','P') NOT NULL,
  `kelas` enum('0','10','11') NOT NULL,
  `level` enum('Siswa','Instruktur','Pengurus','Piket') NOT NULL,
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif',
  `kehadiran_senbud` int(200) NOT NULL DEFAULT '0',
  `kehadiran_ekskul_biasa` int(200) NOT NULL DEFAULT '0',
  `kehadiran_keputrian` int(200) NOT NULL DEFAULT '0',
  `kehadiran_ekskul_produktif` int(200) NOT NULL DEFAULT '0',
  `cek_pilihan` enum('belum','sudah') NOT NULL DEFAULT 'belum',
  `foto` varchar(255) DEFAULT 'avatar.png',
  `tgl_pilih` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nis`, `nama`, `email`, `username`, `password`, `rombel_id`, `rayon_id`, `jurusan_id`, `senbud_id`, `ekskul_biasa_id`, `ekskul_produktif_id`, `keputrian_id`, `jk`, `kelas`, `level`, `status`, `kehadiran_senbud`, `kehadiran_ekskul_biasa`, `kehadiran_keputrian`, `kehadiran_ekskul_produktif`, `cek_pilihan`, `foto`, `tgl_pilih`, `created_at`, `updated_at`) VALUES
(1, '0', 'Pengurus', 'pengurus@gmail.com', 'pengurus', '$2y$10$kWbT7deoGJz/dnsa3Q0lbe.b31rp5Fc/VFIgrShGhiAEdGJG6lYum', 0, 0, 0, 0, 0, 0, 0, 'P', '0', 'Pengurus', 'aktif', 0, 0, 0, 0, 'belum', '1584805150_restoran.jpg', '2019-10-29', '2019-10-29 02:42:28', '2020-03-21 15:39:10'),
(2, '11706157', 'Mochamad Satriatna', 'sat212@gmail.com', '11706157', '$2y$10$1c9lWyvDh7IqBlxKntyuDuyF7PX7RppJf5w16GJd0O0ciEIwrczXO', 2, 1, 2, 3, 6, 1, 0, 'L', '11', 'Siswa', 'aktif', 2, 1, 0, 0, 'sudah', '1577464507_ask.jpg', '2019-12-14', '2019-10-29 02:43:34', '2020-01-11 03:13:36'),
(3, '0', 'Elzi Rina', 'instruktur@gmail.com', 'instruktur', '$2y$10$.aAIdS3CnuoIfrzqAJ3VIujkcsuxrOfXLgf6U0U62asHWsIq13EJG', 0, 0, 0, 0, 0, 0, 0, 'L', '0', 'Instruktur', 'aktif', 0, 0, 0, 0, 'belum', 'avatar.png', '2019-10-29', '2019-10-29 02:48:31', '2020-01-11 09:07:49'),
(4, '11706100', 'Perempuan', 'perempuan@gmail.com', '11706100', '$2y$10$v5mI4DSjgzcbyRg48Ee9yu8HMtgNqr8.r2vEs71mgYlEkVq1RFDTW', 1, 1, 1, 3, 3, 2, 3, 'P', '11', 'Siswa', 'aktif', 0, 0, 0, 0, 'sudah', '1577881143_ask.jpg', '2019-12-13', '2019-10-29 02:54:03', '2020-01-11 03:13:22'),
(5, '0', 'Anderson', 'anderson@gmail.com', 'andersons', '$2y$10$tfKu5CkLLojlHtVPMN0f0ejM.nIispaQG00DjJ0tSO9aqOnTOCVOO', 0, 0, 0, 0, 0, 0, 0, 'L', '0', 'Instruktur', 'non-aktif', 0, 0, 0, 0, 'belum', '1577798260_ask.jpg', '2019-11-13', '2019-11-12 18:16:05', '2020-01-11 03:15:59'),
(6, '0', 'Elvi', 'elviaroza@gmail.com', 'elvi', '$2y$10$r54Rnq8RUn4db1huXaC0i.N00gef3VF62tO3zQI/9eYgEJuU/Lusy', 0, 0, 0, 0, 0, 0, 0, 'P', '0', 'Pengurus', 'aktif', 0, 0, 0, 0, 'belum', '1577463783_anderson.jpg', '2019-11-13', '2019-11-13 03:15:41', '2019-12-31 13:16:51'),
(7, '0', 'pengurus2', 'pengurus2@gmail.com', 'pengurus', '$2y$10$GvWFjEA8gnluqpfHxGiljORK1cKUROwjz3CFbO3Whprx53BwAQB/S', 0, 0, 0, 0, 0, 0, 0, 'L', '0', 'Pengurus', 'aktif', 0, 0, 0, 0, 'belum', 'avatar.png', '2019-12-10', '2019-12-09 19:12:52', '2019-12-27 15:37:42'),
(8, '0', 'piket1', 'piket1@gmail.com', 'piket1', '$2y$10$5u2UT634flWURB0iAmWq/.OY7F7drL3E1REWZBnoWwAIjwmyp/zi2', 0, 0, 0, 0, 0, 0, 0, 'L', '0', 'Piket', 'aktif', 0, 0, 0, 0, 'belum', '1577929280_ask.jpg', '2019-12-10', '2019-12-09 20:33:40', '2020-01-02 01:41:20'),
(9, '0', 'piket2', 'piket2@gmail.com', 'piket2', '$2y$10$n13v7drvvnMZwJS9FS5Ud.66mhrKkXPlp4yjtIFBgw1otfIIDEQUO', 0, 0, 0, 0, 0, 0, 0, 'L', '0', 'Piket', 'aktif', 0, 0, 0, 0, 'belum', 'avatar.png', '2019-12-10', '2019-12-09 20:34:56', '2019-12-09 20:34:56'),
(10, '11706101', 'Amelia', 'amelia@gmai.com', 'amelia', '$2y$10$mcSnThxMavvQDWZ4eXuY6eR248CrxB7gXVsj2tIZ1OnO/mel1NlRa', 1, 1, 1, 0, 0, 0, 0, 'P', '11', 'Siswa', 'aktif', 0, 0, 0, 0, 'belum', 'avatar.png', '2019-12-13', '2019-12-11 22:44:53', '2019-12-13 01:46:33'),
(11, '11706102', 'Rasyid', 'rasyid@gmail.com', 'rasyid', '$2y$10$gWZKqJhIWZtnOYUZ8YTP7uTiGSDxibRS0WgXMuIFt8JdBRY6HNlRa', 1, 1, 1, 0, 0, 0, 0, 'L', '11', 'Siswa', 'aktif', 0, 0, 0, 0, 'belum', 'avatar.png', '2019-12-12', '2019-12-11 22:45:37', '2019-12-11 22:45:37'),
(14, '11706150', 'saaaa', 'asdf@gmail.com', 'asdf', '$2y$10$jYUPzfytt2GXYo4mYIBPCeMpwG/G6JJqt2ryvTfE5y3vne2hMzTH6', 2, 2, 1, 0, 0, 0, 0, 'L', '11', 'Siswa', 'aktif', 0, 0, 0, 0, 'belum', 'avatar.png', NULL, '2019-12-27 08:20:42', '2020-01-11 03:13:43'),
(15, '11706103', 'Febrian Arrasyid', 'tes@gmail.com', '11706102', '$2y$10$x6XxmWxWEyc//jVVrye60eDP0czZwvyW1/tD.dJrsujeHFVpQdTjK', 1, 1, 1, 0, 0, 0, 0, 'L', '10', 'Siswa', 'aktif', 0, 0, 0, 0, 'belum', 'avatar.png', NULL, '2020-01-01 18:56:14', '2020-01-01 18:56:14'),
(16, '11707070', 'Febrian', 'febrian@gmail.com', '11707070', '$2y$10$p0jJRAjjYvGRVYeTNMpkJejpLSVpLivohFGCemM9zXWnP8AGC5IK.', 2, 1, 1, 3, 3, 0, 0, 'L', '10', 'Siswa', 'aktif', 0, 0, 0, 0, 'sudah', 'avatar.png', '2020-01-02', '2020-01-01 18:58:12', '2020-01-02 01:59:54'),
(17, '11707071', 'Hendrawan', 'hendrawan@gmail.com', '11707071', '$2y$10$ZIesWewMcv0yflu/a1pJt.Z7CUOTr5v7bUfclMTjilRFmEy10qZe2', 1, 1, 1, 3, 3, 0, 0, 'L', '10', 'Siswa', 'aktif', 0, 0, 0, 0, 'sudah', 'avatar.png', '2020-01-02', '2020-01-01 23:15:22', '2020-01-02 06:22:34'),
(18, '11707072', 'Anisa', 'anisa@gmail.com', '11707072', '$2y$10$v7QZKqhhX5Nhl0XHupOm.OugTkceIUMX8Via.wM6YTlXe1Ol4LyIq', 2, 1, 1, 0, 0, 0, 0, 'L', '11', 'Siswa', 'aktif', 0, 0, 0, 0, 'belum', 'avatar.png', NULL, '2020-01-01 23:15:51', '2020-01-01 23:15:51'),
(19, '11707073', 'Muchtarom', 'muchtarom@gmail.com', '11707073', '$2y$10$GRkVyQ6VLK8a6I6THOpfP.mQPYXNO.NEGFPtsp96eXuayQwqf2yNK', 1, 1, 1, 0, 0, 0, 0, 'L', '11', 'Siswa', 'aktif', 0, 0, 0, 0, 'belum', 'avatar.png', NULL, '2020-01-02 01:22:41', '2020-01-02 08:23:05'),
(20, '11700000', 'Saya', 'saya@gmail.com', '11700000', '$2y$10$nRZufo9cFs68nnabneGKF.UakVRPAMxXfUzTLeNAdwKN3ZC63XDPm', 1, 5, 1, 3, 3, 2, 0, 'L', '11', 'Siswa', 'aktif', 0, 0, 0, 0, 'sudah', 'avatar.png', '2020-03-27', '2020-03-27 01:25:03', '2020-03-27 08:30:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `tb_absen_ekskul_biasa`
--
ALTER TABLE `tb_absen_ekskul_biasa`
  ADD PRIMARY KEY (`id_absen_ekskul_biasa`);

--
-- Indexes for table `tb_absen_ekskul_produktif`
--
ALTER TABLE `tb_absen_ekskul_produktif`
  ADD PRIMARY KEY (`id_absen_ekskul_produktif`);

--
-- Indexes for table `tb_absen_instruktur_ekskul_biasa`
--
ALTER TABLE `tb_absen_instruktur_ekskul_biasa`
  ADD PRIMARY KEY (`id_absen_instruktur_ekskul_biasa`);

--
-- Indexes for table `tb_absen_instruktur_ekskul_produktif`
--
ALTER TABLE `tb_absen_instruktur_ekskul_produktif`
  ADD PRIMARY KEY (`id_absen_instruktur_ekskul_produktif`);

--
-- Indexes for table `tb_absen_instruktur_keputrian`
--
ALTER TABLE `tb_absen_instruktur_keputrian`
  ADD PRIMARY KEY (`id_absen_instruktur_keputrian`);

--
-- Indexes for table `tb_absen_instruktur_senbud`
--
ALTER TABLE `tb_absen_instruktur_senbud`
  ADD PRIMARY KEY (`id_absen_instruktur_senbud`);

--
-- Indexes for table `tb_absen_keputrian`
--
ALTER TABLE `tb_absen_keputrian`
  ADD PRIMARY KEY (`id_absen_keputrian`);

--
-- Indexes for table `tb_absen_senbud`
--
ALTER TABLE `tb_absen_senbud`
  ADD PRIMARY KEY (`id_absen_senbud`);

--
-- Indexes for table `tb_ekskul_biasa`
--
ALTER TABLE `tb_ekskul_biasa`
  ADD PRIMARY KEY (`id_ekskul_biasa`);

--
-- Indexes for table `tb_ekskul_produktif`
--
ALTER TABLE `tb_ekskul_produktif`
  ADD PRIMARY KEY (`id_ekskul_produktif`);

--
-- Indexes for table `tb_gambar_ekskul_biasa`
--
ALTER TABLE `tb_gambar_ekskul_biasa`
  ADD PRIMARY KEY (`id_gambar_ekskul_biasa`);

--
-- Indexes for table `tb_gambar_ekskul_produktif`
--
ALTER TABLE `tb_gambar_ekskul_produktif`
  ADD PRIMARY KEY (`id_gambar_ekskul_produktif`);

--
-- Indexes for table `tb_gambar_keputrian`
--
ALTER TABLE `tb_gambar_keputrian`
  ADD PRIMARY KEY (`id_gambar_keputrian`);

--
-- Indexes for table `tb_gambar_senbud`
--
ALTER TABLE `tb_gambar_senbud`
  ADD PRIMARY KEY (`id_gambar_senbud`);

--
-- Indexes for table `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `tb_keputrian`
--
ALTER TABLE `tb_keputrian`
  ADD PRIMARY KEY (`id_keputrian`);

--
-- Indexes for table `tb_keterangan_nilai_ekskul_biasa`
--
ALTER TABLE `tb_keterangan_nilai_ekskul_biasa`
  ADD PRIMARY KEY (`id_keterangan_nilai_ekskul_biasa`);

--
-- Indexes for table `tb_keterangan_nilai_ekskul_produktif`
--
ALTER TABLE `tb_keterangan_nilai_ekskul_produktif`
  ADD PRIMARY KEY (`id_keterangan_nilai_ekskul_produktif`);

--
-- Indexes for table `tb_keterangan_nilai_keputrian`
--
ALTER TABLE `tb_keterangan_nilai_keputrian`
  ADD PRIMARY KEY (`id_keterangan_nilai_keputrian`);

--
-- Indexes for table `tb_keterangan_nilai_senbud`
--
ALTER TABLE `tb_keterangan_nilai_senbud`
  ADD PRIMARY KEY (`id_keterangan_nilai_senbud`);

--
-- Indexes for table `tb_nilai_ekskul_biasa`
--
ALTER TABLE `tb_nilai_ekskul_biasa`
  ADD PRIMARY KEY (`id_nilai_ekskul_biasa`);

--
-- Indexes for table `tb_nilai_ekskul_produktif`
--
ALTER TABLE `tb_nilai_ekskul_produktif`
  ADD PRIMARY KEY (`id_nilai_ekskul_produktif`);

--
-- Indexes for table `tb_nilai_keputrian`
--
ALTER TABLE `tb_nilai_keputrian`
  ADD PRIMARY KEY (`id_nilai_keputrian`);

--
-- Indexes for table `tb_nilai_senbud`
--
ALTER TABLE `tb_nilai_senbud`
  ADD PRIMARY KEY (`id_nilai_senbud`);

--
-- Indexes for table `tb_rayon`
--
ALTER TABLE `tb_rayon`
  ADD PRIMARY KEY (`id_rayon`);

--
-- Indexes for table `tb_rombel`
--
ALTER TABLE `tb_rombel`
  ADD PRIMARY KEY (`id_rombel`);

--
-- Indexes for table `tb_senbud`
--
ALTER TABLE `tb_senbud`
  ADD PRIMARY KEY (`id_senbud`);

--
-- Indexes for table `tb_tgl_absen_ekskul_biasa`
--
ALTER TABLE `tb_tgl_absen_ekskul_biasa`
  ADD PRIMARY KEY (`tgl_absen_ekskul_biasa`);

--
-- Indexes for table `tb_tgl_absen_ekskul_produktif`
--
ALTER TABLE `tb_tgl_absen_ekskul_produktif`
  ADD PRIMARY KEY (`tgl_absen_ekskul_produktif`);

--
-- Indexes for table `tb_tgl_absen_keputrian`
--
ALTER TABLE `tb_tgl_absen_keputrian`
  ADD PRIMARY KEY (`tgl_absen_keputrian`);

--
-- Indexes for table `tb_tgl_absen_senbud`
--
ALTER TABLE `tb_tgl_absen_senbud`
  ADD PRIMARY KEY (`tgl_absen_senbud`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_absen_ekskul_biasa`
--
ALTER TABLE `tb_absen_ekskul_biasa`
  MODIFY `id_absen_ekskul_biasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_absen_ekskul_produktif`
--
ALTER TABLE `tb_absen_ekskul_produktif`
  MODIFY `id_absen_ekskul_produktif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_absen_instruktur_ekskul_biasa`
--
ALTER TABLE `tb_absen_instruktur_ekskul_biasa`
  MODIFY `id_absen_instruktur_ekskul_biasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_absen_instruktur_ekskul_produktif`
--
ALTER TABLE `tb_absen_instruktur_ekskul_produktif`
  MODIFY `id_absen_instruktur_ekskul_produktif` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_absen_instruktur_keputrian`
--
ALTER TABLE `tb_absen_instruktur_keputrian`
  MODIFY `id_absen_instruktur_keputrian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_absen_instruktur_senbud`
--
ALTER TABLE `tb_absen_instruktur_senbud`
  MODIFY `id_absen_instruktur_senbud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_absen_keputrian`
--
ALTER TABLE `tb_absen_keputrian`
  MODIFY `id_absen_keputrian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_absen_senbud`
--
ALTER TABLE `tb_absen_senbud`
  MODIFY `id_absen_senbud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tb_ekskul_biasa`
--
ALTER TABLE `tb_ekskul_biasa`
  MODIFY `id_ekskul_biasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_ekskul_produktif`
--
ALTER TABLE `tb_ekskul_produktif`
  MODIFY `id_ekskul_produktif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_gambar_ekskul_biasa`
--
ALTER TABLE `tb_gambar_ekskul_biasa`
  MODIFY `id_gambar_ekskul_biasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_gambar_ekskul_produktif`
--
ALTER TABLE `tb_gambar_ekskul_produktif`
  MODIFY `id_gambar_ekskul_produktif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_gambar_keputrian`
--
ALTER TABLE `tb_gambar_keputrian`
  MODIFY `id_gambar_keputrian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_gambar_senbud`
--
ALTER TABLE `tb_gambar_senbud`
  MODIFY `id_gambar_senbud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_keputrian`
--
ALTER TABLE `tb_keputrian`
  MODIFY `id_keputrian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_keterangan_nilai_ekskul_biasa`
--
ALTER TABLE `tb_keterangan_nilai_ekskul_biasa`
  MODIFY `id_keterangan_nilai_ekskul_biasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_keterangan_nilai_ekskul_produktif`
--
ALTER TABLE `tb_keterangan_nilai_ekskul_produktif`
  MODIFY `id_keterangan_nilai_ekskul_produktif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_keterangan_nilai_keputrian`
--
ALTER TABLE `tb_keterangan_nilai_keputrian`
  MODIFY `id_keterangan_nilai_keputrian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_keterangan_nilai_senbud`
--
ALTER TABLE `tb_keterangan_nilai_senbud`
  MODIFY `id_keterangan_nilai_senbud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_nilai_ekskul_biasa`
--
ALTER TABLE `tb_nilai_ekskul_biasa`
  MODIFY `id_nilai_ekskul_biasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tb_nilai_ekskul_produktif`
--
ALTER TABLE `tb_nilai_ekskul_produktif`
  MODIFY `id_nilai_ekskul_produktif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tb_nilai_keputrian`
--
ALTER TABLE `tb_nilai_keputrian`
  MODIFY `id_nilai_keputrian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_nilai_senbud`
--
ALTER TABLE `tb_nilai_senbud`
  MODIFY `id_nilai_senbud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_rayon`
--
ALTER TABLE `tb_rayon`
  MODIFY `id_rayon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_rombel`
--
ALTER TABLE `tb_rombel`
  MODIFY `id_rombel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_senbud`
--
ALTER TABLE `tb_senbud`
  MODIFY `id_senbud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
