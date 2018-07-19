<?php
include_once('./_common.php');

$id = apms_escape_string(trim($id));

if(!$id) {
	goto_url(G5_SHOP_URL.'/partner');
}

$author = array();
$mb_id = $id;
$author = apms_member($mb_id);

$is_auth = false;
$is_cf = false;
if($author['partner']) {
	;
} else if($is_admin == 'super') {
	$is_auth = true;
} else if($mb_id == $config['cf_admin']) {
	$is_cf = true;
} else {
	alert('등록된 마이샵이 없습니다.', G5_SHOP_URL);
}

// Page ID
$pid = ($pid) ? $pid : 'myshop';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// RSS
$rss_href = G5_URL.'/rss/?id='.$id;

// Partner
$myshop_href = ($mb_id == $member['mb_id']) ? G5_SHOP_URL.'/partner' : '';

$author_homepage = set_http(clean_xss_tags($author['mb_homepage']));
$author_profile = ($author['mb_profile']) ? conv_content($author['mb_profile'],0) : '';
$author_signature = ($author['mb_signature']) ? apms_content(conv_content($author['mb_signature'], 1)) : '';

// where
if($is_auth || $is_cf) { // 최고관리자는 자기꺼와 파트너아이디 없는 것 다 보여줌
	$sql_where = " and (pt_id = '' or pt_id = '{$mb_id}')";
} else { // 파트너는 자기꺼만 보여줌
	$sql_where = " and pt_id = '{$mb_id}'";
}

// 분류
$category = array();
$category_options  = '';
$sql = " select * from {$g5['g5_shop_category_table']} ";
if (!$is_auth)
    $sql .= " where pt_use = '1' and (pt_cate = '' or pt_cate = '{$mb_id}') ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$c = $row['ca_id'];
	$category[$c] = $row['ca_name'];

	if(!$is_admin && $row['as_menu_show']) { // 접근제한
		if(apms_auth($row['as_grade'], $row['as_equal'], $row['as_min'], $row['as_max'], 1)) continue;
	}

	$len = strlen($row['ca_id']) / 2 - 1;
    $nbsp = '';
    for ($i=0; $i<$len; $i++) {
        $nbsp .= '&nbsp;&nbsp;&nbsp;';
    }
	$selected = ($ca_id === $row['ca_id']) ? ' selected' : '';
	$category_options .= '<option value="'.$row['ca_id'].'"'.$selected.'>'.$nbsp.$row['ca_name'].'</option>'.PHP_EOL;
}

$order_by = ($sort != "") ? $sort.' '.$sortodr.' , pt_show, pt_num desc, it_id desc' : 'pt_show, pt_num desc, it_id desc'; // 상품 출력순서가 있다면
$where = "it_use = '1'";
$where .= $sql_where;
if(isset($type) && $type) {
	$where .= " and it_type{$type} = '1'";
	$qstr .= '&amp;type='.$type;
}
if(isset($ca_id) && $ca_id) {
	$where .= " and (ca_id like '{$ca_id}%' or ca_id2 like '{$ca_id}%' or ca_id3 like '{$ca_id}%')";
	$qstr .= '&amp;ca_id='.$ca_id;
}

// 정렬
$list_sort_href = $_SERVER['PHP_SELF'].'?id='.$id.$qstr.'&amp;sort=';

if($sort) $qstr .= '&amp;sort='.$sort;
if($sortodr) $qstr .= '&amp;sortodr='.$sortodr;

// 상품리스트
$list = array();

$skin_row = array();
$skin_row = apms_rows('myshop_'.MOBILE_.'mods, myshop_'.MOBILE_.'rows, myshop_'.MOBILE_.'img_width, myshop_'.MOBILE_.'img_height, myshop_'.MOBILE_.'skin, myshop_'.MOBILE_.'set');
$skin_name = $skin_row['myshop_'.MOBILE_.'skin'];
$list_mods = $skin_row['myshop_'.MOBILE_.'mods'];
$list_rows = $skin_row['myshop_'.MOBILE_.'rows'];
$thumb_w = $skin_row['myshop_'.MOBILE_.'img_width'];
$thumb_h = $skin_row['myshop_'.MOBILE_.'img_height'];

// 스킨설정
$wset = array();
if($skin_row['myshop_'.MOBILE_.'set']) {
	$wset = apms_unpack($skin_row['myshop_'.MOBILE_.'set']);
}

// 데모
if($is_demo) {
	@include ($demo_setup_file);
}

$skin_path = G5_SKIN_PATH.'/apms/myshop/'.$skin_name;
$skin_url = G5_SKIN_URL.'/apms/myshop/'.$skin_name;

// 스킨 체크
list($skin_path, $skin_url) = apms_skin_thema('shop/myshop', $skin_path, $skin_url); 

// 설정값 불러오기
$is_myshop_sub = false;
@include_once($skin_path.'/config.skin.php');

if(!$list_mods) $list_mods = 3;
if(!$list_rows) $list_rows = 5;
$rows = $list_mods * $list_rows;

// 페이지가 없으면 첫 페이지 (1 페이지)
if ($page < 1) $page = 1;

// 시작 레코드 구함
$from_record = ($page - 1) * $rows;

// 전체 페이지 계산
$row2 = sql_fetch(" select count(*) as cnt from `{$g5['g5_shop_item_table']}` where $where ");
$total_count = $row2['cnt'];
$total_page  = ceil($total_count / $rows);

// 리스트
$num = $total_count - ($page - 1) * $rows;
$result = sql_query(" select * from `{$g5['g5_shop_item_table']}` where $where order by $order_by limit $from_record, $rows ");
for ($i=0; $row=sql_fetch_array($result); $i++) { 
	$list[$i] = $row;
	$list[$i]['href'] = './item.php?it_id='.$row['it_id'];
	$list[$i]['num'] = $num;
	$num--;
}

// 페이징
$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['SCRIPT_NAME'].'?id='.$id.$qstr.'&amp;page=';

$list_all = './myshop.php?id='.$id;

$g5['title'] = get_text($author['mb_nick'])."님의 마이샵";

if($is_myshop_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$lm = 'myshop'; // 리스트 모드
$ls = $skin_name; // 리스트 스킨

// 셋업
$setup_href = '';
if (is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
    $setup_href = './skin.setup.php?skin=myshop&amp;name='.urlencode($ls).'&amp;ts='.urlencode(THEMA);
}

include_once($skin_path.'/myshop.skin.php');

if($is_myshop_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>