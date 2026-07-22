-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: sakib
-- ------------------------------------------------------
-- Server version	10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `desig` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `pass` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `access` mediumtext DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin',NULL,'admin','40bd001563085fc35165329ea1ff5c5ecbdbbeef','commandernet24@gmail.com','017000000','','dashboard,investor,investor_add,investor_edit,investor_delete,investment,investment_add,investment_delete,profit_generate,profit_generate_add,profit_generate_edit,profit_generate_delete,mng_pages,mng_pages_add,mng_pages_edit,mng_pages_delete,sms','2026-07-22 07:20:10');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `investor`
--

DROP TABLE IF EXISTS `investor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `investor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cus_id` varchar(50) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `commission` float DEFAULT 0,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `investor`
--

LOCK TABLES `investor` WRITE;
/*!40000 ALTER TABLE `investor` DISABLE KEYS */;
INSERT INTO `investor` VALUES (1,'XM18979431','123','Md Sabuj Hossain','01707777425','model town, 1 no road,zinzira,keranigonj,dhaka-1310',70,NULL),(4,'5','123','Md Rasel','01988088803','Commander house, Habib Nagar, Suvadda Uttar Para, South Keraniganj, Dhaka -1310.',0,NULL),(5,'4','123','Md Mustafa Hussain Babu ','01611611057','51 Sarafat Gonj Lane Gandaria Dhaka 1204',0,NULL),(6,'3','1234','Md Badsha Sheikh (Nirob)','01729288870','Siraj Market,4Tola,Tvs Bike Building,Kodomtoli U-turn,Keraniganj,Dhaka',0,NULL),(7,'2','123','ANOWAR HOSSAN MILON','01727472868','Vagna mazhati toha monjil kalindi Keraniganj Dhaka 1310',0,NULL),(8,'6','123','Md Sohel Hossain','01677070804','J.K Nibas, Muslimbag, Kalindi, Keraniganj Model, Dhaka.',0,NULL),(9,'7','123','Mazharul Islam Bappy','01707009267','Kodomtoli, South Keranigonj, Dhaka-1310',0,NULL),(10,'8','123','Mahadi Hasan Rubel','01783855558','Golam Bazar Hossain Somiti Tower',0,NULL),(11,'9','123','Md Selim','01841708817','utrail, konda-1421, south Keraniganj, Dhaka-1310',0,NULL),(12,'10','123','Rifat Hossain','01610606032','Asif Hossain House, poshchim Imam bari, Aganagar, South Keraniganj, Dhaka-1310.',0,NULL),(13,'11','Intakhab','Iftakhyrul alam','01850842242','Hasara,sreenagar.munshiganj',0,NULL);
/*!40000 ALTER TABLE `investor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ledger`
--

DROP TABLE IF EXISTS `ledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ledger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `investor_id` int(11) DEFAULT NULL,
  `debit` float DEFAULT 0,
  `credit` float DEFAULT 0,
  `remarks` varchar(500) DEFAULT NULL,
  `type` varchar(15) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `date` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ledger`
--

LOCK TABLES `ledger` WRITE;
/*!40000 ALTER TABLE `ledger` DISABLE KEYS */;
INSERT INTO `ledger` VALUES (3,NULL,NULL,0,0,'','generate',1,NULL),(4,NULL,NULL,0,0,'','generate',1,NULL),(16,NULL,NULL,0,0,'','generate',1,NULL),(17,NULL,NULL,0,0,'','generate',1,NULL),(18,NULL,NULL,0,0,'','generate',1,NULL),(19,NULL,NULL,0,0,'','generate',1,NULL),(20,NULL,NULL,0,0,'','generate',1,NULL),(21,NULL,NULL,0,0,'','generate',1,NULL),(22,NULL,NULL,0,0,'','generate',1,NULL),(23,NULL,NULL,0,0,'','generate',1,NULL),(24,NULL,NULL,0,0,'','generate',1,NULL),(25,NULL,NULL,0,0,'','generate',1,NULL),(26,NULL,NULL,0,0,'','generate',1,NULL),(27,NULL,NULL,0,0,'','generate',1,NULL),(28,NULL,NULL,0,0,'','generate',1,NULL),(29,NULL,NULL,0,0,'','generate',1,NULL),(30,NULL,NULL,0,0,'','generate',1,NULL),(31,NULL,NULL,0,0,'','generate',1,NULL),(32,NULL,NULL,0,0,'','generate',1,NULL),(33,NULL,NULL,0,0,'','generate',1,NULL),(34,NULL,NULL,0,0,'','generate',1,NULL),(35,NULL,NULL,0,0,'','generate',1,NULL),(36,NULL,NULL,0,0,'','generate',1,NULL),(37,NULL,NULL,0,0,'','generate',1,NULL),(38,NULL,NULL,0,0,'','generate',1,NULL),(39,NULL,NULL,0,0,'','generate',1,NULL),(40,NULL,NULL,0,0,'','generate',1,NULL),(41,NULL,NULL,0,0,'','generate',1,NULL),(42,NULL,NULL,0,0,'','generate',1,NULL),(43,NULL,NULL,0,0,'','generate',1,NULL),(44,NULL,NULL,0,0,'','generate',1,NULL),(45,NULL,NULL,0,0,'','generate',1,NULL),(46,NULL,NULL,0,0,'','generate',1,NULL),(47,NULL,NULL,0,0,'','generate',1,NULL),(48,NULL,NULL,0,0,'','generate',1,NULL),(49,NULL,NULL,0,0,'','generate',1,NULL),(50,NULL,NULL,0,0,'','generate',1,NULL),(51,NULL,NULL,0,0,'','generate',1,NULL),(52,NULL,NULL,0,0,'','generate',1,NULL),(53,NULL,NULL,0,0,'','generate',1,NULL),(60,NULL,NULL,0,0,'haf year','generate',1,NULL),(61,NULL,NULL,0,0,'haf year','generate',1,NULL),(62,NULL,NULL,0,0,'haf year','generate',1,NULL),(63,NULL,NULL,0,0,'haf year','generate',1,NULL),(64,NULL,NULL,0,0,'haf year','generate',1,NULL),(65,NULL,NULL,0,0,'haf year','generate',1,NULL),(66,NULL,NULL,0,0,'haf year','generate',1,NULL),(67,NULL,NULL,0,0,'haf year','generate',1,NULL),(73,NULL,NULL,0,0,'','generate',1,NULL),(74,NULL,NULL,0,0,'','generate',1,NULL),(75,NULL,NULL,0,0,'','generate',1,NULL),(76,NULL,NULL,0,0,'','generate',1,NULL),(77,NULL,NULL,0,0,'','generate',1,NULL),(78,NULL,NULL,0,0,'','generate',1,NULL),(79,NULL,NULL,0,0,'','generate',1,NULL),(80,NULL,NULL,0,0,'','generate',1,NULL),(81,NULL,NULL,0,0,'','generate',1,NULL),(82,NULL,NULL,0,0,'','generate',1,NULL),(83,NULL,NULL,0,0,'','generate',1,NULL),(84,NULL,NULL,0,0,'','generate',1,NULL),(95,NULL,NULL,0,0,'','generate',1,NULL),(96,NULL,NULL,0,0,'','generate',1,NULL),(97,NULL,NULL,0,0,'','generate',1,NULL),(98,NULL,NULL,0,0,'','generate',1,NULL),(99,NULL,NULL,0,0,'','generate',1,NULL),(100,NULL,NULL,0,0,'','generate',1,NULL),(101,NULL,NULL,0,0,'','generate',1,NULL),(102,NULL,NULL,0,0,'','generate',1,NULL),(103,NULL,NULL,0,0,'','generate',1,NULL),(104,NULL,NULL,0,0,'','generate',1,NULL),(105,NULL,NULL,0,0,'','generate',1,NULL),(106,NULL,NULL,0,0,'','generate',1,NULL),(107,NULL,NULL,0,0,'','generate',1,NULL),(108,NULL,NULL,0,0,'','generate',1,NULL),(109,NULL,NULL,0,0,'','generate',1,NULL),(110,NULL,NULL,0,0,'haf yarly','generate',1,NULL),(111,NULL,NULL,0,0,'','generate',1,NULL),(113,4,NULL,0,0,'','collection',1,NULL),(114,5,NULL,0,0,'','collection',1,NULL),(115,6,NULL,0,0,'','collection',1,NULL),(116,7,NULL,0,0,'','collection',1,NULL),(117,8,NULL,0,0,'','collection',1,NULL),(118,9,NULL,0,0,'','collection',1,NULL),(119,10,NULL,0,0,'','collection',1,NULL),(120,11,NULL,0,0,'','collection',1,NULL),(121,12,NULL,0,0,'','collection',1,NULL),(122,13,NULL,0,0,'','collection',1,NULL),(123,14,NULL,0,0,'','collection',1,NULL),(125,16,NULL,0,0,'','collection',1,NULL),(126,17,NULL,0,0,'','collection',1,NULL),(127,18,NULL,0,0,'','collection',1,NULL),(128,19,NULL,0,0,'','collection',1,NULL),(129,20,NULL,0,0,'','collection',1,NULL),(130,21,NULL,0,0,'','collection',1,NULL),(131,22,NULL,0,0,'','collection',1,NULL),(132,23,NULL,0,0,'','collection',1,NULL),(133,24,NULL,0,0,'','collection',1,NULL),(134,25,NULL,0,0,'','collection',1,NULL),(136,27,NULL,0,0,'','collection',1,NULL),(137,28,NULL,0,0,'','collection',1,NULL),(138,29,NULL,0,0,'','collection',1,NULL),(139,30,NULL,0,0,'','collection',1,NULL),(140,31,NULL,0,0,'','collection',1,NULL),(141,32,NULL,0,0,'','collection',1,NULL),(142,33,NULL,0,0,'','collection',1,NULL),(143,34,NULL,0,0,'','collection',1,NULL),(144,35,NULL,0,0,'','collection',1,NULL),(145,36,NULL,0,0,'','collection',1,NULL),(146,37,NULL,0,0,'','collection',1,NULL),(147,38,NULL,0,0,'','collection',1,NULL),(148,39,NULL,0,0,'','collection',1,NULL),(149,40,NULL,0,0,'','collection',1,NULL),(150,41,NULL,0,0,'','collection',1,NULL),(151,42,NULL,0,0,'','collection',1,NULL),(152,43,NULL,0,0,'','collection',1,NULL),(153,44,NULL,0,0,'','collection',1,NULL),(154,45,NULL,0,0,'','collection',1,NULL),(155,46,NULL,0,0,'','collection',1,NULL),(156,47,NULL,0,0,'','collection',1,NULL),(157,48,NULL,0,0,'','collection',1,NULL),(158,49,NULL,0,0,'','collection',1,NULL),(159,50,NULL,0,0,'','collection',1,NULL),(160,51,NULL,0,0,'','collection',1,NULL),(161,52,NULL,0,0,'','collection',1,NULL),(162,53,NULL,0,0,'','collection',1,NULL),(163,54,NULL,0,0,'','collection',1,NULL),(164,55,NULL,0,0,'','collection',1,NULL),(165,56,NULL,0,0,'','collection',1,NULL),(166,57,NULL,0,0,'','collection',1,NULL),(168,59,NULL,0,0,'','collection',1,NULL),(170,60,NULL,0,0,'','collection',1,NULL),(172,62,NULL,0,0,'','collection',1,NULL),(173,63,NULL,0,0,'','collection',1,NULL),(174,64,NULL,0,0,'','collection',1,NULL),(175,65,NULL,0,0,'','collection',1,NULL),(177,67,NULL,0,0,'','collection',1,NULL),(178,68,NULL,0,0,'','collection',1,NULL),(179,69,NULL,0,0,'','collection',1,NULL),(180,70,NULL,0,0,'','collection',1,NULL),(183,NULL,NULL,0,0,'','generate',1,NULL),(184,NULL,NULL,0,0,'','generate',1,NULL),(185,NULL,NULL,0,0,'','generate',1,NULL),(186,NULL,NULL,0,0,'','generate',1,NULL),(187,NULL,NULL,0,0,'','generate',1,NULL),(188,NULL,NULL,0,0,'','generate',1,NULL),(189,NULL,NULL,0,0,'','generate',1,NULL),(190,NULL,NULL,0,0,'','generate',1,NULL),(191,NULL,NULL,0,0,'','generate',1,NULL),(192,NULL,NULL,0,0,'','generate',1,NULL),(193,NULL,NULL,0,0,'','generate',1,NULL),(195,73,NULL,0,0,'','collection',1,NULL),(196,74,NULL,0,0,'','collection',1,NULL),(197,75,NULL,0,0,'','collection',1,NULL),(198,76,NULL,0,0,'','collection',1,NULL),(199,77,NULL,0,0,'','collection',1,NULL),(200,78,NULL,0,0,'','collection',1,NULL),(203,81,NULL,0,0,'','collection',1,NULL),(206,1,NULL,0,0,NULL,'transfer_in',1,NULL),(207,1,NULL,0,0,NULL,'transfer_out',1,NULL),(208,1,NULL,0,0,NULL,'transfer_in',1,NULL),(209,1,NULL,0,0,NULL,'transfer_out',1,NULL),(210,NULL,NULL,0,0,'','generate',1,NULL),(211,NULL,NULL,0,0,'','generate',1,NULL),(212,NULL,NULL,0,0,'','generate',1,NULL),(213,NULL,NULL,0,0,'','generate',1,NULL),(214,NULL,NULL,0,0,'','generate',1,NULL),(215,NULL,NULL,0,0,'','generate',1,NULL),(216,NULL,NULL,0,0,'','generate',1,NULL),(217,NULL,NULL,0,0,'','generate',1,NULL),(218,NULL,NULL,0,0,'','generate',1,NULL),(219,NULL,NULL,0,0,'','generate',1,NULL),(220,NULL,NULL,0,0,'','generate',1,NULL),(221,82,NULL,0,0,'April 26','collection',1,NULL),(224,84,NULL,0,0,'','collection',1,NULL),(225,NULL,NULL,0,0,'','generate',1,NULL),(226,NULL,NULL,0,0,'','generate',1,NULL),(227,NULL,NULL,0,0,'','generate',1,NULL),(228,NULL,NULL,0,0,'','generate',1,NULL),(229,NULL,NULL,0,0,'','generate',1,NULL),(230,NULL,NULL,0,0,'','generate',1,NULL),(231,NULL,NULL,0,0,'','generate',1,NULL),(232,NULL,NULL,0,0,'','generate',1,NULL),(233,NULL,NULL,0,0,'','generate',1,NULL),(234,NULL,NULL,0,0,'','generate',1,NULL),(235,NULL,NULL,0,0,'','generate',1,NULL),(236,85,NULL,0,0,'','collection',1,NULL),(237,86,NULL,0,0,'','collection',1,NULL),(238,87,NULL,0,0,'','collection',1,NULL),(239,88,NULL,0,0,'','collection',1,NULL),(240,89,NULL,0,0,'','collection',1,NULL),(241,90,NULL,0,0,'','collection',1,NULL),(242,91,NULL,0,0,'','collection',1,NULL),(245,94,NULL,0,0,'','collection',1,NULL),(246,95,NULL,0,0,'','collection',1,NULL),(247,96,NULL,0,0,'','collection',1,NULL),(248,97,NULL,0,0,'','collection',1,NULL),(249,98,NULL,0,0,'','collection',1,NULL),(250,99,NULL,0,0,'','collection',1,NULL),(251,100,NULL,0,0,'','collection',1,NULL),(253,101,NULL,0,0,'May 2026','collection',1,NULL),(254,102,NULL,0,0,'','collection',1,NULL),(255,103,NULL,0,0,'','collection',1,NULL),(256,104,NULL,0,0,'May-2026','collection',1,NULL),(258,106,NULL,0,0,'May-26','collection',1,NULL),(259,107,NULL,0,0,'May-2026','collection',1,NULL),(260,108,NULL,0,0,'may-26','collection',1,NULL),(261,NULL,NULL,0,0,'','generate',1,NULL),(262,NULL,NULL,0,0,'','generate',1,NULL),(263,NULL,NULL,0,0,'','generate',1,NULL),(264,NULL,NULL,0,0,'','generate',1,NULL),(265,NULL,NULL,0,0,'','generate',1,NULL),(266,NULL,NULL,0,0,'','generate',1,NULL),(267,NULL,NULL,0,0,'','generate',1,NULL),(268,NULL,NULL,0,0,'','generate',1,NULL),(269,NULL,NULL,0,0,'','generate',1,NULL),(270,NULL,NULL,0,0,'','generate',1,NULL),(271,NULL,NULL,0,0,'','generate',1,NULL),(272,109,NULL,0,0,'April-26','collection',1,NULL),(273,110,NULL,0,0,'May-26','collection',1,NULL),(274,111,NULL,0,0,'','collection',1,NULL),(275,112,NULL,0,0,'June-26','collection',1,NULL),(276,113,NULL,0,0,'Osifa','collection',1,NULL),(277,114,NULL,0,0,'June 2026','collection',1,NULL),(280,115,NULL,0,0,'June 26','collection',1,NULL),(283,NULL,NULL,0,0,'','generate',1,NULL),(284,NULL,NULL,0,0,'','generate',1,NULL),(285,NULL,NULL,0,0,'','generate',1,NULL),(286,NULL,NULL,0,0,'','generate',1,NULL),(287,NULL,NULL,0,0,'','generate',1,NULL),(288,NULL,NULL,0,0,'','generate',1,NULL),(289,NULL,NULL,0,0,'','generate',1,NULL),(290,NULL,NULL,0,0,'','generate',1,NULL),(291,NULL,NULL,0,0,'','generate',1,NULL),(292,NULL,NULL,0,0,'','generate',1,NULL),(293,NULL,NULL,0,0,'','generate',1,NULL),(294,116,NULL,0,0,'','collection',1,NULL),(295,117,NULL,0,0,'Kings net','collection',1,NULL);
/*!40000 ALTER TABLE `ledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sl` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `name` varchar(100) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `page_title` varchar(300) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `option` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,1,0,'Dashboard','dashboard','','fas fa-th-large','',NULL),(2,2,0,'Investor','investor','Investor List','fas fa-users','','add,edit,delete'),(8,4,0,'Investment','investment','Investor Investment','fas fa-list','','add,delete'),(9,4,0,'Daily Profit','profit_generate','Daily Profit','fa fa-money-bill','','add,edit,delete'),(20,4,0,'Page Management','mng_pages','Page Management','fas fa-list','','add,edit,delete'),(38,20,16,'user','user','user','fas fa-list','',NULL);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-22 15:11:21
