<?php
include_once('../../../_common.php');

if ($sw == 'move') {
	$act = $eyoom['theme_lang_type']=='m' ? $lang_theme[685] : '이동';
} else if ($sw == 'copy') {
	$act = $eyoom['theme_lang_type']=='m' ? $lang_theme[684] : '복사';
} else {
	if($eyoom['theme_lang_type']=='m') {
		alert("{$lang_theme[59]}");
	} else {
		alert('sw 값이 제대로 넘어오지 않았습니다.');
	}
}

// 게시판 관리자 이상 복사, 이동 가능
if ($is_admin != 'board' && $is_admin != 'group' && $is_admin != 'super') {
	if($eyoom['theme_lang_type']=='m') {
		alert_close("{$lang_theme[88]}");
	} else {
		alert_close("게시판 관리자 이상 접근이 가능합니다.");
	}
}

if($eyoom['theme_lang_type']=='m') {
	$tit_prev = $lang_theme[1077];
	$now = 'Now';
} else {
	$tit_prev = '게시물';
	$now = '현재';
}

$g5['title'] = $tit_prev . ' ' . $act;
include_once(G5_PATH.'/head.sub.php');

$wr_id_list = '';
if ($wr_id)
	$wr_id_list = $wr_id;
else {
	$comma = '';
	for ($i=0; $i<count($_POST['chk_wr_id']); $i++) {
		$wr_id_list .= $comma . $_POST['chk_wr_id'][$i];
		$comma = ',';
	}
}

//$sql = " select * from {$g5['board_table']} a, {$g5['group_table']} b where a.gr_id = b.gr_id and bo_table <> '$bo_table' ";
// 원본 게시판을 선택 할 수 있도록 함.
$sql = " select * from {$g5['board_table']} a, {$g5['group_table']} b where a.gr_id = b.gr_id ";
if ($is_admin == 'group')
	$sql .= " and b.gr_admin = '{$member['mb_id']}' ";
else if ($is_admin == 'board')
	$sql .= " and a.bo_admin = '{$member['mb_id']}' ";
$sql .= " order by a.gr_id, a.bo_order, a.bo_table ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
	$atc_mark = '';
	$atc_bg = '';
	if ($row['bo_table'] == $bo_table) { // 게시물이 현재 속해 있는 게시판이라면
		$row['atc_mark'] = '<span class="copymove_current">'.$now.'<span class="sound_only">게시판</span></span>';
		$row['atc_bg'] = 'copymove_currentbg';
	}
	$list[$i] = $row;
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/board/move.skin.php');

// Template define
$tpl->define_template('board',$eyoom_board['bo_skin'],'move.skin.html');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);