-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 17, 2018 at 06:28 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rps`
--

-- --------------------------------------------------------

--
-- Table structure for table `po_according_to_co`
--

DROP TABLE IF EXISTS `po_according_to_co`;
CREATE TABLE IF NOT EXISTS `po_according_to_co` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_id` varchar(100) NOT NULL,
  `course_code` varchar(100) NOT NULL,
  `sec_no` int(11) NOT NULL,
  `semester` varchar(15) NOT NULL,
  `year` int(4) NOT NULL,
  `po` varchar(10) NOT NULL,
  `co` varchar(15) NOT NULL,
  `po_per` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7622 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
