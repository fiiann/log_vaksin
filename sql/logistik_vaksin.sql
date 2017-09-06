-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2016 at 06:37 PM
-- Server version: 5.6.30
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logistik_vaksin`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `newid` () RETURNS VARCHAR(32) CHARSET utf8 return replace(uuid(), '-', '')$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `idx` int(3) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`idx`, `username`, `password`) VALUES
(1, 'admin', '123admin');

-- --------------------------------------------------------

--
-- Table structure for table `amprahan`
--

CREATE TABLE `amprahan` (
  `id_proses` varchar(7) NOT NULL,
  `kode_instansi` varchar(7) NOT NULL,
  `tanggal` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `amprahan`
--

INSERT INTO `amprahan` (`id_proses`, `kode_instansi`, `tanggal`, `status`) VALUES
('trx-001', 'IN61101', '2016-11-09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `amprahan_detil`
--

CREATE TABLE `amprahan_detil` (
  `id_proses` varchar(7) NOT NULL,
  `id_jenis` varchar(8) NOT NULL,
  `jumlah` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `amprahan_detil`
--

INSERT INTO `amprahan_detil` (`id_proses`, `id_jenis`, `jumlah`) VALUES
('trx-001', 'JN610.01', 250),
('trx-001', 'JN610.02', 150),
('trx-001', 'JN610.03', 200);

-- --------------------------------------------------------

--
-- Table structure for table `amprah_approval`
--

CREATE TABLE `amprah_approval` (
  `id_approval` int(7) NOT NULL,
  `id_proses` varchar(7) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `amprah_approval`
--

INSERT INTO `amprah_approval` (`id_approval`, `id_proses`, `tanggal`) VALUES
(2, 'trx-001', '2016-11-10');

-- --------------------------------------------------------

--
-- Table structure for table `amprah_approval_detil`
--

CREATE TABLE `amprah_approval_detil` (
  `id_proses` varchar(7) NOT NULL,
  `kode_batch` varchar(20) NOT NULL,
  `id_jenis` varchar(10) NOT NULL,
  `jumlah` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `amprah_approval_detil`
--

INSERT INTO `amprah_approval_detil` (`id_proses`, `kode_batch`, `id_jenis`, `jumlah`) VALUES
('trx-001', 'BAT0117', 'JN610.01', 40),
('trx-001', 'BAT0232', 'JN610.01', 40),
('trx-001', 'BAT0221', 'JN610.02', 30),
('trx-001', 'BAT123', 'JN610.03', 50);

-- --------------------------------------------------------

--
-- Table structure for table `expired_stok`
--

CREATE TABLE `expired_stok` (
  `idx` int(4) NOT NULL,
  `id_jenis` varchar(8) NOT NULL,
  `bulan` tinyint(2) NOT NULL,
  `tahun` smallint(4) NOT NULL,
  `stok_awal` int(4) NOT NULL,
  `stok_expired` int(5) NOT NULL,
  `satuan` varchar(15) NOT NULL,
  `tgl_create` date NOT NULL,
  `tgl_update` date NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `instansi`
--

CREATE TABLE `instansi` (
  `kode_instansi` varchar(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `kota` varchar(45) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `instansi`
--

INSERT INTO `instansi` (`kode_instansi`, `nama`, `alamat`, `kota`, `no_telp`, `username`, `password`) VALUES
('IN61101', 'Puskesmas Aceh Barat', 'Jl. Aceh Barat', 'Banda Aceh', '023', 'YWRtaW4wMQ==', 'MTIzb2tl'),
('IN61102', 'Puskesmas Aceh Raya', 'Jl. Aceh Raya', 'Banda Aceh', '9829', 'YWRtaW4wMg==', 'MTIzb2tl');

-- --------------------------------------------------------

--
-- Table structure for table `instansi_stok`
--

CREATE TABLE `instansi_stok` (
  `idx_stok` int(7) NOT NULL,
  `kode_instansi` varchar(7) NOT NULL,
  `id_jenis` varchar(15) NOT NULL,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL,
  `jumlah` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `instansi_stok`
--

INSERT INTO `instansi_stok` (`idx_stok`, `kode_instansi`, `id_jenis`, `bulan`, `tahun`, `jumlah`) VALUES
(4, 'IN61101', 'JN610.01', 11, 2016, 40),
(5, 'IN61101', 'JN610.01', 11, 2016, 40),
(6, 'IN61101', 'JN610.02', 11, 2016, 30),
(7, 'IN61101', 'JN610.03', 11, 2016, 50);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_vaksin`
--

CREATE TABLE `jenis_vaksin` (
  `id_jenis` varchar(8) NOT NULL,
  `nama` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jenis_vaksin`
--

INSERT INTO `jenis_vaksin` (`id_jenis`, `nama`) VALUES
('JN610.01', 'Polio'),
('JN610.02', 'BCG'),
('JN610.03', 'Campak'),
('JN610.04', 'Hepatitis');

-- --------------------------------------------------------

--
-- Table structure for table `master_stok`
--

CREATE TABLE `master_stok` (
  `idx` int(4) NOT NULL,
  `id_jenis` varchar(8) NOT NULL,
  `stok_tersedia` int(5) NOT NULL,
  `satuan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_stok`
--

INSERT INTO `master_stok` (`idx`, `id_jenis`, `stok_tersedia`, `satuan`) VALUES
(1, 'JN610.01', 100, 'Dosis'),
(2, 'JN610.02', 330, 'Dosis'),
(3, 'JN610.03', 50, 'Dosis');

-- --------------------------------------------------------

--
-- Table structure for table `master_stok_detil`
--

CREATE TABLE `master_stok_detil` (
  `id_jenis` varchar(15) NOT NULL,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `satuan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_stok_detil`
--

INSERT INTO `master_stok_detil` (`id_jenis`, `bulan`, `tahun`, `jumlah`, `satuan`) VALUES
('JN610.01', 11, 2016, 250, 'Dosis'),
('JN610.02', 11, 2016, 420, 'Dosis'),
('JN610.03', 11, 2016, 150, 'Dosis');

-- --------------------------------------------------------

--
-- Table structure for table `master_vaksin`
--

CREATE TABLE `master_vaksin` (
  `kode_batch` varchar(10) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `id_jenis` varchar(8) NOT NULL,
  `vvm` varchar(1) NOT NULL,
  `tgl_terima` date NOT NULL,
  `tgl_expired` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_vaksin`
--

INSERT INTO `master_vaksin` (`kode_batch`, `nama`, `id_jenis`, `vvm`, `tgl_terima`, `tgl_expired`) VALUES
('BAT0117', 'Polio', 'JN610.01', 'A', '2016-11-01', '2016-12-31'),
('BAT0221', 'BCG', 'JN610.02', 'A', '2016-11-01', '2016-12-31'),
('BAT0232', 'Polio', 'JN610.01', 'A', '2016-11-01', '2017-01-04'),
('BAT123', 'Campak', 'JN610.03', 'A', '2016-11-02', '2016-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `pakai_stok`
--

CREATE TABLE `pakai_stok` (
  `idx_pakai` int(7) NOT NULL,
  `id_jenis` varchar(15) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pakai_stok`
--

INSERT INTO `pakai_stok` (`idx_pakai`, `id_jenis`, `jumlah`, `tanggal`) VALUES
(2, 'JN610.01', 50, '2016-11-02'),
(3, 'JN610.01', 20, '2016-11-02'),
(4, 'JN610.01', 20, '2016-11-10'),
(5, 'JN610.01', 50, '2016-11-10'),
(6, 'JN610.02', 60, '2016-11-10'),
(7, 'JN610.03', 50, '2016-11-10'),
(8, 'JN610.01', 40, '2016-11-10'),
(9, 'JN610.01', 40, '2016-11-10'),
(10, 'JN610.02', 30, '2016-11-10'),
(11, 'JN610.03', 50, '2016-11-10');

-- --------------------------------------------------------

--
-- Table structure for table `pemakaian`
--

CREATE TABLE `pemakaian` (
  `id_pakai` varchar(15) NOT NULL,
  `kode_instansi` varchar(7) NOT NULL,
  `tanggal` date NOT NULL,
  `bulan` tinyint(3) NOT NULL,
  `tahun` smallint(4) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pemakaian_detil`
--

CREATE TABLE `pemakaian_detil` (
  `id_pakai` varchar(15) NOT NULL,
  `id_jenis` varchar(15) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `satuan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`idx`);

--
-- Indexes for table `amprahan`
--
ALTER TABLE `amprahan`
  ADD PRIMARY KEY (`id_proses`);

--
-- Indexes for table `amprah_approval`
--
ALTER TABLE `amprah_approval`
  ADD PRIMARY KEY (`id_approval`);

--
-- Indexes for table `expired_stok`
--
ALTER TABLE `expired_stok`
  ADD PRIMARY KEY (`idx`);

--
-- Indexes for table `instansi`
--
ALTER TABLE `instansi`
  ADD PRIMARY KEY (`kode_instansi`);

--
-- Indexes for table `instansi_stok`
--
ALTER TABLE `instansi_stok`
  ADD PRIMARY KEY (`idx_stok`);

--
-- Indexes for table `jenis_vaksin`
--
ALTER TABLE `jenis_vaksin`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `master_stok`
--
ALTER TABLE `master_stok`
  ADD PRIMARY KEY (`idx`);

--
-- Indexes for table `master_vaksin`
--
ALTER TABLE `master_vaksin`
  ADD PRIMARY KEY (`kode_batch`),
  ADD UNIQUE KEY `idx_vaksin` (`kode_batch`);

--
-- Indexes for table `pakai_stok`
--
ALTER TABLE `pakai_stok`
  ADD PRIMARY KEY (`idx_pakai`);

--
-- Indexes for table `pemakaian`
--
ALTER TABLE `pemakaian`
  ADD PRIMARY KEY (`id_pakai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `idx` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `amprah_approval`
--
ALTER TABLE `amprah_approval`
  MODIFY `id_approval` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `expired_stok`
--
ALTER TABLE `expired_stok`
  MODIFY `idx` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `instansi_stok`
--
ALTER TABLE `instansi_stok`
  MODIFY `idx_stok` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `master_stok`
--
ALTER TABLE `master_stok`
  MODIFY `idx` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pakai_stok`
--
ALTER TABLE `pakai_stok`
  MODIFY `idx_pakai` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
