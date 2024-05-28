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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES
(1,'werr','$2a$12$Ckrvk2zlVQB8e7vTqDUOieiKrhSHiEOUwAuGw1sGC8Sux7F9ayLCi','moritz.werr@zi-mannheim.de'),
(36,'richtep','$2y$10$00okJglPG8CS8KhfAeH30./8s/g/7l3/q1CTmbP5tAcAnQAjH92cq','richter.orga@web.de'),
(37,'budzi','$2y$10$9Uk6.Or7mNeUpuiJ0tsR2eyedL3DLD2Ngu1iJXxo6H9hx3s8TB9gG','christoph.budziszewski@zi-mannheim.de'),
(39,'UrMom','$2y$10$zeAcSs8SNObBV48MA3/4hOHq3kOBMXlUtJqVAu0Uk7x5DTfrR04Cy','lukas.trapp@outlook.de'),
(41,'ponkx','$2y$10$xpWMy/e9129eIcX7TGcFreA4LKqvTga9i0BTthr56KhN2lG6PV6oe','julivnagel@gmail.com'),
(42,'admin','$2y$10$vKU18itknq4L448k3tGUv.QI4rkT0CQzr1Zv3v1S762n5Fc8P/jXK','admin@adminrechte.de'),
(45,'urMom2','$2y$10$4PrYagnaon9qI1qVBF65h.Fhyfj4tYn5TIWTlXNfkzGGPhAfrHf/.','urMom2@gmail.com'),
(46,'test3','$2y$10$b.qpbi0PzVK7VqzQCuEZ3uXc3Fk.RFiVTvRqyNyFDuD993deqnAy.','test3@gmail.com'),
(47,'test4','$2y$10$qPWe74deGcgotp9e.H5UUOH8Q9T7GZgna.L8MvTC7hNbWTZOESY1O','test4@gmail.com'),
(48,'test5','$2y$10$N9A/6EcMsykxIrwXcsXXSuCV4NVOycTTWlccVG2IpgU6SzHZsfJf6','test5@gmail.com'),
(51,'werr3','$2y$10$epVvAZOkZR5mlUg.IbjrM.idXOiYmAUUpnza6iDLwFKUS9EwGzKRe','ticonderoga122@gmail.com'),
(52,'test99','$2y$10$I0Ob7Jkq/.COhb8.EmESSeJ3ZGatLaD6hIUPSBYwU4vTVZ1s3hYj6','test99@gmail.com'),
(53,'werr4','$2y$10$OuZL/TSRIHF3qv5JOe8v1O.ZUgoZqVf.ahEXnA2d3WMk/Tv60Uclm','moritz@wuenet.de'),
(54,'dennislauer','$2y$10$MbKRsyiyH6mKh4xTtxdQG.fPrJf0S1lV1NO58cpnYg4RMXv59IwR.','dennislauer82@yahoo.de');
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
(52,1);
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
  `timestamp` datetime DEFAULT NULL,
  `id_account` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_account` (`id_account`),
  KEY `id_thread` (`id_thread`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_thread`) REFERENCES `threads` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
(10,23,'Wow so ein toller Thread\\r\\njaja \\r\\nwasd','2024-05-04 20:29:02',36),
(11,23,'Ihr gönnt mir auch nicht einen einzigen Tag mit euren Absätzen\\r\\nIhr seid ja auch unter Windows weswegen es NICHT nur ein \\\\n ist\\r\\nnein, es muss ja ein \\\\r\\\\n sein.\\r\\nFML Ich hasse mein Leben','2024-05-04 21:54:21',1),
(12,23,'ja\\r\\ntut\\r\\nmir\\r\\nleid\\r\\n:(','2024-05-05 11:13:04',36),
(13,23,'Test\\r\\nklappt aber trozdem nicht \\r\\n','2024-05-05 12:35:01',36),
(14,24,'Cooler Kommentar\\r\\n','2024-05-06 09:17:47',1),
(15,23,'Geht\\r\\njetzt\\r\\n!\\r\\nich\\r\\nhasse\\r\\nmein\\r\\nLeben\\r\\n!','2024-05-06 12:12:59',1),
(17,23,'Boa geil\\r\\ndu bist der beste \\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\nlol','2024-05-06 12:44:51',36),
(19,28,'lul','2024-05-06 16:50:43',1),
(21,28,'lul','2024-05-06 16:55:29',1),
(23,42,'lol','2024-05-08 09:12:01',42),
(24,42,'lol','2024-05-08 09:12:14',42),
(25,41,'test','2024-05-08 11:38:21',1),
(26,46,'Er ist in der Tat wunderschön','2024-05-08 12:50:54',1),
(27,32,'Wow','2024-05-09 11:16:21',36),
(37,45,'lul','2024-05-10 17:02:36',1),
(45,52,'Ja sieht soweit gut aus','2024-05-14 19:40:11',36),
(46,12,'test\\r\\n','2024-05-15 18:28:36',36),
(47,55,'Immerhin passt Designtechnisch alles ','2024-05-15 22:44:38',36),
(48,55,'Timestamp test\\r\\n','2024-05-16 06:22:40',36),
(49,55,'lul','2024-05-16 06:24:12',1),
(50,55,'Test','2024-05-16 06:30:01',36),
(51,56,'UrMom','2024-05-16 06:31:30',36),
(52,57,'Ja genau, dachte ist halt nicht so schön, wenn man auf den Zurückbutton des Browser drücken muss, wenn man doch keinen Thread erstellen möchte.','2024-05-19 19:47:30',36),
(53,58,'Also das war auf meiner Prioriätenliste ganz weit unten.','2024-05-20 17:03:40',1),
(55,56,'lol','2024-05-21 08:05:57',36),
(56,58,'Der Mond und die Sonne sind toll\\r\\n','2024-05-22 15:00:50',39),
(57,58,'Dankeschön <3\\r\\n','2024-05-23 12:28:25',36);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
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
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_account` (`id_account`),
  CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `threads`
--

LOCK TABLES `threads` WRITE;
/*!40000 ALTER TABLE `threads` DISABLE KEYS */;
INSERT INTO `threads` VALUES
(1,'lul',1,'2024-04-25 00:00:00',NULL,'lul'),
(3,'Hallo ich schreibe zum ersten mal was hier LUL',36,'2024-04-25 00:00:00',NULL,'Das ist ein Test'),
(10,'asdasd',36,'2024-04-26 13:03:38',NULL,'Test'),
(11,'Yo mama\\\'s so poor, the ducks throw bread at her.',39,'2024-04-30 13:41:05',NULL,'Yo Mama'),
(12,'Ok',36,'2024-04-30 13:41:29',NULL,'Das ist ein Test, wie viel man eigentlich so in einen Titel schreiben kann. Ich wennte, dass es hier ein Zeichenlimit geben wir die Frage ist nur wie Lange ist diese. Also bis jetzt habe ich noch kein Limit erreicht.Langsam glaube ich, dass ich angelogen '),
(14,'Das ist das schönste Bild was ich je von mir gemacht habe <3 <3. Bin gespannt was ihr davon haltet!',36,'2024-04-30 13:49:35',NULL,'Das schönste Bild!!!'),
(15,'haha',36,'2024-04-30 13:50:05',NULL,'Juhu'),
(16,'Wer das liest ist dum hehe lol omegalul xd rofel',36,'2024-04-30 13:52:35',NULL,'Jetzt wirds Flach:'),
(19,'<3',36,'2024-04-30 13:56:02',NULL,'Cat'),
(20,'HELLO',37,'2024-05-02 15:31:18',NULL,'Kein Titel'),
(21,'Das ist ein Test mit Bild',1,'2024-05-04 09:25:40','isso.png','Mal gucken, ob es geht'),
(23,'Was\\r\\n\\r\\npassiert\\r\\n\\r\\nwenn\\r\\n\\r\\nich\\r\\nhier \\r\\n\\r\\nein\\r\\n\\r\\npaar\\r\\n\\r\\nZeilenumbrüche\\r\\n\\r\\nreinmache\\r\\n\\r\\n?',36,'2024-05-04 20:06:54',NULL,'Kurzer test'),
(24,'Cooler Text',1,'2024-05-06 09:17:34',NULL,'Cooler Titel'),
(26,'Immer noch Test für gehashte Bilder',1,'2024-05-06 13:07:42','d2b5ca33bd970f64a6301fa75ae2eb22','test für gehashte Bilder'),
(27,', Dateigröße und Erstellungsdatum',1,'2024-05-06 13:14:05','b9a7afdaf91d33d380bf9e0c2048e7ff','jetzt gehasht basierend auf Name'),
(28,'drittes mal',1,'2024-05-06 13:14:30','c1ac7a2a109e2f16471c67f29f28f95f','und ein'),
(29,'meine\\r\\nGüte',1,'2024-05-07 08:01:10','d07560d69062a93dd3a103c835ba5e3d','ach du'),
(32,'Was wäre eigentlich, wenn ...\\r\\nhttps://xkcd.com/327/',41,'2024-05-07 19:06:39','5a5f923f31956268aa622fdd670ebf25','Exploits of a Mom'),
(33,'Gibt',41,'2024-05-07 19:17:22',NULL,'es'),
(34,'eigentlich',41,'2024-05-07 19:17:31',NULL,'irgendwann'),
(35,'einen',41,'2024-05-07 19:17:40',NULL,'Seitenumbruch'),
(36,'oder',41,'2024-05-07 19:17:49',NULL,'werden'),
(37,'einfach',41,'2024-05-07 19:18:01',NULL,'unendlich'),
(38,'viele',41,'2024-05-07 19:18:08',NULL,'Threads'),
(39,'angezeigt',41,'2024-05-07 19:18:16',NULL,'?'),
(40,'Gibt es nicht',1,'2024-05-07 19:18:22',NULL,'Nein'),
(41,'einfach ewig angezeigt.',1,'2024-05-07 19:20:10',NULL,'Die werden bisher'),
(42,'Hallo dies ist ein DUmmy Thread.',42,'2024-05-08 09:11:36',NULL,'DUmmy Thread'),
(43,'lul',1,'2024-05-08 12:35:52',NULL,'lul'),
(45,'erster Versuch',1,'2024-05-08 12:49:44',NULL,'auf ein neues'),
(46,'Ist das nicht ein schöner Arbeiter',1,'2024-05-08 12:50:40','f503d855b56815fd38107bdd758bc759','Jetzt mit Bild '),
(52,'Ich bin aber ein Profi, sollte also alles weiterhin funktionieren',1,'2024-05-14 19:38:13',NULL,'Hoffentlich geht noch alles, nachdem ich Links geändert habe'),
(55,'Ich habe die letzten 1,5h bestimmt nicht damit verbraucht ein Logout zu programmieren. Ich bin daran bestimmt auch nicht kläglich gescheitert und habe ums verecken meinen Fehler nicht gefunden. Nene bestimmt nicht, dass denke ich mir gerade alles aus. Ich habe auch nicht alles bezüglich des Logout gelöscht und rückgägngig gemacht weil das DRECKS TEIL NICHT FUNTKIONIERT HABE OBWOHL ICH DEN CODE DOCH EINS ZU EINS VON STACK OVERFLOW KOPIERT HABE, DER CODE KANN DOCH EIGENTLICH NUR FUNKTIONIEREN. Selst ChatGPT hat gesagt das der richtig sei. Zum Glück ist das alles nicht passiet. Naja egal gehe jetzt schlafen gn.',36,'2024-05-15 22:43:26','35d96aac1e8c7cf87acea3157ceed8c8','Test ob alles noch geht und so'),
(56,'ITS ME',39,'2024-05-16 06:30:40','081010ff4faa62d430b3f46ef81b802a','Hello, its me'),
(57,'Ich meine was sollte er sonst machen?',1,'2024-05-19 15:42:55','acdd2efd7b7c87ea7f7b5b9d7028e881','Der Cancelknopf ist doch nur ein Link zurück auf die Mainpage, oder?'),
(58,'Schön wenn alles Funktioniert und jetzt haben wir auch endlich das wichtigste Feature überhaupt, jajaja',36,'2024-05-19 21:28:31',NULL,'Es ist doch Toll');
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

-- Dump completed on 2024-05-28 13:32:49
