CREATE DATABASE  IF NOT EXISTS `omss` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `omss`;
-- MySQL dump 10.13  Distrib 5.6.21, for Win32 (x86)
--
-- Host: 195.154.10.243    Database: omss
-- ------------------------------------------------------
-- Server version	5.1.73

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `idAccount` int(11) NOT NULL AUTO_INCREMENT,
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
  `supprimer` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idAccount`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


-- Table structure for table `element`
--

DROP TABLE IF EXISTS `element`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `element` (
  `idElement` int(11) NOT NULL AUTO_INCREMENT,
  `element` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idElement`),
  UNIQUE KEY `element_UNIQUE` (`element`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `element`
--

LOCK TABLES `element` WRITE;
/*!40000 ALTER TABLE `element` DISABLE KEYS */;
INSERT INTO `element` VALUES (1,'membres::list'),(2,'membres::listEmptyAdress'),(3,'membres::listEmptyMail'),(4,'membres::listEmptyPermis'),(5,'membres::localizeMembers'),(6,'membres::exportCSV'),(7,'parcours::list'),(8,'account::list'),(9,'groupe::list'),(10,'permission::list'),(11,'membres::reIndexAllMembers'),(12,'membres::new'),(13,'membres::edit'),(14,'membres::localizeMember');
/*!40000 ALTER TABLE `element` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `idEvent` int(11) NOT NULL AUTO_INCREMENT,
  `nomEvent` varchar(45) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `lieux` varchar(45) DEFAULT NULL,
  `description` blob,
  PRIMARY KEY (`idEvent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `idEvent` int(11) NOT NULL AUTO_INCREMENT,
  `nomEvent` varchar(45) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `lieux` varchar(45) DEFAULT NULL,
  `description` blob,
  `eventcol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idEvent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groupe` (
  `idGroupe` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`idGroupe`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupe`
--

LOCK TABLES `groupe` WRITE;
/*!40000 ALTER TABLE `groupe` DISABLE KEYS */;
INSERT INTO `groupe` VALUES (1,'Lecteur'),(2,'Redacteur'),(3,'Administrateur'),(4,'Concepteur');
/*!40000 ALTER TABLE `groupe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membres`
--

DROP TABLE IF EXISTS `membres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membres` (
  `idMembre` int(11) NOT NULL AUTO_INCREMENT,
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
  `owner` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMembre`)
) ENGINE=InnoDB AUTO_INCREMENT=307 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `parcours`
--

DROP TABLE IF EXISTS `parcours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parcours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(60) DEFAULT NULL,
  `url` varchar(120) DEFAULT NULL,
  `checksum` varchar(33) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checksum` (`checksum`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission` (
  `idPermission` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(50) NOT NULL,
  `element` varchar(50) NOT NULL,
  `allowdeny` varchar(50) NOT NULL,
  `groupe_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPermission`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` VALUES (3,'ACCESS','membres::list','ALLOW',4),(4,'ACCESS','membres::listEmptyAdress','ALLOW',4),(5,'ACCESS','membres::listEmptyMail','ALLOW',4),(6,'ACCESS','membres::listEmptyPermis','ALLOW',4),(7,'ACCESS','membres::localizeMembers','ALLOW',4),(8,'ACCESS','membres::exportCSV','ALLOW',4),(9,'ACCESS','parcours::list','ALLOW',4),(10,'ACCESS','account::list','ALLOW',4),(11,'ACCESS','groupe::list','ALLOW',4),(12,'ACCESS','permission::list','ALLOW',4),(15,'ACCESS','membres::list','ALLOW',1),(20,'ACCESS','membres::reIndexAllMembers','ALLOW',4),(21,'ACCESS','membres::new','ALLOW',2),(22,'ACCESS','membres::new','ALLOW',3),(23,'ACCESS','membres::new','ALLOW',4),(24,'ACCESS','membres::exportCSV','ALLOW',2),(25,'ACCESS','membres::exportCSV','ALLOW',3),(26,'ACCESS','membres::exportCSV','ALLOW',4),(27,'ACCESS','membres::edit','ALLOW',2),(28,'ACCESS','membres::edit','ALLOW',3),(29,'ACCESS','membres::edit','ALLOW',4),(30,'ACCESS','membres::localizeMember','ALLOW',3),(31,'ACCESS','membres::localizeMember','ALLOW',4),(32,'ACCESS','membres::list','ALLOW',3),(33,'ACCESS','membres::listEmptyAdress','ALLOW',3),(34,'ACCESS','membres::listEmptyMail','ALLOW',3),(35,'ACCESS','membres::listEmptyPermis','ALLOW',3),(36,'ACCESS','membres::localizeMembers','ALLOW',3),(37,'ACCESS','membres::exportCSV','ALLOW',3),(38,'ACCESS','membres::list','ALLOW',2),(39,'ACCESS','membres::listEmptyAdress','ALLOW',2),(40,'ACCESS','membres::listEmptyMail','ALLOW',2),(41,'ACCESS','membres::listEmptyPermis','ALLOW',2),(43,'ACCESS','membres::exportCSV','ALLOW',2),(44,'ACCESS','element::list','ALLOW',4);
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;


/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-09 23:59:47
