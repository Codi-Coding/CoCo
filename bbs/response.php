<?php
include_once('./_common.php');

if ($is_guest) {
	if($win) {
		if($win == "2") {
			alert_modal('회원만 이용가능합니다.');
		} else {
			alert_close('회원만 이용가능합니다.');
		}
	} else {
		alert('회원만 이용가능합니다.', G5_URL);
	}
}

if($id) { //이동
	$url = apms_response_act($id);

	if(!$url) alert('자료가 없습니다.', G5_URL);

	if($win) {
		$url = str_replace("&amp;", "&", $url);

		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
		echo "<script>";
		if($win == "2") { //모달
			echo "parent.location.href=\"".$url."\";";
		} else {
			echo "opener.location.href=\"".$url."\";";
			echo "document.location.href=\"./response.php?page=".$page."&read=".$read."&win=".$win."\";";
		}
		echo "</script>";
		exit;
	} else {
		goto_url($url);
	}

}

if($opt == "1") { //일괄처리
	$row = sql_fetch(" update {$g5['apms_response']} set confirm = '1' where mb_id = '{$member['mb_id']}' and confirm <> '1' ", false);
	sql_query(" update {$g5['member_table']} set as_response = 0 where mb_id = '{$member['mb_id']}' ", false);

	// 푸시처리
	if(function_exists('apms_send_push')) {
		apms_read_push($member['mb_id'], true);
	}
	goto_url('./response.php');
} else if($opt == "2") { //리카운트
	$row = sql_fetch(" select count(*) as cnt from {$g5['apms_response']} where mb_id = '{$member['mb_id']}' and confirm <> '1' ", false);
	sql_query(" update {$g5['member_table']} set as_response = '{$row['cnt']}' where mb_id = '{$member['mb_id']}' ", false);
	goto_url('./response.php');
}

// Filter Subject
function response_subject_filter($str) {

	$str = str_replace(array("[새글]", "[답글]"), array("", ""), $str);

	return $str;
}

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_response_sub = true;
$is_response_win = (APMS_PIM) ? 2 : 1;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = $member['mb_nick'].' 님의 내글반응';

if($is_response_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

if(isset($read) && $read) {
	$read = 1;
	$sql_sort = 'desc';
} else {
	$read = 0;
	$sql_sort = 'asc';
}
$sql_common = " from {$g5['apms_response']} where mb_id = '{$member['mb_id']}' and confirm = '{$read}' ";
$sql_order = " order by regdate $sql_sort ";
$sql = " select count(*) as cnt $sql_common ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];
$rows = $config['cf_'.MOBILE_.'page_rows'];
$total_page  = ceil($total_count / $rows);
$page = ($page > 1) ? $page : 1;
$from_record = ($page - 1) * $rows;

$list = array();
$num = $total_count - ($page - 1) * $rows;
$result = sql_query(" select * $sql_common $sql_order limit $from_record, $rows ");
for($i=0; $row = sql_fetch_array($result); $i++) {
	$list[$i] = apms_response_row($row, $is_response_win, $page, $read);

	if($read) $list[$i]['subject'] = response_subject_filter($list[$i]['subject']);

	$list[$i]['num'] = $num;
	$num--;
}

// 리카운트
if(!$read && $member['as_response'] != $total_count) {
	sql_query(" update {$g5['member_table']} set as_response = '$total_count' where mb_id = '{$member['mb_id']}' ", false);
	$member['response'] = $member['as_response'] = $total_count;
}

$write_page_rows = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];

$all_href = './response.php?opt=1';
$recount_href = './response.php?opt=2';
$list_page = './response.php?read='.$read.'&amp;page=';

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('member_mobile') : apms_skin_set('member');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=member&amp;ts='.urlencode(THEMA);
}

include_once($skin_path.'/response.skin.php');

if($is_response_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>