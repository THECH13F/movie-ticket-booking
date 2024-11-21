-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 06:15 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `booking_user` int(11) NOT NULL,
  `booking_show` int(11) NOT NULL,
  `silver_seat_no` text,
  `payment` varchar(20) NOT NULL,
  `gold_seat_no` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `booking_user`, `booking_show`, `silver_seat_no`, `payment`, `gold_seat_no`) VALUES
(1, 1, 1, 'C4,C3', '5678', '');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `movie_name` varchar(30) NOT NULL,
  `movie_image` varchar(255) NOT NULL,
  `movie_description` varchar(50) DEFAULT NULL,
  `movie_category` varchar(30) NOT NULL,
  `movie_seats` int(3) NOT NULL,
  `movie_price` int(5) NOT NULL,
  `movie_vote` int(15) NOT NULL DEFAULT '0',
  `movie_ratings` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `movie_name`, `movie_image`, `movie_description`, `movie_category`, `movie_seats`, `movie_price`, `movie_vote`, `movie_ratings`) VALUES
(1, 'LEO', '../uploads/movie1.jpg', NULL, 'Action/Drama', 100, 120, 1200, 8),
(2, 'HERA PHERI', '../uploads/movie2.jpg', NULL, 'Action/Drama/comdey', 200, 150, 1000, 10),
(4, 'kill', '../uploads/unnamed.jpg', NULL, 'action/love', 200, 150, 1000, 9);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--
-- Error reading structure for table movie_booking.seats: #1932 - Table 'movie_booking.seats' doesn't exist in engine
-- Error reading data for table movie_booking.seats: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `movie_booking`.`seats`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shows`
--

CREATE TABLE `tbl_shows` (
  `show_id` int(11) NOT NULL,
  `theater_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `gold_row` char(2) NOT NULL,
  `gold_col` int(11) NOT NULL,
  `gold_price` int(11) NOT NULL,
  `silver_row` char(2) NOT NULL,
  `silver_col` int(11) NOT NULL,
  `silver_price` int(11) NOT NULL,
  `silver_booked` text,
  `gold_booked` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_shows`
--

INSERT INTO `tbl_shows` (`show_id`, `theater_id`, `movie_id`, `time`, `date`, `gold_row`, `gold_col`, `gold_price`, `silver_row`, `silver_col`, `silver_price`, `silver_booked`, `gold_booked`) VALUES
(1, 1, 1, '12:00:00', '2024-11-08', 'AC', 3, 300, 'AF', 6, 200, ',C4,C3', ','),
(2, 1, 4, '18:00:00', '2024-11-08', 'AC', 3, 300, 'AF', 6, 200, '', ''),
(3, 2, 1, '18:00:00', '2024-11-08', 'AC', 3, 300, 'AF', 6, 200, '', ''),
(4, 1, 1, '20:00:00', '2024-11-09', 'AC', 3, 300, 'AF', 6, 200, '', ''),
(5, 2, 1, '12:00:00', '2024-11-08', 'AC', 3, 300, 'AF', 6, 200, '', ''),
(6, 1, 2, '18:00:00', '2024-11-09', 'AC', 10, 350, 'AE', 16, 200, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `theater`
--

CREATE TABLE `theater` (
  `theater_id` int(10) NOT NULL,
  `theater_name` varchar(50) NOT NULL,
  `theater_location` varchar(100) NOT NULL,
  `Cancellation` varchar(5) NOT NULL,
  `Food_Beverage` varchar(5) NOT NULL,
  `M_Ticket` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `theater`
--

INSERT INTO `theater` (`theater_id`, `theater_name`, `theater_location`, `Cancellation`, `Food_Beverage`, `M_Ticket`) VALUES
(1, 'Movietime Cubic Mall', 'Chembur', 'true', 'true', 'false'),
(2, 'MovieMax', 'Sion', 'true', 'false', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(5) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_phone` varchar(12) DEFAULT NULL,
  `user_type` enum('admin','user','theatre') NOT NULL DEFAULT 'user',
  `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_phone`, `user_type`, `creation_time`) VALUES
(1, 'admin', 'admin@admin.com', '0192023a7bbd73250516f069df18b500', '1234567890', 'admin', '2024-10-16 18:20:52'),
(2, 'hardik', 'hardik@admin.com', '8e55ecef6a2e2b363e7f56fe00d6cd64', '1234567890', 'admin', '2024-10-16 18:22:17'),
(3, 'test', 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', NULL, 'user', '2024-10-17 20:56:02'),
(4, 'test1', 'test123@gmail.com', 'cc03e747a6afbbcbf8be7668acfebee5', NULL, 'user', '2024-11-17 15:58:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user` (`booking_user`),
  ADD KEY `show` (`booking_show`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `tbl_shows`
--
ALTER TABLE `tbl_shows`
  ADD PRIMARY KEY (`show_id`),
  ADD KEY `theater` (`theater_id`),
  ADD KEY `movies` (`movie_id`);

--
-- Indexes for table `theater`
--
ALTER TABLE `theater`
  ADD PRIMARY KEY (`theater_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_shows`
--
ALTER TABLE `tbl_shows`
  MODIFY `show_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `theater`
--
ALTER TABLE `theater`
  MODIFY `theater_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `show` FOREIGN KEY (`booking_show`) REFERENCES `tbl_shows` (`show_id`),
  ADD CONSTRAINT `user` FOREIGN KEY (`booking_user`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `tbl_shows`
--
ALTER TABLE `tbl_shows`
  ADD CONSTRAINT `movies` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`),
  ADD CONSTRAINT `theater` FOREIGN KEY (`theater_id`) REFERENCES `theater` (`theater_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
