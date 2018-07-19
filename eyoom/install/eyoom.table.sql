-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_respond`
--

DROP TABLE IF EXISTS `g5_eyoom_respond`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_respond` (
  `rid` int(11) NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL default '',
  `pr_id` mediumint(11) NOT NULL,
  `wr_id` int(11) NOT NULL default '0',
  `wr_cmt` int(11) NOT NULL default '0',
  `wr_subject` varchar(255) NOT NULL default '',
  `wr_mb_id` varchar(20) NOT NULL,
  `mb_id` varchar(20) NOT NULL,
  `mb_name` varchar(255) NOT NULL,
  `re_cnt` mediumint(3) NOT NULL default '0',
  `re_type` varchar(20) NOT NULL,
  `re_chk` tinyint(4) NOT NULL default '0',
  `regdt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`rid`),
  KEY `mb_id` (`wr_mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_member`
--

DROP TABLE IF EXISTS `g5_eyoom_member`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_member` (
  `mb_id` varchar(30) NOT NULL,
  `level` mediumint(5) NOT NULL default '1',
  `level_point` mediumint(11) NOT NULL default '0',
  `photo` varchar(100) NOT NULL,
  `myhome_cover` varchar(100) NOT NULL,
  `main_index` enum('index','mypage','myhome','shop') NOT NULL default 'index',
  `mypage_main` enum('respond','timeline','favorite','followinggul') NOT NULL default 'respond',
  `myhome_hit` mediumint(11) NOT NULL default '0',
  `open_page` enum('y','n') NOT NULL default 'y',
  `respond` mediumint(5) NOT NULL default '0',
  `onoff_push` enum('on','off') NOT NULL default 'on',
  `onoff_push_respond` enum('on','off') NOT NULL default 'on',
  `onoff_push_memo` enum('on','off') NOT NULL default 'on',
  `onoff_push_social` enum('on','off') NOT NULL default 'on',
  `onoff_push_likes` enum('on','off') NOT NULL default 'on',
  `onoff_push_guest` enum('on','off') NOT NULL default 'on',
  `onoff_social` enum('on','off') NOT NULL default 'on',
  `open_email` enum('y','n') NOT NULL default 'y',
  `open_homepage` enum('y','n') NOT NULL default 'y',
  `open_tel` enum('y','n') NOT NULL default 'y',
  `open_hp` enum('y','n') NOT NULL default 'y',
  `view_timeline` char(1) NOT NULL default '1',
  `view_favorite` char(1) NOT NULL default '1',
  `view_followinggul` char(1) NOT NULL default '1',
  `favorite` text NOT NULL,
  `following` longtext NOT NULL,
  `follower` longtext NOT NULL,
  `likes` longtext NOT NULL,
  UNIQUE KEY `mb_id` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_new`
--

DROP TABLE IF EXISTS `g5_eyoom_new`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_new` (
  `bn_id` int(11) NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL default '',
  `pr_id` int(10) NOT NULL,
  `wr_id` int(11) NOT NULL default '0',
  `wr_parent` int(11) NOT NULL default '0',
  `ca_name` varchar(255) NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_content` text NOT NULL,
  `wr_image` text NOT NULL,
  `wr_video` text NOT NULL,
  `wr_sound` text NOT NULL,
  `wr_comment` int(11) NOT NULL default '0',
  `wr_hit` int(11) NOT NULL default '0',
  `wr_good` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL default '',
  `mb_name` varchar(50) NOT NULL,
  `mb_nick` varchar(50) NOT NULL,
  `mb_level` varchar(255) NOT NULL,
  `bn_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
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
  PRIMARY KEY  (`bn_id`),
  KEY `mb_id` (`mb_id`),
  KEY `wr_hit` (`wr_hit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_banner`
--

DROP TABLE IF EXISTS `g5_eyoom_banner`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_banner` (
  `bn_no` int(10) unsigned NOT NULL auto_increment,
  `bn_type` enum('intra','extra') NOT NULL default 'intra',
  `bn_location` mediumint(3) NOT NULL default '0',
  `bn_link` text,
  `bn_img` varchar(100) NOT NULL default '',
  `bn_target` varchar(20) NOT NULL default '',
  `bn_code` text NOT NULL,
  `bn_sort` int(10) default '0',
  `bn_theme` varchar(30) NOT NULL default 'default',
  `bn_state` smallint(1) NOT NULL default '0',
  `bn_period` char(1) NOT NULL default '1',
  `bn_start` varchar(10) NOT NULL,
  `bn_end` varchar(10) NOT NULL,
  `bn_exposed` mediumint(10) NOT NULL default '0',
  `bn_clicked` mediumint(10) NOT NULL default '0',
  `bn_view_level` tinyint(4) NOT NULL default '1',
  `bn_regdt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`bn_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_activity`
--

DROP TABLE IF EXISTS `g5_eyoom_activity`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_activity` (
  `act_id` mediumint(11) unsigned NOT NULL auto_increment,
  `mb_id` varchar(40) NOT NULL,
  `act_type` varchar(20) NOT NULL,
  `act_contents` text NOT NULL,
  `act_image` text NOT NULL,
  `act_regdt` datetime NOT NULL,
  PRIMARY KEY  (`act_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_board`
--

DROP TABLE IF EXISTS `g5_eyoom_board`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_board` (
  `bo_id` mediumint(11) unsigned NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL,
  `gr_id` varchar(10) NOT NULL,
  `bo_theme` varchar(50) NOT NULL,
  `bo_skin` varchar(40) NOT NULL,
  `use_gnu_skin` enum('y','n') NOT NULL default 'n',
  `bo_use_profile_photo` char(1) NOT NULL default '1',
  `bo_sel_date_type` enum('1','2') NOT NULL default '1',
  `bo_use_hotgul` char(1) NOT NULL default '0',
  `bo_use_anonymous` char(1) NOT NULL default '0',
  `bo_use_infinite_scroll` char(1) NOT NULL default '0',
  `bo_use_cmt_best` char(1) NOT NULL default '0',
  `bo_use_point_explain` char(1) NOT NULL default '0',
  `bo_use_video_photo` char(1) NOT NULL default '0',
  `bo_use_list_image` char(1) NOT NULL default '1',
  `bo_use_yellow_card` char(1) NOT NULL default '0',
  `bo_use_exif` char(1) NOT NULL default '0',
  `bo_use_rating` char(1) NOT NULL default '0',
  `bo_use_rating_list` char(1) NOT NULL default '0',
  `bo_use_tag` char(1) NOT NULL default '0',
  `bo_use_automove` char(1) NOT NULL default '0',
  `bo_use_addon_emoticon` char(1) NOT NULL default '1',
  `bo_use_addon_video` char(1) NOT NULL default '1',
  `bo_use_addon_coding` char(1) NOT NULL default '0',
  `bo_use_addon_soundcloud` char(1) NOT NULL default '0',
  `bo_use_addon_map` char(1) NOT NULL default '0',
  `bo_use_addon_cmtimg` char(1) NOT NULL default '1',
  `bo_use_extimg` char(1) NOT NULL default '0',
  `bo_cmt_best_min` tinyint(2) NOT NULL default '10',
  `bo_cmt_best_limit` tinyint(2) NOT NULL default '5',
  `bo_tag_level` tinyint(4) NOT NULL default '2',
  `bo_tag_limit` tinyint(4) NOT NULL default '10',
  `bo_automove` varchar(255) NOT NULL,
  `bo_exif_detail` text NOT NULL,
  `bo_blind_limit` tinyint(2) NOT NULL default '5',
  `bo_blind_view` tinyint(2) NOT NULL default '10',
  `bo_blind_direct` tinyint(2) NOT NULL default '10',
  `bo_cmtpoint_target` char(1) NOT NULL default '1',
  `bo_firstcmt_point` int(7) NOT NULL default '0',
  `bo_firstcmt_point_type` char(1) NOT NULL default '1',
  `bo_bomb_point` int(7) NOT NULL default '0',
  `bo_bomb_point_type` char(1) NOT NULL default '1',
  `bo_bomb_point_limit` int(3) NOT NULL default '10',
  `bo_bomb_point_cnt` int(2) NOT NULL default '1',
  `bo_lucky_point` int(7) NOT NULL default '0',
  `bo_lucky_point_type` char(1) NOT NULL default '1',
  `bo_lucky_point_ratio` int(2) NOT NULL default '1',
  `download_fee_ratio` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`bo_id`),
  KEY `bo_table` (`bo_table`),
  KEY `bo_theme` (`bo_theme`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_guest`
--

DROP TABLE IF EXISTS `g5_eyoom_guest`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_guest` (
  `gu_no` mediumint(11) unsigned NOT NULL auto_increment,
  `mb_id` varchar(40) NOT NULL,
  `gu_id` varchar(40) NOT NULL,
  `gu_name` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `gu_regdt` datetime NOT NULL,
  PRIMARY KEY  (`gu_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_menu`
--

DROP TABLE IF EXISTS `g5_eyoom_menu`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_menu` (
  `me_id` int(11) NOT NULL auto_increment,
  `me_theme` varchar(20) NOT NULL,
  `me_code` varchar(255) NOT NULL default '',
  `me_name` varchar(255) NOT NULL default '',
  `me_icon` varchar(100) NOT NULL,
  `me_shop` char(1) NOT NULL default '2',
  `me_path` varchar(255) NOT NULL,
  `me_type` varchar(30) NOT NULL,
  `me_pid` varchar(40) NOT NULL,
  `me_sca` varchar(50) NOT NULL,
  `me_link` varchar(255) NOT NULL default '',
  `me_target` varchar(255) NOT NULL default '',
  `me_order` int(11) NOT NULL default '0',
  `me_permit_level` tinyint(4) NOT NULL default '1',
  `me_side` enum('y','n') NOT NULL default 'y',
  `me_use` enum('y','n') NOT NULL default 'y',
  `me_use_nav` enum('y','n') NOT NULL default 'y',
  PRIMARY KEY  (`me_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_theme`
--

DROP TABLE IF EXISTS `g5_eyoom_theme`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_theme` (
  `tm_name` varchar(40) NOT NULL,
  `tm_alias` varchar(20) NOT NULL,
  `tm_key` varchar(100) NOT NULL,
  `cm_key` varchar(255) NOT NULL,
  `cm_salt` varchar(10) NOT NULL,
  `tm_last` varchar(20) NOT NULL,
  `tm_time` varchar(20) NOT NULL,
  UNIQUE KEY `tm_name` (`tm_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_link`
--

DROP TABLE IF EXISTS `g5_eyoom_link`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_link` (
  `s_no` int(11) unsigned NOT NULL auto_increment,
  `bo_table` varchar(20) collate utf8_unicode_ci NOT NULL,
  `wr_id` int(11) unsigned NOT NULL default '0',
  `theme` varchar(40) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`s_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_yellowcard`
--

DROP TABLE IF EXISTS `g5_eyoom_yellowcard`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_yellowcard` (
  `yc_id` int(11) unsigned NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` int(11) NOT NULL default '0',
  `pr_id` int(11) NOT NULL,
  `mb_id` varchar(20) NOT NULL default '',
  `yc_reason` char(1) NOT NULL,
  `yc_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`yc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_rating`
--

DROP TABLE IF EXISTS `g5_eyoom_rating`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_rating` (
  `rt_id` int(11) unsigned NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` int(11) NOT NULL default '0',
  `pr_id` int(11) NOT NULL,
  `mb_id` varchar(20) NOT NULL default '',
  `rating` smallint(2) NOT NULL default '0',
  `rt_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`rt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_tag`
--

DROP TABLE IF EXISTS `g5_eyoom_tag`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_tag` (
  `tg_id` int(11) unsigned NOT NULL auto_increment,
  `tg_word` varchar(20) NOT NULL default '',
  `tg_theme` varchar(40) NOT null default 'basic',
  `tg_regcnt` int(11) unsigned NOT NULL default '0',
  `tg_dpmenu` enum('y','n') NOT NULL default 'n',
  `tg_scnt` int(11) NOT NULL default '0',
  `tg_score` int(11) NOT NULL default '0',
  `tg_recommdt` datetime NOT NULL default '0000-00-00 00:00:00',
  `tg_regdt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`tg_id`),
  KEY `tg_word` (`tg_word`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_tag_write`
--

DROP TABLE IF EXISTS `g5_eyoom_tag_write`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_tag_write` (
  `tw_id` int(11) NOT NULL auto_increment,
  `tw_theme` varchar(40) NOT NULL,
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` int(11) NOT NULL default '0',
  `wr_subject` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_content` text NOT NULL,
  `wr_tag` text NOT NULL,
  `wr_image` text NOT NULL,
  `wr_hit` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL default '',
  `mb_name` varchar(50) NOT NULL,
  `mb_nick` varchar(50) NOT NULL,
  `mb_level` varchar(255) NOT NULL,
  `tw_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
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
  PRIMARY KEY  (`tw_id`),
  KEY `mb_id` (`mb_id`),
  KEY `wr_hit` (`wr_hit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_ebslider`
--

DROP TABLE IF EXISTS `g5_eyoom_ebslider`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_ebslider` (
  `es_no` int(10) unsigned NOT NULL auto_increment,
  `es_code` varchar(255) NOT NULL,
  `es_subject` varchar(255) NOT NULL,
  `es_theme` varchar(30) NOT NULL DEFAULT 'basic3',
  `es_skin` varchar(50) NOT NULL DEFAULT 'basic',
  `es_ytplay` char(1) NOT NULL DEFAULT '1',
  `es_ytmauto` char(1) NOT NULL DEFAULT '2',
  `es_state` smallint(1) NOT NULL DEFAULT '0',
  `es_regdt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`es_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_ebslider_item`
--

DROP TABLE IF EXISTS `g5_eyoom_ebslider_item`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_ebslider_item` (
  `ei_no` int(10) unsigned NOT NULL auto_increment,
  `es_code` varchar(255) NOT NULL,
  `ei_theme` varchar(50) NOT NULL default '',
  `ei_state` char(1) NOT NULL default '2',
  `ei_sort` int(10) default '0',
  `ei_title` varchar(255) NOT NULL,
  `ei_subtitle` varchar(255) NOT NULL,
  `ei_text` text NOT NULL,
  `ei_link` varchar(255) NOT NULL default '',
  `ei_target` varchar(20) NOT NULL default '',
  `ei_img` varchar(100) NOT NULL default '',
  `ei_period` char(1) NOT NULL default '1',
  `ei_start` varchar(10) NOT NULL,
  `ei_end` varchar(10) NOT NULL,
  `ei_clicked` mediumint(10) NOT NULL default '0',
  `ei_view_level` tinyint(4) NOT NULL default '1',
  `ei_regdt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ei_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_ebslider_ytitem`
--

DROP TABLE IF EXISTS `g5_eyoom_ebslider_ytitem`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_ebslider_ytitem` (
  `ei_no` int(10) unsigned NOT NULL auto_increment,
  `es_code` text NOT NULL,
  `ei_theme` varchar(30) NOT NULL DEFAULT '',
  `ei_state` char(1) NOT NULL DEFAULT '2',
  `ei_sort` int(10) DEFAULT '0',
  `ei_ytcode` varchar(255) NOT NULL,
  `ei_quality` varchar(10) NOT NULL DEFAULT 'hd1080',
  `ei_remember` char(1) NOT NULL DEFAULT '1',
  `ei_autoplay` char(1) NOT NULL DEFAULT '1',
  `ei_control` char(1) NOT NULL DEFAULT '1',
  `ei_loop` char(1) NOT NULL DEFAULT '1',
  `ei_mute` char(1) NOT NULL DEFAULT '1',
  `ei_raster` char(1) NOT NULL DEFAULT '1',
  `ei_volumn` smallint(3) NOT NULL DEFAULT '10',
  `ei_stime` smallint(4) NOT NULL DEFAULT '0',
  `ei_etime` smallint(4) NOT NULL DEFAULT '0',
  `ei_period` char(1) NOT NULL DEFAULT '1',
  `ei_start` varchar(10) NOT NULL,
  `ei_end` varchar(10) NOT NULL,
  `ei_view_level` tinyint(4) NOT NULL DEFAULT '1',
  `ei_regdt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`ei_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_exboard`
--

DROP TABLE IF EXISTS `g5_eyoom_exboard`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_exboard` (
  `ex_no` int(11) unsigned NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL,
  `ex_fname` varchar(10) NOT NULL,
  `ex_subject` varchar(50) NOT NULL,
  `ex_use_search` enum('y','n') NOT NULL default 'n',
  `ex_required` enum('y','n') NOT NULL default 'n',
  `ex_form` varchar(20) NOT NULL default 'text',
  `ex_type` varchar(20) NOT NULL,
  `ex_length` mediumint(5) NOT NULL,
  `ex_default` varchar(255) NOT NULL,
  `ex_item_value` text NOT NULL,
  PRIMARY KEY  (`ex_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_ebcontents`
--

DROP TABLE IF EXISTS `g5_eyoom_ebcontents`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_ebcontents` (
  `ec_no` int(10) unsigned NOT NULL auto_increment,
  `ec_code` text NOT NULL,
  `ec_subject` varchar(255) NOT NULL,
  `ec_theme` varchar(30) NOT NULL default '',
  `ec_skin` varchar(50) NOT NULL default 'basic',
  `ec_state` smallint(1) NOT NULL default '0',
  `ec_text` text NOT NULL,
  `ec_link_cnt` smallint(2) NOT NULL default '2',
  `ec_image_cnt` smallint(2) NOT NULL default '5',
  `ec_regdt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ec_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_ebcontents_item`
--

DROP TABLE IF EXISTS `g5_eyoom_ebcontents_item`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_ebcontents_item` (
  `ci_no` int(10) unsigned NOT NULL auto_increment,
  `ec_code` text NOT NULL,
  `ci_theme` varchar(30) NOT NULL default '',
  `ci_state` char(1) NOT NULL default '2',
  `ci_sort` int(10) default '0',
  `ci_title` varchar(255) NOT NULL,
  `ci_subtitle` varchar(255) NOT NULL,
  `ci_text` text NOT NULL,
  `ci_content` text NOT NULL,
  `ci_link` text NOT NULL,
  `ci_target` text NOT NULL,
  `ci_img` text NOT NULL,
  `ci_period` char(1) NOT NULL default '1',
  `ci_start` varchar(10) NOT NULL,
  `ci_end` varchar(10) NOT NULL,
  `ci_view_level` tinyint(4) NOT NULL default '1',
  `ci_regdt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ci_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `g5_eyoom_latest`
--

DROP TABLE IF EXISTS `g5_eyoom_latest`;
CREATE TABLE IF NOT EXISTS `g5_eyoom_latest` (
  `el_no` int(10) unsigned NOT NULL auto_increment,
  `el_code` varchar(20) NOT NULL,
  `el_subject` varchar(255) NOT NULL,
  `el_theme` varchar(30) NOT NULL default 'basic3',
  `el_skin` varchar(50) NOT NULL default 'basic',
  `el_state` smallint(1) NOT NULL default '0',
  `el_regdt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`el_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `eyoom_eblatest_item`
--

DROP TABLE IF EXISTS `eyoom_eblatest_item`;
CREATE TABLE IF NOT EXISTS `eyoom_eblatest_item` (
  `li_no` int(10) unsigned NOT NULL auto_increment,
  `el_code` varchar(20) NOT NULL,
  `li_theme` varchar(30) NOT NULL default '',
  `li_state` char(1) NOT NULL default '2',
  `li_sort` int(10) default '0',
  `li_title` varchar(255) NOT NULL,
  `li_bo_table` varchar(20) NOT NULL default '',
  `li_gr_id` varchar(20) NOT NULL default '',
  `li_exclude` varchar(255) NOT NULL default '',
  `li_include` varchar(255) NOT NULL default '',
  `li_direct` char(1) NOT NULL default 'n',
  `li_count` smallint(2) NOT NULL default '5',
  `li_period` smallint(2) NOT NULL default '0',
  `li_ca_view` char(1) NOT NULL default 'n',
  `li_cut_subject` smallint(2) NOT NULL default '50',
  `li_best` char(1) NOT NULL default 'n',
  `li_random` char(1) NOT NULL default 'n',
  `li_img_view` char(1) NOT NULL default 'n',
  `li_img_width` smallint(3) NOT NULL default '300',
  `li_img_height` smallint(3) NOT NULL default '300',
  `li_content` char(1) NOT NULL default 'n',
  `li_cut_content` smallint(3) NOT NULL default '100',
  `li_bo_subject` char(1) NOT NULL default 'n',
  `li_mbname_view` char(1) NOT NULL default 'y',
  `li_photo` char(1) NOT NULL default 'n',
  `li_use_date` char(1) NOT NULL default 'y',
  `li_date_type` char(1) NOT NULL default '1',
  `li_date_kind` varchar(20) NOT NULL,
  `li_where` text NOT NULL,
  `li_regdt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`li_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;