<?php
$gmnow = gmdate('D, d M Y H:i:s').' GMT';
header('Expires: 0'); // rfc2616 - Section 14.21
header('Last-Modified: ' . $gmnow);
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Pragma: no-cache'); // HTTP/1.0
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="Cache-Control" content="no-cache"/> 
<meta http-equiv="Expires" content="0"/> 
<meta http-equiv="Pragma" content="no-cache"/>
<title>Eyoom Builder Install</title>
<link rel="stylesheet" href="install.css">
</head>
<body>

<div id="ins_bar">
    <span id="bar_img">EYOOM BUILDER</span>
    <span id="bar_txt">INSTALLATION</span>
</div>

<?php
// 파일이 존재한다면 설치할 수 없다.
$eyoom_config_file 		= G5_DATA_PATH.'/eyoom.config.php';
$levelset_config_file 	= G5_DATA_PATH.'/eyoom.levelset.php';
$levelinfo_config_file 	= G5_DATA_PATH.'/eyoom.levelinfo.php';
$eyoom_config 			= '../..'.$eyoom_config_file;
$levelset_config 		= '../..'.$levelset_config_file;
$levelinfo_config 		= '../..'.$levelinfo_config_file;
if (file_exists($eyoom_config)) {
?>
<h1>이윰빌더가 이미 설치되어 있습니다.</h1>

<div class="ins_inner">
    <p>이윰빌더(Eyoom Builder)가 이미 설치되어 있습니다.<br />새로 설치하시려면 다음 파일을 삭제 하신 후 새로고침 하십시오.</p>
    <ul>
        <li><?php echo $eyoom_config_file ?></li>
    </ul>
</div>
<div class="ins_inner">
    <div class="inner_btn">
        <a href="../../">메인페이지로 이동</a>
    </div>
</div>
<?php
include_once ('./install.tail.php');
exit;
}
?>