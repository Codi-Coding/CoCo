<?php

$ch = curl_init();

$postData = array(
    'userid' => 'acogneau',
    'productid' => 'secretpassword',
);

curl_setopt_array($ch, array(
    CURLOPT_URL => 'http://172.16.101.178:5000/submit',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData,
    CURLOPT_FOLLOWLOCATION => true
));


$output = curl_exec($ch);
echo ("<img src='".$output."'/>");
?>