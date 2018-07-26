<?php
include_once('./_common.php');

if($is_guest) {
	alert('파트너만 이용가능합니다.', APMS_PARTNER_URL.'/login.php');
}

$is_auth = ($is_admin == 'super') ? true : false;
$is_partner = (IS_SELLER) ? true : false;

if($is_auth || $is_partner) {
	; // 통과
} else {
	alert('판매자(셀러) 파트너만 이용가능합니다.', APMS_PARTNER_URL);
}

$is_sql = '';
if ($is_auth) {
	$is_sql .= " and (pt_id = '' or pt_id = '{$member['mb_id']}')";
} else {
	$is_sql .= " and pt_id = '{$member['mb_id']}'";
}

$sql = " select * from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' $is_sql ";
$use = sql_fetch($sql);

if (!$use['is_id']) 
	alert('등록된 자료가 없습니다.', './?ap=uselist');

// 답변등록
$sql = "update {$g5['g5_shop_item_use_table']}
		   set is_reply_subject = '$is_reply_subject',
			   is_reply_content = '$is_reply_content',
			   is_reply_name = '".$member['mb_nick']."'
		 where is_id = '$is_id' ";
sql_query($sql);

//내글반응
if($is_reply_content) {
	$is_reply_subject = ($is_reply_subject) ? $is_reply_subject : apms_cut_text($is_reply_content, 80);
	apms_response('it', 'use', $use['it_id'], '', $is_id, $is_reply_subject, $use['mb_id'], $member['mb_id'], $member['mb_nick']);
}

goto_url('./?ap=useform&amp;is_id='.$is_id.'&amp;sca='.$sca.'&amp;save_opt='.$opt.'&amp;opt='.$opt.'&amp;page='.$page);

?>
