-- MySQL dump 10.13  Distrib 8.0.28, for macos11 (x86_64)
--
-- Host: localhost    Database: ptp_jleague
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `packs_purchases`
--

DROP TABLE IF EXISTS `packs_purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `packs_purchases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pack_id` bigint unsigned NOT NULL,
  `purchase_id` bigint unsigned NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `packs_purchases_ibfk_1` (`pack_id`),
  KEY `packs_purchases_ibfk_2` (`purchase_id`),
  CONSTRAINT `packs_purchases_ibfk_1` FOREIGN KEY (`pack_id`) REFERENCES `packs` (`id`),
  CONSTRAINT `packs_purchases_ibfk_2` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=273 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packs_purchases`
--

LOCK TABLES `packs_purchases` WRITE;
/*!40000 ALTER TABLE `packs_purchases` DISABLE KEYS */;
INSERT INTO `packs_purchases` VALUES (1,191,1,0,'2022-10-14 18:57:46','2022-10-14 18:57:46'),(2,191,2,0,'2022-10-14 19:07:32','2022-10-14 19:07:32'),(3,191,3,0,'2022-10-14 19:12:28','2022-10-14 19:12:28'),(4,191,4,0,'2022-10-14 19:31:29','2022-10-14 19:31:29'),(5,191,5,0,'2022-10-14 19:32:51','2022-10-14 19:32:51'),(6,191,6,0,'2022-10-14 19:33:42','2022-10-14 19:33:42'),(7,189,7,0,'2022-10-14 19:41:19','2022-10-14 19:41:19'),(8,190,8,0,'2022-10-14 19:45:07','2022-10-14 19:45:07'),(9,188,9,0,'2022-10-14 19:50:14','2022-10-14 19:50:14'),(10,191,10,0,'2022-10-14 19:54:37','2022-10-14 19:54:37'),(11,186,11,0,'2022-10-14 19:55:56','2022-10-14 19:55:56'),(12,191,12,0,'2022-10-14 20:14:07','2022-10-14 20:14:07'),(13,191,13,0,'2022-10-14 20:15:11','2022-10-14 20:15:11'),(14,191,14,0,'2022-10-14 20:17:35','2022-10-14 20:17:35'),(15,184,15,0,'2022-10-14 20:18:53','2022-10-14 20:18:53'),(16,190,16,0,'2022-10-14 20:20:56','2022-10-14 20:20:56'),(17,188,17,0,'2022-10-14 20:23:01','2022-10-14 20:23:01'),(18,188,18,0,'2022-10-14 20:27:00','2022-10-14 20:27:00'),(19,185,19,0,'2022-10-14 20:30:19','2022-10-14 20:30:19'),(20,177,20,0,'2022-10-14 20:34:59','2022-10-14 20:34:59'),(21,190,21,0,'2022-10-14 20:36:09','2022-10-14 20:36:09'),(22,181,22,0,'2022-10-14 20:36:11','2022-10-14 20:36:11'),(23,185,23,0,'2022-10-14 20:43:58','2022-10-14 20:43:58'),(24,178,24,0,'2022-10-14 20:49:08','2022-10-14 20:49:08'),(25,186,25,0,'2022-10-14 20:50:35','2022-10-14 20:50:35'),(26,180,26,0,'2022-10-14 20:52:01','2022-10-14 20:52:01'),(27,181,27,0,'2022-10-14 20:52:53','2022-10-14 20:52:53'),(28,191,28,0,'2022-10-14 20:55:48','2022-10-14 20:55:48'),(29,191,29,0,'2022-10-14 21:20:27','2022-10-14 21:20:27'),(30,191,30,0,'2022-10-14 21:21:34','2022-10-14 21:21:34'),(31,191,31,0,'2022-10-14 21:22:12','2022-10-14 21:22:12'),(32,190,32,0,'2022-10-14 21:23:27','2022-10-14 21:23:27'),(33,190,33,0,'2022-10-14 21:24:35','2022-10-14 21:24:35'),(34,190,34,0,'2022-10-14 21:26:09','2022-10-14 21:26:09'),(35,191,35,0,'2022-10-14 21:27:54','2022-10-14 21:27:54'),(36,190,36,0,'2022-10-14 21:28:34','2022-10-14 21:28:34'),(37,188,37,0,'2022-10-14 21:28:55','2022-10-14 21:28:55'),(38,190,38,0,'2022-10-14 21:37:09','2022-10-14 21:37:09'),(39,191,39,0,'2022-10-14 21:47:45','2022-10-14 21:47:45'),(40,189,40,0,'2022-10-14 21:48:18','2022-10-14 21:48:18'),(41,189,41,0,'2022-10-14 21:56:22','2022-10-14 21:56:22'),(42,190,42,0,'2022-10-14 21:59:02','2022-10-14 21:59:02'),(43,190,43,0,'2022-10-14 22:04:11','2022-10-14 22:04:11'),(44,191,44,0,'2022-10-14 22:31:42','2022-10-14 22:31:42'),(45,184,45,0,'2022-10-14 22:46:29','2022-10-14 22:46:29'),(46,188,46,0,'2022-10-14 22:47:24','2022-10-14 22:47:24'),(47,185,47,0,'2022-10-14 22:48:07','2022-10-14 22:48:07'),(48,185,48,0,'2022-10-14 22:49:44','2022-10-14 22:49:44'),(49,185,49,0,'2022-10-14 22:52:39','2022-10-14 22:52:39'),(50,185,50,0,'2022-10-14 22:53:20','2022-10-14 22:53:20'),(51,180,51,0,'2022-10-14 22:54:09','2022-10-14 22:54:09'),(52,178,52,0,'2022-10-14 22:55:01','2022-10-14 22:55:01'),(53,176,53,0,'2022-10-14 22:57:17','2022-10-14 22:57:17'),(54,185,54,0,'2022-10-14 23:01:31','2022-10-14 23:01:31'),(55,190,55,0,'2022-10-14 23:04:02','2022-10-14 23:04:02'),(56,177,56,0,'2022-10-14 23:15:25','2022-10-14 23:15:25'),(57,184,57,0,'2022-10-14 23:17:09','2022-10-14 23:17:09'),(58,189,58,0,'2022-10-14 23:19:45','2022-10-14 23:19:45'),(59,188,59,0,'2022-10-15 01:08:41','2022-10-15 01:08:41'),(60,188,60,0,'2022-10-15 01:09:52','2022-10-15 01:09:52'),(61,178,61,0,'2022-10-15 01:10:49','2022-10-15 01:10:49'),(62,188,62,0,'2022-10-15 01:11:41','2022-10-15 01:11:41'),(63,193,63,0,'2022-10-15 01:38:47','2022-10-15 01:38:47'),(64,185,64,0,'2022-10-15 02:09:43','2022-10-15 02:09:43'),(65,190,65,0,'2022-10-15 09:37:24','2022-10-15 09:37:24'),(66,189,66,0,'2022-10-15 09:39:58','2022-10-15 09:39:58'),(67,182,67,0,'2022-10-15 09:56:08','2022-10-15 09:56:08'),(68,193,68,0,'2022-10-15 10:00:59','2022-10-15 10:00:59'),(69,190,69,0,'2022-10-15 10:02:28','2022-10-15 10:02:28'),(70,193,70,0,'2022-10-15 10:04:00','2022-10-15 10:04:00'),(71,189,71,0,'2022-10-15 10:06:01','2022-10-15 10:06:01'),(72,190,72,0,'2022-10-15 10:13:48','2022-10-15 10:13:48'),(73,188,73,0,'2022-10-15 11:19:30','2022-10-15 11:19:30'),(74,188,74,0,'2022-10-15 11:20:31','2022-10-15 11:20:31'),(75,185,75,0,'2022-10-15 11:24:07','2022-10-15 11:24:07'),(76,193,76,0,'2022-10-15 11:25:26','2022-10-15 11:25:26'),(77,190,77,0,'2022-10-15 11:28:24','2022-10-15 11:28:24'),(78,190,78,0,'2022-10-15 11:30:17','2022-10-15 11:30:17'),(79,190,79,0,'2022-10-15 11:32:26','2022-10-15 11:32:26'),(80,176,80,0,'2022-10-15 11:57:04','2022-10-15 11:57:04'),(81,190,81,0,'2022-10-15 11:57:42','2022-10-15 11:57:42'),(82,177,82,0,'2022-10-15 11:58:50','2022-10-15 11:58:50'),(83,177,83,0,'2022-10-15 11:59:58','2022-10-15 11:59:58'),(84,181,84,0,'2022-10-15 12:02:34','2022-10-15 12:02:34'),(85,193,85,0,'2022-10-15 12:03:04','2022-10-15 12:03:04'),(86,181,86,0,'2022-10-15 12:03:28','2022-10-15 12:03:28'),(87,193,87,0,'2022-10-15 12:04:45','2022-10-15 12:04:45'),(88,184,88,0,'2022-10-15 12:05:54','2022-10-15 12:05:54'),(89,188,89,0,'2022-10-15 12:06:37','2022-10-15 12:06:37'),(90,180,90,0,'2022-10-15 12:07:21','2022-10-15 12:07:21'),(91,190,91,0,'2022-10-15 12:09:58','2022-10-15 12:09:58'),(92,190,92,0,'2022-10-15 12:10:29','2022-10-15 12:10:29'),(93,190,93,0,'2022-10-15 12:21:26','2022-10-15 12:21:26'),(94,190,94,0,'2022-10-15 12:22:02','2022-10-15 12:22:02'),(95,193,95,0,'2022-10-15 12:22:44','2022-10-15 12:22:44'),(96,190,96,0,'2022-10-15 12:23:05','2022-10-15 12:23:05'),(97,189,97,0,'2022-10-15 12:23:42','2022-10-15 12:23:42'),(98,188,98,0,'2022-10-15 12:24:18','2022-10-15 12:24:18'),(99,190,99,0,'2022-10-15 12:32:42','2022-10-15 12:32:42'),(100,189,100,0,'2022-10-15 12:35:15','2022-10-15 12:35:15'),(101,188,101,0,'2022-10-15 12:35:18','2022-10-15 12:35:18'),(102,190,102,0,'2022-10-15 12:40:11','2022-10-15 12:40:11'),(103,193,103,0,'2022-10-15 12:45:57','2022-10-15 12:45:57'),(104,188,104,0,'2022-10-15 12:47:32','2022-10-15 12:47:32'),(105,182,105,0,'2022-10-15 12:48:48','2022-10-15 12:48:48'),(106,182,106,0,'2022-10-15 12:49:39','2022-10-15 12:49:39'),(107,190,107,0,'2022-10-15 12:50:25','2022-10-15 12:50:25'),(108,188,108,0,'2022-10-15 12:50:50','2022-10-15 12:50:50'),(109,193,109,0,'2022-10-15 12:50:54','2022-10-15 12:50:54'),(110,176,110,0,'2022-10-15 12:51:15','2022-10-15 12:51:15'),(111,193,111,0,'2022-10-15 12:51:29','2022-10-15 12:51:29'),(112,188,112,0,'2022-10-15 12:51:42','2022-10-15 12:51:42'),(113,181,113,0,'2022-10-15 12:52:26','2022-10-15 12:52:26'),(114,190,114,0,'2022-10-15 12:53:16','2022-10-15 12:53:16'),(115,193,115,0,'2022-10-15 12:53:33','2022-10-15 12:53:33'),(116,189,116,0,'2022-10-15 12:53:46','2022-10-15 12:53:46'),(117,188,117,0,'2022-10-15 12:54:53','2022-10-15 12:54:53'),(118,189,118,0,'2022-10-15 12:55:32','2022-10-15 12:55:32'),(119,186,119,0,'2022-10-15 12:55:47','2022-10-15 12:55:47'),(120,188,120,0,'2022-10-15 12:56:03','2022-10-15 12:56:03'),(121,193,121,0,'2022-10-15 12:56:06','2022-10-15 12:56:06'),(122,185,122,0,'2022-10-15 12:57:07','2022-10-15 12:57:07'),(123,188,123,0,'2022-10-15 12:57:14','2022-10-15 12:57:14'),(124,189,124,0,'2022-10-15 12:57:41','2022-10-15 12:57:41'),(125,189,125,0,'2022-10-15 12:58:18','2022-10-15 12:58:18'),(126,186,126,0,'2022-10-15 12:59:09','2022-10-15 12:59:09'),(127,180,127,0,'2022-10-15 12:59:29','2022-10-15 12:59:29'),(128,182,128,0,'2022-10-15 12:59:52','2022-10-15 12:59:52'),(129,185,129,0,'2022-10-15 13:00:34','2022-10-15 13:00:34'),(130,182,130,0,'2022-10-15 13:01:15','2022-10-15 13:01:15'),(131,185,131,0,'2022-10-15 13:01:35','2022-10-15 13:01:35'),(132,177,132,0,'2022-10-15 13:01:46','2022-10-15 13:01:46'),(133,189,133,0,'2022-10-15 13:02:37','2022-10-15 13:02:37'),(134,193,134,0,'2022-10-15 13:02:43','2022-10-15 13:02:43'),(135,189,135,0,'2022-10-15 13:03:27','2022-10-15 13:03:27'),(136,176,136,0,'2022-10-15 13:03:52','2022-10-15 13:03:52'),(137,185,137,0,'2022-10-15 13:04:51','2022-10-15 13:04:51'),(138,176,138,0,'2022-10-15 13:05:43','2022-10-15 13:05:43'),(139,181,139,0,'2022-10-15 13:26:10','2022-10-15 13:26:10'),(140,193,140,0,'2022-10-15 13:39:15','2022-10-15 13:39:15'),(141,186,141,0,'2022-10-15 13:45:08','2022-10-15 13:45:08'),(142,176,142,0,'2022-10-15 14:00:55','2022-10-15 14:00:55'),(143,176,143,0,'2022-10-15 14:03:12','2022-10-15 14:03:12'),(144,176,144,0,'2022-10-15 14:04:08','2022-10-15 14:04:08'),(145,177,145,0,'2022-10-15 14:06:18','2022-10-15 14:06:18'),(146,189,146,0,'2022-10-15 14:10:28','2022-10-15 14:10:28'),(147,189,147,0,'2022-10-15 14:10:58','2022-10-15 14:10:58'),(148,189,148,0,'2022-10-15 14:11:23','2022-10-15 14:11:23'),(149,189,149,0,'2022-10-15 14:12:30','2022-10-15 14:12:30'),(150,193,150,0,'2022-10-15 14:14:10','2022-10-15 14:14:10'),(151,185,151,0,'2022-10-15 14:24:17','2022-10-15 14:24:17'),(152,177,152,0,'2022-10-15 14:25:27','2022-10-15 14:25:27'),(153,189,153,0,'2022-10-15 14:26:13','2022-10-15 14:26:13'),(154,189,154,0,'2022-10-15 14:58:28','2022-10-15 14:58:28'),(155,182,155,0,'2022-10-15 15:02:03','2022-10-15 15:02:03'),(156,185,156,0,'2022-10-15 15:06:53','2022-10-15 15:06:53'),(157,180,158,0,'2022-10-15 15:41:12','2022-10-15 15:41:12'),(158,193,159,0,'2022-10-15 15:41:53','2022-10-15 15:41:53'),(159,176,160,0,'2022-10-15 15:43:00','2022-10-15 15:43:00'),(160,182,161,0,'2022-10-15 15:44:03','2022-10-15 15:44:03'),(161,186,162,0,'2022-10-15 15:50:44','2022-10-15 15:50:44'),(162,186,163,0,'2022-10-15 16:28:13','2022-10-15 16:28:13'),(163,177,164,0,'2022-10-15 16:29:15','2022-10-15 16:29:15'),(164,176,165,0,'2022-10-15 16:50:54','2022-10-15 16:50:54'),(165,193,166,0,'2022-10-15 16:54:14','2022-10-15 16:54:14'),(166,177,167,0,'2022-10-15 16:55:41','2022-10-15 16:55:41'),(167,193,168,0,'2022-10-15 17:53:59','2022-10-15 17:53:59'),(168,189,169,0,'2022-10-15 17:55:00','2022-10-15 17:55:00'),(169,185,170,0,'2022-10-15 17:55:46','2022-10-15 17:55:46'),(170,193,171,0,'2022-10-15 18:16:37','2022-10-15 18:16:37'),(171,186,172,0,'2022-10-15 18:23:41','2022-10-15 18:23:41'),(172,193,173,0,'2022-10-15 18:36:22','2022-10-15 18:36:22'),(173,189,174,0,'2022-10-15 18:38:54','2022-10-15 18:38:54'),(174,185,175,0,'2022-10-15 18:42:33','2022-10-15 18:42:33'),(175,193,176,0,'2022-10-15 19:00:39','2022-10-15 19:00:39'),(176,189,177,0,'2022-10-15 20:57:05','2022-10-15 20:57:05'),(177,185,178,0,'2022-10-15 20:58:00','2022-10-15 20:58:00'),(178,176,182,0,'2022-10-15 21:42:52','2022-10-15 21:42:52'),(179,177,186,0,'2022-10-15 21:46:00','2022-10-15 21:46:00'),(180,178,190,0,'2022-10-15 21:48:28','2022-10-15 21:48:28'),(181,178,191,0,'2022-10-15 21:54:57','2022-10-15 21:54:57'),(182,180,192,0,'2022-10-15 21:56:02','2022-10-15 21:56:02'),(183,181,196,0,'2022-10-15 21:59:04','2022-10-15 21:59:04'),(184,193,197,0,'2022-10-15 22:04:13','2022-10-15 22:04:13'),(185,182,198,0,'2022-10-15 22:05:09','2022-10-15 22:05:09'),(186,193,203,0,'2022-10-15 23:29:02','2022-10-15 23:29:02'),(187,193,208,0,'2022-10-15 23:33:28','2022-10-15 23:33:28'),(188,193,209,0,'2022-10-15 23:34:03','2022-10-15 23:34:03'),(189,176,210,0,'2022-10-15 23:36:26','2022-10-15 23:36:26'),(190,186,212,0,'2022-10-15 23:46:08','2022-10-15 23:46:08'),(191,193,213,0,'2022-10-15 23:46:40','2022-10-15 23:46:40'),(192,189,214,0,'2022-10-16 00:00:02','2022-10-16 00:00:02'),(193,193,215,0,'2022-10-16 00:03:27','2022-10-16 00:03:27'),(194,193,216,0,'2022-10-16 00:07:10','2022-10-16 00:07:10'),(195,193,217,0,'2022-10-16 00:10:08','2022-10-16 00:10:08'),(196,193,218,0,'2022-10-16 00:10:53','2022-10-16 00:10:53'),(197,193,219,0,'2022-10-16 00:11:40','2022-10-16 00:11:40'),(198,193,220,0,'2022-10-16 00:13:26','2022-10-16 00:13:26'),(199,193,221,0,'2022-10-16 00:15:08','2022-10-16 00:15:08'),(200,193,222,0,'2022-10-16 00:15:34','2022-10-16 00:15:34'),(201,193,223,0,'2022-10-16 00:16:03','2022-10-16 00:16:03'),(202,193,224,0,'2022-10-16 00:16:15','2022-10-16 00:16:15'),(203,193,225,0,'2022-10-16 00:17:53','2022-10-16 00:17:53'),(204,193,226,0,'2022-10-16 00:18:56','2022-10-16 00:18:56'),(205,193,227,0,'2022-10-16 00:19:22','2022-10-16 00:19:22'),(206,193,228,0,'2022-10-16 00:20:43','2022-10-16 00:20:43'),(207,193,229,0,'2022-10-16 00:20:57','2022-10-16 00:20:57'),(208,193,230,0,'2022-10-16 00:21:22','2022-10-16 00:21:22'),(209,193,231,0,'2022-10-16 00:26:07','2022-10-16 00:26:07'),(210,193,232,0,'2022-10-16 00:27:27','2022-10-16 00:27:27'),(211,193,233,0,'2022-10-16 00:27:52','2022-10-16 00:27:52'),(212,193,234,0,'2022-10-16 00:28:20','2022-10-16 00:28:20'),(213,193,235,0,'2022-10-16 00:29:52','2022-10-16 00:29:52'),(214,193,237,0,'2022-10-16 10:13:22','2022-10-16 10:13:22'),(215,193,239,0,'2022-10-16 11:08:36','2022-10-16 11:08:36'),(216,184,244,0,'2022-10-16 11:22:14','2022-10-16 11:22:14'),(217,193,246,0,'2022-10-16 11:23:36','2022-10-16 11:23:36'),(218,177,247,0,'2022-10-16 11:25:04','2022-10-16 11:25:04'),(219,177,248,0,'2022-10-16 11:25:47','2022-10-16 11:25:47'),(220,193,249,0,'2022-10-16 11:26:22','2022-10-16 11:26:22'),(221,186,250,0,'2022-10-16 11:28:17','2022-10-16 11:28:17'),(222,193,251,0,'2022-10-16 11:28:23','2022-10-16 11:28:23'),(223,189,252,0,'2022-10-16 11:28:40','2022-10-16 11:28:40'),(224,193,253,0,'2022-10-16 11:28:41','2022-10-16 11:28:41'),(225,193,254,0,'2022-10-16 11:28:54','2022-10-16 11:28:54'),(226,178,255,0,'2022-10-16 11:32:37','2022-10-16 11:32:37'),(227,193,256,0,'2022-10-16 11:33:24','2022-10-16 11:33:24'),(228,193,257,0,'2022-10-16 11:33:56','2022-10-16 11:33:56'),(229,193,258,0,'2022-10-16 11:34:25','2022-10-16 11:34:25'),(230,184,259,0,'2022-10-16 11:41:34','2022-10-16 11:41:34'),(231,193,266,0,'2022-10-16 12:16:54','2022-10-16 12:16:54'),(232,182,269,0,'2022-10-16 12:28:25','2022-10-16 12:28:25'),(233,178,270,0,'2022-10-16 12:35:33','2022-10-16 12:35:33'),(234,184,273,0,'2022-10-16 12:44:22','2022-10-16 12:44:22'),(235,184,275,0,'2022-10-16 12:46:19','2022-10-16 12:46:19'),(236,177,284,0,'2022-10-16 13:37:10','2022-10-16 13:37:10'),(237,193,285,0,'2022-10-16 14:16:13','2022-10-16 14:16:13'),(238,177,286,0,'2022-10-16 14:45:41','2022-10-16 14:45:41'),(239,180,287,0,'2022-10-16 14:46:11','2022-10-16 14:46:11'),(240,181,291,0,'2022-10-16 14:48:20','2022-10-16 14:48:20'),(241,193,298,0,'2022-10-16 15:02:10','2022-10-16 15:02:10'),(242,193,299,0,'2022-10-16 15:22:53','2022-10-16 15:22:53'),(243,178,300,0,'2022-10-16 15:23:36','2022-10-16 15:23:36'),(244,189,302,0,'2022-10-16 16:14:37','2022-10-16 16:14:37'),(245,186,303,0,'2022-10-16 16:29:51','2022-10-16 16:29:51'),(246,189,305,0,'2022-10-16 17:15:37','2022-10-16 17:15:37'),(247,189,306,0,'2022-10-16 17:15:54','2022-10-16 17:15:54'),(248,176,308,0,'2022-10-16 18:04:49','2022-10-16 18:04:49'),(249,184,309,0,'2022-10-16 18:05:29','2022-10-16 18:05:29'),(250,176,311,0,'2022-10-16 18:07:07','2022-10-16 18:07:07'),(251,176,313,0,'2022-10-16 18:07:37','2022-10-16 18:07:37'),(252,178,327,0,'2022-10-16 18:27:10','2022-10-16 18:27:10'),(253,180,331,0,'2022-10-16 18:32:48','2022-10-16 18:32:48'),(254,184,337,0,'2022-10-16 18:41:17','2022-10-16 18:41:17'),(255,176,338,0,'2022-10-16 18:41:53','2022-10-16 18:41:53'),(256,176,343,0,'2022-10-16 18:50:31','2022-10-16 18:50:31'),(257,176,352,0,'2022-10-16 19:41:31','2022-10-16 19:41:31'),(258,176,359,0,'2022-10-16 20:13:29','2022-10-16 20:13:29'),(259,176,363,0,'2022-10-16 20:28:02','2022-10-16 20:28:02'),(260,178,364,0,'2022-10-16 20:29:56','2022-10-16 20:29:56'),(261,178,368,0,'2022-10-16 20:33:13','2022-10-16 20:33:13'),(262,184,369,0,'2022-10-16 20:34:33','2022-10-16 20:34:33'),(263,180,370,0,'2022-10-16 20:35:29','2022-10-16 20:35:29'),(264,180,372,0,'2022-10-16 20:36:47','2022-10-16 20:36:47'),(265,174,373,0,'2022-10-16 20:38:42','2022-10-16 20:38:42'),(266,174,374,0,'2022-10-16 20:38:54','2022-10-16 20:38:54'),(267,193,377,0,'2022-10-16 21:20:16','2022-10-16 21:20:16'),(268,174,383,0,'2022-10-16 21:47:50','2022-10-16 21:47:50'),(269,189,395,0,'2022-10-18 21:12:09','2022-10-18 21:12:09'),(270,193,396,0,'2022-10-20 13:32:46','2022-10-20 13:32:46'),(271,186,398,0,'2022-10-21 15:07:12','2022-10-21 15:07:12'),(272,181,399,0,'2022-10-21 15:08:17','2022-10-21 15:08:17');
/*!40000 ALTER TABLE `packs_purchases` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-28 18:37:54