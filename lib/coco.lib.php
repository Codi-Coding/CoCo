<?php

include_once(dirname(__DIR__)."/data/CoCo_config.php");
include_once('../_common.php');
include_once(G5_LIB_PATH.'/aes_encrypt.php');


$ch = curl_init();

curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1);

function request_virtual_fitting($it_id, $mb_id){
	global $ch;

	$postData = array(
	    'userid' => $mb_id,
	    'productid' => $it_id,
	);

	curl_setopt_array($ch, array(
	    CURLOPT_URL => DeepLearning_Server.'/submit',
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_POST => true,
	    CURLOPT_POSTFIELDS => $postData,
	    CURLOPT_FOLLOWLOCATION => true
	));

	$re = curl_exec($ch);

	$output = array(
		"result" => 1,
		"src" => $re,
	);

	if(curl_errno($ch)){
		$output['result'] = 0;
		$output['src'] = NULL;
	}

	$codi_url_sql = "UPDATE CoCo_cody SET image_url='https://www.google.co.kr/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png' where mb_id='{$mb_id}'";
	sql_query($codi_url_sql);

	return $output;
}

function notification_item_Deep($it_id){
	global $ch;

	$postData = array(
	    'productid' => $it_id,
	);

	curl_setopt_array($ch, array(
	    CURLOPT_URL => DeepLearning_Server.'/upload',
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_POST => true,
	    CURLOPT_POSTFIELDS => $postData,
	    CURLOPT_FOLLOWLOCATION => true
	));

	$re = curl_exec($ch);

	$output = array(
		"result" => 1,
		"src" => $re,
	);

	if(curl_errno($ch)){
		$output['result'] = 0;
		$output['src'] = NULL;
	}
	return $output;

}

function resize_image_save($file, $dest, $w, $h) {
	list($width, $height) = getimagesize($file);
	$extension = end(explode(".", $file));
	// $src="";
	// $func="";
	switch($extension){
		case 'jpeg':
			$src = imagecreatefromjpeg($file);
			$func = 'imagejpeg';
			break;
		case 'png':
			$src = imagecreatefrompng($file);
			$func = 'imagepng';
			break;
		case 'gif':
			$src = imagecreatefromgif($file);
			$func = 'imagegif';
			break;
		default:
			$src = imagecreatefromjpeg($file);
			$func = 'imagejpeg';
			break;
	}
	$dst = imagecreatetruecolor($w, $h);
	imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
	$func($dst, $dest);
	imagedestroy($dst);
	imagedestroy($src);
	return true;
 }
 
function getCodiRow($mb_id){
	$codi_sql = "select * from CoCo_cody where mb_id='{$mb_id}'";
	$codi_result = sql_query($codi_sql);
	$codi_row = sql_fetch_array($codi_result);

	return $codi_row;
}

function getEncPath($path){
    return "/image.php?key=".urlencode(aes_encrypt($path, IMAGE_KEY));
}

?>