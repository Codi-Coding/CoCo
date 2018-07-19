-- MySQL dump 10.11
--
-- Host: localhost    Database: g6builder_rel_51
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
-- Table structure for table `g5_auth`
--

DROP TABLE IF EXISTS `g5_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_auth` (
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `au_menu` varchar(20) NOT NULL DEFAULT '',
  `au_auth` set('r','w','d') NOT NULL DEFAULT '',
  PRIMARY KEY  (`mb_id`,`au_menu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_auth`
--

LOCK TABLES `g5_auth` WRITE;
/*!40000 ALTER TABLE `g5_auth` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_autosave`
--

DROP TABLE IF EXISTS `g5_autosave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_autosave` (
  `as_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL,
  `as_uid` bigint(20) unsigned NOT NULL,
  `as_subject` varchar(255) NOT NULL,
  `as_content` text NOT NULL,
  `as_datetime` datetime NOT NULL,
  PRIMARY KEY  (`as_id`),
  UNIQUE KEY `as_uid` (`as_uid`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_autosave`
--

LOCK TABLES `g5_autosave` WRITE;
/*!40000 ALTER TABLE `g5_autosave` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_autosave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_board`
--

DROP TABLE IF EXISTS `g5_board`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_board` (
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `gr_id` varchar(255) NOT NULL DEFAULT '',
  `bo_subject` varchar(255) NOT NULL DEFAULT '',
  `bo_mobile_subject` varchar(255) NOT NULL DEFAULT '',
  `bo_admin` varchar(255) NOT NULL DEFAULT '',
  `bo_list_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_read_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_write_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_reply_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_comment_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_upload_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_download_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_html_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_link_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_trackback_level` tinyint(4) NOT NULL DEFAULT '0',
  `bo_count_delete` tinyint(4) NOT NULL DEFAULT '0',
  `bo_count_modify` tinyint(4) NOT NULL DEFAULT '0',
  `bo_read_point` int(11) NOT NULL DEFAULT '0',
  `bo_write_point` int(11) NOT NULL DEFAULT '0',
  `bo_comment_point` int(11) NOT NULL DEFAULT '0',
  `bo_download_point` int(11) NOT NULL DEFAULT '0',
  `bo_use_category` tinyint(4) NOT NULL DEFAULT '0',
  `bo_category_list` text NOT NULL,
  `bo_disable_tags` text NOT NULL,
  `bo_use_sideview` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_file_content` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_secret` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_dhtml_editor` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_rss_view` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_comment` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_good` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_nogood` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_name` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_signature` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_ip_view` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_trackback` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_list_view` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_list_file` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_list_content` tinyint(4) NOT NULL DEFAULT '0',
  `bo_table_width` int(11) NOT NULL DEFAULT '0',
  `bo_subject_len` int(11) NOT NULL DEFAULT '0',
  `bo_page_rows` int(11) NOT NULL DEFAULT '0',
  `bo_new` int(11) NOT NULL DEFAULT '0',
  `bo_hot` int(11) NOT NULL DEFAULT '0',
  `bo_image_width` int(11) NOT NULL DEFAULT '0',
  `bo_skin` varchar(255) NOT NULL DEFAULT '',
  `bo_image_head` varchar(255) NOT NULL DEFAULT '',
  `bo_image_tail` varchar(255) NOT NULL DEFAULT '',
  `bo_include_head` varchar(255) NOT NULL DEFAULT '',
  `bo_include_tail` varchar(255) NOT NULL DEFAULT '',
  `bo_content_head` text NOT NULL,
  `bo_content_tail` text NOT NULL,
  `bo_insert_content` text NOT NULL,
  `bo_gallery_cols` int(11) NOT NULL DEFAULT '0',
  `bo_upload_size` int(11) NOT NULL DEFAULT '0',
  `bo_reply_order` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_search` tinyint(4) NOT NULL DEFAULT '0',
  `bo_order_search` int(11) NOT NULL DEFAULT '0',
  `bo_count_write` int(11) NOT NULL DEFAULT '0',
  `bo_count_comment` int(11) NOT NULL DEFAULT '0',
  `bo_write_min` int(11) NOT NULL DEFAULT '0',
  `bo_write_max` int(11) NOT NULL DEFAULT '0',
  `bo_comment_min` int(11) NOT NULL DEFAULT '0',
  `bo_comment_max` int(11) NOT NULL DEFAULT '0',
  `bo_notice` text NOT NULL,
  `bo_upload_count` tinyint(4) NOT NULL DEFAULT '0',
  `bo_use_email` tinyint(4) NOT NULL DEFAULT '0',
  `bo_sort_field` varchar(255) NOT NULL DEFAULT '',
  `bo_1_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_2_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_3_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_4_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_5_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_6_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_7_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_8_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_9_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_10_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_1` varchar(255) NOT NULL DEFAULT '',
  `bo_2` varchar(255) NOT NULL DEFAULT '',
  `bo_3` varchar(255) NOT NULL DEFAULT '',
  `bo_4` varchar(255) NOT NULL DEFAULT '',
  `bo_5` varchar(255) NOT NULL DEFAULT '',
  `bo_6` varchar(255) NOT NULL DEFAULT '',
  `bo_7` varchar(255) NOT NULL DEFAULT '',
  `bo_8` varchar(255) NOT NULL DEFAULT '',
  `bo_9` varchar(255) NOT NULL DEFAULT '',
  `bo_10` varchar(255) NOT NULL DEFAULT '',
  `bo_m_table_width` int(11) NOT NULL DEFAULT '100',
  `bo_m_subject_len` int(11) NOT NULL DEFAULT '50',
  `bo_m_page_rows` int(11) NOT NULL DEFAULT '10',
  `bo_m_image_width` int(11) NOT NULL DEFAULT '300',
  `bo_m_skin` varchar(255) NOT NULL DEFAULT 'basic',
  `bo_m_include_head` varchar(255) NOT NULL DEFAULT '../_head.php',
  `bo_m_include_tail` varchar(255) NOT NULL DEFAULT '../_tail.php',
  `bo_m_content_head` text NOT NULL,
  `bo_m_content_tail` text NOT NULL,
  `bo_m_use` int(11) NOT NULL DEFAULT '1',
  `bo_m_main_use` int(11) NOT NULL DEFAULT '1',
  `bo_m_latest_rows` int(11) NOT NULL DEFAULT '5',
  `bo_m_latest_skin` varchar(255) NOT NULL DEFAULT 'g4m_basic',
  `bo_m_sort` int(11) NOT NULL DEFAULT '0',
  `bo_m_main_sort` int(11) NOT NULL DEFAULT '0',
  `bo_m_latestsub_len` int(11) NOT NULL DEFAULT '50',
  `bo_w_skin` varchar(255) NOT NULL DEFAULT 'basic',
  `bo_w_table_width` int(11) NOT NULL DEFAULT '0',
  `bo_device` enum('both','pc','mobile') NOT NULL DEFAULT 'both',
  `bo_mobile_subject_len` int(11) NOT NULL DEFAULT '0',
  `bo_mobile_page_rows` int(11) NOT NULL DEFAULT '0',
  `bo_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic',
  `bo_mobile_content_head` text NOT NULL,
  `bo_mobile_content_tail` text NOT NULL,
  `bo_gallery_width` int(11) NOT NULL DEFAULT '0',
  `bo_gallery_height` int(11) NOT NULL DEFAULT '0',
  `bo_mobile_gallery_cols` int(11) NOT NULL DEFAULT '0',
  `bo_mobile_gallery_width` int(11) NOT NULL DEFAULT '0',
  `bo_mobile_gallery_height` int(11) NOT NULL DEFAULT '0',
  `bo_show_menu` tinyint(4) NOT NULL DEFAULT '0',
  `bo_order` int(11) NOT NULL DEFAULT '0',
  `bo_use_cert` enum('','cert','adult','hp-cert','hp-adult') NOT NULL DEFAULT '',
  `bo_use_sns` tinyint(4) NOT NULL DEFAULT '0',
  `bo_explan` text NOT NULL,
  PRIMARY KEY  (`bo_table`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_board`
--

LOCK TABLES `g5_board` WRITE;
/*!40000 ALTER TABLE `g5_board` DISABLE KEYS */;
INSERT INTO `g5_board` VALUES ('callcenter','callcenter','콜 센터','','',1,1,10,10,10,10,1,10,10,10,1,1,0,0,0,0,0,'','',0,0,0,1,0,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_webzine','','','../_head.php','../_tail.php','','','',4,1048576,1,0,0,1,0,0,0,0,0,'',10,0,'','','','','','','','','','','','210','160','90','','','','','','','',100,50,10,300,'good_webzine','../_head.php','../_tail.php','','',1,0,5,'g4m_gallery',3,0,50,'good_webzine_sy',100,'both',30,15,'good_webzine','','',174,124,3,125,100,1,3,'',0,'');
INSERT INTO `g5_board` VALUES ('notice','callcenter','공지 사항','','',1,1,10,10,10,10,1,10,10,10,1,1,0,0,0,0,0,'','',0,0,0,1,0,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_basic_popup','','','../_head.php','../_tail.php','','','',4,1048576,1,1,0,3,0,0,0,0,0,'',10,0,'','','','','','','','','','','','','','','','','','','','','',100,50,10,300,'good_basic','../_head.php','../_tail.php','','',1,1,5,'g4m_basic',0,2,50,'good_basic_sy',100,'both',30,15,'good_basic','','',174,124,3,125,100,1,0,'',0,'');
INSERT INTO `g5_board` VALUES ('qna','callcenter','질문 답변','','',1,1,2,2,2,2,1,2,2,2,1,1,0,0,0,0,0,'','',0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_basic','','','../_head.php','../_tail.php','','','',4,1048576,1,1,0,0,0,0,0,0,0,'',10,0,'','','','','','','','','','','','','','','','','','','','','',100,50,10,300,'good_basic','../_head.php','../_tail.php','','',1,0,5,'g4m_basic',1,0,50,'good_basic_sy',100,'both',30,15,'good_basic','','',174,124,3,125,100,1,1,'',0,'');
INSERT INTO `g5_board` VALUES ('faq','callcenter','FAQ','','',1,1,10,10,10,10,1,10,10,10,1,1,0,0,0,0,0,'','',0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,100,60,15,24,100,600,'good_basic','','','../_head.php','../_tail.php','','','',4,1048576,1,1,0,0,0,0,0,0,0,'',10,0,'','','','','','','','','','','','','','','','','','','','','',100,50,10,300,'good_basic','../_head.php','../_tail.php','','',1,0,5,'g4m_basic',2,0,50,'good_basic_sy',100,'both',30,15,'good_basic','','',174,124,3,125,100,1,2,'',0,'');
INSERT INTO `g5_board` VALUES ('free','board','자유 게시판','','',1,1,2,2,2,2,1,2,2,2,1,1,0,0,0,0,0,'','',0,0,0,0,1,0,0,0,0,0,0,1,0,1,1,100,60,15,24,100,600,'good_basic','','','../_head.php','../_tail.php','','','',4,1048576,1,1,0,3,0,0,0,0,0,'',10,0,'','','','','','','','','','','','','','','','','','','','','',100,50,10,300,'good_basic','../_head.php','../_tail.php','','',1,1,5,'g4m_basic',0,0,50,'good_basic_sy',100,'both',30,15,'good_basic','','',174,124,3,125,100,1,0,'',0,'');
INSERT INTO `g5_board` VALUES ('intro','intro','사이트 소개','','',1,1,10,10,10,10,1,10,10,1,1,1,0,0,0,0,0,'','',0,0,0,1,0,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_basic','','','../_head.php','../_tail.php','','','',4,1048576,1,1,0,4,0,0,0,0,0,'',10,0,'','','','','','','','','','','','130','90','100','','','','','','','',100,50,10,300,'good_basic','../_head.php','../_tail.php','','',1,0,5,'g4m_basic',0,0,50,'good_basic_sy',100,'both',30,15,'good_webzine','','',174,124,3,125,100,1,0,'',0,'');
INSERT INTO `g5_board` VALUES ('gallery1','board','갤러리1','','',1,1,10,10,10,10,1,10,10,1,1,1,0,0,0,0,0,'','',0,0,0,0,1,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_gallery','','','../_head.php','../_tail.php','','','',4,1048576,1,1,0,5,0,0,0,0,0,'',10,0,'','목록 가로 픽셀','목록 세로 픽셀','압축 비율','전체 가로 픽셀','전체 세로 픽셀','','','','','','130','90','100','','','','','','','',100,50,10,300,'good_gallery','../_head.php','../_tail.php','','',1,0,5,'g4m_gallery',1,0,50,'good_gallery_sy',100,'both',30,15,'good_gallery','','',174,124,3,125,100,1,1,'',0,'');
INSERT INTO `g5_board` VALUES ('gallery2','board','갤러리2','','',1,1,10,10,10,10,1,10,10,1,1,1,0,0,0,0,1,'취미|여행|유머|기타','',0,0,0,1,1,0,1,1,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_webzine','','','../_head.php','../_tail.php','','','',4,1048576,1,1,0,5,0,0,0,0,0,'',10,0,'','목록 가로 픽셀','목록 세로 픽셀','압축 비율','전체 가로 픽셀','전체 세로 픽셀','','','','','','130','90','100','','','','','','','',100,50,10,300,'good_webzine2','../_head.php','../_tail.php','','',1,0,5,'g4m_gallery',2,0,50,'good_webzine_sy',100,'both',30,15,'good_webzine','','',174,124,3,125,100,1,2,'',0,'');
INSERT INTO `g5_board` VALUES ('gallery_ad','board','배너 광고','','',1,1,10,10,10,10,1,10,10,1,1,1,0,0,0,0,0,'','',0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_gallery','','','../_head.php','../_tail.php','','','',4,1048576,1,0,0,3,0,0,0,0,0,'',10,0,'','목록 가로 픽셀','목록 세로 픽셀','퀄러티','','','','','','','','210','140','90','','','','','','','',100,50,10,300,'good_webzine','../_head.php','../_tail.php','','',0,0,5,'g4m_basic',0,0,50,'good_gallery',100,'both',30,15,'good_webzine','','',174,124,3,125,100,0,0,'',0,'');
INSERT INTO `g5_board` VALUES ('request','callcenter','상담 요청','','',1,1,2,2,2,2,1,2,2,2,1,1,0,0,0,0,0,'','',0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_basic','','','../_head.php','../_tail.php','','','',4,1048576,1,1,0,1,0,0,0,0,0,'',10,0,'','','','','','','','','','','','','','','','','','','','','',100,50,10,300,'good_basic','../_head.php','../_tail.php','','',0,0,5,'g4m_basic',0,0,50,'good_basic',100,'both',30,15,'good_basic','','',174,124,3,125,100,0,0,'',0,'');
INSERT INTO `g5_board` VALUES ('service','service','서비스 내용','','',1,1,10,10,10,10,1,10,10,10,1,1,0,0,0,0,0,'','',0,0,0,1,0,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_basic','','','../_head.php','../_tail.php','','','',4,1048576,1,1,0,2,0,0,0,0,0,'',10,0,'','목록 가로 픽셀','목록 세로 픽셀','압축 비율','','','','','','','','130','90','90','','','','','','','',100,50,10,300,'good_basic','../_head.php','../_tail.php','','',1,0,5,'g4m_basic',0,0,50,'good_basic_sy',100,'both',30,15,'good_webzine','','',174,124,3,125,100,1,0,'',0,'');
INSERT INTO `g5_board` VALUES ('gallery0','board','갤러리0','','',1,1,10,10,10,10,1,10,10,1,1,1,0,0,0,0,0,'','',0,0,0,1,0,0,0,0,0,0,0,0,0,1,1,100,60,6,24,100,600,'good_gallery','','','../_head.php','../_tail.php','','','',3,1048576,1,0,0,1,0,0,0,0,0,'',10,0,'','목록 가로 픽셀','목록 세로 픽셀','압축 비율','','','','','','','','130','90','100','','','','','','','',100,50,10,300,'good_gallery','../_head.php','../_tail.php','','',0,0,5,'g4m_basic',0,0,50,'good_gallery',100,'both',30,15,'good_gallery','','',174,124,3,125,100,0,0,'',0,'');
INSERT INTO `g5_board` VALUES ('gallery_main_ad','board','메인 광고','','',1,1,10,10,10,10,1,10,10,1,1,1,0,0,0,0,0,'','',0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_gallery','','','../_head.php','../_tail.php','','','',4,1048576,1,0,0,4,0,0,0,0,0,'',10,0,'','목록 가로 픽셀','목록 세로 픽셀','퀄러티','','','','','','','','200','140','90','','','','','','','',100,50,10,300,'good_webzine','../_head.php','../_tail.php','','',0,1,5,'g4m_gallery_main',0,0,50,'good_basic',100,'both',30,15,'good_webzine','','',174,124,3,125,100,0,0,'',0,'');
INSERT INTO `g5_board` VALUES ('blog','blog','멤버 블로그','','',1,1,2,2,2,2,1,2,2,2,1,1,0,0,0,0,0,'','',0,0,0,1,0,0,1,1,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_blog','','','../_head.php','../_tail.php','','','',4,1048576,1,1,0,2,0,0,0,0,0,'',10,0,'','','','','','','','','','','','','','','','','','','','','',100,50,10,300,'good_blog','../_head.php','../_tail.php','','',1,1,5,'g4m_basic',0,0,50,'good_blog_sy',100,'both',30,15,'good_blog','','',174,124,3,125,100,1,0,'',0,'');
INSERT INTO `g5_board` VALUES ('main_banner','board','메인 배너','','',1,1,10,10,10,10,1,10,10,10,1,1,0,0,0,0,0,'','',0,0,0,1,0,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_webzine','','','../_head.php','../_tail.php','','','',4,1048576,1,0,0,1,0,0,0,0,0,'',10,0,'','','','','','','','','','','','','','','','','','','','','',100,50,10,300,'basic','../_head.php','../_tail.php','','',0,1,5,'g4m_basic',0,0,50,'good_basic',100,'both',30,15,'good_webzine','','',174,124,3,125,100,0,0,'',0,'');
INSERT INTO `g5_board` VALUES ('qa','callcenter','질문 답변','','',1,1,2,2,2,2,1,2,2,0,1,1,0,0,0,0,0,'','',0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_basic','','','../_head.php','../_tail.php','','','',4,1048576,1,1,0,0,0,0,0,0,0,'',10,0,'','','','','','','','','','','','','','','','','','','','','',100,50,10,300,'basic','../_head.php','../_tail.php','','',1,1,5,'g4m_basic',0,0,50,'basic',0,'both',30,15,'good_basic','','',174,124,0,125,100,0,1,'',0,'');
INSERT INTO `g5_board` VALUES ('builder','board','빌더 이용 안내','','',1,1,10,10,10,10,1,10,10,0,1,1,0,0,0,0,0,'','',0,0,0,1,0,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'good_basic','','','../_head.php','../_tail.php','','','',4,1048576,1,1,0,0,0,0,0,0,0,'',10,0,'','','','','','','','','','','','','','','','','','','','','',100,50,10,300,'basic','../_head.php','../_tail.php','','',1,1,5,'g4m_basic',0,0,50,'basic',0,'both',30,15,'good_basic','','',174,124,0,125,100,0,0,'',0,'');
INSERT INTO `g5_board` VALUES ('basic_about','intro','소개','','',1,1,10,10,10,10,1,10,10,0,1,1,0,0,0,0,0,'','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,100,60,15,24,100,600,'good_basic','','','_head.php','_tail.php','','','',4,1048576,1,1,0,3,0,0,0,0,0,'',2,0,'wr_datetime asc','','','','','','','','','','','','','','','','','','','','w3_basic',100,50,10,300,'basic','../_head.php','../_tail.php','','',1,1,5,'g4m_basic',0,0,50,'basic',0,'both',30,15,'basic','','',174,124,0,125,100,0,0,'',0,'');
INSERT INTO `g5_board` VALUES ('basic_main_banner','board','메인 배너','','',1,1,10,10,10,10,1,10,10,0,1,1,0,0,0,0,0,'','',0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'r_good_basic','','','_head.php','_tail.php','','','',4,5000000,1,1,0,1,0,0,0,0,0,'',10,0,'','','','','','','','','','','','','','','','','','','','','w3_basic',100,50,10,300,'basic','../_head.php','../_tail.php','','',1,1,5,'g4m_basic',0,0,50,'basic',0,'both',30,15,'basic','','',174,124,0,125,100,0,0,'',0,'');
INSERT INTO `g5_board` VALUES ('basic_gallery','intro','갤러리','','',1,1,10,10,10,10,1,10,10,0,1,1,0,0,0,0,0,'','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,100,60,15,24,100,600,'basic','','','_head.php','_tail.php','','','',4,10485760,1,1,0,8,0,0,0,0,0,'',10,0,'','','','','','','','','','','','','','','','','','','','','w3_basic',100,50,10,300,'basic','../_head.php','../_tail.php','','',1,1,5,'g4m_basic',0,0,50,'basic',0,'both',30,15,'basic','','',174,124,0,125,100,0,0,'',0,'');
INSERT INTO `g5_board` VALUES ('basic_service','intro','서비스','','',1,1,10,10,10,10,1,10,10,0,1,1,0,0,0,0,0,'','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,100,60,15,24,100,600,'basic','','','_head.php','_tail.php','','','',4,10485760,1,1,0,4,0,0,0,0,0,'',2,0,'wr_datetime asc','','','','','','','','','','','','','','','','','','','','w3_basic',100,50,10,300,'basic','../_head.php','../_tail.php','','',1,1,5,'g4m_basic',0,0,50,'basic',0,'both',30,15,'basic','','',174,124,0,125,100,0,0,'',0,'');
INSERT INTO `g5_board` VALUES ('basic_contact','callcenter','상담','','',10,10,1,10,10,10,10,10,10,0,1,1,0,0,0,0,0,'','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,100,60,15,24,100,600,'basic','','','_head.php','_tail.php','','','',4,1048576,1,1,0,16,0,0,0,0,0,'',2,0,'','','','','','','','','','','','','','','','','','','','','w3_basic',100,50,10,300,'basic','../_head.php','../_tail.php','','',1,1,5,'g4m_basic',0,0,50,'basic',0,'both',30,15,'basic','','',174,124,0,125,100,0,0,'',0,'상담 및 문의를 환영합니다!');
/*!40000 ALTER TABLE `g5_board` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_board_file`
--

DROP TABLE IF EXISTS `g5_board_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_board_file` (
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` int(11) NOT NULL DEFAULT '0',
  `bf_no` int(11) NOT NULL DEFAULT '0',
  `bf_source` varchar(255) NOT NULL DEFAULT '',
  `bf_file` varchar(255) NOT NULL DEFAULT '',
  `bf_download` varchar(255) NOT NULL DEFAULT '',
  `bf_content` text NOT NULL,
  `bf_filesize` int(11) NOT NULL DEFAULT '0',
  `bf_width` int(11) NOT NULL DEFAULT '0',
  `bf_height` smallint(6) NOT NULL DEFAULT '0',
  `bf_type` tinyint(4) NOT NULL DEFAULT '0',
  `bf_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`bo_table`,`wr_id`,`bf_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_board_file`
--

LOCK TABLES `g5_board_file` WRITE;
/*!40000 ALTER TABLE `g5_board_file` DISABLE KEYS */;
INSERT INTO `g5_board_file` VALUES ('callcenter',1,0,'gallery.png','2130706433_Y1eWwEAk_gallery.png','0','',1587,600,400,3,'2013-07-06 22:43:27');
INSERT INTO `g5_board_file` VALUES ('gallery_ad',3,0,'family-591579_960_720.jpg','2130706433_4SdH2c5E_9956981f31305df54c58c420fefff45144a40bcc.jpg','0','',183379,960,640,2,'2016-05-13 00:48:10');
INSERT INTO `g5_board_file` VALUES ('gallery_ad',2,0,'mont-st-michel-343642__340.jpg','2130706433_CXI3SLcQ_dc149003ba39f324adc43011fed37a9477acc2a7.jpg','0','',11266,510,340,2,'2016-05-13 01:18:13');
INSERT INTO `g5_board_file` VALUES ('gallery_ad',1,0,'fishing-at-sunset-209112_1920.jpg','2130706433_olSEAkU1_7b78b8e80ac59ea0ad8f70fcf94cc8cba222da76.jpg','0','',484882,1920,1080,2,'2016-05-13 00:54:44');
INSERT INTO `g5_board_file` VALUES ('gallery2',2,0,'spring-800240__340.jpg','2130706433_bAm6CzkX_7efca3d06eb5f8c1783f60ee2da1e505b95ff626.jpg','0','',55637,510,340,2,'2016-05-10 02:10:07');
INSERT INTO `g5_board_file` VALUES ('gallery2',1,0,'strawberries-in-bowl-783351__340.jpg','2130706433_LNwudsQV_aa74a0c090caae74c6164acc35dc481589e9005c.jpg','0','',35719,510,340,2,'2016-05-10 02:11:53');
INSERT INTO `g5_board_file` VALUES ('gallery0',1,0,'Head02.jpg','2130706433_ecaEbOAC_Head02.jpg','0','',17136,470,52,2,'2014-08-01 04:45:43');
INSERT INTO `g5_board_file` VALUES ('gallery_ad',6,0,'banner-sample-01.png','2130706433_J7VuHQMP_banner-sample-01.png','0','',458,220,140,3,'2012-11-09 01:21:18');
INSERT INTO `g5_board_file` VALUES ('gallery_ad',7,0,'banner-sample-02.png','2130706433_XPtjLF2G_banner-sample-02.png','0','',457,220,140,3,'2012-11-09 01:23:44');
INSERT INTO `g5_board_file` VALUES ('gallery_main_ad',1,0,'nature-893465_1280.wide.jpg','2130706433_bWB4zltI_5a3b93f285c23faf6ec2dff2a9e7a7bcd5181d29.jpg','0','',703352,1280,486,2,'2016-05-08 01:10:39');
INSERT INTO `g5_board_file` VALUES ('gallery2',4,0,'breakfast-848313__340.jpg','2130706433_N6wWAoa4_6687dbaaa7cc6fb208e75bc3bec84e5bd3b1989a.jpg','0','',44307,510,340,2,'2016-05-10 02:08:46');
INSERT INTO `g5_board_file` VALUES ('gallery1',3,0,'japanese-cherry-trees-324175__340.jpg','2130706433_70dwAt4E_1d360ed316501d210631a967c15a3a06e51cdcd7.jpg','0','',28928,510,340,2,'2016-05-10 01:57:50');
INSERT INTO `g5_board_file` VALUES ('gallery1',2,0,'flower-180035__340.jpg','2130706433_RaNsTrO8_dd57cfdd9ff051fdfefbcce612c3af2dffea8864.jpg','0','',24284,510,340,2,'2016-05-10 02:00:11');
INSERT INTO `g5_board_file` VALUES ('gallery1',1,0,'flower-215565__340.jpg','2130706433_8rsF7j2R_349f0d8aec4fd29a7beca45c6885342b4a181e49.jpg','0','',28329,510,340,2,'2016-05-10 01:52:23');
INSERT INTO `g5_board_file` VALUES ('intro',2,0,'gallery.png','2130706433_Xr5xlJzi_gallery.png','0','',1587,600,400,3,'2013-08-09 03:03:59');
INSERT INTO `g5_board_file` VALUES ('intro',1,0,'gallery.png','2130706433_e7pU6lMA_gallery.png','0','',1587,600,400,3,'2013-08-09 03:03:42');
INSERT INTO `g5_board_file` VALUES ('service',2,0,'gallery.png','2130706433_avwMt7zR_gallery.png','0','',1587,600,400,3,'2013-06-02 01:00:23');
INSERT INTO `g5_board_file` VALUES ('service',1,0,'gallery.png','2130706433_aNk1ZdHT_gallery.png','0','',1587,600,400,3,'2013-06-02 01:00:44');
INSERT INTO `g5_board_file` VALUES ('blog',1,0,'gallery-half.png','2130706433_KuPB3ifZ_gallery-half.png','0','',837,600,200,3,'2013-07-17 01:35:37');
INSERT INTO `g5_board_file` VALUES ('blog',2,0,'gallery-half.png','2130706433_Zkvn5g8D_gallery-half.png','0','',837,600,200,3,'2013-07-17 01:36:08');
INSERT INTO `g5_board_file` VALUES ('gallery1',4,0,'bloom-283020__340.jpg','2130706433_q53j90mD_ee8b6856862a9474d6649aa91b7623eb12fc971a.jpg','0','',37937,507,340,2,'2016-05-10 01:58:50');
INSERT INTO `g5_board_file` VALUES ('main_banner',1,0,'Main-slide-09.jpg','1825697942_7hMpDoIV_Main-slide-09.jpg','0','',145125,740,406,2,'2014-11-21 03:14:40');
INSERT INTO `g5_board_file` VALUES ('intro',3,0,'gallery.png','2130706433_cPiIZKuH_gallery.png','0','',1587,600,400,3,'2014-05-06 21:53:44');
INSERT INTO `g5_board_file` VALUES ('intro',4,0,'gallery.png','2130706433_RMmXnkVt_gallery.png','0','',1587,600,400,3,'2014-05-06 21:54:47');
INSERT INTO `g5_board_file` VALUES ('gallery_main_ad',2,0,'spring-flowers-741965_1920.wide.jpg','2130706433_vUNuzigd_95002109fa86e104d51c01d3f76df1312d3cb12e.jpg','0','',833342,1920,784,2,'2016-05-07 20:12:31');
INSERT INTO `g5_board_file` VALUES ('gallery_main_ad',3,0,'dandelion-817642_1920.wide.jpg','2130706433_zoZwdLX5_26a373fba624eae0bce089b49fe5c37dc289041a.jpg','0','',761750,1920,729,2,'2016-05-08 01:09:24');
INSERT INTO `g5_board_file` VALUES ('gallery_main_ad',4,0,'wild-flowers-571940_1920.wide.jpg','2130706433_59LuFeG0_2032cb9e365bf6668819088ca02364186ca17ece.jpg','0','',664508,1920,729,2,'2016-05-08 01:08:09');
INSERT INTO `g5_board_file` VALUES ('gallery1',5,0,'bee-173322__340.jpg','2130706433_d1TvIJZX_ee382aebc8fe95c88985395edcfa4522ce89cc7c.jpg','0','',41234,604,340,2,'2016-05-10 02:05:26');
INSERT INTO `g5_board_file` VALUES ('gallery2',5,0,'vegetables-791892__340.jpg','2130706433_wDAz7XQ2_c96d60c2fbb21008885ee539ca079c2d67b73660.jpg','0','',51897,509,340,2,'2016-05-12 00:19:06');
INSERT INTO `g5_board_file` VALUES ('gallery2',6,0,'summer-still-life-783347__340.jpg','2130706433_VRUKeJ2r_7b2df5fdf024ebfa50265ee1555bbb6638c87834.jpg','0','',45432,510,340,2,'2016-05-12 00:20:49');
INSERT INTO `g5_board_file` VALUES ('archi_about',7,0,'about_3.jpg','2130706433_tWYZ2Fam_e9378730b4ee1b4588d5f13e53d5c0945ec3ca09.jpg','0','',460355,1024,640,2,'2017-06-27 04:02:42');
INSERT INTO `g5_board_file` VALUES ('archi_about',6,0,'about_2.jpg','2130706433_Wt6zEn7L_a576df2241d53289262a927c4008598a8f828da5.jpg','0','',429169,1024,640,2,'2017-06-27 04:08:04');
INSERT INTO `g5_board_file` VALUES ('archi_about',5,0,'about_1.jpg','2130706433_krH1fv5Y_2e70e9815ee560d946d2d55a5dd55a60ea0a57c4.jpg','0','',366074,1024,640,2,'2017-06-27 04:07:37');
INSERT INTO `g5_board_file` VALUES ('archi_main_banner',1,0,'architect.jpg','2130706433_EnkShRO4_40b7591ce77995283bbb67b978279fb73b61fc5b.jpg','0','',85530,1500,800,2,'2017-07-27 20:46:58');
INSERT INTO `g5_board_file` VALUES ('archi_members',1,0,'team1.jpg','2130706433_5UnHlhGQ_29a5a52811e526a76f0685016f87ec11bc2c50f5.jpg','0','',14849,500,333,2,'2017-07-04 17:45:57');
INSERT INTO `g5_board_file` VALUES ('archi_members',2,0,'team2.jpg','2130706433_0XaTftF4_7a0eac1aad0e24a7def5922096d146ddb592bd3a.jpg','0','',8378,500,333,2,'2017-07-04 17:50:16');
INSERT INTO `g5_board_file` VALUES ('archi_members',3,0,'team3.jpg','2130706433_NUoWOm02_081d5548ba5bea1f8cdcd8139f9feae3aa15316d.jpg','0','',16744,500,333,2,'2017-07-04 17:51:08');
INSERT INTO `g5_board_file` VALUES ('archi_members',4,0,'team4.jpg','2130706433_el7Hn3CF_ba518bb85a7b3f9e6155270ae78ad1a7085bf71f.jpg','0','',14124,500,333,2,'2017-07-04 17:51:34');
INSERT INTO `g5_board_file` VALUES ('archi_works',1,0,'house5.jpg','2130706433_71dbIhsw_1bb2068354ad7b145ea48fceb7aae9e074403a32.jpg','0','',30267,500,333,2,'2017-07-04 02:23:56');
INSERT INTO `g5_board_file` VALUES ('archi_works',2,0,'house2.jpg','2130706433_d2vEtAi5_6f1368cc9109b5746b65169504a8e49d46cd2c66.jpg','0','',30068,500,333,2,'2017-07-04 02:23:33');
INSERT INTO `g5_board_file` VALUES ('archi_works',3,0,'house3.jpg','2130706433_NdLj85Og_6985a36727f2480ef242fc4c60e8ebc90b6ba261.jpg','0','',14906,500,333,2,'2017-07-04 02:23:10');
INSERT INTO `g5_board_file` VALUES ('archi_works',4,0,'house4.jpg','2130706433_aI39LDRY_af30cb39bfc838955b9750a36cb16e03b7fa4753.jpg','0','',16020,500,333,2,'2017-07-04 02:24:23');
INSERT INTO `g5_board_file` VALUES ('archi_works',5,0,'house5.jpg','2130706433_rRc18euN_bf036101bfbeaa5d48908ae83832029f83577bc2.jpg','0','',30267,500,333,2,'2017-07-04 02:24:58');
INSERT INTO `g5_board_file` VALUES ('archi_works',6,0,'house2.jpg','2130706433_meY0jECg_33ec1522e5e6733bc930b1d3d75ec87c3d594e30.jpg','0','',30068,500,333,2,'2017-07-04 02:26:21');
INSERT INTO `g5_board_file` VALUES ('archi_works',7,0,'house3.jpg','2130706433_YNJf5Xb7_7e958fa0897339acaa5a44519856273eb1df5e1e.jpg','0','',14906,500,333,2,'2017-07-04 02:26:51');
INSERT INTO `g5_board_file` VALUES ('archi_works',8,0,'house4.jpg','2130706433_jdPNZRYu_cec344cab7caf1592ed417d15490bdc459014de3.jpg','0','',16020,500,333,2,'2017-07-04 02:27:19');
INSERT INTO `g5_board_file` VALUES ('band_members',1,0,'team1.jpg','2130706433_5UnHlhGQ_29a5a52811e526a76f0685016f87ec11bc2c50f5.jpg','0','',14849,500,333,2,'2017-07-04 17:45:57');
INSERT INTO `g5_board_file` VALUES ('band_members',2,0,'team2.jpg','2130706433_0XaTftF4_7a0eac1aad0e24a7def5922096d146ddb592bd3a.jpg','0','',8378,500,333,2,'2017-07-04 17:50:16');
INSERT INTO `g5_board_file` VALUES ('band_members',3,0,'team3.jpg','2130706433_NUoWOm02_081d5548ba5bea1f8cdcd8139f9feae3aa15316d.jpg','0','',16744,500,333,2,'2017-07-04 17:51:08');
INSERT INTO `g5_board_file` VALUES ('band_members',4,0,'team4.jpg','2130706433_el7Hn3CF_ba518bb85a7b3f9e6155270ae78ad1a7085bf71f.jpg','0','',14124,500,333,2,'2017-07-04 17:51:34');
INSERT INTO `g5_board_file` VALUES ('band_tours',1,0,'newyork.jpg','2130706433_BSFmVMGT_160ade0a6bf7d445cf217b5c08ed9aa32629e030.jpg','0','',33636,400,300,2,'2017-07-07 17:39:51');
INSERT INTO `g5_board_file` VALUES ('band_tours',2,0,'paris.jpg','2130706433_PGAhUgHe_a5dcf640328609f88fcc280305d70b37ec0153c9.jpg','0','',29529,400,300,2,'2017-07-07 17:40:46');
INSERT INTO `g5_board_file` VALUES ('band_tours',3,0,'sanfran.jpg','2130706433_tFPXLu3a_9321dc0472154d1dfe1e33ac0dde26890cf97ecc.jpg','0','',16102,400,300,2,'2017-07-07 17:41:40');
INSERT INTO `g5_board_file` VALUES ('band_main_banner',1,0,'chicago.jpg','2130706433_gcdzSmEp_5b0d6c8c8c85a4353a9e097b9b79d16012ee7fc1.jpg','0','',30675,1200,600,2,'2017-08-05 22:11:31');
INSERT INTO `g5_board_file` VALUES ('band_main_banner',3,0,'la.jpg','2130706433_k49WfCAM_74322556114d81dba96cb4907f85b8282bb2e386.jpg','0','',17761,1200,600,2,'2017-08-05 22:11:56');
INSERT INTO `g5_board_file` VALUES ('band_about',1,0,'ny.jpg','2130706433_a9NTynAL_5511d9fe689b24d8a5b3f858d0f2184afa08acd0.jpg','0','',21125,1200,600,2,'2017-07-28 10:45:28');
INSERT INTO `g5_board_file` VALUES ('band_main_banner',2,0,'ny.jpg','2130706433_Mx1LUs8l_879995d3355c2a01eaae5106b6ebe9f4976fea20.jpg','0','',21125,1200,600,2,'2017-08-05 22:03:34');
INSERT INTO `g5_board_file` VALUES ('basic_about',5,0,'about_1.jpg','2130706433_krH1fv5Y_2e70e9815ee560d946d2d55a5dd55a60ea0a57c4.jpg','0','',366074,1024,640,2,'2017-06-27 04:07:37');
INSERT INTO `g5_board_file` VALUES ('basic_about',6,0,'about_11.jpg','2130706433_iBUnPkqZ_5815cc47237593bda9f8fb5fa94df29a6c01eb5b.jpg','0','',420778,1024,640,2,'2017-08-13 01:48:30');
INSERT INTO `g5_board_file` VALUES ('basic_about',7,0,'g97kovjgmqa_basic.jpg','2130706433_io8z7t6g_fc0229cbacd4a5e45346c2d0fa06ea92b20e0db6.jpg','0','',405320,1024,640,2,'2017-08-13 01:53:54');
INSERT INTO `g5_board_file` VALUES ('basic_main_banner',1,0,'beach_boat_basic2.jpg','2130706433_RxeqAZ7Q_59d6ea77bda12f24df1bcab62788f45db35ed75e.jpg','0','',445470,1024,680,2,'2017-08-13 00:47:38');
INSERT INTO `g5_board_file` VALUES ('basic_gallery',4,0,'dike_dike_road_basic.jpg','2130706433_FgfbQu7m_bb7856a38f41be4ce7c3acf5f0bde53b5a7d67db.jpg','0','',491506,1024,680,2,'2017-08-12 02:00:00');
INSERT INTO `g5_board_file` VALUES ('basic_gallery',3,0,'coast_sea_basic.jpg','2130706433_F7dRkbDL_2af1810857f45c13b84ac0a2f82dc55ea7511b4e.jpg','0','',415751,1024,682,2,'2017-08-12 01:40:49');
INSERT INTO `g5_board_file` VALUES ('basic_gallery',2,0,'baltic_sea_sunset_basic.jpg','2130706433_WxSjBoQl_54897bd786b1807299dc0839f9c2db3ecfdc8e06.jpg','0','',439619,1024,680,2,'2017-08-12 01:39:48');
INSERT INTO `g5_board_file` VALUES ('basic_gallery',1,0,'baltic_sea_angler_basic.jpg','2130706433_OI7qMQxk_f9d3fa3aa5209105e6413a6bf4edc1cb8b787e78.jpg','0','',452311,1024,680,2,'2017-08-12 01:39:05');
INSERT INTO `g5_board_file` VALUES ('basic_service',1,0,'pedalo_basic.jpg','2130706433_OYM81ohW_26e0edee09192f9748cce21422619cec439a264f.jpg','0','',447945,1024,683,2,'2017-08-11 21:39:52');
INSERT INTO `g5_board_file` VALUES ('basic_service',2,0,'kite_surfer_basic.jpg','2130706433_Mvh24JIu_23262d69504dc0d89378c0cdf52b039a191bc95b.jpg','0','',441279,1024,685,2,'2017-08-11 21:41:51');
INSERT INTO `g5_board_file` VALUES ('basic_service',3,0,'sun_bed_basic.jpg','2130706433_AK2mxntH_fb120daede2eba3d52bc3f343a6b0b465bcba598.jpg','0','',459547,1024,683,2,'2017-08-11 21:40:52');
INSERT INTO `g5_board_file` VALUES ('basic_service',4,0,'restaurant_basic.jpg','2130706433_NZPV4xce_d2e48d27928a66353d8def0f743975e554364e5a.jpg','0','',604007,1024,683,2,'2017-08-11 21:42:18');
INSERT INTO `g5_board_file` VALUES ('basic_gallery',5,0,'east_devon_basic.jpg','2130706433_GnKmL84A_2addcb076fbf5bc79182368e375c587b5f0a3fb3.jpg','0','',560293,1024,680,2,'2017-08-12 02:01:08');
INSERT INTO `g5_board_file` VALUES ('basic_gallery',6,0,'explorer_basic.jpg','2130706433_2LoaUnXt_c6385502400a57316c3ff310853edfacebe9d9aa.jpg','0','',710176,1024,683,2,'2017-08-12 01:44:02');
INSERT INTO `g5_board_file` VALUES ('basic_gallery',7,0,'house_in_basic.jpg','2130706433_lHYCx9P2_cff9b14bdd1aee6e6af725c6f71da0f7d10d5715.jpg','0','',356145,1024,683,2,'2017-08-12 01:44:57');
INSERT INTO `g5_board_file` VALUES ('basic_gallery',8,0,'moon_sea_basic.jpg','2130706433_YtPKm6hO_99f7b7f428c299319e2a501d3b5e94bd10a3f913.jpg','0','',509820,1024,680,2,'2017-08-12 01:47:24');
INSERT INTO `g5_board_file` VALUES ('cafe_main_banner',1,0,'coffeehouse.jpg','2130706433_Chn90Gxv_069c099e0697d67105b2a0350a361598614884f1.jpg','0','',68443,1200,900,2,'2017-07-20 00:53:35');
INSERT INTO `g5_board_file` VALUES ('cafe_about',1,0,'coffeeshop.jpg','2130706433_vzy1Ku5I_1016a387f96fb5cb7381260fb998139483e0ba8c.jpg','0','',49787,900,506,2,'2017-07-20 02:14:52');
INSERT INTO `g5_board_file` VALUES ('cafe_main_banner',1,1,'coffeehouse2.jpg','2130706433_OyDxMr10_da336e0a5d315a1b8c9cc14425b8c1bd69f9fbba.jpg','0','',30674,900,506,2,'2017-07-20 18:14:18');
INSERT INTO `g5_board_file` VALUES ('cafe_menu',3,0,'coffeehouse2.jpg','2130706433_ikbR3XvW_60f402f2295b94195e2b0ced9be2e20390278100.jpg','0','',30674,900,506,2,'2017-07-28 10:57:10');
INSERT INTO `g5_board_file` VALUES ('cafe_menu',2,0,'coffeehouse2.jpg','2130706433_qVM1b3RT_422ba6fa9a8f6120eaba85b37874b2a92634b63b.jpg','0','',30674,900,506,2,'2017-07-28 10:56:22');
INSERT INTO `g5_board_file` VALUES ('cafe_menu',1,0,'coffeehouse2.jpg','2130706433_xJdgUhFT_17fe03da728f8713fe9323be2a6de64a68a5a5dc.jpg','0','',30674,900,506,2,'2017-07-28 10:55:46');
INSERT INTO `g5_board_file` VALUES ('cafe_menu',4,0,'coffeehouse2.jpg','2130706433_UepohyEt_4fd3862070230da4f11f03671d26293fa106ccb1.jpg','0','',30674,900,506,2,'2017-07-28 10:58:11');
INSERT INTO `g5_board_file` VALUES ('cafe_menu',5,0,'coffeehouse2.jpg','2130706433_fzHPgoV4_a830754da136e5612aaf1afef259be2a616da7d7.jpg','0','',30674,900,506,2,'2017-07-28 10:58:35');
INSERT INTO `g5_board_file` VALUES ('cafe_menu',6,0,'coffeehouse2.jpg','2130706433_pZo5OQbH_1e2b24f792ba04a104f128f2915f1bab0406444c.jpg','0','',30674,900,506,2,'2017-07-28 10:58:59');
INSERT INTO `g5_board_file` VALUES ('cafe_menu',7,0,'coffeehouse2.jpg','2130706433_2YSZNbpI_940b3ea1f4b0ad0e823b9e02e89f6aec3043432b.jpg','0','',30674,900,506,2,'2017-07-28 10:59:31');
INSERT INTO `g5_board_file` VALUES ('cafe_menu',8,0,'coffeehouse2.jpg','2130706433_0ItSL8mY_81274ef7b3d4775193f0bfbf7c560ac8b1f99bb5.jpg','0','',30674,900,506,2,'2017-07-28 10:59:57');
INSERT INTO `g5_board_file` VALUES ('cafe_menu',9,0,'coffeehouse2.jpg','2130706433_IQxpJibv_4c4e8650f1b42d398cc1f04fb42461314e2ebf97.jpg','0','',30674,900,506,2,'2017-07-28 11:00:22');
INSERT INTO `g5_board_file` VALUES ('cafe_menu',10,0,'coffeehouse2.jpg','2130706433_TNelbMG0_f74e1056ecb3ce100618a05d50575f24f497e103.jpg','0','',30674,900,506,2,'2017-07-28 11:00:46');
INSERT INTO `g5_board_file` VALUES ('fashion_main_banner',1,0,'jane.jpg','2130706433_jESvUoVN_4073cf2fb0e3f63bb9b85cea4d0134abc76187c5.jpg','0','',95436,1600,1060,2,'2017-07-12 20:55:47');
INSERT INTO `g5_board_file` VALUES ('fashion_blog',1,0,'runway.jpg','2130706433_LyEsnZqS_0c2cee4d797de6787a9360481c23116c3daa0ad5.jpg','0','',35694,600,395,2,'2017-07-12 21:18:48');
INSERT INTO `g5_board_file` VALUES ('fashion_blog',2,0,'man_hat.jpg','2130706433_lWOMDtjm_5318145909a2a16d7a2bdf1897dc5390edb8947b.jpg','0','',32889,600,395,2,'2017-07-12 21:05:04');
INSERT INTO `g5_board_file` VALUES ('fashion_blog',3,0,'girl_hat.jpg','2130706433_meD5qryz_479f323b2d9abb9d7dd54c809562318e339ef635.jpg','0','',19571,600,395,2,'2017-07-12 21:18:06');
INSERT INTO `g5_board_file` VALUES ('fashion_about',1,0,'avatar_girl2.jpg','2130706433_o6FQ5DyU_6718b8af2cee7d897bc18247816f0056a05cecfa.jpg','0','',5457,300,160,2,'2017-07-13 00:35:07');
INSERT INTO `g5_board_file` VALUES ('fashion_ad',1,0,'jeans3.jpg','2130706433_XKxnWw5I_1527296680859812bbefa8679fe2bd7f3b6a306c.jpg','0','',18807,400,500,2,'2017-07-13 01:00:47');
INSERT INTO `g5_board_file` VALUES ('fashion_inspiration',1,0,'avatar_hat.jpg','2130706433_U2JCs9e6_00228c2e341aeeee8a3e25d2325afb001adb2c70.jpg','0','',13680,500,333,2,'2017-07-13 01:05:08');
INSERT INTO `g5_board_file` VALUES ('fashion_inspiration',2,0,'team1.jpg','2130706433_ycMJ7rKP_c70cfed706ca8f860fafae3f0dd00fa22c103b9a.jpg','0','',14849,500,333,2,'2017-07-13 22:05:03');
INSERT INTO `g5_board_file` VALUES ('fashion_inspiration',3,0,'jeans.jpg','2130706433_3rf2yFmn_b69ea008a36ddc2544b5452bf566ef0705ac4b48.jpg','0','',90224,1200,800,2,'2017-07-13 22:05:34');
INSERT INTO `g5_board_file` VALUES ('fashion_inspiration',4,0,'team4.jpg','2130706433_hNU57ARo_43d5c520ac95533ca3126508437e5c24ab0d5e8c.jpg','0','',14124,500,333,2,'2017-07-13 01:12:08');
INSERT INTO `g5_board_file` VALUES ('market_main_banner',1,0,'sound.jpg','2130706433_yENClR70_138fff5457496ccdb4bc236729700bd1437e875c.jpg','0','',56401,1100,500,2,'2017-07-26 03:52:12');
INSERT INTO `g5_board_file` VALUES ('market_main_banner',2,0,'workbench.jpg','2130706433_kn1awqHK_60b095d5db37886eacb1074696cbe3c825ae8155.jpg','0','',101592,1100,500,2,'2017-07-26 03:52:59');
INSERT INTO `g5_board_file` VALUES ('market_main_banner',3,0,'coffee.jpg','2130706433_2mLnGoXz_ed47c2c69ac6d0b4ee85187cd8e0c0d1dddffd83.jpg','0','',26771,1100,500,2,'2017-07-26 03:54:25');
INSERT INTO `g5_board_file` VALUES ('market_members',1,0,'team1.jpg','2130706433_riMIdBqS_d466478900fc0f7e8dec609b438dad529abc8f23.jpg','0','',14849,500,333,2,'2017-07-26 04:18:08');
INSERT INTO `g5_board_file` VALUES ('market_members',2,0,'team2.jpg','2130706433_f4RmCeb7_345620195ceba8334763be70fe0c1e56345d58b3.jpg','0','',8378,500,333,2,'2017-07-26 04:19:14');
INSERT INTO `g5_board_file` VALUES ('market_members',3,0,'team3.jpg','2130706433_A1D3Fzb9_ae033140a0717606a945b3081b94b1faebd95f15.jpg','0','',16744,500,333,2,'2017-07-26 04:20:09');
INSERT INTO `g5_board_file` VALUES ('market_offer',1,0,'coffee.jpg','2130706433_4uWPsn6I_7b5984d489ad3ed97adba94bdac9d3d972c0468b.jpg','0','',26771,1100,500,2,'2017-07-28 11:10:06');
INSERT INTO `g5_board_file` VALUES ('market_offer',2,0,'fjords.jpg','2130706433_yZibfv75_2bcabaa001254b1048b259cfebe7177c95be5f9e.jpg','0','',37075,600,400,2,'2017-07-28 11:10:44');
INSERT INTO `g5_board_file` VALUES ('market_offer',3,0,'lights.jpg','2130706433_5n3DAEqV_e7a339007d062832489298fc7bc70893e823b722.jpg','0','',20461,600,400,2,'2017-07-28 11:12:18');
INSERT INTO `g5_board_file` VALUES ('market_offer',4,0,'mountains.jpg','2130706433_4wng1BlK_2a9161466b78560a94b6af9b2c3a9b9436c36694.jpg','0','',43415,600,400,2,'2017-07-28 11:12:46');
INSERT INTO `g5_board_file` VALUES ('photo3_main_banner',1,0,'photographer.jpg','2130706433_m7GrDATk_2170de75822fea880ed8bb75de8caa3d06e40443.jpg','0','',146994,1500,600,2,'2017-07-25 00:23:31');
INSERT INTO `g5_board_file` VALUES ('photo3_portfolio',1,0,'mountains2.jpg','2130706433_kR3hdme1_cc4e213f5ba901d24ac0e38618588ef07b362b5d.jpg','0','',69892,1000,500,2,'2017-07-25 01:48:07');
INSERT INTO `g5_board_file` VALUES ('photo3_portfolio',2,0,'mountainskies.jpg','2130706433_KC5On2zQ_23c0900688afea5d59fd7df036d67d194ae6b2a0.jpg','0','',48294,1000,500,2,'2017-07-25 01:49:34');
INSERT INTO `g5_board_file` VALUES ('photo3_portfolio',3,0,'falls2.jpg','2130706433_8t2BYmXF_69b70fc6fa014a0625f8530782b2ddf6a8ebbd04.jpg','0','',31500,1000,500,2,'2017-07-25 01:50:19');
INSERT INTO `g5_board_file` VALUES ('photo3_portfolio',4,0,'ocean2.jpg','2130706433_swJNBYcQ_e45681769581af2c5020d6a561ce04669e30fc14.jpg','0','',57097,1000,500,2,'2017-07-25 01:51:15');
INSERT INTO `g5_board_file` VALUES ('photo3_portfolio',5,0,'ocean.jpg','2130706433_FcS8bQBA_e72131ead7e758ee747a39fe6d9ac27e430d339c.jpg','0','',68793,1000,500,2,'2017-07-25 01:51:46');
INSERT INTO `g5_board_file` VALUES ('restau_main_banner',1,0,'onepage_restaurant.jpg','2130706433_EFPs0iAf_797a2d8953baeffa97b87f85503072d82486737d.jpg','0','',47085,1000,666,2,'2017-07-25 21:09:05');
INSERT INTO `g5_board_file` VALUES ('website_business',2,0,'business_1.jpg','2130706433_8w7ixDuJ_2d7cec40b1e4372bbb809ee25cf35d716196cc9b.jpg','0','',635649,1024,680,2,'2017-06-26 20:45:53');
INSERT INTO `g5_board_file` VALUES ('website_business',3,0,'business_2.jpg','2130706433_Nin02QHt_b2b8c71cc94a750d74df5ef8ea516a5c37768a39.jpg','0','',651356,1024,680,2,'2017-06-26 20:46:26');
INSERT INTO `g5_board_file` VALUES ('website_business',4,0,'business_3.jpg','2130706433_OQrReU3t_cbde39069841de4300903ec9f4ee2b1438245125.jpg','0','',583576,1024,680,2,'2017-06-26 20:46:58');
INSERT INTO `g5_board_file` VALUES ('website_about',7,0,'about_3.jpg','2130706433_tWYZ2Fam_e9378730b4ee1b4588d5f13e53d5c0945ec3ca09.jpg','0','',460355,1024,640,2,'2017-06-27 04:02:42');
INSERT INTO `g5_board_file` VALUES ('website_about',6,0,'about_2.jpg','2130706433_Wt6zEn7L_a576df2241d53289262a927c4008598a8f828da5.jpg','0','',429169,1024,640,2,'2017-06-27 04:08:04');
INSERT INTO `g5_board_file` VALUES ('website_about',5,0,'about_1.jpg','2130706433_krH1fv5Y_2e70e9815ee560d946d2d55a5dd55a60ea0a57c4.jpg','0','',366074,1024,640,2,'2017-06-27 04:07:37');
INSERT INTO `g5_board_file` VALUES ('website_business',5,0,'business_4.jpg','2130706433_BbTpt9sK_3f798e09efc3a8405b2b678b41a67c8b5264d34d.jpg','0','',444240,1024,680,2,'2017-06-26 20:47:29');
INSERT INTO `g5_board_file` VALUES ('website_products',2,0,'products_1.jpg','2130706433_XoaOSxhJ_4f3731b4b611eece751e2cff16778348c8004780.jpg','0','',469581,1024,680,2,'2017-06-26 20:48:32');
INSERT INTO `g5_board_file` VALUES ('website_products',3,0,'products_2.jpg','2130706433_MZCbGVF9_014c1f51e32f8923337e77f7fec8bc6fd21df651.jpg','0','',504936,1024,680,2,'2017-06-26 20:49:05');
INSERT INTO `g5_board_file` VALUES ('website_products',4,0,'products_3.jpg','2130706433_9LA0XCg4_b6fe2012450e9a73672175c6d47a41a83c8aa8e4.jpg','0','',494366,1024,684,2,'2017-06-26 20:49:36');
INSERT INTO `g5_board_file` VALUES ('website_main_banner',1,0,'main_banner_1.jpg','2130706433_fPtguLMa_90b8b1ff754bd8ef602d8cd74cbdc75f1d14987e.jpg','0','',498386,1024,680,2,'2017-06-30 16:44:37');
INSERT INTO `g5_board_file` VALUES ('wedding_main_banner',1,0,'wedding_couple.jpg','2130706433_Qx6h5SHZ_68870261e8040b142a7af93acd880863092e787b.jpg','0','',41901,1000,667,2,'2017-07-21 23:18:58');
INSERT INTO `g5_board_file` VALUES ('wedding_about',1,0,'wedding_couple2.jpg','2130706433_Rju1ekoz_caa1427c2d0ec3ec32673dc384821515e5deb52e.jpg','0','',33438,900,506,2,'2017-07-22 00:29:06');
INSERT INTO `g5_board_file` VALUES ('wedding_main_banner',2,0,'flowers.jpg','2130706433_aGql026r_475cd9342c8ab15e3d7c33ad175928606fb061e8.jpg','0','',71221,1000,668,2,'2017-07-22 01:20:01');
INSERT INTO `g5_board_file` VALUES ('wedding_details',2,0,'wedding_location.jpg','2130706433_FjKJHiVG_04cbd288e451e1ead9381438e5a9bd0c69571503.jpg','0','',61206,900,600,2,'2017-07-22 01:42:18');
INSERT INTO `g5_board_file` VALUES ('wedding_details',1,0,'wedding_location.jpg','2130706433_E0NITJQv_e2acf754af2a8885b5f768ac267183d0ac6f452e.jpg','0','',61206,900,600,2,'2017-07-28 11:42:52');
/*!40000 ALTER TABLE `g5_board_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_board_good`
--

DROP TABLE IF EXISTS `g5_board_good`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_board_good` (
  `bg_id` int(11) NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `bg_flag` varchar(255) NOT NULL DEFAULT '',
  `bg_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`bg_id`),
  UNIQUE KEY `fkey1` (`bo_table`,`wr_id`,`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_board_good`
--

LOCK TABLES `g5_board_good` WRITE;
/*!40000 ALTER TABLE `g5_board_good` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_board_good` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_board_new`
--

DROP TABLE IF EXISTS `g5_board_new`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_board_new` (
  `bn_id` int(11) NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` int(11) NOT NULL DEFAULT '0',
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `bn_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY  (`bn_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_board_new`
--

LOCK TABLES `g5_board_new` WRITE;
/*!40000 ALTER TABLE `g5_board_new` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_board_new` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_cert_history`
--

DROP TABLE IF EXISTS `g5_cert_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_cert_history` (
  `cr_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `cr_company` varchar(255) NOT NULL DEFAULT '',
  `cr_method` varchar(255) NOT NULL DEFAULT '',
  `cr_ip` varchar(255) NOT NULL DEFAULT '',
  `cr_date` date NOT NULL DEFAULT '0000-00-00',
  `cr_time` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY  (`cr_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_cert_history`
--

LOCK TABLES `g5_cert_history` WRITE;
/*!40000 ALTER TABLE `g5_cert_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_cert_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config`
--

DROP TABLE IF EXISTS `g5_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_config` (
  `cf_title` varchar(255) NOT NULL DEFAULT '',
  `cf_theme` varchar(255) NOT NULL DEFAULT '',
  `cf_admin` varchar(255) NOT NULL DEFAULT '',
  `cf_admin_email` varchar(255) NOT NULL DEFAULT '',
  `cf_admin_email_name` varchar(255) NOT NULL DEFAULT '',
  `cf_add_script` text NOT NULL,
  `cf_use_point` tinyint(4) NOT NULL DEFAULT '0',
  `cf_point_term` int(11) NOT NULL DEFAULT '0',
  `cf_use_copy_log` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_email_certify` tinyint(4) NOT NULL DEFAULT '0',
  `cf_login_point` int(11) NOT NULL DEFAULT '0',
  `cf_cut_name` tinyint(4) NOT NULL DEFAULT '0',
  `cf_nick_modify` int(11) NOT NULL DEFAULT '0',
  `cf_new_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_new_rows` int(11) NOT NULL DEFAULT '0',
  `cf_search_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_connect_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_faq_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_read_point` int(11) NOT NULL DEFAULT '0',
  `cf_write_point` int(11) NOT NULL DEFAULT '0',
  `cf_comment_point` int(11) NOT NULL DEFAULT '0',
  `cf_download_point` int(11) NOT NULL DEFAULT '0',
  `cf_write_pages` int(11) NOT NULL DEFAULT '0',
  `cf_mobile_pages` int(11) NOT NULL DEFAULT '0',
  `cf_link_target` varchar(255) NOT NULL DEFAULT '',
  `cf_delay_sec` int(11) NOT NULL DEFAULT '0',
  `cf_filter` text NOT NULL,
  `cf_possible_ip` text NOT NULL,
  `cf_intercept_ip` text NOT NULL,
  `cf_analytics` text NOT NULL,
  `cf_add_meta` text NOT NULL,
  `cf_syndi_token` varchar(255) NOT NULL,
  `cf_syndi_except` text NOT NULL,
  `cf_member_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_use_homepage` tinyint(4) NOT NULL DEFAULT '0',
  `cf_req_homepage` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_tel` tinyint(4) NOT NULL DEFAULT '0',
  `cf_req_tel` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_hp` tinyint(4) NOT NULL DEFAULT '0',
  `cf_req_hp` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_addr` tinyint(4) NOT NULL DEFAULT '0',
  `cf_req_addr` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_signature` tinyint(4) NOT NULL DEFAULT '0',
  `cf_req_signature` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_profile` tinyint(4) NOT NULL DEFAULT '0',
  `cf_req_profile` tinyint(4) NOT NULL DEFAULT '0',
  `cf_register_level` tinyint(4) NOT NULL DEFAULT '0',
  `cf_register_point` int(11) NOT NULL DEFAULT '0',
  `cf_icon_level` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_recommend` tinyint(4) NOT NULL DEFAULT '0',
  `cf_recommend_point` int(11) NOT NULL DEFAULT '0',
  `cf_leave_day` int(11) NOT NULL DEFAULT '0',
  `cf_search_part` int(11) NOT NULL DEFAULT '0',
  `cf_email_use` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_wr_super_admin` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_wr_group_admin` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_wr_board_admin` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_wr_write` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_wr_comment_all` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_mb_super_admin` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_mb_member` tinyint(4) NOT NULL DEFAULT '0',
  `cf_email_po_super_admin` tinyint(4) NOT NULL DEFAULT '0',
  `cf_prohibit_id` text NOT NULL,
  `cf_prohibit_email` text NOT NULL,
  `cf_new_del` int(11) NOT NULL DEFAULT '0',
  `cf_memo_del` int(11) NOT NULL DEFAULT '0',
  `cf_visit_del` int(11) NOT NULL DEFAULT '0',
  `cf_popular_del` int(11) NOT NULL DEFAULT '0',
  `cf_optimize_date` date NOT NULL DEFAULT '0000-00-00',
  `cf_use_member_icon` tinyint(4) NOT NULL DEFAULT '0',
  `cf_member_icon_size` int(11) NOT NULL DEFAULT '0',
  `cf_member_icon_width` int(11) NOT NULL DEFAULT '0',
  `cf_member_icon_height` int(11) NOT NULL DEFAULT '0',
  `cf_member_img_size` int(11) NOT NULL DEFAULT '0',
  `cf_member_img_width` int(11) NOT NULL DEFAULT '0',
  `cf_member_img_height` int(11) NOT NULL DEFAULT '0',
  `cf_login_minutes` int(11) NOT NULL DEFAULT '0',
  `cf_image_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_flash_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_movie_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_formmail_is_member` tinyint(4) NOT NULL DEFAULT '0',
  `cf_page_rows` int(11) NOT NULL DEFAULT '0',
  `cf_mobile_page_rows` int(11) NOT NULL DEFAULT '0',
  `cf_visit` varchar(255) NOT NULL DEFAULT '',
  `cf_max_po_id` int(11) NOT NULL DEFAULT '0',
  `cf_stipulation` text NOT NULL,
  `cf_privacy` text NOT NULL,
  `cf_open_modify` int(11) NOT NULL DEFAULT '0',
  `cf_memo_send_point` int(11) NOT NULL DEFAULT '0',
  `cf_mobile_new_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_search_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_connect_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_faq_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_member_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_captcha_mp3` varchar(255) NOT NULL DEFAULT '',
  `cf_editor` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_use` tinyint(4) NOT NULL DEFAULT '0',
  `cf_cert_ipin` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_hp` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kcb_cd` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kcp_cd` varchar(255) NOT NULL DEFAULT '',
  `cf_lg_mid` varchar(255) NOT NULL DEFAULT '',
  `cf_lg_mert_key` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_limit` int(11) NOT NULL DEFAULT '0',
  `cf_cert_req` tinyint(4) NOT NULL DEFAULT '0',
  `cf_sms_use` varchar(255) NOT NULL DEFAULT '',
  `cf_sms_type` varchar(10) NOT NULL DEFAULT '',
  `cf_icode_id` varchar(255) NOT NULL DEFAULT '',
  `cf_icode_pw` varchar(255) NOT NULL DEFAULT '',
  `cf_icode_server_ip` varchar(255) NOT NULL DEFAULT '',
  `cf_icode_server_port` varchar(255) NOT NULL DEFAULT '',
  `cf_googl_shorturl_apikey` varchar(255) NOT NULL DEFAULT '',
  `cf_social_login_use` tinyint(4) NOT NULL DEFAULT '0',
  `cf_social_servicelist` varchar(255) NOT NULL DEFAULT '',
  `cf_payco_clientid` varchar(100) NOT NULL DEFAULT '',
  `cf_payco_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_facebook_appid` varchar(255) NOT NULL,
  `cf_facebook_secret` varchar(255) NOT NULL,
  `cf_twitter_key` varchar(255) NOT NULL,
  `cf_twitter_secret` varchar(255) NOT NULL,
  `cf_google_clientid` varchar(100) NOT NULL DEFAULT '',
  `cf_google_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_naver_clientid` varchar(100) NOT NULL DEFAULT '',
  `cf_naver_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_kakao_rest_key` varchar(100) NOT NULL DEFAULT '',
  `cf_kakao_client_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_kakao_js_apikey` varchar(255) NOT NULL,
  `cf_captcha` varchar(100) NOT NULL DEFAULT '',
  `cf_recaptcha_site_key` varchar(100) NOT NULL DEFAULT '',
  `cf_recaptcha_secret_key` varchar(100) NOT NULL DEFAULT '',
  `cf_1_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_2_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_3_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_4_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_5_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_6_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_7_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_8_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_9_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_10_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_1` varchar(255) NOT NULL DEFAULT '',
  `cf_2` varchar(255) NOT NULL DEFAULT '',
  `cf_3` varchar(255) NOT NULL DEFAULT '',
  `cf_4` varchar(255) NOT NULL DEFAULT '',
  `cf_5` varchar(255) NOT NULL DEFAULT '',
  `cf_6` varchar(255) NOT NULL DEFAULT '',
  `cf_7` varchar(255) NOT NULL DEFAULT '',
  `cf_8` varchar(255) NOT NULL DEFAULT '',
  `cf_9` varchar(255) NOT NULL DEFAULT '',
  `cf_10` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config`
--

LOCK TABLES `g5_config` WRITE;
/*!40000 ALTER TABLE `g5_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config2`
--

DROP TABLE IF EXISTS `g5_config2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_config2` (
  `id` int(11) NOT NULL auto_increment,
  `cf_id` varchar(30) NOT NULL DEFAULT '',
  `cf_header_logo` text NOT NULL,
  `cf_site_addr` text NOT NULL,
  `cf_copyright` text NOT NULL,
  `cf_keywords` text NOT NULL,
  `cf_description` text NOT NULL,
  `cf_templete` varchar(30) NOT NULL DEFAULT '',
  `cf_max_menu` tinyint(4) NOT NULL DEFAULT '10',
  `cf_max_submenu` tinyint(4) NOT NULL DEFAULT '10',
  `cf_width_main_total` int(11) NOT NULL DEFAULT '960',
  `cf_width_main` int(11) NOT NULL DEFAULT '520',
  `cf_width_main_left` int(11) NOT NULL DEFAULT '220',
  `cf_width_main_right` int(11) NOT NULL DEFAULT '220',
  `cf_hide_left` tinyint(4) NOT NULL DEFAULT '0',
  `cf_hide_right` tinyint(4) NOT NULL DEFAULT '0',
  `cf_max_main` tinyint(4) NOT NULL DEFAULT '30',
  `cf_max_main_left` tinyint(4) NOT NULL DEFAULT '15',
  `cf_max_main_right` tinyint(4) NOT NULL DEFAULT '15',
  `cf_max_head` tinyint(4) NOT NULL DEFAULT '5',
  `cf_max_tail` tinyint(4) NOT NULL DEFAULT '5',
  `cf_menu_name_0` text NOT NULL,
  `cf_menu_name_1` text NOT NULL,
  `cf_menu_name_2` text NOT NULL,
  `cf_menu_name_3` text NOT NULL,
  `cf_menu_name_4` text NOT NULL,
  `cf_menu_name_5` text NOT NULL,
  `cf_menu_name_6` text NOT NULL,
  `cf_menu_name_7` text NOT NULL,
  `cf_menu_name_8` text NOT NULL,
  `cf_menu_name_9` text NOT NULL,
  `cf_menu_leng_0` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_1` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_2` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_3` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_4` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_5` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_6` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_7` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_8` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_9` int(11) NOT NULL DEFAULT '0',
  `cf_menu_link_0` text NOT NULL,
  `cf_menu_link_1` text NOT NULL,
  `cf_menu_link_2` text NOT NULL,
  `cf_menu_link_3` text NOT NULL,
  `cf_menu_link_4` text NOT NULL,
  `cf_menu_link_5` text NOT NULL,
  `cf_menu_link_6` text NOT NULL,
  `cf_menu_link_7` text NOT NULL,
  `cf_menu_link_8` text NOT NULL,
  `cf_menu_link_9` text NOT NULL,
  `cf_submenu_name_0_0` text NOT NULL,
  `cf_submenu_name_0_1` text NOT NULL,
  `cf_submenu_name_0_2` text NOT NULL,
  `cf_submenu_name_0_3` text NOT NULL,
  `cf_submenu_name_0_4` text NOT NULL,
  `cf_submenu_name_0_5` text NOT NULL,
  `cf_submenu_name_0_6` text NOT NULL,
  `cf_submenu_name_0_7` text NOT NULL,
  `cf_submenu_name_0_8` text NOT NULL,
  `cf_submenu_name_0_9` text NOT NULL,
  `cf_submenu_link_0_0` text NOT NULL,
  `cf_submenu_link_0_1` text NOT NULL,
  `cf_submenu_link_0_2` text NOT NULL,
  `cf_submenu_link_0_3` text NOT NULL,
  `cf_submenu_link_0_4` text NOT NULL,
  `cf_submenu_link_0_5` text NOT NULL,
  `cf_submenu_link_0_6` text NOT NULL,
  `cf_submenu_link_0_7` text NOT NULL,
  `cf_submenu_link_0_8` text NOT NULL,
  `cf_submenu_link_0_9` text NOT NULL,
  `cf_submenu_name_1_0` text NOT NULL,
  `cf_submenu_name_1_1` text NOT NULL,
  `cf_submenu_name_1_2` text NOT NULL,
  `cf_submenu_name_1_3` text NOT NULL,
  `cf_submenu_name_1_4` text NOT NULL,
  `cf_submenu_name_1_5` text NOT NULL,
  `cf_submenu_name_1_6` text NOT NULL,
  `cf_submenu_name_1_7` text NOT NULL,
  `cf_submenu_name_1_8` text NOT NULL,
  `cf_submenu_name_1_9` text NOT NULL,
  `cf_submenu_link_1_0` text NOT NULL,
  `cf_submenu_link_1_1` text NOT NULL,
  `cf_submenu_link_1_2` text NOT NULL,
  `cf_submenu_link_1_3` text NOT NULL,
  `cf_submenu_link_1_4` text NOT NULL,
  `cf_submenu_link_1_5` text NOT NULL,
  `cf_submenu_link_1_6` text NOT NULL,
  `cf_submenu_link_1_7` text NOT NULL,
  `cf_submenu_link_1_8` text NOT NULL,
  `cf_submenu_link_1_9` text NOT NULL,
  `cf_submenu_name_2_0` text NOT NULL,
  `cf_submenu_name_2_1` text NOT NULL,
  `cf_submenu_name_2_2` text NOT NULL,
  `cf_submenu_name_2_3` text NOT NULL,
  `cf_submenu_name_2_4` text NOT NULL,
  `cf_submenu_name_2_5` text NOT NULL,
  `cf_submenu_name_2_6` text NOT NULL,
  `cf_submenu_name_2_7` text NOT NULL,
  `cf_submenu_name_2_8` text NOT NULL,
  `cf_submenu_name_2_9` text NOT NULL,
  `cf_submenu_link_2_0` text NOT NULL,
  `cf_submenu_link_2_1` text NOT NULL,
  `cf_submenu_link_2_2` text NOT NULL,
  `cf_submenu_link_2_3` text NOT NULL,
  `cf_submenu_link_2_4` text NOT NULL,
  `cf_submenu_link_2_5` text NOT NULL,
  `cf_submenu_link_2_6` text NOT NULL,
  `cf_submenu_link_2_7` text NOT NULL,
  `cf_submenu_link_2_8` text NOT NULL,
  `cf_submenu_link_2_9` text NOT NULL,
  `cf_submenu_name_3_0` text NOT NULL,
  `cf_submenu_name_3_1` text NOT NULL,
  `cf_submenu_name_3_2` text NOT NULL,
  `cf_submenu_name_3_3` text NOT NULL,
  `cf_submenu_name_3_4` text NOT NULL,
  `cf_submenu_name_3_5` text NOT NULL,
  `cf_submenu_name_3_6` text NOT NULL,
  `cf_submenu_name_3_7` text NOT NULL,
  `cf_submenu_name_3_8` text NOT NULL,
  `cf_submenu_name_3_9` text NOT NULL,
  `cf_submenu_link_3_0` text NOT NULL,
  `cf_submenu_link_3_1` text NOT NULL,
  `cf_submenu_link_3_2` text NOT NULL,
  `cf_submenu_link_3_3` text NOT NULL,
  `cf_submenu_link_3_4` text NOT NULL,
  `cf_submenu_link_3_5` text NOT NULL,
  `cf_submenu_link_3_6` text NOT NULL,
  `cf_submenu_link_3_7` text NOT NULL,
  `cf_submenu_link_3_8` text NOT NULL,
  `cf_submenu_link_3_9` text NOT NULL,
  `cf_submenu_name_4_0` text NOT NULL,
  `cf_submenu_name_4_1` text NOT NULL,
  `cf_submenu_name_4_2` text NOT NULL,
  `cf_submenu_name_4_3` text NOT NULL,
  `cf_submenu_name_4_4` text NOT NULL,
  `cf_submenu_name_4_5` text NOT NULL,
  `cf_submenu_name_4_6` text NOT NULL,
  `cf_submenu_name_4_7` text NOT NULL,
  `cf_submenu_name_4_8` text NOT NULL,
  `cf_submenu_name_4_9` text NOT NULL,
  `cf_submenu_link_4_0` text NOT NULL,
  `cf_submenu_link_4_1` text NOT NULL,
  `cf_submenu_link_4_2` text NOT NULL,
  `cf_submenu_link_4_3` text NOT NULL,
  `cf_submenu_link_4_4` text NOT NULL,
  `cf_submenu_link_4_5` text NOT NULL,
  `cf_submenu_link_4_6` text NOT NULL,
  `cf_submenu_link_4_7` text NOT NULL,
  `cf_submenu_link_4_8` text NOT NULL,
  `cf_submenu_link_4_9` text NOT NULL,
  `cf_submenu_name_5_0` text NOT NULL,
  `cf_submenu_name_5_1` text NOT NULL,
  `cf_submenu_name_5_2` text NOT NULL,
  `cf_submenu_name_5_3` text NOT NULL,
  `cf_submenu_name_5_4` text NOT NULL,
  `cf_submenu_name_5_5` text NOT NULL,
  `cf_submenu_name_5_6` text NOT NULL,
  `cf_submenu_name_5_7` text NOT NULL,
  `cf_submenu_name_5_8` text NOT NULL,
  `cf_submenu_name_5_9` text NOT NULL,
  `cf_submenu_link_5_0` text NOT NULL,
  `cf_submenu_link_5_1` text NOT NULL,
  `cf_submenu_link_5_2` text NOT NULL,
  `cf_submenu_link_5_3` text NOT NULL,
  `cf_submenu_link_5_4` text NOT NULL,
  `cf_submenu_link_5_5` text NOT NULL,
  `cf_submenu_link_5_6` text NOT NULL,
  `cf_submenu_link_5_7` text NOT NULL,
  `cf_submenu_link_5_8` text NOT NULL,
  `cf_submenu_link_5_9` text NOT NULL,
  `cf_submenu_name_6_0` text NOT NULL,
  `cf_submenu_name_6_1` text NOT NULL,
  `cf_submenu_name_6_2` text NOT NULL,
  `cf_submenu_name_6_3` text NOT NULL,
  `cf_submenu_name_6_4` text NOT NULL,
  `cf_submenu_name_6_5` text NOT NULL,
  `cf_submenu_name_6_6` text NOT NULL,
  `cf_submenu_name_6_7` text NOT NULL,
  `cf_submenu_name_6_8` text NOT NULL,
  `cf_submenu_name_6_9` text NOT NULL,
  `cf_submenu_link_6_0` text NOT NULL,
  `cf_submenu_link_6_1` text NOT NULL,
  `cf_submenu_link_6_2` text NOT NULL,
  `cf_submenu_link_6_3` text NOT NULL,
  `cf_submenu_link_6_4` text NOT NULL,
  `cf_submenu_link_6_5` text NOT NULL,
  `cf_submenu_link_6_6` text NOT NULL,
  `cf_submenu_link_6_7` text NOT NULL,
  `cf_submenu_link_6_8` text NOT NULL,
  `cf_submenu_link_6_9` text NOT NULL,
  `cf_submenu_name_7_0` text NOT NULL,
  `cf_submenu_name_7_1` text NOT NULL,
  `cf_submenu_name_7_2` text NOT NULL,
  `cf_submenu_name_7_3` text NOT NULL,
  `cf_submenu_name_7_4` text NOT NULL,
  `cf_submenu_name_7_5` text NOT NULL,
  `cf_submenu_name_7_6` text NOT NULL,
  `cf_submenu_name_7_7` text NOT NULL,
  `cf_submenu_name_7_8` text NOT NULL,
  `cf_submenu_name_7_9` text NOT NULL,
  `cf_submenu_link_7_0` text NOT NULL,
  `cf_submenu_link_7_1` text NOT NULL,
  `cf_submenu_link_7_2` text NOT NULL,
  `cf_submenu_link_7_3` text NOT NULL,
  `cf_submenu_link_7_4` text NOT NULL,
  `cf_submenu_link_7_5` text NOT NULL,
  `cf_submenu_link_7_6` text NOT NULL,
  `cf_submenu_link_7_7` text NOT NULL,
  `cf_submenu_link_7_8` text NOT NULL,
  `cf_submenu_link_7_9` text NOT NULL,
  `cf_submenu_name_8_0` text NOT NULL,
  `cf_submenu_name_8_1` text NOT NULL,
  `cf_submenu_name_8_2` text NOT NULL,
  `cf_submenu_name_8_3` text NOT NULL,
  `cf_submenu_name_8_4` text NOT NULL,
  `cf_submenu_name_8_5` text NOT NULL,
  `cf_submenu_name_8_6` text NOT NULL,
  `cf_submenu_name_8_7` text NOT NULL,
  `cf_submenu_name_8_8` text NOT NULL,
  `cf_submenu_name_8_9` text NOT NULL,
  `cf_submenu_link_8_0` text NOT NULL,
  `cf_submenu_link_8_1` text NOT NULL,
  `cf_submenu_link_8_2` text NOT NULL,
  `cf_submenu_link_8_3` text NOT NULL,
  `cf_submenu_link_8_4` text NOT NULL,
  `cf_submenu_link_8_5` text NOT NULL,
  `cf_submenu_link_8_6` text NOT NULL,
  `cf_submenu_link_8_7` text NOT NULL,
  `cf_submenu_link_8_8` text NOT NULL,
  `cf_submenu_link_8_9` text NOT NULL,
  `cf_submenu_name_9_0` text NOT NULL,
  `cf_submenu_name_9_1` text NOT NULL,
  `cf_submenu_name_9_2` text NOT NULL,
  `cf_submenu_name_9_3` text NOT NULL,
  `cf_submenu_name_9_4` text NOT NULL,
  `cf_submenu_name_9_5` text NOT NULL,
  `cf_submenu_name_9_6` text NOT NULL,
  `cf_submenu_name_9_7` text NOT NULL,
  `cf_submenu_name_9_8` text NOT NULL,
  `cf_submenu_name_9_9` text NOT NULL,
  `cf_submenu_link_9_0` text NOT NULL,
  `cf_submenu_link_9_1` text NOT NULL,
  `cf_submenu_link_9_2` text NOT NULL,
  `cf_submenu_link_9_3` text NOT NULL,
  `cf_submenu_link_9_4` text NOT NULL,
  `cf_submenu_link_9_5` text NOT NULL,
  `cf_submenu_link_9_6` text NOT NULL,
  `cf_submenu_link_9_7` text NOT NULL,
  `cf_submenu_link_9_8` text NOT NULL,
  `cf_submenu_link_9_9` text NOT NULL,
  `cf_main_nouse_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_5` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_6` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_7` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_8` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_9` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_10` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_11` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_12` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_13` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_14` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_15` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_16` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_17` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_18` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_19` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_20` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_21` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_22` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_23` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_24` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_25` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_26` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_27` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_28` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_29` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_30` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_31` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_32` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_33` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_34` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_35` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_36` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_37` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_38` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_39` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_name_0` text NOT NULL,
  `cf_main_name_1` text NOT NULL,
  `cf_main_name_2` text NOT NULL,
  `cf_main_name_3` text NOT NULL,
  `cf_main_name_4` text NOT NULL,
  `cf_main_name_5` text NOT NULL,
  `cf_main_name_6` text NOT NULL,
  `cf_main_name_7` text NOT NULL,
  `cf_main_name_8` text NOT NULL,
  `cf_main_name_9` text NOT NULL,
  `cf_main_name_10` text NOT NULL,
  `cf_main_name_11` text NOT NULL,
  `cf_main_name_12` text NOT NULL,
  `cf_main_name_13` text NOT NULL,
  `cf_main_name_14` text NOT NULL,
  `cf_main_name_15` text NOT NULL,
  `cf_main_name_16` text NOT NULL,
  `cf_main_name_17` text NOT NULL,
  `cf_main_name_18` text NOT NULL,
  `cf_main_name_19` text NOT NULL,
  `cf_main_name_20` text NOT NULL,
  `cf_main_name_21` text NOT NULL,
  `cf_main_name_22` text NOT NULL,
  `cf_main_name_23` text NOT NULL,
  `cf_main_name_24` text NOT NULL,
  `cf_main_name_25` text NOT NULL,
  `cf_main_name_26` text NOT NULL,
  `cf_main_name_27` text NOT NULL,
  `cf_main_name_28` text NOT NULL,
  `cf_main_name_29` text NOT NULL,
  `cf_main_name_30` text NOT NULL,
  `cf_main_name_31` text NOT NULL,
  `cf_main_name_32` text NOT NULL,
  `cf_main_name_33` text NOT NULL,
  `cf_main_name_34` text NOT NULL,
  `cf_main_name_35` text NOT NULL,
  `cf_main_name_36` text NOT NULL,
  `cf_main_name_37` text NOT NULL,
  `cf_main_name_38` text NOT NULL,
  `cf_main_name_39` text NOT NULL,
  `cf_main_style_0` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_1` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_2` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_3` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_4` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_5` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_6` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_7` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_8` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_9` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_10` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_11` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_12` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_13` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_14` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_15` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_16` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_17` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_18` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_19` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_20` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_21` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_22` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_23` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_24` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_25` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_26` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_27` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_28` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_29` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_30` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_31` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_32` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_33` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_34` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_35` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_36` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_37` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_38` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_39` varchar(30) NOT NULL DEFAULT '',
  `cf_main_long_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_5` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_6` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_7` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_8` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_9` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_10` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_11` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_12` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_13` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_14` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_15` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_16` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_17` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_18` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_19` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_20` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_21` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_22` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_23` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_24` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_25` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_26` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_27` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_28` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_29` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_30` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_31` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_32` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_33` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_34` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_35` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_36` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_37` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_38` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_39` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_5` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_6` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_7` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_8` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_9` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_10` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_11` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_12` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_13` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_14` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_15` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_16` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_17` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_18` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_19` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_name_0` text NOT NULL,
  `cf_main_left_name_1` text NOT NULL,
  `cf_main_left_name_2` text NOT NULL,
  `cf_main_left_name_3` text NOT NULL,
  `cf_main_left_name_4` text NOT NULL,
  `cf_main_left_name_5` text NOT NULL,
  `cf_main_left_name_6` text NOT NULL,
  `cf_main_left_name_7` text NOT NULL,
  `cf_main_left_name_8` text NOT NULL,
  `cf_main_left_name_9` text NOT NULL,
  `cf_main_left_name_10` text NOT NULL,
  `cf_main_left_name_11` text NOT NULL,
  `cf_main_left_name_12` text NOT NULL,
  `cf_main_left_name_13` text NOT NULL,
  `cf_main_left_name_14` text NOT NULL,
  `cf_main_left_name_15` text NOT NULL,
  `cf_main_left_name_16` text NOT NULL,
  `cf_main_left_name_17` text NOT NULL,
  `cf_main_left_name_18` text NOT NULL,
  `cf_main_left_name_19` text NOT NULL,
  `cf_main_left_style_0` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_1` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_2` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_3` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_4` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_5` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_6` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_7` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_8` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_9` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_10` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_11` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_12` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_13` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_14` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_15` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_16` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_17` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_18` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_19` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_admin_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_5` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_6` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_7` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_8` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_9` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_10` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_11` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_12` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_13` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_14` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_15` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_16` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_17` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_18` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_19` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_5` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_6` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_7` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_8` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_9` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_10` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_11` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_12` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_13` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_14` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_15` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_16` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_17` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_18` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_19` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_name_0` text NOT NULL,
  `cf_main_right_name_1` text NOT NULL,
  `cf_main_right_name_2` text NOT NULL,
  `cf_main_right_name_3` text NOT NULL,
  `cf_main_right_name_4` text NOT NULL,
  `cf_main_right_name_5` text NOT NULL,
  `cf_main_right_name_6` text NOT NULL,
  `cf_main_right_name_7` text NOT NULL,
  `cf_main_right_name_8` text NOT NULL,
  `cf_main_right_name_9` text NOT NULL,
  `cf_main_right_name_10` text NOT NULL,
  `cf_main_right_name_11` text NOT NULL,
  `cf_main_right_name_12` text NOT NULL,
  `cf_main_right_name_13` text NOT NULL,
  `cf_main_right_name_14` text NOT NULL,
  `cf_main_right_name_15` text NOT NULL,
  `cf_main_right_name_16` text NOT NULL,
  `cf_main_right_name_17` text NOT NULL,
  `cf_main_right_name_18` text NOT NULL,
  `cf_main_right_name_19` text NOT NULL,
  `cf_main_right_style_0` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_1` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_2` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_3` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_4` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_5` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_6` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_7` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_8` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_9` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_10` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_11` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_12` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_13` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_14` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_15` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_16` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_17` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_18` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_19` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_admin_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_5` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_6` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_7` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_8` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_9` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_10` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_11` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_12` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_13` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_14` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_15` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_16` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_17` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_18` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_19` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_nouse_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_nouse_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_nouse_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_nouse_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_nouse_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_name_0` text NOT NULL,
  `cf_head_name_1` text NOT NULL,
  `cf_head_name_2` text NOT NULL,
  `cf_head_name_3` text NOT NULL,
  `cf_head_name_4` text NOT NULL,
  `cf_head_style_0` varchar(30) NOT NULL DEFAULT '',
  `cf_head_style_1` varchar(30) NOT NULL DEFAULT '',
  `cf_head_style_2` varchar(30) NOT NULL DEFAULT '',
  `cf_head_style_3` varchar(30) NOT NULL DEFAULT '',
  `cf_head_style_4` varchar(30) NOT NULL DEFAULT '',
  `cf_head_long_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_long_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_long_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_long_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_long_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_nouse_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_nouse_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_nouse_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_nouse_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_nouse_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_name_0` text NOT NULL,
  `cf_tail_name_1` text NOT NULL,
  `cf_tail_name_2` text NOT NULL,
  `cf_tail_name_3` text NOT NULL,
  `cf_tail_name_4` text NOT NULL,
  `cf_tail_style_0` varchar(30) NOT NULL DEFAULT '',
  `cf_tail_style_1` varchar(30) NOT NULL DEFAULT '',
  `cf_tail_style_2` varchar(30) NOT NULL DEFAULT '',
  `cf_tail_style_3` varchar(30) NOT NULL DEFAULT '',
  `cf_tail_style_4` varchar(30) NOT NULL DEFAULT '',
  `cf_tail_long_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_long_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_long_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_long_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_long_4` enum('','checked') NOT NULL DEFAULT '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cf_id` (`cf_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config2`
--

LOCK TABLES `g5_config2` WRITE;
/*!40000 ALTER TABLE `g5_config2` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_config2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config2m`
--

DROP TABLE IF EXISTS `g5_config2m`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_config2m` (
  `id` int(11) NOT NULL auto_increment,
  `cf_id` varchar(30) NOT NULL DEFAULT '',
  `cf_templete` varchar(30) NOT NULL DEFAULT 'basic',
  `cf_search` varchar(30) NOT NULL DEFAULT 'nouse',
  `cf_menu` varchar(30) NOT NULL DEFAULT 'list',
  `cf_main_image` varchar(30) NOT NULL DEFAULT 'nouse',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cf_id` (`cf_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config2m`
--

LOCK TABLES `g5_config2m` WRITE;
/*!40000 ALTER TABLE `g5_config2m` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_config2m` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config2w`
--

DROP TABLE IF EXISTS `g5_config2w`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_config2w` (
  `cf_id` varchar(255) NOT NULL DEFAULT '',
  `cf_menu` varchar(255) NOT NULL DEFAULT 'basic',
  `cf_max_menu` tinyint(4) NOT NULL DEFAULT '10',
  `cf_max_submenu` tinyint(4) NOT NULL DEFAULT '10',
  `cf_width_main_total` int(11) NOT NULL DEFAULT '960',
  `cf_width_main` int(11) NOT NULL DEFAULT '520',
  `cf_width_main_left` int(11) NOT NULL DEFAULT '220',
  `cf_width_main_right` int(11) NOT NULL DEFAULT '220',
  `cf_hide_left` tinyint(4) NOT NULL DEFAULT '0',
  `cf_hide_right` tinyint(4) NOT NULL DEFAULT '0',
  `cf_max_main` tinyint(4) NOT NULL DEFAULT '30',
  `cf_max_main_left` tinyint(4) NOT NULL DEFAULT '15',
  `cf_max_main_right` tinyint(4) NOT NULL DEFAULT '15',
  `cf_max_head` tinyint(4) NOT NULL DEFAULT '5',
  `cf_max_tail` tinyint(4) NOT NULL DEFAULT '5',
  `cf_main_nouse_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_5` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_6` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_7` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_8` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_9` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_10` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_11` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_12` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_13` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_14` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_15` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_16` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_17` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_18` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_19` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_20` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_21` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_22` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_23` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_24` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_25` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_26` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_27` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_28` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_29` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_30` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_31` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_32` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_33` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_34` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_35` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_36` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_37` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_38` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_nouse_39` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_name_0` text NOT NULL,
  `cf_main_name_1` text NOT NULL,
  `cf_main_name_2` text NOT NULL,
  `cf_main_name_3` text NOT NULL,
  `cf_main_name_4` text NOT NULL,
  `cf_main_name_5` text NOT NULL,
  `cf_main_name_6` text NOT NULL,
  `cf_main_name_7` text NOT NULL,
  `cf_main_name_8` text NOT NULL,
  `cf_main_name_9` text NOT NULL,
  `cf_main_name_10` text NOT NULL,
  `cf_main_name_11` text NOT NULL,
  `cf_main_name_12` text NOT NULL,
  `cf_main_name_13` text NOT NULL,
  `cf_main_name_14` text NOT NULL,
  `cf_main_name_15` text NOT NULL,
  `cf_main_name_16` text NOT NULL,
  `cf_main_name_17` text NOT NULL,
  `cf_main_name_18` text NOT NULL,
  `cf_main_name_19` text NOT NULL,
  `cf_main_name_20` text NOT NULL,
  `cf_main_name_21` text NOT NULL,
  `cf_main_name_22` text NOT NULL,
  `cf_main_name_23` text NOT NULL,
  `cf_main_name_24` text NOT NULL,
  `cf_main_name_25` text NOT NULL,
  `cf_main_name_26` text NOT NULL,
  `cf_main_name_27` text NOT NULL,
  `cf_main_name_28` text NOT NULL,
  `cf_main_name_29` text NOT NULL,
  `cf_main_name_30` text NOT NULL,
  `cf_main_name_31` text NOT NULL,
  `cf_main_name_32` text NOT NULL,
  `cf_main_name_33` text NOT NULL,
  `cf_main_name_34` text NOT NULL,
  `cf_main_name_35` text NOT NULL,
  `cf_main_name_36` text NOT NULL,
  `cf_main_name_37` text NOT NULL,
  `cf_main_name_38` text NOT NULL,
  `cf_main_name_39` text NOT NULL,
  `cf_main_style_0` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_1` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_2` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_3` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_4` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_5` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_6` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_7` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_8` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_9` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_10` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_11` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_12` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_13` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_14` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_15` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_16` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_17` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_18` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_19` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_20` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_21` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_22` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_23` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_24` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_25` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_26` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_27` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_28` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_29` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_30` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_31` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_32` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_33` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_34` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_35` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_36` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_37` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_38` varchar(30) NOT NULL DEFAULT '',
  `cf_main_style_39` varchar(30) NOT NULL DEFAULT '',
  `cf_main_long_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_5` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_6` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_7` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_8` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_9` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_10` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_11` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_12` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_13` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_14` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_15` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_16` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_17` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_18` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_19` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_20` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_21` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_22` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_23` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_24` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_25` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_26` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_27` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_28` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_29` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_30` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_31` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_32` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_33` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_34` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_35` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_36` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_37` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_38` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_long_39` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_5` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_6` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_7` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_8` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_9` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_10` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_11` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_12` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_13` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_14` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_15` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_16` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_17` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_18` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_nouse_19` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_name_0` text NOT NULL,
  `cf_main_left_name_1` text NOT NULL,
  `cf_main_left_name_2` text NOT NULL,
  `cf_main_left_name_3` text NOT NULL,
  `cf_main_left_name_4` text NOT NULL,
  `cf_main_left_name_5` text NOT NULL,
  `cf_main_left_name_6` text NOT NULL,
  `cf_main_left_name_7` text NOT NULL,
  `cf_main_left_name_8` text NOT NULL,
  `cf_main_left_name_9` text NOT NULL,
  `cf_main_left_name_10` text NOT NULL,
  `cf_main_left_name_11` text NOT NULL,
  `cf_main_left_name_12` text NOT NULL,
  `cf_main_left_name_13` text NOT NULL,
  `cf_main_left_name_14` text NOT NULL,
  `cf_main_left_name_15` text NOT NULL,
  `cf_main_left_name_16` text NOT NULL,
  `cf_main_left_name_17` text NOT NULL,
  `cf_main_left_name_18` text NOT NULL,
  `cf_main_left_name_19` text NOT NULL,
  `cf_main_left_style_0` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_1` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_2` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_3` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_4` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_5` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_6` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_7` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_8` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_9` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_10` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_11` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_12` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_13` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_14` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_15` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_16` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_17` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_18` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_style_19` varchar(30) NOT NULL DEFAULT '',
  `cf_main_left_admin_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_5` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_6` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_7` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_8` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_9` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_10` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_11` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_12` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_13` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_14` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_15` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_16` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_17` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_18` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_left_admin_19` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_5` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_6` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_7` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_8` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_9` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_10` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_11` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_12` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_13` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_14` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_15` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_16` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_17` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_18` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_nouse_19` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_name_0` text NOT NULL,
  `cf_main_right_name_1` text NOT NULL,
  `cf_main_right_name_2` text NOT NULL,
  `cf_main_right_name_3` text NOT NULL,
  `cf_main_right_name_4` text NOT NULL,
  `cf_main_right_name_5` text NOT NULL,
  `cf_main_right_name_6` text NOT NULL,
  `cf_main_right_name_7` text NOT NULL,
  `cf_main_right_name_8` text NOT NULL,
  `cf_main_right_name_9` text NOT NULL,
  `cf_main_right_name_10` text NOT NULL,
  `cf_main_right_name_11` text NOT NULL,
  `cf_main_right_name_12` text NOT NULL,
  `cf_main_right_name_13` text NOT NULL,
  `cf_main_right_name_14` text NOT NULL,
  `cf_main_right_name_15` text NOT NULL,
  `cf_main_right_name_16` text NOT NULL,
  `cf_main_right_name_17` text NOT NULL,
  `cf_main_right_name_18` text NOT NULL,
  `cf_main_right_name_19` text NOT NULL,
  `cf_main_right_style_0` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_1` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_2` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_3` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_4` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_5` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_6` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_7` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_8` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_9` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_10` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_11` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_12` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_13` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_14` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_15` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_16` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_17` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_18` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_style_19` varchar(30) NOT NULL DEFAULT '',
  `cf_main_right_admin_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_5` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_6` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_7` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_8` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_9` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_10` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_11` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_12` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_13` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_14` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_15` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_16` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_17` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_18` enum('','checked') NOT NULL DEFAULT '',
  `cf_main_right_admin_19` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_nouse_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_nouse_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_nouse_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_nouse_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_nouse_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_name_0` text NOT NULL,
  `cf_head_name_1` text NOT NULL,
  `cf_head_name_2` text NOT NULL,
  `cf_head_name_3` text NOT NULL,
  `cf_head_name_4` text NOT NULL,
  `cf_head_style_0` varchar(30) NOT NULL DEFAULT '',
  `cf_head_style_1` varchar(30) NOT NULL DEFAULT '',
  `cf_head_style_2` varchar(30) NOT NULL DEFAULT '',
  `cf_head_style_3` varchar(30) NOT NULL DEFAULT '',
  `cf_head_style_4` varchar(30) NOT NULL DEFAULT '',
  `cf_head_long_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_long_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_long_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_long_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_head_long_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_nouse_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_nouse_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_nouse_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_nouse_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_nouse_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_name_0` text NOT NULL,
  `cf_tail_name_1` text NOT NULL,
  `cf_tail_name_2` text NOT NULL,
  `cf_tail_name_3` text NOT NULL,
  `cf_tail_name_4` text NOT NULL,
  `cf_tail_style_0` varchar(30) NOT NULL DEFAULT '',
  `cf_tail_style_1` varchar(30) NOT NULL DEFAULT '',
  `cf_tail_style_2` varchar(30) NOT NULL DEFAULT '',
  `cf_tail_style_3` varchar(30) NOT NULL DEFAULT '',
  `cf_tail_style_4` varchar(30) NOT NULL DEFAULT '',
  `cf_tail_long_0` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_long_1` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_long_2` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_long_3` enum('','checked') NOT NULL DEFAULT '',
  `cf_tail_long_4` enum('','checked') NOT NULL DEFAULT '',
  `cf_use_common_logo` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_common_menu` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_common_addr` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`cf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config2w`
--

LOCK TABLES `g5_config2w` WRITE;
/*!40000 ALTER TABLE `g5_config2w` DISABLE KEYS */;
INSERT INTO `g5_config2w` VALUES ('g4_basic','basic',10,10,960,520,220,220,0,1,30,15,15,5,5,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"g4_good_webzine_main\", \"gallery_main_ad\", 1, 48)','latest(\"g4_good_basic\", \"notice\", 4, 32)','latest(\"g4_good_basic\", \"free\", 4, 32)','latest(\"g4_good_webzine\", \"gallery1\", 2, 48)','latest(\"g4_good_webzine\", \"gallery2\", 2, 48)','latest(\"g4_good_gallery\", \"gallery1\", 3, 48, 1, \"158|94\")','latest(\"g4_good_gallery\", \"gallery2\", 3, 48, 1, \"158|94\")','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"g4_good_basic\")','sidemenu(\"g4_good_basic\")','outlogin(\"g4_good_basic\")','popular(\"g4_good_basic\")','poll(\"g4_good_basic\")','visit(\"g4_good_basic\")','connect(\"g4_good_basic\")','outnew(\"g4_good_basic\")','latest(\"g4_good_webzine_guide\", \"callcenter\", 1)','','','','','','','','','','','','searchBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','','','','','','','','','','','','','','','','','checked','checked','checked','','','','','','','','','','','','','checked','','','','','','','','','','','','','','','','','','','','latest(\"g4_good_basic_popup\", \"notice\")','latest(\"g4_good_webzine_ad\", \"gallery_ad\", 10, 0)','latest(\"g4_good_basic\", \"qna\", 5, 30)','latest(\"g4_good_basic\", \"request\", 5, 30)','latest(\"g4_good_basic\", \"builder\", 5, 30)','latest_group(\"g4_good_group_basic2\", \"board\", 10, 0)','','','','','','','','','','','','','','','','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','','','','','','','','','','','','','','','','checked','','','','','latest(\"g4_good_webzine_full\", \"gallery0\", 1, 48)','','','','','','','','','','checked','','','','','checked','','','','','latest(\"g4_good_webzine_full\", \"gallery0\", 1, 48)','','','','','','','','','','checked','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('g4_basic_biz_easy','basic',10,10,960,520,220,220,0,1,30,15,15,5,5,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_main\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_webzine\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_gallery\", \"gallery1\", 6, 48)','latest(\"good_gallery\", \"gallery2\", 6, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','poll(\"good_basic\")','visit(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','latest(\"good_webzine_guide\", \"callcenter\", 1)','','','','','','','','','','','','searchBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','','','','','','','','','','','','','','','','','checked','checked','checked','','','','','','','','','','','','','checked','','','','','','','','','','','','','','','','','','','','latest(\"good_basic_popup\", \"notice\")','latest(\"good_webzine_ad\", \"gallery_ad\", 10, 0)','latest(\"good_basic\", \"qna\", 5, 30)','latest(\"good_basic\", \"request\", 5, 30)','latest(\"good_basic\", \"builder\", 5, 30)','latest_group(\"good_group_basic2\", \"board\", 10, 0)','','','','','','','','','','','','','','','','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','','','','','','','','','','','','','','','','checked','','','','','latest(\"good_webzine_full\", \"gallery0\", 1, 48)','','','','','','','','','','checked','','','','','checked','','','','','latest(\"good_webzine_full\", \"gallery0\", 1, 48)','','','','','','','','','','checked','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('basic_biz_easy','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('basic','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 5, 48, 1, \"141|94\")','latest(\"good_webzine\", \"gallery2\", 3, 48, 1, \"120|80\")','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_webzine_row\", \"gallery1\", 3, 48)','latest(\"good_webzine_row\", \"gallery2\", 3, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('shop_basic','shop_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('shop_c_basic_biz_easy','shop_c_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('shop_c_basic','shop_c_basic',10,10,1000,840,160,0,0,0,30,15,15,5,5,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 5, 48, 1, \"143|95\")','latest(\"good_webzine\", \"gallery2\", 3, 48, 1, \"122|81\")','latest(\"good_webzine_row\", \"gallery1\", 3, 48)','latest(\"good_webzine_row\", \"gallery2\", 3, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_ad\", \"gallery_ad\", 3, 0)','latest(\"good_basic_aside\", \"qna\", 5, 30)','latest(\"good_basic_aside\", \"request\", 5, 30)','latest(\"good_basic_aside\", \"builder\", 5, 30)','','','','','','','','','','','','','','','','','sideBoxN','sideBoxN','sideBoxN','sideBoxN','','','','','','','','','','','','','','','','','','','','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_search_all\")','sidemenu(\"good_shop_basic\")','outlogin(\"good_shop_basic\")','popular(\"good_shop_basic\")','poll(\"good_shop_basic\")','visit(\"good_shop_basic\")','connect(\"good_shop_basic\")','','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('basic_banner','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_main_gal\", \"gallery_main_ad\", 5, 0, 1, \"728|276\")','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 5, 48, 1, \"141|94\")','latest(\"good_webzine\", \"gallery2\", 3, 48, 1, \"120|80\")','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_webzine_row\", \"gallery1\", 3, 48)','latest(\"good_webzine_row\", \"gallery2\", 3, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('shop_basic_banner','shop_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('g4_basic_banner','basic',10,10,960,520,220,220,0,1,30,15,15,5,5,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"g4_good_main_gal\", \"gallery_main_ad\", 5, 0, 1, \"514|195|36\")','latest(\"g4_good_basic\", \"notice\", 4, 32)','latest(\"g4_good_basic\", \"free\", 4, 32)','latest(\"g4_good_webzine\", \"gallery1\", 2, 48)','latest(\"g4_good_webzine\", \"gallery2\", 2, 48)','latest(\"g4_good_gallery\", \"gallery1\", 3, 48, 1, \"158|94\")','latest(\"g4_good_gallery\", \"gallery2\", 3, 48, 1, \"158|94\")','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"g4_good_basic\")','sidemenu(\"g4_good_basic\")','outlogin(\"g4_good_basic\")','popular(\"g4_good_basic\")','poll(\"g4_good_basic\")','visit(\"g4_good_basic\")','connect(\"g4_good_basic\")','outnew(\"g4_good_basic\")','latest(\"g4_good_webzine_guide\", \"callcenter\", 1)','','','','','','','','','','','','searchBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','sideBoxN','','','','','','','','','','','','','','','','','checked','checked','checked','','','','','','','','','','','','','checked','','','','','','','','','','','','','','','','','','','','latest(\"g4_good_basic_popup\", \"notice\")','latest(\"g4_good_webzine_ad\", \"gallery_ad\", 10, 0)','latest(\"g4_good_basic\", \"qna\", 5, 30)','latest(\"g4_good_basic\", \"request\", 5, 30)','latest(\"g4_good_basic\", \"builder\", 5, 30)','latest_group(\"g4_good_group_basic2\", \"board\", 10, 0)','','','','','','','','','','','','','','','','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','','','','','','','','','','','','','','','','checked','','','','','latest(\"g4_good_webzine_full\", \"gallery0\", 1, 48)','','','','','','','','','','checked','','','','','checked','','','','','latest(\"g4_good_webzine_full\", \"gallery0\", 1, 48)','','','','','','','','','','checked','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('shop_c_basic_banner','shop_c_basic',10,10,1000,840,160,0,0,0,30,15,15,5,5,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_main_gal\", \"gallery_main_ad\", 5, 0, 1, \"740|281\")','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 5, 48, 1, \"143|95\")','latest(\"good_webzine\", \"gallery2\", 3, 48, 1, \"122|81\")','latest(\"good_webzine_row\", \"gallery1\", 3, 48)','latest(\"good_webzine_row\", \"gallery2\", 3, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_ad\", \"gallery_ad\", 3, 0)','latest(\"good_basic_aside\", \"qna\", 5, 30)','latest(\"good_basic_aside\", \"request\", 5, 30)','latest(\"good_basic_aside\", \"builder\", 5, 30)','','','','','','','','','','','','','','','','','sideBoxN','sideBoxN','sideBoxN','sideBoxN','','','','','','','','','','','','','','','','','','','','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_search_all\")','sidemenu(\"good_shop_basic\")','outlogin(\"good_shop_basic\")','popular(\"good_shop_basic\")','poll(\"good_shop_basic\")','visit(\"good_shop_basic\")','connect(\"good_shop_basic\")','','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('basic_video','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_main_video\", \"gallery_main_ad\", 1, 0, 1, \"728|360\")','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 5, 48, 1, \"141|94\")','latest(\"good_webzine\", \"gallery2\", 3, 48, 1, \"120|80\")','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_webzine_row\", \"gallery1\", 3, 48)','latest(\"good_webzine_row\", \"gallery2\", 3, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('basic_slide','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_main_slide\", \"gallery_main_ad\", 5, 0, 1, \"728|276\")','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 5, 48, 1, \"141|94\")','latest(\"good_webzine\", \"gallery2\", 3, 48, 1, \"120|80\")','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_boot_basic','r_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"r_good_slide_carousel\", \"gallery_main_ad\", 5, 0, 1,  \"600|227\")','latest(\"r_good_boot_basic_popup\", \"notice\", 4, 32)','latest(\"r_good_boot_basic\", \"free\", 4, 32)','latest(\"r_good_boot_basic\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic\", \"blog\", 4, 32)','latest(\"r_good_boot_basic\", \"qna\", 4, 32)','latest(\"r_good_boot_basic\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','checked','checked','checked','checked','','','','','','','','','','','','','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','outsearch(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','sideBox2N','sideBox2N','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_boot_basic_col2','r_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"r_good_slide_carousel\", \"gallery_main_ad\", 5, 0, 1,  \"600|227\")','latest(\"r_good_boot_basic_popup_col2\", \"notice\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"free\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"blog\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"qna\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','checked','checked','checked','checked','','','','','','','','','','','','','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','outsearch(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','sideBox2N','sideBox2N','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_boot_basic_green','r_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"r_good_slide_carousel\", \"gallery_main_ad\", 5, 0, 1,  \"600|227\")','latest(\"r_good_boot_basic_popup\", \"notice\", 4, 32)','latest(\"r_good_boot_basic\", \"free\", 4, 32)','latest(\"r_good_boot_basic\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic\", \"blog\", 4, 32)','latest(\"r_good_boot_basic\", \"qna\", 4, 32)','latest(\"r_good_boot_basic\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','checked','checked','checked','checked','','','','','','','','','','','','','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','outsearch(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','sideBox2N','sideBox2N','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_boot_basic_green_col2','r_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"r_good_slide_carousel\", \"gallery_main_ad\", 5, 0, 1,  \"600|227\")','latest(\"r_good_boot_basic_popup_col2\", \"notice\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"free\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"blog\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"qna\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','checked','checked','checked','checked','','','','','','','','','','','','','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','outsearch(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','sideBox2N','sideBox2N','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_boot_basic_video','r_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"r_good_slide_bx\", \"gallery_main_ad\", 5, 0, 1, \"480|182|728|360|1\")','latest(\"r_good_boot_basic_popup\", \"notice\", 4, 32)','latest(\"r_good_boot_basic\", \"free\", 4, 32)','latest(\"r_good_boot_basic\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic\", \"blog\", 4, 32)','latest(\"r_good_boot_basic\", \"qna\", 4, 32)','latest(\"r_good_boot_basic\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','checked','checked','checked','checked','','','','','','','','','','','','','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','outsearch(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','sideBox2N','sideBox2N','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_boot_free_col2','r_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"r_good_slide_carousel\", \"gallery_main_ad\", 5, 0, 1, \"600|227\")','latest(\"r_good_boot_basic_popup_col2\", \"notice\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"free\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"blog\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"qna\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','checked','checked','checked','checked','','','','','','','','','','','','','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','outsearch(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','sideBox2N','sideBox2N','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_boot_swatch','r_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"r_good_slide_carousel\", \"gallery_main_ad\", 5, 0, 1, \"600|227\")','latest(\"r_good_boot_basic_popup_col2\", \"notice\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"free\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"blog\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"qna\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','checked','checked','checked','checked','','','','','','','','','','','','','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','outsearch(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','sideBox2N','sideBox2N','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_shop_boot_basic','r_shop_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'checked','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"r_good_boot_basic_popup\", \"notice\", 4, 32)','latest(\"r_good_boot_basic\", \"free\", 4, 32)','latest(\"r_good_boot_basic\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic\", \"blog\", 4, 32)','latest(\"r_good_boot_basic\", \"qna\", 4, 32)','latest(\"r_good_boot_basic\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_shop_boot_basic_col2','r_shop_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'checked','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"r_good_slide_carousel\", \"gallery_main_ad\", 5, 0, 1, \"600|227\")','latest(\"r_good_boot_basic_popup_col2\", \"notice\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"free\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"blog\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"qna\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_shop_boot_basic_green','r_shop_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'checked','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"r_good_slide_carousel\", \"gallery_main_ad\", 5, 0, 1, \"600|227\")','latest(\"r_good_boot_basic_popup\", \"notice\", 4, 32)','latest(\"r_good_boot_basic\", \"free\", 4, 32)','latest(\"r_good_boot_basic\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic\", \"blog\", 4, 32)','latest(\"r_good_boot_basic\", \"qna\", 4, 32)','latest(\"r_good_boot_basic\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_shop_boot_basic_green_col','r_shop_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'checked','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"r_good_boot_basic_popup_col2\", \"notice\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"free\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"blog\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"qna\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_shop_boot_free_col2','r_shop_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'checked','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"r_good_slide_carousel\", \"gallery_main_ad\", 5, 0, 1, \"600|227\")','latest(\"r_good_boot_basic_popup_col2\", \"notice\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"free\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"blog\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"qna\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_basic','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_portpolio','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_companybts','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_shop_company','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_community','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_noodle','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_shop_basic','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('t_shop_basic','shop_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('t_basic','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 5, 48, 1, \"141|94\")','latest(\"good_webzine\", \"gallery2\", 3, 48, 1, \"120|80\")','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_webzine_row\", \"gallery1\", 3, 48)','latest(\"good_webzine_row\", \"gallery2\", 3, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_basicbts','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_clean_blog','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_hz_black','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_jm','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_lu01','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_mint','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_raysoda','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_shop_baver','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_shop_hello','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_shop_jewelry','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_shop_modern','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_shop_nongsan','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_w3schools','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_contents_basic','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_shop_boot_basic_green_col2','r_shop_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'checked','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"r_good_slide_carousel\", \"gallery_main_ad\", 5, 0, 1, \"600|227\")','latest(\"r_good_boot_basic_popup_col2\", \"notice\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"free\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"blog\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"qna\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_basic_pro','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 5, 48, 1, \"141|94\")','latest(\"good_webzine\", \"gallery2\", 3, 48, 1, \"120|80\")','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_webzine_row\", \"gallery1\", 3, 48)','latest(\"good_webzine_row\", \"gallery2\", 3, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_contents_basic_pro','contents_basic',10,10,1000,790,0,210,0,0,30,15,15,5,5,'checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_main_gal\", \"gallery_main_ad\", 5, 0, 1, \"790|300\")','latest(\"good_main_slide\", \"gallery_main_ad\", 5, 0, 1, \"790|300\")','latest(\"good_main_video\", \"gallery_main_ad\", 1, 0, 1, \"790|360\")','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_shop_basic_pro','shop_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_main_gal\", \"gallery_main_ad\", 5, 0, 1, \"740|281\")','latest(\"good_main_slide\", \"gallery_main_ad\", 5, 0, 1, \"740|281\")','latest(\"good_main_video\", \"gallery_main_ad\", 1, 0, 1, \"740|360\")','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('w3_basic','w3_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('basic_pro','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 5, 48, 1, \"141|94\")','latest(\"good_webzine\", \"gallery2\", 3, 48, 1, \"120|80\")','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_webzine_row\", \"gallery1\", 3, 48)','latest(\"good_webzine_row\", \"gallery2\", 3, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_boot_basic_pro','r_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"r_good_boot_basic_popup_col2\", \"notice\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"free\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"blog\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"qna\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','checked','checked','checked','checked','','','','','','','','','','','','','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','outsearch(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','sideBox2N','sideBox2N','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('r_shop_boot_basic_pro','r_shop_boot_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','checked','checked','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"r_good_boot_basic_popup_col2\", \"notice\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"free\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 3, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"blog\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"qna\", 4, 32)','latest(\"r_good_boot_basic_col2\", \"gallery1\", 2, 48)','latest(\"r_good_boot_basic_col2\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('shop_basic_pro','shop_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('w3_shop_basic','w3_shop_basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('w3_contents_basic','w3_contents_basic',10,10,1000,790,0,210,0,0,30,15,15,5,5,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_basic_new','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_shop_basic_new','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_basic_new_pro','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'checked','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
INSERT INTO `g5_config2w` VALUES ('theme_shop_basic_new_pro','basic',10,10,960,760,0,200,0,0,30,15,15,5,5,'checked','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','latest(\"good_webzine_full\", \"gallery_main_ad\", 1, 48)','latest(\"good_basic\", \"notice\", 4, 32)','latest(\"good_basic\", \"free\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 3, 48)','latest(\"good_webzine\", \"gallery2\", 2, 48)','latest(\"good_basic\", \"blog\", 4, 32)','latest(\"good_basic\", \"qna\", 4, 32)','latest(\"good_gallery\", \"gallery1\", 2, 48)','latest(\"good_webzine\", \"gallery2\", 1, 48)','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','sideBoxGN','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','checked','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','outsearch(\"good_basic\")','sidemenu(\"good_basic\")','outlogin(\"good_basic\")','popular(\"good_basic\")','visit(\"good_basic\")','poll(\"good_basic\")','connect(\"good_basic\")','outnew(\"good_basic\")','','','','','','','','','','','','','searchBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','sideBox2N','','','','','','','','','','','','','','','','','','','checked','checked','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0,0,0);
/*!40000 ALTER TABLE `g5_config2w` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config2w_board`
--

DROP TABLE IF EXISTS `g5_config2w_board`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_config2w_board` (
  `cf_id` varchar(255) NOT NULL DEFAULT '',
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `bo_skin` varchar(255) NOT NULL DEFAULT '',
  `bo_latest_skin` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`cf_id`,`bo_table`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config2w_board`
--

LOCK TABLES `g5_config2w_board` WRITE;
/*!40000 ALTER TABLE `g5_config2w_board` DISABLE KEYS */;
INSERT INTO `g5_config2w_board` VALUES ('basic','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','gallery_main_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','gallery_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','service','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','notice','theme/good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','intro','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','notice','theme/good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','intro','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','gallery_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','service','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','gallery_main_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_banner','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','notice','theme/good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','intro','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','gallery_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','service','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','gallery_main_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_biz_easy','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','callcenter','theme/g4_good_webzine_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','notice','theme/g4_good_popup_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','qna','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','faq','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','free','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','intro','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','gallery1','theme/g4_good_gallery_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','gallery2','theme/g4_good_webzine_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','gallery_ad','theme/g4_good_gallery_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','request','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','service','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','gallery0','theme/g4_good_gallery_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','gallery_main_ad','theme/g4_good_gallery_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','blog','theme/g4_good_blog_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','main_banner','theme/g4_good_webzine_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','qa','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic','builder','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','callcenter','theme/g4_good_webzine_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','notice','theme/g4_good_popup_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','qna','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','faq','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','free','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','intro','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','gallery1','theme/g4_good_gallery_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','gallery2','theme/g4_good_webzine_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','gallery_ad','theme/g4_good_gallery_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','request','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','service','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','gallery0','theme/g4_good_gallery_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','gallery_main_ad','theme/g4_good_gallery_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','blog','theme/g4_good_blog_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','main_banner','theme/g4_good_webzine_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','qa','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_banner','builder','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','callcenter','theme/g4_good_webzine_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','notice','theme/g4_good_popup_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','qna','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','faq','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','free','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','intro','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','gallery1','theme/g4_good_gallery_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','gallery2','theme/g4_good_webzine_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','gallery_ad','theme/g4_good_gallery_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','request','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','service','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','gallery0','theme/g4_good_gallery_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','gallery_main_ad','theme/g4_good_gallery_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','blog','theme/g4_good_blog_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','main_banner','theme/g4_good_webzine_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','qa','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('g4_basic_biz_easy','builder','theme/g4_good_basic_me','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','notice','theme/good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','intro','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','gallery_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','service','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','gallery_main_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','notice','theme/good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','intro','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','gallery_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','service','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','gallery_main_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_banner','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','notice','theme/good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','intro','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','gallery_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','service','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','gallery_main_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','notice','theme/good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','intro','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','gallery_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','service','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','gallery_main_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_biz_easy','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','notice','theme/good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','intro','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','gallery_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','service','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','gallery_main_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_c_basic_banner','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','gallery_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','gallery_main_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','intro','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','notice','theme/good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_video','service','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','gallery_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','gallery_main_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','intro','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','notice','theme/good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_slide','service','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','notice','theme/r_good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','notice','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_col2','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','notice','theme/r_good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','notice','theme/r_good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_green_col2','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','notice','theme/r_good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_video','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','notice','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_free_col2','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','notice','theme/r_good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_swatch','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','notice','theme/r_good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','notice','theme/r_good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_col2','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','notice','theme/r_good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','notice','theme/r_good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_green_col2','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','notice','theme/r_good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_free_col2','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','gallery_ad','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_company','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_pro','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_community','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_companybts','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_portpolio','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_basic','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_shop_basic','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basicbts','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_clean_blog','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_hello','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_jm','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_lu01','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_mint','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_baver','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_raysoda','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_w3schools','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_jewelry','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_modern','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_nongsan','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_noodle','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('t_woonote_basic','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_pro','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_contents_basic_pro','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','notice','theme/r_good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','basic_service','theme/r_good_webzine','');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','basic_main_banner','theme/r_good_webzine','');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','basic_gallery','theme/r_good_webzine','');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','basic_contact','theme/online_contact','');
INSERT INTO `g5_config2w_board` VALUES ('w3_basic','basic_about','theme/r_good_about','');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','notice','theme/good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','intro','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','gallery_main_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','gallery_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('basic_pro','service','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','notice','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_boot_basic_pro','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','notice','theme/r_good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('r_shop_boot_basic_pro','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','gallery_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','gallery_main_ad','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','intro','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','notice','theme/good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('shop_basic_pro','service','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','basic_about','theme/r_good_about','');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','basic_contact','theme/online_contact','');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','basic_gallery','theme/r_good_webzine','');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','basic_main_banner','theme/r_good_webzine','');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','basic_service','theme/r_good_webzine','');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','blog','theme/r_good_blog','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','builder','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','callcenter','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','faq','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','free','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','gallery0','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','gallery1','theme/r_good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','gallery2','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','gallery_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','gallery_main_ad','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','intro','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','main_banner','theme/r_good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','notice','theme/r_good_basic_popup','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','qa','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','qna','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','request','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_shop_basic','service','theme/r_good_basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('w3_contents_basic','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_basic_new_pro','service','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_board` VALUES ('theme_shop_basic_new_pro','service','theme/gallery','theme/good_basic');
/*!40000 ALTER TABLE `g5_config2w_board` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config2w_config`
--

DROP TABLE IF EXISTS `g5_config2w_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_config2w_config` (
  `cf_id` varchar(255) NOT NULL DEFAULT '',
  `cf_new_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_search_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_connect_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_faq_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_qa_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_co_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_member_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_shop_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_contents_skin` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`cf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config2w_config`
--

LOCK TABLES `g5_config2w_config` WRITE;
/*!40000 ALTER TABLE `g5_config2w_config` DISABLE KEYS */;
INSERT INTO `g5_config2w_config` VALUES ('basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','','');
INSERT INTO `g5_config2w_config` VALUES ('basic_banner','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('basic_biz_easy','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('g4_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('g4_basic_banner','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('g4_basic_biz_easy','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('shop_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('shop_basic_banner','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('shop_boot_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('shop_c_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('shop_c_basic_biz_easy','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('shop_c_basic_banner','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('basic_video','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('basic_slide','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_boot_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_boot_basic_col2','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_boot_basic_green','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_boot_basic_green_col2','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_boot_basic_video','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_boot_free_col2','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_boot_swatch','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_shop_boot_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_shop_boot_basic_col2','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_shop_boot_basic_green','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_shop_boot_basic_green_col2','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_shop_boot_free_col2','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('theme_shop_company','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_basic_pro','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_community','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_shop_baver','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_companybts','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_portpolio','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_shop_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('t_shop_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('t_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_basicbts','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_clean_blog','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_shop_hello','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_jm','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_lu01','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_mint','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_raysoda','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_w3schools','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_shop_jewelry','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_shop_modern','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_shop_nongsan','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_noodle','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_contents_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic');
INSERT INTO `g5_config2w_config` VALUES ('theme_shop_basic_pro','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_contents_basic_pro','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic');
INSERT INTO `g5_config2w_config` VALUES ('w3_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic','theme/basic','theme/basic','theme/r_good_basic_simple','theme/basic');
INSERT INTO `g5_config2w_config` VALUES ('basic_pro','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_boot_basic_pro','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('r_shop_boot_basic_pro','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/r_good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('shop_basic_pro','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic_simple','');
INSERT INTO `g5_config2w_config` VALUES ('w3_shop_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/good_basic','theme/basic','theme/basic','theme/w3_basic','theme/basic');
INSERT INTO `g5_config2w_config` VALUES ('w3_contents_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/w3_basic','theme/w3_basic');
INSERT INTO `g5_config2w_config` VALUES ('theme_basic_new','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_shop_basic_new','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_basic_new_pro','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_config` VALUES ('theme_shop_basic_new_pro','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
/*!40000 ALTER TABLE `g5_config2w_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config2w_def`
--

DROP TABLE IF EXISTS `g5_config2w_def`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_config2w_def` (
  `cf_templete` varchar(255) NOT NULL DEFAULT 'basic',
  `lang` varchar(30) NOT NULL DEFAULT '',
  `lang_list` text NOT NULL,
  `currency` varchar(30) NOT NULL DEFAULT '',
  `currency_list` text NOT NULL,
  `lang_currency_list` text NOT NULL,
  `exchange_rate_list` text NOT NULL,
  `cf_header_logo` text NOT NULL,
  `cf_site_name` varchar(255) NOT NULL DEFAULT '',
  `cf_site_addr` text NOT NULL,
  `cf_zip` varchar(255) NOT NULL DEFAULT '',
  `cf_tel` varchar(255) NOT NULL DEFAULT '',
  `cf_fax` varchar(255) NOT NULL DEFAULT '',
  `cf_email` varchar(255) NOT NULL DEFAULT '',
  `cf_site_owner` varchar(255) NOT NULL DEFAULT '',
  `cf_biz_num` varchar(255) NOT NULL DEFAULT '',
  `cf_ebiz_num` varchar(255) NOT NULL DEFAULT '',
  `cf_info_man` varchar(255) NOT NULL DEFAULT '',
  `cf_info_email` varchar(255) NOT NULL DEFAULT '',
  `cf_copyright` text NOT NULL,
  `cf_keywords` text NOT NULL,
  `cf_description` text NOT NULL,
  `cf_contact_info` varchar(255) NOT NULL DEFAULT '',
  `cf_google_map_pos` varchar(255) NOT NULL DEFAULT '',
  `cf_google_map_api_key` varchar(255) NOT NULL DEFAULT '',
  `cf_google_captcha_api_key` varchar(255) NOT NULL DEFAULT '',
  `cf_google_captcha_api_secret` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config2w_def`
--

LOCK TABLES `g5_config2w_def` WRITE;
/*!40000 ALTER TABLE `g5_config2w_def` DISABLE KEYS */;
INSERT INTO `g5_config2w_def` VALUES ('w3_basic','ko_KR','ko_KR|en_US|ja_JP|zh_CN|zh_TW|ru_RU|vi_VN|ms_MY|th_TH|mn_MN|ar_EG|de_DE|el_GR|es_ES|fa_IR|fr_FR|he_IL|hi_IN|id_ID|nb_NO|ne_NP|nl_NL|ro_RO|tr_TR','KRW','KRW|USD|JPY100|CNY|TWD|RUB|VND100|MYR|THB|MNT|SAR|EUR|EUR|EUR|EGP|EUR|ILS|INR|IDR100|NOK|INR|EUR|EUR|TRY','ko_KR:KRW|en_US:USD|ja_JP:JPY100|zh_CN:CNY|zh_TW:TWD|ru_RU:RUB|vi_VN:VND100|ms_MY:MYR|th_TH:THB|mn_MN:MNT|ar_EG:SAR|de_DE:EUR|el_GR:EUR|es_ES:EUR|fa_IR:EGP|fr_FR:EUR|he_IL:ILS|hi_IN:INR|id_ID:IDR100|nb_NO:NOK|ne_NP:INR|nl_NL:EUR|ro_RO:EUR|tr_TR:TRY','KRW:1|USD:1065.00|JPY100:957.99|CNY:164.73|EUR:1292.27|INR:16.75|SAR:283.98|NOK:133.79|MYR:268.16|IDR100:8.00|TWD:35.95|THB:33.32|EGP:60.14|ILS:313.19|VND100:4.69|RUB:18.81|MNT:0.4522|TRY:283.21','헤더 로고명','사이트 이름','사이트 주소','우편 번호','전화 번호','팩스','이메일','대표','사업자 등록 번호','통신 판매업 신고 번호','개인 정보 관리 책임자','개인 정보 관리 책임자 이메일','Copyright (c) 2010 All Rights Reserved.','사이트 키워드들','사이트에 대한 설명','시카고, 미국::: +00 1515151515::: test@test.com::: 방문 및 상담을 환영합니다!','41.878114, -87.629798','AIzaSyDFX2xiKdH3unkDcMYb6nFXvJAplGieHE4','','');
/*!40000 ALTER TABLE `g5_config2w_def` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config2w_m`
--

DROP TABLE IF EXISTS `g5_config2w_m`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_config2w_m` (
  `cf_id` varchar(255) NOT NULL DEFAULT '',
  `cf_search` varchar(30) NOT NULL DEFAULT 'nouse',
  `cf_menu_style` varchar(30) NOT NULL DEFAULT 'list',
  `cf_main_image` varchar(30) NOT NULL DEFAULT 'nouse',
  `cf_use_common_logo` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_common_menu` tinyint(4) NOT NULL DEFAULT '0',
  `cf_use_common_addr` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`cf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config2w_m`
--

LOCK TABLES `g5_config2w_m` WRITE;
/*!40000 ALTER TABLE `g5_config2w_m` DISABLE KEYS */;
INSERT INTO `g5_config2w_m` VALUES ('basic','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('shop_basic','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('shop_c_basic','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('basic_webzine','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('shop_c_basic_webzine','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('theme_basic','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('t_shop_basic','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('t_basic','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('theme_shop_basic','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('theme_community','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('theme_hz_black','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('theme_mint','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('theme_w3schools','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('theme_shop_jewelry','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('theme_contents_basic','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('theme_contents_basic_pro','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('theme_shop_basic_pro','nouse','list','nouse',0,0,0);
INSERT INTO `g5_config2w_m` VALUES ('theme_basic_pro','nouse','list','nouse',0,0,0);
/*!40000 ALTER TABLE `g5_config2w_m` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config2w_m_board`
--

DROP TABLE IF EXISTS `g5_config2w_m_board`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_config2w_m_board` (
  `cf_id` varchar(255) NOT NULL DEFAULT '',
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `bo_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `bo_mobile_latest_skin` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`cf_id`,`bo_table`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config2w_m_board`
--

LOCK TABLES `g5_config2w_m_board` WRITE;
/*!40000 ALTER TABLE `g5_config2w_m_board` DISABLE KEYS */;
INSERT INTO `g5_config2w_m_board` VALUES ('basic','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','gallery_main_ad','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','gallery_ad','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','service','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','notice','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','intro','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','notice','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','intro','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','gallery_ad','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','service','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','gallery_main_ad','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_basic','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','notice','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','intro','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','gallery_ad','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','service','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','gallery_main_ad','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','gallery_ad','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','gallery_main_ad','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','intro','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','notice','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('basic_webzine','service','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','blog','theme/good_blog','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','builder','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','callcenter','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','faq','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','free','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','gallery0','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','gallery1','theme/good_gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','gallery2','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','gallery_ad','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','gallery_main_ad','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','intro','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','main_banner','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','notice','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','qa','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','qna','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','request','theme/good_basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('shop_c_basic_webzine','service','theme/good_webzine','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic','service','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_basic_pro','service','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_basic','service','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic','service','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('t_shop_basic','service','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_community','service','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_mint','service','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_w3schools','service','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_jewelry','service','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic','service','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','service','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_shop_basic_pro','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','blog','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','builder','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','callcenter','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','faq','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','free','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','gallery0','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','gallery1','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','gallery2','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','gallery_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','gallery_main_ad','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','intro','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','main_banner','theme/gallery','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','notice','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','qa','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','qna','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','request','theme/basic','theme/good_basic');
INSERT INTO `g5_config2w_m_board` VALUES ('theme_contents_basic_pro','service','theme/basic','theme/good_basic');
/*!40000 ALTER TABLE `g5_config2w_m_board` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config2w_m_config`
--

DROP TABLE IF EXISTS `g5_config2w_m_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_config2w_m_config` (
  `cf_id` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_new_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_search_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_connect_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_faq_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_qa_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_co_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_member_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_shop_skin` varchar(255) NOT NULL DEFAULT '',
  `cf_mobile_contents_skin` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`cf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config2w_m_config`
--

LOCK TABLES `g5_config2w_m_config` WRITE;
/*!40000 ALTER TABLE `g5_config2w_m_config` DISABLE KEYS */;
INSERT INTO `g5_config2w_m_config` VALUES ('basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','','');
INSERT INTO `g5_config2w_m_config` VALUES ('shop_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('shop_c_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('shop_c_basic_webzine','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('basic_webzine','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('theme_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('theme_basic_pro','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('t_shop_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('t_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('theme_shop_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('theme_community','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('theme_mint','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('theme_w3schools','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('theme_shop_jewelry','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('theme_contents_basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic');
INSERT INTO `g5_config2w_m_config` VALUES ('theme_shop_basic_pro','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','');
INSERT INTO `g5_config2w_m_config` VALUES ('theme_contents_basic_pro','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic','theme/basic');
/*!40000 ALTER TABLE `g5_config2w_m_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config2w_m_def`
--

DROP TABLE IF EXISTS `g5_config2w_m_def`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_config2w_m_def` (
  `cf_templete` varchar(255) NOT NULL DEFAULT 'basic',
  `cf_mobile_templete` varchar(255) NOT NULL DEFAULT 'basic',
  PRIMARY KEY  (`cf_templete`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config2w_m_def`
--

LOCK TABLES `g5_config2w_m_def` WRITE;
/*!40000 ALTER TABLE `g5_config2w_m_def` DISABLE KEYS */;
INSERT INTO `g5_config2w_m_def` VALUES ('shop_basic','shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('basic','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('basic_banner','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('basic_biz_easy','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('basic_slide','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('basic_video','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('g4_basic','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('g4_basic_banner','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('g4_basic_biz_easy','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_boot_basic','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_boot_basic_col2','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_boot_basic_green','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_boot_basic_green_col2','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_boot_basic_video','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_boot_free_col2','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_boot_swatch','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_shop_boot_basic','shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_shop_boot_basic_col2','shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_shop_boot_basic_green','shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_shop_boot_basic_green_col2','shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_shop_boot_free_col2','shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('shop_basic_banner','shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('shop_c_basic','shop_c_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('shop_c_basic_banner','shop_c_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('shop_c_basic_biz_easy','shop_c_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_basic','theme_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_shop_company','theme_shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_community','theme_community');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_noodle','theme_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_companybts','theme_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_portpolio','theme_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_shop_basic','theme_shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('t_basic','t_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('t_shop_basic','t_shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_basicbts','theme_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_baver','theme_no_mobile');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_clean_blog','theme_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_hello','theme_no_mobile');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_mint','theme_mint');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_hz_black','theme_hz_black');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_jewelry','theme_no_mobile');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_jm','theme_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_lu01','theme_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_modernshop','theme_no_mobile');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_nongsan','theme_no_mobile');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_raysoda','theme_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_w3schools','theme_w3schools');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_shop_hello','theme_shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_shop_jewelry','theme_shop_jewelry');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_shop_modern','theme_shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_shop_nongsan','theme_shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_shop_noodle','theme_shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_shop_baver','theme_shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('t_woonote_basic','theme_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_contents_basic','theme_contents_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_contents_basic_pro','theme_contents_basic_pro');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_shop_basic_pro','theme_shop_basic_pro');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_basic_pro','theme_basic_pro');
INSERT INTO `g5_config2w_m_def` VALUES ('w3_basic','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('basic_pro','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_boot_basic_pro','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('r_shop_boot_basic_pro','shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('shop_basic_pro','shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('w3_shop_basic','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('w3_contents_basic','basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_basic_new','theme_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_shop_basic_new','theme_shop_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_basic_new_pro','theme_basic');
INSERT INTO `g5_config2w_m_def` VALUES ('theme_shop_basic_new_pro','theme_shop_basic');
/*!40000 ALTER TABLE `g5_config2w_m_def` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config2w_menu`
--

DROP TABLE IF EXISTS `g5_config2w_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_config2w_menu` (
  `cf_menu` varchar(255) NOT NULL DEFAULT '',
  `cf_menu_name_0` text NOT NULL,
  `cf_menu_name_1` text NOT NULL,
  `cf_menu_name_2` text NOT NULL,
  `cf_menu_name_3` text NOT NULL,
  `cf_menu_name_4` text NOT NULL,
  `cf_menu_name_5` text NOT NULL,
  `cf_menu_name_6` text NOT NULL,
  `cf_menu_name_7` text NOT NULL,
  `cf_menu_name_8` text NOT NULL,
  `cf_menu_name_9` text NOT NULL,
  `cf_menu_leng_0` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_1` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_2` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_3` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_4` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_5` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_6` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_7` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_8` int(11) NOT NULL DEFAULT '0',
  `cf_menu_leng_9` int(11) NOT NULL DEFAULT '0',
  `cf_menu_link_0` text NOT NULL,
  `cf_menu_link_1` text NOT NULL,
  `cf_menu_link_2` text NOT NULL,
  `cf_menu_link_3` text NOT NULL,
  `cf_menu_link_4` text NOT NULL,
  `cf_menu_link_5` text NOT NULL,
  `cf_menu_link_6` text NOT NULL,
  `cf_menu_link_7` text NOT NULL,
  `cf_menu_link_8` text NOT NULL,
  `cf_menu_link_9` text NOT NULL,
  `cf_submenu_name_0_0` text NOT NULL,
  `cf_submenu_name_0_1` text NOT NULL,
  `cf_submenu_name_0_2` text NOT NULL,
  `cf_submenu_name_0_3` text NOT NULL,
  `cf_submenu_name_0_4` text NOT NULL,
  `cf_submenu_name_0_5` text NOT NULL,
  `cf_submenu_name_0_6` text NOT NULL,
  `cf_submenu_name_0_7` text NOT NULL,
  `cf_submenu_name_0_8` text NOT NULL,
  `cf_submenu_name_0_9` text NOT NULL,
  `cf_submenu_link_0_0` text NOT NULL,
  `cf_submenu_link_0_1` text NOT NULL,
  `cf_submenu_link_0_2` text NOT NULL,
  `cf_submenu_link_0_3` text NOT NULL,
  `cf_submenu_link_0_4` text NOT NULL,
  `cf_submenu_link_0_5` text NOT NULL,
  `cf_submenu_link_0_6` text NOT NULL,
  `cf_submenu_link_0_7` text NOT NULL,
  `cf_submenu_link_0_8` text NOT NULL,
  `cf_submenu_link_0_9` text NOT NULL,
  `cf_submenu_name_1_0` text NOT NULL,
  `cf_submenu_name_1_1` text NOT NULL,
  `cf_submenu_name_1_2` text NOT NULL,
  `cf_submenu_name_1_3` text NOT NULL,
  `cf_submenu_name_1_4` text NOT NULL,
  `cf_submenu_name_1_5` text NOT NULL,
  `cf_submenu_name_1_6` text NOT NULL,
  `cf_submenu_name_1_7` text NOT NULL,
  `cf_submenu_name_1_8` text NOT NULL,
  `cf_submenu_name_1_9` text NOT NULL,
  `cf_submenu_link_1_0` text NOT NULL,
  `cf_submenu_link_1_1` text NOT NULL,
  `cf_submenu_link_1_2` text NOT NULL,
  `cf_submenu_link_1_3` text NOT NULL,
  `cf_submenu_link_1_4` text NOT NULL,
  `cf_submenu_link_1_5` text NOT NULL,
  `cf_submenu_link_1_6` text NOT NULL,
  `cf_submenu_link_1_7` text NOT NULL,
  `cf_submenu_link_1_8` text NOT NULL,
  `cf_submenu_link_1_9` text NOT NULL,
  `cf_submenu_name_2_0` text NOT NULL,
  `cf_submenu_name_2_1` text NOT NULL,
  `cf_submenu_name_2_2` text NOT NULL,
  `cf_submenu_name_2_3` text NOT NULL,
  `cf_submenu_name_2_4` text NOT NULL,
  `cf_submenu_name_2_5` text NOT NULL,
  `cf_submenu_name_2_6` text NOT NULL,
  `cf_submenu_name_2_7` text NOT NULL,
  `cf_submenu_name_2_8` text NOT NULL,
  `cf_submenu_name_2_9` text NOT NULL,
  `cf_submenu_link_2_0` text NOT NULL,
  `cf_submenu_link_2_1` text NOT NULL,
  `cf_submenu_link_2_2` text NOT NULL,
  `cf_submenu_link_2_3` text NOT NULL,
  `cf_submenu_link_2_4` text NOT NULL,
  `cf_submenu_link_2_5` text NOT NULL,
  `cf_submenu_link_2_6` text NOT NULL,
  `cf_submenu_link_2_7` text NOT NULL,
  `cf_submenu_link_2_8` text NOT NULL,
  `cf_submenu_link_2_9` text NOT NULL,
  `cf_submenu_name_3_0` text NOT NULL,
  `cf_submenu_name_3_1` text NOT NULL,
  `cf_submenu_name_3_2` text NOT NULL,
  `cf_submenu_name_3_3` text NOT NULL,
  `cf_submenu_name_3_4` text NOT NULL,
  `cf_submenu_name_3_5` text NOT NULL,
  `cf_submenu_name_3_6` text NOT NULL,
  `cf_submenu_name_3_7` text NOT NULL,
  `cf_submenu_name_3_8` text NOT NULL,
  `cf_submenu_name_3_9` text NOT NULL,
  `cf_submenu_link_3_0` text NOT NULL,
  `cf_submenu_link_3_1` text NOT NULL,
  `cf_submenu_link_3_2` text NOT NULL,
  `cf_submenu_link_3_3` text NOT NULL,
  `cf_submenu_link_3_4` text NOT NULL,
  `cf_submenu_link_3_5` text NOT NULL,
  `cf_submenu_link_3_6` text NOT NULL,
  `cf_submenu_link_3_7` text NOT NULL,
  `cf_submenu_link_3_8` text NOT NULL,
  `cf_submenu_link_3_9` text NOT NULL,
  `cf_submenu_name_4_0` text NOT NULL,
  `cf_submenu_name_4_1` text NOT NULL,
  `cf_submenu_name_4_2` text NOT NULL,
  `cf_submenu_name_4_3` text NOT NULL,
  `cf_submenu_name_4_4` text NOT NULL,
  `cf_submenu_name_4_5` text NOT NULL,
  `cf_submenu_name_4_6` text NOT NULL,
  `cf_submenu_name_4_7` text NOT NULL,
  `cf_submenu_name_4_8` text NOT NULL,
  `cf_submenu_name_4_9` text NOT NULL,
  `cf_submenu_link_4_0` text NOT NULL,
  `cf_submenu_link_4_1` text NOT NULL,
  `cf_submenu_link_4_2` text NOT NULL,
  `cf_submenu_link_4_3` text NOT NULL,
  `cf_submenu_link_4_4` text NOT NULL,
  `cf_submenu_link_4_5` text NOT NULL,
  `cf_submenu_link_4_6` text NOT NULL,
  `cf_submenu_link_4_7` text NOT NULL,
  `cf_submenu_link_4_8` text NOT NULL,
  `cf_submenu_link_4_9` text NOT NULL,
  `cf_submenu_name_5_0` text NOT NULL,
  `cf_submenu_name_5_1` text NOT NULL,
  `cf_submenu_name_5_2` text NOT NULL,
  `cf_submenu_name_5_3` text NOT NULL,
  `cf_submenu_name_5_4` text NOT NULL,
  `cf_submenu_name_5_5` text NOT NULL,
  `cf_submenu_name_5_6` text NOT NULL,
  `cf_submenu_name_5_7` text NOT NULL,
  `cf_submenu_name_5_8` text NOT NULL,
  `cf_submenu_name_5_9` text NOT NULL,
  `cf_submenu_link_5_0` text NOT NULL,
  `cf_submenu_link_5_1` text NOT NULL,
  `cf_submenu_link_5_2` text NOT NULL,
  `cf_submenu_link_5_3` text NOT NULL,
  `cf_submenu_link_5_4` text NOT NULL,
  `cf_submenu_link_5_5` text NOT NULL,
  `cf_submenu_link_5_6` text NOT NULL,
  `cf_submenu_link_5_7` text NOT NULL,
  `cf_submenu_link_5_8` text NOT NULL,
  `cf_submenu_link_5_9` text NOT NULL,
  `cf_submenu_name_6_0` text NOT NULL,
  `cf_submenu_name_6_1` text NOT NULL,
  `cf_submenu_name_6_2` text NOT NULL,
  `cf_submenu_name_6_3` text NOT NULL,
  `cf_submenu_name_6_4` text NOT NULL,
  `cf_submenu_name_6_5` text NOT NULL,
  `cf_submenu_name_6_6` text NOT NULL,
  `cf_submenu_name_6_7` text NOT NULL,
  `cf_submenu_name_6_8` text NOT NULL,
  `cf_submenu_name_6_9` text NOT NULL,
  `cf_submenu_link_6_0` text NOT NULL,
  `cf_submenu_link_6_1` text NOT NULL,
  `cf_submenu_link_6_2` text NOT NULL,
  `cf_submenu_link_6_3` text NOT NULL,
  `cf_submenu_link_6_4` text NOT NULL,
  `cf_submenu_link_6_5` text NOT NULL,
  `cf_submenu_link_6_6` text NOT NULL,
  `cf_submenu_link_6_7` text NOT NULL,
  `cf_submenu_link_6_8` text NOT NULL,
  `cf_submenu_link_6_9` text NOT NULL,
  `cf_submenu_name_7_0` text NOT NULL,
  `cf_submenu_name_7_1` text NOT NULL,
  `cf_submenu_name_7_2` text NOT NULL,
  `cf_submenu_name_7_3` text NOT NULL,
  `cf_submenu_name_7_4` text NOT NULL,
  `cf_submenu_name_7_5` text NOT NULL,
  `cf_submenu_name_7_6` text NOT NULL,
  `cf_submenu_name_7_7` text NOT NULL,
  `cf_submenu_name_7_8` text NOT NULL,
  `cf_submenu_name_7_9` text NOT NULL,
  `cf_submenu_link_7_0` text NOT NULL,
  `cf_submenu_link_7_1` text NOT NULL,
  `cf_submenu_link_7_2` text NOT NULL,
  `cf_submenu_link_7_3` text NOT NULL,
  `cf_submenu_link_7_4` text NOT NULL,
  `cf_submenu_link_7_5` text NOT NULL,
  `cf_submenu_link_7_6` text NOT NULL,
  `cf_submenu_link_7_7` text NOT NULL,
  `cf_submenu_link_7_8` text NOT NULL,
  `cf_submenu_link_7_9` text NOT NULL,
  `cf_submenu_name_8_0` text NOT NULL,
  `cf_submenu_name_8_1` text NOT NULL,
  `cf_submenu_name_8_2` text NOT NULL,
  `cf_submenu_name_8_3` text NOT NULL,
  `cf_submenu_name_8_4` text NOT NULL,
  `cf_submenu_name_8_5` text NOT NULL,
  `cf_submenu_name_8_6` text NOT NULL,
  `cf_submenu_name_8_7` text NOT NULL,
  `cf_submenu_name_8_8` text NOT NULL,
  `cf_submenu_name_8_9` text NOT NULL,
  `cf_submenu_link_8_0` text NOT NULL,
  `cf_submenu_link_8_1` text NOT NULL,
  `cf_submenu_link_8_2` text NOT NULL,
  `cf_submenu_link_8_3` text NOT NULL,
  `cf_submenu_link_8_4` text NOT NULL,
  `cf_submenu_link_8_5` text NOT NULL,
  `cf_submenu_link_8_6` text NOT NULL,
  `cf_submenu_link_8_7` text NOT NULL,
  `cf_submenu_link_8_8` text NOT NULL,
  `cf_submenu_link_8_9` text NOT NULL,
  `cf_submenu_name_9_0` text NOT NULL,
  `cf_submenu_name_9_1` text NOT NULL,
  `cf_submenu_name_9_2` text NOT NULL,
  `cf_submenu_name_9_3` text NOT NULL,
  `cf_submenu_name_9_4` text NOT NULL,
  `cf_submenu_name_9_5` text NOT NULL,
  `cf_submenu_name_9_6` text NOT NULL,
  `cf_submenu_name_9_7` text NOT NULL,
  `cf_submenu_name_9_8` text NOT NULL,
  `cf_submenu_name_9_9` text NOT NULL,
  `cf_submenu_link_9_0` text NOT NULL,
  `cf_submenu_link_9_1` text NOT NULL,
  `cf_submenu_link_9_2` text NOT NULL,
  `cf_submenu_link_9_3` text NOT NULL,
  `cf_submenu_link_9_4` text NOT NULL,
  `cf_submenu_link_9_5` text NOT NULL,
  `cf_submenu_link_9_6` text NOT NULL,
  `cf_submenu_link_9_7` text NOT NULL,
  `cf_submenu_link_9_8` text NOT NULL,
  `cf_submenu_link_9_9` text NOT NULL,
  PRIMARY KEY  (`cf_menu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config2w_menu`
--

LOCK TABLES `g5_config2w_menu` WRITE;
/*!40000 ALTER TABLE `g5_config2w_menu` DISABLE KEYS */;
INSERT INTO `g5_config2w_menu` VALUES ('basic','홈','소개','서비스','게시판','블로그','고객 센타','','','','',80,140,140,140,140,140,0,0,0,0,'/','/bbs/board.php?bo_table=intro','/bbs/board.php?bo_table=service','/bbs/board.php?bo_table=free','/bbs/board.php?bo_table=blog','/bbs/board.php?bo_table=notice','','','','','','','','','','','','','','','','','','','','','','','','','인사말','연혁','약력','오시는 길','','','','','','','/bbs/board.php?bo_table=intro&wr_id=1','/bbs/board.php?bo_table=intro&wr_id=2','/bbs/board.php?bo_table=intro&wr_id=3','/bbs/board.php?bo_table=intro&wr_id=4','','','','','','','서비스 내용1','서비스 내용2','','','','','','','','','/bbs/board.php?bo_table=service&wr_id=1','/bbs/board.php?bo_table=service&wr_id=2','','','','','','','','','자유 게시판','갤러리1','갤러리2','','','','','','','','/bbs/board.php?bo_table=free','/bbs/board.php?bo_table=gallery1','/bbs/board.php?bo_table=gallery2','','','','','','','','멤버 블로그','','','','','','','','','','/bbs/board.php?bo_table=blog','','','','','','','','','','공지 사항','질문 답변','FAQ','콜 센타','','','','','','','/bbs/board.php?bo_table=notice','/bbs/board.php?bo_table=qna','/bbs/board.php?bo_table=faq','/bbs/board.php?bo_table=callcenter','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
INSERT INTO `g5_config2w_menu` VALUES ('shop_basic','홈','분류1','분류2','분류3','분류4','블로그','고객 센타','','','',80,140,140,140,140,140,140,0,0,0,'/','/shop/list.php?ca_id=10','/shop/list.php?ca_id=20','/shop/list.php?ca_id=30','/shop/list.php?ca_id=40','/bbs/board.php?bo_table=blog','/bbs/board.php?bo_table=notice','','','','','','','','','','','','','','','','','','','','','','','','분류11','분류12','','','','','','','','','/shop/list.php?ca_id=1010','/shop/list.php?ca_id=1020','','','','','','','','','분류21','분류22','','','','','','','','','/shop/list.php?ca_id=2010','/shop/list.php?ca_id=2020','','','','','','','','','분류31','분류32','','','','','','','','','/shop/list.php?ca_id=3010','/shop/list.php?ca_id=3020','','','','','','','','','분류41','분류42','','','','','','','','','/shop/list.php?ca_id=4010','/shop/list.php?ca_id=4020','','','','','','','','','멤버 블로그','','','','','','','','','','/bbs/board.php?bo_table=blog','','','','','','','','','','공지 사항','질문 답변','FAQ','콜 센타','','','','','','','/bbs/board.php?bo_table=notice','/bbs/board.php?bo_table=qna','/bbs/board.php?bo_table=faq','/bbs/board.php?bo_table=callcenter','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
INSERT INTO `g5_config2w_menu` VALUES ('shop_c_basic','홈','소개','서비스','게시판','블로그','고객 센타','쇼핑몰','','','',80,140,140,140,140,140,140,0,0,0,'/','/bbs/board.php?bo_table=intro','/bbs/board.php?bo_table=service','/bbs/board.php?bo_table=free','/bbs/board.php?bo_table=blog','/bbs/board.php?bo_table=notice','/shop','','','','','','','','','','','','','','','','','','','','','','','','인사말','연혁','약력','오시는 길','','','','','','','/bbs/board.php?bo_table=intro&wr_id=1','/bbs/board.php?bo_table=intro&wr_id=2','/bbs/board.php?bo_table=intro&wr_id=3','/bbs/board.php?bo_table=intro&wr_id=4','','','','','','','서비스 내용1','서비스 내용2','','','','','','','','','/bbs/board.php?bo_table=service&wr_id=1','/bbs/board.php?bo_table=service&wr_id=2','','','','','','','','','자유 게시판','갤러리1','갤러리2','','','','','','','','/bbs/board.php?bo_table=free','/bbs/board.php?bo_table=gallery1','/bbs/board.php?bo_table=gallery2','','','','','','','','멤버 블로그','','','','','','','','','','/bbs/board.php?bo_table=blog','','','','','','','','','','공지 사항','질문 답변','FAQ','콜 센타','','','','','','','/bbs/board.php?bo_table=notice','/bbs/board.php?bo_table=qna','/bbs/board.php?bo_table=faq','/bbs/board.php?bo_table=callcenter','','','','','','','분류1','분류2','분류3','분류4','','','','','','','/shop/list.php?ca_id=10','/shop/list.php?ca_id=20','/shop/list.php?ca_id=30','/shop/list.php?ca_id=40','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
INSERT INTO `g5_config2w_menu` VALUES ('contents_basic','홈','분류1','분류2','분류3','분류4','블로그','고객 센타','','','',80,140,140,140,140,140,140,0,0,0,'/','/contents/list.php?ca_id=10','/contents/list.php?ca_id=20','/contents/list.php?ca_id=30','/contents/list.php?ca_id=40','/bbs/board.php?bo_table=blog','/bbs/board.php?bo_table=notice','','','','','','','','','','','','','','','','','','','','','','','','분류11','분류12','','','','','','','','','/contents/list.php?ca_id=1010','/contents/list.php?ca_id=1020','','','','','','','','','분류21','분류22','','','','','','','','','/contents/list.php?ca_id=2010','/contents/list.php?ca_id=2020','','','','','','','','','분류31','분류32','','','','','','','','','/contents/list.php?ca_id=3010','/contents/list.php?ca_id=3020','','','','','','','','','분류41','분류42','','','','','','','','','/contents/list.php?ca_id=4010','/contents/list.php?ca_id=4020','','','','','','','','','멤버 블로그','','','','','','','','','','/bbs/board.php?bo_table=blog','','','','','','','','','','공지 사항','질문 답변','FAQ','콜 센타','','','','','','','/bbs/board.php?bo_table=notice','/bbs/board.php?bo_table=qna','/bbs/board.php?bo_table=faq','/bbs/board.php?bo_table=callcenter','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
INSERT INTO `g5_config2w_menu` VALUES ('r_boot_basic','홈','소개','게시판','고객 센타','','','','','','',80,140,140,140,0,0,0,0,0,0,'/','/bbs/board.php?bo_table=intro','/bbs/board.php?bo_table=free','/bbs/board.php?bo_table=notice','','','','','','','','','','','','','','','','','','','','','','','','','','','소개','서비스','','','','','','','','','/bbs/board.php?bo_table=intro','/bbs/board.php?bo_table=service','','','','','','','','','자유 게시판','갤러리1','갤러리2','블로그','','','','','','','/bbs/board.php?bo_table=free','/bbs/board.php?bo_table=gallery1','/bbs/board.php?bo_table=gallery2','/bbs/board.php?bo_table=blog','','','','','','','공지 사항','질문 답변','FAQ','콜 센타','1:1문의','현재 접속자','새 게시물','','','','/bbs/board.php?bo_table=notice','/bbs/board.php?bo_table=qna','/bbs/faq.php','/bbs/board.php?bo_table=callcenter','/bbs/qalist.php','/bbs/current_connect.php','/bbs/new.php','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
INSERT INTO `g5_config2w_menu` VALUES ('r_shop_boot_basic','홈','샵','게시판','고객 센타','','','','','','',80,140,140,140,0,0,0,0,0,0,'/','/shop','/bbs/board.php?bo_table=free','/bbs/board.php?bo_table=notice','','','','','','','','','','','','','','','','','','','','','','','','','','','전체상품','분류11','분류12','분류21','분류22','','','','','','/shop/','/shop/list.php?ca_id=1010','/shop/list.php?ca_id=1020','/shop/list.php?ca_id=2010','/shop/list.php?ca_id=2020','','','','','','자유 게시판','갤러리1','갤러리2','블로그','','','','','','','/bbs/board.php?bo_table=free','/bbs/board.php?bo_table=gallery1','/bbs/board.php?bo_table=gallery2','/bbs/board.php?bo_table=blog','','','','','','','공지 사항','질문 답변','FAQ','콜 센타','1:1문의','개인결제','','','','','/bbs/board.php?bo_table=notice','/bbs/board.php?bo_table=qna','/bbs/faq.php','/bbs/board.php?bo_table=callcenter','/bbs/qalist.php','/shop/personalpay.php','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
INSERT INTO `g5_config2w_menu` VALUES ('w3_basic','홈','소개','서비스','갤러리','상담','고객 센타','','','','',80,140,140,140,140,140,0,0,0,0,'/','/bbs/board.php?bo_table=basic_about','/bbs/board.php?bo_table=basic_service','/bbs/board.php?bo_table=basic_gallery','/bbs/board.php?bo_table=basic_contact','/bbs/board.php?bo_table=notice','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','공지 사항','FAQ','질문 답변','1:1문의','현재 접속자','새 게시물','','','','','/bbs/board.php?bo_table=notice','/bbs/faq.php','/bbs/board.php?bo_table=qna','/bbs/qalist.php','/bbs/current_connect.php','/bbs/new.php','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
INSERT INTO `g5_config2w_menu` VALUES ('w3_shop_basic','홈','샵','게시판','고객 센타','','','','','','',80,140,140,140,0,0,0,0,0,0,'/','/shop','/bbs/board.php?bo_table=free','/bbs/board.php?bo_table=notice','','','','','','','','','','','','','','','','','','','','','','','','','','','전체상품','분류1','분류2','','','','','','','','/shop/','/shop/list.php?ca_id=10','/shop/list.php?ca_id=20','','','','','','','','자유 게시판','갤러리1','갤러리2','블로그','','','','','','','/bbs/board.php?bo_table=free','/bbs/board.php?bo_table=gallery1','/bbs/board.php?bo_table=gallery2','/bbs/board.php?bo_table=blog','','','','','','','공지 사항','질문 답변','FAQ','콜 센타','1:1문의','개인결제','','','','','/bbs/board.php?bo_table=notice','/bbs/board.php?bo_table=qna','/bbs/faq.php','/bbs/board.php?bo_table=callcenter','/bbs/qalist.php','/shop/personalpay.php','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
INSERT INTO `g5_config2w_menu` VALUES ('w3_contents_basic','홈','컨텐츠','게시판','고객 센타','','','','','','',80,140,140,140,0,0,0,0,0,0,'/','/contents','/bbs/board.php?bo_table=free','/bbs/board.php?bo_table=notice','','','','','','','','','','','','','','','','','','','','','','','','','','','전체상품','분류1','분류2','','','','','','','','/contents/','/contents/list.php?ca_id=10','/contents/list.php?ca_id=20','','','','','','','','자유 게시판','갤러리1','갤러리2','블로그','','','','','','','/bbs/board.php?bo_table=free','/bbs/board.php?bo_table=gallery1','/bbs/board.php?bo_table=gallery2','/bbs/board.php?bo_table=blog','','','','','','','공지 사항','질문 답변','FAQ','콜 센타','1:1문의','','','','','','/bbs/board.php?bo_table=notice','/bbs/board.php?bo_table=qna','/bbs/faq.php','/bbs/board.php?bo_table=callcenter','/bbs/qalist.php','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_config2w_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_content`
--

DROP TABLE IF EXISTS `g5_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_content` (
  `co_id` varchar(20) NOT NULL DEFAULT '',
  `co_html` tinyint(4) NOT NULL DEFAULT '0',
  `co_subject` varchar(255) NOT NULL DEFAULT '',
  `co_content` longtext NOT NULL,
  `co_mobile_content` longtext NOT NULL,
  `co_skin` varchar(255) NOT NULL DEFAULT '',
  `co_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `co_tag_filter_use` tinyint(4) NOT NULL DEFAULT '0',
  `co_hit` int(11) NOT NULL DEFAULT '0',
  `co_include_head` varchar(255) NOT NULL,
  `co_include_tail` varchar(255) NOT NULL,
  PRIMARY KEY  (`co_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_content`
--

LOCK TABLES `g5_content` WRITE;
/*!40000 ALTER TABLE `g5_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_faq`
--

DROP TABLE IF EXISTS `g5_faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_faq` (
  `fa_id` int(11) NOT NULL auto_increment,
  `fm_id` int(11) NOT NULL DEFAULT '0',
  `fa_subject` text NOT NULL,
  `fa_content` text NOT NULL,
  `fa_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`fa_id`),
  KEY `fm_id` (`fm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_faq`
--

LOCK TABLES `g5_faq` WRITE;
/*!40000 ALTER TABLE `g5_faq` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_faq_master`
--

DROP TABLE IF EXISTS `g5_faq_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_faq_master` (
  `fm_id` int(11) NOT NULL auto_increment,
  `fm_subject` varchar(255) NOT NULL DEFAULT '',
  `fm_head_html` text NOT NULL,
  `fm_tail_html` text NOT NULL,
  `fm_mobile_head_html` text NOT NULL,
  `fm_mobile_tail_html` text NOT NULL,
  `fm_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`fm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_faq_master`
--

LOCK TABLES `g5_faq_master` WRITE;
/*!40000 ALTER TABLE `g5_faq_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_faq_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_group`
--

DROP TABLE IF EXISTS `g5_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_group` (
  `gr_id` varchar(10) NOT NULL DEFAULT '',
  `gr_subject` varchar(255) NOT NULL DEFAULT '',
  `gr_device` enum('both','pc','mobile') NOT NULL DEFAULT 'both',
  `gr_admin` varchar(255) NOT NULL DEFAULT '',
  `gr_use_access` tinyint(4) NOT NULL DEFAULT '0',
  `gr_order` int(11) NOT NULL DEFAULT '0',
  `gr_1_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_2_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_3_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_4_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_5_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_6_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_7_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_8_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_9_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_10_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_1` varchar(255) NOT NULL DEFAULT '',
  `gr_2` varchar(255) NOT NULL DEFAULT '',
  `gr_3` varchar(255) NOT NULL DEFAULT '',
  `gr_4` varchar(255) NOT NULL DEFAULT '',
  `gr_5` varchar(255) NOT NULL DEFAULT '',
  `gr_6` varchar(255) NOT NULL DEFAULT '',
  `gr_7` varchar(255) NOT NULL DEFAULT '',
  `gr_8` varchar(255) NOT NULL DEFAULT '',
  `gr_9` varchar(255) NOT NULL DEFAULT '',
  `gr_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`gr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_group`
--

LOCK TABLES `g5_group` WRITE;
/*!40000 ALTER TABLE `g5_group` DISABLE KEYS */;
INSERT INTO `g5_group` VALUES ('board','게시판','both','',0,2,'','','','','','','','','','','','','','','','','','','','');
INSERT INTO `g5_group` VALUES ('intro','소개','both','',0,0,'','','','','','','','','','','','','','','','','','','','');
INSERT INTO `g5_group` VALUES ('service','서비스','both','',0,1,'','','','','','','','','','','','','','','','','','','','');
INSERT INTO `g5_group` VALUES ('blog','블로그','both','',0,3,'','','','','','','','','','','','','','','','','','','','');
INSERT INTO `g5_group` VALUES ('callcenter','고객센타','both','',0,4,'','','','','','','','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_group_member`
--

DROP TABLE IF EXISTS `g5_group_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_group_member` (
  `gm_id` int(11) NOT NULL auto_increment,
  `gr_id` varchar(255) NOT NULL DEFAULT '',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `gm_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`gm_id`),
  KEY `gr_id` (`gr_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_group_member`
--

LOCK TABLES `g5_group_member` WRITE;
/*!40000 ALTER TABLE `g5_group_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_group_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_login`
--

DROP TABLE IF EXISTS `g5_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_login` (
  `lo_ip` varchar(255) NOT NULL DEFAULT '',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `lo_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lo_location` text NOT NULL,
  `lo_url` text NOT NULL,
  PRIMARY KEY  (`lo_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_login`
--

LOCK TABLES `g5_login` WRITE;
/*!40000 ALTER TABLE `g5_login` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_mail`
--

DROP TABLE IF EXISTS `g5_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_mail` (
  `ma_id` int(11) NOT NULL auto_increment,
  `ma_subject` varchar(255) NOT NULL DEFAULT '',
  `ma_content` mediumtext NOT NULL,
  `ma_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ma_ip` varchar(255) NOT NULL DEFAULT '',
  `ma_last_option` text NOT NULL,
  PRIMARY KEY  (`ma_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_mail`
--

LOCK TABLES `g5_mail` WRITE;
/*!40000 ALTER TABLE `g5_mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_member`
--

DROP TABLE IF EXISTS `g5_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_member` (
  `mb_no` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `mb_password` varchar(255) NOT NULL DEFAULT '',
  `mb_name` varchar(255) NOT NULL DEFAULT '',
  `mb_nick` varchar(255) NOT NULL DEFAULT '',
  `mb_nick_date` date NOT NULL DEFAULT '0000-00-00',
  `mb_email` varchar(255) NOT NULL DEFAULT '',
  `mb_homepage` varchar(255) NOT NULL DEFAULT '',
  `mb_level` tinyint(4) NOT NULL DEFAULT '0',
  `mb_sex` char(1) NOT NULL DEFAULT '',
  `mb_birth` varchar(255) NOT NULL DEFAULT '',
  `mb_tel` varchar(255) NOT NULL DEFAULT '',
  `mb_hp` varchar(255) NOT NULL DEFAULT '',
  `mb_certify` varchar(20) NOT NULL DEFAULT '',
  `mb_adult` tinyint(4) NOT NULL DEFAULT '0',
  `mb_dupinfo` varchar(255) NOT NULL DEFAULT '',
  `mb_zip1` char(3) NOT NULL DEFAULT '',
  `mb_zip2` char(3) NOT NULL DEFAULT '',
  `mb_addr1` varchar(255) NOT NULL DEFAULT '',
  `mb_addr2` varchar(255) NOT NULL DEFAULT '',
  `mb_addr3` varchar(255) NOT NULL DEFAULT '',
  `mb_addr_jibeon` varchar(255) NOT NULL DEFAULT '',
  `mb_signature` text NOT NULL,
  `mb_recommend` varchar(255) NOT NULL DEFAULT '',
  `mb_point` int(11) NOT NULL DEFAULT '0',
  `mb_today_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_login_ip` varchar(255) NOT NULL DEFAULT '',
  `mb_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_ip` varchar(255) NOT NULL DEFAULT '',
  `mb_leave_date` varchar(8) NOT NULL DEFAULT '',
  `mb_intercept_date` varchar(8) NOT NULL DEFAULT '',
  `mb_email_certify` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_email_certify2` varchar(255) NOT NULL DEFAULT '',
  `mb_memo` text NOT NULL,
  `mb_lost_certify` varchar(255) NOT NULL,
  `mb_mailling` tinyint(4) NOT NULL DEFAULT '0',
  `mb_sms` tinyint(4) NOT NULL DEFAULT '0',
  `mb_open` tinyint(4) NOT NULL DEFAULT '0',
  `mb_open_date` date NOT NULL DEFAULT '0000-00-00',
  `mb_profile` text NOT NULL,
  `mb_memo_call` varchar(255) NOT NULL DEFAULT '',
  `mb_1` varchar(255) NOT NULL DEFAULT '',
  `mb_2` varchar(255) NOT NULL DEFAULT '',
  `mb_3` varchar(255) NOT NULL DEFAULT '',
  `mb_4` varchar(255) NOT NULL DEFAULT '',
  `mb_5` varchar(255) NOT NULL DEFAULT '',
  `mb_6` varchar(255) NOT NULL DEFAULT '',
  `mb_7` varchar(255) NOT NULL DEFAULT '',
  `mb_8` varchar(255) NOT NULL DEFAULT '',
  `mb_9` varchar(255) NOT NULL DEFAULT '',
  `mb_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`mb_no`),
  UNIQUE KEY `mb_id` (`mb_id`),
  KEY `mb_today_login` (`mb_today_login`),
  KEY `mb_datetime` (`mb_datetime`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_member`
--

LOCK TABLES `g5_member` WRITE;
/*!40000 ALTER TABLE `g5_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_memo`
--

DROP TABLE IF EXISTS `g5_memo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_memo` (
  `me_id` int(11) NOT NULL DEFAULT '0',
  `me_recv_mb_id` varchar(20) NOT NULL DEFAULT '',
  `me_send_mb_id` varchar(20) NOT NULL DEFAULT '',
  `me_send_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_memo` text NOT NULL,
  PRIMARY KEY  (`me_id`),
  KEY `me_recv_mb_id` (`me_recv_mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_memo`
--

LOCK TABLES `g5_memo` WRITE;
/*!40000 ALTER TABLE `g5_memo` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_memo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_menu`
--

DROP TABLE IF EXISTS `g5_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_menu` (
  `me_id` int(11) NOT NULL auto_increment,
  `me_code` varchar(255) NOT NULL DEFAULT '',
  `me_name` varchar(255) NOT NULL DEFAULT '',
  `me_link` varchar(255) NOT NULL DEFAULT '',
  `me_target` varchar(255) NOT NULL DEFAULT '',
  `me_order` int(11) NOT NULL DEFAULT '0',
  `me_use` tinyint(4) NOT NULL DEFAULT '0',
  `me_mobile_use` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`me_id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_menu`
--

LOCK TABLES `g5_menu` WRITE;
/*!40000 ALTER TABLE `g5_menu` DISABLE KEYS */;
INSERT INTO `g5_menu` VALUES (69,'10','소개','/bbs/board.php?bo_table=intro','self',0,1,1);
INSERT INTO `g5_menu` VALUES (70,'20','서비스','/bbs/board.php?bo_table=service','self',0,1,1);
INSERT INTO `g5_menu` VALUES (71,'30','게시판','/bbs/board.php?bo_table=free','self',0,1,1);
INSERT INTO `g5_menu` VALUES (72,'3010','자유 게시판','/bbs/board.php?bo_table=free','self',0,1,1);
INSERT INTO `g5_menu` VALUES (73,'3020','갤러리1','/bbs/board.php?bo_table=gallery1','self',0,1,1);
INSERT INTO `g5_menu` VALUES (74,'3030','갤러리2','/bbs/board.php?bo_table=gallery2','self',0,1,1);
INSERT INTO `g5_menu` VALUES (75,'40','블로그','/bbs/board.php?bo_table=blog','self',0,1,1);
INSERT INTO `g5_menu` VALUES (76,'50','고객 센타','/bbs/board.php?bo_table=notice','self',0,1,1);
INSERT INTO `g5_menu` VALUES (77,'5010','공지 사항','/bbs/board.php?bo_table=notice','self',0,1,1);
INSERT INTO `g5_menu` VALUES (78,'5020','질문 답변','/bbs/board.php?bo_table=qna','self',0,1,1);
INSERT INTO `g5_menu` VALUES (79,'5030','FAQ','/bbs/board.php?bo_table=faq','self',0,1,1);
INSERT INTO `g5_menu` VALUES (80,'5040','콜 센타','/bbs/board.php?bo_table=callcenter','self',0,1,1);
/*!40000 ALTER TABLE `g5_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_new_win`
--

DROP TABLE IF EXISTS `g5_new_win`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_new_win` (
  `nw_id` int(11) NOT NULL auto_increment,
  `nw_division` varchar(10) NOT NULL DEFAULT 'both',
  `nw_device` varchar(10) NOT NULL DEFAULT 'both',
  `nw_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nw_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nw_disable_hours` int(11) NOT NULL DEFAULT '0',
  `nw_left` int(11) NOT NULL DEFAULT '0',
  `nw_top` int(11) NOT NULL DEFAULT '0',
  `nw_height` int(11) NOT NULL DEFAULT '0',
  `nw_width` int(11) NOT NULL DEFAULT '0',
  `nw_subject` text NOT NULL,
  `nw_content` text NOT NULL,
  `nw_content_html` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`nw_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_new_win`
--

LOCK TABLES `g5_new_win` WRITE;
/*!40000 ALTER TABLE `g5_new_win` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_new_win` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_point`
--

DROP TABLE IF EXISTS `g5_point`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_point` (
  `po_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `po_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `po_content` varchar(255) NOT NULL DEFAULT '',
  `po_point` int(11) NOT NULL DEFAULT '0',
  `po_use_point` int(11) NOT NULL DEFAULT '0',
  `po_expired` tinyint(4) NOT NULL DEFAULT '0',
  `po_expire_date` date NOT NULL DEFAULT '0000-00-00',
  `po_mb_point` int(11) NOT NULL DEFAULT '0',
  `po_rel_table` varchar(20) NOT NULL DEFAULT '',
  `po_rel_id` varchar(20) NOT NULL DEFAULT '',
  `po_rel_action` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`po_id`),
  KEY `index1` (`mb_id`,`po_rel_table`,`po_rel_id`,`po_rel_action`),
  KEY `index2` (`po_expire_date`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_point`
--

LOCK TABLES `g5_point` WRITE;
/*!40000 ALTER TABLE `g5_point` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_point` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_poll`
--

DROP TABLE IF EXISTS `g5_poll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_poll` (
  `po_id` int(11) NOT NULL auto_increment,
  `po_subject` varchar(255) NOT NULL DEFAULT '',
  `po_poll1` varchar(255) NOT NULL DEFAULT '',
  `po_poll2` varchar(255) NOT NULL DEFAULT '',
  `po_poll3` varchar(255) NOT NULL DEFAULT '',
  `po_poll4` varchar(255) NOT NULL DEFAULT '',
  `po_poll5` varchar(255) NOT NULL DEFAULT '',
  `po_poll6` varchar(255) NOT NULL DEFAULT '',
  `po_poll7` varchar(255) NOT NULL DEFAULT '',
  `po_poll8` varchar(255) NOT NULL DEFAULT '',
  `po_poll9` varchar(255) NOT NULL DEFAULT '',
  `po_cnt1` int(11) NOT NULL DEFAULT '0',
  `po_cnt2` int(11) NOT NULL DEFAULT '0',
  `po_cnt3` int(11) NOT NULL DEFAULT '0',
  `po_cnt4` int(11) NOT NULL DEFAULT '0',
  `po_cnt5` int(11) NOT NULL DEFAULT '0',
  `po_cnt6` int(11) NOT NULL DEFAULT '0',
  `po_cnt7` int(11) NOT NULL DEFAULT '0',
  `po_cnt8` int(11) NOT NULL DEFAULT '0',
  `po_cnt9` int(11) NOT NULL DEFAULT '0',
  `po_etc` varchar(255) NOT NULL DEFAULT '',
  `po_level` tinyint(4) NOT NULL DEFAULT '0',
  `po_point` int(11) NOT NULL DEFAULT '0',
  `po_date` date NOT NULL DEFAULT '0000-00-00',
  `po_ips` mediumtext NOT NULL,
  `mb_ids` text NOT NULL,
  PRIMARY KEY  (`po_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_poll`
--

LOCK TABLES `g5_poll` WRITE;
/*!40000 ALTER TABLE `g5_poll` DISABLE KEYS */;
INSERT INTO `g5_poll` VALUES (1,'설문 조사 질문?','답변1','답변2','답변3','답변4','','','','','',1,0,0,0,0,0,0,0,0,'',1,0,'2014-10-25','','admin,');
/*!40000 ALTER TABLE `g5_poll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_poll_etc`
--

DROP TABLE IF EXISTS `g5_poll_etc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_poll_etc` (
  `pc_id` int(11) NOT NULL DEFAULT '0',
  `po_id` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `pc_name` varchar(255) NOT NULL DEFAULT '',
  `pc_idea` varchar(255) NOT NULL DEFAULT '',
  `pc_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`pc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_poll_etc`
--

LOCK TABLES `g5_poll_etc` WRITE;
/*!40000 ALTER TABLE `g5_poll_etc` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_poll_etc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_popular`
--

DROP TABLE IF EXISTS `g5_popular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_popular` (
  `pp_id` int(11) NOT NULL auto_increment,
  `pp_word` varchar(50) NOT NULL DEFAULT '',
  `pp_date` date NOT NULL DEFAULT '0000-00-00',
  `pp_ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY  (`pp_id`),
  UNIQUE KEY `index1` (`pp_date`,`pp_word`,`pp_ip`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_popular`
--

LOCK TABLES `g5_popular` WRITE;
/*!40000 ALTER TABLE `g5_popular` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_popular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_qa_config`
--

DROP TABLE IF EXISTS `g5_qa_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_qa_config` (
  `qa_title` varchar(255) NOT NULL DEFAULT '',
  `qa_category` varchar(255) NOT NULL DEFAULT '',
  `qa_skin` varchar(255) NOT NULL DEFAULT '',
  `qa_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `qa_use_email` tinyint(4) NOT NULL DEFAULT '0',
  `qa_req_email` tinyint(4) NOT NULL DEFAULT '0',
  `qa_use_hp` tinyint(4) NOT NULL DEFAULT '0',
  `qa_req_hp` tinyint(4) NOT NULL DEFAULT '0',
  `qa_use_sms` tinyint(4) NOT NULL DEFAULT '0',
  `qa_send_number` varchar(255) NOT NULL DEFAULT '0',
  `qa_admin_hp` varchar(255) NOT NULL DEFAULT '',
  `qa_admin_email` varchar(255) NOT NULL DEFAULT '',
  `qa_use_editor` tinyint(4) NOT NULL DEFAULT '0',
  `qa_subject_len` int(11) NOT NULL DEFAULT '0',
  `qa_mobile_subject_len` int(11) NOT NULL DEFAULT '0',
  `qa_page_rows` int(11) NOT NULL DEFAULT '0',
  `qa_mobile_page_rows` int(11) NOT NULL DEFAULT '0',
  `qa_image_width` int(11) NOT NULL DEFAULT '0',
  `qa_upload_size` int(11) NOT NULL DEFAULT '0',
  `qa_insert_content` text NOT NULL,
  `qa_include_head` varchar(255) NOT NULL DEFAULT '',
  `qa_include_tail` varchar(255) NOT NULL DEFAULT '',
  `qa_content_head` text NOT NULL,
  `qa_content_tail` text NOT NULL,
  `qa_mobile_content_head` text NOT NULL,
  `qa_mobile_content_tail` text NOT NULL,
  `qa_1_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_2_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_3_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_4_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_5_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_1` varchar(255) NOT NULL DEFAULT '',
  `qa_2` varchar(255) NOT NULL DEFAULT '',
  `qa_3` varchar(255) NOT NULL DEFAULT '',
  `qa_4` varchar(255) NOT NULL DEFAULT '',
  `qa_5` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_qa_config`
--

LOCK TABLES `g5_qa_config` WRITE;
/*!40000 ALTER TABLE `g5_qa_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_qa_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_qa_content`
--

DROP TABLE IF EXISTS `g5_qa_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_qa_content` (
  `qa_id` int(11) NOT NULL auto_increment,
  `qa_num` int(11) NOT NULL DEFAULT '0',
  `qa_parent` int(11) NOT NULL DEFAULT '0',
  `qa_related` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `qa_name` varchar(255) NOT NULL DEFAULT '',
  `qa_email` varchar(255) NOT NULL DEFAULT '',
  `qa_hp` varchar(255) NOT NULL DEFAULT '',
  `qa_type` tinyint(4) NOT NULL DEFAULT '0',
  `qa_category` varchar(255) NOT NULL DEFAULT '',
  `qa_email_recv` tinyint(4) NOT NULL DEFAULT '0',
  `qa_sms_recv` tinyint(4) NOT NULL DEFAULT '0',
  `qa_html` tinyint(4) NOT NULL DEFAULT '0',
  `qa_subject` varchar(255) NOT NULL DEFAULT '',
  `qa_content` text NOT NULL,
  `qa_status` tinyint(4) NOT NULL DEFAULT '0',
  `qa_file1` varchar(255) NOT NULL DEFAULT '',
  `qa_source1` varchar(255) NOT NULL DEFAULT '',
  `qa_file2` varchar(255) NOT NULL DEFAULT '',
  `qa_source2` varchar(255) NOT NULL DEFAULT '',
  `qa_ip` varchar(255) NOT NULL DEFAULT '',
  `qa_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `qa_1` varchar(255) NOT NULL DEFAULT '',
  `qa_2` varchar(255) NOT NULL DEFAULT '',
  `qa_3` varchar(255) NOT NULL DEFAULT '',
  `qa_4` varchar(255) NOT NULL DEFAULT '',
  `qa_5` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`qa_id`),
  KEY `qa_num_parent` (`qa_num`,`qa_parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_qa_content`
--

LOCK TABLES `g5_qa_content` WRITE;
/*!40000 ALTER TABLE `g5_qa_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_qa_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_scrap`
--

DROP TABLE IF EXISTS `g5_scrap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_scrap` (
  `ms_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` varchar(15) NOT NULL DEFAULT '',
  `ms_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`ms_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_scrap`
--

LOCK TABLES `g5_scrap` WRITE;
/*!40000 ALTER TABLE `g5_scrap` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_scrap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_uniqid`
--

DROP TABLE IF EXISTS `g5_uniqid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_uniqid` (
  `uq_id` bigint(20) unsigned NOT NULL,
  `uq_ip` varchar(255) NOT NULL,
  PRIMARY KEY  (`uq_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_uniqid`
--

LOCK TABLES `g5_uniqid` WRITE;
/*!40000 ALTER TABLE `g5_uniqid` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_uniqid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_visit`
--

DROP TABLE IF EXISTS `g5_visit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_visit` (
  `vi_id` int(11) NOT NULL DEFAULT '0',
  `vi_ip` varchar(255) NOT NULL DEFAULT '',
  `vi_date` date NOT NULL DEFAULT '0000-00-00',
  `vi_time` time NOT NULL DEFAULT '00:00:00',
  `vi_referer` text NOT NULL,
  `vi_agent` varchar(255) NOT NULL DEFAULT '',
  `vi_browser` varchar(255) NOT NULL DEFAULT '',
  `vi_os` varchar(255) NOT NULL DEFAULT '',
  `vi_device` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`vi_id`),
  UNIQUE KEY `index1` (`vi_ip`,`vi_date`),
  KEY `index2` (`vi_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_visit`
--

LOCK TABLES `g5_visit` WRITE;
/*!40000 ALTER TABLE `g5_visit` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_visit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_visit_sum`
--

DROP TABLE IF EXISTS `g5_visit_sum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_visit_sum` (
  `vs_date` date NOT NULL DEFAULT '0000-00-00',
  `vs_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`vs_date`),
  KEY `index1` (`vs_count`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_visit_sum`
--

LOCK TABLES `g5_visit_sum` WRITE;
/*!40000 ALTER TABLE `g5_visit_sum` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_visit_sum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_basic_about`
--

DROP TABLE IF EXISTS `g5_write_basic_about`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_basic_about` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_basic_about`
--

LOCK TABLES `g5_write_basic_about` WRITE;
/*!40000 ALTER TABLE `g5_write_basic_about` DISABLE KEYS */;
INSERT INTO `g5_write_basic_about` VALUES (5,-2,'',5,0,0,'','','','소개','여기에 사이트 소개 내용을 입력하십시오.\r\n여기에 사이트 소개 내용을 입력하십시오.\r\n여기에 사이트 소개 내용을 입력하십시오.','','',0,0,9,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-06-20 16:23:29',1,'2017-06-20 16:23:29','127.0.0.1','','','','','','','','','','','','');
INSERT INTO `g5_write_basic_about` VALUES (6,-3,'',6,0,0,'','','','약력','여기에 사이트 소개 내용을 입력하십시오.\r\n여기에 사이트 소개 내용을 입력하십시오.\r\n여기에 사이트 소개 내용을 입력하십시오.','','',0,0,5,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-06-20 16:29:02',1,'2017-06-20 16:29:02','127.0.0.1','','','','','','','','','','','','');
INSERT INTO `g5_write_basic_about` VALUES (7,-4,'',7,0,0,'','','','약도','여기에 사이트 소개 내용을 입력하십시오.\r\n여기에 사이트 소개 내용을 입력하십시오.\r\n여기에 사이트 소개 내용을 입력하십시오.','','',0,0,9,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-06-20 22:42:43',1,'2017-06-20 22:42:43','127.0.0.1','','','시카고, 미국::: +00 1515151515::: test@test.com::: 방문 및 상담을 환영합니다!','41.878114, -87.629798','AIzaSyDFX2xiKdH3unkDcMYb6nFXvJAplGieHE4','','','','','','','');
/*!40000 ALTER TABLE `g5_write_basic_about` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_basic_contact`
--

DROP TABLE IF EXISTS `g5_write_basic_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_basic_contact` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_basic_contact`
--

LOCK TABLES `g5_write_basic_contact` WRITE;
/*!40000 ALTER TABLE `g5_write_basic_contact` DISABLE KEYS */;
INSERT INTO `g5_write_basic_contact` VALUES (22,-11,'',22,0,0,'','','','상담 신청','test5','','',0,0,1,0,0,'','','test5','mhsong@ws21.com','','2017-07-07 23:06:21',0,'2017-07-07 23:06:21','127.0.0.1','','','답변 대기','','','','','1','','','','');
INSERT INTO `g5_write_basic_contact` VALUES (21,-10,'',21,0,0,'','','','test4','test4','','',0,0,0,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 16:24:20',0,'2017-07-04 16:24:20','127.0.0.1','','','답변 대기','','','','','1','','','','');
INSERT INTO `g5_write_basic_contact` VALUES (20,-9,'',20,0,0,'','','','test3','test3','','',0,0,0,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 15:47:06',0,'2017-07-04 15:47:06','127.0.0.1','','','답변 대기','','','','','1','','','','');
INSERT INTO `g5_write_basic_contact` VALUES (19,-8,'',19,0,0,'','','','test2','test2','','',0,0,1,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 04:22:27',0,'2017-07-04 04:22:27','127.0.0.1','','','답변 대기','','','','','1','','','','');
INSERT INTO `g5_write_basic_contact` VALUES (18,-7,'',18,0,0,'','','','테스트','테스트','','',0,0,1,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 03:45:55',0,'2017-07-04 03:45:55','127.0.0.1','','','답변 대기','','','','','1','','','','');
INSERT INTO `g5_write_basic_contact` VALUES (17,-6,'',17,0,0,'','','','상담 신청','테스팅','','',0,0,3,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-06-16 03:31:31',0,'2017-06-16 03:31:31','127.0.0.1','','','답변 대기','','','','','1','','','','');
INSERT INTO `g5_write_basic_contact` VALUES (16,-5,'',16,0,0,'','','','상담 신청','테스팅','','',0,0,2,0,0,'','','테스트6','test@test.com','','2017-06-16 03:26:28',0,'2017-06-16 03:26:28','127.0.0.1','','','답변 대기','','','','','1','','','','');
INSERT INTO `g5_write_basic_contact` VALUES (15,-4,'',15,0,0,'','','','상담 신청','테스팅','','',0,0,1,0,0,'','','테스트5','test@test.com','','2017-06-16 03:20:54',0,'2017-06-16 03:20:54','127.0.0.1','','','답변 대기','','','','','1','','','','');
INSERT INTO `g5_write_basic_contact` VALUES (14,-3,'',14,0,0,'','','','상담 신청','테스팅','','',0,0,1,0,0,'','','테스트4','test@test.com','','2017-06-16 03:17:29',0,'2017-06-16 03:17:29','127.0.0.1','','','답변 대기','','','','','1','','','','');
INSERT INTO `g5_write_basic_contact` VALUES (13,-2,'',13,0,0,'','','','상담 신청','테스팅','','',0,0,0,0,0,'','','테스트2','test@test.com','','2017-06-16 02:59:28',0,'2017-06-16 02:59:28','127.0.0.1','','','답변 대기','','','','','1','','','','');
INSERT INTO `g5_write_basic_contact` VALUES (23,-12,'',23,0,0,'','','','상담 신청','테스트','','',0,0,1,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-20 20:47:54',0,'2017-07-20 20:47:54','127.0.0.1','','','답변 대기','3','2017-07-30 20:00','','','','','','','');
INSERT INTO `g5_write_basic_contact` VALUES (24,-13,'',24,0,0,'','','','상담 신청','포토3 상담','','',0,0,1,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-25 02:49:36',0,'2017-07-25 02:49:36','127.0.0.1','','','답변 대기','','','','','1','','','','');
INSERT INTO `g5_write_basic_contact` VALUES (25,-14,'',25,0,0,'','','','상담 신청','포토3 상담 2','','',0,0,0,0,0,'','','테스트','test@test.com','','2017-07-25 02:54:57',0,'2017-07-25 02:54:57','127.0.0.1','','','답변 대기','','','','','1','','','','');
INSERT INTO `g5_write_basic_contact` VALUES (26,-15,'',26,0,0,'','','','상담 신청','레스토랑 테스트','','',0,0,1,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-25 23:55:04',0,'2017-07-25 23:55:04','127.0.0.1','','','답변 대기','3','2017-08-01 09:00','','','1','','','','');
/*!40000 ALTER TABLE `g5_write_basic_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_basic_gallery`
--

DROP TABLE IF EXISTS `g5_write_basic_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_basic_gallery` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_basic_gallery`
--

LOCK TABLES `g5_write_basic_gallery` WRITE;
/*!40000 ALTER TABLE `g5_write_basic_gallery` DISABLE KEYS */;
INSERT INTO `g5_write_basic_gallery` VALUES (1,-1,'',1,0,0,'','','','갤러리 1','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','','',0,0,5,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 02:21:16',1,'2017-07-04 02:21:16','127.0.0.1','','','','','','','','','','','','');
INSERT INTO `g5_write_basic_gallery` VALUES (2,-2,'',2,0,0,'','','','갤러리 2','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','','',0,0,4,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 02:22:22',1,'2017-07-04 02:22:22','127.0.0.1','','','','','','','','','','','','');
INSERT INTO `g5_write_basic_gallery` VALUES (3,-3,'',3,0,0,'','','','갤러리 3','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','','',0,0,4,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 02:23:10',1,'2017-07-04 02:23:10','127.0.0.1','','','','','','','','','','','','');
INSERT INTO `g5_write_basic_gallery` VALUES (4,-4,'',4,0,0,'','','','갤러리 4','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','','',0,0,4,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 02:24:23',1,'2017-07-04 02:24:23','127.0.0.1','','','','','','','','','','','','');
INSERT INTO `g5_write_basic_gallery` VALUES (5,-5,'',5,0,0,'','','','갤러리 5','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','','',0,0,4,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 02:24:58',1,'2017-07-04 02:24:58','127.0.0.1','','','','','','','','','','','','');
INSERT INTO `g5_write_basic_gallery` VALUES (6,-6,'',6,0,0,'','','','갤러리 6','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','','',0,0,4,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 02:25:39',1,'2017-07-04 02:25:39','127.0.0.1','','','','','','','','','','','','');
INSERT INTO `g5_write_basic_gallery` VALUES (7,-7,'',7,0,0,'','','','갤러리 7','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','','',0,0,4,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 02:26:51',1,'2017-07-04 02:26:51','127.0.0.1','','','','','','','','','','','','');
INSERT INTO `g5_write_basic_gallery` VALUES (8,-8,'',8,0,0,'','','','갤러리 8','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','','',0,0,6,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 02:27:19',1,'2017-07-04 02:27:19','127.0.0.1','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_basic_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_basic_main_banner`
--

DROP TABLE IF EXISTS `g5_write_basic_main_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_basic_main_banner` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_basic_main_banner`
--

LOCK TABLES `g5_write_basic_main_banner` WRITE;
/*!40000 ALTER TABLE `g5_write_basic_main_banner` DISABLE KEYS */;
INSERT INTO `g5_write_basic_main_banner` VALUES (1,-1,'',1,0,0,'','','','베이직','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','','',0,0,10,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-27 20:46:58',1,'2017-07-27 20:46:58','127.0.0.1','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_basic_main_banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_basic_service`
--

DROP TABLE IF EXISTS `g5_write_basic_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_basic_service` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_basic_service`
--

LOCK TABLES `g5_write_basic_service` WRITE;
/*!40000 ALTER TABLE `g5_write_basic_service` DISABLE KEYS */;
INSERT INTO `g5_write_basic_service` VALUES (1,-1,'',1,0,0,'','','','서비스 1','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','','',0,0,5,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 17:45:57',1,'2017-07-04 17:45:57','127.0.0.1','','','','','','','','','','','','');
INSERT INTO `g5_write_basic_service` VALUES (2,-2,'',2,0,0,'','','','서비스 2','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','','',0,0,4,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 17:50:16',1,'2017-07-04 17:50:16','127.0.0.1','','','','','','','','','','','','');
INSERT INTO `g5_write_basic_service` VALUES (3,-3,'',3,0,0,'','','','서비스 3','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','','',0,0,3,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 17:51:08',1,'2017-07-04 17:51:08','127.0.0.1','','','','','','','','','','','','');
INSERT INTO `g5_write_basic_service` VALUES (4,-4,'',4,0,0,'','','','서비스 4','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','','',0,0,3,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-04 17:51:34',1,'2017-07-04 17:51:34','127.0.0.1','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_basic_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_blog`
--

DROP TABLE IF EXISTS `g5_write_blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_blog` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_blog`
--

LOCK TABLES `g5_write_blog` WRITE;
/*!40000 ALTER TABLE `g5_write_blog` DISABLE KEYS */;
INSERT INTO `g5_write_blog` VALUES (1,-1,'',1,0,0,'','','html1','블로그 글1입니다','블로그 글1입니다. 아래에는 적절한 폭의 이미지들을 배치할 수 있습니다. 이미지들은 첨부 화일로 올리면 되며,\r\n여러 개를 출력할 수도 있습니다. 이미지 출력 갯수는 num_of_images 값을 조정하면 됩니다.','','',0,0,'',15,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2013-05-25 19:14:14',1,'2013-05-25 19:14:14','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_blog` VALUES (2,-2,'',2,0,0,'','','html1','블로그 글2입니다','블로그 글2입니다. 아래에는 적절한 폭의 이미지들을 배치할 수 있습니다. 이미지들은 첨부 화일로 올리면 되며,\r\n여러 개를 출력할 수도 있습니다. 이미지 출력 갯수는 num_of_images 값을 조정하면 됩니다.','','',0,0,'',30,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2013-07-17 01:36:08',1,'2013-07-17 01:36:08','127.0.0.1','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_builder`
--

DROP TABLE IF EXISTS `g5_write_builder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_builder` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_me2day_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_builder`
--

LOCK TABLES `g5_write_builder` WRITE;
/*!40000 ALTER TABLE `g5_write_builder` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_builder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_callcenter`
--

DROP TABLE IF EXISTS `g5_write_callcenter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_callcenter` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL DEFAULT '',
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL DEFAULT '',
  `ca_name` varchar(255) NOT NULL DEFAULT '',
  `wr_option` set('html1','html2','secret','mail') NOT NULL DEFAULT '',
  `wr_subject` varchar(255) NOT NULL DEFAULT '',
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL DEFAULT '',
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `wr_password` varchar(255) NOT NULL DEFAULT '',
  `wr_name` varchar(255) NOT NULL DEFAULT '',
  `wr_email` varchar(255) NOT NULL DEFAULT '',
  `wr_homepage` varchar(255) NOT NULL DEFAULT '',
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL DEFAULT '',
  `wr_ip` varchar(255) NOT NULL DEFAULT '',
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL DEFAULT '',
  `wr_2` varchar(255) NOT NULL DEFAULT '',
  `wr_3` varchar(255) NOT NULL DEFAULT '',
  `wr_4` varchar(255) NOT NULL DEFAULT '',
  `wr_5` varchar(255) NOT NULL DEFAULT '',
  `wr_6` varchar(255) NOT NULL DEFAULT '',
  `wr_7` varchar(255) NOT NULL DEFAULT '',
  `wr_8` varchar(255) NOT NULL DEFAULT '',
  `wr_9` varchar(255) NOT NULL DEFAULT '',
  `wr_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_callcenter`
--

LOCK TABLES `g5_write_callcenter` WRITE;
/*!40000 ALTER TABLE `g5_write_callcenter` DISABLE KEYS */;
INSERT INTO `g5_write_callcenter` VALUES (1,-1,'',1,0,0,'','','html1','콜 센터','이미지에 전화 번호 등을 적어 업로드 하십시요.','','',0,0,'',19,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2013-06-09 00:13:00',1,'2013-06-09 00:13:00','127.0.0.1','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_callcenter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_faq`
--

DROP TABLE IF EXISTS `g5_write_faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_faq` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_faq`
--

LOCK TABLES `g5_write_faq` WRITE;
/*!40000 ALTER TABLE `g5_write_faq` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_free`
--

DROP TABLE IF EXISTS `g5_write_free`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_free` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`),
  KEY `wr_datetime` (`wr_datetime`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_free`
--

LOCK TABLES `g5_write_free` WRITE;
/*!40000 ALTER TABLE `g5_write_free` DISABLE KEYS */;
INSERT INTO `g5_write_free` VALUES (1,-1,'',1,0,0,'','','','자유 게시판입니다','자유 게시판입니다.','','',0,0,'',4,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2013-05-25 03:07:30',0,'2013-05-25 03:07:30','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_free` VALUES (2,-2,'',2,0,0,'','','','자유 게시판입니다','자유 게시판입니다.','','',0,0,'',10,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2013-05-28 22:54:15',0,'2013-05-28 22:54:15','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_free` VALUES (3,-3,'',3,0,0,'','','','자유 게시판입니다','자유 게시판입니다.','','',0,0,'',27,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2013-05-28 22:54:33',0,'2013-05-28 22:54:33','127.0.0.1','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_free` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_gallery0`
--

DROP TABLE IF EXISTS `g5_write_gallery0`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_gallery0` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_gallery0`
--

LOCK TABLES `g5_write_gallery0` WRITE;
/*!40000 ALTER TABLE `g5_write_gallery0` DISABLE KEYS */;
INSERT INTO `g5_write_gallery0` VALUES (1,-1,'',1,0,0,'','','html1','상단 헤더 이미지','상단 헤더 이미지<br>','','',0,0,'',10,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2013-05-25 01:25:33',1,'2013-05-25 01:25:33','127.0.0.1','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_gallery0` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_gallery1`
--

DROP TABLE IF EXISTS `g5_write_gallery1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_gallery1` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_gallery1`
--

LOCK TABLES `g5_write_gallery1` WRITE;
/*!40000 ALTER TABLE `g5_write_gallery1` DISABLE KEYS */;
INSERT INTO `g5_write_gallery1` VALUES (1,-1,'',1,0,0,'','','','갤러리 이미지','이미지와 관련된 설명을 여기에 적어 넣으십시요.\r\n이미지와 관련된 설명을 여기에 적어 넣으십시요.','','',0,0,'',13,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@domain.com','','2013-05-25 19:34:06',1,'2013-05-25 19:34:06','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_gallery1` VALUES (2,-2,'',2,0,0,'','','','갤러리 이미지','이미지와 관련된 설명을 여기에 적어 넣으십시요.\r\n이미지와 관련된 설명을 여기에 적어 넣으십시요.','','',0,0,'',12,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@domain.com','','2013-05-25 19:35:25',1,'2013-05-25 19:35:25','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_gallery1` VALUES (3,-3,'',3,0,0,'','','','갤러리 이미지','이미지와 관련된 설명을 여기에 적어 넣으십시요.\r\n이미지와 관련된 설명을 여기에 적어 넣으십시요.','','',0,0,'',19,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@domain.com','','2013-05-25 19:35:47',1,'2013-05-25 19:35:47','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_gallery1` VALUES (4,-4,'',4,0,0,'','','','갤러리 이미지','이미지와 관련된 설명을 여기에 적어 넣으십시요.\r\n이미지와 관련된 설명을 여기에 적어 넣으십시요.','','',0,0,'',10,0,0,'admin','4d9436990dd66a11','최고관리자','admin@domain.com','','2013-09-08 01:24:30',1,'2013-09-08 01:24:30','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_gallery1` VALUES (5,-5,'',5,0,0,'','','','갤러리 이미지','이미지와 관련된 설명을 여기에 적어 넣으십시요.\r\n이미지와 관련된 설명을 여기에 적어 넣으십시요.','','',0,0,'',2,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2016-05-10 02:05:26',1,'2016-05-10 02:05:26','127.0.0.1','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_gallery1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_gallery2`
--

DROP TABLE IF EXISTS `g5_write_gallery2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_gallery2` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_gallery2`
--

LOCK TABLES `g5_write_gallery2` WRITE;
/*!40000 ALTER TABLE `g5_write_gallery2` DISABLE KEYS */;
INSERT INTO `g5_write_gallery2` VALUES (1,-1,'',1,0,0,'','여행','html1','테스트1','정해진 문자 갯수를 초과하지 않는 경우의 예입니다. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 정해진 문자 갯수를 초과하지 않는 경우의 예입니다. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요.','','',0,0,'',12,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@domain.com','','2013-05-25 19:36:37',1,'2013-05-25 19:36:37','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_gallery2` VALUES (2,-2,'',2,0,0,'','취미','html1','테스트2','정해진 문자 갯수를 초과하는 경우의 예입니다. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 정해진 문자 갯수를 초과하는 경우의 예입니다. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요.','','',0,0,'',19,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@domain.com','','2013-05-25 19:37:49',1,'2013-05-25 19:37:49','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_gallery2` VALUES (4,-3,'',4,0,0,'','유머','html1','테스트3','정해진 문자 갯수를 초과하는 경우의 예입니다. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어\r\n 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 정해진 문자 갯수를\r\n 초과하는 경우의 예입니다. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. \r\n이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요.','','',0,0,'',7,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@domain.com','','2013-08-06 00:02:51',1,'2013-08-06 00:02:51','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_gallery2` VALUES (5,-4,'',5,0,0,'','여행','html1','테스트4','정해진 문자 갯수를 초과하는 경우의 예입니다. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어\r\n 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 정해진 문자 갯수를\r\n 초과하는 경우의 예입니다. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. \r\n이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요.','','',0,0,'',1,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2016-05-12 00:19:06',1,'2016-05-12 00:19:06','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_gallery2` VALUES (6,-5,'',6,0,0,'','기타','html1','테스트5','정해진 문자 갯수를 초과하는 경우의 예입니다. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어\r\n 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 정해진 문자 갯수를\r\n 초과하는 경우의 예입니다. 이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요. \r\n이미지와 관련된 설명을 여기에 적어 넣으십시요. 이미지와 관련된 설명을 여기에 적어 넣으십시요.','','',0,0,'',1,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2016-05-12 00:20:49',1,'2016-05-12 00:20:49','127.0.0.1','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_gallery2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_gallery_ad`
--

DROP TABLE IF EXISTS `g5_write_gallery_ad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_gallery_ad` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_gallery_ad`
--

LOCK TABLES `g5_write_gallery_ad` WRITE;
/*!40000 ALTER TABLE `g5_write_gallery_ad` DISABLE KEYS */;
INSERT INTO `g5_write_gallery_ad` VALUES (1,-1,'',6,0,0,'','','','배너 샘플','http://www.goodbuilder.co.kr','','',0,0,'',5,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2012-11-09 00:12:04',1,'2012-11-09 00:12:04','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_gallery_ad` VALUES (2,-2,'',7,0,0,'','','','배너 샘플','http://www.goodbuilder.co.kr','','',0,0,'',8,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2012-11-09 00:41:52',1,'2012-11-09 00:41:52','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_gallery_ad` VALUES (3,-3,'',3,0,0,'','','','배너 샘플','http://www.goodbuilder.co.kr','','',0,0,'',8,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2013-05-29 03:33:40',1,'2013-05-29 03:33:40','127.0.0.1','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_gallery_ad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_gallery_main_ad`
--

DROP TABLE IF EXISTS `g5_write_gallery_main_ad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_gallery_main_ad` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_gallery_main_ad`
--

LOCK TABLES `g5_write_gallery_main_ad` WRITE;
/*!40000 ALTER TABLE `g5_write_gallery_main_ad` DISABLE KEYS */;
INSERT INTO `g5_write_gallery_main_ad` VALUES (1,-1,'',1,0,0,'','','','메인 광고1','메인 광고1','https://www.youtube.com/embed/ORBrnyuMhjI','',0,0,'',23,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@domain.com','','2013-01-10 01:51:54',1,'2013-01-10 01:51:54','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_gallery_main_ad` VALUES (2,-2,'',2,0,0,'','','','메인 광고2','메인 광고2\r\n\r\n* basic_video 템플릿을 이용하여 동영상을 링크하고자 하는 경우 링크#1에 (현재 유튜브만 지원)\r\nhttp://www.youtube.com/embed/영상번호\r\n(영상번호는 v 값)','https://www.youtube.com/embed/xaHh756BOR0','',0,0,'',12,0,0,'admin','7f65a30860dac8d0','최고관리자','admin@domain.com','','2014-12-16 23:49:54',1,'2014-12-16 23:49:54','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_gallery_main_ad` VALUES (3,-3,'',3,0,0,'','','','메인 광고3','메인 광고3','https://www.youtube.com/embed/ORBrnyuMhjI','',0,0,'',4,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2016-05-07 03:31:46',1,'2016-05-07 03:31:46','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_gallery_main_ad` VALUES (4,-4,'',4,0,0,'','','','메인 광고4','메인 광고4','https://www.youtube.com/embed/xaHh756BOR0','',0,0,'',4,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2016-05-07 03:36:16',1,'2016-05-07 03:36:16','127.0.0.1','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_gallery_main_ad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_intro`
--

DROP TABLE IF EXISTS `g5_write_intro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_intro` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_intro`
--

LOCK TABLES `g5_write_intro` WRITE;
/*!40000 ALTER TABLE `g5_write_intro` DISABLE KEYS */;
INSERT INTO `g5_write_intro` VALUES (1,-1,'',1,0,0,'','','html1','인사말','<p>\r\n						저희 사이트를 방문해 주셔서 감사합니다.</p>','','',0,0,'',47,0,0,'admin','12d0346b4847233f','최고관리자','admin@localhost.localdomain','','2011-04-08 21:07:01',1,'2011-04-08 21:07:01','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_intro` VALUES (2,-2,'',2,0,0,'','','html1','연혁','<h3>2014년</h3>\r\n					<p>\r\n					사이트 운영\r\n					</p>\r\n					<h3>2013년</h3>\r\n					<p>\r\n					사이트 오픈\r\n					</p>','','',0,0,'',56,0,0,'admin','12d0346b4847233f','최고관리자','admin@localhost.localdomain','','2011-04-08 21:07:25',1,'2011-04-08 21:07:25','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_intro` VALUES (3,-3,'',3,0,0,'','','html1','약력','<h3>2014년~현재</h3>\r\n					<p>약력2</p>\r\n					<h3>2013년</h3>\r\n					<p>약력1</p>','','',0,0,'',4,0,0,'admin','4d9436990dd66a11','최고관리자','admin@localhost.localdomain','','2014-05-06 21:49:39',1,'2014-05-06 21:49:39','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_intro` VALUES (4,-4,'',4,0,0,'','','html1','오시는 길','약도','','',0,0,'',8,0,0,'admin','4d9436990dd66a11','최고관리자','admin@localhost.localdomain','','2014-05-06 21:51:38',1,'2014-05-06 21:51:38','127.0.0.1','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_intro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_main_banner`
--

DROP TABLE IF EXISTS `g5_write_main_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_main_banner` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_me2day_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_main_banner`
--

LOCK TABLES `g5_write_main_banner` WRITE;
/*!40000 ALTER TABLE `g5_write_main_banner` DISABLE KEYS */;
INSERT INTO `g5_write_main_banner` VALUES (1,-1,'',1,0,0,'','','html1','메인 배너1','메인 배너1<br>','http://www.goodbuilder.co.kr','',0,0,'',5,0,0,'admin','4d9436990dd66a11','최고관리자','admin@localhost.localdomain','','2014-05-04 03:08:56',1,'2014-05-04 03:08:56','127.0.0.1','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_main_banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_notice`
--

DROP TABLE IF EXISTS `g5_write_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_notice` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_notice`
--

LOCK TABLES `g5_write_notice` WRITE;
/*!40000 ALTER TABLE `g5_write_notice` DISABLE KEYS */;
INSERT INTO `g5_write_notice` VALUES (1,-1,'',1,0,0,'','','html1','공지 사항입니다','공지 사항입니다.<br>','','',0,0,'',13,0,0,'admin','12d0346b4847233f','최고관리자','admin@localhost.localdomain','','2012-09-04 01:03:23',0,'2012-09-04 01:03:23','127.0.0.1','','','','','2','','','','','','','','');
INSERT INTO `g5_write_notice` VALUES (5,-3,'',5,0,0,'','','html1','공지 사항입니다','공지 사항입니다.\r\n<br>\r\n<br>팝업 창을 사용하지 않으려면\r\n<br>공지 사항 게시판에서 \'팝업\' 표시된 게시물의\r\n<br>\'팝업 사용 여부\'를 \'사용하지 않음\'으로 체크해 주시면 됩니다.\r\n<br>\r\n<br>감사합니다.','','',0,0,'',27,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2013-05-28 22:53:35',0,'2013-05-28 22:53:35','127.0.0.1','','','','','2','','','','','','','','');
INSERT INTO `g5_write_notice` VALUES (4,-2,'',4,0,0,'','','html1','공지 사항입니다','공지 사항입니다.<br>','','',0,0,'',4,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2013-05-28 22:53:07',0,'2013-05-28 22:53:07','127.0.0.1','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_qa`
--

DROP TABLE IF EXISTS `g5_write_qa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_qa` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_me2day_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_qa`
--

LOCK TABLES `g5_write_qa` WRITE;
/*!40000 ALTER TABLE `g5_write_qa` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_qa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_qna`
--

DROP TABLE IF EXISTS `g5_write_qna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_qna` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_qna`
--

LOCK TABLES `g5_write_qna` WRITE;
/*!40000 ALTER TABLE `g5_write_qna` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_qna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_request`
--

DROP TABLE IF EXISTS `g5_write_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_request` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_request`
--

LOCK TABLES `g5_write_request` WRITE;
/*!40000 ALTER TABLE `g5_write_request` DISABLE KEYS */;
INSERT INTO `g5_write_request` VALUES (1,-1,'',1,0,0,'','','','상담 요청입니다','상담 요청입니다.','','',0,0,'',4,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2013-05-25 03:08:20',0,'2013-05-25 03:08:20','127.0.0.1','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_service`
--

DROP TABLE IF EXISTS `g5_write_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_service` (
  `wr_id` int(11) NOT NULL auto_increment,
  `wr_num` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT '0',
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
  `wr_comment` int(11) NOT NULL DEFAULT '0',
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
  `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
  `wr_trackback` varchar(255) NOT NULL,
  `wr_hit` int(11) NOT NULL DEFAULT '0',
  `wr_good` int(11) NOT NULL DEFAULT '0',
  `wr_nogood` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_file` tinyint(4) NOT NULL DEFAULT '0',
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_me2day_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY  (`wr_id`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_service`
--

LOCK TABLES `g5_write_service` WRITE;
/*!40000 ALTER TABLE `g5_write_service` DISABLE KEYS */;
INSERT INTO `g5_write_service` VALUES (1,-1,'',1,0,0,'','','html1','서비스 내용1','서비스 내용1<br>','','',0,0,'',14,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2012-10-10 01:51:05',1,'2012-10-10 01:51:05','127.0.0.1','','','','','','','','','','','','','');
INSERT INTO `g5_write_service` VALUES (2,-2,'',2,0,0,'','','html1','서비스 내용2','서비스 내용2<br>','','',0,0,'',31,0,0,'admin','074b36bc18ae7bb3','최고관리자','admin@localhost.localdomain','','2012-10-10 01:51:53',1,'2012-10-10 01:51:53','127.0.0.1','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_zip`
--

DROP TABLE IF EXISTS `g5_zip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_zip` (
  `zp_id` int(11) NOT NULL DEFAULT '0',
  `zp_code` varchar(6) NOT NULL DEFAULT '',
  `zp_sido` varchar(4) NOT NULL DEFAULT '',
  `zp_gugun` varchar(20) NOT NULL DEFAULT '',
  `zp_dong` varchar(50) NOT NULL DEFAULT '',
  `zp_bunji` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY  (`zp_id`),
  KEY `zp_code` (`zp_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_zip`
--

LOCK TABLES `g5_zip` WRITE;
/*!40000 ALTER TABLE `g5_zip` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_zip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms5_book`
--

DROP TABLE IF EXISTS `sms5_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms5_book` (
  `bk_no` int(11) NOT NULL auto_increment,
  `bg_no` int(11) NOT NULL DEFAULT '0',
  `mb_no` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `bk_name` varchar(255) NOT NULL DEFAULT '',
  `bk_hp` varchar(255) NOT NULL DEFAULT '',
  `bk_receipt` tinyint(4) NOT NULL DEFAULT '0',
  `bk_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bk_memo` text NOT NULL,
  PRIMARY KEY  (`bk_no`),
  KEY `bk_name` (`bk_name`),
  KEY `bk_hp` (`bk_hp`),
  KEY `mb_no` (`mb_no`),
  KEY `bg_no` (`bg_no`,`bk_no`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms5_book`
--

LOCK TABLES `sms5_book` WRITE;
/*!40000 ALTER TABLE `sms5_book` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms5_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms5_book_group`
--

DROP TABLE IF EXISTS `sms5_book_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms5_book_group` (
  `bg_no` int(11) NOT NULL auto_increment,
  `bg_name` varchar(255) NOT NULL DEFAULT '',
  `bg_count` int(11) NOT NULL DEFAULT '0',
  `bg_member` int(11) NOT NULL DEFAULT '0',
  `bg_nomember` int(11) NOT NULL DEFAULT '0',
  `bg_receipt` int(11) NOT NULL DEFAULT '0',
  `bg_reject` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`bg_no`),
  KEY `bg_name` (`bg_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms5_book_group`
--

LOCK TABLES `sms5_book_group` WRITE;
/*!40000 ALTER TABLE `sms5_book_group` DISABLE KEYS */;
INSERT INTO `sms5_book_group` VALUES (1,'미분류',0,0,0,0,0);
/*!40000 ALTER TABLE `sms5_book_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms5_config`
--

DROP TABLE IF EXISTS `sms5_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms5_config` (
  `cf_phone` varchar(255) NOT NULL DEFAULT '',
  `cf_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cf_member` tinyint(4) NOT NULL DEFAULT '1',
  `cf_level` tinyint(4) NOT NULL DEFAULT '2',
  `cf_point` int(11) NOT NULL DEFAULT '0',
  `cf_day_count` int(11) NOT NULL DEFAULT '0',
  `cf_skin` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms5_config`
--

LOCK TABLES `sms5_config` WRITE;
/*!40000 ALTER TABLE `sms5_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms5_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms5_form`
--

DROP TABLE IF EXISTS `sms5_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms5_form` (
  `fo_no` int(11) NOT NULL auto_increment,
  `fg_no` tinyint(4) NOT NULL DEFAULT '0',
  `fg_member` char(1) NOT NULL DEFAULT '0',
  `fo_name` varchar(255) NOT NULL DEFAULT '',
  `fo_content` text NOT NULL,
  `fo_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`fo_no`),
  KEY `fg_no` (`fg_no`,`fo_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms5_form`
--

LOCK TABLES `sms5_form` WRITE;
/*!40000 ALTER TABLE `sms5_form` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms5_form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms5_form_group`
--

DROP TABLE IF EXISTS `sms5_form_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms5_form_group` (
  `fg_no` int(11) NOT NULL auto_increment,
  `fg_name` varchar(255) NOT NULL DEFAULT '',
  `fg_count` int(11) NOT NULL DEFAULT '0',
  `fg_member` tinyint(4) NOT NULL,
  PRIMARY KEY  (`fg_no`),
  KEY `fg_name` (`fg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms5_form_group`
--

LOCK TABLES `sms5_form_group` WRITE;
/*!40000 ALTER TABLE `sms5_form_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms5_form_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms5_history`
--

DROP TABLE IF EXISTS `sms5_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms5_history` (
  `hs_no` int(11) NOT NULL auto_increment,
  `wr_no` int(11) NOT NULL DEFAULT '0',
  `wr_renum` int(11) NOT NULL DEFAULT '0',
  `bg_no` int(11) NOT NULL DEFAULT '0',
  `mb_no` int(11) NOT NULL DEFAULT '0',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `bk_no` int(11) NOT NULL DEFAULT '0',
  `hs_name` varchar(30) NOT NULL DEFAULT '',
  `hs_hp` varchar(255) NOT NULL DEFAULT '',
  `hs_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hs_flag` tinyint(4) NOT NULL DEFAULT '0',
  `hs_code` varchar(255) NOT NULL DEFAULT '',
  `hs_memo` varchar(255) NOT NULL DEFAULT '',
  `hs_log` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`hs_no`),
  KEY `wr_no` (`wr_no`),
  KEY `mb_no` (`mb_no`),
  KEY `bk_no` (`bk_no`),
  KEY `hs_hp` (`hs_hp`),
  KEY `hs_code` (`hs_code`),
  KEY `bg_no` (`bg_no`),
  KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms5_history`
--

LOCK TABLES `sms5_history` WRITE;
/*!40000 ALTER TABLE `sms5_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms5_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms5_member_history`
--

DROP TABLE IF EXISTS `sms5_member_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms5_member_history` (
  `mh_no` int(11) NOT NULL auto_increment,
  `mb_id` varchar(30) NOT NULL,
  `mh_reply` varchar(30) NOT NULL,
  `mh_hp` varchar(30) NOT NULL,
  `mh_datetime` datetime NOT NULL,
  `mh_booking` datetime NOT NULL,
  `mh_log` varchar(255) NOT NULL,
  `mh_ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`mh_no`),
  KEY `mb_id` (`mb_id`,`mh_datetime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms5_member_history`
--

LOCK TABLES `sms5_member_history` WRITE;
/*!40000 ALTER TABLE `sms5_member_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms5_member_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms5_write`
--

DROP TABLE IF EXISTS `sms5_write`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms5_write` (
  `wr_no` int(11) NOT NULL DEFAULT '1',
  `wr_renum` int(11) NOT NULL DEFAULT '0',
  `wr_reply` varchar(255) NOT NULL DEFAULT '',
  `wr_message` varchar(255) NOT NULL DEFAULT '',
  `wr_booking` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_total` int(11) NOT NULL DEFAULT '0',
  `wr_re_total` int(11) NOT NULL DEFAULT '0',
  `wr_success` int(11) NOT NULL DEFAULT '0',
  `wr_failure` int(11) NOT NULL DEFAULT '0',
  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wr_memo` text NOT NULL,
  KEY `wr_no` (`wr_no`,`wr_renum`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms5_write`
--

LOCK TABLES `sms5_write` WRITE;
/*!40000 ALTER TABLE `sms5_write` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms5_write` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-02  3:59:04
