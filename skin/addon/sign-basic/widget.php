<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

global $is_signature, $author, $signature, $at_href;

if(!$is_signature) return;

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css" media="screen">', 0);

?>
<div class="panel panel-default sign-author">
	<div class="panel-heading">
		<h3 class="panel-title">
			<?php if($author['partner']) { ?>
				<a href="<?php echo $at_href['myshop'];?>?id=<?php echo $author['mb_id'];?>" class="pull-right">
					<span class="orangered font-14 en"><i class="fa fa-thumbs-o-up"></i> My Shop</span>
				</a>
			<?php } ?>
			Author
		</h3>
	</div>
	<div class="panel-body">
		<div class="pull-left text-center sign-photo">
			<div class="sign-photo-icon">
				<?php echo ($author['photo']) ? '<img src="'.$author['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
			</div>
			<div class="btn-group" style="margin-top:-30px;white-space:nowrap;">
				<button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $author['mb_id'];?>', 'like', 'it_like'); return false;" title="Like">
					<i class="fa fa-thumbs-up"></i> <span id="it_like"><?php echo $author['liked']; ?></span>
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
				<?php echo ($signature) ? $signature : '등록된 서명이 없습니다.'; ?>
			</p>
		</div>
		<div class="clearfix"></div>
	</div>
</div>	