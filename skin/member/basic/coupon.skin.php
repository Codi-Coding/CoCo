<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>

<div class="sub-title">
	<h4>
		<?php if($member['photo']) { ?>
			<img src="<?php echo $member['photo'];?>" alt="">
		<?php } else { ?>
			<i class="fa fa-user"></i>
		<?php } ?>
		<?php echo $g5['title'];?>
	</h4>
</div>

<div class="coupon-skin">
	<table class="div-table table">
	<tbody>
	<tr class="bg-black">
		<th class="text-center" scope="col">쿠폰명</th>
		<th class="text-center" scope="col">적용대상</th>
		<th class="text-center" scope="col">할인금액</th>
		<th class="text-center" scope="col">사용기한</th>
	</tr>
	<?php for($i=0; $i < count($cp); $i++) { 
		$cp_a = ($cp[$i]['cp_href']) ? '<a href="'.$cp[$i]['cp_href'].'" target="_blank">' : '<a>';	
	?>
		<tr>
			<td><?php echo $cp_a;?><?php echo $cp[$i]['cp_subject']; ?></a></td>
			<td><?php echo $cp_a;?><?php echo $cp[$i]['cp_target']; ?></a></td>
			<td class="text-center"><?php echo $cp[$i]['cp_price']; ?></td>
			<td class="text-center"><?php echo substr($cp[$i]['cp_start'], 2, 8); ?> ~ <?php echo substr($cp[$i]['cp_end'], 2, 8); ?></td>
		</tr>
	<?php } ?>
	<?php if($i == 0) { ?>
		<tr><td colspan="4" class="text-center text-muted" height="150">사용할 수 있는 쿠폰이 없습니다.</td></tr>
	<?php } ?>
	</tbody>
	</table>

	<p class="text-center">
		<button type="button" onclick="window.close();" class="btn btn-black btn-sm">닫기</button>
	</p>
</div>