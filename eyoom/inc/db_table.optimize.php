<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 최고관리자일 때만 실행
if($config['cf_admin'] != $member['mb_id'] || $is_admin != 'super')
	return;

// 실행일 비교
if(isset($config['cf_optimize_date']) && $config['cf_optimize_date'] >= G5_TIME_YMD)
	return;

// 설정일이 지난 최근게시물 삭제
if($config['cf_new_del'] > 0) {
	$sql = " delete from {$g5['eyoom_new']} where (TO_DAYS('".G5_TIME_YMDHIS."') - TO_DAYS(bn_datetime)) > '{$config['cf_new_del']}' ";
	//sql_query($sql);
	//sql_query(" OPTIMIZE TABLE `{$g5['eyoom_new']}` ");
}

if($config['cf_new_del'] > 0) {

	// 설정일이 지난 내글반응글 삭제
	$sql = " delete from {$g5['eyoom_respond']} where (TO_DAYS('".G5_TIME_YMDHIS."') - TO_DAYS(regdt)) > '{$config['cf_new_del']}' ";
	sql_query($sql);
	sql_query(" OPTIMIZE TABLE `{$g5['eyoom_respond']}` ");

	// 이윰멤버 테이블 자동정리
	$sql = " delete from {$g5['eyoom_member']} where mb_id='' ";
	sql_query($sql);
	sql_query(" OPTIMIZE TABLE `{$g5['eyoom_member']}` ");
}

if($member['mb_id'] && substr($member['mb_today_login'], 0, 10) != G5_TIME_YMD) {
	// 누적된 푸시파일 자동삭제
	$push_file_dir = G5_DATA_PATH . '/member/push';
	$qfile->del_timeover_file($push_file_dir,86400,'push');
}