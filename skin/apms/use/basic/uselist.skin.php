<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 헤더 출력
if($header_skin)
	include_once('./header.php');

if(!$wset['cont']) $wset['cont'] = 60;

$list_cnt = count($list);

?>

<div class="use-box">
	<form class="form" role="form" method="get" action="./itemuselist.php">
		<div class="row">
			<div class="col-sm-3 col-xs-6">
				<div class="form-group">
					<label for="ca_id" class="sound_only">분류</label>
					<select name="ca_id" id="ca_id" class="form-control input-sm">
						<option value="">카테고리</option>
						<?php echo apms_category($ca_id);?>
					</select>
				</div>
			</div>
			<div class="col-sm-3 col-xs-6">
				<div class="form-group">
					<label for="sfl" class="sound_only">검색항목<strong class="sound_only"> 필수</strong></label>
					<select name="sfl" id="sfl" class="form-control input-sm">
						<option value="">선택</option>
						<option value="b.it_name"    <?php echo get_selected($sfl, "b.it_name", true); ?>>상품명</option>
						<option value="a.it_id"      <?php echo get_selected($sfl, "a.it_id"); ?>>상품코드</option>
						<option value="a.is_subject" <?php echo get_selected($sfl, "a.is_subject"); ?>>후기제목</option>
						<option value="a.is_name"    <?php echo get_selected($sfl, "a.is_id"); ?>>작성자명</option>
						<option value="a.mb_id"      <?php echo get_selected($sfl, "a.mb_id"); ?>>작성자아이디</option>
					</select>
				</div>
			</div>
			<div class="col-sm-3 col-xs-6">
				<div class="form-group">
					<div class="form-group">
						<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
						<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" class="form-control input-sm" placeholder="검색어">
					</div>
				</div>
			</div>
			<div class="col-sm-3 col-xs-6">
				<div class="form-group">
					<button type="submit" class="btn btn-black btn-sm btn-block"><i class="fa fa-search"></i> 검색하기</button>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="div-box-light"> 
	총 <b><?php echo number_format($total_count);?></b>개의 후기가 등록되어 있습니다.
</div>

<div class="h20"></div>

<div class="use-media">	
	<?php 
		for ($i=0; $i < $list_cnt; $i++) { 
			// 이미지
			$img = apms_it_write_thumbnail($list[$i]['it_id'], $list[$i]['is_content'], 80, 80);
			$img['src'] = ($img['src']) ? $img['src'] : $list[$i]['is_photo'];
	?>
		<div class="div-title-wrap">
			<div class="div-title">
				<strong>
					<a href="<?php echo $list[$i]['is_href']; ?>">
						<?php echo $list[$i]['is_num']; ?>.<?php echo $list[$i]['is_subject']; ?>
					</a>
				</strong>
			</div>
			<div class="div-sep-wrap">
				<div class="div-sep sep-thin"></div>
			</div>
		</div>

		<div class="media">
			<div class="photo pull-left">
				<a href="<?php echo $list[$i]['is_href']; ?>">
					<?php echo ($img['src']) ? '<img src="'.$img['src'].'" alt="'.$img['src'].'">' : '<i class="fa fa-user"></i>'; ?>
				</a>
			</div>
			<div class="media-body">
				<div class="media-info text-muted">
					<?php echo apms_get_star($list[$i]['is_score'],'red font-14'); //별점 ?>
					<span class="sp"></span>
					<i class="fa fa-user"></i>
					<?php echo $list[$i]['is_name']; ?>
					<span class="sp"></span>
					<i class="fa fa-clock-o"></i>
					<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$i]['is_time']) ?>"><?php echo apms_date($list[$i]['is_time'], 'orangered', 'before', 'm.d', 'Y.m.d');?></time>
				</div>
				<div class="media-content">
					<a href="<?php echo $list[$i]['is_href']; ?>">
						<span class="text-muted"><?php echo apms_cut_text($list[$i]['is_content'], $wset['cont'], '… <span class="font-11 text-muted">더보기</span>'); ?></span>
					</a>
				</div>
				<div class="media-heading">
					<a href="<?php echo $list[$i]['it_href']; ?>">
						<span class="font-11 text-muted"><i class="fa fa-cube"></i> <?php echo $list[$i]['it_name']; ?></span>
					</a>
				</div>
			</div>
		</div>
	<?php } ?>
</div>

<?php if(!$i) { ?>
	<div class="use-none text-center text-muted">등록된 후기가 없습니다.</div>
<?php } ?>

<div class="text-center">
	<ul class="pagination pagination-sm">
		<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
	</ul>
</div>

<?php if ($is_admin || $setup_href) { ?>
	<div class="print-hide text-center">
		<?php if($is_admin) { ?>
			<a class="btn btn-black btn-sm" href="<?php echo G5_ADMIN_URL;?>/apms_admin/apms.admin.php?ap=thema"><i class="fa fa-cog"></i> 설정</a>
		<?php } ?>
		<?php if($setup_href) { ?>
			<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>"><i class="fa fa-cogs"></i> 스킨설정</a>
		<?php } ?>
		<div class="h30"></div>
	</div>
<?php } ?>