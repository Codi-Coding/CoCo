<?php
$g5_path = '../../..';
include_once ($g5_path.'/common.php');
include_once(EYOOM_PATH.'/common.php');

if(!$is_member) exit;

// 업로드 경로
$dest_path = G5_DATA_PATH.'/member/cover/';
$upload->path = $dest_path;

if($del_cover) {
	$_old_cover = $dest_path.$old_cover;
	@unlink($_old_cover);
	sql_query("update {$g5['eyoom_member']} set myhome_cover = '' where mb_id='".$member['mb_id']."'");
}

$thumb['width'] = $eyoom['cover_width'];
$thumb['height'] = 0; // 가로기준 세로부분은 1/3 기준
$thumb['delete'] = 'y'; //원본 업로드 이미지 삭제여부

$res = $upload->upload_make_thumb("photo", $thumb);
if($res) {
	$thumb_file = $res['t_file'];
	// 썸네일 파일명을 회원아이디로 치환
	$rename = $member['mb_id'].'.'.$res['ext'];
	@rename($thumb_file, $dest_path.$rename);
	sql_query("update {$g5[eyoom_member]} set myhome_cover = '".$rename."' where mb_id='".$member['mb_id']."'");
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/mypage/cover_update.php');

goto_url(G5_URL.$back_url);