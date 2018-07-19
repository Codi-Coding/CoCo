<?php
include_once('./_common.php');

if($is_guest) {
	alert_close(aslang('alert', 'is_member')); //회원만 이용하실 수 있습니다.
}

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// Upload Member Photo
function apms_photo_upload($mb_id, $del_photo, $file) {
	global $g5, $xp;

	if(!$mb_id) return;

	//Photo Size
	$photo_w = (isset($xp['xp_photo']) && $xp['xp_photo']) ? $xp['xp_photo'] : 80;
	$photo_h = $photo_w;

	$photo_dir = G5_DATA_PATH.'/apms/photo/'.substr($mb_id,0,2);
	$temp_dir = G5_DATA_PATH.'/apms/photo/temp';

	if(!is_dir($photo_dir)) {
        @mkdir($photo_dir, G5_DIR_PERMISSION);
        @chmod($photo_dir, G5_DIR_PERMISSION);
	}

	if(!is_dir($temp_dir)) {
        @mkdir($temp_dir, G5_DIR_PERMISSION);
        @chmod($temp_dir, G5_DIR_PERMISSION);
	}

	//Delete Photo
	if ($del_photo == "1") {
		@unlink($photo_dir.'/'.$mb_id.'.jpg');
		sql_query(" update {$g5['member_table']} set as_photo = '0' where mb_id = '$mb_id' ", false);
	}
    
	//Upload Photo
	if (is_uploaded_file($file['mb_icon2']['tmp_name'])) {
		if (!preg_match("/(\.(jpg|jpeg|gif|png))$/i", $file['mb_icon2']['name'])) {
			alert(aslang('alert', 'is_image', array($file['mb_icon2']['name']))); //은(는) 이미지(gif/jpg/png) 파일이 아닙니다.
		} else {
			$filename  = $file['mb_icon2']['name'];
			$filename  = preg_replace('/(<|>|=)/', '', $filename);
			$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

			$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
			shuffle($chars_array);
			$shuffle = implode('', $chars_array);
	        $filename = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);

			$org_photo = $photo_dir.'/'.$mb_id.'.jpg';
			$temp_photo = $temp_dir.'/'.$filename;

			move_uploaded_file($file['mb_icon2']['tmp_name'], $temp_photo) or die($file['mb_icon2']['error']);
			chmod($temp_photo, G5_FILE_PERMISSION);
			if(is_file($temp_photo)) {
			    $size = @getimagesize($temp_photo);

			    //Non Image
				if (!$size[0]) {
					@unlink($temp_photo);
					alert(aslang('alert', 'is_photo')); //회원사진 등록에 실패했습니다. 이미지 파일이 정상적으로 업로드 되지 않았거나, 이미지 파일이 아닙니다.
				}			

				//Animated GIF
	            $is_animated = false;
	            if($size[2] == 1) {
	                $is_animated = is_animated_gif($temp_photo);
		        }

				if($is_animated) {
					@unlink($temp_photo);
					alert(aslang('alert', 'is_photo_gif')); //움직이는 GIF 파일은 회원사진으로 등록할 수 없습니다.
				} else {
					$thumb = thumbnail($filename, $temp_dir, $temp_dir, $photo_w, $photo_h, true, true);
					if($thumb) {
						copy($temp_dir.'/'.$thumb, $org_photo);
						chmod($org_photo, G5_FILE_PERMISSION);
						@unlink($temp_dir.'/'.$thumb);
						@unlink($temp_photo);
						sql_query(" update {$g5['member_table']} set as_photo = '1' where mb_id = '$mb_id' ", false);
					} else {
						@unlink($temp_photo);
						//회원사진 등록에 실패했습니다. 이미지 파일이 정상적으로 업로드 되지 않았거나, 이미지 파일이 아닙니다.
						alert(aslang('alert', 'is_photo'), G5_BBS_URL.'/mb.photo.php');
					}
				}
			}
		}
	}
}

// 설정 저장-------------------------------------------------------
if ($mode == "u") apms_photo_upload($member['mb_id'], $del_mb_icon2, $_FILES); //Save
//--------------------------------------------------------------------

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_myphoto_sub = true;
@include_once($member_skin_path.'/config.skin.php');

$mb_dir = substr($member['mb_id'],0,2);

$is_photo = (is_file(G5_DATA_PATH.'/apms/photo/'.$mb_dir.'/'.$member['mb_id'].'.jpg')) ? true : false;

$photo_size = $xp['xp_photo'];

$myphoto = apms_photo_url($member['mb_id']);

//$g5['title'] = '내사진 등록/수정';

if($is_myphoto_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('member_mobile') : apms_skin_set('member');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=member&amp;ts='.urlencode(THEMA);
}

include_once($skin_path.'/myphoto.skin.php');

if($is_myphoto_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>