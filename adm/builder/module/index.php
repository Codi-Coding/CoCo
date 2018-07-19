<?php // 굿빌더 ?>
<?php
$sub_menu = "350909";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "모듈 관리";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>

<section class="cbox">
<!--<div style="float:right"><?php if($g5['work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_def['cf_templete']?></div>-->
<h2>모듈 관리</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<?php
$arr = scandir(".");
for ($i = 0; $i < count($arr); $i++) {
    if($arr[$i] == '.' or $arr[$i] == '..' or is_file("./{$arr[$i]}")) continue;
?>
<tr class='ht2'>
    <td valign=top style="padding:10px 5px 5px 5px">
    <?php if(file_exists("./{$arr[$i]}/sc.png")) { ?>
    <a href="<?php echo "./{$arr[$i]}/sc.png" ?>">
    <img src="<?php echo "./{$arr[$i]}/sc.png" ?>" width=150 height=105 style="margin-left:0px; border:1px solid #dddddd; overflow:hidden">
    </a>
    <?php } else { ?>
    <img src="<?php echo "$g5[url]/images/noscreenshot.png" ?>" width=150 height=105 style="margin-left:0px; border:1px solid #dddddd; overflow:hidden">
    <?php } ?>
    </td>
    <td valign=top style="padding:12px 5px 5px 10px">
    <?php if(file_exists("./{$arr[$i]}/sc.php")) { ?>
    <?php include "./{$arr[$i]}/sc.php"; ?>
    <?php } ?>
    </td>
</tr>
<?php
}
?>
</table>
</section>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
