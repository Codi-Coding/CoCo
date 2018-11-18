<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/coco.lib.php');

$id = $member["mb_id"];

$sql = "delete from `CoCo_fitting_cart` where mb_id = '{$id}'";
echo($sql);
sql_query($sql);

?>