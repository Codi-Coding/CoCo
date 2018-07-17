<?php
include_once('./_common.php');

if(USE_G5_THEME && defined('G5_THEME_PATH')) {
    require_once(G5_SHOP_PATH.'/yc/itemuseform.php');
    return;
}

if (!$is_member) {
	if($move) {
	    alert("회원만 가능합니다.");
	} else {
	    alert_close("회원만 가능합니다.");
	}
}

$w     = trim($_REQUEST['w']);
$it_id = get_search_string(trim($_REQUEST['it_id']));
$is_id = preg_replace('/[^0-9]/', '', trim($_REQUEST['is_id']));

// 상품정보체크
$sql = " select it_id, ca_id from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
$row = sql_fetch($sql);
if(!$row['it_id']) {
	if($move) {
		alert('자료가 존재하지 않습니다.');
	} else {
		alert_close('자료가 존재하지 않습니다.');
	}
}

$ca_id = ($ca_id) ? $ca_id : $row['ca_id'];

if ($w == "") {
    $is_score = 5;

	if($row['pt_review_use']) $default['de_item_use_write'] = ''; // 후기권한 재설정

	check_itemuse_write($it_id, $member['mb_id']); // 사용후기 작성 설정에 따른 체크

} else if ($w == "u") {
    $use = sql_fetch(" select * from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' ");
    if (!$use) {
		if($move) {
	        alert("자료가 없습니다.");
		} else {
	        alert_close("자료가 없습니다.");
		}
    }

    $it_id    = $use['it_id'];
    $is_score = $use['is_score'];

    if (!$is_admin && $use['mb_id'] != $member['mb_id']) {
		if($move) {
			alert("자신의 글만 수정이 가능합니다.");	
		} else {
			alert_close("자신의 글만 수정이 가능합니다.");
		}
    }
}

// Page ID
$pid = ($pid) ? $pid : 'iuse';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

$skin_row = array();
$skin_row = apms_rows('use_'.MOBILE_.'rows, use_'.MOBILE_.'skin, use_'.MOBILE_.'set, editor_'.MOBILE_.'skin');
$skin_name = $skin_row['use_'.MOBILE_.'skin'];

// 스킨설정
$wset = array();
if($skin_row['use_'.MOBILE_.'set']) {
	$wset = apms_unpack($skin_row['use_'.MOBILE_.'set']);
}

// 데모
if($is_demo) {
	@include ($demo_setup_file);
}

$skin_path = G5_SKIN_PATH.'/apms/use/'.$skin_name;
$skin_url = G5_SKIN_URL.'/apms/use/'.$skin_name;

// 스킨 체크
list($skin_path, $skin_url) = apms_skin_thema('shop/use', $skin_path, $skin_url); 

// 설정값 불러오기
$is_useform_sub = false;
@include_once($skin_path.'/config.skin.php');

if($move) {
	if($is_useform_sub) {
		include_once(G5_PATH.'/head.sub.php');
		if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
	} else {
		include_once('./_head.php');
	}
} else {
	include_once(G5_PATH.'/head.sub.php');
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
}

// 에디터 별도설정
$apms_editor = $skin_row['editor_'.MOBILE_.'skin'];
$is_apms_editor = (G5_IS_MOBILE && !$apms_editor) ? false : true;

if($config['cf_editor'] && $apms_editor) {
	$config['cf_editor'] = $apms_editor;
	include_once(G5_EDITOR_PATH.'/'.$config['cf_editor'].'/editor.lib.php');
} else {
	include_once(G5_EDITOR_LIB);
}

$is_dhtml_editor = false;
// 모바일에서는 DHTML 에디터 사용불가
//if ($config['cf_editor'] && (!is_mobile() || defined('G5_IS_MOBILE_DHTML_USE') && G5_IS_MOBILE_DHTML_USE)) {
if ($config['cf_editor'] && $is_apms_editor) {
    $is_dhtml_editor = true;
}
$editor_html = editor_html('is_content', get_text($use['is_content'], 0), $is_dhtml_editor);
$editor_js = '';
$editor_js .= get_editor_js('is_content', $is_dhtml_editor);
$editor_js .= chk_editor_js('is_content', $is_dhtml_editor);

include_once($skin_path.'/useform.skin.php');

if($move) {
	if($is_useform_sub) {
		if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
		include_once(G5_PATH.'/tail.sub.php');
	} else {
		include_once('./_tail.php');
	}
} else {
	if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
}
?>