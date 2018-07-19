INSERT INTO `g5_board` VALUES ('shop_basic_main','board','메인 배너','','',1,1,10,10,10,10,1,10,10,0,1,1,0,0,0,0,0,'','',0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,100,60,15,24,100,600,'r_good_basic','','','_head.php','_tail.php','','','',4,5000000,1,1,0,1,0,0,0,0,0,'',10,0,'','','','','','','','','','','','','','','','','','','','','w3_shop_basic',100,50,10,300,'basic','../_head.php','../_tail.php','','',1,1,5,'g4m_basic',0,0,50,'basic',0,'both',30,15,'basic','','',174,124,0,125,100,0,0,'',0,'');

INSERT INTO `g5_board_file` VALUES ('shop_basic_main',1,0,'3m2lrpvtlwa_607932.1024.jpg','2130706433_ZKGj5tuq_75c8fee9f3a9a8c4ac6396acf5b6bc8499935eff.jpg','0','',48522,1024,731,2,'2017-11-10 02:43:28');

--
-- Table structure for table `g5_write_shop_basic_main`
--

DROP TABLE IF EXISTS `g5_write_shop_basic_main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_shop_basic_main` (
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
-- Dumping data for table `g5_write_shop_basic_main`
--

LOCK TABLES `g5_write_shop_basic_main` WRITE;
/*!40000 ALTER TABLE `g5_write_shop_basic_main` DISABLE KEYS */;
INSERT INTO `g5_write_shop_basic_main` VALUES (1,-1,'',1,0,0,'','','','베이직','여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.\r\n여기에 내용을 입력하십시오.','https://www.youtube.com/embed/xaHh756BOR0','',0,0,12,0,0,'admin','03ad9a9a6aab2f5c','최고관리자','admin@domain.com','','2017-07-27 20:46:58',1,'2017-07-27 20:46:58','127.0.0.1','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_shop_basic_main` ENABLE KEYS */;
UNLOCK TABLES;
