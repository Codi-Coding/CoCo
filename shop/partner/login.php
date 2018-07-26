<?php
include_once('./_common.php');

// 이미 로그인 중이라면
if ($is_member) goto_url(APMS_PARTNER_URL);

$action_url = APMS_PARTNER_HTTPS_URL.'/login_check.php';

include_once(G5_PATH.'/head.sub.php');
include_once($skin_path.'/login.skin.php');
include_once(G5_PATH.'/tail.sub.php');

?>