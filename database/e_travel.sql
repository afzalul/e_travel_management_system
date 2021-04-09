-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2021 at 04:18 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`) VALUES
(1, 'Afzalul Alam', 'afzalul_alam', 'baT1ogwytou8.'),
(2, 'Afzalul Alam', 'ashraf', 'baT1ogwytou8.'),
(3, 'xx', 'xx', 'baRNTHqW8BeeQ'),
(4, 'vv', 'vv', 'baRNTHqW8BeeQ');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `schedule_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `schedule_id`) VALUES
(51, 5, 4),
(52, 5, 3),
(53, 5, 5),
(54, 1, 4),
(56, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `bus_info`
--

CREATE TABLE `bus_info` (
  `id` int(10) NOT NULL,
  `number` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `company` varchar(30) NOT NULL,
  `admin_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bus_info`
--

INSERT INTO `bus_info` (`id`, `number`, `type`, `company`, `admin_id`) VALUES
(1, 'CHI-1234', 'AC', 'Hanif', 1),
(2, 'CHI-2233', 'AC', 'Unique', 1),
(3, 'CHI-9293', 'AC', 'CUET', 1),
(4, 'CHI-6563', 'NON-AC', 'Unique', 1),
(6, 'DHA-1122', 'AC', 'Hanif', 1);

-- --------------------------------------------------------

--
-- Table structure for table `daily_schedule`
--

CREATE TABLE `daily_schedule` (
  `id` int(10) NOT NULL,
  `bus_id` int(10) NOT NULL,
  `route` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL,
  `time` varchar(30) NOT NULL,
  `total_seat_available` int(2) NOT NULL,
  `admin_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daily_schedule`
--

INSERT INTO `daily_schedule` (`id`, `bus_id`, `route`, `date`, `time`, `total_seat_available`, `admin_id`) VALUES
(3, 2, 'Dhaka-Chittagong', '2021-04-20', '2:00PM', 38, 1),
(4, 3, 'Dhaka-Chittagong', '2021-04-20', '11:00AM', 38, 1),
(5, 4, 'Dhaka-Chittagong', '2021-04-20', '12:30PM', 39, 1);

-- --------------------------------------------------------

--
-- Table structure for table `driver_info`
--

CREATE TABLE `driver_info` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `experiance` int(2) NOT NULL,
  `admin_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `driver_info`
--

INSERT INTO `driver_info` (`id`, `name`, `company`, `experiance`, `admin_id`) VALUES
(1, 'Afzalul Alam', 'Unique', 10, 1),
(2, 'Joynal Sheikh afzal', 'Unique', 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile_no` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `name`, `mobile_no`, `message`, `date`) VALUES
(5, 'Afzalul Alam', '01427479657', 'good system', '21.04.02 10:39:58 AM'),
(7, 'xx', '01427449653', 'xxxxxxxx', '21.04.03 11:04:04 PM'),
(10, 'Hasina Akterff', '01427479657', 'dddddddddd', '21.04.06 10:00:53 AM'),
(13, 'Hasina Akterff', '01427479657', 'uuuuuuuu', '21.04.09 08:08:35 PM');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_no` varchar(13) NOT NULL,
  `account_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `username`, `password`, `mobile_no`, `account_status`) VALUES
(1, 'Afzalul Alam', 'afzal', 'baT1ogwytou8.', '01527449653', 1),
(2, 'ashraful alam', 'ashraf', 'baT1ogwytou8.', '01627449653', 1),
(3, 'Mushfiqur Rahim', 'sakib', 'badDr97Or40Ac', '01334640913', 1),
(4, 'ashraful alam', 'roni', 'badDr97Or40Ac', '01427449653', 1),
(5, 'Mashrafe Bin Mortaza', 'mash', 'badDr97Or40Ac', '01334640918', 1),
(8, 'ashraful alam', 'aaaa', 'baRNTHqW8BeeQ', '01727449653', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE `user_notification` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `status` int(1) NOT NULL,
  `Message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_notification`
--

INSERT INTO `user_notification` (`id`, `user_id`, `status`, `Message`) VALUES
(94, 1, 0, 'You Have Booked a Seat in <br>Bus Number=CHI-9293<br>Route=Dhaka-Chittagong<br>Date=2021-04-20<br>Time=11:00AM<br><b><i>Booking date and time = 21.04.08 11:37:33 PM</i></b>'),
(95, 1, 0, 'You Have Booked a Seat in <br>Bus Number=CHI-2233<br>Route=Dhaka-Chittagong<br>Date=2021-04-20<br>Time=2:00PM<br><b><i>Booking date and time = 21.04.08 11:37:45 PM</i></b>'),
(96, 5, 0, 'You Have Booked a Seat in <br>Bus Number=CHI-9293<br>Route=Dhaka-Chittagong<br>Date=2021-04-20<br>Time=11:00AM<br><b><i>Booking date and time = 21.04.08 12:07:27 AM</i></b>'),
(97, 5, 0, 'You Have Booked a Seat in <br>Bus Number=CHI-2233<br>Route=Dhaka-Chittagong<br>Date=2021-04-20<br>Time=2:00PM<br><b><i>Booking date and time = 21.04.08 12:07:35 AM</i></b>'),
(98, 5, 0, 'You Have Booked a Seat in <br>Bus Number=CHI-6563<br>Route=Dhaka-Chittagong<br>Date=2021-04-20<br>Time=12:30PM<br><b><i>Booking date and time = 21.04.08 12:07:57 AM</i></b>'),
(99, 1, 0, 'You Have Booked a Seat in <br>Bus Number=CHI-9293<br>Route=Dhaka-Chittagong<br>Date=2021-04-20<br>Time=11:00AM<br><b><i>Booking date and time = 21.04.09 11:27:51 AM</i></b>'),
(100, 1, 0, 'You Have Booked a Seat in <br>Bus Number=CHI-2233<br>Route=Dhaka-Chittagong<br>Date=2021-04-20<br>Time=2:00PM<br><b><i>Booking date and time = 21.04.09 11:28:02 AM</i></b>'),
(104, 1, 0, 'You Have Searched Into driver_info For Keyward=joy<br>Search date and time = 21.04.09 08:00:21 PM'),
(105, 1, 0, 'You Have Booked a Seat in <br>Bus Number=CHI-2233<br>Route=Dhaka-Chittagong<br>Date=2021-04-20<br>Time=2:00PM<br><b><i>Booking date and time = 21.04.09 08:07:49 PM</i></b>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `bus_info`
--
ALTER TABLE `bus_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_schedule`
--
ALTER TABLE `daily_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_info`
--
ALTER TABLE `driver_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `bus_info`
--
ALTER TABLE `bus_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `daily_schedule`
--
ALTER TABLE `daily_schedule`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `driver_info`
--
ALTER TABLE `driver_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_notification`
--
ALTER TABLE `user_notification`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
