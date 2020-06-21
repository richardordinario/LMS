-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2019 at 01:31 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `librarybd`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `book_dis` varchar(255) NOT NULL,
  `book_cat` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `book_left` int(255) NOT NULL,
  `stock` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `book_name`, `book_dis`, `book_cat`, `author`, `book_left`, `stock`) VALUES
(9, 'Web Development', 'Sample', 'History', 'Sample', 3, 3),
(10, 'Algebra', 'Sample', 'Math', 'Cajes, Melay', 3, 3),
(11, 'Chemistry', 'Sample', 'Math', 'Sample', 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

CREATE TABLE `borrow` (
  `id` int(11) NOT NULL,
  `bookid` varchar(255) NOT NULL,
  `libraryid` varchar(255) NOT NULL,
  `studname` varchar(255) NOT NULL,
  `bname` varchar(255) NOT NULL,
  `dateborrow` date NOT NULL,
  `datereturn` date NOT NULL,
  `penalty` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_disc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `category_disc`) VALUES
(15, 'Journal', 'Sample Description'),
(16, 'History', 'Sample Description'),
(17, 'Science Fiction', 'Sample'),
(18, 'Dictionary', 'Sample'),
(19, 'Autobiography', 'Sample'),
(20, 'Art', 'Sample'),
(21, 'Health', 'Sample'),
(22, 'Encyclopedia', 'Sample'),
(23, 'Math', 'Sample'),
(24, 'Travel', 'Sample'),
(25, 'Peotry', 'Sample'),
(26, 'Historical Fiction', 'Sample');

-- --------------------------------------------------------

--
-- Table structure for table `reserve`
--

CREATE TABLE `reserve` (
  `id` int(11) NOT NULL,
  `libraryid` varchar(255) NOT NULL,
  `bookid` varchar(255) NOT NULL,
  `studname` varchar(255) NOT NULL,
  `bname` varchar(255) NOT NULL,
  `dateborrow` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `libraryid` varchar(255) NOT NULL,
  `studentid` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `mi` varchar(255) NOT NULL,
  `bdate` date NOT NULL,
  `section` varchar(255) NOT NULL,
  `ylevel` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `pending` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `libraryid`, `studentid`, `fname`, `lname`, `mi`, `bdate`, `section`, `ylevel`, `address`, `contact`, `gender`, `img`, `pending`) VALUES
(28, '2019-1001', '166-0075', 'RICHARD', 'ORDINARIO', 'DAYPUYART', '2019-12-31', '1', 'GRADE 9', 'TONDO MANILA', '09269076915', 'Male', '../image/43500047_486054975243611_5570760414716755968_n.jpg', '0'),
(29, '2019-1002', '166-0076', 'REGINA', 'BARACENA', 'EMPLOMA', '2019-12-31', '3', 'GRADE 11', 'PASAY MANILA', '09269076915', 'Female', '../image/green-background-texture-best-of-green-background-texture-solid-color-wallpaper-free-wallpapers-stock-of-green-background-texture.jpg', '0'),
(30, '2019-1003', '166-0079', 'MELISA', 'CAJES', '', '1994-08-24', '6', 'GRADE 10', 'QIUAPO MANILA', '032678941', 'Female', '../image/gJB0DJs.jpg', '0'),
(31, '2019-1004', '166-0098', 'MARK', 'MIRADOR', '', '1991-02-27', '8', 'GRADE 12', 'QUEZON CITY', '092365879', 'Male', '../image/04.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `usertype`) VALUES
(9, 'Richard D. Ordinario', 'Chadordi', 'chad082326', 'Admin'),
(17, 'Regina Baracena', 'redge', '12345', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserve`
--
ALTER TABLE `reserve`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `borrow`
--
ALTER TABLE `borrow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reserve`
--
ALTER TABLE `reserve`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
