-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 21, 2020 at 07:37 AM
-- Server version: 5.7.30
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smmr09`
--

-- --------------------------------------------------------

--
-- Table structure for table `services_media`
--

CREATE TABLE `services_media` (
  `id` int(10) NOT NULL,
  `uid` int(5) NOT NULL,
  `media_id` varchar(300) NOT NULL,
  `type` tinyint(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '0',
  `file_path` varchar(400) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '1',
  `img_order` int(5) NOT NULL,
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services_media`
--

INSERT INTO `services_media` (`id`, `uid`, `media_id`, `type`, `name`, `file_path`, `status`, `img_order`, `changed`, `created`) VALUES
(45, 40, '63039c43b1f0adbf5baa5baee0ff9fab', 0, 'link.PNG', '08.192.run/assets/uploads/media/63039c43b1f0adbf5baa5baee0ff9fab', 0, 0, '2020-06-15 01:13:13', '2020-06-15 01:13:13'),
(46, 40, '63039c43b1f0adbf5baa5baee0ff9fab', 0, 'mee.PNG', '08.192.run/assets/uploads/media/63039c43b1f0adbf5baa5baee0ff9fab', 0, 0, '2020-06-15 01:13:13', '2020-06-15 01:13:13'),
(47, 40, '63039c43b1f0adbf5baa5baee0ff9fab', 1, '1.mp4', '08.192.run/assets/uploads/media/63039c43b1f0adbf5baa5baee0ff9fab', 0, 0, '2020-06-15 01:13:13', '2020-06-15 01:13:13'),
(49, 40, '63039c43b1f0adbf5baa5baee0ff9fab', 0, 'plant-flower-macro-87840.jpg', '08.192.run/assets/uploads/media/63039c43b1f0adbf5baa5baee0ff9fab', 0, 0, '2020-06-15 01:13:13', '2020-06-15 01:13:13'),
(57, 40, '471e9015f540959f359067fc318ca15f', 1, 'bandicam 2020-05-03 12-20-06-517.mp4', '09.192.run/assets/uploads/media/471e9015f540959f359067fc318ca15f', 0, 0, NULL, NULL),
(62, 40, '471e9015f540959f359067fc318ca15f', 0, 'ocean.jpg', '09.192.run/assets/uploads/media/471e9015f540959f359067fc318ca15f', 0, 0, NULL, NULL),
(69, 40, '82c196f8e34f372916c3f0139d679ac1', 0, 'apple3.jpg', '09.192.run/assets/uploads/media/82c196f8e34f372916c3f0139d679ac1', 0, 1, NULL, NULL),
(70, 40, '82c196f8e34f372916c3f0139d679ac1', 0, 'ocean.jpg', '09.192.run/assets/uploads/media/82c196f8e34f372916c3f0139d679ac1', 0, 0, NULL, NULL),
(71, 40, '82c196f8e34f372916c3f0139d679ac1', 0, 'Webp.net-resizeimage (1).png', '09.192.run/assets/uploads/media/82c196f8e34f372916c3f0139d679ac1', 0, 2, NULL, NULL),
(73, 40, '471e9015f540959f359067fc318ca15f', 1, 'bandicam 2020-05-27 09-02-25-449.mp4', '09.192.run/assets/uploads/media/471e9015f540959f359067fc318ca15f', 0, 0, NULL, NULL),
(74, 40, '471e9015f540959f359067fc318ca15f', 1, 'bandicam 2020-06-13 21-40-16-397.mp4', '09.192.run/assets/uploads/media/471e9015f540959f359067fc318ca15f', 0, 0, NULL, NULL),
(75, 40, '471e9015f540959f359067fc318ca15f', 0, '300px-The_Earth_seen_from_Apollo_17.jpg', '09.192.run/assets/uploads/media/471e9015f540959f359067fc318ca15f', 0, 0, NULL, NULL),
(77, 40, '6365b4b400a024abffce4c029780d651', 0, '300px 10.png', '08.192.run/assets/uploads/media/6365b4b400a024abffce4c029780d651', 0, 0, '2020-06-16 00:04:12', '2020-06-16 00:04:12'),
(78, 40, '6365b4b400a024abffce4c029780d651', 0, '300px-The_Earth_seen_from_Apollo_17.jpg', '08.192.run/assets/uploads/media/6365b4b400a024abffce4c029780d651', 0, 0, '2020-06-16 00:04:12', '2020-06-16 00:04:12'),
(79, 40, '6365b4b400a024abffce4c029780d651', 0, 'ocean.jpg', '08.192.run/assets/uploads/media/6365b4b400a024abffce4c029780d651', 0, 0, '2020-06-16 00:04:12', '2020-06-16 00:04:12'),
(81, 40, '63039c43b1f0adbf5baa5baee0ff9fab', 0, 'media4.png', '08.192.run/assets/uploads/media/63039c43b1f0adbf5baa5baee0ff9fab', 0, 0, '2020-06-16 03:01:36', '2020-06-16 03:01:36'),
(82, 40, '24220de029d69d048dcad06f5b121793', 0, 'Webp.net-resizeimage (1).png', '09.192.run/assets/uploads/media/24220de029d69d048dcad06f5b121793', 0, 0, NULL, NULL),
(83, 40, 'e9778f8e548f514cdcf165d9747ea118', 0, 'Webp.net-resizeimage (1).png', '09.192.run/assets/uploads/media/e9778f8e548f514cdcf165d9747ea118', 0, 0, NULL, NULL),
(84, 40, 'e9778f8e548f514cdcf165d9747ea118', 1, 'screen3.mp4', '09.192.run/assets/uploads/media/e9778f8e548f514cdcf165d9747ea118', 0, 0, NULL, NULL),
(85, 40, '5be3a3293f506d2b8acff2668013525b', 0, 'Webp.net-resizeimage (1).png', '09.192.run/assets/uploads/media/5be3a3293f506d2b8acff2668013525b', 0, 0, NULL, NULL),
(86, 40, '5be3a3293f506d2b8acff2668013525b', 1, 'screen3.mp4', '09.192.run/assets/uploads/media/5be3a3293f506d2b8acff2668013525b', 0, 0, NULL, NULL),
(87, 40, '82c196f8e34f372916c3f0139d679ac1', 1, 'screen3.mp4', '09.192.run/assets/uploads/media/82c196f8e34f372916c3f0139d679ac1', 0, 3, NULL, NULL),
(89, 40, 'd31e39ff189b8379bffef02e6125668c', 0, '300px-The_Earth_seen_from_Apollo_17.jpg', '08.192.run/assets/uploads/media/d31e39ff189b8379bffef02e6125668c', 0, 0, '2020-06-18 03:18:09', '2020-06-18 03:18:09'),
(91, 40, 'd31e39ff189b8379bffef02e6125668c', 0, 'Webp.net-resizeimage.jpg', '08.192.run/assets/uploads/media/d31e39ff189b8379bffef02e6125668c', 0, 0, '2020-06-18 03:27:20', '2020-06-18 03:27:20'),
(93, 40, 'd31e39ff189b8379bffef02e6125668c', 0, '300px 10.png', '08.192.run/assets/uploads/media/d31e39ff189b8379bffef02e6125668c', 0, 0, '2020-06-18 03:50:34', '2020-06-18 03:50:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `services_media`
--
ALTER TABLE `services_media`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `services_media`
--
ALTER TABLE `services_media`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
