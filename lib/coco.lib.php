<?php

function request_img_Deep($it_id, $mb_id){
	$ch = curl_init();

	$postData = array(
	    'userid' => $mb_id,
	    'productid' => $it_id,
	);

	curl_setopt_array($ch, array(
	    CURLOPT_URL => 'http://172.16.101.84:5000/submit',
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_POST => true,
	    CURLOPT_POSTFIELDS => $postData,
	    CURLOPT_FOLLOWLOCATION => true
	));


	$output = curl_exec($ch);
	return $output;
}

function notification_item_Deep($it_id){
	$ch = curl_init();

	$postData = array(
	    'productid' => $it_id,
	);

	curl_setopt_array($ch, array(
	    CURLOPT_URL => 'http://172.16.101.84:5000/upload',
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_POST => true,
	    CURLOPT_POSTFIELDS => $postData,
	    CURLOPT_FOLLOWLOCATION => true
	));


	$output = curl_exec($ch);
	return $output;

}


?>