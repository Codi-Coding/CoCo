<?php
include_once('./_common.php');

switch ($w) {
    case 'u' :
        $action = G5_HTTP_BBS_URL.'/write.php';
        $return_url = G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id;
        break;
    case 'd' :
        set_session('ss_delete_token', $token = uniqid(time()));
        $action = https_url(G5_BBS_DIR).'/delete.php?token='.$token;
        $return_url = G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id;
        break;
    case 'x' :
        set_session('ss_delete_comment_'.$comment_id.'_token', $token = uniqid(time()));
        $action = https_url(G5_BBS_DIR).'/delete_comment.php?token='.$token;
        $row = sql_fetch(" select wr_parent from $write_table where wr_id = '$comment_id' ");
        $return_url = G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$row['wr_parent'];
        break;
    case 's' :
        // 비밀번호 창에서 로그인 하는 경우 관리자 또는 자신의 글이면 바로 글보기로 감
        if ($is_admin || ($member['mb_id'] == $write['mb_id'] && $write['mb_id']))
            goto_url(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id);
        else {
            $action = https_url(G5_BBS_DIR).'/password_check.php';
            $return_url = G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table;
        }
        break;
    case 'sc' :
        // 비밀번호 창에서 로그인 하는 경우 관리자 또는 자신의 글이면 바로 글보기로 감
        if ($is_admin || ($member['mb_id'] == $write['mb_id'] && $write['mb_id']))
            goto_url(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id);
        else {
            $action = https_url(G5_BBS_DIR).'/password_check.php';
            $return_url = G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id;
        }
        break;
    default :
        alert('w 값이 제대로 넘어오지 않았습니다.');
}

// Page ID
$pid = ($pid) ? $pid : 'password';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url); 

// 설정값 불러오기
$is_password_sub = false;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = '비밀번호 입력';

if($is_password_sub) {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
	include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

/* 비밀글의 제목을 가져옴 지운아빠 2013-01-29 */
$sql = " select wr_subject from {$write_table}
                      where wr_num = '{$write['wr_num']}'
                      and wr_reply = ''
                      and wr_is_comment = 0 ";
$row = sql_fetch($sql);

$g5['title'] = get_text($row['wr_subject']);

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('member_mobile') : apms_skin_set('member');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
	$setup_href = './skin.setup.php?skin=member&amp;ts='.urlencode(THEMA);
}

include_once($skin_path.'/password.skin.php');

if($is_password_sub) {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
} else {
	include_once('./_tail.php');
}
?>
