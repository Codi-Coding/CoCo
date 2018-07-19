<?php // 굿빌더 ?>
<?php
$sub_menu = "350302";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "메뉴 설정";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;

if(is_file(G5_TMPL_PATH.'/theme.config.php'))
    include_once(G5_TMPL_PATH.'/theme.config.php');
if(G5_USE_INTERNAL_MOBILE === true)
    $mobile_included = '(모바일 포함)';
else
    $mobile_included = '';

if(0) {
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
} /// if 0
?>
<form name="fconfigform" id="fconfigform" method="post" action="./basic_menu_config_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<div style="float:right"><?php if($g5['work_tmpl'] or $g5['mobile_work_tmpl']) echo "<span class='work_templete'>작업 템플릿: <b>".$g5['work_tmpl'].'</b> / '.$g5['mobile_work_tmpl']."</span> | "; ?>현재 템플릿: <b><?php echo $config2w_def['cf_templete'].'</b> '.$mobile_included.' / '.$config2w_m_def['cf_mobile_templete']?>, 현재 메뉴: <b><?php echo $config2w['cf_menu']; ?></b></div>
<h2>메뉴 설정</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td>메뉴 선택</td>
    <td><select name=cf_menu>
<?php
        $arr = scandir("$g5[path]/$g5[tmpl_dir]");
        $res = sql_query(" select * from $g5[config2w_menu_table] ");
        ///for ($i = 0; $i < count($arr); $i++) {
        while($row = sql_fetch_array($res)) {
            $row_menu = $row['cf_menu'];
            //if($arr[$i] == '.' or $arr[$i] == '..' or is_file("$g5[path]/$g5[tmpl_dir]/$arr[$i]")) continue;
            ///if($arr[$i] == $g5['tmpl'])
            if($row_menu == $config2w['cf_menu'])
                echo "    <option value='$row_menu' selected>$row_menu</option>\n";
            else
                echo "    <option value='$row_menu'>$row_menu</option>\n";
        }
?>    </select>
    <?php echo help("메뉴를 선택하십시요. (shop_ 메뉴는 쇼핑몰, contents_ 메뉴는 컨텐츠몰, g4_ 메뉴는 구형 사이트, r_ 메뉴는 반응형 템플릿을 위한 메뉴입니다)")?>

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
    f.action = "./basic_menu_config_form_update.php";
    f.submit();
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
