<?php
define('G5_CAPTCHA', true);
include_once('./_common.php');

if ($is_guest) {
    apms_alert('1|회원만 가능합니다.');
}

// 테이블
$comment_table = $g5['apms_comment'];

// 토큰체크
$comment_token = trim(get_session('ss_comment_token'));
set_session('ss_comment_token', '');
if(!trim($_POST['token']) || !$comment_token || $comment_token != $_POST['token'])
    apms_alert('1|올바른 방법으로 이용해 주십시오.');

// 090710
if (substr_count($wr_content, "&#") > 50) {
    apms_alert('1|내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
}

$w = $_POST["w"];
$wr_name  = trim($_POST['wr_name']);
$wr_email = '';
if (!empty($_POST['wr_email']))
    $wr_email = trim($_POST['wr_email']);

// 비회원의 경우 이름이 누락되는 경우가 있음
if ($is_guest) {
    if ($wr_name == '')
        apms_alert('1|이름은 필히 입력하셔야 합니다.');
}

// 상품정보
$it = apms_it($it_id, 1);

if (!$it['it_id'])
    apms_alert("1|자료가 없습니다.");

if ($w == "c") {
	if (!($it['ca_use'] && $it['it_use'])) {
		apms_alert('1|댓글을 달 수 없는 자료입니다.');
	}
}

if ($w == "c" || $w == "cu") {
	if ($is_member && $it['pt_comment_use']) {
		if($is_admin != 'super' && $it['pt_comment_use'] == "2") {
			if($member['mb_id'] != $it['pt_id']) {
		        apms_alert('1|댓글을 쓸 권한이 없습니다.');
			}
		}
	} else {
        apms_alert('1|댓글을 쓸 권한이 없습니다.');
	}
} else {
    apms_alert('1|w 값이 제대로 넘어오지 않았습니다.');
}

// 세션의 시간 검사
// 4.00.15 - 댓글 수정시 연속 게시물 등록 메시지로 인한 오류 수정
//if ($w == 'c' && $_SESSION['ss_datetime'] >= (G5_SERVER_TIME - $config['cf_delay_sec']) && !$is_admin)
//    apms_alert('1|너무 빠른 시간내에 게시물을 연속해서 올릴 수 없습니다.');

set_session('ss_datetime', G5_SERVER_TIME);

// "인터넷옵션 > 보안 > 사용자정의수준 > 스크립팅 > Action 스크립팅 > 사용 안 함" 일 경우의 오류 처리
// 이 옵션을 사용 안 함으로 설정할 경우 어떤 스크립트도 실행 되지 않습니다.
//if (!trim($_POST["wr_content"])) die ("내용을 입력하여 주십시오.");

if ($is_member)
{
    $mb_id = $member['mb_id'];
    // 4.00.13 - 실명 사용일때 댓글에 닉네임으로 입력되던 오류를 수정
    //$wr_name = $board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick'];
    $wr_name = $member['mb_nick'];
    $wr_password = $member['mb_password'];
	if($member['mb_open']) {
	    $wr_email = addslashes($member['mb_email']);
	    $wr_homepage = addslashes(clean_xss_tags($member['mb_homepage']));
	} else {
	    $wr_email = '';
	    $wr_homepage = '';
	}
    $wr_level = (int)$member['as_level'];
}
else
{
    $mb_id = '';
    $wr_password = sql_password($wr_password);
    $wr_level = 1;
}

//댓글제목 - 상품명
$wr_subject = get_text(stripslashes($it['it_name']));

if ($w == 'c') { // 댓글 입력

	// 댓글포인트 적립
	$is_cmt_point = true;
	if(isset($default['pt_comment_limit']) && $default['pt_comment_limit'] > 0) {
		if ($it['it_time'] < date("Y-m-d H:i:s", G5_SERVER_TIME - ($default['pt_comment_limit'] * 86400))) {
			$is_cmt_point = false;
		}
	}

	// 댓글쓰기 포인트설정시 회원의 포인트가 음수인 경우 댓글을 쓰지 못하던 버그를 수정 (곱슬최씨님)
    $tmp_point = ($member['mb_point'] > 0) ? $member['mb_point'] : 0;
    if ($tmp_point + $default['pt_comment_point'] < 0 && !$is_admin)
        apms_alert('1|보유하신 포인트('.number_format($member['mb_point']).')가 없거나 모자라서 댓글쓰기('.number_format($default['pt_comment_point']).')가 불가합니다. 포인트를 적립하신 후 다시 댓글을 써 주십시오.');

    // 댓글 답변
	$wr_re_mb = '';
	$wr_re_name = '';
	if ($comment_id) {
		$sql = " select wr_id, mb_id, wr_comment, wr_comment_reply, wr_name from $comment_table where wr_id = '$comment_id' and it_id = '$it_id' ";
        $reply_array = sql_fetch($sql);
        if (!$reply_array['wr_id'])
            apms_alert('1|답변할 댓글이 없습니다. 답변하는 동안 댓글이 삭제되었을 수 있습니다.');

        $tmp_comment = $reply_array['wr_comment'];

		//대댓글 내글반응
		$wr_re_mb = $reply_array['mb_id'];
		$wr_re_name = $reply_array['wr_name'];
		$wr_re_cnt = strlen($reply_array['wr_comment_reply']);

        if ($wr_re_cnt == 5)
            apms_alert('1|더 이상 답변하실 수 없습니다. 답변은 5단계 까지만 가능합니다.');

        $reply_len = $wr_re_cnt + 1;
        //if ($board['bo_reply_order']) {
            $begin_reply_char = 'A';
            $end_reply_char = 'Z';
            $reply_number = +1;
            $sql = " select MAX(SUBSTRING(wr_comment_reply, $reply_len, 1)) as reply
                        from $comment_table
                        where wr_comment = '$tmp_comment' and it_id = '$it_id'
                        and SUBSTRING(wr_comment_reply, $reply_len, 1) <> '' ";
        //} else {
        //    $begin_reply_char = 'Z';
        //    $end_reply_char = 'A';
        //    $reply_number = -1;
        //    $sql = " select MIN(SUBSTRING(wr_comment_reply, $reply_len, 1)) as reply
        //                from $comment_table
        //                where wr_comment = '$tmp_comment'
        //                and SUBSTRING(wr_comment_reply, $reply_len, 1) <> '' ";
        //}
        if ($reply_array['wr_comment_reply'])
            $sql .= " and wr_comment_reply like '{$reply_array['wr_comment_reply']}%' ";
        $row = sql_fetch($sql);

        if (!$row['reply'])
            $reply_char = $begin_reply_char;
        else if ($row['reply'] == $end_reply_char) // A~Z은 26 입니다.
            apms_alert('1|더 이상 답변하실 수 없습니다. 답변은 26개 까지만 가능합니다.');
        else
            $reply_char = chr(ord($row['reply']) + $reply_number);

        $tmp_comment_reply = $reply_array['wr_comment_reply'] . $reply_char;

	} else {
		$sql = " select max(wr_comment) as max_comment from $comment_table
                    where it_id = '$it_id' ";
        $row = sql_fetch($sql);
        //$row[max_comment] -= 1;
        $row['max_comment'] += 1;
        $tmp_comment = $row['max_comment'];
        $tmp_comment_reply = '';
    }

	//럭키포인트
	$wr_lucky = ($default['pt_lucky'] && $is_cmt_point) ? apms_lucky($it_id, '', '') : 0;

    $sql = " insert into $comment_table
                set it_id = '{$it['it_id']}',
                     pt_id = '{$it['pt_id']}',
					 wr_option = '$wr_secret',
                     wr_comment = '$tmp_comment',
                     wr_comment_reply = '$tmp_comment_reply',
                     wr_subject = '$wr_subject',
                     wr_content = '$wr_content',
                     wr_level = '$wr_level',
					 wr_lucky = '$wr_lucky',
                     mb_id = '$mb_id',
                     wr_password = '$wr_password',
                     wr_name = '$wr_name',
                     wr_email = '$wr_email',
                     wr_homepage = '$wr_homepage',
                     wr_re_mb = '$wr_re_mb',
					 wr_re_name = '$wr_re_name',
                     wr_datetime = '".G5_TIME_YMDHIS."',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}',
                     wr_1 = '$wr_1',
                     wr_2 = '$wr_2',
                     wr_3 = '$wr_3',
                     wr_4 = '$wr_4',
                     wr_5 = '$wr_5' ";
    sql_query($sql);

    $comment_id = sql_insert_id();

    // 상품에 댓글 반영
    sql_query(" update {$g5['g5_shop_item_table']} set pt_comment = pt_comment + 1 where it_id = '$it_id' ");

	// 내글반응 등록
	$it['pt_id'] = ($it['pt_id']) ? $it['pt_id'] : $config['cf_admin']; // 파트너 없으면 최고관리자에게 보냄
	apms_response('it', 'comment', $it_id, '', '', $it['it_name'], $it['pt_id'], $member['mb_id'], $wr_name, $comment_id);

	// 대댓글일 때
	if($wr_re_mb && $wr_re_mb != $it['pt_id']) {
		apms_response('it', 'comment_reply', $it_id, '', '', $it['it_name'], $wr_re_mb, $member['mb_id'], $wr_name, $comment_id);
	}

    // 포인트 부여
	if($default['pt_comment_point'] && $is_cmt_point) {
	    insert_point($member['mb_id'], $default['pt_comment_point'], "{$it_id}-{$comment_id} 댓글", $it_id, $comment_id, '댓글');
	}

    // SNS 등록
    include_once("./itemcommentsend.php");
    if($wr_facebook_user || $wr_twitter_user) {
        $sql = " update $comment_table
                    set wr_facebook_user = '$wr_facebook_user',
                        wr_twitter_user  = '$wr_twitter_user'
                    where wr_id = '$comment_id' ";
        sql_query($sql);
    }

	apms_alert('0|댓글을 등록 하였습니다.');
}
else if ($w == 'cu') // 댓글 수정
{
    $sql = " select mb_id, wr_password, wr_comment, wr_comment_reply from $comment_table
                where wr_id = '$comment_id' and it_id = '$it_id' ";
    $comment = $reply_array = sql_fetch($sql);
    $tmp_comment = $reply_array['wr_comment'];

    $len = strlen($reply_array['wr_comment_reply']);
    if ($len < 0) $len = 0;
    $comment_reply = substr($reply_array['wr_comment_reply'], 0, $len);
    //print_r2($GLOBALS); exit;

    if ($is_admin == 'super') { // 최고관리자 통과
        ;
    } else if ($member['mb_id']) {
        if ($member['mb_id'] != $comment['mb_id'])
            apms_alert('1|자신의 댓글이 아니므로 수정할 수 없습니다.');
    } else {
        if($comment['wr_password'] != $wr_password)
            apms_alert('1|댓글을 수정할 권한이 없습니다.');
    }

    $sql = " select count(*) as cnt from $comment_table
                where wr_comment_reply like '$comment_reply%'
                and wr_id <> '$comment_id'
				and it_id = '$it_id'
                and wr_comment = '$tmp_comment' ";
    $row = sql_fetch($sql);
    if ($row['cnt'] && !$is_admin)
        apms_alert('1|이 댓글와 관련된 대댓글이 존재하므로 수정할 수 없습니다.');

    $sql_ip = "";
    if (!$is_admin)
        $sql_ip = " , wr_ip = '{$_SERVER['REMOTE_ADDR']}' ";

    $sql_secret = "";
    if ($wr_secret)
        $sql_secret = " , wr_option = '$wr_secret' ";

    $sql = " update $comment_table
                set wr_subject = '$wr_subject',
                     wr_content = '$wr_content',
                     wr_1 = '$wr_1',
                     wr_2 = '$wr_2',
                     wr_3 = '$wr_3',
                     wr_4 = '$wr_4',
                     wr_option = '$wr_option'
                     $sql_ip
                     $sql_secret
              where wr_id = '$comment_id' and it_id = '$it_id' ";
    sql_query($sql);

	apms_alert('0|댓글을 수정 하였습니다.');
}

?>