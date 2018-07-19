<?php // 굿빌더 ?>
<?php
$sub_menu = "350501";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "모바일 기본 설정";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<form name="fconfigform" id="fconfigform" method="post" action="./default_basic_config_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<div style="float:right"><?php if($g5['mobile_work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['mobile_work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_m_def['cf_mobile_templete']?></div>
<h2>기본 설정</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
	<td>
		상단 검색 박스
	</td>
	<td valign=middle>
                <select id='cf_search' name='cf_search' required itemname="상단 검색 박스">
                <?php
                    echo "<option value='nouse'>미사용</option>\n";
                    echo "<option value='use'>사용</option>\n";
                ?>
                </select>
                <script type="text/javascript"> document.getElementById('cf_search').value="<?php echo $config2w_m['cf_search']?>";</script>
	</td>
</tr>
<tr class='ht2'>
	<td>
		상단 메뉴 방식
	</td>
	<td valign=middle>
                <select id='cf_menu_style' name='cf_menu_style' required itemname="상단 메뉴 방식">
                <?php
                    echo "<option value='list'>list</option>\n";
                    echo "<option value='button'>button</option>\n";
                ?>
                </select>
                <script type="text/javascript"> document.getElementById('cf_menu_style').value="<?php echo $config2w_m['cf_menu_style']?>";</script>
	</td>
</tr>
<tr class='ht2'>
	<td>
		상단 메인 이미지
	</td>
	<td valign=middle>
                <select id='cf_main_image' name='cf_main_image' required itemname="상단 메인 이미지">
                <?php
                    echo "<option value='nouse'>미사용</option>\n";
                    echo "<option value='use'>사용</option>\n";
                ?>
                </select>
                <script type="text/javascript"> document.getElementById('cf_main_image').value="<?php echo $config2w_m['cf_main_image']?>";</script>
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
    f.action = "./default_basic_config_form_update.php";
    f.submit();
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
