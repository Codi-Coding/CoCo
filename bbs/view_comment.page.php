<?php
if (!defined('_GNUBOARD_')) {
	$is_view_comment = false;
	define('G5_CAPTCHA', true);
	include_once('./_common.php');
	include_once(G5_LIB_PATH.'/thumbnail.lib.php');

	if (!$board['bo_table']) {
	   apms_alert('1|존재하지 않는 게시판입니다.');
	}

	check_device($board['bo_device']);

	if (!$bo_table) {
		apms_alert("1|bo_table 값이 넘어오지 않았습니다.");
	}

	// wr_id 값이 있으면 글읽기
	if (isset($wr_id) && $wr_id) {
		// 글이 없을 경우 해당 게시판 목록으로 이동
		if (!$write['wr_id']) {
			apms_alert('1|글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동된 경우입니다.');
		}

		// 그룹접근 사용
		if (isset($group['gr_use_access']) && $group['gr_use_access']) {
			if ($is_guest) {
				apms_alert('1|비회원은 이 게시판에 접근할 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.');
			}

			// 그룹관리자 이상이라면 통과
			if ($is_admin === "super" || $is_admin === "group") {
				;
			} else {
				// 그룹접근
				$sql = " select count(*) as cnt from {$g5['group_member_table']} where gr_id = '{$board['gr_id']}' and mb_id = '{$member['mb_id']}' ";
				$row = sql_fetch($sql);
				if (!$row['cnt']) {
					apms_alert('1|접근 권한이 없으므로 글읽기가 불가합니다.\\n\\n궁금하신 사항은 관리자에게 문의 바랍니다.');
				}
			}
		}

		// 로그인된 회원의 권한이 설정된 읽기 권한보다 작다면
		if ($member['mb_level'] < $board['bo_read_level']) {
			if ($is_member)
				apms_alert('1|글을 읽을 권한이 없습니다.');
			else
				apms_alert('1|글을 읽을 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.'); 
		}

		// 본인확인을 사용한다면
		if ($config['cf_cert_use'] && !$is_admin) {
			// 인증된 회원만 가능
			if ($board['bo_use_cert'] != '' && $is_guest) {
				apms_alert('1|이 게시판은 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.');
			}

			if ($board['bo_use_cert'] == 'cert' && !$member['mb_certify']) {
				apms_alert('1|이 게시판은 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원정보 수정에서 본인확인을 해주시기 바랍니다.');
			}

			if ($board['bo_use_cert'] == 'adult' && !$member['mb_adult']) {
				apms_alert('1|이 게시판은 본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.\\n\\n현재 성인인데 글읽기가 안된다면 회원정보 수정에서 본인확인을 다시 해주시기 바랍니다.');
			}

			if ($board['bo_use_cert'] == 'hp-cert' && $member['mb_certify'] != 'hp') {
				apms_alert('1|이 게시판은 휴대폰 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원정보 수정에서 휴대폰 본인확인을 해주시기 바랍니다.');
			}

			if ($board['bo_use_cert'] == 'hp-adult' && (!$member['mb_adult'] || $member['mb_certify'] != 'hp')) {
				apms_alert('1|이 게시판은 휴대폰 본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.\\n\\n현재 성인인데 글읽기가 안된다면 회원정보 수정에서 휴대폰 본인확인을 다시 해주시기 바랍니다.');
			}
		}

		// 자신의 글이거나 관리자라면 통과
		if (($write['mb_id'] && $write['mb_id'] === $member['mb_id']) || $is_admin) {
			;
		} else {
			// 비밀글이라면
			if (strstr($write['wr_option'], "secret")) {
				// 회원이 비밀글을 올리고 관리자가 답변글을 올렸을 경우
				// 회원이 관리자가 올린 답변글을 바로 볼 수 없던 오류를 수정
				$is_owner = false;
				if ($write['wr_reply'] && $member['mb_id'])	{
					$sql = " select mb_id from {$write_table}
								where wr_num = '{$write['wr_num']}'
								and wr_reply = ''
								and wr_is_comment = 0 ";
					$row = sql_fetch($sql);
					if ($row['mb_id'] === $member['mb_id'])
						$is_owner = true;
				}

				$ss_name = 'ss_secret_'.$bo_table.'_'.$write['wr_num'];

				if (!$is_owner)	{
					//$ss_name = "ss_secret_{$bo_table}_{$wr_id}";
					// 한번 읽은 게시물의 번호는 세션에 저장되어 있고 같은 게시물을 읽을 경우는 다시 비밀번호를 묻지 않습니다.
					// 이 게시물이 저장된 게시물이 아니면서 관리자가 아니라면
					//if ("$bo_table|$write['wr_num']" != get_session("ss_secret"))
					if (!get_session($ss_name))
						apms_alert('1|비밀글은 본인과 관리자만 볼 수 있습니다.');
				}
			}
		}
	}

	// IP
	$is_ip_view = $board['bo_use_ip_view'];
	if ($is_admin) {
		$is_ip_view = true;
	}

	// 보드설정
	$boset = array();
	$boset = apms_boset();

	// 베스트 댓글
	$cbid = array();
	if(isset($board['as_best_cmt']) && $board['as_best_cmt'] > 0) {

		$cbrows = (isset($board['as_rank_cmt']) && $board['as_rank_cmt'] > 0) ? $board['as_rank_cmt'] : 3;	

		// 비밀글, 블라인드글은 제외
		$result = sql_query(" select wr_id from {$write_table} where wr_parent = '{$wr_id}' and wr_is_comment = 1 and wr_good >= '{$board['as_best_cmt']}' and as_shingo >= '0' and wr_option not like '%secret%' order by wr_good desc, wr_id desc limit 0, $cbrows ", false);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$cbwrid = $row['wr_id'];
			$cbid[$cbwrid] = $i + 1;
		}
	}

}

// 신고
$is_shingo = ($board['as_shingo'] > 0) ? true : false;

include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

$captcha_html = "";
if ($is_guest && $board['bo_comment_level'] < 2) {
    $captcha_html = captcha_html('_comment');
}

if($is_view_comment) {
	@include_once($board_skin_path.'/view_comment.head.skin.php');
}

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

$sql_common = "from {$write_table} where wr_parent = '{$wr_id}' and wr_is_comment = 1 $sql_comment";

$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 댓글갯수
$crows = (isset($crows) && $crows) ? $crows : $board['as_comment_'.MOBILE_.'rows'];
$crows = ($crows > 0) ? $crows : 20;

$total_page  = ceil($total_count / $crows);  // 전체 페이지 계산
if($page > 0) {
	;
} else {
	$page = ($is_rev_cmt) ? 1 : $total_page; // 페이지가 없으면 마지막 페이지
}
$from_record = ($page - 1) * $crows; // 시작 열을 구함
if($from_record < 0)
	$from_record = 0;

//$sql = " select * from {$write_table} where wr_parent = '{$wr_id}' and wr_is_comment = 1 order by wr_comment desc, wr_comment_reply ";
$sql = " select * $sql_common order by $sql_comment_orderby wr_comment $is_rev_cmt, wr_comment_reply limit $from_record, $crows ";
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
				$list[$i]['del_href']  = './delete_comment.page.php?bo_table='.$bo_table.'&comment_id='.$row['wr_id'].'&token='.$token;
                $list[$i]['del_return']  = './view_comment.page.php?bo_table='.$bo_table.'&wr_id='.$wr_id.'&crows='.$crows.'&page='.$page;
				$list[$i]['del_link']  = './delete_comment.php?bo_table='.$bo_table.'&amp;comment_id='.$row['wr_id'].'&amp;token='.$token.'&amp;page='.$page.$qstr;
				$list[$i]['is_edit']   = true;
                $list[$i]['is_del']    = true;
            }
        }
        else
        {
            if (!$row['mb_id']) {
                $list[$i]['del_href']  = '';
                $list[$i]['del_return']  = '';
				$list[$i]['del_link'] = './password.php?w=x&amp;bo_table='.$bo_table.'&amp;comment_id='.$row['wr_id'].'&amp;page='.$is_list_page.$qstr;
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
$comment_url = G5_HTTP_BBS_URL.'/view_comment.page.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;crows='.$crows;
$comment_script_url = G5_HTTP_BBS_URL.'/view_comment.page.php?bo_table='.$bo_table.'&wr_id='.$wr_id.'&crows='.$crows;
$comment_action_url = https_url(G5_BBS_DIR).'/write_comment_update.page.php';
$comment_page = G5_HTTP_BBS_URL.'/view_comment.page.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;crows='.$crows.'&amp;page=';
$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];

if($w == '') $w = 'c';

if($is_view_comment) {
?>
	<script>
	// 글자수 제한
	var char_min = parseInt(<?php echo $comment_min ?>); // 최소
	var char_max = parseInt(<?php echo $comment_max ?>); // 최대
	</script>
<?php
}

include_once($board_skin_path.'/view_comment.page.skin.php');

if($is_view_comment) {
	if ($is_comment_write)  {
		include_once('./view_comment.page.script.php');
	}

	if (!$member['mb_id']) // 비회원일 경우에만
		echo '<script src="'.G5_JS_URL.'/md5.js"></script>'."\n";

	@include_once($board_skin_path.'/view_comment.tail.skin.php');
}

?>