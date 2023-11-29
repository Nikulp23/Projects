-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 16, 2023 at 05:49 PM
-- Server version: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `team`
--

-- --------------------------------------------------------

--
-- Table structure for table `weekly_plan`
--

CREATE TABLE `weekly_plan` (
  `username` varchar(25) NOT NULL,
  `day` varchar(25) NOT NULL,
  `type` varchar(25) NOT NULL,
  `exercise` varchar(25) NOT NULL,
  `duration_reps` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weekly_plan`
--

INSERT INTO `weekly_plan` (`username`, `day`, `type`, `exercise`, `duration_reps`) VALUES
('test_pla', 'Monday', 'Lose Weight', 'Brisk Walk', '1 x 30'),
('test_pla', 'Tuesday', 'Lose Weight', 'Cycling', '1 x 30'),
('test_pla', 'Wednesday', 'Lose Weight', 'Swimming', '1 x 30'),
('test_pla', 'Thursday', 'Lose Weight', 'Brisk Walk', '1 x 30'),
('test_pla', 'Friday', 'Lose Weight', 'Cycling', '1 x 30'),
('test_pla', 'Saturday', 'Lose Weight', 'Swimming', '1 x 30'),
('test_pla', 'Sunday', 'Lose Weight', 'Rest', '0 x 0');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
