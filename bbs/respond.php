<?php
	include_once('./_common.php');
	include_once(EYOOM_PATH.'/common.php');

	if (!$is_member) {
		alert('로그인해 주세요.', G5_BBS_URL.'/login.php?url='.urlencode('../bbs/respond.php'));
	}

	$g5['title'] = '내글반응';
	include_once('./_head.php');

	$sql_common = " from {$g5['eyoom_respond']} where wr_mb_id = '{$member['mb_id']}' ";


	// 읽음 여부
	$chk = isset($_GET['chk']) ? $_GET['chk'] : "";
	if ($chk == "y") {
		$sql_common .= " and re_chk = 1 ";
		$get .= '&chk=1';
	} else if ($chk == "n") {
		$sql_common .= " and re_chk = 0 ";
		$get .= '&chk=0';
	}
	$type = isset($_GET['type']) ? $_GET['type'] : "";
	if ($type) {
		$sql_common .= " and re_type = '".$type."' ";
		$get .= '&type='.$type;
	}


	//$mb_id = isset($_GET['mb_id']) ? strip_tags($_GET['mb_id']) : "";
	if ($stx && $stw) {
		switch($stx) {
			case 'id': $sql_common .= " and mb_id = '{$stw}' "; break;
			case 'nick': $sql_common .= " and mb_name = '{$stw}' "; break;
		}
		
		$get .= '&stx='.$stx.'&stw='.$stw;
	}
	$sql_order = " order by regdt desc ";

	$sql = " select count(*) as cnt {$sql_common} ";
	$row = sql_fetch($sql, false);
	$total_count = $row['cnt'];

	$rows = $config['cf_new_rows'];
	$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
	if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
	$from_record = ($page - 1) * $rows; // 시작 열을 구함

	$get .= '&page='.$page;

	$list = array();
	$sql = " select * {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";

	$result = sql_query($sql, false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$reinfo = $eb->respond_mention($row['re_type'],$row['mb_name'],$row['re_cnt']);

		// 당일인 경우 시간으로 표시함
		$datetime = substr($row['regdt'],0,10);
		$datetime2 = $row['regdt'];
		if ($datetime == G5_TIME_YMD) {
			$datetime2 = substr($datetime2,11,5);
		} else {
			$datetime2 = substr($datetime2,5,5);
		}
		$list[$i]['rid'] = $row['rid'];
		$list[$i]['mb_name'] = $row['mb_name'];
		$list[$i]['mention'] = $reinfo['mention'];
		$list[$i]['wr_subject'] = $row['wr_subject'];
		$list[$i]['chk'] = $row['re_chk'];
		$list[$i]['type'] = $reinfo['type'];
		$list[$i]['href'] = './respond_chk.php?rid='.$row['rid'];
		$list[$i]['delete'] = './respond_chk.php?rid='.$row['rid'].'&act=delete'.$get;
		$list[$i]['datetime'] = $datetime;
		$list[$i]['datetime2'] = $datetime2;
		$list[$i]['mb_photo'] = $eb->mb_photo($row['mb_id']);
	}

	include_once($respond_skin_path.'/respond.skin.php');

	include_once('./_tail.php');
?>
