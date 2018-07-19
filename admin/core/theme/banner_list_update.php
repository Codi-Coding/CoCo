<?php
$sub_menu = "800500";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

check_demo();

if (!count($_POST['chk'])) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($page) $qstr = "&amp;page={$page}";
if ($loccd) $qstr .= "&amp;loccd={$loccd}";

if ($_POST['act_button'] == "선택수정") {
	
	auth_check($auth[$sub_menu], 'w');

    for ($i=0; $i<count($_POST['chk']); $i++) {

        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];

        $sql = " update {$g5['eyoom_banner']}
                    set bn_state = '{$_POST['bn_state'][$k]}'
                 where bn_no = '{$_POST['bn_no'][$k]}' and bn_theme = '{$_POST['theme']}' ";
        sql_query($sql);
    }
    $msg = "정상적으로 수정하였습니다.";

} else if ($_POST['act_button'] == "선택삭제") {

    auth_check($auth[$sub_menu], 'd');

    for ($i=0; $i<count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];
        $del_bn_no[$i] = $_POST['bn_no'][$k];
    }
    
    /**
	 * 쿼리 조건문
	 */
    $where = " find_in_set(bn_no, '".implode(',', $del_bn_no)."') and bn_theme = '{$_POST['theme']}' ";
    
    /**
	 * 배너/광고 이미지 삭제를 위한 쿼리실행
	 */
    $sql = "select * from {$g5['eyoom_banner']} where {$where} ";
    $res = sql_query($sql);
    for($i=0; $row=sql_fetch_array($res); $i++) {
	    $bn_file = G5_DATA_PATH.'/banner/'.$row['bn_theme'].'/'.$row['bn_img'];
	    if (file_exists($bn_file) && !is_dir($bn_file)) {
			@unlink($bn_file);
		}
    }
    
    /**
	 * 배너/광고 테이블 레코드 삭제
	 */
    $sql = "delete from {$g5['eyoom_banner']} where {$where} ";
	sql_query($sql);
    $msg = "선택한 배너/광고를 삭제하였습니다.";
}

alert($msg, EYOOM_ADMIN_URL . '/?dir=theme&amp;pid=banner_list'.$qstr);