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
-- Table structure for table `temp_users`
--

DROP TABLE IF EXISTS `temp_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `temp_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `salt` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `wallet_address` varchar(42) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin DEFAULT NULL,
  `activation_token` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_bin NOT NULL,
  `expires_in` datetime NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_users`
--

LOCK TABLES `temp_users` WRITE;
/*!40000 ALTER TABLE `temp_users` DISABLE KEYS */;
INSERT INTO `temp_users` VALUES (1,'ogata@un-t.com','f5ec69909054263d832b01e05f6b5d4994a7fac86953081e7b69f97d04485ecd','bdd6285d84a12d0703c10b56','昌典','大形','ogata','','29ee18b5-1f0a-4d40-b883-fff79743b800','2022-09-26 17:30:40',1,0,'2022-09-26 16:30:40','2022-09-26 16:56:16'),(2,'twatanabe@un-t.com','37679bd76fd04c75335e6da9babe2d780418938b269f8aa852f4e20388911189','82c980b843bc40fdd901a6de','透也','渡邊','twatanabe','','782ce4ca-fe44-46ae-a93a-44c952ac0350','2022-09-26 19:11:28',0,0,'2022-09-26 18:11:28','2022-09-26 18:11:28'),(3,'t-watanabe@un-t.com','fc908a9dba74a0f234d866ddadbe3a0dbe1e1e5a7fe25a179a98fdb555638102','bfc2b6d2896090cb36610115','透也','渡邊','twatanabe','','7b6846b4-15fa-4941-8d00-8a26331f9a99','2022-09-26 19:12:59',1,0,'2022-09-26 18:12:59','2022-09-26 18:32:18'),(4,'t-yoshikawa1111@un-t.com','09584bff172c866d0ae37702f3fb545c175ad85bf772678b43afc33cd95c0727','e9d213c728c1ca0a877ddf25','aaaaa','aaaaa','aaaaa','1qaz2wsx','21bc6193-4850-4b15-bc27-a910d15f5e1a','2022-09-26 20:03:02',0,0,'2022-09-26 19:03:02','2022-09-26 19:03:02'),(5,'tyoshikawa.unt@gmail.com','9261bd0d960f68d550f136ce88e5bd6580c18f84521e48f848b49983a367de9e','f4c39eb042e1e6610131b81c','卓倫','吉川','よしかわ','','8b231845-20cc-4684-aaff-b652092797e8','2022-09-26 20:16:09',0,0,'2022-09-26 19:16:09','2022-09-26 19:16:09'),(6,'tyoshikawa.unt@gmail.com','6bbf85ab82bad88a7bb9b981817525973d306437c9d4178da7812a55bc36b3d0','5eb8fa478e6db10faba066ae','卓倫','吉川','よしかわ','','847e0d2e-28ba-4ab5-b588-68c44e62647d','2022-09-27 13:37:14',1,0,'2022-09-27 09:37:14','2022-09-27 12:25:03'),(7,'tyoshikawa.unt@gmail.com','6f07fbb7e1ecbd4a36e81c60ed49dca8f836a752dc02bd674e8ec4a117c0da53','e05d2bf558eade131a06cb4e','卓倫','吉川','よしかわ','','00db7306-2850-4229-b0a2-02dad6eaef3c','2022-09-27 11:09:05',0,0,'2022-09-27 10:09:05','2022-09-27 10:09:05'),(8,'tyoshikawa.unt@gmail.com','0c6d5698c07862980a11b4e83c7e74c462e46ee04ba8ea0579d9e68b0a44a665','721b310af32cb77a48170e5b','卓倫','吉川','よしかわ','','fc2641b6-9b8c-4bfb-90ed-c6d7bd3b43e6','2022-09-27 11:09:44',0,0,'2022-09-27 10:09:44','2022-09-27 10:09:44'),(9,'tyoshikawa.unt@gmail.com','9469626cddb79b46aa4548bd25a63a6d00a19653a8103059a95b2a14aec18aec','04af459cc9f97d306745f7e0','卓倫','吉川','よしかわ','','72dced27-5214-408f-9623-ef4769dda5cf','2022-09-27 11:16:56',0,0,'2022-09-27 10:16:56','2022-09-27 10:16:56'),(10,'tyoshikawa.unt@gmail.com','24ce80850f626e8e2e4e0e6128eed978aaea0da37e0bef5429d053e11895d06c','c0fed59cbd13be9d3284d53e','卓倫','吉川','aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa','','411ecade-563a-4a5c-832a-97bee3486220','2022-09-27 13:23:20',0,0,'2022-09-27 10:23:20','2022-09-27 12:26:18'),(11,'tyoshikawa+0002@gmail.com','6a50a27dce07cc634292bdfc7b74199061076bf5c2ff668004b60c68f4fc4505','c885087bed42d468d696dabc','卓倫','吉川','よしかわ','','c06c6807-f822-43c0-ab1c-307e23e6c51f','2022-10-03 14:58:50',0,0,'2022-10-03 13:58:50','2022-10-03 13:58:50'),(12,'tyoshikawa.unt+0002@gmail.com','c32ab181fb44a11c4bbf15587b3a0a9b9b483fade0f96402af87ec45e4fecf1d','7fb2b274c1d478ea17a7c89b','卓倫','吉川','よしかわ','','82e01034-f697-4075-b90a-6ea3129c6644','2022-10-03 16:12:06',0,0,'2022-10-03 15:12:06','2022-10-03 15:12:06'),(13,'tyoshikawa.unt+0003@gmail.com','4d04b099a89782a933e77016031b0dd4d7186c5bddc374ded55c0e42d466806b','86ba7454388b11aca3952bd6','卓倫','吉川','よしかわ','','a7e04b4e-dbcc-4a3c-89ea-1a4d15603e6c','2022-10-03 18:08:48',0,0,'2022-10-03 17:08:48','2022-10-03 17:08:48'),(14,'unt.ogata@gmail.com','728cbbd6f47eb4354acaf57dea2ab110ffa7ce64d1e068548d894c41d1defa2a','23bc6b8016cfcb11e7742cab','test','test','aaa','','b1cc9571-1585-4ab7-9180-ef76ef2e261a','2022-10-03 18:11:44',0,0,'2022-10-03 17:11:44','2022-10-03 17:11:44'),(15,'yamanaka@un-t.com','5c8dce45391601c6936d605f7abb96392a59b8d8be7a39dc813b3eb0bcaad3c2','b61b58ea715670371586927d','y','dev','dev_y','','c439dd72-c234-4bf9-a0a2-eb1d29336ba4','2022-10-03 18:18:19',1,0,'2022-10-03 17:18:19','2022-10-03 17:19:44'),(16,'twatanabe.unt@gmail.com','72bc5499b0b4d3f6ef0fce8e96de4f80e1a30fdd8b3fcbbe3ede4c2e43401afc','91004c96e008860c70610045','touya','watanabe','nickname','','ea40b146-b3b1-4b46-b0f6-74644ac182d6','2022-10-03 18:49:15',0,0,'2022-10-03 17:49:15','2022-10-03 17:49:15'),(17,'tyoshikawa.unt+0001@gmail.com','cffba40107757a45e865e222a8dfe3c9739255df506a1b277b907aab6deca3f1','039da81323ae6eaa4d08cab4','卓倫','吉川','よしかわ','','11815bfd-4dfd-4a8f-a1bd-6dcbe844a7cc','2022-10-05 15:37:23',0,0,'2022-10-05 14:37:23','2022-10-05 14:37:23'),(18,'tyoshikawa.unt+0001@gmail.com','487c942deecb682becf21e628db8be373523ee4af0377c780dfa2d13fb574ee8','01507c96dd28ffce83c91f09','卓倫','吉川','よしかわ','','891d67fb-b5f0-4e42-8484-29ed6857dcf4','2022-10-05 15:40:56',0,0,'2022-10-05 14:40:56','2022-10-05 14:40:56'),(19,'twatanabe.unt@gmail.com','9d80648d0c9fd6a960aed1a43e6349968b29df3aa6c11718d8d274562158d9d6','88447457d6add861329ff3c0','dadsa','ssss','sssss','','d315618b-60ae-4977-a53e-6b6729dfca29','2022-10-06 13:18:27',0,0,'2022-10-06 12:18:27','2022-10-06 12:18:27'),(20,'twatanabe.unt@gmail.com','d9ed64117d111c173754ccbc1220e5f2c948b35aa254596a7ce88a647cbddc28','e1db52116970a1536ca7d966','touya','watanabe',' twatnabe','0xssssssssssssssssssssssssssssssssssssssdd','570a7634-4cad-40b9-bfa6-ade5f3513bcb','2022-10-06 14:49:20',0,0,'2022-10-06 13:49:20','2022-10-06 13:49:20'),(22,'twatanabe.unt@gmail.com','9cc9ce38bf3ea139ef4b23e9392f31bc0950a92d7f515bc1911ca7e2175df4b8','9ee66549200a52c928822fd7','touya','watanabe','twatanabe','0x0000000000000000000000000000000000000000','fc8cb356-5c3b-42b2-856f-811b6d48f316','2022-10-06 15:10:40',0,0,'2022-10-06 14:10:40','2022-10-06 14:10:40'),(24,'twatanabe.unt@gmail.com','dc4f6f43ccacf343f0ff3a7e53c0f9db06f07a954fabdae7a47e6bca674f8369','57986d471089ec1eeac51a54','透也','渡邊','twatanabe','','40107bf7-0a0f-4545-9129-cd537838661e','2022-10-13 11:21:20',0,0,'2022-10-13 10:21:20','2022-10-13 10:21:20'),(29,'twatanabe.unt@gmail.com','c4e6f6ae12fb0938a9d5ecc769543fef4313103efb5326cea11456d6c4bf4d45','d4c842aef998ecf2c8fd04d4','透也','渡邊','ddd','','f0cf6127-ff7f-425b-834d-097d29e3df64','2022-10-13 11:24:11',0,0,'2022-10-13 10:24:11','2022-10-13 10:24:11'),(30,'twatanabe.unt@gmail.com','00fea9262416fcbc89da7fdbeadba3ea1e05d6e2ce3b967069b9a274d0fbd5b5','df4e6fa8d8d2e2484230d6f4','透也','渡邊','nickname','','f5963527-7274-40b3-ab6f-c5343305a84d','2022-10-13 11:24:59',0,0,'2022-10-13 10:24:59','2022-10-13 10:24:59'),(31,'twatanabe.unt@gmail.com','6338f311e9ccebbe9fe8e77c445431f09ad02d1c47c16c25257b60a4e868560a','49ebd52d803d0cfaea3b3b36','透也','渡邊','nickname','','2bdd025d-9ace-44e1-badd-1a633e01fdb3','2022-10-13 11:26:22',0,0,'2022-10-13 10:26:22','2022-10-13 10:26:22'),(32,'twatanabe.unt@gmail.com','c74b0aedf06ea618fe6d1e2a4e434d28df68c8f4e3be302926a23bcf32a16f67','9efe4f364e6bd026a4cccf09','透也','渡邊','nickname','','cdd459d6-27f5-460f-8ed9-cad574f65957','2022-10-13 11:27:01',0,0,'2022-10-13 10:27:01','2022-10-13 10:27:01'),(33,'twatanabe.unt@gmail.com','7bfe0abe8ffcb5b66fb53dc9b1063fa350eec64598459ad97c4cb941fde49ab2','b6ada5fd66d1c7dece7056a8','透也','渡邊','nickname','','48062317-800f-4158-8468-08e56050710b','2022-10-13 11:39:55',0,0,'2022-10-13 10:39:55','2022-10-13 10:39:55'),(34,'twatanabe.unt@gmail.com','ddb13251cda0aedba86cf485cbfacd350cb0ffc7203a69c00b45b7834555b362','320e77a88566ed7c469c73a5','touya','watanabe','nickname','','cebf0b7b-d23d-4b11-a252-994720c87315','2022-10-13 11:40:36',0,0,'2022-10-13 10:40:36','2022-10-13 10:40:36'),(35,'twatanabe.unt@gmail.com','456bc7e4a07e07f35bd6c7c6172c798b7fac22bbe5cb23000953ab4bbd5d050a','4212d03f563e65dfd8193062','透也','渡邊','nickname','','1197177d-b2a6-4820-b104-3cddb9ac7a28','2022-10-13 11:41:27',0,0,'2022-10-13 10:41:27','2022-10-13 10:41:27'),(36,'twatanabe.unt@gmail.com','6bb8e65e61098aa6926874d42bc73ba7225bcf79a2642b236fac4f27337498bf','daa526ca34c590f89d876bf8','透也','渡邊','nickname','','f9f54fa4-da57-4637-b420-436877c0211f','2022-10-13 12:07:46',0,0,'2022-10-13 11:07:46','2022-10-13 11:07:46'),(37,'twatanabe.unt@gmail.com','d23b2347178ac3a67905f7bb0c5bd7801f3ac1a89c02b3c1cf8e52d85b5fdd50','1e3a0bf4c9599a40173e5a83','透也','渡邊','nickname','','21f5ade2-dc4e-476b-bfca-60aaeec0bda7','2022-10-13 12:09:30',0,0,'2022-10-13 11:09:30','2022-10-13 11:09:30'),(38,'tooiea1113@gmail.com','535add9659fd887bc63204afb960ed58d274d8ce5bda0fc6e7e49c0dbe4c0281','aadd339b373d450d5fda54be','namef','watanabe','twatnabe','','989846ae-1af8-4a4f-8eb0-a84aebdc1c51','2022-10-13 12:41:16',0,0,'2022-10-13 11:41:16','2022-10-13 11:41:16'),(39,'twatanabe.unt@gmail.com','0453da2f1c4f1f4ea1f91d2b14bb1001e0b73ba7221f8148690322d64639f2c9','21e669dc2015db76114216c4','透也','渡邊','nickname','','d65e7f63-d657-42fc-8881-f1377fb4ce4b','2022-10-13 12:50:53',0,0,'2022-10-13 11:50:53','2022-10-13 11:50:53'),(40,'twatanabe.unt@gmail.com','ce5bf56150663a8fbf02118597323f465725bdc6fc89619cc896f194823d0cba','a01a6b1438e6ac5dda7011f0','透也','渡邊','nickname','','f929f7ae-98f8-454d-9018-3d0b40ec66b4','2022-10-13 12:59:23',0,0,'2022-10-13 11:59:23','2022-10-13 11:59:23');
/*!40000 ALTER TABLE `temp_users` ENABLE KEYS */;
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
