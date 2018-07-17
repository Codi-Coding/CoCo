<?php
include_once('./_common.php');

if (!$is_designer) {
    alert("관리자만 접근이 가능합니다.");
}

if ($is_demo) {
    alert("데모에서는 테마설정값을 저장할 수 없습니다.");
}

// 미리보기 작업
$is_preview = get_session('thema');
$is_org = get_session('thema_org');

if($is_preview && $is_org && $is_org == $is_preview) {
    alert("현재 운영중인 테마는 미리보기 작업을 할 수 없습니다.");
}

if(apms_escape_check($_POST['sw_type']) || apms_escape_check($_POST['sw_code']) || apms_escape_check($_POST['sw_thema']) || apms_escape_check($_POST['colorset'])) {
    alert("테마명, 컬러셋 등에 특수문자는 사용할 수 없습니다.");
}

$type = $_POST['sw_type'];
$code = $_POST['sw_code'];
$thema = $_POST['sw_thema'];
$colorset = $_POST['colorset'];

if($type && $thema) {

	if($reset) {
		//초기화
        sql_query(" delete from {$g5['apms_data']} where type = '$type' and data_q = '$code' and data_1 = '$thema' ", false);
	} else {
		$str = apms_pack($_POST['at_set']);

		// 등록여부 체크
		$data = sql_fetch(" select * from {$g5['apms_data']} where type = '$type' and data_q = '$code' and data_1 = '$thema' ");

		if($data['id']) {
			sql_query(" update {$g5['apms_data']} set data_set = '$str', data_2 = '$colorset' where type = '$type' and data_q = '$code' and data_1 = '$thema' ");
		} else {
			sql_query(" insert {$g5['apms_data']} set type = '$type', data_q = '$code', data_1 = '$thema', data_2 = '$colorset', data_set = '$str' ");
		}

		// 컬러셋 : 미리보기시에는 업데이트 안함
		if($colorset && !$is_preview) {
			if($type == "11") { //커뮤니티 기본 PC 컬러셋
				sql_query(" update {$g5['config_table']} set as_color = '{$colorset}' ");
			} else if($type == "12") { //커뮤니티 그룹 PC 컬러셋
				sql_query(" update {$g5['group_table']} set as_color = '{$colorset}' where gr_id = '{$code}' ");
			} else if($type == "13") { //커뮤니티 기본 모바일 컬러셋
				sql_query("update {$g5['config_table']} set as_mobile_color = '{$colorset}'");
			} else if($type == "14") { //커뮤니티 그룹 모바일 컬러셋
				sql_query(" update {$g5['group_table']} set as_mobile_color = '{$colorset}' where gr_id = '{$code}' ");
			} else if($type == "15") { //쇼핑몰 기본 PC 컬러셋
				sql_query(" update {$g5['g5_shop_default_table']} set as_color = '{$colorset}' ");
			} else if($type == "16") { //쇼핑몰 분류 PC 컬러셋
				sql_query(" update {$g5['g5_shop_category_table']} set as_color = '{$colorset}' where ca_id = '{$code}' ");
			} else if($type == "17") { //쇼핑몰 기본 모바일 컬러셋
				sql_query(" update {$g5['g5_shop_default_table']} set as_mobile_color = '{$colorset}' ");
			} else if($type == "18") { //쇼핑몰 분류 모바일 컬러셋
				sql_query(" update {$g5['g5_shop_category_table']} set as_mobile_color = '{$colorset}' where ca_id = '{$code}' ");
			}
		}
	}
}

if ($url) {
	$link = urldecode($url);
} else  {
    $link = G5_URL;
}

goto_url($link);

?>