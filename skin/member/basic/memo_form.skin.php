<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>

<div class="sub-title">
	<h4>
		<?php if($member['photo']) { ?>
			<img src="<?php echo $member['photo'];?>" alt="">
		<?php } else { ?>
			<i class="fa fa-user"></i>
		<?php } ?>
		<?php echo $g5['title'];?>
	</h4>
</div>

<div class="btn-group btn-group-justified">
	<a href="./memo.php?kind=recv" class="btn btn-sm btn-black<?php echo ($kind == "recv") ? ' active' : '';?>">받은쪽지</a>
	<a href="./memo.php?kind=send" class="btn btn-sm btn-black<?php echo ($kind == "send") ? ' active' : '';?>">보낸쪽지</a>
	<a href="./memo_form.php" class="btn btn-sm btn-black<?php echo ($kind == "") ? ' active' : '';?>">쪽지쓰기</a>
</div>

<div class="memo-send-form">
	<form class="form-horizontal" role="form" name="fmemoform" action="<?php echo $action_url; ?>" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
		<?php if ($config['cf_memo_send_point']) { ?>
			<p>
				<strong><i class="fa fa-bell"></i> 쪽지 보낼때 회원당 <?php echo number_format($config['cf_memo_send_point']); ?>점의 포인트를 차감합니다.</strong>
			<p>
		<?php } ?>

		<div class="form-group">
			<label class="col-sm-2 control-label" for="me_recv_mb_id"><b>받는 회원</b><strong class="sound_only">필수</strong></label>
			<div class="col-sm-10">
				<div class="input-group input-group-sm">
					<input type="text" name="me_recv_mb_id" value="<?php echo $me_recv_mb_id ?>" id="me_recv_mb_id" required class="form-control input-sm" placeholder="여러 회원에게 보낼때는 회원아이디를 컴마(,)로 구분">
					<span class="input-group-btn" role="group">
						<a onclick="apms_emoticon('me_memo');" title="이모티콘" class="btn btn-black btn-xs"><i class="fa fa-smile-o fa-lg"></i></a>
						<a href="<?php echo G5_BBS_URL;?>/helper.php?act=map" title="구글지도" target="_blank" class="btn btn-black btn-xs win_scrap"><i class="fa fa-compass fa-lg"></i></a>
						<a href="<?php echo G5_BBS_URL;?>/helper.php" title="작성안내" target="_blank" class="btn btn-black btn-xs win_scrap"><i class="fa fa-info-circle fa-lg"></i></a>
					</span>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label" for="me_memo"><b>쪽지 내용</b><strong class="sound_only">필수</strong></label>
			<div class="col-sm-10">
				<textarea name="me_memo" id="me_memo" rows="11" required class="form-control input-sm"><?php echo $content ?></textarea>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
				<?php echo captcha_html(); ?>
			</div>
		</div>

		<p class="text-center">
			<button type="submit" id="btn_submit" class="btn btn-color btn-sm">보내기</button>
			<button type="button" onclick="window.close();" class="btn btn-black btn-sm">닫기</button>
		</p>
	</form>
</div>

<script>
function fmemoform_submit(f) {
    <?php echo chk_captcha_js();  ?>

    return true;
}
</script>
