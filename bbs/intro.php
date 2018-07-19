<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// Intro
$intro_id = 'apms_intro';
$intro_set = $config['as_intro'];
$intro_skin = $config['as_'.MOBILE_.'intro_skin'];

list($intro_type, $intro_time) = explode("|", $intro_set);

if($intro_type == "2") { // 지정날짜
	if((int)$intro_time > G5_SERVER_TIME) {
		if(!$is_admin)
			$is_intro = true;
	} else {
		sql_query(" update `{$g5['config_table']}` set as_intro = '', as_intro_skin = '', as_mobile_intro_skin = '' ", false); // 인트로 해제
	}
} else if($intro_type == "1") { // 캐시체크(1일)
	if(!get_cookie($intro_id)) {
		set_cookie($intro_id, 1, 86400 * 1); // 1일동안 쿠키 유지
		$is_intro = true;
	}
} else { //세션체크
	if(!get_session($intro_id)) {
		set_session($intro_id, TRUE);
		$is_intro = true;
	}
}

if($is_intro) {
	if(is_file(G5_SKIN_PATH.'/intro/'.$intro_skin.'/intro.html')) {

		$title = $config['cf_title'];
		$datetime = (int)$intro_time;
		$skin = $intro_skin; 
		$url = G5_SKIN_URL.'/intro/'.$skin;
		$path = G5_SKIN_PATH.'/intro/'.$skin;
		$enter_url = G5_URL;
		$is_wdir = str_replace(G5_PATH, '', $path).'/widget'; //위젯 경로

		ob_start();
		include_once($path.'/intro.html');
		$intro_content = ob_get_contents();
		ob_end_clean();

		$intro_content = str_replace("./", $url."/", $intro_content);

		echo $intro_content;

		return;
	} else {
		$is_intro = false;
	}
}
?>