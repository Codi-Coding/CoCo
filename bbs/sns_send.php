<?php
include_once("./_common.php");
@include_once(G5_LIB_PATH.'/json.lib.php');

$title = $_REQUEST['title'];
$mode = $_REQUEST['sns'];

// 트위터 제목변환
if($mode == 'twitter') {
	$title = str_replace(array("&lt;", "&gt;", "&#034;", "&#039;"), array("<", ">", "\"", "\'"), $title);
}

$title = urlencode(str_replace('\"', '"', $title));
$short_url = googl_short_url($_REQUEST['longurl']);
if(!$short_url) {
	$short_url = $_REQUEST['longurl'];

	if($mode == 'naver') { // Naver
		$short_url = str_replace("&amp;", "%26", $short_url);
		$short_url = str_replace("&", "%26", $short_url);
	} else if($mode == 'naverband') { // Naver Band
		$short_url = str_replace("&amp;", "&", $short_url);
	}

	$short_url = urlencode($short_url);
}
$title_url = $title.' : '.$short_url;

switch($mode) {
    case 'facebook' :
	    header("Location:http://www.facebook.com/sharer/sharer.php?s=100&u=".$short_url."&p=".$title);
		break;
    case 'twitter' :
        header("Location:https://twitter.com/intent/tweet?text=".$title_url);
        break;
    case 'gplus' :
        header("Location:https://plus.google.com/share?url=".$short_url);
        break;
    case 'naverband' :
        header("Location:http://www.band.us/plugin/share?body=".$title_url);
        break;
    case 'naver' :
		header("Location:http://share.naver.com/web/shareView.nhn?url=".$short_url."&title=".$title); 
        break;
    case 'tumblr' :
		header("Location:http://tumblr.com/widgets/share/tool?canonicalUrl=".$short_url); 
        break;
    case 'pinterest' :
		header("Location:https://www.pinterest.com/pin/create/button/?url=".$short_url.'&media='.urlencode($img).'&description='.$title); 
        break;
	case 'kakaostory' :
        header("Location:https://story.kakao.com/share?url=".$short_url);
        break;
	default :
        echo 'Error';
}
?>