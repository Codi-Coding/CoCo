<?php
$sub_menu = "300100";
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], 'w');

$action_url = EYOOM_ADMIN_URL . '/?dir=board&amp;pid=board_copy_update&amp;smode=1';

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";