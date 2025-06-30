-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 08:48 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_admin`, `created_at`) VALUES
(1, 'admin', '$2y$10$zmunf9nOZ6dSzPMl8xqtDO7yE/35znyqQZqIbMiJ1rPu7sSdlk1/i', 'Administrator', '2025-06-29 07:59:52');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `program_studi` varchar(100) DEFAULT NULL,
  `jenjang` varchar(10) DEFAULT NULL,
  `tahun_masuk` year(4) DEFAULT NULL,
  `tahun_lulus` int(11) DEFAULT NULL,
  `fakultas` varchar(255) DEFAULT NULL,
  `sumber_dana` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `provinsi` varchar(100) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id`, `nim`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `program_studi`, `jenjang`, `tahun_masuk`, `tahun_lulus`, `fakultas`, `sumber_dana`, `email`, `no_hp`, `password`, `created_at`, `provinsi`, `kota`) VALUES
(1, '20221001', 'Fulan Fadli', 'Laki-laki', 'Bandung', '1999-05-22', '55202', 'S1', '2018', 2022, 'Teknik Informatik', 'Gaji', 'fulan@mail.com', '08123456789', '$2y$10$VJrvAxUjwacjxxSNx5XxTOGXjcDItWXuUDnierJM2ioSTO/ART.VW', '2025-06-29 07:06:09', 'Jawa Barat', 'Bandung');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna_lulusan`
--

CREATE TABLE `pengguna_lulusan` (
  `id` int(11) NOT NULL,
  `nama_perusahaan` varchar(150) NOT NULL,
  `alamat_perusahaan` text DEFAULT NULL,
  `nama_pengisi` varchar(100) DEFAULT NULL,
  `jabatan_pengisi` varchar(100) DEFAULT NULL,
  `email_pengisi` varchar(100) DEFAULT NULL,
  `no_telp_pengisi` varchar(30) DEFAULT NULL,
  `tahun_merekrut` int(11) DEFAULT NULL,
  `jumlah_lulusan_direkrut` int(11) DEFAULT NULL,
  `etika_kerja` tinyint(4) DEFAULT NULL,
  `keahlian_profesional` tinyint(4) DEFAULT NULL,
  `penguasaan_bahasa_asing` tinyint(4) DEFAULT NULL,
  `teknologi_informasi` tinyint(4) DEFAULT NULL,
  `komunikasi` tinyint(4) DEFAULT NULL,
  `kerjasama` tinyint(4) DEFAULT NULL,
  `pengembangan_diri` tinyint(4) DEFAULT NULL,
  `saran_umum` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna_lulusan`
--

INSERT INTO `pengguna_lulusan` (`id`, `nama_perusahaan`, `alamat_perusahaan`, `nama_pengisi`, `jabatan_pengisi`, `email_pengisi`, `no_telp_pengisi`, `tahun_merekrut`, `jumlah_lulusan_direkrut`, `etika_kerja`, `keahlian_profesional`, `penguasaan_bahasa_asing`, `teknologi_informasi`, `komunikasi`, `kerjasama`, `pengembangan_diri`, `saran_umum`, `created_at`) VALUES
(1, 'Tokoweb.CO', 'Jl. Belimbing No 13 / Cihapit - Bandung', 'Fulan Fadli', 'Senior Web Developer', 'pujiermanto@gmail.com', NULL, 2024, 515, 1, 2, 2, 1, 2, 1, 3, 'Yah coba aja sih', '2025-06-29 07:46:10'),
(2, 'Mindsparks.CO', 'Jl. Nanggeleng No. 235 / Kabupaten Bandung', 'Kenanga Asumsi', 'Operational Director', 'info@mindsparks.id', '082232137137123', 2024, 2, 1, 1, 2, 1, 2, 1, 1, 'Tambahkan kegiatan khusus untuk mengasah informasi tentang perkembangan dunia teknologi', '2025-06-30 10:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna_lulusan_detail`
--

CREATE TABLE `pengguna_lulusan_detail` (
  `id` int(11) NOT NULL,
  `pengguna_id` int(11) DEFAULT NULL,
  `alumni_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna_lulusan_detail`
--

INSERT INTO `pengguna_lulusan_detail` (`id`, `pengguna_id`, `alumni_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `periode_tracer`
--

CREATE TABLE `periode_tracer` (
  `id` int(11) NOT NULL,
  `tahun` varchar(10) DEFAULT NULL,
  `lulusan_tahun` varchar(10) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `file_surat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `periode_tracer`
--

INSERT INTO `periode_tracer` (`id`, `tahun`, `lulusan_tahun`, `tanggal_mulai`, `tanggal_selesai`, `file_surat`) VALUES
(1, '2025', '2024', '2025-06-25', '2025-08-25', 'uploads/surat/1751163319_97a72915d38e2d41427f.pdf'),
(3, '2024', '2023', '2024-02-01', '2025-02-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id` int(11) NOT NULL,
  `kode_prodi` varchar(255) DEFAULT NULL,
  `nama_prodi` varchar(100) DEFAULT NULL,
  `jenjang` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id`, `kode_prodi`, `nama_prodi`, `jenjang`) VALUES
(1, '62201', 'S1 Akuntansi', 'S1'),
(2, '62401', 'D3 Akuntansi', 'D3'),
(3, '61201', 'S1 Manajemen', 'S1'),
(4, '94202', 'S1 Kewirausahaan', 'S1'),
(5, '74101', 'S1 Hukum', 'S1'),
(6, '55202', 'S1 Teknik Informatika', 'S1'),
(7, '56401', 'D3 Teknik Komputer', 'D3'),
(8, '26201', 'S1 Teknik Industri', 'S1'),
(9, '21201', 'S1 Teknik Mesin', 'S1'),
(10, '90241', 'S1 Desain Komunikasi Visual', 'S1'),
(11, '46202', 'S1 Mikrobiologi', 'S1'),
(12, '13450', 'D3 Teknologi Laboratorium Medis', 'D3'),
(13, '13350', 'D4 Teknologi Laboratorium Medis', 'D4'),
(14, '74101', 'S2 Hukum', 'S2'),
(15, '61101', 'S2 Manajemen', 'S2');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key_name` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key_name`, `value`) VALUES
(1, 'panduan_tracer', 'uploads/panduan_tracer_1751260252.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `tracer_study`
--

CREATE TABLE `tracer_study` (
  `id` int(11) NOT NULL,
  `alumni_id` int(11) NOT NULL,
  `tahun_pengisian` int(11) NOT NULL,
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

INSERT INTO `tracer_study` (`id`, `alumni_id`, `tahun_pengisian`, `status_pekerjaan`, `institusi_bekerja`, `posisi_pekerjaan`, `tahun_mulai_bekerja`, `gaji_pertama`, `tempat_kerja_kabupaten`, `sektor_tempat_kerja`, `sesuai_bidang`, `dapat_kerja_sebelum_lulus`, `cara_mendapat_kerja`, `kepuasan_etika`, `kepuasan_keahlian_bidan_ilmu`, `kepuasan_bahasa_asing`, `kepuasan_teknologi_informasi`, `kepuasan_komunikasi`, `kepuasan_kerjasama`, `kepuasan_pengembangan_diri`, `relevansi_kurikulum`, `saran_kurikulum`, `harapan_umaha`, `created_at`) VALUES
(1, 1, 2025, 'bekerja', 'PT. Inditama Nusa Digitama (Tokoweb.CO)', 'Senior Developer', 2025, 2500000, NULL, 'Kota', NULL, NULL, NULL, 1, 1, 2, 2, 3, 1, 1, 'tinggi', 'Coba kirim yah', NULL, '2025-06-29 07:56:12'),
(2, 1, 2025, 'bekerja', 'PT. Mindsparks Digital Architecture Agency', 'Senior Engineer', 2024, 3500000, NULL, 'Swasta', 'ya', NULL, 'Melamar melalui forum pencarian kerja', 2, 1, 1, 1, 1, 1, 1, 'tinggi', 'Semoga aja', NULL, '2025-06-30 10:32:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `pengguna_lulusan`
--
ALTER TABLE `pengguna_lulusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna_lulusan_detail`
--
ALTER TABLE `pengguna_lulusan_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengguna_id` (`pengguna_id`),
  ADD KEY `alumni_id` (`alumni_id`);

--
-- Indexes for table `periode_tracer`
--
ALTER TABLE `periode_tracer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_name` (`key_name`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengguna_lulusan`
--
ALTER TABLE `pengguna_lulusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengguna_lulusan_detail`
--
ALTER TABLE `pengguna_lulusan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `periode_tracer`
--
ALTER TABLE `periode_tracer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tracer_study`
--
ALTER TABLE `tracer_study`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengguna_lulusan_detail`
--
ALTER TABLE `pengguna_lulusan_detail`
  ADD CONSTRAINT `pengguna_lulusan_detail_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna_lulusan` (`id`),
  ADD CONSTRAINT `pengguna_lulusan_detail_ibfk_2` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`);

--
-- Constraints for table `tracer_study`
--
ALTER TABLE `tracer_study`
  ADD CONSTRAINT `tracer_study_ibfk_1` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
