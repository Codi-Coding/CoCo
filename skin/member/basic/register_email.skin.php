<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

if($header_skin)
	include_once('./header.php');

?>

<form class="form-horizontal" role="form" method="post" name="fregister_email" action="<?php echo $action_url; ?>" onsubmit="return fregister_email_submit(this);">
	<input type="hidden" name="mb_id" value="<?php echo $mb_id; ?>">
	<div class="panel panel-default">
		<div class="panel-heading"><strong><i class="fa fa-microphone fa-lg"></i> 메일인증을 받지 못한 경우 회원정보의 메일주소를 변경 할 수 있습니다.</strong></div>
		<div class="panel-body">

			<div class="form-group has-feedback">
				<label class="col-sm-2 control-label" for="reg_mb_email"><b>E-mail</b><strong class="sound_only">필수</strong></label>
				<div class="col-sm-8">
					<input type="text" name="mb_email" id="reg_mb_email" required class="form-control input-sm email" size="50" maxlength="100" value="<?php echo $mb['mb_email']; ?>">
					<span class="fa fa-envelope form-control-feedback"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label class="col-sm-2 control-label"><b>자동등록방지</b><strong class="sound_only">필수</strong></label>
				<div class="col-sm-8">
					<?php echo captcha_html(); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="text-center" style="margin:30px 0px;">
		<button type="submit" id="btn_submit" class="btn btn-color">인증메일변경</button>
	    <a href="<?php echo G5_URL ?>" class="btn btn-black" role="button">취소</a>
	</div>
</form>

<script>
function fregister_email_submit(f) {
    <?php echo chk_captcha_js();  ?>

    return true;
}
</script>
