-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2021 at 04:47 PM
-- Server version: 8.0.23
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `austinshow`
--

-- --------------------------------------------------------

--
-- Table structure for table `allshows`
--

CREATE TABLE `allshows` (
  `showid` int NOT NULL,
  `showtype` smallint UNSIGNED NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `smalldescription` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `applicationID` int NOT NULL,
  `username` varchar(150) NOT NULL,
  `twitterurl` varchar(150) NOT NULL,
  `youtubevideo` varchar(200) NOT NULL,
  `images` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `whyareyouinterested` text NOT NULL,
  `anythingelse` text NOT NULL,
  `whoareyou` text NOT NULL,
  `age` tinyint UNSIGNED NOT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT '0',
  `dateinserted` varchar(100) NOT NULL,
  `ihavebeenontheshow` tinyint(1) NOT NULL,
  `ihavebeeninterviewed` tinyint(1) NOT NULL,
  `showid` smallint NOT NULL,
  `ipadresse` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `showtypes`
--

CREATE TABLE `showtypes` (
  `showidtypes` int NOT NULL,
  `showname` varchar(150) NOT NULL,
  `showimage` varchar(150) NOT NULL,
  `age` smallint NOT NULL,
  `containsVideo` tinyint(1) NOT NULL,
  `containsImage` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allshows`
--
ALTER TABLE `allshows`
  ADD PRIMARY KEY (`showid`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`applicationID`);

--
-- Indexes for table `showtypes`
--
ALTER TABLE `showtypes`
  ADD PRIMARY KEY (`showidtypes`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allshows`
--
ALTER TABLE `allshows`
  MODIFY `showid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `applicationID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `showtypes`
--
ALTER TABLE `showtypes`
  MODIFY `showidtypes` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
