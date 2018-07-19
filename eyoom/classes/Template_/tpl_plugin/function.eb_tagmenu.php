<?php

function eb_tagmenu($skin_dir='basic', $limit=20, $sort='regdt')
{
    global $eyoom, $g5, $tpl, $tpl_name, $theme;

    $skin_dir = $eyoom['tag_skin'];
    if (!$skin_dir) $skin_dir = 'basic';
    
    $limit = $eyoom['tag_dpmenu_count'];
    if (!$limit) $limit = 20;
    
    $sort = $eyoom['tag_dpmenu_sort'];
    if (!$sort) $sort = 'regdt';
    
    switch($sort) {
	    case 'regdt'	: $sql_order = "tg_regdt desc"; break;
	    case 'score'	: $sql_order = "tg_score desc"; break;
	    case 'regcnt'	: $sql_order = "tg_regcnt desc"; break;
	    case 'scnt'		: $sql_order = "tg_scnt desc"; break;
	    case 'random'	: $sql_order = "rand()"; break;
    }

    $sql = " select * from {$g5['eyoom_tag']} where (1) and tg_theme = '{$theme}' and tg_dpmenu = 'y' order by {$sql_order} limit {$limit} ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $list[$i] = $row;
        $list[$i]['tag'] = get_text($list[$i]['tg_word']);
        $list[$i]['href'] = G5_URL . '/tag/?tag=' . str_replace("&", "^", $list[$i]['tg_word']);
    }

	$tpl->define(array(
		'pc' => 'skin_pc/tag/' . $skin_dir . '/tag_menu.skin.html',
		'mo' => 'skin_mo/tag/' . $skin_dir . '/tag_menu.skin.html',
		'bs' => 'skin_bs/tag/' . $skin_dir . '/tag_menu.skin.html',
	));

	$tpl->assign(array(
		'list'	=> $list,
	));
	$tpl->print_($tpl_name);
}
