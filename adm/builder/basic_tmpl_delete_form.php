<?php // 굿빌더 ?>
<?php
$sub_menu = "350603";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "템플릿 삭제";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<form name="fconfigform" id="fconfigform" method="post" action="./basic_tmpl_delete_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<div style="float:right"><?php if($g5['work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_def['cf_templete']?></div>
<h2>템플릿 삭제</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td>템플릿 삭제</td>
    <td>* 기본(basic) 템플릿, 현재 템플릿(<?php echo $config2w_def['cf_templete']; ?>)<?php if($g5['work_tmpl']) echo ", 작업 템플릿(".$g5['tmpl'].")"; ?>은 삭제할 수 없슴.<br><br>
    <select name=cf_id>
    <option value=''>== 아래에서 선택 ==</option>
<?php
        $arr = scandir("$g5[path]/$g5[tmpl_dir]");
        for ($i = 0; $i < count($arr); $i++) {
            /// if($arr[$i] == '.' or $arr[$i] == '..' or is_file("$g5[path]/$g5[tmpl_dir]/$arr[$i]")) continue;
            if($arr[$i] == '.' or $arr[$i] == '..' or $arr[$i] == 'basic' or $arr[$i] == $config2w_def['cf_templete'] or $arr[$i] == $g5['tmpl'] or is_file("$g5[path]/$g5[tmpl_dir]/{$arr[$i]}")) continue;
            $sql = " select cf_id from $g5[config2w_table] where cf_id='{$arr[$i]}' ";
            $row = sql_fetch($sql);
            if(!$row) continue;
            echo "    <option value='{$arr[$i]}'>{$arr[$i]}</option>\n";
        }
?>    </select>
    <?php echo help("템플릿을 선택하십시요. 선택된 템플릿의 데이타베이스 정보가 삭제되며, 파일 삭제 체크시에는 선택된 템플릿의 프로그램 파일들도 함께 삭제됩니다.")?>

    <input type=checkbox name=chk_del_file value='1'>파일 삭제
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
    if(f.cf_id.value == '') { alert('템플릿을 선택해 주십시요.'); return; }

    if(f.cf_id.value == 'basic') { alert('basic 템플릿입니다.'); return; }

    if(f.cf_id.value == '<?php echo $config2w_def['cf_templete']?>') { alert('사용 중인 템플릿입니다.'); return; }

    if(f.cf_id.value == '<?php echo $g5['tmpl']?>') { alert('작업 중인 템플릿입니다.'); return; }

    if(confirm("한번 삭제한 템플릿은 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
        f.action = "./basic_tmpl_delete_form_update.php";
        f.submit();
    } else {
        return false;
    }
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
