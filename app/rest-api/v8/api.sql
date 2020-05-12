-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 24 apr 2020 om 10:38
-- Serverversie: 10.4.11-MariaDB
-- PHP-versie: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200306121016', '2020-03-06 12:10:54');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `movie`
--

INSERT INTO `movie` (`id`, `name`, `description`) VALUES
(1, 'This is the names', 'This is the first descriptions'),
(2, 'Movie Title 2', 'Movie Description number 2'),
(3, 'This name', 'This is the third descriptions'),
(8, 'test', 'test'),
(9, 'pizza', 'pizza is amazing, don\'t you agree?');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `api_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `created_at`, `api_token`, `token_expires_at`) VALUES
(1, 'test@tester.com', '[]', 'hhaa', 'hahahahahaha', '2020-03-31 10:08:32', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9LnsiZW1haWwiOiJ0ZXN0QHRlc3Rlci5jb20iLCJyb2xlcyI6WyJST0xFX1VTRVIiXSwiY3JlYXRlZF9hdCI6eyJkYXRlIjoiMjAyMC0wMy0zMSAxMDowODozMi4wMDAwMDAiLCJ0aW1lem9uZV90eXBlIjozLCJ0aW1lem9uZSI6IkV1cm9wZVwvQmVybGluIn0sInRva2VuX2V4cGlyZXNfYXQ', '2020-03-31 10:44:27'),
(2, 'mike@test.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$R1h4U3hsTVBNa1dCaWdZYQ$tZG2yZNhw3KTN0z9RRijKiVCZL5CVP2HcolScP0njCQ', 'Mike', '2020-03-31 10:39:28', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9LnsiZW1haWwiOiJtaWtlQHRlc3QuY29tIiwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImNyZWF0ZWRfYXQiOnsiZGF0ZSI6IjIwMjAtMDMtMzEgMTA6Mzk6MjguMDAwMDAwIiwidGltZXpvbmVfdHlwZSI6MywidGltZXpvbmUiOiJFdXJvcGVcL0JlcmxpbiJ9LCJ0b2tlbl9leHBpcmVzX2F0Ijp7ImRhdGUiOiIyMDIwLTA0LTI0IDEwOjQxOjMxLjAwMDAwMCIsInRpbWV6b25lX3R5cGUiOjMsInRpbWV6b25lIjoiRXVyb3BlXC9CZXJsaW4ifSwiY3VycmVudF90aW1lIjp7ImRhdGUiOiIyMDIwLTA0LTI0IDEwOjM2OjM3LjkyNjYxNCIsInRpbWV6b25lX3R5cGUiOjMsInRpbWV6b25lIjoiRXVyb3BlXC9CZXJsaW4ifX0=', '2020-04-24 10:41:37');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexen voor tabel `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_8D93D6497BA2F5EB` (`api_token`) USING HASH;

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
