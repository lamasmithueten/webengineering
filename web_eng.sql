-- MariaDB dump 10.19  Distrib 10.11.3-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: web_eng
-- ------------------------------------------------------
-- Server version	10.11.3-MariaDB-1:10.11.3+maria~ubu2204

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
-- Current Database: `web_eng`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `web_eng` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `web_eng`;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES
(1,'werr','$2y$10$22KpNue8pXgb9J8sjS.rIeJz5z//lnZODC2nmAASAOhO3I2WFH.2m','moritz.werr@zi-mannheim.de'),
(36,'richtep','$2y$10$trbHXZMryE8gXQBepnqIEOFA8Nn9rSmRoAOScMdNKGbRaOWkPlC12','richter.orga@web.de'),
(37,'budzi','$2y$10$9Uk6.Or7mNeUpuiJ0tsR2eyedL3DLD2Ngu1iJXxo6H9hx3s8TB9gG','christoph.budziszewski@zi-mannheim.de	'),
(39,'UrMom','$2y$10$xMV9KO7S1OGQkGWtLxGOE.NjhpAPoOMabf1mLSyOdiZ4J0gdBQrMG','lukas.trapp@outlook.de');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment_likes`
--

DROP TABLE IF EXISTS `comment_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment_likes` (
  `id_comment` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  KEY `id_comment` (`id_comment`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `comment_likes_ibfk_1` FOREIGN KEY (`id_comment`) REFERENCES `comments` (`id`),
  CONSTRAINT `comment_likes_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment_likes`
--

LOCK TABLES `comment_likes` WRITE;
/*!40000 ALTER TABLE `comment_likes` DISABLE KEYS */;
INSERT INTO `comment_likes` VALUES
(51,51),
(51,1),
(51,39),
(51,36),
(52,1),
(64,1),
(67,1),
(64,36),
(65,1),
(65,36),
(23,1),
(23,36),
(22,1),
(23,37),
(27,37),
(23,39),
(22,39),
(27,1),
(22,36),
(32,36);
/*!40000 ALTER TABLE `comment_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_thread` int(11) NOT NULL,
  `text` text NOT NULL,
  `timestamp` datetime NOT NULL,
  `id_account` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_account` (`id_account`),
  KEY `id_thread` (`id_thread`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_thread`) REFERENCES `threads` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES
(2,20,'lul','2024-05-04 11:25:44',1),
(3,21,'lul','2024-05-04 11:42:17',1),
(5,21,'xDD','2024-05-04 13:08:00',1),
(6,10,'Uhrensohn','2024-05-04 13:08:38',1),
(7,21,'Wow so ein schönes Bild das ist ja Unglaublich\\r\\n','2024-05-04 20:00:10',36),
(8,21,'Da stimmt noch irgendetwas mit den Kommentaren nicht\\r\\n\\r\\n','2024-05-04 20:00:44',36),
(9,21,'test','2024-05-04 20:01:00',36),
(14,24,'Cooler Kommentar\\r\\n','2024-05-06 09:17:47',1),
(19,28,'lul','2024-05-06 16:50:43',1),
(21,28,'lul','2024-05-06 16:55:29',1),
(22,33,'Nice','2024-06-09 20:30:42',36),
(23,33,'Gleis','2024-06-10 09:56:05',1),
(27,33,'likes','2024-06-11 13:04:18',37),
(32,33,'Funktioniert nicht mehr mach mal heile du bot','2024-06-24 20:08:21',36);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset`
--

DROP TABLE IF EXISTS `password_reset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset`
--

LOCK TABLES `password_reset` WRITE;
/*!40000 ALTER TABLE `password_reset` DISABLE KEYS */;
INSERT INTO `password_reset` VALUES
(25,36,'676605','2024-06-10 09:41:19');
/*!40000 ALTER TABLE `password_reset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thread_likes`
--

DROP TABLE IF EXISTS `thread_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thread_likes` (
  `id_thread` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  KEY `id_thread` (`id_thread`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `thread_likes_ibfk_1` FOREIGN KEY (`id_thread`) REFERENCES `threads` (`id`),
  CONSTRAINT `thread_likes_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thread_likes`
--

LOCK TABLES `thread_likes` WRITE;
/*!40000 ALTER TABLE `thread_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `thread_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `threads`
--

DROP TABLE IF EXISTS `threads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `threads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `id_account` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `picture_path` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_account` (`id_account`),
  CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `threads`
--

LOCK TABLES `threads` WRITE;
/*!40000 ALTER TABLE `threads` DISABLE KEYS */;
INSERT INTO `threads` VALUES
(1,'lul',1,'2024-04-25 00:00:00',NULL,'lul'),
(2,'xdd',1,'2024-04-25 00:00:00',NULL,'xdd'),
(3,'Hallo ich schreibe zum ersten mal was hier LUL',36,'2024-04-25 00:00:00',NULL,'Das ist ein Test'),
(4,'shrzwg',1,'2024-04-25 00:00:00',NULL,'rsghdb'),
(5,'shrzwg',1,'2024-04-25 00:00:00',NULL,'rsghdb'),
(8,'dnbsrt',1,'2024-04-25 00:00:00',NULL,'bsrgt'),
(9,'sbretg',1,'2024-04-25 16:05:03',NULL,'gertb'),
(10,'asdasd',36,'2024-04-26 13:03:38',NULL,'Test'),
(11,'Yo mama\\\'s so poor, the ducks throw bread at her.',39,'2024-04-30 13:41:05',NULL,'Yo Mama'),
(14,'Das ist das schönste Bild was ich je von mir gemacht habe <3 <3. Bin gespannt was ihr davon haltet!',36,'2024-04-30 13:49:35',NULL,'Das schönste Bild!!!'),
(15,'haha',36,'2024-04-30 13:50:05',NULL,'Juhu'),
(17,'few',1,'2024-04-30 13:52:36',NULL,'gtes'),
(19,'<3',36,'2024-04-30 13:56:02',NULL,'Cat'),
(20,'HELLO',37,'2024-05-02 15:31:18',NULL,'Kein Titel'),
(21,'Das ist ein Test mit Bild',1,'2024-05-04 09:25:40','isso.png','Mal gucken, ob es geht'),
(22,'lul',1,'2024-05-04 11:20:20',NULL,'lul'),
(24,'Cooler Text',1,'2024-05-06 09:17:34',NULL,'Cooler Titel'),
(26,'Immer noch Test für gehashte Bilder',1,'2024-05-06 13:07:42','d2b5ca33bd970f64a6301fa75ae2eb22','test für gehashte Bilder'),
(27,', Dateigröße und Erstellungsdatum',1,'2024-05-06 13:14:05','b9a7afdaf91d33d380bf9e0c2048e7ff','jetzt gehasht basierend auf Name'),
(28,'drittes mal',1,'2024-05-06 13:14:30','c1ac7a2a109e2f16471c67f29f28f95f','und ein'),
(29,'meine\\r\\nGüte',1,'2024-05-07 08:01:10','d07560d69062a93dd3a103c835ba5e3d','ach du'),
(33,' ',39,'2024-06-09 15:32:34','1a0854cf42e53218c7af95fe274d280d','Passwort zurücksetzen funktioniert'),
(37,'DON\\\'T ENTER YOUR CREDIT CARD NUMBER TO GET THE FREE TRIAL! HANK!!!!!',1,'2024-06-24 17:43:33','f54b6df23e808c722be84b38eef43fe4','HANK! HANK!');
/*!40000 ALTER TABLE `threads` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-24 20:27:53
