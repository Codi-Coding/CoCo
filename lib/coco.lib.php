<?php

include_once(dirname(__DIR__).'/_common.php');
include_once(dirname(__DIR__)."/data/CoCo_config.php");
include_once(G5_LIB_PATH.'/aes_encrypt.php');


$ch = curl_init();

// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
// curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5);

function getHashPath($user_id, $it_id){
	$ext = '.png';

	$target_name = md5($user_id.$it_id);

	// $root = dirname(__DIR__);
	$upddr = "/res/{$user_id}/";

	if (!is_dir($upddr ))
        mkdir($upddr, 0777, true);
	
	$target_file = $upddr . basename($target_name.$ext);

	return $target_file;
}


function request_virtual_fitting($item, $mb_id){
	global $ch;
	$cate = 0;
	$item_id = 0;
	$sql = "";


	// $get_num_sql = "SELECT mb_no FROM `CoCo_member` where mb_id = '{$mb_id}'";
	// $row = sql_fetch_array(sql_query($get_num_sql));
	// $mb_no = $row['mb_no'];
	// $data = Array();


	// foreach($items as $ca => $it_id){
	// 	$sql = "SELECT it_img1 FROM `CoCo_item` where it_id='{$it_id}'";
	// 	$row = sql_query($sql);
	// 	$row = sql_fetch_array($row);
	// 	$cate = $ca;
	// 	$item_id = $row['it_img1'];
	// 	$data[$ca] = [];
	// 	array_push($data[$ca], $item_id);
	// }

	// $ff = explode ("/", $row['it_img1'])[0];


	// $mb_no = "000005";
	// $ff = "000010";

    // $postData = array(
	//     'userid' => "{$mb_no}",
	// 	'productid' => "{$ff}",
	// 	'category' => "{$cate}",
	// );

	$upperid = $item['upperid'];
	$lowerid = $item['lowerid'];

	$postData = array(
	    'userid' => "{$mb_id}",
		'upperid' => "{$upperid}",
		'lowerid' => "{$lowerid}",
		'category' => '0000',
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
		"src" => getHashPath($mb_id, $upperid.$lowerid),
	);

	if(curl_errno($ch)){
		$output['result'] = 0;
		$output['src'] = NULL;

		return json_encode($output);
	}

//	$codi_url_sql = "UPDATE CoCo_cody SET image_url='https://www.google.co.kr/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png' where mb_id='{$mb_id}'";
	// $codi_url_sql = "UPDATE CoCo_cody SET image_url='{resopnse_url}' where mb_id='{$mb_id}'";
//	sql_query($codi_url_sql);



	$codi_url_sql = "UPDATE CoCo_cody SET image_url='{$output['src']}' where mb_id='{$mb_id}'";
	sql_query($codi_url_sql);



	return json_encode($output);
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