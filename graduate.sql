-- MySQL dump 10.13  Distrib 5.7.24, for osx10.13 (x86_64)
--
-- Host: localhost    Database: graduate
-- ------------------------------------------------------
-- Server version	5.7.24

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
-- Table structure for table `Customers`
--

DROP TABLE IF EXISTS `Customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Customers` (
  `CustomerID` char(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Contactname` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `EmployeeID` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Zip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `Phone` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `Fax` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `Email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  UNIQUE KEY `customers_customerid_unique` (`CustomerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Employees`
--

DROP TABLE IF EXISTS `Employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Employees` (
  `EmployeeID` char(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmployeeName` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `Gender` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `BirthDate` date NOT NULL,
  `Hiredate` date NOT NULL,
  `HomePhone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `OfficePhone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `Fax` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `Mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `QQ` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `Email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  UNIQUE KEY `employees_employeeid_unique` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `adminId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `telephone` char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `loginTimes` int(11) NOT NULL DEFAULT '0',
  `lastLoginIp` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastLoginTime` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`adminId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `attention`
--

DROP TABLE IF EXISTS `attention`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attention` (
  `attentionId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `resourceId` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `changed` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`attentionId`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city` (
  `cityId` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `code` char(12) DEFAULT NULL,
  `provinceCode` char(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `companyData`
--

DROP TABLE IF EXISTS `companyData`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companyData` (
  `CustomerName` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Province_City` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contract`
--

DROP TABLE IF EXISTS `contract`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contract` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conveyance`
--

DROP TABLE IF EXISTS `conveyance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conveyance` (
  `conveyanceId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `province` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `length` double(8,2) NOT NULL,
  `width` double(8,2) NOT NULL,
  `height` double(8,2) NOT NULL,
  `price` double(8,2) NOT NULL,
  `number` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maxWeight` double(8,2) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagePath` text COLLATE utf8mb4_unicode_ci,
  `usedStatus` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `checkedStatus` char(2) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `checkedTime` datetime DEFAULT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`conveyanceId`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conveyanceOrder`
--

DROP TABLE IF EXISTS `conveyanceOrder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conveyanceOrder` (
  `orderId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `resourceId` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `province` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` int(11) NOT NULL,
  `distance` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `replyContent` text COLLATE utf8mb4_unicode_ci,
  `amount` double(8,2) NOT NULL,
  `score` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`orderId`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `countryId` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `code` char(12) DEFAULT NULL,
  `cityCode` char(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `goods`
--

DROP TABLE IF EXISTS `goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods` (
  `goodId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `province` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` int(11) NOT NULL,
  `weight` double(8,2) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `price` double(8,2) NOT NULL,
  `goodsImage` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usedStatus` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `checkedStatus` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `checkedTime` datetime DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`goodId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `orderId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `resourceId` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `area` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `rate` int(11) NOT NULL,
  `type` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`orderId`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `province`
--

DROP TABLE IF EXISTS `province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `province` (
  `provinceId` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `code` char(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `storage`
--

DROP TABLE IF EXISTS `storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `storage` (
  `storageId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `warehouseId` int(11) NOT NULL,
  `usedArea` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`storageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `transport`
--

DROP TABLE IF EXISTS `transport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transport` (
  `transportId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `conveyanceId` int(11) NOT NULL,
  `province` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usedArea` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`transportId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` char(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idCard` varchar(18) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `infoStatus` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `usedStatus` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `loginTimes` int(11) NOT NULL DEFAULT '0',
  `lastLoginIp` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastLoginTime` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `blockChainAddress` char(42) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `userInfo`
--

DROP TABLE IF EXISTS `userInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userInfo` (
  `username` varchar(20) NOT NULL,
  `gender` char(3) NOT NULL,
  `idCard` char(18) NOT NULL,
  `province_city` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `warehouse`
--

DROP TABLE IF EXISTS `warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warehouse` (
  `warehouseId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `category` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `environment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `length` double(8,2) NOT NULL,
  `width` double(8,2) NOT NULL,
  `height` double(8,2) NOT NULL,
  `number` int(11) NOT NULL DEFAULT '1',
  `imagePath` text COLLATE utf8mb4_unicode_ci,
  `usedStatus` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `checkedStatus` char(2) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `checkedTime` datetime DEFAULT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`warehouseId`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `warehouseOrder`
--

DROP TABLE IF EXISTS `warehouseOrder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warehouseOrder` (
  `orderId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `resourceId` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `area` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `replyContent` text COLLATE utf8mb4_unicode_ci,
  `amount` double(8,2) NOT NULL,
  `score` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rentDays` int(11) DEFAULT NULL,
  PRIMARY KEY (`orderId`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-21 14:19:32
