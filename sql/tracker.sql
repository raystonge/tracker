CREATE DATABASE  IF NOT EXISTS `tracker` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `tracker`;
-- MySQL dump 10.13  Distrib 5.1.69, for redhat-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: tracker
-- ------------------------------------------------------
-- Server version	5.1.69-log

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
-- Table structure for table `mimeType`
--

DROP TABLE IF EXISTS `mimeType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mimeType` (
  `mimeTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `mimeType` varchar(45) NOT NULL,
  `handler` varchar(25) NOT NULL,
  PRIMARY KEY (`mimeTypeId`),
  KEY `name` (`name`),
  KEY `mimeType` (`mimeType`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mimeType`
--

LOCK TABLES `mimeType` WRITE;
/*!40000 ALTER TABLE `mimeType` DISABLE KEYS */;
INSERT INTO `mimeType` VALUES (1,'text/plain','text/plain','text'),(2,'application/vnd.oasis.ope','application/vnd.oasis.opendocument.spreadshee','default'),(3,'image/jpeg','image/jpeg','image'),(4,'application/pdf','application/pdf','pdf');
/*!40000 ALTER TABLE `mimeType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `commentId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `posted` datetime DEFAULT NULL,
  `ticketId` int(11) DEFAULT NULL,
  `comment` text,
  `assetId` int(11) DEFAULT NULL,
  `postId` int(11) DEFAULT NULL,
  `replyToId` int(11) DEFAULT NULL,
  PRIMARY KEY (`commentId`),
  KEY `ticketId` (`ticketId`),
  KEY `assetId` (`assetId`),
  KEY `ticketIdPosted` (`ticketId`,`posted`),
  KEY `assetIdPosted` (`assetId`,`posted`),
  KEY `postId` (`postId`,`posted`),
  KEY `replyToIdPosted` (`replyToId`,`posted`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `defaultUser`
--

DROP TABLE IF EXISTS `defaultUser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `defaultUser` (
  `defaultUserId` int(11) NOT NULL AUTO_INCREMENT,
  `userType` varchar(45) DEFAULT NULL,
  `userId` varchar(45) DEFAULT NULL,
  `queueId` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`defaultUserId`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `defaultUser`
--

LOCK TABLES `defaultUser` WRITE;
/*!40000 ALTER TABLE `defaultUser` DISABLE KEYS */;
INSERT INTO `defaultUser` VALUES (6,'assignee','1','1'),(7,'cc','1','1'),(8,'cc','2','1'),(9,'assignee','2','9'),(10,'assignee','1','3'),(11,'assignee','1','2'),(12,'assignee','1','23'),(13,'assignee','2','5'),(14,'assignee','8','8');
/*!40000 ALTER TABLE `defaultUser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticketCC`
--

DROP TABLE IF EXISTS `ticketCC`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticketCC` (
  `ticketCCId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticketId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ticketCCId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticketCC`
--

LOCK TABLES `ticketCC` WRITE;
/*!40000 ALTER TABLE `ticketCC` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticketCC` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmpLink`
--

DROP TABLE IF EXISTS `tmpLink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmpLink` (
  `tmpLinkId` int(11) NOT NULL AUTO_INCREMENT,
  `rndString` varchar(255) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tmpLinkId`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmpLink`
--

LOCK TABLES `tmpLink` WRITE;
/*!40000 ALTER TABLE `tmpLink` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmpLink` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticketDependencies`
--

DROP TABLE IF EXISTS `ticketDependencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticketDependencies` (
  `ticketDependenciesId` int(11) NOT NULL,
  `blockId` int(11) DEFAULT NULL,
  `dependsId` int(11) DEFAULT NULL,
  PRIMARY KEY (`ticketDependenciesId`),
  KEY `block` (`blockId`),
  KEY `dep` (`dependsId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticketDependencies`
--

LOCK TABLES `ticketDependencies` WRITE;
/*!40000 ALTER TABLE `ticketDependencies` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticketDependencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insuranceRepairComplete`
--

DROP TABLE IF EXISTS `insuranceRepairComplete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insuranceRepairComplete` (
  `insuranceRepairCompleteId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`insuranceRepairCompleteId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insuranceRepairComplete`
--

LOCK TABLES `insuranceRepairComplete` WRITE;
/*!40000 ALTER TABLE `insuranceRepairComplete` DISABLE KEYS */;
/*!40000 ALTER TABLE `insuranceRepairComplete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userToGroup`
--

DROP TABLE IF EXISTS `userToGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userToGroup` (
  `userToGroupId` int(11) NOT NULL AUTO_INCREMENT,
  `userGroupId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  PRIMARY KEY (`userToGroupId`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userToGroup`
--

LOCK TABLES `userToGroup` WRITE;
/*!40000 ALTER TABLE `userToGroup` DISABLE KEYS */;
INSERT INTO `userToGroup` VALUES (21,3,1),(20,2,1),(4,2,2),(5,1,3),(6,2,4),(7,2,5),(8,2,6),(9,2,7),(10,2,8),(19,1,1);
/*!40000 ALTER TABLE `userToGroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assetType`
--

DROP TABLE IF EXISTS `assetType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assetType` (
  `assetTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `monitor` int(11) DEFAULT '0',
  `hasMacAddress` int(11) DEFAULT '0',
  PRIMARY KEY (`assetTypeId`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assetType`
--

LOCK TABLES `assetType` WRITE;
/*!40000 ALTER TABLE `assetType` DISABLE KEYS */;
INSERT INTO `assetType` VALUES (1,'Computer',1,0),(2,'WAP',1,0),(3,'Managed Switch',1,1),(4,'Laptop',0,0),(5,'Printer',1,0),(6,'Copier',0,0),(7,'LCD Monitor',0,0),(8,'Document Camera',0,0),(9,'Netbook',0,0),(10,'iPad',0,0),(11,'Unmanaged Switch',0,0),(12,'Router',1,0);
/*!40000 ALTER TABLE `assetType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queue`
--

DROP TABLE IF EXISTS `queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `queue` (
  `queueId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`queueId`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `queue`
--

LOCK TABLES `queue` WRITE;
/*!40000 ALTER TABLE `queue` DISABLE KEYS */;
INSERT INTO `queue` VALUES (1,'Ames'),(2,'CASS'),(3,'Drinkwater'),(4,'East Belfast'),(5,'Adult Ed'),(6,'After School Program'),(7,'BAHS'),(8,'BCOPE'),(9,'Central Office'),(10,'District Office'),(11,'Google Domain'),(12,'Infinite Campus'),(13,'Laptop Repairs'),(14,'Nickerson'),(15,'SDHS'),(16,'SDMS'),(17,'SES'),(18,'Special Services Office'),(19,'SSES'),(20,'Technology'),(21,'THMS'),(22,'Transportation'),(23,'Weymouth');
/*!40000 ALTER TABLE `queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monitor`
--

DROP TABLE IF EXISTS `monitor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `monitor` (
  `monitorId` int(11) NOT NULL AUTO_INCREMENT,
  `assetId` int(11) NOT NULL,
  `ipAddress` varchar(25) NOT NULL,
  `state` int(11) NOT NULL DEFAULT '0',
  `fqdn` varchar(255) NOT NULL,
  `stateChangeDateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`monitorId`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monitor`
--

LOCK TABLES `monitor` WRITE;
/*!40000 ALTER TABLE `monitor` DISABLE KEYS */;
/*!40000 ALTER TABLE `monitor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assetCondition`
--

DROP TABLE IF EXISTS `assetCondition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assetCondition` (
  `assetConditionId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`assetConditionId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assetCondition`
--

LOCK TABLES `assetCondition` WRITE;
/*!40000 ALTER TABLE `assetCondition` DISABLE KEYS */;
INSERT INTO `assetCondition` VALUES (1,'Poor'),(2,'Good'),(3,'Excellent'),(4,'Out of Service');
/*!40000 ALTER TABLE `assetCondition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `priority`
--

DROP TABLE IF EXISTS `priority`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `priority` (
  `priorityId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `sortOn` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`priorityId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `priority`
--

LOCK TABLES `priority` WRITE;
/*!40000 ALTER TABLE `priority` DISABLE KEYS */;
INSERT INTO `priority` VALUES (1,'Urgent','1'),(2,'High','2'),(3,'Normal','3'),(4,'Low','4');
/*!40000 ALTER TABLE `priority` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticketToInsurancePayment`
--

DROP TABLE IF EXISTS `ticketToInsurancePayment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticketToInsurancePayment` (
  `ticketToInsurancePaymentId` int(11) NOT NULL AUTO_INCREMENT,
  `ticketId` int(11) DEFAULT NULL,
  `insurancePaymentId` int(11) DEFAULT NULL,
  PRIMARY KEY (`ticketToInsurancePaymentId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticketToInsurancePayment`
--

LOCK TABLES `ticketToInsurancePayment` WRITE;
/*!40000 ALTER TABLE `ticketToInsurancePayment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticketToInsurancePayment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attachment`
--

DROP TABLE IF EXISTS `attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment` (
  `attachmentId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `originalName` varchar(255) DEFAULT NULL,
  `assetId` int(11) DEFAULT NULL,
  `ticketId` int(11) DEFAULT NULL,
  `mimeTypeId` int(11) DEFAULT NULL,
  `ext` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`attachmentId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachment`
--

LOCK TABLES `attachment` WRITE;
/*!40000 ALTER TABLE `attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userGroup`
--

DROP TABLE IF EXISTS `userGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userGroup` (
  `userGroupId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `developer` int(11) DEFAULT NULL,
  `assignee` int(11) DEFAULT '0',
  PRIMARY KEY (`userGroupId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userGroup`
--

LOCK TABLES `userGroup` WRITE;
/*!40000 ALTER TABLE `userGroup` DISABLE KEYS */;
INSERT INTO `userGroup` VALUES (1,'Admin',1,1,0),(2,'Tech',0,0,1),(3,'Developer',1,1,0);
/*!40000 ALTER TABLE `userGroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userToPermission`
--

DROP TABLE IF EXISTS `userToPermission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userToPermission` (
  `userToPermissionId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `permissionId` int(11) DEFAULT NULL,
  PRIMARY KEY (`userToPermissionId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userToPermission`
--

LOCK TABLES `userToPermission` WRITE;
/*!40000 ALTER TABLE `userToPermission` DISABLE KEYS */;
/*!40000 ALTER TABLE `userToPermission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insuranceRepair`
--

DROP TABLE IF EXISTS `insuranceRepair`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insuranceRepair` (
  `insuranceRepairId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`insuranceRepairId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insuranceRepair`
--

LOCK TABLES `insuranceRepair` WRITE;
/*!40000 ALTER TABLE `insuranceRepair` DISABLE KEYS */;
/*!40000 ALTER TABLE `insuranceRepair` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset`
--

DROP TABLE IF EXISTS `asset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset` (
  `assetId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `serialNumber` varchar(45) NOT NULL,
  `macAddress` varchar(45) NOT NULL,
  `assetConditionId` int(10) unsigned NOT NULL DEFAULT '0',
  `assetTypeId` varchar(45) DEFAULT NULL,
  `buildingId` int(11) DEFAULT NULL,
  `make` varchar(45) DEFAULT NULL,
  `model` varchar(45) DEFAULT NULL,
  `modelNumber` varchar(45) DEFAULT NULL,
  `assetTag` varchar(45) DEFAULT NULL,
  `buildingLocation` varchar(45) DEFAULT NULL,
  `employeeName` varchar(45) DEFAULT NULL,
  `poNumber` varchar(45) DEFAULT NULL,
  `aquireDate` datetime DEFAULT NULL,
  `vendor` varchar(45) DEFAULT NULL,
  `creatorId` int(11) DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `conditionId` int(11) DEFAULT NULL,
  PRIMARY KEY (`assetId`)
) ENGINE=MyISAM AUTO_INCREMENT=824 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset`
--

LOCK TABLES `asset` WRITE;
/*!40000 ALTER TABLE `asset` DISABLE KEYS */;
/*!40000 ALTER TABLE `asset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `statusId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `sortOn` int(11) DEFAULT NULL,
  PRIMARY KEY (`statusId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'New',1),(2,'Open',2),(3,'In Process',3),(4,'Closed',4),(5,'Re-Open',5),(6,'Hold',6);
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `fullName` varchar(45) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `lastLogin` datetime DEFAULT NULL,
  `initials` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  KEY `INITIALS` (`initials`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'raymond.stonge@gmail.com','ferderkl','Ray St. Onge',1,'2013-11-07 08:46:31','rls'),(2,'bbradford@rsu20.org','password','Bob Bradford',1,'2013-11-06 17:13:12',''),(3,'thayslip@rsu20.org','password','Tracy Hayslip',1,'2013-03-19 15:44:30',''),(4,'rgrove@rsu20.org','password','Rusty Grove',1,'2013-10-30 20:08:08',''),(5,'mfuller@rsu20.org','password','Mike Fuller',1,'2013-10-30 20:08:38',''),(6,'cbrinn@rsu20.org','password','Chris Brinn',1,'2013-10-30 20:09:02',''),(7,'jtozer@rsu20.org','password','Jason Tozer',1,'2013-10-30 20:09:27',''),(8,'ekennard@rsu20.org','password','Erick Kennard',1,'2013-10-30 20:10:33','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission` (
  `permissionId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `developer` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`permissionId`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` VALUES (1,'Config: Controls',0),(2,'Config: Users',0),(3,'Config: User Groups',0),(4,'Config: User: Permissions',0),(5,'Config: User Group: Permissions',0),(6,'Config: Delete User',0),(7,'Config: Delete User Group',0),(8,'Config: User Group: Create',0),(9,'Config: User Group: Delete',0),(10,'Config: User Group: Edit',0),(11,'Config: User Group: View',0),(12,'Config: User: Create',0),(13,'Config: User: Edit',0),(14,'Config: User: Delete',0),(15,'Config: User: View',0),(16,'Config: Export Data Structure',1),(17,'Config: Upgrade',1),(18,'Config: Importer',1),(19,'Developer',1),(20,'Ticket: List',0),(21,'Asset: List',0),(22,'Asset: Create',0),(23,'Ticket: Create',0),(24,'Ticket: Edit',0),(25,'Ticket: View',0),(26,'Asset: Edit',0),(27,'Asset: View',0),(28,'Asset: View Tickets',0),(29,'Config: AssetType Create',0),(30,'Config: AssetType Delete',0),(31,'Config: AssetType Edit',0),(32,'Asset: View Attachments',0),(33,'Assets: List',0),(34,'Tickets: List',0),(35,'Config',0),(36,'Monitor',0),(37,'Config: Asset Type',0),(38,'Config: Asset Condition',0),(39,'Config: Insurance Payment',0),(40,'Config: Insurance Repair',0),(41,'Config: Insurance Repair Complete',0),(42,'Config: Queue',0),(43,'Config: Status',0),(44,'Asset: Monitor',0);
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assetToTicket`
--

DROP TABLE IF EXISTS `assetToTicket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assetToTicket` (
  `assetToTicketId` int(11) NOT NULL AUTO_INCREMENT,
  `assetId` int(11) DEFAULT NULL,
  `ticketId` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`assetToTicketId`),
  KEY `assetId` (`assetId`),
  KEY `ticketId` (`ticketId`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assetToTicket`
--

LOCK TABLES `assetToTicket` WRITE;
/*!40000 ALTER TABLE `assetToTicket` DISABLE KEYS */;
INSERT INTO `assetToTicket` VALUES (1,1,'1'),(2,645,'2'),(3,662,'2'),(4,661,'2'),(5,660,'2'),(6,659,'2'),(7,658,'2'),(8,657,'2'),(9,648,'2'),(10,647,'2'),(11,650,'2'),(12,649,'2'),(13,663,'2'),(14,655,'2'),(15,643,'2'),(16,651,'2'),(17,656,'2'),(18,654,'2'),(19,652,'2'),(20,653,'2'),(21,666,'2'),(22,665,'2'),(23,646,'2'),(24,644,'2'),(25,664,'2'),(26,667,'1'),(27,668,'1');
/*!40000 ALTER TABLE `assetToTicket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket` (
  `ticketId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creatorId` int(10) unsigned NOT NULL,
  `ownerId` int(10) unsigned NOT NULL,
  `statusId` int(10) unsigned NOT NULL,
  `subject` varchar(255) NOT NULL,
  `insuranceRepairId` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `createDate` datetime NOT NULL,
  `dueDate` date NOT NULL,
  `priorityId` int(10) unsigned NOT NULL,
  `timeEstimate` int(10) unsigned NOT NULL,
  `timeWorked` int(10) unsigned NOT NULL,
  `queueId` int(10) unsigned NOT NULL,
  `repairCost` varchar(45) NOT NULL,
  `poNumber` varchar(45) NOT NULL,
  `requestorId` int(11) DEFAULT NULL,
  `insuranceRepairCompleteId` int(11) DEFAULT NULL,
  `insurancePaymentId` int(11) DEFAULT NULL,
  `lastUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`ticketId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket`
--

LOCK TABLES `ticket` WRITE;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userGroupToPermission`
--

DROP TABLE IF EXISTS `userGroupToPermission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userGroupToPermission` (
  `userGroupToPermissionId` int(11) NOT NULL AUTO_INCREMENT,
  `userGroupId` int(11) DEFAULT NULL,
  `permissionId` int(11) DEFAULT NULL,
  PRIMARY KEY (`userGroupToPermissionId`)
) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userGroupToPermission`
--

LOCK TABLES `userGroupToPermission` WRITE;
/*!40000 ALTER TABLE `userGroupToPermission` DISABLE KEYS */;
INSERT INTO `userGroupToPermission` VALUES (12,3,19),(189,2,36),(188,2,2),(19,1,17),(18,1,16),(187,2,15),(186,2,4),(185,2,13),(184,2,14),(183,2,12),(182,2,3),(181,2,11),(180,2,5),(179,2,10),(178,2,9),(177,2,8),(176,2,43),(175,2,42),(174,2,41),(173,2,40),(172,2,39),(171,2,7),(170,2,6),(169,2,1),(168,2,31),(167,2,30),(166,2,29),(165,2,37),(164,2,38),(163,2,35),(162,2,33),(161,2,28),(160,2,32),(159,2,27),(158,2,21),(157,2,26),(156,2,22),(190,2,23),(191,2,24),(192,2,20),(193,2,25),(194,2,34);
/*!40000 ALTER TABLE `userGroupToPermission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `building`
--

DROP TABLE IF EXISTS `building`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `building` (
  `buildingId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `domain` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`buildingId`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `building`
--

LOCK TABLES `building` WRITE;
/*!40000 ALTER TABLE `building` DISABLE KEYS */;
INSERT INTO `building` VALUES (1,'Ames',NULL),(2,'CASS',NULL),(3,'Drinkwater',NULL),(4,'East Belfast',NULL),(5,'BAHS',NULL),(6,'Central Office',NULL),(7,'BCOPE',NULL),(8,'SES',NULL),(9,'SDHS',NULL),(10,'SDMS',NULL),(11,'Weymouth',NULL);
/*!40000 ALTER TABLE `building` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insurancePayment`
--

DROP TABLE IF EXISTS `insurancePayment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insurancePayment` (
  `insurancePaymentId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`insurancePaymentId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insurancePayment`
--

LOCK TABLES `insurancePayment` WRITE;
/*!40000 ALTER TABLE `insurancePayment` DISABLE KEYS */;
/*!40000 ALTER TABLE `insurancePayment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticketToAsset`
--

DROP TABLE IF EXISTS `ticketToAsset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticketToAsset` (
  `ticketToAssetId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticketId` int(10) unsigned NOT NULL,
  `assetId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ticketToAssetId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticketToAsset`
--

LOCK TABLES `ticketToAsset` WRITE;
/*!40000 ALTER TABLE `ticketToAsset` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticketToAsset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticketToAttachment`
--

DROP TABLE IF EXISTS `ticketToAttachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticketToAttachment` (
  `ticketToAttachment` int(11) NOT NULL AUTO_INCREMENT,
  `ticketId` int(11) DEFAULT NULL,
  `attachmentId` int(11) DEFAULT NULL,
  PRIMARY KEY (`ticketToAttachment`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticketToAttachment`
--

LOCK TABLES `ticketToAttachment` WRITE;
/*!40000 ALTER TABLE `ticketToAttachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticketToAttachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticketToInsuranceRepairComplete`
--

DROP TABLE IF EXISTS `ticketToInsuranceRepairComplete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticketToInsuranceRepairComplete` (
  `ticketToInsuranceRepairCompleteId` int(11) NOT NULL AUTO_INCREMENT,
  `ticketId` int(11) DEFAULT NULL,
  `insuranceRepairCompleteId` int(11) DEFAULT NULL,
  PRIMARY KEY (`ticketToInsuranceRepairCompleteId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticketToInsuranceRepairComplete`
--

LOCK TABLES `ticketToInsuranceRepairComplete` WRITE;
/*!40000 ALTER TABLE `ticketToInsuranceRepairComplete` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticketToInsuranceRepairComplete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `historyId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL DEFAULT '0',
  `adOrderId` int(10) unsigned NOT NULL DEFAULT '0',
  `actionDate` datetime NOT NULL,
  `action` text NOT NULL,
  PRIMARY KEY (`historyId`),
  KEY `adOrderId` (`adOrderId`)
) ENGINE=MyISAM AUTO_INCREMENT=9396 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
INSERT INTO `history` VALUES (9395,1,0,'2013-11-07 08:46:31','Logged in');
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-11-07  8:46:56
