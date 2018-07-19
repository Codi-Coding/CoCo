<?php
if (!defined('_GNUBOARD_')) exit;

foreach( $faq_master_list as $k => $v ){
	$category_msg = '';
	$category_option = '';
	if($v['fm_id'] == $fm_id){ // 현재 선택된 카테고리라면
		$category_option = ' id="bo_cate_on"';
		$category_msg = '<span class="sound_only">열린 분류 </span>';
	}
	$list[$k] = $v;
	$list[$k]['category_option'] = $category_option;
	$list[$k]['category_msg'] = $category_msg;
}

// Paging 
$paging = $thema->pg_pages($tpl_name,$_SERVER['PHP_SELF'].'?'.$qstr.'&amp;page=');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/faq/list.skin.php');

// Template define
$tpl->define_template('faq',$eyoom['faq_skin'],'list.skin.html');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);