<?php
if (!defined('_GNUBOARD_')) {
	$is_item = false;
	include_once('./_common.php');

	if(USE_G5_THEME && defined('G5_THEME_PATH')) {
		require_once(G5_SHOP_PATH.'/yc/itemuse.php');
		return;
	}

	if( !isset($it) && !get_session("ss_tv_idx") ){
		if( !headers_sent() ){  //헤더를 보내기 전이면 검색엔진에서 제외합니다.
			echo '<meta name="robots" content="noindex, nofollow">';
		}
		/*
		if( !G5_IS_MOBILE ){    //PC 에서는 검색엔진 화면에 노출하지 않도록 수정
			return;
		}
		*/
	}

	include_once(G5_LIB_PATH.'/thumbnail.lib.php');

	$it = apms_it($it_id);
	$ca_id = ($ca_id) ? $ca_id : $it['ca_id'];
	$ca = sql_fetch(" select as_item_set, as_mobile_item_set from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ");
	$at = apms_ca_thema($ca_id, $ca, 1);
	if(!defined('THEMA_PATH')) {
		include_once(G5_LIB_PATH.'/apms.thema.lib.php');
	}

	$item_skin = apms_itemview_skin($at['item'], $ca_id, $it['ca_id']);

	// 출력수
	if(!$urows) $itemrows = apms_rows('iuse_'.MOBILE_.'rows');

	$wset = array();
	if($ca['as_'.MOBILE_.'item_set']) {
		$wset = apms_unpack($ca['as_'.MOBILE_.'item_set']);
	}

	// 데모
	if($is_demo) {
		@include ($demo_setup_file);
	}

	$item_skin_path = G5_SKIN_PATH.'/apms/item/'.$item_skin;
	$item_skin_url = G5_SKIN_URL.'/apms/item/'.$item_skin;

	$is_author = ($is_member && $it['pt_id'] && $it['pt_id'] == $member['mb_id']) ? true : false;
	$author_id = ($it['pt_id']) ? $it['pt_id'] : $config['cf_admin'];
	$author_photo = apms_photo_url($author_id);

} else {

	if(USE_G5_THEME && defined('G5_THEME_PATH')) {
		require_once(G5_SHOP_PATH.'/yc/itemuse.php');
		return;
	}

	$page = 0;
}

// 후기권한 재설정
$is_free_write = ($it['pt_review_use'] || !$default['de_item_use_write']) ? true : false;

$total_count = (int)$it['it_use_cnt'];

$urows = (isset($urows) && $urows > 0) ? $urows : $itemrows['iuse_'.MOBILE_.'rows'];
$urows = ($urows > 0) ? $urows : 15;

$total_page  = ceil($total_count / $urows); // 전체 페이지 계산
if($page > 0) {
	;
} else {
	$page = 1; // 페이지가 없으면 1페이지
}

$itemuse_list = "./itemuselist.php";
$itemuse_form = "./itemuseform.php?it_id=".$it_id.'&amp;ca_id='.$ca_id.'&amp;urows='.$urows;
$itemuse_formupdate = "./itemuseformupdate.php?it_id=".$it_id.'&amp;ca_id='.$ca_id.'&amp;urows='.$urows.'&amp;page='.$page;

$list = array();

if($total_count > 0) {

	$from_record = ($page - 1) * $urows; // 시작 레코드 구함

	if($from_record < 0)
		$from_record = 0;

	$iuse_num = $total_count - ($page - 1) * $urows;

	$result = sql_query("select * from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' order by is_id desc limit $from_record, $urows ");
	for ($i=0; $row=sql_fetch_array($result); $i++)	{
		$list[$i] = $row;
		$list[$i]['is_num'] = $iuse_num;
		$list[$i]['is_time'] = strtotime($row['is_time']);
		$list[$i]['is_star'] = apms_get_star($row['is_score']);
		$list[$i]['is_photo'] = apms_photo_url($row['mb_id']);
		$list[$i]['is_href'] = './itemuselist.php?bo_table=itemuse&amp;wr_id='.$row['wr_id'];
		$list[$i]['is_edit_href'] = $itemuse_form.'&amp;is_id='.$row['is_id'].'&amp;page='.$page.'&amp;w=u';
		$list[$i]['is_edit_self'] = $itemuse_form.'&amp;is_id='.$row['is_id'].'&amp;page='.$page.'&amp;w=u&amp;move=1';
		$list[$i]['is_content'] = apms_content(conv_content($row['is_content'], 1));
		$list[$i]['is_reply'] = false;
		if(!empty($row['is_reply_content'])) {
			$list[$i]['is_reply'] = true;
			$list[$i]['is_reply_name'] = get_text($row['is_reply_name']); 
			$list[$i]['is_reply_subject'] = get_text($row['is_reply_subject']); 
			$list[$i]['is_reply_content'] = apms_content(conv_content($row['is_reply_content'], 1));
		}

		$hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);
		$list[$i]['is_del_href'] = $itemuse_formupdate.'&amp;is_id='.$row['is_id'].'&amp;w=d&amp;hash='.$hash;
		$list[$i]['is_del_return'] = './itemuse.php?it_id='.$it_id.'&amp;ca_id='.$ca_id.'&amp;urows='.$urows.'&amp;page='.$page;
		$list[$i]['is_btn'] = ($is_admin || $row['mb_id'] == $member['mb_id']) ? true : false;

		$iuse_num--;
	}
}

$write_pages = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = './itemuse.php?it_id='.$it_id.'&amp;ca_id='.$ca_id.'&amp;urows='.$urows.'&amp;page=';

include_once($item_skin_path.'/itemuse.skin.php');

unset($list);
?>