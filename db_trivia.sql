-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 19, 2017 at 04:44 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_trivia`
--

-- --------------------------------------------------------

--
-- Table structure for table `master_accesses`
--

CREATE TABLE `master_accesses` (
  `level_systems_id` int(11) NOT NULL,
  `features_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_accesses`
--

INSERT INTO `master_accesses` (`level_systems_id`, `features_id`) VALUES
(4, 14),
(5, 14),
(2, 31),
(2, 33),
(2, 32),
(2, 34),
(2, 35),
(2, 70),
(2, 72),
(2, 71),
(2, 73),
(2, 74),
(2, 20),
(3, 80),
(3, 81),
(3, 82),
(3, 83),
(3, 84),
(3, 85),
(3, 86),
(3, 87),
(3, 88),
(3, 89),
(3, 90),
(3, 91),
(3, 50),
(3, 51),
(3, 48),
(3, 49),
(3, 20),
(1, 31),
(1, 33),
(1, 32),
(1, 34),
(1, 35),
(1, 70),
(1, 72),
(1, 71),
(1, 73),
(1, 74),
(1, 80),
(1, 81),
(1, 82),
(1, 83),
(1, 84),
(1, 85),
(1, 86),
(1, 87),
(1, 88),
(1, 89),
(1, 90),
(1, 91),
(1, 50),
(1, 51),
(1, 48),
(1, 49),
(1, 96),
(1, 97),
(1, 98),
(1, 99),
(1, 7),
(1, 9),
(1, 8),
(1, 10),
(1, 11),
(1, 17),
(1, 19),
(1, 18),
(1, 20),
(1, 21),
(1, 52),
(1, 54),
(1, 53),
(1, 55),
(1, 56),
(1, 65),
(1, 67),
(1, 66),
(1, 68),
(1, 69),
(1, 16),
(1, 2),
(1, 4),
(1, 3),
(1, 5),
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `master_app_configurations`
--

CREATE TABLE `master_app_configurations` (
  `path_logo_app_configurations` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_logo_app_configurations` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path_icon_app_configurations` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_icon_app_configurations` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sessions_days_duration_app_configurations` double NOT NULL,
  `game_minutes_duration_app_configurations` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_app_configurations`
--

INSERT INTO `master_app_configurations` (`path_logo_app_configurations`, `name_logo_app_configurations`, `path_icon_app_configurations`, `name_icon_app_configurations`, `sessions_days_duration_app_configurations`, `game_minutes_duration_app_configurations`) VALUES
('./public/images/', 'logo.png', './public/images/', 'icon.png', 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `master_features`
--

CREATE TABLE `master_features` (
  `id_features` int(10) UNSIGNED NOT NULL,
  `menus_id` int(11) NOT NULL,
  `name_features` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_features`
--

INSERT INTO `master_features` (`id_features`, `menus_id`, `name_features`) VALUES
(1, 1, 'view'),
(2, 2, 'view'),
(3, 2, 'add'),
(4, 2, 'read'),
(5, 2, 'edit'),
(6, 2, 'delete'),
(7, 3, 'view'),
(8, 3, 'add'),
(9, 3, 'read'),
(10, 3, 'edit'),
(11, 3, 'delete'),
(16, 5, 'view'),
(17, 4, 'view'),
(18, 4, 'add'),
(19, 4, 'read'),
(20, 4, 'edit'),
(21, 4, 'delete'),
(31, 8, 'view'),
(32, 8, 'add'),
(33, 8, 'read'),
(34, 8, 'edit'),
(35, 8, 'delete'),
(48, 14, 'view'),
(49, 14, 'print'),
(50, 13, 'view'),
(51, 13, 'print'),
(52, 15, 'view'),
(53, 15, 'add'),
(54, 15, 'read'),
(55, 15, 'edit'),
(56, 15, 'delete'),
(65, 16, 'view'),
(66, 16, 'add'),
(67, 16, 'read'),
(68, 16, 'edit'),
(69, 16, 'delete'),
(70, 17, 'view'),
(71, 17, 'add'),
(72, 17, 'read'),
(73, 17, 'edit'),
(74, 17, 'delete'),
(80, 9, 'view'),
(81, 9, 'add'),
(82, 9, 'edit'),
(83, 9, 'delete'),
(84, 10, 'view'),
(85, 10, 'add'),
(86, 10, 'edit'),
(87, 10, 'delete'),
(88, 11, 'view'),
(89, 11, 'add'),
(90, 11, 'edit'),
(91, 11, 'delete'),
(96, 18, 'view'),
(97, 18, 'add'),
(98, 18, 'edit'),
(99, 18, 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `master_games`
--

CREATE TABLE `master_games` (
  `id_games` int(10) UNSIGNED NOT NULL,
  `sessions_id` int(11) NOT NULL,
  `start_date_games` datetime NOT NULL,
  `end_date_games` datetime NOT NULL,
  `rtp_games` double NOT NULL,
  `status_active_games` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_groups`
--

CREATE TABLE `master_groups` (
  `id_groups` int(10) UNSIGNED NOT NULL,
  `users_id` int(11) NOT NULL,
  `credit_groups` double NOT NULL,
  `whatsapp_group_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_groups` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on_groups` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_level_systems`
--

CREATE TABLE `master_level_systems` (
  `id_level_systems` int(10) UNSIGNED NOT NULL,
  `name_level_systems` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_level_systems`
--

INSERT INTO `master_level_systems` (`id_level_systems`, `name_level_systems`) VALUES
(1, 'Admin'),
(2, 'Master Agent'),
(3, 'Agent');

-- --------------------------------------------------------

--
-- Table structure for table `master_list_stakes`
--

CREATE TABLE `master_list_stakes` (
  `id_list_stakes` int(10) UNSIGNED NOT NULL,
  `name_list_stakes` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path_image_list_stakes` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_image_list_stakes` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_list_stakes`
--

INSERT INTO `master_list_stakes` (`id_list_stakes`, `name_list_stakes`, `path_image_list_stakes`, `name_image_list_stakes`) VALUES
(1, 'dog', './public/images/stake/', 'dog.jpg'),
(2, 'dragon', './public/images/stake/', 'dragon.jpg'),
(3, 'goat', './public/images/stake/', 'goat.jpg'),
(4, 'horse', './public/images/stake/', 'horse.jpg'),
(5, 'monkey', './public/images/stake/', 'monkey.jpg'),
(6, 'ox', './public/images/stake/', 'ox.jpg'),
(7, 'pig', './public/images/stake/', 'pig.jpg'),
(8, 'rabbit', './public/images/stake/', 'rabbit.jpg'),
(9, 'rat', './public/images/stake/', 'rat.jpg'),
(10, 'rooster', './public/images/stake/', 'rooster.jpg'),
(11, 'snake', './public/images/stake/', 'snake.jpg'),
(12, 'tiger', './public/images/stake/', 'tiger.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `master_menus`
--

CREATE TABLE `master_menus` (
  `id_menus` int(10) UNSIGNED NOT NULL,
  `sub_menus_id` int(11) NOT NULL,
  `name_menus` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_menus` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon_menus` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_menus` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_menus`
--

INSERT INTO `master_menus` (`id_menus`, `sub_menus_id`, `name_menus`, `link_menus`, `icon_menus`, `order_menus`) VALUES
(1, 0, 'Admin', '', 'mdi-wrench', 5),
(2, 1, 'Menu', 'menu', 'mdi-menu', 6),
(3, 1, 'Level System', 'level_system', 'mdi-layers', 1),
(4, 1, 'Manage Admin', 'admin', 'mdi-account', 2),
(5, 1, 'App Config', 'app_configuration', 'mdi-wrench', 5),
(6, 0, 'Master Agent', '', 'mdi-account-star', 0),
(7, 0, 'Agent', '', 'mdi-account-multiple', 0),
(8, 6, 'Manage Agent', 'agent', 'mdi-account-multiple', 0),
(9, 7, 'Manage Group', 'group', 'mdi-group', 1),
(10, 7, 'Manage Sessions', 'sessions', 'mdi-calendar-clock', 2),
(11, 7, 'Manage Game', 'game', 'mdi-gamepad-variant', 3),
(12, 0, 'Report', '', 'mdi-file-document-box', 0),
(13, 12, 'List Game', 'list_game_report', 'mdi-file-document', 1),
(14, 12, 'Gamestat', 'gamestat_report', 'mdi-file-document', 2),
(15, 1, 'Manage Master Agent', 'master_agent', 'mdi-account-star', 3),
(16, 1, 'Top Up Master Agent', 'top_up_master_agent', 'mdi-credit-card', 4),
(17, 6, 'Top Up Agent', 'top_up_agent', 'mdi-credit-card', 0),
(18, 1, 'List Stakes', 'list_stakes', 'mdi-animation', 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_register_members`
--

CREATE TABLE `master_register_members` (
  `id_register_members` int(10) UNSIGNED NOT NULL,
  `sessions_id` int(11) NOT NULL,
  `credit_register_members` double NOT NULL,
  `phone_number_register_members` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_sessions`
--

CREATE TABLE `master_sessions` (
  `id_sessions` int(10) UNSIGNED NOT NULL,
  `groups_id` int(11) NOT NULL,
  `start_date_sessions` datetime NOT NULL,
  `end_date_sessions` datetime NOT NULL,
  `credit_member_sessions` double NOT NULL,
  `status_active_sessions` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_stakes`
--

CREATE TABLE `master_stakes` (
  `id_stakes` int(10) UNSIGNED NOT NULL,
  `games_id` int(11) NOT NULL,
  `register_members_id` int(11) NOT NULL,
  `list_stakes_id` int(11) NOT NULL,
  `value_stakes` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_top_ups`
--

CREATE TABLE `master_top_ups` (
  `id_top_ups` int(10) UNSIGNED NOT NULL,
  `from_users_id` int(11) NOT NULL,
  `to_users_id` int(11) NOT NULL,
  `date_top_ups` date NOT NULL,
  `time_top_ups` time NOT NULL,
  `credit_top_ups` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_winloses`
--

CREATE TABLE `master_winloses` (
  `id_winloses` int(10) UNSIGNED NOT NULL,
  `stakes_id` int(11) NOT NULL,
  `profit_winloses` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_12_08_070336_create_master_level_systems_table', 1),
(4, '2017_12_08_070413_create_master_accesses_table', 1),
(5, '2017_12_08_070433_create_master_features_table', 1),
(6, '2017_12_08_070444_create_master_menus_table', 1),
(7, '2017_12_08_080010_create_master_app_configurations_table', 2),
(8, '2017_12_11_181209_create_master_top_ups_table', 3),
(9, '2017_12_11_181240_create_master_groups_table', 3),
(10, '2017_12_12_174837_create_master_sessions_table', 4),
(11, '2017_12_12_174901_create_master_games_table', 4),
(12, '2017_12_12_181700_create_master_register_members_table', 5),
(13, '2017_12_12_181730_create_master_stakes_table', 5),
(14, '2017_12_12_181745_create_master_winloses_table', 5),
(15, '2017_12_12_181759_create_master_list_stakes_table', 5),
(16, '2016_06_01_000001_create_oauth_auth_codes_table', 6),
(17, '2016_06_01_000002_create_oauth_access_tokens_table', 6),
(18, '2016_06_01_000003_create_oauth_refresh_tokens_table', 6),
(19, '2016_06_01_000004_create_oauth_clients_table', 6),
(20, '2016_06_01_000005_create_oauth_personal_access_clients_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Trivia Personal Access Client', 'vBMHgvO22XtgK0zr79DcXNUCFviFjtqEyVeoHxBk', 'http://localhost', 1, 0, 0, '2017-12-13 08:31:58', '2017-12-13 08:31:58'),
(2, NULL, 'Trivia Password Grant Client', 'DIdZLHI2oz8rCWiiiWqrcqxAKOoieSVbE7TDffUR', 'http://localhost', 0, 1, 0, '2017-12-13 08:31:59', '2017-12-13 08:31:59');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2017-12-13 08:31:58', '2017-12-13 08:31:58');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `sub_users_id` int(11) NOT NULL,
  `level_systems_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number_users` double NOT NULL,
  `credit_users` double NOT NULL,
  `max_group_users` double NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `sub_users_id`, `level_systems_id`, `name`, `email`, `password`, `phone_number_users`, `credit_users`, `max_group_users`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 'Trivia', 'info@trivia.com', '$2y$10$yz8HMeQDxtLUnu48iwnZpuCZbeFzCDlawRf9Cpd/YG16E6yxVWYwy', 0, 0, 0, 'dquseBUk6JkdTuRDiokmDJWsq1ooMK3t5EQWgSvU6GL947cYk0AdtM4w3c0m', '2017-12-08 10:50:13', '2017-12-11 07:54:06'),
(2, 0, 2, 'Irawan Agung Nugroho', 'irawan@shwetech.com', '$2y$10$RdxAgFb2nqr97wOShSk89eSwBpIy1nRXXbtFZISPRZS5kYoV43aVu', 6285643167946, 0, 0, 'DS8DIh5OEwSaxifVQS1TFALlzqQsLzmXadK3F7Dq7mAmVcbZa1OlYJIfT6hs', '2017-12-11 08:17:16', '2017-12-17 12:28:27'),
(3, 0, 2, 'Abdul Alim', 'abdul@shwetech.com', '$2y$10$CbjdDpV4HHaguFO2no0ayOOKxZdJdLzeYOeuWNUU4iziCQaYHLJfm', 959424013044, 0, 0, '08wYpE2boWWQgWzGHm6wb2TmWmUBjYvUZ7vQXqgatQo12lyijd7DAUZS57Ji', '2017-12-11 09:51:04', '2017-12-19 04:20:36'),
(4, 2, 3, 'Muhammad Hanif', 'hanif@shwetech.com', '$2y$10$QJ6j9k76oELlJM2l7J4wPemQW2VuXvHslrLtY.5MLiaJ.JK7L5IOG', 6285328908074, 500000, 1, 'qvBTSuJlvGvEfkOKdhd65GNnaXmk5OpcY23Zf4GHttHiwk8k71UiYjZg4By7', '2017-12-11 11:00:53', '2017-12-17 12:28:53'),
(5, 3, 3, 'James', 'james@shwetech.com', '$2y$10$QJ6j9k76oELlJM2l7J4wPemQW2VuXvHslrLtY.5MLiaJ.JK7L5IOG', 6596427506, 500000, 1, 'Blkc22gA4cd3WnTik1SInrOCOwb1RMNNOGRTZrEwTFuLPXyL7gBQlqTBHfxm', '2017-12-11 11:00:53', '2017-12-17 12:28:53'),
(6, 3, 3, 'Lionel Low', 'lionel@shwetech.com', '$2y$10$QJ6j9k76oELlJM2l7J4wPemQW2VuXvHslrLtY.5MLiaJ.JK7L5IOG', 6590609450, 500000, 1, '9zCYXXT94r7E0Whei7z6SfkCQnDSJG7HSS7857gMz4gd2n8rlS3w1v9YUzpg', '2017-12-11 11:00:53', '2017-12-17 12:28:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_accesses`
--
ALTER TABLE `master_accesses`
  ADD KEY `master_accesses_level_systems_id_index` (`level_systems_id`),
  ADD KEY `master_accesses_features_id_index` (`features_id`);

--
-- Indexes for table `master_features`
--
ALTER TABLE `master_features`
  ADD PRIMARY KEY (`id_features`),
  ADD KEY `master_features_menus_id_index` (`menus_id`);

--
-- Indexes for table `master_games`
--
ALTER TABLE `master_games`
  ADD PRIMARY KEY (`id_games`),
  ADD KEY `master_games_sessions_id_index` (`sessions_id`);

--
-- Indexes for table `master_groups`
--
ALTER TABLE `master_groups`
  ADD PRIMARY KEY (`id_groups`),
  ADD KEY `master_groups_users_id_index` (`users_id`);

--
-- Indexes for table `master_level_systems`
--
ALTER TABLE `master_level_systems`
  ADD PRIMARY KEY (`id_level_systems`);

--
-- Indexes for table `master_list_stakes`
--
ALTER TABLE `master_list_stakes`
  ADD PRIMARY KEY (`id_list_stakes`);

--
-- Indexes for table `master_menus`
--
ALTER TABLE `master_menus`
  ADD PRIMARY KEY (`id_menus`),
  ADD KEY `master_menus_sub_menus_id_index` (`sub_menus_id`);

--
-- Indexes for table `master_register_members`
--
ALTER TABLE `master_register_members`
  ADD PRIMARY KEY (`id_register_members`),
  ADD KEY `master_register_members_sessions_id_index` (`sessions_id`);

--
-- Indexes for table `master_sessions`
--
ALTER TABLE `master_sessions`
  ADD PRIMARY KEY (`id_sessions`),
  ADD KEY `master_sessions_groups_id_index` (`groups_id`);

--
-- Indexes for table `master_stakes`
--
ALTER TABLE `master_stakes`
  ADD PRIMARY KEY (`id_stakes`),
  ADD KEY `master_stakes_games_id_index` (`games_id`),
  ADD KEY `master_stakes_list_stakes_id_index` (`list_stakes_id`),
  ADD KEY `register_members_id` (`register_members_id`);

--
-- Indexes for table `master_top_ups`
--
ALTER TABLE `master_top_ups`
  ADD PRIMARY KEY (`id_top_ups`),
  ADD KEY `master_top_ups_host_users_id_index` (`from_users_id`),
  ADD KEY `master_top_ups_agent_users_id_index` (`to_users_id`);

--
-- Indexes for table `master_winloses`
--
ALTER TABLE `master_winloses`
  ADD PRIMARY KEY (`id_winloses`),
  ADD KEY `master_winloses_stakes_id_index` (`stakes_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_sub_users_id_index` (`sub_users_id`),
  ADD KEY `users_level_systems_id_index` (`level_systems_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_features`
--
ALTER TABLE `master_features`
  MODIFY `id_features` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `master_games`
--
ALTER TABLE `master_games`
  MODIFY `id_games` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_groups`
--
ALTER TABLE `master_groups`
  MODIFY `id_groups` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_level_systems`
--
ALTER TABLE `master_level_systems`
  MODIFY `id_level_systems` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_list_stakes`
--
ALTER TABLE `master_list_stakes`
  MODIFY `id_list_stakes` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `master_menus`
--
ALTER TABLE `master_menus`
  MODIFY `id_menus` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `master_register_members`
--
ALTER TABLE `master_register_members`
  MODIFY `id_register_members` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_sessions`
--
ALTER TABLE `master_sessions`
  MODIFY `id_sessions` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_stakes`
--
ALTER TABLE `master_stakes`
  MODIFY `id_stakes` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_top_ups`
--
ALTER TABLE `master_top_ups`
  MODIFY `id_top_ups` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_winloses`
--
ALTER TABLE `master_winloses`
  MODIFY `id_winloses` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
