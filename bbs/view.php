<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($board['as_code']) {
	apms_script('code');
}

// 게시판에서 두단어 이상 검색 후 검색된 게시물에 코멘트를 남기면 나오던 오류 수정
$sop = strtolower($sop);
if ($sop != 'and' && $sop != 'or')
    $sop = 'and';

@include_once($board_skin_path.'/view.head.skin.php');

$sql_search = "";
// 검색이면
if ($sca || $stx || $stx === '0') {
    // where 문을 얻음
    $sql_search = get_sql_search($sca, $sfl, $stx, $sop);
    $search_href = './board.php?bo_table='.$bo_table.'&amp;page='.$page.$qstr;
    $list_href = './board.php?bo_table='.$bo_table;
} else {
    $search_href = '';
    $list_href = './board.php?bo_table='.$bo_table.'&amp;page='.$page;
}

if (!$board['bo_use_list_view']) {
    if ($sql_search)
        $sql_search = " and " . $sql_search;

    // 윗글을 얻음
    $sql = " select wr_id, wr_subject, wr_comment, wr_datetime from {$write_table} where wr_is_comment = 0 and wr_num = '{$write['wr_num']}' and wr_reply < '{$write['wr_reply']}' {$sql_search} order by wr_num desc, wr_reply desc limit 1 ";
    $prev = sql_fetch($sql);
    // 위의 쿼리문으로 값을 얻지 못했다면
    if (!$prev['wr_id'])     {
        $sql = " select wr_id, wr_subject, wr_comment, wr_datetime from {$write_table} where wr_is_comment = 0 and wr_num < '{$write['wr_num']}' {$sql_search} order by wr_num desc, wr_reply desc limit 1 ";
        $prev = sql_fetch($sql);
    }

    // 아래글을 얻음
    $sql = " select wr_id, wr_subject, wr_comment, wr_datetime from {$write_table} where wr_is_comment = 0 and wr_num = '{$write['wr_num']}' and wr_reply > '{$write['wr_reply']}' {$sql_search} order by wr_num, wr_reply limit 1 ";
    $next = sql_fetch($sql);
    // 위의 쿼리문으로 값을 얻지 못했다면
    if (!$next['wr_id']) {
        $sql = " select wr_id, wr_subject, wr_comment, wr_datetime from {$write_table} where wr_is_comment = 0 and wr_num > '{$write['wr_num']}' {$sql_search} order by wr_num, wr_reply limit 1 ";
        $next = sql_fetch($sql);
    }
}

// 이전글 링크
$prev_href = '';
if (isset($prev['wr_id']) && $prev['wr_id']) {
    $prev_wr_subject = get_text(cut_str($prev['wr_subject'], 255));
    $prev_wr_comment = $prev['wr_comment'];
    $prev_wr_date = $prev['wr_datetime'];
	$prev_href = './board.php?bo_table='.$bo_table.'&amp;wr_id='.$prev['wr_id'].$qstr;
}

// 다음글 링크
$next_href = '';
if (isset($next['wr_id']) && $next['wr_id']) {
    $next_wr_subject = get_text(cut_str($next['wr_subject'], 255));
    $next_wr_comment = $next['wr_comment'];
    $next_wr_date = $next['wr_datetime'];
    $next_href = './board.php?bo_table='.$bo_table.'&amp;wr_id='.$next['wr_id'].$qstr;
}

// 쓰기 링크
$write_href = '';
if ($member['mb_level'] >= $board['bo_write_level'])
    $write_href = './write.php?bo_table='.$bo_table;

// 답변 링크
$reply_href = '';
if ($member['mb_level'] >= $board['bo_reply_level'])
    $reply_href = './write.php?w=r&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr;

// 수정, 삭제 링크
$update_href = $delete_href = '';
// 로그인중이고 자신의 글이라면 또는 관리자라면 비밀번호를 묻지 않고 바로 수정, 삭제 가능
if (($member['mb_id'] && ($member['mb_id'] === $write['mb_id'])) || $is_admin) {
    $update_href = './write.php?w=u&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;page='.$page.$qstr;
    set_session('ss_delete_token', $token = uniqid(time()));
    $delete_href ='./delete.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;token='.$token.'&amp;page='.$page.urldecode($qstr);
}
else if (!$write['mb_id']) { // 회원이 쓴 글이 아니라면
    $update_href = './password.php?w=u&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;page='.$page.$qstr;
    $delete_href = './password.php?w=d&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;page='.$page.$qstr;
}

// 최고, 그룹관리자라면 글 복사, 이동 가능
$copy_href = $move_href = '';
if ($write['wr_reply'] == '' && ($is_admin == 'super' || $is_admin == 'group')) {
    $copy_href = './move.php?sw=copy&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;page='.$page.$qstr;
    $move_href = './move.php?sw=move&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;page='.$page.$qstr;
}

//$scrap_href = '';
$good_href = '';
$nogood_href = '';
//if ($is_member) {
    // 스크랩 링크
    $scrap_href = ($is_member) ? './scrap_popin.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id : '';

    // 추천 링크
    if ($board['bo_use_good'])
        $good_href = './good.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;good=good';

    // 비추천 링크
    if ($board['bo_use_nogood'])
        $nogood_href = './good.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;good=nogood';
//}

$view = get_view($write, $board, $board_skin_path);

if (strstr($sfl, 'subject'))
    $view['subject'] = search_font($stx, $view['subject']);

$html = 0;
if (strstr($view['wr_option'], 'html1'))
    $html = 1;
else if (strstr($view['wr_option'], 'html2'))
    $html = 2;

$is_torrent = false;
$is_view_shingo = false;
$shingo_txt = '';
if($view['as_shingo'] < 0) {
	$shingo_txt = '<p><b>'.$aslang['wr_lock'].'</b></p>'; //블라인더 처리된 글입니다.
	if($is_admin || ($view['mb_id'] && $view['mb_id'] == $member['mb_id'])) {
		; // 관리자 또는 글쓴이는 통과
	} else {
		$is_view_shingo = true;
		$view['content'] = $view['wr_content'] = ''; // 글내용 지움
		if(!$is_admin) 
			unset($view['file']); //첨부도 다 날림

	}
}

if(!$is_view_shingo) {
	$view['content'] = conv_content($view['wr_content'], $html, $board['as_purifier'] ? false : true);
	if (strstr($sfl, 'content'))
		$view['content'] = search_font($stx, $view['content']);

	// APMS 글내용 컨버터
	$exceptfile = array();
	$autoplay = '';
	if($board['as_autoplay'] && $view['file']['count']) { //첨부동영상 오디오 자동실행

		$autoplay_ext = array("mp4", "m4v", "f4v", "mov", "flv", "webm", "acc", "m4a", "f4a", "mp3", "ogg", "oga", "rss");

		for ($i=0; $i<count($view['file']); $i++) {
			if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
				$file = apms_get_filename($view['file'][$i]['source']);
				if(in_array($file['ext'], $autoplay_ext)) {
					list($screen, $caption, $exceptnum) = apms_get_caption($view['file'], $file['name'], $i);
					$jw_title = ($view['file'][$i]['content']) ? $view['file'][$i]['content'] : $view['file'][$i]['source'];
					$autoplay .= apms_jwplayer($view['file'][$i]['path'].'/'.$view['file'][$i]['file'], $screen, $caption, $jw_title);
					if(count($exceptnum) > 0) $exceptfile = array_merge($exceptfile, $exceptnum);
				}
			}
		}

		if(count($exceptfile)) { // 동영상 이미지는 출력이미지에서 제외
			$refile = array();
			$j = 0;
			for ($i=0; $i<count($view['file']); $i++) {

				if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && $view['file'][$i]['view']) continue;

				if (in_array($i, $exceptfile)) continue;

				$refile['file'][$j] = $view['file'][$i];
				$j++;
			}

			if($j > 0) {
				$view['file'] = $refile['file'];
				$view['file']['count'] = $j;
			}
		}
	}

	$view['content'] = apms_content($view['content']);
	if($is_link_video) {
		$view['content'] = $autoplay.apms_link_video($view['link'], '', $seometa['img']['src']).$view['content'];
	} else {
		$view['content'] = $autoplay.$view['content'];
	}

	//$view['rich_content'] = preg_replace("/{이미지\:([0-9]+)[:]?([^}]*)}/ie", "view_image(\$view, '\\1', '\\2')", $view['content']);
	if($view['as_img'] == "2") { // 본문삽입
		function conv_rich_content($matches){
			global $view;
			return view_image($view, $matches[2], $matches[3]);
		}

		$view['content'] = preg_replace_callback("/{(이미지|img)\:([0-9]+)[:]?([^}]*)}/i", "conv_rich_content", $view['content']);
	}

	// 토렌트
	if($board['as_torrent'] && $view['file']['count']) { //첨부파일에서 토렌트 시드추출
		$torrent = apms_get_torrent($view['file'], G5_DATA_PATH.'/file/'.$bo_table);
		if(count($torrent) > 0)
			$is_torrent = true;
	}
}

$view['content'] = $shingo_txt.$view['content'];

// 글쓴이
$author = array();
$is_signature = false;
$signature = '';
if($view['mb_id']) {
	$lvl = ($board['as_level']) ? 'yes' : 'no';
	$author = apms_member($view['mb_id'], $lvl, $board['bo_use_name']);
	if($author['mb_id']) {
		if(!$author['mb_open']) {
			$author['mb_email'] = '';
			$author['mb_homepage'] = '';
		}
		if ($board['bo_use_signature']) {
			$is_signature = true;
			$signature = apms_content(conv_content($author['mb_signature'], 1));
		}
	}
}

if($is_signature) {
	$view['photo'] = $author['photo'];
} else {
	$view['photo'] = apms_photo_url($view['mb_id']);
}

// 신고
$is_shingo = ($board['as_shingo'] > 0) ? true : false;

// Tag
$is_tag = false;
if($view['as_tag']) {
	$tag_list = apms_get_tag($view['as_tag']);
	if($tag_list) $is_tag = true;
}

// 이미지 위치
$is_img_head = ($view['as_img']) ? false : true; // 상단
$is_img_tail = ($view['as_img'] == "1") ? true : false; // 하단

// 페이지 댓글용
$is_view_comment = true;
$is_list_page = $page;
$page = '';

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
		//$cbest[$i]['content'] = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<a href=\"".G5_BBS_URL."/view_img.php?img=$1://$2.$3\" target=\"_blank\" class=\"item_image\"><img src=\"$1://$2.$3\" alt=\"\" style=\"max-width:100%;border:0;\"></a>", $cbest[$i]['content']);
		$cbest[$i]['content'] = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src=\"$1://$2.$3\" alt=\"\">", $cbest[$i]['content']);

		$cbest[$i]['content'] = apms_content(get_view_thumbnail($cbest[$i]['content']));

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

include_once($board_skin_path.'/view.skin.php');

@include_once($board_skin_path.'/view.tail.skin.php');

$page = $is_list_page;

?>