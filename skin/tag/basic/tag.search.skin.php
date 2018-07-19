<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 헤더 출력
if($header_skin)
	include_once('./header.php');

?>

<div class="tagbox-box">
	<form class="form" role="form" name="fsearch" onsubmit="return fsearch_submit(this);" method="get">
		<div class="row">
			<div class="col-sm-4 col-sm-offset-3 col-xs-7">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
						<input type="text" name="q" value="<?php echo $q; ?>" id="q" required class="form-control input-sm" maxlength="20" placeholder="두글자 이상 입력">
					</div>
				</div>
			</div>
			<div class="col-sm-2 col-xs-5">
				<div class="form-group">
					<button type="submit" class="btn btn-black btn-sm btn-block"><i class="fa fa-search"></i> 검색</button>
				</div>
			</div>
		</div>
	</form>
    <script>
    function fsearch_submit(f)
    {
        if (f.q.value.length < 2) {
            alert("검색어는 두글자 이상 입력하십시오.");
            f.q.select();
            f.q.focus();
            return false;
        }

        // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
        var cnt = 0;
        for (var i=0; i<f.q.value.length; i++) {
            if (f.q.value.charAt(i) == ' ')
                cnt++;
        }

        if (cnt > 1) {
            alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
            f.q.select();
            f.q.focus();
            return false;
        }

        f.action = "";
        return true;
    }
    </script>
</div>

<aside>
	<div class="div-tab tabs" style="margin-bottom:20px;">
		<ul class="nav nav-tabs nav-justified">
			<li class="active">
				<a><b>Total <?php echo number_format($total_count);?></b></a>
			</li>
			<li>
				<a href="./tag.php">최신</a>
			</li>
			<li>
				<a href="./tag.php?sort=popular">인기</a>
			</li>
			<li>
				<a href="./tag.php?sort=index">색인</a>
			</li>
		</ul>
	</div>
</aside>

<div class="tagbox-media">
	<?php for($i=0; $i < count($list); $i++) { ?>
		<div class="media">
			<div class="photo pull-left">
				<?php if($list[$i]['img']['src']) { 
					$img = apms_thumbnail($list[$i]['img']['src'], 80, 80);
				?>
					<img src="<?php echo $img['src'];?>" alt="<?php echo $img['alt'];?>">
				<?php } else { ?>
					<i class="fa fa-tag"></i>
				<?php } ?>
			</div>
			<div class="media-body">
				<a href="<?php echo $list[$i]['href'] ?>" target="_blank" class="pull-right"><span class="text-muted font-11">새창</span></a>
				<div class="media-heading">
					<a href="<?php echo $list[$i]['href'] ?>">
						<b><?php echo $list[$i]['subject'] ?></b>
					</a>
				</div>
				<div class="media-info text-muted">
					<i class="fa fa-comment"></i>
					<?php echo ($list[$i]['comment']) ? '<span class="red">'.number_format($list[$i]['comment']).'</span>' : 0; ?>

					<span class="sp"></span>
					<i class="fa fa-eye"></i>
					<?php echo number_format($list[$i]['hit']);?>

					<span class="hidden-xs">
						<span class="sp"></span>
						<i class="fa fa-clock-o"></i>
						<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$i]['date']) ?>"><?php echo apms_datetime($list[$i]['date'], 'Y.m.d H:i');?></time>
					</span>
				</div>
				<div class="media-content">
					<a href="<?php echo $list[$i]['href'] ?>">
						<span class="text-muted"><?php echo apms_cut_text($list[$i]['content'], 60, '… <span class="font-11 text-muted">더보기</span>'); ?></span>
					</a>
				</div>
			</div>
		</div>
	<?php }  ?>
	<?php if($i == 0) { ?>
		<p class="tagbox-none text-center text-muted">검색된 자료가 하나도 없습니다.</p>
	<?php }  ?>
</div>
<div class="clearfix"></div>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en">
			<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>