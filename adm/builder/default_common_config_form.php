<?php // 굿빌더 ?>
<?php
$sub_menu = "350101";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "공통 이용 설정";
include_once (G5_ADMIN_PATH."/admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<form name="fconfigform" id="fconfigform" method="post" action="./default_common_config_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<div style="float:right"><?php if($g5['work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_def['cf_templete']?></div>
<h2>공통 이용 여부 설정</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td>공통 로고 이용 여부 선택</td>
    <td>
    <div style="float:right">공통 로고: <?php echo($config2w['cf_use_common_logo'])?'이용':'이용하지 않음'?></div>
    <select name=cf_use_common_logo>
<?php
     $true_selected  = '';
     $false_selected = '';
     if($config2w['cf_use_common_logo']) $true_selected = 'selected';
     else $false_selected = 'selected';
     echo "    <option value='1' $true_selected>이용</option>\n";
     echo "    <option value='0' $false_selected>이용하지 않음</option>\n";
?>    </select>
    &nbsp; <input type=checkbox name=cf_all_common_logo_chk value='1'>전체 템플릿에 적용
    <?php echo help("공통 로고 이용 여부를 선택하십시요. 공통 로고는 /img 디렉터리를 사용합니다.")?>
    </td>
</tr>
<tr class='ht2'>
    <td>공통 메뉴 이용 여부 선택</td>
    <td>
    <div style="float:right">공통 메뉴: <?php echo ($config2w['cf_use_common_menu'])?'이용':'이용하지 않음'?></div>
    <select name=cf_use_common_menu>
<?php
     $true_selected  = '';
     $false_selected = '';
     if($config2w['cf_use_common_menu']) $true_selected = 'selected';
     else $false_selected = 'selected';
     echo "    <option value='1' $true_selected>이용</option>\n";
     echo "    <option value='0' $false_selected>이용하지 않음</option>\n";
?>    </select>
    &nbsp; <input type=checkbox name=cf_all_common_menu_chk value='1'>전체 템플릿에 적용
    <?php echo help("공통 메뉴 이용 여부를 선택하십시요. 공통 메뉴는 'basic' 템플릿의 메뉴를 사용합니다.")?>
    </td>
</tr>
<tr class='ht2'>
    <td>공통 주소 이용 여부 선택</td>
    <td>
    <div style="float:right">공통 주소: <?php echo ($config2w['cf_use_common_addr'])?'이용':'이용하지 않음'?></div>
    <select name=cf_use_common_addr>
<?php
     $true_selected  = '';
     $false_selected = '';
     if($config2w['cf_use_common_addr']) $true_selected = 'selected';
     else $false_selected = 'selected';
     echo "    <option value='1' $true_selected>이용</option>\n";
     echo "    <option value='0' $false_selected>이용하지 않음</option>\n";
?>    </select>
    &nbsp; <input type=checkbox name=cf_all_common_addr_chk value='1'>전체 템플릿에 적용
    <?php echo help("공통 주소 이용 여부를 선택하십시요. 공통 주소는 'basic' 템플릿의 '페이지 기본 설정' 데이타를 사용합니다.")?>
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
    f.action = "./default_common_config_form_update.php";
    f.submit();
}
</script>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
