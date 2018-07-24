<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css" media="screen">', 0);

// 값정리
$boset['modal'] = (isset($boset['modal'])) ? $boset['modal'] : '';
$boset['list_skin'] = (isset($boset['list_skin']) && $boset['list_skin']) ? $boset['list_skin'] : 'basic';

//창열기
$is_modal_js = $is_link_target = '';
if($boset['modal'] == "1") { //모달
	$is_modal_js = apms_script('modal');
} else if($boset['modal'] == "2") { //링크#1
	$is_link_target = ' target="_blank"';
}

$list_skin_url = $board_skin_url.'/list/'.$boset['list_skin'];
$list_skin_path = $board_skin_path.'/list/'.$boset['list_skin'];
$list_cnt = count($list);

?>

<section class="board-list<?php echo (G5_IS_MOBILE) ? ' font-14' : '';?>"> 
	<?php if($boset['tsearch']) { ?>
		<div class="list-tsearch">
			<form name="fhsearch" method="get" role="form" class="form">
				<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
				<input type="hidden" name="sca" value="<?php echo $sca ?>">
				<div class="row row-15">
					<div class="col-sm-2 col-sm-offset-1 col-xs-5 col-15">
						<div class="form-group">
							<label for="sfl" class="sound_only">검색조건</label>
							<select name="sfl" id="sfl" class="form-control input-sm">
								<option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
								<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
								<option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
								<option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
								<option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
								<option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
								<option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4 col-xs-7 col-15">
						<div class="form-group">
							<div class="form-group">
								<label for="stx" class="sound_only">검색어</label>
								<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" class="form-control input-sm" maxlength="20" placeholder="검색어">
							</div>
						</div>
					</div>
					<div class="col-sm-2 col-xs-5 col-15">
						<div class="form-group">
							<select name="sop" id="sop" class="form-control input-sm">
								<option value="or"<?php echo get_selected($sop, "or") ?>>또는</option>
								<option value="and"<?php echo get_selected($sop, "and") ?>>그리고</option>
							</select>	
						</div>
					</div>
					<div class="col-sm-2 col-xs-7 col-15">
						<div class="form-group">
							<button type="submit" class="btn btn-<?php echo $boset['tsearch'];?> btn-sm btn-block"><i class="fa fa-search"></i> 검색</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	<?php } ?>

	<?php @include_once($list_skin_path.'/list.head.skin.php'); // 헤드영역 ?>

	<div class="list-wrap">
		<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post" role="form" class="form">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
			<input type="hidden" name="stx" value="<?php echo $stx ?>">
			<input type="hidden" name="spt" value="<?php echo $spt ?>">
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<input type="hidden" name="sst" value="<?php echo $sst ?>">
			<input type="hidden" name="sod" value="<?php echo $sod ?>">
			<input type="hidden" name="page" value="<?php echo $page ?>">
			<input type="hidden" name="sw" value="">
			<?php 
				// 목록스킨
				if(is_file($list_skin_path.'/list.skin.php')) {
					include_once($list_skin_path.'/list.skin.php');
				} else {
					echo '<div class="well text-center"><i class="fa fa-bell red"></i> 설정하신 목록스킨('.$boset['list_skin'].')이 존재하지 않습니다.</div>';
				}
			?>
			<div class="list-btn">
				<div class="form-group pull-right">
					<div class="btn-group dropup" role="group">
						<ul class="dropdown-menu sort-drop" role="menu" aria-labelledby="sortLabel">
							<li>
								<a href="./board.php?bo_table=<?php echo $bo_table;?>&amp;sca=<?php echo urlencode($sca);?>">
									<i class="fa fa-power-off"></i> 초기화
								</a>
							</li>
							<li<?php echo ($sst == 'wr_datetime') ? ' class="sort"' : '';?>>
								<?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>
									<i class="fa fa-clock-o"></i> 날짜순
								</a>
							</li>
							<li<?php echo ($sst == 'wr_hit') ? ' class="sort"' : '';?>>
								<?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>
									<i class="fa fa-eye"></i> 조회순
								</a>
							</li>
							<?php if ($is_good) { ?>
								<li<?php echo ($sst == 'wr_good') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('wr_good', $qstr2, 1) ?>
										<i class="fa fa-thumbs-up"></i> 추천순
									</a>
								</li>
							<?php } ?>
							<?php if ($is_nogood) { ?>
								<li<?php echo ($sst == 'wr_nogood') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>
										<i class="fa fa-thumbs-down"></i> 비추순
									</a>
								</li>
							<?php } ?>
							<?php if ($boset['scmt']) { ?>
								<li<?php echo ($sst == 'wr_comment') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('wr_comment', $qstr2, 1) ?>
										<i class="fa fa-comment"></i> 댓글순
									</a>
								</li>
							<?php } ?>
							<?php if ($boset['sdload']) { ?>
								<li<?php echo ($sst == 'as_download') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('as_download', $qstr2, 1) ?>
										<i class="fa fa-download"></i> 다운순
									</a>
								</li>
							<?php } ?>
							<?php if ($boset['spoll']) { ?>
								<li<?php echo ($sst == 'as_poll') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('as_poll', $qstr2, 1) ?>
										<i class="fa fa-user"></i> 참여순
									</a>
								</li>
							<?php } ?>
							<?php if ($boset['svisit']) { ?>
								<li<?php echo ($sst == 'wr_link1_hit') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('wr_link1_hit', $qstr2, 1) ?>
										<i class="fa fa-share"></i> 방문순
									</a>
								</li>
							<?php } ?>
							<?php if ($boset['supdate']) { ?>
								<li<?php echo ($sst == 'as_update') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('as_update', $qstr2, 1) ?>
										<i class="fa fa-history"></i> 업데이트순
									</a>
								</li>
							<?php } ?>
							<?php if ($boset['sdown']) { ?>
								<li<?php echo ($sst == 'as_down') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('as_down', $qstr2, 1) ?>
										<i class="fa fa-gift"></i> 다운점수순
									</a>
								</li>
							<?php } ?>
						</ul>
						<a id="sortLabel" role="button" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-<?php echo $btn1;?> btn-sm">
							<?php 
								switch($sst) {
									case 'wr_datetime'	: echo '<i class="fa fa-clock-o"></i> 날짜순'; break;
									case 'wr_hit'		: echo '<i class="fa fa-eye"></i> 조회순'; break;
									case 'wr_good'		: echo '<i class="fa fa-thumbs-up"></i> 추천순'; break;
									case 'wr_nogood'	: echo '<i class="fa fa-thumbs-down"></i> 비추순'; break;
									case 'wr_comment'	: echo '<i class="fa fa-comment"></i> 댓글순'; break;
									case 'as_download'	: echo '<i class="fa fa-download"></i> 다운순'; break;
									case 'as_poll'		: echo '<i class="fa fa-user"></i> 참여순'; break;
									case 'wr_link1_hit'	: echo '<i class="fa fa-share"></i> 방문순'; break;
									case 'as_update'	: echo '<i class="fa fa-history"></i> 업데이트순'; break;
									case 'as_down'		: echo '<i class="fa fa-gift"></i> 다운점수순'; break;
									default				: echo '<i class="fa fa-sort"></i> 정렬'; break;
								}
							?>
						</a>
						<?php if ($list_href) { ?><a role="button" href="<?php echo $list_href ?>" class="btn btn-<?php echo $btn1;?> btn-sm"><i class="fa fa-bars"></i> 목록</a><?php } ?>
						<?php if ($write_href) { ?><a role="button" href="<?php echo $write_href ?>" class="btn btn-<?php echo $btn2;?> btn-sm"><i class="fa fa-pencil"></i> 글쓰기</a><?php } ?>
					</div>
				</div>
				<div class="form-group pull-left">
					<div class="btn-group" role="group">
						<?php if ($rss_href) { ?>
							<a role="button" href="<?php echo $rss_href; ?>" class="btn btn-<?php echo $btn2;?> btn-sm"><i class="fa fa-rss"></i></a>
						<?php } ?>
						<a role="button" href="#" class="btn btn-<?php echo $btn1;?> btn-sm" data-toggle="modal" data-target="#searchModal" onclick="return false;"><i class="fa fa-search"></i><span class="hidden-xs"> 검색</span></a>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="list-page text-center">
				<ul class="pagination en no-margin">
					<?php if($prev_part_href) { ?>
						<li><a href="<?php echo $prev_part_href;?>">이전검색</a></li>
					<?php } ?>
					<?php echo apms_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './board.php?bo_table='.$bo_table.$qstr.'&amp;page=');?>
					<?php if($next_part_href) { ?>
						<li><a href="<?php echo $next_part_href;?>">다음검색</a></li>
					<?php } ?>
				</ul>
			</div>

			<div class="clearfix"></div>
			<?php if ($is_checkbox || $setup_href || $admin_href) { ?>
				<div class="list-admin">
					<div class="btn-group" role="group">
						<?php if ($is_checkbox) { ?>
							<button type="button" class="btn-chkall btn btn-<?php echo $btn1;?> btn-sm"><i class="fa fa-check"></i><span class="hidden-xs"> 전체선택</span></button>
							<button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn-<?php echo $btn1;?> btn-sm"><i class="fa fa-times"></i><span class="hidden-xs"> 선택삭제</span></button>
							<button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn btn-<?php echo $btn1;?> btn-sm"><i class="fa fa-clipboard"></i><span class="hidden-xs"> 선택복사</span></button>
							<button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="btn btn-<?php echo $btn1;?> btn-sm"><i class="fa fa-arrows"></i><span class="hidden-xs"> 선택이동</span></button>
						<?php } ?>
						<?php if ($admin_href) { ?>
							<a role="button" href="<?php echo $admin_href; ?>" class="btn btn-<?php echo $btn1;?> btn-sm"><i class="fa fa-cog"></i><span class="hidden-xs"> 보드설정</span></a>
						<?php } ?>
						<?php if ($setup_href) { ?>
							<a role="button" href="<?php echo $setup_href; ?>" class="btn btn-<?php echo $btn2;?> btn-sm win_memo"><i class="fa fa-cogs"></i><span class="hidden-xs"> 추가설정</span></a>
						<?php } ?>
					</div>
				</div>
			<?php } ?>

		</form>

		<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-body">
						<div class="text-center">
							<h4 id="myModalLabel"><i class="fa fa-search fa-lg"></i> Search</h4>
						</div>
						<form name="fsearch" method="get" role="form" class="form" style="margin-top:20px;">
							<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
							<input type="hidden" name="sca" value="<?php echo $sca ?>">
							<div class="row row-15">
								<div class="col-xs-6 col-15">
									<div class="form-group">
										<label for="sfl" class="sound_only">검색대상</label>
										<select name="sfl" id="sfl" class="form-control input-sm">
											<option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
											<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
											<option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
											<option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
											<option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
											<option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
											<option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
										</select>
									</div>
								</div>
								<div class="col-xs-6 col-15">
									<div class="form-group">
										<select name="sop" id="sop" class="form-control input-sm">
											<option value="or"<?php echo get_selected($sop, "or") ?>>또는</option>
											<option value="and"<?php echo get_selected($sop, "and") ?>>그리고</option>
										</select>	
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
								<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="form-control input-sm" maxlength="20" placeholder="검색어">
							</div>
							<div class="row row-15">
								<div class="col-xs-6 col-15">
									<button type="submit" class="btn btn-<?php echo $btn2;?> btn-sm btn-block"><i class="fa fa-check"></i> 검색</button>
								</div>
								<div class="col-xs-6 col-15">
									<button type="button" class="btn btn-<?php echo $btn1;?> btn-sm btn-block" data-dismiss="modal"><i class="fa fa-times"></i> 닫기</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php @include_once($list_skin_path.'/list.tail.skin.php'); // 테일영역 ?>

</section>

<?php if ($is_checkbox) { ?>
<noscript>
<p align="center">자바스크립트를 사용하지 않는 경우 별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>

<script>
function all_checked(sw) {
	var f = document.fboardlist;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]")
			f.elements[i].checked = sw;
	}
}
$(function(){
	$(".btn-chkall").click(function(){
		var clicked_checked = $(this);

		if(clicked_checked.hasClass('active')) {
			all_checked(false);
			clicked_checked.removeClass('active');
		} else {
			all_checked(true);
			clicked_checked.addClass('active');
		}
	});
});
function fboardlist_submit(f) {
	var chk_count = 0;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
			chk_count++;
	}

	if (!chk_count) {
		alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
		return false;
	}

	if(document.pressed == "선택복사") {
		select_copy("copy");
		return;
	}

	if(document.pressed == "선택이동") {
		select_copy("move");
		return;
	}

	if(document.pressed == "선택삭제") {
		if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
			return false;

		f.removeAttribute("target");
		f.action = "./board_list_update.php";
	}

	return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
	var f = document.fboardlist;

	if (sw == "copy")
		str = "복사";
	else
		str = "이동";

	var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

	f.sw.value = sw;
	f.target = "move";
	f.action = "./move.php";
	f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->

<div class="h20"></div>