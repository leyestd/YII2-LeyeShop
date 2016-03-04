-- MySQL dump 10.13  Distrib 5.6.24, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: leyeshop
-- ------------------------------------------------------
-- Server version	5.6.26

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
-- Table structure for table `auth`
--

DROP TABLE IF EXISTS `auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `source_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-auth-user_id-user-id_idx` (`user_id`),
  CONSTRAINT `fk-auth-user_id-user-id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth`
--

LOCK TABLES `auth` WRITE;
/*!40000 ALTER TABLE `auth` DISABLE KEYS */;
INSERT INTO `auth` VALUES (4,1,'qq','9D985C284410D83337EDE9B78E5A51F0'),(5,19,'qq','AEB496C04BE8563D5098FEBAB42A9C3A'),(7,18,'qq','57B52930E466E53F7F82F779FE58BD80'),(8,21,'qq','049F7AC430A45334AF66FDAD6769A435'),(9,22,'qq','2760105EAFFDED491974DEBC9AFF52E1'),(10,24,'qq','2E889CE4E3840E95E8A164963BD24948');
/*!40000 ALTER TABLE `auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('administrator','1',1439433130);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('/*',2,NULL,NULL,NULL,1439437931,1439437931),('administrator',1,'管理员',NULL,NULL,1431925230,1431925230);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('administrator','/*');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-category-parent_id-category-id` (`parent_id`),
  CONSTRAINT `fk-category-parent_id-category-id` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (11,NULL,'灯饰照明','吊灯  | 吸顶灯  | 落地灯  | 台灯  | 壁灯  | 灯具套装  | LED灯/光源'),(12,NULL,'厨房用品','厨盆/水槽  | 厨房龙头  | 角阀  | 厨房挂件  | 其他厨房配件  | 定制橱柜 '),(13,NULL,'卫浴用品','浴缸  | 浴室柜  | 座便器  | 淋浴房  | 花洒  | 卫浴龙头  | 卫浴挂件  | 地漏  | 洗面盆  | 蹲便器  | 座便器盖板  | 沐浴桶/沐浴盆  | 卫浴套装  | 其他卫浴配件  | 浴霸  | 吊顶  | 冲水箱  '),(14,NULL,'家装五金','开关插座   | 锁具  | 测量工具  | 门吸  | 合页  | 管道  | 配电箱  | 拉手'),(15,NULL,'墙地面','瓷砖  | 门  | 楼梯  | 墙纸  | 地板  | 油漆  | 辅助材料 '),(16,NULL,'安装服务','卫浴安装  | 地板安装  | 门安装  | 灯饰安装 '),(17,11,'吊灯','吊灯'),(18,11,'吸顶灯','吸顶灯'),(19,11,'落地灯','落地灯'),(20,11,'台灯','台灯'),(21,11,'壁灯','壁灯'),(22,11,'灯具套装','灯具套装'),(23,11,'LED灯/光源','LED灯/光源'),(24,12,'厨盆/水槽','厨盆/水槽'),(25,12,'厨房龙头','厨房龙头'),(26,12,'角阀','角阀'),(27,12,'厨房挂件','厨房挂件'),(28,12,'其他厨房配件','其他厨房配件'),(29,12,'定制橱柜','定制橱柜'),(30,13,'浴缸','浴缸'),(31,13,'浴室柜','浴室柜'),(32,13,'座便器','座便器'),(33,13,'淋浴房','淋浴房'),(34,13,'花洒','花洒'),(35,13,'卫浴龙头','卫浴龙头'),(36,13,'卫浴挂件','卫浴挂件'),(37,13,'地漏','地漏'),(38,13,'洗面盆','洗面盆'),(39,13,'蹲便器','蹲便器'),(40,13,'座便器盖板','座便器盖板'),(41,13,'沐浴桶/沐浴盆','沐浴桶/沐浴盆'),(42,13,'卫浴套装','卫浴套装'),(43,13,'其他卫浴配件','其他卫浴配件'),(44,13,'浴霸','浴霸'),(46,13,'冲水箱','冲水箱'),(47,14,'开关插座','开关插座'),(48,14,'锁具','锁具'),(49,14,'测量工具','测量工具'),(50,14,'门吸','门吸'),(51,14,'合页','合页'),(52,14,'管道','管道'),(53,14,'配电箱','配电箱'),(54,14,'拉手','拉手'),(55,15,'瓷砖','瓷砖'),(56,15,'门','门'),(57,15,'楼梯','楼梯'),(58,15,'墙纸','墙纸'),(60,15,'油漆','油漆'),(62,16,'卫浴安装','卫浴安装'),(63,16,'地板安装','地板安装'),(64,16,'门安装','门安装'),(65,16,'灯饰安装','灯饰安装');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_attr`
--

DROP TABLE IF EXISTS `category_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_attribute_category_fk1_idx` (`category_id`),
  CONSTRAINT `fk_category_attr_category_fk1` FOREIGN KEY (`category_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_attr`
--

LOCK TABLES `category_attr` WRITE;
/*!40000 ALTER TABLE `category_attr` DISABLE KEYS */;
INSERT INTO `category_attr` VALUES (5,'品牌','华为',0,17),(6,'灯源类型','LED灯',1,17),(7,'灯具色温','冷光(白光）',2,17),(8,'灯具螺口','E27大螺口',2,17),(9,'灯具功率','10W以下',4,17),(10,'日用品产地','中国大陆',6,17),(11,'灯泡形状','球形',6,17);
/*!40000 ALTER TABLE `category_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productSku_id` int(11) DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-image-product_id-product_id` (`productSku_id`),
  CONSTRAINT `fk_image_productSku_fk1` FOREIGN KEY (`productSku_id`) REFERENCES `product_sku` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image`
--

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` VALUES (8,3,NULL,NULL),(9,4,NULL,NULL),(10,5,NULL,NULL),(11,6,NULL,NULL),(12,7,NULL,NULL),(13,8,NULL,NULL),(14,9,NULL,NULL),(15,10,NULL,NULL),(16,11,NULL,NULL),(17,12,NULL,NULL),(18,13,NULL,NULL),(19,14,NULL,NULL),(20,15,NULL,NULL),(21,16,NULL,NULL),(22,17,NULL,NULL),(23,18,NULL,NULL),(24,19,NULL,NULL),(25,20,NULL,NULL),(26,21,NULL,NULL),(27,22,NULL,NULL),(28,23,NULL,NULL),(30,24,NULL,NULL),(31,25,NULL,NULL),(33,26,NULL,NULL),(34,27,NULL,NULL),(35,28,NULL,NULL),(36,29,NULL,NULL),(37,30,NULL,NULL),(38,31,NULL,NULL),(39,32,NULL,NULL),(40,33,NULL,NULL),(41,34,NULL,NULL),(42,35,NULL,NULL),(44,36,NULL,NULL),(46,37,NULL,NULL),(48,38,NULL,NULL),(49,39,NULL,NULL),(50,40,NULL,NULL),(51,41,NULL,NULL),(52,42,NULL,NULL),(53,43,NULL,NULL),(54,44,NULL,NULL),(55,45,NULL,NULL),(56,46,NULL,NULL),(57,47,NULL,NULL),(58,48,NULL,NULL),(59,51,NULL,NULL),(60,52,NULL,NULL),(61,53,NULL,NULL),(62,54,NULL,NULL);
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1427343684),('m130524_201442_init',1427343691),('m140506_102106_rbac_init',1431916729),('m140602_111327_create_menu_table',1428388948),('m141123_221351_shop',1427343696);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `status` tinyint(4) DEFAULT NULL,
  `logistics` tinyint(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `alinumber` varchar(255) DEFAULT NULL,
  `trade_status` varchar(255) DEFAULT NULL,
  `refund_status` varchar(255) DEFAULT NULL,
  `experience` tinyint(4) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `orderNumber` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_user_fk1_idx` (`user_id`),
  KEY `order_user_fk2_idx` (`recipient_id`),
  CONSTRAINT `order_user_fk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `order_user_fk2` FOREIGN KEY (`recipient_id`) REFERENCES `recipient` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (96,1437450289,1437450325,'ertgert',0,0,1,5,'2015072100001000720076074966','WAIT_BUYER_PAY',NULL,NULL,NULL,'2015072111444996'),(97,1437450782,1437549437,'yu',10,0,1,5,'2015072100001000720076075476','WAIT_SELLER_SEND_GOODS',NULL,NULL,NULL,'2015072111530297'),(98,1437451266,1437455217,'',111,0,1,5,NULL,NULL,NULL,NULL,NULL,'2015072112010698'),(99,1437458571,1437461266,'',111,0,1,5,NULL,NULL,NULL,NULL,NULL,'2015072114025199'),(100,1437461975,1437483996,'',10,10,18,10,'2015072100001000720076088466','TRADE_FINISHED','REFUND_CLOSED',NULL,NULL,'20150721145935100'),(101,1437462944,1437484648,'',10,10,18,10,'2015072100001000720076089712','WAIT_BUYER_CONFIRM_GOODS','REFUND_SUCCESS',NULL,NULL,'20150721151544101'),(102,1437465466,1437465481,'',111,0,18,10,NULL,NULL,NULL,NULL,NULL,'20150721155746102'),(103,1437465491,1437483705,'政',10,10,18,10,'2015072100001000720076094980','TRADE_FINISHED',NULL,NULL,NULL,'20150721155811103'),(104,1437485206,1437485382,'',10,10,1,5,'2015072100001000720076118789','TRADE_FINISHED','REFUND_CLOSED',NULL,NULL,'20150721212646104'),(105,1437485429,1437571892,'',10,0,1,5,'2015072100001000720076119129','WAIT_SELLER_SEND_GOODS',NULL,NULL,NULL,'20150721213029105'),(106,1437485538,1437639845,'',10,10,1,5,'2015072100001000720076119236','TRADE_FINISHED','REFUND_CLOSED',2,'还不错','20150721213218106'),(107,1437526237,1437634051,'wrwerwe',10,0,1,5,'2015072200001000720076163372','WAIT_SELLER_SEND_GOODS',NULL,NULL,NULL,'20150722085037107'),(108,1437530982,1437617492,'',10,0,1,5,'2015072200001000720076143683','WAIT_SELLER_SEND_GOODS',NULL,NULL,NULL,'20150722100942108'),(109,1437531487,1437617974,'',10,0,1,5,'2015072200001000720076144431','WAIT_SELLER_SEND_GOODS',NULL,NULL,NULL,'20150722101807109'),(110,1437629635,1437716134,'779',10,0,1,5,'2015072300001000720076233070','WAIT_SELLER_SEND_GOODS',NULL,NULL,NULL,'20150723133355110'),(111,1437641690,1437641690,'rthrth',0,0,1,5,NULL,NULL,NULL,NULL,NULL,'20150723165450111'),(112,1437641746,1437641746,'',0,0,22,11,NULL,NULL,NULL,NULL,NULL,'20150723165546112'),(113,1437709759,1437709759,'',0,0,1,5,NULL,NULL,NULL,NULL,NULL,'20150724114919113'),(114,1437710294,1437710485,'',111,0,1,5,NULL,NULL,NULL,NULL,NULL,'20150724115814114'),(115,1437718040,1437718040,'',0,0,23,12,NULL,NULL,NULL,NULL,NULL,'20150724140720115'),(116,1438757769,1439362621,'TRHRTH',0,0,1,5,'2015080500001000720077315129','TRADE_CLOSED',NULL,NULL,NULL,'20150805145609116'),(117,1438760244,1438760244,'',0,0,1,5,NULL,NULL,NULL,NULL,NULL,'20150805153724117'),(118,1438865588,1438865588,'',0,0,28,13,NULL,NULL,NULL,NULL,NULL,'20150806205308118'),(119,1438998238,1438998238,'',0,0,29,14,NULL,NULL,NULL,NULL,NULL,'20150808094358119'),(120,1439349347,1439349347,'',0,0,31,15,NULL,NULL,NULL,NULL,NULL,'20150812111547120'),(121,1439431370,1439431370,'',0,0,33,16,NULL,NULL,NULL,NULL,NULL,'20150813100250121'),(122,1439431462,1439431476,'rthrh',111,0,1,5,NULL,NULL,NULL,NULL,NULL,'20150813100422122'),(123,1439435463,1439435463,'',0,0,35,17,NULL,NULL,NULL,NULL,NULL,'20150813111103123');
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `productSku_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-order_item-order_id-order-id` (`order_id`),
  KEY `fk-order_item-product_id-product-id` (`productSku_id`),
  CONSTRAINT `fk-order_item-order_id-order-id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk-order_item-product_id-product-id` FOREIGN KEY (`productSku_id`) REFERENCES `product_sku` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_item`
--

LOCK TABLES `order_item` WRITE;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` VALUES (103,96,NULL,156.00,7,1),(104,97,NULL,0.01,3,1),(105,98,NULL,0.01,3,2),(106,99,NULL,0.01,3,1),(107,100,NULL,0.01,3,1),(108,101,NULL,0.01,3,1),(109,102,NULL,0.01,3,1),(110,103,NULL,0.01,3,2),(111,104,NULL,0.01,3,2),(112,105,NULL,0.01,3,1),(113,106,NULL,0.01,3,1),(114,107,NULL,0.01,3,1),(115,108,NULL,0.01,3,1),(116,109,NULL,0.01,3,1),(117,110,NULL,0.01,3,1),(118,111,NULL,0.01,3,8),(119,112,NULL,0.01,3,1),(120,113,NULL,0.01,3,1),(121,114,NULL,600.00,45,1),(122,115,NULL,0.01,3,2),(123,116,NULL,0.01,3,12),(124,116,NULL,156.00,7,1),(125,117,NULL,925.00,4,1),(126,118,NULL,0.01,3,3),(127,119,NULL,0.01,3,2),(128,120,NULL,0.01,3,2),(129,121,NULL,0.01,3,1),(130,122,NULL,0.01,3,1),(131,123,NULL,0.01,3,2);
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `introduce` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-product-category_id-category_id` (`category_id`),
  CONSTRAINT `fk-product-category_id-category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (3,'六头吊灯-测试支付','源自欧洲唯美设计，优雅，简约，卓尔不凡！环保优质树脂，不易变形，抗击力度高，唯美雕花，更显古典艺术！',17),(4,'分段式吸顶灯','产品外观设计专利，14个E27灯头，高级磨砂白玉玻璃，镜面不锈钢底盘，具备强光，弱光，LED光等不同光学效果！',18),(5,'卧室客厅落地灯','优质拉丝布艺灯罩+香槟金色吊珠，透光柔和，营造唯美浪漫氛围，透明树脂内雕水仙花中柱，手工描金底盘，彰显无尽端庄优雅！',19),(6,'陶瓷装饰台灯','中式台灯 高档卧室床头单色釉陶瓷装饰台灯 柚子绿款',20),(7,'一头水晶树脂壁灯','玻璃灯罩，纯手工上色，高温烘干，永不褪色；唯美雕花，精雕细琢，融入现代艺术，更显典雅和高贵！',21),(8,'欧美优质有机玻璃灯具6套装','8头吊灯+1头吊灯+吸顶灯+壁灯+台灯+射灯,完美组合，照亮温馨居家环境！有机玻璃灯罩，精湛烤漆工艺，强力吸盘，五星品质，耀世璀璨！',22),(9,'3W球泡灯','暖白光',23),(10,'SUS304不锈钢双面拉丝水槽套装','75*40CM 顶级SUS304不锈钢打造，一体成型设计，保用20年！最新双面拉丝工艺，美观大方，全球首发！',24),(11,'奢华钻石系列全铜重量版厨房冷热旋转水龙头','独有的晶钻电镀工艺和钻石般切面造型，如钻石一样璀璨',25),(12,' 九牧全铜加厚冷热水三角阀','防爆角阀 止水阀74038',26),(13,'厨房挂件置物架套餐','全网功能最全厨房挂件组合',27),(14,'不锈钢实心沥水篮','纯不锈钢实心打造，表面电镀工艺，不生锈，不脱焊，使用方便，厨房必备',28),(15,'日内瓦树脂板系列定制橱柜','价格为定金，详情可咨询在线客服',29),(16,'扇形按摩浴缸','3MM超厚亚克力材质，质地柔和，保温保暖！独特冲浪设计，冲力强劲，在家享受至尊SPA！',30),(17,'进口橡木双盆浴室柜','现代落地式实木浴室柜',31),(18,'陶瓷节水马桶 ','1280度高温烧制纯瓷，坚固不开裂，纳米环保自洁釉技术，彻底杜绝污垢、细菌，双档排水，高效节水，流畅外型，时尚大气！',32),(19,'欧式古典淋浴房','国家3C认证钢化玻璃，值得信赖，进口不锈钢轮滑，开合更顺畅，优质铝材外框，防腐防潮，三层钢化玻璃置物架，贴心便捷！',33),(20,'环保绿色升降花洒套装','主体全铜材质，精美铸造！大气顶喷，出水顺畅！小巧花洒，造型独特！高强度阀芯，现代风格，韵味悠长！',34),(21,'全铜冷热水面盆龙头','全铜铸造，表面多层电镀工艺，出水柔和，含铅量远低于行业标准，环保健康首选！',35),(22,'太空铝仿古卫浴六件套','顶级环保太空铝，不易生锈褪色；五层冷抛光，缔造完美抛光；仿古式设计，打造高端大气品位！',36),(23,'全铜自封水式防臭 防反水地漏','最新推崇款式， 采用精铜铸造，永不生锈，经久耐用，底部始终保持密封状态，真正远离臭气污染！',37),(24,' 时尚陶瓷立柱洗脸盆','采用纳米技术，超平滑表面！进口釉料配方，持久耐用。抗菌、无辐射，时刻呵护家人健康。',38),(25,'陶瓷蹲便器','高岭土烧制优质瓷体，独特洁釉技术，永保光洁，持久抗菌，贴心防滑设计，使用安全，完美外形，独具匠心！',39),(26,'智能座便器盖 马桶盖','简约智能坐便器马桶盖，集多功能于一体，360度全方位洁身。为您解决难言之隐，带来健康便捷生活。',40),(27,'木桶','野生香柏木人工制作，天然材质，环保保温，无需安装，爱美女士首选，小户型不能安浴缸首选。(由于物品大件此商品的快递费用均为物流费用，需客户到物流点自提',41),(28,'九牧浴室柜组合','淋浴简易花洒 坐便器 不锈钢五金挂件套装包安装',42),(29,'不锈钢面盆排水管','不锈钢材质美观大方 ，内部胶皮管，双层保护更耐用。水封设计防臭下水管。存水式设计，可以防止臭气泛出',43),(30,'铝合金面板浴霸','取暖、换气、照明、多功能四灯浴霸，五年质保，集成吊顶专用安装使用。',44),(31,'蹲便器水箱','藏纸式挂壁蹲便器水箱',46),(32,'香槟色雕花面板系列','一居室26只实用套装加送防水盒',47),(33,'黑色雨果门锁','高级黑色太空铝，高端大气上档次！超值大酬宾，错过一次，后悔十年！',48),(34,'GreatWall 通用工具套装','荣获2013中国品牌100强 经久耐用 做工精湛 质量上乘',49),(35,'合金门吸','进口拉丝金锌合金门吸 门吸地吸 超强吸力门吸',50),(36,'进口青古铜不锈钢合页','全数控自动化精细工艺打造，优质不锈钢抗腐蚀、不易氧化生锈，精致生活从细节开始。',51),(37,'PP-R管道系统','德国原装进口PP-R管道系统 20 1/2 内丝三通 阴丝三通',52),(38,'带漏电保护断路器 ','西门子 绿色系类 微断 4P 63A 带漏电保护断路器',53),(39,'厨房衣柜门抽屉拉手把手','欧式青古铜小拉手 厨房衣柜门抽屉拉手把手',54),(40,'防潮白色乳胶漆','20KG超值装，创新防潮科技，保持墙面干爽不潮湿',60),(41,' 米黄色釉面瓷砖600*600','万人追捧，持续热销！进口釉料，质感细腻，釉面平整，色泽圆润，精工磨边，无缝铺贴，赋予爱家别具一格的魅力！',55),(42,'地中海风格实木门','新款首发地中海风格实木复合室内门厨房实木门全屋定制门H系列 冰纹白玻璃门',56),(43,'实木钢木复式旋转楼梯','实木钢木复式旋转玻璃阁楼室内别墅楼梯扶手立柱踏板欧式简约 阿莱雅 ',57),(44,'印花PVC墙纸','粉色花朵墙纸 印花PVC墙纸 儿童房壁纸 ',58),(45,'卫浴上门安装服务 ','智能整体淋浴房安装服务',62),(46,'地板上门安装服务','强化地板安装服务 家居安装 ',63),(47,'防盗门安装','防盗门上门安装服务 防盗门安装',64),(48,'灯饰上门安装服务','灯具安装服务 水晶灯安装',65),(51,'ewfwef','wefwef',11);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_attr`
--

DROP TABLE IF EXISTS `product_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_attr_product_fk1_idx` (`product_id`),
  CONSTRAINT `fk_product_attr_product_fk1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_attr`
--

LOCK TABLES `product_attr` WRITE;
/*!40000 ALTER TABLE `product_attr` DISABLE KEYS */;
INSERT INTO `product_attr` VALUES (5,'品牌','华为',0,3),(6,'灯源类型','LED灯',1,3),(7,'灯具色温','冷光(白光）',2,3),(8,'灯具螺口','E27大螺口',2,3),(9,'灯具功率','10W以下',4,3),(10,'日用品产地','中国大陆',6,3),(11,'灯泡形状','球形',6,3);
/*!40000 ALTER TABLE `product_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_sku`
--

DROP TABLE IF EXISTS `product_sku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_sku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `skucode` varchar(255) DEFAULT NULL,
  `skuinfo` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `introduce` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount` int(11) NOT NULL DEFAULT '100',
  `status` tinyint(4) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`),
  KEY `fk_product_sku_product_fk1_1_idx` (`product_id`),
  CONSTRAINT `fk_product_sku_product_fk1_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_sku`
--

LOCK TABLES `product_sku` WRITE;
/*!40000 ALTER TABLE `product_sku` DISABLE KEYS */;
INSERT INTO `product_sku` VALUES (3,3,'4','blue-big-mm','六头吊灯-测试支付','源自欧洲唯美设计，优雅，简约，卓尔不凡！环保优质树脂，不易变形，抗击力度高，唯美雕花，更显古典艺术！','<h4>源自欧洲唯美设计，优雅，简约，卓尔不凡！环保优质树脂，不易变形，抗击力度高，唯美雕花，更显古典艺术！</h4>',0.01,100,100,10),(4,4,'4','','分段式吸顶灯','产品外观设计专利，14个E27灯头，高级磨砂白玉玻璃，镜面不锈钢底盘，具备强光，弱光，LED光等不同光学效果！','<h4>产品外观设计专利，14个E27灯头，高级磨砂白玉玻璃，镜面不锈钢底盘，具备强光，弱光，LED光等不同光学效果！</h4>\r\n',925.00,100,100,10),(5,5,'4','','卧室客厅落地灯','优质拉丝布艺灯罩+香槟金色吊珠，透光柔和，营造唯美浪漫氛围，透明树脂内雕水仙花中柱，手工描金底盘，彰显无尽端庄优雅！','<h4>优质拉丝布艺灯罩+香槟金色吊珠，透光柔和，营造唯美浪漫氛围，透明树脂内雕水仙花中柱，手工描金底盘，彰显无尽端庄优雅！</h4>\r\n',565.00,100,100,10),(6,6,'4','5','陶瓷装饰台灯','中式台灯 高档卧室床头单色釉陶瓷装饰台灯 柚子绿款','<p>rtyrty<br/></p>',698.00,100,100,10),(7,7,'4','5','一头水晶树脂壁灯','玻璃灯罩，纯手工上色，高温烘干，永不褪色；唯美雕花，精雕细琢，融入现代艺术，更显典雅和高贵！','<h4>玻璃灯罩，纯手工上色，高温烘干，永不褪色；唯美雕花，精雕细琢，融入现代艺术，更显典雅和高贵！</h4>\r\n',156.00,100,100,10),(8,8,'4','5','欧美优质有机玻璃灯具6套装','8头吊灯+1头吊灯+吸顶灯+壁灯+台灯+射灯,完美组合，照亮温馨居家环境！有机玻璃灯罩，精湛烤漆工艺，强力吸盘，五星品质，耀世璀璨！','<h4>完美组合，照亮温馨居家环境！有机玻璃灯罩，精湛烤漆工艺，强力吸盘，五星品质，耀世璀璨！</h4>\r\n',1629.00,100,100,10),(9,9,'4','5','3W球泡灯','暖白光','<p>暖白光</p>\r\n',11.00,100,100,10),(10,10,'4','5','SUS304不锈钢双面拉丝水槽套装','75*40CM 顶级SUS304不锈钢打造，一体成型设计，保用20年！最新双面拉丝工艺，美观大方，全球首发！','<p>75*40CM 顶级SUS304不锈钢打造，一体成型设计，保用20年！最新双面拉丝工艺，美观大方，全球首发！</p>\r\n',499.00,100,100,10),(11,11,'4','5','奢华钻石系列全铜重量版厨房冷热旋转水龙头','独有的晶钻电镀工艺和钻石般切面造型，如钻石一样璀璨','<h4>独有的晶钻电镀工艺和钻石般切面造型，如钻石一样璀璨</h4>\r\n',389.00,100,100,10),(12,12,'4','5',' 九牧全铜加厚冷热水三角阀','防爆角阀 止水阀74038','<h4>防爆角阀 止水阀74038</h4>\r\n',9.90,100,100,10),(13,13,'4','5','厨房挂件置物架套餐','全网功能最全厨房挂件组合','<h4>全网功能最全厨房挂件组合</h4>\r\n',169.00,100,100,10),(14,14,'4','5','不锈钢实心沥水篮','纯不锈钢实心打造，表面电镀工艺，不生锈，不脱焊，使用方便，厨房必备','<h4>纯不锈钢实心打造，表面电镀工艺，不生锈，不脱焊，使用方便，厨房必备</h4>\r\n',23.00,100,100,10),(15,15,'4','5','日内瓦树脂板系列定制橱柜','价格为定金，详情可咨询在线客服','<h4>价格为定金，详情可咨询在线客服</h4>\r\n',1000.00,100,100,10),(16,16,'4','5','扇形按摩浴缸','3MM超厚亚克力材质，质地柔和，保温保暖！独特冲浪设计，冲力强劲，在家享受至尊SPA！','<h4>3MM超厚亚克力材质，质地柔和，保温保暖！独特冲浪设计，冲力强劲，在家享受至尊SPA！</h4>\r\n',5360.00,100,100,10),(17,17,'4','5','进口橡木双盆浴室柜','现代落地式实木浴室柜','<h4>现代落地式实木浴室柜</h4>\r\n',1560.00,100,100,10),(18,18,'4','5','陶瓷节水马桶 ','1280度高温烧制纯瓷，坚固不开裂，纳米环保自洁釉技术，彻底杜绝污垢、细菌，双档排水，高效节水，流畅外型，时尚大气！','<h4>1280度高温烧制纯瓷，坚固不开裂，纳米环保自洁釉技术，彻底杜绝污垢、细菌，双档排水，高效节水，流畅外型，时尚大气！</h4>\r\n',868.00,100,100,10),(19,19,'4','5','欧式古典淋浴房','国家3C认证钢化玻璃，值得信赖，进口不锈钢轮滑，开合更顺畅，优质铝材外框，防腐防潮，三层钢化玻璃置物架，贴心便捷！','<h4>国家3C认证钢化玻璃，值得信赖，进口不锈钢轮滑，开合更顺畅，优质铝材外框，防腐防潮，三层钢化玻璃置物架，贴心便捷！</h4>\r\n',1600.00,100,100,10),(20,20,'4','5','环保绿色升降花洒套装','主体全铜材质，精美铸造！大气顶喷，出水顺畅！小巧花洒，造型独特！高强度阀芯，现代风格，韵味悠长！','<h4>主体全铜材质，精美铸造！大气顶喷，出水顺畅！小巧花洒，造型独特！高强度阀芯，现代风格，韵味悠长！</h4>\r\n',650.00,100,100,10),(21,21,'4','5','全铜冷热水面盆龙头','全铜铸造，表面多层电镀工艺，出水柔和，含铅量远低于行业标准，环保健康首选！','<p>全铜铸造，表面多层电镀工艺，出水柔和，含铅量远低于行业标准，环保健康首选！</p>\r\n',120.00,100,100,10),(22,22,'4','5','太空铝仿古卫浴六件套','顶级环保太空铝，不易生锈褪色；五层冷抛光，缔造完美抛光；仿古式设计，打造高端大气品位！','<p>顶级环保太空铝，不易生锈褪色；五层冷抛光，缔造完美抛光；仿古式设计，打造高端大气品位！</p>\r\n',460.00,100,100,10),(23,23,'4','5','全铜自封水式防臭 防反水地漏','最新推崇款式， 采用精铜铸造，永不生锈，经久耐用，底部始终保持密封状态，真正远离臭气污染！','<h4>最新推崇款式， 采用精铜铸造，永不生锈，经久耐用，底部始终保持密封状态，真正远离臭气污染！</h4>\r\n',39.00,100,100,10),(24,24,'4','5',' 时尚陶瓷立柱洗脸盆','采用纳米技术，超平滑表面！进口釉料配方，持久耐用。抗菌、无辐射，时刻呵护家人健康。','<h4>采用纳米技术，超平滑表面！进口釉料配方，持久耐用。抗菌、无辐射，时刻呵护家人健康。</h4>\r\n',175.00,100,100,10),(25,25,'4','5','陶瓷蹲便器','高岭土烧制优质瓷体，独特洁釉技术，永保光洁，持久抗菌，贴心防滑设计，使用安全，完美外形，独具匠心！','<h4>高岭土烧制优质瓷体，独特洁釉技术，永保光洁，持久抗菌，贴心防滑设计，使用安全，完美外形，独具匠心！</h4>\r\n',135.00,100,100,10),(26,26,'4','5','智能座便器盖 马桶盖','简约智能坐便器马桶盖，集多功能于一体，360度全方位洁身。为您解决难言之隐，带来健康便捷生活。','<h4>简约智能坐便器马桶盖，集多功能于一体，360度全方位洁身。为您解决难言之隐，带来健康便捷生活。</h4>\r\n',1088.00,100,100,10),(27,27,'4','5','木桶','野生香柏木人工制作，天然材质，环保保温，无需安装，爱美女士首选，小户型不能安浴缸首选。(由于物品大件此商品的快递费用均为物流费用，需客户到物流点自提','<h4>野生香柏木人工制作，天然材质，环保保温，无需安装，爱美女士首选，小户型不能安浴缸首选。(由于物品大件此商品的快递费用均为物流费用，需客户到物流点自提</h4>\r\n',12000.00,100,100,10),(28,28,'4','5','九牧浴室柜组合','淋浴简易花洒 坐便器 不锈钢五金挂件套装包安装','<h4>淋浴简易花洒 坐便器 不锈钢五金挂件套装包安装</h4>\r\n',3999.00,100,100,10),(29,29,'4','5','不锈钢面盆排水管','不锈钢材质美观大方 ，内部胶皮管，双层保护更耐用。水封设计防臭下水管。存水式设计，可以防止臭气泛出','<h4>不锈钢材质美观大方 ，内部胶皮管，双层保护更耐用。水封设计防臭下水管。存水式设计，可以防止臭气泛出</h4>\r\n',20.00,100,100,10),(30,30,'4','5','铝合金面板浴霸','取暖、换气、照明、多功能四灯浴霸，五年质保，集成吊顶专用安装使用。','<h4>取暖、换气、照明、多功能四灯浴霸，五年质保，集成吊顶专用安装使用。</h4>\r\n',199.00,100,100,10),(31,31,'4','5','蹲便器水箱','藏纸式挂壁蹲便器水箱','<h4>藏纸式挂壁蹲便器水箱</h4>\r\n',189.00,100,100,10),(32,32,'4','5','香槟色雕花面板系列','一居室26只实用套装加送防水盒','<h4>一居室26只实用套装加送防水盒</h4>\r\n',348.00,100,100,10),(33,33,'4','5','黑色雨果门锁','高级黑色太空铝，高端大气上档次！超值大酬宾，错过一次，后悔十年！','<h4>高级黑色太空铝，高端大气上档次！超值大酬宾，错过一次，后悔十年！</h4>\r\n',216.00,100,100,10),(34,34,'4','5','GreatWall 通用工具套装','荣获2013中国品牌100强 经久耐用 做工精湛 质量上乘','<h4>荣获2013中国品牌100强 经久耐用 做工精湛 质量上乘</h4>\r\n',76.00,100,100,10),(35,35,'4','5','合金门吸','进口拉丝金锌合金门吸 门吸地吸 超强吸力门吸','<h4>进口拉丝金锌合金门吸 门吸地吸 超强吸力门吸</h4>\r\n',26.00,100,100,10),(36,36,'4','5','进口青古铜不锈钢合页','全数控自动化精细工艺打造，优质不锈钢抗腐蚀、不易氧化生锈，精致生活从细节开始。','<h4>全数控自动化精细工艺打造，优质不锈钢抗腐蚀、不易氧化生锈，精致生活从细节开始。</h4>\r\n',48.00,100,100,10),(37,37,'4','5','PP-R管道系统','德国原装进口PP-R管道系统 20 1/2 内丝三通 阴丝三通','<h4>德国原装进口PP-R管道系统 20 1/2 内丝三通 阴丝三通</h4>\r\n',46.00,100,100,10),(38,38,'4','5','带漏电保护断路器 ','西门子 绿色系类 微断 4P 63A 带漏电保护断路器','<h4>西门子 绿色系类 微断 4P 63A 带漏电保护断路器</h4>\r\n',344.00,100,100,10),(39,39,'4','5','厨房衣柜门抽屉拉手把手','欧式青古铜小拉手 厨房衣柜门抽屉拉手把手','<h4>欧式青古铜小拉手 厨房衣柜门抽屉拉手把手</h4>\r\n',7.30,100,100,10),(40,40,'4','5','防潮白色乳胶漆','20KG超值装，创新防潮科技，保持墙面干爽不潮湿','<h4>20KG超值装，创新防潮科技，保持墙面干爽不潮湿</h4>\r\n',289.00,100,100,10),(41,41,'4','5',' 米黄色釉面瓷砖600*600','万人追捧，持续热销！进口釉料，质感细腻，釉面平整，色泽圆润，精工磨边，无缝铺贴，赋予爱家别具一格的魅力！','<h4>万人追捧，持续热销！进口釉料，质感细腻，釉面平整，色泽圆润，精工磨边，无缝铺贴，赋予爱家别具一格的魅力！</h4>\r\n',21.00,100,100,10),(42,42,'4','5','地中海风格实木门','新款首发地中海风格实木复合室内门厨房实木门全屋定制门H系列 冰纹白玻璃门','<p>新款首发地中海风格实木复合室内门厨房实木门全屋定制门H系列 冰纹白玻璃门</p>\r\n',2680.00,100,100,10),(43,43,'4','5','实木钢木复式旋转楼梯','实木钢木复式旋转玻璃阁楼室内别墅楼梯扶手立柱踏板欧式简约 阿莱雅 ','<h4>实木钢木复式旋转玻璃阁楼室内别墅楼梯扶手立柱踏板欧式简约 阿莱雅&ensp;</h4>\r\n',1000.00,100,100,10),(44,44,'4','5','印花PVC墙纸','粉色花朵墙纸 印花PVC墙纸 儿童房壁纸 ','<h4>粉色花朵墙纸 印花PVC墙纸 儿童房壁纸</h4>\r\n',29.00,100,100,10),(45,45,'4','5','卫浴上门安装服务 ','智能整体淋浴房安装服务','<h4>智能整体淋浴房安装服务</h4>\r\n',600.00,100,100,10),(46,46,'4','5','地板上门安装服务','强化地板安装服务 家居安装 ','<h4>强化地板安装服务 家居安装</h4>\r\n',10.00,100,100,10),(47,47,'4','5','防盗门安装','防盗门上门安装服务 防盗门安装','<p>防盗门上门安装服务 防盗门安装</p>\r\n',180.00,100,100,10),(48,48,'4','5','灯饰上门安装服务','灯具安装服务 水晶灯安装','<h4>灯具安装服务 水晶灯安装灯具安装服务 水晶灯安装dvsdfs安装服务 水晶灯安装</h4>',180.00,100,100,10),(51,51,'4','5','ewfwef','wefwef','<p><img src=\"http://img.baidu.com/hi/jx2/j_0015.gif\"/> &nbsp; &nbsp;<img style=\"width: 380px; height: 325px;\" title=\"1431489261276177.png\" alt=\"scrawl.png\" src=\"/ueditor/php/upload/image/20150513/1431489261276177.png\" height=\"325\" width=\"380\"/></p>',11.00,11,11,10),(52,3,'wwer','blue-big-ll','wer','wewe','<p>wer<br/></p>',34.00,343,34,10),(53,3,'45645','red-mid-ll','456','4564','<p>56<br/></p>',45.00,45,45,10),(54,3,'4353','red-small-mm','345','345','<p>345<br/></p>',345.00,34,34,10);
/*!40000 ALTER TABLE `product_sku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipient`
--

DROP TABLE IF EXISTS `recipient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) NOT NULL,
  `address` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `postcode` varchar(45) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recipient_user_fk1_idx` (`user_id`),
  CONSTRAINT `recipient_user_fk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipient`
--

LOCK TABLES `recipient` WRITE;
/*!40000 ALTER TABLE `recipient` DISABLE KEYS */;
INSERT INTO `recipient` VALUES (5,'051257292471','15950162336','昆山张浦 小区126','汪龙','wef@fdf.com','234223',1),(6,'15985245','13773139372','昆山张浦银河小区126号','张强','wekjf@fdf.co','45646',1),(10,'051257292471','15950162339','昆山张浦镇','汪龙','fwf@dsf.co','215321',18),(11,'','13000000000','某省某市某区县','JH','418864391@qq.com','300000',22),(12,'123123','123123','21312','fesfs','31231@123.com','23123123',23),(13,'234234234','234234324234','2342342','eer\'we\'r','3423423@qq.com','234234',28),(14,'111111111111111','1111111111111','1111111111111111','111','mlboy@126.com','100000',29),(15,'gfhgfhgfh','ghgf','gfhfhfg','jk','gfhgfhfghfg@qq.sdd','dsa',31),(16,'fdsafdasdf','dfsafdsadfds','safsafsaf','sfas','safsafsa@qq.qbc','fsafsafasfsafsaf',33),(17,'4015072','13296662415','sdag','ag','123456@qq.com','400000',35);
/*!40000 ALTER TABLE `recipient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sku`
--

DROP TABLE IF EXISTS `sku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sku_product_id_fk1_idx` (`product_id`),
  CONSTRAINT `fk_sku_product_id_fk1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sku`
--

LOCK TABLES `sku` WRITE;
/*!40000 ALTER TABLE `sku` DISABLE KEYS */;
INSERT INTO `sku` VALUES (1,'颜色','color',3),(2,'尺寸','size',3),(3,'长度','long',3);
/*!40000 ALTER TABLE `sku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sku_attr`
--

DROP TABLE IF EXISTS `sku_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sku_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `sku_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sku_attr_1_fk1_idx` (`sku_id`),
  CONSTRAINT `fk_sku_attr_1_fk1` FOREIGN KEY (`sku_id`) REFERENCES `sku` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sku_attr`
--

LOCK TABLES `sku_attr` WRITE;
/*!40000 ALTER TABLE `sku_attr` DISABLE KEYS */;
INSERT INTO `sku_attr` VALUES (1,'红','red',1),(2,'蓝','blue',1),(3,'大','big',2),(4,'中','mid',2),(5,'小','small',2),(6,'长','ll',3),(7,'短','mm',3);
/*!40000 ALTER TABLE `sku_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `fullname` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','ITrjLQyUAbKMSfACEfD_XcD2jFEqP5MB','$2y$13$N1NrNDnrgSt3avRY9IFnru2.fsGZ0/d86dwjEx6HkHkfG.nnFCeyu',NULL,'303650172@qq.com',10,1427353096,1437460263,'汪龙'),(18,'leyestd','F63NsNTOqz_L2UNJwNWVZR_LK4zYzFoX','$2y$13$U/15I2CqkHEQzeMg8DDeZeSJ8AvBUo2x.J2pNfIOv7G5uyzwNhGM.',NULL,'htht@fdf.com',10,1437461930,1437461930,'leyestd'),(19,'leye','7L-N4lgTyQGIrR-MQqSSSi0iWZ8cNRN-','$2y$13$9PwWXYsxs4jaFik0saC4TOWmjNHaeEdGTXjdT8ePQpXHBvY/3qGjG','1BuyGxv3S-_5D68w3ycPWYiFTakOGY2j_1437464346','wleff@fd.vcom',10,1437464346,1437464346,'leye'),(21,'lee','9Ch0DJubaKwN5Bwb6ZrdBT3M-Ea9oTki','$2y$13$gPbPgqPQqb2jXVH1JrAHTu5cegsnxhXw6MTMVX/Qt1itwOzJOMqrW','r0udYeYde71v0sZ1phW_hiNbeqzHKgNw_1437481667','ffwef@f.com',10,1437481667,1437481667,'eeee'),(22,'qweqwe','0mng_DPhRUUIM6fmrInIqt2IhuhIDTgF','$2y$13$m8uGVfp7lG2MTE/sSKbWQeWXd8I2LsU0XSFw4iuSpFvkZxfeKUGKO','sBLyHQc64jLBcPfipYojfYmRdWRls7l3_1437641642','418864391@qq.com',10,1437641642,1437641642,'qweqwe'),(23,'demo','Z44MEMmfmAmvTFPAYdM1D9IxRhvKjeB8','$2y$13$IZXu4XlfDtDVvY2bkTFfmOjJxzCxFDR0gMJFhBV9pSEguUf3wZOna',NULL,'ad@1.com',10,1437718002,1437718002,'demodaw'),(24,'超级无聊','cwdTH8FSVrkMhGVqyt4obF6TRi3e3EqJ','$2y$13$eQhYzM2vMnsJgxTL1al/x.yfiWqdEOvt7OUlOiMeDA6.4keDpcc3O','HPfA2sW2P-vngWBav-FPScxO7e-fMM0d_1437787624','40039885@qq.com',10,1437787624,1437787624,'超级无聊'),(25,'ummer','HbyMV6Ve0Zp7bs__PNUAV5ZDrT4Kt7Y0','$2y$13$CW4wQoH0czGbUVbsVmzVq.ADuyQz4M9AIRY0DbHR3yRGknXI/DcBm',NULL,'summer@eyou.com',10,1438695266,1438695266,'summer'),(26,'laililiang','1BK2KbAQa3mA6Z3s8cfSGsNFouteI6f_','$2y$13$ivXBAGLz9lCYTOEufPwnVOxIj9Xle4rH.OyyOGDBlDpKxukkzGEWO',NULL,'348888888@qq.com',10,1438737825,1438737825,'lai'),(27,'1234556','GeetitkplMKTrqPO-xi78iTUS0Ojgi_K','$2y$13$mDgWvH9RIwh6xW525.5pcupiDrFHUDKq2WW59sU29P59bZ.KCSP0K',NULL,'111@1111.com',10,1438742707,1438742707,'大幅度随风倒'),(28,'aaaa','UYh5GV8O45_uSUI4MBgd2w2NOK0E94AM','$2y$13$yk3gplngt.B0gHQdoHWfNOGR6ok6akgCgy1ckyWBlvYWd4zxoQG8i',NULL,'sdfsdfsf@126.com',10,1438865567,1438865567,'aaaa'),(29,'mlboy','yr4nUYVsj6Cfx1E1MKyNRn5VndJdk4d2','$2y$13$FLWz3BuIHOakdWO2wS9eQO6lEDwMTKBpbU8SaYYOhv1YD.2ckGZhe',NULL,'admin@126.com',10,1438998168,1438998168,'admin'),(30,'following','KwHXCjlhfkukhPMk9_otSjbEEP_emVUs','$2y$13$kUCY8Yb4xxzHGVcivSPxyOb6dl.8cc3fSmz./oqtCOjirQh7sWLty',NULL,'following@163.com',10,1439266835,1439266835,'following'),(31,'admin1','rGd-6chDDu3TwCk0hoTggtoXkHoPGLOK','$2y$13$2mzZsKk34k8lDwt5aPBhdOkqZMI.lOo1ONOKaJitzO8ks5LRYnHE6',NULL,'77174406@qq.com',10,1439349008,1439349008,'vand 1=1'),(32,'11223344','4sfpA2OWdWYK1Jpz5275lhslDxbRSd1Q','$2y$13$hVIjRaTMZnDVmZQS.ONTX.Qj8iSP6HByreKjCUOgnFDxAcrSg.Hxa',NULL,'1015549166@qq.com',10,1439390958,1439390958,'11223344'),(33,'test','ysMzTXPCIEBdBPmtwR4RfxXZeFm0OubX','$2y$13$5pWwJKN/1WT5j/P2pFit9e92B1VgfTSC0nXLsx/OFwCSJppZ8RZ5G',NULL,'test@qq.com',10,1439431213,1439431213,'test'),(34,'jiuye','NS9Cy2qrEihJiD4QpZwi02n-5-GWoTmJ','$2y$13$CBOdlj3iqpU3WscFTDH3MO7ACNpfqhzpz5dUIzHaBlSCZ120UkMnG',NULL,'407898830@qq.com',10,1439431600,1439431600,'jiuye'),(35,'admin888','sZBjawWaY29Kh_RYEoq7qJEt-jlV50Qw','$2y$13$iQ1jRQX5o2YRsAUB3E37AOIS3DJYiZMpTvA9kB0Y95vxb9awACSBm',NULL,'123456@qq.com',10,1439435413,1439435413,'admin888');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-13 12:00:32
