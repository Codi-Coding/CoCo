<?php
include_once('./_common.php');

if (!$is_member)
    die('회원 전용 서비스 입니다.');

if(!$it_id)
    die('상품 코드가 올바르지 않습니다.');


$ch = curl_init();


// $postData = array(
//     'userid' => 'acogneau',
//     'productid' => 'secretpassword',
// );

// curl_setopt_array($ch, array(
//     CURLOPT_URL => 'http://172.16.101.178:5000/submit',
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_POST => true,
//     CURLOPT_POSTFIELDS => $postData,
//     CURLOPT_FOLLOWLOCATION => true
// ));


// $output = curl_exec($ch);
// echo ($output);
echo ("here");

?>
