<?php
include_once('../../common.php');
include_once(G5_ADMIN_PATH.'/apms_admin/apms.admin.lib.php');

if (isset($_REQUEST['sort']))  {
    $sort = trim($_REQUEST['sort']);
    $sort = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $sort);
} else {
    $sort = '';
}

if (isset($_REQUEST['sortodr']))  {
    $sortodr = preg_match("/^(asc|desc)$/i", $sortodr) ? $sortodr : '';
} else {
    $sortodr = '';
}

if (!defined('G5_USE_SHOP') || !G5_USE_SHOP)
    die('<p>쇼핑몰 설치 후 이용해 주십시오.</p>');

define('_SHOP_', true);
define('IS_SHOP', true);

define('APMS_PARTNER_DIR', G5_SHOP_DIR.'/partner');
define('APMS_PARTNER_PATH', G5_PATH.'/'.APMS_PARTNER_DIR);
define('APMS_PARTNER_URL',  G5_URL.'/'.APMS_PARTNER_DIR);
define('APMS_PARTNER_HTTPS_URL', https_url(APMS_PARTNER_DIR, true));

if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

// Skin
if(!$apms['apms_skin']) $apms['apms_skin'] = 'Basic';
$skin_path = APMS_PARTNER_PATH.'/skin/'.$apms['apms_skin'];
$skin_url = APMS_PARTNER_URL.'/skin/'.$apms['apms_skin'];

?>