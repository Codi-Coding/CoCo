<?php
$g5_path = '../../..';
include_once($g5_path.'/common.php');
include_once(EYOOM_PATH.'/common.php');

$action 	= $_POST['action'];
$bo_table 	= $_POST['bo_table'];
$wr_id 		= $_POST['wr_id'];
$cmt_id 	= $_POST['comment_id'];

if (!preg_match('/adopt/i',$eyoom_board['bo_skin'])) exit;
if(!$bo_table) exit;
if(!$wr_id) exit;
if(!$cmt_id) exit;

$tocken = true;
$error = false;

$write_table = $g5['write_prefix'] . $bo_table;
$wr_data = sql_fetch("select mb_id, wr_4, wr_name from {$write_table} where wr_id = '{$wr_id}' ");

// 자신의 글인지 체크
if (($is_member && $member['mb_id'] == $wr_data['mb_id']) || $is_admin) {
	$wr_4 = unserialize($wr_data['wr_4']);
	
	// 이미 채택된 댓글이 존재한지 체크
	if (isset($wr_4['adopt_cmt_id']) && $wr_4['adopt_cmt_id']) {
		$msg = "이미 채택된 게시물입니다.";
		$error = true;
	} else {
		$wr_4['adopt_cmt_id'] = $cmt_id;
		
		$cmt_data = sql_fetch("select mb_id from {$write_table} where wr_id = '{$cmt_id}' ");
		
		// 채택 포인트를 설정한 게시물인지 체크
		if (isset($wr_4['adopt_point']) && $wr_4['adopt_point'] > 0) {
			
			// 수수료률
			$ratio = $eyoom_board['bo_adopt_ratio']? $eyoom_board['bo_adopt_ratio']:20;
			
			// 채택 포인트
			$cmt_point = ceil($wr_4['adopt_point']*(1-($ratio/100)));
			$wr_point = $wr_4['adopt_point'] - $cmt_point;
			
			// 채택된 회원에게 차액 포인트 적립
			if ($cmt_point > 0) {
				insert_point($cmt_data['mb_id'], $cmt_point, "{$board['bo_subject']} $wr_id 채택 후원-".date('ymdhis'), $bo_table, $wr_id, "{$cmt_data['mb_id']}-{$wr_id}-{$cmt_id}-".date('ymdhis')." 채택");
			}
			
			// 작성한 회원에게 차감하고 남은 포인트 재적립
			if ($wr_point > 0) {
				insert_point($wr_data['mb_id'], $wr_point, "{$board['bo_subject']} $wr_id 채택포인트 차감 후 반환 포인트-".date('ymdhis'), $bo_table, $wr_id, "{$wr_data['mb_id']}-{$wr_id}-".date('ymdhis')." 채택");
			}
		}
		
		$wr_4 = serialize($wr_4);
		sql_query("update {$write_table} set wr_4 = '{$wr_4}' where wr_id = '{$wr_id}' ");
		sql_query("update {$g5['eyoom_new']} set wr_4 = '{$wr_4}' where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
		
		// 알람설정
		$adopt_info['bo_table'] = trim($bo_table);
		$adopt_info['wr_id'] = trim($wr_id);
		$adopt_info['cmt_id'] = trim($cmt_id);
		$eb->set_push("adopt",implode('|',$adopt_info),$cmt_data['mb_id'],$wr_data['wr_name']);
	}
} else {
	$msg = "자신이 작성한 게시물만 채택이 가능합니다.";
	$error = true;
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