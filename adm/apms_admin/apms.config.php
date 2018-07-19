<?php
if (!defined('_GNUBOARD_')) exit;

include_once(G5_ADMIN_PATH.'/apms_admin/apms.admin.lib.php');

$apms = array();
$apms = sql_fetch(" select * from {$g5['apms']} ", false);

?>