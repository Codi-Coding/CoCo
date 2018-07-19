<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

//Level Up
if($member['mb_id']) { 
	//Auto Grade
	if($xp['xp_from'] > 1 && $xp['xp_to'] >= $xp['xp_from']) {
		if($member['mb_level'] >= $xp['xp_from'] && $member['mb_level'] <= $xp['xp_to']) {
			$level = $member['mb_level'];
			$n = 1;
			for($i = $xp['xp_from']; $i <= $xp['xp_to']; $i++) {
				$g = 'xp_auto'.$n;
				if($member['as_level'] < $xp[$g]) {
					$level = $i;
					break;
				}
				$n++;
			}

			if($level == $member['mb_level']) {
				;
			} else {
				$member['as_msg'] = ($member['mb_level'] > $level) ? 4 : 3; //3 : 등업, 4 : 다운
				$member['mb_level'] = $level;
			}
		}
	}

	switch($member['as_msg']) { //Message
		case '1'		: $levelup_msg = "축하합니다! ".$member['as_level']."레벨로 레벨업하셨습니다."; break;
		case '2'		: $levelup_msg = $member['as_level']."레벨로 레벨다운되셨습니다."; break;
		case '3'		: $mg = 'xp_grade'.$member['mb_level']; $levelup_msg = $xp[$mg]."(".$member['mb_level'].")등급으로 등업하셨습니다."; break;
		case '4'		: $mg = 'xp_grade'.$member['mb_level']; $levelup_msg = $xp[$mg]."(".$member['mb_level'].")등급으로 다운되셨습니다."; break;
	}

	if($member['as_msg']) {
		// 회원정보 업데이트
		sql_query(" update {$g5['member_table']} set mb_level = '{$member['mb_level']}', as_msg = '0' where mb_id = '{$member['mb_id']}' ", false);

		// 회원자료 업데이트
		change_xp($member['mb_id'], $member['as_level']);

		echo "<script> alert('".$levelup_msg."');</script>";
	}
}

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}

if (isset($config['cf_analytics']) && $config['cf_analytics']) {
    echo $config['cf_analytics'];
}

if(IS_SHOP) echo '<script src="'.G5_JS_URL.'/sns.js"></script>'.PHP_EOL;

// Page Iframe Modal
if(APMS_PIM || $is_layout_sub) {
	@include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
	return;
}

if(file_exists(THEMA_PATH.'/shop.tail.php')) {
	include_once(THEMA_PATH.'/shop.tail.php');
} else {
	include_once(THEMA_PATH.'/tail.php');
}

include_once(G5_PATH."/tail.sub.php"); 

?>