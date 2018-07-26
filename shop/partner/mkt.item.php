<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$list = array();

// 분류
$category = array();
$category_options  = '';
$sql = " select * from {$g5['g5_shop_category_table']} where ca_use = '1' order by ca_order, ca_id ";
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

// 검색
$sql_search = "";
if ($stx) {
	$sql_search .= " and $sfl like '%$stx%' ";
}

if ($sca) {
    $sql_search .= " and (ca_id like '$sca%' or ca_id2 like '$sca%' or ca_id3 like '$sca%') ";
}

$sql_orderby = '';
if ($sst && $sod) {
	$sql_order = "{$sst} {$sod},";
}

$sql_common = " from {$g5['g5_shop_item_table']} where pt_marketer > 0 $sql_search ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_'.MOBILE_.'page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
$sql  = " select * $sql_common order by $sql_orderby pt_num desc, it_id desc limit $from_record, $rows ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	$list[$i]['href'] = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
	$list[$i]['num'] = $total_count - ($page - 1) * $rows - $i;

	$c1 = $row['ca_id'];
	$c2 = ($row['ca_id2']) ? $row['ca_id2'] : substr($c1,0,4);
	$c3 = ($row['ca_id3']) ? $row['ca_id3'] : substr($c1,0,2);

	$list[$i]['ca_name1'] = $category[$c1];
	$list[$i]['ca_name2'] = $category[$c2];
	$list[$i]['ca_name3'] = $category[$c3];
}

// 페이징
$write_pages = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = './?ap='.$ap.'&amp;'.$qstr.'&amp;page=';

echo '<script src="./script.js"></script>'.PHP_EOL;

include_once($skin_path.'/mkt.item.skin.php');
?>
