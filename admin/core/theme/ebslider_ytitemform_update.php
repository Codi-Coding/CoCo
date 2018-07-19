<?php
$sub_menu = "800600";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

$es_code 		= clean_xss_tags(trim($_POST['es_code']));
$ei_state 		= clean_xss_tags(trim($_POST['ei_state']));
$ei_sort 		= clean_xss_tags(trim($_POST['ei_sort']));
$ei_ytcode 		= clean_xss_tags(trim($_POST['ei_ytcode']));
$ei_quality 	= clean_xss_tags(trim($_POST['ei_quality']));
$ei_remember 	= clean_xss_tags(trim($_POST['ei_remember']));
$ei_autoplay 	= clean_xss_tags(trim($_POST['ei_autoplay']));
$ei_control 	= clean_xss_tags(trim($_POST['ei_control']));
$ei_loop 		= clean_xss_tags(trim($_POST['ei_loop']));
$ei_mute 		= clean_xss_tags(trim($_POST['ei_mute']));
$ei_raster 		= clean_xss_tags(trim($_POST['ei_raster']));
$ei_volumn 		= clean_xss_tags(trim($_POST['ei_volumn']));
$ei_stime 		= clean_xss_tags(trim($_POST['ei_stime']));
$ei_etime 		= clean_xss_tags(trim($_POST['ei_etime']));
$ei_theme 		= clean_xss_tags(trim($_POST['theme']));
$ei_period 		= clean_xss_tags(trim($_POST['ei_period']));
$ei_start 		= clean_xss_tags(trim($_POST['ei_start']));
$ei_end 		= clean_xss_tags(trim($_POST['ei_end']));
$ei_view_level 	= clean_xss_tags(trim($_POST['ei_view_level']));

if ($ei_period == '1')  {
	$ei_start 	= '';
	$ei_end 	= '';
} else {
	$ei_start 	= $ei_start ? date('Ymd', strtotime($_POST['ei_start'])) : '';
	$ei_end 	= $ei_end ? date('Ymd', strtotime($_POST['ei_end'])) : '';
}

$sql_common = " 
	es_code = '{$es_code}',
	ei_state = '{$ei_state}',
	ei_sort = '{$ei_sort}',
	ei_ytcode = '{$ei_ytcode}',
	ei_quality = '{$ei_quality}',
	ei_remember = '{$ei_remember}',
	ei_autoplay = '{$ei_autoplay}',
	ei_control = '{$ei_control}',
	ei_loop = '{$ei_loop}',
	ei_mute = '{$ei_mute}',
	ei_raster = '{$ei_raster}',
	ei_volumn = '{$ei_volumn}',
	ei_stime = '{$ei_stime}',
	ei_etime = '{$ei_etime}',
	ei_theme = '{$ei_theme}',
	ei_period = '{$ei_period}',
	ei_start = '{$ei_start}',
	ei_end = '{$ei_end}',
	ei_view_level = '{$ei_view_level}',
";

if ($iw == '') {
	$sql = "insert into {$g5['eyoom_ebslider_ytitem']} set {$sql_common} ei_regdt = '".G5_TIME_YMDHIS."'";
    sql_query($sql);
	$ei_no = sql_insert_id();
	
} else if ($iw == 'u') {
    $sql = " update {$g5['eyoom_ebslider_ytitem']} set {$sql_common} ei_regdt=ei_regdt where ei_no = '{$ei_no}' ";
    sql_query($sql);
	$msg = "유튜브 동영상 아이템을 정상적으로 수정하였습니다.";
	
	alert($msg, EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=ebslider_ytitemform&amp;es_code='.$es_code.'&amp;'.$qstr.'&amp;thema='.$ei_theme.'&amp;w=u&amp;iw=u&amp;wmode=1&amp;ei_no='.$ei_no);
	
} else {
	alert('제대로 된 값이 넘어오지 않았습니다.');
}

if ($iw == '') {
	echo "
		<script>window.parent.closeModal();</script>
	";
}