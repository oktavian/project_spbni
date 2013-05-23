-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 23, 2013 at 06:42 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbkoperasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE IF NOT EXISTS `akun` (
  `kode_akun` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `perlakuan` varchar(100) NOT NULL,
  PRIMARY KEY (`kode_akun`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`kode_akun`, `nama`, `perlakuan`) VALUES
('1.110', 'kas', 'aktiva lancar'),
('1.140', 'piutang anggota', 'aktiva lancar'),
('4.1.1', 'utang bagi hasil mudharabah', 'utang'),
('5.110', 'simpanan wajib', 'modal'),
('5.120', 'dana syirkah temporer', 'modal'),
('6.10', 'beban bagi hasil mudharabah', 'beban'),
('7.10', 'pendapatan yang belum dibagikan', 'pendapatan'),
('7.20', 'pendapatan margin', 'pendapatan');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_umum`
--

CREATE TABLE IF NOT EXISTS `jurnal_umum` (
  `id_jurnal` int(11) NOT NULL AUTO_INCREMENT,
  `kode_akun` varchar(10) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `urutan_akun` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `debet` int(11) DEFAULT NULL,
  `kredit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_jurnal`),
  KEY `kode_akun` (`kode_akun`),
  KEY `id_transaksi` (`id_transaksi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=237 ;

--
-- Dumping data for table `jurnal_umum`
--

INSERT INTO `jurnal_umum` (`id_jurnal`, `kode_akun`, `id_transaksi`, `urutan_akun`, `keterangan`, `debet`, `kredit`) VALUES
(192, '1.110', 46, 1, 'Oktavianus Benny s, penambahan simpanan mudharabah', 25000, 0),
(193, '5.120', 46, 2, 'Oktavianus Benny s, penambahan simpanan mudharabah', 0, 25000),
(194, '1.110', 46, 1, 'Putri sinambela, penambahan simpanan mudharabah', 25000, 0),
(195, '5.120', 46, 2, 'Putri sinambela, penambahan simpanan mudharabah', 0, 25000),
(196, '1.110', 46, 1, 'Rudianto, penambahan simpanan mudharabah', 25000, 0),
(197, '5.120', 46, 2, 'Rudianto, penambahan simpanan mudharabah', 0, 25000),
(198, '1.110', 46, 1, 'Damian nur ansyah, penambahan simpanan mudharabah', 25000, 0),
(199, '5.120', 46, 2, 'Damian nur ansyah, penambahan simpanan mudharabah', 0, 25000),
(200, '1.110', 46, 1, 'Oktavianus Benny s, penambahan simpanan wajib', 50000, 0),
(201, '5.110', 46, 2, 'Oktavianus Benny s, penambahan simpanan wajib', 0, 50000),
(202, '1.110', 46, 1, 'Putri sinambela, penambahan simpanan wajib', 50000, 0),
(203, '5.110', 46, 2, 'Putri sinambela, penambahan simpanan wajib', 0, 50000),
(204, '1.110', 46, 1, 'Rudianto, penambahan simpanan wajib', 50000, 0),
(205, '5.110', 46, 2, 'Rudianto, penambahan simpanan wajib', 0, 50000),
(206, '1.110', 46, 1, 'Damian nur ansyah, penambahan simpanan wajib', 50000, 0),
(207, '5.110', 46, 2, 'Damian nur ansyah, penambahan simpanan wajib', 0, 50000),
(208, '1.140', 47, 1, 'Oktavianus Benny s, pemberian pinjaman qardhul hasan', 10000000, 0),
(209, '1.110', 47, 2, 'Oktavianus Benny s, pemberian pinjaman qardhul hasan', 0, 10000000),
(210, '1.110', 48, 1, 'Oktavianus Benny s, penambahan simpanan mudharabah', 25000, 0),
(211, '5.120', 48, 2, 'Oktavianus Benny s, penambahan simpanan mudharabah', 0, 25000),
(212, '1.110', 48, 1, 'Oktavianus Benny s, penambahan simpanan wajib', 50000, 0),
(213, '5.110', 48, 2, 'Oktavianus Benny s, penambahan simpanan wajib', 0, 50000),
(214, '1.110', 48, 1, 'Putri sinambela, penambahan simpanan mudharabah', 25000, 0),
(215, '5.120', 48, 2, 'Putri sinambela, penambahan simpanan mudharabah', 0, 25000),
(216, '1.110', 48, 1, 'Putri sinambela, penambahan simpanan wajib', 50000, 0),
(217, '5.110', 48, 2, 'Putri sinambela, penambahan simpanan wajib', 0, 50000),
(218, '1.110', 48, 1, 'Rudianto, penambahan simpanan mudharabah', 25000, 0),
(219, '5.120', 48, 2, 'Rudianto, penambahan simpanan mudharabah', 0, 25000),
(220, '1.110', 48, 1, 'Rudianto, penambahan simpanan wajib', 50000, 0),
(221, '5.110', 48, 2, 'Rudianto, penambahan simpanan wajib', 0, 50000),
(222, '1.110', 48, 1, 'Damian nur ansyah, penambahan simpanan mudharabah', 25000, 0),
(223, '5.120', 48, 2, 'Damian nur ansyah, penambahan simpanan mudharabah', 0, 25000),
(224, '1.110', 48, 1, 'Damian nur ansyah, penambahan simpanan wajib', 50000, 0),
(225, '5.110', 48, 2, 'Damian nur ansyah, penambahan simpanan wajib', 0, 50000),
(226, '1.110', 49, 1, 'Oktavianus Benny s ,pembayaran angsuran', 1015000, 0),
(227, '1.140', 49, 2, 'Oktavianus Benny s ,pembayaran angsuran', 0, 1000000),
(228, '7.20', 49, 3, 'Oktavianus Benny s ,pembayaran angsuran', 0, 15000),
(229, '1.110', 50, 1, 'Oktavianus Benny s, penambahan simpanan mudharabah', 25000, 0),
(230, '5.120', 50, 2, 'Oktavianus Benny s, penambahan simpanan mudharabah', 0, 25000),
(231, '1.110', 50, 1, 'Oktavianus Benny s, penambahan simpanan wajib', 50000, 0),
(232, '5.110', 50, 2, 'Oktavianus Benny s, penambahan simpanan wajib', 0, 50000),
(233, '1.110', 50, 1, 'Putri sinambela, penambahan simpanan mudharabah', 25000, 0),
(234, '5.120', 50, 2, 'Putri sinambela, penambahan simpanan mudharabah', 0, 25000),
(235, '1.110', 50, 1, 'Putri sinambela, penambahan simpanan wajib', 50000, 0),
(236, '5.110', 50, 2, 'Putri sinambela, penambahan simpanan wajib', 0, 50000);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE IF NOT EXISTS `pengguna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `password`, `nama`) VALUES
(4, 'pengelola', 'pengelola', 'asep saepuloh'),
(5, 'bagian umum', 'bagian umum', 'bag'),
(6, 'ketua', 'ketua', 'tauhid hidayat');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_anggota`
--

CREATE TABLE IF NOT EXISTS `tbl_anggota` (
  `id_anggota` varchar(100) NOT NULL,
  `id_identitas` int(11) NOT NULL,
  `nama_anggota` varchar(200) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `status_pegawai` enum('tetap','outsourcing') NOT NULL,
  `estimasi_byr` int(11) DEFAULT NULL,
  `status_anggota` int(2) NOT NULL,
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id_anggota`, `id_identitas`, `nama_anggota`, `tgl_masuk`, `tgl_lahir`, `alamat`, `no_telp`, `jabatan`, `status_pegawai`, `estimasi_byr`, `status_anggota`) VALUES
('AKN-0001', 1010, 'Oktavianus Benny s', '2013-02-02', '1989-10-17', 'jalan sukabirus no. 153, ds citereup, Bandung selatan, jawa barat', '085727273941', 'developer', 'tetap', 1000000, 1),
('AKN-0002', 2020, 'Putri sinambela', '2004-01-20', '1986-05-20', 'jalan medan no. 134, desa cipayun Bandung ', '089993994789', 'Staf akunting', 'outsourcing', 500000, 1),
('AKN-0003', 3030, 'Rudianto', '2004-04-14', '1983-01-11', 'jalan kenangan no, 07, desa bunga bandung', '085777234567', 'Staf akunting', 'tetap', 1000000, 1),
('AKN-0004', 4040, 'Damian nur ansyah', '2005-07-21', '1974-03-12', 'jalan cisaruwa, no. 44 Bandung ', '089999999333', 'head office', 'tetap', 2000000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_angsuran_rutin`
--

CREATE TABLE IF NOT EXISTS `tbl_angsuran_rutin` (
  `id_angsuran` int(11) NOT NULL AUTO_INCREMENT,
  `id_pinjaman` varchar(100) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `tgl_buat` date NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `sisa_jml_bayar` int(11) NOT NULL,
  `sisa_byr_ulang` int(11) NOT NULL,
  `sts_tunggu` int(1) NOT NULL,
  `sts_lunas` int(1) NOT NULL,
  PRIMARY KEY (`id_angsuran`),
  KEY `id_pinjaman` (`id_pinjaman`,`id_transaksi`),
  KEY `id_transaksi` (`id_transaksi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_angsuran_rutin`
--

INSERT INTO `tbl_angsuran_rutin` (`id_angsuran`, `id_pinjaman`, `id_transaksi`, `tgl_buat`, `jumlah_bayar`, `sisa_jml_bayar`, `sisa_byr_ulang`, `sts_tunggu`, `sts_lunas`) VALUES
(8, 'PJM-0001', 49, '2013-02-25', 1015000, 9135000, 9, 1, 1),
(9, 'PJM-0001', NULL, '2013-09-24', 1015000, 8120000, 8, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pinjaman`
--

CREATE TABLE IF NOT EXISTS `tbl_pinjaman` (
  `id_pinjaman` varchar(100) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `id_anggota` varchar(100) NOT NULL,
  `nominal_pinjaman` float(20,3) NOT NULL,
  `jml_angsuran` int(11) NOT NULL,
  `jml_margin` float(20,3) NOT NULL,
  `nominal_angsuran` float(20,3) NOT NULL,
  `pembayaran_ke` int(11) NOT NULL,
  `acc` int(1) NOT NULL,
  `status_pembayaran` varchar(30) NOT NULL,
  PRIMARY KEY (`id_pinjaman`),
  KEY `id_transaksi` (`id_transaksi`),
  KEY `id_anggota` (`id_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pinjaman`
--

INSERT INTO `tbl_pinjaman` (`id_pinjaman`, `id_transaksi`, `id_anggota`, `nominal_pinjaman`, `jml_angsuran`, `jml_margin`, `nominal_angsuran`, `pembayaran_ke`, `acc`, `status_pembayaran`) VALUES
('PJM-0001', 47, 'AKN-0001', 10000000.000, 10, 15000.000, 1000000.000, 1, 1, 'belum lunas');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_simpanan_rutin`
--

CREATE TABLE IF NOT EXISTS `tbl_simpanan_rutin` (
  `id_simpanan` varchar(100) NOT NULL,
  `id_anggota` varchar(100) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `tgl_pembuatan` date NOT NULL,
  `jenis_simpanan` varchar(50) NOT NULL,
  `nilai` int(11) NOT NULL,
  `status_tunggu` int(1) NOT NULL,
  `status_lunas` int(1) NOT NULL,
  PRIMARY KEY (`id_simpanan`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_transaksi` (`id_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_simpanan_rutin`
--

INSERT INTO `tbl_simpanan_rutin` (`id_simpanan`, `id_anggota`, `id_transaksi`, `tgl_pembuatan`, `jenis_simpanan`, `nilai`, `status_tunggu`, `status_lunas`) VALUES
('SIMMDH-0001', 'AKN-0001', 46, '2013-01-28', 'simpanan mudharabah', 25000, 1, 1),
('SIMMDH-0002', 'AKN-0002', 46, '2013-01-28', 'simpanan mudharabah', 25000, 1, 1),
('SIMMDH-0003', 'AKN-0003', 46, '2013-01-28', 'simpanan mudharabah', 25000, 1, 1),
('SIMMDH-0004', 'AKN-0004', 46, '2013-01-28', 'simpanan mudharabah', 25000, 1, 1),
('SIMMDH-0005', 'AKN-0001', 48, '2013-02-25', 'simpanan mudharabah', 25000, 1, 1),
('SIMMDH-0006', 'AKN-0002', 48, '2013-02-25', 'simpanan mudharabah', 25000, 1, 1),
('SIMMDH-0007', 'AKN-0003', 48, '2013-02-25', 'simpanan mudharabah', 25000, 1, 1),
('SIMMDH-0008', 'AKN-0004', 48, '2013-02-25', 'simpanan mudharabah', 25000, 1, 1),
('SIMMDH-0009', 'AKN-0001', 50, '2013-03-25', 'simpanan mudharabah', 25000, 1, 1),
('SIMMDH-0010', 'AKN-0002', 50, '2013-03-25', 'simpanan mudharabah', 25000, 1, 1),
('SIMMDH-0011', 'AKN-0003', 50, '2013-03-25', 'simpanan mudharabah', 25000, 1, 0),
('SIMMDH-0012', 'AKN-0004', 50, '2013-03-25', 'simpanan mudharabah', 25000, 1, 0),
('SIMWJB-0001', 'AKN-0001', 46, '2013-01-28', 'simpanan wajib', 50000, 1, 1),
('SIMWJB-0002', 'AKN-0002', 46, '2013-01-28', 'simpanan wajib', 50000, 1, 1),
('SIMWJB-0003', 'AKN-0003', 46, '2013-01-28', 'simpanan wajib', 50000, 1, 1),
('SIMWJB-0004', 'AKN-0004', 46, '2013-01-28', 'simpanan wajib', 50000, 1, 1),
('SIMWJB-0005', 'AKN-0001', 48, '2013-02-25', 'simpanan wajib', 50000, 1, 1),
('SIMWJB-0006', 'AKN-0002', 48, '2013-02-25', 'simpanan wajib', 50000, 1, 1),
('SIMWJB-0007', 'AKN-0003', 48, '2013-02-25', 'simpanan wajib', 50000, 1, 1),
('SIMWJB-0008', 'AKN-0004', 48, '2013-02-25', 'simpanan wajib', 50000, 1, 1),
('SIMWJB-0009', 'AKN-0001', 50, '2013-03-25', 'simpanan wajib', 50000, 1, 1),
('SIMWJB-0010', 'AKN-0002', 50, '2013-03-25', 'simpanan wajib', 50000, 1, 1),
('SIMWJB-0011', 'AKN-0003', 50, '2013-03-25', 'simpanan wajib', 50000, 1, 0),
('SIMWJB-0012', 'AKN-0004', 50, '2013-03-25', 'simpanan wajib', 50000, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi`
--

CREATE TABLE IF NOT EXISTS `tbl_transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_transaksi` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `tbl_transaksi`
--

INSERT INTO `tbl_transaksi` (`id_transaksi`, `nama_transaksi`, `tanggal`) VALUES
(46, 'pembayaran simpanan', '2013-02-02'),
(47, 'pemberian pinjaman', '2013-02-20'),
(48, 'pembayaran simpanan', '2013-03-05'),
(49, 'pembayaran angsuran', '2013-03-01'),
(50, 'pembayaran simpanan', '2013-08-05');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jurnal_umum`
--
ALTER TABLE `jurnal_umum`
  ADD CONSTRAINT `jurnal_umum_ibfk_1` FOREIGN KEY (`kode_akun`) REFERENCES `akun` (`kode_akun`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jurnal_umum_ibfk_2` FOREIGN KEY (`id_transaksi`) REFERENCES `tbl_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_angsuran_rutin`
--
ALTER TABLE `tbl_angsuran_rutin`
  ADD CONSTRAINT `tbl_angsuran_rutin_ibfk_1` FOREIGN KEY (`id_pinjaman`) REFERENCES `tbl_pinjaman` (`id_pinjaman`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_angsuran_rutin_ibfk_2` FOREIGN KEY (`id_transaksi`) REFERENCES `tbl_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_pinjaman`
--
ALTER TABLE `tbl_pinjaman`
  ADD CONSTRAINT `tbl_pinjaman_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `tbl_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `tbl_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_simpanan_rutin`
--
ALTER TABLE `tbl_simpanan_rutin`
  ADD CONSTRAINT `tbl_simpanan_rutin_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `tbl_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_simpanan_rutin_ibfk_2` FOREIGN KEY (`id_transaksi`) REFERENCES `tbl_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
