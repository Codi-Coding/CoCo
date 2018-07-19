<?php // 굿빌더 ?>
<?php
$sub_menu = "350701";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "모바일 템플릿 설정";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;

if(is_file(G5_TMPL_PATH.'/theme.config.php'))
    include_once(G5_TMPL_PATH.'/theme.config.php');
if(G5_USE_INTERNAL_MOBILE === true)
    $mobile_included = '(모바일 포함)';
else
    $mobile_included = '';
?>
<form name="fconfigform" id="fconfigform" method="post" action="./basic_tmpl_config_form_update.php" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="cf_templete" value="<?php echo $g5['work_tmpl'] ? $g5['work_tmpl'] : $config2w_def['cf_templete']; ?>">

<section class="cbox">
<div style="float:right"><?php if($g5['work_tmpl'] or $g5['mobile_work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['work_tmpl'].' / <b>'.$g5['mobile_work_tmpl']."</b></span> | "; ?>현재 템플릿: <?php echo  $config2w_def['cf_templete'].' '.$mobile_included.' / <b>'.$config2w_m_def['cf_mobile_templete']?></b></div>
<h2>템플릿 설정</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td>템플릿 선택</td>
    <td><select name='cf_mobile_templete'>
<?php
        $arr = scandir("$g5[mobile_path]/$g5[mobile_tmpl_dir]");
        for ($i = 0; $i < count($arr); $i++) {
            if($arr[$i] == '.' or $arr[$i] == '..' or is_file("$g5[mobile_path]/$g5[mobile_tmpl_dir]/{$arr[$i]}")) continue;
            ///if($arr[$i] == $g5['mobile_tmpl'])
            if($arr[$i] == $config2w_m_def['cf_mobile_templete'])
                echo "    <option value='{$arr[$i]}' selected>{$arr[$i]}</option>\n";
            else
                echo "    <option value='{$arr[$i]}'>{$arr[$i]}</option>\n";
        }
?>    </select>
    <?php echo help("템플릿을 선택하십시요. (shop_ 템플릿은 쇼핑몰, contents_ 템플릿은 컨텐츠몰, ml_ 템플릿은 다국어 템플릿입니다)")?>

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
    f.action = "./basic_tmpl_config_form_update.php";
    f.submit();
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
