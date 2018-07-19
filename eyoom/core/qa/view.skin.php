<?php
if (!defined('_GNUBOARD_')) exit;

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

for ($i=0; $i<$view['download_count']; $i++) {
	$files[$i]['download_href'] = $view['download_href'][$i];
	$files[$i]['download_source'] = $view['download_source'][$i];
}

// 파일 출력
if($view['img_count']) {
	for ($i=0; $i<$view['img_count']; $i++) {
		$thumbs[$i] = get_view_thumbnail($view['img_file'][$i], $qaconfig['qa_image_width']);
	}
}

$option = '';
$option_hidden = '';

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/qa/view.skin.php');

$tpl->define(array(
	'answer_pc'		=> 'skin_pc/qa/' . $eyoom['qa_skin'] . '/view_answer.skin.html',
	'answer_mo'		=> 'skin_mo/qa/' . $eyoom['qa_skin'] . '/view_answer.skin.html',
	'answer_bs'		=> 'skin_bs/qa/' . $eyoom['qa_skin'] . '/view_answer.skin.html',
	'answerform_pc' => 'skin_pc/qa/' . $eyoom['qa_skin'] . '/view_answerform.skin.html',
	'answerform_mo' => 'skin_mo/qa/' . $eyoom['qa_skin'] . '/view_answerform.skin.html',
	'answerform_bs' => 'skin_bs/qa/' . $eyoom['qa_skin'] . '/view_answerform.skin.html',
));

// Template define
$tpl->define_template('qa',$eyoom['qa_skin'],'view.skin.html');

@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);