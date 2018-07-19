<?php
@header('Content-Type: text/html; charset=utf-8');
@header('X-Robots-Tag: noindex');

include_once ('../../config.php');
include_once ('./setup.head.php');
include_once ('../classes/qfile.class.php');

if ((!isset($_POST['agree']) || $_POST['agree'] != '동의함') && (!isset($_POST['agree2']) || $_POST['agree2'] != '동의함')) {
?>
<div class="ins_inner">
    <p>라이선스(License) 내용에 동의하셔야 설치를 계속하실 수 있습니다.</p>

	<div class="inner_btn">
		<a href="./setup.php">뒤로가기</a>
	</div>
</div>
<?php
	exit;
}

$qfile = new qfile;
$is_config_setup = true;
?>

<form name="frm_install" id="frm_install" method="post" action="./setup_db.php" autocomplete="off" onsubmit="return frm_install_submit(this)">
<input type="hidden" name="cm_key" id="cm_key" value="">
<input type="hidden" name="cm_salt" id="cm_salt" value="">
<input type="hidden" name="tm_name" id="tm_name" value="">
<input type="hidden" name="tm_shop" id="tm_shop" value="">
<input type="hidden" name="tm_community" id="tm_community" value="">
<input type="hidden" name="tm_mainside" id="tm_mainside" value="">
<input type="hidden" name="tm_subside" id="tm_subside" value="">
<input type="hidden" name="tm_mainpos" id="tm_mainpos" value="">
<input type="hidden" name="tm_subpos" id="tm_subpos" value="">
<input type="hidden" name="tm_shopmainside" id="tm_shopmainside" value="">
<input type="hidden" name="tm_shopsubside" id="tm_shopsubside" value="">
<input type="hidden" name="tm_shopmainpos" id="tm_shopmainpos" value="">
<input type="hidden" name="tm_shopsubpos" id="tm_shopsubpos" value="">

<ul id="progressbar">
	<li class="active">초기설정</li>
	<li class="active">라이선스 동의</li>
	<li class="active">정보입력</li>
	<li>설치완료</li>
</ul>

<div class="ins_inner">
    <div class="ins_frm">
	    <h3 class="ins_frm_title">이윰빌더 KEY를 입력</h3>
	    <label for="tm_key">테마 KEY</label>
        <input name="tm_key" type="text" value="" id="tm_key">
        <input id="tmkey_confirm_button" type="button" value="확인" onclick="check_tmkey();">
        <p class="note_txt">이윰넷(<a href="http://eyoom.net" target="_blank">http://eyoom.net</a>)의 회원이시라면 <strong>마이페이지 테마관리</strong>에서 테마키를 확인하실 수 있습니다.</p>
        <p class="note_txt">만일 비회원으로 다운받으셨다면 패키지의 압축해제 후 생성된 <strong style="color:#ff6600">폴더명이 테마키</strong>입니다.</p>
    </div>
    
    <div class="ins_frm gnuboard_frm">
	    <h3 class="ins_frm_title">MySQL 정보입력</h3>
	    <div class="margin-bottom-5">
		    <label for="mysql_host">Host</label>
			<input name="mysql_host" type="text" value="localhost" id="mysql_host">
		</div>
		<div class="margin-bottom-5">
		    <label for="mysql_user">User</label>
		    <input name="mysql_user" type="text" id="mysql_user">
		</div>
		<div class="margin-bottom-5">
		    <label for="mysql_pass">Password</label>
		    <input name="mysql_pass" type="text" id="mysql_pass">
		</div>
		<div class="margin-bottom-5">
		    <label for="mysql_db">DB</label>
		    <input name="mysql_db" type="text" id="mysql_db">
		</div>
		<div class="margin-bottom-5">
		    <label for="table_prefix">TABLE명 접두사</label>
		    <input name="table_prefix" type="text" value="g5_" id="table_prefix">
		    <p class="note_txt">가능한 변경하지 마십시오.</p>
		</div>
		<div class="youngcart_frm margin-bottom-10">
		    <label for="">쇼핑몰TABLE명 접두사</label>
		    <input name="g5_shop_prefix" type="text" value="g5_shop_" id="g5_shop_prefix">
		</div>
		<div class="margin-bottom-10">
		    <label for=""><?php echo G5_VERSION; ?> 재설치</label>
		    <input name="g5_install" type="checkbox" value="1" id="g5_install"><span class="checkbox_txt">재설치</span>
		</div>
		<div class="youngcart_frm margin-bottom-5">
		    <label for="">쇼핑몰설치</label>
		    <input name="g5_shop_install" type="checkbox" value="1" id="g5_shop_install" checked="checked"><span class="checkbox_txt">설치</span>
	    </div>
    </div>

    <div class="ins_frm gnuboard_frm">
	    <h3 class="ins_frm_title">최고관리자 정보입력</h3>
	    <div class="margin-bottom-5">
		    <label for="admin_id">회원 ID</label>
		    <input name="admin_id" type="text" value="admin" id="admin_id">
		</div>
		<div class="margin-bottom-5">
		    <label for="admin_pass">비밀번호</label>
		    <input name="admin_pass" type="text" id="admin_pass">
		</div>
		<div class="margin-bottom-5">
		    <label for="admin_name">이름</label>
		    <input name="admin_name" type="text" value="최고관리자" id="admin_name">
		</div>
		<div class="margin-bottom-5">
		    <label for="admin_email">E-mail</label>
		    <input name="admin_email" type="text" value="admin@domain.com" id="admin_email">
		</div>
    </div>

    <p class="gnuboard_frm margin-bottom-20">
        <strong class="st_strong">주의! 이미 설치된 상태라면 DB 자료가 망실되므로 주의하십시오.</strong><br>
        주의사항을 이해했으며, 설치를 계속 진행하시려면 다음을 누르십시오.
    </p>

    <div class="inner_btn gnuboard_frm">
        <input type="submit" value="다음">
    </div>
</div>

<?php
include_once ('./setup.tail.php');
?>