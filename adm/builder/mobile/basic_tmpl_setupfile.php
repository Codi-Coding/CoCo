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
?>
<div class="btn_confirm01 btn_confirm">
    <a href="./basic_tmpl_setupinfo.php">설정 DB 보기 &gt;&gt;</a>
</div>

<section class="cbox">
<div style="float:right"><?php if($g5['mobile_work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['mobile_work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_m_def['cf_mobile_templete']?></div>
<h2>템플릿 설정 화일</h2>
<table class="frm_tbl">
<colgroup width=150>
<colgroup width=''>
<tr class='ht2'>
    <td valign=top style="padding:10px 5px 5px 5px">템플릿 설정 정보
    <br/><br/><br/><font color=gray> * 도움말
    <br/><br/>템플릿을 개발하여 배포하는 경우에는 개발 완료시 템플릿 DB 설정 정보를 이 템플릿 화일 (<b>local_setup.php</b>)로 "저장"해 주십시요.
    </td>
    <td valign=top style="padding:12px 5px 5px 10px">
    <textarea style="width:100%; height:500px" readonly><?php
    $local_file = "$g5[mobile_tmpl_path]/local_setup.php";
    echo file_get_contents($local_file);
    ?></textarea>
    </td>
</tr>
</table>
</section>

<div class="btn_confirm01 btn_confirm">
    <a href="./basic_tmpl_setupinfo.php">설정 DB 보기 &gt;&gt;</a>
</div>

<?php
include_once (G5_ADMIN_PATH."/admin.tail.php");
?>
