<?php
$sub_menu = "800610";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'w');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=ebcontents_itemform_update&amp;smode=1';

$ec_code = clean_xss_tags(trim($_GET['ec_code']));

/**
 * EB컨텐츠 마스터 정보
 */
$ec = sql_fetch("select * from {$g5[eyoom_ebcontents]} where ec_code = '{$ec_code}' and ec_theme='{$this_theme}'");

/**
 * EB컨텐츠 아이템 정보 가져오기
 */
if ($iw == 'u') {
	$ci = sql_fetch("select * from {$g5['eyoom_ebcontents_item']} where ci_no = '{$ci_no}' and ci_theme='{$this_theme}'");
	$ci['ci_start'] = $ci['ci_start'] ? date('Y-m-d', strtotime($ci['ci_start'])) : '';
	$ci['ci_end'] 	= $ci['ci_end'] ? date('Y-m-d', strtotime($ci['ci_end'])) : '';
	
	if ($ci['ci_no']) {
		foreach($ci as $key => $value) {
			$ec_item[$key] = stripslashes($value);
		}
		$ci_link = unserialize($ec_item['ci_link']);
		$ci_target = unserialize($ec_item['ci_target']);
		$ci_img = unserialize($ec_item['ci_img']);
		for($i=0; $i<$ec['ec_image_cnt']; $i++) {
			unset($ci_file);
			$ci_file = G5_DATA_PATH.'/ebcontents/'.$ci['ci_theme'].'/'.$ci_img[$i];
			if (file_exists($ci_file) && !is_dir($ci_file) && $ci_img[$i]) {
				$ci_url[$i] = G5_DATA_URL.'/ebcontents/'.$ci['ci_theme'].'/'.$ci_img[$i];
			}
		}
	} else {
		alert('존재하지 않는 아이템입니다.');
	}
}

if ($iw == '') {
	$info = sql_fetch("select max(ci_sort) as max from {$g5['eyoom_ebcontents_item']} where ec_code = '{$ec_code}' ");
	$ec_max_sort = $info['max'] + 1;
}

/**
 * 웹에디터 HTML 
 */
$editor_content_html = editor_html("ci_content", stripslashes($ci['ci_content']));

/**
 * 버튼셋
 */
$frm_submit  = ' <div class="text-center margin-top-10 margin-bottom-10"> ';
$frm_submit .= ' <input type="submit" value="확인" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">' ;
$frm_submit .= '</div>';

$atpl->assign(array(
	'ec' 			=> $ec,
	'ec_item' 		=> $ec_item,
	'ci_link' 		=> $ci_link,
	'ci_target' 	=> $ci_target,
	'ci_img' 		=> $ci_img,
	'ci_url' 		=> $ci_url,
	'frm_submit' 	=> $frm_submit,
));