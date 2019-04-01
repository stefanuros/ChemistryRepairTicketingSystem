-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2019 at 07:15 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
