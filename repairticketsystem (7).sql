-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2019 at 07:08 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `repairticketsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `machine_id` int(11) NOT NULL,
  `machine_name` varchar(256) NOT NULL,
  `machine_type` varchar(256) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `username` varchar(256) NOT NULL,
  `email` varchar(256) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL,
  `first_name` varchar(256) DEFAULT NULL,
  `last_name` varchar(256) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `unique_id` varchar(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`username`, `email`, `admin`, `first_name`, `last_name`, `user_id`, `unique_id`) VALUES
('tesla', 'tesla@ldap.forumsys.com', 1, 'Nikola', 'Tesla', 19, '5c5b667156ce33.07558401'),
('newton', 'newton@ldap.forumsys.com', 0, 'Isaac', 'Newton', 20, '5c5b66779e1c51.75979626'),
('curie', 'curie@ldap.forumsys.com', 0, 'Marie', 'Curie', 21, '5c5b66e53a8481.99245874'),
('einstein', 'einstein@ldap.forumsys.com', 0, 'Albert', 'Einstein', 22, '5c5cedc31b4168.11530368');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `machine_name` varchar(256) DEFAULT NULL,
  `room` varchar(256) NOT NULL,
  `status` varchar(64) NOT NULL,
  `comment` text NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `closed_time` timestamp NULL DEFAULT NULL,
  `requested_by` varchar(23) DEFAULT NULL,
  `assigned_tech` varchar(23) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `machine_name`, `room`, `status`, `comment`, `created_time`, `closed_time`, `requested_by`, `assigned_tech`) VALUES
(5, 'Test', 'Test', 'Unassigned', 'Test', '2019-02-09 02:08:36', NULL, '5c5b667156ce33.07558401', NULL),
(8, '', '', 'Unassigned', '', '2019-03-07 07:03:34', NULL, '5c5b667156ce33.07558401', NULL),
(9, '', '', 'Unassigned', '', '2019-03-07 07:04:51', NULL, '5c5b667156ce33.07558401', NULL),
(12, 'test', 'test', 'Unassigned', 'test', '2019-03-16 03:23:38', NULL, '5c5b667156ce33.07558401', NULL),
(13, 'test', 'test', 'Unassigned', 'test', '2019-03-16 03:23:38', NULL, '5c5b667156ce33.07558401', NULL),
(19, 'test', 'test', 'Unassigned', 'test', '2019-03-16 03:24:07', NULL, '5c5b667156ce33.07558401', NULL),
(21, '', '', 'Unassigned', '', '2019-03-16 03:27:57', NULL, '', NULL),
(22, '', '', 'Unassigned', '', '2019-03-16 03:50:06', NULL, '5c5b667156ce33.07558401', NULL),
(23, '', '', 'Unassigned', '', '2019-03-16 03:52:02', NULL, '5c5b667156ce33.07558401', NULL),
(24, '', '', 'Unassigned', '', '2019-03-16 03:52:31', NULL, '5c5b667156ce33.07558401', NULL),
(25, '', '', 'Unassigned', '', '2019-03-16 04:48:27', NULL, '5c5b667156ce33.07558401', NULL),
(26, '', '', 'Unassigned', '', '2019-03-16 04:48:28', NULL, '5c5b667156ce33.07558401', NULL),
(27, '', '', 'Unassigned', '', '2019-03-16 04:48:28', NULL, '5c5b667156ce33.07558401', NULL),
(28, '', '', 'Unassigned', '', '2019-03-16 04:48:28', NULL, '5c5b667156ce33.07558401', NULL),
(29, '', '', 'Unassigned', '', '2019-03-16 04:48:50', NULL, '5c5b667156ce33.07558401', NULL),
(30, '', '', 'Unassigned', '', '2019-03-16 04:48:50', NULL, '5c5b667156ce33.07558401', NULL),
(31, '', '', 'Unassigned', '', '2019-03-16 04:48:51', NULL, '5c5b667156ce33.07558401', NULL),
(32, '', '', 'Unassigned', '', '2019-03-16 04:48:51', NULL, '5c5b667156ce33.07558401', NULL),
(33, '', '', 'Unassigned', '', '2019-03-16 04:48:51', NULL, '5c5b667156ce33.07558401', NULL),
(34, '', '', 'Unassigned', '', '2019-03-16 04:48:51', NULL, '5c5b667156ce33.07558401', NULL),
(35, '', '', 'Unassigned', '', '2019-03-16 04:48:51', NULL, '5c5b667156ce33.07558401', NULL),
(36, '', '', 'Unassigned', '', '2019-03-16 04:48:52', NULL, '5c5b667156ce33.07558401', NULL),
(37, '', '', 'Unassigned', '', '2019-03-16 04:48:52', NULL, '5c5b667156ce33.07558401', NULL),
(38, '', '', 'Unassigned', '', '2019-03-16 04:48:52', NULL, '5c5b667156ce33.07558401', NULL),
(39, '', '', 'Unassigned', '', '2019-03-16 04:49:04', NULL, '5c5b667156ce33.07558401', NULL),
(40, '', '', 'Unassigned', '', '2019-03-16 04:49:05', NULL, '5c5b667156ce33.07558401', NULL),
(41, '', '', 'Unassigned', '', '2019-03-16 04:49:05', NULL, '5c5b667156ce33.07558401', NULL),
(42, '', '', 'Unassigned', '', '2019-03-16 04:49:05', NULL, '5c5b667156ce33.07558401', NULL),
(43, 'test', 'test', 'Unassigned', 'test', '2019-03-16 04:49:08', NULL, '5c5b667156ce33.07558401', NULL),
(44, 'test', 'test', 'Unassigned', 'test', '2019-03-16 04:49:08', NULL, '5c5b667156ce33.07558401', NULL),
(45, 'test', 'test', 'Unassigned', 'test', '2019-03-16 04:49:09', NULL, '5c5b667156ce33.07558401', NULL),
(46, '', '', 'Unassigned', '', '2019-03-16 04:49:55', NULL, '5c5b667156ce33.07558401', NULL),
(47, '', '', 'Unassigned', '', '2019-03-16 04:52:06', NULL, '5c5b667156ce33.07558401', NULL),
(48, '', '', 'Unassigned', '', '2019-03-16 04:56:35', NULL, '5c5b667156ce33.07558401', NULL),
(49, '', '', 'Unassigned', '', '2019-03-16 05:03:49', NULL, '5c5b667156ce33.07558401', NULL),
(50, '', '', 'Unassigned', '', '2019-03-16 05:27:13', NULL, '5c5b667156ce33.07558401', NULL),
(51, '', '', 'Unassigned', '', '2019-03-16 05:28:01', NULL, '5c5b667156ce33.07558401', NULL),
(52, '', '', 'Unassigned', '', '2019-03-16 05:28:38', NULL, '5c5b667156ce33.07558401', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`machine_id`),
  ADD UNIQUE KEY `machine_name` (`machine_name`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`user_id`) USING BTREE,
  ADD KEY `unique_id` (`unique_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `tech_fk` (`assigned_tech`),
  ADD KEY `user_fk` (`requested_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `machine_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tech_fk` FOREIGN KEY (`assigned_tech`) REFERENCES `profile` (`unique_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
