<?php // 굿빌더 ?>
<?php
$sub_menu = "350301";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "메뉴 편집";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<form name="fconfigform" id="fconfigform" method="post" action="./menu_config_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<div style="float:right"><?php if($g5['work_menu']) echo "<span class='work_menu'>작업 메뉴: ".$g5['work_menu']."</span> | "; ?>현재 메뉴: <?php echo $config2w['cf_menu']?></div>
<h2>메뉴 편집</h2>
<table class="frm_tbl">
<colgroup width=80 class='col2 pad2'>
<colgroup width=220 class='col2 pad2'>
<colgroup width=70 class='col2 pad2'>
<colgroup width='350' class='col2 pad2'>
<colgroup width='' class='col2 pad2'>
<tr class='ht' bgcolor=#f5f5f5>
    <td scope="col"><b>순서</b></td>
    <td scope="col"><b>메인 메뉴</b></td>
    <td scope="col"><b>길이</b></td>
    <td scope="col"><b>링크</b></td>
    <td scope="col"><b>서브 메뉴</b></td>
</tr>
<?php for ($i = 0; $i < $config2w['cf_max_menu']; $i++) { ?>
<tr class='ht'>
    <td valign=middle><input type=text class="frm_input" size='2' name='cf_menu_sort[<?php echo $i?>]' value='<?php echo $i?>'> <?php ///echo help("메뉴 정렬 순서를 입력하십시요.")?></td>
    <td valign=middle><input type=text class="frm_input" style='width:180px' name='cf_menu_name[<?php echo $i?>]' value='<?php echo $config2w_menu['cf_menu_name_'.$i]?>'> <?php ///echo help("메뉴 이름을 입력하십시요.")?></td>
    <td valign=middle><input type=text class="frm_input" size='3' name='cf_menu_leng[<?php echo $i?>]' value='<?php echo $config2w_menu['cf_menu_name_'.$i]?$config2w_menu['cf_menu_leng_'.$i]:''?>'> <?php ///echo help("화면 상의 메뉴 폭을 입력하십시요.")?></td>
    <td valign=middle><input type=text class="frm_input" style='width:320px' name='cf_menu_link[<?php echo $i?>]' value='<?php echo $config2w_menu['cf_menu_link_'.$i]?>'> <?php ///echo help("메뉴와 연결시킬 링크를 입력하십시요.")?></td>
    <td valign=middle><a href="submenu_config_form.php?i=<?php echo $i?>">서브 메뉴</a></td>
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
[메인 메뉴]
    <?php echo help("메뉴 이름을 입력하십시요.")?>
[길이]
    <?php echo help("화면 상의 메뉴 폭을 입력하십시요.")?>
[링크]
    <?php echo help("메뉴와 연결시킬 링크를 입력하십시요.")?>
</div>
</section>

<script language="javascript">
function fconfigform_submit(f)
{
    f.action = "./menu_config_form_update.php";
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
