-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 22, 2020 at 07:05 AM
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
-- Table structure for table `users_files`
--

CREATE TABLE `users_files` (
  `id` int(10) NOT NULL,
  `uid` int(5) NOT NULL,
  `media_id` varchar(300) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '0',
  `file_path` varchar(400) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '1',
  `img_order` int(5) NOT NULL,
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_files`
--

INSERT INTO `users_files` (`id`, `uid`, `media_id`, `type`, `name`, `file_path`, `status`, `img_order`, `changed`, `created`) VALUES
(3, 40, 'd645920e395fedad7bbbed0eca3fe2e0', 'png', 'Capture1.png', '09.192.run/assets/uploads/users/d645920e395fedad7bbbed0eca3fe2e0/Capture1.png', 1, 0, '2020-06-21 17:01:59', '2020-06-21 17:01:59'),
(4, 40, 'd645920e395fedad7bbbed0eca3fe2e0', 'png', 'Capture.png', '09.192.run/assets/uploads/users/d645920e395fedad7bbbed0eca3fe2e0/Capture.png', 1, 0, '2020-06-21 17:04:38', '2020-06-21 17:04:38'),
(5, 40, 'd645920e395fedad7bbbed0eca3fe2e0', 'jpg', 'm-01.jpg', '09.192.run/assets/uploads/users/d645920e395fedad7bbbed0eca3fe2e0/m-01.jpg', 1, 0, '2020-06-21 17:05:53', '2020-06-21 17:05:53'),
(6, 40, 'd645920e395fedad7bbbed0eca3fe2e0', 'doc', 'file-sample_100kB.doc', '09.192.run/assets/uploads/users/d645920e395fedad7bbbed0eca3fe2e0/file-sample_100kB.doc', 1, 0, '2020-06-21 17:06:10', '2020-06-21 17:06:10'),
(7, 40, 'd645920e395fedad7bbbed0eca3fe2e0', 'pdf', 'Report4.pdf', '09.192.run/assets/uploads/users/d645920e395fedad7bbbed0eca3fe2e0/Report4.pdf', 1, 0, '2020-06-21 17:06:44', '2020-06-21 17:06:44'),
(8, 40, 'd645920e395fedad7bbbed0eca3fe2e0', 'doc', 'file-sample_100kB.doc', '09.192.run/assets/uploads/users/d645920e395fedad7bbbed0eca3fe2e0/file-sample_100kB.doc', 1, 0, '2020-06-21 17:06:54', '2020-06-21 17:06:54'),
(9, 48, '642e92efb79421734881b53e1e1b18b6', 'doc', 'file-sample_100kB.doc', '09.192.run/assets/uploads/users/642e92efb79421734881b53e1e1b18b6/file-sample_100kB.doc', 1, 0, '2020-06-22 06:52:17', '2020-06-22 06:52:17'),
(10, 48, '642e92efb79421734881b53e1e1b18b6', 'pdf', 'Report4.pdf', '09.192.run/assets/uploads/users/642e92efb79421734881b53e1e1b18b6/Report4.pdf', 1, 0, '2020-06-22 06:52:29', '2020-06-22 06:52:29'),
(11, 48, '642e92efb79421734881b53e1e1b18b6', 'png', 'A2.png', '09.192.run/assets/uploads/users/642e92efb79421734881b53e1e1b18b6/A2.png', 1, 0, '2020-06-22 06:52:40', '2020-06-22 06:52:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users_files`
--
ALTER TABLE `users_files`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users_files`
--
ALTER TABLE `users_files`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
