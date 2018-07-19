<?php // 굿빌더 ?>
<?php
$sub_menu = "350301";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "서브 메뉴 편집";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<form name="fconfigform" id="fconfigform" method="post" action="./submenu_config_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<div style="float:right">현재 메뉴: <?php echo $config2w_menu['cf_menu']?></div>
<h2>서브 메뉴 편집</h2>
<table class="frm_tbl">
<colgroup width=80 class='col2 pad2'>
<colgroup width=220 class='col2 pad2'>
<colgroup width=50 class='col1 pad1 bold right'>
<colgroup width='' class='col2 pad2'>
<?php $i = $_GET['i']; ?>
<tr class='ht' bgcolor=#f5f5f5>
    <td align=left><b>메인 메뉴 <?php echo $i?></b>&nbsp;&nbsp;</td>
    <td valign=middle>
    <input type=text class="frm_input" style='background:#dddddd;width:180px' name='cf_menu_name[<?php echo $i?>]' value='<?php echo $config2w_menu['cf_menu_name_'.$i]?>' readonly> <?php ///echo help("이 화면에서는 서브 메뉴 편집만 가능합니다.")?></td>
    <td align=right>링크&nbsp;&nbsp;</td>
    <td valign=middle>
    <input type=text class="frm_input" style='background:#dddddd;width:320px' name='cf_menu_link[<?php echo $i?>]' value='<?php echo $config2w_menu['cf_menu_link_'.$i]?>' readonly> <?php ///echo help("이 화면에서는 서브 메뉴 편집만 가능합니다.")?></td>
</tr>
<tr><td colspan=4 style="height:5px"></td></tr>

<tr class='ht' bgcolor=#f5f5f5>
    <td><b>순서</b></td>
    <td><b>서브 메뉴</b></td>
    <td></td>
    <td><b>링크</b></td>
</tr>

<?php for ($j = 0; $j < $config2w['cf_max_submenu']; $j++) { ?>
<tr class='ht2'>
    <td valign=middle><input type=text class="frm_input" size='2' name='cf_submenu_sort[<?php echo $j?>]' value='<?php echo $j?>'> <?php ///echo help("메뉴 정렬 순서를 입력하십시요.")?></td>
    <td valign=middle><input type=text class="frm_input" style='width:180px' name='cf_submenu_name[<?php echo $i?>_<?php echo $j?>]' value='<?php echo $config2w_menu['cf_submenu_name_'.$i.'_'.$j]?>'> <?php ///echo help("메뉴 이름을 입력하십시요.")?></td>
    <td></td>
    <td valign=middle><input type=text class="frm_input" style='width:320px' name='cf_submenu_link[<?php echo $i?>_<?php echo $j?>]' value='<?php echo $config2w_menu['cf_submenu_link_'.$i.'_'.$j]?>'> <?php ///echo help("메뉴와 연결시킬 링크를 입력하십시요.")?></td>
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
<?php echo help("메뉴 정렬 순서를 입력하십시요.")?>
[서브 메뉴]
<?php echo help("메뉴 이름을 입력하십시요.")?>
[링크]
<?php echo help("메뉴와 연결시킬 링크를 입력하십시요.")?>
</div>
</section>

<script language="javascript">
function fconfigform_submit(f)
{
    f.action = "./submenu_config_form_update.php?i=<?php echo $i?>";
}
function fconfigform_sort_submit(f)
{
    f.action = "./submenu_config_form_sort.php?i=<?php echo $i?>";
    f.submit();
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
