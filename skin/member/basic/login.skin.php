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
				<h2><b><i class="fa fa-smile-o"></i> Have a Nice Day!</b></h2>
			</div>
			<div class="form-body">
			    <form class="form" role="form" name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
			    <input type="hidden" name="url" value='<?php echo $login_url ?>'>
					<div class="form-group has-feedback">
						<label for="login_id"><b>아이디</b><strong class="sound_only"> 필수</strong></label>
						<input type="text" name="mb_id" id="login_id" required class="form-control input-sm" size="20" maxLength="20">
						<span class="fa fa-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
				        <label for="login_pw"><b>비밀번호</b><strong class="sound_only"> 필수</strong></label>
				        <input type="password" name="mb_password" id="login_pw" required class="form-control input-sm" size="20" maxLength="20">
						<span class="fa fa-lock form-control-feedback"></span>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<label class="remember-me">
								<input type="checkbox" name="auto_login" id="login_auto_login"> 자동로그인
							</label>
						</div>
						<div class="col-xs-6">
							<button type="submit" class="btn btn-color pull-right">Sign In</button>
						</div>
					</div>
				</form>
			</div>
			<div class="form-footer">
				<p class="text-center">
					<a href="./register.php"><i class="fa fa-sign-in"></i> 회원가입</a>
					<a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost"><i class="fa fa-search"></i> 정보찾기</a>
				</p>
			</div>
		</div>
	</div>
</div>

<?php if ($default['de_level_sell'] == 1) { // 상품구입 권한 ?>

	<!-- 주문하기, 신청하기 -->
	<?php if (preg_match("/orderform.php/", $url)) { ?>

		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
				<div class="form-box">
					<div class="form-header">
						<h2><b>비회원 구매</b></h2>
					</div>
					<div class="form-body">
						<p><i class="fa fa-caret-right text-muted"></i> 비회원으로 주문하시는 경우 포인트는 지급하지 않습니다.</p>
						<p><i class="fa fa-caret-right text-muted"></i> <b>개인정보처리방침안내</b></p>
						<table class="table">
						<colgroup>
							<col width="30%">
							<col width="30%">
						</colgroup>
						<thead>
						<tr>
							<th>목적</th>
							<th>항목</th>
							<th>보유기간</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>이용자 식별 및 본인 확인</td>
							<td>이름, 비밀번호</td>
							<td>5년(전자상거래등에서의 소비자보호에 관한 법률)</td>
						</tr>
						<tr>
							<td>배송 및 CS대응을 위한 이용자 식별</td>
							<td>주소, 연락처(이메일, 휴대전화번호)</td>
							<td>5년(전자상거래등에서의 소비자보호에 관한 법률)</td>
						</tr>
						</tbody>
						<tfoot>
						<tr>
							<td colspan="3">
								<label for="agree"><input type="checkbox" id="agree" value="1"> 개인정보처리방침안내의 내용에 동의합니다.</label>
							</td>
						</tr>
						</tfoot>
						</table>
						
						<a href="javascript:guest_submit(document.flogin);" class="btn btn-color btn-block">비회원으로 구매하기</a>

						<script>
						function guest_submit(f) {
							if (document.getElementById('agree')) {
								if (!document.getElementById('agree').checked) {
									alert("개인정보처리방침안내의 내용에 동의하셔야 합니다.");
									return;
								}
							}

							f.url.value = "<?php echo $url; ?>";
							f.action = "<?php echo $url; ?>";
							f.submit();
						}
						</script>
					</div>
				</div>
			</div>
		</div>

	<?php } else if (preg_match("/orderinquiry.php$/", $url)) { ?>

		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
				<div class="form-box">
					<div class="form-header">
						<h2><b>비회원 주문조회</b></h2>
					</div>
					<div class="form-body">
						<p>메일로 발송해드린 주문서의 <strong>주문번호</strong> 및 주문 시 입력하신 <strong>비밀번호</strong>를 정확히 입력해주십시오.</p>

						<form class="form" role="form" name="forderinquiry" method="post" action="<?php echo urldecode($url); ?>" autocomplete="off">
							<div class="form-group has-feedback">
								<label for="od_id" class="od_id"><b>주문서번호</b><strong class="sound_only"> 필수</strong></label>
								<input type="text" name="od_id" value="<?php echo $od_id; ?>" id="od_id" required class="form-control input-sm" size="20">
								<span class="fa fa-user form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<label for="id_pwd" class="od_pwd"><b>비밀번호</b><strong class="sound_only"> 필수</strong></label>
								<input type="password" name="od_pwd" size="20" id="od_pwd" required class="form-control input-sm">
								<span class="fa fa-lock form-control-feedback"></span>
							</div>

							<button type="submit" class="btn btn-color btn-block">확인하기</button>

						</form>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>
<?php } ?>

<div class="text-center" style="margin:30px 0px;">
	<a href="<?php echo G5_URL ?>/" class="btn btn-black btn-sm" role="button">메인으로</a>
</div>

<script>
$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f) {
    return true;
}
</script>
<!-- } 로그인 끝 -->