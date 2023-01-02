-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 01, 2023 at 11:14 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `ebook_shelf`
--
CREATE DATABASE IF NOT EXISTS `ebook_shelf` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ebook_shelf`;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `author` varchar(60) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `posted_by` varchar(60) NOT NULL,
  `date_uploaded` varchar(76) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `new_name` varchar(100) NOT NULL,
  `book_cover` varchar(100) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `book_activities`
--

CREATE TABLE `book_activities` (
  `book_id` int(20) NOT NULL,
  `times_read` int(30) DEFAULT NULL,
  `times_downloaded` int(11) DEFAULT NULL,
  `times_viewed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `book_rating`
--

CREATE TABLE `book_rating` (
  `user_id` varchar(100) NOT NULL,
  `rating` int(5) NOT NULL,
  `comment` varchar(150) NOT NULL,
  `book_id` int(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_books`
--

CREATE TABLE `favorite_books` (
  `user_id` varchar(100) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `online_user`
--

CREATE TABLE `online_user` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `login_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchased_books`
--

CREATE TABLE `purchased_books` (
  `id` int(11) NOT NULL,
  `book_id` int(5) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_method` varchar(12) NOT NULL,
  `transaction_id` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `read_history`
--

CREATE TABLE `read_history` (
  `user_id` varchar(60) NOT NULL,
  `book_id` int(11) NOT NULL,
  `date_read` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `full_name` varchar(120) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  `password_change_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_user`
--
ALTER TABLE `online_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchased_books`
--
ALTER TABLE `purchased_books`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_user`
--
ALTER TABLE `online_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchased_books`
--
ALTER TABLE `purchased_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `user` ADD `email_address` VARCHAR(40) NOT NULL AFTER `full_name`;
COMMIT;
