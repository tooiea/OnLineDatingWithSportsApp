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
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `purchase_detail_id` bigint unsigned NOT NULL,
  `payment_method_mst_id` bigint unsigned NOT NULL,
  `purchase_status_type_mst_id` bigint unsigned NOT NULL,
  `amount` int NOT NULL,
  `purchase_type_mst_id` bigint unsigned NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchases_uq_1` (`purchase_detail_id`,`payment_method_mst_id`),
  KEY `purchases_ibfk_1` (`user_id`),
  KEY `purchases_ibfk_2` (`payment_method_mst_id`),
  KEY `purchases_ibfk_3` (`purchase_status_type_mst_id`),
  KEY `purchases_ibfk_4` (`purchase_type_mst_id`),
  CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ptp`.`users` (`id`),
  CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`payment_method_mst_id`) REFERENCES `payment_method_mst` (`id`),
  CONSTRAINT `purchases_ibfk_3` FOREIGN KEY (`purchase_status_type_mst_id`) REFERENCES `purchase_status_type_mst` (`id`),
  CONSTRAINT `purchases_ibfk_4` FOREIGN KEY (`purchase_type_mst_id`) REFERENCES `purchase_type_mst` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=401 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
INSERT INTO `purchases` VALUES (1,3,1,1,1,2480,1,0,'2022-10-14 18:57:46','2022-10-14 18:57:46'),(2,1,2,1,1,2480,1,0,'2022-10-14 19:07:32','2022-10-14 19:07:32'),(3,4,3,1,1,2480,1,0,'2022-10-14 19:12:28','2022-10-14 19:12:28'),(4,5,4,1,1,2480,1,0,'2022-10-14 19:31:29','2022-10-14 19:31:29'),(5,5,5,1,1,2480,1,0,'2022-10-14 19:32:51','2022-10-14 19:32:51'),(6,5,6,1,1,2480,1,0,'2022-10-14 19:33:42','2022-10-14 19:33:42'),(7,5,7,1,1,990,1,0,'2022-10-14 19:41:19','2022-10-14 19:41:19'),(8,1,8,1,1,990,1,0,'2022-10-14 19:45:07','2022-10-14 19:45:07'),(9,5,9,1,1,2480,1,0,'2022-10-14 19:50:14','2022-10-14 19:50:14'),(10,5,10,1,1,2480,1,0,'2022-10-14 19:54:37','2022-10-14 19:54:37'),(11,5,11,1,1,990,1,0,'2022-10-14 19:55:56','2022-10-14 19:55:56'),(12,4,12,1,1,2480,1,0,'2022-10-14 20:14:07','2022-10-14 20:14:07'),(13,4,13,1,1,2480,1,0,'2022-10-14 20:15:11','2022-10-14 20:15:11'),(14,4,14,1,1,2480,1,0,'2022-10-14 20:17:35','2022-10-14 20:17:35'),(15,3,15,1,1,990,1,0,'2022-10-14 20:18:53','2022-10-14 20:18:53'),(16,4,16,1,1,990,1,0,'2022-10-14 20:20:56','2022-10-14 20:20:56'),(17,2,17,1,1,2480,1,0,'2022-10-14 20:23:01','2022-10-14 20:23:01'),(18,5,18,1,1,2480,1,0,'2022-10-14 20:27:00','2022-10-14 20:27:00'),(19,5,19,1,1,3300,1,0,'2022-10-14 20:30:19','2022-10-14 20:30:19'),(20,3,20,1,1,990,1,0,'2022-10-14 20:34:59','2022-10-14 20:34:59'),(21,2,21,1,1,990,1,0,'2022-10-14 20:36:09','2022-10-14 20:36:09'),(22,3,22,1,1,990,1,0,'2022-10-14 20:36:11','2022-10-14 20:36:11'),(23,2,23,1,1,3300,1,0,'2022-10-14 20:43:58','2022-10-14 20:43:58'),(24,3,24,1,1,3300,1,0,'2022-10-14 20:49:08','2022-10-14 20:49:08'),(25,3,25,1,1,990,1,0,'2022-10-14 20:50:35','2022-10-14 20:50:35'),(26,3,26,1,1,3300,1,0,'2022-10-14 20:52:00','2022-10-14 20:52:00'),(27,3,27,1,1,990,1,0,'2022-10-14 20:52:53','2022-10-14 20:52:53'),(28,4,28,1,1,2480,1,0,'2022-10-14 20:55:48','2022-10-14 20:55:48'),(29,5,29,1,1,2480,1,0,'2022-10-14 21:20:27','2022-10-14 21:20:27'),(30,5,30,1,1,2480,1,0,'2022-10-14 21:21:34','2022-10-14 21:21:34'),(31,7,31,1,1,2480,1,0,'2022-10-14 21:22:12','2022-10-14 21:22:12'),(32,5,32,1,1,990,1,0,'2022-10-14 21:23:27','2022-10-14 21:23:27'),(33,5,33,1,1,990,1,0,'2022-10-14 21:24:35','2022-10-14 21:24:35'),(34,5,34,1,1,990,1,0,'2022-10-14 21:26:09','2022-10-14 21:26:09'),(35,8,35,1,1,2480,1,0,'2022-10-14 21:27:54','2022-10-14 21:27:54'),(36,5,36,1,1,990,1,0,'2022-10-14 21:28:34','2022-10-14 21:28:34'),(37,8,37,1,1,2480,1,0,'2022-10-14 21:28:55','2022-10-14 21:28:55'),(38,4,38,1,1,990,1,0,'2022-10-14 21:37:09','2022-10-14 21:37:09'),(39,1,39,1,1,2480,1,0,'2022-10-14 21:47:45','2022-10-14 21:47:45'),(40,1,40,1,1,990,1,0,'2022-10-14 21:48:18','2022-10-14 21:48:18'),(41,5,41,1,1,990,1,0,'2022-10-14 21:56:22','2022-10-14 21:56:22'),(42,7,42,1,1,990,1,0,'2022-10-14 21:59:02','2022-10-14 21:59:02'),(43,2,43,1,1,990,1,0,'2022-10-14 22:04:11','2022-10-14 22:04:11'),(44,10,44,1,1,2480,1,0,'2022-10-14 22:31:42','2022-10-14 22:31:42'),(45,10,45,1,1,990,1,0,'2022-10-14 22:46:29','2022-10-14 22:46:29'),(46,10,46,1,1,2480,1,0,'2022-10-14 22:47:24','2022-10-14 22:47:24'),(47,10,47,1,1,3300,1,0,'2022-10-14 22:48:07','2022-10-14 22:48:07'),(48,10,48,1,1,3300,1,0,'2022-10-14 22:49:44','2022-10-14 22:49:44'),(49,10,49,1,1,3300,1,0,'2022-10-14 22:52:39','2022-10-14 22:52:39'),(50,10,50,1,1,3300,1,0,'2022-10-14 22:53:20','2022-10-14 22:53:20'),(51,10,51,1,1,3300,1,0,'2022-10-14 22:54:09','2022-10-14 22:54:09'),(52,10,52,1,1,3300,1,0,'2022-10-14 22:55:01','2022-10-14 22:55:01'),(53,10,53,1,1,3300,1,0,'2022-10-14 22:57:17','2022-10-14 22:57:17'),(54,2,54,1,1,3300,1,0,'2022-10-14 23:01:31','2022-10-14 23:01:31'),(55,2,55,1,1,990,1,0,'2022-10-14 23:04:02','2022-10-14 23:04:02'),(56,10,56,1,1,990,1,0,'2022-10-14 23:15:25','2022-10-14 23:15:25'),(57,10,57,1,1,990,1,0,'2022-10-14 23:17:09','2022-10-14 23:17:09'),(58,2,58,1,1,990,1,0,'2022-10-14 23:19:45','2022-10-14 23:19:45'),(59,10,59,1,1,2480,1,0,'2022-10-15 01:08:41','2022-10-15 01:08:41'),(60,10,60,1,1,2480,1,0,'2022-10-15 01:09:52','2022-10-15 01:09:52'),(61,10,61,1,1,3300,1,0,'2022-10-15 01:10:49','2022-10-15 01:10:49'),(62,10,62,1,1,2480,1,0,'2022-10-15 01:11:41','2022-10-15 01:11:41'),(63,3,63,1,1,777,1,0,'2022-10-15 01:38:47','2022-10-15 01:38:47'),(64,10,64,1,1,3300,1,0,'2022-10-15 02:09:43','2022-10-15 02:09:43'),(65,3,65,1,1,990,1,0,'2022-10-15 09:37:24','2022-10-15 09:37:24'),(66,3,66,1,1,990,1,0,'2022-10-15 09:39:58','2022-10-15 09:39:58'),(67,3,67,1,1,990,1,0,'2022-10-15 09:56:08','2022-10-15 09:56:08'),(68,12,68,1,1,777,1,0,'2022-10-15 10:00:59','2022-10-15 10:00:59'),(69,12,69,1,1,990,1,0,'2022-10-15 10:02:28','2022-10-15 10:02:28'),(70,12,70,1,1,777,1,0,'2022-10-15 10:04:00','2022-10-15 10:04:00'),(71,12,71,1,1,990,1,0,'2022-10-15 10:06:01','2022-10-15 10:06:01'),(72,2,72,1,1,990,1,0,'2022-10-15 10:13:48','2022-10-15 10:13:48'),(73,12,73,1,1,2480,1,0,'2022-10-15 11:19:30','2022-10-15 11:19:30'),(74,12,74,1,1,2480,1,0,'2022-10-15 11:20:31','2022-10-15 11:20:31'),(75,12,75,1,1,3300,1,0,'2022-10-15 11:24:07','2022-10-15 11:24:07'),(76,12,76,1,1,777,1,0,'2022-10-15 11:25:26','2022-10-15 11:25:26'),(77,12,77,1,1,990,1,0,'2022-10-15 11:28:24','2022-10-15 11:28:24'),(78,12,78,1,1,990,1,0,'2022-10-15 11:30:17','2022-10-15 11:30:17'),(79,12,79,1,1,990,1,0,'2022-10-15 11:32:26','2022-10-15 11:32:26'),(80,14,80,1,1,3300,1,0,'2022-10-15 11:57:04','2022-10-15 11:57:04'),(81,15,81,1,1,990,1,0,'2022-10-15 11:57:42','2022-10-15 11:57:42'),(82,15,82,1,1,990,1,0,'2022-10-15 11:58:50','2022-10-15 11:58:50'),(83,14,83,1,1,990,1,0,'2022-10-15 11:59:58','2022-10-15 11:59:58'),(84,14,84,1,1,990,1,0,'2022-10-15 12:02:34','2022-10-15 12:02:34'),(85,15,85,1,1,777,1,0,'2022-10-15 12:03:04','2022-10-15 12:03:04'),(86,14,86,1,1,990,1,0,'2022-10-15 12:03:28','2022-10-15 12:03:28'),(87,15,87,1,1,777,1,0,'2022-10-15 12:04:45','2022-10-15 12:04:45'),(88,14,88,1,1,990,1,0,'2022-10-15 12:05:54','2022-10-15 12:05:54'),(89,14,89,1,1,2480,1,0,'2022-10-15 12:06:37','2022-10-15 12:06:37'),(90,14,90,1,1,3300,1,0,'2022-10-15 12:07:21','2022-10-15 12:07:21'),(91,14,91,1,1,990,1,0,'2022-10-15 12:09:58','2022-10-15 12:09:58'),(92,14,92,1,1,990,1,0,'2022-10-15 12:10:29','2022-10-15 12:10:29'),(93,12,93,1,1,990,1,0,'2022-10-15 12:21:26','2022-10-15 12:21:26'),(94,12,94,1,1,990,1,0,'2022-10-15 12:22:02','2022-10-15 12:22:02'),(95,2,95,1,1,777,1,0,'2022-10-15 12:22:44','2022-10-15 12:22:44'),(96,14,96,1,1,990,1,0,'2022-10-15 12:23:05','2022-10-15 12:23:05'),(97,14,97,1,1,990,1,0,'2022-10-15 12:23:42','2022-10-15 12:23:42'),(98,14,98,1,1,2480,1,0,'2022-10-15 12:24:18','2022-10-15 12:24:18'),(99,2,99,1,1,990,1,0,'2022-10-15 12:32:42','2022-10-15 12:32:42'),(100,2,100,1,1,990,1,0,'2022-10-15 12:35:15','2022-10-15 12:35:15'),(101,15,101,1,1,2480,1,0,'2022-10-15 12:35:18','2022-10-15 12:35:18'),(102,3,102,1,1,990,1,0,'2022-10-15 12:40:11','2022-10-15 12:40:11'),(103,12,103,1,1,777,1,0,'2022-10-15 12:45:57','2022-10-15 12:45:57'),(104,15,104,1,1,2480,1,0,'2022-10-15 12:47:32','2022-10-15 12:47:32'),(105,15,105,1,1,990,1,0,'2022-10-15 12:48:48','2022-10-15 12:48:48'),(106,15,106,1,1,990,1,0,'2022-10-15 12:49:39','2022-10-15 12:49:39'),(107,12,107,1,1,990,1,0,'2022-10-15 12:50:25','2022-10-15 12:50:25'),(108,14,108,1,1,2480,1,0,'2022-10-15 12:50:50','2022-10-15 12:50:50'),(109,12,109,1,1,777,1,0,'2022-10-15 12:50:54','2022-10-15 12:50:54'),(110,15,110,1,1,3300,1,0,'2022-10-15 12:51:15','2022-10-15 12:51:15'),(111,12,111,1,1,777,1,0,'2022-10-15 12:51:29','2022-10-15 12:51:29'),(112,14,112,1,1,2480,1,0,'2022-10-15 12:51:42','2022-10-15 12:51:42'),(113,7,113,1,1,990,1,0,'2022-10-15 12:52:26','2022-10-15 12:52:26'),(114,14,114,1,1,990,1,0,'2022-10-15 12:53:16','2022-10-15 12:53:16'),(115,12,115,1,1,777,1,0,'2022-10-15 12:53:33','2022-10-15 12:53:33'),(116,14,116,1,1,990,1,0,'2022-10-15 12:53:46','2022-10-15 12:53:46'),(117,14,117,1,1,2480,1,0,'2022-10-15 12:54:53','2022-10-15 12:54:53'),(118,14,118,1,1,990,1,0,'2022-10-15 12:55:32','2022-10-15 12:55:32'),(119,15,119,1,1,990,1,0,'2022-10-15 12:55:47','2022-10-15 12:55:47'),(120,14,120,1,1,2480,1,0,'2022-10-15 12:56:02','2022-10-15 12:56:02'),(121,7,121,1,1,777,1,0,'2022-10-15 12:56:06','2022-10-15 12:56:06'),(122,15,122,1,1,3300,1,0,'2022-10-15 12:57:07','2022-10-15 12:57:07'),(123,14,123,1,1,2480,1,0,'2022-10-15 12:57:14','2022-10-15 12:57:14'),(124,12,124,1,1,990,1,0,'2022-10-15 12:57:41','2022-10-15 12:57:41'),(125,12,125,1,1,990,1,0,'2022-10-15 12:58:18','2022-10-15 12:58:18'),(126,2,126,1,1,990,1,0,'2022-10-15 12:59:09','2022-10-15 12:59:09'),(127,12,127,1,1,3300,1,0,'2022-10-15 12:59:29','2022-10-15 12:59:29'),(128,2,128,1,1,990,1,0,'2022-10-15 12:59:52','2022-10-15 12:59:52'),(129,14,129,1,1,3300,1,0,'2022-10-15 13:00:34','2022-10-15 13:00:34'),(130,2,130,1,1,990,1,0,'2022-10-15 13:01:15','2022-10-15 13:01:15'),(131,3,131,1,1,3300,1,0,'2022-10-15 13:01:35','2022-10-15 13:01:35'),(132,14,132,1,1,990,1,0,'2022-10-15 13:01:46','2022-10-15 13:01:46'),(133,14,133,1,1,990,1,0,'2022-10-15 13:02:37','2022-10-15 13:02:37'),(134,3,134,1,1,777,1,0,'2022-10-15 13:02:42','2022-10-15 13:02:42'),(135,4,135,1,1,990,1,0,'2022-10-15 13:03:27','2022-10-15 13:03:27'),(136,3,136,1,1,3300,1,0,'2022-10-15 13:03:52','2022-10-15 13:03:52'),(137,2,137,1,1,3300,1,0,'2022-10-15 13:04:51','2022-10-15 13:04:51'),(138,14,138,1,1,3300,1,0,'2022-10-15 13:05:43','2022-10-15 13:05:43'),(139,2,139,1,1,990,1,0,'2022-10-15 13:26:10','2022-10-15 13:26:10'),(140,3,140,1,1,777,1,0,'2022-10-15 13:39:15','2022-10-15 13:39:15'),(141,10,141,1,1,990,1,0,'2022-10-15 13:45:08','2022-10-15 13:45:08'),(142,1,142,1,1,3300,1,0,'2022-10-15 14:00:55','2022-10-15 14:00:55'),(143,1,143,1,1,3300,1,0,'2022-10-15 14:03:12','2022-10-15 14:03:12'),(144,1,144,1,1,3300,1,0,'2022-10-15 14:04:08','2022-10-15 14:04:08'),(145,1,145,1,1,990,1,0,'2022-10-15 14:06:18','2022-10-15 14:06:18'),(146,1,146,1,1,990,1,0,'2022-10-15 14:10:28','2022-10-15 14:10:28'),(147,1,147,1,1,990,1,0,'2022-10-15 14:10:58','2022-10-15 14:10:58'),(148,1,148,1,1,990,1,0,'2022-10-15 14:11:23','2022-10-15 14:11:23'),(149,1,149,1,1,990,1,0,'2022-10-15 14:12:30','2022-10-15 14:12:30'),(150,1,150,1,1,777,1,0,'2022-10-15 14:14:10','2022-10-15 14:14:10'),(151,10,151,1,1,3300,1,0,'2022-10-15 14:24:17','2022-10-15 14:24:17'),(152,10,152,1,1,990,1,0,'2022-10-15 14:25:27','2022-10-15 14:25:27'),(153,10,153,1,1,990,1,0,'2022-10-15 14:26:13','2022-10-15 14:26:13'),(154,16,154,1,1,990,1,0,'2022-10-15 14:58:28','2022-10-15 14:58:28'),(155,16,155,1,1,990,1,0,'2022-10-15 15:02:03','2022-10-15 15:02:03'),(156,16,156,1,1,3300,1,0,'2022-10-15 15:06:53','2022-10-15 15:06:53'),(157,10,157,1,1,938,2,0,'2022-10-15 15:23:20','2022-10-15 15:23:20'),(158,3,158,1,1,3300,1,0,'2022-10-15 15:41:12','2022-10-15 15:41:12'),(159,3,159,1,1,777,1,0,'2022-10-15 15:41:53','2022-10-15 15:41:53'),(160,3,160,1,1,3300,1,0,'2022-10-15 15:43:00','2022-10-15 15:43:00'),(161,3,161,1,1,990,1,0,'2022-10-15 15:44:03','2022-10-15 15:44:03'),(162,10,162,1,1,990,1,0,'2022-10-15 15:50:44','2022-10-15 15:50:44'),(163,7,163,1,1,990,1,0,'2022-10-15 16:28:13','2022-10-15 16:28:13'),(164,7,164,1,1,990,1,0,'2022-10-15 16:29:15','2022-10-15 16:29:15'),(165,7,165,1,1,3300,1,0,'2022-10-15 16:50:54','2022-10-15 16:50:54'),(166,3,166,1,1,777,1,0,'2022-10-15 16:54:14','2022-10-15 16:54:14'),(167,3,167,1,1,990,1,0,'2022-10-15 16:55:41','2022-10-15 16:55:41'),(168,12,168,1,1,777,1,0,'2022-10-15 17:53:59','2022-10-15 17:53:59'),(169,12,169,1,1,990,1,0,'2022-10-15 17:55:00','2022-10-15 17:55:00'),(170,12,170,1,1,3300,1,0,'2022-10-15 17:55:46','2022-10-15 17:55:46'),(171,3,171,1,1,777,1,0,'2022-10-15 18:16:37','2022-10-15 18:16:37'),(172,9,172,1,1,990,1,0,'2022-10-15 18:23:41','2022-10-15 18:23:41'),(173,18,173,1,1,777,1,0,'2022-10-15 18:36:22','2022-10-15 18:36:22'),(174,5,174,1,1,990,1,0,'2022-10-15 18:38:54','2022-10-15 18:38:54'),(175,5,175,1,1,3300,1,0,'2022-10-15 18:42:33','2022-10-15 18:42:33'),(176,6,176,1,1,777,1,0,'2022-10-15 19:00:39','2022-10-15 19:00:39'),(177,17,177,1,1,990,1,0,'2022-10-15 20:57:05','2022-10-15 20:57:05'),(178,17,178,1,1,3300,1,0,'2022-10-15 20:58:00','2022-10-15 20:58:00'),(179,12,179,1,1,938,2,0,'2022-10-15 21:23:04','2022-10-15 21:23:04'),(180,12,180,1,1,19,2,0,'2022-10-15 21:24:51','2022-10-15 21:24:51'),(181,12,181,1,1,19,2,0,'2022-10-15 21:33:49','2022-10-15 21:33:49'),(182,18,182,1,1,3300,1,0,'2022-10-15 21:42:52','2022-10-15 21:42:52'),(183,18,183,1,1,938,2,0,'2022-10-15 21:44:08','2022-10-15 21:44:08'),(184,18,184,1,1,19,2,0,'2022-10-15 21:44:47','2022-10-15 21:44:47'),(185,18,185,1,1,938,2,0,'2022-10-15 21:45:12','2022-10-15 21:45:12'),(186,18,186,1,1,990,1,0,'2022-10-15 21:46:00','2022-10-15 21:46:00'),(187,18,187,1,1,19,2,0,'2022-10-15 21:46:31','2022-10-15 21:46:31'),(188,18,188,1,1,938,2,0,'2022-10-15 21:46:58','2022-10-15 21:46:58'),(189,18,189,1,1,938,2,0,'2022-10-15 21:47:33','2022-10-15 21:47:33'),(190,18,190,1,1,3300,1,0,'2022-10-15 21:48:28','2022-10-15 21:48:28'),(191,18,191,1,1,3300,1,0,'2022-10-15 21:54:57','2022-10-15 21:54:57'),(192,18,192,1,1,3300,1,0,'2022-10-15 21:56:02','2022-10-15 21:56:02'),(193,18,193,1,1,19,2,0,'2022-10-15 21:56:42','2022-10-15 21:56:42'),(194,18,194,1,1,19,2,0,'2022-10-15 21:57:15','2022-10-15 21:57:15'),(195,18,195,1,1,938,2,0,'2022-10-15 21:57:43','2022-10-15 21:57:43'),(196,18,196,1,1,990,1,0,'2022-10-15 21:59:04','2022-10-15 21:59:04'),(197,20,197,1,1,777,1,0,'2022-10-15 22:04:13','2022-10-15 22:04:13'),(198,18,198,1,1,990,1,0,'2022-10-15 22:05:09','2022-10-15 22:05:09'),(199,18,199,1,1,19,2,0,'2022-10-15 22:06:11','2022-10-15 22:06:11'),(200,18,200,1,1,938,2,0,'2022-10-15 22:06:36','2022-10-15 22:06:36'),(201,18,201,1,1,938,2,0,'2022-10-15 22:15:22','2022-10-15 22:15:22'),(202,18,202,1,1,938,2,0,'2022-10-15 22:15:53','2022-10-15 22:15:53'),(203,7,203,1,1,777,1,0,'2022-10-15 23:29:02','2022-10-15 23:29:02'),(204,12,204,1,1,938,2,0,'2022-10-15 23:29:55','2022-10-15 23:29:55'),(205,12,205,1,1,19,2,0,'2022-10-15 23:30:41','2022-10-15 23:30:41'),(206,12,206,1,1,938,2,0,'2022-10-15 23:32:39','2022-10-15 23:32:39'),(207,12,207,1,1,19,2,0,'2022-10-15 23:33:10','2022-10-15 23:33:10'),(208,12,208,1,1,777,1,0,'2022-10-15 23:33:28','2022-10-15 23:33:28'),(209,12,209,1,1,777,1,0,'2022-10-15 23:34:03','2022-10-15 23:34:03'),(210,12,210,1,1,3300,1,0,'2022-10-15 23:36:26','2022-10-15 23:36:26'),(211,12,211,1,1,938,2,0,'2022-10-15 23:37:04','2022-10-15 23:37:04'),(212,10,212,1,1,990,1,0,'2022-10-15 23:46:08','2022-10-15 23:46:08'),(213,7,213,1,1,777,1,0,'2022-10-15 23:46:40','2022-10-15 23:46:40'),(214,12,214,1,1,990,1,0,'2022-10-16 00:00:02','2022-10-16 00:00:02'),(215,12,215,1,1,777,1,0,'2022-10-16 00:03:27','2022-10-16 00:03:27'),(216,12,216,1,1,777,1,0,'2022-10-16 00:07:10','2022-10-16 00:07:10'),(217,12,217,1,1,777,1,0,'2022-10-16 00:10:08','2022-10-16 00:10:08'),(218,12,218,1,1,777,1,0,'2022-10-16 00:10:53','2022-10-16 00:10:53'),(219,12,219,1,1,777,1,0,'2022-10-16 00:11:40','2022-10-16 00:11:40'),(220,12,220,1,1,777,1,0,'2022-10-16 00:13:26','2022-10-16 00:13:26'),(221,12,221,1,1,777,1,0,'2022-10-16 00:15:08','2022-10-16 00:15:08'),(222,12,222,1,1,777,1,0,'2022-10-16 00:15:34','2022-10-16 00:15:34'),(223,12,223,1,1,777,1,0,'2022-10-16 00:16:03','2022-10-16 00:16:03'),(224,3,224,1,1,777,1,0,'2022-10-16 00:16:15','2022-10-16 00:16:15'),(225,12,225,1,1,777,1,0,'2022-10-16 00:17:53','2022-10-16 00:17:53'),(226,12,226,1,1,777,1,0,'2022-10-16 00:18:56','2022-10-16 00:18:56'),(227,12,227,1,1,777,1,0,'2022-10-16 00:19:22','2022-10-16 00:19:22'),(228,12,228,1,1,777,1,0,'2022-10-16 00:20:43','2022-10-16 00:20:43'),(229,12,229,1,1,777,1,0,'2022-10-16 00:20:57','2022-10-16 00:20:57'),(230,12,230,1,1,777,1,0,'2022-10-16 00:21:22','2022-10-16 00:21:22'),(231,12,231,1,1,777,1,0,'2022-10-16 00:26:07','2022-10-16 00:26:07'),(232,12,232,1,1,777,1,0,'2022-10-16 00:27:27','2022-10-16 00:27:27'),(233,12,233,1,1,777,1,0,'2022-10-16 00:27:52','2022-10-16 00:27:52'),(234,12,234,1,1,777,1,0,'2022-10-16 00:28:20','2022-10-16 00:28:20'),(235,12,235,1,1,777,1,0,'2022-10-16 00:29:52','2022-10-16 00:29:52'),(236,12,236,1,1,938,2,0,'2022-10-16 10:11:26','2022-10-16 10:11:26'),(237,21,237,1,1,777,1,0,'2022-10-16 10:13:22','2022-10-16 10:13:22'),(238,7,238,1,1,19,2,0,'2022-10-16 10:33:41','2022-10-16 10:33:41'),(239,18,239,1,1,777,1,0,'2022-10-16 11:08:36','2022-10-16 11:08:36'),(240,3,240,1,1,938,2,0,'2022-10-16 11:10:26','2022-10-16 11:10:26'),(241,3,241,1,1,938,2,0,'2022-10-16 11:12:16','2022-10-16 11:12:16'),(242,1,242,1,1,19,2,0,'2022-10-16 11:14:16','2022-10-16 11:14:16'),(243,10,243,1,1,938,2,0,'2022-10-16 11:21:36','2022-10-16 11:21:36'),(244,5,244,1,1,990,1,0,'2022-10-16 11:22:14','2022-10-16 11:22:14'),(245,10,245,1,1,19,2,0,'2022-10-16 11:22:20','2022-10-16 11:22:20'),(246,5,246,1,1,777,1,0,'2022-10-16 11:23:36','2022-10-16 11:23:36'),(247,5,247,1,1,990,1,0,'2022-10-16 11:25:04','2022-10-16 11:25:04'),(248,5,248,1,1,990,1,0,'2022-10-16 11:25:47','2022-10-16 11:25:47'),(249,5,249,1,1,777,1,0,'2022-10-16 11:26:22','2022-10-16 11:26:22'),(250,10,250,1,1,990,1,0,'2022-10-16 11:28:17','2022-10-16 11:28:17'),(251,3,251,1,1,777,1,0,'2022-10-16 11:28:23','2022-10-16 11:28:23'),(252,7,252,1,1,990,1,0,'2022-10-16 11:28:40','2022-10-16 11:28:40'),(253,2,253,1,1,777,1,0,'2022-10-16 11:28:41','2022-10-16 11:28:41'),(254,3,254,1,1,777,1,0,'2022-10-16 11:28:54','2022-10-16 11:28:54'),(255,5,255,1,1,3300,1,0,'2022-10-16 11:32:37','2022-10-16 11:32:37'),(256,5,256,1,1,777,1,0,'2022-10-16 11:33:24','2022-10-16 11:33:24'),(257,5,257,1,1,777,1,0,'2022-10-16 11:33:56','2022-10-16 11:33:56'),(258,5,258,1,1,777,1,0,'2022-10-16 11:34:25','2022-10-16 11:34:25'),(259,2,259,1,1,990,1,0,'2022-10-16 11:41:34','2022-10-16 11:41:34'),(260,5,260,1,1,19,2,0,'2022-10-16 11:46:55','2022-10-16 11:46:55'),(261,5,261,1,1,19,2,0,'2022-10-16 11:47:50','2022-10-16 11:47:50'),(262,5,262,1,1,19,2,0,'2022-10-16 11:51:15','2022-10-16 11:51:15'),(263,5,263,1,1,19,2,0,'2022-10-16 11:55:49','2022-10-16 11:55:49'),(264,1,264,1,1,938,2,0,'2022-10-16 11:55:56','2022-10-16 11:55:56'),(265,3,265,1,1,19,2,0,'2022-10-16 12:00:56','2022-10-16 12:00:56'),(266,17,266,1,1,777,1,0,'2022-10-16 12:16:54','2022-10-16 12:16:54'),(267,18,267,1,1,938,2,0,'2022-10-16 12:26:36','2022-10-16 12:26:36'),(268,17,268,1,1,938,2,0,'2022-10-16 12:27:19','2022-10-16 12:27:19'),(269,5,269,1,1,990,1,0,'2022-10-16 12:28:25','2022-10-16 12:28:25'),(270,18,270,1,1,3300,1,0,'2022-10-16 12:35:33','2022-10-16 12:35:33'),(271,18,271,1,1,938,2,0,'2022-10-16 12:36:26','2022-10-16 12:36:26'),(272,14,272,1,1,938,2,0,'2022-10-16 12:37:51','2022-10-16 12:37:51'),(273,14,273,1,1,990,1,0,'2022-10-16 12:44:22','2022-10-16 12:44:22'),(274,14,274,1,1,938,2,0,'2022-10-16 12:45:48','2022-10-16 12:45:48'),(275,14,275,1,1,990,1,0,'2022-10-16 12:46:19','2022-10-16 12:46:19'),(276,3,276,1,1,19,2,0,'2022-10-16 12:46:45','2022-10-16 12:46:45'),(277,3,277,1,1,19,2,0,'2022-10-16 12:53:59','2022-10-16 12:53:59'),(278,14,278,1,1,938,2,0,'2022-10-16 13:02:20','2022-10-16 13:02:20'),(279,14,279,1,1,938,2,0,'2022-10-16 13:03:34','2022-10-16 13:03:34'),(280,14,280,1,1,938,2,0,'2022-10-16 13:04:54','2022-10-16 13:04:54'),(281,3,281,1,1,19,2,0,'2022-10-16 13:13:58','2022-10-16 13:13:58'),(282,3,282,1,1,938,2,0,'2022-10-16 13:20:01','2022-10-16 13:20:01'),(283,1,283,1,1,938,2,0,'2022-10-16 13:25:41','2022-10-16 13:25:41'),(284,3,284,1,1,990,1,0,'2022-10-16 13:37:10','2022-10-16 13:37:10'),(285,1,285,1,1,777,1,0,'2022-10-16 14:16:13','2022-10-16 14:16:13'),(286,3,286,1,1,990,1,0,'2022-10-16 14:45:41','2022-10-16 14:45:41'),(287,18,287,1,1,3300,1,0,'2022-10-16 14:46:11','2022-10-16 14:46:11'),(288,18,288,1,1,938,2,0,'2022-10-16 14:46:47','2022-10-16 14:46:47'),(289,18,289,1,1,938,2,0,'2022-10-16 14:47:22','2022-10-16 14:47:22'),(290,18,290,1,1,938,2,0,'2022-10-16 14:47:51','2022-10-16 14:47:51'),(291,18,291,1,1,990,1,0,'2022-10-16 14:48:20','2022-10-16 14:48:20'),(292,18,292,1,1,938,2,0,'2022-10-16 14:49:06','2022-10-16 14:49:06'),(293,18,293,1,1,19,2,0,'2022-10-16 14:49:50','2022-10-16 14:49:50'),(294,18,294,1,1,19,2,0,'2022-10-16 14:50:19','2022-10-16 14:50:19'),(295,18,295,1,1,19,2,0,'2022-10-16 14:50:51','2022-10-16 14:50:51'),(296,18,296,1,1,938,2,0,'2022-10-16 14:51:30','2022-10-16 14:51:30'),(297,18,297,1,1,19,2,0,'2022-10-16 14:54:21','2022-10-16 14:54:21'),(298,12,298,1,1,777,1,0,'2022-10-16 15:02:10','2022-10-16 15:02:10'),(299,12,299,1,1,777,1,0,'2022-10-16 15:22:53','2022-10-16 15:22:53'),(300,12,300,1,1,3300,1,0,'2022-10-16 15:23:36','2022-10-16 15:23:36'),(301,12,301,1,1,938,2,0,'2022-10-16 15:24:35','2022-10-16 15:24:35'),(302,16,302,1,1,990,1,0,'2022-10-16 16:14:37','2022-10-16 16:14:37'),(303,16,303,1,1,990,1,0,'2022-10-16 16:29:51','2022-10-16 16:29:51'),(304,16,304,1,1,938,2,0,'2022-10-16 16:34:11','2022-10-16 16:34:11'),(305,2,305,1,1,990,1,0,'2022-10-16 17:15:37','2022-10-16 17:15:37'),(306,5,306,1,1,990,1,0,'2022-10-16 17:15:54','2022-10-16 17:15:54'),(307,12,307,1,1,938,2,0,'2022-10-16 17:38:27','2022-10-16 17:38:27'),(308,12,308,1,1,3300,1,0,'2022-10-16 18:04:49','2022-10-16 18:04:49'),(309,7,309,1,1,990,1,0,'2022-10-16 18:05:29','2022-10-16 18:05:29'),(310,12,310,1,1,938,2,0,'2022-10-16 18:06:00','2022-10-16 18:06:00'),(311,7,311,1,1,3300,1,0,'2022-10-16 18:07:07','2022-10-16 18:07:07'),(312,12,312,1,1,938,2,0,'2022-10-16 18:07:31','2022-10-16 18:07:31'),(313,14,313,1,1,3300,1,0,'2022-10-16 18:07:37','2022-10-16 18:07:37'),(314,7,314,1,1,19,2,0,'2022-10-16 18:08:24','2022-10-16 18:08:24'),(315,12,315,1,1,938,2,0,'2022-10-16 18:08:56','2022-10-16 18:08:56'),(316,14,316,1,1,938,2,0,'2022-10-16 18:09:26','2022-10-16 18:09:26'),(317,7,317,1,1,938,2,0,'2022-10-16 18:10:25','2022-10-16 18:10:25'),(318,14,318,1,1,938,2,0,'2022-10-16 18:13:29','2022-10-16 18:13:29'),(319,14,319,1,1,938,2,0,'2022-10-16 18:16:38','2022-10-16 18:16:38'),(320,12,320,1,1,938,2,0,'2022-10-16 18:19:14','2022-10-16 18:19:14'),(321,12,321,1,1,19,2,0,'2022-10-16 18:19:45','2022-10-16 18:19:45'),(322,7,322,1,1,938,2,0,'2022-10-16 18:19:57','2022-10-16 18:19:57'),(323,12,323,1,1,938,2,0,'2022-10-16 18:20:31','2022-10-16 18:20:31'),(324,14,324,1,1,938,2,0,'2022-10-16 18:21:54','2022-10-16 18:21:54'),(325,14,325,1,1,938,2,0,'2022-10-16 18:25:04','2022-10-16 18:25:04'),(326,14,326,1,1,938,2,0,'2022-10-16 18:25:51','2022-10-16 18:25:51'),(327,7,327,1,1,3300,1,0,'2022-10-16 18:27:09','2022-10-16 18:27:09'),(328,14,328,1,1,938,2,0,'2022-10-16 18:27:38','2022-10-16 18:27:38'),(329,14,329,1,1,938,2,0,'2022-10-16 18:29:12','2022-10-16 18:29:12'),(330,12,330,1,1,19,2,0,'2022-10-16 18:32:10','2022-10-16 18:32:10'),(331,14,331,1,1,3300,1,0,'2022-10-16 18:32:48','2022-10-16 18:32:48'),(332,14,332,1,1,938,2,0,'2022-10-16 18:33:22','2022-10-16 18:33:22'),(333,7,333,1,1,938,2,0,'2022-10-16 18:34:16','2022-10-16 18:34:16'),(334,14,334,1,1,938,2,0,'2022-10-16 18:34:46','2022-10-16 18:34:46'),(335,14,335,1,1,938,2,0,'2022-10-16 18:35:48','2022-10-16 18:35:48'),(336,7,336,1,1,19,2,0,'2022-10-16 18:36:17','2022-10-16 18:36:17'),(337,14,337,1,1,990,1,0,'2022-10-16 18:41:17','2022-10-16 18:41:17'),(338,14,338,1,1,3300,1,0,'2022-10-16 18:41:53','2022-10-16 18:41:53'),(339,14,339,1,1,938,2,0,'2022-10-16 18:42:26','2022-10-16 18:42:26'),(340,14,340,1,1,938,2,0,'2022-10-16 18:44:55','2022-10-16 18:44:55'),(341,18,341,1,1,938,2,0,'2022-10-16 18:45:13','2022-10-16 18:45:13'),(342,14,342,1,1,938,2,0,'2022-10-16 18:46:32','2022-10-16 18:46:32'),(343,14,343,1,1,3300,1,0,'2022-10-16 18:50:31','2022-10-16 18:50:31'),(344,14,344,1,1,938,2,0,'2022-10-16 18:51:11','2022-10-16 18:51:11'),(345,14,345,1,1,938,2,0,'2022-10-16 18:52:12','2022-10-16 18:52:12'),(346,14,346,1,1,938,2,0,'2022-10-16 18:53:04','2022-10-16 18:53:04'),(347,12,347,1,1,938,2,0,'2022-10-16 19:08:15','2022-10-16 19:08:15'),(348,12,348,1,1,19,2,0,'2022-10-16 19:08:41','2022-10-16 19:08:41'),(349,12,349,1,1,938,2,0,'2022-10-16 19:09:30','2022-10-16 19:09:30'),(350,7,350,1,1,938,2,0,'2022-10-16 19:27:03','2022-10-16 19:27:03'),(351,17,351,1,1,19,2,0,'2022-10-16 19:37:52','2022-10-16 19:37:52'),(352,14,352,1,1,3300,1,0,'2022-10-16 19:41:31','2022-10-16 19:41:31'),(353,14,353,1,1,938,2,0,'2022-10-16 19:42:02','2022-10-16 19:42:02'),(354,14,354,1,1,938,2,0,'2022-10-16 19:42:39','2022-10-16 19:42:39'),(355,12,355,1,1,19,2,0,'2022-10-16 19:43:07','2022-10-16 19:43:07'),(356,14,356,1,1,938,2,0,'2022-10-16 19:43:24','2022-10-16 19:43:24'),(357,12,357,1,1,938,2,0,'2022-10-16 19:43:43','2022-10-16 19:43:43'),(358,14,358,1,1,938,2,0,'2022-10-16 20:00:05','2022-10-16 20:00:05'),(359,14,359,1,1,3300,1,0,'2022-10-16 20:13:29','2022-10-16 20:13:29'),(360,12,360,1,1,938,2,0,'2022-10-16 20:26:07','2022-10-16 20:26:07'),(361,12,361,1,1,19,2,0,'2022-10-16 20:26:37','2022-10-16 20:26:37'),(362,12,362,1,1,938,2,0,'2022-10-16 20:27:04','2022-10-16 20:27:04'),(363,12,363,1,1,3300,1,0,'2022-10-16 20:28:02','2022-10-16 20:28:02'),(364,12,364,1,1,3300,1,0,'2022-10-16 20:29:56','2022-10-16 20:29:56'),(365,12,365,1,1,938,2,0,'2022-10-16 20:30:25','2022-10-16 20:30:25'),(366,12,366,1,1,938,2,0,'2022-10-16 20:30:48','2022-10-16 20:30:48'),(367,12,367,1,1,938,2,0,'2022-10-16 20:31:09','2022-10-16 20:31:09'),(368,12,368,1,1,3300,1,0,'2022-10-16 20:33:13','2022-10-16 20:33:13'),(369,14,369,1,1,990,1,0,'2022-10-16 20:34:33','2022-10-16 20:34:33'),(370,14,370,1,1,3300,1,0,'2022-10-16 20:35:29','2022-10-16 20:35:29'),(371,14,371,1,1,938,2,0,'2022-10-16 20:36:11','2022-10-16 20:36:11'),(372,2,372,1,1,3300,1,0,'2022-10-16 20:36:47','2022-10-16 20:36:47'),(373,12,373,1,1,990,1,0,'2022-10-16 20:38:42','2022-10-16 20:38:42'),(374,14,374,1,1,990,1,0,'2022-10-16 20:38:54','2022-10-16 20:38:54'),(375,14,375,1,1,938,2,0,'2022-10-16 20:39:51','2022-10-16 20:39:51'),(376,12,376,1,1,938,2,0,'2022-10-16 20:40:34','2022-10-16 20:40:34'),(377,2,377,1,1,777,1,0,'2022-10-16 21:20:16','2022-10-16 21:20:16'),(378,2,378,1,1,19,2,0,'2022-10-16 21:25:50','2022-10-16 21:25:50'),(379,12,379,1,1,938,2,0,'2022-10-16 21:45:42','2022-10-16 21:45:42'),(380,12,380,1,1,938,2,0,'2022-10-16 21:46:06','2022-10-16 21:46:06'),(381,14,381,1,1,938,2,0,'2022-10-16 21:46:24','2022-10-16 21:46:24'),(382,17,382,1,1,19,2,0,'2022-10-16 21:46:25','2022-10-16 21:46:25'),(383,17,383,1,1,990,1,0,'2022-10-16 21:47:50','2022-10-16 21:47:50'),(384,17,384,1,1,19,2,0,'2022-10-16 21:48:39','2022-10-16 21:48:39'),(385,16,385,1,1,938,2,0,'2022-10-16 21:50:05','2022-10-16 21:50:05'),(386,12,386,1,1,938,2,0,'2022-10-16 21:53:31','2022-10-16 21:53:31'),(387,12,387,1,1,938,2,0,'2022-10-16 21:54:03','2022-10-16 21:54:03'),(388,12,388,1,1,938,2,0,'2022-10-16 21:55:29','2022-10-16 21:55:29'),(389,12,389,1,1,938,2,0,'2022-10-16 21:55:59','2022-10-16 21:55:59'),(390,2,390,1,1,19,2,0,'2022-10-16 23:44:26','2022-10-16 23:44:26'),(391,3,391,1,1,19,2,0,'2022-10-17 00:11:31','2022-10-17 00:11:31'),(392,3,392,1,1,19,2,0,'2022-10-17 00:48:29','2022-10-17 00:48:29'),(393,14,393,1,1,938,2,0,'2022-10-17 01:19:38','2022-10-17 01:19:38'),(394,16,394,1,1,938,2,0,'2022-10-17 09:06:28','2022-10-17 09:06:28'),(395,2,395,1,1,990,1,0,'2022-10-18 21:12:09','2022-10-18 21:12:09'),(396,4,396,1,1,777,1,0,'2022-10-20 13:32:46','2022-10-20 13:32:46'),(397,4,397,1,1,938,2,0,'2022-10-20 13:33:55','2022-10-20 13:33:55'),(398,4,398,1,1,990,1,0,'2022-10-21 15:07:12','2022-10-21 15:07:12'),(399,4,399,1,1,990,1,0,'2022-10-21 15:08:17','2022-10-21 15:08:17'),(400,4,400,1,1,938,2,0,'2022-10-21 15:09:17','2022-10-21 15:09:17');
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-28 18:37:51