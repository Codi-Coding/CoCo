<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$item_skin_url.'/style.css" media="screen">', 0);

?>

<div class="form-box">
	<div class="form-header">
		<h2><?php echo $it['it_name']; ?></h2>
	</div>
	<div class="form-body">
		<form name="fitemrecommend" class="form-light padding-15" role="form" method="post" action="./itemrecommendmail.php" autocomplete="off" onsubmit="return fitemrecommend_check(this);">
		<input type="hidden" name="token" value="<?php echo $token; ?>">
		<input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
			<div class="form-group">
				<label for="to_email">추천받는 분 E-mail<strong class="sound_only"> 필수</strong></label>
				<input type="text" name="to_email" id="to_email" required class="form-control input-sm" size="51">
			</div>
			<div class="form-group">
				<label for="subject">제목<strong class="sound_only"> 필수</strong></label>
				<input type="text" name="subject" id="subject" required class="form-control input-sm" size="51">
			</div>
			<div class="form-group">
				<label for="content">내용<strong class="sound_only"> 필수</strong></label>
				<textarea name="content" id="content" rows=4 required class="form-control input-sm"></textarea>
			</div>
			<div class="text-center">
				<button type="submit" id="btn_submit" class="btn btn-color btn-sm">보내기</button>
				<button type="button" class="btn btn-black btn-sm" onclick="window.close();">닫기</button>
			</div>
		</form>
	</div>
</div>

<script>
function fitemrecommend_check(f) {
    return true;
}
</script>
