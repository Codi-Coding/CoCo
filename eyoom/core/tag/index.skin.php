<?php
if (!defined('_GNUBOARD_')) exit;
if (!defined('_TAG_')) exit;

if (!$tag) alert('잘못된 접근입니다.');
$tag = get_text($_GET['tag']);

/**
 * 이윰 헤더 디자인 출력
 */
@include_once(EYOOM_PATH.'/head.php');

/**
 * 연관태그 가져오기
 */
$tag_info = $eb->get_rel_tag($tag);
$rel_tags  = $tag_info['rel_tags'];

// 기본 쿼리
$sql_common = " from {$g5['eyoom_tag_write']} as a where (1) {$tag_info['tag_query']} ";

// 출력순서는 등록순으로
$sql_order = " order by tw_datetime desc ";

$sql = " select count(*) as cnt {$sql_common}";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$page = (int)$_GET['page'];
if(!$page) $page = 1;
if(!$page_rows) $page_rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

$sql = "select * {$sql_common} {$sql_order} limit {$from_record}, {$page_rows}";
$result = sql_query($sql);
for($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;

	if(preg_match('/secret/',$row['wr_option']) && (($is_member && !$is_admin && $member['mb_id']!=$row['mb_id']) || !$is_member)) {
		$list[$i]['wr_subject'] = '비밀글입니다.';
		$list[$i]['wr_content'] = '비밀글입니다.';
	} else {
		$list[$i]['wr_subject'] = conv_subject($row['wr_subject'], 100, '…');
		$list[$i]['wr_content'] = cut_str(stripcslashes($row['wr_content']), 300, '…');

		// 옵션으로 이미지 가져오기
		$latest->img_width = 500;
		$latest->img_height = 0;
		$list[$i]['image'] = $latest->latest_image($row,'n');

	}
	$list[$i]['href'] = G5_BBS_URL."/board.php?bo_table={$row['bo_table']}&amp;wr_id={$row['wr_id']}";
	
	$list[$i]['wr_hit'] = $row['wr_hit'];
	$list[$i]['datetime'] = $row['tw_datetime'];
	$wr_1 = $row['wr_1'];
	
	// new 표시
	if ($list[$i]['datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - (2 * 3600))) $list[$i]['new'] = true;
	
	// 레벨정보
	$level = $wr_1 ? $eb->level_info($wr_1):'';
	if(is_array($level)) {
		if(!$level['anonymous']) {
			$list[$i]['mb_photo'] = $eb->mb_photo($list[$i]['mb_id']);
		} else {
			$list[$i]['mb_photo'] = '';
			$list[$i]['mb_id'] = 'anonymous';
			$list[$i]['mb_nick'] = '익명';
			$list[$i]['email'] = '';
			$list[$i]['homepage'] = '';
			$list[$i]['gnu_level'] = '';
			$list[$i]['gnu_icon'] = '';
			$list[$i]['eyoom_icon'] = '';
			$list[$i]['lv_gnu_name'] = '';
			$list[$i]['lv_name'] = '';
		}
	}
	
	// 블라인드 처리
	$wr_4 = unserialize($list[$i]['wr_4']);
	if(!$wr_4) $wr_4 = array();
	if($wr_4['yc_blind'] == 'y') {
		$list[$i]['wr_subject'] = '이 게시물은 블라인드 처리된 글입니다.';
		$list[$i]['wr_content'] = '이 게시물은 블라인드 처리된 글입니다.';
	}
	
	// 게시물에 동영상이 있는지 결정
	$list[$i]['is_video'] = $wr_4['is_video'];
	
	// 별점기능
	$rating = $eb->get_star_rating($wr_4);
	$list[$i]['star'] = $rating['star'];
}

/**
 * 이윰 페이징
 */
$paging = $thema->pg_pages($tpl_name,"./?tag=".$tag."&amp;page=");

/**
 * 사용자 프로그램
 */
@include_once(EYOOM_USER_PATH.'/tag/index.skin.php');

/**
 * Template define
 */
$tpl->define_template('tag',$eyoom['tag_skin'],'index.skin.html');

/**
 * Template assign
 */
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->assign('rel_tags', $rel_tags);

/**
 * 템플릿 디자인 출력
 */
$tpl->print_($tpl_name);

/**
 * 이윰 테일 디자인 출력
 */
@include_once(EYOOM_PATH.'/tail.php');