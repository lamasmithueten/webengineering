-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: web_eng
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'werr','$2a$12$Ckrvk2zlVQB8e7vTqDUOieiKrhSHiEOUwAuGw1sGC8Sux7F9ayLCi','moritz.werr@zi-mannheim.de'),(36,'richtep','$2y$10$00okJglPG8CS8KhfAeH30./8s/g/7l3/q1CTmbP5tAcAnQAjH92cq','richter.orga@web.de'),(37,'budzi','$2y$10$9Uk6.Or7mNeUpuiJ0tsR2eyedL3DLD2Ngu1iJXxo6H9hx3s8TB9gG','christoph.budziszewski@zi-mannheim.de'),(39,'UrMom','$2y$10$DwWIhbSlH1nPeJzMKMhUNOrgsEQxMrhCts.BnNlfeZGq0RTdtD/em','lukas.trapp@outlook.de'),(40,'werr2','$2y$10$2W.deYQiQEkPGJtpGFtXuuSWBzgRdk4RRCJIpWKsR5lETisOE.aIW','ticonderoga122@gmail.com'),(41,'test','$2y$10$Gx1RqaYkERyY3hQ.Eut9juzMzubDoWhYrgvLLdGiFOB.XD8L8sCgq','test@gmail.com'),(42,'test2','$2y$10$r9qmVJaeDJvq0LvWsjlaUe4ATUQkQU8yuvRWP6vCn.5seYoP.GuwK','test2@gmail.com'),(43,'test3','$2y$10$GnQXfGRca1GK2DayApbUsOaEQ1U4RVWupUILm0lkAsjzSO5QZJrBG','test3@gmail.com'),(59,'test4','$2y$10$XjImjFS4i3ysAYsKXXHF8.Un8fzkk3YrxI8wZ8zHoaqm91y2laWM2','test4@gmail.com'),(60,'test5','$2y$10$/KoIfWEoT65oEB4p9GOJKudM3JaQpOXTKBUclvT5nest9ZggnhSia','test5@gmail.com');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
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
  `timestamp` datetime DEFAULT NULL,
  `id_account` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_account` (`id_account`),
  KEY `id_thread` (`id_thread`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_thread`) REFERENCES `threads` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (2,20,'lul','2024-05-04 11:25:44',1),(3,21,'lul','2024-05-04 11:42:17',1),(4,20,'lul','2024-05-04 11:42:43',40),(5,21,'xDD','2024-05-04 13:08:00',1),(6,10,'Uhrensohn','2024-05-04 13:08:38',1),(7,21,'Wow so ein schönes Bild das ist ja Unglaublich\\r\\n','2024-05-04 20:00:10',36),(8,21,'Da stimmt noch irgendetwas mit den Kommentaren nicht\\r\\n\\r\\n','2024-05-04 20:00:44',36),(9,21,'test','2024-05-04 20:01:00',36),(10,23,'Wow so ein toller Thread\\r\\njaja \\r\\nwasd','2024-05-04 20:29:02',36),(11,23,'Ihr gönnt mir auch nicht einen einzigen Tag mit euren Absätzen\\r\\nIhr seid ja auch unter Windows weswegen es NICHT nur ein \\\\n ist\\r\\nnein, es muss ja ein \\\\r\\\\n sein.\\r\\nFML Ich hasse mein Leben','2024-05-04 21:54:21',1),(12,23,'ja\\r\\ntut\\r\\nmir\\r\\nleid\\r\\n:(','2024-05-05 11:13:04',36),(13,23,'Test\\r\\nklappt aber trozdem nicht \\r\\n','2024-05-05 12:35:01',36),(14,24,'Cooler Kommentar\\r\\n','2024-05-06 09:17:47',1),(15,23,'Geht\\r\\njetzt\\r\\n!\\r\\nich\\r\\nhasse\\r\\nmein\\r\\nLeben\\r\\n!','2024-05-06 12:12:59',1),(16,25,'Uhrensohn','2024-05-06 12:15:56',1),(17,23,'Boa geil\\r\\ndu bist der beste \\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\nlol','2024-05-06 12:44:51',36),(19,28,'lul','2024-05-06 16:50:43',1),(21,28,'lul','2024-05-06 16:55:29',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset`
--

LOCK TABLES `password_reset` WRITE;
/*!40000 ALTER TABLE `password_reset` DISABLE KEYS */;
INSERT INTO `password_reset` VALUES (16,39,'721349','2024-06-07 15:53:01');
/*!40000 ALTER TABLE `password_reset` ENABLE KEYS */;
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
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_account` (`id_account`),
  CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `threads`
--

LOCK TABLES `threads` WRITE;
/*!40000 ALTER TABLE `threads` DISABLE KEYS */;
INSERT INTO `threads` VALUES (1,'lul',1,'2024-04-25 00:00:00',NULL,'lul'),(2,'xdd',1,'2024-04-25 00:00:00',NULL,'xdd'),(3,'Hallo ich schreibe zum ersten mal was hier LUL',36,'2024-04-25 00:00:00',NULL,'Das ist ein Test'),(4,'shrzwg',1,'2024-04-25 00:00:00',NULL,'rsghdb'),(5,'shrzwg',1,'2024-04-25 00:00:00',NULL,'rsghdb'),(6,'shrzwg',1,'2024-04-25 00:00:00',NULL,'rsghdb'),(7,'hrzwse',1,'2024-04-25 00:00:00',NULL,'hrze'),(8,'dnbsrt',1,'2024-04-25 00:00:00',NULL,'bsrgt'),(9,'sbretg',1,'2024-04-25 16:05:03',NULL,'gertb'),(10,'asdasd',36,'2024-04-26 13:03:38',NULL,'Test'),(11,'Yo mama\\\'s so poor, the ducks throw bread at her.',39,'2024-04-30 13:41:05',NULL,'Yo Mama'),(12,'Ok',36,'2024-04-30 13:41:29',NULL,'Das ist ein Test, wie viel man eigentlich so in einen Titel schreiben kann. Ich wennte, dass es hier ein Zeichenlimit geben wir die Frage ist nur wie Lange ist diese. Also bis jetzt habe ich noch kein Limit erreicht.Langsam glaube ich, dass ich angelogen '),(14,'Das ist das schönste Bild was ich je von mir gemacht habe <3 <3. Bin gespannt was ihr davon haltet!',36,'2024-04-30 13:49:35',NULL,'Das schönste Bild!!!'),(15,'haha',36,'2024-04-30 13:50:05',NULL,'Juhu'),(16,'Wer das liest ist dum hehe lol omegalul xd rofel',36,'2024-04-30 13:52:35',NULL,'Jetzt wirds Flach:'),(17,'few',1,'2024-04-30 13:52:36',NULL,'gtes'),(18,'fdrt',1,'2024-04-30 13:55:49',NULL,'wrfw'),(19,'<3',36,'2024-04-30 13:56:02',NULL,'Cat'),(20,'HELLO',37,'2024-05-02 15:31:18',NULL,'Kein Titel'),(21,'Das ist ein Test mit Bild',1,'2024-05-04 09:25:40','isso.png','Mal gucken, ob es geht'),(22,'lul',1,'2024-05-04 11:20:20',NULL,'lul'),(23,'Was\\r\\n\\r\\npassiert\\r\\n\\r\\nwenn\\r\\n\\r\\nich\\r\\nhier \\r\\n\\r\\nein\\r\\n\\r\\npaar\\r\\n\\r\\nZeilenumbrüche\\r\\n\\r\\nreinmache\\r\\n\\r\\n?',36,'2024-05-04 20:06:54',NULL,'Kurzer test'),(24,'Cooler Text',1,'2024-05-06 09:17:34',NULL,'Cooler Titel'),(25,'we',1,'2024-05-06 12:13:53',NULL,'dew'),(26,'Immer noch Test für gehashte Bilder',1,'2024-05-06 13:07:42','d2b5ca33bd970f64a6301fa75ae2eb22','test für gehashte Bilder'),(27,', Dateigröße und Erstellungsdatum',1,'2024-05-06 13:14:05','b9a7afdaf91d33d380bf9e0c2048e7ff','jetzt gehasht basierend auf Name'),(28,'drittes mal',1,'2024-05-06 13:14:30','c1ac7a2a109e2f16471c67f29f28f95f','und ein'),(29,'meine\\r\\nGüte',1,'2024-05-07 08:01:10','d07560d69062a93dd3a103c835ba5e3d','ach du'),(30,'LUL',1,'2024-05-07 08:04:34',NULL,'Test'),(31,'Xddd',1,'2024-05-07 08:04:50','12705d017d1fd4cf945ee38c30a8f668','xDDD');
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

-- Dump completed on 2024-06-09 13:37:50
