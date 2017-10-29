-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 212.144.99.249:3306
-- Erstellungszeit: 28. Okt 2017 um 15:35
-- Server-Version: 5.6.30
-- PHP-Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ctmlpaam_hlw`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Saison`
--

CREATE TABLE `Saison` (
  `SaisonID` int(11) NOT NULL,
  `WettbewerbID` int(11) NOT NULL,
  `Jahr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `Saison`
--

INSERT INTO `Saison` (`SaisonID`, `WettbewerbID`, `Jahr`) VALUES
(1, 1, 2012),
(2, 2, 2012),
(3, 1, 2011),
(4, 1, 2010),
(5, 1, 2009),
(6, 1, 2008),
(7, 1, 2007),
(8, 1, 2006),
(9, 1, 2005),
(10, 1, 2004),
(11, 1, 2003),
(12, 1, 2002),
(13, 1, 2001),
(14, 1, 2000),
(15, 1, 1999),
(16, 1, 1998),
(17, 1, 1997),
(18, 1, 1996),
(19, 1, 1995),
(20, 1, 2013),
(21, 2, 2013),
(22, 1, 2014),
(23, 2, 2014),
(24, 4, 2014),
(25, 1, 2015),
(26, 2, 2015),
(27, 4, 2015),
(28, 4, 2013),
(29, 4, 2012),
(30, 4, 2011),
(31, 4, 2010),
(32, 4, 2009),
(33, 4, 2008),
(34, 4, 2007),
(35, 4, 2006),
(36, 4, 2005),
(37, 4, 2004),
(38, 1, 2016),
(39, 2, 2016),
(40, 4, 2016),
(41, 1, 2017),
(42, 2, 2017),
(43, 4, 2017);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `Saison`
--
ALTER TABLE `Saison`
  ADD PRIMARY KEY (`SaisonID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `Saison`
--
ALTER TABLE `Saison`
  MODIFY `SaisonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
