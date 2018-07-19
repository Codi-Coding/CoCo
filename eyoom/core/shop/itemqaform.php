<?php
if (!defined('_SHOP_')) exit;

if (G5_IS_MOBILE && $eyoom['use_shop_mobile'] == 'y') {
	include_once(EYOOM_MSHOP_PATH.'/itemqaform.php');
	return;
}

include_once(G5_EDITOR_LIB);

if (!$is_member) {
	alert_close("상품문의는 회원만 작성 가능합니다.");
}

$w     = trim($_REQUEST['w']);
$it_id = get_search_string(trim($_REQUEST['it_id']));
$iq_id = preg_replace('/[^0-9]/', '', trim($_REQUEST['iq_id']));

// 상품정보체크
$sql = " select it_id from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
$row = sql_fetch($sql);
if(!$row['it_id'])
	alert_close('상품정보가 존재하지 않습니다.');

$chk_secret = '';

if($w == '') {
	$qa['iq_email'] = $member['mb_email'];
	$qa['iq_hp'] = $member['mb_hp'];
}

if ($w == "u")
{
	$qa = sql_fetch(" select * from {$g5['g5_shop_item_qa_table']} where iq_id = '$iq_id' ");
	if (!$qa) {
		alert_close("상품문의 정보가 없습니다.");
	}
	
	$it_id    = $qa['it_id'];
	
	if (!$is_admin && $qa['mb_id'] != $member['mb_id']) {
		alert_close("자신의 상품문의만 수정이 가능합니다.");
	}
	
	if($qa['iq_secret'])
		$chk_secret = 'checked="checked"';
}

// 그누 헤더정보 출력
@include_once(G5_PATH.'/head.sub.php');

$is_dhtml_editor = false;
// 모바일에서는 DHTML 에디터 사용불가
if ($config['cf_editor'] && (!is_mobile() || defined('G5_IS_MOBILE_DHTML_USE') && G5_IS_MOBILE_DHTML_USE)) {
	$is_dhtml_editor = true;
}
$editor_html = editor_html('iq_question', get_text(html_purifier($qa['iq_question']), 0), $is_dhtml_editor);
$editor_js = '';
$editor_js .= get_editor_js('iq_question', $is_dhtml_editor);
$editor_js .= chk_editor_js('iq_question', $is_dhtml_editor);

// Template define
$tpl->define_template('shop',$eyoom['shop_skin'],'item_qaform.skin.html');

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/shop/itemqaform.php');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

include_once(G5_PATH.'/tail.sub.php');