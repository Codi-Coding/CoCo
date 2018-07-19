<?php // 굿빌더 ?>
<?php
$sub_menu = "350606";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if ($is_admin != "super")
    alert("최고관리자만 접근 가능합니다.");

if($work_tmpl) $_SESSION['tmpl'] = $work_tmpl;
else unset($_SESSION['tmpl']);
if($mobile_work_tmpl) $_SESSION['mobile_tmpl'] = $mobile_work_tmpl;
else unset($_SESSION['mobile_tmpl']);

goto_url("./work_tmpl_config_form.php");
?>
