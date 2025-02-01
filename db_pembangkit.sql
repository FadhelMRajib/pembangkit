-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2025 at 07:17 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pembangkit`
--

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(11) NOT NULL,
  `jabatan` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `jabatan`) VALUES
(4, 'Admin'),
(5, 'Marketing'),
(6, 'It Support'),
(7, 'Pegawai');

-- --------------------------------------------------------

--
-- Table structure for table `mesin`
--

CREATE TABLE `mesin` (
  `id_mesin` int(11) NOT NULL,
  `id_uld` int(11) NOT NULL,
  `id_up3` int(11) NOT NULL,
  `sistem` varchar(50) NOT NULL,
  `nama_mesin` varchar(500) NOT NULL,
  `kode_mesin` varchar(100) NOT NULL,
  `merek_mesin` varchar(50) NOT NULL,
  `tipe_mesin` varchar(225) NOT NULL,
  `seri_mesin` varchar(225) NOT NULL,
  `merek_generator` varchar(225) NOT NULL,
  `nama_trafo` varchar(225) NOT NULL,
  `tegangan` varchar(50) NOT NULL,
  `kapasitas` varchar(50) NOT NULL,
  `tahun_operasi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mesin`
--

INSERT INTO `mesin` (`id_mesin`, `id_uld`, `id_up3`, `sistem`, `nama_mesin`, `kode_mesin`, `merek_mesin`, `tipe_mesin`, `seri_mesin`, `merek_generator`, `nama_trafo`, `tegangan`, `kapasitas`, `tahun_operasi`) VALUES
(2, 12, 7, 'Interkoneksi', 'PLTD MOBILER UP3 BANJARMASIN #01 (DEUTZ)', '22552130101001', 'DEUTZ', 'F4L912', '8143 DO 0606', 'LEROY SOMER', '-', '-', '-', '1999'),
(4, 12, 7, 'Interkoneksi', 'PLTD MOBILER UP3 BANJARMASIN #02 (MAN)', '22552130101002', 'MAN', 'D 0836 LE 201', '18020175432008', 'LEROY SOMER', '-', '-', '-', '2009'),
(5, 12, 7, 'Disconnected', 'PLTD UP3 BANJARMASIN #03 (DEUTZ) EX PLTD RANTAU BUJUR #01', '22552130103001', 'DEUTZ', 'F 6L - 912', '8163 D 0157', 'STAMFORD', '-', '-', '-', '1992'),
(6, 12, 7, 'Disconnected', 'PLTD UP3 BANJARMASIN #04 (DEUTZ) EX PLTD RANTAU BUJUR #02', '22552130103002', 'DEUTZ', 'F4L912', '8163 D 0321', 'LEROY SOMER', '-', '-', '-', '1994'),
(7, 13, 7, 'Interkoneksi', 'PLTD BENUA RIAM #01 (DEUTZ)', '22552130104001', 'DEUTZ', 'F4L912', '8143 D 0509', 'STAMFORD', '-', '-', '-', '1995'),
(8, 13, 7, 'Interkoneksi', 'PLTD BENUA RIAM #02 (DEUTZ)', '22552130104002', 'DEUTZ', 'F5L 413 FR', '8058080', 'LEROY SOMER', 'Trafindo', '380/20 KV', '160 KVA', '2000'),
(9, 13, 7, 'Interkoneksi', 'PLTD BENUA RIAM #04 (DEUTZ)', '22552130104004', 'DEUTZ', 'F 6L - 912', '8163 D 0130', 'STAMFORD', '-', '-', '-', '1997'),
(10, 13, 7, 'Interkoneksi', 'PLTD BENUA RIAM #05 (DEUTZ) EX PLTD RANTAU BUJUR #05', '22552130104005', 'DEUTZ', 'F10L 413F', '6953228', 'STAMFORD', 'Bambang Jaya', '20/0.38 KV', '200 KVA', '2015'),
(11, 13, 7, 'Disconnected', 'PLTD BENUA RIAM #06 (DEUTZ) EX PLTD RANTAU BUJUR #03', '22552130103003', 'DEUTZ', 'F 6L - 912', '8143 D 0523', 'STAMFORD', '-', '-', '-', '2005'),
(14, 16, 6, 'Interkoneksi', 'PLTD GERONGGANG #02 (MAN)', '22552180113002', 'MAN', 'D 2866 LE 201', '713128', 'AVK COSIMAT', '-', '20/0.38 KV', '160 KVA', '1999'),
(15, 16, 6, 'Interkoneksi', 'PLTD GERONGGANG #03 (DEUTZ)', '22552180113003', 'DEUTZ', 'BF 6 M 1015 C', '9120193', 'STAMFORD', '-', '20/0.38 KV', '315 KVA', '1998'),
(16, 16, 6, 'Interkoneksi', 'PLTD GERONGGANG #04 (MWM)', '22552180113004', 'MWM', 'TBD 232 V12', '97123F0041', 'STAMFORD', '-', '20/0.38 KV', '315 KVA', '1996'),
(17, 16, 6, 'Interkoneksi', 'PLTD GERONGGANG #05 (SCANIA)', '22552180113005', 'SCANIA', 'DC 072A', '6933047', 'SCANIA', '-', '20/0.38 KV', '-', '2017'),
(18, 16, 6, 'Interkoneksi', 'PLTD GERONGGANG #07 (DEUTZ)', '22552180113007', 'DEUTZ', 'TCD 2013 L06 4V', '12006170', 'STAMFORD', 'Trafindo', '20/0.38 KV', '315 KVA', '2017'),
(19, 16, 6, 'Interkoneksi', 'PLTD GERONGGANG #09 (DEUTZ) EX PLTD SAMPANAHAN #04', '22552180113009', 'DEUTZ', 'BF 6 M 1015 C', '9120486', 'LEROY SOMER', '-', '20/0.38 KV', '-', '2012'),
(20, 16, 6, 'Interkoneksi', 'PLTD GERONGGANG #11 (DEUTZ) EX PLTD GUNUNG BATU BESAR #07', '22552180115007', 'DEUTZ', 'BF 6M 1013 EC', '687191', 'STAMFORD', '-', '20/0.38 KV', '-', '2002'),
(21, 17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR #01 (DEUTZ)', '22552180115001', 'DEUTZ', 'BF4M 1012 E', '00096156', 'LEROY SOMER', '-', '-', '315 KVA', '1996'),
(22, 17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR #02 (DEUTZ)', '22552180115002', 'DEUTZ', 'F10L 413F', '84103 C 0063', 'STAMFORD', '-', '20/0.38 KV', '-', '1993'),
(23, 17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR #03 (DEUTZ)', '22552180115003', 'DEUTZ', 'F10L 413F', '84103 C 0053', 'STAMFORD', '-', '20/0.38 KV', '-', '2012'),
(24, 17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR #04 (DEUTZ)', '22552180115004', 'DEUTZ', 'BF 6M 1013 EC', '11953972', 'STAMFORD', 'Trafindo', '20/0.38 KV', '315 KVA', '2017'),
(25, 17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR #05 (DEUTZ)', '22552180115005', 'DEUTZ', 'BF 6M 1013 EC', '11953973', 'STAMFORD', 'Trafindo', '20/0.38 KV', '-', '2017'),
(26, 17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR #06 (DEUTZ) EX PLTD SAMPANAHAN #02', '22552180115006', 'DEUTZ', 'BA 6 M 816 U', '7073441', 'STAMFORD', '-', '20/0.38 KV', '-', '1985'),
(27, 17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR #08 (DEUTZ) EX PLTD BAKAU #07', '22552180115009', 'DEUTZ', 'BF 6M 1013 EC', '0294691', 'STAMFORD', '-', '-', '-', '2002'),
(28, 17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR #09 (DEUTZ) EX PLTD BAKAU #05', '22552180110005', 'DEUTZ', 'BF 6M 1013 EC', '11956630', '-', '-', '-', '160 KVA', '2017'),
(29, 17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR #10 (DEUTZ) EX PLTD SUNGAI DURIAN #05', '22552180109005', 'DEUTZ', 'F10L 413F', '761110.0', 'STAMFORD', '-', '-', '-', '2002'),
(30, 17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR #11 (DEUTZ) EX PLTD TANJUNG SELOKA #05', '22552180105005', 'DEUTZ', 'TCD 2013 L06 4V', '11954663', 'STAMFORD', 'Trafindo', '20/0.38 KV', '315 KVA', '2017'),
(31, 17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR #12 (DEUTZ) EX PLTD TANJUNG SELOKA #07', '22552180105007', 'DEUTZ', 'TCD 2013 L06 4V', '12006173', 'STAMFORD', 'Trafindo', '20/0.38 KV', '315 KVA', '2017'),
(32, 17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR #13 (DEUTZ) EX PLTD SUNGAI DURIAN #08', '22552180109008', 'DEUTZ', 'TCD 2013 L06 4V', '12006162', 'STAMFORD', 'Trafindo', '20/0.38 KV', '315 KVA', '2018'),
(33, 17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR #14 (DEUTZ) EX PLTD GERONGGANG #06', '22552180113006', 'DEUTZ', 'TCD 2013 L06 4V', '12006169', 'STAMFORD', '-', '20/0.38 KV', '-', '2017'),
(34, 18, 6, 'Isolated', 'PLTD KERASIAN #01 (MTU)', '22552180120001', 'MTU', '6 R 183 AA 32', '44790000000086349', 'LEROY SOMER', '-', '20/0.38 KV', '160 KVA', '2004'),
(35, 18, 6, 'Isolated', 'PLTD KERASIAN #02 (DEUTZ)', '22552180120002', 'DEUTZ', 'BF 6M 1013 EC', '11956632', 'STAMFORD', 'Trafindo', '20/0.38 KV', '160 KVA', '2017'),
(36, 18, 6, 'Isolated', 'PLTD KERASIAN #03 (DEUTZ)', '22552180120003', 'DEUTZ', 'BF 6M 1013 EC', '11953968', 'STAMFORD', 'Trafindo', '20/0.38 KV', '160 KVA', '2017'),
(37, 19, 6, 'Isolated', 'PLTD KERAYAAN #01 (DEUTZ)', '22552180145001', 'DEUTZ', 'BF 6M 1013 EC', '11953969', 'STAMFORD', 'Trafindo', '20/0.38 KV', '160 KVA', '2017'),
(38, 19, 6, 'Isolated', 'PLTD KERAYAAN #02 (DEUTZ)', '22552180145002', 'DEUTZ', 'BF 6M 1013 EC', '11953389', 'STAMFORD', 'Trafindo', '20/0.38 KV', '160 KVA', '2017'),
(39, 19, 6, 'Isolated', 'PLTD KERAYAAN #03 (DEUTZ)', '22552180145003', 'DEUTZ', 'BF 6M 1013 EC', '11953390', 'STAMFORD', 'Trafindo', '20/0.38 KV', '160 KVA', '2017'),
(40, 19, 6, 'Isolated', 'PLTD KERAYAAN #04 (DEUTZ)', '22552180145004', 'DEUTZ', 'BF 6M 1013 EC', '11953387', 'STAMFORD', 'Trafindo', '20/0.38 KV', '160 KVA', '2017'),
(41, 20, 6, 'Isolated', 'PLTD KERUMPUTAN #01 (DEUTZ)', '22552180146001', 'DEUTZ', 'BF 6M 1013 EC', '11953975', 'STAMFORD', 'Trafindo', '20/0.38 KV', '160 KVA', '2017'),
(42, 20, 6, 'Isolated', 'PLTD KERUMPUTAN #02 (DEUTZ)', '22552180146002', 'DEUTZ', 'BF 6M 1013 EC', '11953979', 'STAMFORD', 'Trafindo', '20/0.38 KV', '160 KVA', '2017'),
(43, 20, 6, 'Isolated', 'PLTD KERUMPUTAN #03 (DEUTZ)', '22552180146003', 'DEUTZ', 'BF 6M 1013 EC', '11953974', 'STAMFORD', 'Trafindo', '20/0.38 KV', '160 KVA', '2017'),
(44, 20, 6, 'Isolated', 'PLTD KERUMPUTAN #04 (DEUTZ) EX PLTD BAKAU #01', '22552180146005', 'DEUTZ', 'F 6 L 912 F', '8163 D 0526', 'STAMFORD', '-', '-', '-', '1994'),
(45, 21, 6, 'Isolated', 'PLTD MARABATUAN #01 (CUMMINS)', '22552180106001', 'CUMMINS', '6 CTA 83.G', '44783825', 'STAMFORD', '-', '20/0.38 KV', '-', '1993'),
(46, 21, 6, 'Isolated', 'PLTD MARABATUAN #02 (DEUTZ)', '22552180106002', 'DEUTZ', 'F10L 413F', '8413 C 0109', 'STAMFORD', '-', '20/0.38 KV', '-', '1995'),
(47, 21, 6, 'Isolated', 'PLTD MARABATUAN #03 (DEUTZ)', '22552180106003', 'DEUTZ', 'F10L 413F', '8413 C 0116', 'STAMFORD', '-', '20/0.38 KV', '-', '1991'),
(48, 21, 6, 'Isolated', 'PLTD MARABATUAN #04 (DEUTZ) EX PLTD SUNGAI BALI #04', '22552180106004', 'DEUTZ', 'F10L 413F', '84103 A 0001', 'STAMFORD', '-', '-', '-', '1991'),
(49, 21, 6, 'Isolated', 'PLTD MARABATUAN #05 (DEUTZ) EX PLTD BAKAU #02', '22552180106005', 'DEUTZ', 'F 6 L 912 F', '8163 F 0685', 'STAMFORD', '-', '20/0.38 KV', '160 KVA', '1996'),
(50, 21, 6, 'Isolated', 'PLTD MARABATUAN #06 (DEUTZ) EX PLTD TANJUNG SELOKA #08', '22552180116005', 'DEUTZ', 'BF 6M 1013 EC', '11953981', 'STAMFORD', '-', '-', '-', '2017'),
(51, 22, 6, 'Interkoneksi', ' PLTD MOBILER MULYA HARJA #01 (DEUTZ) EX PLTD MOBILER AREA KOTABARU #03 ', ' 22552180116009 ', 'DEUTZ', ' BF 6 M 1015 CP LA G ', ' 1167/100M140465 ', 'STAMFORD', '-', '20/0.38 KV', '-', '2014'),
(52, 22, 6, 'Interkoneksi', ' PLTD MULYA HARJA #02 (DEUTZ) ', ' 22552180116002 ', 'DEUTZ', ' BF4M 1012 E ', ' 00096160 ', 'STAMFORD', '-', '20/0.38 KV', '-', '1996'),
(54, 23, 6, 'Interkoneksi', ' PLTD SAMPANAHAN #01 (MWM) ', ' 22552180108001 ', 'MWM', ' TBD 232 V 6 ', ' 8763 E 0019 ', 'STAMFORD', '-', '20/0.38 KV', '630 KVA', '1996'),
(55, 23, 6, 'Interkoneksi', ' PLTD SAMPANAHAN #05 (MTU) ', ' 22552180108005 ', 'MTU', ' 12V2000G62 ', ' 535101707 ', 'LEROY SOMER', '-', '20/0.38 KV', '-', '2003'),
(57, 26, 6, 'Isolated', ' PLTD SUNGAI BALI #02 (MAN) ', ' 22552180104002 ', 'MAN', ' D0826 LE201 ', ' 1709762525 C 501 ', ' AVK ', '-', '20/0.38 KV', '160 KVA', '2001'),
(58, 26, 6, 'Isolated', ' PLTD SUNGAI BALI #05 (DEUTZ) ', ' 22552180104005 ', 'DEUTZ', ' TCD 2013 L06 4V ', ' 11895187 ', 'STAMFORD', 'Trafindo', '20/0.38 KV', '315 KVA', '2017'),
(59, 26, 6, 'Isolated', ' PLTD SUNGAI BALI #06 (DEUTZ) ', ' 22552180104006 ', 'DEUTZ', 'TCD 2013 L06 4V', ' 11902075 ', 'STAMFORD', 'Trafindo', '20/0.38 KV', '315 KVA', '2017'),
(60, 26, 6, 'Isolated', ' PLTD SUNGAI BALI #07 (DEUTZ) ', ' 22552180104007 ', 'DEUTZ', 'TCD 2013 L06 4V', ' 12021675 ', 'STAMFORD', 'Trafindo', '20/0.38 KV', '315 KVA', '2017'),
(61, 26, 6, 'Isolated', ' PLTD SUNGAI BALI #08 (DEUTZ) ', ' 22552180104008 ', 'DEUTZ', 'TCD 2013 L06 4V', ' 12022521 ', 'STAMFORD', 'Trafindo', '20/0.38 KV', '315 KVA', '2017'),
(62, 26, 6, 'Isolated', ' PLTD SUNGAI BALI #09 (DEUTZ) ', ' 22552180104009 ', 'DEUTZ', 'TCD 2013 L06 4V', ' 12021659 ', 'STAMFORD', 'Trafindo', '20/0.38 KV', '315 KVA', '2017'),
(63, 26, 6, 'Isolated', ' PLTD SUNGAI BALI #10 (MTU) EX PLTD SENGAYAM #02 ', ' 22552180104013 ', 'MTU', ' 12V2000G62 ', ' 535102552 ', 'LEROY SOMER', '-', '-', '-', '2003'),
(64, 26, 6, 'Isolated', ' PLTD SUNGAI BALI #11 (CUMMINS) EX PLTD LONTAR #03 ', ' 22552180104012 ', 'CUMMINS', ' QSK23-G3 ', ' 85002828 ', 'STAMFORD', 'Lucky Light', '20/0.38 KV', '820 KVA', '2017'),
(65, 26, 6, 'Isolated', ' PLTD SUNGAI BALI #12 (DEUTZ) EX PLTD TANJUNG SELOKA #06 ', ' 22552180105006 ', 'DEUTZ', ' TCD 2013 L06 4V ', ' 12006165.0 ', 'STAMFORD', 'Trafindo', '20/0.38 KV', '315 KVA', '2017'),
(66, 27, 6, 'Isolated', ' PLTD SUNGAI DURIAN #01 (DEUTZ) ', ' 22552180109001 ', 'DEUTZ', ' F6L 912 F ', ' 8163 D 0525 ', 'STAMFORD', '-', '20/0.38 KV', '315 KVA', '1994'),
(67, 27, 6, 'Isolated', ' PLTD SUNGAI DURIAN #02 (DEUTZ) ', ' 22552180109002 ', 'DEUTZ', ' F6L 912 ', ' 8643929 ', 'LEROY SOMER', '-', '20/0.38 KV', '-', '2002'),
(68, 27, 6, 'Isolated', ' PLTD SUNGAI DURIAN #03 (DEUTZ) ', ' 22552180109003 ', 'DEUTZ', ' F 6 L 912 L ', ' 8163 D 0539 ', 'STAMFORD', '-', '20/0.38 KV', '-', '1990'),
(69, 28, 6, 'Isolated', ' PLTD MOBILER TANJUNG BATU #01 (FORD) EX PLTD MOBILER AREA KOTABARU #01 ', ' 22552180101018 ', 'FORD', ' 2725E ', ' E7173/353 NL ', 'STAMFORD', '-', '-', '-', '2012'),
(70, 28, 6, 'Isolated', ' PLTD TANJUNG BATU #01 (MERCEDES-BENZ) ', ' 22552180103001 ', ' MERCEDES-BENZ ', ' OM 402 ', ' 900-000-246423 ', ' AVK ', '-', '20/0.38 KV', '400 KVA', '1983'),
(71, 28, 6, 'Isolated', ' PLTD TANJUNG BATU #02 (DEUTZ) ', ' 22552180103002 ', 'DEUTZ', ' F5L 413 FR ', ' 8048072 ', 'LEROY SOMER', '-', '20/0.38 KV', '-', '1993'),
(72, 28, 6, 'Isolated', ' PLTD TANJUNG BATU #03 (DEUTZ KHD) ', ' 22552180103003 ', ' DEUTZ KHD ', ' BF6M 1013 E ', ' 00130957 ', 'LEROY SOMER', '-', '20/0.38 KV', '-', '1996'),
(73, 28, 6, 'Isolated', ' PLTD TANJUNG BATU #05 (KOMATSU) ', ' 22552180103005 ', 'KOMATSU', ' S6D 140-1 ', ' 118647 ', 'STAMFORD', '-', '20/0.38 KV', '-', '1994'),
(74, 28, 6, 'Isolated', ' PLTD TANJUNG BATU #06 (DEUTZ) ', ' 22552180103007 ', 'DEUTZ', ' TCD 2013 L06 4V ', ' 12006171 ', 'STAMFORD', '-', '20/0.38 KV', '315 KVA', '2018'),
(75, 28, 6, 'Isolated', ' PLTD TANJUNG BATU #07 (DEUTZ) ', ' 22552180103008 ', 'DEUTZ', ' TCD 2013 L06 4V ', ' 12006172 ', 'STAMFORD', '-', '20/0.38 KV', '315 KVA', '2018'),
(76, 28, 6, 'Isolated', ' PLTD TANJUNG BATU #08 (DEUTZ) EX PLTD SAMPANAHAN #06 ', ' 22552180103009 ', 'DEUTZ', ' TCD 2013 L06 4V ', ' 11951481 ', 'STAMFORD', 'Trafindo', '20/0.38 KV', '315 KVA', '2017'),
(77, 28, 6, 'Isolated', ' PLTD TANJUNG BATU #09 (DEUTZ) EX PLTD BAKAU #06 ', ' 22552180103010 ', 'DEUTZ', ' BF 6M 1013 EC ', ' 11956636 ', 'STAMFORD', 'Trafindo', '20/0.38 KV', '160 KVA', '2017'),
(78, 28, 6, 'Isolated', ' PLTD TANJUNG BATU #10 (DEUTZ) EX PLTD SUNGAI DURIAN #07 ', ' 22552180109007 ', 'DEUTZ', ' TCD 2013 L06 4V ', ' 11966098.0 ', 'STAMFORD', 'Trafindo', '20/0.38 KV', '315 KVA', '2018'),
(79, 28, 6, 'Isolated', ' PLTD TANJUNG BATU #11 (DEUTZ) EX PLTD SUNGAI DURIAN #06 ', ' 22552180109006 ', 'DEUTZ', ' TCD 2013 L06 4V ', ' 12006166.0 ', 'STAMFORD', 'Trafindo', '20/0.4 KV', '315 KVA', '2017'),
(80, 28, 6, 'Isolated', ' PLTD TANJUNG BATU #12 (DEUTZ) EX PLTD GERONGGANG #08 ', ' 22552180113008 ', 'DEUTZ', ' TCD 2013 L06 4V ', ' 12006168 ', 'STAMFORD', '-', '20/0.38 KV', '-', '2017'),
(81, 28, 6, 'Isolated', ' PLTD TANJUNG BATU #13 (DEUTZ) EX PLTD GERONGGANG #01 ', ' 22552180113001 ', 'DEUTZ', ' BF 6M 1013 EC ', ' 619998 ', 'STAMFORD', '-', '20/0.38 KV', '400 KVA', '1998'),
(82, 30, 6, 'Interkoneksi', ' PLTD TANJUNG SELOKA #03 (DEUTZ) ', ' 22552180105003 ', 'DEUTZ', ' BF 8M 1015 C ', ' 9116512 ', 'LEROY SOMER', 'Starlite', '20/0.38 KV', '-', '1996'),
(83, 31, 6, 'Isolated', ' PLTD MOBILER UP3 KOTABARU #02 (DEUTZ) ', ' 22552180103006 ', 'DEUTZ', ' BF 6 M 1015 C ', ' 9178852 ', 'STAMFORD', '-', '20/0.38 KV', '-', '2010'),
(84, 31, 6, 'Isolated', ' PLTD MOBILER UP3 KOTABARU #04 (DEUTZ) ', ' 22552180117001 ', 'DEUTZ', ' F4L912 ', ' 8143D0505 ', 'LEROY SOMER', '-', '-', '-', '1993'),
(89, 32, 4, 'Isolated', 'PLTD BABAI #01 (DEUTZ)', ' 22.552.160.110.001 ', 'DEUTZ', ' F10L 413F ', ' 7.134.406 ', 'LEROY SOMER', 'Trafo 1', '20/0.40 KV', '160 KVA', '1983'),
(90, 32, 4, 'Isolated', ' PLTD BABAI #02 (DEUTZ) ', ' 22.552.160.110.002 ', 'DEUTZ', 'F10L 413F', ' 84103 C 0052 ', 'STAMFORD', 'Trafo 2', '20/0.40 KV', '160 KVA', '1993'),
(91, 32, 4, 'Isolated', ' PLTD BABAI #03 (DEUTZ) ', ' 22.552.160.110.003 ', 'DEUTZ', 'F10L 413F', ' 84103 C 0062 ', 'STAMFORD', 'Trafo 3', '20/0.40 KV', '160 KVA', '1994'),
(92, 32, 4, 'Isolated', ' PLTD BABAI #04 (DEUTZ) ', ' 22.552.160.110.004 ', 'DEUTZ', 'F10L 413F', ' 84103 D 0179 ', 'STAMFORD', '-', '-', '-', '1993'),
(93, 32, 4, 'Isolated', ' PLTD BABAI #05 (DEUTZ) EX PLTD DAMPARAN #01 ', ' 22.552.160.118.001 ', 'DEUTZ', 'F10L 413F', ' 84103 C 0106 ', 'STAMFORD', '-', '-', '-', '1994'),
(94, 32, 4, 'Isolated', ' PLTD BABAI #06 (DEUTZ) EX PLTD DAMPARAN #05 ', ' 22.552.160.118.005 ', 'DEUTZ AG', ' BF 6M 1013 EC ', ' 11.953.966 ', 'STAMFORD', 'Trafo Deutz BF', '20/0.40 KV', '160 KVA', '2017'),
(95, 32, 4, 'Isolated', ' PLTD BABAI #07 (DEUTZ) EX PLTD SEBANGAU #05 ', ' 22.552.160.104.005 ', 'DEUTZ AG', ' BF 6M 1013 EC ', ' 12.027.954 ', 'STAMFORD', '-', '-', '-', '2017'),
(96, 33, 4, 'Isolated', ' PLTD BENANGIN #01 (DEUTZ) ', ' 22.552.160.123.001 ', 'DEUTZ', ' F6L 912 ', ' 816.360.122 ', 'STAMFORD', 'Trafo 1', '20/0.40 KV', '100 KVA', '1990'),
(97, 33, 4, 'Isolated', ' PLTD BENANGIN #02 (DEUTZ) ', ' 22.552.160.123.002 ', 'DEUTZ', ' F6L 912 ', ' 816.390.330 ', ' AVK ', 'Trafo 2', '20/0.40 KV', '100 KVA', '1987'),
(98, 33, 4, 'Isolated', ' PLTD BENANGIN #03 (DEUTZ) ', ' 22.552.160.123.003 ', 'DEUTZ', ' F6L 912 ', ' 8163 D 0529 ', 'STAMFORD', '-', '-', '-', '1995'),
(99, 33, 4, 'Isolated', ' PLTD BENANGIN #04 (MWM) ', ' 22.552.160.123.004 ', 'MWM', ' D 229 6 ', ' 22.906.182.051 ', 'STAMFORD', '-', '-', '-', '2001'),
(100, 33, 4, 'Isolated', ' PLTD BENANGIN #05 (DEUTZ) ', ' 22.552.160.123.005 ', 'DEUTZ', ' F10L 413F ', ' 84103 C 0053 ', 'STAMFORD', '-', '-', '-', '1993'),
(101, 33, 4, 'Isolated', ' PLTD BENANGIN #06 (DEUTZ) ', ' 22.552.160.123.006 ', 'DEUTZ', ' F10L 413F ', ' 84103 C 0103 ', 'STAMFORD', '-', '-', '-', '1988'),
(102, 33, 4, 'Isolated', ' PLTD BENANGIN #07 (DEUTZ) EX PLTD SABUH #04 ', ' 22.552.160.123.007 ', 'DEUTZ', ' F10L 413F ', ' 6.355.272 ', 'STAMFORD', '-', '-', '-', '1987'),
(103, 33, 4, 'Isolated', ' PLTD BENANGIN #08 (DEUTZ) EX PLTD LUWE HULU #07 ', ' 22.552.160.127.007 ', 'DEUTZ', ' BF 6M 1013 EC ', ' 11.953.964 ', 'STAMFORD', 'Trafindo', '20/0.40 KV', '160 KVA', '2017'),
(104, 33, 4, 'Isolated', ' PLTD BENANGIN #09 (DEUTZ) EX PLTD TUMBANG LAHUNG #04 ', ' 22.552.160.126.004 ', 'DEUTZ', ' BF 6M 1013 EC ', ' 11.872.596 ', 'STAMFORD', 'Trafo Lama', '20/0.40 KV', '-', '2017'),
(105, 34, 4, 'Interkoneksi', ' PLTD BUNDAR #01 (MWM) ', ' 22.552.160.119.001 ', 'MWM', ' D 229 6 ', ' 22.906.182.045 ', ' AVK ', 'Trafo Gabungan', '20/0.40 KV', '100 KVA', '1997'),
(106, 34, 4, 'Interkoneksi', ' PLTD BUNDAR #02 (DEUTZ) ', ' 22.552.160.119.002 ', 'DEUTZ', ' F6L 912 ', ' 8.614.790 ', 'STAMFORD', '-', '-', '-', '1987'),
(107, 34, 4, 'Interkoneksi', ' PLTD BUNDAR #03 (DEUTZ) ', ' 22.552.160.119.003 ', 'DEUTZ', ' F6L 912 ', ' 8.614.791 ', ' AVK ', '-', '-', '-', '1987'),
(108, 34, 4, 'Interkoneksi', ' PLTD BUNDAR #04 (DEUTZ) EX PLTD MUARA PLANTAU #02 ', ' 22.552.160.119.004 ', 'DEUTZ', ' F6L 912 ', ' 8.614.793 ', 'STAMFORD', '-', '-', '-', '1996'),
(109, 34, 4, 'Interkoneksi', ' PLTD MOBILER BUNDAR #05 (KORMAN) ', ' 22.552.030.103.001 ', 'KORMAN', ' 4KMD-75 ', ' 18KMD0240 ', ' MARELLIMOTORI ', '-', '-', '-', '2021'),
(110, 34, 4, 'Interkoneksi', ' PLTD BUNDAR #06 (DEUTZ) EX PLTD SEBANGAU #01 ', ' 22.552.160.104.001 ', 'DEUTZ', ' F6L 912 ', ' 8163 A 0385 ', 'STAMFORD', '-', '-', '-', '1993'),
(111, 34, 4, 'Interkoneksi', ' PLTD BUNDAR #07 (DEUTZ) EX PLTD TUMBANG LAHUNG #06 ', ' 22.552.160.126.006 ', 'DEUTZ', ' F6L 912 ', ' 8163 F 0681 ', 'STAMFORD', 'Trafo Lama', '20/0.38 KV', '-', '1996'),
(112, 15, 6, 'Interkoneksi', 'PLTD BAKAU #04 (DEUTZ)', '22552180110004', 'DEUTZ', 'BF4M 1012 E', '00134391', 'LEROY SOMER', '-', '20/0.38 KV', '-', '1993'),
(113, 18, 6, 'Isolated', 'PLTD KERASIAN #04 (DEUTZ) EX PLTD TANJUNG BATU #09', '22552180103010.', 'DEUTZ', 'BF 6M 1013 EC', '11956636', 'STAMFORD', 'Trafindo', '20/0.38 KV', '160 KVA', '2017'),
(114, 22, 6, 'Interkoneksi', 'PLTD MULYA HARJA #03 (DEUTZ)', '22552180116003', 'DEUTZ', 'BF4M 1012 E', '00096155', 'LEROY SOMER', '-', '20/0.38 KV', '-', '1999'),
(115, 24, 6, 'Interkoneksi', 'PLTD SENGAYAM #01 (MWM)', '22552180140001', 'MWM', 'TBD 616 V12', '001621', 'STAMFORD', '-', '-', '630 KVA', '1998'),
(116, 29, 6, 'Isolated', 'PLTD TANJUNG SAMALANTAKAN #01 (CUMMINS)', '22552180112001', 'CUMMINS', '6 CTA 83.G', '44759044', 'STAMFORD', '-', '20/0.38 KV', '-', '1990'),
(117, 29, 6, 'Isolated', 'PLTD TANJUNG SAMALANTAKAN #02 (DEUTZ)', '22552180112002', 'DEUTZ', 'F 6 L 912 L', '816390369', 'STAMFORD', '-', '20/0.38 KV', '-', '1994'),
(118, 29, 6, 'Isolated', 'PLTD TANJUNG SAMALANTAKAN #03 (DEUTZ)', '22552180112003', 'DEUTZ', 'F 6 L 912 L', '8652572', 'STAMFORD', '-', '20/0.38 KV', '-', '2002'),
(119, 29, 6, 'Isolated', 'PLTD TANJUNG SAMALANTAKAN #04 (DEUTZ)', '22552180112004', 'DEUTZ', 'BF 6M 1013 EC', '11953393', 'STAMFORD', '-', '20/0.38 KV', '-', '2017'),
(120, 29, 6, 'Isolated', 'PLTD TANJUNG SAMALANTAKAN #05 (DEUTZ)', '22552180112005', 'DEUTZ', 'BF 6M 1013 EC', '11956633', 'STAMFORD', '-', '20/0.38 KV', '-', '2017'),
(121, 29, 6, 'Isolated', 'PLTD TANJUNG SAMALANTAKAN #06 (DEUTZ) EX PLTD BAKAU #03', '22552180112006', 'DEUTZ', 'F 6 L 912 F', '8163 D 0603', 'STAMFORD', '-', '20/0.38 KV', '-', '1990'),
(122, 29, 6, 'Isolated', 'PLTD TANJUNG SAMALANTAKAN #07 (CUMMINS) EX PLTD MULYAHARJA #06', '22552180112007', 'CUMMINS', '6 CTA 83.G', '44783810', 'ENGGA', '-', '20/0.38 KV', '-', '1993'),
(123, 29, 6, 'Isolated', 'PLTD TANJUNG SAMALANTAKAN #08 (DEUTZ) EX PLTD SUNGAI DURIAN #09', '22552180109009', 'DEUTZ', 'BF 6M 1013 EC', '11914867', 'STAMFORD', '-', '-', '-', '2018'),
(124, 35, 4, 'Interkoneksi', 'PLTD DAMPARAN #02 (DEUTZ)', '22552160118002', 'DEUTZ', 'F6L 912', '8163 C 0542', 'STAMFORD', '-', '-', '-', '1994'),
(125, 35, 4, 'Interkoneksi', 'PLTD DAMPARAN #03 (DEUTZ)', '22552160118003', 'DEUTZ', 'F10L 413F', '6355306', 'SIEMENS', '-', '-', '-', '1982'),
(126, 36, 4, 'Isolated', 'PLTD GUNUNG PUREI #01 (DEUTZ) EX PLTD PENDANG #01', '22552160112001', 'DEUTZ AG', 'BF 6M 1013 EC', '11953379', 'STAMFORD', 'TRAFO DEUTZ 1', '20/0.40 KV', '160 KVA', '2017'),
(127, 36, 4, 'Isolated', 'PLTD GUNUNG PUREI #02 (DEUTZ) EX PLTD PENDANG #02', '22552160112002', 'DEUTZ AG', 'BF 6M 1013 EC', '11953381', 'STAMFORD', 'TRAFO DEUTZ 2', '20/0.40 KV', '160 KVA', '2017'),
(128, 36, 4, 'Isolated', 'PLTD GUNUNG PUREI #03 (DEUTZ) EX PLTD PENDANG #03', '22552160112003', 'DEUTZ AG', 'BF 6M 1013 EC', '11953382', 'STAMFORD', 'TRAFO DEUTZ 3', '20/0.40 KV', '160 KVA', '2017'),
(129, 36, 4, 'Isolated', 'PLTD GUNUNG PUREI #04 (DEUTZ) EX PLTD PUJON #04', '22552160107004', 'DEUTZ', 'F10L 413F', '84103 C 0105', 'STAMFORD', '-', '-', '-', '1991'),
(130, 38, 4, 'Interkoneksi', 'PLTD KUALA KAPUAS KSKT #01 (VOLVO) EX PLTD TANJUNG BATU #04', '22552160156001', 'VOLVO', 'TAG 1242 GE', '2012467366', 'LEROY SOMER', '-', '20/0.39', '-', '2003'),
(131, 37, 4, 'Interkoneksi', 'PLTD LUWE HULU #01 (DEUTZ)', '22552160127001', 'DEUTZ', 'F5L 413 FR', '8048170', 'LEROY SOMER', 'TRAFO COUPLE', '20/0.40 KV', '375 KVA', '1994'),
(132, 37, 4, 'Interkoneksi', 'PLTD LUWE HULU #08 (DEUTZ) EX PLTD UP3 KUALA KAPUAS #03', '22552160127003', 'DEUTZ', 'F6L 912', '816360104', ' AVK ', '-', '-', '-', '1981'),
(133, 39, 4, 'Isolated', 'PLTD MANGKATIP #01 (DEUTZ)', '22552160111001', 'DEUTZ', 'F10L 413F ', '7113075', 'LEROY SOMER', 'Trafo 01', '20/0.40 KV', '160 KVA', '1984'),
(134, 39, 4, 'Isolated', 'PLTD MANGKATIP #03 (DEUTZ)', '22552160111003', 'DEUTZ', 'F6L 912', '8163 D 0535', 'STAMFORD', 'Trafo 02', '20/0.40 KV', '160 KVA', '1997'),
(135, 39, 4, 'Isolated', 'PLTD MANGKATIP #04 (DEUTZ - PEMDA)', '22552160111004', 'DEUTZ', 'BF 6M 1013 EC', '60117843', 'STAMFORD', '-', '-', '-', '1995'),
(136, 39, 4, 'Isolated', 'PLTD MANGKATIP #05 (DEUTZ - PEMDA)', '22552160111005', 'DEUTZ', 'BF 6M 1013 EC', '60117844', 'STAMFORD', '-', '-', '-', '1995'),
(137, 39, 4, 'Isolated', 'PLTD MANGKATIP #06 (DEUTZ) EX PLTD MUARA PLANTAU #03', '22552160111006', 'DEUTZ', 'BF 6M 1013 EC', '11951721', 'STAMFORD', '-', '-', '-', '2017'),
(138, 39, 4, 'Isolated', 'PLTD MANGKATIP #07 (DEUTZ) EX PLTD MUARA LAUNG #09', '22552160125012', 'DEUTZ', 'F10L 413F', '6711901', 'STAMFORD', '-', '20/0.39 KVA', '-', '1988'),
(139, 39, 4, 'Isolated', 'PLTD MANGKATIP #08 (DEUTZ) EX PLTD RANGGA ILUNG #01', '22552160115001', 'DEUTZ', 'F10L 413F', '84103 C 0064', 'LEROY SOMER', '-', '-', '-', '1996'),
(140, 40, 4, 'Interkoneksi', 'PLTD MERAWAN LAMA #01 (DEUTZ)', '22552160120001', 'DEUTZ', 'F5L 413 FR', '8048169', 'LEROY SOMER', '-', '-', '-', '1994'),
(141, 40, 4, 'Interkoneksi', 'PLTD MERAWAN LAMA #03 (DEUTZ)', '22552160120003', 'DEUTZ AG', 'BF 6M 1013 EC', '11954001', 'STAMFORD', 'TRAFO MESIN BF 1', '20/0.40 KV', '160 KVA', '2017'),
(142, 40, 4, 'Interkoneksi', 'PLTD MERAWAN LAMA #04 (DEUTZ)', '22552160120004', 'DEUTZ AG', 'BF 6M 1013 EC', '11953982', 'STAMFORD', 'TRAFO MESIN BF 2', '20/0.40 KV', '160 KVA', '2017'),
(143, 41, 4, 'Interkoneksi', 'PLTD MONTALAT #01 (DEUTZ)', '22552160128001', 'DEUTZ', 'F6L 912', '8614792', 'STAMFORD', 'TRAFO 1', '20/0.40', '50 KVA', '1997'),
(144, 41, 4, 'Interkoneksi', 'PLTD MONTALAT #02 (DEUTZ)', '22552160128002', 'DEUTZ', 'BF4M 1012 E', '00110270', 'STAMFORD', 'TRAFO 2', '20/0.40 KV', '100 KVA', '1997'),
(145, 41, 4, 'Interkoneksi', 'PLTD MONTALAT #03 (MWM)', '22552160128003', 'MWM', 'D 226 B4', '4B000045', 'STAMFORD', '-', '-', '-', '2004'),
(146, 41, 4, 'Interkoneksi', 'PLTD MONTALAT #04 (DEUTZ)', '22552160128004', 'DEUTZ', 'F6L 912', '5655557', ' AVK ', '-', '-', '-', '1987'),
(147, 42, 4, 'Interkoneksi', 'PLTD MUARA LAUNG #02 (MWM)', '22552160125002', 'MWM', 'TBD 232 V12', '81435', ' AVK ', '-', '-', '-', '1988'),
(148, 69, 3, 'Isolated', 'PLTD TELAGA KSKT #01 (DEUTZ)', '22552140118001', 'DEUTZ', 'BF4M 1012 E', '00128927', 'LEROY SOMER', '-', '-', '-', '2000'),
(149, 69, 3, 'Isolated', 'PLTD TELAGA KSKT #02 (DEUTZ)', '22552140118002', 'DEUTZ', 'F6L 912', '8163 B 0460', 'STAMFORD', '-', '-', '-', '2001'),
(150, 69, 3, 'Isolated', 'PLTD TELAGA KSKT #03 (DEUTZ)', '22552140118003', 'DEUTZ', 'F6L 912', '816360124', 'STAMFORD', '-', '-', '-', '1990'),
(151, 69, 3, 'Isolated', 'PLTD TELAGA KSKT #04 (DEUTZ)', '22552140118004', 'DEUTZ', 'BF 6M 1013 EC', '11953960', 'STAMFORD', '-', '-', '-', '2017'),
(152, 69, 3, 'Isolated', 'PLTD MOBILER TELAGA KSKT #05 (KORMAN)', '22552020115001', 'KORMAN', '4KMD-75', '18KMD0228', 'MARELLIMOTORI', '-', '-', '-', '2019'),
(153, 69, 3, 'Isolated', 'PLTD TELAGA KSKT #06 (DEUTZ) EX PLTD TELAGA PULANG #04', '22552140123005', 'DEUTZ', 'F6L 912', '816390375', 'STAMFORD', '-', '-', '-', '1996'),
(154, 70, 3, 'Interkoneksi', 'PLTD TEWAH #01 (MTU)', '22552140106001', 'MTU', '12V2000G62', '535101576', ' AVK ', 'STARLITE', '20/0.40 KV', '630 KVA', '2001'),
(155, 72, 3, 'Interkoneksi', 'PLTD TUMBANG JUTUH #02 (MAN)', '22552140109002', 'MAN', 'D 0826 LE', '1608165531 C3', ' AVK ', 'STARLITE', '20/0.40 KV', '400 KVA', '1997'),
(156, 72, 3, 'Interkoneksi', 'PLTD TUMBANG JUTUH #03 (VOLVO PENTA)', '22552140109003', 'VOLVO PENTA', 'TAD 1242GE D 12', '466197.D1.A', 'LEROY SOMER', 'STARLITE', '20/0.40 KV', '400 KVA', '2005'),
(157, 73, 3, 'Interkoneksi', 'PLTD TUMBANG KAMAN #01 (DEUTZ)', '22552140112001', 'DEUTZ', 'F10L 413F', '7261389', 'STAMFORD', '-', '-', '-', '1995'),
(158, 73, 3, 'Interkoneksi', 'PLTD TUMBANG KAMAN #02 (DEUTZ)', '22552140112002', 'DEUTZ', 'F5L 413 FR', '8048084', 'LEROY SOMER', '-', '-', '-', '1994'),
(159, 73, 3, 'Interkoneksi', 'PLTD TUMBANG KAMAN #03 (DEUTZ)', '22552140112003', 'DEUTZ', 'F5L 413 FR', '8048073', 'LEROY SOMER', '-', '-', '-', '1994'),
(160, 73, 3, 'Interkoneksi', 'PLTD TUMBANG KAMAN #05 (DEUTZ)', '22552140112005', 'DEUTZ', 'F10L 413F', '84103 C 0115', 'STAMFORD', '-', '-', '-', '1992'),
(161, 73, 3, 'Interkoneksi', 'PLTD TUMBANG KAMAN #07 (DEUTZ)', '22552140112007', 'DEUTZ', 'BF 6M 1013E', '00064073', 'LEROY SOMER', '-', '-', '-', '1998'),
(162, 73, 3, 'Interkoneksi', 'PLTD TUMBANG KAMAN #08 (DEUTZ)', '22552140112008', 'DEUTZ', 'F6L 912', '816360129', 'STAMFORD', '-', '-', '-', '1987'),
(163, 54, 5, 'Interkoneksi', 'PLTD BALAI RIAM #02 (DEUTZ)', '22552140133002', 'DEUTZ', 'BF4M 1012 E', '00125439', 'LEROY SOMER', '-', '-', '-', '2004'),
(164, 54, 5, 'Interkoneksi', 'PLTD BALAI RIAM #03 (MAN - PEMDA)', '22552140133003', 'MAN', 'D 0836 LE 201', '18020175312008', 'LEROY SOMER', '-', '-', '-', '2010'),
(165, 54, 5, 'Interkoneksi', 'PLTD BALAI RIAM #04 (MWM)', '22552140133004', 'MWM', 'TBD 232 V12', '741628', ' AVK ', '-', '-', '-', '1982'),
(166, 55, 5, 'Isolated', 'PLTD KENAMBUI #01 (DEUTZ)', '22552140137001', 'DEUTZ', 'F5L 413FR', '8048129', 'LEROY SOMER', 'STARLITE', '20/0.40 KV', '160 KVA', '1996'),
(167, 55, 5, 'Isolated', 'PLTD KENAMBUI #02 (DEUTZ)', '22552140137002', 'DEUTZ', 'BF4M 1012 E', '00096151', 'LEROY SOMER', '-', '-', '-', '1996'),
(168, 55, 5, 'Isolated', 'PLTD KENAMBUI #03 (DEUTZ)', '22552140137003', 'DEUTZ', 'F5L 413 FR', '8048115', 'LEROY SOMER', '-', '-', '-', '1994');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_handphone` varchar(20) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `foto` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nip`, `nama`, `jenis_kelamin`, `alamat`, `no_handphone`, `jabatan`, `foto`) VALUES
(1, 'PEMBANGKIT-001', 'Fadhel Muhammad Rajib', 'Laki-laki', 'Jambu Raya', '081346556749', 'Admin', 'fadhel.jpeg'),
(2, 'PEMBANGKIT-002', 'Rajib Ganteng', 'Laki-laki', 'Panglima Batur', '081346556749', 'Pegawai', 'IMG_20201108_113025.jpg'),
(3, 'PEMBANGKIT-003', 'Rafi', 'Laki-laki', 'Belitung', '081352391840', 'It Support', 'IMG-20231016-WA0046.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `relokasi_mesin`
--

CREATE TABLE `relokasi_mesin` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `kota` varchar(225) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `file` varchar(255) NOT NULL,
  `status_pengajuan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `relokasi_mesin`
--

INSERT INTO `relokasi_mesin` (`id`, `id_pegawai`, `kota`, `tanggal`, `keterangan`, `file`, `status_pengajuan`) VALUES
(3, 2, 'Palangka Raya', '2024-10-29', 'ULD Tumbang Miri ke ULD Telaga', 'BA RELOKASI MIRI KE TELAGA.pdf', 'PENDING'),
(4, 2, 'Kota Baru', '2024-10-29', 'ULD Tanjung Batu Ke ULD Kerasian', 'BA RELOKASI MESIN DARI ULD TJ. BATU KE ULD KERASIAN.pdf', 'PENDING'),
(5, 2, 'Palangka Raya', '2024-09-26', 'ULD Timpah Ke ULD Rangga Ilung', 'BA Relokasi mesin TCD Timpah ke Rangga Ilung.pdf', 'APPROVED');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_mesin`
--

CREATE TABLE `riwayat_mesin` (
  `id` int(11) NOT NULL,
  `sistem` varchar(50) NOT NULL,
  `nama_mesin` varchar(255) NOT NULL,
  `kode_mesin` varchar(255) NOT NULL,
  `merek_mesin` varchar(50) NOT NULL,
  `tipe_mesin` varchar(255) NOT NULL,
  `seri_mesin` varchar(255) NOT NULL,
  `merek_generator` varchar(225) NOT NULL,
  `nama_trafo` varchar(225) NOT NULL,
  `tegangan` varchar(50) NOT NULL,
  `kapasitas` varchar(50) NOT NULL,
  `tahun_operasi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_mesin`
--

INSERT INTO `riwayat_mesin` (`id`, `sistem`, `nama_mesin`, `kode_mesin`, `merek_mesin`, `tipe_mesin`, `seri_mesin`, `merek_generator`, `nama_trafo`, `tegangan`, `kapasitas`, `tahun_operasi`) VALUES
(1, 'Interkoneksi', ' PLTD SENGAYAM #01 (MWM) ', ' 22552180140001 ', 'MWM', ' TBD 616 V12 ', ' 001621 ', 'STAMFORD', '-', '-', '630 KVA', '1998'),
(2, 'Interkoneksi', ' PLTD MULYA HARJA #03 (DEUTZ) ', ' 22552180116003 ', 'DEUTZ', 'BF4M 1012 E', ' 00096155 ', 'LEROY SOMER', '-', '20/0.38 KV', '-', '1999');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_uld`
--

CREATE TABLE `riwayat_uld` (
  `id_uld` int(11) NOT NULL,
  `sistem` varchar(50) NOT NULL,
  `nama_uld` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uld`
--

CREATE TABLE `uld` (
  `id_uld` int(11) NOT NULL,
  `id_up3` int(11) NOT NULL,
  `sistem` varchar(50) NOT NULL,
  `nama_uld` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uld`
--

INSERT INTO `uld` (`id_uld`, `id_up3`, `sistem`, `nama_uld`) VALUES
(12, 7, 'Interkoneksi', 'PLTD UP3 BANJARMASIN'),
(13, 7, 'Interkoneksi', 'PLTD BENUA RIAM'),
(14, 7, 'Interkoneksi', 'PLTD TIWINGAN LAMA'),
(15, 6, 'Interkoneksi', 'PLTD BAKAU'),
(16, 6, 'Interkoneksi', 'PLTD GERONGGANG'),
(17, 6, 'Isolated', 'PLTD GUNUNG BATU BESAR'),
(18, 6, 'Isolated', 'PLTD KERASIAN'),
(19, 6, 'Isolated', 'PLTD KERAYAAN'),
(20, 6, 'Isolated', 'PLTD KERUMPUTAN'),
(21, 6, 'Isolated', 'PLTD MARABATUAN'),
(22, 6, 'Interkoneksi', 'PLTD MULYA HARJA'),
(23, 6, 'Interkoneksi', 'PLTD SAMPANAHAN'),
(24, 6, 'Interkoneksi', 'PLTD SENGAYAM'),
(26, 6, 'Isolated', 'PLTD SUNGAI BALI'),
(27, 6, 'Isolated', 'PLTD SUNGAI DURIAN'),
(28, 6, 'Isolated', 'PLTD TANJUNG BATU'),
(29, 6, 'Isolated', 'PLTD TANJUNG SAMALANTAKAN'),
(30, 6, 'Interkoneksi', 'PLTD TANJUNG SELOKA'),
(31, 6, 'Isolated', 'PLTD UP3 KOTA BARU'),
(32, 4, 'Isolated', 'PLTD BABAI'),
(33, 4, 'Isolated', 'PLTD BENANGIN'),
(34, 4, 'Interkoneksi', 'PLTD BUNDAR'),
(35, 4, 'Interkoneksi', 'PLTD DAMPARAN'),
(36, 4, 'Isolated', 'PLTD GUNUNG PUREI'),
(37, 4, 'Interkoneksi', 'PLTD LUWE HULU'),
(38, 4, 'Interkoneksi', 'PLTD KUALA KAPUAS KSKT'),
(39, 4, 'Isolated', 'PLTD MANGKATIP'),
(40, 4, 'Interkoneksi', 'PLTD MERAWAN LAMA'),
(41, 4, 'Interkoneksi', 'PLTD MONTALAT'),
(42, 4, 'Interkoneksi', 'PLTD MUARA LAUNG'),
(43, 4, 'Interkoneksi', 'PLTD PUJON'),
(44, 4, 'Isolated', 'PLTD RANGGA ILUNG'),
(45, 4, 'Interkoneksi', 'PLTD SABUH'),
(46, 4, 'Interkoneksi', 'PLTD SEBANGAU'),
(47, 4, 'Interkoneksi', 'PLTD SEI HANYU'),
(48, 4, 'Interkoneksi', 'PLTD TANJUNG JAWA'),
(49, 4, 'Isolated', 'PLTD TELUK BETUNG KSKT'),
(50, 4, 'Interkoneksi', 'PLTD TUMBANG LAHUNG'),
(51, 4, 'Isolated', 'PLTD TUMPUNG LAUNG'),
(52, 4, 'Interkoneksi', 'UP3 KUALA KAPUAS'),
(54, 5, 'Interkoneksi', 'PLTD BALAI RIAM'),
(55, 5, 'Isolated', 'PLTD KENAMBUI'),
(56, 5, 'Interkoneksi', 'PLTD KOTA WARINGIN'),
(57, 5, 'Interkoneksi', 'PLTD KUALA JELAI'),
(58, 5, 'Isolated', 'PLTD KUDANGAN'),
(59, 5, 'Isolated', 'PLTD MENDAWAI'),
(60, 5, 'Interkoneksi', 'PLTD MENTHOBY RAYA'),
(61, 5, 'Isolated', 'PLTD PAGATAN'),
(62, 5, 'Interkoneksi', 'PLTD PANGKUT'),
(63, 5, 'Interkoneksi', 'PLTD RANTAU PULUT'),
(64, 5, 'Interkoneksi', 'PLTD SUKAMANDANG'),
(65, 5, 'Interkoneksi', 'PLTD SUNGAI CABANG BARAT'),
(66, 5, 'Isolated', 'PLTD TAPIN BINI'),
(67, 5, 'Isolated', 'PLTD TELAGA PULANG'),
(68, 5, 'Isolated', 'PLTD TUMBANG MANJUL'),
(69, 3, 'Isolated', 'PLTD TELAGA KSKT'),
(70, 3, 'Interkoneksi', 'PLTD TEWAH'),
(71, 3, 'Isolated', 'PLTD TUMBANG HIRAN'),
(72, 3, 'Interkoneksi', 'PLTD TUMBANG JUTUH'),
(73, 3, 'Interkoneksi', 'PLTD TUMBANG KAMAN'),
(74, 3, 'Isolated', 'PLTD TUMBANG MANJUL'),
(75, 3, 'Interkoneksi', 'PLTD TUMBANG MIRI'),
(76, 3, 'Interkoneksi', 'PLTD TUMBANG MIWAN'),
(77, 3, 'Isolated', 'PLTD TUMBANG SENAMANG'),
(78, 3, 'Interkoneksi', 'PLTD TUMBANG TALAKEN'),
(79, 3, 'Interkoneksi', 'PLTD TUMBANG TAMBIRAH'),
(80, 3, 'Isolated', 'PLTD UP3 PALANGKARAYA'),
(83, 9, 'Interkoneksi', 'PLTBG IPP SUKADAMAI (PT. NAGATA BIO ENERGI)'),
(84, 8, '', 'PLTU EXCESS TAMIANG LAYANG (PT RIMAU ELECTRIC)'),
(85, 8, '', 'PLTBG EXCESS TAMIANG LAYANG (PT SAWIT GRAHA MANUNGGAL)'),
(86, 8, '', 'PLTBM EXCESS PANGKALAN BUN (PT KORINTIGA HUTANI)'),
(87, 8, '', 'PLTBG EXCESS SAMPIT (PT MAJU ANEKA SAWIT)'),
(88, 8, '', 'PLTBG EXCESS SAMPIT (PT SUKAJADI SAWIT MEKAR)'),
(89, 8, '', 'PLTG EXCESS SAMPIT (PT UNGGUL LESTARI)'),
(90, 8, '', 'PLTBG EXCESS SAMPIT (PT. TAPIAN NADENGGAN)'),
(94, 4, 'Isolated', 'PLTD SW PUJON'),
(95, 4, 'Isolated', 'PLTD SW TIMPAH (PLN NUSA DAYA)'),
(96, 4, 'Isolated', 'PLTD TIMPAH');

-- --------------------------------------------------------

--
-- Table structure for table `up3`
--

CREATE TABLE `up3` (
  `id_up3` int(11) NOT NULL,
  `nama_up3` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `up3`
--

INSERT INTO `up3` (`id_up3`, `nama_up3`) VALUES
(3, 'Palangka Raya'),
(4, 'Kuala Kapuas'),
(5, 'Pangkalanbuun'),
(6, 'Kota Baru'),
(7, 'Banjarmasin'),
(8, 'Excess'),
(9, 'IPP');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `status` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_pegawai`, `username`, `password`, `status`, `role`) VALUES
(1, 1, 'fadhel', '$2y$10$Cm.NcH.S4640L.AcoMsjJeTa84MPnA4b1XFgz8/yuLvQLbnOSgSBa', 'Aktif', 'admin'),
(2, 2, 'rajib', '$2y$10$Cm.NcH.S4640L.AcoMsjJeTa84MPnA4b1XFgz8/yuLvQLbnOSgSBa', 'Aktif', 'pegawai'),
(3, 3, 'rafi', '$2y$10$xEBYYnAhCs5VPSRdg2Lmj.YJ4kKjqWqHFD/vCpyU85nW/l4EUqPKy', 'Tidak Aktif', 'pegawai');

-- --------------------------------------------------------

--
-- Table structure for table `usulan_sebelum`
--

CREATE TABLE `usulan_sebelum` (
  `id` int(11) NOT NULL,
  `id_usulan` int(11) NOT NULL,
  `kode_ranting` varchar(255) NOT NULL,
  `ranting` varchar(255) NOT NULL,
  `kode_sentral` varchar(225) NOT NULL,
  `sentral` varchar(225) NOT NULL,
  `mesin` varchar(255) NOT NULL,
  `kode_mesin` varchar(255) NOT NULL,
  `sistem` varchar(225) NOT NULL,
  `provinsi` varchar(225) NOT NULL,
  `merek` varchar(50) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `seri` varchar(255) NOT NULL,
  `merek_generator` varchar(255) NOT NULL,
  `nama_trafo` varchar(255) NOT NULL,
  `tegangan` varchar(50) NOT NULL,
  `kapasitas` varchar(50) NOT NULL,
  `tahun` varchar(20) NOT NULL,
  `kode_bhnbakar` varchar(50) NOT NULL,
  `kode_pembangkit` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `kode_status` varchar(50) NOT NULL,
  `kode_jenis_bhnbakar` varchar(50) NOT NULL,
  `jenis_teg` varchar(55) NOT NULL,
  `daya_terpasang` varchar(55) NOT NULL,
  `daya_mampu` varchar(55) NOT NULL,
  `kondisi` varchar(55) NOT NULL,
  `kode_kondisi` varchar(55) NOT NULL,
  `mutasi` varchar(55) NOT NULL,
  `kode_mutasi` varchar(55) NOT NULL,
  `keterangan` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usulan_sebelum`
--

INSERT INTO `usulan_sebelum` (`id`, `id_usulan`, `kode_ranting`, `ranting`, `kode_sentral`, `sentral`, `mesin`, `kode_mesin`, `sistem`, `provinsi`, `merek`, `tipe`, `seri`, `merek_generator`, `nama_trafo`, `tegangan`, `kapasitas`, `tahun`, `kode_bhnbakar`, `kode_pembangkit`, `status`, `kode_status`, `kode_jenis_bhnbakar`, `jenis_teg`, `daya_terpasang`, `daya_mampu`, `kondisi`, `kode_kondisi`, `mutasi`, `kode_mutasi`, `keterangan`) VALUES
(1, 1, '225520402', 'Kota Baru', '22552040202', 'PLTD TANJUNG BATU', 'PLTD TANJUNG BATU #09 (DEUTZ) EX PLTD BAKAU #06', '22552180103010', 'SISTEM ISOLATED TANJUNG BATU', 'KALIMANTAN SELATAN', 'DEUTZ', 'BF 6M 1013 EC', '11956636', 'STAMFORD', 'TRAFINDO', '20/0.38', '160', '2017', 'PLTD-BIO', 'PLTD', 'Produksi Sendiri', 'P', 'BIO', 'TM', ' 128 ', ' 100 ', 'BEROPERASI', 'OP', 'EXISTING', '01', '');

-- --------------------------------------------------------

--
-- Table structure for table `usulan_sesudah`
--

CREATE TABLE `usulan_sesudah` (
  `id` int(11) NOT NULL,
  `id_usulan` int(11) NOT NULL,
  `kode_ranting` varchar(255) NOT NULL,
  `ranting` varchar(255) NOT NULL,
  `kode_sentral` varchar(225) NOT NULL,
  `sentral` varchar(225) NOT NULL,
  `mesin` varchar(255) NOT NULL,
  `kode_mesin` varchar(255) NOT NULL,
  `sistem` varchar(225) NOT NULL,
  `provinsi` varchar(225) NOT NULL,
  `merek` varchar(50) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `seri` varchar(255) NOT NULL,
  `merek_generator` varchar(255) NOT NULL,
  `nama_trafo` varchar(255) NOT NULL,
  `tegangan` varchar(50) NOT NULL,
  `kapasitas` varchar(50) NOT NULL,
  `tahun` varchar(20) NOT NULL,
  `kode_bhnbakar` varchar(50) NOT NULL,
  `kode_pembangkit` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `kode_status` varchar(50) NOT NULL,
  `kode_jenis_bhnbakar` varchar(50) NOT NULL,
  `jenis_teg` varchar(55) NOT NULL,
  `daya_terpasang` varchar(55) NOT NULL,
  `daya_mampu` varchar(55) NOT NULL,
  `kondisi` varchar(55) NOT NULL,
  `kode_kondisi` varchar(55) NOT NULL,
  `mutasi` varchar(55) NOT NULL,
  `kode_mutasi` varchar(55) NOT NULL,
  `keterangan` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usulan_sesudah`
--

INSERT INTO `usulan_sesudah` (`id`, `id_usulan`, `kode_ranting`, `ranting`, `kode_sentral`, `sentral`, `mesin`, `kode_mesin`, `sistem`, `provinsi`, `merek`, `tipe`, `seri`, `merek_generator`, `nama_trafo`, `tegangan`, `kapasitas`, `tahun`, `kode_bhnbakar`, `kode_pembangkit`, `status`, `kode_status`, `kode_jenis_bhnbakar`, `jenis_teg`, `daya_terpasang`, `daya_mampu`, `kondisi`, `kode_kondisi`, `mutasi`, `kode_mutasi`, `keterangan`) VALUES
(2, 0, '225520402', 'Kota Baru', '22552040215', 'PLTD KERASIAN', 'PLTD KERASIAN #4 (DEUTZ) EX PLTD TANJUNG BATU #9', '22552180103010', 'SISTEM ISOLATED TANJUNG BATU', 'KALIMANTAN SELATAN', 'DEUTZ', 'BF 6M 1013 EC', '11956636', 'STAMFORD', 'TRAFINDO', '20/0.38', '160', '2017', 'PLTD-BIO', 'PLTD', 'Produksi Sendiri', 'P', 'BIO', 'TM', ' 128 ', ' 100 ', 'STANDBY', 'OP', 'TAMABAHAN', '01', 'Relokasi Mesin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mesin`
--
ALTER TABLE `mesin`
  ADD PRIMARY KEY (`id_mesin`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relokasi_mesin`
--
ALTER TABLE `relokasi_mesin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `riwayat_mesin`
--
ALTER TABLE `riwayat_mesin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_uld`
--
ALTER TABLE `riwayat_uld`
  ADD PRIMARY KEY (`id_uld`);

--
-- Indexes for table `uld`
--
ALTER TABLE `uld`
  ADD PRIMARY KEY (`id_uld`);

--
-- Indexes for table `up3`
--
ALTER TABLE `up3`
  ADD PRIMARY KEY (`id_up3`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_pegawai`);

--
-- Indexes for table `usulan_sebelum`
--
ALTER TABLE `usulan_sebelum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usulan_sesudah`
--
ALTER TABLE `usulan_sesudah`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mesin`
--
ALTER TABLE `mesin`
  MODIFY `id_mesin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `relokasi_mesin`
--
ALTER TABLE `relokasi_mesin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `riwayat_mesin`
--
ALTER TABLE `riwayat_mesin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `riwayat_uld`
--
ALTER TABLE `riwayat_uld`
  MODIFY `id_uld` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uld`
--
ALTER TABLE `uld`
  MODIFY `id_uld` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `up3`
--
ALTER TABLE `up3`
  MODIFY `id_up3` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usulan_sebelum`
--
ALTER TABLE `usulan_sebelum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usulan_sesudah`
--
ALTER TABLE `usulan_sesudah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `relokasi_mesin`
--
ALTER TABLE `relokasi_mesin`
  ADD CONSTRAINT `relokasi_mesin_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
