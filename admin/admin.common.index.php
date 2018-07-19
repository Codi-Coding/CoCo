<?php
if (!defined('_EYOOM_IS_ADMIN_')) exit;

// 하루 일자 지정
$yesterday = date('Y-m-d', strtotime('-1day'));
$today = date('Y-m-d');

// 하루 방문자 통계
$last_vi_info = get_visit_info($yesterday);
$this_vi_info = get_visit_info($today);

// 시간별 방문자 및 회원가입
for($i=0; $i<24; $i++) {
	// 방문자
	$last_vi_count[$i] = $last_vi_info['vi_cnt'][$i] ? count($last_vi_info['vi_cnt'][$i]) : 0;
	$this_vi_count[$i] = $this_vi_info['vi_cnt'][$i] ? count($this_vi_info['vi_cnt'][$i]) : 0;

	// 회원가입
	$last_vi_regist[$i] = $last_vi_info['vi_regist'][$i] ? count($last_vi_info['vi_regist'][$i]) : 0;
	$this_vi_regist[$i] = $this_vi_info['vi_regist'][$i] ? count($this_vi_info['vi_regist'][$i]) : 0;
}

// 접속 브라우저
$last_vi_browser = $last_vi_info['vi_br'];
$this_vi_browser = $this_vi_info['vi_br'];

// 접속 디바이스
$last_vi_device = $last_vi_info['vi_dev'];
$this_vi_device = $this_vi_info['vi_dev'];

// 접속 OS
$last_vi_os = $last_vi_info['vi_os'];
$this_vi_os = $this_vi_info['vi_os'];

// 접속 도메인
$last_vi_domain = $last_vi_info['vi_domain'];
$this_vi_domain = $this_vi_info['vi_domain'];

// 새로 가입한 회원
if ($is_admin != 'super') $add_where = " and mb_level <= '{$member['mb_level']}' ";
$sql = " select * from {$g5['member_table']} where (1) and mb_id != '{$config['cf_admin']}' {$add_where} and mb_leave_date = '' order by mb_datetime desc limit 10 ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
	// 암호화 시스템 적용
	if(defined('__MSS_API_INCLUDED__')) {
	    if(!isset($mssapi)) $mssapi = new CMSSAPI;
	    if($mssapi->use_infoenc) {
	        $row = $mssapi->getInfoDecryptData($g5['member_table'], $row, $row['mb_no']);
	    }
	}

	$new_member[$i] = $row;
	$new_member[$i]['photo_url'] = mb_photo_url($row['mb_id']);
}

// 최근 게시물
$new_write_rows = 5;

$sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c where a.bo_table = b.bo_table and b.gr_id = c.gr_id ";

if ($gr_id)
    $sql_common .= " and b.gr_id = '$gr_id' ";
if ($view) {
    if ($view == 'w')
        $sql_common .= " and a.wr_id = a.wr_parent ";
    else if ($view == 'c')
        $sql_common .= " and a.wr_id <> a.wr_parent ";
}
$sql_order = " order by a.bn_id desc ";

$sql = " select a.*, b.bo_subject, c.gr_subject, c.gr_id {$sql_common} {$sql_order} limit {$new_write_rows} ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];

    if ($row['wr_id'] == $row['wr_parent']) { // 원글
        $comment = "";
        $comment_link = "";
        $row2 = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ");

        $name = $row2['wr_name'];
        // 당일인 경우 시간으로 표시함
        $datetime = substr($row2['wr_datetime'],0,10);
        $datetime2 = $row2['wr_datetime'];
        if ($datetime == G5_TIME_YMD)
            $datetime2 = substr($datetime2,11,5);
        else
            $datetime2 = substr($datetime2,5,5);

    } else { // 코멘트
        $comment = '댓글. ';
        $comment_link = '#c_'.$row['wr_id'];
        $row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ");
        $row3 = sql_fetch(" select mb_id, wr_name, wr_email, wr_homepage, wr_datetime from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");

        $name = $row3['wr_name'];
        // 당일인 경우 시간으로 표시함
        $datetime = substr($row3['wr_datetime'],0,10);
        $datetime2 = $row3['wr_datetime'];
        if ($datetime == G5_TIME_YMD)
            $datetime2 = substr($datetime2,11,5);
        else
            $datetime2 = substr($datetime2,5,5);
    }

    $new_post[$i]['gr_href']	= G5_BBS_URL . '/new.php?gr_id=' . $row['gr_id'];
    $new_post[$i]['group']		= cut_str($row['gr_subject'], 10);
    $new_post[$i]['bo_href']	= G5_BBS_URL . '/board.php?bo_table=' . $row['bo_table'];
    $new_post[$i]['board']		= cut_str($row['bo_subject'], 20);
    $new_post[$i]['view_url']	= G5_BBS_URL . '/board.php?bo_table=' . $row['bo_table'] . '&amp;wr_id=' . $row2['wr_id'] . $comment_link;
    $new_post[$i]['subject']	= $comment . conv_subject($row2['wr_subject'], 100);
    $new_post[$i]['name']		= $name;
    $new_post[$i]['datetime']	= $datetime;
}

// 최근 포인트 발생내역
$new_point_rows = 5;

$sql_common = " from {$g5['point_table']} ";
$sql_search = " where (1) ";
$sql_order = " order by po_id desc ";

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$new_point_rows} ";
$result = sql_query($sql);
$row2['mb_id'] = '';
for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($row2['mb_id'] != $row['mb_id']) {
        $sql2 = " select mb_no, mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
        $row2 = sql_fetch($sql2);
        
		// 암호화 시스템 적용
		if(defined('__MSS_API_INCLUDED__')) {
		    if(!isset($mssapi)) $mssapi = new CMSSAPI;
		    if($mssapi->use_infoenc) {
		        $row2 = $mssapi->getInfoDecryptData($g5['member_table'], $row2, $row2['mb_no']);
		    }
		}
    }

    $new_point[$i] = $row;
    $new_point[$i]['mb_name'] = get_text($row2['mb_name']);
    $new_point[$i]['mb_nick'] = $row2['mb_nick'];
}

$atpl->assign(array(
	'last_vi_count' 	=> $last_vi_count,
	'this_vi_count' 	=> $this_vi_count,
	'last_vi_regist' 	=> $last_vi_regist,
	'this_vi_regist' 	=> $this_vi_regist,
	'last_vi_browser' 	=> $last_vi_browser,
	'this_vi_browser' 	=> $this_vi_browser,
	'last_vi_device'	=> $last_vi_device,
	'this_vi_device'	=> $this_vi_device,
	'last_vi_os'		=> $last_vi_os,
	'this_vi_os'		=> $this_vi_os,
	'last_vi_domain'	=> $last_vi_domain,
	'this_vi_domain'	=> $this_vi_domain,
	'new_member'		=> $new_member,
	'new_post'			=> $new_post,
	'new_point'			=> $new_point,
));