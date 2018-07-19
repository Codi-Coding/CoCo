<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 헤더 출력
if($header_skin)
	include_once('./header.php');

?>

<div class="search-box">
	<form class="form" role="form" name="fsearch" onsubmit="return fsearch_submit(this);" method="get">
	<input type="hidden" name="srows" value="<?php echo $srows ?>">
		<div class="row">
			<div class="col-sm-3 col-xs-6">
				<div class="form-group">
					<label for="gr_id" class="sound_only">그룹</label>
					<select name="gr_id" id="gr_id" class="form-control input-sm">
						<option value="">전체그룹</option>
						<?php echo $group_option ?>
					</select>
				    <script>document.getElementById("gr_id").value = "<?php echo $gr_id ?>";</script>
				</div>
			</div>
			<div class="col-sm-2 col-xs-6">
				<div class="form-group">
					<label for="sfl" class="sound_only">검색조건</label>
					<select name="sfl" id="sfl" class="form-control input-sm">
						<option value="wr_subject||wr_content"<?php echo get_selected($_GET['sfl'], "wr_subject||wr_content") ?>>제목+내용</option>
						<option value="wr_subject"<?php echo get_selected($_GET['sfl'], "wr_subject") ?>>제목</option>
						<option value="wr_content"<?php echo get_selected($_GET['sfl'], "wr_content") ?>>내용</option>
						<option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id") ?>>회원아이디</option>
						<option value="wr_name"<?php echo get_selected($_GET['sfl'], "wr_name") ?>>이름</option>
					</select>
				</div>
			</div>
			<div class="col-sm-3 col-xs-6">
				<div class="form-group">
					<div class="form-group">
					    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
					    <input type="text" name="stx" value="<?php echo $text_stx ?>" id="stx" required class="form-control input-sm" maxlength="20" placeholder="두글자 이상 입력">
					</div>
				</div>
			</div>
			<div class="col-sm-2 col-xs-6">
				<div class="form-group">
   					<select name="sop" id="sop" class="form-control input-sm">
						<option value="or"<?php echo get_selected($sop, "or") ?>>또는</option>
						<option value="and"<?php echo get_selected($sop, "and") ?>>그리고</option>
					</select>	
				</div>
			</div>
			<div class="col-sm-2 col-xs-12">
				<div class="form-group">
					<button type="submit" class="btn btn-black btn-sm btn-block"><i class="fa fa-search"></i> 검색</button>
				</div>
			</div>
		</div>
	</form>
    <script>
    function fsearch_submit(f)
    {
        if (f.stx.value.length < 2) {
            alert("검색어는 두글자 이상 입력하십시오.");
            f.stx.select();
            f.stx.focus();
            return false;
        }

        // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
        var cnt = 0;
        for (var i=0; i<f.stx.value.length; i++) {
            if (f.stx.value.charAt(i) == ' ')
                cnt++;
        }

        if (cnt > 1) {
            alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
            f.stx.select();
            f.stx.focus();
            return false;
        }

        f.action = "";
        return true;
    }
    </script>
</div>

<?php
if ($stx) {
	if ($board_count) {
 ?>
	<div class="row">
		<div class="col-sm-3">
			<div class="form-group">
				<a href="?<?php echo $search_query ?>&amp;gr_id=<?php echo $gr_id ?>" class="btn btn-black btn-sm btn-block">
					전체게시판 (<?php echo number_format($total_count); ?>)
				</a>
			</div>
		</div>
		<?php for($i=0;$i < count($bo_list);$i++) { ?>
			<div class="col-sm-3">
				<div class="form-group">
					<a href="<?php echo $bo_list[$i]['href']; ?>" class="btn btn-default btn-sm btn-block">
						<?php echo $bo_list[$i]['name'];?> (<?php echo number_format($bo_list[$i]['cnt']);?>)
					</a>
				</div>
			</div>
		<?php } ?>
	</div>
	<br>
<?php } else { ?>
	<p class="search-none text-center text-muted<?php echo (G5_IS_MOBILE) ? '' : ' search-none';?>">검색된 자료가 하나도 없습니다.</p>
<?php } } else { ?>
	<p class="search-none text-center text-muted<?php echo (G5_IS_MOBILE) ? '' : ' search-none';?>">검색어는 두글자 이상, 공백은 1개만 입력할 수 있습니다.</p>
<?php } ?>

<div class="clearfix"></div>

<?php
$k=0;
for ($idx=$table_index, $k=0; $idx<count($search_table) && $k<$rows; $idx++) {
?>
	<div class="div-title-wrap">
		<div class="div-title"><strong><a href="./board.php?bo_table=<?php echo $search_table[$idx] ?>&amp;<?php echo $search_query ?>"><?php echo $bo_subject[$idx] ?> 내 결과</a></strong></div>
		<div class="div-sep-wrap">
			<div class="div-sep sep-bold"></div>
		</div>
	</div>
	<div class="search-media">
	<?php
	for ($i=0; $i<count($list[$idx]) && $k<$rows; $i++, $k++) {

		$img = apms_wr_thumbnail($list[$idx][$i]['bo_table'], $list[$idx][$i], 80, 80, false, true); // 썸네일
		$img['src'] = ($img['src']) ? $img['src'] : apms_photo_url($list[$idx][$i]['mb_id']); // 회원사진

		if ($list[$idx][$i]['wr_is_comment']) {
			$comment_def = '<span class="tack-icon bg-orange">댓글</span> ';
			$comment_href = '#c_'.$list[$idx][$i]['wr_id'];
			$fa_icon = 'comment';
			$txt = '[댓글] ';
		} else {
			$comment_def = '';
			$comment_href = '';
			$fa_icon = 'file-text-o';
			$txt = '';
		}
	 ?>
		<div class="media">
			<div class="photo pull-left">
				<?php echo ($img['src']) ? '<img src="'.$img['src'].'" alt="'.$img['src'].'">' : '<i class="fa fa-'.$fa_icon.'"></i>'; ?>
			</div>
			<div class="media-body">
				<a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" target="_blank" class="pull-right"><span class="text-muted font-11">새창</span></a>
				<div class="media-heading">
					<a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>">
						<b><?php echo $comment_def ?><?php echo $icon;?><?php echo $list[$idx][$i]['subject'] ?></b>
					</a>
				</div>
				<div class="media-info font-11 text-muted">
					<i class="fa fa-user"></i>
					<?php echo $list[$idx][$i]['name']; ?>

					<?php if($list[$idx][$i]['ca_name']) { ?>
						<span class="sp"></span>
						<i class="fa fa-tag"></i>
						<?php echo $list[$idx][$i]['ca_name']; ?>
					<?php } ?>

					<span class="hidden-xs">
						<span class="sp"></span>
						<i class="fa fa-clock-o"></i>
						<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$idx][$i]['date']) ?>"><?php echo apms_datetime($list[$idx][$i]['date'], 'Y.m.d H:i');?></time>
					</span>
				</div>
				<div class="media-content">
					<a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>">
						<span class="text-muted"><?php echo apms_cut_text($list[$idx][$i]['content'], 60, '… <span class="font-11 text-muted">더보기</span>'); ?></span>
					</a>
				</div>
			</div>
		</div>
	<?php }  ?>
	</div>
	<div class="text-right">
		<a href="./board.php?bo_table=<?php echo $search_table[$idx] ?>&amp;<?php echo $search_query ?>"><i class="fa fa-search-plus fa-lg lightgray"></i> <strong><?php echo $bo_subject[$idx] ?></strong> 결과 더보기</a>
	</div>
	<div class="clearfix h20"></div>
<?php }  ?>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en">
			<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>