<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/apms.event.lib.php');

if ($is_guest) {
	alert('회원만 가능합니다.');
}

if (!($bo_table && $wr_id)) {
	alert('값이 제대로 넘어오지 않았습니다.');
}

$ss_name = 'ss_view_'.$bo_table.'_'.$wr_id;
if (!get_session($ss_name)) {
	alert('해당 이벤트에서만 참여하실 수 있습니다.');
}

$row = sql_fetch(" select count(*) as cnt from {$g5['write_prefix']}{$bo_table} ", FALSE);
if (!$row['cnt']) {
	alert('존재하는 이벤트 게시판이 아닙니다.');
}

// 이벤트 정보
$ev = apms_event_info($bo_table, $wr_id, $write);

// 당첨처리
if(isset($ec) && $ec) {
	$own = apms_event_own($bo_table, $wr_id, $member['mb_id']);

	$mb_point = $member['mb_point'];

	$win_point = apms_event_point($ev, $bo_table, $wr_id);

	if($own[0]['is_win'] && $own[0]['is_confirm']) {
		$j = 0; // 미처리 카운트
		for($i=1; $i < count($own); $i++) {
			if($own[$i]['ev_win'] && !$own[$i]['ev_confirm']) { // 당첨인데, 미처리된 내역이면
				$mb_point = $mb_point - $own[$i]['ev_point'];
				if($mb_point >= 0) {
					// 낙찰포인트 등록
					$ev_point = $own[$i]['ev_point'] * (-1);
				    insert_point($member['mb_id'], $ev_point, "{$board['bo_subject']} $wr_id 이벤트 낙찰", $bo_table, $wr_id, "이벤트낙찰");

					// 이벤트 당첨포인트
					if($win_point) {
						insert_point($member['mb_id'], $win_point, "{$board['bo_subject']} $wr_id 이벤트 당첨", $bo_table, $wr_id, "이벤트당첨");
					}

					// 당첨정보 입력
					sql_query(" update {$g5['apms_event']} set ev_win = '1', ev_confirm = '1' where bo_table = '$bo_table' and wr_id = '$wr_id' and mb_id = '{$member['mb_id']}' and ev_point = '{$own[$i]['ev_point']}' ", false);
				} else {
					$j++;
				}
			}
		}

		$msg = ($j) ? '보유 '.AS_MP.' 부족으로 이벤트 당첨처리를 완료하지 못했습니다.\\n\\n'.AS_MP.'를 확인 후 다시 당첨처리해 주시기 바랍니다.' : '이벤트 당첨처리가 완료되었습니다.';

		alert($msg, G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;page='.$page.$qstr);

	} else {
		alert('이벤트에 당첨되지 않았거나, 이미 당첨처리를 하셨습니다.');
	}
}

// 당첨포기
if(isset($ed) && $ed) {
	$own = apms_event_own($bo_table, $wr_id, $member['mb_id']);

	if($own[0]['is_win'] && $own[0]['is_confirm']) {

		// 내기록 지우기
		sql_query(" delete from {$g5['apms_event']} where bo_table = '$bo_table' and wr_id = '$wr_id' and mb_id = '{$member['mb_id']}' ");

		// 필요자료 정리
		$view = $write; //글내용으로 전환
		$ev['status'] = '종료';
		$ev['end'] = '';
		if($ev['win'] == "1") { // 1명이면

			apms_event_win($bo_table, $wr_id, $ev); // 당첨자 뽑기

		} else {

			//기존 당첨자 뽑기
			$ex_mb = '';
			$result = sql_query(" select mb_id from {$g5['apms_event']} where bo_table = '$bo_table' and wr_id = '$wr_id' and ev_win = '1'"); 
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				if($i > 0) $ex_mb .= ',';
				$ex_mb .= $row['mb_id'];
			}

			//추가 1명 더뽑기
			$ev['win'] = 1;
			apms_event_win($bo_table, $wr_id, $ev, $ex_mb); // 당첨자 뽑기
		}

		alert('이벤트 당첨을 포기하였습니다.', G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;page='.$page.$qstr);

	} else {
		alert('당첨포기 대상자가 아니던가, 당첨포기를 할 수 없는 이벤트입니다.');
	}
}

if (!$ev['start_datetime'] || !$ev['end_datetime']) {
	alert("참여가능한 이벤트가 아닙니다.");
}

if (G5_TIME_YMDHIS < $ev['start_datetime']) {
	alert("이벤트 시작 전입니다.");
}

if (G5_TIME_YMDHIS > $ev['end_datetime']) {
	alert("종료된 이벤트입니다.");
}

if($write['mb_id'] == $member['mb_id'] || ($ev['spt_id'] && $ev['spt_id'] == $member['mb_id'])) {
	alert('자신이 등록한 이벤트에는 참여하실 수 없습니다.');
}

if($ev['tender'] > 0) {
	$row = sql_fetch(" select count(*) as cnt from {$g5['apms_event']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and mb_id = '{$member['mb_id']}' ");
	if($row['cnt'] >= $ev['tender']) {
		alert('본 이벤트에는 더이상 참여하실 수 없습니다.');
	}
}

// 입찰금 미납확인
$row = sql_fetch(" select count(*) as cnt from {$g5['apms_event']} where mb_id = '{$member['mb_id']}' and ev_win = '1' and ev_confirm = '0' ");
if($row['cnt']) {
	alert('보유 '.AS_MP.' 부족으로 당첨된 입찰 '.AS_MP.'가 미처리된 내역이 있습니다.\\n\\n미처리된 이벤트에서 먼저 당첨처리 또는 당첨포기 후 다시 참여해 주세요.');
}

// 참가비 지불여부
if($ev['entry_point'] > 0) {
	$is_entry = true;
	$row = sql_fetch(" select count(*) as cnt from {$g5['point_table']} where mb_id = '{$member['mb_id']}' and po_rel_table = '{$bo_table}' and po_rel_id = '{$wr_id}' and po_rel_action = '이벤트참여' ");
	if($row['cnt']) {
		$is_entry = false;
	} else {
	    if ($member['mb_point'] < $ev['entry_point']) {
		    alert("보유중인 ".AS_MP."(".number_format($member['mb_point']).")가 참여 ".AS_MP."(".number_format($ev['entry_point']).") 보다 부족합니다.");
		}
	}
} else {
	$is_entry = false;
}

@include_once($board_skin_path.'/event.head.skin.php');

// 입찰 포인트
if(isset($point) && $point) {
	if($point > 0) {
		;
	} else {
	    alert("입찰 ".AS_MP."는 양수로만 등록할 수 있습니다.");
	}

	// 입찰 포인트 제한
	if($ev['tender_limit'] > 0 && $point < $ev['tender_limit']) {
		alert("최소 입찰 ".AS_MP."(".number_format($ev['tender_limit']).") 보다 큰 값을 입력해 주세요.");
	}

	if($is_entry) {
		$limit_point = $ev['entry_point'] + $point;
		if ($member['mb_point'] < $limit_point) {
			alert("보유중인 ".AS_MP."(".number_format($member['mb_point']).")가 참여 + 입찰 ".AS_MP."(".number_format($limit_point).") 보다 부족합니다.");
		}
	} else if ($member['mb_point'] < $point) {
		alert("보유중인 ".AS_MP."(".number_format($member['mb_point']).")가 입찰 ".AS_MP."(".number_format($point).") 보다 부족합니다.");
	}

	// 동일 입찰여부
	$row = sql_fetch(" select count(*) as cnt from {$g5['apms_event']} where mb_id = '{$member['mb_id']}' and bo_table = '$bo_table' and wr_id = '$wr_id' and ev_point = '{$point}' ");
	if($row['cnt']) {
		alert('이미 동일 '.AS_MP.'로 입찰하셨습니다.');
	}

}

// 참가비 처리
if($is_entry) {
	$entry_point = (int)$ev['entry_point'] * (-1);
    insert_point($member['mb_id'], $entry_point, "{$board['bo_subject']} $wr_id 이벤트 참여", $bo_table, $wr_id, "이벤트참여");

	if($ev['spt_id'] && $ev['spt_rate'] > 0) {
		$support_point = $ev['entry_point'] * ( $ev['spt_rate'] / 100 );
	    insert_point($ev['spt_id'], $support_point, "{$board['bo_subject']} $wr_id 이벤트 협찬", $bo_table, $wr_id, "이벤트협찬");
	}
}

// 입찰처리
if(!isset($point) || !$point) $point = 0;

sql_query(" insert into {$g5['apms_event']} set bo_table = '$bo_table', wr_id = '$wr_id', mb_id = '{$member['mb_id']}', ev_point = '$point', ev_datetime = '".G5_TIME_YMDHIS."' ");

// 입찰 횟수
$row = sql_fetch(" select count(*) as cnt from {$g5['apms_event']} where bo_table = '$bo_table' and wr_id = '$wr_id' ");
$tender_count = (int)$row['cnt'];
sql_query(" update $write_table set wr_4 = '$tender_count' where wr_id = '$wr_id' ");
sql_query(" update {$g5['board_new_table']} set as_event = '$tender_count' where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ", false);

@include_once($board_skin_path.'/event.tail.skin.php');

// 참여 완료
alert('이벤트 참여가 완료되었습니다.', G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;page='.$page.$qstr);

?>