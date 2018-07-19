<?php // 굿빌더 ?>
<?php
$sub_menu = "350303";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "메뉴 생성";
include_once (G5_ADMIN_PATH."/admin.head.php");

$res = sql_query(" select distinct cf_menu from {$g5['config2w_menu_table']} ");
$arr = array();
while($row = sql_fetch_array($res)) { if($row['cf_menu']) $arr[] = $row['cf_menu']; }

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<form name="fconfigform" id="fconfigform" method="post" action="./menu_create_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<div style="float:right"><?php if($g5['work_menu']) echo "<span class='work_templete'>작업 메뉴: ".$g5['work_menu']."</span> | "; ?>현재 메뉴: <?php echo $config2w['cf_menu']?></div>
<h2>메뉴 생성</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td>메뉴 생성</td>
    <td valign=middle>복사할 메뉴:
    <select name=src_cf_menu>
<?php
        for ($i = 0; $i < count($arr); $i++) {
            if($arr[$i] == 'basic')
                echo "    <option value='{$arr[$i]}' selected>{$arr[$i]}</option>\n";
            else
                echo "    <option value='{$arr[$i]}'>{$arr[$i]}</option>\n";
        }
?>    </select> 
    <br/>
    <br/>
    <input type=text class="frm_input" style="width:200px" name='cf_menu' value='<?php echo $cf_menu?>'> <?php echo help("메뉴 이름을 입력하십시요. 입력된 이름의 메뉴가 생성됩니다.")?>
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
    f.action = "./menu_create_form_update.php";
    f.submit();
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
