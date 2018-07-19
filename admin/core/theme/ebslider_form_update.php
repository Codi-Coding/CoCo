<?php
$sub_menu = "800600";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

$es_code 		= clean_xss_tags(trim($_POST['es_code']));
$es_theme 		= clean_xss_tags(trim($_POST['theme']));
$es_state 		= clean_xss_tags(trim($_POST['es_state']));
$es_subject		= clean_xss_tags(trim($_POST['es_subject']));
$es_skin 		= clean_xss_tags(trim($_POST['es_skin']));
$es_ytplay 		= clean_xss_tags(trim($_POST['es_ytplay']));
$es_ytmauto 	= clean_xss_tags(trim($_POST['es_ytmauto']));

$sql_common = " 
	es_code = '{$es_code}',
	es_theme = '{$es_theme}',
	es_state = '{$es_state}',
	es_subject = '{$es_subject}',
	es_skin = '{$es_skin}',
	es_ytplay = '{$es_ytplay}',
	es_ytmauto = '{$es_ytmauto}',
";


if ($w == '') {
    sql_query(" insert into {$g5['eyoom_ebslider']} set {$sql_common} es_regdt = '".G5_TIME_YMDHIS."'");
	$es_no = sql_insert_id();
	$msg = "EB슬라이더 마스터를 추가하였습다.";
	
} else if ($w == 'u') {
	
    $sql = " update {$g5['eyoom_ebslider']} set {$sql_common} es_regdt=es_regdt where es_code = '{$es_code}' ";
    sql_query($sql);
	$msg = "EB슬라이더 마스터를 수정하였습니다.";
	
} else {
	alert('제대로 된 값이 넘어오지 않았습니다.');
}

alert($msg, EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=ebslider_form&amp;'.$qstr.'&amp;thema='.$_POST['theme'].'&amp;w=u&amp;es_code='.$es_code);

