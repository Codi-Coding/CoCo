<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 목록헤드
if(isset($wset['hskin']) && $wset['hskin']) {
	add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/head/'.$wset['hskin'].'.css" media="screen">', 0);
	$head_class = 'list-head';
} else {
	$head_class = (isset($wset['hcolor']) && $wset['hcolor']) ? 'border-'.$wset['hcolor'] : 'border-black';
}

// 헤더 출력
if($header_skin)
	include_once('./header.php');
?>

<div class="new-box">
	<form class="form" role="form" name="fnew" method="get">
		<div class="row row-15">
			<div class="col-sm-3 col-xs-6 col-15">
				<div class="form-group">
					<label for="gr_id" class="sound_only">그룹</label>
					<select name="gr_id" id="gr_id" class="form-control input-sm">
						<option value="">전체그룹</option>
						<?php echo $group_option ?>
					</select>
				</div>
			</div>
			<div class="col-sm-3 col-xs-6 col-15">
				<div class="form-group">
					<label for="view" class="sound_only">검색대상</label>
					<select name="view" id="view" class="form-control input-sm">
						<option value="">전체게시물
						<option value="w">원글만
						<option value="c">코멘트만
					</select>
				</div>
			</div>
			<div class="col-sm-3 col-xs-6 col-15">
				<div class="form-group">
					<div class="form-group">
					    <label for="mb_id" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
					    <input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="mb_id" class="form-control input-sm" placeholder="회원아이디">
					</div>
				</div>
			</div>
			<div class="col-sm-3 col-xs-6 col-15">
				<div class="form-group">
					<button type="submit" class="btn btn-black btn-sm btn-block"><i class="fa fa-search"></i> 검색하기</button>
				</div>
			</div>
		</div>
	</form>

    <script>
    /* 셀렉트 박스에서 자동 이동 해제
    function select_change()
    {
        document.fnew.submit();
    }
    */
    document.getElementById("gr_id").value = "<?php echo $gr_id ?>";
    document.getElementById("view").value = "<?php echo $view ?>";
    </script>
</div>

<!-- 전체게시물 목록 시작 { -->
<form class="form" role="form" name="fnewlist" method="post" action="#" onsubmit="return fnew_submit(this);">
<input type="hidden" name="sw"       value="move">
<input type="hidden" name="view"     value="<?php echo $view; ?>">
<input type="hidden" name="sfl"      value="<?php echo $sfl; ?>">
<input type="hidden" name="stx"      value="<?php echo $stx; ?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
<input type="hidden" name="page"     value="<?php echo $page; ?>">
<input type="hidden" name="pressed"  value="">

	<div class="list-board">
		<div class="div-head <?php echo $head_class;?>">
			<?php if ($is_admin) { ?>
			<span class="chk">
				<label for="all_chk" class="sound_only">목록 전체</label>
				<input type="checkbox" id="all_chk">
			</span>
			<?php } ?>
			<span class="thumb">구분</span>
			<span class="subj">제목</span>
			<span class="name hidden-xs">이름</span>
			<span class="date hidden-xs">날짜</span>
		</div>
		<ul id="list-container" class="board-list">
		<?php
			for ($i=0; $i<count($list); $i++)
			{
				$num = $total_count - ($page - 1) * $config['cf_page_rows'] - $i;
				$gr_subject = cut_str($list[$i]['gr_subject'], 20);
				$bo_subject = cut_str($list[$i]['bo_subject'], 20);
				$wr_subject = get_text(cut_str($list[$i]['wr_subject'], 30));
				$date = strtotime($list[$i]['wr_datetime']);
				$wr_date = apms_datetime($date, 'Y.m.d');
				$is_new = ($date + 86400) - G5_SERVER_TIME; // 24시간
			?>
			<li class="list-item">
				<?php if ($is_admin) { ?>
					<div class="chk">
						<label for="chk_bn_id_<?php echo $i; ?>" class="sound_only"><?php echo $num?>번</label>
						<input type="checkbox" name="chk_bn_id[]" value="<?php echo $i; ?>" id="chk_bn_id_<?php echo $i; ?>">
						<input type="hidden" name="bo_table[<?php echo $i; ?>]" value="<?php echo $list[$i]['bo_table']; ?>">
						<input type="hidden" name="wr_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['wr_id']; ?>">
					</div>
				<?php } ?>
				<div class="thumb">
					<div class="icon">
						<?php if($list[$i]['is_lock']) { ?>
							<a href="<?php echo $list[$i]['href']; ?>" class="bg-<?php echo ($is_new > 0) ? 'orangered' : 'light';?>">
								<i class="fa fa-lock"></i>
							</a>
						<?php } else { ?>
							<?php if($list[$i]['comment']) { ?>
								<a href="<?php echo $list[$i]['href']; ?>" class="bg-<?php echo ($is_new > 0) ? 'green' : 'light';?>">
									<i class="fa fa-comment"></i>
								</a>
							<?php } else { ?>
								<a href="<?php echo $list[$i]['href']; ?>" class="bg-<?php echo ($is_new > 0) ? 'blue' : 'light';?>">
									<i class="fa fa-pencil"></i>
								</a>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
				<div class="subj">
					<a href="<?php echo $list[$i]['href'] ?>" class="ellipsis"><?php echo $wr_subject ?></a>
					<div class="subj-item font-12 text-muted ellipsis">
						<span class="hide"><?php echo $list[$i]['name'] ?></span>
						<span>
							<a href="./new.php?gr_id=<?php echo $list[$i]['gr_id'] ?>"><?php echo $gr_subject ?></a>
							>
							<a href="./board.php?bo_table=<?php echo $list[$i]['bo_table'] ?>"><?php echo $bo_subject ?></a>
						</span>
						<span class="hide"><i class="fa fa-clock-o"></i> <?php echo $wr_date; ?></span>
					</div>
				</div>
				<div class="name hidden-xs">
					<?php echo $list[$i]['name'] ?>
				</div>
				<div class="date hidden-xs">
					<?php echo $wr_date; ?>
				</div>
			</li>
		<?php }  ?>
		</ul>
		<?php if ($i == 0) { ?>
			<div class="none text-center text-muted">게시물이 없습니다.</div>
		<?php } ?>
	</div>

	<div class="text-center">
		<ul class="pagination en">
			<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
		</ul>
	</div>

	<?php if ($is_admin || $setup_href) { ?>
		<p class="print-hide text-center">
			<?php if ($is_admin) { ?>
				<input type="submit" onclick="document.pressed=this.value" value="선택삭제" class="btn btn-black btn-sm">
			<?php } ?>
			<?php if($setup_href) { ?>
				<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
					<i class="fa fa-cogs"></i> 스킨설정
				</a>
			<?php } ?>
		</p>
	<?php } ?>

</form>

<?php if ($is_admin) { ?>
	<script>
	$(function(){
		$('#all_chk').click(function(){
			$('[name="chk_bn_id[]"]').attr('checked', this.checked);
		});
	});

	function fnew_submit(f)
	{
		f.pressed.value = document.pressed;

		var cnt = 0;
		for (var i=0; i<f.length; i++) {
			if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
				cnt++;
		}

		if (!cnt) {
			alert(document.pressed+"할 게시물을 하나 이상 선택하세요.");
			return false;
		}

		if (!confirm("선택한 게시물을 정말 "+document.pressed+" 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다")) {
			return false;
		}

		f.action = "./new_delete.php";

		return true;
	}
	</script>
<?php } ?>
