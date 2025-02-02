-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: miniprojet
-- ------------------------------------------------------
-- Server version	8.4.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `abdel`
--

DROP TABLE IF EXISTS `abdel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `abdel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `friends` varchar(50) DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `users_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abdel`
--

LOCK TABLES `abdel` WRITE;
/*!40000 ALTER TABLE `abdel` DISABLE KEYS */;
INSERT INTO `abdel` VALUES (23,'denis',NULL,2);
/*!40000 ALTER TABLE `abdel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anis`
--

DROP TABLE IF EXISTS `anis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `friends` varchar(50) DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `users_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anis`
--

LOCK TABLES `anis` WRITE;
/*!40000 ALTER TABLE `anis` DISABLE KEYS */;
/*!40000 ALTER TABLE `anis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cali`
--

DROP TABLE IF EXISTS `cali`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cali` (
  `id` int NOT NULL AUTO_INCREMENT,
  `friends` varchar(50) DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `users_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cali`
--

LOCK TABLES `cali` WRITE;
/*!40000 ALTER TABLE `cali` DISABLE KEYS */;
INSERT INTO `cali` VALUES (6,'toufik',NULL,3),(9,'anis',NULL,6);
/*!40000 ALTER TABLE `cali` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `denis`
--

DROP TABLE IF EXISTS `denis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `denis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `friends` varchar(50) DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `users_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `denis`
--

LOCK TABLES `denis` WRITE;
/*!40000 ALTER TABLE `denis` DISABLE KEYS */;
INSERT INTO `denis` VALUES (19,'abdel',NULL,5),(20,'anis',NULL,6),(21,'toufik',NULL,3),(22,'cali',NULL,4);
/*!40000 ALTER TABLE `denis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` int DEFAULT NULL,
  `message` varchar(100) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,2,'Test 1 PDO !','denis'),(2,3,'Test 2 HELLLO','toufik'),(3,5,'Test 3 !!!!!!!!!!!!!!!!!!!!!!!!!!','abdel');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_like`
--

DROP TABLE IF EXISTS `post_like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_like` (
  `users_id` int DEFAULT NULL,
  `post_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_like`
--

LOCK TABLES `post_like` WRITE;
/*!40000 ALTER TABLE `post_like` DISABLE KEYS */;
INSERT INTO `post_like` VALUES (3,1),(5,2),(5,1),(4,1),(4,3),(4,2),(2,3);
/*!40000 ALTER TABLE `post_like` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `toufik`
--

DROP TABLE IF EXISTS `toufik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `toufik` (
  `id` int NOT NULL AUTO_INCREMENT,
  `friends` varchar(50) DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `users_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `toufik`
--

LOCK TABLES `toufik` WRITE;
/*!40000 ALTER TABLE `toufik` DISABLE KEYS */;
/*!40000 ALTER TABLE `toufik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin',NULL),(2,'denis','$2y$10$ujP3lYsC5pJVr9BLKNY1A.E91HRFEdgWwO3VsbzpzVQjo4PBRoC92','denis@mail.com'),(3,'toufik','$2y$10$a0ZnACH8NEBV7Xrd45YzEOz26WDGgxRCdXrRcCkoLr6IXYuu5cSs2','toufik@mail.com'),(4,'cali','$2y$10$kyPc/P0R2q7ll6Oa4R97yeDMwGRAAz7GuyXAQJLrWdWTcqs425qFa','cali@mail.com'),(5,'abdel','$2y$10$g2zfnpE14K/ovonaUgLMl.D/Uc5urWLcR0c0/grnp2fPzxlIB/Ia6','abdel@mail.com'),(6,'anis','$2y$10$YdkDnCW3wGt5Gh9l5hgo8OzS4ryYGehD3skReIzUJWzhzr4RTTkde','anis@mail.com');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-29 13:59:46
