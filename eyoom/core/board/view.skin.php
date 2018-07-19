<?php
if (!defined('_GNUBOARD_')) exit;

include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

// 글쓴이 정보를 가져옴
if ($view['mb_id']) {
	if(!$mb) $mb = get_member($view['mb_id']);
	$user = $eb->get_user_info($mb['mb_id'])+$mb;
	$lvuser = $eb->user_level_info($user);
}

// wr_4 unserialize
$wr_4 = unserialize($view['wr_4']);
if(!$wr_4) $wr_4 = array();

// 신고처리 정보
if($eyoom_board['bo_use_yellow_card'] == '1') {
	$mb_ycard = $eb->mb_yellow_card($member['mb_id'],$bo_table, $wr_id);
	$ycard = $wr_4;
	if($ycard['yc_blind'] == 'y') {
		if(!$is_admin && $member['mb_level'] < $eyoom_board['bo_blind_view']) {
			if(!$mb_ycard['mb_id']) {
				alert('이 게시물은 블라인드 처리된 게시물입니다.');
				exit;
			}
		}
	}
	
	// 바로 블라인드 처리할 수 있는 권한인지 체크
	if($is_admin || $member['mb_level'] >= $eyoom_board['bo_blind_direct'] ) {
		$blind_direct = true;
	}
}

// 별점기능 사용여부
if($eyoom_board['bo_use_rating'] == '1') {
	$mb_rating = $eb->mb_rating($member['mb_id'],$bo_table, $wr_id);
	$rating = $eb->get_star_rating($wr_4);
}

// 채택게시판
if (preg_match('/adopt/i',$eyoom_board['bo_skin'])) {
	$adopt_cmt_id = $wr_4['adopt_cmt_id'];
	$adopt_point = $wr_4['adopt_point'];
	
	if ($eyoom_board['bo_use_adopt_point'] == '1' && $eyoom_board['bo_adopt_ratio'] > 0) {
		$real_adopt_point = ceil($adopt_point*(1-($eyoom_board['bo_adopt_ratio']/100)));
		$return_adopt_point = $adopt_point - $real_adopt_point;
	}
	
	$is_adoptable = false;
	if (!$adopt_cmt_id && (($is_member && $member['mb_id'] == $view['mb_id']) || $is_admin)) {
		$is_adoptable = true;
	}
}

// 읽는사람 포인트 주기 및 이윰뉴 테이블의 히트수/댓글수 일치 시키기
$spv_name = 'spv_board_'.$bo_table.'_'.$wr_id;
if (!get_session($spv_name)) {
	if($is_member) $eb->level_point($levelset['read']);
    set_session($spv_name, TRUE);

	// 이윰뉴 테이블에 wr_hit 적용
	$where = "wr_id = '{$wr_id}' ";
	$parent = sql_fetch("select wr_hit, wr_comment from {$write_table} where $where");
	sql_query("update {$g5['eyoom_new']} set wr_hit = '{$parent['wr_hit']}', wr_comment = '{$parent['wr_comment']}' where $where and bo_table='{$bo_table}'");
	sql_query("update {$g5['eyoom_tag_write']} set wr_hit = '{$parent['wr_hit']}' where $where and bo_table='{$bo_table}' and tw_theme='{$theme}'");
}

// 짤은주소 체크 및 생성
if(!($short_url = $eb->get_short_url())) {
	$short_url = $eb->make_short_url();
}

// 첨부파일 정보 가져오기
if ($view['file']['count']) {
	$cnt = 0;
	for ($i=0; $i<count($view['file']); $i++) {
		if (isset($view['file'][$i]['source']) && $view['file'][$i]['source']) {
			$view_file[$cnt] = $view['file'][$i];
			$cnt++;
		}
	}
}

// 링크 정보 가져오기
$i=1;
foreach($view['link'] as $k => $v) {
	if(!$v) break;
	$view_link[$i]['link']	= cut_str($view['link'][$i], 70);
	$view_link[$i]['href']	= $view['link_href'][$i];
	$view_link[$i]['hit']	= $view['link_hit'][$i];
	$i++;
}

// 파일 출력
$v_img_count = count($view['file']);
if($v_img_count) {
	$file_conts = "<div id=\"bo_v_img\">\n";

	for ($i=0; $i<=count($view['file']); $i++) {
		if ($view['file'][$i]['view']) {
			unset($thumbnail, $matches);

			$thumbnail = $eb->get_thumbnail($view['file'][$i]['view']);
			$file_conts .= $thumbnail;		
			preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $thumbnail, $matches);

			$file_url[$i]['source'] = $view['file'][$i]['path'] . '/' . $view['file'][$i]['file'];
			$file_url[$i]['content'] = $view['file'][$i]['content'];
			$file_url[$i]['thumb'] = $matches[1][0];
		}
	}
	$file_conts .= "</div>\n";
}
$view_content = $eb->eyoom_content($view['content'], $bo_table, $wr_id);

// 작성자 레벨정보 가져오기	
if($view['wr_1']) {
	$lv = $eb->level_info($view['wr_1']);
	if ($levelset['use_eyoom_level'] != 'n') {
		$lv['eyoom_icon'] = '';
	}
} else {
	$lv['gnu_level'] = '';
	$lv['gnu_icon'] = '';
	$lv['eyoom_icon'] = '';
	$lv['gnu_name'] = '';
	$lv['name'] = '';
}

// 익명글 기능
if(!$lv['anonymous']) {
	// 작성자 프로필 사진
	$view['mb_photo'] = $eb->mb_photo($view['mb_id']);
} else {
	$view['mb_photo'] = '';
	$view['mb_id'] = 'anonymous';
	$view['wr_name'] = '익명';
	$view['wr_email'] = '';
	$view['wr_homepage'] = '';
}

// 추천/비추천
if($member['mb_id']) {
	$goodinfo = $eb->mb_goodinfo($member['mb_id'],$bo_table,$wr_id);
}

// sns 버튼들
if($board['bo_use_sns']) {
	$sns_msg = urlencode(str_replace('\"', '"', $view['subject']));

	$longurl = urlencode($short_url);
	$sns_send  = EYOOM_CORE_URL.'/board/sns_send.php?longurl='.$longurl;
	$sns_send .= '&amp;title='.$sns_msg;

	$facebook_url = $sns_send.'&amp;sns=facebook';
	$twitter_url  = $sns_send.'&amp;sns=twitter';
	$gplus_url    = $sns_send.'&amp;sns=gplus';
	$kakaostory_url   = $sns_send.'&amp;sns=kakaostory';
	$band_url   = $sns_send.'&amp;sns=band';
}

// Window Mode 사용시
if($wmode) {
	// 목록 출력을 강제로 막음
	$board['bo_use_list_view'] = 0;

	// 일반 버튼들 wmode 적용하기
	$add_query = '&wmode=1';
	$prev_href .= $prev_href ? $add_query:'';
	$next_href .= $next_href ? $add_query:'';
	$update_href .= $update_href ? $add_query:'';
	$delete_href .= $delete_href ? $add_query:'';
	$copy_href .= $copy_href ? $add_query:'';
	$move_href .= $move_href ? $add_query:'';
	$search_href .= $search_href ? $add_query:'';
	$reply_href .= $reply_href ? $add_query:'';
	$write_href .= $write_href ? $add_query:'';
}

// wr_1에 작성자의 레벨정보 입력
if($is_member) $wr_1 = $member['mb_level']."|".$eyoomer['level'];

// 태그 정보
if ($eyoom['use_tag'] == 'y' && $eyoom_board['bo_use_tag'] == '1') {
	$tag_info = $eb->get_tag_info($bo_table, $wr_id);
	if($tag_info['wr_tag']) {
		$wr_tags = explode(',', $tag_info['wr_tag']);
		$i=0;
		foreach($wr_tags as $key => $_tag) {
			$view_tags[$i]['tag'] = $_tag;
			$view_tags[$i]['href'] = G5_URL . '/tag/?tag=' . str_replace('&', '^', $_tag);
			$i++;
		}
	}
	if(isset($view_tags)) $tpl->assign('view_tags', $view_tags);
}

// 확장필드
if ($bo_extend) {
	foreach ($exbo as $ex_fname => $exinfo) {
		unset($ex_value);
		
		$ex_view[$ex_fname]['title'] = $exinfo['ex_subject'];
		switch ($exinfo['ex_form']) {
			case 'text':
			case 'radio':
			case 'select':
			    $ex_view[$ex_fname]['value'] = $view[$ex_fname];
				break;
			case 'checkbox':
				$ex_value = explode('^|^', $view[$ex_fname]);
				$ex_view[$ex_fname]['value'] = is_array($ex_value) ? implode(', ', $ex_value): $ex_value;
				break;
			case 'address':
				$ex_value = explode('^|^', $view[$ex_fname]);
				unset($ex_value[4]);
				$ex_view[$ex_fname]['value'] = $ex_view[$ex_fname]['address'] = is_array($ex_value) ? implode(' ', $ex_value): $ex_value;
				$ex_view[$ex_fname]['zip'] = $ex_value[0];
				$ex_view[$ex_fname]['addr1'] = $ex_value[1];
				$ex_view[$ex_fname]['addr2'] = $ex_value[2];
				$ex_view[$ex_fname]['addr3'] = $ex_value[3];
				break;
			case 'textarea':
				$ex_view[$ex_fname]['value'] = conv_content($view[$ex_fname], $html);
				break;
		}
	}
	
	$tpl->assign(array(
		'ex_view' => $ex_view,
	));
}

include_once(G5_BBS_PATH.'/view_comment.php');

$tpl->define(array(
	'cmt_pc'	=> 'skin_pc/board/' . $eyoom_board['bo_skin'] . '/view_comment.skin.html',
	'cmt_mo'	=> 'skin_mo/board/' . $eyoom_board['bo_skin'] . '/view_comment.skin.html',
	'cmt_bs'	=> 'skin_bs/board/' . $eyoom_board['bo_skin'] . '/view_comment.skin.html',
	'sns_pc'	=> 'skin_pc/board/' . $eyoom_board['bo_skin'] . '/sns.skin.html',
	'sns_mo'	=> 'skin_mo/board/' . $eyoom_board['bo_skin'] . '/sns.skin.html',
	'sns_bs'	=> 'skin_bs/board/' . $eyoom_board['bo_skin'] . '/sns.skin.html',
	'signature_pc'	=> 'skin_pc/signature/' . $eyoom['signature_skin'] . '/signature.skin.html',
	'signature_mo'	=> 'skin_mo/signature/' . $eyoom['signature_skin'] . '/signature.skin.html',
	'signature_bs'	=> 'skin_bs/signature/' . $eyoom['signature_skin'] . '/signature.skin.html',
));

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/board/view.skin.php');

// Template define
$tpl->define_template('board',$eyoom_board['bo_skin'],'view.skin.html');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);