-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 02 mars 2020 à 14:18
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `camping`
--
CREATE DATABASE IF NOT EXISTS `camping` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `camping`;

-- --------------------------------------------------------

--
-- Structure de la table `emplacements`
--

DROP TABLE IF EXISTS `emplacements`;
CREATE TABLE IF NOT EXISTS `emplacements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `emplacements`
--

INSERT INTO `emplacements` (`id`, `nom`) VALUES
(1, 'La Plage'),
(2, 'Les Pins'),
(3, 'Le Maquis');

-- --------------------------------------------------------

--
-- Structure de la table `equipements`
--

DROP TABLE IF EXISTS `equipements`;
CREATE TABLE IF NOT EXISTS `equipements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `nb_emplacements` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `equipements`
--

INSERT INTO `equipements` (`id`, `nom`, `nb_emplacements`) VALUES
(1, 'Tente', 1),
(2, 'Camping-car', 2);

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `options`
--

INSERT INTO `options` (`id`, `nom`) VALUES
(1, 'Borne'),
(2, 'Club'),
(3, 'Activites');

-- --------------------------------------------------------

--
-- Structure de la table `prix`
--

DROP TABLE IF EXISTS `prix`;
CREATE TABLE IF NOT EXISTS `prix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `prix`
--

INSERT INTO `prix` (`id`, `nom`, `prix`) VALUES
(1, 'emplacement', 10),
(2, 'borne', 2),
(3, 'club', 17),
(4, 'activites', 30);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `debut` date NOT NULL,
  `fin` date NOT NULL,
  `nb_jours` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_emplacement` int(11) NOT NULL,
  `nb_emplacement` int(11) NOT NULL,
  `id_borne` int(11) NOT NULL,
  `id_club` int(11) NOT NULL,
  `id_activites` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `debut`, `fin`, `nb_jours`, `id_utilisateur`, `id_emplacement`, `nb_emplacement`, `id_borne`, `id_club`, `id_activites`, `prix`) VALUES
(24, '2020-03-04', '2020-03-05', 1, 12, 3, 1, 1, 0, 0, 12),
(20, '2020-03-03', '2020-03-04', 1, 12, 1, 1, 0, 1, 0, 27),
(21, '2020-03-13', '2020-03-15', 2, 12, 2, 1, 0, 0, 1, 80);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'membre',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `mdp`, `mail`, `role`) VALUES
(12, 'azerty', '$2y$12$jducomslBLdcq7Il7k.i.Of1KtaJGE.Wg9Z4bZCqxPnqnlGQhgy7m', 'azerty@sfr.fr', 'membre'),
(11, 'admin', '$2y$12$b/hXugDqjafmFdpm1B3DP.iA4bC2lA5yb3QheUUOIr5RgbjEj0XyW', 'admin@laplateforme.io', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
