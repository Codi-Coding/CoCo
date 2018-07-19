<?php
$sub_menu = "800200";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') alert('최고관리자만 접근 가능합니다.');

/**
 * 테마 환경설정 파일
 */
include_once(EYOOM_ADMIN_CORE_PATH . "/theme/eyoom_theme.php");

$action_url = EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=board_list_update&amp;smode=1';

/**
 * 이윰게시판 설정에서 쇼핑몰 스킨사용체크 필드 추가
 */
if(!sql_query(" select use_shop_skin from {$g5['eyoom_board']} limit 1 ", false)) {
	$sql = " alter table `{$g5['eyoom_board']}` add `use_shop_skin` enum('y','n') NOT NULL default 'n' after `use_gnu_skin` ";
	sql_query($sql, true);
}

/**
 * 채택게시판 설정 필드 추가
 */
if(!sql_query(" select bo_use_adopt_point from {$g5['eyoom_board']} limit 1 ", false)) {
	$sql = " alter table `{$g5['eyoom_board']}`
		add `bo_use_adopt_point` char(1) NOT NULL default '' after `bo_use_extimg`,
		add `bo_adopt_minpoint` int(7) NOT NULL default '0' after `bo_use_adopt_point`,
		add `bo_adopt_maxpoint` int(11) NOT NULL default '0' after `bo_adopt_minpoint`,
		add `bo_adopt_ratio` smallint(3) NOT NULL default '0' after `bo_adopt_maxpoint`
	";
	sql_query($sql, true);
}

/**
 * 회원당 하루 게시물 작성회수 설정 필드 추가
 */
if(!sql_query(" select bo_write_limit from {$g5['eyoom_board']} limit 1 ", false)) {
	$sql = " alter table `{$g5['eyoom_board']}`
		add `bo_write_limit` smallint(3) NOT NULL default '0' after `bo_adopt_ratio`
	";
	sql_query($sql, true);
}

/**
 * 게시판 정보 가져오기
 */
$sql_common = " from {$g5['board_table']} as a left join {$g5['group_table']} as b on a.gr_id = b.gr_id ";
$sql_search = " where (1) ";
$sql_order = " order by a.gr_id, a.bo_table asc ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "bo_table" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.gr_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "a.gr_id, a.bo_table";
    $sod = "asc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);
$bo_table = array();

/**
 * 해당 게시판의 스킨정보
 */
$arr = $eb->get_skin_dir('board',EYOOM_THEME_PATH.'/'.$this_theme.'/skin_'.$_tpl_name);

for($i=0; $bbs=sql_fetch_array($result); $i++) {
	
	/**
	 * 이윰 게시판 테이블에 게시판 정보가 있는지 체크
	 */
	$tmp = sql_fetch("select bo_table, bo_skin, use_gnu_skin, bo_write_limit from {$g5['eyoom_board']} where bo_table='{$bbs['bo_table']}' and bo_theme='{$this_theme}'",false);
	if(!$tmp['bo_table']) {
		sql_query("insert into {$g5['eyoom_board']} set bo_table='{$bbs['bo_table']}', gr_id='{$bbs['gr_id']}', bo_theme='{$this_theme}', bo_skin='basic', use_gnu_skin='n'");
	}

	$board_list[$i]['bo_table'] = $bo_table[$i] = $bbs['bo_table'];
	$board_list[$i]['gr_subject'] = $bbs['gr_subject'];
	$board_list[$i]['bo_subject'] = $bbs['bo_subject'];
	$board_list[$i]['bo_skin'] = $tmp['bo_skin'] ? $tmp['bo_skin']:'basic';
	$board_list[$i]['use_gnu_skin'] = $tmp['use_gnu_skin'] ? $tmp['use_gnu_skin']:'n';
	$board_list[$i]['bo_write_limit'] = $tmp['bo_write_limit'];
	
	if($arr) {
		$bo_skin_select = "<select name='bo_skin[$i]' id='bo_skin_{$i}' required>";
		for ($j=0; $j<count($arr); $j++) {
			if ($j == 0) $bo_skin_select .= "<option value=''>선택</option>";
			$skin_selected = str_replace('"', "'", get_selected($board_list[$i]['bo_skin'], $arr[$j]));
			$bo_skin_select .= "<option value='{$arr[$j]}'" . $skin_selected . ">".$arr[$j]."</option>";
		}
		$bo_skin_select .= '</select>';
	} else {
		$bo_skin_select = "없음";
	}
	
	$board_list[$i]['bo_skin_select'] = $bo_skin_select;
}

/*
 * Paging 
 */
$paging = $thema->pg_pages($tpl_name,"./?dir=theme&amp;pid=board_list&amp;thema={$this_theme}&amp;{$qstr}&amp;page=");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";

$atpl->assign(array(
	'board_list' => $board_list,
));