-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Bulan Mei 2026 pada 03.54
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bengkel_mobil`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `customer_vehicle_model` varchar(255) NOT NULL,
  `customer_license_plate` varchar(255) NOT NULL,
  `customer_vehicle_color` varchar(255) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `status` enum('pending','confirmed','in_progress','completed','cancelled') NOT NULL,
  `complaint` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `vehicle_id`, `customer_vehicle_model`, `customer_license_plate`, `customer_vehicle_color`, `booking_date`, `booking_time`, `status`, `complaint`, `created_at`, `updated_at`) VALUES
(2, 6, 5, '1.3 E', 'B 1111 RAA', 'Putih', '2026-12-12', '12:12:00', 'completed', 'asdads', '2026-04-09 23:50:51', '2026-04-11 03:22:59'),
(3, 6, 6, '1.3 A', 'A 099 RPP', 'hitam', '2026-04-13', '10:10:00', 'completed', 'ganti Oli', '2026-04-10 09:02:43', '2026-04-10 09:06:38'),
(4, 6, 7, '1.3 E', 'Z 40 AP', 'hitam', '2026-12-04', '12:00:00', 'completed', 'GAnti oli', '2026-04-11 06:33:30', '2026-04-11 06:35:14'),
(5, 11, 8, 'Toyota', 'A 009 ARZ', 'hitam', '2026-12-04', '10:00:00', 'completed', 'Ganti Oli', '2026-04-12 03:35:12', '2026-04-12 21:00:38'),
(6, 6, 9, '1.3 E', 'A 099 RPP', 'Putih', '2026-04-13', '10:55:00', 'completed', '\\sjgkjgf', '2026-04-12 20:56:08', '2026-04-20 02:13:28'),
(7, 11, 10, 'innova', 'Q 1291 PP', 'Putih', '2026-04-14', '12:00:00', 'completed', 'Ganti oli dan air radiaotr', '2026-04-12 21:10:32', '2026-04-12 23:58:51'),
(8, 12, 11, 'innova', 'Q 1291 PP', 'hitam', '2026-04-13', '11:18:00', 'completed', 'bocor', '2026-04-12 21:18:33', '2026-04-12 21:51:59'),
(9, 11, 12, 'Alphard', 'A 187 |RXZ', 'hitam', '2026-04-16', '10:00:00', 'completed', 'Ganti Oli', '2026-04-13 00:47:49', '2026-04-13 00:51:04'),
(10, 11, 13, 'Alphard', 'B 999 P', 'Putih', '2026-04-18', '10:00:00', 'completed', 'Ganti Air radiator', '2026-04-16 17:22:40', '2026-04-16 17:24:10'),
(11, 11, 14, 'CR - V', 'Q 123 PP', 'hitam', '2026-05-20', '10:00:00', 'completed', 'Ganti Oli', '2026-04-20 02:11:11', '2026-04-20 02:20:46'),
(12, 14, 15, 'innova', 'Q 123 WW', 'hitam', '2026-05-01', '12:12:00', 'completed', 'Servis Mobil', '2026-04-30 04:03:10', '2026-04-30 05:35:48'),
(13, 15, 16, 'Alphard', 'Z 123 P', 'Putih', '2026-05-03', '12:00:00', 'completed', 'Mesin berat saat dijalan', '2026-05-01 23:18:00', '2026-05-01 23:21:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking_services`
--

CREATE TABLE `booking_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `booking_services`
--

INSERT INTO `booking_services` (`id`, `booking_id`, `service_id`, `price`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 300000.00, '2026-04-09 23:50:51', '2026-04-09 23:50:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `jenis_vehicles`
--

CREATE TABLE `jenis_vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jenis_vehicles`
--

INSERT INTO `jenis_vehicles` (`id`, `user_id`, `brand`, `created_at`, `updated_at`) VALUES
(4, 3, 'Toyota', '2026-04-11 04:26:54', '2026-04-11 04:26:54'),
(5, 3, 'Honda', '2026-04-19 21:01:17', '2026-04-19 21:01:17'),
(6, 3, 'Nissan', '2026-04-19 21:01:26', '2026-04-19 21:01:26'),
(7, 3, 'Suzuki', '2026-04-19 21:01:41', '2026-04-19 21:01:41'),
(8, 3, 'Mazda', '2026-04-19 21:01:59', '2026-04-19 21:01:59'),
(9, 3, 'Lexus', '2026-04-19 21:02:17', '2026-04-19 21:02:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
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
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_01_132335_create_vehicles_table', 1),
(5, '2026_04_01_132404_create_services_table', 1),
(6, '2026_04_01_132410_create_bookings_table', 1),
(7, '2026_04_01_132427_create_transactions_table', 1),
(8, '2026_04_01_132434_create_payments_table', 1),
(9, '2026_04_01_132440_create_spareparts_table', 1),
(10, '2026_04_01_135944_create_booking_services_table', 1),
(11, '2026_04_01_140105_create_transaction_spareparts_table', 1),
(12, '2026_04_03_000000_create_site_contents_table', 2),
(13, '2026_04_08_000001_update_roles_and_transactions_for_staff_flow', 3),
(14, '2026_04_08_000002_split_vehicle_master_and_customer_vehicle_details', 4),
(15, '2026_04_10_090000_create_jenis_vehicles_table', 5),
(16, '2026_04_10_091000_seed_default_services', 6),
(17, '2026_04_10_100000_add_cashier_fields_to_transactions_table', 7),
(18, '2026_04_10_103000_add_cashier_ready_fields_to_transactions_table', 8),
(19, '2026_04_10_110000_add_customer_payment_fields_to_payments_table', 9),
(20, '2026_04_11_090000_add_midtrans_fields_to_payments_table', 10),
(21, '2026_04_12_090000_add_profile_photo_to_users_table', 11),
(22, '2026_04_20_113155_add_purchase_prices_to_spareparts_and_transaction_spareparts', 12),
(23, '2026_04_20_122500_add_more_hero_fields_to_site_contents_table', 13),
(24, '2026_04_20_130000_create_service_reviews_table', 14),
(25, '2026_04_30_120000_add_email_otp_columns_to_users_table', 15),
(26, '2026_04_30_150000_add_payment_ready_notified_at_to_payments_table', 16),
(27, '2026_05_02_090000_add_invoice_emailed_at_to_payments_table', 17);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `payment_date` date NOT NULL,
  `amount_paid` decimal(12,2) NOT NULL,
  `payment_method` enum('cash','transfer','qris') NOT NULL,
  `payment_status` enum('unpaid','partial','paid') NOT NULL,
  `payer_name` varchar(255) DEFAULT NULL,
  `payer_notes` text DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `payment_ready_notified_at` timestamp NULL DEFAULT NULL,
  `invoice_emailed_at` timestamp NULL DEFAULT NULL,
  `midtrans_order_id` varchar(255) DEFAULT NULL,
  `midtrans_transaction_id` varchar(255) DEFAULT NULL,
  `midtrans_status` varchar(255) DEFAULT NULL,
  `snap_token` text DEFAULT NULL,
  `midtrans_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`midtrans_response`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`id`, `transaction_id`, `payment_date`, `amount_paid`, `payment_method`, `payment_status`, `payer_name`, `payer_notes`, `submitted_at`, `payment_ready_notified_at`, `invoice_emailed_at`, `midtrans_order_id`, `midtrans_transaction_id`, `midtrans_status`, `snap_token`, `midtrans_response`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-04-10', 190000.00, 'cash', 'paid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-10 09:24:39', '2026-04-10 09:24:39'),
(2, 1, '2026-04-11', 620000.00, 'cash', 'paid', 'ahmad', 'SUdah cash yaa', '2026-04-11 03:34:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-11 03:23:57', '2026-04-11 03:34:02'),
(3, 3, '2026-04-12', 160000.00, 'transfer', 'paid', 'ahmad', NULL, '2026-04-12 01:45:51', NULL, NULL, 'TRX-3-01KP0DSCAJMRFK22CT79CBH5YP', 'A12026041208452729s7mLsYzyID', 'settlement', '90e9ec97-f74f-42fa-831d-8ffcfed119d8', '{\"status_code\":\"200\",\"transaction_id\":\"A12026041208452729s7mLsYzyID\",\"gross_amount\":\"160000.00\",\"currency\":\"IDR\",\"order_id\":\"A12026041208452729s7mLsYzyID\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"0cb644f4e85a11b150c29c9e448c9fd2f12889d611d2f0fdb0af42f7ea07c5836db772bd50b182c3a57c09231c8977a0625ce8d6db513100909f80f2aae98d4d\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"M940734373\",\"va_numbers\":[{\"bank\":\"bsi\",\"va_number\":\"34373777987913009\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-04-12 15:45:27\",\"settlement_time\":\"2026-04-12 15:45:39\",\"expiry_time\":\"2026-04-13 15:45:27\"}', '2026-04-11 06:36:26', '2026-04-12 01:45:51'),
(4, 4, '2026-04-13', 240000.00, 'qris', 'paid', 'Zio', NULL, '2026-04-12 21:03:06', NULL, NULL, 'TRX-4-01KP2G2W88CW12RCTSH3ND8DQG', 'f475242f-b4a5-4644-9819-398078075e3a', 'settlement', '53e5eae2-4842-4d1c-a9e6-d3054a797fe5', '{\"status_code\":\"200\",\"transaction_id\":\"f475242f-b4a5-4644-9819-398078075e3a\",\"gross_amount\":\"240000.00\",\"currency\":\"IDR\",\"order_id\":\"TRX-4-01KP2G2W88CW12RCTSH3ND8DQG\",\"payment_type\":\"qris\",\"signature_key\":\"fbcede4759af5ec0ac4b147f8eec8d505335f99223087fbb3a3699c2914b467bb93920fcbeb9fa2eaac206f7143f75c757757e8f86f42cb1a20d6a9b4932db91\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"M940734373\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2026-04-13 11:02:40\",\"settlement_time\":\"2026-04-13 11:02:57\",\"expiry_time\":\"2026-04-13 11:17:40\"}', '2026-04-12 21:02:04', '2026-04-12 21:03:06'),
(5, 6, '2026-04-13', 0.00, 'transfer', 'unpaid', 'nurul', NULL, NULL, NULL, NULL, 'TRX-6-01KP2T03D99Z4YAD9YV2VMVZBY', NULL, 'pending', '0a41fe7e-ebc3-4cae-9d66-7ed542156a33', '{\"transaction_details\":{\"order_id\":\"TRX-6-01KP2T03D99Z4YAD9YV2VMVZBY\",\"gross_amount\":20000},\"customer_details\":{\"first_name\":\"nurul\",\"email\":\"nurul@gmail.com\",\"phone\":null},\"item_details\":[{\"id\":\"service-6\",\"price\":20000,\"quantity\":1,\"name\":\"Tagihan Servis #6\"}],\"callbacks\":{\"finish\":\"http:\\/\\/127.0.0.1:8000\\/payments\"}}', '2026-04-12 22:45:17', '2026-04-12 23:55:52'),
(6, 7, '2026-04-13', 440000.00, 'qris', 'paid', 'Zio', NULL, '2026-04-13 00:15:12', NULL, NULL, 'TRX-7-01KP2T8NXMJKCHKMFPJAKRRNGD', 'bb13f0f7-05d9-4d1b-a659-a5d5d91a593b', 'settlement', 'e9d5e32f-1c18-4904-a740-ad0c7c4bbd2b', '{\"transaction_status\":\"settlement\",\"payment_type\":\"qris\",\"transaction_id\":\"bb13f0f7-05d9-4d1b-a659-a5d5d91a593b\",\"order_id\":\"TRX-7-01KP2T8NXMJKCHKMFPJAKRRNGD\",\"gross_amount\":\"440000.00\",\"fraud_status\":\"accept\"}', '2026-04-13 00:00:05', '2026-04-13 00:15:12'),
(7, 8, '2026-04-13', 290000.00, 'qris', 'paid', 'Zio', NULL, '2026-04-13 00:55:10', NULL, NULL, 'TRX-8-01KP2XBS52BQEPHYREEQGGQ1HZ', '5377a575-7f2c-4df8-805f-cceb049f4696', 'settlement', '64762c22-c59a-493e-83eb-09e53f305d6b', '{\"status_code\":\"200\",\"transaction_id\":\"5377a575-7f2c-4df8-805f-cceb049f4696\",\"gross_amount\":\"290000.00\",\"currency\":\"IDR\",\"order_id\":\"TRX-8-01KP2XBS52BQEPHYREEQGGQ1HZ\",\"payment_type\":\"qris\",\"signature_key\":\"8f9eb864dcf14816ecb4a5dc8463b4934c398eae8ae352f337d5840d2ccfe23e6f4d0a25645e97361a9727b4d1d20afe15b53ef69a4569ee2c24bb4c2183be8c\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"M940734373\",\"transaction_type\":\"on-us\",\"issuer\":\"gopay\",\"acquirer\":\"gopay\",\"transaction_time\":\"2026-04-13 14:54:47\",\"settlement_time\":\"2026-04-13 14:55:02\",\"expiry_time\":\"2026-04-13 15:09:47\"}', '2026-04-13 00:52:35', '2026-04-13 00:55:10'),
(8, 9, '2026-04-17', 300000.00, 'qris', 'paid', 'Zio', NULL, '2026-04-16 17:26:24', NULL, NULL, 'TRX-9-01KPCD8Q8TMHXGN0CSPNQKRV80', '7b315e86-eda9-4e79-b8a0-d7529bf2960c', 'settlement', '5d44fbbf-2f01-4417-a569-308eeacf48aa', '{\"transaction_status\":\"settlement\",\"payment_type\":\"qris\",\"transaction_id\":\"7b315e86-eda9-4e79-b8a0-d7529bf2960c\",\"order_id\":\"TRX-9-01KPCD8Q8TMHXGN0CSPNQKRV80\",\"gross_amount\":\"300000.00\",\"fraud_status\":\"accept\"}', '2026-04-16 17:25:15', '2026-04-16 17:26:24'),
(9, 5, '2026-04-20', 0.00, 'transfer', 'unpaid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-20 02:19:10', '2026-04-20 02:19:10'),
(10, 10, '2026-04-20', 340000.00, 'transfer', 'paid', 'Zio', NULL, '2026-04-20 02:23:18', NULL, NULL, 'TRX-10-01KPN367RY7TQRYK1Y0J255EKB', '07594e06-dcec-4fcc-8da3-3a801047f148', 'settlement', 'afbbceb1-21ef-4336-aefa-feaa5bc3e6e2', '{\"transaction_status\":\"settlement\",\"payment_type\":\"bank_transfer\",\"transaction_id\":\"07594e06-dcec-4fcc-8da3-3a801047f148\",\"order_id\":\"TRX-10-01KPN367RY7TQRYK1Y0J255EKB\",\"gross_amount\":\"340000.00\",\"fraud_status\":\"accept\"}', '2026-04-20 02:21:55', '2026-04-20 02:23:18'),
(11, 11, '2026-04-30', 740000.00, 'qris', 'paid', 'Ahmad Rafii Santika', NULL, '2026-04-30 06:02:38', '2026-04-30 05:42:12', NULL, 'TRX-11-01KQF7Q4W13H0HQR43BH0WGWRN', 'a46d4c01-13e4-4096-b38b-4b4ce2f8759d', 'settlement', '210f9c73-fb0b-401b-accf-09142d77eb67', '{\"transaction_status\":\"settlement\",\"payment_type\":\"qris\",\"transaction_id\":\"a46d4c01-13e4-4096-b38b-4b4ce2f8759d\",\"order_id\":\"TRX-11-01KQF7Q32CR5GMP6M6XF3KH7FT\",\"gross_amount\":\"740000.00\",\"fraud_status\":\"accept\"}', '2026-04-30 05:42:07', '2026-04-30 06:02:38'),
(12, 12, '2026-05-02', 100000.00, 'transfer', 'paid', 'Akhmad', NULL, '2026-05-01 23:31:14', '2026-05-01 23:22:55', '2026-05-01 23:31:08', 'TRX-12-01KQKP2XA9Z9KJ5G5WRVFEZC3G', 'c80ee69f-bbd9-4e94-9073-7e61cce36aaa', 'settlement', '5298fbb4-c21c-4f0b-8b27-9c0e913e35b3', '{\"status_code\":\"200\",\"transaction_id\":\"c80ee69f-bbd9-4e94-9073-7e61cce36aaa\",\"gross_amount\":\"100000.00\",\"currency\":\"IDR\",\"order_id\":\"TRX-12-01KQKP2XA9Z9KJ5G5WRVFEZC3G\",\"payment_type\":\"bank_transfer\",\"signature_key\":\"048d474fe399d04fd68b2c79ac0f1f1dea4064f674370ac4199f5f39b5c7cf9c132054675afc038b1cbda5dd25eb8cb6fac07a2a44b19337f721f33c285bc429\",\"transaction_status\":\"settlement\",\"fraud_status\":\"accept\",\"status_message\":\"Success, transaction is found\",\"merchant_id\":\"M940734373\",\"va_numbers\":[{\"bank\":\"bca\",\"va_number\":\"34373240422483341552599\"}],\"payment_amounts\":[],\"transaction_time\":\"2026-05-02 13:30:19\",\"settlement_time\":\"2026-05-02 13:30:42\",\"expiry_time\":\"2026-05-03 13:30:19\"}', '2026-05-01 23:22:50', '2026-05-01 23:31:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `estimated_time` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `services`
--

INSERT INTO `services` (`id`, `service_name`, `price`, `estimated_time`, `created_at`, `updated_at`) VALUES
(1, 'Ganti Oli', 150000.00, 30, '2026-04-09 23:44:51', '2026-04-09 23:44:51'),
(2, 'Tune Up', 350000.00, 90, '2026-04-09 23:44:51', '2026-04-09 23:44:51'),
(3, 'Servis Rem', 250000.00, 60, '2026-04-09 23:44:51', '2026-04-09 23:44:51'),
(4, 'Servis AC', 300000.00, 75, '2026-04-09 23:44:51', '2026-04-09 23:44:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `service_reviews`
--

CREATE TABLE `service_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `review_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `service_reviews`
--

INSERT INTO `service_reviews` (`id`, `transaction_id`, `user_id`, `rating`, `review_text`, `created_at`, `updated_at`) VALUES
(1, 10, 11, 5, 'Pengerjaan nya sangat cepat sekali', '2026-04-20 02:23:56', '2026-04-20 02:23:56'),
(2, 11, 14, 5, 'Pengerjaannya sangat rapih dan cepat sekali', '2026-05-01 00:02:45', '2026-05-01 00:02:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
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
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7JnUGIJnWI0AhegWk5IWcmMMrAJePzFyBr152fzb', NULL, '127.0.0.1', 'Veritrans', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUXVhcVc2cW9MZ0d4dmh2Y1RxUzhOUW1BQTNLSElNUEdDS3RSOGhCTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777703445),
('AWOmzvpz84mIaRF2ZnQohEhwYKND3a6PQX177dk7', NULL, '127.0.0.1', 'Veritrans', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoidG1UWWxpQm9BN1ZhamJ3TW5ONEF5ZVE3dmNNVDBaOWN6YTlRS1ZqRSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777703422),
('bXUE9PRsVMBkFlTNfhylPblaGRSMDbPvaWtjr6Ww', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYnoyTHg4YnplMTdpSUlxcFNKa1BzeE01bEVKamtFVmVEamVTZjZjQSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3BheW1lbnRzIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777770853),
('HCl1yB33YVF77dleDedfzB7zUHleha3minxEFePH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTFFmd3hKZUFaV0hVUG01MXZEV2J5RFRweFJlRklpOHRDbnVIWndFVyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Jldmlld3MiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777638361),
('PKvErHlXr4ylfiehLrrUokYpnopTtVSJFB8Vn8K4', 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVjJnWkhqTXB0dkxSaVZOcmxJYTlRVWRBTWdCR0R6S29NOFBtN1FnbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wYXltZW50cyI7czo1OiJyb3V0ZSI7czoxNDoicGF5bWVudHMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNTt9', 1777703478),
('q3j8Kdeybif4U1aZpXMQVh54SYxubCGJdLZpwGp6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieGp0eklxcEZEUUJlWDdGdVlDUlpHSEhCMmhaRU5UNjR5eG84NWZQcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7czo1OiJyb3V0ZSI7czo4OiJyZWdpc3RlciI7fX0=', 1777797169),
('uzgCZ718BR2HhOIfU8ujy19Fi67KyGPmOdoYlbBE', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidEd2eEtobDhPbThCS25qa2NZa0hzQVRqQXVHMTFrYlp4RnpUM21IeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1778000415);

-- --------------------------------------------------------

--
-- Struktur dari tabel `site_contents`
--

CREATE TABLE `site_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hero_badge` varchar(255) DEFAULT NULL,
  `hero_title` varchar(255) DEFAULT NULL,
  `hero_subtitle` varchar(255) DEFAULT NULL,
  `hero_description` text DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `hero_primary_cta_text` varchar(255) DEFAULT NULL,
  `hero_primary_cta_link` varchar(255) DEFAULT NULL,
  `hero_secondary_cta_text` varchar(255) DEFAULT NULL,
  `hero_secondary_cta_link` varchar(255) DEFAULT NULL,
  `hero_highlight_1` varchar(255) DEFAULT NULL,
  `hero_highlight_2` varchar(255) DEFAULT NULL,
  `hero_highlight_3` varchar(255) DEFAULT NULL,
  `about_text` text DEFAULT NULL,
  `extra_info` text DEFAULT NULL,
  `gallery_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery_images`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `site_contents`
--

INSERT INTO `site_contents` (`id`, `hero_badge`, `hero_title`, `hero_subtitle`, `hero_description`, `hero_image`, `hero_primary_cta_text`, `hero_primary_cta_link`, `hero_secondary_cta_text`, `hero_secondary_cta_link`, `hero_highlight_1`, `hero_highlight_2`, `hero_highlight_3`, `about_text`, `extra_info`, `gallery_images`, `created_at`, `updated_at`) VALUES
(1, 'Servis Mobil Tepercaya', 'Bengkel Mobil', 'Servis terpercaya untuk kendaraan Anda', 'Perawatan berkala, pengecekan menyeluruh, dan penggantian sparepart dengan proses yang rapi dan transparan.', 'site/cmLDKZ66UBeV9tQ2sRXAkKR3qFEFlO6aOTPU03xX.jpg', 'bookings', '/bookings', 'Tentang Bengkel', '#about', 'Mekanik berpengalaman', 'Sparepart berkualitas', 'Booking cepat dan mudah', 'Kami melayani perawatan dan perbaikan mobil dengan mekanik berpengalaman.', 'Jam operasional: Senin–Sabtu 08:00–20:00', '[\"site\\/gallery\\/ngfQ3nF3xlKsBzYlq8tp5f9oUTePTIWgQRhekwj2.png\",\"site\\/gallery\\/lCwKpLWypxTCN18bfQlrmLSI6ZamFQJRYZBGVQ2W.jpg\"]', '2026-04-02 21:14:16', '2026-04-20 03:14:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `spareparts`
--

CREATE TABLE `spareparts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `purchase_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `spareparts`
--

INSERT INTO `spareparts` (`id`, `name`, `stock`, `purchase_price`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Sock', 7, 20000.00, 20000.00, '2026-04-10 05:40:31', '2026-04-10 09:04:30'),
(2, 'Air radiator', 12, 200000.00, 250000.00, '2026-04-11 04:26:33', '2026-04-30 04:23:20'),
(3, 'Oli', 12, 60000.00, 60000.00, '2026-04-11 04:30:19', '2026-04-30 04:23:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `mekanik_id` bigint(20) UNSIGNED NOT NULL,
  `kasir_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_service` decimal(12,2) NOT NULL DEFAULT 0.00,
  `manual_service_name` varchar(255) DEFAULT NULL,
  `manual_service_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cashier_notes` text DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `cashier_ready_at` timestamp NULL DEFAULT NULL,
  `total_sparepart` decimal(12,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `work_summary` text DEFAULT NULL,
  `work_recommendation` text DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `booking_id`, `mekanik_id`, `kasir_id`, `total_service`, `manual_service_name`, `manual_service_price`, `cashier_notes`, `processed_at`, `cashier_ready_at`, `total_sparepart`, `grand_total`, `work_summary`, `work_recommendation`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 2, 7, 9, 600000.00, NULL, 300000.00, NULL, '2026-04-11 03:23:57', '2026-04-11 03:22:59', 20000.00, 620000.00, 'servis tone up', 'mandiin aja trs mobilnya', '2026-04-11 03:22:59', '2026-04-10 05:28:31', '2026-04-11 03:23:57'),
(2, 3, 7, 9, 150000.00, NULL, 150000.00, NULL, '2026-04-10 09:24:39', '2026-04-10 09:06:38', 240000.00, 390000.00, 'Ganti Oli', 'Servis Ganti oli sebulan sekali', '2026-04-10 09:06:38', '2026-04-10 09:03:20', '2026-04-12 03:37:18'),
(3, 4, 7, 9, 100000.00, NULL, 100000.00, 'QRIS', '2026-04-11 06:36:27', '2026-04-11 06:35:14', 60000.00, 160000.00, 'ganti oli', '1 bulan sekali ganti oli supaya ga kering', '2026-04-11 06:35:14', '2026-04-11 06:34:17', '2026-04-11 06:36:27'),
(4, 5, 7, 9, 60000.00, 'Ganti Oli', 60000.00, 'Harga 60 ribu', '2026-04-12 21:02:04', '2026-04-12 21:00:38', 180000.00, 240000.00, 'Ganti Oli', '! bulan sekali ganti', '2026-04-12 21:00:38', '2026-04-12 03:35:48', '2026-04-12 21:02:04'),
(5, 6, 7, 9, 100000.00, NULL, 100000.00, NULL, '2026-04-20 02:19:10', '2026-04-20 02:13:28', 1000000.00, 1100000.00, 'ganti air radiator', NULL, '2026-04-20 02:13:28', '2026-04-12 21:11:16', '2026-04-20 02:19:10'),
(6, 8, 7, 9, 20000.00, NULL, 20000.00, NULL, '2026-04-12 22:45:23', '2026-04-12 21:51:59', 0.00, 20000.00, 'Ban Bocor', 'pake ban truk', '2026-04-12 21:51:59', '2026-04-12 21:51:11', '2026-04-12 22:45:23'),
(7, 7, 7, 9, 120000.00, NULL, 120000.00, 'Total 200 ribu rupiah', '2026-04-13 00:00:05', '2026-04-12 23:58:51', 320000.00, 440000.00, 'Ganti Oli dan air radiator', '1 bulan sekali ganti oli', '2026-04-12 23:58:51', '2026-04-12 23:57:18', '2026-04-13 00:00:05'),
(8, 9, 7, 9, 50000.00, 'Ganti Oli', 50000.00, 'Totalnya 50 ribu rupiah', '2026-04-13 00:52:57', '2026-04-13 00:51:04', 240000.00, 290000.00, 'Ganti Oli', 'Ganti Ban karena sudah botak', '2026-04-13 00:51:04', '2026-04-13 00:48:42', '2026-04-13 00:52:57'),
(9, 10, 7, 9, 100000.00, 'Ganti Air Radiator', 100000.00, 'Jasa 100 ribu', '2026-04-16 17:25:15', '2026-04-16 17:24:10', 200000.00, 300000.00, 'Ganti Air Radiator', 'Nothings', '2026-04-16 17:24:10', '2026-04-16 17:23:28', '2026-04-16 17:25:15'),
(10, 11, 7, 9, 100000.00, NULL, 100000.00, NULL, '2026-04-20 02:22:00', '2026-04-20 02:20:46', 240000.00, 340000.00, 'Ganti Oli', '-', '2026-04-20 02:20:46', '2026-04-20 02:13:38', '2026-04-20 02:22:00'),
(11, 12, 7, 9, 250000.00, 'Ganti Oli dan air radiator', 250000.00, 'jasa Oli dan air radiator 250 ribu', '2026-04-30 05:42:07', '2026-04-30 05:35:48', 490000.00, 740000.00, 'Ganti Oli\r\nGanti Air Radiuator', 'tidak ada', '2026-04-30 05:35:48', '2026-04-30 04:22:12', '2026-04-30 05:42:07'),
(12, 13, 7, 9, 100000.00, 'Servis Mesin', 100000.00, 'Jasa servis mesin total 100 ribu', '2026-05-01 23:22:50', '2026-05-01 23:21:42', 0.00, 100000.00, 'Servis Mesin', 'tidak ada', '2026-05-01 23:21:42', '2026-05-01 23:18:50', '2026-05-01 23:22:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_spareparts`
--

CREATE TABLE `transaction_spareparts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `sparepart_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `purchase_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaction_spareparts`
--

INSERT INTO `transaction_spareparts` (`id`, `transaction_id`, `sparepart_id`, `qty`, `price`, `purchase_price`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 20000.00, 20000.00, 20000.00, '2026-04-10 08:47:37', '2026-04-10 08:47:37'),
(2, 2, 1, 2, 20000.00, 20000.00, 40000.00, '2026-04-10 09:04:30', '2026-04-10 09:04:30'),
(3, 3, 3, 1, 60000.00, 60000.00, 60000.00, '2026-04-11 06:34:42', '2026-04-11 06:34:42'),
(4, 4, 3, 3, 60000.00, 60000.00, 180000.00, '2026-04-12 03:36:28', '2026-04-12 21:00:32'),
(5, 2, 2, 1, 200000.00, 200000.00, 200000.00, '2026-04-12 03:37:18', '2026-04-12 03:37:18'),
(6, 5, 2, 5, 200000.00, 200000.00, 1000000.00, '2026-04-12 21:14:14', '2026-04-12 21:14:14'),
(7, 7, 2, 1, 200000.00, 200000.00, 200000.00, '2026-04-12 23:58:01', '2026-04-12 23:58:01'),
(8, 7, 3, 2, 60000.00, 60000.00, 120000.00, '2026-04-12 23:58:21', '2026-04-12 23:58:21'),
(9, 8, 3, 4, 60000.00, 60000.00, 240000.00, '2026-04-13 00:49:38', '2026-04-13 00:49:47'),
(10, 9, 2, 1, 200000.00, 200000.00, 200000.00, '2026-04-16 17:23:37', '2026-04-16 17:23:37'),
(11, 10, 3, 4, 60000.00, 60000.00, 240000.00, '2026-04-20 02:16:39', '2026-04-20 02:16:39'),
(12, 11, 2, 1, 250000.00, 200000.00, 250000.00, '2026-04-30 04:23:20', '2026-04-30 04:23:20'),
(13, 11, 3, 4, 60000.00, 60000.00, 240000.00, '2026-04-30 04:23:29', '2026-04-30 04:23:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `email_otp_code` varchar(255) DEFAULT NULL,
  `email_otp_expires_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','mekanik','kasir','customer','owner') NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_photo_path` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `email_otp_code`, `email_otp_expires_at`, `password`, `role`, `phone`, `address`, `profile_photo_path`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Administrator', 'admin@bengkel.test', NULL, NULL, NULL, '$2y$12$mdSgF0Q8ZBfzVUoxx84tRupeeGNKWSQS4DPUWSwCKkMAXeAuq0YKe', 'admin', NULL, NULL, NULL, NULL, '2026-04-02 21:30:26', '2026-04-10 08:27:40'),
(3, 'Admin Utama', 'admin123@gmail.com', NULL, NULL, NULL, '$2y$12$37EIrRST4r3PdSpPBLP9oOXmqJGl1IpRmZhv8YIUZf39.JceCJbtq', 'admin', NULL, NULL, NULL, 'BZzTGWRrPlmGYuyKgrcs32EsuQxOI1bmEPjPkmIgmh4cxtPV79t1QbwBP4YJ', '2026-04-02 21:30:26', '2026-04-10 08:27:41'),
(4, 'Pelanggan Demo', 'customer@bengkel.test', NULL, NULL, NULL, '$2y$12$ZBbJ3CuDJudWx3x3r6Q2q.jy.mCqkogRGbG/eeniaZDLR4ERMf5I6', 'customer', NULL, NULL, NULL, NULL, '2026-04-02 21:30:26', '2026-04-10 08:27:41'),
(5, 'rapii', 'rapii@gmail.com', NULL, NULL, NULL, '$2y$12$ooZI2BmHLxlqRZ/u/4ZqW.Fu/uNVajpw8OtiHcz9FAwczwOURLH9u', 'customer', '081285799222', NULL, NULL, NULL, '2026-04-03 01:36:34', '2026-04-03 01:36:34'),
(6, 'ahmad', 'ahmad@gmail.com', NULL, NULL, NULL, '$2y$12$CX53IrBYUHii/pbmupGuaOLTx91y7xzMr05qAECjGU1l9E37NswPC', 'customer', NULL, NULL, NULL, NULL, '2026-04-03 18:34:45', '2026-04-03 18:34:45'),
(7, 'Mekanik', 'mekanik@bengkel.com', NULL, NULL, NULL, '$2y$12$TcrinMHkT7HGmvP7NC1mVeTrBfB.KmhEDMkRQauYUOUUDbXM0RhIm', 'mekanik', '080997544', NULL, 'profile-photos/HCMJmS23PdI3eJToihwqOjFWZxzmAuTB65sgbMJO.jpg', NULL, '2026-04-08 04:35:22', '2026-04-12 05:00:19'),
(8, 'Owner', 'owner@bengkel.com', NULL, NULL, NULL, '$2y$12$mOVWmkqz58cNbq0XI.Iw2.4XUQVx.9LGwgsYhiYIgbqdlIBSxMyWK', 'owner', '081234567891', 'Bogor', NULL, NULL, '2026-04-08 05:27:52', '2026-04-08 05:27:52'),
(9, 'Kasir', 'kasir@bengkel.test', NULL, NULL, NULL, '$2y$12$CDCADbcbvBRQ0V5MF2fQ2urGK9SGldYfYNx.PTciigfUdw3N.paae', 'kasir', NULL, NULL, NULL, 'CN0TPqBowztzjz8hggEMrQLwPSMNPO1p449olwCGXeCwHZ62xZmVszdtoK2u', '2026-04-10 08:27:42', '2026-04-20 02:22:18'),
(10, 'Owner Demo', 'owner@bengkel.test', NULL, NULL, NULL, '$2y$12$7ZaSWW9XiORjOp/62SoKw.0BbcDAFb.ArVNlrfyoa34f65kju.PZa', 'owner', NULL, NULL, NULL, NULL, '2026-04-10 08:27:42', '2026-04-10 08:27:42'),
(11, 'Zio', 'zio@gmail.com', NULL, NULL, NULL, '$2y$12$F1QKApnDpU2Ri6RBcsq18.ete6AmcjqduR0UMyJZMlFpSEZ6jnQOy', 'customer', '081285799222', 'depok', 'profile-photos/gulSwtTteEpYdMkgSTCr2j2cn3rAG4sC3AuvKqJr.jpg', NULL, '2026-04-12 03:33:44', '2026-04-16 17:39:21'),
(12, 'nurul', 'nurul@gmail.com', NULL, NULL, NULL, '$2y$12$csCzvzt0Mn7uHPDoux.VluurgJOq5zBaTngdLe2B.c0EhM2kuO6Ky', 'customer', NULL, NULL, NULL, NULL, '2026-04-12 21:17:44', '2026-04-12 21:17:44'),
(13, 'Ahmad Rafii Razka Santika', 'ahmadsantika80@gmail.com', NULL, NULL, NULL, '$2y$12$LSFd8LR.bw3ILMOVrvfFbuFBHdr8INsc7abcWUnXM3wGzh0uXijLC', 'customer', '081285799292', NULL, NULL, NULL, '2026-04-29 20:46:17', '2026-04-29 20:46:17'),
(14, 'Ahmad Rafii Santika', 'maddpiirazka@gmail.com', '2026-04-30 03:18:42', NULL, NULL, '$2y$12$bnRBrbqbk6xGLMGv4gXJc.dkcvu.qKVw8N.P8cBSJQCtFKdGz4Cou', 'customer', '081285799222', NULL, NULL, NULL, '2026-04-29 20:47:49', '2026-04-30 03:18:42'),
(15, 'Akhmad', 'yusepsantika14@gmail.com', '2026-04-30 04:25:11', NULL, NULL, '$2y$12$xIXRXyBn.tyLSL/ZlRL6kOiWmF5Zut4ngPUjpTkVcOFjro.kJork.', 'customer', '081285799222', NULL, NULL, NULL, '2026-04-30 04:24:38', '2026-04-30 04:25:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `license_plate` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `vehicles`
--

INSERT INTO `vehicles` (`id`, `user_id`, `brand`, `model`, `year`, `license_plate`, `color`, `created_at`, `updated_at`) VALUES
(5, 6, 'Avanza', '1.3 E', NULL, 'B 1111 RAA', 'Putih', '2026-04-09 23:50:51', '2026-04-09 23:50:51'),
(6, 6, 'Avanza', '1.3 A', NULL, 'A 099 RPP', 'hitam', '2026-04-10 09:02:43', '2026-04-10 09:02:43'),
(7, 6, 'Toyota', '1.3 E', NULL, 'Z 40 AP', 'hitam', '2026-04-11 06:33:30', '2026-04-11 06:33:30'),
(8, 11, 'Toyota', 'Toyota', NULL, 'A 009 ARZ', 'hitam', '2026-04-12 03:35:12', '2026-04-12 03:35:12'),
(9, 6, 'Toyota', '1.3 E', NULL, 'A 099 RPP', 'Putih', '2026-04-12 20:56:08', '2026-04-12 20:56:08'),
(10, 11, 'Toyota', 'innova', NULL, 'Q 1291 PP', 'Putih', '2026-04-12 21:10:32', '2026-04-12 21:10:32'),
(11, 12, 'Toyota', 'innova', NULL, 'Q 1291 PP', 'hitam', '2026-04-12 21:18:33', '2026-04-12 21:18:33'),
(12, 11, 'Toyota', 'Alphard', NULL, 'A 187 |RXZ', 'hitam', '2026-04-13 00:47:49', '2026-04-13 00:47:49'),
(13, 11, 'Toyota', 'Alphard', NULL, 'B 999 P', 'Putih', '2026-04-16 17:22:40', '2026-04-16 17:22:40'),
(14, 11, 'Honda', 'CR - V', NULL, 'Q 123 PP', 'hitam', '2026-04-20 02:11:11', '2026-04-20 02:11:11'),
(15, 14, 'Nissan', 'innova', NULL, 'Q 123 WW', 'hitam', '2026-04-30 04:03:10', '2026-04-30 04:03:10'),
(16, 15, 'Toyota', 'Alphard', NULL, 'Z 123 P', 'Putih', '2026-05-01 23:18:00', '2026-05-01 23:18:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_vehicle_id_foreign` (`vehicle_id`);

--
-- Indeks untuk tabel `booking_services`
--
ALTER TABLE `booking_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_services_booking_id_foreign` (`booking_id`),
  ADD KEY `booking_services_service_id_foreign` (`service_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jenis_vehicles`
--
ALTER TABLE `jenis_vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jenis_vehicles_brand_unique` (`brand`),
  ADD KEY `jenis_vehicles_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_transaction_id_foreign` (`transaction_id`);

--
-- Indeks untuk tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `service_reviews`
--
ALTER TABLE `service_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_reviews_transaction_id_foreign` (`transaction_id`),
  ADD KEY `service_reviews_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `site_contents`
--
ALTER TABLE `site_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `spareparts`
--
ALTER TABLE `spareparts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_booking_id_foreign` (`booking_id`),
  ADD KEY `transactions_mekanik_id_foreign` (`mekanik_id`),
  ADD KEY `transactions_kasir_id_foreign` (`kasir_id`);

--
-- Indeks untuk tabel `transaction_spareparts`
--
ALTER TABLE `transaction_spareparts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_spareparts_transaction_id_foreign` (`transaction_id`),
  ADD KEY `transaction_spareparts_sparepart_id_foreign` (`sparepart_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicles_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `booking_services`
--
ALTER TABLE `booking_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis_vehicles`
--
ALTER TABLE `jenis_vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `service_reviews`
--
ALTER TABLE `service_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `site_contents`
--
ALTER TABLE `site_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `spareparts`
--
ALTER TABLE `spareparts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `transaction_spareparts`
--
ALTER TABLE `transaction_spareparts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `booking_services`
--
ALTER TABLE `booking_services`
  ADD CONSTRAINT `booking_services_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jenis_vehicles`
--
ALTER TABLE `jenis_vehicles`
  ADD CONSTRAINT `jenis_vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `service_reviews`
--
ALTER TABLE `service_reviews`
  ADD CONSTRAINT `service_reviews_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_kasir_id_foreign` FOREIGN KEY (`kasir_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_mekanik_id_foreign` FOREIGN KEY (`mekanik_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaction_spareparts`
--
ALTER TABLE `transaction_spareparts`
  ADD CONSTRAINT `transaction_spareparts_sparepart_id_foreign` FOREIGN KEY (`sparepart_id`) REFERENCES `spareparts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_spareparts_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
