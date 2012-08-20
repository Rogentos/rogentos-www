-- MySQL dump 10.13  Distrib 5.5.24, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: rogentos.ro
-- ------------------------------------------------------
-- Server version	5.5.24-5-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ITEMS`
--

DROP TABLE IF EXISTS `ITEMS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ITEMS` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `type` char(40) NOT NULL,
  `name_ro` text NOT NULL,
  `name_en` text NOT NULL,
  `new` char(3) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ITEMS`
--

LOCK TABLES `ITEMS` WRITE;
/*!40000 ALTER TABLE `ITEMS` DISABLE KEYS */;
INSERT INTO `ITEMS` VALUES (1,'single','Acasa','Home','',NULL),(2,'single','Despre','Despre','',NULL),(3,'single','Descarca','Descarca','',NULL),(4,'webchat','Webchat','Webchat','',NULL),(5,'contact','Contact','Contact','',NULL),(6,'single','Bugs','Implica-te','',NULL),(7,'single','Galerie','Galerie','',NULL);
/*!40000 ALTER TABLE `ITEMS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MENUS`
--

DROP TABLE IF EXISTS `MENUS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MENUS` (
  `id` int(3) NOT NULL,
  `idM` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MENUS`
--

LOCK TABLES `MENUS` WRITE;
/*!40000 ALTER TABLE `MENUS` DISABLE KEYS */;
INSERT INTO `MENUS` VALUES (1,1),(2,1),(3,1),(6,1),(4,1),(5,1);
/*!40000 ALTER TABLE `MENUS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TREE`
--

DROP TABLE IF EXISTS `TREE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TREE` (
  `Pid` int(3) NOT NULL,
  `Cid` int(3) NOT NULL,
  `poz` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TREE`
--

LOCK TABLES `TREE` WRITE;
/*!40000 ALTER TABLE `TREE` DISABLE KEYS */;
INSERT INTO `TREE` VALUES (0,1,0),(0,2,1),(0,3,2),(0,6,3),(0,4,4),(0,5,5);
/*!40000 ALTER TABLE `TREE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uid` int(5) NOT NULL AUTO_INCREMENT,
  `username` char(30) DEFAULT NULL,
  `user_rfirst` char(25) DEFAULT NULL,
  `user_rlast` char(30) DEFAULT NULL,
  `dept` char(100) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `level` char(1) DEFAULT NULL,
  `lastlogin` char(10) DEFAULT NULL,
  `lastip` char(15) DEFAULT '0.0.0.0',
  `lastbrowser` char(255) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'root','Site','Admin',NULL,'victor@debian.org.ro','1',NULL,'0.0.0.0',NULL,'66ffddb43dd2f31df590e2dea33c74ae');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `view_TREE`
--

DROP TABLE IF EXISTS `view_TREE`;
/*!50001 DROP VIEW IF EXISTS `view_TREE`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_TREE` (
  `Pid` int(3),
  `Cid` int(3),
  `type` char(40),
  `name_ro` text,
  `name_en` text,
  `poz` int(2),
  `new` char(3)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_TREE`
--

/*!50001 DROP TABLE IF EXISTS `view_TREE`*/;
/*!50001 DROP VIEW IF EXISTS `view_TREE`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_TREE` AS select `TREE`.`Pid` AS `Pid`,`TREE`.`Cid` AS `Cid`,`ITEMS`.`type` AS `type`,`ITEMS`.`name_ro` AS `name_ro`,`ITEMS`.`name_en` AS `name_en`,`TREE`.`poz` AS `poz`,`ITEMS`.`new` AS `new` from (`TREE` join `ITEMS` on((`TREE`.`Cid` = `ITEMS`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-08-21  0:26:49
