<?php // 굿빌더 ?>
<?php
$sub_menu = "350901";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if($use_shop == 'true') {
    if(!defined('G5_SHOP_PATH')) alert('G5_SHOP_PATH 정의되지 않음. 쇼핑몰 모듈 설치 후 이용 바랍니다.');
    if(!file_exists(G5_SHOP_PATH)) alert('shop 화일 없음. 쇼핑몰 모듈 설치 후 이용 바랍니다.');
    if(!sql_query(" DESC {$g5['g5_shop_default_table']} ", false)) alert('shop_default table 없슴. 쇼핑몰 모듈 설치 후 이용 바랍니다.');
}

$cfile = "$g5[path]/data/shop.dbconfig.php";
$bfile = "$g5[path]/data/shop.dbconfig.bak.php";
copy($cfile, $bfile); 
$arr = file($cfile);

for ($i = 0; $i < count($arr); $i++) {
    ///echo "$arr[$i]<br>";
    if( preg_match("/define\('G5_USE_SHOP', (.*)\)\;/", $arr[$i]) )
        $arr[$i] = "define('G5_USE_SHOP', ".$use_shop.");\n";
}

$cstring = implode($arr);
file_put_contents($cfile, $cstring);

goto_url("../index.php");
?>
