<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 헤더 출력
if($header_skin)
	include_once('./header.php');

$is_view = false;
$list_cnt = count($list);

?>

<section class="qa-list<?php echo (G5_IS_MOBILE) ? ' font-14' : '';?>"> 

	<div class="qsearch-box">
		<form name="fsearch" method="get" role="form" class="form">
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<div class="row row-15">
				<div class="col-sm-4 col-sm-offset-3 col-xs-7 col-15">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-search"></i></span>
							<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="form-control input-sm" maxlength="15" placeholder="검색어">
						</div>
					</div>
				</div>
				<div class="col-sm-2 col-xs-5 col-15">
					<div class="form-group">
						<button type="submit" class="btn btn-black btn-sm btn-block"><i class="fa fa-search"></i> 검색</button>
					</div>
				</div>
			</div>
		</form>
	</div>

	<?php if($category_option) include_once($skin_path.'/category.skin.php'); // 카테고리	?>

	<div class="list-wrap">

		<form name="fqalist" id="fqalist" action="./qadelete.php" onsubmit="return fqalist_submit(this);" method="post" role="form" class="form">
		<input type="hidden" name="stx" value="<?php echo $stx; ?>">
		<input type="hidden" name="sca" value="<?php echo $sca; ?>">
		<input type="hidden" name="page" value="<?php echo $page; ?>">

		<?php include_once($skin_path.'/list.rows.php'); ?>

		<div class="list-btn-box">
			<?php if ($list_href || $write_href) { ?>
				<div class="form-group pull-right list-btn">
					<div class="btn-group">
						<?php if ($list_href) { ?>
							<a href="<?php echo $list_href ?>" class="btn btn-black btn-sm"><i class="fa fa-bars"></i> 목록</a>
						<?php } ?>
						<?php if ($write_href) { ?>
							<a href="<?php echo $write_href ?>" class="btn btn-color btn-sm"><i class="fa fa-pencil"></i> 글쓰기</a>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
			<?php if ($is_checkbox || $admin_href || $setup_href) { ?>
				<div class="form-group list-btn">
					<div class="btn-group btn-group-sm">
						<?php if ($is_checkbox) { ?>
							<input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn-black btn-sm">
						<?php } ?>
						<?php if ($admin_href) { ?>
							<a href="<?php echo $admin_href ?>" class="btn btn-black btn-sm"><i class="fa fa-cog"></i></a>
						<?php } ?>
						<?php if($setup_href) { ?>
							<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
								<i class="fa fa-cogs"></i> 스킨설정
							</a>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
			<div class="clearfix"></div>
		</div>
		</form>
	</div>

	<?php if($is_checkbox) { ?>
		<noscript>
		<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
		</noscript>
	<?php } ?>

	<div class="list-page text-center">
		<ul class="pagination pagination-sm en">
			<?php echo preg_replace('/(\.php)(&amp;|&)/i', '$1?', apms_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './qalist.php'.$qstr.'&amp;page='));?>
		</ul>
	</div>

	<div class="clearfix"></div>

</section>
<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}

function fqalist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다"))
            return false;
    }

    return true;
}
</script>
<?php } ?>
