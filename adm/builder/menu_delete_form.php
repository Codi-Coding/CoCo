<?php // 굿빌더 ?>
<?php
$sub_menu = "350304";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "메뉴 삭제";
include_once (G5_ADMIN_PATH."/admin.head.php");

$res = sql_query(" select distinct cf_menu from {$g5['config2w_menu_table']} ");
$arr = array();
while($row = sql_fetch_array($res)) { if($row['cf_menu']) $arr[] = $row['cf_menu']; }

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<form name="fconfigform" id="fconfigform" method="post" action="./menu_delete_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<div style="float:right"><?php if($g5['work_menu']) echo "<span class='work_menu'>작업 메뉴: ".$g5['menu']."</span> | "; ?>현재 메뉴: <?php echo $config2w['cf_menu']?></div>
<h2>메뉴 삭제</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td>메뉴 삭제</td>
    <td>* 기본(basic) 메뉴, 현재 메뉴(<?php echo $config2w['cf_menu']; ?>)<?php if($g5['work_menu']) echo ", 작업 메뉴(".$g5['menu'].")"; ?>은 삭제할 수 없슴.<br><br>
    <select name=cf_menu>
    <option value=''>== 아래에서 선택 ==</option>
<?php
        for ($i = 0; $i < count($arr); $i++) {
            if($arr[$i] == 'basic' or $arr[$i] == $config2w['cf_menu'] or $arr[$i] == $g5['menu']) continue;
            echo "    <option value='{$arr[$i]}'>{$arr[$i]}</option>\n";
        }
?>    </select> 
    <br/>
    <br/>
    <?php echo help("메뉴를 선택하십시요. 선택된 메뉴의 데이타베이스 정보가 삭제됩니다.")?>
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
    if(f.cf_menu.value == '') { alert('메뉴를 선택해 주십시요.'); return; }

    if(f.cf_menu.value == 'basic') { alert('basic 메뉴입니다.'); return; }

    if(f.cf_menu.value == '<?php echo $config2w['cf_menu']?>') { alert('사용 중인 메뉴입니다.'); return; }

    if(f.cf_menu.value == '<?php echo $g5['menu']?>') { alert('작업 중인 메뉴입니다.'); return; }

    if(confirm("한번 삭제한 메뉴는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
        f.action = "./menu_delete_form_update.php";
        f.submit();
    } else {
        return false;
    }
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
