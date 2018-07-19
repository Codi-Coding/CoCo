<?php // 굿빌더 ?>
<?php
$sub_menu = "350605";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if(preg_match('/^shop_/', $cf_mobile_templete)) {
    if(!defined('G5_SHOP_PATH')) alert('G5_SHOP_PATH 정의되지 않음. 쇼핑몰 모듈 설치 후 이용 바랍니다.');
    if(!file_exists(G5_SHOP_PATH) and !sql_query(" DESC {$g5['g5_shop_default_table']} ", false))
        alert('쇼핑몰 모듈 설치 후 이용 바랍니다.');
    if(!(defined('G5_USE_SHOP') && G5_USE_SHOP))
        alert('모듈 관리에서 쇼핑몰 설치 또는 이용 설정 후 이용 바랍니다.');
}

$sql = " select * from $g5[config2w_m_board_table] where cf_id='$g5[mobile_tmpl]' ";
$res = sql_query($sql);
$config2w_m_board_all = array();
while($row = sql_fetch_array($res)) {
    $config2w_m_board_all[] = array_slice($row, 1);
}

/// 현재 화일 백업 후 새로운 설정 정보 저장

$cfile = "$g5[mobile_tmpl_path]/local_setup.php";
$bfile = "$g5[mobile_tmpl_path]/local_setup.bak.php";
$arr = file($cfile);

/// if(file_exists($cfile)) copy($cfile, $bfile); /// 생략

$cstring  = "<?php\n";
$cstring .= "if (!defined('_GNUBOARD_')) exit;\n";
$cstring .= "\n";
$cstring .= "\$config2w_m_local = ".var_export(array_slice($config2w_m, 1), true).";\n";
$cstring .= "\$config2w_m_config_local = ".var_export(array_slice($config2w_m_config, 1), true).";\n";
$cstring .= "\$config2w_m_board_all_local = ".var_export(array_slice($config2w_m_board_all, 0), true).";\n";
$cstring .= "?>";

file_put_contents($cfile, $cstring);

goto_url("./basic_tmpl_setupfile.php");
///echo "<script>alert('화일로 저장되었습니다.');history.go(-1);</script>";
?>
