<?php
$sub_menu = "800620";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=eblatest_itemform_update&amp;smode=1';

$el_code = clean_xss_tags(trim($_GET['el_code']));

/**
 * EB슬라이더 아이템 정보 가져오기
 */
if ($iw == 'u') {
	$li = sql_fetch("select * from {$g5['eyoom_eblatest_item']} where li_no = '{$li_no}' and li_theme='{$this_theme}'");
	if ($li) {
		foreach($li as $key => $value) {
			$el_item[$key] = get_text(stripslashes($value));
		}
		
		$li_file = G5_DATA_PATH.'/eblatest/'.$li['li_theme'].'/'.$el_item['li_img'];
		if (file_exists($li_file) && !is_dir($li_file) && $el_item['li_img']) {
			$el_item['li_url'] = G5_DATA_URL.'/eblatest/'.$li['li_theme'].'/'.$el_item['li_img'];
		}
	} else {
		alert('존재하지 않는 아이템입니다.');
	}
}

/**
 * 전체 게시판 정보
 */
$bo_info = $eb->get_all_board_info();

/**
 * 전체 그룹 정보
 */
$gr_info = $eb->get_all_group_info();

if ($iw == '') {
	$info = sql_fetch("select max(li_sort) as max from {$g5['eyoom_eblatest_item']} where el_code = '{$el_code}' ");
	$li_max_sort = $info['max'] + 1;
}

/**
 * 버튼셋
 */
$frm_submit  = ' <div class="text-center margin-top-10 margin-bottom-10"> ';
$frm_submit .= ' <input type="submit" value="확인" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">' ;
$frm_submit .= '</div>';

$atpl->assign(array(
	'el_item' 		=> $el_item,
	'bo_info' 		=> $bo_info,
	'gr_info' 		=> $gr_info,
	'frm_submit' 	=> $frm_submit,
));