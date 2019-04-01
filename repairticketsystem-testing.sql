-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2019 at 07:14 PM
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
CREATE DATABASE IF NOT EXISTS `repairticketsystem` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `repairticketsystem`;

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

DROP TABLE IF EXISTS `machines`;
CREATE TABLE IF NOT EXISTS `machines` (
  `machine_id` int(11) NOT NULL AUTO_INCREMENT,
  `machine_name` varchar(256) NOT NULL,
  `machine_type` varchar(256) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`machine_id`),
  UNIQUE KEY `machine_name` (`machine_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages_list`
--

DROP TABLE IF EXISTS `messages_list`;
CREATE TABLE IF NOT EXISTS `messages_list` (
  `ticket_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(23) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  `isInfo` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages_list`
--

INSERT INTO `messages_list` (`ticket_id`, `message_id`, `user_id`, `timestamp`, `content`, `isInfo`) VALUES
(8, 1, '5c5b667156ce33.07558401', '2019-03-28 09:42:35', 'Hello There!', 0),
(8, 2, '5c5b66779e1c51.75979626', '2019-03-28 10:10:35', 'fix my issue please', 0),
(8, 3, '5c5b667156ce33.07558401', '2019-03-28 10:18:35', 'test', 0),
(8, 4, '5c5b66779e1c51.75979626', '2019-03-28 11:45:35', 't\nt', 0),
(8, 5, '5c5b667156ce33.07558401', '2019-03-28 12:45:35', 't', 0),
(8, 6, '5c5b667156ce33.07558401', '2019-03-28 13:45:35', 'hello', 0),
(8, 7, '5c5b667156ce33.07558401', '2019-03-28 14:45:35', 'what', 0),
(8, 8, '5c5b667156ce33.07558401', '2019-03-28 15:45:35', 'double line\nmessage\nmake it triple', 0),
(8, 9, '5c5b667156ce33.07558401', '2019-03-28 16:45:35', 'A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.', 0),
(8, 10, '5c5b66779e1c51.75979626', '2019-03-28 16:45:35', 'A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.', 0),
(8, 11, '5c5b66779e1c51.75979626', '2019-03-28 17:45:35', 'A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.A new, longer message.', 0),
(8, 12, '5c5b667156ce33.07558401', '2019-03-28 17:45:35', 'j', 0),
(8, 13, '5c5b667156ce33.07558401', '2019-03-28 18:45:35', 'ghjhgf', 0),
(8, 14, '5c5b667156ce33.07558401', '2019-03-28 19:45:35', 'dfgdf', 0),
(8, 26, '5c5b667156ce33.07558401', '2019-03-28 20:45:35', 'dsfdsf', 0),
(8, 27, '5c5b667156ce33.07558401', '2019-03-28 21:45:35', 'dsf', 0),
(8, 28, '5c5b667156ce33.07558401', '2019-03-28 22:45:35', 'dsfds', 0),
(5, 29, '5c5b667156ce33.07558401', '2019-03-29 02:33:02', 'hi', 0),
(8, 30, '5c5b667156ce33.07558401', '2019-03-29 03:03:17', 'Hello', 0),
(8, 31, '5c5b667156ce33.07558401', '2019-03-29 03:06:06', 'hi', 0),
(8, 32, '5c5b667156ce33.07558401', '2019-03-29 03:06:30', 'hi', 0),
(8, 33, '5c5b667156ce33.07558401', '2019-03-29 03:08:43', 'sdf', 0),
(8, 34, '5c5b667156ce33.07558401', '2019-03-29 03:08:50', 'sdf', 0),
(8, 35, '5c5b667156ce33.07558401', '2019-03-29 03:09:23', 'dfg', 0),
(8, 36, '5c5b667156ce33.07558401', '2019-03-29 03:13:46', 'hi', 0),
(8, 37, '5c5b667156ce33.07558401', '2019-03-29 03:15:49', 'dfg', 0),
(62, 38, '5c5b667156ce33.07558401', '2019-03-29 21:21:24', 'This should appear first. Here is my problem', 0),
(62, 39, '5c5b667156ce33.07558401', '2019-03-29 21:21:24', 'This should appear second', 0),
(63, 40, '5c5b667156ce33.07558401', '2019-03-29 22:46:47', 'testing', 0),
(63, 41, '5c5b667156ce33.07558401', '2019-03-29 22:46:47', '', 0),
(64, 42, '5c5b667156ce33.07558401', '2019-03-29 22:47:29', 't', 0),
(64, 43, '5c5b667156ce33.07558401', '2019-03-29 22:47:29', 't', 0),
(65, 44, '5c5b667156ce33.07558401', '2019-03-29 23:07:43', 'This is the problem', 0),
(65, 45, '5c5b667156ce33.07558401', '2019-03-29 23:07:43', 'Misc comments here', 0),
(66, 46, '5c5b667156ce33.07558401', '2019-03-29 23:10:20', 'test', 0),
(66, 47, '5c5b667156ce33.07558401', '2019-03-29 23:10:20', 'test', 0),
(67, 48, '5c5b667156ce33.07558401', '2019-03-29 23:11:32', 'test', 0),
(67, 49, '5c5b667156ce33.07558401', '2019-03-29 23:11:32', 'test', 0),
(68, 50, '5c5b667156ce33.07558401', '2019-03-29 23:11:48', 't', 0),
(68, 51, '5c5b667156ce33.07558401', '2019-03-29 23:11:48', 't', 0),
(69, 52, '5c5b667156ce33.07558401', '2019-03-29 23:12:36', 't', 0),
(69, 53, '5c5b667156ce33.07558401', '2019-03-29 23:12:36', 't', 0),
(70, 54, '5c5b667156ce33.07558401', '2019-03-29 23:17:14', 't', 0),
(70, 55, '5c5b667156ce33.07558401', '2019-03-29 23:17:14', 't', 0),
(71, 56, '5c5b667156ce33.07558401', '2019-03-29 23:17:26', 't', 0),
(71, 57, '5c5b667156ce33.07558401', '2019-03-29 23:17:26', 't', 0),
(72, 58, '5c5b667156ce33.07558401', '2019-03-30 16:16:06', 't', 0),
(72, 59, '5c5b667156ce33.07558401', '2019-03-30 16:16:06', 't', 0),
(72, 60, '5c5b667156ce33.07558401', '2019-03-30 16:20:45', 'sdf', 0),
(73, 61, '5c5b66e53a8481.99245874', '2019-03-31 05:34:33', 't', 0),
(73, 62, '5c5b66e53a8481.99245874', '2019-03-31 05:34:33', '', 0),
(74, 63, '5c5b667156ce33.07558401', '2019-04-01 16:45:40', 't', 0),
(74, 64, '5c5b667156ce33.07558401', '2019-04-01 16:45:40', 't', 0),
(75, 65, '5c5b667156ce33.07558401', '2019-04-01 16:46:01', 'q', 0),
(75, 66, '5c5b667156ce33.07558401', '2019-04-01 16:46:01', 'q', 0),
(75, 67, '5c5b667156ce33.07558401', '2019-04-01 16:57:12', 'Closed', 1),
(75, 68, '5c5b667156ce33.07558401', '2019-04-01 17:03:08', 'In Progress', 1),
(75, 69, '5c5b667156ce33.07558401', '2019-04-01 17:11:58', 'hi', 0),
(75, 70, '5c5b667156ce33.07558401', '2019-04-01 17:12:05', 'hi', 0),
(75, 71, '5c5b667156ce33.07558401', '2019-04-01 17:12:26', 'hi', 0);

-- --------------------------------------------------------

--
-- Table structure for table `parts_list`
--

DROP TABLE IF EXISTS `parts_list`;
CREATE TABLE IF NOT EXISTS `parts_list` (
  `part_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `item_description` varchar(256) DEFAULT '',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `price` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`part_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parts_list`
--

INSERT INTO `parts_list` (`part_id`, `ticket_id`, `item_description`, `quantity`, `price`) VALUES
(1, 1, 'Test Item', 1, 10.99),
(25, 1, 'New Test Item ', 2, 2.99),
(32, 1, 'Test Update', 1, 1),
(36, 1, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `username` varchar(256) NOT NULL,
  `email` varchar(256) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL,
  `first_name` varchar(256) DEFAULT NULL,
  `last_name` varchar(256) DEFAULT NULL,
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(23) NOT NULL,
  PRIMARY KEY (`user_id`) USING BTREE,
  KEY `unique_id` (`unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`username`, `email`, `admin`, `first_name`, `last_name`, `user_id`, `unique_id`) VALUES
('tesla', 'tesla@ldap.forumsys.com', 1, 'Nikola', 'Tesla', 19, '5c5b667156ce33.07558401'),
('newton', 'newton@ldap.forumsys.com', 1, 'Isaac', 'Newton', 20, '5c5b66779e1c51.75979626'),
('curie', 'curie@ldap.forumsys.com', 0, 'Marie', 'Curie', 21, '5c5b66e53a8481.99245874'),
('einstein', 'einstein@ldap.forumsys.com', 0, 'Albert', 'Einstein', 22, '5c5cedc31b4168.11530368');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `machine_name` varchar(256) DEFAULT NULL,
  `room` varchar(256) NOT NULL,
  `status` varchar(64) NOT NULL,
  `comment` text NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `closed_time` timestamp NULL DEFAULT NULL,
  `requested_by` varchar(23) DEFAULT NULL,
  `assigned_tech` varchar(23) DEFAULT NULL,
  `supervisor_name` varchar(256) NOT NULL,
  `supervisor_code` varchar(256) NOT NULL,
  `other_comments` text NOT NULL,
  PRIMARY KEY (`ticket_id`),
  KEY `tech_fk` (`assigned_tech`),
  KEY `user_fk` (`requested_by`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `machine_name`, `room`, `status`, `comment`, `created_time`, `closed_time`, `requested_by`, `assigned_tech`, `supervisor_name`, `supervisor_code`, `other_comments`) VALUES
(5, 'Test', 'Test', 'Closed', 'Test', '2019-02-09 02:08:36', '2019-03-16 09:24:35', '5c5b667156ce33.07558401', '5c5b66e53a8481.99245874', 'He', 'Who', ''),
(8, 'Machine E', 'Room D', 'Closed', '', '2019-03-07 07:03:34', '2019-03-16 09:26:24', '5c5b667156ce33.07558401', '5c5cedc31b4168.11530368', '', '', ''),
(9, 'Machine D', 'Room E', 'Closed', '', '2019-03-07 07:04:51', '2019-03-16 09:27:05', '5c5b667156ce33.07558401', '5c5cedc31b4168.11530368', '', '', ''),
(12, 'test', 'test', 'Closed', 'test', '2019-03-16 03:23:38', '2019-03-16 09:30:23', '5c5b667156ce33.07558401', '5c5b667156ce33.07558401', '', '', ''),
(13, 'test', 'test', 'Closed', 'test', '2019-03-16 03:23:38', '2019-03-16 09:30:53', '5c5b667156ce33.07558401', '5c5b667156ce33.07558401', '', '', ''),
(19, 'test', 'test', 'Closed', 'test', '2019-03-16 03:24:07', '2019-03-16 15:09:22', '5c5b667156ce33.07558401', '', '', '', ''),
(21, 'Machine C', 'Room B', 'Closed', '', '2019-03-16 03:27:57', '2019-03-16 15:09:48', '', '', '', '', ''),
(22, 'Machine B', 'Room E', 'Closed', '', '2019-03-16 03:50:06', '2019-03-16 15:11:28', '5c5b667156ce33.07558401', '', '', '', ''),
(23, 'Machine B', 'Room B', 'Closed', '', '2019-03-16 03:52:02', '2019-03-13 16:17:39', '5c5b667156ce33.07558401', '', '', '', ''),
(24, 'Machine A', 'Room A', 'In Progress', '', '2019-03-16 03:52:31', '2019-02-20 05:00:00', '5c5b667156ce33.07558401', '', '', '', ''),
(25, 'NoT Test', '', 'In Progress', '', '2019-03-16 04:48:27', NULL, '5c5b667156ce33.07558401', '5c5b667156ce33.07558401', '', '', ''),
(26, '', '', 'Unassigned', '', '2019-03-16 04:48:28', NULL, '5c5b667156ce33.07558401', '5c5b66e53a8481.99245874', '', '', ''),
(27, '', 'Notty', 'Unassigned', '', '2019-03-16 04:48:28', NULL, '5c5b667156ce33.07558401', '5c5cedc31b4168.11530368', '', '', ''),
(28, '', 'Room C', 'In Progress', '', '2019-03-16 04:48:28', NULL, '5c5b667156ce33.07558401', '5c5cedc31b4168.11530368', '', '', ''),
(29, '', '', 'Unassigned', '', '2019-03-16 04:48:50', NULL, '5c5b667156ce33.07558401', '5c5b667156ce33.07558401', '', '', ''),
(30, 'Notty', '', 'Unassigned', '', '2019-03-16 04:48:50', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(31, '', '', 'Unassigned', '', '2019-03-16 04:48:51', NULL, '5c5b667156ce33.07558401', '5c5cedc31b4168.11530368', '', '', ''),
(32, '', '', 'Unassigned', '', '2019-03-16 04:48:51', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(33, '', '', 'Unassigned', '', '2019-03-16 04:48:51', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(34, 'Notty', '', 'Unassigned', '', '2019-03-16 04:48:51', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(35, '', '', 'Unassigned', '', '2019-03-20 04:48:51', '2019-03-21 04:00:00', '5c5b667156ce33.07558401', '', '', '', ''),
(36, '', '', 'Unassigned', '', '2019-01-01 05:48:52', '2019-03-24 04:00:00', '5c5b667156ce33.07558401', '', '', '', ''),
(37, '', '', 'Unassigned', '', '2019-03-16 04:48:52', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(38, '', '', 'Unassigned', '', '2019-03-16 04:48:52', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(39, '', '', 'Unassigned', '', '2019-03-16 04:49:04', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(40, '', '', 'Unassigned', '', '2019-03-16 04:49:05', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(41, '', '', 'Unassigned', '', '2019-03-16 04:49:05', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(42, '', '', 'Unassigned', '', '2019-03-16 04:49:05', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(43, 'test', 'test', 'Unassigned', 'test', '2019-03-16 04:49:08', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(44, 'test', 'test', 'Unassigned', 'test', '2019-03-16 04:49:08', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(45, 'test', 'test', 'Unassigned', 'test', '2019-03-16 04:49:09', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(46, '', '', 'Unassigned', '', '2019-03-16 04:49:55', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(47, '', '', 'Unassigned', '', '2019-03-16 04:52:06', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(48, '', '', 'Unassigned', '', '2019-03-16 04:56:35', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(49, '', '', 'Unassigned', '', '2019-03-16 05:03:49', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(50, '', '', 'Unassigned', '', '2019-03-16 05:27:13', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(51, '', '', 'Unassigned', '', '2019-03-16 05:28:01', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(52, '', '', 'Unassigned', '', '2019-03-16 05:28:38', NULL, '5c5b667156ce33.07558401', '', '', '', ''),
(53, 'New tick', 'new', 'Unassigned', '', '2019-03-25 20:09:25', NULL, '5c5b667156ce33.07558401', NULL, '', '', ''),
(54, 'new', 'new', 'Unassigned', 'new', '2019-03-25 20:09:57', NULL, '5c5b667156ce33.07558401', NULL, '', '', ''),
(55, 'new', 'new', 'Unassigned', 'new', '2019-03-25 20:10:36', NULL, '5c5b667156ce33.07558401', NULL, '', '', ''),
(56, 'xzd', 'jghg', 'Unassigned', 'jhg', '2019-03-25 20:12:00', NULL, '5c5b667156ce33.07558401', NULL, '', '', ''),
(57, 'new3', 'new3', 'Unassigned', '', '2019-03-25 20:42:34', NULL, '5c5b667156ce33.07558401', NULL, '', '', ''),
(58, 'a', 'a', 'Unassigned', 'a', '2019-03-25 22:14:04', NULL, '5c5b667156ce33.07558401', NULL, 'a', 'a', 'a'),
(59, 'a', 'a', 'Unassigned', 'a', '2019-03-25 22:14:25', NULL, '5c5b667156ce33.07558401', NULL, 'a', 'a', ''),
(60, 'b', 'b', 'Unassigned', 'b', '2019-03-25 22:15:03', NULL, '5c5b667156ce33.07558401', NULL, 'b', 'b', 'b'),
(61, 'c', 'c', 'Unassigned', 'c', '2019-03-25 22:15:13', NULL, '5c5b667156ce33.07558401', NULL, 'c', 'c', ''),
(62, 'testing new', 'testing new', 'Unassigned', 'This should appear first. Here is my problem', '2019-03-29 21:21:24', NULL, '5c5b667156ce33.07558401', NULL, 'hello', 'hello', 'This should appear second'),
(63, 'testing', 'testing', 'Unassigned', 'testing', '2019-03-29 22:46:47', NULL, '5c5b667156ce33.07558401', NULL, 'testing', 'testing', ''),
(64, 't', 't', 'Unassigned', 't', '2019-03-29 22:47:29', NULL, '5c5b667156ce33.07558401', NULL, 't', 't', 't'),
(65, 'Machine A', 'Room 324', 'Unassigned', 'This is the problem', '2019-03-29 23:07:43', NULL, '5c5b667156ce33.07558401', NULL, '123456', 'Bob', 'Misc comments here'),
(66, 'test', 'testq', 'Unassigned', 'test', '2019-03-29 23:10:20', NULL, '5c5b667156ce33.07558401', NULL, 'test', 'test', 'test'),
(67, 'test', 'test', 'Unassigned', 'test', '2019-03-29 23:11:32', NULL, '5c5b667156ce33.07558401', NULL, 'test', 'test', 'test'),
(68, 't', 't', 'Unassigned', 't', '2019-03-29 23:11:48', NULL, '5c5b667156ce33.07558401', NULL, 't', 't', 't'),
(69, 't', 't', 'Unassigned', 't', '2019-03-29 23:12:36', NULL, '5c5b667156ce33.07558401', NULL, 't', 't', 't'),
(70, 't', 't', 'Unassigned', 't', '2019-03-29 23:17:14', NULL, '5c5b667156ce33.07558401', NULL, 't', 't', 't'),
(71, 't', 't', 'Unassigned', 't', '2019-03-29 23:17:26', NULL, '5c5b667156ce33.07558401', NULL, 't', 't', 't'),
(72, 'test', 't', 'Unassigned', 't', '2019-03-30 16:16:06', NULL, '5c5b667156ce33.07558401', NULL, 't', 't', 't'),
(73, 't', 't', 'Unassigned', 't', '2019-03-31 05:34:33', NULL, '5c5b66e53a8481.99245874', NULL, 't', 't', ''),
(74, 't', 't', 'Unassigned', 't', '2019-04-01 16:45:40', NULL, '5c5b667156ce33.07558401', NULL, 't', 't', 't'),
(75, 'q', 'q', 'Unassigned', 'q', '2019-04-01 16:46:01', NULL, '5c5b667156ce33.07558401', NULL, 'q', 'q', 'q');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
