<?php

include_once('data/CoCo_config.php');
include_once('lib/aes_encrypt.php');


$key = $_GET['key'];


if(!$key){
    echo("invalid url");
    exit;
}
// 이미지 처리 과정
// $enc = aes_encrypt($path, IMAGE_KEY);

// echo("PATH:".aes_decrypt($enc, IMAGE_KEY)."<br/>");
// echo("enc:".$enc."<br/>");
// echo("urlencode:".urlencode($enc)."<br/>");

// echo("<br/>=====================================<br/>");


$path = aes_decrypt($key, IMAGE_KEY);

// echo("key:".$key."<br/>");
// echo("dec:".$path."<br/>");

// echo($dec);


// echo($path);

$im = imagecreatefrompng($path);

header('Content-Type: image/png');

imagepng($im);
imagedestroy($im);

?>
