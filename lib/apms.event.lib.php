<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 타임스탬프 형식으로 넘어와야 한다.
// 시작시간, 종료시간
if (!function_exists('gap_time')) {
	function gap_time($begin_time, $end_time)
	{
		$gap = $end_time - $begin_time;
		$time['days']    = (int)($gap / 86400);
		$time['hours']   = (int)(($gap - ($time['days'] * 86400)) / 3600);
		$time['minutes'] = (int)(($gap - ($time['days'] * 86400 + $time['hours'] * 3600)) / 60);
		$time['seconds'] = (int)($gap - ($time['days'] * 86400 + $time['hours'] * 3600 + $time['minutes'] * 60));
		return $time;
	}
}

// 당첨점수
function apms_event_point($ev, $bo_table, $wr_id) {
	global $g5;

	if($ev['win_pay']) { // 총 참가금액의 1/n
		if($ev['win'] > 0) {
			$row = sql_fetch(" select sum(po_point) as point from {$g5['point_table']} where po_rel_table = '{$bo_table}' and po_rel_id = '{$wr_id}' and po_rel_action = '이벤트참여' and po_point < '0' ");

			$sum = $row['point'] * (-1);
			$fee = ($ev['win_fee'] > 0) ? $sum * ($ev['win_fee'] / 100) : 0;
			$sum = $sum - $fee;
			$point = round($sum / $ev['win']);

			//참가비 보다 적다면
			if($ev['entry_point'] > $point) {
				$point = $ev['entry_point'];
			}
		} else {
			$point = $ev['entry_point'];
		}
	} else {
		$point = $ev['win_point'];
	}

	return $point;
}

// 이벤트 정보(추가필드)
function apms_event_info($bo_table, $wr_id, $row=null) {
    global $g5, $is_admin;

	// as_down : 당첨 포인트
	// wr_1 : 시작일시
	// wr_2 : 종료일시
	// wr_3 : 당첨방법|당첨인원|참가비|참가비 증가율|입찰횟수|최소입찰|당첨자공개|최고가공개|당첨가공개|당첨금|수수료
	// wr_4 : 총 입찰 횟수
	// wr_5 : 종료처리(1)
	// wr_6 : 협찬정보
	// wr_7 : 협찬회원 ID
	// wr_8 : 참가비 적립율

	$ev = array();

	if (!$row) {
		$tmp_write_table = $g5['write_prefix'] . $bo_table;
		$row = sql_fetch(" select as_down, wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10 from $tmp_write_table where wr_id = '$wr_id' ");
	}

    $res = explode("|", $row['wr_3']);

	$ev['win_point'] = $row['as_down'];
	$ev['start_datetime'] = $row['wr_1'];
    $ev['end_datetime'] = $row['wr_2'];
	$ev['type'] = $res[0];
	$ev['win'] = (int)$res[1];
	$ev['entry_point'] = (int)$res[2];
	$ev['entry_rate'] = (int)$res[3];
	$ev['tender'] = (int)$res[4];
	$ev['tender_limit'] = (int)$res[5];
	$ev['show_win'] = (int)$res[6];
	$ev['show_tender'] = (int)$res[7];
	$ev['show_tender_win'] = (int)$res[8];
	$ev['win_pay'] = (int)$res[9];
	$ev['win_fee'] = (int)$res[10];
	$ev['tender_count'] = (int)$row['wr_4'];
    $ev['end'] = $row['wr_5'];
	$ev['spt_info'] = $row['wr_6'];
	$ev['spt_id'] = $row['wr_7'];
	$ev['spt_rate'] = (int)$row['wr_8'];

	if($ev['type']) {
		$ev['tender'] = 1;
		$ev['tender_limit'] = 0;
	}

	if (G5_TIME_YMDHIS < $ev['start_datetime']) {
		$ev['status'] = '시작전';
		$ev['show_win'] = 1;
		$ev['show_tender'] = 1;
	    $ev['end'] = '';
	} else if (G5_TIME_YMDHIS > $ev['end_datetime']) {
		$ev['status'] = '종료';
	} else {
		$ev['status'] = '진행중';
		$ev['show_win'] = 1;
	    $ev['end'] = '';
	}

    // 경매가 종료되지 않았다면
    if (G5_TIME_YMDHIS < $ev['end_datetime'] && $ev['entry_rate'] > 0) {
        // 날짜가 지날수록 초기 참여포인트에 $res['entry_rate'] 만큼 더해진다.
        $date = gap_time(strtotime(substr($ev['start_datetime'],0,10)), G5_SERVER_TIME);
        // 보통 자정부터 시작하므로 일수의 갭이 2일 일경우로 제한한다.
        if ($date['days'] > 0) {
			$ev_rate = $date['days'] * ($ev['entry_rate'] / 100);
            $ev['entry_point'] = (int)($ev['entry_point'] + ($ev['entry_point'] * $ev_rate));
        }

        // 입찰이 많아보이기 위해 입찰 횟수의 초기값을 변경
        // if ($res['status'] > 0) $res['tender_count'] += 9999;
    }

    return $ev;
}

// 당첨자
function apms_event_win($bo_table, $wr_id, $ev, $ex_mb='') {
	global $g5, $config, $board, $write_table, $view;

	$list = array();

	$rows = (int)$ev['win']; // 당첨자수

	if($ev['status'] == '종료') {
		if($ev['end']) {
			$result = sql_query(" select * from {$g5['apms_event']} where bo_table = '$bo_table' and wr_id = '$wr_id' and ev_win = '1' order by ev_point desc limit 0, $rows ", false); //당첨현황
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				$list[$i] = $row;
			}
		} else {
			$sql_ex = ($ex_mb) ? "and find_in_set(mb_id, '{$ex_mb}')=0" : "";
			if($ev['type']) { //랜덤당첨
				$result = sql_query(" select *, max(ev_point) as ev_point from {$g5['apms_event']} where bo_table = '$bo_table' and wr_id = '$wr_id' $sql_ex group by mb_id order by rand() limit 0, $rows ", false);
			} else { //최고입찰
				$result = sql_query(" select *, max(ev_point) as ev_point from {$g5['apms_event']} where bo_table = '$bo_table' and wr_id = '$wr_id' $sql_ex group by mb_id order by ev_point desc, ev_datetime limit 0, $rows ", false);
			}

			// 당첨 포인트
			$win_point = apms_event_point($ev, $bo_table, $wr_id);

			for ($i=0; $row=sql_fetch_array($result); $i++) {
				$list[$i] = $row;
				$list[$i]['ev_win'] = 1;

				// 낙찰포인트 차감
				$confirm = 1;
				if(!$ev['type'] && $row['ev_point'] > 0) {
					$mb = get_member($row['mb_id'], 'mb_point');
					if($mb['mb_point'] >= $row['ev_point']) {
						$ev_point = $row['ev_point'] * (-1);
					    insert_point($row['mb_id'], $ev_point, "{$board['bo_subject']} $wr_id 이벤트 낙찰", $bo_table, $wr_id, "이벤트낙찰");
					} else {
						$confirm = 0;
					}
				}
				
				// 이벤트 당첨포인트
				if($confirm && $win_point) {
				    insert_point($row['mb_id'], $win_point, "{$board['bo_subject']} $wr_id 이벤트 당첨", $bo_table, $wr_id, "이벤트당첨");
				}

				// 당첨정보 입력
				sql_query(" update {$g5['apms_event']} set ev_win = '1', ev_confirm = '$confirm' where bo_table = '$bo_table' and wr_id = '$wr_id' and mb_id = '{$row['mb_id']}' and ev_point = '{$row['ev_point']}' ", false);

				// 쪽지발송
				if($confirm) {
					$msg = get_text($view['wr_subject']).' 이벤트에 당첨되셨습니다.\n\n';
					$msg .= '이벤트 바로가기 : '.G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_id;
				} else {
					$msg = get_text($view['wr_subject']).' 이벤트에 당첨되셨으나 보유 포인트 부족으로 당첨처리가 되지 않았습니다.\n\n';
					$msg .= '포인트 확인 후 해당 이벤트에서 당첨처리 또는 당첨포기를 해 주셔야 다른 이벤트에도 참여가 가능합니다.\n\n';
					$msg .= '(이벤트 당첨을 포기하시더라도 이벤트 참여비는 반환되지 않습니다.)\n\n';
					$msg .= '이벤트 바로가기 : '.G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_id;
				}

			    $tmp_row = sql_fetch(" select max(me_id) as max_me_id from {$g5['memo_table']} ");
			    $me_id = $tmp_row['max_me_id'] + 1;

			    // 쪽지 INSERT
			    sql_query(" insert into {$g5['memo_table']} ( me_id, me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo ) values ( '$me_id', '{$row['mb_id']}', '{$config['cf_admin']}', '".G5_TIME_YMDHIS."', '{$msg}' ) ", false);

				// 읽지 않은 쪽지체크
				$tmp_row2 = sql_fetch(" select count(*) as cnt from {$g5['memo_table']} where me_recv_mb_id = '{$row['mb_id']}' and me_read_datetime = '0000-00-00 00:00:00' ", false);

			    // 실시간 쪽지 알림 기능
			    sql_query(" update {$g5['member_table']} set mb_memo_call = '{$config['cf_admin']}', as_memo = '{$tmp_row2['cnt']}' where mb_id = '{$row['mb_id']}' ", false);

				// Push -----------------------------------------------------------------
				apms_push($row['mb_id'], '이벤트 당첨을 축하드립니다.', $msg, G5_URL);

			}

			// 종료처리
			sql_query(" update $write_table set wr_5 = '1' where wr_id = '$wr_id' ");
		}
	}

	return $list;
}

// 내기록
function apms_event_own($bo_table, $wr_id, $mb_id) {
	global $g5;

	$list = array();

	$n = 0;
	$j = 0;
	if($mb_id) {
		$result = sql_query(" select * from {$g5['apms_event']} where bo_table = '$bo_table' and wr_id = '$wr_id' and mb_id = '$mb_id' order by ev_id desc ", false);
		for ($i=1; $row=sql_fetch_array($result); $i++) {
			if($row['ev_win']) {
				$n = $i;
				if(!$row['ev_confirm']) {
					$j++;
				}
			}
			$list[$i] = $row;
		}
	}

	$list[0]['is_win'] = $n; // 당첨
	$list[0]['is_confirm'] = $j; // 미처리 확인

	return $list;
}

// 최고가
function apms_event_tender($bo_table, $wr_id) {
	global $g5;

	$row = sql_fetch(" select ev_point from {$g5['apms_event']} where bo_table = '$bo_table' and wr_id = '$wr_id' order by ev_point desc limit 0, 1 ", false); //최고입찰가
	
	$tender = $row['ev_point'];

	return $tender;
}

?>