<?php
if (!defined('_GNUBOARD_')) {
	$is_item = false;
	include_once('./_common.php');
	include_once(G5_LIB_PATH.'/thumbnail.lib.php');
}

if(!$it['it_id']) {
	$it = sql_fetch(" select it_id, ca_id, pt_id, pt_comment_use, pt_comment from {$g5['g5_shop_item_table']} where it_id = '$it_id' ");
	$is_comment = ($it['pt_comment_use']) ? true : false;
}

if(!$is_comment) return;

if($is_item) {
	$page = 0;
} else {
	if(!$ca_id) $ca_id = $it['ca_id'];
	if(!$item_skin_path) {
		$ca = sql_fetch(" select as_item_set, as_mobile_item_set from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ");
		$at = apms_ca_thema($ca_id, $ca, 1);
		include_once(G5_LIB_PATH.'/apms.thema.lib.php');
		$item_skin = apms_itemview_skin($at['item'], $ca_id, $it['ca_id']);

		// 출력수
		if(!$crows) $itemrows = apms_rows('icomment_'.MOBILE_.'rows');

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
	}

	$is_auther = ($is_member && $it['pt_id'] && $it['pt_id'] == $member['mb_id']) ? true : false;
	$author_id = ($it['pt_id']) ? $it['pt_id'] : $config['cf_admin'];
}

// 아이피
$is_ip_view = ($is_admin) ? true : false;

// SNS 동시등록
$board['bo_use_sns'] = ($default['pt_comment_sns']) ? true : false;

$is_shingo = ($default['pt_shingo'] > 0) ? true : false;

$list = array();

// 댓글권한
$is_comment_write = false;
if ($is_member && $it['pt_comment_use']) {
	if($is_admin != 'super' && $it['pt_comment_use'] == "2") {
	    $is_comment_write = ($is_author) ? true : false;
	} else {
	    $is_comment_write = true;
	}
}
$is_author_comment = ($it['pt_comment_use'] == "2") ? true : false;

// 전체 댓글수
$total_count = (int)$it['pt_comment'];

// 댓글갯수
$crows = (isset($crows) && $crows > 0) ? $crows : $itemrows['icomment_'.MOBILE_.'rows'];
$crows = ($crows > 0) ? $crows : 15;

// 전체 페이지 계산
$total_page  = ceil($total_count / $crows);  

if($page > 0) {
	;
} else {
	$page = $total_page; // 페이지가 없으면 마지막 페이지
}

// 댓글이 있으면...
if($total_count > 0) {

	$sql_common = " from {$g5['apms_comment']} where it_id = '$it_id' ";

	$from_record = ($page - 1) * $crows; // 시작 열을 구함
	if($from_record < 0)
		$from_record = 0;

	$result = sql_query(" select * $sql_common order by wr_comment, wr_comment_reply limit $from_record, $crows ");
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = $row;
		$list[$i]['name'] = apms_sideview($row['mb_id'], $row['wr_name'], $row['wr_email'], $row['wr_homepage'], $row['wr_level']);
		$list[$i]['is_lock'] = ($row['wr_shingo'] < 0) ? true : false;
		$list[$i]['reply_name'] = ($row['wr_comment_reply'] && $row['wr_re_name']) ? $row['wr_re_name'] : '';

		$shingo_txt = '';
		$is_content = $is_secret = $is_cmt_shingo = false;
		$list[$i]['content'] = $list[$i]['content1']= '비밀댓글 입니다.';
		if($row['as_shingo'] < 0) {
			$shingo_txt = '<p><b>블라인더 처리된 댓글입니다.</b></p>';
			if($is_admin || ($row['mb_id'] && $row['mb_id'] === $member['mb_id'])) {
				; // 관리자 또는 글쓴이는 통과
			} else {
				$is_cmt_shingo = true;
				$row['wr_content'] = ''; // 글내용 지움
			}
		}

		$list[$i]['content'] = $list[$i]['content1']= '비밀댓글 입니다.';
		if (!strstr($row['wr_option'], 'secret') || 
			$is_admin || 
			($it['pt_id'] && $it['pt_id'] === $member['mb_id']) ||
			($row['mb_id'] && $row['mb_id'] === $member['mb_id'])) {

			if($is_cmt_shingo) {
				$list[$i]['content1'] = '블라인더 처리된 댓글입니다'; 
				$list[$i]['content'] = '';
			} else {
				$list[$i]['content1'] = $row['wr_content'];
				$list[$i]['content'] = conv_content($row['wr_content'], 0, 'wr_content');
				$is_content = true;
			}
		} else {
			// 대댓글의 비밀글을 원댓글쓴이에게도 보이기
			$is_pre_commenter = false;
			if($row['wr_comment_reply'] && $member['mb_id']) {
				if($row['wr_re_mb'] && $row['wr_re_mb'] === $member['mb_id']) {
					$is_pre_commenter = true;
				} else {
					$pre_comment = sql_fetch(" select mb_id from {$g5['apms_comment']} where wr_id = '{$row['wr_comment']}' and wr_comment_reply = '".substr($row['wr_comment_reply'],0,-1)."' "); 
					if($pre_comment['mb_id'] && $pre_comment['mb_id'] === $member['mb_id']) {
						$is_pre_commenter = true;
					}
				}
			}

			if($is_pre_commenter) {
				if($is_cmt_shingo) {
					$list[$i]['content'] = '';
				} else {
					$list[$i]['content'] = conv_content($row['wr_content'], 0, 'wr_content');
					$is_content = true;
				}
			} else {
				$is_secret = true;
			}
		}

		if($is_content) {
			//$list[$i]['content'] = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<a href=\"".G5_BBS_URL."/view_img.php?img=$1://$2.$3\" target=\"_blank\" onclick=\"apms_image(this.href); return false;\"><img src=\"$1://$2.$3\" alt=\"\" style=\"max-width:100%;border:0;\"></a>", $list[$i]['content']);
			$list[$i]['content'] = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src=\"$1://$2.$3\" alt=\"\">", $list[$i]['content']);

			$list[$i]['content'] = apms_content(get_view_thumbnail($list[$i]['content']));

			//럭키포인트
			if($row['wr_lucky']) {
				$list[$i]['content'] = $list[$i]['content'].''.str_replace("[point]", number_format($row['wr_lucky']), $xp['lucky_msg']);
			}
		}

		// 글정리
		$list[$i]['content'] = $shingo_txt.$list[$i]['content'];
		$list[$i]['is_secret'] = $is_secret;
		$list[$i]['date'] = strtotime($list[$i]['wr_datetime']);
		$list[$i]['datetime'] = substr($row['wr_datetime'],2,14);

		// 관리자가 아니라면 중간 IP 주소를 감춘후 보여줍니다.
		$list[$i]['ip'] = $row['wr_ip'];
		if (!$is_admin)
			$list[$i]['ip'] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['wr_ip']);

		$list[$i]['is_reply'] = false;
		$list[$i]['is_edit'] = false;
		$list[$i]['is_del']  = false;

		if ($is_comment_write || $is_admin) {

			$token = '';

			if ($member['mb_id']) {
				if ($row['mb_id'] === $member['mb_id'] || $is_admin) {
	                set_session('it_delete_comment_'.$row['wr_id'].'_token', $token = uniqid(time()));
					$list[$i]['del_href']  = './itemcommentdelete.php?it_id='.$it_id.'&comment_id='.$row['wr_id'].'&token='.$token;
					$list[$i]['del_return']  = './itemcomment.php?it_id='.$it_id.'&ca_id='.$ca_id.'&crows='.$crows.'&page='.$page;
					$list[$i]['is_edit']   = true;
					$list[$i]['is_del']    = true;
				}
			}

			if (strlen($row['wr_comment_reply']) < 5) {
				$list[$i]['is_reply'] = true;
				$list[$i]['reply_link'] = '';
			}
		}

		// 05.05.22
		// 답변있는 코멘트는 수정, 삭제 불가
		if ($i > 0 && !$is_admin) {
			if ($row['wr_comment_reply']) {
				$tmp_comment_reply = substr($row['wr_comment_reply'], 0, strlen($row['wr_comment_reply']) - 1);
				if ($tmp_comment_reply == $list[$i-1]['wr_comment_reply']) {
					$list[$i-1]['is_edit'] = false;
					$list[$i-1]['is_del'] = false;
				}
			}
		}
	}
}

$itemcomment_url = './itemcomment.php?it_id='.$it_id.'&amp;ca_id='.$ca_id.'&amp;crows='.$crows;
$itemcomment_login_url = G5_HTTP_BBS_URL.'/login.php?url='.$urlencode;
$itemcomment_action_url = https_url(G5_SHOP_DIR).'/itemcommentupdate.php';
$is_comment_sns = ($default['pt_comment_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) ? true : false;

$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];
$list_page = './itemcomment.php?it_id='.$it_id.'&amp;ca_id='.$ca_id.'&amp;crows='.$crows.'&amp;page=';

if($w == '') $w = 'c';

include_once($item_skin_path.'/itemcomment.skin.php');

unset($list);

?>
