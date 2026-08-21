-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 21, 2026 at 10:51 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rehla`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_ar` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `type` enum('property','car') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `name`, `name_ar`, `icon`, `type`, `created_at`, `updated_at`) VALUES
(19, 'WiFi', NULL, 'fa-wifi', 'property', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(20, 'Pool', NULL, 'fa-swimming-pool', 'property', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(21, 'Parking', NULL, 'fa-parking', 'property', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(22, 'Air Conditioning', NULL, 'fa-snowflake', 'property', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(23, 'TV', NULL, 'fa-tv', 'property', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(24, 'Kitchen', NULL, 'fa-utensils', 'property', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(25, 'Washer', NULL, 'fa-soap', 'property', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(26, 'Automatic Transmission', NULL, 'fa-car', 'car', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(27, 'Manual Transmission', NULL, 'fa-cogs', 'car', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(28, 'Leather Seats', NULL, 'fa-chair', 'car', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(29, 'Sunroof / Panoramic', NULL, 'fa-sun', 'car', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(30, 'Apple CarPlay / Android Auto', NULL, 'fa-mobile-alt', 'car', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(31, 'Bluetooth', NULL, 'fa-bluetooth', 'car', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(32, 'GPS Navigation', NULL, 'fa-location-arrow', 'car', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(33, 'Rear Camera', NULL, 'fa-camera', 'car', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(34, 'Parking Sensors', NULL, 'fa-wave-square', 'car', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(35, 'Cruise Control', NULL, 'fa-tachometer-alt', 'car', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(36, 'تكييف مركزي', NULL, NULL, 'property', '2026-08-21 05:04:59', '2026-08-21 05:04:59'),
(37, 'موقف مغطى', NULL, NULL, 'property', '2026-08-21 05:04:59', '2026-08-21 05:04:59'),
(38, 'تجهيزات مطبخ', NULL, NULL, 'property', '2026-08-21 05:04:59', '2026-08-21 05:04:59'),
(39, 'حديقة خاصة', NULL, NULL, 'property', '2026-08-21 05:04:59', '2026-08-21 05:04:59'),
(40, 'مسبح مشترك', NULL, NULL, 'property', '2026-08-21 05:04:59', '2026-08-21 05:04:59'),
(41, 'مطل على بحيرات', NULL, NULL, 'property', '2026-08-21 05:04:59', '2026-08-21 05:04:59'),
(42, 'صالة رياضة مشتركة', NULL, NULL, 'property', '2026-08-21 05:04:59', '2026-08-21 05:04:59'),
(43, 'مصعد', NULL, NULL, 'property', '2026-08-21 05:04:59', '2026-08-21 05:04:59');

-- --------------------------------------------------------

--
-- Table structure for table `availability_blocks`
--

CREATE TABLE `availability_blocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `listing_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `blocked_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `booking_reference` varchar(20) NOT NULL,
  `listing_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `guests_count` int(10) UNSIGNED NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'EGP',
  `total_amount_cents` bigint(20) UNSIGNED NOT NULL,
  `platform_fee_cents` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','confirmed','active','completed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid','refunded','failed') NOT NULL DEFAULT 'pending',
  `cancellation_reason` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `pricing_snapshot` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Persisted pricing breakdown at booking creation time' CHECK (json_valid(`pricing_snapshot`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `promo_code_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount_amount_cents` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `length_of_stay_discount_cents` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `uuid`, `booking_reference`, `listing_id`, `customer_id`, `check_in_date`, `check_out_date`, `guests_count`, `currency`, `total_amount_cents`, `platform_fee_cents`, `status`, `payment_status`, `cancellation_reason`, `notes`, `pricing_snapshot`, `deleted_at`, `created_at`, `updated_at`, `promo_code_id`, `discount_amount_cents`, `length_of_stay_discount_cents`) VALUES
(1, '9370a9cb-2df8-4c4c-9262-78b1eeca5790', 'VS-OEMEGSI6', 1, 118, '2026-08-17', '2026-08-18', 1, 'EGP', 220000, 20000, 'pending', 'pending', NULL, NULL, '{\"nights\":1,\"base_total_cents\":200000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":20000,\"grand_total_cents\":220000}', NULL, '2026-08-17 08:45:18', '2026-08-17 08:45:18', NULL, 0, 0),
(2, '5213fd63-f2c3-4a9f-843e-bb53aa5657b5', 'VS-CMSAQPAF', 1, 118, '2026-08-19', '2026-08-26', 1, 'EGP', 1540000, 140000, 'pending', 'pending', NULL, NULL, '{\"nights\":7,\"base_total_cents\":1400000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":140000,\"grand_total_cents\":1540000}', NULL, '2026-08-17 09:04:03', '2026-08-17 09:04:03', NULL, 0, 0),
(3, '28b78b48-ea9f-4c94-828f-f9a52852ef54', 'VS-Q8N645LC', 1, 118, '2026-08-17', '2026-08-25', 1, 'EGP', 1760000, 160000, 'pending', 'pending', NULL, NULL, '{\"nights\":8,\"base_total_cents\":1600000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":160000,\"grand_total_cents\":1760000}', NULL, '2026-08-17 10:41:16', '2026-08-17 10:41:16', NULL, 0, 0),
(4, 'bfdf4e22-2abb-4ab1-b803-634c62d3246f', 'VS-NPX98VXH', 2, 118, '2026-08-18', '2026-08-25', 1, 'EGP', 3850000, 350000, 'pending', 'pending', NULL, NULL, '{\"nights\":7,\"base_total_cents\":3500000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":350000,\"grand_total_cents\":3850000}', NULL, '2026-08-17 10:41:52', '2026-08-17 10:41:52', NULL, 0, 0),
(5, 'c483362e-a65c-4e1e-9b2d-970d8295d64e', 'VS-Q59TA2ON', 1, 118, '2026-08-17', '2026-08-26', 1, 'EGP', 1980000, 180000, 'pending', 'pending', NULL, NULL, '{\"nights\":9,\"base_total_cents\":1800000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":180000,\"grand_total_cents\":1980000}', NULL, '2026-08-17 10:53:24', '2026-08-17 10:53:24', NULL, 0, 0),
(6, 'cac0f666-7b5c-46d2-85a5-5dbfcec277d1', 'VS-RYT4LB2L', 1, 118, '2026-08-18', '2026-08-26', 1, 'EGP', 1760000, 160000, 'pending', 'pending', NULL, NULL, '{\"nights\":8,\"base_total_cents\":1600000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":160000,\"grand_total_cents\":1760000}', NULL, '2026-08-17 10:53:57', '2026-08-17 10:53:57', NULL, 0, 0),
(7, '04c17bd9-98d0-4828-8005-6029f9d085dd', 'VS-XHJYTOE8', 2, 118, '2026-08-26', '2026-08-29', 1, 'EGP', 1650000, 150000, 'pending', 'pending', NULL, NULL, '{\"nights\":3,\"base_total_cents\":1500000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":150000,\"grand_total_cents\":1650000}', NULL, '2026-08-17 10:54:12', '2026-08-17 10:54:12', NULL, 0, 0),
(8, '1c2abaaf-d259-47e4-b8d8-ec9e407681ad', 'VS-DRGU52UD', 3, 118, '2026-08-17', '2026-08-25', 1, 'EGP', 352000, 32000, 'pending', 'pending', NULL, NULL, '{\"nights\":8,\"base_total_cents\":320000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":32000,\"grand_total_cents\":352000}', NULL, '2026-08-17 10:55:23', '2026-08-17 10:55:23', NULL, 0, 0),
(9, '578edd25-49f9-4a42-b4f8-5f24770b7469', 'VS-N1ZPTE8O', 3, 118, '2026-08-18', '2026-08-26', 1, 'EGP', 352000, 32000, 'pending', 'pending', NULL, NULL, '{\"nights\":8,\"base_total_cents\":320000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":32000,\"grand_total_cents\":352000}', NULL, '2026-08-17 10:55:39', '2026-08-17 10:55:39', NULL, 0, 0),
(10, '17e333d0-2cc4-4645-a276-729003fbbe94', 'VS-4UCQYZVI', 3, 118, '2026-08-19', '2026-08-26', 1, 'EGP', 308000, 28000, 'pending', 'pending', NULL, NULL, '{\"nights\":7,\"base_total_cents\":280000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":28000,\"grand_total_cents\":308000}', NULL, '2026-08-17 11:06:59', '2026-08-17 11:06:59', NULL, 0, 0),
(11, 'a656d6fd-f68a-4321-8a99-73b7bef10b8f', 'VS-6GKLYE4H', 3, 118, '2026-08-18', '2026-08-25', 1, 'EGP', 308000, 28000, 'pending', 'pending', NULL, NULL, '{\"nights\":7,\"base_total_cents\":280000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":28000,\"grand_total_cents\":308000}', NULL, '2026-08-17 11:07:10', '2026-08-17 11:07:10', NULL, 0, 0),
(12, 'ddbb1ca4-57e9-4bdc-8905-51df492f22a8', 'VS-1HKONQ7U', 1, 118, '2026-08-19', '2026-08-26', 1, 'EGP', 1540000, 140000, 'pending', 'pending', NULL, NULL, '{\"nights\":7,\"base_total_cents\":1400000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":140000,\"grand_total_cents\":1540000}', NULL, '2026-08-17 11:07:22', '2026-08-17 11:07:22', NULL, 0, 0),
(13, '93b0b8fc-40ad-4625-b97d-361c190d5cb5', 'VS-AP1EADAO', 3, 118, '2026-08-18', '2026-08-25', 1, 'EGP', 308000, 28000, 'pending', 'pending', NULL, NULL, '{\"nights\":7,\"base_total_cents\":280000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":28000,\"grand_total_cents\":308000}', NULL, '2026-08-17 11:07:45', '2026-08-17 11:07:45', NULL, 0, 0),
(14, '98f1e94d-b3c7-4911-92e2-0693dc0c308f', 'VS-EDD0KSO8', 3, 118, '2026-08-17', '2026-08-19', 1, 'EGP', 88000, 8000, 'pending', 'pending', NULL, NULL, '{\"nights\":2,\"base_total_cents\":80000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":8000,\"grand_total_cents\":88000}', NULL, '2026-08-17 11:08:02', '2026-08-17 11:08:02', NULL, 0, 0),
(15, '8ff8dca4-c796-4296-a280-d95b29ee2839', 'VS-I06U51CW', 3, 118, '2026-08-17', '2026-08-19', 1, 'EGP', 88000, 8000, 'pending', 'pending', NULL, NULL, '{\"nights\":2,\"base_total_cents\":80000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":8000,\"grand_total_cents\":88000}', NULL, '2026-08-17 11:09:54', '2026-08-17 11:09:54', NULL, 0, 0),
(16, '0439ad75-f2de-4422-98be-24a038317bc6', 'VS-R4OOBNTW', 1, 118, '2026-08-17', '2026-08-19', 1, 'EGP', 440000, 40000, 'pending', 'pending', NULL, NULL, '{\"nights\":2,\"base_total_cents\":400000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":40000,\"grand_total_cents\":440000}', NULL, '2026-08-17 11:12:13', '2026-08-17 11:12:13', NULL, 0, 0),
(17, '1dbb5620-74ef-4519-8ad2-7b772d4d401c', 'VS-WMHCIZIZ', 2, 118, '2026-08-17', '2026-08-20', 1, 'EGP', 1650000, 150000, 'pending', 'pending', NULL, NULL, '{\"nights\":3,\"base_total_cents\":1500000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":150000,\"grand_total_cents\":1650000}', NULL, '2026-08-17 11:23:38', '2026-08-17 11:23:38', NULL, 0, 0),
(18, 'a74baef5-0321-454f-afc6-a39537bb57bd', 'VS-QTNL8TAW', 3, 118, '2026-10-13', '2026-10-31', 1, 'EGP', 742000, 72000, 'pending', 'pending', NULL, NULL, '{\"nights\":18,\"base_total_cents\":720000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":72000,\"discount_amount_cents\":50000,\"promo_code\":\"SUMM2\",\"grand_total_cents\":742000}', NULL, '2026-08-19 15:54:43', '2026-08-19 15:54:43', 3, 50000, 0),
(19, '6ee7d07e-9df1-4e0d-8ce7-e3c123a12d85', 'VS-1ONYXHNP', 9, 118, '2026-08-19', '2026-08-27', 1, 'EGP', 660000, 60000, 'confirmed', 'pending', NULL, NULL, '{\"nights\":8,\"base_total_cents\":1600000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":60000,\"length_of_stay_discount_cents\":1000000,\"discount_amount_cents\":0,\"promo_code\":null,\"grand_total_cents\":660000}', NULL, '2026-08-19 17:04:08', '2026-08-19 17:39:35', NULL, 0, 1000000),
(20, '9cdd7db4-a07b-4ee6-be6a-b5706e838d69', 'VS-BU7BDLRA', 9, 118, '2026-08-19', '2026-08-26', 1, 'EGP', 440000, 40000, 'confirmed', 'pending', NULL, NULL, '{\"nights\":7,\"base_total_cents\":1400000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":40000,\"length_of_stay_discount_cents\":1000000,\"discount_amount_cents\":0,\"promo_code\":null,\"grand_total_cents\":440000}', NULL, '2026-08-19 17:08:51', '2026-08-19 17:39:31', NULL, 0, 1000000),
(21, '550d9529-fce4-451c-8b64-921aafc57256', 'VS-XFRAUAGE', 9, 118, '2026-08-19', '2026-08-26', 1, 'EGP', 440000, 40000, 'confirmed', 'pending', NULL, NULL, '{\"nights\":7,\"base_total_cents\":1400000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":40000,\"length_of_stay_discount_cents\":1000000,\"discount_amount_cents\":0,\"promo_code\":null,\"grand_total_cents\":440000}', NULL, '2026-08-19 17:08:51', '2026-08-19 17:39:33', NULL, 0, 1000000),
(22, '93b33295-0f04-4680-aa2d-423feefec3ce', 'VS-CPTMNSVG', 8, 118, '2026-08-27', '2026-08-29', 1, 'EGP', 440000, 40000, 'confirmed', 'pending', NULL, NULL, '{\"nights\":2,\"base_total_cents\":400000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":40000,\"length_of_stay_discount_cents\":0,\"discount_amount_cents\":0,\"promo_code\":null,\"grand_total_cents\":440000}', NULL, '2026-08-19 17:14:36', '2026-08-19 17:14:56', NULL, 0, 0),
(23, 'bca2e72c-bb48-46be-8d63-7182fc3c1375', 'VS-TNVQHJUY', 9, 118, '2026-08-26', '2026-08-29', 1, 'EGP', 594000, 60000, 'confirmed', 'paid', NULL, NULL, '{\"nights\":3,\"base_total_cents\":600000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":60000,\"length_of_stay_discount_cents\":0,\"discount_amount_cents\":66000,\"promo_code\":\"SUM\",\"grand_total_cents\":594000}', NULL, '2026-08-19 17:49:02', '2026-08-19 17:49:03', 4, 66000, 0),
(24, 'a288fe55-9b8d-4b7a-ad7c-5decac1cd0cd', 'VS-7JBXQUHA', 9, 118, '2026-08-19', '2026-08-29', 1, 'EGP', 1100000, 100000, 'pending', 'pending', NULL, NULL, '{\"nights\":10,\"base_total_cents\":2000000,\"cleaning_fee_cents\":0,\"extra_guest_fee_cents\":0,\"platform_fee_cents\":100000,\"length_of_stay_discount_cents\":1000000,\"discount_amount_cents\":0,\"promo_code\":null,\"grand_total_cents\":1100000}', NULL, '2026-08-19 17:50:15', '2026-08-19 17:50:15', NULL, 0, 1000000);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-55dfb68540ba847ff2de94b7caa0d781', 'i:1;', 1787172675),
('laravel-cache-55dfb68540ba847ff2de94b7caa0d781:timer', 'i:1787172675;', 1787172675),
('laravel-cache-e45444ecc678a271a6330f468a373360', 'i:2;', 1787299256),
('laravel-cache-e45444ecc678a271a6330f468a373360:timer', 'i:1787299256;', 1787299256),
('laravel-cache-setting_data_v2_cancellation_window_days', 'a:2:{s:5:\"value\";s:2:\"10\";s:4:\"type\";E:29:\"App\\Enums\\SettingType:Integer\";}', 2102529956),
('laravel-cache-setting_data_v2_lead_statuses', 'a:2:{s:5:\"value\";s:52:\"[\"pending\",\"contacted\",\"booked\",\"lost\",\"interested\"]\";s:4:\"type\";E:26:\"App\\Enums\\SettingType:Json\";}', 2102657580),
('laravel-cache-setting_data_v2_max_photos_per_listing', 'a:2:{s:5:\"value\";s:2:\"20\";s:4:\"type\";E:29:\"App\\Enums\\SettingType:Integer\";}', 2102527440),
('laravel-cache-setting_data_v2_platform_fee_percentage', 'a:2:{s:5:\"value\";s:2:\"10\";s:4:\"type\";E:29:\"App\\Enums\\SettingType:Integer\";}', 2102525683);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `icon_color` varchar(255) DEFAULT NULL,
  `icon_bg` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `uuid`, `name`, `subtitle`, `icon`, `icon_color`, `icon_bg`, `is_active`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '120343ac-994f-47fb-bccc-54f1c86bb639', 'Cairo', 'The City of a Thousand Minarets', 'business-outline', '#003d9b', 'rgba(0, 61, 155, 0.10)', 1, 0, '2026-08-08 18:57:55', '2026-08-08 18:57:55', NULL),
(2, '693419ba-3be1-43b5-90bd-f1231cf0ba68', 'Alexandria', 'Pearl of the Mediterranean', 'water-outline', '#009b8c', 'rgba(0, 155, 140, 0.10)', 1, 1, '2026-08-08 18:57:55', '2026-08-08 18:57:55', NULL),
(3, '2c888069-deb8-4701-9c21-96affba9bba3', 'Sharm El Sheikh', 'City of Peace', 'sunny-outline', '#e89c0e', 'rgba(232, 156, 14, 0.10)', 1, 2, '2026-08-08 18:57:55', '2026-08-08 18:57:55', NULL),
(4, 'a123e7bf-6baa-4d63-9e33-dd38c5f32267', 'Hurghada', 'Red Sea Riviera', 'boat-outline', '#0e9ce8', 'rgba(14, 156, 232, 0.10)', 1, 3, '2026-08-08 18:57:55', '2026-08-08 18:57:55', NULL),
(5, '5a6c8878-63cb-4391-b2ae-1f3e77836fc2', 'Gouna', 'Life as it should be', 'wine-outline', '#9b003d', 'rgba(155, 0, 61, 0.10)', 1, 4, '2026-08-08 18:57:55', '2026-08-08 18:57:55', NULL),
(6, '1b8e99b3-e5ae-4a1e-ab68-8a150a7ba2d9', 'North Coast', 'Summer Capital', 'umbrella-outline', '#009b4d', 'rgba(0, 155, 77, 0.10)', 1, 5, '2026-08-08 18:57:55', '2026-08-08 18:57:55', NULL),
(7, '5eda4eb9-01d0-433f-a4e8-fc9b9f52f253', 'Luxor', 'World\'s Greatest Open-Air Museum', 'map-outline', '#7a009b', 'rgba(122, 0, 155, 0.10)', 1, 6, '2026-08-08 18:57:55', '2026-08-08 18:57:55', NULL),
(8, '1f31fc35-fc95-49e1-a723-b01f552a17cc', 'Aswan', 'Jewel of the Nile', 'image-outline', '#9b3d00', 'rgba(155, 61, 0, 0.10)', 1, 7, '2026-08-08 18:57:55', '2026-08-08 18:57:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
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
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"bd15549a-9814-4aa4-bfa2-9c652a50c804\",\"displayName\":\"App\\\\Mail\\\\BookingConfirmedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:29:\\\"App\\\\Mail\\\\BookingConfirmedMail\\\":3:{s:7:\\\"booking\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Booking\\\";s:2:\\\"id\\\";i:20;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:7:\\\"listing\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:9:\\\"aa@aa.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1787171971,\"delay\":null}', 0, NULL, 1787171971, 1787171971),
(2, 'default', '{\"uuid\":\"a3a930e0-0127-4411-bca3-8fef379faef3\",\"displayName\":\"App\\\\Jobs\\\\SendPushNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendPushNotification\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\SendPushNotification\\\":4:{s:6:\\\"tokens\\\";s:41:\\\"ExponentPushToken[i8H1mYGI72JZN-0SmKt1sn]\\\";s:5:\\\"title\\\";s:18:\\\"Booking Confirmed!\\\";s:4:\\\"body\\\";s:41:\\\"Your booking at lanos has been confirmed.\\\";s:4:\\\"data\\\";a:1:{s:12:\\\"booking_uuid\\\";s:36:\\\"9cdd7db4-a07b-4ee6-be6a-b5706e838d69\\\";}}\",\"batchId\":null},\"createdAt\":1787171971,\"delay\":null}', 0, NULL, 1787171971, 1787171971),
(3, 'default', '{\"uuid\":\"4cd48a31-6486-414b-94f9-65fe09a7a248\",\"displayName\":\"App\\\\Mail\\\\BookingConfirmedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:29:\\\"App\\\\Mail\\\\BookingConfirmedMail\\\":3:{s:7:\\\"booking\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Booking\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:7:\\\"listing\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:9:\\\"aa@aa.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1787171973,\"delay\":null}', 0, NULL, 1787171973, 1787171973),
(4, 'default', '{\"uuid\":\"0ef046e5-3387-4336-b294-6d505efa170e\",\"displayName\":\"App\\\\Jobs\\\\SendPushNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendPushNotification\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\SendPushNotification\\\":4:{s:6:\\\"tokens\\\";s:41:\\\"ExponentPushToken[i8H1mYGI72JZN-0SmKt1sn]\\\";s:5:\\\"title\\\";s:18:\\\"Booking Confirmed!\\\";s:4:\\\"body\\\";s:41:\\\"Your booking at lanos has been confirmed.\\\";s:4:\\\"data\\\";a:1:{s:12:\\\"booking_uuid\\\";s:36:\\\"550d9529-fce4-451c-8b64-921aafc57256\\\";}}\",\"batchId\":null},\"createdAt\":1787171973,\"delay\":null}', 0, NULL, 1787171973, 1787171973),
(5, 'default', '{\"uuid\":\"1a3e9a70-2711-4239-8352-391a0edeed8f\",\"displayName\":\"App\\\\Mail\\\\BookingConfirmedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:29:\\\"App\\\\Mail\\\\BookingConfirmedMail\\\":3:{s:7:\\\"booking\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Booking\\\";s:2:\\\"id\\\";i:19;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:7:\\\"listing\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:9:\\\"aa@aa.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1787171975,\"delay\":null}', 0, NULL, 1787171975, 1787171975),
(6, 'default', '{\"uuid\":\"f298a834-0c49-4fa1-ae22-a64df318d6a6\",\"displayName\":\"App\\\\Jobs\\\\SendPushNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendPushNotification\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\SendPushNotification\\\":4:{s:6:\\\"tokens\\\";s:41:\\\"ExponentPushToken[i8H1mYGI72JZN-0SmKt1sn]\\\";s:5:\\\"title\\\";s:18:\\\"Booking Confirmed!\\\";s:4:\\\"body\\\";s:41:\\\"Your booking at lanos has been confirmed.\\\";s:4:\\\"data\\\";a:1:{s:12:\\\"booking_uuid\\\";s:36:\\\"6ee7d07e-9df1-4e0d-8ce7-e3c123a12d85\\\";}}\",\"batchId\":null},\"createdAt\":1787171975,\"delay\":null}', 0, NULL, 1787171975, 1787171975),
(7, 'default', '{\"uuid\":\"c1f5b28d-999c-4ada-b1b8-cb110ba8fc85\",\"displayName\":\"App\\\\Mail\\\\BookingConfirmedMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:29:\\\"App\\\\Mail\\\\BookingConfirmedMail\\\":3:{s:7:\\\"booking\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Booking\\\";s:2:\\\"id\\\";i:23;s:9:\\\"relations\\\";a:2:{i:0;s:8:\\\"customer\\\";i:1;s:7:\\\"listing\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:9:\\\"aa@aa.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1787172543,\"delay\":null}', 0, NULL, 1787172543, 1787172543),
(8, 'default', '{\"uuid\":\"f16f5c9b-2d3a-4563-aee3-50b1f292bf90\",\"displayName\":\"App\\\\Jobs\\\\SendPushNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendPushNotification\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\SendPushNotification\\\":4:{s:6:\\\"tokens\\\";s:41:\\\"ExponentPushToken[i8H1mYGI72JZN-0SmKt1sn]\\\";s:5:\\\"title\\\";s:18:\\\"Booking Confirmed!\\\";s:4:\\\"body\\\";s:41:\\\"Your booking at lanos has been confirmed.\\\";s:4:\\\"data\\\";a:1:{s:12:\\\"booking_uuid\\\";s:36:\\\"bca2e72c-bb48-46be-8d63-7182fc3c1375\\\";}}\",\"batchId\":null},\"createdAt\":1787172543,\"delay\":null}', 0, NULL, 1787172543, 1787172543);

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
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `type` enum('property','car') NOT NULL,
  `property_type` enum('hotel','apartment','villa','room') DEFAULT NULL,
  `category` enum('luxury','sports','family','economy') DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `base_price_cents` bigint(20) UNSIGNED DEFAULT NULL,
  `original_base_price_cents` int(11) DEFAULT NULL,
  `weekly_price_cents` int(10) UNSIGNED DEFAULT NULL,
  `monthly_price_cents` int(10) UNSIGNED DEFAULT NULL,
  `cleaning_fee_cents` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `extra_guest_fee_cents` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('active','hidden','disabled','archived') DEFAULT 'active',
  `is_instant_bookable` tinyint(1) NOT NULL DEFAULT 1,
  `max_guests` int(10) UNSIGNED NOT NULL,
  `bedrooms` int(10) UNSIGNED DEFAULT NULL,
  `bathrooms` decimal(3,1) DEFAULT NULL,
  `transmission` varchar(255) DEFAULT NULL,
  `fuel_type` varchar(255) DEFAULT NULL,
  `average_rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `total_reviews` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`id`, `uuid`, `created_by`, `type`, `property_type`, `category`, `title`, `description`, `address`, `country`, `city`, `latitude`, `longitude`, `base_price_cents`, `original_base_price_cents`, `weekly_price_cents`, `monthly_price_cents`, `cleaning_fee_cents`, `extra_guest_fee_cents`, `status`, `is_instant_bookable`, `max_guests`, `bedrooms`, `bathrooms`, `transmission`, `fuel_type`, `average_rating`, `total_reviews`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '94659fa6-fee2-434b-aec8-62e5611cf350', 66, 'property', 'villa', NULL, 'vi1', 'aa', '7, Merit Pasha Street, Al Ismalia, Bab al Luq, Cairo, 11519, Egypt', 'Egypt', 'Cairo', 30.0450244, 31.2363625, 200000, NULL, NULL, NULL, 0, 0, 'active', 1, 3, 3, 3.0, NULL, NULL, 0.00, 0, NULL, '2026-08-17 08:36:49', '2026-08-17 08:36:49'),
(2, '618d5de3-57a8-4283-acf1-32e83a6b3b9b', 66, 'property', 'apartment', NULL, 'r', 'aa', '5, Champollion Street, Al Ismalia, Al-Azbakeya, Cairo, 11519, Egypt', 'Egypt', 'Cairo', 30.0479835, 31.2357718, 500000, NULL, NULL, NULL, 0, 0, 'active', 1, 1, 2, NULL, NULL, NULL, 0.00, 0, NULL, '2026-08-17 08:37:41', '2026-08-17 08:37:41'),
(3, 'b45ea3ea-94d1-4728-b2e3-e8eeaad4f3c0', 66, 'property', 'room', NULL, 'mmm', 'mmm', '1, Talaat Harb Street, Al Ismalia, Bab al Luq, Cairo, 11519, Egypt', 'Egypt', 'Cairo', 30.0446565, 31.2365760, 40000, 60000, NULL, NULL, 0, 0, 'active', 1, 4, 4, 3.0, NULL, NULL, 0.00, 0, NULL, '2026-08-17 09:21:58', '2026-08-17 09:21:58'),
(4, 'ea8002bb-ea14-4757-b04e-3bccb0b7576b', 66, 'property', 'apartment', NULL, 'nnn', 'nnn', '22, Adly Street, El Fawala, Al-Azbakeya, Cairo, 11518, Egypt', 'Egypt', 'Cairo', 30.0511166, 31.2430573, 100000, 120000, NULL, NULL, 0, 0, 'active', 1, 4, 2, 2.0, NULL, NULL, 0.00, 0, NULL, '2026-08-19 16:23:48', '2026-08-19 16:23:48'),
(5, '647d6ef7-5e93-48f4-b2f3-a5d01c8cfacc', 66, 'car', NULL, NULL, 'bmw x7', 'good', 'EUGÉNIE CAFE, 19, Merit Pasha Street, Al Ismalia, Bab al Luq, Cairo, 11556, Egypt', 'Egypt', 'Cairo', 30.0483306, 31.2346888, 100000, 125000, NULL, NULL, 0, 0, 'active', 1, 1, NULL, NULL, 'automatic', 'diesel', 0.00, 0, NULL, '2026-08-19 16:25:46', '2026-08-19 16:25:46'),
(6, '0afd049d-60a0-41dd-89b8-3b26dda1c236', 66, 'car', NULL, NULL, 'mercedes', 'nice', '21, Mahmoud Bassiouni Street, Maarouf, Bab al Luq, Cairo, 11519, Egypt', 'Egypt', 'Cairo', 30.0478477, 31.2378216, 400000, 500000, NULL, NULL, 0, 0, 'active', 1, 1, NULL, NULL, 'automatic', 'hybrid', 0.00, 0, NULL, '2026-08-19 16:37:53', '2026-08-19 16:37:53'),
(7, 'db2d8cf8-50ad-4bb1-be23-f031cf341ec5', 66, 'property', 'hotel', NULL, 'new', 'new', '12, Extension Mahmoud Yousef Street, Giza, Aj Jiza, 12814, Egypt', 'Egypt', 'Giza', 30.0082728, 31.1725087, 200000, 250000, NULL, NULL, 0, 0, 'active', 1, 1, 2, 2.0, NULL, NULL, 0.00, 0, NULL, '2026-08-19 16:43:28', '2026-08-19 16:43:28'),
(8, '8f1b036a-dff0-48d7-949d-5580833c4694', 66, 'car', NULL, 'economy', 'sunny', 'aaa', 'Al Sheikh Rihan Street, Qasr Al Doubara, Bab al Luq, Cairo, 11519, Egypt', 'Egypt', 'Cairo', 30.0427954, 31.2339592, 200000, 250000, NULL, NULL, 0, 0, 'active', 1, 1, NULL, NULL, 'automatic', 'petrol', 0.00, 0, NULL, '2026-08-19 16:48:58', '2026-08-19 16:48:58'),
(9, '66e8102c-30b7-477c-8794-fab803075f18', 66, 'car', NULL, 'family', 'lanos', 'aaa', 'Steigenberger Hotel El Tahrir Cairo, 2, Kasr El Nil Street, Al Ismalia, Bab al Luq, Cairo, 11556, Egypt', 'Egypt', 'Cairo', 30.0472533, 31.2356329, 200000, 250000, 400000, 600000, 0, 0, 'active', 1, 1, NULL, NULL, 'automatic', 'petrol', 3.00, 2, NULL, '2026-08-19 16:55:20', '2026-08-19 17:54:52'),
(10, '4e5ffd5f-645c-4ccc-a253-66f941dedbf8', 66, 'car', NULL, 'sports', 'mercedes', 'Great', '180, Al Tahrir Street, Bab El Louk, Bab al Luq, Cairo, 11513, Egypt', 'Egypt', 'Cairo', 30.0448015, 31.2415123, 100000, 125000, 500000, 2000000, 0, 0, 'active', 1, 7, NULL, NULL, 'automatic', 'electric', 0.00, 0, NULL, '2026-08-19 17:57:20', '2026-08-19 17:57:20'),
(12, '15c79011-7137-4414-bd76-a56f6ab633ce', 1, 'property', 'apartment', NULL, 'شقه مفروشه بالكامل للايجار في كمبوندسوديك ڤيليت', 'شقه مفروشه بالكامل للايجار في كمبوندسوديك ڤيليت \n\nالمطور العقاري :سوديك   \nاسم الكمبوند : سوديك ڤيليت \nالموقع : القاهرة الجديدة - التجمع الخامس \n\n\nمواصفات الوحدة \nالمساحة 190 متر \n\nالتقسيمة \n3 غرفه نوم ( 2 غرفه ماستر )  \n 3 حمام\n  اول استخدام\nمطبخ مجهز بالكامل\nتكييفات   \nتشطيب الترا سوبر لوكس\nالسعر120 الف', 'فيليت, كمبوندات التجمع الخامس, التجمع الخامس, مدينة القاهرة الجديدة, القاهرة', 'Egypt', 'Cairo', 30.0225964, 31.5458145, 400000, 500000, 1500000, 5000000, 0, 0, 'active', 1, 6, 3, 3.0, NULL, NULL, 0.00, 0, NULL, '2026-08-21 05:04:59', '2026-08-21 05:23:05');

-- --------------------------------------------------------

--
-- Table structure for table `listing_amenity`
--

CREATE TABLE `listing_amenity` (
  `listing_id` bigint(20) UNSIGNED NOT NULL,
  `amenity_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `listing_amenity`
--

INSERT INTO `listing_amenity` (`listing_id`, `amenity_id`) VALUES
(1, 20),
(1, 21),
(1, 24),
(3, 20),
(3, 22),
(3, 23),
(3, 25),
(4, 21),
(5, 33),
(6, 26),
(6, 29),
(7, 21),
(8, 27),
(10, 26),
(10, 27),
(10, 28),
(10, 29),
(10, 30),
(10, 31),
(10, 32),
(10, 33),
(10, 34),
(10, 35),
(12, 36),
(12, 37),
(12, 38),
(12, 39),
(12, 40),
(12, 41),
(12, 42),
(12, 43);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `entity_type` varchar(255) NOT NULL,
  `entity_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('image','video') NOT NULL,
  `provider` varchar(255) NOT NULL DEFAULT 'cloudinary',
  `url` varchar(255) NOT NULL,
  `public_id` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `uuid`, `entity_type`, `entity_id`, `type`, `provider`, `url`, `public_id`, `order`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 'ccd5ef4b-2f82-4f51-a3cc-83c713465389', 'listing', 1, 'image', 'cloudinary', 'https://res.cloudinary.com/b07hlpxm/image/upload/f_auto,q_auto/v1786966620/listings/94659fa6-fee2-434b-aec8-62e5611cf350/jn6zhghpdlikykfnn0cn.jpg', 'listings/94659fa6-fee2-434b-aec8-62e5611cf350/jn6zhghpdlikykfnn0cn', 1, 1, '2026-08-17 08:37:01', '2026-08-17 08:37:01'),
(2, 'fb337453-f503-4674-8da4-e84ea434f6d1', 'listing', 1, 'image', 'cloudinary', 'https://res.cloudinary.com/b07hlpxm/image/upload/f_auto,q_auto/v1786966638/listings/94659fa6-fee2-434b-aec8-62e5611cf350/ssljwanbqi961xqfgcoe.jpg', 'listings/94659fa6-fee2-434b-aec8-62e5611cf350/ssljwanbqi961xqfgcoe', 2, 0, '2026-08-17 08:37:19', '2026-08-17 08:37:19'),
(3, '59b2101f-99ae-4211-8b0f-e43439e9bc5f', 'listing', 2, 'image', 'cloudinary', 'https://res.cloudinary.com/b07hlpxm/image/upload/f_auto,q_auto/v1786966671/listings/618d5de3-57a8-4283-acf1-32e83a6b3b9b/bzebzsan9d7cztw4j9uu.jpg', 'listings/618d5de3-57a8-4283-acf1-32e83a6b3b9b/bzebzsan9d7cztw4j9uu', 1, 1, '2026-08-17 08:37:52', '2026-08-17 08:37:52'),
(4, '2784d0f9-b542-4bd9-be97-12186f514666', 'listing', 2, 'image', 'cloudinary', 'https://res.cloudinary.com/b07hlpxm/image/upload/f_auto,q_auto/v1786966713/listings/618d5de3-57a8-4283-acf1-32e83a6b3b9b/ljxnvawx6t6kktl1rm51.jpg', 'listings/618d5de3-57a8-4283-acf1-32e83a6b3b9b/ljxnvawx6t6kktl1rm51', 2, 0, '2026-08-17 08:38:34', '2026-08-17 08:38:34'),
(5, 'c4e93f86-0637-4ef8-9272-a15ed511313c', 'listing', 3, 'image', 'cloudinary', 'https://res.cloudinary.com/b07hlpxm/image/upload/f_auto,q_auto/v1786969326/listings/b45ea3ea-94d1-4728-b2e3-e8eeaad4f3c0/xlfkefac5pcyejktnm0v.jpg', 'listings/b45ea3ea-94d1-4728-b2e3-e8eeaad4f3c0/xlfkefac5pcyejktnm0v', 1, 1, '2026-08-17 09:22:07', '2026-08-17 09:22:07'),
(6, '8927383b-9541-4da7-a922-bbd15ebedc0c', 'listing', 4, 'image', 'cloudinary', 'https://res.cloudinary.com/b07hlpxm/image/upload/f_auto,q_auto/v1787167442/listings/ea8002bb-ea14-4757-b04e-3bccb0b7576b/s1i0ffooz99qzi6gikln.jpg', 'listings/ea8002bb-ea14-4757-b04e-3bccb0b7576b/s1i0ffooz99qzi6gikln', 1, 1, '2026-08-19 16:24:02', '2026-08-19 16:24:02'),
(7, '833a4023-6cbc-4182-824e-c7dd10fe7bbf', 'listing', 5, 'image', 'cloudinary', 'https://res.cloudinary.com/b07hlpxm/image/upload/f_auto,q_auto/v1787167553/listings/647d6ef7-5e93-48f4-b2f3-a5d01c8cfacc/c7cyut7sdwdmvoukmczk.jpg', 'listings/647d6ef7-5e93-48f4-b2f3-a5d01c8cfacc/c7cyut7sdwdmvoukmczk', 1, 1, '2026-08-19 16:25:53', '2026-08-19 16:25:53'),
(8, 'e9836d67-ea7d-4ede-9a4e-0763cd8408f3', 'listing', 6, 'image', 'cloudinary', 'https://res.cloudinary.com/b07hlpxm/image/upload/f_auto,q_auto/v1787168315/listings/0afd049d-60a0-41dd-89b8-3b26dda1c236/qyfsmfikfdr5oruzhunh.jpg', 'listings/0afd049d-60a0-41dd-89b8-3b26dda1c236/qyfsmfikfdr5oruzhunh', 1, 1, '2026-08-19 16:38:35', '2026-08-19 16:38:35'),
(9, '98964e41-e304-4d69-a406-f7789a89a2f2', 'listing', 7, 'image', 'cloudinary', 'https://res.cloudinary.com/b07hlpxm/image/upload/f_auto,q_auto/v1787168663/listings/db2d8cf8-50ad-4bb1-be23-f031cf341ec5/c0jibudzstm0w7gp7pxs.jpg', 'listings/db2d8cf8-50ad-4bb1-be23-f031cf341ec5/c0jibudzstm0w7gp7pxs', 1, 1, '2026-08-19 16:44:26', '2026-08-19 16:44:26'),
(10, 'fc3ebe09-6a64-4099-a4aa-f6fb40e0cff7', 'listing', 8, 'image', 'cloudinary', 'https://res.cloudinary.com/b07hlpxm/image/upload/f_auto,q_auto/v1787168944/listings/8f1b036a-dff0-48d7-949d-5580833c4694/chin6maxvxahhy1w3ktn.jpg', 'listings/8f1b036a-dff0-48d7-949d-5580833c4694/chin6maxvxahhy1w3ktn', 1, 1, '2026-08-19 16:49:04', '2026-08-19 16:49:04'),
(11, '43c32082-038d-4098-b443-008f2e6f6524', 'listing', 9, 'image', 'cloudinary', 'https://res.cloudinary.com/b07hlpxm/image/upload/f_auto,q_auto/v1787169325/listings/66e8102c-30b7-477c-8794-fab803075f18/atbtn1pkhdktq4aumboq.jpg', 'listings/66e8102c-30b7-477c-8794-fab803075f18/atbtn1pkhdktq4aumboq', 1, 1, '2026-08-19 16:55:25', '2026-08-19 16:55:25'),
(12, 'faefce82-7e74-4c58-b2fa-5423f9ad3860', 'listing', 10, 'image', 'cloudinary', 'https://res.cloudinary.com/b07hlpxm/image/upload/f_auto,q_auto/v1787173048/listings/4e5ffd5f-645c-4ccc-a253-66f941dedbf8/ymqbwz9fz3wdn2wqilpp.jpg', 'listings/4e5ffd5f-645c-4ccc-a253-66f941dedbf8/ymqbwz9fz3wdn2wqilpp', 1, 1, '2026-08-19 17:57:28', '2026-08-19 17:57:28'),
(13, '5efe4cd8-64b2-473d-99e6-905e705a8fa6', 'listing', 11, 'image', 'local', 'http://10.0.2.2:8002/storage/listings/1314d403-9195-44d7-8c9e-79319dde35d0/img_0.jpg', NULL, 0, 1, '2026-08-21 05:04:21', '2026-08-21 05:16:49'),
(14, '63267d5c-93fc-4521-a66b-33db8a439ccd', 'listing', 11, 'image', 'local', 'http://10.0.2.2:8002/storage/listings/1314d403-9195-44d7-8c9e-79319dde35d0/img_1.jpg', NULL, 1, 0, '2026-08-21 05:04:21', '2026-08-21 05:16:49'),
(15, '19f16c8c-7b6a-4bb8-a12c-b7d627eb43d2', 'listing', 11, 'image', 'local', 'http://10.0.2.2:8002/storage/listings/1314d403-9195-44d7-8c9e-79319dde35d0/img_2.jpg', NULL, 2, 0, '2026-08-21 05:04:22', '2026-08-21 05:16:49'),
(19, '0ec99f7f-9e75-4c5e-996a-fcb599647664', 'listing', 12, 'image', 'local', 'http://10.0.2.2:8002/storage/listings/15c79011-7137-4414-bd76-a56f6ab633ce/img_0.jpg', NULL, 0, 1, '2026-08-21 05:12:34', '2026-08-21 05:16:49'),
(20, '2a08575a-21e4-4d71-80a2-d552df02d736', 'listing', 12, 'image', 'local', 'http://10.0.2.2:8002/storage/listings/15c79011-7137-4414-bd76-a56f6ab633ce/img_1.jpg', NULL, 1, 0, '2026-08-21 05:12:34', '2026-08-21 05:16:49'),
(21, '5042130b-eeaf-4eb4-a674-5b18c5499eba', 'listing', 12, 'image', 'local', 'http://10.0.2.2:8002/storage/listings/15c79011-7137-4414-bd76-a56f6ab633ce/img_2.jpg', NULL, 2, 0, '2026-08-21 05:12:34', '2026-08-21 05:16:49'),
(22, '2f46143c-c085-4cd7-a6c0-b0481695415a', 'listing', 12, 'image', 'local', 'http://10.0.2.2:8002/storage/listings/15c79011-7137-4414-bd76-a56f6ab633ce/img_3.jpg', NULL, 3, 0, '2026-08-21 05:12:35', '2026-08-21 05:16:49'),
(23, '429ca859-e6bf-4b98-b030-15da06d3c8e3', 'listing', 12, 'image', 'local', 'http://10.0.2.2:8002/storage/listings/15c79011-7137-4414-bd76-a56f6ab633ce/img_4.jpg', NULL, 4, 0, '2026-08-21 05:12:35', '2026-08-21 05:16:49'),
(24, 'b7955c9f-1dee-4d09-a2cb-7e516ecb9198', 'listing', 12, 'image', 'local', 'http://10.0.2.2:8002/storage/listings/15c79011-7137-4414-bd76-a56f6ab633ce/img_5.jpg', NULL, 5, 0, '2026-08-21 05:12:35', '2026-08-21 05:16:49'),
(25, '4e978c9f-def9-4967-a57b-5d5581b8bf3b', 'listing', 12, 'image', 'local', 'http://10.0.2.2:8002/storage/listings/15c79011-7137-4414-bd76-a56f6ab633ce/img_6.jpg', NULL, 6, 0, '2026-08-21 05:12:36', '2026-08-21 05:16:49'),
(26, '27e5e8fb-3f01-4638-b31f-ee3753e87579', 'listing', 12, 'image', 'local', 'http://10.0.2.2:8002/storage/listings/15c79011-7137-4414-bd76-a56f6ab633ce/img_7.jpg', NULL, 7, 0, '2026-08-21 05:12:36', '2026-08-21 05:16:49'),
(27, '0f69d2b4-521d-456f-84e3-1cd111e50f93', 'listing', 12, 'image', 'local', 'http://10.0.2.2:8002/storage/listings/15c79011-7137-4414-bd76-a56f6ab633ce/img_8.jpg', NULL, 8, 0, '2026-08-21 05:12:37', '2026-08-21 05:16:49');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_01_021018_create_personal_access_tokens_table', 1),
(5, '2026_07_01_022337_modify_users_table_for_vistastay', 1),
(6, '2026_07_01_022338_01_create_listings_table', 1),
(7, '2026_07_01_022338_02_create_amenities_table', 1),
(8, '2026_07_01_022338_03_create_listing_amenity_table', 1),
(9, '2026_07_01_022338_04_create_media_table', 1),
(10, '2026_07_01_022338_05_create_availability_blocks_table', 1),
(11, '2026_07_01_022339_06_create_bookings_table', 1),
(12, '2026_07_01_022339_07_create_payments_table', 1),
(13, '2026_07_01_022339_08_create_reviews_table', 1),
(14, '2026_07_01_022339_09_create_platform_settings_table', 1),
(15, '2026_07_02_062528_create_notifications_table', 1),
(16, '2026_07_07_012748_create_wishlists_table', 1),
(17, '2026_07_07_033730_create_wallets_table', 1),
(18, '2026_07_07_033731_create_wallet_transactions_table', 1),
(19, '2026_07_13_121048_update_listings_status_enum', 1),
(20, '2026_07_14_194059_create_destinations_table', 1),
(21, '2026_07_14_222516_make_booking_and_reviewer_nullable_on_reviews_table', 1),
(22, '2026_08_12_134826_add_expo_push_token_to_users_table', 2),
(23, '2026_08_17_103821_add_wallet_and_gateway_amounts_to_payments_table', 3),
(24, '2026_08_17_121341_add_original_base_price_cents_to_listings_table', 4),
(25, '2026_08_17_130935_create_potential_clients_table', 5),
(26, '2026_08_17_134650_add_is_read_to_potential_clients_table', 6),
(27, '2026_08_17_141605_add_status_to_potential_clients_table', 7),
(28, '2026_08_17_144349_insert_default_lead_statuses_to_settings', 8),
(29, '2026_08_19_173553_create_promo_codes_table', 9),
(30, '2026_08_19_173554_add_promo_code_to_bookings_table', 10),
(31, '2026_08_19_183648_add_travel_dates_to_promo_codes_table', 11),
(32, '2026_08_19_191245_add_length_of_stay_prices_to_listings_table', 12),
(33, '2026_08_19_191248_add_length_of_stay_discount_cents_to_bookings_table', 12),
(34, '2026_08_21_074319_add_permissions_to_users_table', 13),
(35, '2026_08_21_084104_make_base_price_cents_nullable_in_listings_table', 14),
(36, '2026_08_21_084244_add_name_ar_to_amenities_table', 15);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0577da93-d893-400f-a120-1d2149fb3254', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for mmm.\",\"booking_uuid\":\"98f1e94d-b3c7-4911-92e2-0693dc0c308f\",\"type\":\"new_booking\"}', NULL, '2026-08-17 11:08:02', '2026-08-17 11:08:02'),
('1a5e8492-2a2b-4c36-ab0f-a2ef65255eb7', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for r.\",\"booking_uuid\":\"1dbb5620-74ef-4519-8ad2-7b772d4d401c\",\"type\":\"new_booking\"}', NULL, '2026-08-17 11:23:38', '2026-08-17 11:23:38'),
('2c0d69df-226b-4927-9765-7b26559675d5', 'App\\Notifications\\BookingConfirmedNotification', 'user', 118, '{\"title\":\"Booking Confirmed!\",\"message\":\"Your booking at lanos has been confirmed.\",\"booking_uuid\":\"9cdd7db4-a07b-4ee6-be6a-b5706e838d69\",\"type\":\"booking_confirmed\"}', NULL, '2026-08-19 17:39:31', '2026-08-19 17:39:31'),
('2c8169ae-3050-4f23-bae6-8984e680bcf7', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for vi1.\",\"booking_uuid\":\"9370a9cb-2df8-4c4c-9262-78b1eeca5790\",\"type\":\"new_booking\"}', NULL, '2026-08-17 08:45:18', '2026-08-17 08:45:18'),
('32066239-e49e-49c8-a37e-4314d361a9f8', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for vi1.\",\"booking_uuid\":\"ddbb1ca4-57e9-4bdc-8905-51df492f22a8\",\"type\":\"new_booking\"}', NULL, '2026-08-17 11:07:22', '2026-08-17 11:07:22'),
('3dd9c18f-38eb-4d6e-9df3-9fb4a8e830dc', 'App\\Notifications\\BookingConfirmedNotification', 'user', 118, '{\"title\":\"Booking Confirmed!\",\"message\":\"Your booking at lanos has been confirmed.\",\"booking_uuid\":\"550d9529-fce4-451c-8b64-921aafc57256\",\"type\":\"booking_confirmed\"}', NULL, '2026-08-19 17:39:33', '2026-08-19 17:39:33'),
('3de27326-3b4c-40f4-9f94-34662b32cf6a', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for mmm.\",\"booking_uuid\":\"578edd25-49f9-4a42-b4f8-5f24770b7469\",\"type\":\"new_booking\"}', NULL, '2026-08-17 10:55:39', '2026-08-17 10:55:39'),
('42b936c3-5c2b-4f14-b196-ebdeaa8fbbaa', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"Booking Requested\",\"message\":\"Your booking request for lanos has been submitted successfully.\",\"booking_uuid\":\"bca2e72c-bb48-46be-8d63-7182fc3c1375\",\"type\":\"booking_submitted\"}', NULL, '2026-08-19 17:49:02', '2026-08-19 17:49:02'),
('45ba5625-d728-48f3-9f68-dc8a80b89da5', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"Booking Requested\",\"message\":\"Your booking request for sunny has been submitted successfully.\",\"booking_uuid\":\"93b33295-0f04-4680-aa2d-423feefec3ce\",\"type\":\"booking_submitted\"}', NULL, '2026-08-19 17:14:36', '2026-08-19 17:14:36'),
('4df524f7-e1a0-461e-b49f-1468986b415a', 'App\\Notifications\\BookingConfirmedNotification', 'user', 118, '{\"title\":\"Booking Confirmed!\",\"message\":\"Your booking at lanos has been confirmed.\",\"booking_uuid\":\"6ee7d07e-9df1-4e0d-8ce7-e3c123a12d85\",\"type\":\"booking_confirmed\"}', NULL, '2026-08-19 17:39:35', '2026-08-19 17:39:35'),
('544dd2da-76bd-4fb4-aaf1-bff5fefb03a4', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for mmm.\",\"booking_uuid\":\"a656d6fd-f68a-4321-8a99-73b7bef10b8f\",\"type\":\"new_booking\"}', NULL, '2026-08-17 11:07:10', '2026-08-17 11:07:10'),
('82d965e4-0c4a-47aa-8503-91e03c8c48c0', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for vi1.\",\"booking_uuid\":\"0439ad75-f2de-4422-98be-24a038317bc6\",\"type\":\"new_booking\"}', NULL, '2026-08-17 11:12:13', '2026-08-17 11:12:13'),
('85d91fe0-1c57-40d4-a40b-2fd265fad664', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for mmm.\",\"booking_uuid\":\"17e333d0-2cc4-4645-a276-729003fbbe94\",\"type\":\"new_booking\"}', NULL, '2026-08-17 11:06:59', '2026-08-17 11:06:59'),
('86ae3ed2-34df-4d1d-b77a-902c9fd711bd', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for mmm.\",\"booking_uuid\":\"8ff8dca4-c796-4296-a280-d95b29ee2839\",\"type\":\"new_booking\"}', NULL, '2026-08-17 11:09:54', '2026-08-17 11:09:54'),
('8c43666c-6e73-4d22-b60a-764c607db098', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for lanos.\",\"booking_uuid\":\"9cdd7db4-a07b-4ee6-be6a-b5706e838d69\",\"type\":\"new_booking\"}', NULL, '2026-08-19 17:08:51', '2026-08-19 17:08:51'),
('906bd18b-8a8b-4fc8-9a42-86c3d5e8baec', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for lanos.\",\"booking_uuid\":\"6ee7d07e-9df1-4e0d-8ce7-e3c123a12d85\",\"type\":\"new_booking\"}', NULL, '2026-08-19 17:04:08', '2026-08-19 17:04:08'),
('923d5fec-2726-4302-850b-8fda16a620b9', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for vi1.\",\"booking_uuid\":\"28b78b48-ea9f-4c94-828f-f9a52852ef54\",\"type\":\"new_booking\"}', NULL, '2026-08-17 10:41:16', '2026-08-17 10:41:16'),
('948804ad-cc85-4685-beb6-9b773d0ba52b', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for mmm.\",\"booking_uuid\":\"93b0b8fc-40ad-4625-b97d-361c190d5cb5\",\"type\":\"new_booking\"}', NULL, '2026-08-17 11:07:45', '2026-08-17 11:07:45'),
('98af25ef-3262-4b4d-8775-9dd84f2d6331', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for r.\",\"booking_uuid\":\"bfdf4e22-2abb-4ab1-b803-634c62d3246f\",\"type\":\"new_booking\"}', NULL, '2026-08-17 10:41:52', '2026-08-17 10:41:52'),
('99f05897-9ea5-42f8-8ff5-dade8f98830d', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for vi1.\",\"booking_uuid\":\"cac0f666-7b5c-46d2-85a5-5dbfcec277d1\",\"type\":\"new_booking\"}', NULL, '2026-08-17 10:53:57', '2026-08-17 10:53:57'),
('ac85dc4c-dd5b-4c04-bee2-eff584bb8fae', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for mmm.\",\"booking_uuid\":\"a74baef5-0321-454f-afc6-a39537bb57bd\",\"type\":\"new_booking\"}', NULL, '2026-08-19 15:54:43', '2026-08-19 15:54:43'),
('b9f5cb01-d125-4a55-8976-53839d5ff174', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for vi1.\",\"booking_uuid\":\"c483362e-a65c-4e1e-9b2d-970d8295d64e\",\"type\":\"new_booking\"}', NULL, '2026-08-17 10:53:24', '2026-08-17 10:53:24'),
('ba412827-5c94-435c-9e16-ac3df069505e', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for vi1.\",\"booking_uuid\":\"5213fd63-f2c3-4a9f-843e-bb53aa5657b5\",\"type\":\"new_booking\"}', '2026-08-17 10:30:12', '2026-08-17 09:04:03', '2026-08-17 10:30:12'),
('bb2c2767-c7e9-423b-8e95-9029b9e6b92c', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for lanos.\",\"booking_uuid\":\"550d9529-fce4-451c-8b64-921aafc57256\",\"type\":\"new_booking\"}', NULL, '2026-08-19 17:08:51', '2026-08-19 17:08:51'),
('c0cfed5f-c490-441b-aab3-45c929e5b1b8', 'App\\Notifications\\BookingConfirmedNotification', 'user', 118, '{\"title\":\"Booking Confirmed!\",\"message\":\"Your booking at lanos has been confirmed.\",\"booking_uuid\":\"bca2e72c-bb48-46be-8d63-7182fc3c1375\",\"type\":\"booking_confirmed\"}', NULL, '2026-08-19 17:49:03', '2026-08-19 17:49:03'),
('c8202470-313a-4e14-9f47-73ccd0ea6c70', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for r.\",\"booking_uuid\":\"04c17bd9-98d0-4828-8005-6029f9d085dd\",\"type\":\"new_booking\"}', NULL, '2026-08-17 10:54:12', '2026-08-17 10:54:12'),
('e3646d7c-c9f9-4d41-8a8f-a7be689f64a3', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"Booking Requested\",\"message\":\"Your booking request for lanos has been submitted successfully.\",\"booking_uuid\":\"a288fe55-9b8d-4b7a-ad7c-5decac1cd0cd\",\"type\":\"booking_submitted\"}', NULL, '2026-08-19 17:50:15', '2026-08-19 17:50:15'),
('f67f7a13-2c34-4156-b03b-16061090b2e7', 'App\\Notifications\\NewBookingNotification', 'user', 118, '{\"title\":\"New Booking Request\",\"message\":\"You have received a new booking request for mmm.\",\"booking_uuid\":\"1c2abaaf-d259-47e4-b8d8-ec9e407681ad\",\"type\":\"new_booking\"}', NULL, '2026-08-17 10:55:23', '2026-08-17 10:55:23');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `amount_cents` bigint(20) UNSIGNED NOT NULL,
  `wallet_amount_cents` int(11) NOT NULL DEFAULT 0,
  `gateway_amount_cents` int(11) NOT NULL DEFAULT 0,
  `fee_cents` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `gateway` enum('paymob','revenuecat','stripe','fawry','paypal','null_adapter') NOT NULL,
  `gateway_transaction_id` varchar(255) DEFAULT NULL,
  `provider_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`provider_response`)),
  `status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `uuid`, `booking_id`, `amount_cents`, `wallet_amount_cents`, `gateway_amount_cents`, `fee_cents`, `gateway`, `gateway_transaction_id`, `provider_response`, `status`, `payment_method`, `metadata`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '381d7e1e-44d5-4090-ba9e-6fee9b786e79', 1, 220000, 10000, 210000, 0, 'paymob', 'null-txn-6a82f451e8868', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 08:45:21', '2026-08-17 08:45:21'),
(2, 'cadc3656-a99a-4046-aa88-17b204fa96e1', 2, 1540000, 0, 1540000, 0, 'paymob', 'null-txn-6a82f8b5c1004', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 09:04:05', '2026-08-17 09:04:05'),
(3, '0819d12b-87a2-40de-aef4-5e9cfef85de1', 3, 1760000, 0, 1760000, 0, 'paymob', 'null-txn-6a830f7fe9dd4', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 10:41:19', '2026-08-17 10:41:19'),
(4, 'b20d9afb-919d-47fe-8951-b4a28c8e584b', 4, 3850000, 0, 3850000, 0, 'paymob', 'null-txn-6a830fa0ae8c9', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 10:41:52', '2026-08-17 10:41:52'),
(5, '9d20bc19-4f3a-4bca-9b75-e1a58bc011e7', 5, 1980000, 0, 1980000, 0, 'paymob', 'null-txn-6a83125bcf7ae', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 10:53:31', '2026-08-17 10:53:31'),
(6, 'e015f402-98f9-421b-a643-437de3323a86', 6, 1760000, 0, 1760000, 0, 'paymob', 'null-txn-6a8312767b46e', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 10:53:58', '2026-08-17 10:53:58'),
(7, 'dbdc62ef-bfe8-44c0-8590-4188789c178a', 7, 1650000, 0, 1650000, 0, 'paymob', 'null-txn-6a8312858a0c6', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 10:54:13', '2026-08-17 10:54:13'),
(8, 'e7973e5e-54bc-494b-8140-cc67d4f7ed60', 8, 352000, 0, 352000, 0, 'paymob', 'null-txn-6a8312cc1511f', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 10:55:24', '2026-08-17 10:55:24'),
(9, 'f4e0a476-24ef-447f-86d2-d56c09ad9757', 9, 352000, 0, 352000, 0, 'paymob', 'null-txn-6a8312de15f15', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 10:55:42', '2026-08-17 10:55:42'),
(10, '672b2695-2fdf-470e-8fb6-d800e42089d8', 10, 308000, 0, 308000, 0, 'paymob', 'null-txn-6a831584ecfed', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 11:07:00', '2026-08-17 11:07:00'),
(11, 'e3a6848f-1ec7-4dd7-859e-5d6fffb37f14', 11, 308000, 0, 308000, 0, 'paymob', 'null-txn-6a83158f511c6', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 11:07:11', '2026-08-17 11:07:11'),
(12, '37dd894e-5a81-4952-ad9f-8e4bac8d886b', 12, 1540000, 0, 1540000, 0, 'paymob', 'null-txn-6a83159c0359a', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 11:07:24', '2026-08-17 11:07:24'),
(13, '2d482c15-82af-4795-a937-dc329e65cc52', 16, 440000, 0, 440000, 0, 'paymob', 'null-txn-6a8316c245b4b', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 11:12:18', '2026-08-17 11:12:18'),
(14, 'f6711674-bc26-4f1a-9365-bd0ee7aa0588', 17, 1650000, 0, 1650000, 0, 'paymob', 'null-txn-6a83196b2ead7', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-17 11:23:39', '2026-08-17 11:23:39'),
(15, '0242708b-8cb1-4872-95fb-b9e407113076', 18, 742000, 0, 742000, 0, 'paymob', 'null-txn-6a85fbf4e46fa', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-19 15:54:44', '2026-08-19 15:54:44'),
(16, '23ab344f-7d57-470f-aa00-6377fb775000', 19, 660000, 0, 660000, 0, 'paymob', 'null-txn-6a860c3a01ea7', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-19 17:04:10', '2026-08-19 17:04:10'),
(17, 'c4d0944b-e271-4454-a9b4-6ac38fa06a6f', 21, 440000, 0, 440000, 0, 'paymob', 'null-txn-6a860d54aac08', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-19 17:08:52', '2026-08-19 17:08:52'),
(18, '9add1560-993a-476e-8f82-01be8a8c7e49', 20, 440000, 0, 440000, 0, 'paymob', 'null-txn-6a860d54aede5', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-19 17:08:52', '2026-08-19 17:08:52'),
(19, '38711db9-6a5b-45ee-b4dd-7b8bd8965f05', 22, 440000, 0, 440000, 0, 'paymob', 'null-txn-6a860ead5a98e', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-19 17:14:37', '2026-08-19 17:14:37'),
(20, 'bc440983-4c25-4731-a2f9-41928b6cfd93', 23, 594000, 594000, 0, 0, 'paymob', NULL, NULL, 'paid', NULL, NULL, NULL, '2026-08-19 17:49:03', '2026-08-19 17:49:03'),
(21, '22d72793-eb72-425b-9b98-8c9ee5e49483', 24, 1100000, 806000, 294000, 0, 'paymob', 'null-txn-6a861707a2a55', '{\"adapter\":\"null\"}', 'pending', NULL, NULL, NULL, '2026-08-19 17:50:15', '2026-08-19 17:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'user', 66, 'auth_token', '8b100c4d1b7a7052a5a8d19e36a46f31bda33ca5d2399e95b6ffa7d0732b6f9f', '[\"*\"]', '2026-08-21 04:59:04', NULL, '2026-08-17 08:25:38', '2026-08-21 04:59:04'),
(2, 'user', 118, 'auth_token', '3a6193936c7fb26136fcee41154fc138af16da2e6ce8d483f109b2e4af3af227', '[\"*\"]', '2026-08-19 17:58:17', NULL, '2026-08-17 08:26:25', '2026-08-19 17:58:17'),
(3, 'user', 120, 'auth_token', '4c282d09db682c94445696d84c2dd850f7e5a00afa290972ee95863f012947b3', '[\"*\"]', '2026-08-21 05:45:50', NULL, '2026-08-21 05:00:01', '2026-08-21 05:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `platform_settings`
--

CREATE TABLE `platform_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `type` enum('string','integer','boolean','json') NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `platform_settings`
--

INSERT INTO `platform_settings` (`id`, `key`, `value`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'platform_fee_percentage', '10', 'integer', 'Platform fee percentage applied to bookings', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(2, 'cancellation_window_days', '10', 'integer', 'Number of days before check-in where cancellation is free', '2026-08-08 18:58:09', '2026-08-10 15:18:02'),
(3, 'max_photos_per_listing', '20', 'integer', 'Maximum photos allowed per listing', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(4, 'max_guests_default', '10', 'integer', 'Default maximum guests allowed per listing', '2026-08-08 18:58:09', '2026-08-08 18:58:09'),
(5, 'lead_statuses', '[\"pending\",\"contacted\",\"booked\",\"lost\",\"interested\"]', 'json', NULL, '2026-08-17 11:44:15', '2026-08-17 12:05:31');

-- --------------------------------------------------------

--
-- Table structure for table `potential_clients`
--

CREATE TABLE `potential_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `listing_id` bigint(20) UNSIGNED NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `step` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `device_id` varchar(255) DEFAULT NULL,
  `guests_count` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `potential_clients`
--

INSERT INTO `potential_clients` (`id`, `uuid`, `user_id`, `listing_id`, `check_in_date`, `check_out_date`, `step`, `is_read`, `status`, `device_id`, `guests_count`, `created_at`, `updated_at`) VALUES
(1, '2d217590-123c-4283-963e-e9db9af4c747', 118, 1, '2026-08-19', '2026-08-26', 'date_selected', 1, 'pending', NULL, 1, '2026-08-17 10:33:09', '2026-08-17 11:07:21'),
(2, '50c0fa97-2678-462a-8a7f-61012893eebe', 118, 1, '2026-08-19', '2026-08-26', 'checkout_started', 1, 'pending', NULL, 1, '2026-08-17 10:33:10', '2026-08-17 11:07:22'),
(3, 'a2787fbe-320b-4e22-81fd-adf7601e7d95', 118, 2, '2026-08-26', '2026-08-29', 'date_selected', 1, 'pending', NULL, 1, '2026-08-17 10:41:51', '2026-08-17 10:54:11'),
(4, '37974c78-a062-4e5f-9cb4-fc54413b3a24', 118, 2, '2026-08-26', '2026-08-29', 'checkout_started', 1, 'pending', NULL, 1, '2026-08-17 10:41:52', '2026-08-17 10:54:12'),
(5, '8f6a6a8b-bd8b-4d59-9578-1baec740cda1', 118, 3, '2026-08-17', '2026-08-19', 'date_selected', 1, 'pending', NULL, 1, '2026-08-17 10:55:20', '2026-08-17 11:08:01'),
(6, '61e4662e-0758-4ba7-b0ac-06995d4ef1f5', 118, 3, '2026-08-17', '2026-08-19', 'checkout_started', 1, 'pending', NULL, 1, '2026-08-17 10:55:23', '2026-08-17 11:08:02'),
(7, '3670db54-02cd-42a1-b3bc-0a8b9b0f0651', 118, 1, '2026-08-17', '2026-08-19', 'date_selected', 1, 'pending', NULL, 1, '2026-08-17 11:12:12', '2026-08-17 11:13:39'),
(8, '1fb7423d-3111-4049-9992-60149ff1dc1a', 118, 1, '2026-08-17', '2026-08-19', 'checkout_started', 1, 'booked', NULL, 1, '2026-08-17 11:12:13', '2026-08-17 11:25:30'),
(9, 'bb6dda7d-8686-4e1f-9fcc-847fafa6b4f7', 118, 2, '2026-08-17', '2026-08-21', 'date_selected', 1, 'pending', NULL, 1, '2026-08-17 11:12:53', '2026-08-17 11:13:39'),
(10, '9188051d-1a2a-41c1-8507-966a4357907f', 118, 2, '2026-08-17', '2026-08-24', 'date_selected', 1, 'pending', NULL, 1, '2026-08-17 11:19:37', '2026-08-17 11:19:40'),
(11, '3bead855-ec13-4e9c-9c81-eb07dc9629d3', 118, 2, '2026-08-24', '2026-08-27', 'date_selected', 1, 'pending', NULL, 1, '2026-08-17 11:20:01', '2026-08-17 11:20:07'),
(12, 'a2aa10c8-d2a4-460d-a84a-6215a2cc190c', 118, 2, '2026-08-17', '2026-08-20', 'date_selected', 1, 'pending', NULL, 1, '2026-08-17 11:23:21', '2026-08-17 11:23:30'),
(13, '9a350d3c-befc-4c68-8f60-287195c0ffc8', 118, 2, '2026-08-17', '2026-08-20', 'checkout_started', 1, 'pending', NULL, 1, '2026-08-17 11:23:38', '2026-08-17 11:25:55'),
(14, '534b17ab-4f3b-4034-b75e-8f863cfb8827', 118, 1, '2026-08-17', '2026-08-22', 'date_selected', 1, 'booked', NULL, 1, '2026-08-17 12:06:34', '2026-08-21 04:33:43'),
(15, '2b076d28-4b5d-4216-8108-f687d4e54334', 118, 2, '2026-08-26', '2026-08-28', 'date_selected', 1, 'contacted', NULL, 1, '2026-08-19 15:07:46', '2026-08-21 04:33:42'),
(16, '1f5505e4-e76c-4f32-92c0-58b4efa40fc2', 118, 1, '2026-08-19', '2026-08-20', 'date_selected', 1, 'lost', NULL, 1, '2026-08-19 15:08:06', '2026-08-21 04:33:45'),
(17, '4688a713-22cc-47d1-89af-f6c092876032', 118, 2, '2026-08-19', '2026-08-20', 'date_selected', 1, 'interested', NULL, 1, '2026-08-19 15:44:57', '2026-08-21 04:33:49'),
(18, 'b9983ff3-1da9-4181-8777-ca1228dfcf18', 118, 1, '2026-08-19', '2026-08-27', 'date_selected', 1, 'contacted', NULL, 1, '2026-08-19 15:45:49', '2026-08-21 04:33:53'),
(19, '59b5034b-f7a4-4b34-b1ee-549edca44120', 118, 2, '2026-08-19', '2026-08-26', 'date_selected', 1, 'booked', NULL, 1, '2026-08-19 15:52:36', '2026-08-21 04:33:56'),
(20, '5532c632-d116-4888-9920-50a9cd5f1290', 118, 3, '2026-08-19', '2026-10-13', 'date_selected', 1, 'lost', NULL, 1, '2026-08-19 15:54:09', '2026-08-21 04:33:58'),
(21, 'f4cee046-b9ee-42ab-b6de-afc53d5e9199', 118, 3, '2026-10-13', '2026-10-31', 'checkout_started', 1, 'pending', NULL, 1, '2026-08-19 15:54:43', '2026-08-21 04:35:35'),
(22, 'd8297c9e-8fe4-4e09-bcda-cedc2d21284a', 118, 4, '2026-08-19', '2026-08-26', 'date_selected', 1, 'pending', NULL, 1, '2026-08-19 16:27:16', '2026-08-21 04:32:53'),
(23, '9f1418d2-0c99-4506-8b84-dba1278bf42b', 118, 4, '2026-08-19', '2026-08-20', 'date_selected', 1, 'contacted', NULL, 1, '2026-08-19 16:29:06', '2026-08-21 04:34:09'),
(24, 'b48ea800-b6dc-4045-994f-fb4486bcb9aa', 118, 8, '2026-08-19', '2026-08-26', 'date_selected', 1, 'pending', NULL, 1, '2026-08-19 16:49:38', '2026-08-21 04:32:53'),
(25, '85c2b495-c248-4959-af33-99195b92ca69', 118, 9, '2026-08-19', '2026-08-20', 'date_selected', 1, 'contacted', NULL, 1, '2026-08-19 16:55:57', '2026-08-21 04:34:37'),
(26, 'b7ce86d8-9ee1-48b6-bb6e-9def6cd21b81', 118, 9, '2026-08-19', '2026-08-27', 'date_selected', 1, 'booked', NULL, 1, '2026-08-19 17:01:23', '2026-08-21 04:34:42'),
(27, 'ea7a7ef3-ddcf-4d7e-b4ec-d16a4a7409e1', 118, 9, '2026-08-19', '2026-08-27', 'date_selected', 1, 'lost', NULL, 1, '2026-08-19 17:04:08', '2026-08-21 04:34:43'),
(28, '03bf14ac-0bcb-497a-98f3-afdf67b52445', 118, 9, '2026-08-19', '2026-08-27', 'checkout_started', 1, 'pending', NULL, 1, '2026-08-19 17:04:08', '2026-08-21 04:35:35'),
(29, 'b036e4aa-1176-413d-890d-3576b08ac170', 118, 9, '2026-08-19', '2026-08-26', 'date_selected', 1, 'interested', NULL, 1, '2026-08-19 17:08:40', '2026-08-21 04:34:46'),
(30, '75c1c743-e15f-473a-a616-e2035881e145', 118, 9, '2026-08-19', '2026-08-26', 'checkout_started', 1, 'pending', NULL, 1, '2026-08-19 17:08:41', '2026-08-21 04:35:35'),
(31, '54ad090d-ba8a-42cf-af54-d582e9e5656b', 118, 9, '2026-08-19', '2026-08-26', 'checkout_started', 1, 'pending', NULL, 1, '2026-08-19 17:08:51', '2026-08-21 04:35:35'),
(32, '872716d3-3c06-456c-b954-89376f56a41f', 118, 9, '2026-08-19', '2026-08-26', 'checkout_started', 1, 'pending', NULL, 1, '2026-08-19 17:08:51', '2026-08-21 04:35:35'),
(33, 'e60694d2-9fd9-4185-9e8a-965a4f0cdb00', 118, 8, '2026-08-27', '2026-08-29', 'date_selected', 1, 'pending', NULL, 1, '2026-08-19 17:14:35', '2026-08-21 04:32:53'),
(34, '7529dc54-52ba-4f1d-833e-d947f24275d3', 118, 8, '2026-08-27', '2026-08-29', 'checkout_started', 1, 'pending', NULL, 1, '2026-08-19 17:14:36', '2026-08-21 04:35:35'),
(35, '4ae5c040-a5be-45fb-9f29-dd396ef2b628', 118, 1, '2026-08-19', '2026-08-27', 'date_selected', 1, 'interested', NULL, 1, '2026-08-19 17:20:13', '2026-08-21 04:33:04'),
(36, '063b1425-c180-4ebf-be5f-9113ab56ec20', 118, 1, '2026-08-19', '2026-08-27', 'checkout_started', 1, 'pending', NULL, 1, '2026-08-19 17:20:16', '2026-08-21 04:35:35'),
(37, '80ccf8d9-1ae7-4f13-9f58-e491a6be266f', 118, 9, '2026-08-19', '2026-08-24', 'date_selected', 1, 'lost', NULL, 1, '2026-08-19 17:40:05', '2026-08-21 04:33:03'),
(38, 'b0dd82b3-2c61-4df0-9b72-fa3d7248a08c', 118, 9, '2026-08-26', '2026-08-29', 'date_selected', 1, 'booked', NULL, 1, '2026-08-19 17:48:45', '2026-08-21 04:33:01'),
(39, 'e3680e49-9682-4a13-aecb-1dd3b7d6a1c9', 118, 9, '2026-08-26', '2026-08-29', 'checkout_started', 1, 'pending', NULL, 1, '2026-08-19 17:49:02', '2026-08-21 04:35:35'),
(40, '53f4ff85-7e16-4c11-a3ec-e92da42984cd', 118, 9, '2026-08-19', '2026-08-26', 'date_selected', 1, 'contacted', NULL, 1, '2026-08-19 17:49:28', '2026-08-21 04:33:00'),
(41, 'af8a7ef3-834a-4886-9eb0-1ea57f0c9cf5', 118, 9, '2026-08-19', '2026-08-29', 'checkout_started', 1, 'pending', NULL, 1, '2026-08-19 17:50:15', '2026-08-21 04:35:35'),
(42, 'd852181a-9ddb-447b-a00c-4dd5b73a77a3', NULL, 1, '2026-08-21', '2026-08-28', 'date_selected', 0, 'pending', NULL, 1, '2026-08-21 04:53:15', '2026-08-21 04:53:15');

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes`
--

CREATE TABLE `promo_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `scope_type` enum('global','listing_type','property_type','listing') NOT NULL DEFAULT 'global',
  `scope_value` varchar(255) DEFAULT NULL,
  `discount_type` enum('percentage','fixed_amount') NOT NULL,
  `discount_amount` int(10) UNSIGNED NOT NULL COMMENT 'Cents for fixed, 1-100 for percentage',
  `max_discount_amount` int(10) UNSIGNED DEFAULT NULL COMMENT 'Cents cap for percentage discounts',
  `min_checkout_amount` int(10) UNSIGNED DEFAULT NULL COMMENT 'Minimum required cents in total price',
  `max_uses` int(10) UNSIGNED DEFAULT NULL,
  `used_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `valid_from` datetime DEFAULT NULL,
  `valid_until` datetime DEFAULT NULL,
  `travel_start_date` timestamp NULL DEFAULT NULL,
  `travel_end_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promo_codes`
--

INSERT INTO `promo_codes` (`id`, `code`, `scope_type`, `scope_value`, `discount_type`, `discount_amount`, `max_discount_amount`, `min_checkout_amount`, `max_uses`, `used_count`, `valid_from`, `valid_until`, `travel_start_date`, `travel_end_date`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SUMM', 'property_type', 'villa', 'percentage', 10, 100000, 500000, 1, 0, '2026-08-18 12:04:00', '2026-10-01 12:04:00', NULL, NULL, 1, '2026-08-19 15:07:03', '2026-08-19 15:08:54', NULL),
(2, 'SUMM1', 'listing', '94659fa6-fee2-434b-aec8-62e5611cf350', 'percentage', 10, 100000, 500000, 1, 0, NULL, NULL, '2026-09-01 12:43:00', '2026-10-01 12:43:00', 0, '2026-08-19 15:42:55', '2026-08-19 15:46:58', NULL),
(3, 'SUMM2', 'listing', 'b45ea3ea-94d1-4728-b2e3-e8eeaad4f3c0', 'percentage', 10, 50000, 406300, 1, 1, NULL, NULL, '2026-10-01 13:51:00', '2026-11-01 17:51:00', 1, '2026-08-19 15:52:24', '2026-08-19 15:54:43', NULL),
(4, 'SUM', 'global', NULL, 'percentage', 10, 100000, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, '2026-08-19 17:40:54', '2026-08-19 17:49:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewer_name` varchar(255) DEFAULT NULL,
  `listing_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `comment` text DEFAULT NULL,
  `owner_reply` text DEFAULT NULL,
  `owner_reply_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','approved','hidden') NOT NULL DEFAULT 'pending',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `uuid`, `booking_id`, `reviewer_id`, `reviewer_name`, `listing_id`, `rating`, `comment`, `owner_reply`, `owner_reply_at`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '663a8808-527f-4104-96ff-7a06601454fc', NULL, NULL, NULL, 9, 5, NULL, NULL, NULL, 'approved', NULL, '2026-08-19 17:52:45', '2026-08-19 17:52:45'),
(2, 'd63fd580-2ebb-47cb-9259-daaf32fab436', NULL, NULL, 'mo salah', 9, 1, 'mmm', NULL, NULL, 'approved', NULL, '2026-08-19 17:54:52', '2026-08-19 17:54:52');

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
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('hAJgDbIevdEcPgGihEL719JJrazNTQO5ieMl2QAW', NULL, '127.0.0.1', 'curl/8.7.1', 'eyJfdG9rZW4iOiI5MmFYR2pTb0hmc0tFOVZOcVk5b3k4SGZ1VGdRRDQwVVZNWmRQbTJoIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1786965826);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','provider','admin') NOT NULL DEFAULT 'customer',
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `status` enum('active','pending','suspended') NOT NULL DEFAULT 'active',
  `avatar_url` varchar(255) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `provider_id` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `expo_push_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `name`, `email`, `email_verified_at`, `phone`, `password`, `role`, `permissions`, `status`, `avatar_url`, `last_login_at`, `provider`, `provider_id`, `remember_token`, `expo_push_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'f1d66501-a35d-4d75-afa0-6c40dee79fe3', 'Host Roxanne', 'host1@example.com', NULL, '+20110817985', '$2y$12$qhg7zKNkw.uYNC7k/N1OAO63b4G1HayCDaEEREPLWJUOMr58jqhum', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host1', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:55', '2026-08-08 18:57:55', NULL),
(2, '17798c53-fabf-4f95-9194-4872c1fd6611', 'Host Katlyn', 'host2@example.com', NULL, '+20110702395', '$2y$12$7lU17yPoT9VhW6yweKkile2FdX2gnTNe9L4nqBVPVyqsvkJrtQNQq', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host2', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:55', '2026-08-08 18:57:55', NULL),
(3, '7190a895-a65e-43f7-b88d-cf934b76dd91', 'Host Diamond', 'host3@example.com', NULL, '+20110710372', '$2y$12$z9AG1xPLUPWbKezIBvRf2uWk95QuDsOF.QT4C4m3qNcZR4ZeHS6ca', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host3', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:55', '2026-08-08 18:57:55', NULL),
(4, '911aeba2-5cdc-4df7-9906-e0c33f97dfd8', 'Host Eleonore', 'host4@example.com', NULL, '+20110192783', '$2y$12$cvFIK7AK8/OMutqCCWs/W.BowGZTUmyi357ZWWPB4KXretyAhlUPG', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host4', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:56', '2026-08-08 18:57:56', NULL),
(5, '44fd9b76-a858-4d56-be82-8a7045d8eeeb', 'Host Hipolito', 'host5@example.com', NULL, '+20110295896', '$2y$12$77VRedQjq4oqrM2XjORJF.S1egZ.h3md0B4bz4QL.MHBbuhpgjvza', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host5', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:56', '2026-08-08 18:57:56', NULL),
(6, '531743e1-98d2-42ec-b30b-6eeb31bd480b', 'Host Everette', 'host6@example.com', NULL, '+20110741382', '$2y$12$sAz9d8UFabD7gwWXX6BVF.Yqxas8WuGGHEIFzNIJRlVm3u/S68RIK', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host6', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:56', '2026-08-08 18:57:56', NULL),
(7, 'baaee586-c248-4ed3-9ae1-ad5c1ed80fad', 'Host Pat', 'host7@example.com', NULL, '+20110988801', '$2y$12$JlX56dXnDWrkwvmQnOTymeGuFwhP6HI973dZNp5IPrbvrGrN0MFJa', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host7', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:56', '2026-08-08 18:57:56', NULL),
(8, 'f9d00d17-5b59-4822-8fbd-a7da23b8e62d', 'Host Neha', 'host8@example.com', NULL, '+20110310566', '$2y$12$uDQiBBSaGdgTk.NEuf9JB.iQAhboHNEr/n7c0WFvwBeFdMAG/UEI2', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host8', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:57', '2026-08-08 18:57:57', NULL),
(9, '771f5318-9ec5-4d1e-8254-a9bfc478ad86', 'Host Tristian', 'host9@example.com', NULL, '+20110669404', '$2y$12$dXK7qW1G5QTrF28Oicnyau/6C0OgMj/LjQoCSJi1CBxRNw5bJWdD.', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host9', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:57', '2026-08-08 18:57:57', NULL),
(10, '03d51d3b-7e04-4afe-8333-0d1f9d28334e', 'Host Rick', 'host10@example.com', NULL, '+20110105476', '$2y$12$s2qYW8Kr2v9WTN433uQhV.A4s1wTi/zIhm1fH9YyLwi/PJn/Vygxi', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host10', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:57', '2026-08-08 18:57:57', NULL),
(11, '8da69dfd-e989-41d5-906f-891c63cf20bf', 'Host Donnell', 'host11@example.com', NULL, '+20110471906', '$2y$12$Nmpdly71kF3IfjgYRgX.muPje1rPI6XFepvwc3SKq664fGN40JwGW', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host11', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:57', '2026-08-08 18:57:57', NULL),
(12, 'eaa0139f-9ec5-40f0-8b53-646919338946', 'Host Weldon', 'host12@example.com', NULL, '+20110937348', '$2y$12$1nf9txgpODE7Wua1Bj6lne.hfF90D9OhRrLrisp90PyVh3OruhkT2', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host12', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:57', '2026-08-08 18:57:57', NULL),
(13, '9b30287f-a828-42ef-a8f7-f6920ee58ee1', 'Host Charley', 'host13@example.com', NULL, '+20110669072', '$2y$12$kRWkI.Q5GgWOEryrTggij.mssLiNVOJqkCa7LR.NlKWV5CeZ1xwI2', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host13', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:58', '2026-08-08 18:57:58', NULL),
(14, '11970e6f-f2f1-46ec-bf7e-4a3f4f92e0fe', 'Host Jasen', 'host14@example.com', NULL, '+20110993686', '$2y$12$vBb9jPsCk1kVxpT4tFUIjOCY83Alk1LI3dhUSsXMED22UPO3tRuDi', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host14', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:58', '2026-08-08 18:57:58', NULL),
(15, '6ce87992-7c5a-4b5d-8ddf-c7df047ad2c1', 'Host Rodrick', 'host15@example.com', NULL, '+20110412652', '$2y$12$OC8WpFm9XH./0QnLJqDLXu7EzYPOOLOmBvmhew/CYe7CVfzEiouXy', 'admin', NULL, 'active', 'https://i.pravatar.cc/150?u=host15', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:58', '2026-08-08 18:57:58', NULL),
(16, '7c0178a5-ef03-4971-91ad-fc0f1d8c0216', 'Customer Lucinda', 'customer1@example.com', NULL, '+20120872043', '$2y$12$TJZVf68zA0bGlW51.nUSMO9/SXZ72iHjZFD7BiJ3tsuclmnF6bWAG', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer1', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:58', '2026-08-08 18:57:58', NULL),
(17, 'd6ceca1e-b107-4de2-865f-4d592516c2ad', 'Customer Lorenza', 'customer2@example.com', NULL, '+20120901952', '$2y$12$cv5GiYLq6o2e12buO3z7xeS/O2LtQF0ywgoKktxqQoUhLbjtuKj1W', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer2', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:58', '2026-08-08 18:57:58', NULL),
(18, 'cdef3241-2fa8-4074-8ab7-c7f34eba6836', 'Customer Gus', 'customer3@example.com', NULL, '+20120404748', '$2y$12$1xln4HJNE/OeAbNv4PnXuuEHAKqdNBp4.I/wS5ItdzR3XiDTFOBVa', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer3', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:59', '2026-08-08 18:57:59', NULL),
(19, 'f07040c3-4eac-4da0-87f3-96659feb678b', 'Customer Fritz', 'customer4@example.com', NULL, '+20120713349', '$2y$12$WYLdhfwtDpEFKFGrChWPEuhvQEU3al56qBXZ/vovdur4JjmyqkSdC', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer4', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:59', '2026-08-08 18:57:59', NULL),
(20, 'b9f2e011-946e-441e-9ad0-a13a7cafbd69', 'Customer Lea', 'customer5@example.com', NULL, '+20120295505', '$2y$12$cwB79bfJlZUyWoFZxkImKeJBT21sboBSeJSCYV9I1iJvpw3Xa4.Ta', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer5', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:59', '2026-08-08 18:57:59', NULL),
(21, '80159420-82c9-4b22-bc36-03093bda78ad', 'Customer Brandy', 'customer6@example.com', NULL, '+20120670235', '$2y$12$9DR2TXSZYkDD4lShJV7uHORnagGrCGJshO9SQLlhmC52N8MFSWFom', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer6', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:59', '2026-08-08 18:57:59', NULL),
(22, 'f7cea160-b702-410c-a983-0755538af53b', 'Customer Steve', 'customer7@example.com', NULL, '+20120223462', '$2y$12$7PWUulBrDxkNGvvBXWxOQukTQR6M2/T/vgMQ0czp.cicCiODYGGvu', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer7', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:57:59', '2026-08-08 18:57:59', NULL),
(23, '594803bf-3f33-40ec-8714-fda089e3707b', 'Customer Anna', 'customer8@example.com', NULL, '+20120703639', '$2y$12$64CwaAKo/LwQ.ScRzIFKJe32f4a2dAKUd34S8m7cTIrXuwG9xIAqe', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer8', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:00', '2026-08-08 18:58:00', NULL),
(24, 'df582ce8-9b97-4038-9c10-589461670401', 'Customer Efren', 'customer9@example.com', NULL, '+20120581947', '$2y$12$Uxgf4gSKpu8oVkJkqbhW3uamdySYhZpP0u4x7dlQ.uwbucBrf1BKG', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer9', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:00', '2026-08-08 18:58:00', NULL),
(25, 'a58daf67-4e4f-4e5b-91cd-786b7edfb9cc', 'Customer Magali', 'customer10@example.com', NULL, '+20120473944', '$2y$12$RHX1LH4iWmAC2sAYJOAu5uR9GDVynD/Kdd2mEAGYfrJAypzK0se9u', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer10', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:00', '2026-08-08 18:58:00', NULL),
(26, '60a7d958-8ea0-40d6-8a9e-00177f3e80f4', 'Customer Magnus', 'customer11@example.com', NULL, '+20120231723', '$2y$12$paekim8V2lFRps/Nk/W5K.PMq7OoxtrrGWTO/OBuPlaxRGHn/QStO', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer11', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:00', '2026-08-08 18:58:00', NULL),
(27, 'fe4d3f63-2c65-4a1b-b819-c6a9f68babe4', 'Customer Kali', 'customer12@example.com', NULL, '+20120410404', '$2y$12$ovix7HQ/1V.o6yWsrpuzHe6aDWAjKbQHutiNCvtxEyn9s1RWGh8KC', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer12', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:00', '2026-08-08 18:58:00', NULL),
(28, '04ede4f8-635b-4d9b-a230-04081bcec82e', 'Customer Crawford', 'customer13@example.com', NULL, '+20120815509', '$2y$12$FKUletjENsg8LjgWSRcVsOnjJn7a0px4edinWMTiddNHt71mI02rO', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer13', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:01', '2026-08-08 18:58:01', NULL),
(29, '4620b500-5f09-4f52-939d-a5803493ac0c', 'Customer Vicente', 'customer14@example.com', NULL, '+20120899623', '$2y$12$wnf7ghlDbNUZSo1frJiS4OV0o2TE9x72ucqNw5nc5UXRjC3H/wsOy', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer14', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:01', '2026-08-08 18:58:01', NULL),
(30, '64b55ada-230c-43d8-bdf8-a44f553f2228', 'Customer Karlie', 'customer15@example.com', NULL, '+20120129809', '$2y$12$6xgJjORxqWdwS/meeJc.4e9bGt2SoNmDXJLXyU9z2GwZSoTWi5mXG', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer15', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:01', '2026-08-08 18:58:01', NULL),
(31, 'a20c178f-2c25-4367-875a-4882b0be5db4', 'Customer Brian', 'customer16@example.com', NULL, '+20120100022', '$2y$12$QU6iBhzyieNTBtetplY/heU8wT.yWtC3VOzfHHdoDWCmscanEZDpK', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer16', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:01', '2026-08-08 18:58:01', NULL),
(32, 'e1f4ea5d-50b9-42d8-acdb-60055a2ef9ef', 'Customer Adelle', 'customer17@example.com', NULL, '+20120390851', '$2y$12$3NvpG3NLmPGBJHDYbGt4.eF0g8lPxfgbBhWNdj0HEG6VLTE9dChtC', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer17', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:01', '2026-08-08 18:58:01', NULL),
(33, '8b17e274-c5d3-4f25-b084-f46107efba9f', 'Customer Erica', 'customer18@example.com', NULL, '+20120724067', '$2y$12$Tlyb0UjXEgpEItfaSDVgEOhvyOIcYYTM24cGpl1AmvohPX.JoxXy2', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer18', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:02', '2026-08-08 18:58:02', NULL),
(34, '56e361c5-7aec-4ea5-8ad9-597a14f542b5', 'Customer Jovany', 'customer19@example.com', NULL, '+20120869687', '$2y$12$5utZHP8QWBc1mFSljU1UsuqekfsNPA3GUZEDwK9D7G0oDtrcS4N22', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer19', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:02', '2026-08-08 18:58:02', NULL),
(35, 'b27f432d-94e1-458c-a93b-006353ed9c6a', 'Customer Dora', 'customer20@example.com', NULL, '+20120966400', '$2y$12$wTMV87rwxThgxG2kSgN4Me.8KpxMc6u7Z52d7MH5AwF4z50Iu3BNa', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer20', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:02', '2026-08-08 18:58:02', NULL),
(36, '459d13ff-c9c6-4862-8380-6761cd136477', 'Customer Eleonore', 'customer21@example.com', NULL, '+20120620946', '$2y$12$XUA88sr6ubEmjs54FdPTvuiVcVbynsO7ZvB23S3/pzmPG/2SnXLvu', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer21', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:02', '2026-08-08 18:58:02', NULL),
(37, '3827d1d1-348d-4d10-af1d-bf200b3ba497', 'Customer Rylee', 'customer22@example.com', NULL, '+20120189105', '$2y$12$L3olimneBO7FcVJBNR5SC.ORM..Apzar2nYHKAmLMQf/lkI6oDYha', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer22', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:02', '2026-08-08 18:58:02', NULL),
(38, '8d420c94-d85e-4413-8321-481443b2a684', 'Customer Johathan', 'customer23@example.com', NULL, '+20120174226', '$2y$12$uD8FVGR6hNu8TITqKshOeOXZ7lt9uk2BiWcqX69ViaB9TbvZnXXbW', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer23', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:03', '2026-08-08 18:58:03', NULL),
(39, 'e46ab0dd-a3b3-4a41-b261-c813ef8a1621', 'Customer Jada', 'customer24@example.com', NULL, '+20120777647', '$2y$12$XHESwZJ0OlmHvuIP0oSoLeaTIesVgSEtEuFv8qchMi.g3goh9Atke', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer24', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:03', '2026-08-08 18:58:03', NULL),
(40, '3b2f49ef-7490-422b-99af-9c82e0c501df', 'Customer Lera', 'customer25@example.com', NULL, '+20120294244', '$2y$12$KSXN/Ld1rqgWUhVXx0GQ/urwVp/gAUScZ3WrQmyO6KcAT5dP9/6e6', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer25', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:03', '2026-08-08 18:58:03', NULL),
(41, 'c5319dd5-91bc-4b96-b479-3e2511dabc1f', 'Customer Louvenia', 'customer26@example.com', NULL, '+20120690833', '$2y$12$udtAyv4qX9WTHyRQ1wau8e5lOPrnbJHp8IzGefYmxBXINm1d/LQSm', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer26', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:03', '2026-08-08 18:58:03', NULL),
(42, 'a7a67e8c-e03a-4245-b6af-3fc767b8567e', 'Customer Raul', 'customer27@example.com', NULL, '+20120219028', '$2y$12$iuP5IWtLL4Yzp8.xoN13OOnkqP2bKpBuipWhiUxL9mh2KcMaWln8u', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer27', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:03', '2026-08-08 18:58:03', NULL),
(43, '1c29694c-b81d-4fd3-b95d-938df87db6e4', 'Customer Lauretta', 'customer28@example.com', NULL, '+20120771886', '$2y$12$U4EX04pIvFNeMtrFPc6vfeojiLqzb1UqNXmOjFfixRFnIcG..K.4G', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer28', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:04', '2026-08-08 18:58:04', NULL),
(44, 'dfa28b88-2253-4e6a-9410-ba7fb542bff8', 'Customer Myah', 'customer29@example.com', NULL, '+20120274963', '$2y$12$ojbZXwgMZkKqB4OSR78EtecnHck7pYQYAlfPEtp1TbGizNWZNrHmm', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer29', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:04', '2026-08-08 18:58:04', NULL),
(45, 'df639e79-119a-4a9e-9d51-46e74d79e1c6', 'Customer Janae', 'customer30@example.com', NULL, '+20120659828', '$2y$12$tqtnyR25MBf8u9DIFf8bxO2ICOoLN/DSWpPoE36ug8IjCCB1PLVrq', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer30', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:04', '2026-08-08 18:58:04', NULL),
(46, '61925be9-f941-4778-a824-c01bcacf97ec', 'Customer Lizeth', 'customer31@example.com', NULL, '+20120988476', '$2y$12$a8Y8BWyWb4JDEXmSWa2H5erveg/qD/atNniTj0mIGwNcg2u55zf8a', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer31', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:04', '2026-08-08 18:58:04', NULL),
(47, 'b3644c44-4d77-4299-b3d3-bed5bae711f0', 'Customer Ellie', 'customer32@example.com', NULL, '+20120794598', '$2y$12$j1f6M7fSA6UTeNGgyHhNWOrz1kas1D7cYGJS3HCe9iWQ2bm5gfBza', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer32', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:05', '2026-08-08 18:58:05', NULL),
(48, '1b4a7cd1-5953-485d-a0d8-cc53f9fa2b9f', 'Customer Antoinette', 'customer33@example.com', NULL, '+20120929849', '$2y$12$CldVR/L6qQ54zYnTuyG7n.VQZ6UADc6Qs1gPFTNflefk.Ryk2aAxi', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer33', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:05', '2026-08-08 18:58:05', NULL),
(49, '352ed6aa-d4e8-4362-a350-28ca228d6904', 'Customer Lucio', 'customer34@example.com', NULL, '+20120541978', '$2y$12$JTENykfj8zCp7PA8L2IOceDugKUar5IP0lI/pd3sDg0l.3MUjjBSG', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer34', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:05', '2026-08-08 18:58:05', NULL),
(50, '899da07f-1a29-4ebd-a759-08d643e14405', 'Customer Rudolph', 'customer35@example.com', NULL, '+20120705081', '$2y$12$KODUEndyekuWdygBZrZYB.ohL.TWaRCiUSRvF5tINuFcvYafy2AHG', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer35', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:05', '2026-08-08 18:58:05', NULL),
(51, '29da6407-508c-4ea8-83e8-17dffeaed4a7', 'Customer Erik', 'customer36@example.com', NULL, '+20120954427', '$2y$12$wmX3IdK2kC8CJwtr6bAlz.RqpneQefPGtTFxkBjMsyfRA/a/M0cgq', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer36', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:05', '2026-08-08 18:58:05', NULL),
(52, '2a7b3be1-a7f0-4a68-89db-ec62ff02645b', 'Customer Cary', 'customer37@example.com', NULL, '+20120289997', '$2y$12$K/AIAPV2gquzvE5Qnp/t7OJaL1y0zdN7H2wa4AdurXZDX4QZ//ylS', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer37', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:06', '2026-08-08 18:58:06', NULL),
(53, '0ef6cb11-ee5f-4128-aa3b-513fbf86dbd5', 'Customer Vivien', 'customer38@example.com', NULL, '+20120906858', '$2y$12$twOi4icCPu7WIA39cQMAa.bDJB6yUcGQBRCDVW6L8HeW6YUiFJmQi', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer38', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:06', '2026-08-08 18:58:06', NULL),
(54, 'd07b4f11-1774-4c23-8e96-0292f5f2fafa', 'Customer Jaquelin', 'customer39@example.com', NULL, '+20120369738', '$2y$12$isUuDNcs804emnwaDtPJeeT8ccKhP6OW/eYjSE2armhZU5dNNd5wG', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer39', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:06', '2026-08-08 18:58:06', NULL),
(55, '0383a00a-55ff-4be9-998e-4e41098149b4', 'Customer Hertha', 'customer40@example.com', NULL, '+20120149189', '$2y$12$zKTh1/s4wB2EBKSzRtVyfONBcew5O6UXnlbxTAforrgGnXFfcspg.', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer40', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:06', '2026-08-08 18:58:06', NULL),
(56, '458a31b2-4699-455a-9caf-59e0f798d37d', 'Customer Hugh', 'customer41@example.com', NULL, '+20120341593', '$2y$12$EkAZJQH0w7bwn36CzphNge1aHFUgRRdh7ZTshy4fOdswpOZCWtUXa', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer41', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:06', '2026-08-08 18:58:06', NULL),
(57, '27324ae7-c844-40bc-b9d5-11af8054b607', 'Customer Sydni', 'customer42@example.com', NULL, '+20120434408', '$2y$12$BPtg.L44wJEn.mLMe52M5OkoY2hj3NqvOsj.2ktSIfcl6FJD0gB2y', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer42', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:07', '2026-08-08 18:58:07', NULL),
(58, '9b4895f8-a16a-4d60-bcdf-f3748ddc4ad2', 'Customer Lizeth', 'customer43@example.com', NULL, '+20120782685', '$2y$12$ufah5aRoxZ6qoHueuAdnQu/h6BRwhgvsmF1l64ciBTR3N0g68ueZO', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer43', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:07', '2026-08-08 18:58:07', NULL),
(59, 'bdef951f-d70b-464f-9467-3510084400ee', 'Customer Alexandrea', 'customer44@example.com', NULL, '+20120158401', '$2y$12$0z0Qjgjw00YWHqRremhi1uwaLaz9mcXFYWHz0kY7GcTJ2cLa4QFT6', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer44', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:07', '2026-08-08 18:58:07', NULL),
(60, 'fab0f057-af7d-403b-924a-5182c84eddc5', 'Customer Marcia', 'customer45@example.com', NULL, '+20120484395', '$2y$12$fPHk8ZIRsVqCcf/V8EXfhex0bEvzgxr7ui2wGB0TLjJAqT4d2Hq1K', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer45', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:07', '2026-08-08 18:58:07', NULL),
(61, '133ea223-55b5-4c40-9fad-ecabda90134c', 'Customer Susana', 'customer46@example.com', NULL, '+20120328138', '$2y$12$yloFu3PXnR5OEmY8y10WGubdHe51oeQIXefawB2kSoLwyOla/p1Pe', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer46', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:07', '2026-08-08 18:58:07', NULL),
(62, '4c216e20-c521-41ff-84bf-d1dade3f4c89', 'Customer Breanna', 'customer47@example.com', NULL, '+20120835049', '$2y$12$nN2tL07vllCxKRHSqrCm6.MXuyaZoPWuumrORdy3gtOhQi9me/A86', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer47', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:08', '2026-08-08 18:58:08', NULL),
(63, '1c44695f-1bc5-405d-92b3-e36f6878b90b', 'Customer Wade', 'customer48@example.com', NULL, '+20120235496', '$2y$12$SIXhcLoyDotHbw13fU./he.6veGCsgk5v5zdzwC27eKXaQ2.rUcgS', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer48', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:08', '2026-08-08 18:58:08', NULL),
(64, '04eeb583-3ac9-47b4-9069-5336d160e513', 'Customer Watson', 'customer49@example.com', NULL, '+20120536438', '$2y$12$8prol53/DJ/ELoQeNUtviu5NMWoWSi8i3qlknOkLi47W/ZWZn2W.C', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer49', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:08', '2026-08-08 18:58:08', NULL),
(65, '43bd99f6-696a-4ba4-a4b5-cd430228c6ee', 'Customer Fausto', 'customer50@example.com', NULL, '+20120816283', '$2y$12$ucZCtLu30cBSRFjcrxgsR.mVb1e1v1DXOUXIA2V/cnOalaKbASb5W', 'customer', NULL, 'active', 'https://i.pravatar.cc/150?u=customer50', NULL, NULL, NULL, NULL, NULL, '2026-08-08 18:58:08', '2026-08-08 18:58:08', NULL),
(66, '085af8ae-631d-400a-b38b-501b11196b82', 'Platform Admin', 'admin@vistastay.com', '2026-08-08 18:58:09', NULL, '$2y$12$GL9/w9js1CQdCwrHxwt7feSJPHXRGEmkR/H7uh9UR/FnzygSzrCJ2', 'admin', NULL, 'active', NULL, '2026-08-17 08:25:38', NULL, NULL, NULL, NULL, '2026-08-08 18:58:09', '2026-08-17 08:25:38', NULL),
(67, 'a331c5c7-1966-4f3c-bddb-d6c3f85c9e57', 'Rosalind Hand', 'mayert.mohammed@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, '0tRL7VL9O8', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(68, '5a8bef37-acc0-440a-9450-269c7b6a1f4e', 'Aidan Koss PhD', 'gail.witting@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, '2UnbMRmyta', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(69, '44db8b41-7f14-48b0-9dba-5eca3681fc79', 'Trystan Rolfson', 'dgusikowski@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'MjhyUF8bPY', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(70, '3209d1a5-e737-4e2a-9e48-6cc1cb2d31f1', 'Prof. Damion Nolan DDS', 'mohr.easter@example.net', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'bP58vefcw9', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(71, 'dca44a39-2ea5-4fb9-83ce-5f3b057ebcbf', 'Cornell Smith', 'umarvin@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'joDDR0uFwr', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(72, '2fb78007-2e08-4eb9-9a67-2d1bf4dbda1c', 'Jeramy Ferry I', 'leora.oberbrunner@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, '9W2wfGelAg', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(73, 'd1569d2e-2d6f-4001-b005-639466f4efe7', 'Prof. Hilda Wolff Sr.', 'nitzsche.lonny@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, '7zd506Ve6V', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(74, 'd676991c-3fa4-453b-b003-fceb24f3d0bb', 'Chanel Wilkinson III', 'owilderman@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, '9NkWXa4D7V', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(75, 'a5203547-3720-4409-b105-1841221a4f9a', 'Abbey Mann', 'cruickshank.lorna@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, '1hCEwWnIeD', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(76, '671a1f3b-4920-48b2-bbc5-2562776b1336', 'Immanuel Rowe', 'armstrong.patricia@example.net', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'uPQum27Wcg', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(77, 'ca068dcb-d6ed-45e1-826b-d27fa7ec78c9', 'Austen Strosin', 'treva.romaguera@example.net', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'admin', NULL, 'active', NULL, NULL, NULL, NULL, 'LcOPnLrv2j', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(78, '763dc337-b69b-4392-b919-807a278f219e', 'Ms. Joyce Gibson', 'harry02@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'admin', NULL, 'active', NULL, NULL, NULL, NULL, 'ES1uxsk8q0', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(79, '5c11da7d-3aca-4d42-90fc-8e24a8cb4cd9', 'Rick Lueilwitz', 'qhammes@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'admin', NULL, 'active', NULL, NULL, NULL, NULL, 'T6WWiUWd40', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(80, '21045c09-0afd-400b-bf4e-80d87134871c', 'Arnold Lindgren', 'trace.oconner@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'admin', NULL, 'active', NULL, NULL, NULL, NULL, 'PFeyRPQCnj', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(81, '3c7cb428-ccd0-4189-b644-efe5635c8dea', 'Eugenia Jacobi', 'gwen55@example.net', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'admin', NULL, 'active', NULL, NULL, NULL, NULL, 'LjBfM4XBEy', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(82, '004f3c41-e420-484d-b1f4-e1763248d469', 'Ms. Elvie Rippin II', 'retta.oreilly@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'admin', NULL, 'active', NULL, NULL, NULL, NULL, 'SCxNF0qm99', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(83, '8f994256-fe4b-41b6-907c-f5a1b78ea290', 'Mrs. Constance Pfeffer IV', 'agnes86@example.net', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'NbfvIOTsAt', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(84, '7bb2f588-271f-4f33-830e-7e04ddf4e8ce', 'Prince Boehm III', 'thansen@example.net', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, '7EXlMdQjZT', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(85, 'bcd2b617-b6b4-4424-90e1-63f720fc24d6', 'Erick Roberts', 'jaleel.roberts@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'd8e83kjByi', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(86, '5d647f7b-03e9-40a3-86d3-c1c33650a730', 'Prof. Mark Stehr DDS', 'barrows.samir@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, '2s7JlVLsKt', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(87, 'f1abed82-70a6-4fcd-b9f7-44fda5d7a218', 'Dr. Timmothy McCullough', 'sasha06@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'XlsO6uI42R', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(88, '0eb0b744-b779-434d-9854-e858770cf94a', 'Rosamond Denesik', 'tremblay.alessandro@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'GUHGKvQ84K', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(89, '56b8b2ea-13a4-4eea-8156-b1175422534a', 'Dedrick Miller', 'joelle88@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'MFZYt14Rdd', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(90, '0e6b876e-bbd4-48c4-a9a3-0eed2e1a0b46', 'Isabell Koss', 'chauncey66@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'zTUN0h61JQ', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(91, 'e9a1d510-372b-4f33-8091-64a6d79517a9', 'Shayne Bartell', 'sandrine.mraz@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'MTaIGzWYdJ', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(92, '7aa05384-c3f1-4e6b-b0eb-37065970f0bb', 'Brando Yundt MD', 'roberts.heaven@example.net', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'kD5BmHciev', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(93, 'f1d0e0ff-87a3-4825-b51e-cb8063f5d0cc', 'Maegan Russel', 'champlin.ava@example.net', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'zsIw76HOyn', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(94, '5c2271bb-ba5e-4ac8-bc58-4fde92240294', 'Jazmyn Schuster', 'rosenbaum.earline@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'WrnFKNMaB5', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(95, 'a520329e-b3f9-46cb-a2c8-79ff82203d45', 'Miss Reanna Luettgen', 'irwin05@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'n7I7pDK70j', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(96, '2e5f6ac8-1b14-436d-8d41-cd9c68a19c1e', 'Mrs. Georgiana Emmerich V', 'mharris@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'uczeDnYJFO', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(97, '3da4ec76-0fc6-49cd-a4b4-22657f2fc6ce', 'Antonetta Weissnat Sr.', 'hschroeder@example.net', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'gbh7HXc1hm', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(98, '2033a4b2-8649-461d-b373-3a0b0ca14741', 'Dixie Hettinger', 'jose02@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'mcUcN5WXTn', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(99, '227d7616-115f-4c5d-9986-908d080d6856', 'Daphney Jerde', 'brooks70@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'KpCe9cwog0', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(100, 'd609ce37-4499-4b5b-b7a2-c70187e266cb', 'Sabryna Bergnaum', 'pkessler@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'TfLuk8evKD', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(101, '8be1c23f-856f-409b-a269-3e01c8a16e13', 'Alisha Hartmann Sr.', 'gschmitt@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'n8YUj8cghz', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(102, '31a1cbd2-742a-4426-b0b3-e4f557c16245', 'Nichole Runte V', 'brionna.legros@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'f4TPXKCH6b', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(103, '409fa51e-560b-4cc4-8652-af9f460e0da3', 'Mr. Darius Bartell I', 'wiza.woodrow@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'TMfkWA22vW', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(104, '70e28715-9ab4-4e55-88cb-1ec01b956144', 'Alexandra Wolf', 'ozella43@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'yMh2zUa73I', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(105, '7db5aaf8-7a82-4305-94fb-c3293254deeb', 'Prof. Jimmy Heidenreich', 'katrine03@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, '48gdpcbQ7P', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(106, 'f1a76441-f219-4717-b398-a5850b6a2c93', 'Dr. Rupert Gutkowski', 'grady.shany@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'P4ujk0AGbA', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(107, '8544380b-92e5-4666-890a-588f0b190c35', 'Demetris McKenzie', 'alda.schulist@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'N9BMC4IhDC', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(108, '8e58c29d-3b67-4a9f-8fae-13b7aa0a822c', 'Prof. Hugh Keebler MD', 'lesch.aliza@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, '9qVB7cXb8j', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(109, '5b5fc031-ed1e-474c-af4d-fbf8bacf1323', 'Daniela Davis Sr.', 'toney17@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'XQpgX1wtUF', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(110, 'db411580-ab68-4e00-9b9b-04a53c1f00a7', 'Minerva Flatley', 'urussel@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'wlLFGKvD07', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(111, 'd21859e1-411c-4b14-aa29-f80671469e84', 'Kiera Koepp', 'ykerluke@example.net', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'Cr4h8qLVsd', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(112, '2e2944c6-6c1d-4ffd-a70e-6fa0ed688098', 'Dan Greenfelder', 'eorn@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, '9lRAeF61YM', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(113, '4390072e-420d-43af-84b9-87a6e46c2e75', 'Lenore Parker', 'rachelle22@example.net', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'R6FuwB3DwN', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(114, '06073dc6-cc69-4a9d-9416-3cc5399e8fda', 'Chad Green MD', 'lind.spencer@example.com', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'ebuUblEhrH', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(115, '0e191776-d027-4daa-ab97-e87402a75865', 'Issac Gibson I', 'kaitlin.borer@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'QEFhRCSWAI', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(116, 'a7f05e67-fe8b-4e12-aefc-c81b947984fc', 'Carmel Marks IV', 'beer.maureen@example.net', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, 'a1AK06Q6yo', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(117, 'de9e2a57-c2ca-4fdf-a249-2b85f1d2f951', 'Emanuel Nitzsche', 'arvel.torp@example.org', '2026-08-08 18:58:09', NULL, '$2y$12$ebmvUo3ykFG.SuiSnPSDV.T71hBKHmlid.UOrbcLh3DmJVADY9UQO', 'customer', NULL, 'active', NULL, NULL, NULL, NULL, '0BOVK6yzNs', NULL, '2026-08-08 18:58:09', '2026-08-08 18:58:09', NULL),
(118, 'bc0607ec-0d03-4fe8-85c3-e27d6f88ebed', 'Usf', 'aa@aa.com', NULL, '+201183838383', '$2y$12$3qIkiUrUQNtCQH/6muiSDeqVmqLQ2fSGVrjSeRY0rENpFiH68SmD.', 'customer', NULL, 'active', NULL, '2026-08-17 08:26:25', NULL, NULL, NULL, 'ExponentPushToken[i8H1mYGI72JZN-0SmKt1sn]', '2026-08-10 14:46:22', '2026-08-19 17:21:35', NULL),
(119, '2c665adf-7f34-42af-8bb2-613d5e5ebe12', 'Admin', 'admin@admin.com', NULL, '123456789', '$2y$12$e5y1ts1tNLWevLd2rP788uAlZoLjgPOGpEYHkXaiKM.i/WT98vwmW', 'admin', NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-17 08:13:02', '2026-08-17 08:13:02', NULL),
(120, '5db84e57-b475-4b21-8bc8-09681b272f42', 'mo ahmed', 'a@aa.com', NULL, NULL, '$2y$12$fNtDjoYsUlU9Xwld6Agaw.fQ3L7CSgdhpofI/ssCAykb2L3Hjkbtq', 'admin', '[\"manage_listings\"]', 'active', NULL, '2026-08-21 05:00:01', NULL, NULL, NULL, NULL, '2026-08-21 04:59:04', '2026-08-21 05:00:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `balance_cents` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `uuid`, `user_id`, `balance_cents`, `created_at`, `updated_at`) VALUES
(1, '6f694dfc-a50c-4787-a250-348d2e326bfd', 118, 0, '2026-08-17 08:25:55', '2026-08-19 17:50:15'),
(2, 'a14c6d66-4ebb-4d3e-ad35-39c18a1e4b4b', 120, 0, '2026-08-21 04:59:04', '2026-08-21 04:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('credit','debit') NOT NULL,
  `amount_cents` bigint(20) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_transactions`
--

INSERT INTO `wallet_transactions` (`id`, `uuid`, `wallet_id`, `type`, `amount_cents`, `description`, `created_at`, `updated_at`) VALUES
(1, 'dc35072e-1112-4598-8140-65c7c1544aef', 1, 'credit', 4000, 'Admin adjustment: hh', '2026-08-17 08:25:55', '2026-08-17 08:25:55'),
(2, '6e278206-e9c9-4a66-a424-1abe9de3e2fd', 1, 'credit', 6000, 'Admin adjustment: uuu', '2026-08-17 08:32:52', '2026-08-17 08:32:52'),
(3, '27e6bda3-440f-4f1d-b049-27eadbeb2f91', 1, 'debit', 10000, 'Payment for booking VS-OEMEGSI6', '2026-08-17 08:45:21', '2026-08-17 08:45:21'),
(4, 'e2f67c3f-8995-4087-a2d3-eee764794343', 1, 'credit', 1000000, 'Admin adjustment: شحن فودافون كاش', '2026-08-19 17:22:35', '2026-08-19 17:22:35'),
(5, 'add3c0ab-d0d8-40fe-be11-b1096dda6a91', 1, 'credit', 200000, 'Admin adjustment: refund for trip canceling after a long call with long text test test test', '2026-08-19 17:31:33', '2026-08-19 17:31:33'),
(6, '3a44f7d5-1f44-45fd-9137-3f653af50c71', 1, 'credit', 100000, 'Admin adjustment: recharge', '2026-08-19 17:35:29', '2026-08-19 17:35:29'),
(7, '32b9af98-eaca-4f2a-abbd-436664e2cb52', 1, 'credit', 100000, 'Admin adjustment: manual recharge', '2026-08-19 17:35:38', '2026-08-19 17:35:38'),
(8, 'b7c4f7e2-04cf-4d89-91cd-d3d2f5473678', 1, 'debit', 594000, 'Payment for booking VS-TNVQHJUY', '2026-08-19 17:49:03', '2026-08-19 17:49:03'),
(9, '4aa3aa77-6641-4707-a5e6-7c9759147c33', 1, 'debit', 806000, 'Payment for booking VS-7JBXQUHA', '2026-08-19 17:50:15', '2026-08-19 17:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `listing_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `listing_id`, `created_at`, `updated_at`) VALUES
(1, 118, 1, '2026-08-17 09:20:27', '2026-08-17 09:20:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `availability_blocks`
--
ALTER TABLE `availability_blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `availability_blocks_blocked_by_user_id_foreign` (`blocked_by_user_id`),
  ADD KEY `availability_blocks_listing_id_start_date_end_date_index` (`listing_id`,`start_date`,`end_date`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `bookings_booking_reference_unique` (`booking_reference`),
  ADD KEY `bookings_listing_id_check_in_date_check_out_date_index` (`listing_id`,`check_in_date`,`check_out_date`),
  ADD KEY `bookings_customer_id_status_index` (`customer_id`,`status`),
  ADD KEY `bookings_promo_code_id_foreign` (`promo_code_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `destinations_uuid_unique` (`uuid`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `listings_uuid_unique` (`uuid`),
  ADD KEY `listings_created_by_index` (`created_by`),
  ADD KEY `listings_city_type_status_index` (`city`,`type`,`status`),
  ADD KEY `listings_status_index` (`status`);

--
-- Indexes for table `listing_amenity`
--
ALTER TABLE `listing_amenity`
  ADD PRIMARY KEY (`listing_id`,`amenity_id`),
  ADD KEY `listing_amenity_amenity_id_foreign` (`amenity_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_entity_type_entity_id_index` (`entity_type`,`entity_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_uuid_unique` (`uuid`),
  ADD KEY `payments_booking_id_index` (`booking_id`),
  ADD KEY `payments_gateway_transaction_id_index` (`gateway_transaction_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `platform_settings`
--
ALTER TABLE `platform_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `platform_settings_key_unique` (`key`);

--
-- Indexes for table `potential_clients`
--
ALTER TABLE `potential_clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `potential_clients_uuid_unique` (`uuid`),
  ADD KEY `potential_clients_user_id_foreign` (`user_id`),
  ADD KEY `potential_clients_listing_id_foreign` (`listing_id`);

--
-- Indexes for table `promo_codes`
--
ALTER TABLE `promo_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promo_codes_code_unique` (`code`),
  ADD KEY `promo_codes_code_is_active_index` (`code`,`is_active`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_uuid_unique` (`uuid`),
  ADD KEY `reviews_reviewer_id_foreign` (`reviewer_id`),
  ADD KEY `reviews_listing_id_status_index` (`listing_id`,`status`),
  ADD KEY `reviews_booking_id_index` (`booking_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_uuid_unique` (`uuid`),
  ADD KEY `users_role_status_index` (`role`,`status`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wallets_uuid_unique` (`uuid`),
  ADD KEY `wallets_user_id_foreign` (`user_id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wallet_transactions_uuid_unique` (`uuid`),
  ADD KEY `wallet_transactions_wallet_id_foreign` (`wallet_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_listing_id_unique` (`user_id`,`listing_id`),
  ADD KEY `wishlists_listing_id_foreign` (`listing_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `availability_blocks`
--
ALTER TABLE `availability_blocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `platform_settings`
--
ALTER TABLE `platform_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `potential_clients`
--
ALTER TABLE `potential_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `promo_codes`
--
ALTER TABLE `promo_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `availability_blocks`
--
ALTER TABLE `availability_blocks`
  ADD CONSTRAINT `availability_blocks_blocked_by_user_id_foreign` FOREIGN KEY (`blocked_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `availability_blocks_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_promo_code_id_foreign` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_codes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `listings`
--
ALTER TABLE `listings`
  ADD CONSTRAINT `listings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `listing_amenity`
--
ALTER TABLE `listing_amenity`
  ADD CONSTRAINT `listing_amenity_amenity_id_foreign` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `listing_amenity_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `potential_clients`
--
ALTER TABLE `potential_clients`
  ADD CONSTRAINT `potential_clients_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `potential_clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
