<?php
$sub_menu = '500120';
if (!defined('_EYOOM_IS_ADMIN_')) exit;

auth_check($auth[$sub_menu], "r");

$action_url = EYOOM_ADMIN_URL . '/?dir=shopetc&amp;pid=orderprintresult&amp;wmode=1';

include EYOOM_ADMIN_INC_PATH . "/atpl.assign.php";