<?php
$sub_menu = '400660';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

include_once(G5_EDITOR_LIB);

/**
 * 폼 action URL
 */
$action_url = EYOOM_ADMIN_CORE_URL . "/shop/itemqaformupdate.php";

/**
 * 상품문의 정보 가져오기
 */
$sql = " select * from {$g5['g5_shop_item_qa_table']} a left join {$g5['member_table']} b on (a.mb_id = b.mb_id) where iq_id = '$iq_id' ";
$itemqa = sql_fetch($sql);
if (!$itemqa['iq_id']) alert('등록된 자료가 없습니다.');

$itemqa['name'] = get_sideview($itemqa['mb_id'], get_text($itemqa['iq_name']), $itemqa['mb_email'], $itemqa['mb_homepage']);

$qstr .= ($qstr ? '&amp;' : '').'sca='.$sca;

/**
 * 에디터
 */
$editor_question_html = editor_html("iq_question", get_text(html_purifier($itemqa['iq_question']), 0));
$editor_answer_html = editor_html("iq_answer", get_text(html_purifier($itemqa['iq_answer']), 0));

/**
 * 서밋 버튼
 */
$buttons = "
	<button type='submit' value='확인' id='btn_submit' class='btn-e btn-e-lg btn-e-red'>확인</button>
	<a href='" . EYOOM_ADMIN_URL . "/?dir=shop&pid=itemqalist&qstr={$qstr}' id='btn_list' class='btn-e btn-e-lg btn-e-dark'>목록</a>
";

$atpl->assign(array(
	'itemqa' => $itemqa,
	'buttons' => $buttons,
));