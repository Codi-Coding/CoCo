<?php
if (!$board['bo_table']) {
	echo '존재하지 않는 게시판입니다.';
	exit;
}

check_device($board['bo_device']);

if (!$bo_table) {
	echo 'bo_table 값이 넘어오지 않았습니다.';
	exit;
}

if (!$write['wr_id']) {
	echo '글이 존재하지 않습니다. 글이 삭제되었거나 이동된 경우입니다.';
	exit;
}

// 그룹접근 사용
if (isset($group['gr_use_access']) && $group['gr_use_access']) {
	if ($is_guest) {
		echo '비회원은 이 게시판에 접근할 권한이 없습니다.';
		exit;
	}

	// 그룹관리자 이상이라면 통과
	if ($is_admin == "super" || $is_admin == "group") {
		;
	} else {
		// 그룹접근
		$sql = " select count(*) as cnt from {$g5['group_member_table']} where gr_id = '{$board['gr_id']}' and mb_id = '{$member['mb_id']}' ";
		$row = sql_fetch($sql);
		if (!$row['cnt']) {
			echo '접근 권한이 없으므로 글읽기가 불가합니다.';
			exit;
		}
	}
}

// 로그인된 회원의 권한이 설정된 읽기 권한보다 작다면
if ($member['mb_level'] < $board['bo_read_level']) {
	echo '글을 읽을 권한이 없습니다.';
	exit;
}

// 본인확인을 사용한다면
if ($config['cf_cert_use'] && !$is_admin) {
	// 인증된 회원만 가능
	if ($board['bo_use_cert'] != '' && $is_guest) {
		echo '본인확인 하신 회원님만 글읽기가 가능합니다.';	
		exit;
	}

	if ($board['bo_use_cert'] == 'cert' && !$member['mb_certify']) {
		echo '본인확인 하신 회원님만 글읽기가 가능합니다.';	
		exit;
	}

	if ($board['bo_use_cert'] == 'adult' && !$member['mb_adult']) {
		echo '본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.';
		exit;
	}

	if ($board['bo_use_cert'] == 'hp-cert' && $member['mb_certify'] != 'hp') {
		echo '휴대폰 본인확인 하신 회원님만 글읽기가 가능합니다.';
		exit;
	}

	if ($board['bo_use_cert'] == 'hp-adult' && (!$member['mb_adult'] || $member['mb_certify'] != 'hp')) {
		echo '휴대폰 본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.';
		exit;
	}
}

// 자신의 글이거나 관리자라면 통과
if (($write['mb_id'] && $write['mb_id'] == $member['mb_id']) || $is_admin) {
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
			if ($row['mb_id'] == $member['mb_id'])
				$is_owner = true;
		}

		$ss_name = 'ss_secret_'.$bo_table.'_'.$write['wr_num'];

		if (!$is_owner)	{
			//$ss_name = "ss_secret_{$bo_table}_{$wr_id}";
			// 한번 읽은 게시물의 번호는 세션에 저장되어 있고 같은 게시물을 읽을 경우는 다시 비밀번호를 묻지 않습니다.
			// 이 게시물이 저장된 게시물이 아니면서 관리자가 아니라면
			//if ("$bo_table|$write['wr_num']" != get_session("ss_secret"))
			if (!get_session($ss_name)) {
				echo '비밀글은 본인과 관리자만 볼 수 있습니다.';
				exit;
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
$cbest = array();
$cbid = array();
$is_best_cmt = false;
if(isset($board['as_best_cmt']) && $board['as_best_cmt'] > 0) {

	$cbrows = (isset($board['as_rank_cmt']) && $board['as_rank_cmt'] > 0) ? $board['as_rank_cmt'] : 3;	

	// 비밀글, 블라인드글은 제외
	$result = sql_query(" select * from {$write_table} where wr_parent = '{$wr_id}' and wr_is_comment = 1 and wr_good >= '{$board['as_best_cmt']}' and as_shingo >= '0' and wr_option not like '%secret%' order by wr_good desc, wr_id desc limit 0, $cbrows ", false);
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$cbest[$i] = $row;

		$cbwrid = $row['wr_id'];
		$cbid[$cbwrid] = $i + 1;

		$tmp_name = get_text(cut_str($row['wr_name'], $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
		if ($board['bo_use_sideview']) {
			$lvl = ($board['as_level']) ? 'yes' : 'no';
			$cbest[$i]['name'] = apms_sideview($row['mb_id'], $tmp_name, $row['wr_email'], $row['wr_homepage'], $row['as_level'], $lvl); // APMS 용으로 교체
		} else {
			$cbest[$i]['name'] = '<span class="'.($row['mb_id']?'member':'guest').'">'.$tmp_name.'</span>';
		}

		$cbest[$i]['reply_name'] = ($row['wr_comment_reply'] && $row['as_re_name']) ? $row['as_re_name'] : '';

		$chtml = 0;
		if (strstr($row['wr_option'], 'html1'))
			$chtml = 1;
		else if (strstr($row['wr_option'], 'html2'))
			$chtml = 2;

		$cbest[$i]['content'] = conv_content($row['wr_content'], $chtml, 'wr_content');
		$cbest[$i]['content'] = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<a href=\"".G5_BBS_URL."/view_img.php?img=$1://$2.$3\" target=\"_blank\" onclick=\"apms_image(this.href); return false;\"><img src=\"$1://$2.$3\" alt=\"\" style=\"max-width:100%;border:0;\"></a>", $cbest[$i]['content']);
		$cbest[$i]['content'] = apms_content($cbest[$i]['content']);

		//럭키포인트
		if($row['as_lucky']) {
			$best[$i]['content'] = $cbest[$i]['content'].''.str_replace("[point]", number_format($row['as_lucky']), APMS_LUCKY_TEXT);
		}

		// 글정리
		$cbest[$i]['date'] = strtotime($cbest[$i]['wr_datetime']);
		$cbest[$i]['datetime'] = substr($cbest['wr_datetime'],2,14);

		// 관리자가 아니라면 중간 IP 주소를 감춘후 보여줍니다.
		$cbest[$i]['ip'] = $cbest['wr_ip'];
		if (!$is_admin)
			$cbest[$i]['ip'] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['wr_ip']);

	}

	if($i) $is_best_cmt = true;
}

// 신고
$is_shingo = ($board['as_shingo'] > 0) ? true : false;

// 댓글역순 출력
$is_rev_cmt = ($board['as_rev_cmt']) ? 'desc' : '';

// 코멘트 출력
$list = array();
$sql_comment = '';
$sql_comment_orderby = '';

@include_once($board_skin_path.'/view_comment.sql.skin.php');

$sql_common = "from {$write_table} where wr_parent = '{$wr_id}' and wr_is_comment = 1 $sql_comment";

if(isset($crows) && $crows > 0) {
	$sql = " select count(*) as cnt " . $sql_common;
	$row = sql_fetch($sql);
	$total_count = $row['cnt'];

	$total_page  = ceil($total_count / $crows);  // 전체 페이지 계산
	if($page > 0) {
		;
	} else {
		$page = 1; // 페이지가 없으면 마지막 페이지
	}
	$from_record = ($page - 1) * $crows; // 시작 열을 구함
	if($from_record < 0)
		$from_record = 0;

	$sql = " select * $sql_common order by $sql_comment_orderby wr_comment $is_rev_cmt, wr_comment_reply limit $from_record, $crows ";
} else {
	$sql = " select * $sql_common order by $sql_comment_orderby wr_comment $is_rev_cmt, wr_comment_reply ";
}
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $list[$i] = $row;
	$list[$i]['name'] = get_text(cut_str($row['wr_name'], $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
	$list[$i]['is_lock'] = ($row['as_shingo'] < 0) ? true : false;
	$list[$i]['reply_name'] = ($row['wr_comment_reply'] && $row['as_re_name']) ? $row['as_re_name'] : '';

	// APMS -------->
	$shingo_txt = '';
	$is_content = $is_secret = $is_cmt_shingo = false;
    $list[$i]['content'] = $list[$i]['content1']= '비밀댓글 입니다.';
	if($row['as_shingo'] < 0) {
		$shingo_txt = '<p><b>블라인더 처리된 댓글입니다.</b></p>';
		if($is_admin || ($row['mb_id'] && $row['mb_id'] == $member['mb_id'])) {
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
        ($write['mb_id'] && $write['mb_id'] == $member['mb_id']) ||
        ($row['mb_id'] && $row['mb_id'] == $member['mb_id'])) {

		if($is_cmt_shingo) {
			$list[$i]['content1'] = '블라인더 처리된 댓글입니다'; 
			$list[$i]['content'] = '';
		} else {
			$list[$i]['content1'] = $row['wr_content'];
		    $list[$i]['content'] = conv_content($row['wr_content'], $chtml, 'wr_content');
			$is_content = true;
		}
	} else {
        $ss_name = 'ss_secret_comment_'.$bo_table.'_'.$list[$i]['wr_id'];

		// APMS : 대댓글의 비밀글을 원댓글쓴이에게도 보이기
		$is_pre_commenter = false;
		if($row['wr_comment_reply'] && $member['mb_id']) {
			$pre_comment = sql_fetch(" select mb_id from {$write_table} where wr_parent = '$wr_id' and wr_is_comment = 1 and wr_comment = '{$row['wr_comment']}' and wr_comment_reply = '".substr($row['wr_comment_reply'],0,-1)."' "); 
			if($pre_comment['mb_id'] && $pre_comment['mb_id'] == $member['mb_id']) 
				$is_pre_commenter = true;
		}		

        if(get_session($ss_name) || $is_pre_commenter) {
			if($is_cmt_shingo) {
				$list[$i]['content'] = '';
			} else {
				$list[$i]['content'] = conv_content($row['wr_content'], $chtml, 'wr_content');
				$is_content = true;
			}
		} else {
            $list[$i]['content'] = '<a href="./password.php?w=sc&amp;bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].$qstr.'" class="s_cmt">댓글내용 확인</a>';
			$is_secret = true;
        }
    }

	if($is_content) {
		$list[$i]['content'] = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<a href=\"".G5_BBS_URL."/view_img.php?img=$1://$2.$3\" target=\"_blank\" class=\"item_image\"><img src=\"$1://$2.$3\" alt=\"\" style=\"max-width:100%;border:0;\"></a>", $list[$i]['content']);
		$list[$i]['content'] = apms_content($list[$i]['content']);

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
	$list[$i]['href'] = G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'#c_'.$list[$i]['wr_id'];

	// 베스트
	$cbwrid = $row['wr_id'];
	$list[$i]['best'] = $cbid[$cbwrid];

    // 관리자가 아니라면 중간 IP 주소를 감춘후 보여줍니다.
    $list[$i]['ip'] = $row['wr_ip'];
    if (!$is_admin)
        $list[$i]['ip'] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['wr_ip']);
}

?>