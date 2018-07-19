<?php
if (!defined('_GNUBOARD_')) exit;

// Auth
if($is_admin != 'super') {
	alert("최고관리자만 설치할 수 있습니다.");
}

if(IS_YC) {
	// APMS Config
	$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms']}` (
			  `apms_company` tinyint(4) NOT NULL DEFAULT '0',
			  `apms_personal` tinyint(4) NOT NULL DEFAULT '0',
			  `apms_register` tinyint(4) NOT NULL DEFAULT '0',
			  `apms_email_yes` tinyint(4) NOT NULL DEFAULT '0',
			  `apms_cert_yes` tinyint(4) NOT NULL DEFAULT '0',
			  `apms_adult_yes` tinyint(4) NOT NULL DEFAULT '0',
			  `apms_partner` tinyint(4) NOT NULL DEFAULT '0',
			  `apms_marketer` tinyint(4) NOT NULL DEFAULT '0',
			  `apms_commission_1` tinyint(4) NOT NULL DEFAULT '30',
			  `apms_commission_2` tinyint(4) NOT NULL DEFAULT '30',
			  `apms_commission_3` tinyint(4) NOT NULL DEFAULT '30',
			  `apms_commission_4` tinyint(4) NOT NULL DEFAULT '30',
			  `apms_commission_5` tinyint(4) NOT NULL DEFAULT '30',
			  `apms_benefit1` int(11) NOT NULL DEFAULT '0',
			  `apms_benefit2` int(11) NOT NULL DEFAULT '0',
			  `apms_benefit3` int(11) NOT NULL DEFAULT '0',
			  `apms_benefit4` int(11) NOT NULL DEFAULT '0',
			  `apms_benefit5` int(11) NOT NULL DEFAULT '0',
			  `apms_benefit6` int(11) NOT NULL DEFAULT '0',
			  `apms_benefit7` int(11) NOT NULL DEFAULT '0',
			  `apms_benefit8` int(11) NOT NULL DEFAULT '0',
			  `apms_benefit9` int(11) NOT NULL DEFAULT '0',
			  `apms_benefit10` int(11) NOT NULL DEFAULT '0',
			  `apms_payment_cut` tinyint(4) NOT NULL DEFAULT '0',
			  `apms_payment_day` tinyint(4) NOT NULL DEFAULT '0',
			  `apms_payment` int(11) NOT NULL DEFAULT '100000',
			  `apms_payment_limit` varchar(255) NOT NULL DEFAULT '',
			  `apms_admin_name` varchar(255) NOT NULL DEFAULT '',
			  `apms_admin_email` varchar(255) NOT NULL DEFAULT '',
			  `apms_admin_hp` varchar(255) NOT NULL DEFAULT '',
			  `apms_stipulation` text NOT NULL,
			  `apms_notice` text NOT NULL,
			  `apms_account_no` text NOT NULL,
			  `apms_skin` varchar(255) NOT NULL DEFAULT '',
			  `apms_1` varchar(255) NOT NULL DEFAULT '',
			  `apms_2` varchar(255) NOT NULL DEFAULT '',
			  `apms_3` varchar(255) NOT NULL DEFAULT '',
			  `apms_4` varchar(255) NOT NULL DEFAULT '',
			  `apms_5` varchar(255) NOT NULL DEFAULT '',
			  `apms_6` varchar(255) NOT NULL DEFAULT '',
			  `apms_7` varchar(255) NOT NULL DEFAULT '',
			  `apms_8` varchar(255) NOT NULL DEFAULT '',
			  `apms_9` varchar(255) NOT NULL DEFAULT '',
			  `apms_10` varchar(255) NOT NULL DEFAULT ''
			) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
	sql_query($sql, false);

	// APMS Config
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_payment_day` tinyint(4) NOT NULL DEFAULT '0' AFTER `apms_payment_cut` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_payment_limit` varchar(255) NOT NULL DEFAULT '' AFTER `apms_payment` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_skin` varchar(255) NOT NULL DEFAULT '' AFTER `apms_account_no` ", false);

	// APMS Config
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_notice` text NOT NULL AFTER `apms_stipulation` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_account_no` text NOT NULL AFTER `apms_notice` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_payment_no` text NOT NULL AFTER `apms_account_no` ", false);

	// APMS Config
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_partner` tinyint(4) NOT NULL DEFAULT '0' AFTER `apms_adult_yes` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_marketer` tinyint(4) NOT NULL DEFAULT '0' AFTER `apms_partner` ", false);

	// APMS Config
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_benefit1` int(11) NOT NULL DEFAULT '0' AFTER `apms_commission_5` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_benefit2` int(11) NOT NULL DEFAULT '0' AFTER `apms_benefit1` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_benefit3` int(11) NOT NULL DEFAULT '0' AFTER `apms_benefit2` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_benefit4` int(11) NOT NULL DEFAULT '0' AFTER `apms_benefit3` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_benefit5` int(11) NOT NULL DEFAULT '0' AFTER `apms_benefit4` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_benefit6` int(11) NOT NULL DEFAULT '0' AFTER `apms_benefit5` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_benefit7` int(11) NOT NULL DEFAULT '0' AFTER `apms_benefit6` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_benefit8` int(11) NOT NULL DEFAULT '0' AFTER `apms_benefit7` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_benefit9` int(11) NOT NULL DEFAULT '0' AFTER `apms_benefit8` ", false);
	sql_query(" ALTER TABLE `{$g5['apms']}`	ADD `apms_benefit10` int(11) NOT NULL DEFAULT '0' AFTER `apms_benefit9` ", false);

	// Partner
	$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_partner']}` (
			  `pt_no` int(11) NOT NULL AUTO_INCREMENT,
			  `pt_type` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_partner` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_marketer` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_id` varchar(255) NOT NULL DEFAULT '',
			  `pt_register` varchar(8) NOT NULL DEFAULT '',
			  `pt_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `pt_leave` varchar(8) NOT NULL DEFAULT '',
			  `pt_name` varchar(255) NOT NULL DEFAULT '',
			  `pt_email` varchar(255) NOT NULL DEFAULT '',
			  `pt_hp` varchar(255) NOT NULL DEFAULT '',
			  `pt_company` varchar(255) NOT NULL DEFAULT '',
			  `pt_company_name` varchar(255) NOT NULL DEFAULT '',
			  `pt_company_president` varchar(255) NOT NULL DEFAULT '',
			  `pt_company_saupja` varchar(255) NOT NULL DEFAULT '',
			  `pt_company_addr` varchar(255) NOT NULL DEFAULT '',
			  `pt_company_type` varchar(255) NOT NULL DEFAULT '',
			  `pt_company_item` varchar(255) NOT NULL DEFAULT '',
			  `pt_bank_name` varchar(255) NOT NULL DEFAULT '',
			  `pt_bank_account` varchar(255) NOT NULL DEFAULT '',
			  `pt_bank_holder` varchar(255) NOT NULL DEFAULT '',
			  `pt_bank_limit` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_flag` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_point` int(11) NOT NULL DEFAULT '0',
			  `pt_benefit` int(11) NOT NULL DEFAULT '0',
			  `pt_level` tinyint(4) NOT NULL DEFAULT '1',
			  `pt_limit` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_commission_1` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_commission_2` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_commission_3` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_commission_4` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_commission_5` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_incentive_1` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_incentive_2` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_incentive_3` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_incentive_4` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_incentive_5` tinyint(4) NOT NULL DEFAULT '0',
			  `pt_memo` text NOT NULL,
			  `pt_1` varchar(255) NOT NULL DEFAULT '',
			  `pt_2` varchar(255) NOT NULL DEFAULT '',
			  `pt_3` varchar(255) NOT NULL DEFAULT '',
			  `pt_4` varchar(255) NOT NULL DEFAULT '',
			  `pt_5` varchar(255) NOT NULL DEFAULT '',
			  `pt_6` varchar(255) NOT NULL DEFAULT '',
			  `pt_7` varchar(255) NOT NULL DEFAULT '',
			  `pt_8` varchar(255) NOT NULL DEFAULT '',
			  `pt_9` varchar(255) NOT NULL DEFAULT '',
			  `pt_10` varchar(255) NOT NULL DEFAULT '',
			  PRIMARY KEY  (`pt_no`),
			  UNIQUE KEY `pt_id` (`pt_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
	sql_query($sql, false);

	// Partner
	sql_query(" ALTER TABLE `{$g5['apms_partner']}` ADD `pt_company` varchar(255) NOT NULL DEFAULT '' AFTER `pt_hp` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_partner']}` ADD `pt_bank_limit` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_bank_holder` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_partner']}` ADD `pt_flag` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_bank_limit` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_partner']}` ADD `pt_partner` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_type` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_partner']}` ADD `pt_marketer` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_partner` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_partner']}` ADD `pt_benefit` int(11) NOT NULL DEFAULT '0' AFTER `pt_point` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_partner']}` ADD `pt_level` tinyint(4) NOT NULL DEFAULT '1' AFTER `pt_benefit` ", false);

	// Payment
	$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_payment']}` (
				`pp_id` int(11) NOT NULL AUTO_INCREMENT,
				`mb_id` varchar(255) NOT NULL DEFAULT '',
				`pp_staff` varchar(255) NOT NULL DEFAULT '',
				`pp_amount` int(11) NOT NULL DEFAULT '0',
				`pp_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				`pp_confirm` tinyint(4) NOT NULL DEFAULT '0',
				`pp_confirmtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY  (`pp_id`, `mb_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
	sql_query($sql, false);

	// Payment
	sql_query(" ALTER TABLE `{$g5['apms_payment']}` ADD `pp_staff` varchar(255) NOT NULL DEFAULT '' AFTER `mb_id` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_payment']}` ADD `pp_shingo` int(11) NOT NULL DEFAULT '0' AFTER `pp_amount` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_payment']}`
					ADD `pp_type` tinyint(4) NOT NULL DEFAULT '0',
					ADD `pp_means` tinyint(4) NOT NULL DEFAULT '0',
					ADD `pp_flag` tinyint(4) NOT NULL DEFAULT '0',
					ADD `pp_field` tinyint(4) NOT NULL DEFAULT '0',
					ADD `pp_tax` int(11) NOT NULL DEFAULT '0',
					ADD `pp_pay` int(11) NOT NULL DEFAULT '0',
					ADD `pp_company` varchar(255) NOT NULL DEFAULT '',
					ADD `pp_ip` varchar(255) NOT NULL DEFAULT '',
					ADD `pp_memo` text NOT NULL,
					ADD `pp_ans` text NOT NULL ", false);

	sql_query(" ALTER TABLE `{$g5['apms_payment']}` ADD `pp_field` tinyint(4) NOT NULL DEFAULT '0' AFTER `pp_flag` ", false); //정산종류

	// Sendcost
	$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_sendcost']}` (
				`sc_id` int(11) NOT NULL AUTO_INCREMENT,
				`pt_id` varchar(255) NOT NULL DEFAULT '',
				`it_name` varchar(255) NOT NULL DEFAULT '',
				`it_id` varchar(20) NOT NULL DEFAULT '',
				`od_id` bigint(20) unsigned NOT NULL,
				`sc_flag` tinyint(4) NOT NULL DEFAULT '0',
				`sc_price` int(11) NOT NULL DEFAULT '0',
				`sc_type` varchar(255) NOT NULL DEFAULT '',
				`sc_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				`pt_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY  (`sc_id`, `pt_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
	sql_query($sql, false);

	sql_query(" ALTER TABLE `{$g5['apms_sendcost']}` ADD `it_name` varchar(255) NOT NULL DEFAULT '' AFTER `pt_id` ", false); //상품명

	// File
	$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_file']}` (
			  `pf_id` varchar(255) NOT NULL DEFAULT '',
			  `pf_no` int(11) NOT NULL DEFAULT '0',
			  `pf_source` varchar(255) NOT NULL DEFAULT '',
			  `pf_file` varchar(255) NOT NULL DEFAULT '',
			  `pf_guest_use` tinyint(4) NOT NULL DEFAULT '0',
			  `pf_purchase_use` tinyint(4) NOT NULL DEFAULT '0',
			  `pf_download_use` tinyint(4) NOT NULL DEFAULT '0',
			  `pf_download` int(11) NOT NULL DEFAULT '0',
			  `pf_view_use` tinyint(4) NOT NULL DEFAULT '0',
			  `pf_view` int(11) NOT NULL DEFAULT '0',
			  `pf_filesize` int(11) NOT NULL DEFAULT '0',
			  `pf_width` int(11) NOT NULL DEFAULT '0',
			  `pf_height` int(11) NOT NULL DEFAULT '0',
			  `pf_type` tinyint(4) NOT NULL DEFAULT '0',
			  `pf_dir` tinyint(4) NOT NULL DEFAULT '0',
			  `pf_ext` tinyint(4) NOT NULL DEFAULT '0',
			  `pf_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY  (`pf_id`, `pf_dir`,`pf_no`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
	sql_query($sql, false);

	// Comment
	$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_comment']}` (
			  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
			  `mb_id` varchar(255) NOT NULL DEFAULT '',
			  `it_id` varchar(20) NOT NULL DEFAULT '',
			  `pt_id` varchar(255) NOT NULL DEFAULT '',
			  `wr_comment` int(11) NOT NULL DEFAULT '0',
			  `wr_comment_reply` varchar(5) NOT NULL,
			  `wr_option` set('html1','html2','secret','mail') NOT NULL,
			  `wr_subject` varchar(255) NOT NULL,
			  `wr_content` text NOT NULL,
			  `wr_shingo` tinyint(4) NOT NULL DEFAULT '0',
			  `wr_level` int(11) NOT NULL DEFAULT '1',
			  `wr_lucky` int(11) NOT NULL DEFAULT '0',
			  `wr_good` int(11) NOT NULL DEFAULT '0',
			  `wr_nogood` int(11) NOT NULL DEFAULT '0',
			  `wr_password` varchar(255) NOT NULL,
			  `wr_name` varchar(255) NOT NULL,
			  `wr_email` varchar(255) NOT NULL,
			  `wr_homepage` varchar(255) NOT NULL,
			  `wr_re_mb` varchar(255) NOT NULL DEFAULT '',
			  `wr_re_name` varchar(255) NOT NULL,
			  `wr_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `wr_ip` varchar(255) NOT NULL,
			  `wr_facebook_user` varchar(255) NOT NULL,
			  `wr_twitter_user` varchar(255) NOT NULL,
			  `wr_1` varchar(255) NOT NULL,
			  `wr_2` varchar(255) NOT NULL,
			  `wr_3` varchar(255) NOT NULL,
			  `wr_4` varchar(255) NOT NULL,
			  `wr_5` varchar(255) NOT NULL,
			  PRIMARY KEY (`wr_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
	sql_query($sql, false);

	// Comment Shingo
	sql_query(" ALTER TABLE `{$g5['apms_comment']}` ADD `wr_shingo` tinyint(4) NOT NULL DEFAULT '0' AFTER `wr_content` ", false);

	// Comment Level
	sql_query(" ALTER TABLE `{$g5['apms_comment']}` ADD `wr_level` int(11) NOT NULL DEFAULT '1' AFTER `wr_shingo` ", false);

	// Comment Lucky
	sql_query(" ALTER TABLE `{$g5['apms_comment']}` ADD `wr_lucky` int(11) NOT NULL DEFAULT '0' AFTER `wr_level` ", false);

	// Comment Reply
	sql_query(" ALTER TABLE `{$g5['apms_comment']}` ADD `wr_re_mb` varchar(255) NOT NULL DEFAULT '' AFTER `wr_homepage` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_comment']}` ADD `wr_re_name` varchar(255) NOT NULL AFTER `wr_re_mb` ", false);

	// Rows
	$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_rows']}` (
			  `icomment_rows` int(11) NOT NULL DEFAULT '20',
			  `icomment_mobile_rows` int(11) NOT NULL DEFAULT '10',
			  `iuse_rows` int(11) NOT NULL DEFAULT '20',
			  `iuse_mobile_rows` int(11) NOT NULL DEFAULT '10',
			  `iqa_rows` int(11) NOT NULL DEFAULT '20',
			  `iqa_mobile_rows` int(11) NOT NULL DEFAULT '10',
			  `irelation_mods` int(11) NOT NULL DEFAULT '3',
			  `irelation_mobile_mods` int(11) NOT NULL DEFAULT '3',
			  `irelation_rows` int(11) NOT NULL DEFAULT '2',
			  `irelation_mobile_rows` int(11) NOT NULL DEFAULT '1',
			  `type_mods` int(11) NOT NULL DEFAULT '3',
			  `type_mobile_mods` int(11) NOT NULL DEFAULT '3',
			  `type_rows` int(11) NOT NULL DEFAULT '5',
			  `type_mobile_rows` int(11) NOT NULL DEFAULT '2',
			  `event_mods` int(11) NOT NULL DEFAULT '3',
			  `event_mobile_mods` int(11) NOT NULL DEFAULT '3',
			  `event_rows` int(11) NOT NULL DEFAULT '5',
			  `event_mobile_rows` int(11) NOT NULL DEFAULT '2',
			  `myshop_mods` int(11) NOT NULL DEFAULT '3',
			  `myshop_mobile_mods` int(11) NOT NULL DEFAULT '3',
			  `myshop_rows` int(11) NOT NULL DEFAULT '5',
			  `myshop_mobile_rows` int(11) NOT NULL DEFAULT '2',
			  `ppay_mods` int(11) NOT NULL DEFAULT '3',
			  `ppay_mobile_mods` int(11) NOT NULL DEFAULT '3',
			  `ppay_rows` int(11) NOT NULL DEFAULT '5',
			  `ppay_mobile_rows` int(11) NOT NULL DEFAULT '2',
			  `type_img_width` int(11) NOT NULL DEFAULT '400',
			  `type_img_height` int(11) NOT NULL DEFAULT '400',
			  `type_mobile_img_width` int(11) NOT NULL DEFAULT '400',
			  `type_mobile_img_height` int(11) NOT NULL DEFAULT '400',
			  `myshop_img_width` int(11) NOT NULL DEFAULT '400',
			  `myshop_img_height` int(11) NOT NULL DEFAULT '400',
			  `myshop_mobile_img_width` int(11) NOT NULL DEFAULT '400',
			  `myshop_mobile_img_height` int(11) NOT NULL DEFAULT '400',
			  `type_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `type_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `myshop_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `myshop_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `order_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `order_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `event_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `event_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `editor_skin` varchar(255) NOT NULL DEFAULT '',
			  `editor_mobile_skin` varchar(255) NOT NULL DEFAULT '',
			  `qa_rows` int(11) NOT NULL DEFAULT '15',
			  `qa_mobile_rows` int(11) NOT NULL DEFAULT '10',
			  `qa_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `qa_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `use_rows` int(11) NOT NULL DEFAULT '15',
			  `use_mobile_rows` int(11) NOT NULL DEFAULT '10',
			  `use_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `use_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `type_set` text NOT NULL DEFAULT '',
			  `type_mobile_set` text NOT NULL DEFAULT '',
			  `event_set` text NOT NULL DEFAULT '',
			  `event_mobile_set` text NOT NULL DEFAULT '',
			  `myshop_set` text NOT NULL DEFAULT '',
			  `myshop_mobile_set` text NOT NULL DEFAULT '',
			  `search_set` text NOT NULL DEFAULT '',
			  `search_mobile_set` text NOT NULL DEFAULT '',
			  `qa_set` text NOT NULL DEFAULT '',
			  `qa_mobile_set` text NOT NULL DEFAULT '',
			  `use_set` text NOT NULL DEFAULT '',
			  `use_mobile_set` text NOT NULL DEFAULT '',
			  `order_set` text NOT NULL DEFAULT '',
			  `order_mobile_set` text NOT NULL DEFAULT '',
			  `cz_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `cz_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic',
			  `cz_set` text NOT NULL DEFAULT '',
			  `cz_mobile_set` text NOT NULL DEFAULT ''
			) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
	sql_query($sql, false);

	// Rows Thumbails
	sql_query(" ALTER TABLE `{$g5['apms_rows']}`
					ADD `type_img_width` int(11) NOT NULL DEFAULT '400',
					ADD `type_img_height` int(11) NOT NULL DEFAULT '400',
					ADD `type_mobile_img_width` int(11) NOT NULL DEFAULT '400',
					ADD `type_mobile_img_height` int(11) NOT NULL DEFAULT '400',
					ADD `myshop_img_width` int(11) NOT NULL DEFAULT '400',
					ADD `myshop_img_height` int(11) NOT NULL DEFAULT '400',
					ADD `myshop_mobile_img_width` int(11) NOT NULL DEFAULT '400',
					ADD `myshop_mobile_img_height` int(11) NOT NULL DEFAULT '400' ", false);

	// Rows Misc
	sql_query(" ALTER TABLE `{$g5['apms_rows']}`
					ADD `ppay_mods` int(11) NOT NULL DEFAULT '3',
					ADD `ppay_mobile_mods` int(11) NOT NULL DEFAULT '3',
					ADD `ppay_rows` int(11) NOT NULL DEFAULT '5',
					ADD `ppay_mobile_rows` int(11) NOT NULL DEFAULT '2' ", false);

	// Rows Skin
	sql_query(" ALTER TABLE `{$g5['apms_rows']}`
					ADD `type_skin` varchar(255) NOT NULL DEFAULT 'basic',
					ADD `type_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic',
					ADD `myshop_skin` varchar(255) NOT NULL DEFAULT 'basic',
					ADD `myshop_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic' ", false);

	// Rows Skin & Set
	sql_query(" ALTER TABLE `{$g5['apms_rows']}`
					ADD `order_skin` varchar(255) NOT NULL DEFAULT 'basic',
					ADD `order_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic',
					ADD `event_skin` varchar(255) NOT NULL DEFAULT 'basic',
					ADD `event_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic',
					ADD `editor_skin` varchar(255) NOT NULL DEFAULT '',
					ADD `editor_mobile_skin` varchar(255) NOT NULL DEFAULT '',
					ADD `qa_rows` int(11) NOT NULL DEFAULT '15',
					ADD `qa_mobile_rows` int(11) NOT NULL DEFAULT '10',
					ADD `qa_skin` varchar(255) NOT NULL DEFAULT 'basic',
					ADD `qa_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic', 					
					ADD `use_rows` int(11) NOT NULL DEFAULT '15',
					ADD `use_mobile_rows` int(11) NOT NULL DEFAULT '10',
					ADD `use_skin` varchar(255) NOT NULL DEFAULT 'basic',
					ADD `use_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic', 
					ADD `type_set` text NOT NULL DEFAULT '', 
					ADD `type_mobile_set` text NOT NULL DEFAULT '', 
					ADD `event_set` text NOT NULL DEFAULT '', 
					ADD `event_mobile_set` text NOT NULL DEFAULT '', 
					ADD `myshop_set` text NOT NULL DEFAULT '', 
					ADD `myshop_mobile_set` text NOT NULL DEFAULT '', 
					ADD `search_set` text NOT NULL DEFAULT '', 
					ADD `search_mobile_set` text NOT NULL DEFAULT '', 
					ADD `qa_set` text NOT NULL DEFAULT '',
					ADD `qa_mobile_set` text NOT NULL DEFAULT '',
					ADD `use_set` text NOT NULL DEFAULT '',
					ADD `use_mobile_set` text NOT NULL DEFAULT '' ", false);

	// Rows Skin & Set
	sql_query(" ALTER TABLE `{$g5['apms_rows']}` ADD `event_skin` varchar(255) NOT NULL DEFAULT 'basic' AFTER `order_skin` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_rows']}` ADD `event_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic' AFTER `event_skin` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_rows']}` ADD `editor_skin` varchar(255) NOT NULL DEFAULT '' AFTER `event_mobile_skin` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_rows']}` ADD `editor_mobile_skin` varchar(255) NOT NULL DEFAULT '' AFTER `editor_skin` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_rows']}` ADD `order_set` text NOT NULL DEFAULT '' AFTER `use_mobile_set` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_rows']}` ADD `order_mobile_set` text NOT NULL DEFAULT '' AFTER `order_set` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_rows']}` ADD `cz_skin` varchar(255) NOT NULL DEFAULT 'basic' AFTER `order_mobile_set` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_rows']}` ADD `cz_mobile_skin` varchar(255) NOT NULL DEFAULT 'basic' AFTER `cz_skin` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_rows']}` ADD `cz_set` text NOT NULL DEFAULT '' AFTER `cz_mobile_skin` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_rows']}` ADD `cz_mobile_set` text NOT NULL DEFAULT '' AFTER `cz_set` ", false);

	// Form
	$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_form']}` (
				`pi_id` int(11) NOT NULL AUTO_INCREMENT,
				`pi_name` varchar(255) NOT NULL DEFAULT '',
				`pi_file` varchar(255) NOT NULL DEFAULT '',
				`pi_use` tinyint(4) NOT NULL DEFAULT '0',
				`pi_show` tinyint(4) NOT NULL DEFAULT '0',
				`pi_order` int(11) NOT NULL DEFAULT '0',
				PRIMARY KEY  (`pi_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
	sql_query($sql, false);

	// Item Good
	$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_good']}` (
				`pg_id` int(11) NOT NULL AUTO_INCREMENT,
				`mb_id` varchar(255) NOT NULL DEFAULT '',
				`it_id` varchar(20) NOT NULL DEFAULT '',
				`pg_flag` varchar(255) NOT NULL DEFAULT '',
				`pg_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY  (`pg_id`),
				UNIQUE KEY `fkey1` (`mb_id`,`it_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
	sql_query($sql, false);

	// Item Use Log
	$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_use_log']}` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`od_id` bigint(20) unsigned NOT NULL,
				`pt_id` varchar(255) NOT NULL DEFAULT '',
				`mb_id` varchar(255) NOT NULL DEFAULT '',
				`it_id` varchar(20) NOT NULL DEFAULT '',
				`it_name` varchar(255) NOT NULL DEFAULT '',
				`use_file` varchar(255) NOT NULL DEFAULT '',
				`use_cnt` int(11) NOT NULL DEFAULT '0',
				`use_regdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				`use_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY  (`id`),
				KEY `index1` (`mb_id`,`it_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
	sql_query($sql, false);

	sql_query(" ALTER TABLE `{$g5['apms_use_log']}` ADD `od_id` bigint(20) unsigned NOT NULL AFTER `id` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_use_log']}` ADD `pt_id` varchar(255) NOT NULL DEFAULT '' AFTER `od_id` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_use_log']}` ADD `it_name` varchar(255) NOT NULL DEFAULT '' AFTER `it_id` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_use_log']}` ADD `use_file` varchar(255) NOT NULL DEFAULT '' AFTER `it_name` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_use_log']}` ADD `use_cnt` int(11) NOT NULL DEFAULT '0' AFTER `use_file` ", false);
	sql_query(" ALTER TABLE `{$g5['apms_use_log']}` ADD `use_regdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `use_cnt` ", false);

	// 쇼핑몰설정 테이블에 필드 추가
	sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
					ADD `as_thema` varchar(255) NOT NULL DEFAULT 'Basic' AFTER `de_member_reg_coupon_minimum`,
					ADD `as_color` varchar(255) NOT NULL DEFAULT 'Basic' AFTER `as_thema`,
					ADD `as_mobile_thema` varchar(255) NOT NULL DEFAULT 'Basic' AFTER `as_color`,
					ADD `as_mobile_color` varchar(255) NOT NULL DEFAULT 'Basic' AFTER `as_mobile_thema`,
					ADD `as_intro` varchar(255) NOT NULL DEFAULT '' AFTER `as_mobile_color`,
					ADD `as_intro_skin` varchar(255) NOT NULL DEFAULT '' AFTER `as_intro`,
					ADD `as_mobile_intro_skin` varchar(255) NOT NULL DEFAULT '' AFTER `as_intro_skin`,
					ADD `as_partner` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_mobile_intro_skin`,
					ADD `as_point` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_partner`,
					ADD `pt_shingo` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_point`,
					ADD `pt_lucky` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_shingo`,
					ADD `pt_code` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_lucky`,
					ADD `pt_auto` tinyint(4) NOT NULL DEFAULT '10' AFTER `pt_code`,
					ADD `pt_auto_cache` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_auto`,
					ADD `pt_auto_time` int(11) NOT NULL DEFAULT '10' AFTER `pt_auto_cache`,
					ADD `pt_good_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_auto_time`,
					ADD `pt_good_point` int(11) NOT NULL DEFAULT '0' AFTER `pt_good_use`,
					ADD `pt_review_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_good_point`,
					ADD `pt_comment_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_review_use`,
					ADD `pt_comment_sns` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_comment_use`,
					ADD `pt_comment_point` int(11) NOT NULL DEFAULT '0' AFTER `pt_comment_sns`,
					ADD `pt_comment_limit` int(11) NOT NULL DEFAULT '0' AFTER `pt_comment_point`,
					ADD `pt_reserve` int(11) NOT NULL DEFAULT '0' AFTER `pt_comment_limit`,
					ADD `pt_reserve_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_reserve`,
					ADD `pt_reserve_end` int(11) NOT NULL DEFAULT '0' AFTER `pt_reserve_use`,
					ADD `pt_reserve_day` int(11) NOT NULL DEFAULT '0' AFTER `pt_reserve_end`,
					ADD `pt_reserve_cache` int(11) NOT NULL DEFAULT '0' AFTER `pt_reserve_day`,
					ADD `pt_reserve_none` int(11) NOT NULL DEFAULT '24' AFTER `pt_reserve_cache`,
					ADD `pt_img_width` int(11) NOT NULL DEFAULT '600' AFTER `pt_reserve_none`,
					ADD `pt_upload_size` int(11) NOT NULL DEFAULT '10485760' AFTER `pt_img_width` ", false);

	// Intro
	sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `as_intro` varchar(255) NOT NULL DEFAULT '' AFTER `as_mobile_color` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `as_intro_skin` varchar(255) NOT NULL DEFAULT '' AFTER `as_intro` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `as_mobile_intro_skin` varchar(255) NOT NULL DEFAULT '' AFTER `as_intro_skin` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `as_partner` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_mobile_intro_skin` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `as_point` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_partner` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `pt_shingo` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_point` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `pt_lucky` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_shingo` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `pt_code` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_lucky` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `pt_auto` tinyint(4) NOT NULL DEFAULT '10' AFTER `pt_code` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `pt_auto_cache` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_auto` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `pt_auto_time` int(11) NOT NULL DEFAULT '0' AFTER `pt_auto_cache` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` ADD `pt_comment_limit` int(11) NOT NULL DEFAULT '0' AFTER `pt_comment_point` ", false);

	// 장바구니 테이블에 필드 추가
	sql_query(" ALTER TABLE `{$g5['g5_shop_cart_table']}`
					ADD `pt_sale` int(11) NOT NULL DEFAULT '0' AFTER `ct_select_time`,
					ADD `pt_commission` int(11) NOT NULL DEFAULT '0' AFTER `pt_sale`,
					ADD `pt_point` int(11) NOT NULL DEFAULT '0' AFTER `pt_commission`,
					ADD `pt_incentive` int(11) NOT NULL DEFAULT '0' AFTER `pt_point`,
					ADD `pt_net` int(11) NOT NULL DEFAULT '0' AFTER `pt_incentive`,
					ADD `pt_commission_rate` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_net`,
					ADD `pt_incentive_rate` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_commission_rate`,
					ADD `pt_it` tinyint(4) NOT NULL DEFAULT '1' AFTER `pt_incentive_rate`,
					ADD `pt_id` varchar(255) NOT NULL DEFAULT '' AFTER `pt_it`,
					ADD `pt_send` varchar(255) NOT NULL DEFAULT '' AFTER `pt_id`,
					ADD `pt_send_num` varchar(255) NOT NULL DEFAULT '' AFTER `pt_send`,
					ADD `pt_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `pt_send_num` ", false);

	// 장바구니 테이블에 필드 추가 2
	sql_query(" ALTER TABLE `{$g5['g5_shop_cart_table']}` ADD `pt_msg1` varchar(255) NOT NULL DEFAULT '' AFTER `pt_datetime` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_cart_table']}` ADD `pt_msg2` varchar(255) NOT NULL DEFAULT '' AFTER `pt_msg1` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_cart_table']}` ADD `pt_msg3` varchar(255) NOT NULL DEFAULT '' AFTER `pt_msg2` ", false);

	// 장바구니 테이블에 필드 추가 3
	sql_query(" ALTER TABLE `{$g5['g5_shop_cart_table']}` ADD `mk_id` varchar(255) NOT NULL DEFAULT '' AFTER `pt_msg3` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_cart_table']}` ADD `mk_profit` int(11) NOT NULL DEFAULT '0' AFTER `mk_id` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_cart_table']}` ADD `mk_benefit` int(11) NOT NULL DEFAULT '0' AFTER `mk_profit` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_cart_table']}` ADD `mk_profit_rate` int(11) NOT NULL DEFAULT '0' AFTER `mk_benefit` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_cart_table']}` ADD `mk_benefit_rate` int(11) NOT NULL DEFAULT '0' AFTER `mk_profit_rate` ", false);

	// 상품분류 테이블에 필드 추가
	sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}` 
					ADD `as_thema` varchar(255) NOT NULL DEFAULT '' AFTER `ca_10`,
					ADD `as_color` varchar(255) NOT NULL DEFAULT '' AFTER `as_thema`,
					ADD `as_mobile_thema` varchar(255) NOT NULL DEFAULT '' AFTER `as_color`,
					ADD `as_mobile_color` varchar(255) NOT NULL DEFAULT '' AFTER `as_mobile_thema`,
					ADD `as_icon` varchar(255) NOT NULL DEFAULT '' AFTER `as_mobile_color`,
					ADD `as_mobile_icon` varchar(255) NOT NULL DEFAULT '' AFTER `as_icon`,
					ADD `as_main` varchar(255) NOT NULL DEFAULT '' AFTER `as_mobile_icon`,
					ADD `as_title` varchar(255) NOT NULL DEFAULT '' AFTER `as_main`,
					ADD `as_desc` varchar(255) NOT NULL DEFAULT '' AFTER `as_title`,
					ADD `as_link` varchar(255) NOT NULL DEFAULT '' AFTER `as_desc`,
					ADD `as_target` varchar(255) NOT NULL DEFAULT '' AFTER `as_link`,
					ADD `as_line` varchar(255) NOT NULL DEFAULT '' AFTER `as_target`,
					ADD `as_sp` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_line`,
					ADD `as_show` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_sp`,
					ADD `as_order` int(11) NOT NULL DEFAULT '0' AFTER `as_show`,
					ADD `as_menu` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_order`,
					ADD `as_menu_show` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_menu`,
					ADD `as_grade` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_menu_show`,
					ADD `as_equal` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_grade`,
					ADD `as_wide` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_equal`,
					ADD `as_multi` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_wide`,
					ADD `as_partner` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_multi`,
					ADD `as_min` int(11) NOT NULL DEFAULT '0' AFTER `as_partner`,
					ADD `as_max` int(11) NOT NULL DEFAULT '0' AFTER `as_min`,
					ADD `as_list_set` text NOT NULL DEFAULT '' AFTER `as_max`,
					ADD `as_mobile_list_set` text NOT NULL DEFAULT '' AFTER `as_list_set`,
					ADD `as_item_set` text NOT NULL DEFAULT '' AFTER `as_mobile_list_set`,
					ADD `as_mobile_item_set` text NOT NULL DEFAULT '' AFTER `as_item_set`,
					ADD `pt_cate` varchar(255) NOT NULL DEFAULT '' AFTER `as_mobile_item_set`,
					ADD `pt_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_cate`,
					ADD `pt_limit` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_use`, 
					ADD `pt_item` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_limit`, 
					ADD `pt_point` int(11) NOT NULL DEFAULT '0' AFTER `pt_item`, 
					ADD `pt_form` int(11) NOT NULL DEFAULT '0' AFTER `pt_point` ", false);

	// 상품분류 테이블에 필드 추가 - Wide, Multi
	sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}` ADD `as_wide` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_equal` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}` ADD `as_multi` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_wide` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}` ADD `as_line` varchar(255) NOT NULL DEFAULT '' AFTER `as_target` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}` ADD `as_sp` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_line` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}` ADD `as_list_set` text NOT NULL DEFAULT '' AFTER `as_max` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}` ADD `as_mobile_list_set` text NOT NULL DEFAULT '' AFTER `as_list_set` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}` ADD `as_item_set` text NOT NULL DEFAULT '' AFTER `as_mobile_list_set` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}` ADD `as_mobile_item_set` text NOT NULL DEFAULT '' AFTER `as_item_set` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}` ADD `pt_cate` varchar(255) NOT NULL DEFAULT '' AFTER `as_mobile_item_set` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}` ADD `as_order` int(11) NOT NULL DEFAULT '0' AFTER `as_show` ", false);

	// 상품 테이블에 필드 추가
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}`
					ADD `pt_tag` varchar(255) NOT NULL DEFAULT '' AFTER `it_10`,
					ADD `pt_thumb` varchar(255) NOT NULL DEFAULT '' AFTER `pt_tag`,
					ADD `pt_link1` varchar(255) NOT NULL DEFAULT '' AFTER `pt_thumb`,
					ADD `pt_link2` varchar(255) NOT NULL DEFAULT '' AFTER `pt_link1`,
					ADD `pt_map` varchar(255) NOT NULL DEFAULT '' AFTER `pt_link2`,
					ADD `pt_id` varchar(255) NOT NULL DEFAULT '' AFTER `pt_map`,
					ADD `pt_it` tinyint(4) NOT NULL DEFAULT '1' AFTER `pt_id`,
					ADD `pt_ccl` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_it`,
					ADD `pt_img` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_ccl`,
					ADD `pt_file` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_img`,
					ADD `pt_main` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_file`,
					ADD `pt_point` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_main`,
					ADD `pt_order` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_point`,
					ADD `pt_commission` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_order`,
					ADD `pt_incentive` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_commission`,
					ADD `pt_marketer` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_incentive`,
					ADD `pt_review_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_marketer`,
					ADD `pt_comment_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_review_use`,
					ADD `pt_comment` int(11) NOT NULL DEFAULT '0' AFTER `pt_comment_use`,
					ADD `pt_qa` int(11) NOT NULL DEFAULT '0' AFTER `pt_comment`,
					ADD `pt_good` int(11) NOT NULL DEFAULT '0' AFTER `pt_qa`,
					ADD `pt_nogood` int(11) NOT NULL DEFAULT '0' AFTER `pt_good`,
					ADD `pt_show` int(11) NOT NULL DEFAULT '0' AFTER `pt_nogood`,
					ADD `pt_num` int(11) NOT NULL DEFAULT '0' AFTER `pt_show`,
					ADD `pt_end` int(11) NOT NULL DEFAULT '0' AFTER `pt_num`,
					ADD `pt_reserve` int(11) NOT NULL DEFAULT '0' AFTER `pt_end`,
					ADD `pt_reserve_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_reserve`,
					ADD `pt_syndi` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_reserve_use`,
					ADD `pt_explan` mediumtext NOT NULL DEFAULT '' AFTER `pt_syndi`,
					ADD `pt_mobile_explan` mediumtext NOT NULL DEFAULT '' AFTER `pt_explan`,
					ADD `pt_msg1` varchar(255) NOT NULL DEFAULT '' AFTER `pt_mobile_explan`,
					ADD `pt_msg2` varchar(255) NOT NULL DEFAULT '' AFTER `pt_msg1`,
					ADD `pt_msg3` varchar(255) NOT NULL DEFAULT '' AFTER `pt_msg2` ", false);


	// 상품 테이블에 필드 추가 1 - Show Order
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` ADD `pt_show` int(11) NOT NULL DEFAULT '0' AFTER `pt_nogood` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` ADD `pt_day` int(11) NOT NULL DEFAULT '0' AFTER `pt_num` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` ADD `pt_syndi` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_reserve_use` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` ADD `pt_marketer` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_incentive` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` ADD `pt_file` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_img` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` ADD `pt_main` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_file` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` ADD `pt_point` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_main` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` ADD `pt_qa` int(11) NOT NULL DEFAULT '0' AFTER `pt_comment` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` ADD `pt_map` varchar(255) NOT NULL DEFAULT '' AFTER `pt_link2` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` ADD `pt_thumb` varchar(255) NOT NULL DEFAULT '' AFTER `pt_tag` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` ADD `pt_msg1` varchar(255) NOT NULL DEFAULT '' AFTER `pt_mobile_explan` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` ADD `pt_msg2` varchar(255) NOT NULL DEFAULT '' AFTER `pt_msg1` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` ADD `pt_msg3` varchar(255) NOT NULL DEFAULT '' AFTER `pt_msg2` ", false);

	// 상품 사용후기 테이블에 필드 추가
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_use_table']}`
					ADD `pt_it` tinyint(4) NOT NULL DEFAULT '1' AFTER `is_confirm`,
					ADD `pt_photo` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_it`,
					ADD `pt_id` varchar(255) NOT NULL DEFAULT '' AFTER `pt_photo` ", false);

	sql_query(" ALTER TABLE `{$g5['g5_shop_item_use_table']}` ADD `pt_photo` tinyint(4) NOT NULL DEFAULT '0' AFTER `pt_it` ", false);

	// 상품 질문답변 테이블에 필드 추가
	sql_query(" ALTER TABLE `{$g5['g5_shop_item_qa_table']}`
					ADD `pt_it` tinyint(4) NOT NULL DEFAULT '1' AFTER `iq_ip`,
					ADD `pt_id` varchar(255) NOT NULL DEFAULT '' AFTER `pt_it` ", false);

	// 이벤트 테이블에 필드 추가
	sql_query(" ALTER TABLE `{$g5['g5_shop_event_table']}` ADD `ev_type` int(11) NOT NULL DEFAULT '0' AFTER `ev_use` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_event_table']}` ADD `ev_href` varchar(255) NOT NULL DEFAULT '' AFTER `ev_type` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_event_table']}` ADD `ev_set` text NOT NULL DEFAULT '' AFTER `ev_href` ", false);
	sql_query(" ALTER TABLE `{$g5['g5_shop_event_table']}` ADD `ev_mobile_set` text NOT NULL DEFAULT '' AFTER `ev_set` ", false);

	// 주문서 테이블에 필드 추가
	// od_receipt_time, od_status(입금), od_misu(0) Update 
	sql_query(" ALTER TABLE `{$g5['g5_shop_order_table']}`
					ADD `pt_case` varchar(255) NOT NULL DEFAULT '' AFTER `od_ip`,
					ADD `pt_price` varchar(255) NOT NULL DEFAULT '' AFTER `pt_case`,
					ADD `pt_memo` varchar(255) NOT NULL DEFAULT '' AFTER `pt_price` ", false);

} // IS_YC

// Event
$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_event']}` (
			`ev_id` int(11) NOT NULL AUTO_INCREMENT,
			`bo_table` varchar(20) NOT NULL default '',
			`wr_id` int(11) NOT NULL default '0',
			`mb_id` varchar(255) NOT NULL default '',
			`ev_point` int(11) NOT NULL default '0',
			`ev_win` tinyint(4) NOT NULL default '0',
			`ev_confirm` tinyint(4) NOT NULL default '0',
			`ev_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`ev_id`),
			KEY `mb_id` (`mb_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
sql_query($sql, false);

// Tag Log
$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_tag_log']}` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`it_id` varchar(20) NOT NULL DEFAULT '',
			`bo_table` varchar(20) NOT NULL DEFAULT '',
			`wr_id` int(11) NOT NULL default '0',
			`tag_id` int(11) NOT NULL DEFAULT '0',
			`tag` varchar(255) NOT NULL DEFAULT '',
			`mb_id` varchar(255) NOT NULL DEFAULT '',
			`regdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			`it_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
sql_query($sql, false);

// Tag Log - POST
sql_query(" ALTER TABLE `{$g5['apms_tag_log']}` ADD `bo_table` varchar(20) NOT NULL DEFAULT '' AFTER `it_id` ", false);
sql_query(" ALTER TABLE `{$g5['apms_tag_log']}` ADD `wr_id` int(11) NOT NULL DEFAULT '0' AFTER `bo_table` ", false);
sql_query(" ALTER TABLE `{$g5['apms_tag_log']}` ADD `mb_id` varchar(255) NOT NULL DEFAULT '' AFTER `tag` ", false);

// Tag
$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_tag']}` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`type` tinyint(4) NOT NULL DEFAULT '0',
			`idx` varchar(10) NOT NULL DEFAULT '',
			`tag` varchar(255) NOT NULL DEFAULT '',
			`cnt` int(11) NOT NULL DEFAULT '0',
			`desc` text NOT NULL DEFAULT '',
			`regdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			`lastdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			PRIMARY KEY  (`id`),
			KEY tag (tag, lastdate)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
sql_query($sql, false);

// Poll
$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_poll']}` (
			`po_id` int(11) NOT NULL auto_increment,
			`bo_table` varchar(20) NOT NULL DEFAULT '',
			`wr_id` int(11) NOT NULL default '0',
			`po_subject` varchar(255) NOT NULL default '',
			`po_poll1` varchar(255) NOT NULL default '',
			`po_poll2` varchar(255) NOT NULL default '',
			`po_poll3` varchar(255) NOT NULL default '',
			`po_poll4` varchar(255) NOT NULL default '',
			`po_poll5` varchar(255) NOT NULL default '',
			`po_poll6` varchar(255) NOT NULL default '',
			`po_poll7` varchar(255) NOT NULL default '',
			`po_poll8` varchar(255) NOT NULL default '',
			`po_poll9` varchar(255) NOT NULL default '',
			`po_score` int(11) NOT NULL default '0',
			`po_cnt` int(11) NOT NULL default '0',
			`po_cnt1` int(11) NOT NULL default '0',
			`po_cnt2` int(11) NOT NULL default '0',
			`po_cnt3` int(11) NOT NULL default '0',
			`po_cnt4` int(11) NOT NULL default '0',
			`po_cnt5` int(11) NOT NULL default '0',
			`po_cnt6` int(11) NOT NULL default '0',
			`po_cnt7` int(11) NOT NULL default '0',
			`po_cnt8` int(11) NOT NULL default '0',
			`po_cnt9` int(11) NOT NULL default '0',
			`po_use` tinyint(4) NOT NULL default '0',
			`po_type` tinyint(4) NOT NULL default '0',
			`po_ans` tinyint(4) NOT NULL default '0',
			`po_end` tinyint(4) NOT NULL default '0',
			`po_level` tinyint(4) NOT NULL default '0',
			`po_join` int(11) NOT NULL default '0',
			`po_point` int(11) NOT NULL default '0',
			`po_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
			`po_endtime` datetime NOT NULL default '0000-00-00 00:00:00',
			`po_ips` mediumtext NOT NULL,
			`mb_ids` text NOT NULL,
			`po_content` text NOT NULL,
		PRIMARY KEY  (`po_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
sql_query($sql, false);

// Cache
$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_cache']}` (
			`c_id` int(11) NOT NULL AUTO_INCREMENT,
			`c_name` varchar(255) NOT NULL,
			`c_text` text NOT NULL,
			`c_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY (`c_id`),
			UNIQUE KEY `c_name` (`c_name`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
sql_query($sql, false);

// Response
$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_response']}` (
			`id` int(11) NOT NULL auto_increment,
			`it_id` varchar(20) NOT NULL default '',
			`bo_table` varchar(20) NOT NULL default '',
			`wr_id` int(11) NOT NULL default '0',
			`co_id` int(11) NOT NULL default '0',
			`subject` varchar(255) NOT NULL default '',
			`mb_id` varchar(255) NOT NULL default '',
			`my_id` varchar(255) NOT NULL default '',
			`my_name` varchar(255) NOT NULL default '',
			`reply_cnt` int(11) NOT NULL default '0',
			`comment_cnt` int(11) NOT NULL default '0',
			`comment_reply_cnt` int(11) NOT NULL default '0',
			`good_cnt` int(11) NOT NULL default '0',
			`nogood_cnt` int(11) NOT NULL default '0',
			`use_cnt` int(11) NOT NULL default '0',
			`qa_cnt` int(11) NOT NULL default '0',
			`type` tinyint(4) NOT NULL default '0',
			`confirm` tinyint(4) NOT NULL default '0',
			`regdate` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`id`),
			KEY `mb_id` (`mb_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";

sql_query($sql, false);

sql_query(" ALTER TABLE `{$g5['apms_response']}` ADD `co_id` int(11) NOT NULL DEFAULT '0' AFTER `wr_id` ", false);

// XP
$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_xp']}` (
			`xp_now` tinyint(4) NOT NULL default '0',
			`xp_point` int(11) NOT NULL default '1000',
			`xp_rate` decimal(9,3) NOT NULL default '0.1',
			`xp_max` int(11) NOT NULL default '99',
			`xp_icon` varchar(20) NOT NULL default 'txt',
			`xp_icon_skin` varchar(255) NOT NULL default 'zb4',
			`xp_icon_css` varchar(255) NOT NULL default 'basic',
			`xp_icon_admin` varchar(255) NOT NULL default 'M',
			`xp_icon_guest` varchar(255) NOT NULL default 'G',
			`xp_icon_special` varchar(255) NOT NULL default 'S',
			`xp_special` varchar(255) NOT NULL default '',
			`xp_except` varchar(255) NOT NULL default '',
			`xp_designer` varchar(255) NOT NULL default '',
			`xp_manager` varchar(255) NOT NULL default '',
			`xp_photo` int(11) NOT NULL default '80',
			`xp_photo_url` varchar(255) NOT NULL default '',
			`xp_grade1` varchar(255) NOT NULL default '비회원',
			`xp_grade2` varchar(255) NOT NULL default '실버',
			`xp_grade3` varchar(255) NOT NULL default '골드',
			`xp_grade4` varchar(255) NOT NULL default '로열',
			`xp_grade5` varchar(255) NOT NULL default '프렌드',
			`xp_grade6` varchar(255) NOT NULL default '패밀리',
			`xp_grade7` varchar(255) NOT NULL default '스페셜',
			`xp_grade8` varchar(255) NOT NULL default '운영자',
			`xp_grade9` varchar(255) NOT NULL default '관리자',
			`xp_grade10` varchar(255) NOT NULL default '최고관리자',
			`xp_auto1` smallint(6) NOT NULL default '0',
			`xp_auto2` smallint(6) NOT NULL default '0',
			`xp_auto3` smallint(6) NOT NULL default '0',
			`xp_auto4` smallint(6) NOT NULL default '0',
			`xp_auto5` smallint(6) NOT NULL default '0',
			`xp_auto6` smallint(6) NOT NULL default '0',
			`xp_auto7` smallint(6) NOT NULL default '0',
			`xp_from` tinyint(4) NOT NULL default '0',
			`xp_to` tinyint(4) NOT NULL default '0',
			`exp_point` tinyint(4) NOT NULL default '0',
			`exp_login` tinyint(4) NOT NULL default '1',
			`exp_write` tinyint(4) NOT NULL default '1',
			`exp_comment` tinyint(4) NOT NULL default '1',
			`exp_read` tinyint(4) NOT NULL default '0',
			`exp_good` tinyint(4) NOT NULL default '0',
			`exp_nogood` tinyint(4) NOT NULL default '0',
			`exp_chulsuk` tinyint(4) NOT NULL default '0',
			`exp_delivery` tinyint(4) NOT NULL default '1',
			`item_cnt` tinyint(4) NOT NULL default '0',
			`https_url` tinyint(4) NOT NULL default '0',
			`editor_img` tinyint(4) NOT NULL default '1',
			`comment_limit` int(11) NOT NULL default '0',
			`lucky_point` int(11) NOT NULL default '50',
			`lucky_dice` tinyint(4) NOT NULL default '10',
			`lucky_msg` text NOT NULL default '',
			`auto_size` varchar(255) NOT NULL default '800px',
			`jwplayer_key` varchar(255) NOT NULL default '',
			`facebook_token` varchar(255) NOT NULL default '',
			`google_map_key` varchar(255) NOT NULL default '',
			`seo_img` varchar(255) NOT NULL default '',
			`seo_key` text NOT NULL default '',
			`seo_desc` text NOT NULL default ''
		) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";

sql_query($sql, false);

// XP Plus
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `xp_photo_url` varchar(255) NOT NULL DEFAULT '' AFTER `xp_photo` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `xp_designer` varchar(255) NOT NULL DEFAULT '' AFTER `xp_except` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `xp_manager` varchar(255) NOT NULL DEFAULT '' AFTER `xp_designer` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `xp_icon_css` varchar(255) NOT NULL DEFAULT 'basic' AFTER `xp_icon_skin` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `xp_icon_admin` varchar(255) NOT NULL DEFAULT 'M' AFTER `xp_icon_css` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `xp_icon_guest` varchar(255) NOT NULL DEFAULT 'G' AFTER `xp_icon_admin` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `xp_icon_special` varchar(255) NOT NULL DEFAULT 'S' AFTER `xp_icon_guest` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `item_cnt` tinyint(4) NOT NULL DEFAULT '0' AFTER `exp_delivery` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `https_url` tinyint(4) NOT NULL DEFAULT '0' AFTER `item_cnt` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `editor_img` tinyint(4) NOT NULL DEFAULT '1' AFTER `https_url` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `comment_limit` int(11) NOT NULL DEFAULT '0' AFTER `editor_img` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `lucky_point` int(11) NOT NULL DEFAULT '50' AFTER `comment_limit` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `lucky_dice` tinyint(4) NOT NULL DEFAULT '10' AFTER `lucky_point` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `lucky_msg` text NOT NULL DEFAULT '' AFTER `lucky_dice` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `auto_size` varchar(255) NOT NULL DEFAULT '800px' AFTER `lucky_msg` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `jwplayer_key` varchar(255) NOT NULL DEFAULT '' AFTER `auto_size` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `facebook_token` varchar(255) NOT NULL DEFAULT '' AFTER `jwplayer_key` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `google_map_key` varchar(255) NOT NULL DEFAULT '' AFTER `facebook_token` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `seo_img` varchar(255) NOT NULL DEFAULT '' AFTER `google_map_key` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `seo_key` text NOT NULL DEFAULT '' AFTER `seo_img` ", false);
sql_query(" ALTER TABLE `{$g5['apms_xp']}` ADD `seo_desc` text NOT NULL DEFAULT '' AFTER `seo_key` ", false);

// Like & Follow
$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_like']}` (
			`id` int(11) NOT NULL auto_increment,
			`mb_id` varchar(255) NOT NULL default '',
			`to_id` varchar(255) NOT NULL default '',
			`flag` varchar(20) NOT NULL default '',
			`regdate` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";

sql_query($sql, false);

//Shingo Table
$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_shingo']}` (
			`id` int(11) NOT NULL auto_increment,
			`bo_table` varchar(20) NOT NULL default '',
			`wr_id` int(11) NOT NULL default '0',
			`wr_parent` int(11) NOT NULL default '0',
			`mb_id` varchar(255) NOT NULL default '',
			`flag` tinyint(4) NOT NULL default '0',
			`datetime` datetime NOT NULL default '0000-00-00 00:00:00',
			`ip` varchar(20) NOT NULL default '',
			PRIMARY KEY  (`id`),
			UNIQUE KEY `fkey1` (`bo_table`,`wr_id`,`mb_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";

sql_query($sql, false);

//Playlist Table
$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_playlist']}` (
			`pl_id` int(11) NOT NULL auto_increment,
			`bo_table` varchar(20) NOT NULL default '',
			`wr_id` int(11) NOT NULL default '0',
			`mb_id` varchar(255) NOT NULL default '',
			`pl_order` int(11) NOT NULL default '0',
			`pl_flag` tinyint(4) NOT NULL default '0',
			`pl_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`pl_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";

sql_query($sql, false);

// Page
$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_page']}` (
			`id` int(11) NOT NULL auto_increment,
			`gr_id` varchar(20) NOT NULL default '',
			`co_id` varchar(20) NOT NULL default '',
			`html_id` varchar(255) NOT NULL default '',
			`bo_subject` varchar(255) NOT NULL default '',
			`bo_mobile_subject` varchar(255) NOT NULL default '',
			`bo_device` ENUM('both','pc','mobile') NOT NULL default 'both',
			`as_html` tinyint(4) NOT NULL default '1',
			`as_file` varchar(255) NOT NULL default '',
			`as_title` varchar(255) NOT NULL default '',
			`as_desc` varchar(255) NOT NULL default '',
			`as_icon` varchar(255) NOT NULL default '',
			`as_mobile_icon` varchar(255) NOT NULL default '',
			`as_link` varchar(255) NOT NULL default '',
			`as_target` varchar(255) NOT NULL default '',
			`as_head` varchar(255) NOT NULL default '',
			`as_hcolor` varchar(255) NOT NULL default '',
			`as_skin` varchar(255) NOT NULL default '',
			`as_line` varchar(255) NOT NULL default '',
			`as_sp` tinyint(4) NOT NULL default '0',
			`as_show` tinyint(4) NOT NULL default '0',
			`as_order` tinyint(4) NOT NULL default '0',
			`as_menu` tinyint(4) NOT NULL default '0',
			`as_menu_show` tinyint(4) NOT NULL default '0',
			`as_grade` tinyint(4) NOT NULL default '0',
			`as_equal` tinyint(4) NOT NULL default '0',
			`as_wide` tinyint(4) NOT NULL default '0',
			`as_partner` tinyint(4) NOT NULL default '0',
			`as_min` int(11) NOT NULL default '0',
			`as_max` int(11) NOT NULL default '0',
			`as_code` int(11) NOT NULL default '0',
			`as_content` text NOT NULL default '',
			`as_mobile_content` text NOT NULL default '',
			PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";

sql_query($sql, false);

// Page
sql_query(" ALTER TABLE `{$g5['apms_page']}` ADD `as_wide` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_equal` ", false);
sql_query(" ALTER TABLE `{$g5['apms_page']}` ADD `as_head` varchar(255) NOT NULL DEFAULT '' AFTER `as_target` ", false);
sql_query(" ALTER TABLE `{$g5['apms_page']}` ADD `as_hcolor` varchar(255) NOT NULL DEFAULT '' AFTER `as_head` ", false);
sql_query(" ALTER TABLE `{$g5['apms_page']}` ADD `as_skin` varchar(255) NOT NULL DEFAULT '' AFTER `as_hcolor` ", false);
sql_query(" ALTER TABLE `{$g5['apms_page']}` ADD `as_line` varchar(255) NOT NULL DEFAULT '' AFTER `as_skin` ", false);
sql_query(" ALTER TABLE `{$g5['apms_page']}` ADD `as_sp` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_line` ", false);
sql_query(" ALTER TABLE `{$g5['apms_page']}` ADD `as_code` int(11) NOT NULL DEFAULT '0' AFTER `as_max` ", false);
sql_query(" ALTER TABLE `{$g5['apms_page']}` ADD `as_menu` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_order` ", false);
sql_query(" ALTER TABLE `{$g5['apms_page']}` ADD `as_content` text NOT NULL DEFAULT '' AFTER `as_code` ", false);
sql_query(" ALTER TABLE `{$g5['apms_page']}` ADD `as_mobile_content` text NOT NULL DEFAULT '' AFTER `as_content` ", false);

// Data
$sql = " CREATE TABLE IF NOT EXISTS `{$g5['apms_data']}` (
			`id` int(11) NOT NULL auto_increment,
			`type` tinyint(4) NOT NULL default '0',
			`data_q` varchar(255) NOT NULL default '',
			`data_1` varchar(255) NOT NULL default '',
			`data_2` varchar(255) NOT NULL default '',
			`data_3` varchar(255) NOT NULL default '',
			`data_4` varchar(255) NOT NULL default '',
			`data_5` varchar(255) NOT NULL default '',
			`data_6` varchar(255) NOT NULL default '',
			`data_7` varchar(255) NOT NULL default '',
			`data_8` varchar(255) NOT NULL default '',
			`data_9` varchar(255) NOT NULL default '',
			`data_10` varchar(255) NOT NULL default '',
			`data_set` text NOT NULL default '',
			PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";

sql_query($sql, false);

// 1:1
sql_query(" ALTER TABLE `{$g5['qa_config_table']}` ADD `as_admin` varchar(255) NOT NULL DEFAULT '' AFTER `qa_5` ", false);
sql_query(" ALTER TABLE `{$g5['qa_config_table']}` ADD `as_editor` varchar(255) NOT NULL DEFAULT '' AFTER `as_admin` ", false);
sql_query(" ALTER TABLE `{$g5['qa_config_table']}` ADD `as_mobile_editor` varchar(255) NOT NULL DEFAULT '' AFTER `as_editor` ", false);

// Config
sql_query(" ALTER TABLE `{$g5['config_table']}`
				ADD `as_thema` varchar(255) NOT NULL DEFAULT 'Basic' AFTER `cf_10`,
				ADD `as_color` varchar(255) NOT NULL DEFAULT 'Basic' AFTER `as_thema`,
				ADD `as_mobile_thema` varchar(255) NOT NULL DEFAULT 'Basic' AFTER `as_color`,
				ADD `as_mobile_color` varchar(255) NOT NULL DEFAULT 'Basic' AFTER `as_mobile_thema`,
				ADD `as_admin` varchar(255) NOT NULL DEFAULT '' AFTER `as_mobile_color`,
				ADD `as_intro` varchar(255) NOT NULL DEFAULT '' AFTER `as_admin`,
				ADD `as_intro_skin` varchar(255) NOT NULL DEFAULT '' AFTER `as_intro`,
				ADD `as_mobile_intro_skin` varchar(255) NOT NULL DEFAULT '' AFTER `as_intro_skin`,
				ADD `as_tag_skin` varchar(255) NOT NULL DEFAULT 'basic' AFTER `as_mobile_intro_skin`,
				ADD `as_mobile_tag_skin` varchar(255) NOT NULL DEFAULT 'basic' AFTER `as_tag_skin`,
				ADD `as_misc_skin` varchar(255) NOT NULL DEFAULT 'basic' AFTER `as_mobile_tag_skin`,
				ADD `as_lang` varchar(255) NOT NULL DEFAULT 'korean' AFTER `as_misc_skin`,
				ADD `as_gnu` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_lang`,
				ADD `as_xp` varchar(255) NOT NULL DEFAULT 'XP' AFTER `as_gnu`,
				ADD `as_mp` varchar(255) NOT NULL DEFAULT 'MP' AFTER `as_xp` ", false);

// Intro
sql_query(" ALTER TABLE `{$g5['config_table']}` ADD `as_intro` varchar(255) NOT NULL DEFAULT '' AFTER `as_admin` ", false);
sql_query(" ALTER TABLE `{$g5['config_table']}` ADD `as_intro_skin` varchar(255) NOT NULL DEFAULT '' AFTER `as_intro` ", false);
sql_query(" ALTER TABLE `{$g5['config_table']}` ADD `as_mobile_intro_skin` varchar(255) NOT NULL DEFAULT '' AFTER `as_intro_skin` ", false);
sql_query(" ALTER TABLE `{$g5['config_table']}` ADD `as_tag_skin` varchar(255) NOT NULL DEFAULT 'basic' AFTER `as_mobile_intro_skin` ", false);
sql_query(" ALTER TABLE `{$g5['config_table']}` ADD `as_mobile_tag_skin` varchar(255) NOT NULL DEFAULT 'basic' AFTER `as_tag_skin` ", false);
sql_query(" ALTER TABLE `{$g5['config_table']}` ADD `as_misc_skin` varchar(255) NOT NULL DEFAULT 'basic' AFTER `as_mobile_tag_skin` ", false);
sql_query(" ALTER TABLE `{$g5['config_table']}` ADD `as_lang` varchar(255) NOT NULL DEFAULT 'korean' AFTER `as_misc_skin` ", false);
sql_query(" ALTER TABLE `{$g5['config_table']}` ADD `as_gnu` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_lang` ", false);

// Group
sql_query(" ALTER TABLE `{$g5['group_table']}`
				ADD `as_thema` varchar(255) NOT NULL DEFAULT '' AFTER `gr_10`,
				ADD `as_color` varchar(255) NOT NULL DEFAULT '' AFTER `as_thema`,
				ADD `as_mobile_thema` varchar(255) NOT NULL DEFAULT '' AFTER `as_color`,
				ADD `as_mobile_color` varchar(255) NOT NULL DEFAULT '' AFTER `as_mobile_thema`,
				ADD `as_icon` varchar(255) NOT NULL DEFAULT '' AFTER `as_mobile_color`,
				ADD `as_mobile_icon` varchar(255) NOT NULL DEFAULT '' AFTER `as_icon`,
				ADD `as_main` varchar(255) NOT NULL DEFAULT '' AFTER `as_mobile_icon`,
				ADD `as_mobile_main` varchar(255) NOT NULL DEFAULT '' AFTER `as_main`,
				ADD `as_link` varchar(255) NOT NULL DEFAULT '' AFTER `as_mobile_main`,
				ADD `as_target` varchar(255) NOT NULL DEFAULT '' AFTER `as_link`,
				ADD `as_show` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_target`,
				ADD `as_shop` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_show`,
				ADD `as_menu` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_shop`,
				ADD `as_menu_show` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_menu`,
				ADD `as_grade` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_menu_show`,
				ADD `as_equal` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_grade`,
				ADD `as_wide` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_equal`,
				ADD `as_multi` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_wide`,
				ADD `as_partner` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_multi`,
				ADD `as_min` int(11) NOT NULL DEFAULT '0' AFTER `as_partner`,
				ADD `as_max` int(11) NOT NULL DEFAULT '0' AFTER `as_min` ", false);

// Group - Shop, Wide, Multi
sql_query(" ALTER TABLE `{$g5['group_table']}` ADD `as_shop` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_show` ", false);
sql_query(" ALTER TABLE `{$g5['group_table']}` ADD `as_wide` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_equal` ", false);
sql_query(" ALTER TABLE `{$g5['group_table']}` ADD `as_multi` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_wide` ", false);
sql_query(" ALTER TABLE `{$g5['group_table']}` ADD `as_mobile_main` varchar(255) NOT NULL DEFAULT '' AFTER `as_main` ", false);

// Group as_main column drop
sql_query(" ALTER TABLE `{$g5['group_table']}` DROP COLUMN `as_group_skin` ", false);

// Board
sql_query(" ALTER TABLE `{$g5['board_table']}`
				ADD `as_title` varchar(255) NOT NULL DEFAULT '' AFTER `bo_10`,
				ADD `as_desc` varchar(255) NOT NULL DEFAULT '' AFTER `as_title`,
				ADD `as_icon` varchar(255) NOT NULL DEFAULT '' AFTER `as_desc`,
				ADD `as_mobile_icon` varchar(255) NOT NULL DEFAULT '' AFTER `as_icon`,
				ADD `as_main` varchar(255) NOT NULL DEFAULT '' AFTER `as_mobile_icon`,
				ADD `as_link` varchar(255) NOT NULL DEFAULT '' AFTER `as_main`,
				ADD `as_target` varchar(255) NOT NULL DEFAULT '' AFTER `as_link`,
				ADD `as_line` varchar(255) NOT NULL DEFAULT '' AFTER `as_target`,
				ADD `as_sp` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_line`,
				ADD `as_show` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_sp`,
				ADD `as_order` int(11) NOT NULL DEFAULT '0' AFTER `as_show`,
				ADD `as_menu` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_order`,
				ADD `as_menu_show` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_menu`,
				ADD `as_grade` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_menu_show`,
				ADD `as_equal` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_grade`,
				ADD `as_wide` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_equal`,
				ADD `as_partner` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_wide`,
				ADD `as_autoplay` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_partner`,
				ADD `as_torrent` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_autoplay`,
				ADD `as_shingo` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_torrent`,
				ADD `as_level` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_shingo`,
				ADD `as_lucky` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_level`,
				ADD `as_good` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_lucky`,
				ADD `as_save` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_good`,
				ADD `as_code` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_save`,
				ADD `as_exif` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_code`,
				ADD `as_loc` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_exif`,
				ADD `as_new` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_loc`,
				ADD `as_notice` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_new`,
				ADD `as_search` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_notice`,
				ADD `as_lightbox` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_search`,
				ADD `as_rev_cmt` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_lightbox`,
				ADD `as_best_cmt` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_rev_cmt`,
				ADD `as_rank_cmt` tinyint(4) NOT NULL DEFAULT '3' AFTER `as_best_cmt`,
				ADD `as_purifier` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_rank_cmt`,
				ADD `as_resize` int(11) NOT NULL DEFAULT '0' AFTER `as_purifier`,
				ADD `as_resize_kb` int(11) NOT NULL DEFAULT '0' AFTER `as_resize`,
				ADD `as_min` int(11) NOT NULL DEFAULT '0' AFTER `as_resize_kb`,
				ADD `as_max` int(11) NOT NULL DEFAULT '0' AFTER `as_min`,
				ADD `as_comment_rows` int(11) NOT NULL DEFAULT '0' AFTER `as_max`,
				ADD `as_comment_mobile_rows` int(11) NOT NULL DEFAULT '0' AFTER `as_comment_rows`,
				ADD `as_editor` varchar(255) NOT NULL DEFAULT '' AFTER `as_comment_mobile_rows`,
				ADD `as_mobile_editor` varchar(255) NOT NULL DEFAULT '' AFTER `as_editor`,
				ADD `as_set` text NOT NULL DEFAULT '' AFTER `as_mobile_editor`,
				ADD `as_mobile_set` text NOT NULL DEFAULT '' AFTER `as_set` ", false);

// Shingo & Setup
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_wide` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_equal` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_shingo` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_torrent` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_level` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_shingo` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_lucky` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_level` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_good` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_lucky` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_save` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_good` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_code` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_save` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_exif` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_code` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_loc` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_exif` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_new` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_loc` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_notice` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_new` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_search` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_notice` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_lightbox` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_search` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_rev_cmt` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_lightbox` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_best_cmt` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_rev_cmt` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_rank_cmt` tinyint(4) NOT NULL DEFAULT '3' AFTER `as_best_cmt` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_purifier` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_rank_cmt` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_resize` int(11) NOT NULL DEFAULT '0' AFTER `as_purifier` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_resize_kb` int(11) NOT NULL DEFAULT '0' AFTER `as_resize` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_line` varchar(255) NOT NULL DEFAULT '' AFTER `as_target` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_sp` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_line` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_editor` varchar(255) NOT NULL DEFAULT '' AFTER `as_comment_mobile_rows` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_mobile_editor` varchar(255) NOT NULL DEFAULT '' AFTER `as_editor` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_set` text NOT NULL DEFAULT '' AFTER `as_mobile_editor` ", false);
sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `as_mobile_set` text NOT NULL DEFAULT '' AFTER `as_set` ", false);

// Menu Order
sql_query(" ALTER TABLE `{$g5['board_table']}` CHANGE `as_order` `as_order` int(11) NOT NULL DEFAULT '0' ", false);

// Write
$result = sql_query(" select bo_table from `{$g5['board_table']}` ");
for ($i=0; $row=sql_fetch_array($result); $i++) {
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_type` tinyint(4) NOT NULL DEFAULT '0' AFTER `wr_10` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_shingo` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_type` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_img` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_shingo` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_list` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_img` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_publish` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_list` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_extra` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_publish` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_extend` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_extra` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_level` int(11) NOT NULL DEFAULT '1' AFTER `as_extend` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_download` int(11) NOT NULL DEFAULT '0' AFTER `as_level` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_down` int(11) NOT NULL DEFAULT '0' AFTER `as_download` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_view` int(11) NOT NULL DEFAULT '0' AFTER `as_down` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_lucky` int(11) NOT NULL DEFAULT '0' AFTER `as_view` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_poll` int(11) NOT NULL DEFAULT '0' AFTER `as_lucky` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_star_score` int(11) NOT NULL DEFAULT '0' AFTER `as_poll` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_star_cnt` int(11) NOT NULL DEFAULT '0' AFTER `as_star_score` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_choice` int(11) NOT NULL DEFAULT '0' AFTER `as_star_cnt` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` DROP COLUMN `as_choice_mb` ", false);
	//sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_choice_mb` varchar(255) NOT NULL DEFAULT '' AFTER `as_choice` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_choice_cnt` int(11) NOT NULL DEFAULT '0' AFTER `as_choice` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_re_mb` varchar(255) NOT NULL DEFAULT '' AFTER `as_choice_cnt` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_re_name` varchar(255) NOT NULL AFTER `as_re_mb` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_tag` varchar(255) NOT NULL AFTER `as_re_name` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_map` varchar(255) NOT NULL AFTER `as_tag` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_icon` varchar(255) NOT NULL AFTER `as_map` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_thumb` varchar(255) NOT NULL AFTER `as_icon` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_video` varchar(255) NOT NULL AFTER `as_thumb` ", false);
	sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}` ADD `as_update` datetime NOT NULL default '0000-00-00 00:00:00' AFTER `as_video` ", false);
}

// New
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_type` tinyint(4) NOT NULL DEFAULT '0'  AFTER `mb_id`", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_list` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_type` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_secret` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_list` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_publish` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_secret` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_extra` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_publish` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_comment` int(11) NOT NULL DEFAULT '0' AFTER `as_extra` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_hit` int(11) NOT NULL DEFAULT '0' AFTER `as_comment` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_good` int(11) NOT NULL DEFAULT '0' AFTER `as_hit` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_nogood` int(11) NOT NULL DEFAULT '0' AFTER `as_good` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_download` int(11) NOT NULL DEFAULT '0' AFTER `as_nogood` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_link` int(11) NOT NULL DEFAULT '0' AFTER `as_download` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_poll` int(11) NOT NULL DEFAULT '0' AFTER `as_link` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_event` int(11) NOT NULL DEFAULT '0' AFTER `as_poll` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_lucky` int(11) NOT NULL DEFAULT '0' AFTER `as_event` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_reply` varchar(10) NOT NULL DEFAULT '' AFTER `as_lucky` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_re_mb` varchar(255) NOT NULL DEFAULT '' AFTER `as_reply` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_video` varchar(255) NOT NULL DEFAULT '' AFTER `as_re_mb` ", false);
sql_query(" ALTER TABLE `{$g5['board_new_table']}` ADD `as_update` datetime NOT NULL default '0000-00-00 00:00:00' AFTER `as_video` ", false);

// Member
sql_query(" ALTER TABLE `{$g5['member_table']}`
				ADD `as_msg` tinyint(4) NOT NULL DEFAULT '0' AFTER `mb_10`,
				ADD `as_photo` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_msg`,
				ADD `as_partner` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_photo`,
				ADD `as_marketer` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_partner`,
				ADD `as_exp` int(11) NOT NULL DEFAULT '0' AFTER `as_marketer`,
				ADD `as_level` int(11) NOT NULL DEFAULT '1' AFTER `as_exp`,
				ADD `as_like` int(11) NOT NULL DEFAULT '0' AFTER `as_level`,
				ADD `as_liked` int(11) NOT NULL DEFAULT '0' AFTER `as_like`,
				ADD `as_follow` int(11) NOT NULL DEFAULT '0' AFTER `as_liked`,
				ADD `as_followed` int(11) NOT NULL DEFAULT '0' AFTER `as_follow`,
				ADD `as_response` int(11) NOT NULL DEFAULT '0' AFTER `as_followed`,
				ADD `as_memo` int(11) NOT NULL DEFAULT '0' AFTER `as_response`,
				ADD `as_coupon` int(11) NOT NULL DEFAULT '0' AFTER `as_memo`,
				ADD `as_join` int(11) NOT NULL DEFAULT '0' AFTER `as_coupon`,
				ADD `as_date` int(11) NOT NULL DEFAULT '0' AFTER `as_join` ", false);

// Member - Membership Date
sql_query(" ALTER TABLE `{$g5['member_table']}` ADD `mb_sn` varchar(255) NOT NULL DEFAULT '' AFTER `mb_id` ", false);
sql_query(" ALTER TABLE `{$g5['member_table']}` ADD `as_memo` int(11) NOT NULL DEFAULT '0' AFTER `as_response` ", false);
sql_query(" ALTER TABLE `{$g5['member_table']}` ADD `as_coupon` int(11) NOT NULL DEFAULT '0' AFTER `as_memo` ", false);
sql_query(" ALTER TABLE `{$g5['member_table']}` ADD `as_join` int(11) NOT NULL DEFAULT '0' AFTER `as_coupon` ", false);
sql_query(" ALTER TABLE `{$g5['member_table']}` ADD `as_date` int(11) NOT NULL DEFAULT '0' AFTER `as_join` ", false);
sql_query(" ALTER TABLE `{$g5['member_table']}` ADD `as_marketer` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_partner` ", false);

// Make Dir
$dir_arr = array (
	G5_DATA_PATH.'/apms/',
	G5_DATA_PATH.'/apms/partner/',
	G5_DATA_PATH.'/apms/photo/',
	G5_DATA_PATH.'/apms/photo/temp',
	G5_DATA_PATH.'/apms/video/',
	G5_DATA_PATH.'/apms/background/',
	G5_DATA_PATH.'/apms/title/',
	G5_DATA_PATH.'/apms/banner/',
	G5_DATA_PATH.'/apms/image/'
);

for ($i=0; $i<count($dir_arr); $i++) {

	if(is_dir($dir_arr[$i])) continue;

	@mkdir($dir_arr[$i], G5_DIR_PERMISSION);
	@chmod($dir_arr[$i], G5_DIR_PERMISSION);
}

// 초기값 등록
$tmp = array();

if(IS_YC) {
	// Default APMS
	$tmp = sql_fetch(" select count(*) as cnt from {$g5['apms']} ", false);
	if(!$tmp['cnt']) {
		sql_query(" insert into {$g5['apms']} set apms_payment = '100000' ", false);
	}

	// Default Rows
	$tmp = sql_fetch("select count(*) as cnt from {$g5['apms_rows']} ", false);
	if(!$tmp['cnt']) {
		sql_query(" insert into {$g5['apms_rows']} set icomment_rows = '20' ", false);
	}

	// Default Form
	$tmp = sql_fetch("select count(*) as cnt from {$g5['apms_form']} ", false);
	if(!$tmp['cnt']) {
		sql_query(" insert into {$g5['apms_form']} set pi_show = '1', pi_order = '1', pi_file = 'item.php', pi_name = '아이템', pi_use = '1' ", false);
		sql_query(" insert into {$g5['apms_form']} set pi_show = '1', pi_order = '2', pi_file = 'post.php', pi_name = '포스트', pi_use = '1' ", false);
	}
}

// Default XP
$tmp = sql_fetch("select count(*) as cnt from {$g5['apms_xp']} ", false);
if(!$tmp['cnt']) {
	sql_query(" insert into {$g5['apms_xp']} set xp_icon = 'txt' ", false);
}

//기본문서
//array('html_id', 'as_file', 'bo_subject', 'as_title', 'as_desc');
$PHtml[] = array('login', 'bbs/login.php', '로그인', '{아이콘:user} Login', '회원 로그인');
$PHtml[] = array('reg', 'bbs/register.php', '회원가입', '{아이콘:sign-in} Register', '회원가입안내');
$PHtml[] = array('regform', '', '가입양식', '{아이콘:file-text} Register Form', '회원가입 신청서 작성');
$PHtml[] = array('regresult', '', '가입완료', '{아이콘:leaf} Congratulations!', '회원가입을 축하드립니다.');
$PHtml[] = array('regmail', '', '메일변경', '{아이콘:envelope-o} E-mail Certify', '메일인증 메일주소 변경');
$PHtml[] = array('confirm', '', '회원확인', '{아이콘:check-circle} Confirm', '회원 비밀번호 확인');
$PHtml[] = array('password', '', '비밀번호', '{아이콘:unlock-o} Password', '비밀번호 확인');
$PHtml[] = array('faq', 'bbs/faq.php', 'FAQ', '{아이콘:exclamation-circle} FAQ', '자주하는 질문');
$PHtml[] = array('secret', 'bbs/qalist.php', '1:1 문의', '{아이콘:exclamation-circle} Secret', '1:1 문의');
$PHtml[] = array('search', 'bbs/search.php', '게시물검색', '{아이콘:search} Post Search', '포스트 검색');
$PHtml[] = array('new', 'bbs/new.php', '새글모음', '{아이콘:refresh} New Post', '새글모음');
$PHtml[] = array('connect', 'bbs/current_connect.php', '현재접속자', '{아이콘:link} Connect', '현재접속자');
$PHtml[] = array('tag', 'bbs/tag.php', '태그박스', '{아이콘:tags} Tag Box', '태그박스');
$PHtml[] = array('mypage', 'bbs/mypage.php', '마이페이지', '{아이콘:user} My Page', '마이페이지');

if(IS_YC) {
	$PHtml[] = array('partner', 'shop/partner/', '파트너등록', '{아이콘:heart} Partner Register', '파트너등록');
	$PHtml[] = array('orderform', '', '주문서', '{아이콘:file-text-o} Order Form', '주문서 작성하기');
	$PHtml[] = array('orderview', '', '주문상세내역', '{아이콘:file-text-o} Breakdown', '주문상세내역 조회하기');
	$PHtml[] = array('cart', 'shop/cart.php', '장바구니', '{아이콘:shopping-cart} Cart', '장바구니');
	$PHtml[] = array('inquiry', 'shop/orderinquiry.php', '주문내역조회', '{아이콘:bars} Inquiry', '주문내역조회');
	$PHtml[] = array('inquiryview', 'shop/orderinquiryview.php', '주문내역보기', '{아이콘:file-text-o} Inquiry View', '주문내역보기');
	$PHtml[] = array('ppay', 'shop/personalpay.php', '개인결제', '{아이콘:bars} Personal Pay', '개인결제리스트');
	$PHtml[] = array('ppayform', '', '개인결제폼', '{아이콘:money} Personal Pay Form', '개인결제하기');
	$PHtml[] = array('ppayresult', '', '개인결제상세내역', '{아이콘:file-text-o} Personal Pay Result', '개인결제상세내역');
	$PHtml[] = array('wishlist', 'shop/wishlist.php', '위시리스트', '{아이콘:thumb-tack} Wishlist', '위시리스트');
	$PHtml[] = array('myshop', 'shop/myshop.php', '마이샵', '{아이콘:th-large} My Shop', '마이샵');
	$PHtml[] = array('event', 'shop/event.php', '이벤트', '{아이콘:gift} Event', '이벤트');
	$PHtml[] = array('itype', 'shop/listtype.php', '컬렉션', '{아이콘:star} Collection', '아이템 모음전');
	$PHtml[] = array('itype1', 'shop/listtype.php?type=1', '히트상품', '{아이콘:star} Hit Items', '히트상품 모음전');
	$PHtml[] = array('itype2', 'shop/listtype.php?type=2', '추천상품', '{아이콘:thumbs-up} Good Items', '추천상품 모음전');
	$PHtml[] = array('itype3', 'shop/listtype.php?type=3', '신규상품', '{아이콘:cube} New Items', '신상품 모음전');
	$PHtml[] = array('itype4', 'shop/listtype.php?type=4', '베스트상품', '{아이콘:star} Best Items', '베스트상품 모음전');
	$PHtml[] = array('itype5', 'shop/listtype.php?type=5', '할인상품', '{아이콘:shopping-bag} Discount Items', '할인상품 모음전');
	$PHtml[] = array('isearch', 'shop/search.php', '아이템검색', '{아이콘:search} Search', '아이템 검색');
	$PHtml[] = array('iuse', 'shop/itemuselist.php', '후기모음', '{아이콘:pencil} Review', '후기 모음');
	$PHtml[] = array('iqa', 'shop/itemqalist.php', '문의모음', '{아이콘:comments-o} Q & A', '문의 모음');
	$PHtml[] = array('couponzone', 'shop/couponzone.php', '쿠폰존', '{아이콘:ticket} Coupon Zone', '쿠폰존');
}

$pcnt = count($PHtml);
for($i=0; $i < $pcnt; $i++) {
	$row = sql_fetch("select count(*) as cnt from {$g5['apms_page']} where html_id = '{$PHtml[$i][0]}' and as_html = '0' ", false);
	if(!$row['cnt']) {
		$sql = " insert {$g5['apms_page']}
					set html_id					= '".addslashes($PHtml[$i][0])."'
						, as_file				= '".addslashes($PHtml[$i][1])."'
						, bo_subject			= '".addslashes($PHtml[$i][2])."'
						, as_title				= '".addslashes($PHtml[$i][3])."'
						, as_desc				= '".addslashes($PHtml[$i][4])."'
						, as_html				= '0'
						";
		sql_query($sql, false);
	}
}

//Html
//array('html_id', 'as_file', 'bo_subject', 'as_title', 'as_desc');
$DHtml = array();
$DHtml[] = array('intro', 'intro.php', '사이트 소개', '{아이콘:leaf} Introduction', '사이트 소개');
$DHtml[] = array('provision', 'provision.php', '이용약관', '{아이콘:check-circle} Provision', '사이트 이용약관');
$DHtml[] = array('privacy', 'privacy.php', '개인정보처리방침', '{아이콘:plus-circle} Privacy', '사이트 개인정보처리방침');
$DHtml[] = array('noemail', 'noemail.php', '이메일 무단수집 거부', '{아이콘:ban} Rejection of E-mail Collection', '이메일 무단수집 거부');
$DHtml[] = array('disclaimer', 'disclaimer.php', '책임의 한계와 법적고지', '{아이콘:minus-circle} Lines of Responsibility', '책임의 한계와 법적고지');
$DHtml[] = array('guide', 'guide.php', '이용안내', '{아이콘:info-circle} User Guide', '사이트 이용안내');

$hcnt = count($DHtml);
for($i=0; $i < $hcnt; $i++) {
	$row = sql_fetch("select count(*) as cnt from {$g5['apms_page']} where html_id = '{$DHtml[$i][0]}' and as_html = '1' ", false);
	if(!$row['cnt']) {
		$sql = " insert {$g5['apms_page']}
					set html_id					= '".addslashes($DHtml[$i][0])."'
						, as_file				= '".addslashes($DHtml[$i][1])."'
						, bo_subject			= '".addslashes($DHtml[$i][2])."'
						, as_title				= '".addslashes($DHtml[$i][3])."'
						, as_desc				= '".addslashes($DHtml[$i][4])."'
						, as_html				= '1'
						";
		sql_query($sql, false);
	}
}

//업데이트일 경우
if($ap == "update") {
	alert('DB 업데이트가 완료되었습니다.', './apms.admin.php');
}

?>