<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_LIB_PATH.'/apms.lib.php');

$bonames = array();
$as_href = array();
$at = array();
$xp = array();

// APMS Version
$yc5_ver = (defined('G5_USE_SHOP')) ? ' / 영카트 5.2.9.8.4' : '';
define('APMS_VERSION', '아미나빌더 1.7.26 / 그누보드 5.2.9.8.4'.$yc5_ver);
define('APMS_SVER', '171013');

// USE YC5
if (defined('G5_USE_SHOP') && G5_USE_SHOP) {
	define('IS_YC', true);
	@include_once(G5_EXTEND_PATH.'/shop.extend.php');
	if($default['as_partner']) {
		//MKT Check
		if($config['cf_use_recommend']) {
			if (isset($_REQUEST['mkt']) && $_REQUEST['mkt'])  {
				$_REQUEST['mkt'] = get_text(clean_xss_tags($_REQUEST['mkt']));
				set_cookie('mkt_id', $_REQUEST['mkt'], 86400 * 15); // 15일동안 쿠키 유지
				//set_session('mkt_id', $_REQUEST['mkt']);
			}
			define('APMS_MKT', get_cookie('mkt_id'));
			//define('APMS_MKT', get_session('mkt_id'));
		} else {
			define('APMS_MKT', '');
		}
		define('USE_PARTNER', true);
	} else {
		define('USE_PARTNER', false);
	}
	@include_once(G5_LIB_PATH.'/apms.shop.lib.php');

	// Content-Item Type Num (No Delivery Item Tyep Num)
	$g5['apms_automation'] = array("2");

	// APMS YC DB Table
	$g5['apms'] = G5_TABLE_PREFIX.'apms';
	$g5['apms_partner'] = G5_TABLE_PREFIX.'apms_partner';
	$g5['apms_payment'] = G5_TABLE_PREFIX.'apms_payment';
	$g5['apms_file'] = G5_TABLE_PREFIX.'apms_file';
	$g5['apms_form'] = G5_TABLE_PREFIX.'apms_form';
	$g5['apms_rows'] = G5_TABLE_PREFIX.'apms_rows';
	$g5['apms_comment'] = G5_TABLE_PREFIX.'apms_comment';
	$g5['apms_use_log'] = G5_TABLE_PREFIX.'apms_use_log';
	$g5['apms_sendcost'] = G5_TABLE_PREFIX.'apms_sendcost';
	$g5['apms_good'] = G5_TABLE_PREFIX.'apms_good';

	// APMS YC Href
	$at_href['myshop'] = G5_SHOP_URL.'/myshop.php';
	$at_href['cart'] = G5_SHOP_URL.'/cart.php';
	$at_href['wishlist'] = G5_SHOP_URL.'/wishlist.php';
	$at_href['shopping'] = G5_SHOP_URL.'/shopping.php';
	$at_href['inquiry'] = G5_SHOP_URL.'/orderinquiry.php';
	$at_href['ppay'] = G5_SHOP_URL.'/personalpay.php';
	$at_href['event'] = G5_SHOP_URL.'/event.php';
	$at_href['itype'] = G5_SHOP_URL.'/listtype.php';
	$at_href['home_shop'] = G5_SHOP_URL;
	$at_href['isearch'] = G5_SHOP_URL.'/search.php';
	$at_href['iuse'] = G5_SHOP_URL.'/itemuselist.php';
	$at_href['iqa'] = G5_SHOP_URL.'/itemqalist.php';
	$at_href['partner'] = G5_SHOP_URL.'/partner/';
} else {
	define('IS_YC', false);
	define('USE_PARTNER', false);
	@include_once(G5_LIB_PATH.'/thumbnail.lib.php');
}

// APMS DB Table
$g5['apms_tag'] = G5_TABLE_PREFIX.'apms_tag';
$g5['apms_tag_log'] = G5_TABLE_PREFIX.'apms_tag_log';
$g5['apms_like'] = G5_TABLE_PREFIX.'apms_like';
$g5['apms_xp'] = G5_TABLE_PREFIX.'apms_xp';
$g5['apms_page'] = G5_TABLE_PREFIX.'apms_page';
$g5['apms_multi'] = G5_TABLE_PREFIX.'apms_multi';
$g5['apms_data'] = G5_TABLE_PREFIX.'apms_data';
$g5['apms_poll'] = G5_TABLE_PREFIX.'apms_poll';
$g5['apms_cache'] = G5_TABLE_PREFIX.'apms_cache';
$g5['apms_shingo'] = G5_TABLE_PREFIX.'apms_shingo';
$g5['apms_response'] = G5_TABLE_PREFIX.'apms_response';
$g5['apms_event'] = G5_TABLE_PREFIX.'apms_event';
$g5['apms_playlist'] = G5_TABLE_PREFIX.'apms_playlist';
$g5['cache_auto_menu'] = (int)$config['cf_9']; //메뉴
$g5['cache_stats_time'] = (int)$config['cf_10_subj']; //통계
$g5['cache_newpost_time'] = (int)$config['cf_10']; //새글

// Extend Var
$mode = apms_escape('mode', 0);
$pid = apms_escape('pid', 0);
$pim = apms_escape('pim', 0);
$ipwm = apms_escape('ipwm', 0);

// Demo Config
$demo_config = array('bo_table' => '', 'ca_id' => '', 'ev_id' => '', 'bn_id' => '');

// APMS Common ---------------------------------------------------------------------------
if(G5_IS_MOBILE) {
	define('MOBILE_', 'mobile_');
} else {
	define('MOBILE_', '');
}

if (!defined('IS_MOBILE_DEVICE')) {
	define('IS_MOBILE_DEVICE', is_mobile());
}

// Load XP
$xp = sql_fetch("select * from {$g5['apms_xp']} ", false);

// Define Term
define('AS_XP', $config['as_xp']);
define('AS_MP', $config['as_mp']);
define('APMS_PLUGIN_PATH', G5_PLUGIN_PATH.'/apms');
define('APMS_PLUGIN_URL', G5_PLUGIN_URL.'/apms');
define('APMS_YEAR', substr(G5_TIME_YMDHIS, 0, 4));
define('APMS_GOOGLE_MAP_KEY', $xp['google_map_key']);
define('APMS_JWPLAYER6_KEY', $xp['jwplayer_key']);
define('APMS_PIM', $pim); // Modal Win
define('APMS_PRINT', $ipwm); // Print Win

// 프린트
if(APMS_PRINT) {
	$qstr .= '&amp;ipwm=1'; 
	if(APMS_PIM) $qstr .= '&amp;pim=1'; 

	$print_skin = $config['cf_8_subj'];
	if(!is_file(G5_SKIN_PATH.'/print/'.$print_skin.'/print.head.php')) {
		$print_skin = 'basic';
	}
	$print_skin_path = G5_SKIN_PATH.'/print/'.$print_skin;
	$print_skin_url = G5_SKIN_URL.'/print/'.$print_skin;
}

// Member
$member = apms_member($member['mb_id']);

if(USE_PARTNER) {
	if(isset($member['as_partner']) && $member['as_partner']) {
		define('IS_SELLER', true);
	} else {
		define('IS_SELLER', false);
	}

	if(isset($member['as_marketer']) && $member['as_marketer']) {
		define('IS_MARKETER', true);
	} else {
		define('IS_MARKETER', false);
	}

	if(IS_SELLER || IS_MARKETER) {
		define('IS_PARTNER', true);
	} else {
		define('IS_PARTNER', false);
	}

} else {
	define('IS_PARTNER', false);
	define('IS_SELLER', false);
	define('IS_MARKETER', false);
}

// Misc Skin
$misc_skin_path = get_skin_path('misc', $config['as_misc_skin']);
$misc_skin_url = get_skin_url('misc', $config['as_misc_skin']);

// Designer Auth
$is_designer = apms_admin($xp['xp_designer']);

// Auth
if($is_designer || $is_admin === 'group') {
	;
} else {
	$chk_auth = '';
	if($gr_id) {
		if($group['as_partner'] && !IS_PARTNER) $chk_auth = aslang('alert', 'is_partner'); //파트너만 이용가능합니다.
		if(!$chk_auth) $chk_auth = apms_auth($group['as_grade'], $group['as_equal'], $group['as_min'], $group['as_max'], 1);
	}

	if(!$chk_auth && !$is_admin && $bo_table) {
		if($board['as_partner'] && !IS_PARTNER) $chk_auth = aslang('alert', 'is_partner'); //파트너만 이용가능합니다.
		if(!$chk_auth) $chk_auth = apms_auth($board['as_grade'], $board['as_equal'], $board['as_min'], $board['as_max'], 1);
	}

	if($chk_auth) {
		include_once(G5_BBS_PATH.'/alert.header.php');
		alert($chk_auth, G5_URL);
		exit;
	}
}

// Index
$is_index = false;
$is_main = false;

// Meta
$is_seometa = '';
$is_feedvideo = false;
$is_layout_sub = false;

// Link Href
$at_href['css'] = (isset($chk_host['path']) && $chk_host['path']) ? $_SERVER['HTTP_HOST'].$chk_host['path'] : $_SERVER['HTTP_HOST'];
$at_href['reg'] = G5_BBS_URL.'/register.php';
$at_href['login'] = ($urlencode) ? G5_BBS_URL.'/login.php?url='.$urlencode : G5_BBS_URL.'/login.php';
$at_href['login_check'] = G5_HTTPS_BBS_URL.'/login_check.php';
$at_href['logout'] = G5_BBS_URL.'/logout.php';
$at_href['point'] = G5_BBS_URL.'/point.php';
$at_href['memo'] = G5_BBS_URL.'/memo.php';
$at_href['scrap'] = G5_BBS_URL.'/scrap.php';
$at_href['edit'] = G5_BBS_URL.'/member_confirm.php?url=register_form.php';
$at_href['leave'] = G5_BBS_URL.'/member_confirm.php?url=member_leave.php';
$at_href['lost'] = G5_BBS_URL.'/password_lost.php';
$at_href['response'] = G5_BBS_URL.'/response.php';
$at_href['follow'] = G5_BBS_URL.'/follow.php';
$at_href['myphoto'] = G5_BBS_URL.'/myphoto.php';
$at_href['mypost'] = G5_BBS_URL.'/mypost.php';
$at_href['connect'] = G5_BBS_URL.'/current_connect.php';
$at_href['secret'] = G5_BBS_URL.'/qalist.php';
$at_href['switcher_submit'] = G5_BBS_URL.'/switcher.update.php';
$at_href['faq'] = G5_BBS_URL.'/faq.php';
$at_href['new'] = G5_BBS_URL.'/new.php';
$at_href['search'] = G5_BBS_URL.'/search.php';
$at_href['tag'] = G5_BBS_URL.'/tag.php';
$at_href['example'] = G5_URL.'/example.php';

if(IS_YC) {
	$at_href['coupon'] = G5_SHOP_URL.'/coupon.php';
	$at_href['couponzone'] = G5_SHOP_URL.'/couponzone.php';
	$at_href['mypage'] = G5_SHOP_URL.'/mypage.php';
} else {
	$at_href['coupon'] = '#';
	$at_href['couponzone'] = '#';
	$at_href['mypage'] = G5_BBS_URL.'/mypage.php';
}

// IE Version
if(preg_match("/MSIE ([0-9]{1,}[\.0-9]{0,})/", $_SERVER['HTTP_USER_AGENT'], $ie_version)){
	define('IS_IE', (int)$ie_version[1]);
} else {
	define('IS_IE', 10);
}

?>