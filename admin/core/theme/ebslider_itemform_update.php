<?php
$sub_menu = "800600";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

$es_code 		= clean_xss_tags(trim($_POST['es_code']));
$ei_state 		= clean_xss_tags(trim($_POST['ei_state']));
$ei_sort 		= clean_xss_tags(trim($_POST['ei_sort']));
$ei_title 		= clean_xss_tags(trim($_POST['ei_title']));
$ei_subtitle 	= clean_xss_tags(trim($_POST['ei_subtitle']));
$ei_text 		= clean_xss_tags(trim($_POST['ei_text']));
$ei_link		= $eb->filter_url($_POST['ei_link']);
$ei_target 		= clean_xss_tags(trim($_POST['ei_target']));
$ei_theme 		= clean_xss_tags(trim($_POST['theme']));
$ei_period 		= clean_xss_tags(trim($_POST['ei_period']));
$ei_start 		= clean_xss_tags(trim($_POST['ei_start']));
$ei_end 		= clean_xss_tags(trim($_POST['ei_end']));
$ei_view_level 	= clean_xss_tags(trim($_POST['ei_view_level']));
$ei_img_del 	= clean_xss_tags(trim($_POST['ei_img_del']));
$del_img_name 	= clean_xss_tags(trim($_POST['del_img_name']));

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
	ei_title = '{$ei_title}',
	ei_subtitle = '{$ei_subtitle}',
	ei_text = '{$ei_text}',
	ei_link = '{$ei_link}',
	ei_target = '{$ei_target}',
	ei_theme = '{$ei_theme}',
	ei_period = '{$ei_period}',
	ei_start = '{$ei_start}',
	ei_end = '{$ei_end}',
	ei_view_level = '{$ei_view_level}',
";

// 아이콘 업로드
if (is_uploaded_file($_FILES['ei_img']['tmp_name'])) {
	$ext = $qfile->get_file_ext($_FILES['ei_img']['name']);
	$file_name = md5(time().$_FILES['ei_img']['name']).".".$ext;
	if (!preg_match("/\.(jpg|gif|png)$/i", $_FILES['ei_img']['name'])) {
		alert($_FILES['ei_img']['name'] . '은(는) jpg/gif/png 파일이 아닙니다.');
	}

	if (preg_match("/\.(jpg|gif|png)$/i", $_FILES['ei_img']['name'])) {
		@mkdir(G5_DATA_PATH.'/ebslider/'.$ei_theme.'/', G5_DIR_PERMISSION);
		@chmod(G5_DATA_PATH.'/ebslider/'.$ei_theme.'/', G5_DIR_PERMISSION);

		$dest_path = G5_DATA_PATH.'/ebslider/'.$_POST['theme'].'/'.$file_name;

		move_uploaded_file($_FILES['ei_img']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);

		if (file_exists($dest_path)) {
			$size = getimagesize($dest_path);
			$sql_common .= "ei_img = '". $file_name ."',";
		}
	}
}

if ($iw == '') {
	$sql = "insert into {$g5['eyoom_ebslider_item']} set {$sql_common} ei_regdt = '".G5_TIME_YMDHIS."'";
    sql_query($sql);
	$ei_no = sql_insert_id();
	
} else if ($iw == 'u') {
	// 업로드 이미지가 있다면 기존 슬라이더 이미지 자동삭제
	if ($size) { // 업로드 파일이 있다면
		$eii = sql_fetch("select * from {$g5['eyoom_ebslider_item']} where ei_no = '{$ei_no}'");
		if ($eii['ei_img']) {
			$ei_img_del = true;
			$del_img_name = $eii['ei_img'];
		}
	}
	
	if($ei_img_del && $del_img_name) {
		$ebslider_file = G5_DATA_PATH.'/ebslider/'.$ei_theme.'/'.$del_img_name;
		if (file_exists($ebslider_file) && !is_dir($ebslider_file)) {
			@unlink($ebslider_file);
		}
		if (!isset($eii)) $sql_common .= "ei_img = '',";
	}
	
    $sql = " update {$g5['eyoom_ebslider_item']} set {$sql_common} ei_regdt=ei_regdt where ei_no = '{$ei_no}' ";
    sql_query($sql);
	$msg = "슬라이더 아이템을 정상적으로 수정하였습니다.";
	
	alert($msg, EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=ebslider_itemform&amp;es_code='.$es_code.'&amp;'.$qstr.'&amp;thema='.$ei_theme.'&amp;w=u&amp;iw=u&amp;wmode=1&amp;ei_no='.$ei_no);
	
} else {
	alert('제대로 된 값이 넘어오지 않았습니다.');
}

if ($iw == '') {
	echo "
		<script>window.parent.closeModal();</script>
	";
}