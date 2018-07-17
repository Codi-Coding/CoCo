<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

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
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tag"></i></span>
						    <input type="text" name="q" value="<?php echo $q; ?>" id="q" required class="form-control input-sm" maxlength="20" placeholder="두글자 이상 입력">
						</div>
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
			<li<?php echo ($sort == "") ? ' class="active"' : '';?>>
				<a href="./tag.php"><b>최신</b></a>
			</li>
			<li<?php echo ($sort == "popular") ? ' class="active"' : '';?>>
				<a href="./tag.php?sort=popular"><b>인기</b></a>
			</li>
			<li<?php echo ($sort == "index") ? ' class="active"' : '';?>>
				<a href="./tag.php?sort=index"><b>색인</b></a>
			</li>
			<li>
				<a>Total <?php echo number_format($total_count);?></a>
			</li>
		</ul>
	</div>
</aside>

<?php if($is_admin == 'super') { ?>
	<form id="tagform" name="tagform" method="post" onsubmit="return ftag_submit(this);" role="form" class="form">
	<input type="hidden" name="sort" value="<?php echo $sort;?>">
	<input type="hidden" name="opt" value="del">
<?php } ?>

<?php for($i=0; $i < $list_cnt; $i++) { ?>
	<?php if($i > 0 && $list[$i]['is_sp']) { ?>
		</div>
	<?php } ?>
	<?php if($list[$i]['is_sp']) { 
		switch($sort) {
			case 'index'	: $tagbox_title = '<i class="fa fa-book fa-lg lightgray"></i> <b>'.$list[$i]['idx'].'</b>'; break;	
			case 'popular'	: $tagbox_title = '<i class="fa fa-trophy fa-lg lightgray"></i> <b>TOP '.$list[$i]['last'].'</b>'; break;
			default			: $tagbox_title = '<i class="fa fa-clock-o fa-lg lightgray"></i> <b>'.date('M', $list[$i]['date']).' '.date('Y', $list[$i]['date']).'</b>'; break;
		}
	?>
		<div class="div-title-wrap">
			<h4 class="div-title"><?php echo $tagbox_title;?></h4>
			<div class="div-sep-wrap">
				<div class="div-sep sep-bold"></div>
			</div>
		</div>
		<div class="row" style="margin-bottom:30px;">
	<?php } ?>
		<div class="col-sm-3 col-xs-6">
			<div class="ellipsis">
				<?php if($is_admin == 'super') { ?>
					<input type="checkbox" name="chk_id[]" value="<?php echo $i;?>">
					<input type="hidden" name="id[<?php echo $i;?>]" value="<?php echo $list[$i]['id'];?>">
				<?php } ?>
				<a href="<?php echo $list[$i]['href'];?>">
					<?php echo ($sort == 'popular') ? $list[$i]['rank'].'.' : '';?>
					<?php echo $list[$i]['tag'];?>
					(<?php echo $list[$i]['cnt'];?>)
				</a>
			</div>
		</div>
<?php } ?>
<?php if($i > 0) { ?>
	</div>
<?php } ?>

<div class="text-center">
	<ul class="pagination pagination-sm en">
		<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
	</ul>
</div>

<?php if($is_admin == 'super') { ?>
		<p class="text-center">
			<button type="submit" class="btn btn-black btn-sm">선택삭제</button>
		</p>
		<p class="text-center text-muted">
			태그삭제시 색인과 로그기록만 삭제되고, 글과 아이템에 등록된 태그정보는 삭제되지 않습니다.
		</p>
	</form>
	<script>
		function ftag_submit(f) {

			var cnt = 0;
			for (var i=0; i<f.length; i++) {
				if (f.elements[i].name == "chk_id[]" && f.elements[i].checked)
					cnt++;
			}

			if (!cnt) {
				alert("삭제할 태그를 하나 이상 선택하세요.");
				return false;
			}

			if (!confirm("선택한 태그를 정말 삭제 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다")) {
				return false;
			}

			f.action = "./tag.php";

			return true;
		}
	</script>
<?php } ?>