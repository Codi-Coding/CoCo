<?php // 굿빌더 ?>
<?php
$sub_menu = "350606";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "작업 템플릿 설정";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<form name="fconfigform" id="fconfigform" method="post" action="./work_tmpl_config_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<div style="float:right"><?php if($g5['work_tmpl'] or $g5['mobile_work_tmpl']) echo "<span class='work_templete'>작업 템플릿: <b>".$g5['work_tmpl'].'</b> / '.$g5['mobile_work_tmpl']."</span> | "; ?>현재 템플릿: <b><?php echo  $config2w_def['cf_templete'].'</b> '.$mobile_included.' / '.$config2w_m_def['cf_mobile_templete']?></div>
<h2>템플릿 설정</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td>템플릿 선택</td>
    <td><select name=work_tmpl>
    <option value="">사용하지 않음
<?php
        $arr = scandir("$g5[path]/$g5[tmpl_dir]");
        for ($i = 0; $i < count($arr); $i++) {
            if($arr[$i] == '.' or $arr[$i] == '..' or is_file("$g5[path]/$g5[tmpl_dir]/{$arr[$i]}")) continue;
            if($arr[$i] == $g5['work_tmpl'])
                echo "    <option value='{$arr[$i]}' selected>{$arr[$i]}</option>\n";
            else
                echo "    <option value='{$arr[$i]}'>{$arr[$i]}</option>\n";
        }
?>    </select>
    </td>
</tr>
<tr class='ht2'>
    <td>모바일 템플릿 선택</td>
    <td><select name=mobile_work_tmpl>
    <option value="">사용하지 않음
<?php
        $arr = scandir("$g5[mobile_path]/$g5[mobile_tmpl_dir]");
        for ($i = 0; $i < count($arr); $i++) {
            if($arr[$i] == '.' or $arr[$i] == '..' or is_file("$g5[mobile_path]/$g5[mobile_tmpl_dir]/{$arr[$i]}")) continue;
            if($arr[$i] == $g5['mobile_work_tmpl'])
                echo "    <option value='{$arr[$i]}' selected>{$arr[$i]}</option>\n";
            else
                echo "    <option value='{$arr[$i]}'>{$arr[$i]}</option>\n";
        }
?>    </select>
    </td>
</tr>
</table>
</section>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>

</form>

<script language="javascript">
function fconfigform_submit(f)
{
    f.action = "./work_tmpl_config_form_update.php";
    f.submit();
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
