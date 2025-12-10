-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 07:45 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tiket_konser`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2025_11_19_021247_create_tickets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `id_card` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `seat_type` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_checked_in` tinyint(1) NOT NULL DEFAULT 0,
  `checked_in_at` timestamp NULL DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_number`, `name`, `email`, `phone`, `id_card`, `birth_date`, `gender`, `seat_type`, `price`, `is_checked_in`, `checked_in_at`, `qr_code`, `created_at`, `updated_at`) VALUES
(1, 'TXYSIVE6JS20251119', 'Fathur Abdul Halim', 'fathurabdul28@gmail.com', '085863983717', '328123871238123', '2002-03-05', 'male', 'premium', '300000.00', 1, '2025-11-18 21:29:01', NULL, '2025-11-18 19:51:35', '2025-11-18 21:29:01'),
(2, 'TXZ2Z4A31Y20251119', 'fathur', 'fathur@gmail.com', '9812931289379', '12312376', '2002-03-06', 'male', 'vip', '500000.00', 1, '2025-11-18 20:20:19', NULL, '2025-11-18 20:01:14', '2025-11-18 20:20:19'),
(3, 'TXBFGW9VZ720251119', 'fathur', 'fathur@gmail.com', '0812391', '12837137', '2002-09-06', 'male', 'regular', '150000.00', 1, '2025-11-18 20:27:02', NULL, '2025-11-18 20:26:05', '2025-11-18 20:56:48'),
(4, 'TXCOASBGDS20251119', 'fathurlagi', 'fathur12@gmail.com', '123123', '124214', '2002-03-06', 'male', 'vip', '500000.00', 1, '2025-11-19 04:36:56', NULL, '2025-11-18 21:31:50', '2025-11-19 04:36:56'),
(5, 'TXWLIMBI4L20251119', 'jmt', 'jmt@gmail.com', '12313', '123213', '2002-03-06', 'male', 'premium', '300000.00', 1, '2025-11-19 05:00:33', NULL, '2025-11-19 04:59:48', '2025-11-19 05:00:33'),
(6, 'TXLDPZLDBD20251119', 'test', 'test@gmail.com', '123981238', '1283718', '2002-09-27', 'female', 'festival', '150000.00', 1, '2025-11-19 05:01:48', NULL, '2025-11-19 05:01:42', '2025-11-19 05:01:48'),
(7, 'TXCVF7N7A820251119', 'testing2', 'testing2@gmail.com', '08518218238', '213213', '2002-09-27', 'male', 'premium', '300000.00', 1, '2025-11-19 05:05:11', NULL, '2025-11-19 05:05:03', '2025-11-19 05:05:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@gmail.com', '2025-11-18 19:37:14', '$2y$10$I0GwNd2brPfKf3fT3Zu2fejDZ/OA1ZVk70UHHGnqvWWbnpKGr8XQe', 'admin', 1, NULL, '2025-11-18 19:37:14', '2025-11-18 19:37:14'),
(2, 'Fathur', 'fathurabdul28@gmail.com', '2025-11-18 19:37:14', '$2y$10$r2MutttYxC3W6TRXmOm1Wu8bjdnkG5BxAuoIxkS7GT7ufn6XBYTJG', 'staff', 1, NULL, '2025-11-18 19:37:14', '2025-11-18 19:37:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_ticket_number_unique` (`ticket_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
