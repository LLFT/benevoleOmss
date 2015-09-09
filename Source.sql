-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 09 Septembre 2015 à 22:25
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `omss`
--
DROP DATABASE `omss`;
CREATE DATABASE IF NOT EXISTS `omss` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `omss`;

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
`idAccount` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `nomUser` varchar(40) DEFAULT NULL,
  `prenomUser` varchar(40) DEFAULT NULL,
  `emailUser` varchar(90) DEFAULT NULL,
  `groupe_id` int(11) NOT NULL,
  `lastLogin` timestamp NULL DEFAULT NULL,
  `presentLogin` timestamp NULL DEFAULT NULL,
  `echecLogin` int(4) NOT NULL DEFAULT '0',
  `ipLogin` varchar(15) NOT NULL,
  `active` int(2) NOT NULL DEFAULT '0',
  `creer` timestamp NULL DEFAULT NULL,
  `modifier` timestamp NULL DEFAULT NULL,
  `supprimer` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `element`
--

DROP TABLE IF EXISTS `element`;
CREATE TABLE IF NOT EXISTS `element` (
`idElement` int(11) NOT NULL,
  `element` varchar(45) DEFAULT NULL,
  `descElement` varchar(90) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
`idEvent` int(11) NOT NULL,
  `nomEvent` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `lieux` varchar(45) DEFAULT NULL,
  `description` blob
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
CREATE TABLE IF NOT EXISTS `groupe` (
`idGroupe` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
`idMembre` int(11) NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `anneeNaissance` int(6) DEFAULT NULL,
  `mail` varchar(50) DEFAULT 'A renseigner',
  `fixe` varchar(15) DEFAULT NULL,
  `gsm` varchar(15) DEFAULT NULL,
  `club` varchar(50) DEFAULT NULL,
  `chkMail` int(2) DEFAULT '0',
  `chkPermis` int(2) DEFAULT '0',
  `numPermis` varchar(50) DEFAULT NULL,
  `numero` int(5) DEFAULT NULL,
  `rue` varchar(50) DEFAULT NULL,
  `complement` varchar(20) DEFAULT NULL,
  `ville` varchar(60) DEFAULT NULL,
  `codePostal` int(6) DEFAULT NULL,
  `coord` int(2) DEFAULT NULL,
  `lat` float(10,7) DEFAULT NULL,
  `lng` float(10,7) DEFAULT NULL,
  `indexMembre` int(11) DEFAULT NULL,
  `active` int(2) NOT NULL DEFAULT '1',
  `creer` timestamp NULL DEFAULT NULL,
  `modifier` timestamp NULL DEFAULT NULL,
  `supprimer` timestamp NULL DEFAULT NULL,
  `owner` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=307 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `parcours`
--

DROP TABLE IF EXISTS `parcours`;
CREATE TABLE IF NOT EXISTS `parcours` (
`id` int(11) NOT NULL,
  `label` varchar(60) DEFAULT NULL,
  `url` varchar(120) DEFAULT NULL,
  `checksum` varchar(33) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
`idPermission` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `element` varchar(50) NOT NULL,
  `allowdeny` varchar(50) NOT NULL,
  `groupe_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `relationeventmemb`
--

DROP TABLE IF EXISTS `relationeventmemb`;
CREATE TABLE IF NOT EXISTS `relationeventmemb` (
  `idRelationEM` int(11) NOT NULL,
  `idEvent` int(11) NOT NULL,
  `idMembre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table des relations entre les Events et les Membres';

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

DROP TABLE IF EXISTS `villes`;
CREATE TABLE IF NOT EXISTS `villes` (
`ville_id` mediumint(8) unsigned NOT NULL,
  `ville_departement` varchar(3) DEFAULT NULL,
  `ville_slug` varchar(255) DEFAULT NULL,
  `ville_nom` varchar(45) DEFAULT NULL,
  `ville_nom_simple` varchar(45) DEFAULT NULL,
  `ville_nom_reel` varchar(45) DEFAULT NULL,
  `ville_nom_soundex` varchar(20) DEFAULT NULL,
  `ville_nom_metaphone` varchar(22) DEFAULT NULL,
  `ville_code_postal` varchar(255) DEFAULT NULL,
  `ville_commune` varchar(3) DEFAULT NULL,
  `ville_code_commune` varchar(5) NOT NULL,
  `ville_arrondissement` smallint(3) unsigned DEFAULT NULL,
  `ville_canton` varchar(4) DEFAULT NULL,
  `ville_amdi` smallint(5) unsigned DEFAULT NULL,
  `ville_population_2010` mediumint(11) unsigned DEFAULT NULL,
  `ville_population_1999` mediumint(11) unsigned DEFAULT NULL,
  `ville_population_2012` mediumint(10) unsigned DEFAULT NULL COMMENT 'approximatif',
  `ville_densite_2010` int(11) DEFAULT NULL,
  `ville_surface` float DEFAULT NULL,
  `ville_longitude_deg` float DEFAULT NULL,
  `ville_latitude_deg` float DEFAULT NULL,
  `ville_longitude_grd` varchar(9) DEFAULT NULL,
  `ville_latitude_grd` varchar(8) DEFAULT NULL,
  `ville_longitude_dms` varchar(9) DEFAULT NULL,
  `ville_latitude_dms` varchar(8) DEFAULT NULL,
  `ville_zmin` mediumint(4) DEFAULT NULL,
  `ville_zmax` mediumint(4) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=36831 DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `account`
--
ALTER TABLE `account`
 ADD PRIMARY KEY (`idAccount`);

--
-- Index pour la table `element`
--
ALTER TABLE `element`
 ADD PRIMARY KEY (`idElement`), ADD UNIQUE KEY `element_UNIQUE` (`element`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
 ADD PRIMARY KEY (`idEvent`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
 ADD PRIMARY KEY (`idGroupe`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
 ADD PRIMARY KEY (`idMembre`);

--
-- Index pour la table `parcours`
--
ALTER TABLE `parcours`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `checksum` (`checksum`);

--
-- Index pour la table `permission`
--
ALTER TABLE `permission`
 ADD PRIMARY KEY (`idPermission`);

--
-- Index pour la table `relationeventmemb`
--
ALTER TABLE `relationeventmemb`
 ADD PRIMARY KEY (`idRelationEM`);

--
-- Index pour la table `villes`
--
ALTER TABLE `villes`
 ADD PRIMARY KEY (`ville_id`), ADD UNIQUE KEY `ville_code_commune_2` (`ville_code_commune`), ADD UNIQUE KEY `ville_slug` (`ville_slug`), ADD KEY `ville_departement` (`ville_departement`), ADD KEY `ville_nom` (`ville_nom`), ADD KEY `ville_nom_reel` (`ville_nom_reel`), ADD KEY `ville_code_commune` (`ville_code_commune`), ADD KEY `ville_code_postal` (`ville_code_postal`), ADD KEY `ville_longitude_latitude_deg` (`ville_longitude_deg`,`ville_latitude_deg`), ADD KEY `ville_nom_soundex` (`ville_nom_soundex`), ADD KEY `ville_nom_metaphone` (`ville_nom_metaphone`), ADD KEY `ville_population_2010` (`ville_population_2010`), ADD KEY `ville_nom_simple` (`ville_nom_simple`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `account`
--
ALTER TABLE `account`
MODIFY `idAccount` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `element`
--
ALTER TABLE `element`
MODIFY `idElement` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
MODIFY `idEvent` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
MODIFY `idGroupe` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
MODIFY `idMembre` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=307;
--
-- AUTO_INCREMENT pour la table `parcours`
--
ALTER TABLE `parcours`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `permission`
--
ALTER TABLE `permission`
MODIFY `idPermission` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT pour la table `villes`
--
ALTER TABLE `villes`
MODIFY `ville_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36831;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
