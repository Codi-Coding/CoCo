<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$item_skin_url.'/style.css" media="screen">', 0);

?>

<div class="form-box">
	<div class="form-header">
		<h2><?php echo $it['it_name']; ?></h2>
	</div>
	<div class="form-body">
		<form name="fstocksms" class="form-light padding-15" role="form" method="post" action="<?php echo G5_HTTPS_SHOP_URL; ?>/itemstocksmsupdate.php" onsubmit="return fstocksms_submit(this);"  autocomplete="off">
		<input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
			<div class="form-group">
				<label for="ss_hp">휴대폰번호<strong class="sound_only"> 필수</strong></label>
				<input type="text" name="ss_hp" value="<?php echo $member['mb_hp']; ?>" id="ss_hp" required class="form-control input-sm">
			</div>
			<div class="form-group">
				<label>개인정보처리방침안내</label>
				<textarea class="form-control input-sm" rows="7" readonly><?php echo get_text($config['cf_privacy']) ?></textarea>
			</div>
			<p><label class="checkbox"><input type="checkbox" name="agree" value="1" id="agree"> 개인정보처리방침안내의 내용에 동의합니다.</label></p>

			<div class="text-center">
				<button type="submit" class="btn btn-color btn-sm">확인</button>
				<button type="button" class="btn btn-black btn-sm" onclick="window.close();">닫기</button>
			</div>
		</form>
	</div>
</div>
<script>
	function fstocksms_submit(f) {
		if(!f.agree.checked) {
			alert("개인정보처리방침안내에 동의해 주십시오.");
			return false;
		}

		if(confirm("재입고SMS 알림 요청을 등록하시겠습니까?")) {
			return true;
		} else {
			window.close();
			return false;
		}
	}
</script>
