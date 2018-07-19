<?php
$g5_path = '../../..';
include_once($g5_path.'/common.php');
include_once(EYOOM_PATH.'/common.php');

if(!$is_member) exit;

$action 	= $_POST['action'];
$bo_table 	= $_POST['bo_table'];
$wr_id 		= $_POST['wr_id'];
$cmt_id 	= $_POST['cmt_id'];

if(!$action) exit;
if(!$bo_table) exit;
if(!$wr_id) exit;

$tocken = true;
$error = false;

$eyoom_board = $eb->eyoom_board_info($bo_table, $theme);

if($eyoom_board['bo_use_yellow_card'] != '1') {
	$tocken = 'no';
} else {
	$write_table = $g5['write_prefix'] . $bo_table;
	if($cmt_id) {
		$wrid = " wr_id = '{$cmt_id}' ";
	} else {
		$wrid = " wr_id = '{$wr_id}' ";
	}
	$data = sql_fetch("select wr_4 from {$write_table} where {$wrid} ");
	$ycard = unserialize($data['wr_4']);
	if(!$ycard) $ycard = array();
	$count = sql_fetch("select count(*) as cnt from {$g5['eyoom_yellowcard']} where bo_table = '{$bo_table}' and {$wrid} ");
	$data = sql_fetch("select mb_id from {$g5['eyoom_yellowcard']} where mb_id = '{$member['mb_id']}' and bo_table = '{$bo_table}' and {$wrid} ");
	
	// 권한 체크
	if(!$is_admin && $member['mb_level'] < $eyoom_board['bo_blind_direct']) {
		$msg = "블라인드 기능을 직접처리할 권한이 없습니다.";
		$error = true;
	} else {
		
		if($ycard['yc_blind'] == 'y' && $action == 'db') {
			$msg = "이미 블라인드 처리된 글입니다.";
			$error = true;
		}
		
		if($ycard['yc_blind'] == 'n' && $action == 'cb') {
			$msg = "이미 블라인드 취소 처리된 글입니다.";
			$error = true;
		}
	
		switch($action) {
			case 'db': // direct blind
				sql_query("insert into {$g5['eyoom_yellowcard']} set bo_table = '{$bo_table}', {$wrid}, pr_id = '{$wr_id}', mb_id = '{$member['mb_id']}', yc_reason = 'd',  yc_datetime = '". G5_TIME_YMDHIS ."' ");
				$ycard['yc_blind'] = 'y';
				$wr_4 = serialize($ycard);
				sql_query("update {$write_table} set wr_4 = '{$wr_4}' where {$wrid} ");
				sql_query("update {$g5['eyoom_new']} set wr_4 = '{$wr_4}' where bo_table = '{$bo_table}' and {$wrid} ");
				sql_query("update {$g5['eyoom_tag_write']} set wr_4 = '{$wr_4}' where tw_theme ='{$theme}' and bo_table = '{$bo_table}' and {$wrid} ");
				
				$msg = "정상적으로 블라인드 처리하였습니다.";
				break;

			case 'cb': // cancel blind
				$ycard['yc_count'] = $yc_count = $count['cnt'] - 1;
				sql_query("delete from {$g5['eyoom_yellowcard']} where bo_table='{$bo_table}' and {$wrid} and mb_id='{$member['mb_id']}' ");
				$ycard['yc_blind'] = 'n';
				$wr_4 = serialize($ycard);
				sql_query("update {$write_table} set wr_4 = '{$wr_4}' where {$wrid} ");
				sql_query("update {$g5['eyoom_new']} set wr_4 = '{$wr_4}' where  bo_table = '{$bo_table}' and {$wrid} ");
				sql_query("update {$g5['eyoom_tag_write']} set wr_4 = '{$wr_4}' where tw_theme ='{$theme}' and bo_table = '{$bo_table}' and {$wrid} ");
				
				$msg = "정상적으로 블라인드 취소 처리하였습니다.";
				break;
		}
	}
}

if($tocken) {
	$_value_array = array();
	$_value_array['msg'] = $msg;
	$_value_array['error'] = $error;

	include_once "../../classes/json.class.php";

	$json = new Services_JSON();
	$output = $json->encode($_value_array);

	echo $output;
}
exit;