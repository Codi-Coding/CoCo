<?php // 굿빌더 ?>
<?php
$sub_menu = "350700";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "모바일 템플릿 정보";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>

<section class="cbox">
<div style="float:right"><?php if($g5['mobile_work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['mobile_work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_m_def['cf_mobile_templete']?></div>
<?php if($v == '1') { ?>
<span style="float:right; margin-right:30px; font-weight:bold"><a href="?v=0">전체 템플릿 정보 ▼</a></span>
<?php } else { ?>
<span style="float:right; margin-right:30px; font-weight:bold"><a href="?v=1">전체 템플릿 정보 ▼</a></span>
<?php } ?>
<h2>템플릿 정보</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<?php
if($v == '1')
    $arr = scandir("$g5[mobile_path]/$g5[mobile_tmpl_dir]");
else
    $arr = array($config2w_m_def['cf_mobile_templete']);

for ($i = 0; $i < count($arr); $i++) {
    if($arr[$i] == '.' or $arr[$i] == '..' or is_file("$g5[mobile_path]/$g5[mobile_tmpl_dir]/{$arr[$i]}")) continue;
?>
<tr class='ht2'>
    <td valign=top style="padding:10px 5px 5px 5px">
    <?php if(file_exists("$g5[mobile_path]/$g5[mobile_tmpl_dir]/{$arr[$i]}/sc.png")) { ?>
    <a href="<?php echo "$g5[mobile_url]/$g5[mobile_tmpl_dir]/{$arr[$i]}/sc.png" ?>" target="_blank">
    <img src="<?php echo "$g5[mobile_url]/$g5[mobile_tmpl_dir]/{$arr[$i]}/sc.png" ?>" width=150 height=105 style="margin-left:0px; border:1px solid #dddddd; overflow:hidden">
    </a>
    <?php } else if(file_exists("$g5[mobile_path]/$g5[mobile_tmpl_dir]/{$arr[$i]}/screenshot.png")) { ?>
    <a href="<?php echo "$g5[mobile_url]/$g5[mobile_tmpl_dir]/{$arr[$i]}/screenshot.png" ?>" target="_blank">
    <img src="<?php echo "$g5[mobile_url]/$g5[mobile_tmpl_dir]/{$arr[$i]}/screenshot.png" ?>" width=150 height=105 style="margin-left:0px; border:1px solid #dddddd; overflow:hidden">
    </a>
    <?php } else { ?>
    <img src="<?php echo "$g5[mobile_url]/images/noscreenshot.png" ?>" width=150 height=105 style="margin-left:0px; border:1px solid #dddddd; overflow:hidden">
    <?php } ?>
    </td>
    <td valign=top style="padding:12px 5px 5px 10px">
    <?php if(file_exists("$g5[mobile_path]/$g5[mobile_tmpl_dir]/{$arr[$i]}/sc.html")) { ?>
    <?php include "$g5[mobile_path]/$g5[mobile_tmpl_dir]/{$arr[$i]}/sc.html"; ?>
    <?php } else if(file_exists("$g5[mobile_path]/$g5[mobile_tmpl_dir]/{$arr[$i]}/readme.txt")) { ?>
    <?php
        $file = file("$g5[mobile_path]/$g5[mobile_tmpl_dir]/{$arr[$i]}/readme.txt");
        $file_string = implode("<br>", $file);
        echo "<span style='font-size:16px; font-weight:bold'>[".$arr[$i]."]</span><br>";
        echo "<div style='margin-top:8px; line-height:150%'>".$file_string."</div>";
    ?>
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
