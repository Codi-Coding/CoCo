<?php
$sub_menu = "800610";
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

        $sql = " update {$g5['eyoom_ebcontents_item']}
                    set ci_sort = '{$_POST['ci_sort'][$k]}',
                        ci_state = '{$_POST['ci_state'][$k]}',
                        ci_view_level = '{$_POST['ci_view_level'][$k]}'
                 where ci_no = '{$_POST['ci_no'][$k]}' and ci_theme = '{$_POST['theme']}' ";
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
        $del_ci_no[$i] = $_POST['ci_no'][$k];
    }
    
	/**
	 * 쿼리 조건문
	 */
	$where = " find_in_set(ci_no, '".implode(',', $del_ci_no)."') and ci_theme = '{$_POST['theme']}' ";

	/**
	 * EB컨텐츠 아이템 파일 경로
	 */
	$ebcontents_folder = G5_DATA_PATH.'/ebcontents/' . $_POST['theme'];
	
	$sql = "select ci_img from {$g5['eyoom_ebcontents_item']} where {$where}";
	$res = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($res); $i++) {
		$ci_img = unserialize($row['ci_img']);
		foreach ($ci_img as $k => $img_name) {
			$ci_file = $ebcontents_folder . '/' . $img_name;
			if (!is_dir($ci_file) && file_exists($ci_file) && $img_name) {
				@unlink($ci_file);
			}
		}
	}

    /**
	 * EB컨텐츠 아이템 레코드 삭제
	 */
	$sql = "delete from {$g5['eyoom_ebcontents_item']} where {$where} ";
	sql_query($sql);
    $msg = "선택한 EB컨텐츠 아이템을 삭제하였습니다.";
}

alert($msg, EYOOM_ADMIN_URL . "/?dir=theme&amp;pid=ebcontents_form&amp;ec_code={$_POST['ec_code']}&amp;thema='{$_POST['theme']}'&amp;w=u&amp;".$qstr);