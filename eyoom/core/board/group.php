<?php
include_once('../../_common.php');

$g5['title'] = '게시물 ' . $act;
include_once(G5_PATH.'/head.sub.php');

// 이윰 헤더 디자인 출력
@include_once(EYOOM_PATH.'/head.php');

$exclude = array();

//  최신글
$sql = " select bo_table, bo_subject
			from {$g5['board_table']}
			where gr_id = '{$gr_id}'
			  and bo_list_level <= '{$member['mb_level']}'
			  and bo_device <> 'mobile'
			  and find_in_set(bo_table,'".implode(',',$exclude)."') = 0 
";
if(!$is_admin)
	$sql .= " and bo_use_cert = '' ";
$sql .= " order by bo_order ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = $row;
	$loop = &$list[$i]['data'];
	if(!$orderby) $orderby = " bn_datetime desc ";
	$sql2 = "select * from {$g5['eyoom_new']} where bo_table='{$row['bo_table']}' and wr_id = wr_parent order by $orderby limit {$eyoom['group_latest_cnt']}";

	$res = sql_query($sql2, false);
	for($k=0; $row2 = sql_fetch_array($res); $k++) {
		$loop[$k] = $row2;

		// new 표시
		if ($row2['bn_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - (24 * 3600))) $loop[$k]['new'] = true;
		
		if(!$row2['wr_subject']) {
			$loop[$k]['wr_subject'] = conv_subject($row2['wr_content'], 30, '…');
			$loop[$k]['href'] = G5_BBS_URL."/board.php?bo_table={$row2['bo_table']}&amp;wr_id={$row2['wr_id']}#c_{$row['wr_id']}";
		} else {
			$loop[$k]['wr_subject'] = conv_subject($row2['wr_subject'], 30, '…');
			$loop[$k]['wr_content'] = conv_subject($row2['wr_content'], 30, '…');
			$loop[$k]['href'] = G5_BBS_URL."/board.php?bo_table={$row2['bo_table']}&amp;wr_id={$row2['wr_parent']}";
		}
		$loop[$k]['datetime'] = $row2['bn_datetime'];
	}
}

// Template define
$tpl->define_template('board',$eyoom['board_skin'],'group.skin.html');

// Template assign
@include EYOOM_INC_PATH.'/tpl.assign.php';
$tpl->print_($tpl_name);

// 이윰 테일 디자인 출력
@include_once(EYOOM_PATH.'/tail.php');