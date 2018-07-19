<?php
if (!defined('_SHOP_')) exit;

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/itemuseform.php');
	return;
}
include_once(G5_EDITOR_LIB);

if (!$is_member) {
	alert_close("사용후기는 회원만 작성 가능합니다.");
}

$w     = trim($_REQUEST['w']);
$it_id = get_search_string(trim($_REQUEST['it_id']));
$is_id = preg_replace('/[^0-9]/', '', trim($_REQUEST['is_id']));

// 상품정보체크
$sql = " select it_id from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
$row = sql_fetch($sql);
if(!$row['it_id'])
	alert_close('상품정보가 존재하지 않습니다.');

if ($w == "") {
	$is_score = 5;
	
	// 사용후기 작성 설정에 따른 체크
	check_itemuse_write($it_id, $member['mb_id']);
} else if ($w == "u") {
	$use = sql_fetch(" select * from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' ");
	if (!$use) {
		alert_close("사용후기 정보가 없습니다.");
	}
	
	$it_id    = $use['it_id'];
	$is_score = $use['is_score'];
	
	if (!$is_admin && $use['mb_id'] != $member['mb_id']) {
		alert_close("자신의 사용후기만 수정이 가능합니다.");
	}
}

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

$is_dhtml_editor = false;
// 모바일에서는 DHTML 에디터 사용불가
if ($config['cf_editor'] && (!is_mobile() || defined('G5_IS_MOBILE_DHTML_USE') && G5_IS_MOBILE_DHTML_USE)) {
	$is_dhtml_editor = true;
}
$editor_html = editor_html('is_content', get_text(html_purifier($use['is_content']), 0), $is_dhtml_editor);
$editor_js = '';
$editor_js .= get_editor_js('is_content', $is_dhtml_editor);
$editor_js .= chk_editor_js('is_content', $is_dhtml_editor);

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'item_useform.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/itemuseform.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

include_once(G5_PATH.'/tail.sub.php');