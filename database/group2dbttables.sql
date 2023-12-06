-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 06, 2023 at 03:09 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `group2dbttables`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_1`
--

DROP TABLE IF EXISTS `table_1`;
CREATE TABLE IF NOT EXISTS `table_1` (
  `class_id` int DEFAULT NULL,
  `classname` varchar(255) DEFAULT NULL,
  `teacher_id` int DEFAULT NULL,
  `time_id` int DEFAULT NULL,
  `subject_id` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `table_1`
--

INSERT INTO `table_1` (`class_id`, `classname`, `teacher_id`, `time_id`, `subject_id`) VALUES
(1, 'Introduction to Astronomy', 1, 1, 1),
(2, 'Economics', 2, 2, 2),
(4, 'World History', 1, 4, 4),
(5, 'Literature', 4, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `table_2`
--

DROP TABLE IF EXISTS `table_2`;
CREATE TABLE IF NOT EXISTS `table_2` (
  `class_id` int DEFAULT NULL,
  `classname` varchar(255) DEFAULT NULL,
  `teacher_id` int DEFAULT NULL,
  `time_id` int DEFAULT NULL,
  `subject_id` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `table_2`
--

INSERT INTO `table_2` (`class_id`, `classname`, `teacher_id`, `time_id`, `subject_id`) VALUES
(6, 'Sub 1', 4, 6, 6);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
