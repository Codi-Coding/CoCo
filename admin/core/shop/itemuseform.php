<?php
$sub_menu = '400650';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

/**
 * 폼 action URL
 */
$action_url = EYOOM_ADMIN_URL . "/?dir=shop&amp;pid=itemuseformupdate&amp;smode=1";

$sql = " select *
           from {$g5['g5_shop_item_use_table']} a
           left join {$g5['member_table']} b on (a.mb_id = b.mb_id)
           left join {$g5['g5_shop_item_table']} c on (a.it_id = c.it_id)
          where is_id = '$is_id' ";
$is = sql_fetch($sql);

if (!$is['is_id'])
    alert('등록된 자료가 없습니다.');

// 사용후기 의 답변 필드 추가
if (!isset($is['is_reply_subject'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_use_table']}`
                ADD COLUMN `is_reply_subject` VARCHAR(255) NOT NULL DEFAULT '' AFTER `is_confirm`,
                ADD COLUMN `is_reply_content` TEXT NOT NULL AFTER `is_reply_subject`,
                ADD COLUMN `is_reply_name` VARCHAR(25) NOT NULL DEFAULT '' AFTER `is_reply_content`
                ", true);
}

$name = get_sideview($is['mb_id'], get_text($is['is_name']), $is['mb_email'], $is['mb_homepage']);

// 확인
$is_confirm_yes  =  $is['is_confirm'] ? 'checked="checked"' : '';
$is_confirm_no   = !$is['is_confirm'] ? 'checked="checked"' : '';

$qstr .= ($qstr ? '&amp;' : '').'sca='.$sca;

/**
 * 에디터
 */
$editor_content_html = editor_html("is_content", get_text(html_purifier($is['is_content']), 0));
$editor_reply_content_html = editor_html("is_reply_content", get_text(html_purifier($is['is_reply_content']), 0));

/**
 * 서밋 버튼
 */
$buttons = "
	<input type='submit' value='확인' class='btn_submit btn-e btn-e-lg btn-e-red' accesskey='s'>
	<a href='" . EYOOM_ADMIN_URL . "/?dir=shop&pid=itemuselist&qstr={$qstr}' id='btn_list' class='btn-e btn-e-lg btn-e-dark'>목록</a>
";

$atpl->assign(array(
	'is' => $is,
	'buttons' => $buttons,
));