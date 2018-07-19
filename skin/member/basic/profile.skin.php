<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>
<div class="profile-skin">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Profile</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-2 col-sm-3 text-center">
					<div class="img-photo">
						<?php echo ($mb['photo']) ? '<img src="'.$mb['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
					</div>
					<div class="btn-group" style="margin-top:-30px;white-space:nowrap;">
						<button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $mb['mb_id'];?>', 'like', 'it_like'); return false;" title="Like">
							<i class="fa fa-thumbs-up"></i> <span id="it_like"><?php echo number_format($mb['liked']) ?></span>
						</button>
						<button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $mb['mb_id'];?>', 'follow', 'it_follow'); return false;" title="Follow">
							<i class="fa fa-users"></i> <span id="it_follow"><?php echo $mb['followed']; ?></span>
						</button>
					</div>
				</div>
				<div class="col-lg-10 col-sm-9">
					<div class="font-13" style="margin-bottom:4px;">
						<span class="pull-right font-12">Lv.<?php echo $mb['level'];?></span>
						<b><?php echo $mb_nick; ?></b> &nbsp;<span class="text-muted font-11"><?php echo $mb['grade'];?></span>
					</div>
					<div class="div-progress progress progress-striped no-margin">
						<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($mb['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($mb['exp_per']);?>%;">
							<span class="sr-only"><?php echo number_format($mb['exp']);?> (<?php echo $mb['exp_per'];?>%)</span>
						</div>
					</div>
					<p style="margin-top:10px;">
						<?php echo ($mb_signature) ? $mb_signature : '등록된 서명이 없습니다.'; ?>
					</p>
				</div>
			</div>
		</div>
		<ul class="list-group">
			<li class="list-group-item">
				<span class="pull-right">
					<b><?php echo number_format($mb['mb_point']) ?></b> 점 
				</span>
				<b><?php echo AS_MP;?></b>
			</li>
			<?php if ($mb_homepage) {  ?>
				<li class="list-group-item">
					<span class="pull-right">
						<a href="<?php echo $mb_homepage ?>" target="_blank"><?php echo $mb_homepage ?></a>
					</span>
					<b>홈페이지</b>
				</li>
			<?php }  ?>
			<li class="list-group-item">
				<span class="pull-right">
					<?php echo ($member['mb_level'] >= $mb['mb_level']) ?  substr($mb['mb_datetime'],0,10) ." (".number_format($mb_reg_after)."일)" : "비공개";  ?>
				</span>
				<b>회원가입일</b>
			</li>
			<li class="list-group-item">
				<span class="pull-right">
					<?php echo ($member['mb_level'] >= $mb['mb_level']) ? $mb['mb_today_login'] : "비공개"; ?>
				</span>
				<b>최종접속일</b>
			</li>
			<?php if($mb_profile) { ?>
				<li class="list-group-item">
					<?php echo $mb_profile ?>
				</li>
			<?php } ?>
		</ul>
	</div>

	<p class="text-center">
		<button type="button" onclick="window.close();" class="btn btn-black btn-sm">닫기</button>
	</p>

	<script>
		window.resizeTo(320, 600);
	</script>
</div>