<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_EDITOR_LIB);

$qa_sql = '';
if ($is_auth) {
	$qa_sql .= " and (a.pt_id = '' or a.pt_id = '{$mb_id}')";
} else {
	$qa_sql .= " and a.pt_id = '{$mb_id}'";
}

$sql = " select *
           from {$g5['g5_shop_item_qa_table']} a
           left join {$g5['member_table']} b on (a.mb_id = b.mb_id)
          where iq_id = '$iq_id' $qa_sql ";
$iq = sql_fetch($sql);

if (!$iq['iq_id']) alert('등록된 자료가 없습니다.', './?ap=qalist');

$iq['iq_question'] = apms_content(conv_content($iq['iq_question'], 1));
$name = apms_sideview($iq['mb_id'], get_text($iq['iq_name']), $iq['mb_email'], $iq['mb_homepage']);
$photo = apms_photo_url($iq['mb_id']);

$it = apms_it($iq['it_id']);

$list_href = './?ap=qalist&amp;sca='.$sca.'&amp;save_opt='.$opt.'&amp;opt='.$opt.'&amp;page='.$page;

include_once($skin_path.'/qaform.skin.php');

?>
