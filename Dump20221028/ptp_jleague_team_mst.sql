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
-- Table structure for table `team_mst`
--

DROP TABLE IF EXISTS `team_mst`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_mst` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `name_abbr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `name_en_abbr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `call_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `copyright` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `logo_image_name` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `logo_image_extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `display_order` int unsigned NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_mst_uq_1` (`name`,`name_en`),
  UNIQUE KEY `team_mst_uq_2` (`logo_image_name`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_mst`
--

LOCK TABLES `team_mst` WRITE;
/*!40000 ALTER TABLE `team_mst` DISABLE KEYS */;
INSERT INTO `team_mst` VALUES (1,'北海道コンサドーレ札幌','札幌','Hokkaido Consadole Sapporo','Sapporo','北海道コンサドーレ札幌','©︎1996 CONSADOLE','33ea3f21-6f21-46d2-bea9-da979d2d3b79','png',1,0,'2022-09-21 14:50:50','2022-10-06 14:08:12'),(2,'鹿島アントラーズ','鹿島','Kashima Antlers','Kashima','鹿島アントラーズ','©︎1992 KASHIMA ANTLERS FOOTBALL CLUB CO.,LTD.','c4e87358-8a00-41a3-9512-4795fb8edba9','png',2,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(3,'浦和レッドダイヤモンズ','浦和','Urawa Reds','Urawa','浦和レッズ','©︎2001 URAWA RED DIAMONDS','b4011502-cb9c-4c9b-b72c-3110de6dc72c','png',3,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(4,'柏レイソル','柏','Kashiwa Reysol','Kashiwa','柏レイソル','©︎1996 .H.K.REYSOL','676065ca-2f14-46e2-b25f-407f1ed4eece','png',4,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(5,'ＦＣ東京','FC東京','F.C.Tokyo','FC-Tokyo','ＦＣ東京','©︎F.C.TOKYO','799e6295-90a8-4ea9-8a6d-f55f0493ffb7','png',5,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(6,'川崎フロンターレ','川崎Ｆ','Kawasaki Frontale','Kawasaki-F','川崎フロンターレ','©︎KAWASAKI FRONTALE','1ae2e840-9c3e-42a2-8e0c-5e8ad066fc36','png',6,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(7,'横浜Ｆ・マリノス','横浜FM','Yokohama F･Marinos','Yokohama F･M','横浜Ｆ・マリノス','©︎1992 Y.MARINOS','632f0549-3fda-473c-b5c6-e3054b4a6e44','png',7,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(8,'湘南ベルマーレ','湘南','Shonan Bellmare','Shonan','湘南ベルマーレ','©︎1993 SHONAN BELLMARE CO.,LTD.','39912a6e-3a4f-4c37-ae94-2a80648d6588','png',8,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(9,'清水エスパルス','清水','Shimizu S-Pulse','Shimizu','清水エスパルス','©︎S-PULSE','6842890e-8404-4171-9a67-24de2abdac7a','png',9,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(10,'ジュビロ磐田','磐田','Jubilo Iwata','Iwata','ジュビロ磐田','©︎2015 JUBILO','9a5560a3-0a54-4a6e-92b4-d20417c09e58','png',10,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(11,'名古屋グランパスエイト','名古屋','Nagoya Grampus','Nagoya','名古屋グランパス','©︎1995 NAGOYA GRAMPUS EIGHT INC.','2210601b-db7d-4469-91fb-3ed2cca8124d','png',11,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(12,'京都サンガF.C.','京都','Kyoto Sanga F.C.','Kyoto','京都サンガF.C.','©︎2006 KYOTO PURPLE SANGA CO.,LTD.','2f9932c2-1f80-4c99-a13b-8ead6bdcb177','png',12,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(13,'ガンバ大阪','Ｇ大阪','Gamba Osaka','G-Osaka','ガンバ大阪','©︎2022 GAMBA OSAKA CO.,LTD.','f98bef28-075a-482a-94d2-cbf729367fc5','png',13,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(14,'セレッソ大阪','Ｃ大阪','Cerezo Osaka','C-Osaka','セレッソ大阪','©︎2018 CEREZO OSAKA CO.,LTD.','e3a0e1c6-122d-4d90-a200-8d73d615fda6','png',14,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(15,'ヴィッセル神戸','神戸','Vissel Kobe','Kobe','ヴィッセル神戸','©︎2005 VISSEL KOBE','32d41305-4418-4475-9e1c-3390ad10b7ad','png',15,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(16,'サンフレッチェ広島Ｆ．Ｃ','広島','Sanfrecce Hiroshima','Hiroshima','サンフレッチェ広島','©︎1992 SANFRECCE HIROSHIMA CORPORATION','3e3df80e-4438-4632-8c50-86949cfbf9d3','png',16,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(17,'アビスパ福岡','福岡','Avispa Fukuoka','Fukuoka','アビスパ福岡','©︎1995 FUKUOKA BLUX CO.,LTD.','eec1813f-3372-4863-a577-d811ad968db8','png',17,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(18,'サガン鳥栖','鳥栖','Sagan Tosu','Tosu','サガン鳥栖','©︎2014 SAGAN DREAMS CO.,LTD.','80c73bb8-6700-440f-97cf-ccb31717f3d2','png',18,0,'2022-09-21 14:50:50','2022-09-21 14:50:50'),(19,'テストチーム','テストチーム略称','testteam','testteam_Abbreviation','テストチーム呼称','copy_right','832fb6d6-fa8e-4ffa-8fa7-36707f596f84','png',1,1,'2022-09-21 17:43:04','2022-09-21 17:55:05'),(20,'テストチーム2','テストチーム2_略称','test_team2','test_team2_Abbreviation','テストチーム2_呼称','copy_right2','04f9829d-19b6-4665-8e6c-90ef5b5c0bab','png',2,0,'2022-09-21 17:46:33','2022-09-21 17:46:33'),(21,'テストチーム3','テストチーム3_ 略称','test_team3','test_team3_Abbreviation','テストチーム3_ 呼称','copy_right3','aa39bbc4-bb9a-457b-8f35-c01c328c5d23','png',3,0,'2022-09-21 17:48:19','2022-09-27 16:50:00');
/*!40000 ALTER TABLE `team_mst` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-28 18:37:49
