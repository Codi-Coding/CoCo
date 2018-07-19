<?php // 굿빌더 ?>
<?php
$sub_menu = "350601";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "템플릿 설정";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;

if(is_file(G5_TMPL_PATH.'/theme.config.php'))
    include_once(G5_TMPL_PATH.'/theme.config.php');
if(G5_USE_INTERNAL_MOBILE === true)
    $mobile_included = '(모바일 포함)';
else
    $mobile_included = '';

if (isset($config2w['cf_id'])) {
    sql_query(" ALTER TABLE `{$g5['config2w_table']}` CHANGE `cf_id` `cf_id` varchar(255) NOT NULL default '' ", true);
}
if (isset($config2w_def['cf_templete'])) {
    sql_query(" ALTER TABLE `{$g5['config2w_def_table']}` CHANGE `cf_templete` `cf_templete` varchar(255) NOT NULL default 'basic' ", true);
}
if (isset($config2w_m['cf_id'])) {
    sql_query(" ALTER TABLE `{$g5['config2w_m_table']}` CHANGE `cf_id` `cf_id` varchar(255) NOT NULL default '' ", true);
}
if (isset($config2w_m_def['cf_templete'])) {
    sql_query(" ALTER TABLE `{$g5['config2w_m_def_table']}` CHANGE `cf_templete` `cf_templete` varchar(255) NOT NULL default 'basic' ", true);
}
if (isset($config2w_m_def['cf_mobile_templete'])) {
    sql_query(" ALTER TABLE `{$g5['config2w_m_def_table']}` CHANGE `cf_mobile_templete` `cf_mobile_templete` varchar(255) NOT NULL default 'basic' ", true);
}

$res = sql_query(" select distinct cf_id from {$g5['config2w_table']} ");
$tmpl_arr_db = array();
while($row = sql_fetch_array($res)) { if($row['cf_id']) $tmpl_arr_db[] = $row['cf_id']; }
?>
<form name="fconfigform" id="fconfigform" method="post" action="./basic_tmpl_config_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<div style="float:right"><?php if($g5['work_tmpl'] or $g5['mobile_work_tmpl']) echo "<span class='work_templete'>작업 템플릿: <b>".$g5['work_tmpl'].'</b> / '.$g5['mobile_work_tmpl']."</span> | "; ?>현재 템플릿: <b><?php echo $config2w_def['cf_templete'].'</b> '.$mobile_included.' / '.$config2w_m_def['cf_mobile_templete']?>, 현재 메뉴: <b><?php echo $config2w['cf_menu']; ?></b></div>
<h2>템플릿 설정</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td>템플릿 선택</td>
    <td><select name=cf_templete>
<?php
        $arr = scandir("$g5[path]/$g5[tmpl_dir]");
        for ($i = 0; $i < count($arr); $i++) {
            if($arr[$i] == '.' or $arr[$i] == '..' or is_file("$g5[path]/$g5[tmpl_dir]/{$arr[$i]}")) continue;
            if(!in_array($arr[$i], $tmpl_arr_db)) continue;
            ///if($arr[$i] == $g5['tmpl'])
            if($arr[$i] == $config2w_def['cf_templete'])
                echo "    <option value='{$arr[$i]}' selected>{$arr[$i]}</option>\n";
            else
                echo "    <option value='{$arr[$i]}'>{$arr[$i]}</option>\n";
        }
?>    </select>
    <?php echo help("템플릿을 선택하십시요. (shop_ 템플릿은 쇼핑몰, contents_ 템플릿은 컨텐츠몰, g4_ 템플릿은 구형 사이트 템플릿입니다)")?>
    <?php echo help("<b>등록되지 않은 템플릿</b>은 템플릿 업로드 후 먼저 <a href='./basic_tmpl_register_form.php'><b>템플릿 등록</b></a> 메뉴에서 등록해 주십시오.")?>

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
