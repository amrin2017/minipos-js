-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 31, 2026 at 08:12 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.27

SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone
= "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang`
(
  `id` int NOT NULL,
  `nama_barang` varchar
(100) DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `harga` int DEFAULT NULL
);

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`
id`,
`nama_barang
`, `stock`, `harga`) VALUES
(1, 'Laptop', 70, 10000000),
(2, 'HP', 102, 5000000),
(3, 'SSD 1 TB', 79, 1200000),
(4, 'PC Core i7-13', 31, 15000000),
(5, 'Mouse Wireless', 44, 250000),
(6, 'Keyboard Mechanical', 34, 750000),
(7, 'Monitor 24 Inch', 19, 2200000),
(8, 'Bantalan Mouse', 9, 15000),
(10, 'Projector Epson MK45', 9, 6600000);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan`
(
  `id` int NOT NULL,
  `barang_id` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `usia_pembeli` int DEFAULT NULL,
  `metode_bayar` varchar
(50) DEFAULT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP,
  `nama_user` varchar
(100) NOT NULL
);

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`
id`,
`barang_id
`, `jumlah`, `usia_pembeli`, `metode_bayar`, `tanggal`, `nama_user`) VALUES
(45, 1, 1, 21, 'Transfer', '2026-05-17 15:43:48', 'Rezky Subrata'),
(46, 7, 2, 22, 'Cash', '2026-05-17 17:43:50', 'Rezky Subrata'),
(47, 1, 4, 4, 'Cash', '2026-05-17 19:37:42', 'Rezky Subrata'),
(48, 3, 2, 0, 'Cash', '2026-05-17 22:05:37', 'Rezky Subrata'),
(49, 7, 3, 33, 'Cash', '2026-05-17 22:07:22', 'Rezky Subrata'),
(50, 5, 2, 21, 'Cash', '2026-05-19 00:26:35', 'Rezky Subrata'),
(51, 8, 1, 21, 'Cash', '2026-05-19 01:22:11', 'Rezky Subrata'),
(53, 1, 3, 15, 'Transfer', '2026-05-19 01:39:06', 'Rezky Subrata'),
(54, 2, 1, 15, 'Transfer', '2026-05-19 01:39:31', 'Rezky Subrata'),
(55, 1, 1, 11, 'Cash', '2026-05-19 01:59:53', 'Rezky Subrata'),
(56, 3, 1, 3, 'Transfer', '2026-05-19 09:00:44', 'Rezky Subrata'),
(57, 5, 2, 12, 'Cash', '2026-05-25 16:30:20', 'Rezky Subrata'),
(58, 6, 1, 12, 'Cash', '2026-05-25 16:35:53', 'Rezky Subrata'),
(59, 3, 2, 12, 'Cash', '2026-05-27 22:24:51', 'Rezky Subrata'),
(60, 7, 1, 0, 'Cash', '2026-05-29 14:08:10', 'Rezky Subrata'),
(61, 1, 2, 13, 'Cash', '2026-05-30 07:32:18', 'Rezky Subrata'),
(62, 8, 2, 12, 'Transfer', '2026-05-30 20:32:39', 'Rezky Subrata'),
(63, 3, 1, 21, 'Cash', '2026-05-31 11:37:29', 'Rezky Subrata'),
(64, 10, 1, 45, 'Cash', '2026-05-31 12:13:24', 'Rezky Subrata'),
(65, 10, 1, 32, 'Cash', '2026-05-31 13:33:07', 'Rahman Hakim'),
(66, 10, 1, 34, 'Cash', '2026-05-31 15:05:33', 'Rezky Subrata');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users`
(
  `id` int NOT NULL,
  `nama` varchar
(100) DEFAULT NULL,
  `username` varchar
(50) DEFAULT NULL,
  `password` varchar
(255) DEFAULT NULL,
  `level_user` enum
('admin','kasir') DEFAULT 'kasir'
);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`
id`,
`nama
`, `username`, `password`, `level_user`) VALUES
(1, 'Amrin', 'admin123', '243279243130244C7A77746F4631693669485169416473644E466961654A6C334452793430756F6374374868534F7578464C415A367A464E6F43684F', 'kasir'),
(2, 'Rezky Subrata', 'admin', '$2y$10$TFjE8S/.gAY0KCQd3H7Hheuj03WjPXjlGu8q4NWcqyOnncY3J2jJG', 'admin'),
(3, 'Rahman Hakim', 'Meta', '$2y$10$gco6O/1yembJ5BgnN6zRauCgH1gLt3/CktjpgWdeiqotxebPyajUm', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
ADD PRIMARY KEY
(`id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
ADD PRIMARY KEY
(`id`),
ADD KEY `fk_barang`
(`barang_id`),
ADD KEY `idx_tanggal`
(`tanggal`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY
(`id`),
ADD UNIQUE KEY `username`
(`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
