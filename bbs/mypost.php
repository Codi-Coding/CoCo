<?php
include_once('./_common.php');

if ($is_guest)
    alert_close('회원만 조회하실 수 있습니다.');

if(!$mode) $mode = 1;

// Page ID
$pid = ($pid) ? $pid : 'mypost';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_mypost_sub = true;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = $member['mb_nick'].' 님의 포스트';

if($is_mypost_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

$list = array();

$rows = $config['cf_'.MOBILE_.'page_rows'];
$img_width = $default['pt_img_width'];
$admin_photo = apms_photo_url($config['cf_admin']);

if($mode == "3" || $mode == "4" || $mode == "5") { // 아이템 댓글, 후기, 문의

	if($mode == "4") {
		$sql_common = " from {$g5['g5_shop_item_use_table']} a join {$g5['g5_shop_item_table']} b on (a.it_id=b.it_id) join {$g5['g5_shop_category_table']} c on (b.ca_id=c.ca_id) ";
		$sql_order = " order by a.is_id desc ";
	} else if($mode == "5") {
		$sql_common = " from {$g5['g5_shop_item_qa_table']} a join {$g5['g5_shop_item_table']} b on (a.it_id=b.it_id) join {$g5['g5_shop_category_table']} c on (b.ca_id=c.ca_id) ";
		$sql_order = " order by a.iq_id desc ";
	} else {
		$sql_common = " from {$g5['apms_comment']} a join {$g5['g5_shop_item_table']} b on (a.it_id=b.it_id) join {$g5['g5_shop_category_table']} c on (b.ca_id=c.ca_id) ";
		$sql_order = " order by a.wr_id desc ";
	}

	$sql_common .= " where a.mb_id = '{$member['mb_id']}' ";

	if($ca_id) {
		$sql_common .= " and (b.ca_id like '{$ca_id}%' or b.ca_id2 like '{$ca_id}%' or b.ca_id3 like '{$ca_id}%')";
	}

	$sql = " select count(*) as cnt {$sql_common} ";
	$row = sql_fetch($sql);
	$total_count = $row['cnt'];

	$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
	if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
	$from_record = ($page - 1) * $rows; // 시작 열을 구함

	$sql = " select a.*, b.*, c.ca_name {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
	$result = sql_query($sql);
	$num = $total_count - ($page - 1) * $rows;
	if($mode == "4") {
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$list[$i] = $row;
			$list[$i]['num'] = $num;
			$list[$i]['date'] = strtotime($row['is_time']);
			$list[$i]['star'] = apms_get_star($row['is_score']);
			$list[$i]['it_href'] = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
			$list[$i]['it_comment'] = $row['pt_comment'];
			$list[$i]['is_content'] = apms_content(conv_content($list[$i]['is_content'], 1));
			$list[$i]['is_reply'] = false;
			if(!empty($row['is_reply_content'])) {
				$list[$i]['is_reply'] = true;
				$list[$i]['is_reply_name'] = get_text($row['is_reply_name']); 
				$list[$i]['is_reply_subject'] = get_text($row['is_reply_subject']); 
				$list[$i]['is_reply_content'] = apms_content(conv_content($row['is_reply_content'], 1));
			}
			$num--;
		}
	} else if($mode == "5") {
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$list[$i] = $row;
			$list[$i]['num'] = $num;
			$list[$i]['date'] = strtotime($row['iq_time']);
			$list[$i]['it_href'] = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
			$list[$i]['it_comment'] = $row['pt_comment'];
			$list[$i]['answer'] = ($row['iq_answer']) ? true : false;
			if($row['pt_id']) {
				$list[$i]['ans_photo'] = ($row['pt_id'] == $config['cf_admin']) ? $admin_photo : apms_photo_url($row['pt_id']);
			} else {
				$list[$i]['ans_photo'] = $admin_photo;
			}
			$list[$i]['iq_question'] = apms_content(conv_content($list[$i]['iq_question'], 1));
			$list[$i]['iq_answer'] = apms_content(conv_content($list[$i]['iq_answer'], 1));
			$num--;
		}
	} else {
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$list[$i] = $row;
			$list[$i]['num'] = $num;
		    $list[$i]['date'] = strtotime($list[$i]['wr_datetime']);
			$list[$i]['reply_name'] = ($row['wr_comment_reply'] && $row['as_re_name']) ? $row['as_re_name'] : '';
			$list[$i]['it_href'] = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
			$list[$i]['it_comment'] = $row['pt_comment'];
			$list[$i]['content'] = apms_content(conv_content($row['wr_content'], 0, 'wr_content'));
			$list[$i]['content'] = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src='$1://$2.$3' alt='' style='max-width:100%;border:0;'>", $list[$i]['content']);
			//럭키포인트
			if($row['wr_lucky']) {
				$list[$i]['content'] = $list[$i]['content'].''.str_replace("[point]", number_format($row['wr_lucky']), $xp['lucky_msg']);
			}
			$num--;
		}
	}
} else { // 포스트

	$sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c where a.bo_table = b.bo_table and b.gr_id = c.gr_id ";

	if ($gr_id) {
		$sql_common .= " and b.gr_id = '$gr_id' ";
	}
	if ($mode == "2") {
		$sql_common .= " and a.wr_id <> a.wr_parent ";
	} else {
		$sql_common .= " and a.wr_id = a.wr_parent ";
	}
	$sql_common .= " and a.mb_id = '{$member['mb_id']}' ";
	$sql_order = " order by a.bn_id desc ";

	$sql = " select count(*) as cnt {$sql_common} ";
	$row = sql_fetch($sql);
	$total_count = $row['cnt'];

	$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
	if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
	$from_record = ($page - 1) * $rows; // 시작 열을 구함

	$group_select = '';
	$sql = " select gr_id, gr_subject from {$g5['group_table']} order by gr_id ";
	$result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$group_select .= "<option value=\"".$row['gr_id']."\">".$row['gr_subject'].'</option>';
	}

	$parent = array();

	$sql = " select a.*, b.bo_subject, c.gr_subject, c.gr_id {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
	$result = sql_query($sql);
	$num = $total_count - ($page - 1) * $rows;
	if($mode == "2") { // 댓글
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$tmp_write_table = $g5['write_prefix'].$row['bo_table'];

			$row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ");
			$row3 = sql_fetch(" select wr_content, wr_datetime, as_lucky from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");
			$list[$i] = $row2;
			$parent[$i] = $row2;
			$list[$i]['num'] = $num;
			$list[$i]['wr_id'] = $row['wr_id'];
			$list[$i]['wr_datetime'] = $row3['wr_datetime'];
			$list[$i]['date'] = strtotime($list[$i]['wr_datetime']);
			$list[$i]['gr_id'] = $row['gr_id'];
			$list[$i]['bo_table'] = $row['bo_table'];
			$list[$i]['href'] = G5_BBS_URL.'/board.php?bo_table='.$row['bo_table'].'&amp;wr_id='.$row2['wr_id'].'#c_'.$row['wr_id'];
			$list[$i]['reply_name'] = ($row['wr_comment_reply'] && $row['as_re_name']) ? $row['as_re_name'] : '';
			$list[$i]['gr_subject'] = $row['gr_subject'];
			$list[$i]['bo_subject'] = $row['bo_subject'];
			$list[$i]['comment'] = $row2['wr_comment'];
			$list[$i]['subject'] = $row2['wr_subject'];
			$list[$i]['wr_content'] = $row3['wr_content'];
			$list[$i]['content'] = apms_content(conv_content($row3['wr_content'], 0, 'wr_content'));
			$list[$i]['content'] = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src='$1://$2.$3' alt='' style='max-width:100%;border:0;'>", $list[$i]['content']);
			//럭키포인트
			if($row3['as_lucky']) {
				$list[$i]['content'] = $list[$i]['content'].''.str_replace("[point]", number_format($row3['as_lucky']), $xp['lucky_msg']);
			}
			$num--;
		}

	} else {
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$tmp_write_table = $g5['write_prefix'].$row['bo_table'];

			$row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ");
			$list[$i] = $row2;
			$list[$i]['num'] = $num;
			$list[$i]['gr_id'] = $row['gr_id'];
			$list[$i]['bo_table'] = $row['bo_table'];
			$list[$i]['href'] = G5_BBS_URL.'/board.php?bo_table='.$row['bo_table'].'&amp;wr_id='.$row2['wr_id'];
			$list[$i]['date'] = strtotime($list[$i]['wr_datetime']);
			$list[$i]['subject'] = $row2['wr_subject'];
			$list[$i]['comment'] = $row2['wr_comment'];
			$list[$i]['gr_subject'] = $row['gr_subject'];
			$list[$i]['bo_subject'] = $row['bo_subject'];
			$num--;
		}		
	}
}

$write_page_rows = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['PHP_SELF'].'?mode='.$mode;
if($gr_id) $list_page .= '&amp;gr_id='.$gr_id;
if($ca_id) $list_page .= '&amp;ca_id='.$ca_id;
$list_page .= '&amp;page=';

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('member_mobile') : apms_skin_set('member');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=member&amp;ts='.urlencode(THEMA);
}

include_once($skin_path.'/mypost.skin.php');

if($is_mypost_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>