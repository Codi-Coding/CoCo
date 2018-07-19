<?php
function eyoom_display_type($type, $list_skin='', $list_mod='', $list_row='', $img_width='', $img_height='', $ca_id='') {
	global $member, $g5, $config, $default;

	if (!$default["de_type{$type}_list_use"]) return "";

	$list_skin  = $list_skin  ? $list_skin  : $default["de_type{$type}_list_skin"];
	$list_mod   = $list_mod   ? $list_mod   : $default["de_type{$type}_list_mod"];
	$list_row   = $list_row   ? $list_row   : $default["de_type{$type}_list_row"];
	$img_width  = $img_width  ? $img_width  : $default["de_type{$type}_img_width"];
	$img_height = $img_height ? $img_height : $default["de_type{$type}_img_height"];

	// 상품수
	$items = $list_mod * $list_row;

	// 1.02.00
	// it_order 추가
	$sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' and it_type{$type} = '1' ";
	if ($ca_id) $sql .= " and ca_id like '$ca_id%' ";
	$sql .= " order by it_order, it_id desc limit $items ";
	$result = sql_query($sql);
	/*
	if (!sql_num_rows($result)) {
		return false;
	}
	*/

	//$file = G5_SHOP_PATH.'/'.$skin_file;
	$file = G5_SHOP_SKIN_PATH.'/'.$list_skin;
	if (!file_exists($file)) {
		return G5_SHOP_SKIN_URL.'/'.$list_skin.' 파일을 찾을 수 없습니다.';
	} else {
		$td_width = (int)(100 / $list_mod);
		ob_start();
		include $file;
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}


// 모바일 유형별 상품 출력
function eyoom_mobile_display_type($type, $skin_file, $list_row, $img_width, $img_height, $ca_id="") {
	global $member, $g5, $config;

	// 상품수
	$items = $list_row;

	// 1.02.00
	// it_order 추가
	$sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' and it_type{$type} = '1' ";
	if ($ca_id) $sql .= " and ca_id like '$ca_id%' ";
	$sql .= " order by it_order, it_id desc limit $items ";
	$result = sql_query($sql);
	/*
	if (!sql_num_rows($result)) {
		return false;
	}
	*/

	$file = G5_MSHOP_PATH.'/'.$skin_file;
	if (!file_exists($file)) {
		echo $file.' 파일을 찾을 수 없습니다.';
	} else {
		//$td_width = (int)(100 / $list_mod);
		include $file;
	}
}


// 분류별 출력
// 스킨파일번호, 1라인이미지수, 총라인수, 이미지폭, 이미지높이 , 분류번호
function eyoom_display_category($no, $list_mod, $list_row, $img_width, $img_height, $ca_id="") {
	global $member, $g5;

	// 상품수
	$items = $list_mod * $list_row;

	$sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1'";
	if ($ca_id)
		$sql .= " and ca_id LIKE '{$ca_id}%' ";
	$sql .= " order by it_order, it_id desc limit $items ";
	$result = sql_query($sql);
	if (!sql_num_rows($result)) {
		return false;
	}

	$file = EYOOM_SHOP_PATH.'/maintype'.$no.'.inc.php';
	if (!file_exists($file)) {
		echo $file.' 파일을 찾을 수 없습니다.';
	} else {
		$td_width = (int)(100 / $list_mod);
		include $file;
	}
}

// 배너출력
function eyoom_display_banner($position, $skin='') {
	global $g5, $theme, $tpl, $tpl_name, $eyoom;

	if (!$position) $position = '왼쪽';
	if (!$skin) $skin = 'boxbanner.skin.php';

	$skin_path = EYOOM_SHOP_PATH.'/'.$skin;

	if(file_exists($skin_path)) {
		// 배너 출력
		$sql = " select * from {$g5['g5_shop_banner_table']} where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time and bn_position = '$position' order by bn_order, bn_id desc ";
		$result = sql_query($sql);

		include $skin_path;

	} else {
		echo '<p>'.str_replace(G5_PATH.'/', '', $skin_path).'파일이 존재하지 않습니다.</p>';
	}
}

// 1.00.02
// 파일번호, 이벤트번호, 1라인이미지수, 총라인수, 이미지폭, 이미지높이
// 1.02.01 $ca_id 추가
function eyoom_display_event($no, $event, $list_mod, $list_row, $img_width, $img_height, $ca_id="") {
	global $member, $g5;

	// 상품수
	$items = $list_mod * $list_row;

	// 1.02.00
	// b.it_order 추가
	$sql = " select b.* from {$g5['g5_shop_event_item_table']} a, {$g5['g5_shop_item_table']} b where a.it_id = b.it_id and b.it_use = '1' and a.ev_id = '$event' ";
	if ($ca_id) $sql .= " and ca_id = '$ca_id' ";
	$sql .= " order by b.it_order, a.it_id desc limit $items ";
	$result = sql_query($sql);
	if (!sql_num_rows($result)) {
		return false;
	}

	$file = G5_SHOP_PATH.'/maintype'.$no.'.inc.php';
	if (!file_exists($file)) {
		echo $file.' 파일을 찾을 수 없습니다.';
	} else {
		$td_width = (int)(100 / $list_mod);
		include $file;
	}
}

// 상품이미지에 유형 아이콘 출력
function eyoom_item_icon($it) {
	global $g5;

	$icon = '<span class="sit_icon">';
	// 품절
	if (is_soldout($it['it_id']))
		$icon .= '<img src="'.G5_SHOP_URL.'/img/icon_soldout.gif" alt="품절">';

	if ($it['it_type1'])
		$icon .= '<img src="'.G5_SHOP_URL.'/img/icon_hit.gif" alt="히트상품">';

	if ($it['it_type2'])
		$icon .= '<img src="'.G5_SHOP_URL.'/img/icon_rec.gif" alt="추천상품">';

	if ($it['it_type3'])
		$icon .= '<img src="'.G5_SHOP_URL.'/img/icon_new.gif" alt="최신상품">';

	if ($it['it_type4'])
		$icon .= '<img src="'.G5_SHOP_URL.'/img/icon_best.gif" alt="인기상품">';

	if ($it['it_type5'])
		$icon .= '<img src="'.G5_SHOP_URL.'/img/icon_discount.gif" alt="할인상품">';

	// 쿠폰상품
	$sql = " select count(*) as cnt
				from {$g5['g5_shop_coupon_table']}
				where cp_start <= '".G5_TIME_YMD."'
				  and cp_end >= '".G5_TIME_YMD."'
				  and (
						( cp_method = '0' and cp_target = '{$it['it_id']}' )
						OR
						( cp_method = '1' and ( cp_target IN ( '{$it['ca_id']}', '{$it['ca_id2']}', '{$it['ca_id3']}' ) ) )
					  ) ";
	$row = sql_fetch($sql);
	if($row['cnt'])
		$icon .= '<img src="'.G5_SHOP_URL.'/img/icon_cp.gif" alt="쿠폰상품">';

	$icon .= '</span>';

	return $icon;
}