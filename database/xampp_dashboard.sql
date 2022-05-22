-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2022 at 07:09 PM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`xampp_dashboard`@`localhost` PROCEDURE `insert_projects` (IN `$name` VARCHAR(50), IN `$description` TEXT, IN `$url` VARCHAR(100))   BEGIN

INSERT INTO `projects`(`name`, `description`, `url`)
VALUES(`$name`, `$description`, `$url`);

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Primary key',
  `name` varchar(50) NOT NULL COMMENT 'Nama project',
  `description` text DEFAULT NULL COMMENT 'Deksripsi project',
  `url` varchar(50) NOT NULL COMMENT 'Url project',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Waktu dibuat',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Waktu diperbarui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `url`, `created_at`, `updated_at`) VALUES
(1, 'phpMyAdmin', 'Database (MariaDB)', 'http://localhost/phpmyadmin/', '2022-05-22 11:49:39', '2022-05-22 11:49:39'),
(2, 'Feelbuy Helpdesk', 'Feelbuy technology system', 'http://localhost:8056/php-5/feelbuy-helpdesk/', '2022-05-22 11:49:39', '2022-05-22 11:49:39'),
(3, 'IO Dev', 'Ipul & Opan Web Portfolio', 'https://iodev.vercel.app/', '2022-05-22 11:49:39', '2022-05-22 11:49:39'),
(4, 'Si-IBU', 'Sistem Informasi Bagian Umum', 'https://github.com/saiful-akbar/si-ibu/', '2022-05-22 11:49:39', '2022-05-22 11:49:39'),
(5, 'Scooter Work Shop', 'Sistem informasi manajemen suku cadang scooter.', 'https://github.com/saiful-akbar/scooter-work-shop/', '2022-05-22 11:49:39', '2022-05-22 11:49:39'),
(6, 'PHP MVC', 'Kerangka kerja php native mvc', 'http://localhost/php-mvc/', '2022-05-22 11:49:39', '2022-05-22 11:49:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_url` (`url`) USING BTREE;
ALTER TABLE `projects` ADD FULLTEXT KEY `fulltext_name_description` (`name`,`description`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
