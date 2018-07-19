<?php
$g5_path = '../../..';
include_once($g5_path.'/common.php');
include_once(EYOOM_PATH.'/common.php');

if(!$is_member) exit;

$action 	= $_POST['action'];
$bo_table 	= $_POST['bo_table'];
$wr_id 		= $_POST['wr_id'];
$cmt_id 	= $_POST['cmt_id'];
$yc_reason 	= $_POST['reason'];

if(!$action) exit;
if(!$bo_table) exit;
if(!$wr_id) exit;
if(!$yc_reason && $action == 'add') exit;

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
	
	$data = sql_fetch("select wr_4 from {$write_table} where {$wrid} and {$prid}");
	$ycard = unserialize($data['wr_4']);
	if(!$ycard) $ycard = array();
	$count = sql_fetch("select count(*) as cnt from {$g5['eyoom_yellowcard']} where bo_table = '{$bo_table}' and {$wrid} ");
	$data = sql_fetch("select mb_id from {$g5['eyoom_yellowcard']} where mb_id = '{$member['mb_id']}' and bo_table = '{$bo_table}' and {$wrid} ");
	
	// 이미 블라인드 처리된 글은 신고처리되지 않도록 처리
	if($ycard['yc_blind'] == 'y' && !$is_admin && $member['mb_level'] < $eyoom_board['bo_blind_direct']) {
		$yc_count = $count['cnt'];
		$msg = "이미 블라인드 처리된 글은 신고 또는 신고취소 처리하실 수 없습니다.";
		$error = true;
	} else {
	
		switch($action) {
			case 'add':
				if(!$data['mb_id']) {
					$ycard['yc_count'] = $yc_count = $count['cnt'] + 1;
					sql_query("insert into {$g5['eyoom_yellowcard']} set bo_table = '{$bo_table}', {$wrid}, pr_id = '{$wr_id}', mb_id = '{$member['mb_id']}', yc_reason = '{$yc_reason}',  yc_datetime = '". G5_TIME_YMDHIS ."' ");
					if($yc_count >= $eyoom_board['bo_blind_limit']) {
						$ycard['yc_blind'] = 'y';
					} else {
						$ycard['yc_blind'] = 'n';
					}
					$wr_4 = serialize($ycard);
					sql_query("update {$write_table} set wr_4 = '{$wr_4}' where {$wrid} ");
					sql_query("update {$g5['eyoom_new']} set wr_4 = '{$wr_4}' where  bo_table = '{$bo_table}' and {$wrid} ");
					sql_query("update {$g5['eyoom_tag_write']} set wr_4 = '{$wr_4}' where  bo_table = '{$bo_table}' and {$wrid} and tw_theme='{$theme}' ");
					
					$msg = "정상적으로 신고처리 하였습니다.";
				} else {
					$yc_count = $count['cnt'];
					$msg = "이미 신고처리 하였입니다.";
				}
				break;

			case 'cancel':
				if(!$data['mb_id']) {
					$yc_count = $count['cnt'];
					$msg = "신고하신 내역이 없습니다.";
				} else {
					$ycard['yc_count'] = $yc_count = $count['cnt'] - 1;
					sql_query("delete from {$g5['eyoom_yellowcard']} where bo_table='{$bo_table}' and {$wrid} and mb_id='{$member['mb_id']}' ");
					if($yc_count >= $eyoom_board['bo_blind_limit']) {
						$ycard['yc_blind'] = 'y';
					} else {
						$ycard['yc_blind'] = 'n';
					}
					$wr_4 = serialize($ycard);
					sql_query("update {$write_table} set wr_4 = '{$wr_4}' where {$wrid} ");
					sql_query("update {$g5['eyoom_new']} set wr_4 = '{$wr_4}' where  bo_table = '{$bo_table}' and {$wrid} ");
					sql_query("update {$g5['eyoom_tag_write']} set wr_4 = '{$wr_4}' where  bo_table = '{$bo_table}' and {$wrid} and tw_theme='{$theme}' ");
					
					$msg = "정상적으로 신고취소처리 하였습니다.";
				}
				break;
		}
	}
}

if($tocken) {
	$_value_array = array();
	$_value_array['count'] = $yc_count;
	$_value_array['msg'] = $msg;
	$_value_array['error'] = $error;

	include_once "../../classes/json.class.php";

	$json = new Services_JSON();
	$output = $json->encode($_value_array);

	echo $output;
}
exit;