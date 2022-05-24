-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2022 at 07:05 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xampp_dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Primary key',
  `name` varchar(100) NOT NULL COMMENT 'Project name',
  `url` varchar(100) NOT NULL COMMENT 'Project url',
  `description` text DEFAULT NULL COMMENT 'Project description',
  `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT 'Created at',
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Updated at'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tables for application projects';

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `url`, `description`, `created_at`, `updated_at`) VALUES
(1, 'PHPMyAdmin', 'http://localhost/phpmyadmin/', 'MariaDB database', '2022-05-24 16:59:02', '2022-05-24 16:59:02'),
(2, 'PHP MVC', 'http://localhost/php-mvc/', 'Framework for native php creation with mvc method (model, view, controller)', '2022-05-24 17:01:03', '2022-05-24 17:01:03'),
(3, 'IO Dev', 'https://iodev.vercel.app/', 'My portfolio web app.', '2022-05-24 17:02:18', '2022-05-24 17:02:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_url` (`url`);
ALTER TABLE `projects` ADD FULLTEXT KEY `fulltext_name_description` (`name`,`description`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
