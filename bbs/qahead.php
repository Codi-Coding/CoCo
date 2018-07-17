<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 관리자 체크
if (chk_multiple_admin($member['mb_id'], $qaconfig['as_admin'])) { 
	$is_admin = 'super'; 
}

// 회원별 정렬
if ($is_admin && isset($_REQUEST['qmb']) && $_REQUEST['qmb'])  {
    $qmb = get_search_string(trim($_REQUEST['qmb']));
    if ($qmb)
        $qstr .= '&amp;qmb=' . urlencode($qmb);
} else {
    $qmb = '';
}

// Page ID
$pid = ($pid) ? $pid : 'secret';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

$qa_skin_path = get_skin_path('qa', (G5_IS_MOBILE ? $qaconfig['qa_mobile_skin'] : $qaconfig['qa_skin']));
$qa_skin_url  = get_skin_url('qa', (G5_IS_MOBILE ? $qaconfig['qa_mobile_skin'] : $qaconfig['qa_skin']));

// 스킨 체크
list($qa_skin_path, $qa_skin_url) = apms_skin_thema('qa', $qa_skin_path, $qa_skin_url); 

// 설정값 불러오기
$is_qa_sub = false;
@include_once($qa_skin_path.'/config.skin.php');

if($is_qa_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	if (G5_IS_MOBILE) {
		// 모바일의 경우 설정을 따르지 않는다.
		include_once('./_head.php');
		echo conv_content($qaconfig['qa_mobile_content_head'], 1);
	} else {
	    if($qaconfig['qa_include_head'] && is_include_path_check($qaconfig['qa_include_head']))
			@include ($qaconfig['qa_include_head']);
		else
			include ('./_head.php');
		echo conv_content($qaconfig['qa_content_head'], 1);
	}
}

$skin_path = $qa_skin_path;
$skin_url = $qa_skin_url;

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('qa_mobile') : apms_skin_set('qa');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=qa&amp;ts='.urlencode(THEMA);
}

?>