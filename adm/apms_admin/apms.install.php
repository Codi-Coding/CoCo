<?php
if (!defined('_GNUBOARD_')) exit;

if($mode == "install") {

	//DB 등록
	include_once('./apms.sql.php');

	//Move
    alert("아미나빌더 설치가 완료되었습니다.", $go_url);
}

?>

<div class="local_ov01 local_ov">
	라이센스(License) 내용을 반드시 확인하십시오. 라이센스에 동의하시는 경우에만 설치가 진행됩니다.
</div>

<form action="./apms.admin.php" method="post" onsubmit="return install_submit(this);">
<input type="hidden" name="mode" value="install">
<div class="tbl_head01 tbl_wrap">
	<textarea name="textarea" id="apms_license" rows="20" readonly style="width:100%;"><?php echo implode('', file('./LICENSE.txt')); ?></textarea>

	<br><br>
	<input type="checkbox" name="agree" value="동의함" id="agree"> <label for="agree">라이센스에 동의합니다.</label>
	<br><br>
</div>

<div class="btn_confirm01 btn_confirm">
	<input type="submit" accesskey="s" class="btn_submit" value="설치하기">
</div>

</form>

<script>
	function install_submit(f) {
	    if (!f.agree.checked) {
		    alert("라이센스에 동의하셔야 설치하실 수 있습니다.");
	        f.agree.focus();
		    return false;
	    }

		if (!confirm("아미나빌더를 설치하시겠습니까?")) {
			return false;
		}

		return true;
	}
</script>
