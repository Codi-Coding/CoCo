<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//내아이콘
$myicon = apms_photo_url($member['mb_id']);
$myicon = ($myicon) ? '<img src="'.$myicon.'">' : '<i class="fa fa-user"></i>';

if(!$boset['icolor']) $boset['icolor'] = 'green';

?>
<?php if($notice_count > 0) { //공지사항 ?>
	<div class="panel panel-default list-notice">
		<div class="panel-heading">
			<h4 class="panel-title">Notice</h4>
		</div>
		<div class="list-group">
			<?php for ($i=0; $i < $notice_count; $i++) { 
					if(!$list[$i]['is_notice']) break; //공지가 아니면 끝냄 
			?>
				 <a href="<?php echo $list[$i]['href'];?>" class="list-group-item ellipsis"<?php echo $is_modal_js;?>>
					<span class="hidden-xs pull-right font-12 black">
						<i class="fa fa-clock-o"></i> <?php echo apms_datetime($list[$i]['date'], "Y.m.d");?>
					</span>
					<span class="wr-notice"></span>
					<strong class="black"><?php echo $list[$i]['subject'];?></strong>
					<?php if($list[$i]['wr_comment']) { ?>
						<span class="count red"><?php echo $list[$i]['wr_comment'];?></span>
					<?php } ?>
				</a>
			<?php } ?>
		</div>
	</div>
<?php } ?>

<?php 
if($is_category) 
	include_once($board_skin_path.'/category.skin.php'); // 카테고리	
?>

<style>
	.board-list .talker-photo i { <?php echo ($boset['ibg']) ? 'background:'.apms_color($boset['icolor']).'; color:#fff' : 'color:'.apms_color($boset['icolor']);?>; }
</style>

<div class="talk-box-wrap">
	<span id="ticon" class="talker-photo pull-left"><?php echo $myicon;?></span>
	<div class="talk-box talk-right">
		<div class="talk-bubble">
			<?php
				// 글자수 제한 설정값
				if ($is_admin) {
					$write_min = $write_max = 0;
				} else {
					$write_min = (int)$board['bo_write_min'];
					$write_max = (int)$board['bo_write_max'];
				}

				$is_link = false;
				if ($member['mb_level'] >= $board['bo_link_level']) {
					$is_link = true;
				}

				$is_file = false;
				if ($member['mb_level'] >= $board['bo_upload_level']) {
					$is_file = true;
				}

				$is_file_content = false;
				if ($board['bo_use_file_content']) {
					$is_file_content = true;
				}

				$file_count = (int)$board['bo_upload_count'];

				$category_option = '';
				if ($board['bo_use_category']) {
					$ca_name = ($sca) ? $sca : '';
					$category_option = get_category_option($bo_table, $ca_name);
				}

				$action_url = https_url(G5_BBS_DIR)."/write_update.php";

			?>

			<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return ftalk_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" role="form" class="form talk-form">
			<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
			<input type="hidden" name="w" value="">
			<input type="hidden" name="is_direct" value="1">
			<input type="hidden" name="is_subject" value="1">
			<input type="hidden" name="html" value="html2">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="wr_subject" value="1">
			<input type="hidden" name="as_icon" value="" id="picon">
			<div class="form-group">
				<?php if($write_min || $write_max) { ?><strong id="char_cnt" style="display:none;"><span id="char_count"></span></strong><?php } ?>
				<textarea id="wr_content" name="wr_content" class="form-control input-sm write-content" rows="3" required maxlength="65536" placeholder="<?php echo ($is_guest) ? '로그인한 회원만 등록할 수 있습니다.' : '';?>"
				<?php if ($write_min || $write_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?>></textarea>
				<?php if ($write_min || $write_max) { ?><script> check_byte('wr_content', 'char_count'); </script><?php } ?>
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
			<div class="row">
				<div class="col-sm-6">
					<div class="row">
						<?php if ($is_category) { ?>
							<div class="col-sm-6">
								<select name="ca_name" id="ca_name" required class="form-control input-sm">
									<option value="">분류선택</option>
									<?php echo $category_option ?>
								</select>
								<div class="clearfix h15 visible-xs"></div>
							</div>
						<?php } ?>
						<div class="col-sm-6">
							<div class="btn-group btn-group-justified" data-toggle="buttons">
								<label class="btn btn-default btn-sm" onclick="apms_emoticon('picon', 'ticon');" title="이모티콘">
									<input type="radio" name="select_icon" id="select_icon1">
									<i class="fa fa-smile-o fa-lg"></i><span class="sound_only">이모티콘</span>
								</label>
								<label class="btn btn-default btn-sm" onclick="win_scrap('<?php echo G5_BBS_URL;?>/ficon.php?fid=picon&sid=ticon');" title="FA아이콘">
									<input type="radio" name="select_icon" id="select_icon2">
									<i class="fa fa-info-circle fa-lg"></i><span class="sound_only">FA아이콘</span>
								</label>
								<label class="btn btn-default btn-sm" onclick="apms_myicon();" title="내사진">
									<input type="radio" name="select_icon" id="select_icon3">
									<i class="fa fa-user fa-lg"></i><span class="sound_only">내사진</span>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 text-right">
					<div class="clearfix h15 visible-xs"></div>
					<div class="btn-group">
						<a role="button" class="btn btn-default btn-sm" title="늘이기" onclick="apms_textarea('wr_content','down');"><i class="fa fa-plus-circle fa-lg"></i><span class="sound_only">입력창 늘이기</span></a>
						<a role="button" class="btn btn-default btn-sm hidden-xs" title="줄이기" onclick="apms_textarea('wr_content','up');"><i class="fa fa-minus-circle fa-lg"></i><span class="sound_only">입력창 줄이기</span></a>
						<?php if($is_link) { ?>
							<a role="button" class="btn btn-default btn-sm" title="동영상" onclick="apms_write_opt('listVideo');"><i class="fa fa-video-camera fa-lg"></i><span class="sound_only">동영상</span></a>
						<?php } ?>
						<?php if($is_file) { ?>
							<a role="button" class="btn btn-default btn-sm" title="포토" onclick="apms_write_opt('listPhoto');"><i class="fa fa-camera fa-lg"></i><span class="sound_only">포토</span></a>
						<?php } ?>
						<a role="button" title="지도" href="<?php echo G5_BBS_URL;?>/helper.php?act=map" target="_blank" class="btn btn-default btn-sm win_scrap"><i class="fa fa-map-marker fa-lg"></i><span class="sound_only">지도</span></a>
						<button type="submit" class="btn btn-black btn-sm" id="talk_submit"><i class="fa fa-comment"></i> <b>등록</b></button>
					</div>
				</div>
			</div>
			<?php if($is_link) { ?>
				<div class="anc-write" id="listVideo">
					<div class="h10"></div>
					<input type="text" name="wr_link1" value="<?php if($w=="u"){ echo $write['wr_link1']; } ?>" id="wr_link1" class="form-control input-sm" size="50" placeholder="유튜브, 비메오 등 동영상 공유주소 등록">
				</div>
			<?php } ?>
			<?php if($is_file) { ?>
				<div class="anc-write" id="listPhoto">
					<?php for ($i=0; $is_file && $i < 1; $i++) { ?>
						<div class="h10"></div>
						<input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo number_format($board['bo_upload_size']);?> 바이트 이하만 업로드 가능">
					<?php } ?>
				</div>
			<?php } ?>
			</form>

			<script>
				<?php if($write_min || $write_max) { ?>
				// 글자수 제한
				var char_min = parseInt(<?php echo $write_min; ?>); // 최소
				var char_max = parseInt(<?php echo $write_max; ?>); // 최대
				check_byte("wr_content", "char_count");

				$(function() {
					$("#wr_content").on("keyup", function() {
						check_byte("wr_content", "char_count");
					});
				});
				<?php } ?>

				function apms_write_opt(id) {
					$(".anc-write").hide();
					$("#" + id).show();
				}

				function apms_myicon() {

					document.getElementById("picon").value = '';
					document.getElementById("ticon").innerHTML = '<?php echo str_replace("'","\"", $myicon);?>';

					return true;
				}

				function ftalk_submit(f) {
					if(!g5_is_member) {
						alert("로그인한 회원만 등록할 수 있습니다.");
						return false;
					}

					var content = "";
					$.ajax({
						url: g5_bbs_url+"/ajax.filter.php",
						type: "POST",
						data: {
							"content": f.wr_content.value
						},
						dataType: "json",
						async: false,
						cache: false,
						success: function(data, textStatus) {
							content = data.content;
						}
					});

					if (content) {
						alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
						if (typeof(ed_wr_content) != "undefined")
							ed_wr_content.returnFalse();
						else
							f.wr_content.focus();
						return false;
					}

					if (document.getElementById("char_count")) {
						if (char_min > 0 || char_max > 0) {
							var cnt = parseInt(check_byte("wr_content", "char_count"));
							if (char_min > 0 && char_min > cnt) {
								alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
								return false;
							}
							else if (char_max > 0 && char_max < cnt) {
								alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
								return false;
							}
						}
					}

					document.getElementById("talk_submit").disabled = "disabled";

					return true;
				}
			</script>
		</div>
	</div>
</div>
