<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/iteminfo.lib.php');

if($it['it_id']) {
    $gubun = $it['it_info_gubun'];
} else {
    $it_id = trim($_POST['it_id']);
    $gubun = $_POST['gubun'] ? $_POST['gubun'] : 'wear';

    $sql = " select it_id, it_info_gubun, it_info_value from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $it = sql_fetch($sql);
}

if($it['it_info_value'])  $info_value = unserialize($it['it_info_value']);
$article = $item_info[$gubun]['article'];

if ($article) {
    $el_no = 0;
    $el_length = count($article);
    foreach($article as $key=>$value) {
        $itinfo[$el_no]['el_name']    = $key;
        $itinfo[$el_no]['el_title']   = $value[0];
        $itinfo[$el_no]['el_example'] = $value[1];
        $itinfo[$el_no]['el_value'] = '상품페이지 참고';

        if($gubun == $it['it_info_gubun'] && $info_value[$key]) $itinfo[$el_no]['el_value'] = $info_value[$key];
        $el_no++;
	}
}

if ($gubun) {
	$admin_theme = $eyoom_admin['theme'] ? $eyoom_admin['theme'] : 'admin_basic';
	$atpl = new Template($admin_theme);
	$atpl->template_dir	= EYOOM_ADMIN_THEME_PATH;
	
	$atpl->define(array(
		'iteminfo' => 'skin_bs/shop/' . $eyoom['shop_skin'] . '/iteminfo.skin.html',
	));
	
	$atpl->assign(array(
		'itinfo' => $itinfo,
	));
	
	// 템플릿 출력
	if ( !($it_info_gubun || $_GET['it_id']) ) {
		$atpl->print_('iteminfo');
	}
}