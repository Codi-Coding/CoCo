<?php
include_once('./_common.php');

if(!$gid) alert('등록되지 않은 그룹입니다.');

$group = sql_fetch(" select * from {$g5['group_table']} where gr_id = '{$gid}' ", false);

if(!$group['gr_id']) alert('등록되지 않은 그룹입니다.');

$gr_id = $group['gr_id'];

if($is_designer || $is_admin == "group") {
	;
} else {
	if($group['as_partner'] && !IS_PARTNER) {
		alert("파트너만 이용가능합니다.", G5_URL);
	}

	// 그룹접근 사용
	if (isset($group['gr_use_access']) && $group['gr_use_access']) {

		if ($is_guest) {
			alert("비회원은 접근할 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.");
		}

		// 그룹접근
		$row = sql_fetch(" select count(*) as cnt from {$g5['group_member_table']} where gr_id = '{$gr_id}' and mb_id = '{$member['mb_id']}' ");
		if (!$row['cnt']) {
			alert("접근 권한이 없습니다.");
		}
	}

	apms_auth($group['as_grade'], $group['as_equal'], $group['as_min'], $group['as_max']);
}

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