-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2025 at 04:02 AM
-- Server version: 10.5.27-MariaDB-log
-- PHP Version: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s2300587_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `password`, `first_name`, `middle_name`, `last_name`) VALUES
(6565847244, '$2y$10$lroBqipJs2V2MWCdhbA8huCXMyilY/yQdahitio82NPuVi7r8tfT.', 'mark gabriel', 'geraldoy', 'cantos');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `middleName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `community_role` varchar(255) NOT NULL,
  `skills_interest` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstName`, `middleName`, `lastName`, `dob`, `email_address`, `password`, `phone_number`, `city`, `barangay`, `gender`, `community_role`, `skills_interest`) VALUES
(1, 'mark', 'gabriel g', 'cantos', '2025-03-13', 'Gabcantoss99@gmail.com', '$2y$10$.eO1fqztJveE5Rh.3SrUVOQ0hOl.53U17gcGhLfSK7Qhegd/2rg5e', '2147483647', 'Bacolod City', 'Mandalagan', 'male', 'volunteer', 'red cross'),
(2, 'mark', 'gabriel g', 'cantos', '1997-06-28', 'Gabcantoss99@gmail.com', '$2y$10$9HaJ7coMK8QB2XA0iZ4qa.bOGdhUfdisOCdEbNpM3r3f2wGv7x3WS', '9770757049', 'Bacolod City', 'Mandalagan', 'male', 'coordinator', 'medical'),
(3, 'mark', 'gabriel g', 'cantos', '2025-03-27', 'Gabcantoss99@gmail.com', '$2y$10$0mX58FTcB8Qtt226dFF9geXx1jfXe323e92UrG63Bh.phKxFnTiO6', '9770757049', 'Bacolod City', 'Mandalagan', 'male', 'volunteer', 'fbfbfb'),
(4, 'mark', 'gabriel g', 'cantos', '2025-03-20', '', '', '', '', '', '', '', ''),
(5, 'leonardo', 'viktur', 'valverde', '2000-06-24', '', '', '', '', '', '', '', ''),
(6, 'mark', 'gabriel g', 'cantos', '2025-03-04', '', '', '', '', '', '', '', ''),
(7, 'mark', 'gabriel g', 'cantos', '2025-03-26', '', '', '', '', '', '', '', ''),
(8, 'leonardo', 'viktur', 'valverde', '2025-02-28', '', '', '', '', '', '', '', ''),
(9, 'mark', 'gabriel g', 'cantos', '2025-03-26', '', '', '', '', '', '', '', ''),
(10, '', '', '', '0000-00-00', 'Gabcantoss99@gmail.com', '$2y$10$psIJd7K.CZepLBZEZl901OPo5YQaD.LxXcPHEVUBEDeb/2qO4Sgyi', '', '', '', 'male', '', ''),
(11, '', '', '', '0000-00-00', 'Gabcantoss99@gmail.com', '$2y$10$0MGINONDO2QTjSn/Pf6QIO7w2aKThcscsk2bgAHZPeRCdWKX.gB6u', '', '', '', 'male', '', ''),
(12, 'mark', 'gabriel g', 'cantos', '2025-03-10', 'Gabcantoss99@gmail.com', '$2y$10$bKNBGH9wINiNlYkwTab2/ujepBTy/H9KsddD53DRw3jBnLgvc1MTa', '9770757049', 'bacolod city', 'Taculing', 'male', 'volunteer', 'medical'),
(13, 'mark', 'gabriel g', 'cantos', '2025-03-05', 'mhen@gmail.com', '$2y$10$JmqVVmKir3f0Y4OpWEDjOOrYpNxTCVX3bejlT03Pqa559rfxWVEUK', '9770757049', 'Bacolod City', 'Bata', 'male', 'volunteer', 'medical'),
(14, 'mark', 'gabriel g', 'cantos', '2025-03-05', 'port@gmail.com', '$2y$10$IzHXkvH20tSxGQkO58dp2OGcXdCsSE9UqdHvKdF.82sCoO6ZOqQzm', '9770757049', 'Bacolod City', 'Bata', 'male', 'volunteer', 'medical'),
(15, 'mark', 'gabriel g', 'cantos', '2025-03-02', 'wow@yahoo.com', '$2y$10$l/6IMTcP8WpMqMFWbBXfYOS894sqUtdLdTHA0cPqvhRBhRDtoTLxy', '9770757049', 'Bacolod City', 'Mandalagan', 'male', 'resident', 'fbfbfb'),
(16, 'juan', 'gil', 'pedro', '2025-02-25', 'juan@gmail.com', '$2y$10$yzMulgzKrm0S5IHtvbilmOTkbuwR5lZj6gQAJ22osQ5dCzpCdzKMi', '9770757049', 'Bacolod City', 'Mandalagan', 'male', 'volunteer', 'red cross'),
(17, 'mark', 'gabriel g', 'cantos', '2025-03-03', 'example@gmail.com', '$2y$10$Jr3px6W8zdRJANY0c1e1u.gYmugTUPRBdUh2Pa8nk3z55J1BLpFGa', '9770757049', 'Bacolod City', 'Granada', 'male', 'volunteer', 'medical'),
(18, 'mark', 'gabriel g', 'cantos', '2025-03-11', 'qwerty@gmail.com', '$2y$10$Q8ShV3mbnAfG3gbBm/9mQuubB.rjuW/1GJuON0374HJvQ1E8zNj6a', '9770757049', 'Bacolod City', 'Bata', 'male', 'volunteer', 'medical');

-- --------------------------------------------------------

--
-- Table structure for table `user_report`
--

CREATE TABLE `user_report` (
  `Report_Id` int(11) NOT NULL,
  `Disaster_Type` varchar(100) NOT NULL,
  `Location` varchar(100) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `Name_of_Reporter` varchar(50) NOT NULL,
  `Contact_Number` varchar(11) NOT NULL,
  `Date_Reported` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_report`
--

INSERT INTO `user_report` (`Report_Id`, `Disaster_Type`, `Location`, `Description`, `Name_of_Reporter`, `Contact_Number`, `Date_Reported`) VALUES
(1, 'Landslide', 'Banago', 'Hahahah', 'Pao', '09484813580', '2025-03-30'),
(2, 'Fire', 'Silay', 'May Sunog', 'Mark', '09484813580', '2025-03-30'),
(3, 'Fire', 'Silay', 'May Sunog', 'Mark', '09484813580', '2025-03-30'),
(4, 'Flood', 'Talisay', 'Dadsad', 'Adrian', '0009999', '2025-03-30'),
(5, 'Medical', 'MANDALAGAN', 'May Bali', 'Khirk', '09484813580', '2025-03-31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_report`
--
ALTER TABLE `user_report`
  ADD PRIMARY KEY (`Report_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6565847245;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_report`
--
ALTER TABLE `user_report`
  MODIFY `Report_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
