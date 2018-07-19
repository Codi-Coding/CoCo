<?php
$sub_menu = "800500";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

$bn_type 		= clean_xss_tags(trim($_POST['bn_type']));
$bn_location 	= clean_xss_tags(trim($_POST['bn_location']));
$bn_link		= $eb->filter_url($_POST['bn_link']);
$bn_target 		= clean_xss_tags(trim($_POST['bn_target']));
$bn_theme 		= clean_xss_tags(trim($_POST['theme']));
$bn_period 		= clean_xss_tags(trim($_POST['bn_period']));
$bn_state 		= clean_xss_tags(trim($_POST['bn_state']));
$bn_start 		= clean_xss_tags(trim($_POST['bn_start']));
$bn_end 		= clean_xss_tags(trim($_POST['bn_end']));
$bn_view_level 	= clean_xss_tags(trim($_POST['bn_view_level']));

$bn_start 	= $bn_start ? date('Ymd', strtotime($_POST['bn_start'])) : '';
$bn_end 	= $bn_end ? date('Ymd', strtotime($_POST['bn_end'])) : '';

$sql_common = " 
	bn_type = '{$bn_type}',
	bn_location = '{$bn_location}',
	bn_link = '{$bn_link}',
	bn_target = '{$bn_target}',
	bn_theme = '{$bn_theme}',
	bn_period = '{$bn_period}',
	bn_state = '{$bn_state}',
	bn_start = '{$bn_start}',
	bn_end = '{$bn_end}',
	bn_code = '".addslashes($_POST['bn_code'])."',
	bn_view_level = '{$bn_view_level}',
";

// 아이콘 업로드
if (is_uploaded_file($_FILES['bn_img']['tmp_name'])) {
	$ext = $qfile->get_file_ext($_FILES['bn_img']['name']);
	$file_name = md5(time().$_FILES['bn_img']['name']).".".$ext;
	if (!preg_match("/\.(jpg|gif|png)$/i", $_FILES['bn_img']['name'])) {
		alert($_FILES['bn_img']['name'] . '은(는) jpg/gif/png 파일이 아닙니다.');
	}

	if (preg_match("/\.(jpg|gif|png)$/i", $_FILES['bn_img']['name'])) {
		@mkdir(G5_DATA_PATH.'/banner/'.$_POST['theme'].'/', G5_DIR_PERMISSION);
		@chmod(G5_DATA_PATH.'/banner/'.$_POST['theme'].'/', G5_DIR_PERMISSION);

		$dest_path = G5_DATA_PATH.'/banner/'.$_POST['theme'].'/'.$file_name;

		move_uploaded_file($_FILES['bn_img']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);

		if (file_exists($dest_path)) {
			$size = getimagesize($dest_path);
			$sql_common .= "bn_img = '". $file_name ."',";
		}
	}
}

if ($w == '') {
    sql_query(" insert into {$g5['eyoom_banner']} set {$sql_common} bn_regdt = '".G5_TIME_YMDHIS."'");
	$bn_no = sql_insert_id();
	$msg = "배너/광고를 추가하였습다.";
	
} else if ($w == 'u') {
	if($del_bn_img) {
		$banner_file = G5_DATA_PATH.'/banner/'.$del_bn_img_name;
		if (file_exists($banner_file)) {
			@unlink($banner_file);
		}
	}
	
    $sql = " update {$g5['eyoom_banner']} set {$sql_common} bn_regdt=bn_regdt where bn_no = '{$bn_no}' ";
    sql_query($sql);
	$msg = "배너/광고를 정상적으로 수정하였습니다.";
	
} else {
	alert('제대로 된 값이 넘어오지 않았습니다.');
}

alert($msg, EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=banner_form&amp;'.$qstr.'&amp;thema='.$_POST['theme'].'&amp;w=u&amp;bn_no='.$bn_no);

