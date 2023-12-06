-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 06, 2023 at 03:08 PM
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
-- Database: `group2db`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE IF NOT EXISTS `class` (
  `class_id` int NOT NULL AUTO_INCREMENT,
  `classname` varchar(255) NOT NULL,
  `teacher_id` int DEFAULT NULL,
  `time_id` int DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  PRIMARY KEY (`class_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `subject_id` (`subject_id`),
  KEY `time_id` (`time_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `classname`, `teacher_id`, `time_id`, `subject_id`) VALUES
(1, 'Introduction to Astronomy', 1, 1, 1),
(2, 'Economics', 2, 2, 2),
(3, 'Creative Writing', 3, 3, 3),
(4, 'World History', 1, 4, 4),
(5, 'Literature', 4, 5, 5),
(6, 'Sub 1', 4, 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `datetimes`
--

DROP TABLE IF EXISTS `datetimes`;
CREATE TABLE IF NOT EXISTS `datetimes` (
  `time_id` int NOT NULL AUTO_INCREMENT,
  `classtime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  PRIMARY KEY (`time_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `datetimes`
--

INSERT INTO `datetimes` (`time_id`, `classtime`, `endtime`) VALUES
(1, '08:30:00', '09:30:00'),
(2, '09:30:00', '10:30:00'),
(3, '13:30:00', '14:30:00'),
(4, '15:30:00', '16:30:00'),
(5, '18:30:00', '19:30:00'),
(6, '19:30:00', '20:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `stud_id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `user_id` int NOT NULL,
  `ttable_id` int DEFAULT NULL,
  PRIMARY KEY (`stud_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`stud_id`, `firstname`, `lastname`, `gender`, `user_id`, `ttable_id`) VALUES
(1, 'Jonathan', 'Smith', 'Male', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `subject_id` int NOT NULL AUTO_INCREMENT,
  `subject_code` varchar(255) NOT NULL,
  `subject_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_name`) VALUES
(1, 'AST101', 'Introduction to Astronomy'),
(2, 'ECO201', 'Principles of Economics'),
(3, 'ENG301', 'Creative Writing Workshop'),
(4, 'HIS102', 'World History'),
(5, 'LIT202', 'Comparative Literature'),
(6, 'Sub Code', 'Sub 1');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `teacher_id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `user_id` int NOT NULL,
  `ttable_id` int DEFAULT NULL,
  PRIMARY KEY (`teacher_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `firstname`, `lastname`, `gender`, `user_id`, `ttable_id`) VALUES
(1, 'Richard', 'Parker', 'Male', 3, 0),
(2, 'Albert', 'Wesker', 'Male', 4, 0),
(3, 'Jonathan', 'Joestar', 'Male', 5, NULL),
(4, 'Joe', 'Mama', 'Male', 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `timetableid`
--

DROP TABLE IF EXISTS `timetableid`;
CREATE TABLE IF NOT EXISTS `timetableid` (
  `ttable_id` int NOT NULL AUTO_INCREMENT,
  `tablename` varchar(255) NOT NULL,
  PRIMARY KEY (`ttable_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `timetableid`
--

INSERT INTO `timetableid` (`ttable_id`, `tablename`) VALUES
(2, 'Timetable 2'),
(1, 'Timetable 1');

-- --------------------------------------------------------

--
-- Table structure for table `usercredentials`
--

DROP TABLE IF EXISTS `usercredentials`;
CREATE TABLE IF NOT EXISTS `usercredentials` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `user_type` enum('student','faculty','sysadmin') NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usercredentials`
--

INSERT INTO `usercredentials` (`user_id`, `user_name`, `pwd`, `user_type`) VALUES
(1, 'admin', 'admin', 'sysadmin'),
(3, 'Richard69420', 'july92003', 'faculty'),
(2, 'John', 'april1945', 'student'),
(4, 'Albert5610', '123456789', 'faculty'),
(6, 'Joe', 'july92003', 'faculty'),
(5, 'Jonathan', '1234567890', 'faculty');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
