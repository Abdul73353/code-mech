-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2024 at 09:00 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `breakdown`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE IF NOT EXISTS `adminlogin` (
`aid` int(11) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `pwd` varchar(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`aid`, `uname`, `pwd`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE IF NOT EXISTS `area` (
`areaid` int(11) NOT NULL,
  `acode` varchar(7) NOT NULL,
  `aname` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`areaid`, `acode`, `aname`) VALUES
(1, 'A01', 'Mahalingapuram'),
(2, 'A02', 'Market Road'),
(3, 'A03', 'New Scheme Road'),
(4, 'A04', 'Aachipatti'),
(6, 'A05', 'Pollachi'),
(8, 'A06', 'Kovilpalayam'),
(10, 'L0023', 'COVAI');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
`fno` int(11) NOT NULL,
  `fdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `regno` int(11) NOT NULL,
  `feedback` varchar(500) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`fno`, `fdate`, `regno`, `feedback`) VALUES
(5, '2024-08-16 12:31:06', 11, 'Thank you. Good service');

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE IF NOT EXISTS `hospital` (
`hspt_id` int(11) NOT NULL,
  `hspt_code` varchar(100) NOT NULL,
  `aname` varchar(100) NOT NULL,
  `acode` varchar(100) NOT NULL,
  `doc_name` varchar(100) NOT NULL,
  `hspt_name` varchar(100) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `land` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`hspt_id`, `hspt_code`, `aname`, `acode`, `doc_name`, `hspt_name`, `addr`, `city`, `land`, `contact`, `email`) VALUES
(6, 'H001', 'Mahalingapuram', 'A01', 'Ravichandran', 'ravi child care', 'Radhakrishnan street', 'coimbatore', 'near rvs hotel', '9874563214', 'ravichildcare@gmail.com'),
(8, 'H002', '', 'A03', 'Ram', 'Radha Hospital', 'Ram nagar', 'Coimbatore', 'Near tea shop', '9632587412', 'ram@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE IF NOT EXISTS `hotel` (
`hot_id` int(11) NOT NULL,
  `hot_code` varchar(100) NOT NULL,
  `aname` varchar(100) NOT NULL,
  `acode` varchar(100) NOT NULL,
  `hot_name` varchar(100) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `land` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`hot_id`, `hot_code`, `aname`, `acode`, `hot_name`, `addr`, `city`, `land`, `contact`, `email`) VALUES
(1, 'HO001', 'New Scheme Road', 'A02', 'Mangala', 'Ram Nagar', 'Coimbatore', 'Near Philips', '9632587412', 'managala4@gmail.com'),
(2, 'HO221', 'Pollachi', 'A07', 'RR Restaurant', 'Ganga street', 'coimbatore', 'Near planet auditorium', '9637412587', 'rr@gmail.com'),
(4, 'HO004', '', 'A04', 'Appuchi Hotel', 'Gandhi nagar', 'Coimbatore', 'Near Banayan tree', '9874563152', 'appuchi@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `mechanic`
--

CREATE TABLE IF NOT EXISTS `mechanic` (
`mech_id` int(11) NOT NULL,
  `mech_code` varchar(100) NOT NULL,
  `acode` varchar(100) NOT NULL,
  `mech_name` varchar(100) NOT NULL,
  `wrk_name` varchar(100) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `land` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `mechanic`
--

INSERT INTO `mechanic` (`mech_id`, `mech_code`, `acode`, `mech_name`, `wrk_name`, `addr`, `City`, `land`, `contact`, `email`) VALUES
(13, 'M004', 'A03', 'Hari', 'Harish workshop', 'Radha street', 'Coimbatore', 'opp to rajesh hotel', '9632587413', 'hari@gmail.com'),
(14, 'M006', 'A07', 'Karthi', 'AK services', 'Radha street', 'Coimbatore', 'near velu lodge', '8563214789', 'karthi@gmail.com'),
(15, 'M005', 'A02', 'Ravi', 'Ravi Spares', 'Radha street', 'Coimbatore', 'Near tea shop', '9632587413', 'ravi@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE IF NOT EXISTS `register` (
`regno` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `acode` varchar(7) NOT NULL,
  `addr` varchar(50) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `pwd` varchar(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`regno`, `name`, `acode`, `addr`, `contact`, `email`, `uname`, `pwd`) VALUES
(8, 'naveen', 'A03', 'pollachi', '9632587410', 'naveen@gmail.com', 'naveen', 'naveen'),
(9, 'Praveen', 'A06', 'jeeva nagar', '9873214560', 'praveen@gmail.com', 'praveen', 'praveen'),
(10, 'pavi', 'A04', 'vadakkipalayam', '6823014567', 'pavi@gmail.com', 'pavi', 'pavi'),
(11, 'Harini', 'A01', 'kjdhxsjkhj', '9874563214', 'harini@gmail.com', 'harini', '123456789'),
(12, 'Harini', 'A05', 'Ram Nagar', '9632587416', 'harini2gmail.com', 'Harini', '123456789'),
(13, 'SAM', 'A01', 'KLDKD', '9874563214', 'sam@gmail.com', 'sam', '123'),
(14, 'Harini', 'A01', 'Coimbatore', '9632587412', 'harini@gmail.com', 'harini', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `service_book`
--

CREATE TABLE IF NOT EXISTS `service_book` (
`bookno` int(11) NOT NULL,
  `bookdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `regno` int(11) NOT NULL,
  `mech_code` varchar(7) NOT NULL,
  `veh_regno` varchar(30) NOT NULL,
  `complaint` varchar(100) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Booked'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `service_book`
--

INSERT INTO `service_book` (`bookno`, `bookdate`, `regno`, `mech_code`, `veh_regno`, `complaint`, `status`) VALUES
(24, '2024-08-16 10:58:39', 11, 'M004', '987456', 'breakdown', 'processed'),
(25, '2024-08-16 12:47:12', 11, 'M001', '98746321', 'Breakdown', 'processed'),
(26, '2024-08-26 18:07:52', 11, 'M004', '987456', 'breakdown', 'processed'),
(27, '2024-08-31 11:53:40', 13, 'M005', 'tn6745', 'sample', 'Booked'),
(28, '2024-08-31 12:06:17', 13, 'M004', 'tn6745', 'fdhgf', 'Booked'),
(29, '2024-08-31 12:07:31', 13, 'M004', 'tn6745', 'repair', 'Booked'),
(30, '2024-08-31 12:16:26', 13, 'M004', 'tn6745', 'ccccccc', 'Booked'),
(31, '2024-08-31 16:19:48', 13, 'M004', 'fgg', 'ffdf', 'processed'),
(32, '2024-08-31 16:25:53', 13, 'M004', 'tn6745', 'fffg', 'processed');

-- --------------------------------------------------------

--
-- Table structure for table `service_response`
--

CREATE TABLE IF NOT EXISTS `service_response` (
`resno` int(11) NOT NULL,
  `serdate` date NOT NULL,
  `bno` int(11) NOT NULL,
  `ser_desc` varchar(100) NOT NULL,
  `ser_cost` decimal(10,2) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `service_response`
--

INSERT INTO `service_response` (`resno`, `serdate`, `bno`, `ser_desc`, `ser_cost`) VALUES
(19, '2024-08-16', 24, 'ok', '500.00'),
(20, '2024-08-16', 25, 'Ok sure we will satisfy your query', '200.00'),
(21, '2024-08-26', 26, 'ok', '0.00'),
(22, '2024-08-31', 31, 'fwffd', '500.00'),
(23, '2024-08-31', 32, 'jnkj', '500.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminlogin`
--
ALTER TABLE `adminlogin`
 ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
 ADD PRIMARY KEY (`areaid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
 ADD PRIMARY KEY (`fno`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
 ADD PRIMARY KEY (`hspt_id`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
 ADD PRIMARY KEY (`hot_id`);

--
-- Indexes for table `mechanic`
--
ALTER TABLE `mechanic`
 ADD PRIMARY KEY (`mech_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
 ADD PRIMARY KEY (`regno`);

--
-- Indexes for table `service_book`
--
ALTER TABLE `service_book`
 ADD PRIMARY KEY (`bookno`);

--
-- Indexes for table `service_response`
--
ALTER TABLE `service_response`
 ADD PRIMARY KEY (`resno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminlogin`
--
ALTER TABLE `adminlogin`
MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
MODIFY `areaid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
MODIFY `fno` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
MODIFY `hspt_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
MODIFY `hot_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `mechanic`
--
ALTER TABLE `mechanic`
MODIFY `mech_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
MODIFY `regno` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `service_book`
--
ALTER TABLE `service_book`
MODIFY `bookno` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `service_response`
--
ALTER TABLE `service_response`
MODIFY `resno` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
