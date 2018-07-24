<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$g5['opage_table'] = G5_TABLE_PREFIX.'opage'; // 외부페이지 테이블
if ($op_id) {
    $opage = sql_fetch(" select * from {$g5['opage_table']} where op_id = '$op_id' ");
    if ($opage['op_id']) {
        $gr_id = $opage['gr_id'];
    }
}
?>