<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css" media="screen">', 0);
?>

<style>
<?php if($is_dhtml_editor) { ?>
	#wr_content { border:0; display:none; }
<?php } ?>
	.write-wrap label { margin-top:0px; }
	.item-label label { font-weight: normal !important; }
</style>


<div id="bo_w" class="write-wrap<?php echo (G5_IS_MOBILE) ? ' font-14' : '';?>">
    <div class="well">
		<h2><?php echo $g5['title'] ?></h2>
	</div>

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" role="form" class="form-horizontal">
    <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <?php
		$option_cnt = 0;
		$option = '';
		$option_hidden = '';
		if ($is_notice || $is_html || $is_secret || $is_mail) {
			$option = '';
			if ($is_notice) {
				$option .= "\n".'<label class="checkbox-inline"><input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'> 공지</label>';
				$option_ctn++;
			}

			if ($is_html) {
				if ($is_dhtml_editor) {
					$option_hidden .= '<input type="hidden" value="html1" name="html">';
				} else {
					$option .= "\n".'<label class="checkbox-inline"><input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'> HTML</label>';
					$option_ctn++;
				}
			}

			if ($is_secret) {
				if ($is_admin || $is_secret==1) {
					$option .= "\n".'<label class="checkbox-inline"><input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'> 비밀글</label>';
					$option_ctn++;
				} else {
					$option_hidden .= '<input type="hidden" name="secret" value="secret">';
				}
			}

			if ($is_admin) {
				$main_checked = ($write['as_type']) ? ' checked' : '';
				$option .= "\n".'<label class="checkbox-inline"><input type="checkbox" id="as_type" name="as_type" value="1" '.$main_checked.'> 메인글</label>';
				$option_ctn++;
			}

			if ($is_mail) {
				$option .= "\n".'<label class="checkbox-inline"><input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'> 답변메일받기</label>';
				$option_ctn++;
			}
		}

		echo $option_hidden;
    ?>

	<?php if ($is_name) { ?>
		<div class="form-group has-feedback">
			<label class="col-sm-2 control-label" for="wr_name">이름<strong class="sound_only">필수</strong></label>
			<div class="col-sm-3">
				<input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="form-control input-sm" size="10" maxlength="20">
				<span class="fa fa-check form-control-feedback"></span>
			</div>
		</div>
	<?php } ?>

	<?php if ($is_password) { ?>
		<div class="form-group has-feedback">
			<label class="col-sm-2 control-label" for="wr_password">비밀번호<strong class="sound_only">필수</strong></label>
			<div class="col-sm-3">
				<input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="form-control input-sm" maxlength="20">
				<span class="fa fa-check form-control-feedback"></span>
			</div>
		</div>
	<?php } ?>

	<?php if ($is_email) { ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="wr_email">E-mail</label>
			<div class="col-sm-6">
				<input type="text" name="wr_email" id="wr_email" value="<?php echo $email ?>" class="form-control input-sm email" size="50" maxlength="100">
			</div>
		</div>
	<?php } ?>

	<?php if ($is_homepage) { ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="wr_homepage">홈페이지</label>
			<div class="col-sm-6">
				<input type="text" name="wr_homepage" id="wr_homepage" value="<?php echo $homepage ?>" class="form-control input-sm" size="50">
			</div>
		</div>
	<?php } ?>

	<?php if ($is_category) { ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="ca_name">분류<strong class="sound_only">필수</strong></label>
			<div class="col-sm-3">
				<select name="ca_name" id="ca_name" required class="form-control input-sm">
                    <option value="">선택하세요</option>
	                <?php echo $category_option ?>
		        </select>
			</div>
		</div>
	<?php } ?>
	<?php if ($option) { ?>
		<div class="form-group">
			<label class="col-sm-2 control-label">옵션</label>
			<div class="col-sm-10 item-label">
				<?php echo $option ?>
			</div>
		</div>
	<?php } ?>
	<?php if ($is_member) { // 임시 저장된 글 기능 ?>
		<script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
		<?php if($editor_content_js) echo $editor_content_js; ?>
		<div class="modal fade" id="autosaveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">임시 저장된 글 목록</h4>
					</div>
					<div class="modal-body">
						<div id="autosave_wrapper">
							<div id="autosave_pop">
								<ul></ul>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="form-group">
		<label class="col-sm-2 control-label" for="wr_subject">제목<strong class="sound_only">필수</strong></label>
		<div class="col-sm-10">
			<div class="input-group">
				<input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="form-control input-sm" size="50" maxlength="255">
				<span class="input-group-btn">
					<a href="<?php echo G5_BBS_URL;?>/helper.php" target="_blank" class="btn btn-black btn-sm hidden-xs win_scrap">안내</a>
					<a href="<?php echo G5_BBS_URL;?>/helper.php?act=map" target="_blank" class="btn btn-black btn-sm hidden-xs win_scrap">지도</a>
					<?php if ($is_member) { // 임시 저장된 글 기능 ?>
						<button type="button" id="btn_autosave" data-toggle="modal" data-target="#autosaveModal" class="btn btn-black btn-sm">저장 (<span id="autosave_count"><?php echo $autosave_count; ?></span>)</button>
					<?php } ?>
				</span>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<?php if($write_min || $write_max) { ?>
				<!-- 최소/최대 글자 수 사용 시 -->
				<div class="well well-sm" style="margin-bottom:15px;">
					현재 <strong><span id="char_count"></span></strong> 글자이며, 최소 <strong><?php echo $write_min; ?></strong> 글자 이상, 최대 <strong><?php echo $write_max; ?></strong> 글자 이하까지 쓰실 수 있습니다.
				</div>
			<?php } ?>
			<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
		</div>
	</div>

	<?php if($is_admin || ($boset['tag'] && $member['mb_level'] >= $boset['tag'])) { //태그 ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="as_tag">태그</label>
			<div class="col-sm-10">
				<input type="text" name="as_tag" id="as_tag" value="<?php echo $write['as_tag']; ?>" class="form-control input-sm" size="50">
			</div>
		</div>
	<?php } ?>
	<?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="wr_link<?php echo $i ?>">링크 #<?php echo $i ?></label>
			<div class="col-sm-10">
				<input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){ echo $write['wr_link'.$i]; } ?>" id="wr_link<?php echo $i ?>" class="form-control input-sm" size="50">
				<?php if($i == "1") { ?>
					<div class="text-muted font-12" style="margin-top:4px;">
						유튜브, 비메오 등 동영상 공유주소 등록시 해당 동영상은 본문 자동실행
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>	
	<?php if ($is_file) { ?>
		<style>
		#variableFiles { width:100%; margin:0; border:0; }
		#variableFiles td { padding:0px 0px 7px; border:0; }
		#variableFiles input[type=file] { box-shadow : none; border: 1px solid #ccc !important; outline:none; }
		#variableFiles .form-group { margin-left:0; margin-right:0; margin-bottom:7px; }
		#variableFiles .checkbox-inline { padding-top:0px; font-weight:normal; }
		</style>
		<div class="form-group">
			<label class="col-sm-2 control-label">첨부파일</label>
			<div class="col-sm-10">
				<button class="btn btn-sm btn-color" type="button" onclick="add_file();"><i class="fa fa-plus-circle fa-lg"></i> 추가하기</button>
				<button class="btn btn-sm btn-black" type="button" onclick="del_file();"><i class="fa fa-times-circle fa-lg"></i> 삭제하기</button>
			</div>
		</div>
		<div class="form-group" style="margin-bottom:0;">
			<div class="col-sm-10 col-sm-offset-2">
				<table id="variableFiles"></table>
			</div>
		</div>
		<script>
		var flen = 0;
		function add_file(delete_code) {
			var upload_count = <?php echo (int)$board['bo_upload_count']; ?>;
			if (upload_count && flen >= upload_count) {
				alert("이 게시판은 "+upload_count+"개 까지만 파일 업로드가 가능합니다.");
				return;
			}

			var objTbl;
			var objNum;
			var objRow;
			var objCell;
			var objContent;
			if (document.getElementById)
				objTbl = document.getElementById("variableFiles");
			else
				objTbl = document.all["variableFiles"];

			objNum = objTbl.rows.length;
			objRow = objTbl.insertRow(objNum);
			objCell = objRow.insertCell(0);

			objContent = "<div class='row'>";
			objContent += "<div class='col-sm-7'><div class='form-group'><div class='input-group input-group-sm'><span class='input-group-addon'>파일 "+objNum+"</span><input type='file' class='form-control input-sm' name='bf_file[]' title='파일 용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능'></div></div></div>";
			if (delete_code) {
				objContent += delete_code;
		    } else {
				<?php if ($is_file_content) { ?>
				objContent += "<div class='col-sm-5'><div class='form-group'><input type='text'name='bf_content[]' class='form-control input-sm' placeholder='이미지에 대한 내용을 입력하세요.'></div></div>";
				<?php } ?>
				;
			}
			objContent += "</div>";

			objCell.innerHTML = objContent;

			flen++;
		}

		<?php echo $file_script; //수정시에 필요한 스크립트?>

		function del_file() {
			// file_length 이하로는 필드가 삭제되지 않아야 합니다.
			var file_length = <?php echo (int)$file_length; ?>;
			var objTbl = document.getElementById("variableFiles");
			if (objTbl.rows.length - 1 > file_length) {
				objTbl.deleteRow(objTbl.rows.length - 1);
				flen--;
			}
		}
		</script>

		<div class="form-group">
			<label class="col-sm-2 control-label">첨부사진</label>
			<div class="col-sm-10 item-label">
				<label class="radio-inline">
					<input type="radio" name="as_img" value="0"<?php if(!$write['as_img']) echo ' checked';?>> 상단출력
				</label>
				<label class="radio-inline">
					<input type="radio" name="as_img" value="1"<?php if($write['as_img'] == "1") echo ' checked';?>> 하단출력
				</label>
				<label class="radio-inline">
					<input type="radio" name="as_img" value="2"<?php if($write['as_img'] == "2") echo ' checked';?>> 본문삽입
				</label>
				<p class="help-block">
					본문삽입시 {이미지:0}, {이미지:1} 과 같이 첨부번호를 입력하면 내용에 첨부사진 출력 가능
				</p>
			</div>
		</div>
	<?php } ?>

	<?php if ($is_guest) { //자동등록방지  ?>
		<div class="well well-sm text-center">
			<?php echo $captcha_html; ?>
		</div>
	<?php } ?>

    <div class="write-btn pull-center">
        <button type="submit" id="btn_submit" accesskey="s" class="btn btn-color btn-sm"><i class="fa fa-check"></i> <b>작성완료</b></button>
        <a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn btn-black btn-sm" role="button">취소</a>
    </div>

	<div class="clearfix"></div>

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

	function html_auto_br(obj) {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "html2";
            else
                obj.value = "html1";
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
                "subject": f.wr_subject.value,
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

        if (subject) {
            alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
            f.wr_subject.focus();
            return false;
        }

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

        <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

	$(function(){
		$("#wr_content").addClass("form-control input-sm write-content");
	});
    </script>
</div>
<!-- } 게시물 작성/수정 끝 -->