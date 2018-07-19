<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/list.php');
    return;
}

$sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' and ca_use = '1'  ";
$ca = sql_fetch($sql);
if (!$ca['ca_id'])
    alert('등록된 분류가 없습니다.');

// 테마체크
$at = apms_ca_thema($ca_id, $ca);
if(!defined('THEMA_PATH')) {
	include_once(G5_LIB_PATH.'/apms.thema.lib.php');
}

// 본인인증, 성인인증체크
if(!$is_admin) {
    $msg = shop_member_cert_check($ca_id, 'list');
    if($msg)
        alert($msg, G5_SHOP_URL);
}

// 리스트 분류
$cate = array();
$cate = apms_item_category_array($ca_id);
$is_cate = (count($cate) > 0) ? true : false;

$thumb_w = $ca['ca_'.MOBILE_.'img_width'];
$thumb_h = $ca['ca_'.MOBILE_.'img_height'];
$list_mods = $ca['ca_'.MOBILE_.'list_mod'];
$list_rows = $ca['ca_'.MOBILE_.'list_row'];

// 스킨설정
$list_skin = $at['list'];

$wset = array();
if($ca['as_'.MOBILE_.'list_set']) {
	$wset = apms_unpack($ca['as_'.MOBILE_.'list_set']);
}

// 데모
if($is_demo) {
	@include($demo_setup_file);
}

// List
$list_skin_path = G5_SKIN_PATH.'/apms/list/'.$list_skin;
$list_skin_url = G5_SKIN_URL.'/apms/list/'.$list_skin;

// 추가설정
$sql_apms_where = $sql_apms_orderby = '';
@include_once($list_skin_path.'/list.head.skin.php');

$order_by = ($sort != "") ? $sort.' '.$sortodr.' ,'.$sql_apms_orderby.' it_order, pt_num desc, it_id desc' : $sql_apms_orderby.' it_order, pt_num desc, it_id desc'; // 상품 출력순서가 있다면
$where = "it_use = '1'";
if(isset($type) && $type) {
	$where .= " and it_type{$type} = '1'";
	$qstr .= '&amp;type='.$type;
}
$where .= " and (ca_id like '{$ca_id}%' or ca_id2 like '{$ca_id}%' or ca_id3 like '{$ca_id}%')";
$where .= $sql_apms_where;

// 정렬
$list_sort_href = './list.php?ca_id='.$ca_id.$qstr.'&amp;sort=';

if($sort) $qstr .= '&amp;sort='.$sort;
if($sortodr) $qstr .= '&amp;sortodr='.$sortodr;

// 상위분류
$ca_id_len = strlen($ca_id);
$up_href = '';
if ($ca_id_len > 2) {
	$len1 = $ca_id_len - 2;
	$up_href = './list.php?ca_id='.substr($ca_id,0,$len1).$qstr;
}

$g5['title'] = $ca['ca_name'].' 리스트';

if (!G5_IS_MOBILE && $ca['ca_include_head']) {
    @include_once($ca['ca_include_head']);
} else {
    include_once('./_head.php');
}

// 상단 HTML
echo '<div id="sct_hhtml">'.conv_content($ca['ca_'.MOBILE_.'head_html'], 1).'</div>'.PHP_EOL;

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
	$list[$i]['href'] = './item.php?it_id='.$row['it_id'].'&amp;ca_id='.$ca_id.$qstr.'&amp;page='.$page;
	$list[$i]['num'] = $num;
	$num--;
}

// 네비게이션
$nav = array();
$len = strlen($ca_id) / 2;
$n=0;
for ($i=1; $i<=$len; $i++) {
	$code = substr($ca_id,0,$i*2);
	$nav[$n]['ca_id'] = $code;

	$row = sql_fetch(" select ca_name from {$g5['g5_shop_category_table']} where ca_id = '$code' ");
	$nav[$n]['name'] = $row['ca_name'];

	if($ca_id === $code) {
		$nav[$n]['on'] = true;
		$nav[$n]['cnt'] = $total_count;
	} else {
		$nav[$n]['on'] = false;
		$nav[$n]['cnt'] = 0;
	}

	$n++;
}

$is_nav = ($n > 0) ? true : false;
$nav_title = $ca['ca_name'];

// 페이징
$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = $_SERVER['SCRIPT_NAME'].'?ca_id='.$ca_id.$qstr.'&amp;page=';

// Button
$admin_href = $config_href = $write_href = '';
if(USE_PARTNER) {
	if($is_admin) {
		if(IS_PARTNER) {
			$write_href = './myshop.php?mode=item&amp;fn='.$ca['pt_form'];
			$admin_href = './myshop.php?mode=list&amp;sca='.$ca_id;
		} else {
			$write_href = G5_ADMIN_URL.'/shop_admin/itemform.php?fn='.$ca['pt_form'];
			$admin_href = G5_ADMIN_URL.'/shop_admin/itemlist.php?ca_id='.$ca_id;
		}
		$config_href = G5_ADMIN_URL.'/shop_admin/categoryform.php?w=u&amp;ca_id='.$ca_id;
	} else if (IS_PARTNER && $ca['pt_use']) {
		$write_href = './myshop.php?mode=item&amp;fn='.$ca['pt_form'];
		$admin_href = './myshop.php?mode=list&amp;sca='.$ca_id;
	}
} else {
	if($is_admin == 'super') {
		$write_href = G5_ADMIN_URL.'/shop_admin/itemform.php?fn='.$ca['pt_form'];
		$admin_href = G5_ADMIN_URL.'/shop_admin/itemlist.php?ca_id='.$ca_id;
		$config_href = G5_ADMIN_URL.'/shop_admin/categoryform.php?w=u&amp;ca_id='.$ca_id;
	}
}

$rss_href = ($ca_id) ? G5_URL.'/rss/?cid='.urlencode($ca_id) : '';

$lm = ''; // 리스트 모드
$ls = $list_skin; // 리스트 스킨

// 셋업
$setup_href = '';
if (!$ev_id && is_file($list_skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
    $setup_href = './skin.setup.php?skin=list&amp;name='.urlencode($ls).'&amp;ca_id='.urlencode($ca_id);
}

// 스킨
$list_skin_file = $list_skin_path.'/list.skin.php';

if(file_exists($list_skin_file)) {
	include_once($list_skin_file);
} else {
	echo '<p>'.str_replace(G5_PATH.'/', '', $list_skin_file).' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</p>';
}

// 하단 HTML
echo '<div id="sct_thtml">'.conv_content($ca['ca_'.MOBILE_.'tail_html'], 1).'</div>'.PHP_EOL;

if (!G5_IS_MOBILE && $ca['ca_include_tail'])
    @include_once($ca['ca_include_tail']);
else
    include_once('./_tail.php');

echo "\n<!-- {$ca['ca_'.MOBILE_.'skin']} -->\n";

?>
