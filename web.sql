-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 08, 2019 at 10:58 AM
-- Server version: 5.7.28-0ubuntu0.18.04.4
-- PHP Version: 7.3.12-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `idsinhvien` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `password`, `isAdmin`, `idsinhvien`) VALUES
('17021357', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 0, '17021357'),
('vinhtq115', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cathi`
--

CREATE TABLE `cathi` (
  `macathi` int(11) NOT NULL,
  `mahocphan` varchar(20) NOT NULL,
  `makythi` int(11) NOT NULL,
  `ngaythi` date NOT NULL,
  `giobatdau` time NOT NULL,
  `gioketthuc` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cathi`
--

INSERT INTO `cathi` (`macathi`, `mahocphan`, `makythi`, `ngaythi`, `giobatdau`, `gioketthuc`) VALUES
(2, 'ELT2035 20', 1, '2017-12-15', '10:05:08', '12:05:08'),
(3, 'MAT1041 1', 1, '2017-12-16', '15:00:00', '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `hocphan`
--

CREATE TABLE `hocphan` (
  `id` int(11) NOT NULL,
  `mahocphan` varchar(20) NOT NULL,
  `mamonthi` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hocphan`
--

INSERT INTO `hocphan` (`id`, `mahocphan`, `mamonthi`) VALUES
(1, 'PHY1100 1', 'PHY1100'),
(2, 'PHY1100 2', 'PHY1100'),
(3, 'MAT1093 10', 'MAT1093'),
(4, 'MAT1041 10', 'MAT1041'),
(6, 'MAT1093 11', 'MAT1093'),
(21, 'ELT2035 20', 'ELT2035'),
(23, 'MAT1093 1', 'MAT1093'),
(24, 'MAT1041 1', 'MAT1041'),
(26, 'MAT1041 8', 'MAT1041');

-- --------------------------------------------------------

--
-- Table structure for table `kythi`
--

CREATE TABLE `kythi` (
  `id` int(11) NOT NULL,
  `ky` int(11) NOT NULL,
  `nambatdau` int(4) NOT NULL,
  `namketthuc` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kythi`
--

INSERT INTO `kythi` (`id`, `ky`, `nambatdau`, `namketthuc`) VALUES
(1, 1, 2017, 2018),
(2, 2, 2017, 2018),
(3, 1, 2018, 2019),
(4, 2, 2018, 2019),
(5, 1, 2019, 2020),
(6, 2, 2019, 2020),
(7, 1, 2020, 2021),
(8, 2, 2020, 2021),
(9, 1, 2021, 2022),
(10, 2, 2021, 2022),
(11, 1, 2022, 2023);

-- --------------------------------------------------------

--
-- Table structure for table `monthi`
--

CREATE TABLE `monthi` (
  `mamonthi` varchar(20) CHARACTER SET utf8 NOT NULL,
  `tenmonthi` varchar(100) CHARACTER SET utf8 NOT NULL,
  `tinchi` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `monthi`
--

INSERT INTO `monthi` (`mamonthi`, `tenmonthi`, `tinchi`) VALUES
('ELT2035', 'Tín hiệu và hệ thống', 3),
('FLF2101', 'Tiếng Anh cơ sở 1', 4),
('FLF2102', 'Tiếng Anh cơ sở 2', 5),
('FLF2103', 'Tiếng Anh cơ sở 3', 5),
('FLF2104', 'Tiếng Anh cơ sở 4', 5),
('HIS1002', 'Đường lối cách mạng của Đảng Cộng sản Việt Nam', 3),
('INT1003', 'Tin học cơ sở 1', 2),
('INT1006', 'Tin học cơ sở 4', 3),
('INT1050', 'Toán học rời rạc', 4),
('INT2202', 'Lập trình nâng cao', 3),
('INT2203', 'Cấu trúc dữ liệu và giải thuật', 3),
('INT2204', 'Lập trình hướng đối tượng', 3),
('INT2205', 'Kiến trúc máy tính', 3),
('INT2206', 'Nguyên lý hệ điều hành', 3),
('INT2207', 'Cơ sở dữ liệu', 3),
('INT2208', 'Công nghệ phần mềm', 3),
('INT2209', 'Mạng máy tính', 3),
('INT3011', 'Các vấn đề hiện đại trong KHMT', 3),
('INT3401', 'Trí tuệ nhân tạo', 3),
('MAT1041', 'Giải tích 1', 4),
('MAT1042', 'Giải tích 2', 4),
('MAT1093', 'Đại số', 4),
('MAT1101', 'Xác suất thống kê', 3),
('PHI1004', 'Những nguyên lý cơ bản của chủ nghĩa Mác - Lênin 1', 2),
('PHI1005', 'Những nguyên lý cơ bản của chủ nghĩa Mác - Lênin 2', 3),
('PHY1100', 'Cơ - Nhiệt', 3),
('POL1001', 'Tư tưởng Hồ Chí Minh', 2);

-- --------------------------------------------------------

--
-- Table structure for table `phongthi`
--

CREATE TABLE `phongthi` (
  `maphongthi` varchar(20) NOT NULL,
  `diadiem` varchar(50) CHARACTER SET utf8 NOT NULL,
  `soluongmay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phongthi_cathi`
--

CREATE TABLE `phongthi_cathi` (
  `macathi` int(11) NOT NULL,
  `maphongthi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sinhvien`
--

CREATE TABLE `sinhvien` (
  `id` varchar(20) NOT NULL,
  `hodem` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ten` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ngaysinh` date NOT NULL,
  `dudieukienduthi` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sinhvien`
--

INSERT INTO `sinhvien` (`id`, `hodem`, `ten`, `ngaysinh`, `dudieukienduthi`) VALUES
('17021204', 'Nguyễn Việt', 'An', '1999-04-01', 0),
('17021311', 'Cao Minh', 'Nhật', '1999-06-10', 1),
('17021357', 'Trần Quang', 'Vinh', '1999-05-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sinhvien_cathi_phongthi`
--

CREATE TABLE `sinhvien_cathi_phongthi` (
  `masinhvien` varchar(20) NOT NULL,
  `macathi` int(11) NOT NULL,
  `maphongthi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sinhvien_hoc_hocphan`
--

CREATE TABLE `sinhvien_hoc_hocphan` (
  `masinhvien` varchar(20) NOT NULL,
  `mahocphan` varchar(20) NOT NULL,
  `idhocky` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idsinhvien` (`idsinhvien`);

--
-- Indexes for table `cathi`
--
ALTER TABLE `cathi`
  ADD PRIMARY KEY (`macathi`),
  ADD KEY `mahocphan` (`mahocphan`),
  ADD KEY `makythi` (`makythi`);

--
-- Indexes for table `hocphan`
--
ALTER TABLE `hocphan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mahocphan` (`mahocphan`),
  ADD KEY `mamonthi` (`mamonthi`);

--
-- Indexes for table `kythi`
--
ALTER TABLE `kythi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthi`
--
ALTER TABLE `monthi`
  ADD PRIMARY KEY (`mamonthi`);

--
-- Indexes for table `phongthi`
--
ALTER TABLE `phongthi`
  ADD PRIMARY KEY (`maphongthi`);

--
-- Indexes for table `phongthi_cathi`
--
ALTER TABLE `phongthi_cathi`
  ADD KEY `macathi` (`macathi`),
  ADD KEY `maphongthi` (`maphongthi`);

--
-- Indexes for table `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sinhvien_cathi_phongthi`
--
ALTER TABLE `sinhvien_cathi_phongthi`
  ADD KEY `masinhvien` (`masinhvien`),
  ADD KEY `macathi` (`macathi`),
  ADD KEY `maphongthi` (`maphongthi`);

--
-- Indexes for table `sinhvien_hoc_hocphan`
--
ALTER TABLE `sinhvien_hoc_hocphan`
  ADD KEY `masinhvien` (`masinhvien`),
  ADD KEY `mahocphan` (`mahocphan`),
  ADD KEY `svhhp_hp` (`mahocphan`,`idhocky`),
  ADD KEY `idhocky` (`idhocky`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cathi`
--
ALTER TABLE `cathi`
  MODIFY `macathi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hocphan`
--
ALTER TABLE `hocphan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `kythi`
--
ALTER TABLE `kythi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `phongthi_cathi`
--
ALTER TABLE `phongthi_cathi`
  MODIFY `macathi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sinhvien_cathi_phongthi`
--
ALTER TABLE `sinhvien_cathi_phongthi`
  MODIFY `macathi` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`idsinhvien`) REFERENCES `sinhvien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cathi`
--
ALTER TABLE `cathi`
  ADD CONSTRAINT `cathi_ibfk_1` FOREIGN KEY (`makythi`) REFERENCES `kythi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cathi_ibfk_2` FOREIGN KEY (`mahocphan`) REFERENCES `hocphan` (`mahocphan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hocphan`
--
ALTER TABLE `hocphan`
  ADD CONSTRAINT `hocphan_ibfk_1` FOREIGN KEY (`mamonthi`) REFERENCES `monthi` (`mamonthi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phongthi_cathi`
--
ALTER TABLE `phongthi_cathi`
  ADD CONSTRAINT `phongthi_cathi_ibfk_1` FOREIGN KEY (`maphongthi`) REFERENCES `phongthi` (`maphongthi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phongthi_cathi_ibfk_2` FOREIGN KEY (`macathi`) REFERENCES `cathi` (`macathi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sinhvien_cathi_phongthi`
--
ALTER TABLE `sinhvien_cathi_phongthi`
  ADD CONSTRAINT `sinhvien_cathi_phongthi_ibfk_1` FOREIGN KEY (`masinhvien`) REFERENCES `sinhvien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sinhvien_cathi_phongthi_ibfk_2` FOREIGN KEY (`macathi`) REFERENCES `cathi` (`macathi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sinhvien_cathi_phongthi_ibfk_3` FOREIGN KEY (`maphongthi`) REFERENCES `phongthi` (`maphongthi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sinhvien_hoc_hocphan`
--
ALTER TABLE `sinhvien_hoc_hocphan`
  ADD CONSTRAINT `sinhvien_hoc_hocphan_ibfk_1` FOREIGN KEY (`idhocky`) REFERENCES `kythi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sinhvien_hoc_hocphan_ibfk_2` FOREIGN KEY (`masinhvien`) REFERENCES `sinhvien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sinhvien_hoc_hocphan_ibfk_3` FOREIGN KEY (`mahocphan`) REFERENCES `hocphan` (`mahocphan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
