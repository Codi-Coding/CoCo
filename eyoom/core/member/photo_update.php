<?php
$g5_path = '../../..';
include_once ($g5_path.'/common.php');
include_once(EYOOM_PATH.'/common.php');

if(!$is_member) exit;

// 업로드 경로
$dest_path = G5_DATA_PATH.'/member/profile/';
$upload->path = $dest_path;

// 이전파일
if($del_photo) {
	$_old_photo = $dest_path.$old_photo;
	@unlink($_old_photo);
	sql_query("update {$g5[eyoom_member]} set photo = '' where mb_id='".$member['mb_id']."'");
}

$thumb['width'] = $eyoom['photo_width'];
$thumb['height'] = $eyoom['photo_height'];
$thumb['delete'] = 'y'; //원본 업로드 이미지 삭제여부

$res = $upload->upload_make_thumb("photo", $thumb);
if($res) {
	// 업로드된 파일 이외의 프로필 파일이 있다면 삭제하기
	$permit = array("jpg","gif","png");
	foreach($permit as $ext) {
		if($ext===$res['ext']) continue;
		$d_photo = $dest_path.$member['mb_id'].'.'.$ext;
		if(file_exists($d_photo)) @unlink($d_photo);
	}

	// 썸네일 파일명을 회원아이디로 치환
	$thumb_file = $res['t_file'];
	$rename = $member['mb_id'].'.'.$res['ext'];
	@rename($thumb_file, $dest_path.$rename);
	sql_query("update {$g5[eyoom_member]} set photo = '".$rename."' where mb_id='".$member['mb_id']."'");
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/member/photo_update.php');

goto_url($back_url);