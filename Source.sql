CREATE DATABASE  IF NOT EXISTS `omss` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `omss`;
-- MySQL dump 10.13  Distrib 5.6.21, for Win32 (x86)
--
-- Host: localhost    Database: omss
-- ------------------------------------------------------
-- Server version	5.6.21

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `idEvent` int(11) NOT NULL AUTO_INCREMENT,
  `nomEvent` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `lieux` varchar(45) DEFAULT NULL,
  `description` blob,
  `active` int(2) DEFAULT '1',
  `creer` timestamp NULL DEFAULT NULL,
  `modifier` timestamp NULL DEFAULT NULL,
  `supprimer` timestamp NULL DEFAULT NULL,
  `owner` int(11) DEFAULT NULL,
  PRIMARY KEY (`idEvent`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


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
  `chkMail` int(2) NOT NULL DEFAULT '0',
  `chkPermis` int(2) NOT NULL DEFAULT '0',
  `chkSignaleur` int(2) NOT NULL DEFAULT '0',
  `chkFormulaire` int(2) NOT NULL DEFAULT '0',
  `numPermis` varchar(50) DEFAULT NULL,
  `numero` int(5) DEFAULT NULL,
  `rue` varchar(50) DEFAULT NULL,
  `complement` varchar(20) DEFAULT NULL,
  `ville` varchar(60) DEFAULT NULL,
  `codePostal` int(6) DEFAULT NULL,
  `coord` int(2) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lng` varchar(20) DEFAULT NULL,
  `indexMembre` int(11) DEFAULT NULL,
  `comment` blob,
  `active` int(2) NOT NULL DEFAULT '1',
  `creer` timestamp NULL DEFAULT NULL,
  `modifier` timestamp NULL DEFAULT NULL,
  `supprimer` timestamp NULL DEFAULT NULL,
  `owner` int(11) DEFAULT NULL,
  `updater` int(11) DEFAULT NULL,
  `deleter` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMembre`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `parcours`
--

DROP TABLE IF EXISTS `parcours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parcours` (
  `idParcours` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(60) DEFAULT NULL,
  `url` varchar(120) DEFAULT NULL,
  `checksum` varchar(33) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`idParcours`),
  UNIQUE KEY `checksum` (`checksum`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` VALUES (3,'ACCESS','membres::list','ALLOW',4),(4,'ACCESS','membres::listEmptyAdress','ALLOW',4),(5,'ACCESS','membres::listEmptyMail','ALLOW',4),(6,'ACCESS','membres::listEmptyPermis','ALLOW',4),(7,'ACCESS','membres::localizeMembers','ALLOW',4),(8,'ACCESS','membres::exportCSV','ALLOW',4),(9,'ACCESS','parcours::list','ALLOW',4),(10,'ACCESS','account::list','ALLOW',4),(11,'ACCESS','groupe::list','ALLOW',4),(12,'ACCESS','permission::list','ALLOW',4),(15,'ACCESS','membres::list','ALLOW',1),(20,'ACCESS','membres::reIndexAllMembers','ALLOW',4),(21,'ACCESS','membres::new','ALLOW',2),(22,'ACCESS','membres::new','ALLOW',3),(23,'ACCESS','membres::new','ALLOW',4),(24,'ACCESS','membres::exportCSV','ALLOW',2),(25,'ACCESS','membres::exportCSV','ALLOW',3),(27,'ACCESS','membres::edit','ALLOW',2),(28,'ACCESS','membres::edit','ALLOW',3),(29,'ACCESS','membres::edit','ALLOW',4),(30,'ACCESS','membres::localizeMember','ALLOW',3),(31,'ACCESS','membres::localizeMember','ALLOW',4),(32,'ACCESS','membres::list','ALLOW',3),(33,'ACCESS','membres::listEmptyAdress','ALLOW',3),(34,'ACCESS','membres::listEmptyMail','ALLOW',3),(35,'ACCESS','membres::listEmptyPermis','ALLOW',3),(38,'ACCESS','membres::list','ALLOW',2),(39,'ACCESS','membres::listEmptyAdress','ALLOW',2),(40,'ACCESS','membres::listEmptyMail','ALLOW',2),(41,'ACCESS','membres::listEmptyPermis','ALLOW',2),(45,'ACCESS','events::list','ALLOW',4),(46,'ACCESS','parcours::list','ALLOW',3),(49,'ACCESS','parcours::show','ALLOW',1),(51,'ACCESS','parcours::show','ALLOW',2),(53,'ACCESS','parcours::show','ALLOW',4),(54,'ACCESS','parcours::show','ALLOW',3),(55,'ACCESS','account::new','ALLOW',4),(56,'ACCESS','account::edit','ALLOW',4),(57,'ACCESS','account::show','ALLOW',4),(58,'ACCESS','account::delete','ALLOW',4),(59,'ACCESS','events::show','ALLOW',4),(60,'ACCESS','events::new','ALLOW',4),(61,'ACCESS','events::edit','ALLOW',4),(62,'ACCESS','events::exportCSV','ALLOW',4),(63,'ACCESS','events::archiver','ALLOW',4),(64,'ACCESS','events::edit','ALLOW',3),(66,'ACCESS','events::exportCSV','ALLOW',2),(67,'ACCESS','events::exportCSV','ALLOW',3),(68,'ACCESS','events::new','ALLOW',3),(69,'ACCESS','events::show','ALLOW',1),(70,'ACCESS','events::show','ALLOW',2),(71,'ACCESS','events::show','ALLOW',3),(72,'ACCESS','events::list','ALLOW',1),(73,'ACCESS','events::list','ALLOW',2),(74,'ACCESS','events::list','ALLOW',3),(75,'ACCESS','groupe::edit','ALLOW',4),(76,'ACCESS','membres::show','ALLOW',4),(77,'ACCESS','membres::delete','ALLOW',4),(78,'ACCESS','membres::ajaxSignaleur','ALLOW',4),(79,'ACCESS','membres::ajaxJoinEventMembre','ALLOW',4),(81,'ACCESS','membres::delete','ALLOW',2),(82,'ACCESS','membres::delete','ALLOW',3),(83,'ACCESS','membres::ajaxSignaleur','ALLOW',2),(84,'ACCESS','membres::ajaxSignaleur','ALLOW',3),(85,'ACCESS','membres::ajaxJoinEventMembre','ALLOW',2),(86,'ACCESS','membres::ajaxJoinEventMembre','ALLOW',3),(87,'ACCESS','parcours::new','ALLOW',4),(88,'ACCESS','permission::addElement','ALLOW',4),(89,'ACCESS','permission::editPermission','ALLOW',4),(90,'ACCESS','membres::show','ALLOW',1),(91,'ACCESS','membres::show','ALLOW',2),(92,'ACCESS','membres::show','ALLOW',3),(93,'ACCESS','account::edit','ALLOW',3),(94,'ACCESS','account::list','ALLOW',3),(95,'ACCESS','account::new','ALLOW',3),(96,'ACCESS','account::show','ALLOW',3),(97,'ACCESS','events::archiver','ALLOW',3),(98,'ACCESS','events::edit','ALLOW',2),(100,'ACCESS','membres::reIndexAllMembers','ALLOW',2),(101,'ACCESS','membres::reIndexAllMembers','ALLOW',3),(102,'ACCESS','parcours::new','ALLOW',3),(103,'ACCESS','parcours::new','ALLOW',2),(104,'ACCESS','parcours::list','ALLOW',2);
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `points`
--

DROP TABLE IF EXISTS `points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `points` (
  `idPoint` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lng` varchar(20) DEFAULT NULL,
  `parcours_id` int(11) NOT NULL,
  `typeofpoint_id` int(11) NOT NULL,
  PRIMARY KEY (`idPoint`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `relationeventmemb`
--

DROP TABLE IF EXISTS `relationeventmemb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relationeventmemb` (
  `event_id` int(11) NOT NULL,
  `membre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table des relations entre les Events et les Membres';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `relationpointmemb`
--

DROP TABLE IF EXISTS `relationpointmemb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relationpointmemb` (
  `point_id` int(11) NOT NULL,
  `membre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `typeofpoint`
--

DROP TABLE IF EXISTS `typeofpoint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typeofpoint` (
  `idTypeofpoint` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `urlLogo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idTypeofpoint`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-10-16 15:28:56
