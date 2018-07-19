<?php

function eb_popular($skin_dir='basic', $pop_cnt=7, $date_cnt=3)
{
    global $config, $g5, $tpl, $tpl_name;

    if (!$skin_dir) $skin_dir = 'basic';

    $date_gap = date("Y-m-d", G5_SERVER_TIME - ($date_cnt * 86400));
    $sql = " select pp_word, count(*) as cnt from {$g5['popular_table']} where pp_date between '$date_gap' and '".G5_TIME_YMD."' group by pp_word order by cnt desc, pp_word limit 0, $pop_cnt ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $list[$i] = $row;
        // 스크립트등의 실행금지
        $list[$i]['pp_word'] = get_text($list[$i]['pp_word']);
    }

	$tpl->define(array(
		'pc' => 'skin_pc/popular/' . $skin_dir . '/popular.skin.html',
		'mo' => 'skin_mo/popular/' . $skin_dir . '/popular.skin.html',
		'bs' => 'skin_bs/popular/' . $skin_dir . '/popular.skin.html',
	));

	$tpl->assign(array(
		'list'	=> $list,
	));
	$tpl->print_($tpl_name);
}
