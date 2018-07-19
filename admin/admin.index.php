<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit;

// check pid
if ($pid) {
	$is_subpage = true;
	$act_file = EYOOM_ADMIN_CORE_PATH . "/{$dir}/{$pid}.php";

	if (file_exists($act_file)) {
		@include_once($act_file);
	}
	
	// 폼전송 모드일 때 출력 방지
	if ($smode) return;

	// Template define
	$atpl->define_template($dir, 'basic', $pid.'.skin.html');
	
	// Template assign
	@include_once(EYOOM_ADMIN_INC_PATH.'/atpl.assign.php');
	$atpl->print_($tpl_name);
	
} else {
	/*** 관리자 메인 ***/
	
	// 소셜로그인 디버그 파일 24시간 지난것은 삭제
	@include_once(G5_ADMIN_PATH . '/safe_check.php');
	if(function_exists('social_log_file_delete')){
	    social_log_file_delete(86400);
	}
	
	// 이윰빌더 및 그누보드 버전관련 정보
	if(defined('_EYOOM_VESION_')) {
		$version_check = false;

		if (!ini_get("allow_url_fopen")) ini_set("allow_url_fopen", 1);
		if (ini_get("allow_url_fopen") == 1) {
			$version_check = true;
			
			// 이윰넷에서 버전 가져오기
			$verinfo['eyoom'] = $eb->verinfo_from_xmlurl(EYOOM_SITE . '/bbs/rss.php?bo_table=update');
			$verinfo['eyoom']['now_version'] = str_replace("EyoomBuilder_", "", _EYOOM_VESION_);

			if ($is_youngcart) {
				$verinfo['gnuboard'] = $eb->verinfo_from_xmlurl(GNU_URL . '/rss/yc5_pds');
			} else {
				$verinfo['gnuboard'] = $eb->verinfo_from_xmlurl(GNU_URL . '/rss/g5_pds');
			}
		}
	}
	
	// 설치 테마들
	$sql="select * from {$g5['eyoom_theme']} where 1 ";
	$res=sql_query($sql,false);
	for($i=0;$row=sql_fetch_array($res);$i++) {
		$tminfo[$row['tm_name']] = $row;
	}
	
	// 영카트5 인가?
	if ($is_youngcart) {
		@include_once(EYOOM_ADMIN_PATH.'/admin.shop.index.php');
	}
	
	// 그누보드5/영카트5 공통
	@include_once(EYOOM_ADMIN_PATH. '/admin.common.index.php');
	
	// Template assign
	@include_once(EYOOM_ADMIN_INC_PATH.'/atpl.assign.php');
	
	$atpl->assign(array(
		'eb'		=> $eb,
		'verinfo' 	=> $verinfo,
		'ver_check'	=> $version_check,
		'tminfo'	=> $tminfo,
	));

	$atpl->print_('index_'.$tpl_name);
}