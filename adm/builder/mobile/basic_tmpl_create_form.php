<?php // 굿빌더 ?>
<?php
$sub_menu = "350702";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "모바일 템플릿 생성";
include_once (G5_ADMIN_PATH."/admin.head.php");

$res = sql_query(" select distinct cf_id from {$g5['config2w_m_table']} ");
$tmpl_arr_db = array();
while($row = sql_fetch_array($res)) { if($row['cf_id']) $tmpl_arr_db[] = $row['cf_id']; }

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<form name="fconfigform" id="fconfigform" method="post" action="./basic_tmpl_create_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<div style="float:right"><?php if($g5['mobile_work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['mobile_work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_m_def['cf_mobile_templete']?></div>
<h2>템플릿 생성</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td>템플릿 생성</td>
    <td valign=middle>복사할 템플릿:
    <select name=src_cf_id>
<?php
        $arr = scandir("$g5[mobile_path]/$g5[mobile_tmpl_dir]");
        for ($i = 0; $i < count($arr); $i++) {
            if($arr[$i] == '.' or $arr[$i] == '..' or is_file("$g5[mobile_path]/$g5[mobile_tmpl_dir]/{$arr[$i]}")) continue;
            if(!in_array($arr[$i], $tmpl_arr_db)) continue;
            if($arr[$i] == 'basic')
                echo "    <option value='{$arr[$i]}' selected>{$arr[$i]}</option>\n";
            else
                echo "    <option value='{$arr[$i]}'>{$arr[$i]}</option>\n";
        }
?>    </select> 
    <input type=checkbox name=chk_no_copy_file value='1'>템플릿 파일은 복사하지 않음 (* 별도로 템플릿 파일을 업로드한 경우)
    <?php echo help("복사할 템플릿 이름을 선택하십시요. 선택된 이름의 템플릿 데이타 베이스 정보 및 템플릿 파일이 복사됩니다.<br>'템플릿 파일은 복사하지 않음'이 체크된 경우, 템플릿 파일은 복사되지 않습니다.<br>'템플릿 파일은 복사하지 않음'이 체크되었으나 업로드된 템플릿 파일이 존재하지 않는 경우, 선택된 템플릿의 파일이 함께 복사됩니다.")?><br>
    <input type=text class="frm_input" size='15' name='cf_id' value='<?php echo $cf_id?>'> <?php echo help("템플릿 이름을 입력하십시요. 입력된 이름의 템플릿이 생성됩니다.")?>
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
    f.action = "./basic_tmpl_create_form_update.php";
    f.submit();
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
