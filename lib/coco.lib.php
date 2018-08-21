<?php

include_once(dirname(__DIR__)."/data/CoCo_config.php");


$ch = curl_init();

curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1);

function request_img_Deep($it_id, $mb_id){
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


?>