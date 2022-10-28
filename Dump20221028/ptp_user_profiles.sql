-- MySQL dump 10.13  Distrib 8.0.28, for macos11 (x86_64)
--
-- Host: localhost    Database: ptp
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
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `first_name_kana` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin DEFAULT NULL,
  `last_name_kana` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin DEFAULT NULL,
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `icon_image_name` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin DEFAULT NULL,
  `icon_image_extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin DEFAULT NULL,
  `gender_mst_id` bigint unsigned DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `wallet_address` varchar(42) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_profiles_uq_4` (`user_id`),
  UNIQUE KEY `user_profiles_uq_2` (`icon_image_name`),
  UNIQUE KEY `user_profiles_uq_3` (`wallet_address`),
  KEY `user_profiles_ibfk_2` (`gender_mst_id`),
  CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `user_profiles_ibfk_2` FOREIGN KEY (`gender_mst_id`) REFERENCES `ptp_jleague`.`gender_mst` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profiles`
--

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
INSERT INTO `user_profiles` VALUES (1,1,'Dev','Y','','','Y_dev',NULL,NULL,1,'1981-06-06',NULL,0,'2022-10-14 18:55:27','2022-10-15 11:21:25'),(2,2,'akihiuro','hoshiyama','','','hoshi',NULL,NULL,3,'1923-10-11',NULL,0,'2022-10-14 18:56:06','2022-10-15 06:12:51'),(3,3,'tsuyoshi','yoshida','','','tsuyoshida',NULL,NULL,NULL,NULL,'0x940B9cC753f48621a90CA8befe3EEb0b51fBb382',0,'2022-10-14 18:56:57','2022-10-15 02:57:49'),(4,4,'将史','川藤',NULL,NULL,'kawafujimasashi',NULL,NULL,NULL,NULL,NULL,0,'2022-10-14 18:58:56','2022-10-14 18:58:56'),(5,5,'しんのすけ','なかむら',NULL,NULL,'なかしん',NULL,NULL,1,NULL,NULL,0,'2022-10-14 18:59:11','2022-10-28 15:46:26'),(6,6,'','',NULL,NULL,'つよしだ',NULL,NULL,NULL,NULL,NULL,0,'2022-10-14 20:01:23','2022-10-14 20:01:23'),(7,7,'ほげほげ','ほげほげ','','','ニック',NULL,NULL,3,'1935-07-25',NULL,0,'2022-10-14 20:11:33','2022-10-14 21:08:14'),(8,8,'らい','ららら','ウエダ','ユウキ','マサカリ金太郎',NULL,NULL,1,'1982-10-12','0x01f718da2b032B45948301739E410dBA8ba7bD15',0,'2022-10-14 21:15:31','2022-10-14 21:43:46'),(9,9,'','',NULL,NULL,'山中 友尋',NULL,NULL,NULL,NULL,NULL,0,'2022-10-14 22:03:44','2022-10-14 22:03:44'),(10,10,'ユウキ','ウエダ','有輝','ウエダ','オッケーボクシング',NULL,NULL,1,'1929-08-10',NULL,0,'2022-10-14 22:29:47','2022-10-14 22:30:53'),(11,11,'','',NULL,NULL,'とーや',NULL,NULL,NULL,NULL,NULL,0,'2022-10-15 09:52:40','2022-10-15 09:52:40'),(12,12,'渡邊','透也','watanabe_en','touya_en','t-watanabe',NULL,NULL,1,'1990-11-13','',0,'2022-10-15 09:59:06','2022-10-16 11:30:23'),(13,13,'槇之介','中村',NULL,NULL,'なかしん2',NULL,NULL,NULL,NULL,NULL,0,'2022-10-15 10:38:12','2022-10-15 10:38:12'),(14,14,'幸子','本望',NULL,NULL,'テストほんもー',NULL,NULL,NULL,NULL,NULL,0,'2022-10-15 11:55:40','2022-10-15 11:55:40'),(15,15,'テストテスト','テスト',NULL,NULL,'てすとっと',NULL,NULL,NULL,NULL,NULL,0,'2022-10-15 11:56:06','2022-10-15 11:56:06'),(16,16,'将史','川藤',NULL,NULL,'kawafujimasashi',NULL,NULL,NULL,NULL,'0x4ECc18725345d3909dCC5199508d3BC2CC257754',0,'2022-10-15 14:56:37','2022-10-16 16:34:11'),(17,17,'卓倫','吉川','','','よしかわ',NULL,NULL,NULL,NULL,'0x5e58e2Ad7Bba3Ac7470e8403FF8143F6fff028E2',0,'2022-10-15 17:56:19','2022-10-16 12:26:22'),(18,18,'watanabe','touya','watanabe_en','touya_en','t-watanabe',NULL,NULL,2,'1993-10-11',NULL,0,'2022-10-15 18:13:11','2022-10-16 11:26:52'),(19,19,'touya','watanabe',NULL,NULL,'t-watanabe',NULL,NULL,NULL,NULL,NULL,0,'2022-10-15 18:14:33','2022-10-15 18:14:33'),(20,20,'','',NULL,NULL,'アンティー・システム',NULL,NULL,NULL,NULL,NULL,0,'2022-10-15 20:16:42','2022-10-15 20:16:42'),(21,21,'','',NULL,NULL,'星山 哲廣',NULL,NULL,NULL,NULL,NULL,0,'2022-10-16 08:30:24','2022-10-16 08:30:24');
/*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-28 18:37:47
