<?php
include_once('./_common.php');

if (!$is_member) {
	alert('로그인해 주세요.', G5_BBS_URL.'/login.php?url='.urlencode('../bbs/respond.php'));
}

if(isset($chk)) $get .= "&chk=$chk";
if(isset($type)) $get .= "&type=$type";
if(isset($mb_id)) $mb_id .= "&chk=$mb_id";
if(isset($page)) $get .= "&page=$page";

class respond
{
	function respond_delete($where) {
		global $g5, $member;
		$where .= " and wr_mb_id = '".$member['mb_id']."'";
		sql_query("delete from {$g5['eyoom_respond']} where $where", false);
	}

	function respond_countdown($cnt) {
		global $g5, $member;
		$set = !$cnt ? "respond=0":"respond=respond-$cnt";
		sql_query("update {$g5['eyoom_member']} set $set where mb_id='".$member['mb_id']."'", false);
	}

	function respond_read($where) {
		global $g5, $member;
		$where .= " and wr_mb_id = '".$member['mb_id']."'";
		sql_query("update {$g5['eyoom_respond']} set re_chk = 1 where $where", false);
	}	
}

$respond = new respond;

switch($act) {
	default:
		if(!$rid) alert('잘못된 접근입니다.',G5_BBS_URL.'/respond.php');
		$where  = "rid = '$rid'";
		$where2 = " and wr_mb_id = '".$member['mb_id']."'";
		$row = sql_fetch("select * from {$g5[eyoom_respond]} where $where $where2", false);

		if(!$row['re_chk']) {
			$respond->respond_read($where);
			$respond->respond_countdown(1);
		}
		
		// 푸쉬 알람 파일 삭제
		$push_file = G5_DATA_PATH.'/member/push/push.'.$member['mb_id'].'.php';
		
		// 푸쉬파일 삭제
		if(@file_exists($push_file)) {
			@unlink($push_file);
		}
		
		$go_url = G5_BBS_URL.'/board.php?bo_table='.$row['bo_table'].'&wr_id='.$row['wr_id'];
		$go_url .= $row['wr_cmt'] ? '#c_'.$row['wr_cmt']:'';
		break;

	case 'delete':
		if(!$rid) alert('잘못된 접근입니다.',G5_BBS_URL.'/respond.php');
		$where = "rid = '".$rid."'";
		$respond->respond_delete($where);
		$respond->respond_countdown(1);
		break;

	case 'chkdel':
		$w = array();
		foreach($_POST['rid'] as $k => $v) {
			$w[$k] = "rid = '".$v."'";
		}
		$cnt = count($w);
		$where = implode(" || ", $w);
		
		$respond->respond_delete($where);
		$respond->respond_countdown($cnt);
		break;

	case 'chkread':
		$w = array();
		foreach($_POST['rid'] as $k => $v) {
			$w[$k] = "rid = '".$v."'";
		}
		$cnt = count($w);
		$where = implode(" || ", $w);
		$respond->respond_read($where);
		$respond->respond_countdown($cnt);
		break;

	case 'alldel':
		$where = "1";
		$respond->respond_delete($where);
		$respond->respond_countdown(0);
		break;
}
$go_url = $go_url ? $go_url : $_SERVER['HTTP_REFERER'];
goto_url($go_url);

?>
