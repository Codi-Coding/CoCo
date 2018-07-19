<?php
if (!defined('_GNUBOARD_')) exit;

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;

if ($is_checkbox) $colspan++;

for ($i=0; $i<count($categories); $i++) {
    $category = trim($categories[$i]);
    if ($category=='') continue;
	$category_tab[$i]['category'] = $category;
	$category_tab[$i]['href'] = $category_href."?sca=".urlencode($category);
}

$list_pages = preg_replace('/(\.php)(&amp;|&)/i', '$1?', get_paging(G5_IS_MOBILE ? $qaconfig['qa_mobile_page_rows'] : $qaconfig['qa_page_rows'], $page, $total_page, './qalist.php'.$qstr.'&amp;page='));

// Paging 
$paging = $thema->pg_pages($tpl_name,'./qalist.php?'.$qstr.'&amp;page=');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/qa/list.skin.php');

// Template define
$tpl->define_template('qa',$eyoom['qa_skin'],'list.skin.html');

@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);