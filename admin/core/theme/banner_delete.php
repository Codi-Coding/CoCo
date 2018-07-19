<?php
$sub_menu = "800500";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

check_demo();

$bn_no = clean_xss_tags(trim($_GET['bn_no']));
$theme = clean_xss_tags(trim($_GET['theme']));

if (!($bn_no && $theme)) alert('잘못된 접근입니다.');

if ($page) $qstr = "&amp;page={$page}";
if ($loccd) $qstr .= "&amp;loccd={$loccd}";

/**
 * 쿼리 조건문
 */
$where = " bn_no='{$bn_no}' and bn_theme = '{$theme}' ";

/**
 * 배너/광고 이미지 삭제를 위한 쿼리실행
 */
$sql = "select * from {$g5['eyoom_banner']} where {$where} ";
$res = sql_query($sql);
for($i=0; $row=sql_fetch_array($res); $i++) {
    $bn_file = G5_DATA_PATH.'/banner/'.$row['bn_theme'].'/'.$row['bn_img'];
    if (file_exists($bn_file) && !is_dir($bn_file)) {
		@unlink($bn_file);
	}
}

/**
 * 배너/광고 테이블 레코드 삭제
 */
$sql = "delete from {$g5['eyoom_banner']} where {$where} ";
sql_query($sql);

alert("선택한 배너/광고를 삭제하였습니다.", EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=banner_list'.$qstr);