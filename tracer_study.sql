-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2025 at 06:12 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tracer_umaha`
--

-- --------------------------------------------------------

--
-- Table structure for table `tracer_study`
--

CREATE TABLE `tracer_study` (
  `id` int(11) NOT NULL,
  `alumni_id` int(11) NOT NULL,
  `tahun_pengisian` int(11) NOT NULL,
  `tahun_lulus` int(255) DEFAULT NULL,
  `status_pekerjaan` enum('bekerja','wirausaha','belum_bekerja','studi_lanjut') NOT NULL,
  `institusi_bekerja` varchar(255) DEFAULT NULL,
  `posisi_pekerjaan` varchar(100) DEFAULT NULL,
  `tahun_mulai_bekerja` int(11) DEFAULT NULL,
  `gaji_pertama` int(11) DEFAULT NULL,
  `tempat_kerja_kabupaten` varchar(100) DEFAULT NULL,
  `sektor_tempat_kerja` varchar(100) DEFAULT NULL,
  `sesuai_bidang` enum('ya','tidak') DEFAULT NULL,
  `dapat_kerja_sebelum_lulus` enum('ya','tidak') DEFAULT NULL,
  `cara_mendapat_kerja` text DEFAULT NULL,
  `kepuasan_etika` tinyint(4) DEFAULT NULL,
  `kepuasan_keahlian_bidan_ilmu` tinyint(4) DEFAULT NULL,
  `kepuasan_bahasa_asing` tinyint(4) DEFAULT NULL,
  `kepuasan_teknologi_informasi` tinyint(4) DEFAULT NULL,
  `kepuasan_komunikasi` tinyint(4) DEFAULT NULL,
  `kepuasan_kerjasama` tinyint(4) DEFAULT NULL,
  `kepuasan_pengembangan_diri` tinyint(4) DEFAULT NULL,
  `relevansi_kurikulum` enum('tinggi','sedang','rendah') DEFAULT NULL,
  `saran_kurikulum` text DEFAULT NULL,
  `harapan_umaha` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tracer_study`
--

INSERT INTO `tracer_study` (`id`, `alumni_id`, `tahun_pengisian`, `tahun_lulus`, `status_pekerjaan`, `institusi_bekerja`, `posisi_pekerjaan`, `tahun_mulai_bekerja`, `gaji_pertama`, `tempat_kerja_kabupaten`, `sektor_tempat_kerja`, `sesuai_bidang`, `dapat_kerja_sebelum_lulus`, `cara_mendapat_kerja`, `kepuasan_etika`, `kepuasan_keahlian_bidan_ilmu`, `kepuasan_bahasa_asing`, `kepuasan_teknologi_informasi`, `kepuasan_komunikasi`, `kepuasan_kerjasama`, `kepuasan_pengembangan_diri`, `relevansi_kurikulum`, `saran_kurikulum`, `harapan_umaha`, `created_at`) VALUES
(1, 1, 2025, NULL, 'bekerja', 'PT. Inditama Nusa Digitama (Tokoweb.CO)', 'Senior Developer', 2025, 2500000, NULL, 'Kota', NULL, NULL, NULL, 1, 1, 2, 2, 3, 1, 1, 'tinggi', 'Coba kirim yah', NULL, '2025-06-29 07:56:12'),
(2, 1, 2025, NULL, 'bekerja', 'PT. Mindsparks Digital Architecture Agency', 'Senior Engineer', 2024, 3500000, NULL, 'Swasta', 'ya', NULL, 'Melamar melalui forum pencarian kerja', 2, 1, 1, 1, 1, 1, 1, 'tinggi', 'Semoga aja', NULL, '2025-06-30 10:32:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tracer_study`
--
ALTER TABLE `tracer_study`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumni_id` (`alumni_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tracer_study`
--
ALTER TABLE `tracer_study`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tracer_study`
--
ALTER TABLE `tracer_study`
  ADD CONSTRAINT `tracer_study_ibfk_1` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
