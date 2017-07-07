-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 26. Jun 2017 um 11:15
-- Server-Version: 10.1.22-MariaDB
-- PHP-Version: 7.0.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `hlw`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `log_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `subject_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` int(11) DEFAULT NULL,
  `causer_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_id`, `subject_type`, `causer_id`, `causer_type`, `properties`, `created_at`, `updated_at`) VALUES
(1, 'default', 'created', 1, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West\",\"published\":0}}', '2017-06-19 15:11:54', '2017-06-19 15:11:54'),
(2, 'default', 'created', 2, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West Pokal\",\"published\":0}}', '2017-06-19 19:14:40', '2017-06-19 19:14:40'),
(3, 'default', 'updated', 1, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"ABC\",\"published\":0},\"old\":{\"name\":\"Hobbyliga-West\",\"published\":0}}', '2017-06-20 10:55:28', '2017-06-20 10:55:28'),
(4, 'default', 'updated', 1, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West\",\"published\":0},\"old\":{\"name\":\"ABC\",\"published\":0}}', '2017-06-20 10:55:36', '2017-06-20 10:55:36'),
(5, 'default', 'created', 3, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Altherren-Liga\",\"published\":0}}', '2017-06-20 11:39:48', '2017-06-20 11:39:48'),
(6, 'default', 'created', 4, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Bundesliga\",\"published\":0}}', '2017-06-20 11:42:19', '2017-06-20 11:42:19'),
(7, 'default', 'created', 5, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Premier League\",\"published\":0}}', '2017-06-20 11:42:53', '2017-06-20 11:42:53'),
(8, 'default', 'created', 6, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Ligue 1\",\"published\":0}}', '2017-06-20 11:44:20', '2017-06-20 11:44:20'),
(9, 'default', 'deleted', 6, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Ligue 1\",\"published\":0}}', '2017-06-20 11:53:50', '2017-06-20 11:53:50'),
(10, 'default', 'deleted', 1, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West\",\"published\":0}}', '2017-06-20 11:56:26', '2017-06-20 11:56:26'),
(11, 'default', 'deleted', 2, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West Pokal\",\"published\":0}}', '2017-06-20 11:57:12', '2017-06-20 11:57:12'),
(12, 'default', 'deleted', 5, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Premier League\",\"published\":0}}', '2017-06-20 11:59:25', '2017-06-20 11:59:25'),
(13, 'default', 'deleted', 4, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Bundesliga\",\"published\":0}}', '2017-06-20 11:59:55', '2017-06-20 11:59:55'),
(14, 'default', 'deleted', 3, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Altherren-Liga\",\"published\":0}}', '2017-06-20 11:59:56', '2017-06-20 11:59:56'),
(15, 'default', 'created', 7, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West\",\"published\":0}}', '2017-06-20 12:01:10', '2017-06-20 12:01:10'),
(16, 'default', 'created', 8, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West Pokal\",\"published\":0}}', '2017-06-20 12:01:20', '2017-06-20 12:01:20'),
(17, 'default', 'created', 9, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Altherren-Liga\",\"published\":0}}', '2017-06-20 12:01:29', '2017-06-20 12:01:29'),
(18, 'default', 'updated', 7, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-Westa\",\"published\":0},\"old\":{\"name\":\"Hobbyliga-West\",\"published\":0}}', '2017-06-20 12:28:10', '2017-06-20 12:28:10'),
(19, 'default', 'updated', 7, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West\",\"published\":0},\"old\":{\"name\":\"Hobbyliga-Westa\",\"published\":0}}', '2017-06-20 12:28:15', '2017-06-20 12:28:15'),
(20, 'default', 'created', 10, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga\",\"published\":0}}', '2017-06-22 10:33:54', '2017-06-22 10:33:54'),
(21, 'default', 'created', 11, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga2\",\"published\":0}}', '2017-06-22 10:35:07', '2017-06-22 10:35:07'),
(22, 'default', 'created', 12, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga3\",\"published\":0}}', '2017-06-22 10:39:21', '2017-06-22 10:39:21'),
(23, 'default', 'created', 13, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga4\",\"published\":1}}', '2017-06-22 10:39:28', '2017-06-22 10:39:28'),
(24, 'default', 'created', 14, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga4\",\"published\":1}}', '2017-06-22 10:44:20', '2017-06-22 10:44:20'),
(25, 'default', 'created', 15, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga5\",\"published\":0}}', '2017-06-22 10:44:28', '2017-06-22 10:44:28'),
(26, 'default', 'updated', 13, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga4\",\"published\":0},\"old\":{\"name\":\"Hobbyliga4\",\"published\":1}}', '2017-06-22 10:55:36', '2017-06-22 10:55:36'),
(27, 'default', 'updated', 13, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga4\",\"published\":1},\"old\":{\"name\":\"Hobbyliga4\",\"published\":0}}', '2017-06-22 10:58:41', '2017-06-22 10:58:41'),
(28, 'default', 'updated', 13, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga4\",\"published\":0},\"old\":{\"name\":\"Hobbyliga4\",\"published\":1}}', '2017-06-22 10:58:44', '2017-06-22 10:58:44'),
(29, 'default', 'deleted', 13, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga4\",\"published\":0}}', '2017-06-22 11:01:26', '2017-06-22 11:01:26'),
(30, 'default', 'updated', 12, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga3\",\"published\":1},\"old\":{\"name\":\"Hobbyliga3\",\"published\":0}}', '2017-06-22 11:01:43', '2017-06-22 11:01:43'),
(31, 'default', 'updated', 12, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga3\",\"published\":0},\"old\":{\"name\":\"Hobbyliga3\",\"published\":1}}', '2017-06-22 13:04:16', '2017-06-22 13:04:16'),
(32, 'default', 'updated', 7, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West\",\"published\":1},\"old\":{\"name\":\"Hobbyliga-West\",\"published\":0}}', '2017-06-22 20:34:32', '2017-06-22 20:34:32'),
(33, 'default', 'updated', 7, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West\",\"published\":0},\"old\":{\"name\":\"Hobbyliga-West\",\"published\":1}}', '2017-06-22 20:35:47', '2017-06-22 20:35:47'),
(34, 'default', 'updated', 7, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West\",\"published\":1},\"old\":{\"name\":\"Hobbyliga-West\",\"published\":0}}', '2017-06-22 20:36:04', '2017-06-22 20:36:04'),
(35, 'default', 'updated', 7, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West\",\"published\":0},\"old\":{\"name\":\"Hobbyliga-West\",\"published\":1}}', '2017-06-22 20:36:07', '2017-06-22 20:36:07'),
(36, 'default', 'updated', 7, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West\",\"published\":1},\"old\":{\"name\":\"Hobbyliga-West\",\"published\":0}}', '2017-06-22 20:36:10', '2017-06-22 20:36:10'),
(37, 'default', 'updated', 7, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West\",\"published\":0},\"old\":{\"name\":\"Hobbyliga-West\",\"published\":1}}', '2017-06-22 20:36:36', '2017-06-22 20:36:36'),
(38, 'default', 'updated', 7, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West\",\"published\":1},\"old\":{\"name\":\"Hobbyliga-West\",\"published\":0}}', '2017-06-22 20:37:04', '2017-06-22 20:37:04'),
(39, 'default', 'updated', 7, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga-West\",\"published\":0},\"old\":{\"name\":\"Hobbyliga-West\",\"published\":1}}', '2017-06-22 20:37:37', '2017-06-22 20:37:37'),
(40, 'default', 'created', 1, 'App\\Division', NULL, NULL, '{\"attributes\":{\"name\":\"1. Liga\",\"hierarchy_level\":1,\"published\":0}}', '2017-06-22 21:06:44', '2017-06-22 21:06:44'),
(41, 'default', 'created', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Liga\",\"hierarchy_level\":1,\"published\":0}}', '2017-06-23 08:40:40', '2017-06-23 08:40:40'),
(42, 'default', 'created', 2, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"2. Liga\",\"competition_id\":7,\"hierarchy_level\":2,\"published\":1}}', '2017-06-23 08:41:26', '2017-06-23 08:41:26'),
(43, 'default', 'created', 3, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"Pokal\",\"competition_id\":8,\"hierarchy_level\":1,\"published\":1}}', '2017-06-23 08:44:32', '2017-06-23 08:44:32'),
(44, 'default', 'created', 4, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"AH-Liga\",\"competition_id\":9,\"hierarchy_level\":1,\"published\":1}}', '2017-06-23 08:49:59', '2017-06-23 08:49:59'),
(45, 'default', 'deleted', 15, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga5\",\"published\":0}}', '2017-06-23 09:40:53', '2017-06-23 09:40:53'),
(46, 'default', 'updated', 14, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga4a\",\"published\":1},\"old\":{\"name\":\"Hobbyliga4\",\"published\":1}}', '2017-06-23 09:41:03', '2017-06-23 09:41:03'),
(47, 'default', 'created', 5, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"Spielklasse4a\",\"competition_id\":14,\"hierarchy_level\":1,\"published\":0}}', '2017-06-23 09:43:55', '2017-06-23 09:43:55'),
(48, 'default', 'deleted', 14, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga4a\",\"published\":1}}', '2017-06-23 09:44:02', '2017-06-23 09:44:02'),
(49, 'default', 'created', 6, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"Spielklasse3\",\"competition_id\":12,\"hierarchy_level\":1,\"published\":0}}', '2017-06-23 09:48:10', '2017-06-23 09:48:10'),
(50, 'default', 'deleted', 12, 'App\\Competition', 1, 'App\\User', '{\"attributes\":{\"name\":\"Hobbyliga3\",\"published\":0}}', '2017-06-23 09:50:14', '2017-06-23 09:50:14'),
(51, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Ligas\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":0},\"old\":{\"name\":\"1. Liga\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":0}}', '2017-06-23 13:01:14', '2017-06-23 13:01:14'),
(52, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Ligas\",\"competition_id\":8,\"hierarchy_level\":2,\"published\":1},\"old\":{\"name\":\"1. Ligas\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":0}}', '2017-06-23 13:01:23', '2017-06-23 13:01:23'),
(53, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Liga\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":0},\"old\":{\"name\":\"1. Ligas\",\"competition_id\":8,\"hierarchy_level\":2,\"published\":1}}', '2017-06-23 13:01:31', '2017-06-23 13:01:31'),
(54, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Ligas\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":0},\"old\":{\"name\":\"1. Liga\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":0}}', '2017-06-23 13:02:16', '2017-06-23 13:02:16'),
(55, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Ligas\",\"competition_id\":7,\"hierarchy_level\":2,\"published\":0},\"old\":{\"name\":\"1. Ligas\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":0}}', '2017-06-23 13:02:20', '2017-06-23 13:02:20'),
(56, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Ligas\",\"competition_id\":8,\"hierarchy_level\":2,\"published\":0},\"old\":{\"name\":\"1. Ligas\",\"competition_id\":7,\"hierarchy_level\":2,\"published\":0}}', '2017-06-23 13:02:24', '2017-06-23 13:02:24'),
(57, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Ligas\",\"competition_id\":8,\"hierarchy_level\":2,\"published\":1},\"old\":{\"name\":\"1. Ligas\",\"competition_id\":8,\"hierarchy_level\":2,\"published\":0}}', '2017-06-23 13:04:08', '2017-06-23 13:04:08'),
(58, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Liga\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":1},\"old\":{\"name\":\"1. Ligas\",\"competition_id\":8,\"hierarchy_level\":2,\"published\":1}}', '2017-06-23 13:07:11', '2017-06-23 13:07:11'),
(59, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Ligas\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":1},\"old\":{\"name\":\"1. Liga\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":1}}', '2017-06-23 13:10:19', '2017-06-23 13:10:19'),
(60, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Ligas\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":0},\"old\":{\"name\":\"1. Ligas\",\"competition_id\":\"7\",\"hierarchy_level\":\"1\",\"published\":1}}', '2017-06-23 13:10:24', '2017-06-23 13:10:24'),
(61, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Ligas\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":1},\"old\":{\"name\":\"1. Ligas\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":0}}', '2017-06-23 13:10:28', '2017-06-23 13:10:28'),
(62, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Ligas\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":0},\"old\":{\"name\":\"1. Ligas\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":1}}', '2017-06-23 13:18:31', '2017-06-23 13:18:31'),
(63, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Liga\",\"competition_id\":8,\"hierarchy_level\":2,\"published\":0},\"old\":{\"name\":\"1. Ligas\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":0}}', '2017-06-23 13:18:31', '2017-06-23 13:18:31'),
(64, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Liga\",\"competition_id\":8,\"hierarchy_level\":2,\"published\":1},\"old\":{\"name\":\"1. Liga\",\"competition_id\":8,\"hierarchy_level\":2,\"published\":0}}', '2017-06-23 13:18:40', '2017-06-23 13:18:40'),
(65, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Liga\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":1},\"old\":{\"name\":\"1. Liga\",\"competition_id\":8,\"hierarchy_level\":2,\"published\":1}}', '2017-06-23 13:18:40', '2017-06-23 13:18:40'),
(66, 'default', 'updated', 1, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"1. Liga\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":0},\"old\":{\"name\":\"1. Liga\",\"competition_id\":7,\"hierarchy_level\":1,\"published\":1}}', '2017-06-23 13:18:49', '2017-06-23 13:18:49'),
(67, 'default', 'updated', 2, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"2. Liga\",\"competition_id\":7,\"hierarchy_level\":2,\"published\":0},\"old\":{\"name\":\"2. Liga\",\"competition_id\":7,\"hierarchy_level\":2,\"published\":1}}', '2017-06-23 13:18:52', '2017-06-23 13:18:52'),
(68, 'default', 'created', 7, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"Tes\",\"competition_id\":9,\"hierarchy_level\":3,\"published\":1}}', '2017-06-23 13:25:04', '2017-06-23 13:25:04'),
(69, 'default', 'deleted', 7, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"Tes\",\"competition_id\":9,\"hierarchy_level\":3,\"published\":1}}', '2017-06-23 13:25:07', '2017-06-23 13:25:07'),
(70, 'default', 'created', 8, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"Test\",\"competition_id\":8,\"hierarchy_level\":4,\"published\":1}}', '2017-06-23 13:25:17', '2017-06-23 13:25:17'),
(71, 'default', 'deleted', 8, 'App\\Division', 1, 'App\\User', '{\"attributes\":{\"name\":\"Test\",\"competition_id\":8,\"hierarchy_level\":4,\"published\":1}}', '2017-06-23 13:25:21', '2017-06-23 13:25:21'),
(72, 'default', 'created', 1, 'App\\Season', 1, 'App\\User', '{\"attributes\":{\"division_id\":1,\"year_begin\":2017,\"year_end\":2017,\"season_nr\":1,\"champion\":null,\"ranks_champion\":\"1\",\"ranks_promotion\":null,\"ranks_relegation\":\"11,12\",\"playoff_champion\":null,\"playoff_cup\":null,\"playoff_relegation\":\"10\",\"rules\":null,\"note\":null,\"published\":0}}', '2017-06-23 14:53:09', '2017-06-23 14:53:09'),
(73, 'default', 'created', 2, 'App\\Season', 1, 'App\\User', '{\"attributes\":{\"division_id\":1,\"year_begin\":2017,\"year_end\":2017,\"season_nr\":1,\"champion\":null,\"ranks_champion\":\"1\",\"ranks_promotion\":null,\"ranks_relegation\":\"11,12\",\"playoff_champion\":null,\"playoff_cup\":null,\"playoff_relegation\":\"10\",\"rules\":null,\"note\":null,\"published\":0}}', '2017-06-23 14:53:33', '2017-06-23 14:53:33'),
(74, 'default', 'updated', 1, 'App\\Club', 1, 'App\\User', '{\"attributes\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79\",\"name_code\":\"SWB\",\"logo_url\":null,\"founded\":\"1979-01-01\",\"league_entry\":\"1997-01-01\",\"league_exit\":null,\"colours_club\":\"#000000\",\"colours_kit\":\"#ffffff\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":null,\"is_real_club\":0,\"published\":0},\"old\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79\",\"name_short\":\"SW Bilk \'79\",\"name_code\":\"SWB\",\"logo_url\":null,\"founded\":\"1979-01-01\",\"league_entry\":\"1997-01-01\",\"league_exit\":null,\"colours_club\":\"#000000\",\"colours_kit\":\"#ffffff\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":null,\"is_real_club\":0,\"published\":0}}', '2017-06-25 12:54:12', '2017-06-25 12:54:12'),
(75, 'default', 'updated', 1, 'App\\Club', 1, 'App\\User', '{\"attributes\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-01\",\"league_entry\":\"1997-01-01\",\"league_exit\":null,\"colours_club\":\"#000000\",\"colours_kit\":\"#ffffff\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":null,\"is_real_club\":0,\"published\":0},\"old\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79\",\"name_code\":\"SWB\",\"logo_url\":null,\"founded\":\"1979-01-01\",\"league_entry\":\"1997-01-01\",\"league_exit\":null,\"colours_club\":\"#000000\",\"colours_kit\":\"#ffffff\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":null,\"is_real_club\":0,\"published\":0}}', '2017-06-25 12:54:17', '2017-06-25 12:54:17'),
(76, 'default', 'updated', 1, 'App\\Club', 1, 'App\\User', '{\"attributes\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":null,\"colours_club\":\"#000000\",\"colours_kit\":\"#ffffff\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":null,\"is_real_club\":0,\"published\":0},\"old\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-01\",\"league_entry\":\"1997-01-01\",\"league_exit\":null,\"colours_club\":\"#000000\",\"colours_kit\":\"#ffffff\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":null,\"is_real_club\":0,\"published\":0}}', '2017-06-25 12:54:26', '2017-06-25 12:54:26'),
(77, 'default', 'updated', 1, 'App\\Club', 1, 'App\\User', '{\"attributes\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":\"2000-01-01\",\"colours_club\":\"#000000\",\"colours_kit\":\"#ffffff\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":null,\"is_real_club\":0,\"published\":0},\"old\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":null,\"colours_club\":\"#000000\",\"colours_kit\":\"#ffffff\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":null,\"is_real_club\":0,\"published\":0}}', '2017-06-25 12:54:31', '2017-06-25 12:54:31'),
(78, 'default', 'updated', 1, 'App\\Club', 1, 'App\\User', '{\"attributes\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":\"2000-01-01\",\"colours_club\":\"#0000a0\",\"colours_kit\":\"#ff80c0\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":null,\"is_real_club\":0,\"published\":0},\"old\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":\"2000-01-01\",\"colours_club\":\"#000000\",\"colours_kit\":\"#ffffff\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":null,\"is_real_club\":0,\"published\":0}}', '2017-06-25 12:54:39', '2017-06-25 12:54:39'),
(79, 'default', 'updated', 1, 'App\\Club', 1, 'App\\User', '{\"attributes\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":\"2000-01-01\",\"colours_club\":\"#0000a0\",\"colours_kit\":\"#ff80c0\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":\"asdasd\",\"is_real_club\":0,\"published\":0},\"old\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":\"2000-01-01\",\"colours_club\":\"#0000a0\",\"colours_kit\":\"#ff80c0\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":null,\"is_real_club\":0,\"published\":0}}', '2017-06-25 12:54:45', '2017-06-25 12:54:45'),
(80, 'default', 'updated', 1, 'App\\Club', 1, 'App\\User', '{\"attributes\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":\"2000-01-01\",\"colours_club\":\"#0000a0\",\"colours_kit\":\"#ff80c0\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":\"asdasd\",\"is_real_club\":1,\"published\":1},\"old\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":\"2000-01-01\",\"colours_club\":\"#0000a0\",\"colours_kit\":\"#ff80c0\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":\"asdasd\",\"is_real_club\":0,\"published\":0}}', '2017-06-25 12:54:49', '2017-06-25 12:54:49'),
(81, 'default', 'updated', 1, 'App\\Club', 1, 'App\\User', '{\"attributes\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":\"2000-01-01\",\"colours_club\":\"#0000a0\",\"colours_kit\":\"#ff80c0\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":\"asdasd\",\"is_real_club\":0,\"published\":1},\"old\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":\"2000-01-01\",\"colours_club\":\"#0000a0\",\"colours_kit\":\"#ff80c0\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":\"asdasd\",\"is_real_club\":1,\"published\":1}}', '2017-06-25 13:03:45', '2017-06-25 13:03:45'),
(82, 'default', 'updated', 1, 'App\\Club', 1, 'App\\User', '{\"attributes\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":\"2000-01-01\",\"colours_club\":\"#0000a0\",\"colours_kit\":\"#ff80c0\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":\"asdasd\",\"is_real_club\":0,\"published\":0},\"old\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":\"2000-01-01\",\"colours_club\":\"#0000a0\",\"colours_kit\":\"#ff80c0\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":\"asdasd\",\"is_real_club\":0,\"published\":1}}', '2017-06-25 13:03:49', '2017-06-25 13:03:49'),
(83, 'default', 'deleted', 1, 'App\\Club', 1, 'App\\User', '{\"attributes\":{\"name\":\"Schwarz Wei\\u00df Bilk \'79s\",\"name_short\":\"SW Bilk \'79s\",\"name_code\":\"SWBs\",\"logo_url\":null,\"founded\":\"1979-01-02\",\"league_entry\":\"1997-01-02\",\"league_exit\":\"2000-01-01\",\"colours_club\":\"#0000a0\",\"colours_kit\":\"#ff80c0\",\"website\":\"http:\\/\\/www.swbilk79.de\",\"facebook\":null,\"note\":\"asdasd\",\"is_real_club\":0,\"published\":0}}', '2017-06-25 13:13:46', '2017-06-25 13:13:46'),
(84, 'default', 'deleted', 2, 'App\\Club', 1, 'App\\User', '{\"attributes\":{\"name\":\"DJK Sparta Bilk e.V.\",\"name_short\":\"Sparta\",\"name_code\":\"SB\",\"logo_url\":null,\"founded\":\"1997-01-01\",\"league_entry\":null,\"league_exit\":null,\"colours_club\":\"#ffff00\",\"colours_kit\":\"#0000ff\",\"website\":\"http:\\/\\/www.sparta.de\",\"facebook\":null,\"note\":null,\"is_real_club\":1,\"published\":1}}', '2017-06-25 13:13:49', '2017-06-25 13:13:49');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cards`
--

CREATE TABLE `cards` (
  `id` int(10) UNSIGNED NOT NULL,
  `fixture_id` int(10) UNSIGNED NOT NULL,
  `player_id` int(10) UNSIGNED NOT NULL,
  `red` tinyint(1) NOT NULL DEFAULT '0',
  `ban_matches` int(10) UNSIGNED DEFAULT NULL,
  `ban_season` tinyint(1) NOT NULL DEFAULT '0',
  `ban_lifetime` tinyint(1) NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `clubs`
--

CREATE TABLE `clubs` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_short` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_url` text COLLATE utf8mb4_unicode_ci,
  `founded` date DEFAULT NULL,
  `league_entry` date DEFAULT NULL,
  `league_exit` date DEFAULT NULL,
  `colours_club` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colours_kit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` text COLLATE utf8mb4_unicode_ci,
  `facebook` text COLLATE utf8mb4_unicode_ci,
  `note` text COLLATE utf8mb4_unicode_ci,
  `is_real_club` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `clubs_seasons`
--

CREATE TABLE `clubs_seasons` (
  `club_id` int(10) UNSIGNED NOT NULL,
  `season_id` int(10) UNSIGNED NOT NULL,
  `deduction_points` int(11) DEFAULT NULL,
  `deduction_goals` int(11) DEFAULT NULL,
  `withdrawal` date DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `clubs_stadiums`
--

CREATE TABLE `clubs_stadiums` (
  `club_id` int(10) UNSIGNED NOT NULL,
  `stadium_id` int(10) UNSIGNED NOT NULL,
  `regular_home_day` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regular_home_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `is_regular_stadium` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `competitions`
--

CREATE TABLE `competitions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `competitions`
--

INSERT INTO `competitions` (`id`, `name`, `published`, `created_at`, `updated_at`) VALUES
(7, 'Hobbyliga-West', 0, '2017-06-20 12:01:10', '2017-06-22 20:37:37'),
(8, 'Hobbyliga-West Pokal', 0, '2017-06-20 12:01:20', '2017-06-20 12:01:20'),
(9, 'Altherren-Liga', 0, '2017-06-20 12:01:29', '2017-06-20 12:01:29'),
(10, 'Hobbyliga', 0, '2017-06-22 10:33:54', '2017-06-22 10:33:54'),
(11, 'Hobbyliga2', 0, '2017-06-22 10:35:07', '2017-06-22 10:35:07');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `club_id` int(10) UNSIGNED NOT NULL,
  `person_id` int(10) UNSIGNED NOT NULL,
  `hierachy_level` int(10) UNSIGNED DEFAULT NULL,
  `mail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `divisions`
--

CREATE TABLE `divisions` (
  `id` int(10) UNSIGNED NOT NULL,
  `competition_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hierarchy_level` smallint(6) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `divisions`
--

INSERT INTO `divisions` (`id`, `competition_id`, `name`, `hierarchy_level`, `published`, `created_at`, `updated_at`) VALUES
(1, 7, '1. Liga', 1, 0, '2017-06-23 08:40:40', '2017-06-23 13:18:49'),
(2, 7, '2. Liga', 2, 0, '2017-06-23 08:41:26', '2017-06-23 13:18:52'),
(3, 8, 'Pokal', 1, 1, '2017-06-23 08:44:32', '2017-06-23 08:44:32'),
(4, 9, 'AH-Liga', 1, 1, '2017-06-23 08:49:59', '2017-06-23 08:49:59');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fixtures`
--

CREATE TABLE `fixtures` (
  `id` int(10) UNSIGNED NOT NULL,
  `matchweek_id` int(10) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `stadium_id` int(10) UNSIGNED DEFAULT NULL,
  `club_id_home` int(10) UNSIGNED DEFAULT NULL,
  `club_id_away` int(10) UNSIGNED DEFAULT NULL,
  `goals_home` int(10) UNSIGNED DEFAULT NULL,
  `goals_away` int(10) UNSIGNED DEFAULT NULL,
  `goals_home_11m` int(10) UNSIGNED DEFAULT NULL,
  `goals_away_11m` int(10) UNSIGNED DEFAULT NULL,
  `goals_home_rated` int(10) UNSIGNED DEFAULT NULL,
  `goals_away_rated` int(10) UNSIGNED DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `cancelled` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `rescheduled_from_fixtures_id` int(10) UNSIGNED DEFAULT NULL,
  `rescheduled_to_fixtures_id` int(10) UNSIGNED DEFAULT NULL,
  `rescheduled_by_club` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fixtures_referees`
--

CREATE TABLE `fixtures_referees` (
  `fixture_id` int(10) UNSIGNED NOT NULL,
  `referee_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `goals`
--

CREATE TABLE `goals` (
  `id` int(10) UNSIGNED NOT NULL,
  `fixture_id` int(10) UNSIGNED NOT NULL,
  `player_id` int(10) UNSIGNED NOT NULL,
  `score` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `matchweeks`
--

CREATE TABLE `matchweeks` (
  `id` int(10) UNSIGNED NOT NULL,
  `season_id` int(10) UNSIGNED NOT NULL,
  `number_consecutive` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `begin` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_03_31_162347_create_activity_log_table', 1),
(4, '2017_03_31_181935_create_permission_tables', 1),
(5, '2017_04_23_145503_create_competitions_table', 1),
(6, '2017_04_23_145727_create_divisions_table', 1),
(7, '2017_04_23_150237_create_clubs_table', 1),
(8, '2017_04_23_154356_create_seasons_table', 1),
(9, '2017_04_23_155424_create_matchweeks_table', 1),
(10, '2017_04_23_155755_create_stadiums_table', 1),
(11, '2017_04_23_161828_create_fixtures_table', 1),
(12, '2017_06_09_123354_create_people_table', 1),
(13, '2017_06_09_124240_create_contacts_table', 1),
(14, '2017_06_09_125157_create_players_table', 1),
(15, '2017_06_09_125335_create_positions_table', 1),
(16, '2017_06_09_125802_create_cards_table', 1),
(17, '2017_06_09_125857_create_goals_table', 1),
(18, '2017_06_09_130004_create_referees_table', 1),
(19, '2017_06_09_130406_create_fixtures_referees_table', 1),
(20, '2017_06_09_130536_create_clubs_stadiums_table', 1),
(21, '2017_06_09_130853_create_clubs_seasons_table', 1),
(22, '2017_06_12_171030_add_rescheduled_by_to_fixtures_table', 1),
(23, '2017_06_24_203234_add_real_club_column_to_clubs_table', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `people`
--

CREATE TABLE `people` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registered_at_club` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `players`
--

CREATE TABLE `players` (
  `id` int(10) UNSIGNED NOT NULL,
  `person_id` int(10) UNSIGNED NOT NULL,
  `club_id` int(10) UNSIGNED NOT NULL,
  `sign_on` date NOT NULL,
  `sign_off` date DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `positions_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `positions`
--

CREATE TABLE `positions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `referees`
--

CREATE TABLE `referees` (
  `id` int(10) UNSIGNED NOT NULL,
  `person_id` int(10) UNSIGNED NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `seasons`
--

CREATE TABLE `seasons` (
  `id` int(10) UNSIGNED NOT NULL,
  `division_id` int(10) UNSIGNED NOT NULL,
  `year_begin` int(10) UNSIGNED NOT NULL,
  `year_end` int(10) UNSIGNED NOT NULL,
  `season_nr` int(10) UNSIGNED DEFAULT NULL,
  `champion` int(10) UNSIGNED DEFAULT NULL,
  `ranks_champion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ranks_promotion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ranks_relegation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `playoff_champion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `playoff_cup` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `playoff_relegation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rules` text COLLATE utf8mb4_unicode_ci,
  `note` text COLLATE utf8mb4_unicode_ci,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `seasons`
--

INSERT INTO `seasons` (`id`, `division_id`, `year_begin`, `year_end`, `season_nr`, `champion`, `ranks_champion`, `ranks_promotion`, `ranks_relegation`, `playoff_champion`, `playoff_cup`, `playoff_relegation`, `rules`, `note`, `published`, `created_at`, `updated_at`) VALUES
(1, 1, 2017, 2017, 1, NULL, '1', NULL, '11,12', NULL, NULL, '10', NULL, NULL, 0, '2017-06-23 14:53:09', '2017-06-23 14:53:09'),
(2, 1, 2017, 2017, 1, NULL, '1', NULL, '11,12', NULL, NULL, '10', NULL, NULL, 0, '2017-06-23 14:53:33', '2017-06-23 14:53:33');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stadiums`
--

CREATE TABLE `stadiums` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_short` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmaps` text COLLATE utf8mb4_unicode_ci,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Kevin', 'kvnkaiser@gmail.com', '$2y$10$A1aVDrtzjQgSgTc7ibdixOSUGeE7EAV7RzbgqsH9M7t73dcXHOMvG', 'jayiSwqCQ8m0i4vPHqCejn5AHO0kNwbQVjGJmhIPU4v7F9q8cMv0oTmPTDE0', '2017-06-18 09:52:23', '2017-06-18 09:52:23');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_has_permissions`
--

CREATE TABLE `user_has_permissions` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_has_roles`
--

CREATE TABLE `user_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indizes für die Tabelle `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cards_fixture_id_foreign` (`fixture_id`),
  ADD KEY `cards_player_id_foreign` (`player_id`);

--
-- Indizes für die Tabelle `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `clubs_seasons`
--
ALTER TABLE `clubs_seasons`
  ADD PRIMARY KEY (`club_id`,`season_id`),
  ADD KEY `clubs_seasons_season_id_foreign` (`season_id`);

--
-- Indizes für die Tabelle `clubs_stadiums`
--
ALTER TABLE `clubs_stadiums`
  ADD PRIMARY KEY (`club_id`,`stadium_id`),
  ADD KEY `clubs_stadiums_stadium_id_foreign` (`stadium_id`);

--
-- Indizes für die Tabelle `competitions`
--
ALTER TABLE `competitions`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_club_id_foreign` (`club_id`),
  ADD KEY `contacts_person_id_foreign` (`person_id`);

--
-- Indizes für die Tabelle `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `divisions_competition_id_foreign` (`competition_id`);

--
-- Indizes für die Tabelle `fixtures`
--
ALTER TABLE `fixtures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fixtures_matchweek_id_foreign` (`matchweek_id`),
  ADD KEY `fixtures_stadium_id_foreign` (`stadium_id`),
  ADD KEY `fixtures_club_id_home_foreign` (`club_id_home`),
  ADD KEY `fixtures_club_id_away_foreign` (`club_id_away`),
  ADD KEY `fixtures_rescheduled_from_fixtures_id_foreign` (`rescheduled_from_fixtures_id`),
  ADD KEY `fixtures_rescheduled_to_fixtures_id_foreign` (`rescheduled_to_fixtures_id`),
  ADD KEY `fixtures_rescheduled_by_club_foreign` (`rescheduled_by_club`);

--
-- Indizes für die Tabelle `fixtures_referees`
--
ALTER TABLE `fixtures_referees`
  ADD PRIMARY KEY (`fixture_id`,`referee_id`),
  ADD KEY `fixtures_referees_referee_id_foreign` (`referee_id`);

--
-- Indizes für die Tabelle `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goals_fixture_id_foreign` (`fixture_id`),
  ADD KEY `goals_player_id_foreign` (`player_id`);

--
-- Indizes für die Tabelle `matchweeks`
--
ALTER TABLE `matchweeks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matchweeks_season_id_foreign` (`season_id`);

--
-- Indizes für die Tabelle `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indizes für die Tabelle `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indizes für die Tabelle `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `players_person_id_foreign` (`person_id`),
  ADD KEY `players_club_id_foreign` (`club_id`);

--
-- Indizes für die Tabelle `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `referees`
--
ALTER TABLE `referees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referees_person_id_foreign` (`person_id`);

--
-- Indizes für die Tabelle `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indizes für die Tabelle `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indizes für die Tabelle `seasons`
--
ALTER TABLE `seasons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seasons_division_id_foreign` (`division_id`),
  ADD KEY `seasons_champion_foreign` (`champion`);

--
-- Indizes für die Tabelle `stadiums`
--
ALTER TABLE `stadiums`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indizes für die Tabelle `user_has_permissions`
--
ALTER TABLE `user_has_permissions`
  ADD PRIMARY KEY (`user_id`,`permission_id`),
  ADD KEY `user_has_permissions_permission_id_foreign` (`permission_id`);

--
-- Indizes für die Tabelle `user_has_roles`
--
ALTER TABLE `user_has_roles`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `user_has_roles_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT für Tabelle `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `competitions`
--
ALTER TABLE `competitions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT für Tabelle `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT für Tabelle `fixtures`
--
ALTER TABLE `fixtures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `goals`
--
ALTER TABLE `goals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `matchweeks`
--
ALTER TABLE `matchweeks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT für Tabelle `people`
--
ALTER TABLE `people`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `players`
--
ALTER TABLE `players`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `referees`
--
ALTER TABLE `referees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `seasons`
--
ALTER TABLE `seasons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `stadiums`
--
ALTER TABLE `stadiums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `cards_fixture_id_foreign` FOREIGN KEY (`fixture_id`) REFERENCES `fixtures` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cards_player_id_foreign` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `clubs_seasons`
--
ALTER TABLE `clubs_seasons`
  ADD CONSTRAINT `clubs_seasons_club_id_foreign` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clubs_seasons_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `clubs_stadiums`
--
ALTER TABLE `clubs_stadiums`
  ADD CONSTRAINT `clubs_stadiums_club_id_foreign` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clubs_stadiums_stadium_id_foreign` FOREIGN KEY (`stadium_id`) REFERENCES `stadiums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_club_id_foreign` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contacts_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `divisions`
--
ALTER TABLE `divisions`
  ADD CONSTRAINT `divisions_competition_id_foreign` FOREIGN KEY (`competition_id`) REFERENCES `competitions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `fixtures`
--
ALTER TABLE `fixtures`
  ADD CONSTRAINT `fixtures_club_id_away_foreign` FOREIGN KEY (`club_id_away`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fixtures_club_id_home_foreign` FOREIGN KEY (`club_id_home`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fixtures_matchweek_id_foreign` FOREIGN KEY (`matchweek_id`) REFERENCES `matchweeks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fixtures_rescheduled_by_club_foreign` FOREIGN KEY (`rescheduled_by_club`) REFERENCES `clubs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fixtures_rescheduled_from_fixtures_id_foreign` FOREIGN KEY (`rescheduled_from_fixtures_id`) REFERENCES `fixtures` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fixtures_rescheduled_to_fixtures_id_foreign` FOREIGN KEY (`rescheduled_to_fixtures_id`) REFERENCES `fixtures` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fixtures_stadium_id_foreign` FOREIGN KEY (`stadium_id`) REFERENCES `stadiums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `fixtures_referees`
--
ALTER TABLE `fixtures_referees`
  ADD CONSTRAINT `fixtures_referees_fixture_id_foreign` FOREIGN KEY (`fixture_id`) REFERENCES `fixtures` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fixtures_referees_referee_id_foreign` FOREIGN KEY (`referee_id`) REFERENCES `referees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `goals`
--
ALTER TABLE `goals`
  ADD CONSTRAINT `goals_fixture_id_foreign` FOREIGN KEY (`fixture_id`) REFERENCES `fixtures` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `goals_player_id_foreign` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `matchweeks`
--
ALTER TABLE `matchweeks`
  ADD CONSTRAINT `matchweeks_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_club_id_foreign` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `players_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `referees`
--
ALTER TABLE `referees`
  ADD CONSTRAINT `referees_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `seasons`
--
ALTER TABLE `seasons`
  ADD CONSTRAINT `seasons_champion_foreign` FOREIGN KEY (`champion`) REFERENCES `clubs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `seasons_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `user_has_permissions`
--
ALTER TABLE `user_has_permissions`
  ADD CONSTRAINT `user_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_has_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `user_has_roles`
--
ALTER TABLE `user_has_roles`
  ADD CONSTRAINT `user_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_has_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
