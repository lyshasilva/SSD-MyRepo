-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2024 at 05:33 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ssdsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `action_plan`
--

CREATE TABLE `action_plan` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `ap_description` text NOT NULL,
  `goal` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `archived` int(1) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `action_plan`
--

INSERT INTO `action_plan` (`id`, `title`, `ap_description`, `goal`, `department`, `budget`, `user_id`, `archived`, `created_at`) VALUES
(1, 'Conduct seminars within Davao Region', 'This AP belongs to the goal \"Sabbath School Goal 2021\".', 1, 'Sabbath School', 100000.00, 1, NULL, '2024-08-02 10:33:32'),
(2, 'Seminars within Region 12', 'Another Action Plan for 2021', 1, 'Sabbath School', 200000.00, 1, NULL, '2024-08-02 10:39:00'),
(3, 'SSD-Wide SS Congress', 'SS Congress to be held in MVC', 3, 'Sabbath School', 2000000.00, 1, NULL, '2024-08-02 10:59:26'),
(4, 'IAD-Wide SS Congress', 'SS Congress to be held in Mexico', 3, 'Sabbath School', 1000000.00, 1, NULL, '2024-08-02 11:04:03'),
(5, 'SSD-Wide Camping', 'To be held in SPAC', 4, 'Sabbath School', 50000.00, 2, NULL, '2024-08-02 11:12:04'),
(6, 'Giving educational aid to IT students', 'Deserving IT students from SSD will be given educational aid', 5, 'IT', 54000.00, 4, NULL, '2024-08-02 11:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `goal`
--

CREATE TABLE `goal` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `targets` varchar(255) NOT NULL,
  `target_value` int(11) NOT NULL,
  `total_budget` decimal(10,2) NOT NULL DEFAULT 0.00,
  `initiative` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `archived` int(1) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `goal`
--

INSERT INTO `goal` (`id`, `title`, `year`, `department`, `targets`, `target_value`, `total_budget`, `initiative`, `user_id`, `archived`, `created_at`) VALUES
(1, 'Sabbath School Goal 2021', 2021, 'Sabbath School', 'Seminars', 3, 300000.00, 'KPI 2.2', 1, NULL, '2024-08-02 10:24:02'),
(2, 'Sabbath School Goal 2023', 2023, 'Sabbath School', 'Worshops', 10, 0.00, 'KPI 1.4', 1, NULL, '2024-08-02 10:26:44'),
(3, 'Sabbath School Goal 2024 by User 1', 2024, 'Sabbath School', 'Division-Wide Congress', 3, 3000000.00, 'KPI 2.5', 1, NULL, '2024-08-02 10:57:49'),
(4, 'SS Goal 2024 created by User 2', 2024, 'Sabbath School', 'Division-Wide Campings', 8, 50000.00, 'KPI 2.2', 2, NULL, '2024-08-02 11:09:49'),
(5, 'Previous IT Goal 2022', 2022, 'IT', 'Sponsorship to IT students in every division', 13, 54000.00, 'KPI 3.3', 4, NULL, '2024-08-02 11:22:06');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(4) UNSIGNED NOT NULL,
  `username` varchar(25) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `middle_name` varchar(25) DEFAULT NULL,
  `suffix` varchar(5) DEFAULT NULL,
  `department` enum('Sabbath School','IT','','') NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `surname`, `first_name`, `middle_name`, `suffix`, `department`, `password`) VALUES
(1, 'lyshasilva', 'Silva', 'Lysha', 'Tolentino', NULL, 'Sabbath School', 'pass1234'),
(2, 'prinzj', 'Magallamento', 'Prinz Juancho', 'L', NULL, 'Sabbath School', 'pass5678'),
(3, 'leonivereloy', 'Eloy', 'Leoniver', NULL, NULL, 'IT', 'pass2'),
(4, 'amielopena', 'Opena', 'Amiel', NULL, NULL, 'IT', 'pass1'),
(5, 'mahalahj', 'Ismael', 'Mahalah Joy', NULL, NULL, 'Sabbath School', 'pass3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action_plan`
--
ALTER TABLE `action_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goal`
--
ALTER TABLE `goal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action_plan`
--
ALTER TABLE `action_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `goal`
--
ALTER TABLE `goal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
