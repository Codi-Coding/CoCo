<?php
$g5_path = '../../..';
include_once($g5_path.'/common.php');
include_once(EYOOM_PATH.'/common.php');

@include_once(EYOOM_INC_PATH.'/hookedfile.header.php');

include_once(G5_PATH.'/head.sub.php');

$emo = $_GET['emo'];
if(!$emo) $emo = 'rabbit';

$emoticon = $eb->get_emoticon($emo);

$emo_type = get_skin_dir('emoticon',EYOOM_THEME_PATH.'/'.$theme);

function get_skin_dir($skin, $skin_path=G5_SKIN_PATH) {
	global $g5;

	$result_array = array();

	$dirname = $skin_path.'/'.$skin.'/';
	$handle = opendir($dirname);
	while ($file = readdir($handle)) {
		if($file == '.'||$file == '..') continue;

		if (is_dir($dirname.$file)) $result_array[] = $file;
	}
	closedir($handle);
	sort($result_array);

	return $result_array;
}

// Template define
$tpl->define_template('emoticon',$eyoom['emoticon_skin'],'emoticon.skin.html');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);