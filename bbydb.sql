-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: babycaresystem
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `babies`
--

DROP TABLE IF EXISTS `babies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `babies` (
  `baby_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `mother_id` int DEFAULT NULL,
  PRIMARY KEY (`baby_id`),
  KEY `mother_id` (`mother_id`),
  CONSTRAINT `babies_ibfk_1` FOREIGN KEY (`mother_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `babies`
--

LOCK TABLES `babies` WRITE;
/*!40000 ALTER TABLE `babies` DISABLE KEYS */;
INSERT INTO `babies` VALUES (5,'test','2025-03-01','Male',2);
/*!40000 ALTER TABLE `babies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificates`
--

DROP TABLE IF EXISTS `certificates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certificates` (
  `certificate_id` int NOT NULL AUTO_INCREMENT,
  `record_id` int DEFAULT NULL,
  `issued_date` date NOT NULL,
  PRIMARY KEY (`certificate_id`),
  KEY `record_id` (`record_id`),
  CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `vaccinationrecords` (`record_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificates`
--

LOCK TABLES `certificates` WRITE;
/*!40000 ALTER TABLE `certificates` DISABLE KEYS */;
/*!40000 ALTER TABLE `certificates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`notification_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `user_type` enum('Midwife','Mother') NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'default.png',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Kavindu','admin@gmail.com','$2y$10$kih/EHxaKfAuSDj4DWBPSOuXR1FWRskwk9cgoZ4d/XNoByn1iFSCe','1234567890','Midwife','uploads/1741770053_Jett Valorant.png'),(2,'Kavindu','admin1@gmail.com','$2y$10$P5Cu1Om2AAzrpf6ZoKVLNO.nPdACHUoj8v/avNHVnkH9L.6S4mzcu',NULL,'Mother','uploads/default.png');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaccinationrecords`
--

DROP TABLE IF EXISTS `vaccinationrecords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vaccinationrecords` (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `baby_id` int DEFAULT NULL,
  `vaccine_id` int DEFAULT NULL,
  `vaccination_date` date DEFAULT NULL,
  `status` enum('Pending','Completed') DEFAULT 'Pending',
  `due_date` date DEFAULT NULL,
  PRIMARY KEY (`record_id`),
  KEY `baby_id` (`baby_id`),
  KEY `vaccine_id` (`vaccine_id`),
  CONSTRAINT `vaccinationrecords_ibfk_1` FOREIGN KEY (`baby_id`) REFERENCES `babies` (`baby_id`) ON DELETE CASCADE,
  CONSTRAINT `vaccinationrecords_ibfk_2` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccinations` (`vaccine_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaccinationrecords`
--

LOCK TABLES `vaccinationrecords` WRITE;
/*!40000 ALTER TABLE `vaccinationrecords` DISABLE KEYS */;
INSERT INTO `vaccinationrecords` VALUES (9,5,1,'2025-03-12','Completed','2025-03-01'),(10,5,2,'2025-06-19','Completed','2025-05-01'),(11,5,3,NULL,'Pending','2025-05-01'),(12,5,4,NULL,'Pending','2025-05-01'),(13,5,5,NULL,'Pending','2025-05-01'),(14,5,6,NULL,'Pending','2025-05-01'),(15,5,7,NULL,'Pending','2026-03-01'),(16,5,8,NULL,'Pending','2026-03-01');
/*!40000 ALTER TABLE `vaccinationrecords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaccinations`
--

DROP TABLE IF EXISTS `vaccinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vaccinations` (
  `vaccine_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `recommended_age` int NOT NULL COMMENT 'Age in months',
  `side_effects` text,
  PRIMARY KEY (`vaccine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaccinations`
--

LOCK TABLES `vaccinations` WRITE;
/*!40000 ALTER TABLE `vaccinations` DISABLE KEYS */;
INSERT INTO `vaccinations` VALUES (1,'Hepatitis B','Protects against Hepatitis B virus, given at birth and later doses.',0,'Mild fever, soreness at injection site'),(2,'Diphtheria, Tetanus, Pertussis (DTaP)','Prevents diphtheria, tetanus, and pertussis. Administered in multiple doses.',2,'Swelling, redness, mild fever'),(3,'Haemophilus influenzae type b (Hib)','Protects against Hib infections, which can cause meningitis and pneumonia.',2,'Fever, irritability, swelling at injection site'),(4,'Pneumococcal','Prevents pneumococcal diseases like pneumonia, meningitis, and sepsis.',2,'Mild fever, irritability, redness at injection site'),(5,'Polio','Protects against poliovirus, preventing paralysis and neurological complications.',2,'Redness at injection site, mild fever'),(6,'Rotavirus','Oral vaccine preventing rotavirus infections, which cause severe diarrhea.',2,'Mild diarrhea, irritability'),(7,'Measles, Mumps, Rubella (MMR)','Prevents measles, mumps, and rubella infections. First dose given at 12 months.',12,'Mild rash, fever, swelling in cheeks'),(8,'Chickenpox (Varicella)','Protects against chickenpox, reducing severity of symptoms.',12,'Mild rash, low-grade fever');
/*!40000 ALTER TABLE `vaccinations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-30 17:24:21
