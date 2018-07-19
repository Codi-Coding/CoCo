<?php // 굿빌더 ?>
<?php
$sub_menu = "350404";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "우측 화면 편집";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<form name="fconfigform" id="fconfigform" method="post" action="./main_right_config_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<div style="float:right"><?php if($g5['work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_def['cf_templete']?></div>
<h2>우측 화면 편집</h2>
<table class="frm_tbl">
<colgroup width=80 class='col2 pad2'>
<colgroup width=80 class='col2 pad2'>
<colgroup width=370 class='col2 pad2'>
<colgroup width=120 class='col2 pad2'>
<colgroup width='' class='col2 pad2'>
<tr class='ht' bgcolor=#f5f5f5>
    <td><b>순서</b></td>
    <td><b>미사용</b></td>
    <td><b>화면 스킨</b></td>
    <td><b>스타일</b></td>
    <td><b>관리자 모드</b></td>
</tr>
<?php for ($i = 0; $i < $config2w['cf_max_main_right']; $i++) { ?>
<tr class='ht'>
    <td valign=middle><input type=text class="frm_input" size='2' name='cf_main_right_sort[<?php echo $i?>]' value='<?php echo $i?>'> <?php ///echo help("우측 화면 정렬 순서를 입력하십시요.")?></td>
    <td valign=middle><input type=checkbox name='cf_main_right_nouse[<?php echo $i?>]' value='checked' <?php echo $config2w['cf_main_right_nouse_'.$i]?>> <?php ///echo help("미사용시 체크해 주십시요.")?></td>
    <td valign=middle><input type=text class="frm_input" style='width:300px' name='cf_main_right_name[<?php echo $i?>]' value='<?php echo $config2w['cf_main_right_name_'.$i]?>'> <?php ///echo help("스킨 이름을 입력하십시요. 입력되지 않은 필드는 무시됩니다.")?></td>
    <td valign=middle><input type=text class="frm_input" style='width:80px' name='cf_main_right_style[<?php echo $i?>]' value='<?php echo $config2w['cf_main_right_style_'.$i]?>'> <?php ///echo help("스타일 이름을 입력하십시요. css/style.css를 참조하십시요.")?></td>
    <td valign=middle><input type=checkbox name='cf_main_right_admin[<?php echo $i?>]' value='checked' <?php echo $config2w['cf_main_right_admin_'.$i]?>> 관리자 모드 <?php ///echo help("관리자 모드에서만 사용할 것인지 체크하십시요.")?></td>
</tr>
<?php } ?>
</table>
</section>

<div class="btn_confirm01 btn_confirm">
    <input type=submit class=btn_submit accesskey='s' value='  확  인  ' onClick='javascript:fconfigform_submit(document.fconfigform);'>
</div>

</form>

<section class="cbox">
<br>
<b>* 도움말</b><br><br>
<div style="margin-left:10px">
[순서]
<?php echo help("화면 정렬 순서를 입력하십시요.")?>
[미사용]
<?php echo help("미사용시 체크해 주십시요.")?>
[화면 스킨]
<?php echo help("스킨 이름을 입력하십시요. 입력되지 않은 필드는 무시됩니다.")?>
[스타일]
<?php echo help("스타일 이름을 입력하십시요. css/style.css를 참조하십시요.")?>
[관리자 모드]
<?php echo help("관리자 모드에서만 사용할 것인지 체크하십시요.")?>
</div>
</section>

<script language="javascript">
function fconfigform_submit(f)
{
    f.action = "./main_right_config_form_update.php";
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
