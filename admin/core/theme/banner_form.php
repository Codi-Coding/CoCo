<?php
$sub_menu = "800500";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=banner_form_update&amp;smode=1';

/**
 * 배너/광고 설정파일
 */
$banner_config = G5_DATA_PATH.'/banner/banner.'.$this_theme.'.config.php';
if(file_exists($banner_config)) {
	@include_once($banner_config);
	if(is_array($bn_loccd)) ksort($bn_loccd);
}

/**
 * 배너/광고 정보 가져오기
 */
if ($w == 'u') {
	$bninfo = sql_fetch("select * from {$g5[eyoom_banner]} where bn_no = '{$bn_no}' and bn_theme='{$this_theme}'");
	$bninfo['bn_start'] = $bninfo['bn_start'] ? date('Y-m-d', strtotime($bninfo['bn_start'])) : '';
	$bninfo['bn_end'] 	= $bninfo['bn_end'] ? date('Y-m-d', strtotime($bninfo['bn_end'])) : '';
	
	if ($bninfo) {
		foreach($bninfo as $key => $value) {
			$banner[$key] = get_text(stripslashes($value));
		}
		
		$bn_file = G5_DATA_PATH.'/banner/'.$bninfo['bn_theme'].'/'.$banner['bn_img'];
		if (file_exists($bn_file) && !is_dir($bn_file) && $banner['bn_img']) {
			$banner['bn_url'] = G5_DATA_URL.'/banner/'.$bninfo['bn_theme'].'/'.$banner['bn_img'];
		}
	} else {
		alert('존재하지 않는 배너광고입니다.');
	}
}

/**
 * 버튼셋
 */
$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="확인" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">' ;
$frm_submit .= ' <a href="' . EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=banner_list&amp;page='.$page.'&amp;thema='.$this_theme.'" class="btn-e btn-e-lg btn-e-dark">목록</a> ';
$frm_submit .= '</div>';

$atpl->assign(array(
	'banner' 		=> $banner,
	'bn_loccd' 		=> $bn_loccd,
	'frm_submit' 	=> $frm_submit,
));