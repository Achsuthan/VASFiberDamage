-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 29, 2017 at 09:09 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Fiber`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_id` varchar(15) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_id`, `firstname`, `lastname`, `email`, `phone`, `address`, `username`, `password`) VALUES
(1, 'AD111111', 'Achsuthan', 'Mahendran', 'achsuthan@icloud.com', '94774455878', 'Colombo', 'Admin123', 'Admin123'),
(2, 'AD111112', 'Waruna ', 'Madhusanka', 'waruna.madhusanka@dialog.lk', '0773337006', 'dialog', 'waruna', 'waruna123');

-- --------------------------------------------------------

--
-- Table structure for table `damage`
--

CREATE TABLE `damage` (
  `id` int(11) NOT NULL,
  `dam_id` varchar(100) NOT NULL,
  `pic_path` varchar(10000) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `lat` varchar(100) NOT NULL,
  `lng` varchar(100) NOT NULL,
  `user_id` varchar(15) NOT NULL,
  `date` varchar(35) NOT NULL,
  `time` varchar(20) NOT NULL,
  `current_status` varchar(10) NOT NULL,
  `wip_date` varchar(10) NOT NULL,
  `wip_comment` varchar(10000) NOT NULL,
  `completed_date` varchar(10) NOT NULL,
  `completed_comment` varchar(10000) NOT NULL,
  `delete_comment` mediumtext NOT NULL,
  `delete_date` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `damage`
--

INSERT INTO `damage` (`id`, `dam_id`, `pic_path`, `comment`, `lat`, `lng`, `user_id`, `date`, `time`, `current_status`, `wip_date`, `wip_comment`, `completed_date`, `completed_comment`, `delete_comment`, `delete_date`) VALUES
(8, 'PIR170906100', 'http://localhost/fib/uploads/0774455878/46148311780306859.png', 'Test', '6.918774264810454', '79.86270253024945', '0774455878', '2017-09-07', '11:32:47am', 'Complete', '2017-09-11', 'wi[', '2017-09-11', 'This is completed hee', '', ''),
(9, 'PIR170907000', 'http://localhost/fib/uploads/0774455878/67732801420927954.png', '', '6.918830506630439', '79.86269476451191', '0774455878', '2017-09-07', '11:37:38am', 'Delete', '2017-09-11', '', '', '', '', ''),
(10, 'PIR170907001', 'http://localhost/fib/uploads/0774455878/63373948415504681.png', '', '6.918795003088055', '79.86260419910101', '0774455878', '2017-09-07', '11:37:55am', 'Completed', '2017-09-11', 'This is the comment for PIR170906101', '2017-09-11', 'This is completed comment for PIR170907001', '', ''),
(11, 'PIR170907002', 'http://localhost/fib/uploads/0774455878/78962338169234065.png', '', '6.918776134924022', '79.86270669394413', '0774455878', '2017-09-07', '11:38:32am', 'Complete', '', '', '', '', '', ''),
(12, 'PIR170907003', 'http://localhost/fib/uploads/0774455878/28889835129346977.png', '', '6.918773945048665', '79.86271140394804', '0774455878', '2017-09-07', '11:38:56am', 'Complete', '2017-09-10', 'WIP ldkjfdfdl', '2017-09-10', 'ldfjlkdfjldfjlkdfldjlkd', '', ''),
(13, 'PIR170907004', 'http://localhost/fib/uploads/0774455878/71994815514073755.png', '', '6.918755974627024', '79.86273611903178', '0774455878', '2017-09-07', '11:40:08am', 'NEW', '', '', '', '', '', ''),
(14, 'PIR170907005', 'http://localhost/fib/uploads/0774455878/85548963069419197.png', 'dfjkjdfjdfjljdljdl', '6.918792513475511', '79.86271290192866', '0774455878', '2017-09-07', '02:01:02pm', 'NEW', '', '', '', '', '', ''),
(15, 'PIR170907006', 'http://localhost/fib/uploads/0774455878/96138352850747328.png', 'Hshshs', '6.91861190099159', '79.86229260962807', '0774455878', '2017-09-07', '03:49:14pm', 'NEW', '', '', '', '', '', ''),
(16, 'PIR170909000', 'http://localhost/fib/uploads/0774455878/46148311780306859.png', 'Test', '6.918774264810454', '79.86270253024945', '0774455878', '2017-09-07', '11:32:47am', 'Complete', '', '', '2017-09-10', 'ldfjkdfjd', '', ''),
(17, 'PIR170911000', 'http://localhost/fib/uploads/0774455878/23495510086345396.png', 'First test', '6.918774620045022', '79.86272082937106', '0774455878', '2017-09-11', '09:55:30am', 'NEW', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tech`
--

CREATE TABLE `tech` (
  `id` int(11) NOT NULL,
  `tec_id` varchar(15) NOT NULL,
  `firstname` varchar(1000) NOT NULL,
  `lastname` varchar(1000) NOT NULL,
  `username` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `phone` varchar(1000) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `address` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tech`
--

INSERT INTO `tech` (`id`, `tec_id`, `firstname`, `lastname`, `username`, `password`, `phone`, `email`, `address`) VALUES
(2, 'TEC111111', 'Achsuthan', 'Mahendran', 'Achsuthan', 'achsuthan', '+94774455878', 'achsuthan@icloud.com', 'Colombo');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `otp` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `phone`, `otp`) VALUES
(1, '0774455878', ''),
(2, 'djf', '9515');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_id` (`admin_id`);

--
-- Indexes for table `damage`
--
ALTER TABLE `damage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dam_id` (`dam_id`),
  ADD KEY `lat` (`lat`),
  ADD KEY `lat_2` (`lat`),
  ADD KEY `lat_3` (`lat`);

--
-- Indexes for table `tech`
--
ALTER TABLE `tech`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_id` (`tec_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `damage`
--
ALTER TABLE `damage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tech`
--
ALTER TABLE `tech`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
