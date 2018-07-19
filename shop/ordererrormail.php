<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_LIB_PATH.'/mailer.lib.php');

$subject = $config['cf_title'].' 주문 오류 알림 메일';

ob_start();
include_once ($misc_skin_path.'/ordererror.mail.php');
$content = ob_get_contents();
ob_end_clean();

// 메일발송
mailer($od_name, $od_email, $config['cf_admin_email'], $subject, $content, 1);

unset($error);
?>