<?php
$sub_menu = "800600";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

check_demo();

if (!count($_POST['chk'])) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택수정") {
	
	auth_check($auth[$sub_menu], 'w');

    for ($i=0; $i<count($_POST['chk']); $i++) {

        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];

        $sql = " update {$g5['eyoom_ebslider_item']}
                    set ei_sort = '{$_POST['ei_sort'][$k]}',
                        ei_state = '{$_POST['ei_state'][$k]}',
                        ei_view_level = '{$_POST['ei_view_level'][$k]}'
                 where ei_no = '{$_POST['ei_no'][$k]}' and ei_theme = '{$_POST['theme']}' ";
        sql_query($sql);
    }
    $msg = "정상적으로 수정하였습니다.";

	if (!$page) $page = 1;
	$qstr = "page={$page}";
	
} else if ($_POST['act_button'] == "선택삭제") {
	
    auth_check($auth[$sub_menu], 'd');

    for ($i=0; $i<count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];
        $del_ei_no[$i] = $_POST['ei_no'][$k];
    }
    
	/**
	 * 쿼리 조건문
	 */
	$where = " find_in_set(ei_no, '".implode(',', $del_ei_no)."') and ei_theme = '{$_POST['theme']}' ";

	/**
	 * EB 슬라이더 아이템 파일 경로
	 */
	$ebslider_folder = G5_DATA_PATH.'/ebslider/' . $_POST['theme'];
	
	$sql = "select ei_img from {$g5['eyoom_ebslider_item']} where {$where}";
	$res = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($res); $i++) {
		$ei_file = $ebslider_folder . "/{$row['ei_img']}";
		if (!is_dir($ei_file) && file_exists($ei_file)) {
			@unlink($ei_file);
		}
	}

    /**
	 * EB슬라이더 아이템 레코드 삭제
	 */
	$sql = "delete from {$g5['eyoom_ebslider_item']} where {$where} ";
	sql_query($sql);
    $msg = "선택한 EB슬라이더의 아이템을 삭제하였습니다.";
}

alert($msg, EYOOM_ADMIN_URL . "/?dir=theme&amp;pid=ebslider_form&amp;es_code={$_POST['es_code']}&amp;thema='{$_POST['theme']}'&amp;w=u&amp;".$qstr);