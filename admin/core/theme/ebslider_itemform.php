<?php
$sub_menu = "800600";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=ebslider_itemform_update&amp;smode=1';

$es_code = clean_xss_tags(trim($_GET['es_code']));

/**
 * EB슬라이더 아이템 정보 가져오기
 */
if ($iw == 'u') {
	$ei = sql_fetch("select * from {$g5['eyoom_ebslider_item']} where ei_no = '{$ei_no}' and ei_theme='{$this_theme}'");
	$ei['ei_start'] = $ei['ei_start'] ? date('Y-m-d', strtotime($ei['ei_start'])) : '';
	$ei['ei_end'] 	= $ei['ei_end'] ? date('Y-m-d', strtotime($ei['ei_end'])) : '';
	
	if ($ei) {
		foreach($ei as $key => $value) {
			$es_item[$key] = get_text(stripslashes($value));
		}
		
		$ei_file = G5_DATA_PATH.'/ebslider/'.$ei['ei_theme'].'/'.$es_item['ei_img'];
		if (file_exists($ei_file) && !is_dir($ei_file) && $es_item['ei_img']) {
			$es_item['ei_url'] = G5_DATA_URL.'/ebslider/'.$ei['ei_theme'].'/'.$es_item['ei_img'];
		}
	} else {
		alert('존재하지 않는 아이템입니다.');
	}
}

if ($iw == '') {
	$info = sql_fetch("select max(ei_sort) as max from {$g5['eyoom_ebslider_item']} where es_code = '{$es_code}' ");
	$es_max_sort = $info['max'] + 1;
}

/**
 * 버튼셋
 */
$frm_submit  = ' <div class="text-center margin-top-10 margin-bottom-10"> ';
$frm_submit .= ' <input type="submit" value="확인" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">' ;
$frm_submit .= '</div>';

$atpl->assign(array(
	'es_item' 		=> $es_item,
	'frm_submit' 	=> $frm_submit,
));