<?php // 굿빌더 ?>
<?php
$sub_menu = "350604";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "템플릿 등록";
include_once (G5_ADMIN_PATH."/admin.head.php");

$res = sql_query(" select distinct cf_id from {$g5['config2w_table']} ");
$tmpl_arr_db = array();
while($row = sql_fetch_array($res)) { if($row['cf_id']) $tmpl_arr_db[] = $row['cf_id']; }

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<form name="fconfigform" id="fconfigform" method="post" action="./basic_tmpl_register_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<div style="float:right"><?php if($g5['work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_def['cf_templete']?></div>
<h2>템플릿 등록</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td>템플릿 등록</td>
    <td valign=middle>
    <select name=cf_id required>
    <option value=''> == 등록할 템플릿을 선택해 주십시오.== </option>
<?php
        $arr = scandir("$g5[path]/$g5[tmpl_dir]");
        for ($i = 0; $i < count($arr); $i++) {
            if($arr[$i] == '.' or $arr[$i] == '..' or is_file("$g5[path]/$g5[tmpl_dir]/{$arr[$i]}")) continue;
            if(in_array($arr[$i], $tmpl_arr_db)) continue;
            echo "    <option value='{$arr[$i]}'>{$arr[$i]}</option>\n";
        }
?>
    </select>
    <br><br>
    <input type=checkbox name=chk_local_setup value='1'> 자체 설정 화일(local_setup.php) 이용 &nbsp; 
    <input type=checkbox name=chk_sample_db value='1'> 샘플 DB (install/local_setup.sql) 등록
    <br>
    <input type=checkbox name=chk_re_setup value='1'> 재등록 (이전 정보 삭제됨)
    <br><br>
    <?php echo help("등록할 템플릿 이름을 선택하십시요. 선택된 이름의 템플릿이 등록됩니다.
    '자체 설정 화일 이용'이 아닌 경우에는 'basic' 템플릿의 설정 정보가 복사되어 등록됩니다.
    '재등록'시에는 선택에 따라 자체 설정 화일 내용 및 샘플 DB 또는 'basic' 템플릿의 설정 정보로 재등록됩니다.
    샘플 DB는 독립적으로 등록 또는 재등록할 수 있습니다.")?>
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
    f.action = "./basic_tmpl_register_form_update.php";
    f.submit();
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
