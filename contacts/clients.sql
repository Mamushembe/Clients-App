-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 05, 2024 at 12:12 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clients`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `client_code` varchar(255) NOT NULL,
  `linked_contacts` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `client_code`, `linked_contacts`) VALUES
(4, 'First National Bank1', 'FIR001', 1),
(2, 'Michael Natangwe', 'MIC001', 814432818),
(3, 'IT', 'ITA001', 814432818),
(5, 'Gustavo Eiseb', 'GUS001', 0),
(8, 'Standard Bank Namibia', 'STA001', 0),
(7, 'Matilda John', 'MAT001', 0),
(9, 'Agri Bank Namibia', 'ABN001', 0);

-- --------------------------------------------------------

--
-- Table structure for table `client_contacts`
--

DROP TABLE IF EXISTS `client_contacts`;
CREATE TABLE IF NOT EXISTS `client_contacts` (
  `client_id` int NOT NULL,
  `contact_id` int NOT NULL,
  PRIMARY KEY (`client_id`,`contact_id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `client_contacts`
--

INSERT INTO `client_contacts` (`client_id`, `contact_id`) VALUES
(2, 2),
(2, 6),
(3, 3),
(5, 6),
(8, 7);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `contact_name`, `contact_email`) VALUES
(1, 'Frans Indongo1', 'frans.indongo@gmail.com'),
(2, 'Amushembe Michael', 'amushembemichael@gmail.com'),
(3, 'Lui', 'lui@gmail.com'),
(4, 'Matry Lyn', 'mary.lyn@gmail.com'),
(6, 'Moses Sky', 'moses.sky@gmail.com'),
(7, 'Hendrik Junias', 'hendrik@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `linked_contacts`
--

DROP TABLE IF EXISTS `linked_contacts`;
CREATE TABLE IF NOT EXISTS `linked_contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int DEFAULT NULL,
  `contact_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
