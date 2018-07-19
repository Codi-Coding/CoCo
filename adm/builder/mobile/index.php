<?php // 굿빌더 ?>
<?php
include_once "./_common.php";
$g5['title'] = "모바일 빌더 관리";
include_once G5_ADMIN_PATH."/admin.head.php";

///echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/builder/style.css">'.PHP_EOL;
?>
<div style="text-align: left; margin: 10px 0; font-size: 1.0em;color:#000000; line-height: 1.5em;">
&nbsp;<b><a href="basic_tmpl_config_form.php">모바일 템플릿 설정</a></b>
<br>
&nbsp;&nbsp;&nbsp;<font style="font-size:0.8em">모바일 템플릿 선택 저장</font>
<br>
<div class="line3"></div>
&nbsp;<b><a href="basic_tmpl_create_form.php">모바일 템플릿 생성</a></b>
<br>
&nbsp;&nbsp;&nbsp;<font style="font-size:0.8em">모바일 템플릿 생성</font>
<br>
<div class="line3"></div>
&nbsp;<b><a href="basic_tmpl_delete_form.php">모바일 템플릿 삭제</a></b>
<br>
&nbsp;&nbsp;&nbsp;<font style="font-size:0.8em">모바일 템플릿 삭제</font>
<br>
<div class="line3"></div>
&nbsp;<b><a href="basic_tmpl_screenshot.php">모바일 템플릿 정보</a></b>
<br>
&nbsp;&nbsp;&nbsp;<font style="font-size:0.8em">모바일 템플릿 정보</font>
<br>
<div class="line3"></div>
&nbsp;<b><a href="basic_config_form.php">모바일 페이지 기본 설정</a></b>
<br>
&nbsp;&nbsp;&nbsp;<font style="font-size:0.8em">모바일 페이지 기본 정보 설정</font>
</div>
<?php
include_once G5_ADMIN_PATH."/admin.tail.php";
?>
