<?php // 굿빌더 ?>
<?php
$sub_menu = "350901";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if($use_tmpl_skin == 'true') {
    ///if(BUILDER_VERSION_CLASS != '프로') alert('먼저 프로 서비스 팩 설치 후 이용 바랍니다.');
    if(!file_exists(G5_ADMIN_PATH.'/builder/tmpl_config_form.php')) alert('프로 서비스 팩 설치 후 이용 바랍니다.');
}

if($use_multi_lang == 'true') {
    if(!file_exists(G5_PATH.'/extend/config.ml.extend.php')) alert('다국어 모듈 설치 후 이용 바랍니다.');
}

$cfile = "$g5[path]/extend/config.extend.php";
$bfile = "$g5[path]/extend.bak/config.extend.php";
copy($cfile, $bfile); 
$arr = file($cfile);

for ($i = 0; $i < count($arr); $i++) {
    if( preg_match("/define\('G5_USE_TMPL_SKIN', (.*)\)\;/", $arr[$i]) )
        $arr[$i] = "define('G5_USE_TMPL_SKIN', ".$use_tmpl_skin.");\n";
}

$cstring = implode($arr);
file_put_contents($cfile, $cstring);

$cfile = "$g5[path]/extend/config.ml.extend.php";
$bfile = "$g5[path]/extend.bak/config.ml.extend.php";
copy($cfile, $bfile); 
$arr = file($cfile);

for ($i = 0; $i < count($arr); $i++) {
    if( preg_match("/define\('G5_USE_MULTI_LANG', (.*)\)\;/", $arr[$i]) )
        $arr[$i] = "define('G5_USE_MULTI_LANG', ".$use_multi_lang.");\n";
    if( isset($_POST['use_multi_lang_single']) && preg_match("/define\('G5_USE_MULTI_LANG_SINGLE', (.*)\)\;/", $arr[$i]) )
        $arr[$i] = "define('G5_USE_MULTI_LANG_SINGLE', ".$use_multi_lang_single.");\n";
    if( isset($_POST['use_multi_lang_db']) && preg_match("/define\('G5_USE_MULTI_LANG_DB', (.*)\)\;/", $arr[$i]) )
        $arr[$i] = "define('G5_USE_MULTI_LANG_DB', ".$use_multi_lang_db.");\n";
}

$cstring = implode($arr);
file_put_contents($cfile, $cstring);

goto_url("./high_level_config_form.php");
?>
