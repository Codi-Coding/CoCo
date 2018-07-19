<?php
$sub_menu = '500110';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";