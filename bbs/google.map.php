<?php
include_once('./_common.php');

function google_map_address_json($lat, $lng) {

	$url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&language=ko&key='.APMS_GOOGLE_MAP_KEY;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
	$json = json_decode(curl_exec($ch), true);
    curl_close($ch);

    return $json;
}

include_once($misc_skin_path.'/google.map.php');

?>