<?php
if (!$it_id) {
	return;
}

$list = array();

$it = sql_fetch(" select it_id, ca_id, pt_id, pt_comment_use, pt_comment from {$g5['g5_shop_item_table']} where it_id = '$it_id' ");

if(!$it['pt_comment_use'] || !$it['pt_comment']) {
	return;
}

$is_comment = ($it['pt_comment_use']) ? true : false;
$is_auther = ($is_member && $it['pt_id'] && $it['pt_id'] == $member['mb_id']) ? true : false;
$author_id = ($it['pt_id']) ? $it['pt_id'] : $config['cf_admin'];

// 아이피
$is_ip_view = ($is_admin) ? true : false;

$is_shingo = ($default['pt_shingo'] > 0) ? true : false;

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

// 댓글 출력
$sql_common = " from {$g5['apms_comment']} where it_id = '$it_id' ";

if(isset($crows) && $crows > 0) {

	$total_count = (int)$it['pt_comment'];

	$total_page  = ceil($total_count / $crows);  // 전체 페이지 계산
	if($page > 0) {
		;
	} else {
		$page = 1; // 페이지가 없으면 마지막 페이지
	}

	$from_record = ($page - 1) * $crows; // 시작 열을 구함

	if($from_record < 0)
		$from_record = 0;

	$sql = " select * $sql_common order by wr_comment, wr_comment_reply limit $from_record, $crows ";
} else {
	$sql = " select * $sql_common order by wr_comment, wr_comment_reply ";
}

$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	$list[$i]['name'] = apms_sideview($row['mb_id'], $row['wr_name'], $row['wr_email'], $row['wr_homepage'], $row['wr_level']);

	$list[$i]['is_lock'] = ($row['wr_shingo'] < 0) ? true : false;

	$list[$i]['reply_name'] = ($row['wr_comment_reply'] && $row['wr_re_name']) ? $row['wr_re_name'] : '';

	$is_content = false;
    $list[$i]['content'] = $list[$i]['content1']= '비밀댓글 입니다.';
    if (!strstr($row['wr_option'], 'secret') || $is_admin || ($it['pt_id']==$member['mb_id'] && $it['pt_id']) || ($row['mb_id']==$member['mb_id'] && $member['mb_id'])) {
        $list[$i]['content1'] = $row['wr_content'];
        $list[$i]['content'] = conv_content($row['wr_content'], 0, 'wr_content');

		if($is_shingo && $row['wr_shingo'] < 0) {
			if($is_admin || ($row['mb_id'] && $row['mb_id'] == $member['mb_id'])) {
				$list[$i]['content'] = '<p><b>블라인더 처리된 댓글입니다.</b></p>'.$list[$i]['content'];
			} else {
				$list[$i]['content'] = '<p><b>블라인더 처리된 댓글입니다.</b></p>';
			}

		}

		$is_content = true;
	} else {
		// 대댓글의 비밀글을 원댓글쓴이에게도 보이기
		$is_pre_commenter = false;
		if($row['wr_comment_reply']) {
			if($row['wr_re_mb']) {
				if($member['mb_id'] && $row['wr_re_mb'] == $member['mb_id']) {
					$is_pre_commenter = true;
				}
			} else {
				$pre_comment = sql_fetch(" select mb_id from {$g5['apms_comment']} where wr_id = '{$row['wr_comment']}' and wr_comment_reply = '".substr($row['wr_comment_reply'],0,-1)."' "); 
				if($member['mb_id'] && $pre_comment['mb_id'] == $member['mb_id']) {
					$is_pre_commenter = true;
				}
			}
		}

        if($is_pre_commenter) {
            $list[$i]['content'] = conv_content($row['wr_content'], 0, 'wr_content');

			if($is_shingo && $row['wr_shingo'] < 0) {
				if($is_admin || ($row['mb_id'] && $row['mb_id'] == $member['mb_id'])) {
					$list[$i]['content'] = '<p><b>블라인더 처리된 댓글입니다.</b></p>'.$list[$i]['content'];
				} else {
					$list[$i]['content'] = '<p><b>블라인더 처리된 댓글입니다.</b></p>';
				}
			}

			$is_content = true;
		} 
    }

	if($is_content) { // 변환
		$list[$i]['content'] = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<a href=\"".G5_BBS_URL."/view_img.php?img=$1://$2.$3\" target=\"_blank\" onclick=\"apms_image(this.href); return false;\"><img src=\"$1://$2.$3\" alt=\"\" style=\"max-width:100%;border:0;\"></a>", $list[$i]['content']);
		$list[$i]['content'] = apms_content($list[$i]['content']);
	}

	//럭키포인트
	if($row['wr_lucky']) {
		$list[$i]['content'] = $list[$i]['content'].''.str_replace("[point]", number_format($row['wr_lucky']), $xp['lucky_msg']);
	}

    $list[$i]['date'] = strtotime($list[$i]['wr_datetime']);

    $list[$i]['datetime'] = substr($row['wr_datetime'],2,14);

	$list[$i]['href'] = G5_SHOP_URL.'/item.php?it_id='.$it_id.'#c_'.$list[$i]['wr_id'];

    // 관리자가 아니라면 중간 IP 주소를 감춘후 보여줍니다.
    $list[$i]['ip'] = $row['wr_ip'];
    if (!$is_admin)
        $list[$i]['ip'] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['wr_ip']);

}

?>
