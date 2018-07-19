<?php
$sub_menu = "800610";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

$ec_code 		= clean_xss_tags(trim($_POST['ec_code']));
$ec_theme 		= clean_xss_tags(trim($_POST['theme']));
$ec_state 		= clean_xss_tags(trim($_POST['ec_state']));
$ec_subject		= clean_xss_tags(trim($_POST['ec_subject']));
$ec_skin 		= clean_xss_tags(trim($_POST['ec_skin']));
$ec_text 		= clean_xss_tags(trim($_POST['ec_text']));
$ec_link_cnt 	= clean_xss_tags(trim($_POST['ec_link_cnt']));
$ec_image_cnt 	= clean_xss_tags(trim($_POST['ec_image_cnt']));

$sql_common = " 
	ec_code = '{$ec_code}',
	ec_theme = '{$ec_theme}',
	ec_state = '{$ec_state}',
	ec_subject = '{$ec_subject}',
	ec_skin = '{$ec_skin}',
	ec_text = '{$ec_text}',
	ec_link_cnt = '{$ec_link_cnt}',
	ec_image_cnt = '{$ec_image_cnt}',
";


if ($w == '') {
    sql_query(" insert into {$g5['eyoom_ebcontents']} set {$sql_common} ec_regdt = '".G5_TIME_YMDHIS."'");
	$ec_no = sql_insert_id();
	$msg = "EB슬라이더 마스터를 추가하였습다.";
	
} else if ($w == 'u') {
	
    $sql = " update {$g5['eyoom_ebcontents']} set {$sql_common} ec_regdt=ec_regdt where ec_code = '{$ec_code}' ";
    sql_query($sql);
	$msg = "EB컨텐츠 마스터를 수정하였습니다.";
	
} else {
	alert('제대로 된 값이 넘어오지 않았습니다.');
}

alert($msg, EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=ebcontents_form&amp;'.$qstr.'&amp;thema='.$_POST['theme'].'&amp;w=u&amp;ec_code='.$ec_code);

