-- MySQL dump 10.11
--
-- Host: localhost    Database: g6builder_rel_50
-- ------------------------------------------------------
-- Server version	5.0.95-log

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
-- Table structure for table `g5_shop_banner`
--

DROP TABLE IF EXISTS `g5_shop_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_banner` (
  `bn_id` int(11) NOT NULL auto_increment,
  `bn_alt` varchar(255) NOT NULL default '',
  `bn_url` varchar(255) NOT NULL default '',
  `bn_device` varchar(10) NOT NULL default '',
  `bn_position` varchar(255) NOT NULL default '',
  `bn_border` tinyint(4) NOT NULL default '0',
  `bn_new_win` tinyint(4) NOT NULL default '0',
  `bn_begin_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `bn_end_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `bn_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `bn_hit` int(11) NOT NULL default '0',
  `bn_order` int(11) NOT NULL default '0',
  PRIMARY KEY  (`bn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_banner`
--

LOCK TABLES `g5_shop_banner` WRITE;
/*!40000 ALTER TABLE `g5_shop_banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_cart`
--

DROP TABLE IF EXISTS `g5_shop_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_cart` (
  `ct_id` int(11) NOT NULL auto_increment,
  `od_id` bigint(20) unsigned NOT NULL,
  `mb_id` varchar(255) NOT NULL default '',
  `it_id` varchar(20) NOT NULL default '',
  `it_name` varchar(255) NOT NULL default '',
  `it_sc_type` tinyint(4) NOT NULL default '0',
  `it_sc_method` tinyint(4) NOT NULL default '0',
  `it_sc_price` int(11) NOT NULL default '0',
  `it_sc_minimum` int(11) NOT NULL default '0',
  `it_sc_qty` int(11) NOT NULL default '0',
  `ct_status` varchar(255) NOT NULL default '',
  `ct_history` text NOT NULL,
  `ct_price` int(11) NOT NULL default '0',
  `ct_point` int(11) NOT NULL default '0',
  `cp_price` int(11) NOT NULL default '0',
  `ct_point_use` tinyint(4) NOT NULL default '0',
  `ct_stock_use` tinyint(4) NOT NULL default '0',
  `ct_option` varchar(255) NOT NULL default '',
  `ct_qty` int(11) NOT NULL default '0',
  `ct_notax` tinyint(4) NOT NULL default '0',
  `io_id` varchar(255) NOT NULL default '',
  `io_type` tinyint(4) NOT NULL default '0',
  `io_price` int(11) NOT NULL default '0',
  `ct_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ct_ip` varchar(25) NOT NULL default '',
  `ct_send_cost` tinyint(4) NOT NULL default '0',
  `ct_direct` tinyint(4) NOT NULL default '0',
  `ct_select` tinyint(4) NOT NULL default '0',
  `ct_select_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ct_status_detail` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ct_id`),
  KEY `od_id` (`od_id`),
  KEY `it_id` (`it_id`),
  KEY `ct_status` (`ct_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_cart`
--

LOCK TABLES `g5_shop_cart` WRITE;
/*!40000 ALTER TABLE `g5_shop_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_category`
--

DROP TABLE IF EXISTS `g5_shop_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_category` (
  `ca_id` varchar(10) NOT NULL default '0',
  `ca_name` varchar(255) NOT NULL default '',
  `ca_order` int(11) NOT NULL default '0',
  `ca_skin_dir` varchar(255) NOT NULL default '',
  `ca_mobile_skin_dir` varchar(255) NOT NULL default '',
  `ca_skin` varchar(255) NOT NULL default '',
  `ca_mobile_skin` varchar(255) NOT NULL default '',
  `ca_img_width` int(11) NOT NULL default '0',
  `ca_img_height` int(11) NOT NULL default '0',
  `ca_mobile_img_width` int(11) NOT NULL default '0',
  `ca_mobile_img_height` int(11) NOT NULL default '0',
  `ca_sell_email` varchar(255) NOT NULL default '',
  `ca_use` tinyint(4) NOT NULL default '0',
  `ca_stock_qty` int(11) NOT NULL default '0',
  `ca_explan_html` tinyint(4) NOT NULL default '0',
  `ca_head_html` text NOT NULL,
  `ca_tail_html` text NOT NULL,
  `ca_mobile_head_html` text NOT NULL,
  `ca_mobile_tail_html` text NOT NULL,
  `ca_list_mod` int(11) NOT NULL default '0',
  `ca_list_row` int(11) NOT NULL default '0',
  `ca_mobile_list_mod` int(11) NOT NULL default '0',
  `ca_mobile_list_row` int(11) NOT NULL default '0',
  `ca_include_head` varchar(255) NOT NULL default '',
  `ca_include_tail` varchar(255) NOT NULL default '',
  `ca_mb_id` varchar(255) NOT NULL default '',
  `ca_cert_use` tinyint(4) NOT NULL default '0',
  `ca_adult_use` tinyint(4) NOT NULL default '0',
  `ca_nocoupon` tinyint(4) NOT NULL default '0',
  `ca_1_subj` varchar(255) NOT NULL default '',
  `ca_2_subj` varchar(255) NOT NULL default '',
  `ca_3_subj` varchar(255) NOT NULL default '',
  `ca_4_subj` varchar(255) NOT NULL default '',
  `ca_5_subj` varchar(255) NOT NULL default '',
  `ca_6_subj` varchar(255) NOT NULL default '',
  `ca_7_subj` varchar(255) NOT NULL default '',
  `ca_8_subj` varchar(255) NOT NULL default '',
  `ca_9_subj` varchar(255) NOT NULL default '',
  `ca_10_subj` varchar(255) NOT NULL default '',
  `ca_1` varchar(255) NOT NULL default '',
  `ca_2` varchar(255) NOT NULL default '',
  `ca_3` varchar(255) NOT NULL default '',
  `ca_4` varchar(255) NOT NULL default '',
  `ca_5` varchar(255) NOT NULL default '',
  `ca_6` varchar(255) NOT NULL default '',
  `ca_7` varchar(255) NOT NULL default '',
  `ca_8` varchar(255) NOT NULL default '',
  `ca_9` varchar(255) NOT NULL default '',
  `ca_10` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ca_id`),
  KEY `ca_order` (`ca_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_category`
--

LOCK TABLES `g5_shop_category` WRITE;
/*!40000 ALTER TABLE `g5_shop_category` DISABLE KEYS */;
INSERT INTO `g5_shop_category` VALUES ('10','분류1',0,'','','list.10.skin.php','list.10.skin.php',230,230,230,230,'',1,0,1,'','','','',3,5,3,5,'','','',0,0,0,'','','','','','','','','','','','','','','','','','','',''),('20','분류2',0,'','','list.10.skin.php','list.10.skin.php',230,230,230,230,'',1,0,1,'','','','',3,5,3,5,'','','',0,0,0,'','','','','','','','','','','','','','','','','','','',''),('30','분류3',0,'','','list.10.skin.php','list.10.skin.php',230,230,230,230,'',1,0,1,'','','','',3,5,3,5,'','','',0,0,0,'','','','','','','','','','','','','','','','','','','',''),('40','분류4',0,'','','list.10.skin.php','list.10.skin.php',230,230,230,230,'',1,0,1,'','','','',3,5,3,5,'','','',0,0,0,'','','','','','','','','','','','','','','','','','','',''),('1010','분류11',0,'','','list.10.skin.php','list.10.skin.php',230,230,230,230,'',1,0,1,'','','','',3,5,3,5,'','','',0,0,0,'','','','','','','','','','','','','','','','','','','',''),('1020','분류12',0,'','','list.10.skin.php','list.10.skin.php',230,230,230,230,'',1,0,1,'','','','',3,5,3,5,'','','',0,0,0,'','','','','','','','','','','','','','','','','','','',''),('2010','분류21',0,'','','list.10.skin.php','list.10.skin.php',230,230,230,230,'',1,0,1,'','','','',3,5,3,5,'','','',0,0,0,'','','','','','','','','','','','','','','','','','','',''),('2020','분류22',0,'','','list.10.skin.php','list.10.skin.php',230,230,230,230,'',1,0,1,'','','','',3,5,3,5,'','','',0,0,0,'','','','','','','','','','','','','','','','','','','',''),('3010','분류31',0,'','','list.10.skin.php','list.10.skin.php',230,230,230,230,'',1,0,1,'','','','',3,5,3,5,'','','',0,0,0,'','','','','','','','','','','','','','','','','','','',''),('3020','분류32',0,'','','list.10.skin.php','list.10.skin.php',230,230,230,230,'',1,0,1,'','','','',3,5,3,5,'','','',0,0,0,'','','','','','','','','','','','','','','','','','','',''),('4010','분류41',0,'','','list.10.skin.php','list.10.skin.php',230,230,230,230,'',1,0,1,'','','','',3,5,3,5,'','','',0,0,0,'','','','','','','','','','','','','','','','','','','',''),('4020','분류42',0,'','','list.10.skin.php','list.10.skin.php',230,230,230,230,'',1,0,1,'','','','',3,5,3,5,'','','',0,0,0,'','','','','','','','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_shop_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_coupon`
--

DROP TABLE IF EXISTS `g5_shop_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_coupon` (
  `cp_no` int(11) NOT NULL auto_increment,
  `cp_id` varchar(255) NOT NULL default '',
  `cp_subject` varchar(255) NOT NULL default '',
  `cp_method` tinyint(4) NOT NULL default '0',
  `cp_target` varchar(255) NOT NULL default '',
  `mb_id` varchar(255) NOT NULL default '',
  `cz_id` int(11) NOT NULL DEFAULT '0',
  `cp_start` date NOT NULL default '0000-00-00',
  `cp_end` date NOT NULL default '0000-00-00',
  `cp_price` int(11) NOT NULL default '0',
  `cp_type` tinyint(4) NOT NULL default '0',
  `cp_trunc` int(11) NOT NULL default '0',
  `cp_minimum` int(11) NOT NULL default '0',
  `cp_maximum` int(11) NOT NULL default '0',
  `od_id` bigint(20) unsigned NOT NULL,
  `cp_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`cp_no`),
  UNIQUE KEY `cp_id` (`cp_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_coupon`
--

LOCK TABLES `g5_shop_coupon` WRITE;
/*!40000 ALTER TABLE `g5_shop_coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_coupon_log`
--

DROP TABLE IF EXISTS `g5_shop_coupon_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_coupon_log` (
  `cl_id` int(11) NOT NULL auto_increment,
  `cp_id` varchar(255) NOT NULL default '',
  `mb_id` varchar(255) NOT NULL default '',
  `od_id` bigint(20) NOT NULL,
  `cp_price` int(11) NOT NULL default '0',
  `cl_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`cl_id`),
  KEY `mb_id` (`mb_id`),
  KEY `od_id` (`od_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_coupon_log`
--

LOCK TABLES `g5_shop_coupon_log` WRITE;
/*!40000 ALTER TABLE `g5_shop_coupon_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_coupon_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_coupon_zone`
--

DROP TABLE IF EXISTS `g5_shop_coupon_zone`;
CREATE TABLE IF NOT EXISTS `g5_shop_coupon_zone` (
  `cz_id` int(11) NOT NULL AUTO_INCREMENT,
  `cz_type` tinyint(4) NOT NULL DEFAULT '0',
  `cz_subject` varchar(255) NOT NULL DEFAULT '',
  `cz_start` DATE NOT NULL DEFAULT '0000-00-00',
  `cz_end` DATE NOT NULL DEFAULT '0000-00-00',
  `cz_file` varchar(255) NOT NULL DEFAULT '',
  `cz_period` int(11) NOT NULL DEFAULT '0',
  `cz_point` INT(11) NOT NULL DEFAULT '0',
  `cp_method` TINYINT(4) NOT NULL DEFAULT '0',
  `cp_target` VARCHAR(255) NOT NULL DEFAULT '',
  `cp_price` INT(11) NOT NULL DEFAULT '0',
  `cp_type` TINYINT(4) NOT NULL DEFAULT '0',
  `cp_trunc` INT(11) NOT NULL DEFAULT '0',
  `cp_minimum` INT(11) NOT NULL DEFAULT '0',
  `cp_maximum` INT(11) NOT NULL DEFAULT '0',
  `cz_download` int(11) NOT NULL DEFAULT '0',
  `cz_datetime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`cz_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `g5_shop_default`
--

DROP TABLE IF EXISTS `g5_shop_default`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_default` (
  `de_admin_company_owner` varchar(255) NOT NULL default '',
  `de_admin_company_name` varchar(255) NOT NULL default '',
  `de_admin_company_saupja_no` varchar(255) NOT NULL default '',
  `de_admin_company_tel` varchar(255) NOT NULL default '',
  `de_admin_company_fax` varchar(255) NOT NULL default '',
  `de_admin_tongsin_no` varchar(255) NOT NULL default '',
  `de_admin_company_zip` varchar(255) NOT NULL default '',
  `de_admin_company_addr` varchar(255) NOT NULL default '',
  `de_admin_info_name` varchar(255) NOT NULL default '',
  `de_admin_info_email` varchar(255) NOT NULL default '',
  `de_shop_skin` varchar(255) NOT NULL default '',
  `de_shop_mobile_skin` varchar(255) NOT NULL default '',
  `de_type1_list_use` tinyint(4) NOT NULL default '0',
  `de_type1_list_skin` varchar(255) NOT NULL default '',
  `de_type1_list_mod` int(11) NOT NULL default '0',
  `de_type1_list_row` int(11) NOT NULL default '0',
  `de_type1_img_width` int(11) NOT NULL default '0',
  `de_type1_img_height` int(11) NOT NULL default '0',
  `de_type2_list_use` tinyint(4) NOT NULL default '0',
  `de_type2_list_skin` varchar(255) NOT NULL default '',
  `de_type2_list_mod` int(11) NOT NULL default '0',
  `de_type2_list_row` int(11) NOT NULL default '0',
  `de_type2_img_width` int(11) NOT NULL default '0',
  `de_type2_img_height` int(11) NOT NULL default '0',
  `de_type3_list_use` tinyint(4) NOT NULL default '0',
  `de_type3_list_skin` varchar(255) NOT NULL default '',
  `de_type3_list_mod` int(11) NOT NULL default '0',
  `de_type3_list_row` int(11) NOT NULL default '0',
  `de_type3_img_width` int(11) NOT NULL default '0',
  `de_type3_img_height` int(11) NOT NULL default '0',
  `de_type4_list_use` tinyint(4) NOT NULL default '0',
  `de_type4_list_skin` varchar(255) NOT NULL default '',
  `de_type4_list_mod` int(11) NOT NULL default '0',
  `de_type4_list_row` int(11) NOT NULL default '0',
  `de_type4_img_width` int(11) NOT NULL default '0',
  `de_type4_img_height` int(11) NOT NULL default '0',
  `de_type5_list_use` tinyint(4) NOT NULL default '0',
  `de_type5_list_skin` varchar(255) NOT NULL default '',
  `de_type5_list_mod` int(11) NOT NULL default '0',
  `de_type5_list_row` int(11) NOT NULL default '0',
  `de_type5_img_width` int(11) NOT NULL default '0',
  `de_type5_img_height` int(11) NOT NULL default '0',
  `de_mobile_type1_list_use` tinyint(4) NOT NULL default '0',
  `de_mobile_type1_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_type1_list_mod` int(11) NOT NULL default '0',
  `de_mobile_type1_list_row` int(11) NOT NULL default '0',
  `de_mobile_type1_img_width` int(11) NOT NULL default '0',
  `de_mobile_type1_img_height` int(11) NOT NULL default '0',
  `de_mobile_type2_list_use` tinyint(4) NOT NULL default '0',
  `de_mobile_type2_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_type2_list_mod` int(11) NOT NULL default '0',
  `de_mobile_type2_list_row` int(11) NOT NULL default '0',
  `de_mobile_type2_img_width` int(11) NOT NULL default '0',
  `de_mobile_type2_img_height` int(11) NOT NULL default '0',
  `de_mobile_type3_list_use` tinyint(4) NOT NULL default '0',
  `de_mobile_type3_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_type3_list_mod` int(11) NOT NULL default '0',
  `de_mobile_type3_list_row` int(11) NOT NULL default '0',
  `de_mobile_type3_img_width` int(11) NOT NULL default '0',
  `de_mobile_type3_img_height` int(11) NOT NULL default '0',
  `de_mobile_type4_list_use` tinyint(4) NOT NULL default '0',
  `de_mobile_type4_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_type4_list_mod` int(11) NOT NULL default '0',
  `de_mobile_type4_list_row` int(11) NOT NULL default '0',
  `de_mobile_type4_img_width` int(11) NOT NULL default '0',
  `de_mobile_type4_img_height` int(11) NOT NULL default '0',
  `de_mobile_type5_list_use` tinyint(4) NOT NULL default '0',
  `de_mobile_type5_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_type5_list_mod` int(11) NOT NULL default '0',
  `de_mobile_type5_list_row` int(11) NOT NULL default '0',
  `de_mobile_type5_img_width` int(11) NOT NULL default '0',
  `de_mobile_type5_img_height` int(11) NOT NULL default '0',
  `de_rel_list_use` tinyint(4) NOT NULL default '0',
  `de_rel_list_skin` varchar(255) NOT NULL default '',
  `de_rel_list_mod` int(11) NOT NULL default '0',
  `de_rel_img_width` int(11) NOT NULL default '0',
  `de_rel_img_height` int(11) NOT NULL default '0',
  `de_mobile_rel_list_use` tinyint(4) NOT NULL default '0',
  `de_mobile_rel_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_rel_list_mod` int(11) NOT NULL default '0',
  `de_mobile_rel_img_width` int(11) NOT NULL default '0',
  `de_mobile_rel_img_height` int(11) NOT NULL default '0',
  `de_search_list_skin` varchar(255) NOT NULL default '',
  `de_search_list_mod` int(11) NOT NULL default '0',
  `de_search_list_row` int(11) NOT NULL default '0',
  `de_search_img_width` int(11) NOT NULL default '0',
  `de_search_img_height` int(11) NOT NULL default '0',
  `de_mobile_search_list_skin` varchar(255) NOT NULL default '',
  `de_mobile_search_list_mod` int(11) NOT NULL default '0',
  `de_mobile_search_list_row` int(11) NOT NULL default '0',
  `de_mobile_search_img_width` int(11) NOT NULL default '0',
  `de_mobile_search_img_height` int(11) NOT NULL default '0',
  `de_listtype_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_listtype_list_mod` int(11) NOT NULL DEFAULT '0',
  `de_listtype_list_row` int(11) NOT NULL DEFAULT '0',
  `de_listtype_img_width` int(11) NOT NULL DEFAULT '0',
  `de_listtype_img_height` int(11) NOT NULL DEFAULT '0',
  `de_mobile_listtype_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_mobile_listtype_list_mod` int(11) NOT NULL DEFAULT '0',
  `de_mobile_listtype_list_row` int(11) NOT NULL DEFAULT '0',
  `de_mobile_listtype_img_width` int(11) NOT NULL DEFAULT '0',
  `de_mobile_listtype_img_height` int(11) NOT NULL DEFAULT '0',
  `de_bank_use` int(11) NOT NULL default '0',
  `de_bank_account` text NOT NULL,
  `de_card_test` int(11) NOT NULL default '0',
  `de_card_use` int(11) NOT NULL default '0',
  `de_card_noint_use` tinyint(4) NOT NULL default '0',
  `de_card_point` int(11) NOT NULL default '0',
  `de_settle_min_point` int(11) NOT NULL default '0',
  `de_settle_max_point` int(11) NOT NULL default '0',
  `de_settle_point_unit` int(11) NOT NULL default '0',
  `de_level_sell` int(11) NOT NULL default '0',
  `de_delivery_company` varchar(255) NOT NULL default '',
  `de_send_cost_case` varchar(255) NOT NULL default '',
  `de_send_cost_limit` varchar(255) NOT NULL default '',
  `de_send_cost_list` varchar(255) NOT NULL default '',
  `de_hope_date_use` int(11) NOT NULL default '0',
  `de_hope_date_after` int(11) NOT NULL default '0',
  `de_baesong_content` text NOT NULL,
  `de_change_content` text NOT NULL,
  `de_point_days` int(11) NOT NULL default '0',
  `de_simg_width` int(11) NOT NULL default '0',
  `de_simg_height` int(11) NOT NULL default '0',
  `de_mimg_width` int(11) NOT NULL default '0',
  `de_mimg_height` int(11) NOT NULL default '0',
  `de_sms_cont1` text NOT NULL,
  `de_sms_cont2` text NOT NULL,
  `de_sms_cont3` text NOT NULL,
  `de_sms_cont4` text NOT NULL,
  `de_sms_cont5` text NOT NULL,
  `de_sms_use1` tinyint(4) NOT NULL default '0',
  `de_sms_use2` tinyint(4) NOT NULL default '0',
  `de_sms_use3` tinyint(4) NOT NULL default '0',
  `de_sms_use4` tinyint(4) NOT NULL default '0',
  `de_sms_use5` tinyint(4) NOT NULL default '0',
  `de_sms_hp` varchar(255) NOT NULL default '',
  `de_pg_service` varchar(255) NOT NULL default '',
  `de_kcp_mid` varchar(255) NOT NULL default '',
  `de_kcp_site_key` varchar(255) NOT NULL default '',
  `de_inicis_mid` varchar(255) NOT NULL default '',
  `de_inicis_admin_key` varchar(255) NOT NULL default '',
  `de_inicis_sign_key` varchar(255) NOT NULL DEFAULT '',
  `de_iche_use` tinyint(4) NOT NULL default '0',
  `de_easy_pay_use` tinyint(4) NOT NULL DEFAULT '0',
  `de_samsung_pay_use` tinyint(4) NOT NULL DEFAULT '0',
  `de_inicis_lpay_use` tinyint(4) NOT NULL DEFAULT '0',
  `de_item_use_use` tinyint(4) NOT NULL default '0',
  `de_item_use_write` tinyint(4) NOT NULL default '0',
  `de_code_dup_use` tinyint(4) NOT NULL default '0',
  `de_cart_keep_term` int(11) NOT NULL default '0',
  `de_guest_cart_use` tinyint(4) NOT NULL default '0',
  `de_admin_buga_no` varchar(255) NOT NULL default '',
  `de_vbank_use` varchar(255) NOT NULL default '',
  `de_taxsave_use` tinyint(4) NOT NULL,
  `de_guest_privacy` text NOT NULL,
  `de_hp_use` tinyint(4) NOT NULL default '0',
  `de_escrow_use` tinyint(4) NOT NULL default '0',
  `de_tax_flag_use` tinyint(4) NOT NULL default '0',
  `de_kakaopay_mid` varchar(255) NOT NULL DEFAULT '',
  `de_kakaopay_key` varchar(255) NOT NULL DEFAULT '',
  `de_kakaopay_enckey` varchar(255) NOT NULL DEFAULT '',
  `de_kakaopay_hashkey` varchar(255) NOT NULL DEFAULT '',
  `de_kakaopay_cancelpwd` varchar(255) NOT NULL DEFAULT '',
  `de_naverpay_mid` varchar(255) NOT NULL DEFAULT '',
  `de_naverpay_cert_key` varchar(255) NOT NULL DEFAULT '',
  `de_naverpay_button_key` varchar(255) NOT NULL DEFAULT '',
  `de_naverpay_test` tinyint(4) NOT NULL DEFAULT '0',
  `de_naverpay_mb_id` varchar(255) NOT NULL DEFAULT '',
  `de_naverpay_sendcost` varchar(255) NOT NULL DEFAULT '',
  `de_member_reg_coupon_use` tinyint(4) NOT NULL default '0',
  `de_member_reg_coupon_term` int(11) NOT NULL default '0',
  `de_member_reg_coupon_price` int(11) NOT NULL default '0',
  `de_member_reg_coupon_minimum` int(11) NOT NULL default '0',
  `de_paypal_use` tinyint(4) NOT NULL default '0',
  `de_paypal_test` tinyint(4) NOT NULL default '0',
  `de_paypal_mid` varchar(255) NOT NULL default '',
  `de_paypal_currency_code` varchar(10) NOT NULL default '',
  `de_paypal_exchange_rate` varchar(20) NOT NULL default '',
  `de_alipay_use` tinyint(4) NOT NULL default '0',
  `de_alipay_test` tinyint(4) NOT NULL default '0',
  `de_alipay_service_type` varchar(30) NOT NULL default '',
  `de_alipay_partner` varchar(60) NOT NULL default '',
  `de_alipay_key` varchar(120) NOT NULL default '',
  `de_alipay_seller_id` varchar(60) NOT NULL default '',
  `de_alipay_seller_email` varchar(120) NOT NULL default '',
  `de_alipay_currency` varchar(10) NOT NULL default '',
  `de_alipay_exchange_rate` varchar(20) NOT NULL default '',
  `de_anet_use` tinyint(4) NOT NULL default '0',
  `de_anet_test` tinyint(4) NOT NULL default '0',
  `de_anet_id` varchar(255) NOT NULL default '',
  `de_anet_key` varchar(255) NOT NULL default '',
  `de_anet_test_mode` tinyint(4) NOT NULL default '0',
  `de_anet_exchange_rate` varchar(20) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_default`
--

LOCK TABLES `g5_shop_default` WRITE;
/*!40000 ALTER TABLE `g5_shop_default` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_default` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_event`
--

DROP TABLE IF EXISTS `g5_shop_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_event` (
  `ev_id` int(11) NOT NULL auto_increment,
  `ev_skin` varchar(255) NOT NULL default '',
  `ev_mobile_skin` varchar(255) NOT NULL default '',
  `ev_img_width` int(11) NOT NULL default '0',
  `ev_img_height` int(11) NOT NULL default '0',
  `ev_list_mod` int(11) NOT NULL default '0',
  `ev_list_row` int(11) NOT NULL default '0',
  `ev_mobile_img_width` int(11) NOT NULL default '0',
  `ev_mobile_img_height` int(11) NOT NULL default '0',
  `ev_mobile_list_mod` int(11) NOT NULL default '0',
  `ev_mobile_list_row` int(11) NOT NULL DEFAULT '0',
  `ev_subject` varchar(255) NOT NULL default '',
  `ev_subject_strong` tinyint(4) NOT NULL default '0',
  `ev_head_html` text NOT NULL,
  `ev_tail_html` text NOT NULL,
  `ev_use` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`ev_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_event`
--

LOCK TABLES `g5_shop_event` WRITE;
/*!40000 ALTER TABLE `g5_shop_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_event_item`
--

DROP TABLE IF EXISTS `g5_shop_event_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_event_item` (
  `ev_id` int(11) NOT NULL default '0',
  `it_id` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`ev_id`,`it_id`),
  KEY `it_id` (`it_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_event_item`
--

LOCK TABLES `g5_shop_event_item` WRITE;
/*!40000 ALTER TABLE `g5_shop_event_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_event_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_inicis_log`
--

DROP TABLE IF EXISTS `g5_shop_inicis_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_inicis_log` (
  `oid` bigint(20) unsigned NOT NULL,
  `P_TID` varchar(255) NOT NULL default '',
  `P_MID` varchar(255) NOT NULL default '',
  `P_AUTH_DT` varchar(255) NOT NULL default '',
  `P_STATUS` varchar(255) NOT NULL default '',
  `P_TYPE` varchar(255) NOT NULL default '',
  `P_OID` varchar(255) NOT NULL default '',
  `P_FN_NM` varchar(255) NOT NULL default '',
  `P_AUTH_NO` varchar(255) NOT NULL DEFAULT '',
  `P_AMT` int(11) NOT NULL default '0',
  `P_RMESG1` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_inicis_log`
--

LOCK TABLES `g5_shop_inicis_log` WRITE;
/*!40000 ALTER TABLE `g5_shop_inicis_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_inicis_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_item`
--

DROP TABLE IF EXISTS `g5_shop_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_item` (
  `it_id` varchar(20) NOT NULL default '',
  `ca_id` varchar(10) NOT NULL default '0',
  `ca_id2` varchar(255) NOT NULL default '',
  `ca_id3` varchar(255) NOT NULL default '',
  `it_skin` varchar(255) NOT NULL default '',
  `it_mobile_skin` varchar(255) NOT NULL default '',
  `it_name` varchar(255) NOT NULL default '',
  `it_maker` varchar(255) NOT NULL default '',
  `it_origin` varchar(255) NOT NULL default '',
  `it_brand` varchar(255) NOT NULL default '',
  `it_model` varchar(255) NOT NULL default '',
  `it_option_subject` varchar(255) NOT NULL default '',
  `it_supply_subject` varchar(255) NOT NULL default '',
  `it_type1` tinyint(4) NOT NULL default '0',
  `it_type2` tinyint(4) NOT NULL default '0',
  `it_type3` tinyint(4) NOT NULL default '0',
  `it_type4` tinyint(4) NOT NULL default '0',
  `it_type5` tinyint(4) NOT NULL default '0',
  `it_basic` text NOT NULL,
  `it_explan` mediumtext NOT NULL,
  `it_explan2` mediumtext NOT NULL,
  `it_mobile_explan` mediumtext NOT NULL,
  `it_cust_price` int(11) NOT NULL default '0',
  `it_price` int(11) NOT NULL default '0',
  `it_point` int(11) NOT NULL default '0',
  `it_point_type` tinyint(4) NOT NULL default '0',
  `it_supply_point` int(11) NOT NULL default '0',
  `it_notax` tinyint(4) NOT NULL default '0',
  `it_sell_email` varchar(255) NOT NULL default '',
  `it_use` tinyint(4) NOT NULL default '0',
  `it_nocoupon` tinyint(4) NOT NULL default '0',
  `it_soldout` tinyint(4) NOT NULL default '0',
  `it_stock_qty` int(11) NOT NULL default '0',
  `it_stock_sms` tinyint(4) NOT NULL default '0',
  `it_noti_qty` int(11) NOT NULL default '0',
  `it_sc_type` tinyint(4) NOT NULL default '0',
  `it_sc_method` tinyint(4) NOT NULL default '0',
  `it_sc_price` int(11) NOT NULL default '0',
  `it_sc_minimum` int(11) NOT NULL default '0',
  `it_sc_qty` int(11) NOT NULL default '0',
  `it_buy_min_qty` int(11) NOT NULL default '0',
  `it_buy_max_qty` int(11) NOT NULL default '0',
  `it_head_html` text NOT NULL,
  `it_tail_html` text NOT NULL,
  `it_mobile_head_html` text NOT NULL,
  `it_mobile_tail_html` text NOT NULL,
  `it_hit` int(11) NOT NULL default '0',
  `it_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `it_update_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `it_ip` varchar(25) NOT NULL default '',
  `it_order` int(11) NOT NULL default '0',
  `it_tel_inq` tinyint(4) NOT NULL default '0',
  `it_info_gubun` varchar(50) NOT NULL default '',
  `it_info_value` text NOT NULL,
  `it_sum_qty` int(11) NOT NULL default '0',
  `it_use_cnt` int(11) NOT NULL default '0',
  `it_use_avg` decimal(2,1) NOT NULL,
  `it_shop_memo` text NOT NULL,
  `ec_mall_pid` varchar(255) NOT NULL DEFAULT '',
  `it_img1` varchar(255) NOT NULL default '',
  `it_img2` varchar(255) NOT NULL default '',
  `it_img3` varchar(255) NOT NULL default '',
  `it_img4` varchar(255) NOT NULL default '',
  `it_img5` varchar(255) NOT NULL default '',
  `it_img6` varchar(255) NOT NULL default '',
  `it_img7` varchar(255) NOT NULL default '',
  `it_img8` varchar(255) NOT NULL default '',
  `it_img9` varchar(255) NOT NULL default '',
  `it_img10` varchar(255) NOT NULL default '',
  `it_1_subj` varchar(255) NOT NULL default '',
  `it_2_subj` varchar(255) NOT NULL default '',
  `it_3_subj` varchar(255) NOT NULL default '',
  `it_4_subj` varchar(255) NOT NULL default '',
  `it_5_subj` varchar(255) NOT NULL default '',
  `it_6_subj` varchar(255) NOT NULL default '',
  `it_7_subj` varchar(255) NOT NULL default '',
  `it_8_subj` varchar(255) NOT NULL default '',
  `it_9_subj` varchar(255) NOT NULL default '',
  `it_10_subj` varchar(255) NOT NULL default '',
  `it_1` varchar(255) NOT NULL default '',
  `it_2` varchar(255) NOT NULL default '',
  `it_3` varchar(255) NOT NULL default '',
  `it_4` varchar(255) NOT NULL default '',
  `it_5` varchar(255) NOT NULL default '',
  `it_6` varchar(255) NOT NULL default '',
  `it_7` varchar(255) NOT NULL default '',
  `it_8` varchar(255) NOT NULL default '',
  `it_9` varchar(255) NOT NULL default '',
  `it_10` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`it_id`),
  KEY `ca_id` (`ca_id`),
  KEY `it_name` (`it_name`),
  KEY `it_order` (`it_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_item`
--

LOCK TABLES `g5_shop_item` WRITE;
/*!40000 ALTER TABLE `g5_shop_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_item_option`
--

DROP TABLE IF EXISTS `g5_shop_item_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_item_option` (
  `io_no` int(11) NOT NULL auto_increment,
  `io_id` varchar(255) NOT NULL default '0',
  `io_type` tinyint(4) NOT NULL default '0',
  `it_id` varchar(20) NOT NULL default '',
  `io_price` int(11) NOT NULL default '0',
  `io_stock_qty` int(11) NOT NULL default '0',
  `io_noti_qty` int(11) NOT NULL default '0',
  `io_use` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`io_no`),
  KEY `io_id` (`io_id`),
  KEY `it_id` (`it_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_item_option`
--

LOCK TABLES `g5_shop_item_option` WRITE;
/*!40000 ALTER TABLE `g5_shop_item_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_item_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_item_qa`
--

DROP TABLE IF EXISTS `g5_shop_item_qa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_item_qa` (
  `iq_id` int(11) NOT NULL auto_increment,
  `it_id` varchar(20) NOT NULL default '',
  `mb_id` varchar(255) NOT NULL default '',
  `iq_secret` tinyint(4) NOT NULL default '0',
  `iq_name` varchar(255) NOT NULL default '',
  `iq_email` varchar(255) NOT NULL default '',
  `iq_hp` varchar(255) NOT NULL default '',
  `iq_password` varchar(255) NOT NULL default '',
  `iq_subject` varchar(255) NOT NULL default '',
  `iq_question` text NOT NULL,
  `iq_answer` text NOT NULL,
  `iq_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `iq_ip` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`iq_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_item_qa`
--

LOCK TABLES `g5_shop_item_qa` WRITE;
/*!40000 ALTER TABLE `g5_shop_item_qa` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_item_qa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_item_relation`
--

DROP TABLE IF EXISTS `g5_shop_item_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_item_relation` (
  `it_id` varchar(20) NOT NULL default '',
  `it_id2` varchar(20) NOT NULL default '',
  `ir_no` int(11) NOT NULL default '0',
  PRIMARY KEY  (`it_id`,`it_id2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_item_relation`
--

LOCK TABLES `g5_shop_item_relation` WRITE;
/*!40000 ALTER TABLE `g5_shop_item_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_item_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_item_stocksms`
--

DROP TABLE IF EXISTS `g5_shop_item_stocksms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_item_stocksms` (
  `ss_id` int(11) NOT NULL auto_increment,
  `it_id` varchar(20) NOT NULL default '',
  `ss_hp` varchar(255) NOT NULL default '',
  `ss_send` tinyint(4) NOT NULL default '0',
  `ss_send_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ss_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `ss_ip` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`ss_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_item_stocksms`
--

LOCK TABLES `g5_shop_item_stocksms` WRITE;
/*!40000 ALTER TABLE `g5_shop_item_stocksms` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_item_stocksms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_item_use`
--

DROP TABLE IF EXISTS `g5_shop_item_use`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_item_use` (
  `is_id` int(11) NOT NULL auto_increment,
  `it_id` varchar(20) NOT NULL default '0',
  `mb_id` varchar(255) NOT NULL default '',
  `is_name` varchar(255) NOT NULL default '',
  `is_password` varchar(255) NOT NULL default '',
  `is_score` tinyint(4) NOT NULL default '0',
  `is_subject` varchar(255) NOT NULL default '',
  `is_content` text NOT NULL,
  `is_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `is_ip` varchar(25) NOT NULL default '',
  `is_confirm` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`is_id`),
  KEY `index1` (`it_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_item_use`
--

LOCK TABLES `g5_shop_item_use` WRITE;
/*!40000 ALTER TABLE `g5_shop_item_use` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_item_use` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_order`
--

DROP TABLE IF EXISTS `g5_shop_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_order` (
  `od_id` bigint(20) unsigned NOT NULL,
  `mb_id` varchar(255) NOT NULL default '',
  `od_name` varchar(20) NOT NULL default '',
  `od_email` varchar(100) NOT NULL default '',
  `od_tel` varchar(20) NOT NULL default '',
  `od_hp` varchar(20) NOT NULL default '',
  `od_zip1` char(3) NOT NULL default '',
  `od_zip2` char(3) NOT NULL default '',
  `od_addr1` varchar(100) NOT NULL default '',
  `od_addr2` varchar(100) NOT NULL default '',
  `od_addr3` varchar(255) NOT NULL default '',
  `od_addr_jibeon` varchar(255) NOT NULL default '',
  `od_deposit_name` varchar(20) NOT NULL default '',
  `od_b_name` varchar(20) NOT NULL default '',
  `od_b_tel` varchar(20) NOT NULL default '',
  `od_b_hp` varchar(20) NOT NULL default '',
  `od_b_zip1` char(3) NOT NULL default '',
  `od_b_zip2` char(3) NOT NULL default '',
  `od_b_addr1` varchar(100) NOT NULL default '',
  `od_b_addr2` varchar(100) NOT NULL default '',
  `od_b_addr3` varchar(255) NOT NULL default '',
  `od_b_addr_jibeon` varchar(255) NOT NULL default '',
  `od_memo` text NOT NULL,
  `od_cart_count` int(11) NOT NULL default '0',
  `od_cart_price` int(11) NOT NULL default '0',
  `od_cart_coupon` int(11) NOT NULL default '0',
  `od_send_cost` int(11) NOT NULL default '0',
  `od_send_cost2` int(11) NOT NULL default '0',
  `od_send_coupon` int(11) NOT NULL default '0',
  `od_receipt_price` int(11) NOT NULL default '0',
  `od_cancel_price` int(11) NOT NULL default '0',
  `od_receipt_point` int(11) NOT NULL default '0',
  `od_refund_price` int(11) NOT NULL default '0',
  `od_bank_account` varchar(255) NOT NULL default '',
  `od_receipt_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `od_coupon` int(11) NOT NULL default '0',
  `od_misu` int(11) NOT NULL default '0',
  `od_shop_memo` text NOT NULL,
  `od_mod_history` text NOT NULL,
  `od_status` varchar(255) NOT NULL default '',
  `od_hope_date` date NOT NULL default '0000-00-00',
  `od_settle_case` varchar(255) NOT NULL default '',
  `od_test` tinyint(4) NOT NULL DEFAULT '0',
  `od_mobile` tinyint(4) NOT NULL default '0',
  `od_pg` varchar(255) NOT NULL default '',
  `od_tno` varchar(255) NOT NULL default '',
  `od_app_no` varchar(20) NOT NULL default '',
  `od_escrow` tinyint(4) NOT NULL default '0',
  `od_casseqno` varchar(255) NOT NULL default '',
  `od_tax_flag` tinyint(4) NOT NULL default '0',
  `od_tax_mny` int(11) NOT NULL default '0',
  `od_vat_mny` int(11) NOT NULL default '0',
  `od_free_mny` int(11) NOT NULL default '0',
  `od_delivery_company` varchar(255) NOT NULL default '0',
  `od_invoice` varchar(255) NOT NULL default '',
  `od_invoice_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `od_cash` tinyint(4) NOT NULL,
  `od_cash_no` varchar(255) NOT NULL,
  `od_cash_info` text NOT NULL,
  `od_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `od_pwd` varchar(255) NOT NULL default '',
  `od_ip` varchar(25) NOT NULL default '',
  `od_status_detail` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`od_id`),
  KEY `index2` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_order`
--

LOCK TABLES `g5_shop_order` WRITE;
/*!40000 ALTER TABLE `g5_shop_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_order_address`
--

DROP TABLE IF EXISTS `g5_shop_order_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_order_address` (
  `ad_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(255) NOT NULL default '',
  `ad_subject` varchar(255) NOT NULL default '',
  `ad_default` tinyint(4) NOT NULL default '0',
  `ad_name` varchar(255) NOT NULL default '',
  `ad_tel` varchar(255) NOT NULL default '',
  `ad_hp` varchar(255) NOT NULL default '',
  `ad_zip1` char(3) NOT NULL default '',
  `ad_zip2` char(3) NOT NULL default '',
  `ad_addr1` varchar(255) NOT NULL default '',
  `ad_addr2` varchar(255) NOT NULL default '',
  `ad_addr3` varchar(255) NOT NULL default '',
  `ad_jibeon` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ad_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_order_address`
--

LOCK TABLES `g5_shop_order_address` WRITE;
/*!40000 ALTER TABLE `g5_shop_order_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_order_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_order_data`
--

DROP TABLE IF EXISTS `g5_shop_order_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_order_data` (
  `od_id` bigint(20) unsigned NOT NULL,
  `cart_id` bigint(20) unsigned NOT NULL,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `dt_pg` varchar(255) NOT NULL default '',
  `dt_data` text NOT NULL,
  `dt_time` datetime NOT NULL default '0000-00-00 00:00:00',
  KEY `od_id` (`od_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_order_data`
--

LOCK TABLES `g5_shop_order_data` WRITE;
/*!40000 ALTER TABLE `g5_shop_order_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_order_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_order_delete`
--

DROP TABLE IF EXISTS `g5_shop_order_delete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_order_delete` (
  `de_id` int(11) NOT NULL auto_increment,
  `de_key` varchar(255) NOT NULL default '',
  `de_data` longtext NOT NULL,
  `mb_id` varchar(20) NOT NULL default '',
  `de_ip` varchar(255) NOT NULL default '',
  `de_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`de_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_order_delete`
--

LOCK TABLES `g5_shop_order_delete` WRITE;
/*!40000 ALTER TABLE `g5_shop_order_delete` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_order_delete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_personalpay`
--

DROP TABLE IF EXISTS `g5_shop_personalpay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_personalpay` (
  `pp_id` bigint(20) unsigned NOT NULL,
  `od_id` bigint(20) unsigned NOT NULL,
  `pp_name` varchar(255) NOT NULL default '',
  `pp_email` varchar(255) NOT NULL default '',
  `pp_hp` varchar(255) NOT NULL default '',
  `pp_content` text NOT NULL,
  `pp_use` tinyint(4) NOT NULL default '0',
  `pp_price` int(11) NOT NULL default '0',
  `pp_pg` varchar(255) NOT NULL default '',
  `pp_tno` varchar(255) NOT NULL default '',
  `pp_app_no` varchar(20) NOT NULL default '',
  `pp_casseqno` varchar(255) NOT NULL default '',
  `pp_receipt_price` int(11) NOT NULL default '0',
  `pp_settle_case` varchar(255) NOT NULL default '',
  `pp_bank_account` varchar(255) NOT NULL default '',
  `pp_deposit_name` varchar(255) NOT NULL default '',
  `pp_receipt_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `pp_receipt_ip` varchar(255) NOT NULL default '',
  `pp_shop_memo` text NOT NULL,
  `pp_cash` tinyint(4) NOT NULL default '0',
  `pp_cash_no` varchar(255) NOT NULL default '',
  `pp_cash_info` text NOT NULL,
  `pp_ip` varchar(255) NOT NULL default '',
  `pp_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`pp_id`),
  KEY `od_id` (`od_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_personalpay`
--

LOCK TABLES `g5_shop_personalpay` WRITE;
/*!40000 ALTER TABLE `g5_shop_personalpay` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_personalpay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_sendcost`
--

DROP TABLE IF EXISTS `g5_shop_sendcost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_sendcost` (
  `sc_id` int(11) NOT NULL auto_increment,
  `sc_name` varchar(255) NOT NULL default '',
  `sc_zip1` varchar(10) NOT NULL default '',
  `sc_zip2` varchar(10) NOT NULL default '',
  `sc_price` int(11) NOT NULL default '0',
  PRIMARY KEY  (`sc_id`),
  KEY `sc_zip1` (`sc_zip1`),
  KEY `sc_zip2` (`sc_zip2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_sendcost`
--

LOCK TABLES `g5_shop_sendcost` WRITE;
/*!40000 ALTER TABLE `g5_shop_sendcost` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_sendcost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_wish`
--

DROP TABLE IF EXISTS `g5_shop_wish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_wish` (
  `wi_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(255) NOT NULL default '',
  `it_id` varchar(20) NOT NULL default '0',
  `wi_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `wi_ip` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`wi_id`),
  KEY `index1` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_wish`
--

LOCK TABLES `g5_shop_wish` WRITE;
/*!40000 ALTER TABLE `g5_shop_wish` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_wish` ENABLE KEYS */;
UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-02  3:59:04
