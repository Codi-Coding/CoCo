<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_EDITOR_LIB);

$is_sql = '';
if ($is_auth) {
	$is_sql .= " and (a.pt_id = '' or a.pt_id = '{$mb_id}')";
} else {
	$is_sql .= " and a.pt_id = '{$mb_id}'";
}

$sql = " select *
           from {$g5['g5_shop_item_use_table']} a
           left join {$g5['member_table']} b on (a.mb_id = b.mb_id)
          where is_id = '$is_id' $is_sql ";
$use = sql_fetch($sql);

if (!$use['is_id']) alert('등록된 자료가 없습니다.', './?ap=uselist');

$use['is_content'] = apms_content(conv_content($use['is_content'], 1));
$name = apms_sideview($use['mb_id'], get_text($use['is_name']), $use['mb_email'], $use['mb_homepage']);
$photo = apms_photo_url($use['mb_id']);

$it = apms_it($use['it_id']);

$list_href = './?ap=uselist&amp;sca='.$sca.'&amp;save_opt='.$opt.'&amp;opt='.$opt.'&amp;page='.$page;

include_once($skin_path.'/useform.skin.php');

?>
