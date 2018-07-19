<?php
$g5_path = '../../..';
include_once ($g5_path.'/common.php');

$title    =  urlencode(str_replace('\"', '"',$_REQUEST['title']));
$short_url = googl_short_url($_REQUEST['longurl']);
if(!$short_url)
    $short_url = urlencode($_REQUEST['longurl']);
$title_url = $title.' : '.$short_url;

switch($_REQUEST['sns']) {
	case 'facebook' :
		header("Location:http://www.facebook.com/sharer/sharer.php?s=100&u=".$short_url."&p=".$title);
		break;
	case 'twitter' :
		header("Location:https://twitter.com/intent/tweet?text=".$title_url);
		break;
	case 'gplus' :
		header("Location:https://plus.google.com/share?url=".$short_url);
		break;
	case 'kakaostory' :
		header("Location:https://story.kakao.com/share?url=".$short_url);
		break;
	case 'band' :
		header("Location:http://www.band.us/plugin/share?body=".$title_url);
		break;			
	default :
		echo 'Error';
}