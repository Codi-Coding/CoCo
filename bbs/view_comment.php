<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 댓글 페이징
$crows = $board['as_comment_'.MOBILE_.'rows'];
if($crows > 0 && file_exists($board_skin_path.'/view_comment.page.skin.php')) {
	include_once('./view_comment.page.php');
	return;
}

// 페이지
$page = ($is_list_page) ? $is_list_page : $page;

// 신고
$is_shingo = ($board['as_shingo'] > 0) ? true : false;

include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

$captcha_html = "";
if ($is_guest && $board['bo_comment_level'] < 2) {
    $captcha_html = captcha_html('_comment');
}

@include_once($board_skin_path.'/view_comment.head.skin.php');

$list = array();

$is_comment_write = false;
if ($member['mb_level'] >= $board['bo_comment_level'])
    $is_comment_write = true;

// 댓글역순 출력
$is_rev_cmt = ($board['as_rev_cmt']) ? 'desc' : '';

// 코멘트 출력
$sql_comment = '';
$sql_comment_orderby = '';

@include_once($board_skin_path.'/view_comment.sql.skin.php');

//$sql = " select * from {$write_table} where wr_parent = '{$wr_id}' and wr_is_comment = 1 order by wr_comment desc, wr_comment_reply ";
$sql = " select * from $write_table where wr_parent = '$wr_id' and wr_is_comment = 1 $sql_comment order by $sql_comment_orderby wr_comment $is_rev_cmt, wr_comment_reply ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $list[$i] = $row;

    $tmp_name = get_text(cut_str($row['wr_name'], $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
    if ($board['bo_use_sideview']) {
        //$list[$i]['name'] = get_sideview($row['mb_id'], $tmp_name, $row['wr_email'], $row['wr_homepage']);
		$lvl = ($board['as_level']) ? 'yes' : 'no';
		$list[$i]['name'] = apms_sideview($row['mb_id'], $tmp_name, $row['wr_email'], $row['wr_homepage'], $row['as_level'], $lvl); // APMS 용으로 교체
	} else {
        $list[$i]['name'] = '<span class="'.($row['mb_id']?'member':'guest').'">'.$tmp_name.'</span>';
	}

	$list[$i]['is_lock'] = ($row['as_shingo'] < 0) ? true : false;
	$list[$i]['reply_name'] = ($row['wr_comment_reply'] && $row['as_re_name']) ? $row['as_re_name'] : '';

	// APMS -------->
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

	$chtml = 0;
	if (strstr($row['wr_option'], 'html1'))
		$chtml = 1;
	else if (strstr($row['wr_option'], 'html2'))
		$chtml = 2;

    if (!strstr($row['wr_option'], 'secret') ||
        $is_admin ||
        ($write['mb_id'] && $write['mb_id'] === $member['mb_id']) ||
        ($row['mb_id'] && $row['mb_id'] === $member['mb_id'])) {

		if($is_cmt_shingo) {
			$list[$i]['content1'] = '블라인더 처리된 댓글입니다'; 
			$list[$i]['content'] = '';
		} else {
			$list[$i]['content1'] = $row['wr_content'];
		    $list[$i]['content'] = conv_content($row['wr_content'], $chtml, 'wr_content');
            $list[$i]['content'] = search_font($stx, $list[$i]['content']);
			$is_content = true;
		}
	} else {
        $ss_name = 'ss_secret_comment_'.$bo_table.'_'.$list[$i]['wr_id'];

		// APMS : 대댓글의 비밀글을 원댓글쓴이에게도 보이기
		$is_pre_commenter = false;
		if($row['wr_comment_reply'] && $member['mb_id']) {
			$pre_comment = sql_fetch(" select mb_id from {$write_table} where wr_parent = '$wr_id' and wr_is_comment = 1 and wr_comment = '{$row['wr_comment']}' and wr_comment_reply = '".substr($row['wr_comment_reply'],0,-1)."' "); 
			if($pre_comment['mb_id'] && $pre_comment['mb_id'] === $member['mb_id']) 
				$is_pre_commenter = true;
		}		

        if(get_session($ss_name) || $is_pre_commenter) {
			if($is_cmt_shingo) {
				$list[$i]['content'] = '';
			} else {
				$list[$i]['content'] = conv_content($row['wr_content'], $chtml, 'wr_content');
	            $list[$i]['content'] = search_font($stx, $list[$i]['content']);
				$is_content = true;
			}
		} else {
            $list[$i]['content'] = '<a href="./password.php?w=sc&amp;bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].$qstr.'" class="s_cmt">댓글내용 확인</a>';
			$is_secret = true;
        }
    }

	if($is_content) {
		//$list[$i]['content'] = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<a href=\"".G5_BBS_URL."/view_img.php?img=$1://$2.$3\" target=\"_blank\" onclick=\"apms_image(this.href); return false;\"><img src=\"$1://$2.$3\" alt=\"\" style=\"max-width:100%;border:0;\"></a>", $list[$i]['content']);
		$list[$i]['content'] = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src=\"$1://$2.$3\" alt=\"\">", $list[$i]['content']);

		$list[$i]['content'] = apms_content(get_view_thumbnail($list[$i]['content']));

		//럭키포인트
		if($row['as_lucky']) {
			$list[$i]['content'] = $list[$i]['content'].''.str_replace("[point]", number_format($row['as_lucky']), $xp['lucky_msg']);
		}
	}

	// 글정리
	$list[$i]['content'] = $shingo_txt.$list[$i]['content'];
    $list[$i]['is_secret'] = $is_secret;
    $list[$i]['date'] = strtotime($list[$i]['wr_datetime']);
    $list[$i]['datetime'] = substr($row['wr_datetime'],2,14);

	// 베스트
	$cbwrid = $row['wr_id'];
	$list[$i]['best'] = $cbid[$cbwrid];

    // 관리자가 아니라면 중간 IP 주소를 감춘후 보여줍니다.
    $list[$i]['ip'] = $row['wr_ip'];
    if (!$is_admin)
        $list[$i]['ip'] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['wr_ip']);

    $list[$i]['is_reply'] = false;
    $list[$i]['is_edit'] = false;
    $list[$i]['is_del']  = false;
    if ($is_comment_write || $is_admin)
    {
        $token = '';

		if ($member['mb_id'])
        {
            if ($row['mb_id'] === $member['mb_id'] || $is_admin)
            {
                set_session('ss_delete_comment_'.$row['wr_id'].'_token', $token = uniqid(time()));
				$list[$i]['del_link']  = './delete_comment.php?bo_table='.$bo_table.'&amp;comment_id='.$row['wr_id'].'&amp;token='.$token.'&amp;page='.$page.$qstr;
                $list[$i]['is_edit']   = true;
                $list[$i]['is_del']    = true;
            }
        }
        else
        {
            if (!$row['mb_id']) {
                $list[$i]['del_link'] = './password.php?w=x&amp;bo_table='.$bo_table.'&amp;comment_id='.$row['wr_id'].'&amp;page='.$page.$qstr;
                $list[$i]['is_del']   = true;
            }
        }

        if (strlen($row['wr_comment_reply']) < 5)
            $list[$i]['is_reply'] = true;
    }

    // 05.05.22
    // 답변있는 코멘트는 수정, 삭제 불가
    if ($i > 0 && !$is_admin)
    {
        if ($row['wr_comment_reply'])
        {
            $tmp_comment_reply = substr($row['wr_comment_reply'], 0, strlen($row['wr_comment_reply']) - 1);
            if ($tmp_comment_reply == $list[$i-1]['wr_comment_reply'])
            {
                $list[$i-1]['is_edit'] = false;
                $list[$i-1]['is_del'] = false;
            }
        }
    }
}

//  코멘트수 제한 설정값
if ($is_admin)
{
    $comment_min = $comment_max = 0;
}
else
{
    $comment_min = (int)$board['bo_comment_min'];
    $comment_max = (int)$board['bo_comment_max'];
}

// APMS
$comment_login_url = G5_HTTP_BBS_URL.'/login.php?wr_id='.$wr_id.$qstr.'&amp;url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr);
$comment_action_url = https_url(G5_BBS_DIR)."/write_comment_update.php";

include_once($board_skin_path.'/view_comment.skin.php');

if (!$member['mb_id']) // 비회원일 경우에만
    echo '<script src="'.G5_JS_URL.'/md5.js"></script>'."\n";

@include_once($board_skin_path.'/view_comment.tail.skin.php');
?>