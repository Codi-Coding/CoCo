<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 특수문자 변환
function specialchars_replace($str, $len=0) {
    if ($len) {
        $str = substr($str, 0, $len);
    }

    $str = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $str);

    return $str;
}

function conv_rich_content($matches){
    global $view;
	return view_image($view, $matches[1], $matches[2]);
}

function conv_link_video($link) {

	if(!$link) return;

	// 비디오, 오디오 체크
	$vext = array("mp4", "m4v", "f4v", "mov", "flv", "webm", "acc", "m4a", "f4a", "mp3", "ogg", "oga", "rss");

	list($link_video) = explode("|", $link);
		
	$file = apms_get_filename($link_video);

	$str = '';
	if(isset($file['ext']) && $file['ext'] && in_array($file['ext'], $vext)) {
		if(apms_jwplayer($link_video)) {
			$str = '<p>{video:'.$link_video.'|file=1}</p>';
		}
	} else {
		$video = apms_video_info($link_video);
		if(isset($video['vid']) && $video['vid']) {
			$str = '<p>{video:'.$link_video.'}</p>';
		}
	}

	return $str;
}

function img_insert_content($matches){
	global $row;

	return view_image($row, $matches[1], $matches[2]);
}

?>
