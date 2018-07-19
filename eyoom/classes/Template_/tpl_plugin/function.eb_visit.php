<?php

function eb_visit($skin_dir='basic')
{
    global $config, $g5, $tpl, $is_admin, $connect, $tpl_name;

    // visit 배열변수에
    // $visit[1] = 오늘
    // $visit[2] = 어제
    // $visit[3] = 최대
    // $visit[4] = 전체
    // 숫자가 들어감
    preg_match("/오늘:(.*),어제:(.*),최대:(.*),전체:(.*)/", $config['cf_visit'], $visit);
    settype($visit[1], "integer");
    settype($visit[2], "integer");
    settype($visit[3], "integer");
    settype($visit[4], "integer");

	// 속도 개선을 위해 DB 커넥션 없이 하는 방법을 강구해야 함.
	$write	 = sql_fetch("select sum(bo_count_write) as total from {$g5['board_table']}", false);
	$comment = sql_fetch("select sum(bo_count_comment) as total from {$g5['board_table']}", false);
	$members  = sql_fetch("select count(*) as total from {$g5['member_table']}", false);
	$newby  = sql_fetch("select count(*) as total from {$g5['member_table']} where mb_datetime between date_format(".date("YmdHis").",'%Y-%m-%d 00:00:00') and date_format(".date("YmdHis").",'%Y-%m-%d 23:59:59')", false);

	$counter['visit_today'] = number_format($visit[1]);
	$counter['visit_yesterday'] = number_format($visit[2]);
	$counter['visit_max'] = number_format($visit[3]);
	$counter['visit_total'] = number_format($visit[4]);
	$counter['total_write'] = number_format($write['total']);
	$counter['total_comment'] = number_format($comment['total']);
	$counter['newby'] = number_format($newby['total']);
	$counter['members'] = number_format($members['total']);
	$counter['write'] = number_format($write['total']);
	$counter['comment'] = number_format($comment['total']);


	$tpl->define(array(
		'pc' => 'skin_pc/visit/' . $skin_dir . '/visit.skin.html',
		'mo' => 'skin_mo/visit/' . $skin_dir . '/visit.skin.html',
		'bs' => 'skin_bs/visit/' . $skin_dir . '/visit.skin.html',
	));
	$tpl->assign(array(
		"visit" => $visit,
		"is_admin" => $is_admin,
		"connect" => $connect,
		"counter" => $counter,
	));
	$tpl->print_($tpl_name);
}
