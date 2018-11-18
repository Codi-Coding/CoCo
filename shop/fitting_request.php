<?php
include_once('./_common.php');
include_once('../lib/coco.lib.php');


$query = $_POST;
$re = request_virtual_fitting($query, $member['mb_id']);

echo($re);


?>
