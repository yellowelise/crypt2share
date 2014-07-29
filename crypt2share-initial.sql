CREATE DATABASE  IF NOT EXISTS `crypt2_securezone` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `crypt2_securezone`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: crypt2_securezone
-- ------------------------------------------------------
-- Server version	5.6.11

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
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `idcontacts` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `last` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `used` int(11) DEFAULT NULL,
  PRIMARY KEY (`idcontacts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cry_contents`
--

DROP TABLE IF EXISTS `cry_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cry_contents` (
  `idcry_contents` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `contents` mediumblob,
  `hash_crypted` varchar(255) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `iduser` int(11) DEFAULT NULL,
  `uploadticket` varchar(12) NOT NULL,
  `download_count` int(11) NOT NULL DEFAULT '0',
  `download_view` int(11) NOT NULL DEFAULT '0',
  `upload_ip` varchar(15) NOT NULL,
  PRIMARY KEY (`idcry_contents`),
  KEY `uploadticket` (`uploadticket`),
  KEY `filename` (`filename`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



DROP TABLE IF EXISTS `crypted`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crypted` (
  `idcrypted` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `hash_crypted` varchar(255) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `iduser` int(11) DEFAULT NULL,
  `uploadticket` varchar(10) DEFAULT NULL,
  `file_size` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idcrypted`,`filename`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `downloads`
--

DROP TABLE IF EXISTS `downloads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `downloads` (
  `iddownload` int(11) NOT NULL AUTO_INCREMENT,
  `uploadticket` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`iddownload`)
) ENGINE=MyISAM AUTO_INCREMENT=147 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `downloads`
--

LOCK TABLES `downloads` WRITE;
/*!40000 ALTER TABLE `downloads` DISABLE KEYS */;
/*!40000 ALTER TABLE `downloads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facebook_login`
--

DROP TABLE IF EXISTS `facebook_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facebook_login` (
  `idfacebook_login` int(11) NOT NULL AUTO_INCREMENT,
  `idfacebook` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `gender` varchar(15) DEFAULT NULL,
  `locale` varchar(15) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  PRIMARY KEY (`idfacebook_login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facebook_login`
--

LOCK TABLES `facebook_login` WRITE;
/*!40000 ALTER TABLE `facebook_login` DISABLE KEYS */;
/*!40000 ALTER TABLE `facebook_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friendship`
--

DROP TABLE IF EXISTS `friendship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friendship` (
  `idfriendship` int(11) NOT NULL AUTO_INCREMENT,
  `id1` int(11) NOT NULL,
  `id2` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(3) NOT NULL,
  PRIMARY KEY (`idfriendship`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendship`
--

LOCK TABLES `friendship` WRITE;
/*!40000 ALTER TABLE `friendship` DISABLE KEYS */;
/*!40000 ALTER TABLE `friendship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invited`
--

DROP TABLE IF EXISTS `invited`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invited` (
  `idinvited` int(11) NOT NULL AUTO_INCREMENT,
  `id_sender` int(11) DEFAULT NULL,
  `invite_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `friend_email` varchar(100) DEFAULT NULL,
  `counted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`idinvited`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invited`
--

LOCK TABLES `invited` WRITE;
/*!40000 ALTER TABLE `invited` DISABLE KEYS */;
/*!40000 ALTER TABLE `invited` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mysite_comments`
--

DROP TABLE IF EXISTS `mysite_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mysite_comments` (
  `idmysite_comments` int(11) NOT NULL AUTO_INCREMENT,
  `resource` varchar(255) DEFAULT NULL,
  `comment_user` varchar(150) DEFAULT NULL,
  `comment` text,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(45) DEFAULT NULL,
  `type` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idmysite_comments`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mysite_comments`
--

LOCK TABLES `mysite_comments` WRITE;
/*!40000 ALTER TABLE `mysite_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `mysite_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mysite_contents`
--

DROP TABLE IF EXISTS `mysite_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mysite_contents` (
  `idmysite_contents` int(11) NOT NULL AUTO_INCREMENT,
  `resource` varchar(255) DEFAULT NULL,
  `content` blob,
  `content_user` varchar(100) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idmysite_contents`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mysite_contents`
--

--
-- Table structure for table `mysite_notifies`
--

DROP TABLE IF EXISTS `mysite_notifies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mysite_notifies` (
  `idmysite_notifies` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(120) DEFAULT NULL,
  `date_last_view` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `resource` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idmysite_notifies`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mysite_notifies`
--

LOCK TABLES `mysite_notifies` WRITE;
/*!40000 ALTER TABLE `mysite_notifies` DISABLE KEYS */;
/*!40000 ALTER TABLE `mysite_notifies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mysite_settings`
--

DROP TABLE IF EXISTS `mysite_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mysite_settings` (
  `idmysite_settings` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `Title` varchar(100) DEFAULT 'MySite - Crypt2Share.com',
  `how_many_images` tinyint(4) DEFAULT '6',
  `how_many_videos` tinyint(4) DEFAULT '4',
  `how_many_files` tinyint(4) DEFAULT '6',
  `how_many_audios` tinyint(4) DEFAULT '4',
  `images_title` varchar(45) DEFAULT 'Foto',
  `videos_title` varchar(45) DEFAULT 'Video',
  `files_title` varchar(45) DEFAULT 'File',
  `audios_title` varchar(45) DEFAULT 'Audio',
  `theme` varchar(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idmysite_settings`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mysite_settings`
--

LOCK TABLES `mysite_settings` WRITE;
/*!40000 ALTER TABLE `mysite_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `mysite_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `idnotification` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `text` text,
  `status` tinyint(4) NOT NULL DEFAULT '-1',
  `not_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from_not` varchar(45) NOT NULL DEFAULT 'Sistema',
  `uploadticket` varchar(15) NOT NULL DEFAULT '',
  `file_for_you` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`idnotification`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `public_upload`
--

DROP TABLE IF EXISTS `public_upload`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `public_upload` (
  `idpublic_upload` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IP` varchar(45) DEFAULT NULL,
  `ticket` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idpublic_upload`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `public_upload`
--

LOCK TABLES `public_upload` WRITE;
/*!40000 ALTER TABLE `public_upload` DISABLE KEYS */;
/*!40000 ALTER TABLE `public_upload` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` text,
  `email` varchar(100) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `ip` varchar(15) NOT NULL,
  `last_access` datetime DEFAULT NULL,
  `max_file_size` int(10) unsigned NOT NULL DEFAULT '209715200',
  `max_number_of_files` smallint(5) unsigned NOT NULL DEFAULT '10',
  `platform_from` varchar(50) DEFAULT 'website',
  `generate_pass` varchar(15) NOT NULL,
  `platform_id` varchar(45) NOT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=290 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (289,'admin','d033e22ae348aeb5660fc2140aec35850c4da997','admin@yourmail.com',1,'','2013-12-11 16:16:14',209715200,10,'website','','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-29 17:19:34
