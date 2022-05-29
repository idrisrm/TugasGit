-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2021 at 09:37 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ikan`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` varchar(6) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_otlet` int(11) NOT NULL,
  `nama_barang` text NOT NULL,
  `stok` int(11) NOT NULL COMMENT 'per kg',
  `harga` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` enum('on','off') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `id_kategori`, `id_otlet`, `nama_barang`, `stok`, `harga`, `created_at`, `status`) VALUES
('1', 2, 2, 'pakan Sapi besar', 4, 44444, '2021-10-26 04:27:59', 'on'),
('fasdas', 1, 1, 'fadsf', 543, 54334, '2021-10-27 05:13:18', 'off'),
('qq', 1, 1, 'qq', 13, 2000, '2021-10-28 06:09:23', 'on'),
('qwe', 1, 1, 'qwe', 4, 17000, '2021-10-27 01:57:13', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail` int(11) NOT NULL,
  `id_penjualan` varchar(10) NOT NULL,
  `id_barang` varchar(6) NOT NULL,
  `qty` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_detail`, `id_penjualan`, `id_barang`, `qty`, `total_harga`, `catatan`, `created_at`) VALUES
(1, '8LAMvnx6f5', 'qq', 3, 6000, NULL, '2021-10-28 19:35:42'),
(5, '8LAMvnx6f5', 'qwe', 2, 35000, '', '2021-10-29 10:15:25');

-- --------------------------------------------------------

--
-- Table structure for table `hutang`
--

CREATE TABLE `hutang` (
  `no_ktp` varchar(16) NOT NULL,
  `id_otlet` int(11) NOT NULL,
  `nama_penghutang` text NOT NULL,
  `foto_ktp` text NOT NULL,
  `total_hutang` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int(1) NOT NULL COMMENT '0 = belum konfirmasi, 1 = bisa hutang, 2 = tidak bisa hutang, 3 = lunas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hutang`
--

INSERT INTO `hutang` (`no_ktp`, `id_otlet`, `nama_penghutang`, `foto_ktp`, `total_hutang`, `created_at`, `updated_at`, `status`) VALUES
('123', 1, 'tes', 'uploads/ktp/2JxyScreenshot_1.png', 41000, '2021-10-26 14:26:11', '2021-10-26 14:26:11', 1),
('1234', 1, 'tes', 'uploads/ktp/9D3fScreenshot_1.png', 0, '2021-10-28 13:06:04', '2021-10-28 13:06:04', 1),
('12345', 1, 'tes3', 'uploads/ktp/lEE5Screenshot_12.png', 0, '2021-10-28 18:08:41', '2021-10-28 18:08:41', 0);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` text NOT NULL,
  `created_at` datetime NOT NULL,
  `status` enum('on','off') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `created_at`, `status`) VALUES
(1, 'Pakan Ikan', '2021-10-26 04:28:34', 'off'),
(2, 'Pakan sapi\r\n', '2021-10-26 04:28:34', 'off'),
(3, 'boleng', '2021-10-27 05:43:07', 'off'),
(4, 'Kemarin', '2021-10-27 05:48:08', 'off');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notif` varchar(15) NOT NULL,
  `id_tujuan` int(11) NOT NULL,
  `judul` text NOT NULL,
  `deskripsi` text NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id_notif`, `id_tujuan`, `judul`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
('8ZdhaOPA0CXlLRZ', 3, 'Penambahan Stok Baru', 'Stok qq baru saja ditambahkan oleh admin sebanyak 2 kg', 1, '2021-10-28 12:51:25', '2021-10-28 18:30:18'),
('cTWsClaMQOPeruj', 1, 'Penambahan Stok Baru', 'Stok qq baru saja ditambahkan oleh admin sebanyak 1 kg', 0, '2021-10-28 18:09:24', NULL),
('ijP4vrD6RzULWQH', 1, 'Pengajuan Penghutang Baru', 'Pengajuan penghutang baru dengan nama tes3 di otlet Jember', 0, '2021-10-28 18:08:41', NULL),
('jr6hsl2T9pdTsKy', 2, 'Penambahan Stok Baru', 'Stok qq baru saja ditambahkan oleh admin sebanyak 2 kg', 0, '2021-10-28 12:51:25', NULL),
('JRlaWzueSFJPqyp', 2, 'Penambahan Stok Baru', 'Stok qwe baru saja ditambahkan oleh admin sebanyak 12 kg', 0, '2021-10-27 13:57:13', NULL),
('y4dmW5kjAO2tqIl', 1, 'Pengajuan Penghutang Baru', 'Pengajuan penghutang baru dengan nama tes di otlet Jember', 0, '2021-10-28 13:06:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `otlet`
--

CREATE TABLE `otlet` (
  `id_otlet` int(11) NOT NULL,
  `wilayah` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `otlet`
--

INSERT INTO `otlet` (`id_otlet`, `wilayah`) VALUES
(1, 'Jember'),
(2, 'Situbondo'),
(3, 'Bali');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` varchar(10) NOT NULL,
  `id_otlet` int(11) NOT NULL,
  `id_penjual` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1 = bayar, 2 = hutang',
  `ktp_penghutang` varchar(16) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `pengajuan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_otlet`, `id_penjual`, `subtotal`, `status`, `ktp_penghutang`, `created_at`, `pengajuan`) VALUES
('8LAMvnx6f5', 1, 3, 41000, 2, '', '2021-10-28 19:35:42', 'revisi');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `id_otlet` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(500) NOT NULL,
  `bagian` enum('admin','karyawan') NOT NULL,
  `status` enum('on','off') NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_otlet`, `nama`, `username`, `password`, `bagian`, `status`, `token`) VALUES
(1, 1, 'idris', 'idris', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'on', 'wndsklkasnd'),
(2, 2, 'Anggi Anggraeniii', 'anggi', '21232f297a57a5a743894a0e4a801fc3', 'karyawan', 'on', ''),
(3, 1, 'tes', 'tes', '202cb962ac59075b964b07152d234b70', 'karyawan', 'on', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_penjualan` (`id_penjualan`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `hutang`
--
ALTER TABLE `hutang`
  ADD PRIMARY KEY (`no_ktp`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `id_tujuan` (`id_tujuan`);

--
-- Indexes for table `otlet`
--
ALTER TABLE `otlet`
  ADD PRIMARY KEY (`id_otlet`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_penjual` (`id_penjual`),
  ADD KEY `ktp_penghutang` (`ktp_penghutang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `otlet`
--
ALTER TABLE `otlet`
  MODIFY `id_otlet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
