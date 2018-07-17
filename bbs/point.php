<?php
include_once('./_common.php');

if ($is_guest)
    alert_close('회원만 조회하실 수 있습니다.');

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_point_sub = true;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = get_text($member['mb_nick']).' 님의 '.AS_MP.' 내역';

if($is_point_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

$list = array();

//분류
$where = '';
switch($sca) {
	case 'write'	: $where = "and po_rel_action in ('쓰기', '댓글')"; break;
	case 'read'		: $where = "and po_rel_action in ('읽기', '열람', '열람적립')"; break;
	case 'good'		: $where = "and po_rel_action in ('@good', '@nogood')"; break;
	case 'download'	: $where = "and po_rel_action in ('다운로드', '다운적립(".$member['mb_id'].")')"; break;
	case 'choice'	: $where = "and po_rel_action in ('채택')"; break;
	case 'poll'		: $where = "and po_rel_action in ('별점', '설문', '퀴즈', '참여')"; break;
	case 'event'	: $where = "and po_rel_action in ('이벤트낙찰', '이벤트당첨', '이벤트참여', '이벤트협찬')"; break;
	case 'login'	: $where = "and po_rel_table in ('@login', '@chulsuk')"; break;
	case 'buy'		: $where = "and po_rel_table in ('@delivery')"; break;
}

$sql_common = " from {$g5['point_table']} where mb_id = '".escape_trim($member['mb_id'])."' $where ";
$sql_order = " order by po_id desc ";

$sql = " select count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$write_page_rows = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page=';

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('member_mobile') : apms_skin_set('member');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=member&amp;ts='.urlencode(THEMA);
}

include_once($skin_path.'/point.skin.php');

if($is_point_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>