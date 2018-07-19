<?php
include_once("./_common.php");

$tocken = $_GET['tocken'];

// GET 변수 처리
$getvar = $eb->decrypt_md5($tocken);

list($bn_no, $ip, $link) = explode("||",$getvar);
$bn_no = intval($bn_no);
if(!$bn_no || !is_int($bn_no)) { alert('잘못된 접근입니다.',G5_URL); exit; }
if($ip != $_SERVER['REMOTE_ADDR']) { alert('잘못된 접근입니다.',G5_URL); exit; }
if(!$link) { alert('잘못된 접근입니다.',G5_URL); exit; }

// 클릭 로그 남기기
// 다음버전에서 개발

// 클릭시 포인트 주기
$spb_name = 'spv_banner_'.$bn_no;
if (!get_session($spb_name) && $is_member) {
	$eb->level_point($levelset['banner']);
	set_session($spb_name, TRUE);

	// 배너 클릭수 증가
	sql_query("update {$g5['eyoom_banner']} set bn_clicked = bn_clicked + 1 where bn_no = '{$bn_no}'",false);
}
header("location:".$link);

?>