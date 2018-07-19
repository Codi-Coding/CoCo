<?php

include_once(EYOOM_PATH.'/common.php');

$ratio = 3;
for($i=0;$i<100;$i++) {
	$lv = $i+1;
	$sp = 100*($i)*$ratio + $sp;
	$ep = 100*($i+1)*$ratio + $sp;
	echo $lv . " : " . $sp . " - " . $ep . " : " . ($ep-$sp) . "<br>";
}

$mypoint = 113401;
$lv = $mypoint/2*(100*$ratio);
echo $lv;

if(0) {
	if(!$is_member) exit;
	// 그누 헤더정보 출력
	@include_once(G5_PATH.'/head.sub.php');
	
	@include_once(G5_LIB_PATH.'/register.lib.php');
	
	// 사용자 아이디 유효성 체크
	if(empty_mb_id($mb_id)) { exit; }
	if(valid_mb_id($mb_id)) { exit; }
	if(count_mb_id($mb_id)) { exit; }
	if(exist_mb_id($mb_id)) {
		$user = $eb->get_user_info($mb_id);
	}
	
	// 방명록
	$page = (int)$_GET['page'];
	if(!$page) $page = 1;
	if(!$page_rows) $page_rows = 5;
	$from_grecord = ($page - 1) * $page_rows; // 시작 열을 구함
	
	$fields = "a.mb_nick, a.mb_name, a.mb_email, a.mb_homepage, a.mb_tel, a.mb_hp, a.mb_point, a.mb_datetime, a.mb_signature, a.mb_profile, b.* ";
	$sql = "select $fields from {$g5['member_table']} as a	left join {$g5['eyoom_guest']} as b on a.mb_id = b.mb_id where b.mb_id = '{$user['mb_id']}' order by b.gu_regdt desc limit $from_grecord, $page_rows";
	
	$res = sql_query($sql, false);
	for($i=0; $row=sql_fetch_array($res); $i++) {
		$guest[$i] = $row;
		$guest[$i]['datetime'] = $row['gu_regdt'];
		$guest[$i]['content'] = nl2br($row['content']);
		$guest[$i]['mb_photo'] = $eb->mb_photo($row['gu_id']);
	}
	
	$tpl->define_template('mypage',$eyoom['mypage_skin'],'guest.skin.html');
	$tpl->assign(array(
		'guest'	=> $guest,
		'page'	=> $page,
	));
	@include EYOOM_INC_PATH.'/tpl.assign.php';
	$tpl->print_($tpl_name);
	
	// 그누 헤더정보 출력
	@include_once(G5_PATH.'/tail.sub.php');
}