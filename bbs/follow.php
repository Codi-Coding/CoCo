<?php
include_once('./_common.php');

if ($is_guest) {
	alert_close('회원만 이용가능합니다.');
}

if(!$mode) $mode = 'follow';

if($del) { //삭제하기
	if($mode == 'follow' || $mode == 'like') { // 자신이 follow하고, like한 것만 가능함
		$row = sql_fetch(" select * from {$g5['apms_like']} where id = '{$id}' and mb_id = '{$member['mb_id']}' ", false);
		if(!$row['mb_id']) {
			alert('자료가 없습니다.');
		}

		if($row['mb_id'] != $member['mb_id']) {
			alert('자신의 것만 삭제할 수 있습니다.');
		}

		if($mode == 'follow') {
			$flag_me = 'as_follow';
			$flag_to = 'as_followed';
		} else {
			$flag_me = 'as_like';
			$flag_to = 'as_liked';
		}

		// 상대편 차감	
		sql_query("update {$g5['member_table']} set $flag_to = $flag_to - 1 where mb_id = '{$row['to_id']}' ");

		// 내꺼 차감
		sql_query("update {$g5['member_table']} set $flag_me = $flag_me - 1 where mb_id = '{$member['mb_id']}' ");

		// 내역삭제
		sql_query("delete from {$g5['apms_like']} where id = '{$id}' ");
	}

	goto_url('./follow.php?mode='.$mode);
}

if($rc) { //리카운트
	// 내가 친구로 맺은 회원들 재계산
	$row1 = sql_fetch(" select count(*) as cnt from {$g5['apms_like']} where mb_id = '{$member['mb_id']}' and flag = 'follow' ", false);

	// 나를 친구로 맺은 회원들 재계산
	$row2 = sql_fetch(" select count(*) as cnt from {$g5['apms_like']} where to_id = '{$member['mb_id']}' and flag = 'follow' ", false);

	// 내가 종아하는 회원들 재계산
	$row3 = sql_fetch(" select count(*) as cnt from {$g5['apms_like']} where mb_id = '{$member['mb_id']}' and flag = 'like' ", false);

	// 나를 종아하는 회원들 재계산
	$row4 = sql_fetch(" select count(*) as cnt from {$g5['apms_like']} where to_id = '{$member['mb_id']}' and flag = 'like' ", false);

	// 업데이트
	sql_query(" update {$g5['member_table']} set as_follow = '{$row1['cnt']}', as_followed = '{$row2['cnt']}', as_like = '{$row3['cnt']}', as_liked = '{$row4['cnt']}' where mb_id = '{$member['mb_id']}' ");

	goto_url('./follow.php?mode='.$mode);
} 

if($mode == 'follow') { // 내가 친구로 맺은 회원들
	$sql_common = " from `{$g5['apms_like']}` a left join `{$g5['member_table']}` b on (a.to_id = b.mb_id) where a.mb_id = '{$member['mb_id']}' and a.flag = 'follow' and b.mb_leave_date = '' ";
} else if($mode == 'followed') { // 나를 친구로 맺은 회원들
	$sql_common = " from `{$g5['apms_like']}` a left join `{$g5['member_table']}` b on (a.mb_id = b.mb_id) where a.to_id = '{$member['mb_id']}' and a.flag = 'follow' and b.mb_leave_date = '' ";
} else if($mode == 'like') { // 내가 좋아하는 회원들
	$sql_common = " from `{$g5['apms_like']}` a left join `{$g5['member_table']}` b on (a.to_id = b.mb_id) where a.mb_id = '{$member['mb_id']}' and a.flag = 'like' and b.mb_leave_date = '' ";
} else if($mode == 'liked') { // 나를 좋아하는 회원들
	$sql_common = " from `{$g5['apms_like']}` a left join `{$g5['member_table']}` b on (a.mb_id = b.mb_id) where a.to_id = '{$member['mb_id']}' and a.flag = 'like' and b.mb_leave_date = '' ";
} else {
	exit;
}

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_follow_sub = true;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = $member['mb_nick'].' 님의 팔로우';

if($is_follow_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

// 전체 페이지 계산
$rows = 5;
$row = sql_fetch(" select count(*) as cnt $sql_common ");
$total_count = $row['cnt'];
$total_page  = ceil($total_count / $rows);
$page = ($page > 1) ? $page : 1;
$from_record = ($page - 1) * $rows;

// 리스트
$result = sql_query(" select * $sql_common order by b.mb_today_login desc limit $from_record, $rows ");
for ($i=0; $row=sql_fetch_array($result); $i++) { 

	// Member
	$list[$i] = apms_member($row['mb_id']);

	$list[$i]['del_href'] = ($mode == 'follow' || $mode == 'like') ? G5_BBS_URL.'/follow.php?id='.$row['id'].'&amp;mode='.$mode.'&amp;&del=1' : '';

	$list[$i]['myshop_href'] = '';
	$list[$i]['myrss_href'] = '';
	if(IS_YC && $list[$i]['partner']) {
		$list[$i]['myshop_href'] = G5_SHOP_URL.'/myshop.php?id='.$row['mb_id'];
		$list[$i]['myrss_href'] = G5_URL.'/rss/?id='.$row['mb_id'];
	}

	// Item
	$j = 0;
	if(IS_YC) { 
		$result2 = sql_query(" select it_id, it_name, pt_comment, it_time from {$g5['g5_shop_item_table']} where pt_id = '{$row['mb_id']}' and it_use = '1' order by it_id desc limit 0, 3 ", false);
		for ($j=0; $row2=sql_fetch_array($result2); $j++) {
			$list[$i]['it'][$j]['subject'] = $row2['it_name'];
			$list[$i]['it'][$j]['comment'] = $row2['pt_comment'];
			$list[$i]['it'][$j]['date'] = strtotime($row2['it_time']);
			$list[$i]['it'][$j]['href'] = G5_SHOP_URL.'/item.php?it_id='.$row2['it_id'];
		}
	}
	$list[$i]['is_it'] = ($j > 0) ? true : false;

	// Post
	$result3 = sql_query(" select bo_table, wr_id from {$g5['board_new_table']} where mb_id = '{$row['mb_id']}' and wr_parent = wr_id order by bn_id desc limit 0, 3 ", false);
	for ($j=0; $row3=sql_fetch_array($result3); $j++) {
		$tmp_write_table = $g5['write_prefix'] . $row3['bo_table']; 
		$wr = sql_fetch(" select wr_subject, wr_comment, wr_datetime from $tmp_write_table where wr_id = '{$row3['wr_id']}' ", false);
		$list[$i]['wr'][$j]['subject'] = $wr['wr_subject'];
		$list[$i]['wr'][$j]['comment'] = $wr['wr_comment'];
		$list[$i]['wr'][$j]['date'] = strtotime($wr['wr_datetime']);
		$list[$i]['wr'][$j]['href'] = G5_BBS_URL.'/board.php?bo_table='.$row3['bo_table'].'&amp;wr_id='.$row3['wr_id'];
	}

	$list[$i]['is_wr'] = ($j > 0) ? true : false;

	// Login
	$row4 = sql_fetch(" select count(*) as cnt from {$g5['login_table']} where mb_id = '{$row['mb_id']}' ");
	$list[$i]['online'] = $row4['cnt'];
}

// 리카운트
if($mode == 'follow') { // 내가 친구로 맺은 회원들
	if($member['as_follow'] != $total_count) {
		sql_query(" update {$g5['member_table']} set as_follow = '$total_count' where mb_id = '{$member['mb_id']}' ", false);
		$member['follow'] = $member['as_follow'] = $total_count;
	}
} else if($mode == 'followed') { // 나를 친구로 맺은 회원들
	if($member['as_followed'] != $total_count) {
		sql_query(" update {$g5['member_table']} set as_followed = '$total_count' where mb_id = '{$member['mb_id']}' ", false);
		$member['followed'] = $member['as_followed'] = $total_count;
	}
} else if($mode == 'like') { // 내가 좋아하는 회원들
	if($member['as_like'] != $total_count) {
		sql_query(" update {$g5['member_table']} set as_like = '$total_count' where mb_id = '{$member['mb_id']}' ", false);
		$member['like'] = $member['as_like'] = $total_count;
	}
} else if($mode == 'liked') { // 나를 좋아하는 회원들
	if($member['as_liked'] != $total_count) {
		sql_query(" update {$g5['member_table']} set as_liked = '$total_count' where mb_id = '{$member['mb_id']}' ", false);
		$member['liked'] = $member['as_liked'] = $total_count;
	}
}

$write_page_rows = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = './follow.php?mode='.$mode.'&amp;page=';
$recount_href = './follow.php?mode='.$mode.'&amp;rc=1';
$follow_href = './follow.php?mode=follow';
$follow_on = ($mode == 'follow') ? true : false;
$followed_href = './follow.php?mode=followed';
$followed_on = ($mode == 'followed') ? true : false;
$like_href = './follow.php?mode=like';
$like_on = ($mode == 'like') ? true : false;
$liked_href = './follow.php?mode=liked';
$liked_on = ($mode == 'liked') ? true : false;

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('member_mobile') : apms_skin_set('member');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=member&amp;ts='.urlencode(THEMA);
}

include_once($skin_path.'/follow.skin.php');

if($is_follow_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>