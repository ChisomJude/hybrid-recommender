-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2024 at 01:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hybrid-book-recommender`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookcategory`
--

CREATE TABLE `bookcategory` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `categoryname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `bookcategory`
--

INSERT INTO `bookcategory` (`id`, `category_id`, `categoryname`) VALUES
(1, 1, 'Lifestyle'),
(2, 2, 'Tech'),
(3, 3, 'Kids'),
(4, 4, 'Beauty'),
(5, 5, 'Science');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `image_id` varchar(100) NOT NULL,
  `image-url-s` varchar(100) NOT NULL,
  `booktitle` varchar(100) NOT NULL,
  `categoryname` varchar(100) NOT NULL,
  `book_category_age` varchar(100) DEFAULT NULL,
  `book_category_city` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `category_id`, `image_id`, `image-url-s`, `booktitle`, `categoryname`, `book_category_age`, `book_category_city`) VALUES
(2, 2, '2.png', '', 'The Future and Technology', 'Tech', 'Adult', 'Lagos'),
(3, 1, '3.png', '', 'Imaginary Ways', 'Lifestyle', 'Adult', 'Onitsha'),
(4, 3, '4.png', '', 'Kids Scout Camp', 'Kids', 'kids', 'All Citys'),
(5, 3, '5.png', '', 'ABC Super Kids Habits', 'kids', 'Kids', 'Lagos'),
(6, 1, '6.png', '', 'Summer Vibes and Location', 'Lifestyle', 'Adults', 'Lagos'),
(7, 2, '7.png', '', 'How to work online like a digital normad', 'Tech', 'Teenage', 'Awka'),
(8, 4, '8.png', '', 'Minimalist Skincare Routine', 'Beauty', 'Adult', 'All'),
(9, 5, '9.png', '', 'Atom', 'Science', 'Teenage', 'All'),
(10, 5, '10.png', '', 'The Science of the Internet', 'Science', 'Adult', 'All'),
(11, 1, '11.png', '', 'Aesthetic Moodhood', 'Lifestyle', 'Adult', 'Onitsha'),
(12, 2, '12.png', '', 'The Ethics of Remote Work', 'Tech', 'Adult', 'All'),
(13, 1, '13.png', '', 'Young and Girly', 'Lifestyle', 'Teenage', 'Lagos'),
(14, 6, '8.png', '', 'fictitious woman', 'Fiction', 'teenage', 'london');

-- --------------------------------------------------------

--
-- Table structure for table `userlikes`
--

CREATE TABLE `userlikes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `userlikes`
--

INSERT INTO `userlikes` (`like_id`, `user_id`, `book_id`) VALUES
(3, 2, 9),
(11, 1, 6),
(12, 1, 15),
(13, 1, 14),
(14, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `myusername` varchar(100) NOT NULL,
  `mypassword` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `myusername`, `mypassword`, `name`, `age`, `email`, `city`, `country`) VALUES
(1, 'chisom', 'admin@123', 'chisom', '25', 'admin@admin.com', 'lagos', 'Nigeria'),
(2, 'jennifer', 'admin@123', 'Jennifer', '20', 'admin@admin.com', 'lagos', 'Nigeria');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookcategory`
--
ALTER TABLE `bookcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `userlikes`
--
ALTER TABLE `userlikes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookcategory`
--
ALTER TABLE `bookcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `userlikes`
--
ALTER TABLE `userlikes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
