-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2019 at 03:10 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

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
  `unique_id` varchar(23) NOT NULL,
  `supervisor_name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`username`, `email`, `admin`, `first_name`, `last_name`, `user_id`, `unique_id`, `supervisor_name`) VALUES
('tesla', 'tesla@ldap.forumsys.com', 1, 'Nikola', 'Tesla', 19, '5c5b667156ce33.07558401', ''),
('newton', 'newton@ldap.forumsys.com', 0, 'Isaac', 'Newton', 20, '5c5b66779e1c51.75979626', ''),
('curie', 'curie@ldap.forumsys.com', 0, 'Marie', 'Curie', 21, '5c5b66e53a8481.99245874', ''),
('einstein', 'einstein@ldap.forumsys.com', 0, 'Albert', 'Einstein', 22, '5c5cedc31b4168.11530368', '');

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
(5, 'Test', 'Test', 'Closed', 'Test', '2019-02-09 02:08:36', '2019-03-16 09:24:35', '5c5b667156ce33.07558401', '5c5b66e53a8481.99245874'),
(8, 'Machine E', 'Room D', 'Closed', '', '2019-03-07 07:03:34', '2019-03-16 09:26:24', '5c5b667156ce33.07558401', '5c5cedc31b4168.11530368'),
(9, 'Machine D', 'Room E', 'Closed', '', '2019-03-07 07:04:51', '2019-03-16 09:27:05', '5c5b667156ce33.07558401', '5c5cedc31b4168.11530368'),
(12, 'test', 'test', 'Closed', 'test', '2019-03-16 03:23:38', '2019-03-16 09:30:23', '5c5b667156ce33.07558401', '5c5b667156ce33.07558401'),
(13, 'test', 'test', 'Closed', 'test', '2019-03-16 03:23:38', '2019-03-16 09:30:53', '5c5b667156ce33.07558401', '5c5b667156ce33.07558401'),
(19, 'test', 'test', 'Closed', 'test', '2019-03-16 03:24:07', '2019-03-16 15:09:22', '5c5b667156ce33.07558401', ''),
(21, 'Machine C', 'Room B', 'Closed', '', '2019-03-16 03:27:57', '2019-03-16 15:09:48', '', ''),
(22, 'Machine B', 'Room E', 'Closed', '', '2019-03-16 03:50:06', '2019-03-16 15:11:28', '5c5b667156ce33.07558401', ''),
(23, 'Machine B', 'Room B', 'Closed', '', '2019-03-16 03:52:02', '2019-03-13 16:17:39', '5c5b667156ce33.07558401', ''),
(24, 'Machine A', 'Room A', 'Assigned', '', '2019-03-16 03:52:31', '2019-02-20 05:00:00', '5c5b667156ce33.07558401', ''),
(25, 'NoT Test', '', 'Assigned', '', '2019-03-16 04:48:27', NULL, '5c5b667156ce33.07558401', '5c5b667156ce33.07558401'),
(26, '', '', 'Unassigned', '', '2019-03-16 04:48:28', NULL, '5c5b667156ce33.07558401', '5c5b66e53a8481.99245874'),
(27, '', 'Notty', 'Unassigned', '', '2019-03-16 04:48:28', NULL, '5c5b667156ce33.07558401', '5c5cedc31b4168.11530368'),
(28, '', 'Room C', 'Assigned', '', '2019-03-16 04:48:28', NULL, '5c5b667156ce33.07558401', '5c5cedc31b4168.11530368'),
(29, '', '', 'Unassigned', '', '2019-03-16 04:48:50', NULL, '5c5b667156ce33.07558401', '5c5b667156ce33.07558401'),
(30, 'Notty', '', 'Unassigned', '', '2019-03-16 04:48:50', NULL, '5c5b667156ce33.07558401', ''),
(31, '', '', 'Unassigned', '', '2019-03-16 04:48:51', NULL, '5c5b667156ce33.07558401', '5c5cedc31b4168.11530368'),
(32, '', '', 'Unassigned', '', '2019-03-16 04:48:51', NULL, '5c5b667156ce33.07558401', ''),
(33, '', '', 'Unassigned', '', '2019-03-16 04:48:51', NULL, '5c5b667156ce33.07558401', ''),
(34, 'Notty', '', 'Unassigned', '', '2019-03-16 04:48:51', NULL, '5c5b667156ce33.07558401', ''),
(35, '', '', 'Unassigned', '', '2019-03-20 04:48:51', '2019-03-21 04:00:00', '5c5b667156ce33.07558401', ''),
(36, '', '', 'Unassigned', '', '2019-01-01 05:48:52', '2019-03-24 04:00:00', '5c5b667156ce33.07558401', ''),
(37, '', '', 'Unassigned', '', '2019-03-16 04:48:52', NULL, '5c5b667156ce33.07558401', ''),
(38, '', '', 'Unassigned', '', '2019-03-16 04:48:52', NULL, '5c5b667156ce33.07558401', ''),
(39, '', '', 'Unassigned', '', '2019-03-16 04:49:04', NULL, '5c5b667156ce33.07558401', ''),
(40, '', '', 'Unassigned', '', '2019-03-16 04:49:05', NULL, '5c5b667156ce33.07558401', ''),
(41, '', '', 'Unassigned', '', '2019-03-16 04:49:05', NULL, '5c5b667156ce33.07558401', ''),
(42, '', '', 'Unassigned', '', '2019-03-16 04:49:05', NULL, '5c5b667156ce33.07558401', ''),
(43, 'test', 'test', 'Unassigned', 'test', '2019-03-16 04:49:08', NULL, '5c5b667156ce33.07558401', ''),
(44, 'test', 'test', 'Unassigned', 'test', '2019-03-16 04:49:08', NULL, '5c5b667156ce33.07558401', ''),
(45, 'test', 'test', 'Unassigned', 'test', '2019-03-16 04:49:09', NULL, '5c5b667156ce33.07558401', ''),
(46, '', '', 'Unassigned', '', '2019-03-16 04:49:55', NULL, '5c5b667156ce33.07558401', ''),
(47, '', '', 'Unassigned', '', '2019-03-16 04:52:06', NULL, '5c5b667156ce33.07558401', ''),
(48, '', '', 'Unassigned', '', '2019-03-16 04:56:35', NULL, '5c5b667156ce33.07558401', ''),
(49, '', '', 'Unassigned', '', '2019-03-16 05:03:49', NULL, '5c5b667156ce33.07558401', ''),
(50, '', '', 'Unassigned', '', '2019-03-16 05:27:13', NULL, '5c5b667156ce33.07558401', ''),
(51, '', '', 'Unassigned', '', '2019-03-16 05:28:01', NULL, '5c5b667156ce33.07558401', ''),
(52, '', '', 'Unassigned', '', '2019-03-16 05:28:38', NULL, '5c5b667156ce33.07558401', '');

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
