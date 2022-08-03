-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 03, 2022 at 07:18 PM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myalgo`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `broker_id` int(10) UNSIGNED NOT NULL,
  `is_live` tinyint(4) NOT NULL DEFAULT '1',
  `config` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `phone`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hasmukh Patel', 'me@h1l.in', 'd00f5d5217896fb7fd601412cb890830', '9227228787', 1, '2022-06-10 10:25:55', '2022-06-10 10:25:55');

-- --------------------------------------------------------

--
-- Table structure for table `brokers`
--

CREATE TABLE `brokers` (
  `broker_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `auth_type` enum('api','oauth') NOT NULL DEFAULT 'api',
  `path` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(10) UNSIGNED NOT NULL,
  `client_code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_code`, `name`, `email`, `password`, `phone`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '12345', 'Hasmukh Patel', 'me@h1l.in', '16d7a4fca7442dda3ad93c9a726597e4', '9227228787', 1, 1, '2022-07-17 08:38:07', '2022-07-17 08:38:07');

-- --------------------------------------------------------

--
-- Table structure for table `daily_summary`
--

CREATE TABLE `daily_summary` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `account_id` int(10) UNSIGNED NOT NULL,
  `total_trades` int(10) UNSIGNED NOT NULL,
  `total_pl` decimal(10,2) NOT NULL,
  `profit_trades` int(10) UNSIGNED NOT NULL,
  `loss_trades` int(10) UNSIGNED NOT NULL,
  `max_profit` decimal(10,2) NOT NULL,
  `max_loss` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password`
--

CREATE TABLE `forgot_password` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT '1',
  `code` varchar(20) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valid_till` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `account_id` int(10) UNSIGNED NOT NULL,
  `date` int(11) NOT NULL,
  `enter_time` int(11) NOT NULL,
  `enter_order_id` varchar(25) NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL,
  `charges` decimal(10,2) UNSIGNED NOT NULL,
  `charges_details` varchar(255) NOT NULL,
  `status` enum('pending','open','closing','closed','cancel') NOT NULL,
  `notes` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'password_length', '10'),
(2, 'theme', 'dark');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_type` tinyint(3) UNSIGNED NOT NULL,
  `token` varchar(50) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expire_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `user_id`, `user_type`, `token`, `status`, `created_on`, `expire_on`) VALUES
(1, 1, 1, 'Ct09Wo4aH0z6diuGrn8zfFoW8g30DFXt4JSGi3Vu', 2, '2022-06-26 09:52:05', '2022-07-26 04:22:05'),
(2, 1, 1, 'D7jgjt6HaRxxVHLpu11HZmt37izZKUShH75aRhAY', 2, '2022-06-26 09:52:41', '2022-07-26 04:22:41'),
(3, 1, 1, '5MEGQHFNLfVNb5jn7JFGFRj6v0L0FxhuoXR72x0o', 2, '2022-06-26 09:55:05', '2022-06-27 04:25:05'),
(4, 1, 1, 'phtWVASj56XuIuz7mofjgspaZT3nMTTXTUgi1PtI', 2, '2022-06-26 10:45:41', '2022-07-26 05:15:41'),
(5, 1, 1, 'oAacLTNcPmnXh150HXA83yRgIqZ8vUis0uJKMYxD', 2, '2022-07-04 08:59:00', '2022-08-03 03:29:00'),
(6, 1, 1, 'nPad8F24n7CjSttvlo8N0H2Rg792jjwIZBDKHmmq', 2, '2022-07-04 09:00:44', '2022-08-03 03:30:44'),
(7, 1, 1, 'us9BPZuHzYHelsrkp8oBxZHG7zaiW8IKfYp7wN64', 2, '2022-07-04 09:01:38', '2022-08-03 03:31:38'),
(8, 1, 1, 'MCJ3FwGBnQylhgTwMAl4Rb8VeJw8BWut86KMvzDr', 2, '2022-07-04 09:03:22', '2022-08-03 03:33:22'),
(9, 1, 1, '0ejruOI1G86M9dCirBlx8Onmzd05olmmASU6usWN', 2, '2022-07-06 11:36:56', '2022-08-05 06:06:56'),
(10, 1, 1, 'eqJoUICQy17QXSNTYXisDC5Un3YUyFuI85F0YWii', 2, '2022-07-06 11:44:02', '2022-08-05 06:14:02'),
(11, 1, 1, 'OIjhBuhDPlSsoEaIZplrcrdSQLaECWC1Hj6rv67Z', 2, '2022-07-06 11:46:11', '2022-08-05 06:16:11'),
(12, 1, 1, 'Foc974cSTCLZJzbZQZbSOspyPqFp2d3VllDbxu3b', 2, '2022-07-06 12:34:57', '2022-08-05 07:04:57'),
(13, 1, 1, 'B0XYKw2lHQUQ2ni7D1zo7YEWpReHXESj5Y3InnfZ', 2, '2022-07-09 16:48:07', '2022-08-08 11:18:07'),
(14, 1, 1, '8MK8zbP5G4uXw9cFfnLfsbyEnDJYpsZGkCx3qOGh', 2, '2022-07-09 16:48:23', '2022-08-08 11:18:23'),
(15, 1, 1, 'cW7FfIvq5rHLSFnbw2Hy2hVt2VGSZrUYw98hMOhk', 2, '2022-07-09 16:51:38', '2022-08-08 11:21:38'),
(16, 1, 1, 'srhVIqsFG74Nppa5DicepGsva5PU3v1Y3GIdcpR6', 1, '2022-07-09 16:52:08', '2022-08-08 11:22:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `client_id_2` (`client_id`,`status`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`password`,`status`) USING BTREE,
  ADD KEY `email_2` (`email`);

--
-- Indexes for table `brokers`
--
ALTER TABLE `brokers`
  ADD PRIMARY KEY (`broker_id`),
  ADD KEY `name` (`name`,`status`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `client_code` (`client_code`);

--
-- Indexes for table `daily_summary`
--
ALTER TABLE `daily_summary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `date_2` (`date`,`client_id`),
  ADD KEY `date_3` (`date`,`client_id`,`account_id`);

--
-- Indexes for table `forgot_password`
--
ALTER TABLE `forgot_password`
  ADD KEY `code` (`code`,`valid_till`,`status`),
  ADD KEY `code_2` (`code`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id_2` (`client_id`,`account_id`,`date`,`enter_time`,`status`) USING BTREE,
  ADD KEY `date` (`date`,`status`) USING BTREE,
  ADD KEY `client_id` (`client_id`,`date`,`enter_time`,`status`) USING BTREE,
  ADD KEY `client_id_3` (`client_id`,`date`,`status`) USING BTREE;

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`,`token`,`status`,`expire_on`),
  ADD KEY `expire_on` (`expire_on`),
  ADD KEY `user_id_2` (`user_id`,`user_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brokers`
--
ALTER TABLE `brokers`
  MODIFY `broker_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daily_summary`
--
ALTER TABLE `daily_summary`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
