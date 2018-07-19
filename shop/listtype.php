<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/listtype.php');
    return;
}

$type = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $_REQUEST['type']);

if(!$type) $type = 1;

if ($type == 1)      $g5['title'] = '히트상품';
else if ($type == 2) $g5['title'] = '추천상품';
else if ($type == 3) $g5['title'] = '최신상품';
else if ($type == 4) $g5['title'] = '인기상품';
else if ($type == 5) $g5['title'] = '할인상품';
else
    alert('상품유형이 아닙니다.');

if($ca_id) {
	$sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' and ca_use = '1'  ";
	$ca = sql_fetch($sql);
	if (!$ca['ca_id'])
	    alert('등록된 분류가 없습니다.');

}

// Page ID
$pid = 'itype'.$type;
$at = apms_page_thema($pid);
if(!$at['gr_id'] && $pid != 'itype') {
	$pid = 'itype';
	$at = apms_page_thema($pid);
}
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 리스트 분류
$cate = array();
$cate = apms_item_category_array($ca_id);
$is_cate = (count($cate) > 0) ? true : false;

// Rows
$skin_row = array();
$skin_row = apms_rows('type_'.MOBILE_.'mods, type_'.MOBILE_.'rows, type_'.MOBILE_.'img_width, type_'.MOBILE_.'img_height, type_'.MOBILE_.'skin, type_'.MOBILE_.'set');
$skin_name = $skin_row['type_'.MOBILE_.'skin'];
$list_mods = $skin_row['type_'.MOBILE_.'mods'];
$list_rows = $skin_row['type_'.MOBILE_.'rows'];
$thumb_w = $skin_row['type_'.MOBILE_.'img_width'];
$thumb_h = $skin_row['type_'.MOBILE_.'img_height'];

// 스킨설정
$wset = array();
if($skin_row['type_'.MOBILE_.'set']) {
	$wset = apms_unpack($skin_row['type_'.MOBILE_.'set']);
}

// 데모
if($is_demo) {
	@include ($demo_setup_file);
}

$skin_path = G5_SKIN_PATH.'/apms/type/'.$skin_name;
$skin_url = G5_SKIN_URL.'/apms/type/'.$skin_name;

// 스킨 체크
list($skin_path, $skin_url) = apms_skin_thema('shop/type', $skin_path, $skin_url); 

$list_skin_path = $skin_path;
$list_skin_url = $skin_url;

// 추가설정
$is_type_sub = false;
$sql_apms_where = $sql_apms_orderby = '';
@include_once($skin_path.'/type.head.skin.php');

$order_by = ($sort != "") ? $sort.' '.$sortodr.' ,'.$sql_apms_orderby.' it_order, pt_num desc, it_id desc' : $sql_apms_orderby.' it_order, pt_num desc, it_id desc'; // 상품 출력순서가 있다면
$where = "it_use = '1'";
$where .= " and it_type{$type} = '1'";
if(isset($ca_id) && $ca_id) {
	$where .= " and (ca_id like '{$ca_id}%' or ca_id2 like '{$ca_id}%' or ca_id3 like '{$ca_id}%')";
	$qstr .= '&amp;ca_id='.$ca_id;
}
$where .= $sql_apms_where;

// 정렬
$list_sort_href = $_SERVER['SCRIPT_NAME'].'?type='.$type.$qstr.'&amp;sort=';

if($sort) $qstr .= '&amp;sort='.$sort;
if($sortodr) $qstr .= '&amp;sortodr='.$sortodr;

// 상위분류
$ca_id_len = strlen($ca_id);
$up_href = '';
if ($ca_id_len > 2){
	$len1 = $ca_id_len - 2;
	$up_href = './listtype.php?type='.$type.$qstr.'&amp;ca_id='.substr($ca_id,0,$len1);
} else if($ca_id_len == 2) {
	$up_href = './listtype.php?type='.$type.$qstr.'&amp;ca_id=';
}

// 상품 리스트
$list = array();

if(!$list_mods) $list_mods = 3;
if(!$list_rows) $list_rows = 5;

// 총몇개 = 한줄에 몇개 * 몇줄
$item_rows = $list_rows * $list_mods;

// 페이지가 없으면 첫 페이지 (1 페이지)
if ($page < 1) $page = 1;
// 시작 레코드 구함
$from_record = ($page - 1) * $item_rows;

// 전체 페이지 계산
$row2 = sql_fetch(" select count(*) as cnt from `{$g5['g5_shop_item_table']}` where $where ");
$total_count = $row2['cnt'];
$total_page  = ceil($total_count / $item_rows);

$num = $total_count - ($page - 1) * $item_rows;
$result = sql_query(" select * from `{$g5['g5_shop_item_table']}` where $where order by $order_by limit $from_record, $item_rows ");
for ($i=0; $row=sql_fetch_array($result); $i++) { 
	$list[$i] = $row;
	$list[$i]['href'] = './item.php?it_id='.$row['it_id'].'&amp;type='.$type.$qstr;
	$list[$i]['num'] = $num;
	$num--;
}

// 페이징
$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['SCRIPT_NAME'].'?type='.$type.$qstr.'&amp;page=';

if($is_type_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$lm = 'type'; // 리스트 모드
$ls = $skin_name; // 리스트 스킨

// 셋업
$setup_href = '';
if (is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
    $setup_href = './skin.setup.php?skin=type&amp;name='.urlencode($ls).'&amp;ts='.urlencode(THEMA);
}

include_once($skin_path.'/type.skin.php');

if($is_type_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>