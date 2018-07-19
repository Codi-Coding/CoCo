<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    $group_file = G5_THEME_PATH.'/group.php';
    if(is_file($group_file)) {
        require_once($group_file);
        return;
    }
    unset($group_file);
}

// 권한체크
if($is_designer || $is_admin == "group") {
	;
} else if($group['as_partner'] && !IS_PARTNER) {
	alert("파트너만 이용가능합니다.", G5_URL);
}

$gid = $gr_id;

// 테마설정
$at = array();
$at = apms_gr_thema();
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

$is_main = true;

$page_name = $group['gr_subject'];

$g5['title'] = $group['gr_subject'];

$group_skin = $group['as_'.MOBILE_.'main'];

if(!$group_skin) {
	// 멀티사용시
	if($group['as_multi']) {

		define('_INDEX_', true);

		$is_index = true;

		include_once('./_head.php');

		if(IS_YC) {
			if(file_exists(THEMA_PATH.'/index.php')) {
				include_once(THEMA_PATH.'/index.php');
			} else {
				include_once(THEMA_PATH.'/shop.index.php');
			}
		} else {
			include_once(THEMA_PATH.'/index.php');
		}

		include_once('./_tail.php');
		return;
	} else {
		alert('그룹메인을 지원하지 않는 보드그룹입니다.', G5_URL);
	}
}

include_once('./_head.php');

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('group_mobile', $gr_id) : apms_skin_set('group', $gr_id);

$group_skin_path = G5_SKIN_PATH.'/group/'.$group_skin;
$group_skin_url = G5_SKIN_URL.'/group/'.$group_skin;

$skin_path = $group_skin_path;
$skin_url  = $group_skin_url;

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_admin)) {
	$setup_href = './skin.setup.php?skin=group&amp;gr_id='.$gr_id;
}

if(is_file($group_skin_path.'/group.skin.php')) {
	include_once($group_skin_path.'/group.skin.php');
} else {
	echo '<p class="text-center text-muted"><br><br>'.$group_skin.' 그룹스킨이 존재하지 않습니다.<br><br></p>';
}

include_once('./_tail.php');
?>