<?php

function eb_poll($skin_dir='basic', $po_id=false)
{
    global $config, $member, $g5, $is_admin, $tpl, $tpl_name;

    // 투표번호가 넘어오지 않았다면 가장 큰(최근에 등록한) 투표번호를 얻는다
    if (!$po_id) {
        $row = sql_fetch(" select MAX(po_id) as max_po_id from {$g5['poll_table']} ");
        $po_id = $row['max_po_id'];
    }

    if(!$po_id)
        return;

    $po = sql_fetch(" select * from {$g5['poll_table']} where po_id = '$po_id' ");

	for ($i=1; $i<=9 && $po["po_poll{$i}"]; $i++) {
		$poll[$i]['po_poll'] = $po["po_poll{$i}"];
	}

	$tpl->define(array(
		'pc'	=> 'skin_pc/poll/' . $skin_dir . '/poll.skin.html',
		'mo'	=> 'skin_mo/poll/' . $skin_dir . '/poll.skin.html',
		'bs'	=> 'skin_bs/poll/' . $skin_dir . '/poll.skin.html',
	));

	$tpl->assign(array(
		'po'		=> $po,
		'poll'		=> $poll,
		'member'	=> $member,
		'po_id'		=> $po_id,
		'skin_dir'	=> $skin_dir,
	));
	$tpl->print_($tpl_name);
}
?>