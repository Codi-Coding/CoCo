<?php
/* Return Eblatest Data Function */
function eb_latest($code) {
	global $g5, $theme, $shop_theme, $member, $tpl, $tpl_name, $is_admin;
	
	if(!$member['mb_level']) $member['mb_level'] = 1;

	if (defined('_SHOP_')) $theme = $shop_theme;
	$elinfo = sql_fetch("select * from {$g5['eyoom_eblatest']} where el_code = '{$code}' and el_theme = '{$theme}' ");

	// 활성화 되어 있다면 아이템 정보를 가져오기
	if ($elinfo['el_state'] == '1') {
		
	}
}