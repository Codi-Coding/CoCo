<?php
include_once('./_common.php');

@include_once($board_skin_path.'/poll.head.skin');

if(!($bo_table && $wr_id)) 
    alert('값이 제대로 넘어오지 않았습니다.');

$ss_name = 'ss_view_'.$bo_table.'_'.$wr_id;

if(!get_session($ss_name))
    alert('해당 게시물에서만 참여할 수 있습니다.');

$row = sql_fetch(" select count(*) as cnt from {$g5['write_prefix']}{$bo_table} ", FALSE);
if(!$row['cnt'])
    alert('존재하는 게시판이 아닙니다.');

if(!$write['as_extra'])
    alert('해당 기능을 사용할 수 없는 게시물입니다.');

$ans = preg_replace('/[^0-9]/', '', $ans);
if(!$ans)
    alert('값이 제대로 넘어오지 않았습니다.');

$po = sql_fetch(" select * from {$g5['apms_poll']} where po_id = '{$_POST['po_id']}' ", false);
if(!$po['po_id'])
    alert('값이 제대로 넘어오지 않았습니다.');

if(!$po['po_use'])
    alert('종료되어 더이상 참여할 수 없습니다.');

if($po['po_end'] && G5_SERVER_TIME > strtotime($po['po_endtime']))
    alert('종료되어 더이상 참여할 수 없습니다.');

if($member['mb_level'] < $po['po_level']) {
	$mg = 'xp_grade'.$po['po_level'];
	alert($xp[$mg].'('.$po['po_level'].') 이상 회원만 참여할 수 있습니다.');
}

if($po['po_join'] > 0) {

	if($is_guest)
	    alert('회원만 참여할 수 있습니다.');

	if($po['po_join'] > $member['mb_point'])
	    alert("보유중인 ".AS_MP."(".number_format($member['mb_point']).")가 참여 ".AS_MP."(".number_format($po['po_join']).") 보다 부족합니다.");

}

// 체크용
$is_point = true;
$search_mb_id = false;
$search_ip = false;

// 메시지
if($po['po_type'] == "1") {
	$po_msg = '별점 참여'; 
	$po_act = '별점'; 
	$ans_msg = '';
} else if($po['po_type'] == "2") {
	$po_msg = '설문 참여'; 
	$po_act = '설문'; 
	$ans_msg = '참여에 감사드립니다.';
} else if($po['po_type'] == "3") {
	$po_msg = '퀴즈 정답'; 
	$po_act = '퀴즈'; 
	if($po['po_ans'] == $ans) {
		$ans_msg = '정답입니다.';
		$is_point = true;
	} else {
		$ans_msg = '오답입니다.';
		$is_point = false;
	}
} else {
    alert('등록된 정보가 없습니다.');
}

@include_once($board_skin_path.'/poll.skin.php');

if($is_member) {
    // 투표했던 회원아이디들 중에서 찾아본다
    $ids = explode(',', trim($po['mb_ids']));
	$ids_cnt = count($ids);
    for ($i=0; $i < $ids_cnt; $i++) {
        if ($member['mb_id'] == trim($ids[$i])) {
            $search_mb_id = true;
            break;
        }
    }
} else {
    // 투표했던 ip들 중에서 찾아본다
    $ips = explode(',', trim($po['po_ips']));
	$ips_cnt = count($ips);
	for ($i=0; $i < $ips_cnt; $i++) {
		if ($_SERVER['REMOTE_ADDR'] == trim($ips[$i])) {
            $search_ip = true;
            break;
        }
    }
}

// 이동주소
$goto_url = G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr;

// 없다면 선택한 전체값 및 해당 항목을 1증가 시키고 ip, id를 저장
if (!($search_ip || $search_mb_id)) {

	$sql_po = " po_score = po_score + {$ans}, po_cnt = po_cnt + 1, po_cnt{$ans} = po_cnt{$ans} + 1 ";
    if ($is_member) { // 회원일 때는 id만 추가
        $mb_ids = $member['mb_id'].','.$po['mb_ids'];
        $sql = " update {$g5['apms_poll']} set $sql_po , mb_ids = '$mb_ids' where po_id = '{$po['po_id']}' ";
    } else {
	    $po_ips = $_SERVER['REMOTE_ADDR'].','.$po['po_ips'];
		$sql = " update {$g5['apms_poll']} set $sql_po , po_ips = '$po_ips' where po_id = '{$po['po_id']}' ";
    }

    sql_query($sql, false);

	//별점
	$sql_star = ($po['po_type'] == "1") ? ", as_star_score = as_star_score + {$ans}, as_star_cnt = as_star_cnt + 1" : "";
	sql_query(" update {$write_table} set as_poll = as_poll + 1 $sql_star where wr_id = '{$wr_id}' ", false);

	// 새글
	sql_query(" update {$g5['board_new_table']} set as_poll = as_poll + 1 where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ", false);

	if (!$search_mb_id && $is_point)
		insert_point($member['mb_id'], $po['po_point'], "{$board['bo_subject']} {$wr_id} {$po_msg}", $bo_table, $wr_id, $po_act);

	if($po['po_join'] > 0)
		insert_point($member['mb_id'], $po['po_join'] * (-1), "{$board['bo_subject']} $wr_id 참여", $bo_table, $wr_id, "참여");
		
	@include_once($board_skin_path.'/poll.tail.skin.php');

	if($ans_msg) {
		alert($ans_msg, $goto_url);
	} else {
		goto_url($goto_url);
	}
} else {
	alert('이미 참여하셨습니다.', $goto_url);
}

?>