-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 14, 2020 at 07:28 PM
-- Server version: 5.7.29-0ubuntu0.16.04.1
-- PHP Version: 7.2.28-3+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizza_order`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) DEFAULT NULL,
  `email` varchar(250) NOT NULL,
  `contact_number_1` varchar(20) NOT NULL,
  `contact_number_2` varchar(20) DEFAULT NULL,
  `gender` tinyint(1) NOT NULL,
  `password` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `remember_token` text,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `last_name`, `email`, `contact_number_1`, `contact_number_2`, `gender`, `password`, `image`, `remember_token`, `status`, `created_at`, `updated_at`, `deleted_at`, `last_login`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '8218344618', '9675351702', 1, '$2y$10$ijOD2Ii0cWHP9p.SDiWwweVtJ7s785kN0oz73bLzNNFuHllO0eFtm', '1562309342.jpg', NULL, 1, '2019-05-05 02:19:21', '2020-03-14 13:55:43', NULL, '2020-03-14 13:55:43');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `pizza_order_id` int(11) NOT NULL,
  `pizza_category_id` int(11) NOT NULL,
  `pizza_type_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` varchar(55) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `pizza_order_id`, `pizza_category_id`, `pizza_type_id`, `quantity`, `amount`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 4, 1, 1, 2, NULL, 1, '2020-03-14 10:02:35', '2020-03-14 12:55:37', NULL),
(10, 4, 1, 2, 1, NULL, 1, '2020-03-14 12:56:49', '2020-03-14 12:56:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pizza_amounts`
--

CREATE TABLE `pizza_amounts` (
  `id` int(11) NOT NULL,
  `pizza_category_id` int(11) NOT NULL,
  `pizza_type_id` int(11) NOT NULL,
  `amount` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pizza_amounts`
--

INSERT INTO `pizza_amounts` (`id`, `pizza_category_id`, `pizza_type_id`, `amount`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 6, 2, '100 Rs', 1, '2020-03-13 10:43:21', '2020-03-14 10:17:20', NULL),
(2, 1, 1, '150 Rs', 1, '2020-03-13 10:52:13', '2020-03-14 10:17:06', NULL),
(3, 1, 1, '300', 1, '2020-03-14 10:09:50', '2020-03-14 10:09:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pizza_categories`
--

CREATE TABLE `pizza_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pizza_categories`
--

INSERT INTO `pizza_categories` (`id`, `image`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, '1584183217.png', 'Onion pizza', 'ryrtuyti', 1, '2020-03-13 03:04:49', '2020-03-14 05:23:37'),
(7, '1584190570.png', 'Marinara pizza', 'gfdh', 1, '2020-03-14 07:26:10', '2020-03-14 07:26:10');

-- --------------------------------------------------------

--
-- Table structure for table `pizza_orders`
--

CREATE TABLE `pizza_orders` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pizza_orders`
--

INSERT INTO `pizza_orders` (`id`, `first_name`, `last_name`, `contact_number`, `address`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'Contact', 'Us', '09876543210', 'Noida sector 63', 1, '2020-03-14 12:16:21', '2020-03-14 12:16:21', NULL),
(5, 'Sanchita', 'Us', '09876543212', 'Noida sector 63', 1, '2020-03-14 12:16:38', '2020-03-14 13:30:54', NULL),
(6, 'Rahul', 'Us', '09876543210', 'Noida sector 63', 2, '2020-03-14 12:21:13', '2020-03-14 12:57:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pizza_types`
--

CREATE TABLE `pizza_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pizza_types`
--

INSERT INTO `pizza_types` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Large', 1, '2020-03-13 01:23:46', '2020-03-13 05:17:40'),
(2, 'Medium', 1, '2020-03-13 01:41:01', '2020-03-13 01:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_line_1` text,
  `address_line_2` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `contact_number`, `email`, `address_line_1`, `address_line_2`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sanchita', 'Raj', 'admin@123', '8882979352', 'sanchitaraj24@gmail.com', 'noida sector - 63', NULL, 1, '2020-03-13 00:00:00', '2020-03-13 00:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pizza_amounts`
--
ALTER TABLE `pizza_amounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pizza_categories`
--
ALTER TABLE `pizza_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pizza_orders`
--
ALTER TABLE `pizza_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pizza_types`
--
ALTER TABLE `pizza_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `pizza_amounts`
--
ALTER TABLE `pizza_amounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pizza_categories`
--
ALTER TABLE `pizza_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `pizza_orders`
--
ALTER TABLE `pizza_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pizza_types`
--
ALTER TABLE `pizza_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
