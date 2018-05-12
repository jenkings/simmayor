-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Sob 12. kvě 2018, 19:45
-- Verze serveru: 10.1.19-MariaDB
-- Verze PHP: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `smayour`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `jmeno` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  `avatar` int(11) NOT NULL DEFAULT '1',
  `penize` bigint(11) NOT NULL,
  `dluh` int(11) NOT NULL DEFAULT '0',
  `uhli` int(11) NOT NULL DEFAULT '0',
  `ropa` int(11) NOT NULL DEFAULT '0',
  `rubin` int(11) NOT NULL DEFAULT '0',
  `odpad` int(11) NOT NULL DEFAULT '0',
  `maxprodej` int(11) NOT NULL DEFAULT '2',
  `lastsave` datetime NOT NULL,
  `kongresmando` datetime NOT NULL DEFAULT '2013-01-01 00:00:00',
  `vipdo` datetime NOT NULL DEFAULT '2013-01-01 00:00:00',
  `admin` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `bankvypisy`
--

CREATE TABLE `bankvypisy` (
  `idostrova` int(11) NOT NULL,
  `pocatecnistav` int(11) NOT NULL,
  `prijmy` text COLLATE utf8_czech_ci NOT NULL,
  `vydaje` text COLLATE utf8_czech_ci NOT NULL,
  `shrnuti` int(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `iduzivatele` int(11) NOT NULL,
  `text` tinytext COLLATE utf8_czech_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `ipzaznamy`
--

CREATE TABLE `ipzaznamy` (
  `id` int(11) NOT NULL,
  `iduzivatele` int(11) NOT NULL,
  `ip` varchar(45) COLLATE utf8_czech_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `islands`
--

CREATE TABLE `islands` (
  `id` int(11) NOT NULL,
  `idmajitele` int(11) NOT NULL,
  `mapa` text COLLATE utf8_czech_ci NOT NULL,
  `oblibenost` int(11) NOT NULL DEFAULT '1',
  `maxpopulace` int(11) NOT NULL DEFAULT '0',
  `soucasnapopulace` int(11) NOT NULL DEFAULT '0',
  `kapacita` int(11) NOT NULL DEFAULT '0',
  `dane` int(11) NOT NULL DEFAULT '17'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `od` int(11) NOT NULL,
  `pro` int(11) NOT NULL,
  `text` text NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `precteno` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `sekce` int(11) NOT NULL,
  `zprava` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `news`
--

INSERT INTO `news` (`id`, `sekce`, `zprava`) VALUES
(1, 1, 'Asie výrazně snížila produkci karamelových tyčinek'),
(2, 1, 'Předseda vlády přišel o práci. Nastává oživení ekonomiky'),
(3, 2, 'Vynálezce perpetuum mobile byl dnes ráno objeven mrtev. Američané tvrdí: \'My to nebyli\''),
(4, 3, 'Letošní závody v letech na lyžích připomínaly spíše závody v letech na hubu'),
(5, 2, 'Přední programátor hry SimMayor ztratil hlavu. Naštestí byla zálohovaná.'),
(6, 4, 'Barack Obama omylem podepsal příkaz k vlastní popravě'),
(7, 5, 'Evropská unie dala Řecko na E-bay'),
(8, 4, 'Satan vyjádřil na twitteru podporu papeži'),
(9, 4, 'Poe změnil svůj názor na blbouny'),
(10, 4, 'Steve Jobs představil iDUCH'),
(11, 5, 'Poslanecká sněmovna odkládá konec světa na příští rok'),
(12, 3, 'Usain bolt v běhu na 500 metrů předběhl sám sebe a skončil tak na 1. a 2. místě'),
(13, 4, 'Američané jsou na okraji útesu.Rusové jsou jako vždy o krok napřed.');

-- --------------------------------------------------------

--
-- Struktura tabulky `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `idtematu` int(11) NOT NULL,
  `idodepisovatele` int(11) NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `prodejna`
--

CREATE TABLE `prodejna` (
  `id` int(11) NOT NULL,
  `idprodavajiciho` int(11) NOT NULL,
  `predmet` varchar(20) NOT NULL,
  `pocet` int(11) NOT NULL,
  `cena` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `reklamy`
--

CREATE TABLE `reklamy` (
  `id` int(11) NOT NULL,
  `typ` smallint(6) NOT NULL,
  `nazev` varchar(50) NOT NULL,
  `odkaz` varchar(120) NOT NULL,
  `obrazek` varchar(120) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `reklamy`
--

INSERT INTO `reklamy` (`id`, `typ`, `nazev`, `odkaz`, `obrazek`) VALUES
(1, 1, 'Kerbal space', 'http://www.kerbal.eu/', 'http://kerbal.eu/images/banners/banner.png');

-- --------------------------------------------------------

--
-- Struktura tabulky `sazby`
--

CREATE TABLE `sazby` (
  `nazev` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `hodnota` int(11) NOT NULL,
  `changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `sazby`
--

INSERT INTO `sazby` (`nazev`, `hodnota`, `changed`) VALUES
('uroky', 7, '2013-12-10 10:22:28'),
('prispevekchudym', 9500, '2013-12-10 10:22:28'),
('danebohatych', 4500, '2013-12-10 10:22:28'),
('stavrozpoctu', 365378516, '2018-05-11 10:06:31');

-- --------------------------------------------------------

--
-- Struktura tabulky `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `idsekce` int(11) NOT NULL DEFAULT '0',
  `idzakladatele` int(11) NOT NULL DEFAULT '0',
  `datum` datetime NOT NULL,
  `nazev` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `ukoly`
--

CREATE TABLE `ukoly` (
  `id` int(11) NOT NULL,
  `idvykonavatele` int(11) NOT NULL,
  `zadani` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `bankvypisy`
--
ALTER TABLE `bankvypisy`
  ADD UNIQUE KEY `idprijemce` (`idostrova`);

--
-- Klíče pro tabulku `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `ipzaznamy`
--
ALTER TABLE `ipzaznamy`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `islands`
--
ALTER TABLE `islands`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `prodejna`
--
ALTER TABLE `prodejna`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `reklamy`
--
ALTER TABLE `reklamy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Klíče pro tabulku `sazby`
--
ALTER TABLE `sazby`
  ADD UNIQUE KEY `nazev` (`nazev`);

--
-- Klíče pro tabulku `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `ukoly`
--
ALTER TABLE `ukoly`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `ipzaznamy`
--
ALTER TABLE `ipzaznamy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `islands`
--
ALTER TABLE `islands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pro tabulku `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `prodejna`
--
ALTER TABLE `prodejna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `reklamy`
--
ALTER TABLE `reklamy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pro tabulku `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `ukoly`
--
ALTER TABLE `ukoly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
