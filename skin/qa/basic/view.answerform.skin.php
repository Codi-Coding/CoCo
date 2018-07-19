<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<div class="panel panel-default no-margin">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-comment"></i> Answer</h3>
	</div>
	<div class="panel-body">
		<?php if($is_admin) { // 관리자이면 답변등록 ?>
			<div class="write-wrap">
				<?php if($is_dhtml_editor) { ?>
					<style>
						.cke_sc { display:none; }
						#qa_content { border:0; display:none; }
					</style>
				<?php } ?>
				<form name="fanswer" method="post" action="./qawrite_update.php" onsubmit="return fwrite_submit(this);" autocomplete="off" role="form" class="form">
				<input type="hidden" name="qa_id" value="<?php echo $view['qa_id']; ?>">
				<input type="hidden" name="w" value="a">
				<input type="hidden" name="sca" value="<?php echo $sca ?>">
				<input type="hidden" name="stx" value="<?php echo $stx; ?>">
				<input type="hidden" name="page" value="<?php echo $page; ?>">
					<div class="form-group<?php if(!$is_dhtml_editor) echo ' input-group';?>">
						<label class="sound_only" for="qa_subject">제목</label>
						<input type="text" name="qa_subject" value="" id="qa_subject" required class="form-control input-sm" placeholder="제목" size="50" maxlength="255">
						<?php
							if ($is_dhtml_editor) {
								echo '<input type="hidden" name="qa_html" value="1">';
							} else {
								echo '<span class="input-group-addon font-12"><label style="padding:0; margin:0;font-weight:normal;"><input type="checkbox" id="qa_html" name="qa_html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.' style="padding:0; margin:0;"> html</label></span>';
							}
						?>
					</div>

					<div class="form-group">
						<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
					</div>

					<div class="text-center">
						<button type="submit" id="btn_submit" accesskey="s" class="btn btn-color btn-sm"><i class="fa fa-comment"></i> 답변쓰기</button>
					</div>
				</form>

				<script>
					function html_auto_br(obj) {
						if (obj.checked) {
							result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
							if (result)
								obj.value = "2";
							else
								obj.value = "1";
						}
						else
							obj.value = "";
					}

					function fwrite_submit(f) {
						<?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

						var subject = "";
						var content = "";
						$.ajax({
							url: g5_bbs_url+"/ajax.filter.php",
							type: "POST",
							data: {
								"subject": f.qa_subject.value,
								"content": f.qa_content.value
							},
							dataType: "json",
							async: false,
							cache: false,
							success: function(data, textStatus) {
								subject = data.subject;
								content = data.content;
							}
						});

						if (subject) {
							alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
							f.qa_subject.focus();
							return false;
						}

						if (content) {
							alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
							if (typeof(ed_qa_content) != "undefined")
								ed_qa_content.returnFalse();
							else
								f.qa_content.focus();
							return false;
						}

						document.getElementById("btn_submit").disabled = "disabled";

						return true;
					}
					$(function(){
						$("#qa_content").addClass("form-control input-sm write-content");
					});
				</script>
			</div>
		<?php } else { ?>
			<p class="help-block text-center">문의에 대한 답변을 준비 중입니다.</p>
		<?php }	?>
	</div>
</div>
