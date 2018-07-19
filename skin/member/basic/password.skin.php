<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$delete_str = "";
if ($w == 'x') $delete_str = "댓";
if ($w == 'u') $g5['title'] = $delete_str."글 수정";
else if ($w == 'd' || $w == 'x') $g5['title'] = $delete_str."글 삭제";
else $g5['title'] = $g5['title'];

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

if($header_skin)
	include_once('./header.php');

?>

<div class="row">
	<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
		<div class="form-box">
			<div class="form-header">
				<h2><b><?php echo cut_str($g5['title'],25); ?></b></h2>
			</div>
			<div class="form-body">
				<p>
					<?php if ($w == 'u') { ?>
						<strong>작성자만 글을 수정할 수 있습니다.</strong>
						<br>
						작성자 본인이라면, 글 작성시 입력한 비밀번호를 입력하여 글을 수정할 수 있습니다.
					<?php } else if ($w == 'd' || $w == 'x') {  ?>
						<strong>작성자만 글을 삭제할 수 있습니다.</strong>
						<br>
						작성자 본인이라면, 글 작성시 입력한 비밀번호를 입력하여 글을 삭제할 수 있습니다.
					<?php } else {  ?>
						<strong>비밀글 기능으로 보호된 글입니다.</strong>
						<br>
						작성자와 관리자만 열람하실 수 있습니다. 본인이라면 비밀번호를 입력하세요.
					<?php }  ?>
				</p>

				<form class="form-horizontal" role="form" name="fboardpassword" action="<?php echo $action; ?>" method="post">
				<input type="hidden" name="w" value="<?php echo $w ?>">
				<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
				<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
				<input type="hidden" name="comment_id" value="<?php echo $comment_id ?>">
				<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
				<input type="hidden" name="stx" value="<?php echo $stx ?>">
				<input type="hidden" name="page" value="<?php echo $page ?>">

					<div class="form-group">
						<label class="col-sm-3 control-label" for="wr_password"><b>비밀번호<strong class="sound_only">필수</strong></b></label>
						<div class="col-sm-8">
							<div class="input-group">
						        <input type="password" name="wr_password" id="password_wr_password" required class="form-control input-sm" size="15" maxLength="20">
								<span class="input-group-btn">
							        <button type="submit" class="btn btn-color btn-sm">확인</button>
								</span>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
