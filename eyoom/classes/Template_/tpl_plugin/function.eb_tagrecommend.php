<?php

function eb_tagrecommend($skin_dir='basic', $limit=5)
{
    global $eyoom, $g5, $tpl, $tpl_name, $theme;

    $skin_dir = $eyoom['tag_skin'];
    if (!$skin_dir) $skin_dir = 'basic';
    
    $limit = $eyoom['tag_recommend_count'];
    if (!$limit) $limit = 5;

    $sql = " select * from {$g5['eyoom_tag']} where (1) and tg_theme = '{$theme}' and tg_recommdt <> '0000-00-00 00:00:00' order by tg_recommdt desc limit {$limit} ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $list[$i] = $row;
        $list[$i]['tag'] = get_text($list[$i]['tg_word']);
        $list[$i]['href'] = G5_URL . '/tag/?tag=' . str_replace("&", "^", $list[$i]['tg_word']);
    }

	$tpl->define(array(
		'pc' => 'skin_pc/tag/' . $skin_dir . '/tag_recommend.skin.html',
		'mo' => 'skin_mo/tag/' . $skin_dir . '/tag_recommend.skin.html',
		'bs' => 'skin_bs/tag/' . $skin_dir . '/tag_recommend.skin.html',
	));

	$tpl->assign(array(
		'list'	=> $list,
	));
	$tpl->print_($tpl_name);
}
