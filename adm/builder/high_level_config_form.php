<?php // 굿빌더 ?>
<?php
$sub_menu = "350901";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

$g5['title'] = "고급 설정";
include_once ("../admin.head.php");

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<form name="fconfigform" id="fconfigform" method="post" action="./high_level_config_form_update.php" onsubmit="return fconfigform_submit(this);">

<section class="cbox">
<!--<div style="float:right"><?php if($g5['work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_def['cf_templete']?></div>-->
<h2>템플릿 스킨 등 이용 여부 설정</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td>템플릿 스킨 이용</td>
    <td>
    <div style="float:right">템플릿 스킨 이용: <?php echo (defined('G5_USE_TMPL_SKIN') and G5_USE_TMPL_SKIN)?'YES':'NO'?></div>
    <select name=use_tmpl_skin>
    <?php
    $true_selected  = '';
    $false_selected = '';
    if(defined('G5_USE_TMPL_SKIN') and G5_USE_TMPL_SKIN) $true_selected = 'selected';
    else $false_selected = 'selected';
    echo "    <option value='true' $true_selected>YES</option>\n";
    echo "    <option value='false' $false_selected>NO</option>\n";
    ?>    </select>
    <?php echo help("템플릿 스킨 이용 여부를 선택하십시요.")?>

    <?php
    if((defined('G5_USE_TMPL_SKIN') and G5_USE_TMPL_SKIN) and !isset($config2w_config)) echo "<font color=#ff0000>(* 템플릿 스킨 처리 모듈이 설치되어 있지 않습니다)</font>";
    ?>
    </td>
</tr>
<tr class='ht2'>
    <td>다국어 이용</td>
    <td>
    <div style="float:right">다국어 이용: <?php echo (defined('G5_USE_MULTI_LANG') and G5_USE_MULTI_LANG)?'YES':'NO'?></div>
    <select name=use_multi_lang>
    <?php
    $true_selected  = '';
    $false_selected = '';
    if(defined('G5_USE_MULTI_LANG') and G5_USE_MULTI_LANG) $true_selected = 'selected';
    else $false_selected = 'selected';
    echo "    <option value='true' $true_selected>YES</option>\n";
    echo "    <option value='false' $false_selected>NO</option>\n";
    ?>    </select>
    <?php echo help("다국어 이용 여부를 선택하십시요.")?>
    <?php
    if(!file_exists(G5_PATH.'/extend/config.ml.extend.php')) echo "<font color=#ff0000>(* 다국어 처리 모듈이 설치되어 있지 않습니다)</font>";
    ?>
    </td>
</tr>
<?php if($g5['use_multi_lang']) { ?>
<tr class='ht2'>
    <td>단일 언어로만 이용</td>
    <td>
    <div style="float:right">단일 언어로만 이용: <?php echo (defined('G5_USE_MULTI_LANG_SINGLE') and G5_USE_MULTI_LANG_SINGLE)?'YES':'NO'?></div>
    <select name=use_multi_lang_single>
    <?php
    $true_selected  = '';
    $false_selected = '';
    if(defined('G5_USE_MULTI_LANG_SINGLE') and G5_USE_MULTI_LANG_SINGLE) $true_selected = 'selected';
    else $false_selected = 'selected';
    echo "    <option value='true' $true_selected>YES</option>\n";
    echo "    <option value='false' $false_selected>NO</option>\n";
    ?>    </select>
    <?php echo help("단일 언어로만 이용 여부를 선택하십시요. '단일 언어로만 이용'시 사용자 화면 상에 언어 선택 버튼이 표시되지 않습니다.")?>
    </td>
</tr>
<?php } ?>
<?php if($g5['use_multi_lang'] && $g5['is_db_trans_possible']) { ?>
<tr class='ht2'>
    <td>다국어 DB 이용</td>
    <td>
    <div style="float:right">다국어 DB 이용: <?php echo (defined('G5_USE_MULTI_LANG_DB') and G5_USE_MULTI_LANG_DB)?'YES':'NO'?></div>
    <select name=use_multi_lang_db>
    <?php
    $true_selected  = '';
    $false_selected = '';
    if(defined('G5_USE_MULTI_LANG_DB') and G5_USE_MULTI_LANG_DB) $true_selected = 'selected';
    else $false_selected = 'selected';
    echo "    <option value='true' $true_selected>YES</option>\n";
    echo "    <option value='false' $false_selected>NO</option>\n";
    ?>    </select>
    <?php echo help("다국어 DB 이용 여부를 선택하십시요.")?>
    </td>
</tr>
<?php } ?>
</table>
</section>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>

</form>

<script language="javascript">
function fconfigform_submit(f)
{
    f.action = "./high_level_config_form_update.php";
    f.submit();
}
</script>

<?php
include_once ("../admin.tail.php");
?>
