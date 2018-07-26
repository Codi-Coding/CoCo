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

$list = array();

if ($member['mb_id'] == $config['cf_admin']) {
	$where = " (a.pt_id = '' or a.pt_id = '{$member['mb_id']}')";
} else {
	$where = " a.pt_id = '{$member['mb_id']}'";
}

if ($sca) {
    $where .= " and (b.ca_id like '$sca%' or b.ca_id2 like '$sca%' or b.ca_id3 like '$sca%') ";
}

if ($opt) { // 별점
    $where .= " and a.is_score = '$opt' ";
} 

$where .= " and a.is_confirm = '1' ";

$sql_common = " from {$g5['g5_shop_item_use_table']} a join {$g5['g5_shop_item_table']} b on (a.it_id=b.it_id) where $where ";

$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_'.MOBILE_.'page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * $sql_common order by a.is_id desc limit $from_record, $rows ";
$result = sql_query($sql);
$num = $total_count - ($page - 1) * $rows;
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	$list[$i]['is_num'] = $num;
	$list[$i]['is_time'] = strtotime($row['is_time']);
	$list[$i]['is_star'] = apms_get_star($row['is_score']);
	$list[$i]['is_photo'] = apms_photo_url($row['mb_id']);
	$list[$i]['it_href'] = './item.php?it_id='.$row['it_id'];
	$list[$i]['is_content'] = apms_content(conv_content($row['is_content'], 1));
	$list[$i]['is_reply'] = false;
	if(!empty($row['is_reply_content'])) {
		$list[$i]['is_reply'] = true;
		$list[$i]['is_reply_name'] = get_text($row['is_reply_name']); 
		$list[$i]['is_reply_subject'] = get_text($row['is_reply_subject']); 
		$list[$i]['is_reply_content'] = apms_content(conv_content($row['is_reply_content'], 1));
	}

	$list[$i]['is_reply_href'] = './?ap=useform&amp;is_id='.$row['is_id'].'&amp;sca='.$sca.'&amp;save_opt='.$opt.'&amp;opt='.$opt.'&amp;page='.$page;

	$num--;
}

$write_pages = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = './?ap='.$ap.'&amp;sca='.$sca.'&amp;save_opt='.$opt.'&amp;opt='.$opt.'&amp;page=';

include_once($skin_path.'/uselist.skin.php');
?>
