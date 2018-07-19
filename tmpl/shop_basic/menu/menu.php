<?php // 굿빌더 ?>
<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(0 and $config2w['cf_use_common_menu'] and $g5['tmpl'] != 'basic') {
    $config2w_sav = $config2w;
    $config2w = sql_fetch(" select * from $g5[config2w_table] where cf_id='basic' ", false);
}

$menu_list = array();
$main_index = 0; /// default
$side_index = -1; /// default
$mi = 0;
global $g5;

// top submenu들의 위치 초기화
$sub_pos = array(0);
$sub_len = 0;

for($i = 0; $i < $config2w['cf_max_menu']; $i++) {

	if($config2w['cf_menu_name_'.$i]) {

		if(defined('BBS_NAME') && BBS_NAME) $config2w['cf_menu_link_'.$i] = strtr($config2w['cf_menu_link_'.$i], array('/bbs/board.php' => '/'.BBS_NAME.'/board.php'));
		if(defined('SHOP_NAME') && SHOP_NAME) $config2w['cf_menu_link_'.$i] = strtr($config2w['cf_menu_link_'.$i], array('/shop/' => '/'.SHOP_NAME.'/'));
		$tmp_menu_path = explode("?", G5_PATH.$config2w['cf_menu_link_'.$i]);

		$config2w['cf_menu_link_'.$i] = G5_URL.$config2w['cf_menu_link_'.$i];
		$menu_list[$mi] = array($config2w['cf_menu_name_'.$i], $config2w['cf_menu_link_'.$i]);

		// side index 구성
		$tmp_uri = explode("?", $_SERVER['REQUEST_URI']);
		$tmp_menu = explode("?", $menu_list[$mi][1]);
		/// if(getmyinode() == fileinode(realpath($tmp_menu[0])) and $tmp_uri[1] == $tmp_menu[1]) {
		if(getmyinode() == fileinode(realpath($tmp_menu_path[0])) and $tmp_uri[1] == $tmp_menu[1]) {
			$main_index = $mi;
		} else {
			$req_bo_table = explode("bo_table=", $_SERVER['REQUEST_URI'], 2);
			$req_bo_table = explode("&", $req_bo_table[1], 2);

			$menu_bo_table = explode("bo_table=", $menu_list[$mi][1], 2);
			$menu_bo_table = explode("&", $menu_bo_table[1], 2);

			if($req_bo_table[0] and $menu_bo_table[0]
			   and $req_bo_table[0] == $menu_bo_table[0]) {
				$main_index = $mi;
			}
		}

		$mj = 0;

		for($j = 0; $j < $config2w['cf_max_submenu']; $j++) {

			if($config2w['cf_submenu_name_'.$i.'_'.$j]) {

				if(defined('BBS_NAME') && BBS_NAME) $config2w['cf_submenu_link_'.$i.'_'.$j] = strtr($config2w['cf_submenu_link_'.$i.'_'.$j], array('/bbs/board.php' => '/'.BBS_NAME.'/board.php'));
				if(defined('SHOP_NAME') && SHOP_NAME) $config2w['cf_submenu_link_'.$i.'_'.$j] = strtr($config2w['cf_submenu_link_'.$i.'_'.$j], array('/shop/' => '/'.SHOP_NAME.'/'));
				$tmp_menu_path = explode("?", G5_PATH.$config2w['cf_submenu_link_'.$i.'_'.$j]);

				$config2w['cf_submenu_link_'.$i.'_'.$j] = G5_URL.$config2w['cf_submenu_link_'.$i.'_'.$j];
				$menu[$mi][$mj] = array($config2w['cf_submenu_name_'.$i.'_'.$j], $config2w['cf_submenu_link_'.$i.'_'.$j]);

				// side index 구성
				$tmp_uri = explode("?", $_SERVER['REQUEST_URI']);
				$tmp_menu = explode("?", $menu[$mi][$mj][1]);

				/// if($_SERVER['REQUEST_URI'] == $menu[$mi][$mj][1]) {
				/// if(getmyinode() == fileinode(realpath($tmp_menu[0])) and $tmp_uri[1] == $tmp_menu[1]) {
				if(getmyinode() == fileinode(realpath($tmp_menu_path[0])) and $tmp_uri[1] == $tmp_menu[1]) {
					$main_index = $mi;
					$side_index = $mj;
				} else {
					$req_bo_table = explode("bo_table=", $_SERVER['REQUEST_URI'], 2);
					$req_bo_table = explode("&", $req_bo_table[1], 2);
					$req_wr_id = explode("wr_id=", $_SERVER['REQUEST_URI'], 2);
					$req_wr_id = explode("&", $req_wr_id[1], 2);

					$menu_bo_table = explode("bo_table=", $menu[$mi][$mj][1], 2);
					$menu_bo_table = explode("&", $menu_bo_table[1], 2);
					$menu_wr_id = explode("wr_id=", $menu[$mi][$mj][1], 2);
					$menu_wr_id = explode("&", $menu_wr_id[1], 2);

					if($req_bo_table[0] and $menu_bo_table[0] and $req_wr_id[0] and $menu_wr_id[0]
					   and $req_bo_table[0] == $menu_bo_table[0]
					   and $req_wr_id[0] == $menu_wr_id[0]) {
						$main_index = $mi;
						$side_index = $mj;
					} else if($req_bo_table[0] and $menu_bo_table[0]
					   and $req_bo_table[0] == $menu_bo_table[0]) {
						$main_index = $mi;
						if(!$menu_wr_id[0]) $side_index = $mj;
					}
				}

				$mj++;
			}
		}

		// top submenu들의 위치
		$sub_len += $config2w['cf_menu_leng_'.$mi];

		$mi++;
		$sub_pos[$mi] = $sub_len;

	}
} /// for

if(0 and $config2w['cf_use_common_menu'] and $g5['tmpl'] != 'basic') {
    $config2w = $config2w_sav;
}
?>
