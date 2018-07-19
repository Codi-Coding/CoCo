<?php
if (!defined('_GNUBOARD_')) {
	$is_item = false;
	include_once('./_common.php');

	if(USE_G5_THEME && defined('G5_THEME_PATH')) {
		require_once(G5_SHOP_PATH.'/yc/itemqa.php');
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
	if(!$qrows) $itemrows = apms_rows('iqa_'.MOBILE_.'rows');

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
		require_once(G5_SHOP_PATH.'/yc/itemqa.php');
		return;
	}

	$page = 0;
}

$sql_common = " from `{$g5['g5_shop_item_qa_table']}` where it_id = '{$it_id}' ";

// 테이블의 전체 레코드수만 얻음
$total_count = (int)$it['pt_qa'];

$qrows = (isset($qrows) && $qrows > 0) ? $qrows : $itemrows['iqa_'.MOBILE_.'rows'];
$qrows = ($qrows > 0) ? $qrows : 20;

$total_page  = ceil($total_count / $qrows); // 전체 페이지 계산

if($page > 0) {
	;
} else {
	$page = 1; // 페이지가 없으면 1페이지
}

$list = array();

$itemqa_list = "./itemqalist.php";
$itemqa_form = "./itemqaform.php?it_id=".$it_id.'&amp;ca_id='.$ca_id.'&amp;qrows='.$qrows;
$itemqa_formupdate = "./itemqaformupdate.php?it_id=".$it_id.'&amp;ca_id='.$ca_id.'&amp;qrows='.$qrows.'&amp;page='.$page;
$itemqans_form = "./itemqansform.php?it_id=".$it_id.'&amp;ca_id='.$ca_id.'&amp;qrows='.$qrows;
$itemqans_formupdate = "./itemqansformupdate.php?it_id=".$it_id.'&amp;ca_id='.$ca_id.'&amp;qrows='.$qrows.'&amp;page='.$page;

if($total_count > 0) {

	$from_record = ($page - 1) * $qrows; // 시작 레코드 구함

	if($from_record < 0)
		$from_record = 0;

	$iqa_num = $total_count - ($page - 1) * $qrows;

	$result = sql_query("select * $sql_common order by iq_id desc limit $from_record, $qrows ");
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = $row;
		$list[$i]['iq_num'] = $iqa_num;

		$list[$i]['secret'] = false;
		if($row['iq_secret']) {
			if($is_admin || $is_author || $member['mb_id' ] == $row['mb_id']) {
				$list[$i]['iq_question'] = apms_content(conv_content($list[$i]['iq_question'], 1));
			} else {
				$list[$i]['iq_question'] = '비밀글로 보호된 문의입니다.';
				$list[$i]['secret'] = true;
			}
		} 

		$list[$i]['iq_time'] = strtotime($row['iq_time']);
		$list[$i]['iq_edit_href'] = $itemqa_form.'&amp;iq_id='.$row['iq_id'].'&amp;page='.$page.'&amp;w=u';
		$list[$i]['iq_edit_self'] = $itemqa_form.'&amp;iq_id='.$row['iq_id'].'&amp;page='.$page.'&amp;w=u&amp;move=1';
		$list[$i]['iq_ans_href'] = $itemqans_form.'&amp;iq_id='.$row['iq_id'].'&amp;page='.$page;
		$list[$i]['iq_ans_self'] = $itemqans_form.'&amp;iq_id='.$row['iq_id'].'&amp;page='.$page.'&amp;move=1';

		$hash = md5($row['iq_id'].$row['iq_time'].$row['iq_ip']);
		$list[$i]['iq_del_href'] = $itemqa_formupdate.'&amp;iq_id='.$row['iq_id'].'&amp;w=d&amp;hash='.$hash;
		$list[$i]['iq_del_return'] = './itemqa.php?it_id='.$it_id.'&amp;ca_id='.$ca_id.'&amp;qrows='.$qrows.'&amp;page='.$page;
		$list[$i]['iq_photo'] = apms_photo_url($row['mb_id']);
		if($row['pt_id']) {
			$list[$i]['ans_photo'] = ($row['pt_id'] == $author_id) ? $author_photo : apms_photo_url($row['pt_id']);
		} else {
			$list[$i]['ans_photo'] = $author_photo;
		}

		$list[$i]['answer'] = false;
		if(!$list[$i]['secret']) {
			if ($row['iq_answer']) {
				$list[$i]['iq_answer'] = apms_content(conv_content($list[$i]['iq_answer'], 1));
				$list[$i]['answer'] = true;
			}
		}

		$list[$i]['iq_btn']	= ($is_admin || $is_author || ($row['mb_id'] == $member['mb_id'] && !$list[$i]['answer'])) ? true : false;

		$iqa_num--;
	}
}

$write_pages = (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = './itemqa.php?it_id='.$it_id.'&amp;ca_id='.$ca_id.'&amp;qrows='.$qrows.'&amp;page=';

include_once($item_skin_path.'/itemqa.skin.php');

unset($list);

?>