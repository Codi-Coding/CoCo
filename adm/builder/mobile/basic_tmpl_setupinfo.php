<?php // 굿빌더 ?>
<?php
$sub_menu = "350705";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "모바일 템플릿 설정 정보";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;

$sql = " select * from $g5[config2w_m_board_table] where cf_id='$g5[mobile_tmpl]' ";
$res = sql_query($sql);
$config2w_m_board_all = array();
while($row = sql_fetch_array($res)) {
    $config2w_m_board_all[] = array_slice($row, 1);
}
?>
<form name="fconfigform" id="fconfigform" method="post" action="./basic_tmpl_setupinfo_save.php" onsubmit="return fconfigform_submit(this);">

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="설정 화일에 저장" class="btn_submit" accesskey="s">
    &nbsp;&nbsp; <a href="./basic_tmpl_setupfile.php">설정 화일 보기 &gt;&gt;</a>
</div>

<section class="cbox">
<div style="float:right"><?php if($g5['mobile_work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['mobile_work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_m_def['cf_mobile_templete']?></div>
<h2>템플릿 설정 DB</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td valign=top style="padding:10px 5px 5px 5px">템플릿 설정 정보
    <br/><br/><br/><font color=gray> * 도움말
    <br/><br/>템플릿을 개발하여 배포하는 경우에는 개발 완료시 이 템플릿 설정 정보를 "화일로 저장"해 주십시요.
    해당 템플릿의 디렉터리 안에 "<b>local_setup.php</b>" 라는 이름으로 저장됩니다.
    템플릿 이용자가 "<b>템플릿 등록</b>"을 하게 되면 이 정보가 템플릿의 설정 정보로 데이타베이스에 등록됩니다.
    </font>
    </td>
    <td valign=top style="padding:12px 5px 5px 10px">
    <textarea style="width:100%; height:500px"><?php
    echo '$config2w_m = ';
    var_export(array_slice($config2w_m, 1));
    echo ';'.PHP_EOL;
    echo '$config2w_m_config = ';
    var_export(array_slice($config2w_m_config, 1));
    echo ';'.PHP_EOL;
    echo '$config2w_m_board_all = ';
    var_export(array_slice($config2w_m_board_all, 0));
    echo ';';
    ?></textarea>
    </td>
</tr>
</table>
</section>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="설정 화일에 저장" class="btn_submit" accesskey="s">
    &nbsp;&nbsp; <a href="./basic_tmpl_setupfile.php">설정 화일 보기 &gt;&gt;</a>
</div>

</form>

<script language="javascript">
function fconfigform_submit(f)
{
    f.action = "./basic_tmpl_setupinfo_save.php";
    f.submit();
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
