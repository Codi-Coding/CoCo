<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>

<div class="sub-title">
	<h4>
		<?php if($photo) { ?>
			<img src="<?php echo $photo;?>" alt="">
		<?php } else { ?>
			<i class="fa fa-user"></i>
		<?php } ?>
		<?php echo $name ?> 님께 메일보내기
	</h4>
</div>

<div class="text-center bg-black" style="padding:7px 20px;">
	첨부파일은 누락될 수 있으므로 메일을 보낸 후 파일이 첨부 되었는지 반드시 확인해 주세요.
</div>

<div class="formmail-form">
    <form class="form-horizontal" role="form" name="fformmail" action="./formmail_send.php" onsubmit="return fformmail_submit(this);" method="post" enctype="multipart/form-data">
    <input type="hidden" name="to" value="<?php echo $email ?>">
    <input type="hidden" name="attach" value="2">
	<?php if ($is_member) { // 회원이면  ?>
		<input type="hidden" name="fnick" value="<?php echo get_text($member['mb_nick']) ?>">
		<input type="hidden" name="fmail" value="<?php echo $member['mb_email'] ?>">
	<?php }  ?>

	<?php if (!$is_member) {  ?>
		<div class="form-group">
			<label class="col-xs-2 control-label" for="fnick"><b>이름</b><strong class="sound_only">필수</strong></label>
			<div class="col-xs-10">
				<input type="text" name="fnick" id="fnick" required class="form-control input-sm">
			</div>
		</div>

		<div class="form-group">
			<label class="col-xs-2 control-label" for="fmail"><b>E-mail</b><strong class="sound_only">필수</strong></label>
			<div class="col-xs-10">
				<input type="text" name="fmail" id="fmain" required class="form-control input-sm">
			</div>
		</div>
	<?php }  ?>

		<div class="form-group">
			<label class="col-xs-2 control-label" for="subject"><b>제목</b><strong class="sound_only">필수</strong></label>
			<div class="col-xs-10">
				<input type="text" name="subject" id="subject" required class="form-control input-sm">
			</div>
		</div>

		<div class="form-group">
			<label class="col-xs-2 control-label"><b>형식</b></label>
			<div class="col-xs-10 formmail-type">
				<label class="control-label"><input type="radio" name="type" value="0" id="type_text" checked> TEXT</label>
				<label class="control-label"><input type="radio" name="type" value="1" id="type_html"> HTML</label>
				<label class="control-label"><input type="radio" name="type" value="2" id="type_both"> TEXT+HTML</label>
			</div>
		</div>

		<div class="form-group">
			<label class="col-xs-2 control-label" for="content"><b>내용</b><strong class="sound_only">필수</strong></label>
			<div class="col-xs-10">
				<textarea name="content" id="content" rows="8" required class="form-control input-sm"></textarea>
			</div>
		</div>

		<div class="form-group">
			<label class="col-xs-2 control-label"><b>첨부</b></label>
			<div class="col-xs-10">
				<input type="file" name="file1"  id="file1">
				<div style="height:10px;"></div>
				<input type="file" name="file2"  id="file2">
			</div>
		</div>

		<div class="form-group">
			<div class="col-xs-10 col-xs-offset-2">
				<?php echo captcha_html(); ?>
			</div>
		</div>

		<p class="text-center">
			<button type="submit" id="btn_submit" class="btn btn-color btn-sm">메일발송</button>
			<button type="button" onclick="window.close();" class="btn btn-black btn-sm">닫기</button>
		</p>
    </form>
</div>

<script>
with (document.fformmail) {
    if (typeof fname != "undefined")
        fname.focus();
    else if (typeof subject != "undefined")
        subject.focus();
}

function fformmail_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    if (f.file1.value || f.file2.value) {
        // 4.00.11
        if (!confirm("첨부파일의 용량이 큰경우 전송시간이 오래 걸립니다.\n\n메일보내기가 완료되기 전에 창을 닫거나 새로고침 하지 마십시오."))
            return false;
    }

    document.getElementById('btn_submit').disabled = true;

    return true;
}

</script>
<!-- } 폼메일 끝 -->