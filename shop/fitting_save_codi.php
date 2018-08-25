<?php
include_once('./_common.php');
include_once('../lib/coco.lib.php');


if (!$is_member)
    die('회원 전용 서비스 입니다.');

if(!$codi)
    die('상품 코드가 올바르지 않습니다.');

$param = mysql_real_escape_string($codi);

$sql = "update CoCo_cody SET cody = `{$param}` WHERE mb_id = `{$member['mb_id']}`;";
sql_query($sql);
echo($sql);



?>