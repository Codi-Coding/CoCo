<?php
include_once('./_common.php');
include_once('../lib/coco.lib.php');


if (!$is_member)
    die('회원 전용 서비스 입니다.');


if(!$it_id)
    die('상품 코드가 올바르지 않습니다.');

$it_id = str_replace("\\", "", $it_id);
$it_id = json_decode($it_id, true);

$re = request_virtual_fitting($it_id, $member['mb_id']);


echo($re);
?>
