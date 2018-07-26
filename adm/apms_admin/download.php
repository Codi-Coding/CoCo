<?php
define('APMS_CHECK', false);
include_once('./_common.php');

// clean the output buffer
ob_end_clean();

switch($pf) {
	case '2'	: $sub_menu = '888002'; $dir = 'partner'; $pf_file = G5_DATA_PATH.'/apms/'.$dir; break;
	default		: $sub_menu = '888003'; $dir = 'item'; $pf_file = G5_DATA_PATH.'/item/'.$pf_id; break;
}

auth_check($auth[$sub_menu], 'w');

$no = (int)$no;

$sql = " select pf_source, pf_file from {$g5['apms_file']} where pf_id = '$pf_id' and pf_dir = '$pf' and pf_no = '$no' ";
$file = sql_fetch($sql);
if (!$file['pf_file'])
    alert('파일 정보가 존재하지 않습니다.');


$filepath = $pf_file.'/'.$file['pf_file'];
$filepath = addslashes($filepath);
if (!is_file($filepath) || !file_exists($filepath)) {
    alert('파일이 존재하지 않습니다.');
}

$original = urlencode($file['pf_source']);

if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
    header("content-type: doesn/matter");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-transfer-encoding: binary");
} else {
    header("content-type: file/unknown");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-description: php generated data");
}
header("pragma: no-cache");
header("expires: 0");
flush();

$fp = fopen($filepath, 'rb');

// 4.00 대체
// 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 방법보다는 이방법이...
//if (!fpassthru($fp)) {
//    fclose($fp);
//}

$download_rate = 10;

while(!feof($fp)) {
    //echo fread($fp, 100*1024);
    /*
    echo fread($fp, 100*1024);
    flush();
    */

    print fread($fp, round($download_rate * 1024));
    flush();
    usleep(1000);
}
fclose ($fp);
flush();
?>
