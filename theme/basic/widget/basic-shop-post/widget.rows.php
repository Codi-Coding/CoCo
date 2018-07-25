<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 썸네일
$wset['thumb_w'] = $wset['thumb_h'] = 80;
if(!$wset['rows']) $wset['rows'] = 5;

// 추출하기
$list = apms_item_post_rows($wset);
$list_cnt = count($list);

// 아이콘
$icon = (isset($wset['icon']) && $wset['icon']) ? apms_fa($wset['icon']) : '<i class="fa fa-user"></i>';

// 새글
$is_new = (isset($wset['new']) && $wset['new']) ? $wset['new'] : 'red'; 

// 별점
$is_star = (isset($wset['star']) && $wset['star']) ? $wset['star'] : 'color'; 

// 강조글
$bold = array();
$strong = explode(",", $wset['strong']);
$is_strong = count($strong);
for($i=0; $i < $is_strong; $i++) {

	list($n, $bc) = explode("|", $strong[$i]);

	if(!$n) continue;

	$n = $n - 1;
	$bold[$n]['num'] = true;
	$bold[$n]['color'] = ($bc) ? ' class="'.$bc.'"' : '';
}

// 리스트
for ($i=0; $i < $list_cnt; $i++) {

	// 아이콘
	$wr_icon = $icon;
	if($list[$i]['img']['src']) {
		$wr_icon = '<img src="'.$list[$i]['img']['src'].'" alt="'.$list[$i]['img']['alt'].'">';
	} else if($list[$i]['photo']) {
		$wr_icon = '<img src="'.$list[$i]['photo'].'">';
	}

	//강조글
	if($is_strong) {
		if($bold[$i]['num']) {
			$list[$i]['subject'] = '<b'.$bold[$i]['color'].'>'.$list[$i]['subject'].'</b>';
		}
	}
?>
	<div class="media">
		<div class="pull-left">
			<a href="<?php echo $list[$i]['href'];?>">
				<span class="fix-icon circle normal">
					<?php echo $wr_icon;?>
				</span>
			</a>
		</div>
		<div class="media-body">
			<a href="<?php echo $list[$i]['href'];?>" class="ellipsis">
				<?php if($list[$i]['new']) { ?>
					<span class="rank-icon txt-normal en bg-<?php echo $is_new;?>">New</span>
				<?php } ?>
				<span class="post-subject"><?php echo $list[$i]['subject'];?></span>
			</a>
			<div class="post-text post-ko ellipsis">
				<?php if($wset['mode'] == 'use') { // 후기 ?>
					<span class="font-13 txt-normal <?php echo $is_star;?>"><?php echo $list[$i]['star'];?></span>
				<?php } else if($wset['mode'] == 'qa') { // 문의 ?>
					<?php echo ($list[$i]['answer']) ? '<span class="orangered">답변완료</span>' : '답변대기';?>
				<?php } else if($list[$i]['name']) { ?>
					<?php echo $list[$i]['name'];?>
				<?php } ?>
				<span class="post-sp">|</span>
				<?php echo $list[$i]['it_name'];?>
			</div>
		</div>
	</div>
<?php } ?>
<?php if(!$list_cnt) { ?>
	<div class="post-none">글이 없습니다.</div>
<?php } ?>
