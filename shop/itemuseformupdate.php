<?php
include_once('./_common.php');

if (!$is_member) {
	if($move) {
		alert("회원만 작성이 가능합니다.");
	} else {
		alert_close("회원만 작성이 가능합니다.");
	}
}

$it_id       = trim($_REQUEST['it_id']);
$is_id       = (int)trim($_REQUEST['is_id']);
$is_subject  = trim($_POST['is_subject']);
$is_content  = trim($_POST['is_content']);
$is_content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $is_content);
$is_name     = trim($_POST['is_name']);
$is_password = trim($_POST['is_password']);
$is_score    = (int)$_POST['is_score'] > 5 ? 0 : (int)$_POST['is_score'];

//APMS : 파트너 정보 등록 - 2014.07.21
$it = apms_it($it_id);

if($it['pt_review_use']) $default['de_item_use_write'] = ''; // 후기권한 재설정

// 사용후기 작성 설정에 따른 체크
check_itemuse_write($it_id, $member['mb_id']);

if ($w == "" || $w == "u") {
    $is_name     = addslashes(strip_tags($member['mb_nick'])); //별명으로 변경
    $is_password = $member['mb_password'];

    if (!$is_subject) alert("제목을 입력하여 주십시오.");
    if (!$is_content) alert("내용을 입력하여 주십시오.");
}

// 포토후기
$is_photo = apms_img_content($is_content);
$is_photo = ($is_photo) ? 1 : 0;

if ($w == "") {
    /*
    $sql = " select max(is_id) as max_is_id from {$g5['g5_shop_item_use_table']} ";
    $row = sql_fetch($sql);
    $max_is_id = $row['max_is_id'];

    $sql = " select max(is_id) as max_is_id from {$g5['g5_shop_item_use_table']} where it_id = '$it_id' and mb_id = '{$member['mb_id']}' ";
    $row = sql_fetch($sql);
    if ($row['max_is_id'] && $row['max_is_id'] == $max_is_id)
        alert("같은 상품에 대하여 계속해서 평가하실 수 없습니다.");
    */

    $sql = "insert {$g5['g5_shop_item_use_table']}
               set it_id = '$it_id',
                   mb_id = '{$member['mb_id']}',
                   is_score = '$is_score',
                   is_name = '$is_name',
                   is_password = '$is_password',
                   is_subject = '$is_subject',
                   is_content = '$is_content',
                   is_time = '".G5_TIME_YMDHIS."',
				   pt_it = '{$it['pt_it']}',
				   pt_photo = '$is_photo',
				   pt_id = '{$it['pt_id']}',
                   is_ip = '{$_SERVER['REMOTE_ADDR']}' "; // APMS - 2014.07.21
    if (!$default['de_item_use_use'])
        $sql .= ", is_confirm = '1' ";
    sql_query($sql);

    $is_id = sql_insert_id();

    if ($default['de_item_use_use']) {
        $alert_msg = "글은 관리자가 확인한 후에 출력됩니다.";
    }  else {
		//$alert_msg = "등록 되었습니다.";

		// 내글반응	등록
		$it['pt_id'] = ($it['pt_id']) ? $it['pt_id'] : $config['cf_admin']; // 파트너 없으면 최고관리자에게 보냄
		apms_response('it', 'use', $it_id, '', $is_id, $is_subject, $it['pt_id'], $member['mb_id'], $is_name);
    }

} else if ($w == "u") {

	$sql = " select is_password from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' ";
    $row = sql_fetch($sql);
    if ($row['is_password'] != $is_password)
        alert("비밀번호가 틀리므로 수정하실 수 없습니다.");

    $sql = " update {$g5['g5_shop_item_use_table']}
                set is_subject = '$is_subject',
                    is_content = '$is_content',
                    is_score = '$is_score',
					pt_photo = '$is_photo'
			  where is_id = '$is_id' ";
    sql_query($sql);

    //$alert_msg = "수정 되었습니다.";

} else if ($w == "d") {

	$row = sql_fetch(" select it_id, mb_id, is_content, is_confirm from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' and md5(concat(is_id,is_time,is_ip)) = '{$hash}' ");

	if (!$is_admin && $member['mb_id'] != $row['mb_id']) {
		if($move) {
			alert("자신의 글만 삭제하실 수 있습니다.");
		} else {
			apms_alert("1|자신의 글만 삭제하실 수 있습니다.");
		}
	}

	// 에디터로 첨부된 이미지 삭제
	apms_editor_image($row['is_content'], 'del');

	// 삭제
	sql_query(" delete from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' and md5(concat(is_id,is_time,is_ip)) = '{$hash}' ");

	// 상품의 후기 감소
	if($row['is_confirm']) {
		sql_query(" update {$g5['g5_shop_item_table']} set it_use_cnt = it_use_cnt - 1 where it_id = '{$row['it_id']}' ", false);
	}

	//$alert_msg = "0|삭제 하셨습니다.";
}

//쇼핑몰 설정에서 사용후기가 즉시 출력일 경우
if( ! $default['de_item_use_use'] ){
    update_use_cnt($it_id);
}

update_use_avg($it_id);

if($move) {
	if($alert_msg) {
		if($move == "1") { //아이템으로
			alert($alert_msg, './item.php?it_id='.$it_id.'&ca_id='.$ca_id.'#itemuse');
		} else if($move == "3") { //내용으로
			alert($alert_msg, './itemuseview.php?is_id='.$is_id.'&ca_id='.$ca_id.'&page='.$page);
		} else { //목록으로
			alert($alert_msg, './itemuselist.php?page='.$page);
		}
	} else {
		if($move == "1") { //아이템으로
			goto_url('./item.php?it_id='.$it_id.'&ca_id='.$ca_id.'#itemqa');
		} else if($move == "3") { //내용으로
			goto_url('./itemuseview.php?is_id='.$is_id.'&ca_id='.$ca_id.'&page='.$page);
		} else { //목록으로
			goto_url('./itemuselist.php?page='.$page);
		}
	}
} else {
	if($w == 'd') {
		apms_alert($alert_msg);
	} else {
		apms_opener('itemuse', $alert_msg, './itemuse.php?it_id='.$it_id.'&ca_id='.$ca_id.'&irows='.$irows.'&page='.$page);
	}
}

?>