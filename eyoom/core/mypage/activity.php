<?php
if (!defined('_GNUBOARD_')) exit;

@include EYOOM_PATH.'/common.php';

if (!$member['mb_id']) alert('회원만 접근하실 수 있습니다.',G5_URL);

// 마이박스
@include_once(EYOOM_CORE_PATH.'/mypage/mybox.php');

$page = (int)$_GET['page'];
if(!$page) $page = 1;
if(!$page_rows) $page_rows = 20;
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

$sql = "select * from {$g5['eyoom_activity']} where mb_id = '{$eyoomer['mb_id']}' order by act_regdt desc limit $from_record, $page_rows";
$res = sql_query($sql, false);
for($i=0;$row=sql_fetch_array($res);$i++) {
	$act_contents = unserialize($row['act_contents']);
	$list[$i] = $act_contents;
	$list[$i]['type'] = $row['act_type'];
	$list[$i]['datetime'] = $row['act_regdt'];
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/mypage/activity.skin.php');
$tpl->define(array(
	'tab_category' => 'skin_bs/mypage/'.$eyoom['mypage_skin'].'/tabmenu.skin.html',
));

$tpl->define_template('mypage',$eyoom['mypage_skin'],'activity.skin.html');
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);