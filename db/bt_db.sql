-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 24 oct. 2023 à 14:09
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `book_time`
--
CREATE DATABASE IF NOT EXISTS `book_time` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `book_time`;

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

DROP TABLE IF EXISTS `author`;
CREATE TABLE IF NOT EXISTS `author` (
  `id_author` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `author_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id_author`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `id_book` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_title` varchar(60) NOT NULL,
  `book_summary` varchar(300) NOT NULL,
  `id_series` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`id_book`),
  KEY `id_series` (`id_series`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `edition`
--

DROP TABLE IF EXISTS `edition`;
CREATE TABLE IF NOT EXISTS `edition` (
  `id_edition` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_ISBN` varchar(13) NOT NULL,
  `book_size` decimal(4,2) UNSIGNED NOT NULL,
  `book_cover` blob NOT NULL,
  `id_format` smallint UNSIGNED NOT NULL,
  `id_editor` smallint UNSIGNED NOT NULL,
  `id_book` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`id_edition`),
  KEY `id_format` (`id_format`),
  KEY `id_editor` (`id_editor`),
  KEY `id_book` (`id_book`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `editor`
--

DROP TABLE IF EXISTS `editor`;
CREATE TABLE IF NOT EXISTS `editor` (
  `id_editor` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `editor_name` varchar(30) NOT NULL,
  PRIMARY KEY (`id_editor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `following`
--

DROP TABLE IF EXISTS `following`;
CREATE TABLE IF NOT EXISTS `following` (
  `id_profile_following` smallint UNSIGNED NOT NULL,
  `id_profile_being_followed` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`id_profile_following`,`id_profile_being_followed`),
  KEY `id_profile_being_followed` (`id_profile_being_followed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `format`
--

DROP TABLE IF EXISTS `format`;
CREATE TABLE IF NOT EXISTS `format` (
  `id_format` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `format_name` varchar(20) NOT NULL,
  `format_unit` varchar(10) NOT NULL,
  PRIMARY KEY (`id_format`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `genre_tag` varchar(20) NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `grouping_`
--

DROP TABLE IF EXISTS `grouping_`;
CREATE TABLE IF NOT EXISTS `grouping_` (
  `id_edition` smallint UNSIGNED NOT NULL,
  `id_list` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`id_edition`,`id_list`),
  KEY `id_list` (`id_list`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `list`
--

DROP TABLE IF EXISTS `list`;
CREATE TABLE IF NOT EXISTS `list` (
  `id_list` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `list_name` varchar(40) NOT NULL,
  `id_profile` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`id_list`),
  KEY `id_profile` (`id_profile`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `id_profile` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  PRIMARY KEY (`id_profile`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reading`
--

DROP TABLE IF EXISTS `reading`;
CREATE TABLE IF NOT EXISTS `reading` (
  `id_edition` smallint UNSIGNED NOT NULL,
  `id_profile` smallint UNSIGNED NOT NULL,
  `book_review` varchar(450) NOT NULL,
  `book_rating` decimal(1,1) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_edition`,`id_profile`),
  KEY `id_profile` (`id_profile`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `series`
--

DROP TABLE IF EXISTS `series`;
CREATE TABLE IF NOT EXISTS `series` (
  `id_series` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `series_name` varchar(60) NOT NULL,
  PRIMARY KEY (`id_series`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tagging`
--

DROP TABLE IF EXISTS `tagging`;
CREATE TABLE IF NOT EXISTS `tagging` (
  `id_book` smallint UNSIGNED NOT NULL,
  `id_genre` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`id_book`,`id_genre`),
  KEY `id_genre` (`id_genre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `writing`
--

DROP TABLE IF EXISTS `writing`;
CREATE TABLE IF NOT EXISTS `writing` (
  `id_book` smallint UNSIGNED NOT NULL,
  `id_author` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`id_book`,`id_author`),
  KEY `id_author` (`id_author`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
