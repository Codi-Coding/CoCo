<?php
$sub_menu = "350909";
include_once("./_common.php");

include_once G5_LIB_PATH.'/common.lib.php';

function delTreeNoRoot($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return;
}

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if ($_POST['g5_shop_uninstall'] == '')
    alert("비정상적인 접근입니다.");

if (defined('G5_USE_SHOP') && G5_USE_SHOP)
    alert("현재 쇼핑몰 이용 중입니다. 먼저 쇼핑몰을 '이용하지 않음'으로 변경해 주십시요.");

$g5['title'] = "쇼핑몰 모듈 삭제";
include_once ("../../../../admin.head.php");

$test = 0;

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;

//print_r($_POST); exit;

$g5_shop_uninstall = 0;
$g5_shop_prefix = G5_SHOP_TABLE_PREFIX;
if($g5_shop_prefix == '') $g5_shop_prefix = 'g5_shop_';
if (isset($_POST['g5_shop_uninstall']))
    $g5_shop_uninstall= $_POST['g5_shop_uninstall'];
?>
<section class="cbox">
<div>
    <h2>쇼핑몰 모듈 삭제가 시작되었습니다.</h2>

    <ol>
<?php
// 쇼핑몰 테이블 삭제 -----------------------------
if($g5_shop_uninstall) {
    $file = implode('', file(G5_PATH.'/install/sql_buildershop.sql'));
    eval("\$file = \"$file\";");

    $file = preg_replace('/^--.*$/m', '', $file);
    $file = preg_replace('|^/\*.*$|m', '', $file);
    $file = preg_replace('/`g5_shop_([^`]+`)/', '`'.$g5_shop_prefix.'$1', $file);
    $f = explode(';', $file);
    for ($i=0; $i<count($f); $i++) {
        if (trim($f[$i]) == '') continue;
        if (!preg_match('/^drop table/i', trim($f[$i]))) continue;
	echo $f[$i].'<br/>';
        if(!$test) sql_query($f[$i]);
    }
}
// 테이블 삭제 ------------------------------------
?>
<br/>
        <li>테이블 삭제 완료</li>
<br/>
<?php
//-------------------------------------------------------------------------------------------------

// 디렉토리 내용 삭제

if($g5_shop_uninstall) {
    $dir_arr = array (
        $data_path.'/banner',
        $data_path.'/event',
        $data_path.'/item'
    );

    for ($i=0; $i<count($dir_arr); $i++) {
        echo $dir_arr[$i].'<br/>';
        if(!$test) @delTreeNoRoot($dir_arr[$i]);
    }
}
?>
<br/>
        <li>데이터 디렉터리 내용 삭제 완료</li>
<br/>
<?php
//-------------------------------------------------------------------------------------------------

// 쇼핑몰 DB설정 파일 삭제

if($g5_shop_uninstall) {
    $file = '../../../../../data/shop.dbconfig.php';
    echo $file.'<br/>';
    if(!$test) { if(file_exists($file)) unlink($file); }
}
?>
<br/>
        <li>쇼핑몰 DB설정 파일 삭제 완료</li>
    </ol>

    <p>쇼핑몰 모듈 삭제가 완료되었습니다. (* 프로그램에 대한 삭제는 ftp를 이용해 주시기 바랍니다.)</p>

</div>
</section>

<section class="cbox">
<div>

    <div>
        <a href="../../index.php" style="display:inline-block;text-decoration:none;font-size:13px;background:#eee;padding:10px;border:1px solid #ddd;border-radius:3px">모듈 관리로 이동</a>
    </div>

</div>
</section>

<?php
include_once ("../../../../admin.tail.php");
?>
