<?php
if (!defined('_GNUBOARD_')) exit;

if (!defined('_SHOP_')) {
	$pop_division = 'comm';
} else {
	$pop_division = 'shop';
}

$_device = G5_IS_MOBILE ? 'mobile': 'pc';

$sql = "
	select * from {$g5['new_win_table']}
	where
		'".G5_TIME_YMDHIS."' between nw_begin_time and nw_end_time
		and nw_device IN ( 'both', '".$_device."' )
	order by nw_id asc 
";
    
$result = sql_query($sql, false);

for ($i=0; $row_nw=sql_fetch_array($result); $i++) {
	// 이미 체크 되었다면 Continue
	if ($_COOKIE["hd_pops_list"])
		continue;

	$sql = " select * from {$g5['new_win_table']} where nw_id = '{$row_nw['nw_id']}' ";
	$newwin[$i] = sql_fetch($sql);
}

// 사용자 프로그램
@include_once(EYOOM_USER_PATH.'/newwin/newwin.skin.php');

// Template define
$tpl->define_template('newwin',$eyoom['newwin_skin'],'newwin.skin.html');

@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);