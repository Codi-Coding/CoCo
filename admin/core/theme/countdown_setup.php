<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit;

if($is_admin != 'super') alert('최고관리자만 설정을 변경할 수 있습니다.');

unset($eyoom);
$eyoom_config = G5_DATA_PATH . '/eyoom.config.php';
include($eyoom_config);

$action_url = EYOOM_ADMIN_URL."/?dir=theme&amp;pid=countdown_setup&wmode=1";
$countdown_date = $eb->mktime_countdown_date($eyoom['countdown_date']);

$w = clean_xss_tags($_POST['w']);
$countdown_skin = get_skin_dir('countdown', EYOOM_THEME_PATH);

if($w == 'u') {
	
	$countdown_use = clean_xss_tags($_POST['countdown_use']);
	$cd_skin = clean_xss_tags($_POST['cd_skin']);
	$cd_date = clean_xss_tags(str_replace('-', '', $_POST['cd_date']));
	$cd_hour = clean_xss_tags($_POST['cd_hour']);
	$cd_time = clean_xss_tags($_POST['cd_time']);
	
	if($countdown_use != 'y') {
		$set_default = true;
	} else {
		if(!$cd_skin || !$cd_date || !$cd_hour || !$cd_time) {
			$set_default = true;
		}
	}
	
	$set_config = array();
	if(isset($set_default) && $set_default) {
		$set_config['countdown'] = 'n';
		$set_config['countdown_skin'] = '';
		$set_config['countdown_date'] = '';
	} else {
		$set_config['countdown'] = 'y';
		$set_config['countdown_skin'] = $cd_skin;
		$set_config['countdown_date'] = $cd_date . $cd_hour . $cd_time;
	}
	
	// 설정 저장
	if(is_array($eyoom)) {
		foreach($eyoom as $key => $val) {
			$_eyoom[$key] = $val;
			if ($key == 'countdown') {
				$_eyoom['countdown'] = $set_config['countdown'];
			}
			if ($key == 'countdown_skin') {
				$_eyoom['countdown_skin'] = $set_config['countdown_skin'];
			}
			if ($key == 'countdown_date') {
				$_eyoom['countdown_date'] = $set_config['countdown_date'];
			}
		}
		$qfile->save_file('eyoom', $eyoom_config, $_eyoom);
		
		alert("공사중 설정을 적용하였습니다.", $action_url);
	}
}

/**
 * submit 버튼
 */
$frm_submit  = ' <div class="text-center margin-top-30 margin-bottom-30"> ';
$frm_submit .= ' <input type="submit" value="적용하기" id="btn_submit" class="btn-e btn-e-lg btn-e-red" accesskey="s">' ;
$frm_submit .= '</div>';

$atpl->assign(array(
	'eyoom' 			=> $eyoom,
	'frm_submit' 		=> $frm_submit,
	'countdown_skin' 	=> $countdown_skin,
	'countdown_date' 	=> $countdown_date,
));