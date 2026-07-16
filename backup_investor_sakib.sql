-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: investor_sakib
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
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','2026-07-16 04:52:35');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_profit`
--

DROP TABLE IF EXISTS `daily_profit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `daily_profit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `investor_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `gross_profit` decimal(12,2) NOT NULL,
  `admin_percent` decimal(5,2) NOT NULL,
  `admin_amount` decimal(12,2) NOT NULL,
  `investor_amount` decimal(12,2) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `investor_id` (`investor_id`),
  CONSTRAINT `daily_profit_ibfk_1` FOREIGN KEY (`investor_id`) REFERENCES `investors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_profit`
--

LOCK TABLES `daily_profit` WRITE;
/*!40000 ALTER TABLE `daily_profit` DISABLE KEYS */;
INSERT INTO `daily_profit` VALUES (1,1,'2026-07-16',5.00,30.00,1.50,3.50,'','2026-07-16 05:00:09'),(2,1,'2026-07-17',2.15,30.00,0.65,1.51,'','2026-07-16 07:35:28'),(3,1,'2026-07-30',2.25,30.00,0.68,1.58,'','2026-07-16 07:35:37');
/*!40000 ALTER TABLE `daily_profit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `investor_ledger`
--

DROP TABLE IF EXISTS `investor_ledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `investor_ledger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `investor_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` enum('deposit','investment_withdraw','profit','profit_withdraw') NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `investor_id` (`investor_id`),
  CONSTRAINT `investor_ledger_ibfk_1` FOREIGN KEY (`investor_id`) REFERENCES `investors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `investor_ledger`
--

LOCK TABLES `investor_ledger` WRITE;
/*!40000 ALTER TABLE `investor_ledger` DISABLE KEYS */;
INSERT INTO `investor_ledger` VALUES (1,1,'2026-07-16','deposit',10000.00,'','2026-07-16 04:57:45'),(2,1,'2026-07-16','profit',3.50,'Daily profit share','2026-07-16 05:00:09'),(3,1,'2026-07-17','profit',1.51,'Daily profit share','2026-07-16 07:35:28'),(4,1,'2026-07-30','profit',1.58,'Daily profit share','2026-07-16 07:35:37'),(5,1,'2026-07-16','investment_withdraw',500.00,'','2026-07-16 07:36:43');
/*!40000 ALTER TABLE `investor_ledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `investors`
--

DROP TABLE IF EXISTS `investors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `investors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT '',
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `profit_percent` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'Admin profit share %',
  `status` int(11) DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `investors`
--

LOCK TABLES `investors` WRITE;
/*!40000 ALTER TABLE `investors` DISABLE KEYS */;
INSERT INTO `investors` VALUES (1,'Md Shariful Islam','0170000','ispmsbd@gmail.com','sharif','$2y$10$IB4lWZWcE8UsLl9f.KxmJeSSX774dAB6BqACxda9aOX3VUyRpNCRe','House # 17/1 B,Babor Road Shyamoli, Mohammadpur Dhaka-1207,Bangladesh',30.00,1,'2026-07-16 04:57:18');
/*!40000 ALTER TABLE `investors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(200) DEFAULT 'Investor Profit Management System',
  `currency` varchar(10) DEFAULT 'USD',
  `logo` varchar(255) DEFAULT '',
  `timezone` varchar(50) DEFAULT 'Asia/Dhaka',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'Investor Profit Management System','USD','','Asia/Dhaka');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-16 18:55:49
