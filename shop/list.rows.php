<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!defined('IS_SHOP')) {
	define('IS_SHOP', true);
}

// Demo Config
if($is_demo) {
	@include_once(G5_LIB_PATH.'/apms.demo.lib.php');
}

$list = array();

$npg = apms_escape('npg', 0);

// 페이지
$page = $page + $npg;
$page = ($page > 1) ? $page : 2;

if($lm == 'ev') { // 이벤트

	$is_event = true;
	$type = apms_escape('type', 0);
	$etype = apms_escape('etype', 0);
	$ev_id = apms_escape('ev_id', 0);

	$ev = sql_fetch(" select * from {$g5['g5_shop_event_table']} where ev_id = '$ev_id' and ev_use = 1 ");
	if (!$ev['ev_id'])
		exit;

	// 스킨값 정리
	$list_id = $ev['ev_id'];
	$thumb_w = $ev['ev_'.MOBILE_.'img_width'];
	$thumb_h = $ev['ev_'.MOBILE_.'img_height'];
	$list_mods = $ev['ev_'.MOBILE_.'list_mod'];
	$list_rows = $ev['ev_'.MOBILE_.'list_row'];

	// 스킨설정
	$list_skin = $ev['ev_'.MOBILE_.'skin'];

	$wset = array();
	if($ev['ev_'.MOBILE_.'set']) {
		$wset = apms_unpack($ev['ev_'.MOBILE_.'set']);
	}

	// 데모
	if($is_demo) {
		if(!defined('THEMA_PATH')) {
			$pid = ($pid) ? $pid : 'event'; // Page ID
			$at = apms_page_thema($pid);
			include_once(G5_LIB_PATH.'/apms.thema.lib.php');
		}
		@include($demo_setup_file);
	}

	// List
	$list_skin_path = G5_SKIN_PATH.'/apms/list/'.$list_skin;
	$list_skin_url = G5_SKIN_URL.'/apms/list/'.$list_skin;

	// 추가설정
	$sql_apms_where = $sql_apms_orderby = '';
	@include_once($list_skin_path.'/list.head.skin.php');

	$order_by = ($sort != "") ? $sort.' '.$sortodr.' ,'.$sql_apms_orderby.' b.it_order, b.pt_num desc, b.it_id desc' : $sql_apms_orderby.' b.it_order, b.pt_num desc, b.it_id desc'; // 상품 출력순서가 있다면
	$where = "a.ev_id = '{$ev_id}' and b.it_use = '1'";
	if(isset($type) && $type) {
		$where .= " and b.it_type{$type} = '1'"; 
		$qstr .= '&amp;type='.$type;
	}
	if(isset($etype) && $etype) {
		$where .= " and a.ev_type = '{$etype}'";
		$qstr .= '&amp;etype='.$etype;
	}
	if(isset($ca_id) && $ca_id) {
		$where .= " and (b.ca_id like '{$ca_id}%' or b.ca_id2 like '{$ca_id}%' or b.ca_id3 like '{$ca_id}%')";
		$qstr .= '&amp;ca_id='.$ca_id;
	}
	if(isset($eimg) && $eimg) {
		$qstr .= '&amp;eimg='.$eimg;
	}
	$where .= $sql_apms_where;

	$qstr .= '&amp;ev_id='.urlencode($ev_id);
	if($sort) $qstr .= '&amp;sort='.$sort;
	if($sortodr) $qstr .= '&amp;sortodr='.$sortodr;

	if(!$list_mods) $list_mods = 3;
	if(!$list_rows) $list_rows = 5;

	// 총몇개 = 한줄에 몇개 * 몇줄
	$item_rows = $list_rows * $list_mods;

	// 페이지가 없으면 첫 페이지 (1 페이지)
	if ($page < 1) $page = 1;

	// 시작 레코드 구함
	$from_record = ($page - 1) * $item_rows;

	// 전체 페이지 계산
	$row2 = sql_fetch(" select count(*) as cnt from `{$g5['g5_shop_event_item_table']}` a left join `{$g5['g5_shop_item_table']}` b on (a.it_id = b.it_id) where $where ");
	$total_count = $row2['cnt'];
	$total_page  = ceil($total_count / $item_rows);

	if($page > $total_page) exit;

	$result = sql_query(" select * from `{$g5['g5_shop_event_item_table']}` a left join `{$g5['g5_shop_item_table']}` b on (a.it_id = b.it_id) where $where order by $order_by limit $from_record, $item_rows ");
	for ($i=0; $row=sql_fetch_array($result); $i++) { 
		$list[$i] = $row;
		$list[$i]['href'] = './item.php?it_id='.$row['it_id'].$qstr;
	}

} else if($lm == 'ir') { // 관련상품

	$it_id = apms_escape('it_id', 0);
	$it = apms_it($it_id);
	$ca_id = ($ca_id) ? $ca_id : $it['ca_id'];
	$ca = sql_fetch(" select as_item_set, as_mobile_item_set from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ");

	// 출력수
	$itemrows = apms_rows('irelation_'.MOBILE_.'mods, irelation_'.MOBILE_.'rows');

	$wset = array();
	if($ca['as_'.MOBILE_.'item_set']) {
		$wset = apms_unpack($ca['as_'.MOBILE_.'item_set']);
	}

	// 데모
	if($is_demo) {
		if(!defined('THEMA_PATH')) {
			$at = apms_ca_thema($ca_id, $ca, 1);
			include_once(G5_LIB_PATH.'/apms.thema.lib.php');
		}
		@include ($demo_setup_file);
	}

	$sql_common = " from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it_id}' and b.it_use='1' ";

	// 테이블의 전체 레코드수만 얻음
	$sql = " select COUNT(*) as cnt " . $sql_common;
	$row = sql_fetch($sql);
	$total_count = $row['cnt'];

	$thumb_w = $default['de_'.MOBILE_.'rel_img_width'];
	$thumb_h = $default['de_'.MOBILE_.'rel_img_height'];
	$rmods = (isset($rmods) && $rmods > 0) ? $rmods : $itemrows['irelation_'.MOBILE_.'mods'];
	$rmods = ($rmods > 0) ? $rmods : 3;
	$rrows = (isset($rrows) && $rrows > 0) ? $rrows : $itemrows['irelation_'.MOBILE_.'rows'];
	$rrows = ($rrows > 0) ? $rrows : 1;

	$rows = $rmods * $rrows;

	$total_page  = ceil($total_count / $rows); // 전체 페이지 계산
	$from_record = ($page - 1) * $rows; // 시작 레코드 구함

	if($from_record < 0)
		$from_record = 0;

	$num = $total_count - ($page - 1) * $rrows;
	$result = sql_query(" select b.* $sql_common order by b.pt_num desc, b.it_id desc limit $from_record, $rows ");
	for ($i=0; $row=sql_fetch_array($result); $i++) { 
		$list[$i] = $row;
		$list[$i]['href'] = './item.php?it_id='.$row['it_id'];
		$list[$i]['num'] = $num;
		$num--;
	}

} else if($lm == 'type') { // 상품유형

	$type = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $_REQUEST['type']);

	if(!$type) $type = 1;

	if(isset($ca_id) && $ca_id) {
		$ca = sql_fetch(" select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' and ca_use = '1' ");
		if (!$ca['ca_id'])
			exit;
	}

	// Rows
	$skin_row = array();
	$skin_row = apms_rows('type_'.MOBILE_.'mods, type_'.MOBILE_.'rows, type_'.MOBILE_.'img_width, type_'.MOBILE_.'img_height, type_'.MOBILE_.'skin, type_'.MOBILE_.'set');
	$skin_name = (isset($ls) && $ls) ? $ls : $skin_row['type_'.MOBILE_.'skin'];
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
		if(!defined('THEMA_PATH')) {
			$pid = ($pid) ? $pid : 'itype';
			$at = apms_page_thema($pid);
			include_once(G5_LIB_PATH.'/apms.thema.lib.php');
		}
		@include($demo_setup_file);
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

	if($sort) $qstr .= '&amp;sort='.$sort;
	if($sortodr) $qstr .= '&amp;sortodr='.$sortodr;

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

	if($page > $total_page) exit;

	$num = $total_count - ($page - 1) * $item_rows;
	$result = sql_query(" select * from `{$g5['g5_shop_item_table']}` where $where order by $order_by limit $from_record, $item_rows ");
	for ($i=0; $row=sql_fetch_array($result); $i++) { 
		$list[$i] = $row;
		$list[$i]['href'] = './item.php?it_id='.$row['it_id'].'&amp;type='.$type.$qstr;
		$list[$i]['num'] = $num;
		$num--;
	}

} else {

	$type = apms_escape('type', 0);

	// 분류
	$ca = sql_fetch(" select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' and ca_use = '1' ");
	if (!$ca['ca_id'])
		exit;

	// 인증
	if(!$is_admin) {
	    $msg = shop_member_cert_check($ca_id, 'list');
	    if($msg)
	        exit;

		if($ca['as_partner'] && !IS_PARTNER) 
			exit;

		if(apms_auth($ca['as_grade'], $ca['as_equal'], $ca['as_min'], $ca['as_max']))
			exit;
	}

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
		if(!defined('THEMA_PATH')) {
			$at = apms_ca_thema($ca_id, $ca);
			include_once(G5_LIB_PATH.'/apms.thema.lib.php');
		}
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

	if($sort) $qstr .= '&amp;sort='.$sort;
	if($sortodr) $qstr .= '&amp;sortodr='.$sortodr;

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

	if($page > $total_page) exit;

	$num = $total_count - ($page - 1) * $item_rows;
	$result = sql_query(" select * from `{$g5['g5_shop_item_table']}` where $where order by $order_by limit $from_record, $item_rows ");
	for ($i=0; $row=sql_fetch_array($result); $i++) { 
		$list[$i] = $row;
		$list[$i]['href'] = './item.php?it_id='.$row['it_id'].'&amp;ca_id='.$ca_id.$qstr;
		$list[$i]['num'] = $num;
		$num--;
	}
}

?>
