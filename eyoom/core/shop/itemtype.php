<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 히트상품
$hit_goods = new item_list();
$hit_goods->tpl_name = $tpl_name;
$hit_goods->theme = $shop_theme;
$hit_goods->eyoom = $eyoom;
$hit_goods->set_list_skin(EYOOM_SHOP_PATH.'/'.$default['de_type1_list_skin']);
$hit_goods->set_type(1);

// 추천상품
$recommend_goods = new item_list();
$recommend_goods->tpl_name = $tpl_name;
$recommend_goods->theme = $shop_theme;
$recommend_goods->eyoom = $eyoom;
$recommend_goods->set_list_skin(EYOOM_SHOP_PATH.'/'.$default['de_type2_list_skin']);
$recommend_goods->set_type(2);

// 최신상품
$new_goods = new item_list();
$new_goods->tpl_name = $tpl_name;
$new_goods->theme = $shop_theme;
$new_goods->eyoom = $eyoom;
$new_goods->set_list_skin(EYOOM_SHOP_PATH.'/'.$default['de_type3_list_skin']);
$new_goods->set_type(3);

// 인기상품
$popular_goods = new item_list();
$popular_goods->tpl_name = $tpl_name;
$popular_goods->theme = $shop_theme;
$popular_goods->eyoom = $eyoom;
$popular_goods->set_list_skin(EYOOM_SHOP_PATH.'/'.$default['de_type4_list_skin']);
$popular_goods->set_type(4);

// 할인상품
$sale_goods = new item_list();
$sale_goods->tpl_name = $tpl_name;
$sale_goods->theme = $shop_theme;
$sale_goods->eyoom = $eyoom;
$sale_goods->set_list_skin(EYOOM_SHOP_PATH.'/'.$default['de_type5_list_skin']);
$sale_goods->set_type(5);

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/index.php');

$tpl->assign(array(
	'shop' => $shop,
	'hit_goods' => $hit_goods,
	'recommend_goods' => $recommend_goods,
	'new_goods' => $new_goods,
	'popular_goods' => $popular_goods,
	'sale_goods' => $sale_goods,
));