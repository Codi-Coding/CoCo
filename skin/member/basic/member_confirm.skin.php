<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

if($header_skin)
	include_once('./header.php');

?>

<div class="row">
	<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
		<div class="form-box">
			<div class="form-header">
				<h2><b><i class="fa fa-lock"></i> <?php echo $g5['title'] ?></b></h2>
			</div>
			<div class="form-body">
				<p>
					<strong>비밀번호를 한번 더 입력해주세요.</strong>
					<br>
					<?php if ($url == 'member_leave.php') { ?>
						비밀번호를 입력하시면 회원탈퇴가 완료됩니다.
					<?php }else{ ?>
						회원님의 정보를 안전하게 보호하기 위해 비밀번호를 한번 더 확인합니다.
					<?php }  ?>
				</p>

				<form class="form" role="form" name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
				<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
				<input type="hidden" name="w" value="u">

					<div class="form-group has-feedback">
						<label><b>회원아이디 : <span id="mb_confirm_id" class="text-primary"><?php echo $member['mb_id'] ?></span></b></label>
						<label class="sound_only" for="confirm_mb_password">비밀번호<strong class="sound_only">필수</strong></label>
				        <input type="password" name="mb_password" id="confirm_mb_password" required class="form-control input-sm" size="15" maxLength="20">
						<span class="fa fa-lock form-control-feedback"></span>
					</div>

					<button type="submit" id="btn_sumbit" class="btn btn-color btn-block">확인하기</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="text-center" style="margin:30px 0px;">
	<a href="<?php echo G5_URL ?>/" class="btn btn-black btn-sm" role="button">메인으로</a>
</div>

<script>
function fmemberconfirm_submit(f) {
    document.getElementById("btn_submit").disabled = true;

    return true;
}
</script>
<!-- } 회원 비밀번호 확인 끝 -->