<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

//분류권한
$is_cauth = apms_is_cauth();

// 분류
$category = array();
$category_options  = '';
$sql = " select * from {$g5['g5_shop_category_table']} ";
if (!$is_cauth)
    $sql .= " where pt_use = '1' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$c = $row['ca_id'];
	$category[$c] = $row['ca_name'];

	$len = strlen($row['ca_id']) / 2 - 1;
    $nbsp = '';
    for ($i=0; $i<$len; $i++) {
        $nbsp .= '&nbsp;&nbsp;&nbsp;';
    }

	if($row['as_line']) {
		$category_options .= "<option value=\"\">".$nbsp."------------</option>\n";
	}

    $category_options .= '<option value="'.$row['ca_id'].'">'.$nbsp.$row['ca_name'].'</option>'.PHP_EOL;
}

// 아이피
$is_ip_view = ($is_admin) ? true : false;

$is_shingo = ($default['pt_shingo'] > 0) ? true : false;

$list = array();

if ($member['mb_id'] == $config['cf_admin']) {
	$where = " (a.pt_id = '' or a.pt_id = '{$member['mb_id']}')";
} else {
	$where = " a.pt_id = '{$member['mb_id']}'";
}

if ($sca) {
    $where .= " and (b.ca_id like '$sca%' or b.ca_id2 like '$sca%' or b.ca_id3 like '$sca%') ";
}

if ($opt == "1") { // 자신
    $where .= " and a.mb_id = '{$member['mb_id']}' ";
} else if($opt == "2") { // 전체
	;
} else { //회원
    $where .= " and a.mb_id <> '{$member['mb_id']}' ";
}

if ($save_opt != $opt) {
	$page = 1;
}

$sql_common = " from {$g5['apms_comment']} a join {$g5['g5_shop_item_table']} b on (a.it_id=b.it_id) where $where ";

$sql = " select count(wr_id) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_'.MOBILE_.'page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * $sql_common order by a.wr_id desc limit $from_record, $rows ";
$result = sql_query($sql);
$num = $total_count - ($page - 1) * $rows;
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	$list[$i]['num'] = $num;
	$list[$i]['name'] = apms_sideview($row['mb_id'], $row['wr_name'], $row['wr_email'], $row['wr_homepage'], $row['wr_level']);

	$list[$i]['is_lock'] = ($row['wr_shingo'] < 0) ? true : false;

	$list[$i]['reply_name'] = ($row['wr_comment_reply'] && $row['wr_re_name']) ? $row['wr_re_name'] : '';

	$is_content = false;
	$list[$i]['content1'] = $row['wr_content'];
	$list[$i]['content'] = conv_content($row['wr_content'], 0, 'wr_content');
	if($is_shingo && $row['wr_shingo'] < 0) {
		if($is_admin || ($row['mb_id'] && $row['mb_id'] == $member['mb_id'])) {
			$list[$i]['content'] = '<p><b>블라인더 처리된 댓글입니다.</b></p>'.$list[$i]['content'];
		} else {
			$list[$i]['content'] = '<p><b>블라인더 처리된 댓글입니다.</b></p>';
		}

	}
	$list[$i]['content'] = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src='$1://$2.$3' alt='' style='max-width:100%;border:0;'>", $list[$i]['content']);
	$list[$i]['content'] = apms_content($list[$i]['content']);

	//럭키포인트
	if($row['wr_lucky']) {
		$list[$i]['content'] = $list[$i]['content'].''.str_replace("[point]", number_format($row['wr_lucky']), $xp['lucky_msg']);
	}
    $list[$i]['date'] = strtotime($list[$i]['wr_datetime']);
    $list[$i]['href'] = './item.php?it_id='.$list[$i]['it_id'].'#itemcomment';

    // 관리자가 아니라면 중간 IP 주소를 감춘후 보여줍니다.
    $list[$i]['ip'] = $row['wr_ip'];
    if (!$is_admin)
        $list[$i]['ip'] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['wr_ip']);

	$num--;
}

$write_pages = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = './?ap='.$ap.'&amp;sca='.$sca.'&amp;save_opt='.$opt.'&amp;opt='.$opt.'&amp;page=';

include_once($skin_path.'/comment.skin.php');
?>
