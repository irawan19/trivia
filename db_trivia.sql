-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 16, 2018 at 11:06 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

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
(3, 100),
(3, 102),
(3, 101),
(3, 103),
(3, 104),
(3, 105),
(3, 107),
(3, 106),
(3, 108),
(3, 109),
(3, 20),
(3, 50),
(3, 51),
(3, 48),
(3, 49),
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
(1, 100),
(1, 102),
(1, 101),
(1, 103),
(1, 104),
(1, 105),
(1, 107),
(1, 106),
(1, 108),
(1, 109),
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
(1, 50),
(1, 51),
(1, 48),
(1, 49),
(1, 120),
(1, 122),
(1, 121),
(1, 123),
(1, 124),
(1, 110),
(1, 111),
(1, 112),
(1, 113),
(1, 115),
(1, 117),
(1, 116),
(1, 118),
(1, 119),
(1, 114);

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
-- Table structure for table `master_bots`
--

CREATE TABLE `master_bots` (
  `id_bots` int(10) UNSIGNED NOT NULL,
  `country_phone_codes_id` int(11) NOT NULL,
  `date_register_bots` date NOT NULL,
  `time_register_bots` time NOT NULL,
  `name_bots` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number_bots` double NOT NULL,
  `code_bots` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_bots` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_bots`
--

INSERT INTO `master_bots` (`id_bots`, `country_phone_codes_id`, `date_register_bots`, `time_register_bots`, `name_bots`, `phone_number_bots`, `code_bots`, `password_bots`) VALUES
(1, 100, '2018-01-05', '14:00:00', 'TRIVIBOT 1', 6285927485652, '', ''),
(2, 100, '2018-01-16', '17:20:41', 'Hanifbot', 6283839138072, '', ''),
(3, 100, '2018-01-16', '17:31:06', 'jarvis', 6283839138067, '627756', 'CMd9j+fUn1jcbvkGjE739JfWKmU=');

-- --------------------------------------------------------

--
-- Table structure for table `master_country_phone_codes`
--

CREATE TABLE `master_country_phone_codes` (
  `id_country_phone_codes` int(10) UNSIGNED NOT NULL,
  `name_country_phone_codes` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_country_phone_codes` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_country_phone_codes`
--

INSERT INTO `master_country_phone_codes` (`id_country_phone_codes`, `name_country_phone_codes`, `code_country_phone_codes`) VALUES
(1, 'Afghanistan', 93),
(2, 'Albania', 355),
(3, 'Algeria', 213),
(4, 'American Samoa', 1684),
(5, 'Andorra', 376),
(6, 'Angola', 244),
(7, 'Anguilla', 1264),
(8, 'Antarctica', 0),
(9, 'Antigua and Barbuda', 1268),
(10, 'Argentina', 54),
(11, 'Armenia', 374),
(12, 'Aruba', 297),
(13, 'Australia', 61),
(14, 'Austria', 43),
(15, 'Azerbaijan', 994),
(16, 'Bahamas', 1242),
(17, 'Bahrain', 973),
(18, 'Bangladesh', 880),
(19, 'Barbados', 1246),
(20, 'Belarus', 375),
(21, 'Belgium', 32),
(22, 'Belize', 501),
(23, 'Benin', 229),
(24, 'Bermuda', 1441),
(25, 'Bhutan', 975),
(26, 'Bolivia', 591),
(27, 'Bosnia and Herzegovina', 387),
(28, 'Botswana', 267),
(29, 'Bouvet Island', 0),
(30, 'Brazil', 55),
(31, 'British Indian Ocean Territory', 246),
(32, 'Brunei Darussalam', 673),
(33, 'Bulgaria', 359),
(34, 'Burkina Faso', 226),
(35, 'Burundi', 257),
(36, 'Cambodia', 855),
(37, 'Cameroon', 237),
(38, 'Canada', 1),
(39, 'Cape Verde', 238),
(40, 'Cayman Islands', 1345),
(41, 'Central African Republic', 236),
(42, 'Chad', 235),
(43, 'Chile', 56),
(44, 'China', 86),
(45, 'Christmas Island', 61),
(46, 'Cocos (Keeling) Islands', 672),
(47, 'Colombia', 57),
(48, 'Comoros', 269),
(49, 'Congo', 242),
(50, 'Congo, the Democratic Republic of the', 242),
(51, 'Cook Islands', 682),
(52, 'Costa Rica', 506),
(53, 'Cote D\'Ivoire', 225),
(54, 'Croatia', 385),
(55, 'Cuba', 53),
(56, 'Cyprus', 357),
(57, 'Czech Republic', 420),
(58, 'Denmark', 45),
(59, 'Djibouti', 253),
(60, 'Dominica', 1767),
(61, 'Dominican Republic', 1809),
(62, 'Ecuador', 593),
(63, 'Egypt', 20),
(64, 'El Salvador', 503),
(65, 'Equatorial Guinea', 240),
(66, 'Eritrea', 291),
(67, 'Estonia', 372),
(68, 'Ethiopia', 251),
(69, 'Falkland Islands (Malvinas)', 500),
(70, 'Faroe Islands', 298),
(71, 'Fiji', 679),
(72, 'Finland', 358),
(73, 'France', 33),
(74, 'French Guiana', 594),
(75, 'French Polynesia', 689),
(76, 'French Southern Territories', 0),
(77, 'Gabon', 241),
(78, 'Gambia', 220),
(79, 'Georgia', 995),
(80, 'Germany', 49),
(81, 'Ghana', 233),
(82, 'Gibraltar', 350),
(83, 'Greece', 30),
(84, 'Greenland', 299),
(85, 'Grenada', 1473),
(86, 'Guadeloupe', 590),
(87, 'Guam', 1671),
(88, 'Guatemala', 502),
(89, 'Guinea', 224),
(90, 'Guinea-Bissau', 245),
(91, 'Guyana', 592),
(92, 'Haiti', 509),
(93, 'Heard Island and Mcdonald Islands', 0),
(94, 'Holy See (Vatican City State)', 39),
(95, 'Honduras', 504),
(96, 'Hong Kong', 852),
(97, 'Hungary', 36),
(98, 'Iceland', 354),
(99, 'India', 91),
(100, 'Indonesia', 62),
(101, 'Iran, Islamic Republic of', 98),
(102, 'Iraq', 964),
(103, 'Ireland', 353),
(104, 'Israel', 972),
(105, 'Italy', 39),
(106, 'Jamaica', 1876),
(107, 'Japan', 81),
(108, 'Jordan', 962),
(109, 'Kazakhstan', 7),
(110, 'Kenya', 254),
(111, 'Kiribati', 686),
(112, 'Korea, Democratic People\'s Republic of', 850),
(113, 'Korea, Republic of', 82),
(114, 'Kuwait', 965),
(115, 'Kyrgyzstan', 996),
(116, 'Lao People\'s Democratic Republic', 856),
(117, 'Latvia', 371),
(118, 'Lebanon', 961),
(119, 'Lesotho', 266),
(120, 'Liberia', 231),
(121, 'Libyan Arab Jamahiriya', 218),
(122, 'Liechtenstein', 423),
(123, 'Lithuania', 370),
(124, 'Luxembourg', 352),
(125, 'Macao', 853),
(126, 'Macedonia, the Former Yugoslav Republic of', 389),
(127, 'Madagascar', 261),
(128, 'Malawi', 265),
(129, 'Malaysia', 60),
(130, 'Maldives', 960),
(131, 'Mali', 223),
(132, 'Malta', 356),
(133, 'Marshall Islands', 692),
(134, 'Martinique', 596),
(135, 'Mauritania', 222),
(136, 'Mauritius', 230),
(137, 'Mayotte', 269),
(138, 'Mexico', 52),
(139, 'Micronesia, Federated States of', 691),
(140, 'Moldova, Republic of', 373),
(141, 'Monaco', 377),
(142, 'Mongolia', 976),
(143, 'Montserrat', 1664),
(144, 'Morocco', 212),
(145, 'Mozambique', 258),
(146, 'Myanmar', 95),
(147, 'Namibia', 264),
(148, 'Nauru', 674),
(149, 'Nepal', 977),
(150, 'Netherlands', 31),
(151, 'Netherlands Antilles', 599),
(152, 'New Caledonia', 687),
(153, 'New Zealand', 64),
(154, 'Nicaragua', 505),
(155, 'Niger', 227),
(156, 'Nigeria', 234),
(157, 'Niue', 683),
(158, 'Norfolk Island', 672),
(159, 'Northern Mariana Islands', 1670),
(160, 'Norway', 47),
(161, 'Oman', 968),
(162, 'Pakistan', 92),
(163, 'Palau', 680),
(164, 'Palestinian Territory, Occupied', 970),
(165, 'Panama', 507),
(166, 'Papua New Guinea', 675),
(167, 'Paraguay', 595),
(168, 'Peru', 51),
(169, 'Philippines', 63),
(170, 'Pitcairn', 0),
(171, 'Poland', 48),
(172, 'Portugal', 351),
(173, 'Puerto Rico', 1787),
(174, 'Qatar', 974),
(175, 'Reunion', 262),
(176, 'Romania', 40),
(177, 'Russian Federation', 70),
(178, 'Rwanda', 250),
(179, 'Saint Helena', 290),
(180, 'Saint Kitts and Nevis', 1869),
(181, 'Saint Lucia', 1758),
(182, 'Saint Pierre and Miquelon', 508),
(183, 'Saint Vincent and the Grenadines', 1784),
(184, 'Samoa', 684),
(185, 'San Marino', 378),
(186, 'Sao Tome and Principe', 239),
(187, 'Saudi Arabia', 966),
(188, 'Senegal', 221),
(189, 'Serbia and Montenegro', 381),
(190, 'Seychelles', 248),
(191, 'Sierra Leone', 232),
(192, 'Singapore', 65),
(193, 'Slovakia', 421),
(194, 'Slovenia', 386),
(195, 'Solomon Islands', 677),
(196, 'Somalia', 252),
(197, 'South Africa', 27),
(198, 'South Georgia and the South Sandwich Islands', 0),
(199, 'Spain', 34),
(200, 'Sri Lanka', 94),
(201, 'Sudan', 249),
(202, 'Suriname', 597),
(203, 'Svalbard and Jan Mayen', 47),
(204, 'Swaziland', 268),
(205, 'Sweden', 46),
(206, 'Switzerland', 41),
(207, 'Syrian Arab Republic', 963),
(208, 'Taiwan, Province of China', 886),
(209, 'Tajikistan', 992),
(210, 'Tanzania, United Republic of', 255),
(211, 'Thailand', 66),
(212, 'Timor-Leste', 670),
(213, 'Togo', 228),
(214, 'Tokelau', 690),
(215, 'Tonga', 676),
(216, 'Trinidad and Tobago', 1868),
(217, 'Tunisia', 216),
(218, 'Turkey', 90),
(219, 'Turkmenistan', 7370),
(220, 'Turks and Caicos Islands', 1649),
(221, 'Tuvalu', 688),
(222, 'Uganda', 256),
(223, 'Ukraine', 380),
(224, 'United Arab Emirates', 971),
(225, 'United Kingdom', 44),
(226, 'United States', 1),
(227, 'United States Minor Outlying Islands', 1),
(228, 'Uruguay', 598),
(229, 'Uzbekistan', 998),
(230, 'Vanuatu', 678),
(231, 'Venezuela', 58),
(232, 'Viet Nam', 84),
(233, 'Virgin Islands, British', 1284),
(234, 'Virgin Islands, U.s.', 1340),
(235, 'Wallis and Futuna', 681),
(236, 'Western Sahara', 212),
(237, 'Yemen', 967),
(238, 'Zambia', 260),
(239, 'Zimbabwe', 263);

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
(7, 3, 'view'),
(8, 3, 'add'),
(9, 3, 'read'),
(10, 3, 'edit'),
(11, 3, 'delete'),
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
(100, 19, 'view'),
(101, 19, 'add'),
(102, 19, 'read'),
(103, 19, 'edit'),
(104, 19, 'delete'),
(105, 20, 'view'),
(106, 20, 'add'),
(107, 20, 'read'),
(108, 20, 'edit'),
(109, 20, 'delete'),
(110, 22, 'view'),
(111, 22, 'add'),
(112, 22, 'edit'),
(113, 22, 'delete'),
(114, 23, 'view'),
(115, 24, 'view'),
(116, 24, 'add'),
(117, 24, 'read'),
(118, 24, 'edit'),
(119, 24, 'delete'),
(120, 25, 'view'),
(121, 25, 'add'),
(122, 25, 'read'),
(123, 25, 'edit'),
(124, 25, 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `master_games`
--

CREATE TABLE `master_games` (
  `id_games` int(10) UNSIGNED NOT NULL,
  `sessions_id` int(11) NOT NULL,
  `start_date_games` datetime NOT NULL,
  `end_date_games` datetime NOT NULL,
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
  `command_list_stakes` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path_image_list_stakes` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_image_list_stakes` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_list_stakes`
--

INSERT INTO `master_list_stakes` (`id_list_stakes`, `name_list_stakes`, `command_list_stakes`, `path_image_list_stakes`, `name_image_list_stakes`) VALUES
(1, 'dog', 'do', './public/images/stake/', 'do.jpg'),
(2, 'dragon', 'dr', './public/images/stake/', 'dr.jpeg'),
(3, 'goat', 'gt', './public/images/stake/', 'gt.jpeg'),
(4, 'horse', 'hr', './public/images/stake/', 'hr.jpeg'),
(5, 'monkey', 'mk', './public/images/stake/', 'mk.jpeg'),
(6, 'ox', 'ox', './public/images/stake/', 'ox.jpeg'),
(7, 'pig', 'pg', './public/images/stake/', 'pg.jpeg'),
(8, 'rabbit', 'rb', './public/images/stake/', 'rb.jpeg'),
(9, 'rat', 'rt', './public/images/stake/', 'rt.jpeg'),
(10, 'rooster', 'ck', './public/images/stake/', 'rt.jpeg'),
(11, 'snake', 'sn', './public/images/stake/', 'sn.jpeg'),
(12, 'tiger', 'tg', './public/images/stake/', 'tg.jpeg');

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
(1, 0, 'Admin', '', 'mdi-account-key', 3),
(3, 1, 'Level System', 'level_system', 'mdi-layers', 1),
(4, 1, 'Manage Admin', 'admin', 'mdi-account', 2),
(6, 0, 'Master Agent', '', 'mdi-account-star', 1),
(7, 0, 'Agent', '', 'mdi-account-multiple', 2),
(8, 6, 'Manage Agent', 'agent', 'mdi-account-multiple', 0),
(9, 7, 'Manage Group', 'group', 'mdi-group', 1),
(10, 7, 'Manage Sessions', 'sessions', 'mdi-calendar-clock', 2),
(11, 7, 'Manage Game', 'game', 'mdi-gamepad-variant', 3),
(12, 0, 'Report', '', 'mdi-file-document-box', 4),
(13, 12, 'List Game', 'list_game_report', 'mdi-file-document', 1),
(14, 12, 'Gamestat', 'gamestat_report', 'mdi-file-document', 2),
(15, 1, 'Manage Master Agent', 'master_agent', 'mdi-account-star', 3),
(16, 1, 'Top Up Master Agent', 'top_up_master_agent', 'mdi-credit-card', 4),
(17, 6, 'Top Up Agent', 'top_up_agent', 'mdi-credit-card', 0),
(19, 7, 'Top Up Group', 'top_up_group', 'mdi-credit-card', 4),
(20, 7, 'Top Up Member', 'top_up_member', 'mdi-credit-card', 5),
(21, 0, 'App Configuration', '', 'mdi-wrench', 5),
(22, 21, 'List Stakes', 'list_stakes', 'mdi-animation', 1),
(23, 21, 'App Configuration', 'app_configuration', 'mdi-wrench', 3),
(24, 21, 'Menu', 'menu', 'mdi-menu', 2),
(25, 21, 'Register BOT', 'register_bot', 'mdi-account-convert', 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_reason_bots`
--

CREATE TABLE `master_reason_bots` (
  `id_reason_bots` int(10) UNSIGNED NOT NULL,
  `name_reason_bots` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `rtp_sessions` double NOT NULL,
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
-- Table structure for table `master_stake_winners`
--

CREATE TABLE `master_stake_winners` (
  `games_id` int(11) NOT NULL,
  `list_stakes_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_status_bots`
--

CREATE TABLE `master_status_bots` (
  `id_status_bots` int(10) UNSIGNED NOT NULL,
  `bots_id` int(11) NOT NULL,
  `reason_bots_id` int(11) NOT NULL,
  `status_bots` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_top_ups`
--

CREATE TABLE `master_top_ups` (
  `id_top_ups` int(10) UNSIGNED NOT NULL,
  `from_users_id` int(11) NOT NULL,
  `to_users_id` int(11) NOT NULL,
  `to_register_members_id` int(11) NOT NULL,
  `to_groups_id` int(11) NOT NULL,
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
(20, '2016_06_01_000005_create_oauth_personal_access_clients_table', 6),
(21, '2018_01_02_111906_create_master_stake_winners_table', 7),
(22, '2018_01_10_112623_create_master_bots_table', 7),
(23, '2018_01_10_112638_create_master_status_bots_table', 7),
(24, '2018_01_10_114814_create_master_reason_bots_table', 7),
(25, '2018_01_16_123904_create_master_country_phone_codes_table', 8);

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
  `bots_id` int(11) NOT NULL,
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

INSERT INTO `users` (`id`, `bots_id`, `sub_users_id`, `level_systems_id`, `name`, `email`, `password`, `phone_number_users`, `credit_users`, `max_group_users`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 1, 'Trivia', 'info@trivia.com', '$2y$10$yz8HMeQDxtLUnu48iwnZpuCZbeFzCDlawRf9Cpd/YG16E6yxVWYwy', 0, 0, 0, 'olVHNwC5n0i22U36S9iOf3Vg8DEGaCEwQOI88kAkgVZYy691mBa6b9XziVb8', '2017-12-08 10:50:13', '2017-12-11 07:54:06'),
(2, 1, 0, 2, 'Irawan', 'irawan@trivia.com', '$2y$10$WWGlS1KYqg/lKVHQ.IWmDu.0LZiATOtTu3S88Tnb28MFL1d/pajri', 6285643167946, 75000, 0, 'q8SE5c0cn2S8ZGrCHiyaV3vXX89SWbGo1tBjMLIt2KO1sqB9zDlxP44avhhf', '2018-01-12 03:54:49', '2018-01-12 04:01:10'),
(3, 1, 2, 3, 'Hanif', 'hanif@trivia.com', '$2y$10$/WQxbg8POVaDav9XNnql1OLICxXPJloNk9Itwc0/Soqgrxz.30OYG', 6285328908074, 25000, 1, 'LSymcyV7ynR7X8e7a8KZIgZXdTyDl6XB80OLje5TaHo2oK5P3yjp0ys5lXAy0GIqwbtwbvk5cOwv5kKZtHhPISNFmOez77Xboskg', '2018-01-12 04:03:56', '2018-01-12 04:03:56');

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
-- Indexes for table `master_bots`
--
ALTER TABLE `master_bots`
  ADD PRIMARY KEY (`id_bots`),
  ADD KEY `country_code_id` (`country_phone_codes_id`);

--
-- Indexes for table `master_country_phone_codes`
--
ALTER TABLE `master_country_phone_codes`
  ADD PRIMARY KEY (`id_country_phone_codes`);

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
-- Indexes for table `master_reason_bots`
--
ALTER TABLE `master_reason_bots`
  ADD PRIMARY KEY (`id_reason_bots`);

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
-- Indexes for table `master_stake_winners`
--
ALTER TABLE `master_stake_winners`
  ADD KEY `master_stake_winners_games_id_index` (`games_id`),
  ADD KEY `master_stake_winners_list_stakes_id_index` (`list_stakes_id`);

--
-- Indexes for table `master_status_bots`
--
ALTER TABLE `master_status_bots`
  ADD PRIMARY KEY (`id_status_bots`),
  ADD KEY `master_status_bots_bots_id_index` (`bots_id`),
  ADD KEY `master_status_bots_reason_bots_id_index` (`reason_bots_id`);

--
-- Indexes for table `master_top_ups`
--
ALTER TABLE `master_top_ups`
  ADD PRIMARY KEY (`id_top_ups`),
  ADD KEY `master_top_ups_host_users_id_index` (`from_users_id`),
  ADD KEY `master_top_ups_agent_users_id_index` (`to_users_id`),
  ADD KEY `to_register_members_id` (`to_register_members_id`),
  ADD KEY `to_groups_id` (`to_groups_id`);

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
  ADD KEY `users_level_systems_id_index` (`level_systems_id`),
  ADD KEY `bots_id` (`bots_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_bots`
--
ALTER TABLE `master_bots`
  MODIFY `id_bots` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_country_phone_codes`
--
ALTER TABLE `master_country_phone_codes`
  MODIFY `id_country_phone_codes` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `master_features`
--
ALTER TABLE `master_features`
  MODIFY `id_features` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

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
  MODIFY `id_menus` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `master_reason_bots`
--
ALTER TABLE `master_reason_bots`
  MODIFY `id_reason_bots` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `master_status_bots`
--
ALTER TABLE `master_status_bots`
  MODIFY `id_status_bots` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
