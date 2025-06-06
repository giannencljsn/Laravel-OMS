-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 08:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phoneville_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1732261456;', 1732261456),
('a17961fa74e9275d529f489537f179c05d50c2f3', 'i:2;', 1732261456);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(27, '0001_01_01_000000_create_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('forpickup','readyforpickup','completed','canceled') NOT NULL DEFAULT 'forpickup',
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `pickup_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phoneville_branches`
--

CREATE TABLE `phoneville_branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `store_location` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phoneville_branches`
--

INSERT INTO `phoneville_branches` (`id`, `store_name`, `store_location`, `created_at`, `updated_at`) VALUES
(1, 'SAMSUNG (MALL OF ASIA)', '2/F, SM Mall Of Asia North Parking, Pacific Dr, Pasay, 1300 Metro Manila', NULL, NULL),
(2, 'SAMSUNG (MARQUEE MALL)', 'LEVEL3 SPACE 3067-3068 MARQUEE MALL FRANCISCO G. NEPOMOCENO AVE', NULL, NULL),
(3, 'SAMSUNG (STA MESA)', 'C-07 3RD FLR SM STA MESA AORORA BLVD COR G ARANETA AVE DONA IMELDA 1113 QC', NULL, NULL),
(4, 'SAMSUNG (TAYTAY)', 'UNIT 4 BLDG A SM TAYTAY MANILA EAST ROAD DOLERES RIZAL', NULL, NULL),
(5, 'SAMSUNG (THE PODIUM)', 'UNIT 3 07 3RD FLR THE PODIUM ADB AVENUE ORTIGAS WACK WACK MANDALUYONG CITY', NULL, NULL),
(6, 'SAMSUNG (RIVERBANKS CENTER)', '84 A BONIFACIO AVENUE RIVERBANK MALL BARANGKA', NULL, NULL),
(7, 'SAMSUNG (SOUTHMALL)', 'UNIT 28 SM SOUTHMALL 3RD FLOOR CYBERZONE ALABANG ZAPOTE RD ALMANZA UNO CITY LPC', NULL, NULL),
(8, 'SAMSUNG (MANILA)', 'CYBERZONE # 003 SM CITY MANILA, SAN MARCELINO ST., ERMITA, MANILA', NULL, NULL),
(9, 'SAMSUNG (BICUTAN)', 'K 001(A) SM CITY BICUTAN DONA SOLEDAD AVE. BARANGAY DON BOSCO, PARANAQUE CITY', NULL, NULL),
(10, 'SAMSUNG (BF)', 'UNIT CZ 18 SM CITY BF DR A. SANTOS COR. PRES, AVE. BRGY BF HOMES PARANAQUE CITY', NULL, NULL),
(11, 'SAMSUNG (VISTA MALL)', '2ND LEVEL VISTA MALL LEVI MARIANO AVE.STA.ANA,TAGUIG CITY', NULL, NULL),
(12, 'SAMSUNG (FAIRVIEW)', '329 CYBERZONE SM CITY FAIRVIEW NORTH FAIRVIEW 2 QUEZON CITY', NULL, NULL),
(13, 'SAMSUNG (TRINOMA)', 'U-432 LEVEL2 TRINOMA MALL NORTH AVE. BAGONG PAG ASA QUEZON CITY', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('19CyvPR2o1dRdzxnpJdzmyrkhwwD5xnQcdte33ca', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoibXk2V0lxM0dSaTBoeFNhdTdab0lybXMwS0N1ZXVVazNZUlVjWVhQMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1732261371),
('nOrOKDQCY9EbfbWdjpP6J0s8dbr6swEYWEZSVyDm', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiYThxNHZ5TEJIWUtnRXRSUnhEZlYzSjU1NlpBM3AyaUNWZFc3UGZHWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9lbXBsb3llZXMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4O3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkLzg5U1VUalNnRzA5ZnY0Z1lhM0guLjNlRzNMVEFkZlFLeXlwTlo0V1ltTWRyLnE4R1hXM3kiO3M6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', 1732261525);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `store_assigned` bigint(20) UNSIGNED DEFAULT NULL,
  `role` enum('Superadmin','Admin','Store_Staff') NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `photo`, `phone`, `address`, `store_assigned`, `role`, `status`, `email`, `password`, `name`, `created_at`, `updated_at`) VALUES
(4, 'superadminuser', 'superadminphoto.jpg', '09123456701', '123 Superadmin St., Supercity, Superprovince', NULL, 'Superadmin', 'Active', 'superadmin@example.com', '$2y$12$1nJ3o7fRMXiQc26mqelace9lfTMrHgbmz4TgBbEc4DHnDXU07j/VO', 'SuperAdmin', '2024-11-22 07:39:55', '2024-11-22 07:39:55'),
(5, 'adminuser', 'adminphoto.jpg', '09123456702', '456 Admin St., Admincity, Adminprovince', 1, 'Admin', 'Active', 'admin@example.com', '$2y$12$p/ZeqAqlJysAD3mtN6IqMObM6bqAmPgo8wXUzlVZbWTS5kXBM90NK', 'Admin', '2024-11-22 07:39:55', '2024-11-22 07:39:55'),
(6, 'storestaffuser', 'storestaffphoto.jpg', '09123456703', '789 Store Staff St., Storecity, Storeprovince', 2, 'Store_Staff', 'Active', 'storestaff@example.com', '$2y$12$gNsJ9dLU574kVzJs6qp07OJhgCOmUVYHFO7M/wazgtj3VwQw0F3z.', 'Store Staff', '2024-11-22 07:39:55', '2024-11-22 07:39:55'),
(7, NULL, NULL, NULL, '123 Anywhere St.', NULL, 'Superadmin', 'Active', 'phonevillemobile@test.gmail.com', '$2y$12$UXWBh345547jYEQbqvo3EuWH1hNQhUmrKc0tRKw41CIIUUVK37n92', 'Phoneville Mobile Inc', '2024-11-21 23:40:43', '2024-11-21 23:40:43'),
(8, NULL, NULL, NULL, '123 Anywhere St.', 1, 'Admin', 'Active', 'phonevilleadmintest@gmail.com', '$2y$12$/89SUTjSgG09fv4gYa3H..3eG3LTAdfQKyypNZ4WYmMdr.q8GXW3y', 'Phoneville Admin', '2024-11-21 23:41:41', '2024-11-21 23:41:41'),
(9, NULL, NULL, NULL, '123 Anywhere St.', 1, 'Store_Staff', 'Active', 'phonevilleemployeetest@gmail.com', '$2y$12$LS.wF1hOl6H.3pWjIvIbUOnslwfxBwdZ4kVTTpEi.g0.lPINCeP0S', 'Phoneville Store Staff', '2024-11-21 23:42:38', '2024-11-21 23:42:38'),
(11, NULL, NULL, NULL, NULL, 1, 'Store_Staff', 'Active', 'phonevilleemployeetest22@gmail.com', '$2y$12$crEg8BfSmJ1ySsAhXNLleOR0sbi2BlsrNhx5BX5J.gVPRn3x6V0re', 'Dummy Employee', '2024-11-21 23:45:17', '2024-11-21 23:45:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phoneville_branches`
--
ALTER TABLE `phoneville_branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_ip_address_index` (`ip_address`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `store_assigned` (`store_assigned`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phoneville_branches`
--
ALTER TABLE `phoneville_branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`store_assigned`) REFERENCES `phoneville_branches` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
