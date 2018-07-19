<?php

$g5_path = '../../..';
include_once($g5_path.'/common.php');
include_once(EYOOM_PATH.'/common.php');

if(!$is_member) exit;

$score 		= $_POST['score'];
$bo_table 	= $_POST['bo_table'];
$wr_id 		= $_POST['wr_id'];

if(!$score) exit;
if(!$bo_table) exit;
if(!$wr_id) exit;

$tocken = true;

$eyoom_board = $eb->eyoom_board_info($bo_table, $theme);

if($eyoom_board['bo_use_rating'] != '1') {
	$msg = "별점 기능을 사용하지 않는 게시판입니다.";
} else {
	$write_table = $g5['write_prefix'] . $bo_table;
	$wrid = " wr_id = '{$wr_id}' ";
	
	$data = sql_fetch("select wr_4 from {$write_table} where {$wrid} ");
	$wr_4 = unserialize($data['wr_4']);
	if(!$wr_4) $wr_4 = array();
	$count = sql_fetch("select count(*) as cnt from {$g5['eyoom_rating']} where bo_table = '{$bo_table}' and {$wrid} ");
	$info = sql_fetch("select mb_id from {$g5['eyoom_rating']} where mb_id = '{$member['mb_id']}' and bo_table = '{$bo_table}' and {$wrid} ");
	if($info['mb_id']) {
		$msg = "이미 별점평가에 참여하였습니다.";
	} else {
		sql_query("insert into {$g5['eyoom_rating']} set bo_table = '{$bo_table}', {$wrid}, mb_id = '{$member['mb_id']}', rating = '".$score."',  rt_datetime = '". G5_TIME_YMDHIS ."' ");
		$wr_4['rating_score'] += $score;
		$wr_4['rating_members']++;
		$wr_4 = serialize($wr_4);
		sql_query("update {$write_table} set wr_4 = '{$wr_4}' where {$wrid} ");
		sql_query("update {$g5['eyoom_new']} set wr_4 = '{$wr_4}' where  bo_table = '{$bo_table}' and {$wrid} ");
		sql_query("update {$g5['eyoom_tag_write']} set wr_4 = '{$wr_4}' where tw_theme = '{$theme}' and bo_table = '{$bo_table}' and {$wrid} ");
		
		$msg = "정상적으로 별점평가를 반영하였습니다.";
	}
}

if($tocken) {
	$_value_array = array();
	$_value_array['msg'] = $msg;

	include_once "../../classes/json.class.php";

	$json = new Services_JSON();
	$output = $json->encode($_value_array);

	echo $output;
}
exit;