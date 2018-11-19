<?php

include_once(dirname(__DIR__).'/_common.php');
include_once(dirname(__DIR__)."/data/CoCo_config.php");
include_once(G5_LIB_PATH.'/aes_encrypt.php');


// $ch = curl_init();

// // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
// // curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// // curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5);


function image_fix_orientation($filename) {
    $exif = exif_read_data($filename);
    if (!empty($exif['Orientation'])) {
        $image = imagecreatefromjpeg($filename);
        switch ($exif['Orientation']) {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;

            case 6:
                $image = imagerotate($image, -90, 0);
                break;

            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }

        imagejpeg($image, $filename, 90);
    }
}

function getHashPath($user_id, $it_id){
	$ext = '.png';

	$target_name = md5($user_id.$it_id);
	$mb_memo = sql_fetch_array(sql_query("select mb_memo from CoCo_member where mb_id = '{$user_id}'"));
	
	$upddr = dirname(__DIR__)."/res/{$user_id}/{$mb_memo["mb_memo"]}/";
	if (!is_dir($upddr))
        mkdir($upddr, 0777, true);
	
	$target_file = $upddr . basename($target_name.$ext);

	return $target_file;
}


function request_virtual_fitting($item, $mb_id){
	$ch = curl_init();
	curl_setopt_array($ch, array(
	    CURLOPT_URL => DeepLearning_Server.'/submit',
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_POST => true,
	    CURLOPT_POSTFIELDS => $item,
	    CURLOPT_FOLLOWLOCATION => true
	));


	$re = curl_exec($ch);

	$output = array(
		"result" => 1,
		"src" => getHashPath($mb_id, $item['upperid'].$item['lowerid']),
	);

	$output["src"] = explode("CoCo", $output["src"])[1];

	if(curl_errno($ch)){
		$output['result'] = 0;
		$output['src'] = NULL;

		return json_encode($output);
	}


	$codi_url_sql = "UPDATE CoCo_cody SET image_url='{$output['src']}' where mb_id='{$mb_id}'";
	sql_query($codi_url_sql);


	return json_encode($output);
}

function notification_user($member, $filePath){
	$curlFile = curl_file_create($filePath);
	$post = array('userid' => "{$member['mb_id']}",'imageid' => "{$member['mb_memo']}",'userpicture'=> $curlFile );
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, DeepLearning_Server."/userupload");
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_exec($ch);
	curl_close($ch);
	return 0;
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

function makeSavePath(&$item1){
	$tmp = $item1;
	$tmp = explode("Project\CoCo", $item1)[1];
	if($tmp == NULL)
		$tmp = explode("Project/CoCo", $item1)[1];

	$item1 = $tmp;
}

?>