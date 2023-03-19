-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 19, 2023 at 01:38 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `solar`
--

-- --------------------------------------------------------

--
-- Table structure for table `ammonia`
--

CREATE TABLE `ammonia` (
  `id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ammonia`
--

INSERT INTO `ammonia` (`id`, `value`, `date`, `time`) VALUES
(1, 302, '2023-03-15', '08:12:25'),
(2, 100, '2023-03-16', '08:13:43'),
(3, 100, '2023-03-16', '08:14:17'),
(4, 100, '2023-03-16', '08:15:13'),
(5, 100, '2023-03-16', '08:15:57'),
(6, 100, '2023-03-16', '08:16:09'),
(7, 100, '2023-03-16', '08:16:38'),
(8, 100, '2023-03-16', '08:16:52'),
(9, 100, '2023-03-16', '08:17:08'),
(10, 100, '2023-03-16', '08:17:32'),
(11, 100, '2023-03-16', '08:17:40'),
(12, 100, '2023-03-16', '08:17:44');

-- --------------------------------------------------------

--
-- Table structure for table `current`
--

CREATE TABLE `current` (
  `id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `pv` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `current`
--

INSERT INTO `current` (`id`, `value`, `pv`, `date`, `time`) VALUES
(1, 10, 1, '2023-03-15', '08:12:25'),
(2, 10, 2, '2023-03-16', '08:13:43'),
(3, 10, 2, '2023-03-16', '08:14:17'),
(4, 10, 2, '2023-03-16', '08:15:13'),
(5, 10, 2, '2023-03-16', '08:15:57'),
(6, 10, 2, '2023-03-16', '08:16:09'),
(7, 10, 2, '2023-03-16', '08:16:38'),
(8, 10, 2, '2023-03-16', '08:16:52'),
(9, 10, 2, '2023-03-16', '08:17:08'),
(10, 10, 2, '2023-03-16', '08:17:32'),
(11, 10, 2, '2023-03-16', '08:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `humidity`
--

CREATE TABLE `humidity` (
  `id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `humidity`
--

INSERT INTO `humidity` (`id`, `value`, `date`, `time`) VALUES
(1, 300, '2023-03-15', '08:12:25'),
(2, 30, '2023-03-16', '08:13:43'),
(3, 30, '2023-03-16', '08:14:17'),
(4, 30, '2023-03-16', '08:15:13'),
(5, 30, '2023-03-16', '08:15:57'),
(6, 30, '2023-03-16', '08:16:09'),
(7, 30, '2023-03-16', '08:16:38'),
(8, 30, '2023-03-16', '08:16:52'),
(9, 30, '2023-03-16', '08:17:08'),
(10, 30, '2023-03-16', '08:17:32'),
(11, 30, '2023-03-16', '08:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `leakage`
--

CREATE TABLE `leakage` (
  `id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leakage`
--

INSERT INTO `leakage` (`id`, `value`, `date`, `time`) VALUES
(1, 1, '2023-03-15', '08:12:25'),
(2, 1, '2023-03-16', '08:13:43'),
(3, 1, '2023-03-16', '08:14:17'),
(4, 1, '2023-03-16', '08:15:13'),
(5, 1, '2023-03-16', '08:15:57'),
(6, 1, '2023-03-16', '08:16:09'),
(7, 1, '2023-03-16', '08:16:38'),
(8, 0, '2023-03-16', '08:16:52'),
(9, 1, '2023-03-16', '08:17:08'),
(10, 1, '2023-03-16', '08:17:32'),
(11, 1, '2023-03-16', '08:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `PV`
--

CREATE TABLE `PV` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `PV`
--

INSERT INTO `PV` (`id`, `name`) VALUES
(1, 'pv1'),
(2, 'pv2');

-- --------------------------------------------------------

--
-- Table structure for table `temperature`
--

CREATE TABLE `temperature` (
  `id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `temperature`
--

INSERT INTO `temperature` (`id`, `value`, `date`, `time`) VALUES
(1, 100, '2023-03-15', '08:17:08'),
(2, 80, '2023-03-16', '08:17:32'),
(3, 100, '2023-03-16', '08:17:32'),
(4, 60, '2023-03-16', '08:17:32'),
(5, 40, '2023-03-16', '08:17:32'),
(6, 10, '2023-03-16', '08:17:32'),
(7, 50, '2023-03-16', '08:17:32'),
(8, 80, '2023-03-16', '08:17:32'),
(9, 100, '2023-03-16', '08:17:32'),
(10, 100, '2023-03-16', '08:17:32'),
(11, 100, '2023-03-16', '08:17:32');

-- --------------------------------------------------------

--
-- Table structure for table `voltage`
--

CREATE TABLE `voltage` (
  `id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `pv` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `voltage`
--

INSERT INTO `voltage` (`id`, `value`, `pv`, `date`, `time`) VALUES
(1, 30, 1, '2023-03-15', '08:17:08'),
(2, 40, 2, '2023-03-16', '08:17:32'),
(3, 30, 3, '2023-03-16', '08:17:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ammonia`
--
ALTER TABLE `ammonia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `current`
--
ALTER TABLE `current`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pv` (`pv`);

--
-- Indexes for table `humidity`
--
ALTER TABLE `humidity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leakage`
--
ALTER TABLE `leakage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PV`
--
ALTER TABLE `PV`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temperature`
--
ALTER TABLE `temperature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voltage`
--
ALTER TABLE `voltage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pv` (`pv`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ammonia`
--
ALTER TABLE `ammonia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `current`
--
ALTER TABLE `current`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `humidity`
--
ALTER TABLE `humidity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `leakage`
--
ALTER TABLE `leakage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `PV`
--
ALTER TABLE `PV`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `temperature`
--
ALTER TABLE `temperature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `voltage`
--
ALTER TABLE `voltage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
