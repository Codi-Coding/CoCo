<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<div class="panel panel-default view-author">
	<div class="panel-heading">
		<div class="pull-right en">
			<a href="<?php echo $rss_href;?>" target="_blank"><i class="fa fa-rss"></i> <b>RSS</b></a>
		</div>
		<h3 class="panel-title">Author</h3>
	</div>
	<div class="panel-body">
		<div class="pull-left text-center auth-photo">
			<div class="img-photo">
				<?php echo ($author['photo']) ? '<img src="'.$author['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
			</div>
			<div class="btn-group" style="margin-top:-30px;white-space:nowrap;">
				<button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $author['mb_id'];?>', 'like', 'it_like'); return false;" title="Like">
					<i class="fa fa-thumbs-up"></i> <span id="it_like"><?php echo number_format($author['liked']) ?></span>
				</button>
				<button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $author['mb_id'];?>', 'follow', 'it_follow'); return false;" title="Follow">
					<i class="fa fa-users"></i> <span id="it_follow"><?php echo $author['followed']; ?></span>
				</button>
			</div>
		</div>
		<div class="auth-info">
			<div style="margin-bottom:4px;">
				<span class="pull-right">Lv.<?php echo $author['level'];?></span>
				<b><?php echo $author['name']; ?></b> &nbsp;<span class="text-muted font-11"><?php echo $author['grade'];?></span>
			</div>
			<div class="div-progress progress progress-striped no-margin">
				<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($author['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($author['exp_per']);?>%;">
					<span class="sr-only"><?php echo number_format($author['exp']);?> (<?php echo $author['exp_per'];?>%)</span>
				</div>
			</div>
			<p style="margin-top:10px;">
				<?php echo ($author_signature) ? $author_signature : '등록된 서명이 없습니다.'; ?>
			</p>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<aside>
	<div class="row">
		<div class="col-sm-3">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-tags"></i></span>
				<select name="ca_id" onchange="location='./myshop.php?id=<?php echo $id;?>&ca_id=' + this.value;" class="form-control input-sm">
					<option value="">카테고리</option>
					<?php echo $category_options;?>
				</select>
			</div>
			<div class="h15"></div>
		</div>
		<div class="col-sm-6">

		</div>
		<div class="col-sm-3">
			<div class="input-group pull-right">
				<span class="input-group-addon"><i class="fa fa-sort-amount-desc"></i></span>
				<select name="sortodr" onchange="location='<?php echo $list_sort_href; ?>' + this.value;" class="form-control input-sm">
					<option value="">정렬하기</option>
					<option value="it_sum_qty&amp;sortodr=desc"<?php echo ($sort == 'it_sum_qty') ? ' selected' : '';?>>판매많은순</option>
					<option value="it_price&amp;sortodr=asc"<?php echo ($sort == 'it_price' && $sortodr == 'asc') ? ' selected' : '';?>>낮은가격순</option>
					<option value="it_price&amp;sortodr=desc"<?php echo ($sort == 'it_price' && $sortodr == 'desc') ? ' selected' : '';?>>높은가격순</option>
					<option value="it_use_avg&amp;sortodr=desc"<?php echo ($sort == 'it_use_avg') ? ' selected' : '';?>>평점높은순</option>
					<option value="it_use_cnt&amp;sortodr=desc"<?php echo ($sort == 'it_use_cnt') ? ' selected' : '';?>>후기많은순</option>
					<option value="pt_good&amp;sortodr=desc"<?php echo ($sort == 'pt_good') ? ' selected' : '';?>>추천많은순</option>
					<option value="pt_comment&amp;sortodr=desc"<?php echo ($sort == 'pt_comment') ? ' selected' : '';?>>댓글많은순</option>
					<option value="it_update_time&amp;sortodr=desc"<?php echo ($sort == 'it_update_time') ? ' selected' : '';?>>최근등록순</option>
				</select>
			</div>
		</div>
	</div>
</aside>

<div class="h15 visible-xs"></div>