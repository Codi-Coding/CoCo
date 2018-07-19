<?php
include_once('./_common.php');

// Page ID
$pid = 'connect';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($connect_skin_path, $connect_skin_url) = apms_skin_thema('connect', $connect_skin_path, $connect_skin_url); 

// 설정값 불러오기
$is_connect_sub = false;
@include_once($connect_skin_path.'/config.skin.php');

$g5['title'] = '현재접속자';

if($is_connect_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $connect_skin_path;
$skin_url = $connect_skin_url;

$list = array();

$sql_find = ($config['as_admin']) ? "and find_in_set(a.mb_id, '{$config['as_admin']}')=0" : "";

$sql = " select a.mb_id, b.mb_nick, b.mb_name, b.mb_email, b.mb_homepage, b.mb_open, b.mb_point, b.as_level, a.lo_ip, a.lo_location, a.lo_url
            from {$g5['login_table']} a left join {$g5['member_table']} b on (a.mb_id = b.mb_id)
            where a.mb_id <> '{$config['cf_admin']}' $sql_find
            order by a.mb_id desc, a.lo_datetime desc ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $row['lo_url'] = get_text($row['lo_url']);
	$list[$i] = $row;

    if ($row['mb_id']) {
        $list[$i]['name'] = apms_sideview($row['mb_id'], cut_str($row['mb_nick'], $config['cf_cut_name']), $row['mb_email'], $row['mb_homepage'], $row['as_level']);
    } else {
        if ($is_admin)
            $list[$i]['name'] = $row['lo_ip'];
        else
            $list[$i]['name'] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['lo_ip']);
    }

    $list[$i]['num'] = sprintf('%03d',$i+1);
}

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('connect_mobile') : apms_skin_set('connect');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=connect&amp;ts='.urlencode(THEMA);
}

include_once($skin_path.'/current_connect.skin.php');

if($is_connect_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>