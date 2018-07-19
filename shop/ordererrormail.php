<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_LIB_PATH.'/mailer.lib.php');

$subject = $config['cf_title'].' '._t('주문 오류 알림 메일');

if($error == 'order') {
    $content = '<p>'._t('주문정보를 DB에 입력하는 중 오류가 발생했습니다.').'</p>';
} else if($error == 'status') {
    $content = '<p>'._t('주문 상품의 상태를 변경하는 중 DB 오류가 발생했습니다.').'</p>';
}

if($tno) {
    $content .= '<p>'._t('PG사의').' '._t($od_settle_case)._t('는 자동 취소되었습니다.').'</p>';
    $content .= '<p>'._t('취소 내역은 PG사 상점관리자에서 확인할 수 있습니다.').'</p>';
}

$content .= '<p>'._t('오류내용').'</p>';
$content .= '<p>'.$sql.'</p><p>'.sql_error_info().'<p>error file : '.$_SERVER['SCRIPT_NAME'].'</p>';

// 메일발송
mailer($od_name, $od_email, $config['cf_admin_email'], $subject, $content, 1);

unset($error);
?>
