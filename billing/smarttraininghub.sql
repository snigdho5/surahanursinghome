-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2020 at 09:53 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smarttraininghub`
--

-- --------------------------------------------------------

--
-- Table structure for table `brochure`
--

CREATE TABLE `brochure` (
  `brochure _id` int(55) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dtime` varchar(255) DEFAULT NULL,
  `iplocation` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brochure`
--

INSERT INTO `brochure` (`brochure _id`, `email`, `dtime`, `iplocation`) VALUES
(1, 'snigdho@orionedutech.in', '2020-04-28 12:20:20', NULL),
(19, 'imup.050@gmail.com', '2020-04-28 13:10:37', ''),
(20, 'sfsd@wadewa', '2020-04-28 13:13:10', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `cont_id` int(55) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `iplocation` varchar(255) DEFAULT NULL,
  `dtime` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`cont_id`, `firstname`, `lastname`, `message`, `email`, `iplocation`, `dtime`) VALUES
(1, 'Test', 'Company', 'hthrthrthtr', 'demo@email.com', NULL, '2020-04-28 12:09:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brochure`
--
ALTER TABLE `brochure`
  ADD PRIMARY KEY (`brochure _id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`cont_id`),
  ADD KEY `cont_id` (`cont_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brochure`
--
ALTER TABLE `brochure`
  MODIFY `brochure _id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `cont_id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
