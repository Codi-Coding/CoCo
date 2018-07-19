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

        $sql = " update {$g5['eyoom_ebcontents']}
                    set ec_state = '{$_POST['ec_state'][$k]}'
                 where ec_no = '{$_POST['ec_no'][$k]}' and ec_theme = '{$_POST['theme']}' ";
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
        $del_ec_no[$i] = $_POST['ec_no'][$k];
        $del_ec_code[$i] = $_POST['ec_code'][$k];
    }
    
    /**
	 * 쿼리 조건문
	 */
    $where = " find_in_set(ec_no, '".implode(',', $del_ec_no)."') and ec_theme = '{$_POST['theme']}' ";
    
    /**
	 * EB컨텐츠 마스터 테이블 레코드 삭제
	 */
    $sql = "delete from {$g5['eyoom_ebcontents']} where {$where} ";
	sql_query($sql);
	
	/**
	 * 쿼리 조건문
	 */
	$where = " find_in_set(ec_code, '".implode(',', $del_ec_code)."') and ci_theme = '{$_POST['theme']}' ";
	
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
    $msg = "선택한 EB컨텐츠를 삭제하였습니다.";
}

alert($msg, EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=ebcontents_list&amp;'.$qstr);