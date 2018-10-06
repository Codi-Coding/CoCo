<?php
include_once('./_common.php');

$pid = 'cart';

include_once('shop/_head.php');

$sql = "SELECT * FROM `CoCo_apms_partner`";
$result = sql_query($sql);


// include_once('skin/more/more.skin.php');
include_once('skin/collect/collect.skin.php');


include_once('shop/_tail.php');

?>