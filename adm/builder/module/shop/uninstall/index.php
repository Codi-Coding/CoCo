<?php // 굿빌더 ?>
<?php
$sub_menu = "350909";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if (defined('G5_USE_SHOP') && G5_USE_SHOP)
    alert("현재 쇼핑몰 이용 중입니다. 먼저 쇼핑몰을 '이용하지 않음'으로 변경해 주십시요.");

$g5['title'] = "쇼핑몰 모듈 삭제";
include_once ("../../../../admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<form method=post action="./check.php">

<section class="cbox">
<div style='margin:0 auto; padding:10p; text-align:left'>
쇼핑몰의 모든 데이타 베이스 및 프로그램이 삭제됩니다. 아래 버튼을 클릭하시면 삭제 목록 검사가 진행됩니다.
</div>
</section>

<div class="btn_confirm01 btn_confirm">
<input type=hidden name=g5_shop_uninstall_check value=1>
<input type=submit value="삭제 목록 검사" class="btn_submit">
</div>

</form>
<?php
include_once ("../../../../admin.tail.php");
?>
