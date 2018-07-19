<?php
$sub_menu = "300100";
define('G5_IS_ADMIN', true);
include_once ('../common.php');
if(!$is_demo) {
	include_once(G5_ADMIN_PATH.'/admin.lib.php');
	auth_check($auth[$sub_menu], 'w');
}

include_once(G5_LIB_PATH.'/apms.widget.lib.php');

$is_skin = $board_skin_path.'/'.$type.'/'.$skin.'/setup.skin.php';
if(file_exists($is_skin)) {
	$boset = apms_unpack($board['as_'.MOBILE_.'set']);
	@include_once($is_skin);
}

?>