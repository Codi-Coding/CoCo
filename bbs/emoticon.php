<?php
include_once('./_common.php');
if(!defined('G5_IS_ADMIN')) {
	define('G5_IS_ADMIN', true);
}

$emo = array();

if(isset($edir) && $edir && is_dir(G5_PATH.'/img/emoticon/'.$edir)) {
	$is_emo = true;
	$emo_path = G5_PATH.'/img/emoticon/'.$edir;
	$emo_skin = $edir.'/';
} else {
	$is_emo = false;
	$emo_path = G5_PATH.'/img/emoticon';
	$emo_skin = '';
}

$handle = opendir($emo_path);
while ($file = readdir($handle)) {
	if(preg_match("/\.(jpg|jpeg|gif|png)$/i", $file)) {
		$emo[] = $file;
	}
}
closedir($handle);
sort($emo);

$emoticon = array();
for($i=0; $i < count($emo); $i++) {
	$emoticon[$i]['name'] = $emo_skin.$emo[$i];
	$emoticon[$i]['url'] = G5_URL.'/img/emoticon/'.$emo_skin.$emo[$i];
}

// Emo Skin
$eskin = array();
$ehandle = opendir(G5_PATH.'/img/emoticon');
while ($efile = readdir($ehandle)) {

	if($efile == "." || $efile == ".." || preg_match("/\.(jpg|jpeg|gif|png)$/i", $efile)) continue;

	if (is_dir(G5_PATH.'/img/emoticon/'.$efile)) 
		$eskin[] = $efile;
}
closedir($ehandle);
sort($eskin);
$eskin_cnt = count($eskin);

$fid = (isset($fid) && $fid) ? $fid : 'wr_content';

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

include_once(G5_PATH.'/head.sub.php');
@include_once(THEMA_PATH.'/head.sub.php');
include_once($misc_skin_path.'/emoticon.php');
@include_once(THEMA_PATH.'/tail.sub.php');
include_once(G5_PATH.'/tail.sub.php');

?>