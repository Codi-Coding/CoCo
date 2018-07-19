<?php
if (!defined('_GNUBOARD_')) exit;

// If this is the eyoom admin page
if (defined('_EYOOM_IS_ADMIN_')) {

	$tmp = dir(G5_ADMIN_PATH);
	while ($entry = $tmp->read()) {
	    if (preg_match('/^admin.menu([0-9]{3}).*\.php$/', $entry, $m)){
		    $menufile[$entry] = $m;
	    }
	}
	@ksort($menufile);
	foreach ($menufile as $entry => $m) {
	    $amenu[$m[1]] = $entry;
	    include_once(G5_ADMIN_PATH.'/'.$entry);
	}
	@ksort($amenu);
	
	$arr_query = array();
	if (isset($sst))  $arr_query[] = 'sst='.$sst;
	if (isset($sod))  $arr_query[] = 'sod='.$sod;
	if (isset($sfl))  $arr_query[] = 'sfl='.$sfl;
	if (isset($stx))  $arr_query[] = 'stx='.$stx;
	if (isset($page)) $arr_query[] = 'page='.$page;
	$qstr = implode("&amp;", $arr_query);
	
	// 쇼핑몰인지 체크
	$dir = clean_xss_tags(trim($_GET['dir']));
	$pid = clean_xss_tags(trim($_GET['pid']));
	
	if ($dir == 'shop' || $dir == 'shopetc') {
		define('G5_IS_SHOP_ADMIN_PAGE', true);
		include_once(EYOOM_ADMIN_INC_PATH . '/admin.shop.lib.php');
		check_order_inicis_tmps();
	}

	// 관리자 공통설정 파일
	@include_once(EYOOM_ADMIN_PATH.'/admin.php');

	// 이후 파일들은 실행 금지
	return;
	exit;
}