<?php
if (!defined('_SHOP_')) exit;

// pg_anchor 스코핑
$shop->pg_anchor('pg_anchor_inf');
$shop->pg_anchor('pg_anchor_use');
$shop->pg_anchor('pg_anchor_qa');
$shop->pg_anchor('pg_anchor_dvr');
$shop->pg_anchor('pg_anchor_ex');
$shop->pg_anchor('pg_anchor_rel');

// 상품정보 제공고시
if ($it['it_info_value']) { // 상품 정보 고시
	$info_data = unserialize(stripslashes($it['it_info_value']));
	if(is_array($info_data)) {
		$gubun = $it['it_info_gubun'];
		$info_array = $item_info[$gubun]['article'];
		
		foreach($info_data as $key=>$val) {
			$open_goods_info[$key]['ii_title'] = $info_array[$key][0];
			$open_goods_info[$key]['ii_value'] = $val;
		}
	}
}

// 사용후기
@include_once(EYOOM_SHOP_PATH.'/itemuse.php');

// 상품문의
@include_once(EYOOM_SHOP_PATH.'/itemqa.php');

// 관련상품
$rel_skin_file = EYOOM_SHOP_PATH.'/'.$default['de_rel_list_skin'];
$sql = " select b.* from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it['it_id']}' and b.it_use='1' ";
$list = new item_list($rel_skin_file, $default['de_rel_list_mod'], 0, $default['de_rel_img_width'], $default['de_rel_img_height']);
$list->tpl_name = $tpl_name;
$list->theme = $shop_theme;
$list->eyoom = $eyoom;
$list->set_query($sql);