-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 22. Mrz 2018 um 15:21
-- Server-Version: 10.1.29-MariaDB
-- PHP-Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `tippspiel`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'Andreas Herz', '$2y$10$2QPgEPC.MdnFbFB20jVmwOGTTYIVkUFnyZuYm.5kCkoTldxElUbhS'),
(2, 'Hannes Rüger', '$2y$10$EeF38HlBJuN1GDbzzlAQvuuvWPLd2A47dpHN/KwDPx3QiYG6AvPNm');


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `matches`
--

CREATE TABLE `matches` (
  `id` int(11) NOT NULL,
  `group` text COLLATE utf8_german2_ci NOT NULL,
  `date` datetime NOT NULL,
  `team1` text COLLATE utf8_german2_ci NOT NULL,
  `team2` text COLLATE utf8_german2_ci NOT NULL,
  `place` text COLLATE utf8_german2_ci NOT NULL,
  `goalsTeam1` int(11) NOT NULL,
  `goalsTeam2` int(11) NOT NULL,
  `korunde` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `matches`
--

INSERT INTO `matches` (`id`, `group`, `date`, `team1`, `team2`, `place`, `goalsTeam1`, `goalsTeam2`, `korunde`) VALUES
(2, 'A', '2018-06-14 17:00:00', 'RUS', 'KSA', 'Moskau', -1, -1, 0),
(4, 'G', '2018-06-18 17:00:00', 'BEL', 'PAN', 'Sotchi', -1, -1, 0),
(5, 'A', '2018-06-15 14:00:00', 'EGY', 'URU', 'Jekateringburug', -1, -1, 0),
(6, 'E', '2018-06-17 14:00:00', 'CRC', 'SRB', 'Samara', -1, -1, 0),
(7, 'G', '2018-06-18 20:00:00', 'TUN', 'ENG', 'Wolgograd', -1, -1, 0),
(8, 'E', '2018-06-17 20:00:00', 'BRA', 'SUI', 'Rostow am Don', -1, -1, 0),
(9, 'A', '2018-06-19 20:00:00', 'RUS', 'EGY', 'Sankt Petersburg', -1, -1, 0),
(10, 'C', '2018-06-16 12:00:00', 'FRA', 'AUS', 'Kasan', -1, -1, 0),
(11, 'D', '2018-06-16 15:00:00', 'ARG', 'ISL', 'Moskau', -1, -1, 0),
(12, 'G', '2018-06-23 14:00:00', 'BEL', 'TUN', 'Moskau', -1, -1, 0),
(13, 'A', '2018-06-20 17:00:00', 'URU', 'KSA', 'Rostow am Don', -1, -1, 0),
(14, 'E', '2018-06-22 14:00:00', 'BRA', 'CRC', 'Sankt Petersburg', -1, -1, 0),
(15, 'G', '2018-06-24 14:00:00', 'ENG', 'PAN', 'Nischni Nowgorod', -1, -1, 0),
(16, 'A', '2018-06-25 16:00:00', 'URU', 'RUS', 'Samara', -1, -1, 0),
(17, 'E', '2018-06-27 20:00:00', 'SRB', 'SUI', 'Kaliningrad', -1, -1, 0),
(18, 'C', '2018-06-16 18:00:00', 'PER', 'DEN', 'Saransk', -1, -1, 0),
(19, 'E', '2018-06-27 20:00:00', 'SRB', 'BRA', 'Moskau', -1, -1, 0),
(20, 'D', '2018-06-16 21:00:00', 'CRO', 'NGA', 'Kaliningrad', -1, -1, 0),
(21, 'G', '2018-06-28 20:00:00', 'ENG', 'BEL', 'Kaliningrad', -1, -1, 0),
(22, 'A', '2018-06-14 17:00:00', 'KSA', 'EGY', 'Wolgograd', -1, -1, 0),
(23, 'C', '2018-06-21 17:00:00', 'FRA', 'PER', 'Jekaterinburg', -1, -1, 0),
(24, 'B', '2018-06-15 17:00:00', 'MAR', 'IRN', 'Sankt Petersburg', -1, -1, 0),
(25, 'E', '2018-06-27 20:00:00', 'SUI', 'CRC', 'Nischni Nowgorod', -1, -1, 0),
(26, 'F', '2018-06-17 17:00:00', 'GER', 'MEX', 'Moskau', -1, -1, 0),
(27, 'C', '2018-06-21 14:00:00', 'DEN', 'AUS', 'Samara', -1, -1, 0),
(28, 'D', '2018-06-21 20:00:00', 'ARG', 'CRO', 'Nischini Nowgorod', -1, -1, 0),
(29, 'G', '2018-06-28 20:00:00', 'PAN', 'TUN', 'Saransk', -1, -1, 0),
(30, 'B', '2018-06-15 20:00:00', 'POR', 'ESP', 'Sotschi', -1, -1, 0),
(31, 'F', '2018-06-18 17:00:00', 'SWE', 'KOR', 'Nischni Nowgorod', -1, -1, 0),
(32, 'B', '2018-06-20 14:00:00', 'POR', 'MAR', 'Moskau', -1, -1, 0),
(33, 'H', '2018-06-19 17:00:00', 'POL', 'SEN', 'Moskau', -1, -1, 0),
(34, 'F', '2018-06-23 20:00:00', 'GER', 'SWE', 'Sotschi', -1, -1, 0),
(35, 'C', '2018-06-26 16:00:00', 'DEN', 'FRA', 'Moskau', -1, -1, 0),
(36, 'B', '2018-06-20 20:00:00', 'IRN', 'ESP', 'Kasan', -1, -1, 0),
(37, 'H', '2018-06-19 14:00:00', 'JPN', 'COL', 'Saransk', -1, -1, 0),
(38, 'B', '2018-06-25 20:00:00', 'ESP', 'MAR', 'Kaliningrad', -1, -1, 0),
(39, 'F', '2018-06-23 17:00:00', 'KOR', 'MEX', 'Rostow am Don', -1, -1, 0),
(40, 'C', '2018-06-26 16:00:00', 'AUS', 'PER', 'Sotschi', -1, -1, 0),
(41, 'H', '2018-06-24 17:00:00', 'JPN', 'SEN', 'Jekaterinburg', -1, -1, 0),
(42, 'B', '2018-06-25 20:00:00', 'IRN', 'POR', 'Saransk', -1, -1, 0),
(43, 'H', '2018-06-24 20:00:00', 'POL', 'COL', 'Kasan', -1, -1, 0),
(45, 'F', '2018-06-27 16:00:00', 'MEX', 'SWE', 'Jekaterinburg', -1, -1, 0),
(46, 'H', '2018-06-28 16:00:00', 'SEN', 'COL', 'Samara', -1, -1, 0),
(47, 'F', '2018-06-27 16:00:00', 'KOR', 'GER', 'Kasan', -1, -1, 0),
(48, 'H', '2018-06-28 16:00:00', 'JPN', 'POL', 'Wolgograd', -1, -1, 0),
(49, 'D', '2018-06-22 17:00:00', 'NGA', 'ISL', 'Wolgograd', -1, -1, 0),
(50, 'D', '2018-06-26 20:00:00', 'ISL', 'CRO', 'Rostow am Dom', -1, -1, 0),
(51, 'D', '2018-06-26 20:00:00', 'NGA', 'ARG', 'Sankt Petersburg', -1, -1, 0),
(53, 'Achtelfinale 1', '2018-06-30 16:00:00', 'Sieger C', 'Zweiter D', 'Kasan', -1, -1, 1),
(54, 'Viertelfinale 1', '2018-07-06 16:00:00', 'Sieger AF 1', 'Sieger AF  2', 'Nischni Nowgorod', -1, -1, 1),
(55, 'Achtelfinale 2', '2018-06-30 20:00:00', 'Sieger A', 'Zweiter B', 'Sotchi', -1, -1, 1),
(56, 'Achtelfinale 3', '2018-07-01 18:00:00', 'Sieger B', 'Zweiter A', 'Moskau', -1, -1, 1),
(57, 'Viertelfinale 4', '2018-06-30 20:00:00', 'Sieger AF 3', 'Sieger AF 4', 'Sotschi', -1, -1, 1),
(58, 'Viertelfinale 2', '2018-07-06 20:00:00', 'Sieger AF 5', 'Sieger AF 6', 'Kasan', -1, -1, 1),
(59, 'Achtelfinale 4', '2018-07-01 20:00:00', 'Sieger D', 'Zweiter C', 'Nischni Nowgorod', -1, -1, 1),
(60, 'Viertelfinale 3', '2018-07-07 16:00:00', 'Sieger AF 7', 'Sieger AF 8', 'Samara', -1, -1, 1),
(61, 'Achtelfinale 6', '2018-07-02 20:00:00', 'Sieger G', 'Zweiter H', 'Rostow am Don', -1, -1, 1),
(62, 'Achtelfinale 7', '2018-07-03 16:00:00', 'Sieger F\r\n\r\n', 'Zweiter H', 'Sankt Petersburg', -1, -1, 1),
(63, 'Achtelfinale 5', '2018-07-02 16:00:00', 'Sieger G', 'Zweiter H', 'Samara', -1, -1, 1),
(64, 'Achtelfinale 8', '2018-07-03 20:00:00', 'Sieger H', 'Zweiter G', 'Moskau', -1, -1, 1),
(65, 'Spiel um Platz 3', '2018-07-14 16:00:00', 'Verlierer HF 1', 'Verlierer HF 2', 'Sankt Petersburg', -1, -1, 1),
(66, 'Finale', '2018-07-15 17:00:00', 'Sieger HF 1', 'Sieger HF 2', 'Moskau', -1, -1, 1),
(67, 'Halbfinale 1', '2018-07-10 20:00:00', 'Sieger VF 2', 'Sieger VF 1', 'Sankt Petersburg', -1, -1, 1),
(68, 'Halbfinale 2', '2018-07-11 20:00:00', 'Sieger VF 4', 'Sieger VF 3', 'Moskau', -1, -1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `gruppenphase` int(11) NOT NULL,
  `achtel` text NOT NULL,
  `viertel` text NOT NULL,
  `halb` text NOT NULL,
  `finale` text NOT NULL,
  `platz3` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `settings`
--

INSERT INTO `settings` (`id`, `gruppenphase`, `achtel`, `viertel`, `halb`, `finale`, `platz3`) VALUES
(0, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `short` text COLLATE utf8_german2_ci NOT NULL,
  `name` text COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `teams`
--

INSERT INTO `teams` (`id`, `short`, `name`) VALUES
(1, 'GER', 'Deutschland'),
(2, 'KSA', 'Saudi-Arabien'),
(3, 'MAR', 'Marokko'),
(4, 'MEX', 'Mexiko'),
(5, 'NGA', 'Nigeria'),
(6, 'PAN', 'Panama'),
(7, 'EGY', 'Ägypten'),
(8, 'PER', 'Peru'),
(9, 'POL', 'Polen'),
(10, 'ARG', 'Argentinien'),
(11, 'AUS', 'Australien'),
(12, 'BEL', 'Belgien'),
(13, 'POR', 'Portugal'),
(14, 'RUS', 'Russland'),
(15, 'BRA', 'Brasilien'),
(16, 'CRC', 'Costa-Rica\r\n'),
(17, 'DEN', 'Dänemark'),
(18, 'SEN', 'Senegal'),
(19, 'SRB', 'Serbien'),
(20, 'ENG', 'England'),
(21, 'FRA', 'Frankreich'),
(22, 'SUI', 'Schweiz'),
(23, 'SWE', 'Schweden'),
(24, 'TUN', 'Tunesien'),
(25, 'URU', 'Uruguay'),
(26, 'IRN', 'Iran'),
(27, 'ISL', 'Island'),
(28, 'JPN', 'Japan'),
(29, 'COL', 'Kolumbien'),
(30, 'KOR', 'Korea'),
(31, 'CRO', 'Kroatien'),
(32, 'ESP', 'Spanien');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tipps`
--

CREATE TABLE `tipps` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `matchid` int(11) NOT NULL,
  `tippTeam1` int(11) NOT NULL,
  `tippTeam2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_german2_ci NOT NULL,
  `nickname` text COLLATE utf8_german2_ci NOT NULL,
  `grade` text COLLATE utf8_german2_ci NOT NULL,
  `password` text COLLATE utf8_german2_ci NOT NULL,
  `points` int(11) NOT NULL,
  `worldchampion` text COLLATE utf8_german2_ci NOT NULL,
  `checked` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tipps`
--
ALTER TABLE `tipps`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT für Tabelle `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT für Tabelle `tipps`
--
ALTER TABLE `tipps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
