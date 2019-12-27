-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 27, 2019 at 02:44 PM
-- Server version: 5.7.28-0ubuntu0.18.04.4
-- PHP Version: 7.3.13-1+ubuntu18.04.1+deb.sury.org+1

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
('17021204', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 0, '17021204'),
('17021345', '*4264A63AF9DB6B1D2839E745DBD9297A06700919', 0, '17021345'),
('17021353', '*12453C42110E67C856D612317C1B48E4DA5A8333', 0, '17021353'),
('17021357', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 0, '17021357'),
('17023456', '*A674691EB6BD51FF0FB11C6939B7AE6FCD961072', 0, '17023456'),
('17026457', '*B78B1D698FFE28065491B3D8D26307C86101DC51', 0, '17026457'),
('vinhtq115', '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9', 1, NULL);

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
(5, 'MAT1041 1', 1, '2017-12-17', '09:00:00', '10:00:00'),
(6, 'PHY1100 2', 1, '2017-12-25', '16:00:00', '17:30:00'),
(7, 'MAT1041 1', 1, '2017-12-23', '09:00:00', '10:30:00'),
(8, 'INT3011 1', 1, '2017-12-16', '08:00:00', '10:00:00'),
(9, 'MAT1093 1', 1, '2017-12-30', '08:00:00', '10:00:00'),
(10, 'INT3011 2', 1, '2017-12-21', '13:00:00', '14:00:00'),
(11, 'ELT2035 20', 1, '2017-12-31', '08:00:00', '09:00:00'),
(12, 'ELT2035 20', 1, '2017-12-30', '08:00:00', '21:00:00'),
(13, 'PHY1100 2', 1, '2018-01-02', '08:00:00', '09:00:00'),
(15, 'MAT1041 1', 1, '2017-12-26', '08:30:00', '10:00:00'),
(16, 'MAT1093 1', 1, '2017-12-27', '08:00:00', '09:00:00'),
(17, 'PHY1100 2', 1, '2018-03-01', '08:00:00', '09:00:00'),
(18, 'MAT1041 10', 5, '2019-12-24', '08:00:00', '09:30:00'),
(19, 'ELT2035 20', 5, '2019-12-31', '14:00:00', '15:30:00'),
(20, 'MAT1041 10', 5, '2019-12-30', '08:00:00', '09:30:00'),
(21, 'INT3011 1', 5, '2019-12-28', '13:00:00', '14:30:00');

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
(27, 'INT3011 1', 'INT3011'),
(28, 'INT3011 2', 'INT3011');

-- --------------------------------------------------------

--
-- Table structure for table `kythi`
--

CREATE TABLE `kythi` (
  `id` int(11) NOT NULL,
  `ky` int(11) NOT NULL,
  `nambatdau` int(4) NOT NULL,
  `namketthuc` int(4) NOT NULL,
  `ngaybatdau` date NOT NULL,
  `ngayketthuc` date NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kythi`
--

INSERT INTO `kythi` (`id`, `ky`, `nambatdau`, `namketthuc`, `ngaybatdau`, `ngayketthuc`, `active`) VALUES
(1, 1, 2017, 2018, '2017-12-04', '2018-01-07', 0),
(2, 2, 2017, 2018, '2018-05-21', '2018-06-17', 0),
(3, 1, 2018, 2019, '2018-12-10', '2019-01-06', 0),
(4, 2, 2018, 2019, '2019-05-27', '2019-06-16', 0),
(5, 1, 2019, 2020, '2019-12-09', '2020-01-05', 1),
(6, 2, 2019, 2020, '2020-05-25', '2020-06-14', 0);

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
  `maphongthi` varchar(20) CHARACTER SET utf8 NOT NULL,
  `diadiem` varchar(50) CHARACTER SET utf8 NOT NULL,
  `soluongmay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `phongthi`
--

INSERT INTO `phongthi` (`maphongthi`, `diadiem`, `soluongmay`) VALUES
('PM 201-G2', 'Tầng 2 tòa nhà G2', 1),
('PM 202-G2', 'Tầng 2 tòa nhà G2', 48),
('PM 208-G2', 'Tầng 2 tòa nhà G2', 50),
('PM 305-G2', 'Tầng 3 nhà G2', 46),
('PM 306-G2', 'Tầng 3 nhà G2', 10),
('PM 405-E3', 'Tầng 4 tòa nhà E3', 50);

-- --------------------------------------------------------

--
-- Table structure for table `phongthi_cathi`
--

CREATE TABLE `phongthi_cathi` (
  `macathi` int(11) NOT NULL,
  `maphongthi` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `phongthi_cathi`
--

INSERT INTO `phongthi_cathi` (`macathi`, `maphongthi`) VALUES
(2, 'PM 201-G2'),
(18, 'PM 306-G2'),
(19, 'PM 201-G2'),
(20, 'PM 208-G2'),
(21, 'PM 202-G2'),
(21, 'PM 405-E3');

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
('17021345', 'Nguyễn Công Trường ', 'Giang', '1999-10-01', 1),
('17021353', 'Nguyễn Duy ', 'Thái ', '1999-05-03', 0),
('17021357', 'Trần Quang', 'Vinh', '1999-05-11', 1),
('17023456', 'Lê Đình', 'Thiện', '1999-07-03', 1),
('17026457', 'Nguyễn Đình Nhật', 'Minh', '1999-04-03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sinhvien_cathi_phongthi`
--

CREATE TABLE `sinhvien_cathi_phongthi` (
  `masinhvien` varchar(20) NOT NULL,
  `macathi` int(11) NOT NULL,
  `maphongthi` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sinhvien_cathi_phongthi`
--

INSERT INTO `sinhvien_cathi_phongthi` (`masinhvien`, `macathi`, `maphongthi`) VALUES
('17021357', 18, 'PM 306-G2'),
('17023456', 18, 'PM 306-G2'),
('17021357', 19, 'PM 201-G2'),
('17021357', 21, 'PM 405-E3');

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
-- Dumping data for table `sinhvien_hoc_hocphan`
--

INSERT INTO `sinhvien_hoc_hocphan` (`masinhvien`, `mahocphan`, `idhocky`) VALUES
('17021357', 'ELT2035 20', 5),
('17021357', 'INT3011 1', 5),
('17021357', 'MAT1041 10', 5);

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
  ADD PRIMARY KEY (`macathi`,`maphongthi`),
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
  ADD UNIQUE KEY `masinhvien_2` (`masinhvien`,`macathi`,`maphongthi`),
  ADD KEY `masinhvien` (`masinhvien`),
  ADD KEY `macathi` (`macathi`),
  ADD KEY `maphongthi` (`maphongthi`),
  ADD KEY `sinhvien_cathi_phongthi_ibfk_2` (`macathi`,`maphongthi`);

--
-- Indexes for table `sinhvien_hoc_hocphan`
--
ALTER TABLE `sinhvien_hoc_hocphan`
  ADD UNIQUE KEY `masinhvien_2` (`masinhvien`,`mahocphan`,`idhocky`),
  ADD KEY `masinhvien` (`masinhvien`),
  ADD KEY `mahocphan` (`mahocphan`),
  ADD KEY `idhocky` (`idhocky`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cathi`
--
ALTER TABLE `cathi`
  MODIFY `macathi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `hocphan`
--
ALTER TABLE `hocphan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `kythi`
--
ALTER TABLE `kythi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `phongthi_cathi`
--
ALTER TABLE `phongthi_cathi`
  MODIFY `macathi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sinhvien_cathi_phongthi`
--
ALTER TABLE `sinhvien_cathi_phongthi`
  MODIFY `macathi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
  ADD CONSTRAINT `phongthi_cathi_ibfk_2` FOREIGN KEY (`macathi`) REFERENCES `cathi` (`macathi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phongthi_cathi_ibfk_3` FOREIGN KEY (`maphongthi`) REFERENCES `phongthi` (`maphongthi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sinhvien_cathi_phongthi`
--
ALTER TABLE `sinhvien_cathi_phongthi`
  ADD CONSTRAINT `sinhvien_cathi_phongthi_ibfk_1` FOREIGN KEY (`masinhvien`) REFERENCES `sinhvien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sinhvien_cathi_phongthi_ibfk_2` FOREIGN KEY (`macathi`,`maphongthi`) REFERENCES `phongthi_cathi` (`macathi`, `maphongthi`) ON DELETE CASCADE ON UPDATE CASCADE;

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
