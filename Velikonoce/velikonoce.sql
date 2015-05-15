-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 20. dub 2015, 22:51
-- Verze serveru: 5.6.21
-- Verze PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `velikonoce`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `lide`
--

CREATE TABLE IF NOT EXISTS `lide` (
  `od` int(255) NOT NULL,
  `jmeno` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `telefon` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `popis` longtext COLLATE utf8_czech_ci NOT NULL,
  `titulek` varchar(255) COLLATE utf8_czech_ci NOT NULL,
`id` int(11) NOT NULL,
  `datum` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `lide`
--

INSERT INTO `lide` (`od`, `jmeno`, `prijmeni`, `telefon`, `popis`, `titulek`, `id`, `datum`) VALUES
(1, 'Romanaaah', 'Labovský', '505', 'd', 'tutulek', 7, '2015-04-19 20:03:49'),
(1, 'eeeeeeee', 'aaaaaaaaaaaaaaaaaaaa', '38373', 'aaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaa', 10, '2015-04-20 22:42:10');

-- --------------------------------------------------------

--
-- Struktura tabulky `mista`
--

CREATE TABLE IF NOT EXISTS `mista` (
  `id_mista` int(11) NOT NULL,
  `mesto` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `ulice` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `psc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `mista`
--

INSERT INTO `mista` (`id_mista`, `mesto`, `ulice`, `psc`) VALUES
(7, 'Liberec', 'ulice', 46005),
(10, 'eeeee', 'aaaaaaaaaaaaaaaaaaaa', 2147483647);

-- --------------------------------------------------------

--
-- Struktura tabulky `pocet`
--

CREATE TABLE IF NOT EXISTS `pocet` (
  `id` int(11) NOT NULL,
  `pocet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatele`
--

CREATE TABLE IF NOT EXISTS `uzivatele` (
`id` int(11) NOT NULL,
  `jmeno` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `uzivatel` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `datum` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `kod` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `aktivace` varchar(255) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `uzivatele`
--

INSERT INTO `uzivatele` (`id`, `jmeno`, `prijmeni`, `uzivatel`, `heslo`, `email`, `datum`, `kod`, `aktivace`) VALUES
(1, 'Roman', 'Labovský', 'roman.labovsky', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'roman.labovsky@pslib.cz', '2015-04-06 16:27:20', 'EFsDMqlERyKFTEn0jPtx', '1');

-- --------------------------------------------------------

--
-- Struktura tabulky `veci`
--

CREATE TABLE IF NOT EXISTS `veci` (
`id_veci` int(11) NOT NULL,
  `predmet` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `pocet` varchar(255) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `veci`
--

INSERT INTO `veci` (`id_veci`, `predmet`, `pocet`) VALUES
(7, 'nic', '7'),
(10, 'aaaaaaaaaaaaaaaaaaaa', '25278');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `lide`
--
ALTER TABLE `lide`
 ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `mista`
--
ALTER TABLE `mista`
 ADD PRIMARY KEY (`id_mista`);

--
-- Klíče pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
 ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `veci`
--
ALTER TABLE `veci`
 ADD PRIMARY KEY (`id_veci`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `lide`
--
ALTER TABLE `lide`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pro tabulku `veci`
--
ALTER TABLE `veci`
MODIFY `id_veci` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
