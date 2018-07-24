<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 값정리
$boset['cmt_photo'] = (isset($boset['cmt_photo'])) ? $boset['cmt_photo'] : '';
$boset['cmt_re'] = (isset($boset['cmt_re'])) ? $boset['cmt_re'] : '';

// 댓글추천
$is_cmt_good = ($board['bo_use_good'] && isset($boset['cgood']) && $boset['cgood']) ? true : false;
$is_cmt_nogood = ($board['bo_use_nogood'] && isset($boset['cnogood']) && $boset['cnogood']) ? true : false;

// 회원사진, 대댓글 이름
if(G5_IS_MOBILE) {
	$depth_gap = 20;
	$is_cmt_photo = (!$boset['cmt_photo'] || $boset['cmt_photo'] == "2") ? true : false;
	$is_replyname = ($boset['cmt_re'] == "1" || $boset['cmt_re'] == "3") ? true : false;
} else {
	$is_cmt_photo = (!$boset['cmt_photo'] || $boset['cmt_photo'] == "1") ? true : false;
	$is_replyname = ($boset['cmt_re'] == "1" || $boset['cmt_re'] == "2") ? true : false;
	$depth_gap = ($is_cmt_photo) ? 64 : 30;
}

$cmt_amt = count($list);

?>

<div class="view-comment font-18 en">
	<i class="fa fa-commenting"></i> <span class="orangered"><?php echo number_format($write['wr_comment']);?></span> Comments
</div>

<script>
// 글자수 제한
var char_min = parseInt(<?php echo $comment_min ?>); // 최소
var char_max = parseInt(<?php echo $comment_max ?>); // 최대
</script>

<?php if($cmt_amt) { ?>
	<section id="bo_vc" class="comment-media">
		<?php
		for ($i=0; $i<$cmt_amt; $i++) {
			$comment_id = $list[$i]['wr_id'];
			$cmt_depth = ""; // 댓글단계
			$cmt_depth = strlen($list[$i]['wr_comment_reply']) * $depth_gap;
			$comment = $list[$i]['content'];
			$cmt_sv = $cmt_amt - $i + 1; // 댓글 헤더 z-index 재설정 ie8 이하 사이드뷰 겹침 문제 해결
			if(APMS_PIM && $list[$i]['is_secret']) {
				$comment = '<a href="./password.php?w=sc&amp;bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].$qstr.'" target="_parent" class="s_cmt">댓글내용 확인</a>';
			}
		 ?>
			<div class="media" id="c_<?php echo $comment_id ?>"<?php echo ($cmt_depth) ? ' style="margin-left:'.$cmt_depth.'px;"' : ''; ?>>
				<?php 
					if($is_cmt_photo) { // 회원사진
						$cmt_photo_url = apms_photo_url($list[$i]['mb_id']);
						$cmt_photo = ($cmt_photo_url) ? '<img src="'.$cmt_photo_url.'" alt="" class="media-object">' : '<div class="media-object"><i class="fa fa-user"></i></div>';
						echo '<div class="photo pull-left">'.$cmt_photo.'</div>'.PHP_EOL;
					 }
				?>
				<div class="media-body">
					<div class="media-heading">
						<b><?php echo $list[$i]['name'] ?></b>
						<span class="font-11 text-muted">
							<span class="media-info">
								<i class="fa fa-clock-o"></i>
								<?php echo apms_date($list[$i]['date'], 'orangered', 'before');?>
							</span>
							<?php if ($is_ip_view) { ?>	<span class="print-hide hidden-xs media-info"><i class="fa fa-thumb-tack"></i> <?php echo $list[$i]['ip']; ?></span> <?php } ?>
						</span>
						&nbsp;
						<?php if ($list[$i]['wr_facebook_user']) { ?>
							<a href="https://www.facebook.com/profile.php?id=<?php echo $list[$i]['wr_facebook_user']; ?>" target="_blank"><i class="fa fa-facebook-square fa-lg lightgray"></i><span class="sound_only">페이스북에도 등록됨</span></a>
						<?php } ?>
						<?php if ($list[$i]['wr_twitter_user']) { ?>
							<a href="https://www.twitter.com/<?php echo $list[$i]['wr_twitter_user']; ?>" target="_blank"><i class="fa fa-twitter-square fa-lg lightgray"></i><span class="sound_only">트위터에도 등록됨</span></a>
						<?php } ?>
						<?php if($list[$i]['is_reply'] || $list[$i]['is_edit'] || $list[$i]['is_del'] || $is_shingo || $is_admin) {

							$query_string = clean_query_string($_SERVER['QUERY_STRING']);

							if($w == 'cu') {
								$sql = " select wr_id, wr_content from $write_table where wr_id = '$c_id' and wr_is_comment = '1' ";
								$cmt = sql_fetch($sql);
								$c_wr_content = $cmt['wr_content'];
							}

							$c_reply_href = './board.php?'.$query_string.'&amp;c_id='.$comment_id.'&amp;w=c#bo_vc_w';
							$c_edit_href = './board.php?'.$query_string.'&amp;c_id='.$comment_id.'&amp;w=cu#bo_vc_w';

						 ?>
							<div class="print-hide pull-right font-11 ">
								<?php if ($list[$i]['is_reply']) { ?>
									<a href="<?php echo $c_reply_href;  ?>" onclick="comment_box('<?php echo $comment_id ?>', 'c'); return false;">
										<span class="text-muted">답변</span>
									</a>
								<?php } ?>
								<?php if ($list[$i]['is_edit']) { ?>
									<a href="<?php echo $c_edit_href;  ?>" onclick="comment_box('<?php echo $comment_id ?>', 'cu'); return false;">
										<span class="text-muted media-btn">수정</span>
									</a>
								<?php } ?>
								<?php if ($list[$i]['is_del'])  { ?>
									<a href="<?php echo $list[$i]['del_link'];  ?>" onclick="return comment_delete();">
										<span class="text-muted media-btn">삭제</span>
									</a>
								<?php } ?>
								<?php if ($is_shingo)  { ?>
									<a href="#" onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $comment_id ?>'); return false;">
										<span class="text-muted media-btn">신고</span>
									</a>
								<?php } ?>
								<?php if ($is_admin) { ?>
									<?php if ($list[$i]['is_lock']) { // 글이 잠긴상태이면 ?>
										<a href="#" onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $comment_id;?>', 'unlock'); return false;">
											<span class="text-muted media-btn">해제</span>
										</a>
									<?php } else { ?>
										<a href="#" onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $comment_id;?>', 'lock'); return false;">
											<span class="text-muted media-btn">잠금</span>
										</a>
									<?php } ?>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
					<div class="media-content">
						<?php if (strstr($list[$i]['wr_option'], "secret")) { ?>
							<img src="<?php echo $board_skin_url;?>/img/icon_secret.gif" alt="">
						<?php } ?>
						<?php echo ($is_replyname && $list[$i]['reply_name']) ? '<b>[<span class="en">@</span>'.$list[$i]['reply_name'].']</b>'.PHP_EOL : ''; ?>
						<?php echo $comment ?>
							<?php if($is_cmt_good || $is_cmt_nogood) { ?>
								<div class="cmt-good-btn">
									<?php if($is_cmt_good) { ?>
										<a href="#" class="cmt-good" onclick="apms_good('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'good', 'c_good<?php echo $comment_id;?>', '<?php echo $comment_id;?>'); return false;">
											<span id="c_good<?php echo $comment_id;?>"><?php echo $list[$i]['wr_good']; ?></span>
										</a><?php } ?><?php if($is_cmt_nogood) { ?><a href="#" class="cmt-nogood" onclick="apms_good('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'nogood', 'c_nogood<?php echo $comment_id;?>', '<?php echo $comment_id;?>'); return false;">
											<span id="c_nogood<?php echo $comment_id;?>"><?php echo $list[$i]['wr_nogood']; ?></span>
										</a>
									<?php } ?>
								</div>
							<?php } ?>
						<?php if(!G5_IS_MOBILE) { // PC ?>
							<span id="edit_<?php echo $comment_id ?>"></span><!-- 수정 -->
							<span id="reply_<?php echo $comment_id ?>"></span><!-- 답변 -->
							<input type="hidden" value="<?php echo strstr($list[$i]['wr_option'],"secret") ?>" id="secret_comment_<?php echo $comment_id ?>">
							<textarea id="save_comment_<?php echo $comment_id ?>" style="display:none"><?php echo get_text($list[$i]['content1'], 0) ?></textarea>
						<?php } ?>
					</div>
			  </div>
			</div>
			<?php if(G5_IS_MOBILE) { // Mobile ?>
				<span id="edit_<?php echo $comment_id ?>"></span><!-- 수정 -->
				<span id="reply_<?php echo $comment_id ?>"></span><!-- 답변 -->
				<input type="hidden" value="<?php echo strstr($list[$i]['wr_option'],"secret") ?>" id="secret_comment_<?php echo $comment_id ?>">
				<textarea id="save_comment_<?php echo $comment_id ?>" style="display:none"><?php echo get_text($list[$i]['content1'], 0) ?></textarea>
			<?php } ?>
		<?php } ?>
	</section>
<?php } ?>

<div class="print-hide">
<?php if ($is_comment_write) {
	if($w == '') $w = 'c';
?>
	<aside id="bo_vc_w">
		<form id="fviewcomment" name="fviewcomment" action="<?php echo $comment_action_url; ?>" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off" class="form comment-form" role="form">
		<input type="hidden" name="w" value="<?php echo $w ?>" id="w">
		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
		<input type="hidden" name="comment_id" value="<?php echo $c_id ?>" id="comment_id">
		<input type="hidden" name="pim" value="<?php echo APMS_PIM ?>">
		<input type="hidden" name="sca" value="<?php echo $sca ?>">
		<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
		<input type="hidden" name="stx" value="<?php echo $stx ?>">
		<input type="hidden" name="spt" value="<?php echo $spt ?>">
		<input type="hidden" name="page" value="<?php echo $page ?>">
		<input type="hidden" name="vskin" value="<?php echo $boset['view_skin']; ?>">
		<input type="hidden" name="is_good" value="">

		<div class="comment-box">
			<div class="pull-left help-block hidden-xs">
				<i class="fa fa-smile-o fa-lg"></i> 댓글은 자신을 나타내는 '얼굴'입니다. *^^*
			</div>
			<?php if ($comment_min || $comment_max) { ?>
				<div class="pull-right help-block" id="char_cnt">
					<i class="fa fa-commenting-o fa-lg"></i>
					현재 <b class="orangered"><span id="char_count">0</span></b>글자
					/
					<?php if($comment_min) { ?>
						<?php echo number_format($comment_min);?>글자 이상
					<?php } ?>
					<?php if($comment_max) { ?>
						<?php echo number_format($comment_max);?>글자 이하
					<?php } ?>
				</div>
			<?php } ?>
			<div class="clearfix"></div>
			<?php if ($is_guest) { ?>
				<div class="form-group row">
					<div class="col-xs-6">
						<label for="wr_name" class="sound_only">이름<strong class="sound_only"> 필수</strong></label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user gray"></i></span>
							<input type="text" name="wr_name" value="<?php echo get_cookie("ck_sns_name"); ?>" id="wr_name" class="form-control input-sm" size="5" maxLength="20" placeholder="이름">
						</div>
					</div>
					<div class="col-xs-6">
						<label for="wr_password" class="sound_only">비밀번호<strong class="sound_only"> 필수</strong></label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock gray"></i></span>
							<input type="password" name="wr_password" id="wr_password" class="form-control input-sm" size="10" maxLength="20" placeholder="비밀번호">
						</div>
					</div>
				</div>
			<?php } ?>

			<div class="form-group comment-content">
				<div class="comment-cell">
					<textarea tabindex="13" id="wr_content" name="wr_content" maxlength="10000" rows=5 class="form-control input-sm" title="내용"
					<?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?>><?php echo $c_wr_content;  ?></textarea>
					<?php if ($comment_min || $comment_max) { ?><script> check_byte('wr_content', 'char_count'); </script><?php } ?>
					<script>
					$("textarea#wr_content[maxlength]").live("keyup change", function() {
						var str = $(this).val()
						var mx = parseInt($(this).attr("maxlength"))
						if (str.length > mx) {
							$(this).val(str.substr(0, mx));
							return false;
						}
					});
					</script>
				</div>
				<div tabindex="14" class="comment-cell comment-submit" onclick="apms_comment_submit();" onKeyDown="apms_comment_onKeyDown();" id="btn_submit">
					등록
				</div>
			</div>

			<div class="comment-btn">
				<div class="form-group pull-right">
					<span class="cursor">
						<label class="checkbox-inline"><input type="checkbox" name="wr_secret" value="secret" id="wr_secret"> 비밀글</label>
					</span>
					<span class="cursor" title="이모티콘" onclick="apms_emoticon();">
						<i class="fa fa-smile-o fa-lg"></i><span class="sound_only">이모티콘</span>
					</span>
					<span class="cursor" title="새댓글" onclick="comment_box('','c');">
						<i class="fa fa-pencil fa-lg"></i><span class="sound_only">새댓글 작성</span>
					</span>
					<span class="cursor" title="새로고침" onclick="apms_page('viewcomment','<?php echo $comment_url;?>');">
						<i class="fa fa-refresh fa-lg"></i><span class="sound_only">댓글 새로고침</span>
					</span>
					<span class="cursor" title="늘이기" onclick="apms_textarea('wr_content','down');">
						<i class="fa fa-plus-circle fa-lg"></i><span class="sound_only">입력창 늘이기</span>
					</span>
					<span class="cursor" title="줄이기" onclick="apms_textarea('wr_content','up');">
						<i class="fa fa-minus-circle fa-lg"></i><span class="sound_only">입력창 줄이기</span>
					</span>
				</div>	
				<?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) {	?>
					<div id="bo_vc_opt" class="form-group pull-left">
						<ol>
							<li id="bo_vc_send_sns"></li>
						</ol>
					</div>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
		</div>

		<?php if ($is_guest) { ?>
			<div class="well well-sm text-center">
				<?php echo $captcha_html; ?>
			</div>
		<?php } ?>

		</form>
	</aside>
<?php } else { ?>
	<div class="h10"></div>
	<div class="well text-center">
		<?php if($is_guest) { ?>
			<a href="<?php echo $comment_login_url;?>">로그인한 회원만 댓글 등록이 가능합니다.</a>
		<?php } else { ?>
			댓글을 등록할 수 있는 권한이 없습니다.
		<?php } ?>
	</div>
<?php } ?>
</div><!-- Print-Hide -->

<?php if ($is_comment_write) { ?>
	<script>
	var save_before = '';
	var save_html = document.getElementById('bo_vc_w').innerHTML;

	function good_and_write()
	{
		var f = document.fviewcomment;
		if (fviewcomment_submit(f)) {
			f.is_good.value = 1;
			f.submit();
		} else {
			f.is_good.value = 0;
		}
	}

	function fviewcomment_submit(f)
	{
		var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

		f.is_good.value = 0;

		var subject = "";
		var content = "";
		$.ajax({
			url: g5_bbs_url+"/ajax.filter.php",
			type: "POST",
			data: {
				"subject": "",
				"content": f.wr_content.value
			},
			dataType: "json",
			async: false,
			cache: false,
			success: function(data, textStatus) {
				subject = data.subject;
				content = data.content;
			}
		});

		if (content) {
			alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
			f.wr_content.focus();
			return false;
		}

		// 양쪽 공백 없애기
		var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
		document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
		if (char_min > 0 || char_max > 0)
		{
			check_byte('wr_content', 'char_count');
			var cnt = parseInt(document.getElementById('char_count').innerHTML);
			if (char_min > 0 && char_min > cnt)
			{
				alert("댓글은 "+char_min+"글자 이상 쓰셔야 합니다.");
				return false;
			} else if (char_max > 0 && char_max < cnt)
			{
				alert("댓글은 "+char_max+"글자 이하로 쓰셔야 합니다.");
				return false;
			}
		}
		else if (!document.getElementById('wr_content').value)
		{
			alert("댓글을 입력하여 주십시오.");
			f.wr_content.focus();
			return false;
		}

		if (typeof(f.wr_name) != 'undefined')
		{
			f.wr_name.value = f.wr_name.value.replace(pattern, "");
			if (f.wr_name.value == '')
			{
				alert('이름이 입력되지 않았습니다.');
				f.wr_name.focus();
				return false;
			}
		}

		if (typeof(f.wr_password) != 'undefined')
		{
			f.wr_password.value = f.wr_password.value.replace(pattern, "");
			if (f.wr_password.value == '')
			{
				alert('비밀번호가 입력되지 않았습니다.');
				f.wr_password.focus();
				return false;
			}
		}

		<?php if($is_guest) echo chk_captcha_js();  ?>

		set_comment_token(f);

		document.getElementById("btn_submit").disabled = "disabled";

		return true;
	}

	function comment_box(comment_id, work)
	{
		var el_id;
		// 댓글 아이디가 넘어오면 답변, 수정
		if (comment_id)
		{
			if (work == 'c')
				el_id = 'reply_' + comment_id;
			else
				el_id = 'edit_' + comment_id;
		}
		else
			el_id = 'bo_vc_w';

		if (save_before != el_id)
		{
			if (save_before)
			{
				document.getElementById(save_before).style.display = 'none';
				document.getElementById(save_before).innerHTML = '';
			}

			document.getElementById(el_id).style.display = '';
			document.getElementById(el_id).innerHTML = save_html;
			// 댓글 수정
			if (work == 'cu')
			{
				document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
				if (typeof char_count != 'undefined')
					check_byte('wr_content', 'char_count');
				if (document.getElementById('secret_comment_'+comment_id).value)
					document.getElementById('wr_secret').checked = true;
				else
					document.getElementById('wr_secret').checked = false;
			}

			document.getElementById('comment_id').value = comment_id;
			document.getElementById('w').value = work;

			if(save_before)
				$("#captcha_reload").trigger("click");

			save_before = el_id;
		}
	}

	function comment_delete(){
		return confirm("이 댓글을 삭제하시겠습니까?");
	}

	comment_box('', 'c'); // 댓글 입력폼이 보이도록 처리하기위해서 추가 (root님)

	<?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) { ?>
	// sns 등록
	$(function() {
		$("#bo_vc_send_sns").load(
			"<?php echo G5_SNS_URL; ?>/view_comment_write.sns.skin.php?bo_table=<?php echo $bo_table; ?>",
			function() {
				save_html = document.getElementById('bo_vc_w').innerHTML;
			}
		);
	});
	<?php } ?>

	// 댓글등록
	function apms_comment_submit() {
		var f = document.getElementById("fviewcomment");
		if (fviewcomment_submit(f)) {
			$("#fviewcomment").submit();
		}
		return false;
	}

	function apms_comment_onKeyDown() {
		  if(event.keyCode == 13) {
			apms_comment_submit();
		 }
	}
	</script>
<?php } ?>