<?php
$sub_menu = "800620";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

$el_code 		= clean_xss_tags(trim($_POST['el_code']));
$el_theme 		= clean_xss_tags(trim($_POST['theme']));
$el_state 		= clean_xss_tags(trim($_POST['el_state']));
$el_subject		= clean_xss_tags(trim($_POST['el_subject']));
$el_skin 		= clean_xss_tags(trim($_POST['el_skin']));

$sql_common = " 
	el_code = '{$el_code}',
	el_theme = '{$el_theme}',
	el_state = '{$el_state}',
	el_subject = '{$el_subject}',
	el_skin = '{$el_skin}',
";


if ($w == '') {
    sql_query(" insert into {$g5['eyoom_eblatest']} set {$sql_common} el_regdt = '".G5_TIME_YMDHIS."'");
	$el_no = sql_insert_id();
	$msg = "EB최신글 마스터를 추가하였습다.";
	
} else if ($w == 'u') {
	
    $sql = " update {$g5['eyoom_eblatest']} set {$sql_common} el_regdt=el_regdt where el_code = '{$el_code}' ";
    sql_query($sql);
	$msg = "EB최신글 마스터를 수정하였습니다.";
	
} else {
	alert('제대로 된 값이 넘어오지 않았습니다.');
}

alert($msg, EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=eblatest_form&amp;'.$qstr.'&amp;thema='.$_POST['theme'].'&amp;w=u&amp;el_code='.$el_code);

