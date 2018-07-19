<?php
$sub_menu = "350909";
include_once("./_common.php");

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

if ($_POST['g5_shop_uninstall_check'] == '')
    alert("비정상적인 접근입니다.");

if (defined('G5_USE_SHOP') && G5_USE_SHOP)
    alert("현재 쇼핑몰 이용 중입니다. 먼저 쇼핑몰을 '이용하지 않음'으로 변경해 주십시요.");

$g5['title'] = "쇼핑몰 모듈 삭제";
include_once ("../../../../admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;

//print_r($_POST); exit;

$g5_shop_prefix = G5_SHOP_TABLE_PREFIX;
if($g5_shop_prefix == '') $g5_shop_prefix = 'g5_shop_';
if (isset($_POST['g5_shop_uninstall_check']))
    $g5_shop_uninstall_check= $_POST['g5_shop_uninstall_check'];

?>
<section class="cbox">
<div>
    <h2>삭제될 목록들입니다</h2>

    <ol>
<br/>
        <li>삭제될 테이블 목록</li>
<br/>
<?php
// 쇼핑몰 테이블 삭제 -----------------------------
if($g5_shop_uninstall_check) {
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
    }
}
// 테이블 삭제 ------------------------------------
?>
<br/>
        <li>삭제될 데이터 디렉터리 내용 목록 (디렉터리 내부만 삭제)</li>
<br/>
<?php
//-------------------------------------------------------------------------------------------------

// 디렉토리 내용 삭제

if($g5_shop_uninstall_check) {
    $dir_arr = array (
        $data_path.'/banner',
        $data_path.'/event',
        $data_path.'/item'
    );

    for ($i=0; $i<count($dir_arr); $i++) {
        echo $dir_arr[$i].'<br/>';
    }
}
?>
<br/>
        <li>삭제될 쇼핑몰 DB설정 파일 목록</li>
<br/>
<?php
//-------------------------------------------------------------------------------------------------

// 쇼핑몰 DB설정 파일 삭제

if($g5_shop_uninstall_check) {
    $file = '../../../../../data/shop.dbconfig.php';
    echo $file.'<br/>';
}
?>
    </ol>

</div>
</section>

<form method=post action="./uninstall.php">

<section class="cbox">
<div style='margin:0 auto; padding:10p; text-align:left'>
아래 버튼을 클릭하시면 삭제가 진행됩니다.</br/>
(* 프로그램에 대한 삭제는 진행되지 않습니다. 프로그램에 대한 삭제는 ftp를 이용해 주시기 바랍니다.)
</div>
</section>

<div class="btn_confirm01 btn_confirm">
<input type=hidden name=g5_shop_uninstall value=1>
<input type=submit value="삭제" class="btn_submit">
</div>

</form>

<?php
include_once ("../../../../admin.tail.php");
?>
