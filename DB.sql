-- MySQL dump 10.13  Distrib 5.7.9, for osx10.9 (x86_64)
--
-- Host: localhost    Database: CMS-V2
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.14-MariaDB

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
-- Table structure for table `Articles`
--

DROP TABLE IF EXISTS `Articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Articles` (
  `idArticles` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `heading` text,
  `headingImage` varchar(255) DEFAULT NULL,
  `text` text,
  `link` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'hr',
  `published` tinyint(1) DEFAULT '0',
  `tags` varchar(150) DEFAULT NULL,
  `isDraft` tinyint(1) DEFAULT '1',
  `idTemplates` int(11) DEFAULT NULL,
  `idUsers` int(11) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `customFieldsValues` text,
  PRIMARY KEY (`idArticles`,`lang`) USING BTREE,
  UNIQUE KEY `ID` (`idArticles`,`lang`) USING BTREE,
  KEY `LINK` (`link`)
) ENGINE=MyISAM AUTO_INCREMENT=1766 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1292;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Articles`
--

LOCK TABLES `Articles` WRITE;
/*!40000 ALTER TABLE `Articles` DISABLE KEYS */;
INSERT INTO `Articles` VALUES (1765,NULL,NULL,NULL,NULL,NULL,'hr',0,NULL,1,NULL,NULL,'2016-02-25 08:51:36',NULL,NULL,NULL),(1765,NULL,NULL,NULL,NULL,NULL,'en',0,NULL,1,NULL,NULL,'2016-02-25 08:51:36',NULL,NULL,NULL),(1764,NULL,NULL,NULL,NULL,NULL,'en',0,NULL,1,NULL,NULL,'2016-02-25 08:51:17',NULL,NULL,NULL),(1763,NULL,NULL,NULL,NULL,NULL,'hr',0,NULL,1,NULL,NULL,'2016-02-25 08:50:41',NULL,NULL,NULL),(1760,'Another news','Lorem ipsum dolor simet es et simetues, Lorem ipsum dolor simet es et simetues',NULL,'','another-news','hr',1,'',0,1003,244,'2016-02-12 15:06:47',NULL,NULL,'{\"dodatno_polje\":\"\",\"dodatno_polje2\":\"\"}'),(1760,'Another news','',NULL,'','another-news-56bdf518688b0','en',1,'',0,1003,244,'2016-02-12 15:06:47',NULL,NULL,'{\"dodatno_polje\":\"\",\"dodatno_polje2\":\"\"}'),(1761,'News news','Lorem ipsum dolor simet',NULL,'','news-news','hr',1,'',0,1003,244,'2016-02-12 15:07:10',NULL,NULL,'{\"dodatno_polje\":\"\",\"dodatno_polje2\":\"\"}'),(1761,'News news','',NULL,'','news-news-56bdf52453fe2','en',1,'',0,1003,244,'2016-02-12 15:07:10',NULL,NULL,'{\"dodatno_polje\":\"\",\"dodatno_polje2\":\"\"}'),(1763,NULL,NULL,NULL,NULL,NULL,'en',0,NULL,1,NULL,NULL,'2016-02-25 08:50:41',NULL,NULL,NULL),(1764,NULL,NULL,NULL,NULL,NULL,'hr',0,NULL,1,NULL,NULL,'2016-02-25 08:51:17',NULL,NULL,NULL),(1762,'Test 123','',NULL,'','test-123','hr',1,'reherherh,qwfqwf,Ozren Putarek,Marko Markič,wegweg,wegwegweg,wegwegwegweg wegwegwegweg,Marko Markić',0,1003,244,'2016-02-25 08:35:27',NULL,NULL,'{\"dodatno_polje\":\"\",\"dodatno_polje2\":\"\"}'),(1762,'','',NULL,'','-56cecd79e2c3b','en',1,'',0,1003,244,'2016-02-25 08:35:27',NULL,NULL,'');
/*!40000 ALTER TABLE `Articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Articles_Pages`
--

DROP TABLE IF EXISTS `Articles_Pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Articles_Pages` (
  `idArticles_Pages` int(11) NOT NULL AUTO_INCREMENT,
  `idArticles` int(11) DEFAULT NULL,
  `idPages` int(11) DEFAULT NULL,
  `mainKategory` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idArticles_Pages`) USING BTREE,
  UNIQUE KEY `ID` (`idArticles_Pages`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2053 DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=13 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Articles_Pages`
--

LOCK TABLES `Articles_Pages` WRITE;
/*!40000 ALTER TABLE `Articles_Pages` DISABLE KEYS */;
INSERT INTO `Articles_Pages` VALUES (2041,1760,23,1),(2040,1758,23,1),(2043,1761,23,1),(2052,1762,23,1);
/*!40000 ALTER TABLE `Articles_Pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CmsMenus`
--

DROP TABLE IF EXISTS `CmsMenus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CmsMenus` (
  `idCMSMenus` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_dor` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `link` varchar(45) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '1',
  `rbr` int(11) DEFAULT '0',
  PRIMARY KEY (`idCMSMenus`),
  UNIQUE KEY `ID_UNIQUE` (`idCMSMenus`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CmsMenus`
--

LOCK TABLES `CmsMenus` WRITE;
/*!40000 ALTER TABLE `CmsMenus` DISABLE KEYS */;
INSERT INTO `CmsMenus` VALUES (1,0,'Web','pages',1,1),(2,0,'Users','klijenti',1,2),(3,0,'News','usluge',1,3),(4,0,'Accomodation objects','lokacije',1,4),(5,0,'Events','eventi',1,5),(6,0,'Galleries','galerije',1,6),(7,0,'Video Library','videos',0,0),(8,0,'Settings','settings',1,7),(9,8,'Logout','logout',1,0),(10,0,'Dashboard','home',1,0);
/*!40000 ALTER TABLE `CmsMenus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Events`
--

DROP TABLE IF EXISTS `Events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Events` (
  `idEvents` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `heading` text,
  `headingImage` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `linkOriginal` varchar(255) DEFAULT NULL,
  `text` text,
  `tags` varchar(150) DEFAULT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'hr',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `isDraft` tinyint(1) DEFAULT '1',
  `idTemplates` int(11) DEFAULT NULL,
  `idUsers` int(11) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `customFieldsValues` text,
  `tel` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `priority` varchar(45) DEFAULT '0',
  PRIMARY KEY (`idEvents`,`lang`),
  KEY `IDDESC` (`idEvents`),
  KEY `test` (`idEvents`,`lang`,`published`),
  KEY `link` (`link`),
  KEY `linkOriginak` (`linkOriginal`),
  KEY `LangIsDraft` (`published`,`lang`,`isDraft`)
) ENGINE=MyISAM AUTO_INCREMENT=1000004737 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Events`
--

LOCK TABLES `Events` WRITE;
/*!40000 ALTER TABLE `Events` DISABLE KEYS */;
INSERT INTO `Events` VALUES (1000004735,'test','',NULL,'test',NULL,'',NULL,'hr',1,0,1004,244,'2016-03-31 07:58:34','{\"ticketField\":\"\"}','','','','0'),(1000004735,'','',NULL,'-56fcd8adaff39',NULL,'',NULL,'en',1,0,1004,244,'2016-03-31 07:58:34','','','','',''),(1000004736,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hr',1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0'),(1000004736,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0');
/*!40000 ALTER TABLE `Events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Events_Pages`
--

DROP TABLE IF EXISTS `Events_Pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Events_Pages` (
  `idEvents_Pages` int(11) NOT NULL AUTO_INCREMENT,
  `idEvents` int(11) DEFAULT NULL,
  `idPages` int(11) DEFAULT NULL,
  `isMainKategory` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idEvents_Pages`),
  KEY `EventKat` (`idEvents`,`idPages`)
) ENGINE=MyISAM AUTO_INCREMENT=101998 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Events_Pages`
--

LOCK TABLES `Events_Pages` WRITE;
/*!40000 ALTER TABLE `Events_Pages` DISABLE KEYS */;
INSERT INTO `Events_Pages` VALUES (101997,1000004735,0,NULL);
/*!40000 ALTER TABLE `Events_Pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Events_Places`
--

DROP TABLE IF EXISTS `Events_Places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Events_Places` (
  `idEvents_Places` int(11) NOT NULL AUTO_INCREMENT,
  `idEvents` int(11) DEFAULT NULL,
  `idPlaces` int(11) DEFAULT NULL,
  PRIMARY KEY (`idEvents_Places`),
  UNIQUE KEY `ID_UNIQUE` (`idEvents_Places`),
  KEY `EventID` (`idEvents`)
) ENGINE=MyISAM AUTO_INCREMENT=47867 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Events_Places`
--

LOCK TABLES `Events_Places` WRITE;
/*!40000 ALTER TABLE `Events_Places` DISABLE KEYS */;
/*!40000 ALTER TABLE `Events_Places` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ExecutionDates`
--

DROP TABLE IF EXISTS `ExecutionDates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ExecutionDates` (
  `idDates` int(11) NOT NULL AUTO_INCREMENT,
  `foreignID` int(11) DEFAULT NULL,
  `foreignType` int(11) DEFAULT NULL,
  `datum_od` datetime DEFAULT NULL,
  `datum_do` datetime DEFAULT NULL,
  PRIMARY KEY (`idDates`),
  KEY `foreignIDDatum` (`foreignID`,`foreignType`,`datum_od`,`datum_do`),
  KEY `samodatum` (`datum_od`)
) ENGINE=MyISAM AUTO_INCREMENT=459835 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ExecutionDates`
--

LOCK TABLES `ExecutionDates` WRITE;
/*!40000 ALTER TABLE `ExecutionDates` DISABLE KEYS */;
INSERT INTO `ExecutionDates` VALUES (459622,1756,1,'2016-02-04 16:06:26',NULL),(459623,1757,1,'2016-02-04 16:08:10',NULL),(459624,4105,3,'2016-02-04 16:08:21',NULL),(459633,1758,1,'2016-02-04 16:09:32',NULL),(459637,4106,3,'2016-02-04 16:09:50',NULL),(459634,1760,1,'2016-02-04 16:09:32',NULL),(459636,1761,1,'2016-02-12 04:07:10',NULL),(459638,4108,3,'2016-02-25 09:29:51',NULL),(459659,4109,3,'2016-02-25 09:32:40',NULL),(459662,1762,1,'2016-02-24 09:35:27',NULL),(459660,4110,3,'2016-02-25 09:37:02',NULL),(459661,4119,3,'2016-02-25 10:38:24',NULL),(459657,4120,3,'2016-02-25 10:38:56',NULL),(459664,4121,3,'2016-02-25 10:39:17',NULL),(459696,4128,3,'2016-03-02 09:17:56',NULL),(459681,4129,3,'2016-03-02 12:18:40',NULL),(459680,4130,3,'2016-03-02 13:16:08',NULL),(459679,4131,3,'2016-03-02 13:16:22',NULL),(459682,4132,3,'2016-03-02 13:17:09',NULL),(459694,4133,3,'2016-03-02 15:50:14',NULL),(459691,4135,3,'2016-03-07 15:17:42',NULL),(459692,4136,3,'2016-03-08 14:34:45',NULL),(459695,4138,3,'2016-03-09 09:26:41',NULL),(459698,4139,3,'2016-03-23 11:06:07',NULL),(459699,4142,3,'2016-03-29 12:48:30',NULL),(459700,4144,3,'2016-03-29 13:07:52',NULL),(459701,4147,3,'2016-03-29 14:07:59',NULL),(459833,4154,3,'2016-04-05 12:07:37',NULL),(459832,4153,3,'2016-04-05 12:07:30',NULL),(459830,4150,3,'2016-04-16 00:00:00',NULL),(459707,1000004735,4,'2016-03-31 09:58:35',NULL),(459834,4155,3,'2016-04-05 12:07:44',NULL),(459714,4156,3,'2016-04-05 14:08:46',NULL),(459715,4157,3,'2016-04-05 14:08:59',NULL),(459721,4159,3,'2016-04-12 11:37:28',NULL),(459827,4150,3,'2016-04-23 00:00:00',NULL),(459826,4150,3,'2016-04-13 00:00:00',NULL),(459825,4150,3,'2016-04-12 00:00:00',NULL),(459824,4150,3,'2016-03-29 14:18:21',NULL),(459828,4150,3,'2016-04-14 00:00:00',NULL),(459829,4150,3,'2016-04-15 00:00:00',NULL),(459831,4150,3,'2016-04-30 00:00:00',NULL);
/*!40000 ALTER TABLE `ExecutionDates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Galleries`
--

DROP TABLE IF EXISTS `Galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Galleries` (
  `idGalleries` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `heading` text,
  `headingImage` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `description` text,
  `lang` varchar(2) NOT NULL DEFAULT 'hr',
  `published` tinyint(1) DEFAULT '1',
  `isDraft` tinyint(1) DEFAULT '1',
  `idTemplates` int(11) DEFAULT NULL,
  `idUsers` int(11) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `customFieldsValues` text,
  PRIMARY KEY (`idGalleries`,`lang`),
  UNIQUE KEY `ID` (`idGalleries`,`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Galleries`
--

LOCK TABLES `Galleries` WRITE;
/*!40000 ALTER TABLE `Galleries` DISABLE KEYS */;
/*!40000 ALTER TABLE `Galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Galleries_Pages`
--

DROP TABLE IF EXISTS `Galleries_Pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Galleries_Pages` (
  `id Galleries_Pages` int(11) NOT NULL AUTO_INCREMENT,
  `idGalleries` int(11) DEFAULT NULL,
  `idPages` int(11) DEFAULT NULL,
  PRIMARY KEY (`id Galleries_Pages`),
  UNIQUE KEY `ID_UNIQUE` (`id Galleries_Pages`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Galleries_Pages`
--

LOCK TABLES `Galleries_Pages` WRITE;
/*!40000 ALTER TABLE `Galleries_Pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `Galleries_Pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Media`
--

DROP TABLE IF EXISTS `Media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Media` (
  `idMedia` int(11) NOT NULL AUTO_INCREMENT,
  `foreignType` int(11) NOT NULL,
  `foreignID` int(11) NOT NULL,
  `fileName` varchar(200) NOT NULL,
  `primaryMedia` tinyint(1) DEFAULT '0',
  `mediaType` varchar(10) DEFAULT NULL,
  `externalLink` varchar(300) DEFAULT NULL,
  `orderNum` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `description` varchar(200) DEFAULT NULL,
  `tags` varchar(100) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '0',
  `dateAdded` datetime DEFAULT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`idMedia`),
  KEY `ForeignID` (`foreignID`),
  KEY `PoVanjskiIDGlavni` (`foreignID`,`primaryMedia`,`foreignType`),
  KEY `est_idx` (`foreignType`,`foreignID`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Media`
--

LOCK TABLES `Media` WRITE;
/*!40000 ALTER TABLE `Media` DISABLE KEYS */;
INSERT INTO `Media` VALUES (15,3,4129,'shutterstock-2728073-56d6f020608ce.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(17,3,4128,'-blg0845-hotel-admiral-56d6f0422920e.JPG',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(18,3,4130,'child-cruiser-sea-shutterstock-7251655-56d6f052e6070.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(19,3,4131,'shutterstock-23656273-56d6f071bd2a8.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(21,3,4132,'shutterstock-41931814-rgb-56d6f15e5458c.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(22,3,4133,'sol-garden-istra-7-56d80ce61f509.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(29,3,4134,'arles-provence-france-two-windows-of-a-house-in-front-of-les-arenes-shutterstock-4829941-cmyk-56d83f4c4f386.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(30,3,4134,'810398-46001291-56d83f7a18440.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(40,3,4133,'podgora-sxc-780090-98152578-56d9451d4f52f.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(41,3,4133,'-blg0845-hotel-admiral-56d94530c34f7.JPG',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(42,3,4133,'10-12-2008-12-12-42-0007-56d9453175a88.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(43,3,4133,'00007463-56d94531c310d.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(51,3,4136,'valentinovo-web-56dfda7de33c4.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(52,3,4138,'valentinovo-web-56dfde52408e4.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(55,3,4139,'vrdoljak-town-56fa502e056f5.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(56,3,4139,'valentinovo-web-56fa503deebe6.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(57,1,1762,'valentinovo-web-56fa55bab80fc.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(59,3,4141,'vrdoljak-town-56fa5d5e75352.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(60,3,4141,'vrdoljak-town-56fa5d65db86b.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(61,3,4141,'valentinovo-web-56fa5d6c45da5.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(62,3,4142,'vrdoljak-town-56fa5d9156084.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(63,3,4143,'vrdoljak-town-56fa61d02104f.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(66,3,4147,'vrdoljak-town-56fa7029cd155.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(79,3,4153,'-blg0845-hotel-admiral-5703aa767236b.JPG',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(80,3,4154,'palace-presidential-suite-5703aa8cd9948.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(81,3,4155,'shutterstock-9828484-copy-5703aa96da188.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(82,3,4156,'podgora-sxc-780090-98152578-5703aad6e4246.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(83,3,4157,'shutterstock-23656273-5703aae272085.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(84,1,1762,'dolazak-57050d9990968.jpg',0,'IMAGE',NULL,1,1,NULL,NULL,1,NULL,NULL),(86,3,4150,'-blg0845-hotel-admiral-570619212a76a.JPG',0,'IMAGE',NULL,3,1,NULL,NULL,1,NULL,NULL),(87,3,4150,'10-12-2008-12-12-42-0007-5706192393c8f.jpg',0,'IMAGE',NULL,1,1,NULL,NULL,1,NULL,NULL),(88,3,4150,'00007463-570619255dbbc.jpg',0,'IMAGE',NULL,2,1,NULL,NULL,1,NULL,NULL),(89,3,4150,'810398-46001291-5706192711a86.jpg',0,'IMAGE',NULL,4,1,NULL,NULL,1,NULL,NULL),(90,3,4150,'animirka-5706192a268aa.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(92,3,4158,'00007463-570cc1beb7d82.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(101,3,4150,'-blg0845-hotel-admiral-570cfae6517ab.JPG',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(102,1,1762,'dolazak-570df2af8da64.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(104,3,4159,'dolazak-570dfa29c2b3f.jpg',1,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(105,3,4159,'img-3522-manja-57174d3c66b44.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(106,3,4159,'nightlife-57174d3d33309.jpg',0,'IMAGE',NULL,1,1,NULL,NULL,1,NULL,NULL),(107,3,4159,'valentinovo-57174d3d69ac6.jpg',0,'IMAGE',NULL,2,1,NULL,NULL,1,NULL,NULL),(108,4,1000004735,'dolazak-57174d732eb67.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(109,4,1000004735,'img-3522-manja-57174d734a944.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(110,4,1000004735,'korisne-info-57174d7354101.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL),(111,4,1000004735,'kretanje-po-gradu-57174d735d1d9.jpg',0,'IMAGE',NULL,0,1,NULL,NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `Media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Modules`
--

DROP TABLE IF EXISTS `Modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Modules` (
  `idModules` varchar(45) DEFAULT NULL,
  `ModuleSettingsID` int(11) NOT NULL AUTO_INCREMENT,
  `MediaForeignType` int(11) DEFAULT NULL,
  `MediaFilePath` varchar(255) DEFAULT NULL,
  `TemplateID` int(11) DEFAULT NULL,
  `CustomFields` text,
  `ForcedPageID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ModuleSettingsID`),
  UNIQUE KEY `IDMediaPaths_UNIQUE` (`ModuleSettingsID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Modules`
--

LOCK TABLES `Modules` WRITE;
/*!40000 ALTER TABLE `Modules` DISABLE KEYS */;
INSERT INTO `Modules` VALUES ('novosti',1,1,'media/news/',1003,'<li class=\"form-item\"> 	\n	<label for=\"naslov\">Dodatno polje<span>Super dodatno polje</span></label> 	\n	<input data-custom=\"true\" type=\"text\" class=\"naslov\" id=\"dodatno_polje\" value=\"\" /> \n</li>\n<li class=\"form-item\"> 	\n	<label for=\"naslov\">Extra polje<span>Extra dodatno polje</span></label> 	\n	<input data-custom=\"true\" type=\"text\" class=\"naslov\" id=\"dodatno_polje2\" value=\"\" /> \n</li>',NULL),('pages',2,2,'media/pages/',NULL,NULL,NULL),('places',3,3,'media/places/',1002,'<li class=\"form-item\">  	<label for=\"naslov\">Travelink ID<span>Upišite ID iz travelinka</span></label> 	<input data-custom=\"true\" type=\"text\" class=\"naslov\" id=\"travelinkID\" value=\"\" />   </li>',NULL),('events',4,4,'media/events/',1004,'<li class=\"form-item\"> 	 	  <label for=\"naslov\">Ulaznice URL<span>Dodatno polje za ulaznice</span></label> 	 	  <input data-custom=\"true\" data-copy=\"false\" type=\"text\" class=\"naslov\" id=\"ticketField\" value=\"\" />  </li> ',357),('galerije',5,5,'media/galerije/',1008,NULL,NULL),('videos',6,6,'media/videos/',1005,NULL,NULL);
/*!40000 ALTER TABLE `Modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PageMenus`
--

DROP TABLE IF EXISTS `PageMenus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PageMenus` (
  `idMenu` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idMenu`),
  UNIQUE KEY `IDMenu_UNIQUE` (`idMenu`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PageMenus`
--

LOCK TABLES `PageMenus` WRITE;
/*!40000 ALTER TABLE `PageMenus` DISABLE KEYS */;
INSERT INTO `PageMenus` VALUES (1,'Glavni meni'),(0,'Sakriven');
/*!40000 ALTER TABLE `PageMenus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pages`
--

DROP TABLE IF EXISTS `Pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pages` (
  `idPages` int(11) NOT NULL AUTO_INCREMENT,
  `idRod` int(11) DEFAULT NULL,
  `idPagesMenus` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `className` varchar(45) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `hreflink` varchar(255) DEFAULT NULL,
  `content` text,
  `lang` varchar(10) NOT NULL DEFAULT 'hr',
  `idPagesTypes` int(11) DEFAULT '1',
  `idTemplates` int(11) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '0',
  `rbr` int(11) DEFAULT NULL,
  `isDropdown` tinyint(1) DEFAULT '0',
  `overrideLink` tinyint(1) DEFAULT '0',
  `Seo_title` varchar(255) DEFAULT NULL,
  `Seo_metaDescription` varchar(255) DEFAULT NULL,
  `Seo_metaKeywords` varchar(255) DEFAULT NULL,
  `idUsers` int(11) DEFAULT NULL,
  `useHash` tinyint(1) DEFAULT '0',
  `templateParametars` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idPages`,`lang`),
  UNIQUE KEY `ID` (`idPages`,`lang`),
  UNIQUE KEY `ID_UNIQUE` (`idPages`,`lang`),
  KEY `link` (`link`,`lang`),
  KEY `new` (`idRod`,`idPagesMenus`,`published`,`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 PACK_KEYS=0 ROW_FORMAT=COMPACT COMMENT='InnoDB free: 3072 kB';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pages`
--

LOCK TABLES `Pages` WRITE;
/*!40000 ALTER TABLE `Pages` DISABLE KEYS */;
INSERT INTO `Pages` VALUES (1,0,1,'Home','/','','','','','hr',1,1,1,0,1,0,'','','',244,0,''),(53,42,1,'Section 2-5',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(2,0,1,'Accommodation','/accommodation','','','','','hr',1,1,1,2,1,0,'','','',244,0,''),(55,43,1,'Section 3-1',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(56,43,1,'Section 3-2',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(57,43,1,'Section 3-3',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(58,43,1,'Section 3-4',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(59,44,1,'Section 4-1',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(60,44,1,'Section 4-2',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(61,44,1,'Section 4-3',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(62,14,1,'Section 5',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,5,0,0,NULL,NULL,NULL,NULL,0,NULL),(63,14,1,'Section 6',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,6,0,0,NULL,NULL,NULL,NULL,0,NULL),(14,0,1,'Who are we','/who-are-we','flat','','','','hr',1,4,1,2,1,0,'','','',244,0,''),(34,2,1,'Another menu with sub',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,1,0,NULL,NULL,NULL,NULL,0,NULL),(12,0,1,'Adriatic Cruises','/adriatic-cruises','','','','','hr',1,1,1,1,1,0,'','','',244,0,''),(13,0,1,'Tailor Made Programs','/tailor-made-programs','','','','','hr',1,1,1,4,1,0,'','','',244,0,''),(54,42,1,'Section 2-6',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(40,12,1,'Second level test 2',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(41,14,1,'Section 1',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,1,0,0,NULL,NULL,NULL,NULL,0,NULL),(42,14,1,'Section 2',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,2,0,0,NULL,NULL,NULL,NULL,0,NULL),(43,14,1,'Section 3',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,3,0,0,NULL,NULL,NULL,NULL,0,NULL),(44,14,1,'Section 4',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,4,0,0,NULL,NULL,NULL,NULL,0,NULL),(45,41,1,'Section 1-1',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(46,41,1,'Section 1-2',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(47,41,1,'Section 1-2',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(48,41,1,'Section 1-4',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(49,42,1,'Section 2-1',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(50,42,1,'Section 2-2',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(51,42,1,'Section 2-3',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(52,42,1,'Section 2-4',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(33,2,1,'Accomodation 2','/accommodation/accomodation-2',NULL,NULL,NULL,NULL,'hr',1,1,1,4,0,0,NULL,NULL,NULL,244,0,NULL),(37,34,1,'Third level menu 2',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(38,12,1,'Second level test',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(39,12,1,'Second level test 1',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(35,34,1,'Third level menu',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(36,34,1,'Third level menu 2',NULL,NULL,NULL,NULL,NULL,'hr',1,NULL,1,NULL,0,0,NULL,NULL,NULL,NULL,0,NULL),(32,2,1,'Super page','/super-page',NULL,NULL,NULL,NULL,'hr',1,1,1,33,0,0,NULL,NULL,NULL,244,0,NULL),(31,2,1,'Coupons','/coupons',NULL,NULL,NULL,'','hr',1,4,1,4,0,0,NULL,NULL,NULL,244,0,NULL);
/*!40000 ALTER TABLE `Pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PagesTypes`
--

DROP TABLE IF EXISTS `PagesTypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PagesTypes` (
  `idPagesTypes` int(11) NOT NULL AUTO_INCREMENT,
  `parentID` int(11) DEFAULT NULL,
  `naziv` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idPagesTypes`),
  UNIQUE KEY `PageTypeID_UNIQUE` (`idPagesTypes`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PagesTypes`
--

LOCK TABLES `PagesTypes` WRITE;
/*!40000 ALTER TABLE `PagesTypes` DISABLE KEYS */;
INSERT INTO `PagesTypes` VALUES (1,NULL,'Page'),(2,NULL,'Filter');
/*!40000 ALTER TABLE `PagesTypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pages_Modules`
--

DROP TABLE IF EXISTS `Pages_Modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pages_Modules` (
  `idPages_Modules` int(11) NOT NULL AUTO_INCREMENT,
  `idModules` int(11) DEFAULT NULL,
  `idPages` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPages_Modules`),
  UNIQUE KEY `PagesModulesID_UNIQUE` (`idPages_Modules`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pages_Modules`
--

LOCK TABLES `Pages_Modules` WRITE;
/*!40000 ALTER TABLE `Pages_Modules` DISABLE KEYS */;
INSERT INTO `Pages_Modules` VALUES (13,1,23),(14,3,1),(15,3,2),(16,3,12),(17,3,13);
/*!40000 ALTER TABLE `Pages_Modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Places`
--

DROP TABLE IF EXISTS `Places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Places` (
  `idPlaces` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `heading` text,
  `headingImage` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `linkOriginal` varchar(255) DEFAULT NULL,
  `adresa` varchar(255) DEFAULT NULL,
  `tel` varchar(100) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `web` varchar(100) DEFAULT NULL,
  `text` text,
  `lat` float(10,6) DEFAULT NULL,
  `lng` float(10,6) DEFAULT NULL,
  `lang` varchar(2) NOT NULL DEFAULT 'hr',
  `published` tinyint(1) DEFAULT '1',
  `citysID` int(11) DEFAULT '0',
  `isDraft` tinyint(1) DEFAULT '1',
  `idTemplates` int(11) DEFAULT NULL,
  `usersID` int(11) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `customFieldsValues` text,
  `tags` varchar(255) DEFAULT NULL,
  `price` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`idPlaces`,`lang`),
  UNIQUE KEY `ID` (`idPlaces`,`lang`),
  UNIQUE KEY `PA LINK` (`link`,`lang`),
  UNIQUE KEY `NAZIV` (`title`,`idPlaces`,`lang`),
  KEY `LINK` (`link`),
  KEY `linkOriginal` (`linkOriginal`),
  FULLTEXT KEY `FULLTEXT` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=4160 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Places`
--

LOCK TABLES `Places` WRITE;
/*!40000 ALTER TABLE `Places` DISABLE KEYS */;
INSERT INTO `Places` VALUES (4145,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hr',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4143,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hr',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4143,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4145,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4146,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hr',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4140,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hr',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4140,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4141,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hr',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4141,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4146,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4155,'Test tour 3','',NULL,'test-tour-3',NULL,'','','','','','',0.000000,0.000000,'hr',1,2,0,1002,244,'2016-04-05 10:07:44',0,'{\"travelinkID\":\"\"}','',0.00),(4155,'','',NULL,'',NULL,'','','','','','',0.000000,0.000000,'en',1,2,0,1002,244,'2016-04-05 10:07:44',0,'','',0.00),(4154,'Test tour 2','',NULL,'test-tour-2',NULL,'','','','','','',0.000000,0.000000,'hr',1,2,0,1002,244,'2016-04-05 10:07:37',0,'{\"travelinkID\":\"\"}','dubrovnik,zakaj,neradi',0.00),(4154,'','',NULL,'-5720935879964',NULL,'','','','','','',0.000000,0.000000,'en',1,2,0,1002,244,'2016-04-05 10:07:37',0,'','',0.00),(4153,'Test tour 1','',NULL,'test-tour-1',NULL,'','','','','','',0.000000,0.000000,'hr',1,2,0,1002,244,'2016-04-05 10:07:30',0,'{\"travelinkID\":\"\"}','zagreb,atlas,dubrovnik',0.00),(4153,'','',NULL,'-5720934f0e96e',NULL,'','','','','','',0.000000,0.000000,'en',1,2,0,1002,244,'2016-04-05 10:07:30',0,'','',0.00),(4150,'Test tour 81234','Super tura za dalmaciju Super tura za dalmaciju Super tura za dalmaciju',NULL,'test-tour-81234',NULL,'','','','','','',0.000000,0.000000,'hr',1,2,0,1002,244,'2016-03-29 12:18:21',0,'{\"travelinkID\":\"\"}','zagreb,dubrovnik,atlas,testiramo,ozren,natko,super,duper,smuper,ova tura',1500.00),(4150,'','',NULL,'-5720934629b9a',NULL,'','','','','','',0.000000,0.000000,'en',1,2,0,1002,244,'2016-03-29 12:18:21',0,'','',0.00),(4151,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hr',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4151,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4152,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hr',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4152,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4156,'Test 6','',NULL,'test-6',NULL,'','','','','','',0.000000,0.000000,'hr',1,2,0,1002,244,'2016-04-05 12:08:45',0,'{\"travelinkID\":\"\"}','',0.00),(4156,'','',NULL,'-5703aad95789e',NULL,'','','','','','',0.000000,0.000000,'en',1,2,0,1002,244,'2016-04-05 12:08:45',0,'','',0.00),(4157,'Test 7','',NULL,'test-7',NULL,'','','','','','',0.000000,0.000000,'hr',1,2,0,1002,244,'2016-04-05 12:08:59',0,'{\"travelinkID\":\"\"}','',0.00),(4157,'','',NULL,'-5703aae77fa70',NULL,'','','','','','',0.000000,0.000000,'en',1,2,0,1002,244,'2016-04-05 12:08:59',0,'','',0.00),(4158,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hr',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4158,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',1,0,1,NULL,NULL,NULL,0,NULL,NULL,NULL),(4159,'test','',NULL,'test-570cc1ff6e294',NULL,'','','','','','',0.000000,0.000000,'hr',1,2,0,1002,244,'2016-04-12 09:37:28',0,'{\"travelinkID\":\"\"}','',0.00),(4159,'','',NULL,'-570cc3c6259b3',NULL,'','','','','','',0.000000,0.000000,'en',1,2,0,1002,244,'2016-04-12 09:37:28',0,'','',0.00);
/*!40000 ALTER TABLE `Places` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PlacesCitys`
--

DROP TABLE IF EXISTS `PlacesCitys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PlacesCitys` (
  `idPlacesCitys` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(255) DEFAULT NULL,
  `lat` float(10,6) DEFAULT NULL,
  `lng` float(10,6) DEFAULT NULL,
  PRIMARY KEY (`idPlacesCitys`),
  UNIQUE KEY `PlacesCityID_UNIQUE` (`idPlacesCitys`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PlacesCitys`
--

LOCK TABLES `PlacesCitys` WRITE;
/*!40000 ALTER TABLE `PlacesCitys` DISABLE KEYS */;
INSERT INTO `PlacesCitys` VALUES (2,'Zagreb',45.840176,15.894120),(3,'Dubrovnik',42.645721,18.058952);
/*!40000 ALTER TABLE `PlacesCitys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Places_Pages`
--

DROP TABLE IF EXISTS `Places_Pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Places_Pages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idPlace` int(11) DEFAULT NULL,
  `idPage` int(11) DEFAULT NULL,
  `MainKategory` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `ID_PLACE` (`idPlace`,`idPage`)
) ENGINE=MyISAM AUTO_INCREMENT=12827 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Places_Pages`
--

LOCK TABLES `Places_Pages` WRITE;
/*!40000 ALTER TABLE `Places_Pages` DISABLE KEYS */;
INSERT INTO `Places_Pages` VALUES (12709,4106,25,1),(12750,4129,25,0),(12746,4131,25,0),(12770,4128,25,0),(12747,4131,33,1),(12749,4130,33,1),(12771,4128,33,1),(12748,4130,25,0),(12752,4132,25,0),(12751,4129,33,1),(12753,4132,33,1),(12767,4133,33,1),(12768,4133,34,0),(12764,4135,42,1),(12765,4136,0,NULL),(12769,4138,33,0),(12824,4155,1,1),(12820,4154,1,1),(12817,4153,1,1),(12813,4150,2,1),(12788,4156,0,NULL),(12789,4157,0,NULL),(12795,4159,0,NULL),(12814,4150,27,0),(12815,4150,28,0),(12816,4150,22,0),(12818,4153,30,0),(12819,4153,21,0),(12821,4154,30,0),(12822,4154,27,0),(12823,4154,22,0),(12825,4155,30,0),(12826,4155,21,0);
/*!40000 ALTER TABLE `Places_Pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SiteLanguages`
--

DROP TABLE IF EXISTS `SiteLanguages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SiteLanguages` (
  `idSiteLanguages` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `isDefault` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idSiteLanguages`),
  KEY `tag` (`tag`),
  KEY `tagid` (`tag`,`idSiteLanguages`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SiteLanguages`
--

LOCK TABLES `SiteLanguages` WRITE;
/*!40000 ALTER TABLE `SiteLanguages` DISABLE KEYS */;
INSERT INTO `SiteLanguages` VALUES (1,'Hrvatski','hr',1),(2,'Engleski','en',0);
/*!40000 ALTER TABLE `SiteLanguages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SiteSettings`
--

DROP TABLE IF EXISTS `SiteSettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SiteSettings` (
  `idSiteSettings` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idSiteSettings`),
  UNIQUE KEY `idSiteSettings_UNIQUE` (`idSiteSettings`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SiteSettings`
--

LOCK TABLES `SiteSettings` WRITE;
/*!40000 ALTER TABLE `SiteSettings` DISABLE KEYS */;
/*!40000 ALTER TABLE `SiteSettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Templates`
--

DROP TABLE IF EXISTS `Templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Templates` (
  `idTemplates` int(11) NOT NULL AUTO_INCREMENT,
  `ModuleSettingsID` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `ime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idTemplates`),
  UNIQUE KEY `ID` (`idTemplates`)
) ENGINE=InnoDB AUTO_INCREMENT=1004 DEFAULT CHARSET=utf8 PACK_KEYS=0 ROW_FORMAT=COMPACT COMMENT='InnoDB free: 3072 kB';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Templates`
--

LOCK TABLES `Templates` WRITE;
/*!40000 ALTER TABLE `Templates` DISABLE KEYS */;
INSERT INTO `Templates` VALUES (1,1,'PagesController#defaultPage','Default content'),(2,2,'PagesController#index','Početna'),(3,3,'PlacesController#defaultPage','Lokacije - lista'),(4,1,'PagesController#defaultServerPage','DefaultServerPage'),(1002,3,'PlacesController#defaultPlace','Lokacija'),(1003,NULL,'PlacesController#WideWithoutMenu','Lokacije -lista bez side menija');
/*!40000 ALTER TABLE `Templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Translations`
--

DROP TABLE IF EXISTS `Translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Translations` (
  `key` varchar(255) NOT NULL,
  `hr` varchar(255) DEFAULT NULL,
  `en` varchar(255) DEFAULT NULL,
  `de` varchar(255) DEFAULT NULL,
  `es` varchar(255) DEFAULT NULL,
  `fr` varchar(255) DEFAULT NULL,
  `it` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`key`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Translations`
--

LOCK TABLES `Translations` WRITE;
/*!40000 ALTER TABLE `Translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `Translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserInteractions`
--

DROP TABLE IF EXISTS `UserInteractions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserInteractions` (
  `idUserInteractions` int(11) NOT NULL AUTO_INCREMENT,
  `idUsers` int(11) DEFAULT NULL,
  `usersInteractionsType` varchar(45) DEFAULT NULL,
  `foreignID` int(11) DEFAULT NULL,
  `foreignType` int(11) DEFAULT NULL,
  `dateCreated` datetime DEFAULT NULL,
  PRIMARY KEY (`idUserInteractions`),
  UNIQUE KEY `UsersLikesID_UNIQUE` (`idUserInteractions`),
  KEY `UI4` (`foreignID`,`idUserInteractions`),
  KEY `UI3` (`idUsers`,`usersInteractionsType`,`foreignType`,`dateCreated`,`idUserInteractions`),
  KEY `dateCreated` (`dateCreated`,`idUserInteractions`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserInteractions`
--

LOCK TABLES `UserInteractions` WRITE;
/*!40000 ALTER TABLE `UserInteractions` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserInteractions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserRights`
--

DROP TABLE IF EXISTS `UserRights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserRights` (
  `idRights` int(11) NOT NULL AUTO_INCREMENT,
  `rightsParentID` int(11) DEFAULT NULL,
  `rightsName` varchar(255) NOT NULL,
  PRIMARY KEY (`idRights`),
  UNIQUE KEY `ZonesID_UNIQUE` (`idRights`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserRights`
--

LOCK TABLES `UserRights` WRITE;
/*!40000 ALTER TABLE `UserRights` DISABLE KEYS */;
INSERT INTO `UserRights` VALUES (1,NULL,'CMS');
/*!40000 ALTER TABLE `UserRights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserTransactions`
--

DROP TABLE IF EXISTS `UserTransactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserTransactions` (
  `id UserTransactions` int(11) NOT NULL AUTO_INCREMENT,
  `idUsers` int(11) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `foreignID` int(11) DEFAULT NULL,
  `foreignType` int(11) DEFAULT NULL,
  `transactionDate` datetime DEFAULT NULL,
  `transactionResponse` text,
  `foreignTransactionID` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id UserTransactions`),
  UNIQUE KEY `UsersTransactionsID_UNIQUE` (`id UserTransactions`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserTransactions`
--

LOCK TABLES `UserTransactions` WRITE;
/*!40000 ALTER TABLE `UserTransactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserTransactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(255) DEFAULT NULL,
  `tvrtka` varchar(255) DEFAULT NULL,
  `adresa` varchar(255) DEFAULT NULL,
  `grad` varchar(255) DEFAULT NULL,
  `postanski` varchar(10) DEFAULT '0',
  `password` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `num_posts` int(11) DEFAULT '0',
  `last_post` datetime DEFAULT NULL,
  `previous_login` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `joined` datetime DEFAULT NULL,
  `aktivan` tinyint(1) DEFAULT '0',
  `vrsta_korisnika` int(11) DEFAULT NULL,
  `creditBalance` decimal(10,2) DEFAULT NULL,
  `countrysID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=257 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (244,'Ozren Putarek','Borming','F. Bošnjakovića 8','Zagreb','10000','9f15343921c79155cbae7c09c716ce1c','oputarek@inet.hr',0,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),(256,'New user','Borming','čala','Zagreb','10000','9f15343921c79155cbae7c09c716ce1c','oputarek123@inet.hr',0,NULL,NULL,NULL,'2016-03-31 08:06:09',1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users_UserRights`
--

DROP TABLE IF EXISTS `Users_UserRights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users_UserRights` (
  `id Users_UserRights` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idUserRights` int(11) NOT NULL,
  `idUsers` int(11) NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id Users_UserRights`)
) ENGINE=MyISAM AUTO_INCREMENT=406 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users_UserRights`
--

LOCK TABLES `Users_UserRights` WRITE;
/*!40000 ALTER TABLE `Users_UserRights` DISABLE KEYS */;
INSERT INTO `Users_UserRights` VALUES (404,1,244,1),(405,1,256,1);
/*!40000 ALTER TABLE `Users_UserRights` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-15  9:52:31
