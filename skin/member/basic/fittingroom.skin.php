<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 목록헤드
if(isset($wset['chead']) && $wset['chead']) {
	add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/head/'.$wset['chead'].'.css" media="screen">', 0);
	$head_class = 'list-head';
} else {
	$head_class = (isset($wset['ccolor']) && $wset['ccolor']) ? 'tr-head border-'.$wset['ccolor'] : 'tr-head border-black';
}

// 헤더 출력
if($header_skin)
	include_once('./header.php');

?>



<div class="row">
	<div class="col-sm-6">
		<img id="me" src="sadf.jpg" width="400" height="600"/>
	</div>
	<div class="col-sm-6">
        <div>
            <button>List</button>
            <button>검색</button>
        </div>
        <div class="wishlist-skin">
	<table class="div-table table bg-white">
	<tbody>
	<?php 
	for($i=0; $i < count($list);$i++) { 
		$list[$i]['img'] = apms_it_thumbnail($list[$i], 40, 40, false, true);	
	?>
		<tr>
			<td class="text-center">
				<?php if($list[$i]['is_soldout']) { // 품절검사 ?>
					품절
				<?php } else { //품절이 아니면 체크할수 있도록한다 ?>
					<label for="chk_it_id_<?php echo $i; ?>" class="sound_only"><?php echo $list[$i]['it_name']; ?></label>
				<?php } ?>
				<input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['it_id']; ?>">
				<input type="hidden" name="io_type[<?php echo $list[$i]['it_id']; ?>][0]" value="0">
				<input type="hidden" name="io_id[<?php echo $list[$i]['it_id']; ?>][0]" value="">
				<input type="hidden" name="io_value[<?php echo $list[$i]['it_id']; ?>][0]" value="<?php echo $list[$i]['it_name']; ?>">
				<input type="hidden" name="ct_qty[<?php echo $list[$i]['it_id']; ?>][0]" value="1">
			</td>
			<td class="text-center">
				<a onclick="request_img(<?php echo $list[$i]['it_id']; ?>)">
				<?php if($list[$i]['img']['src']) {?>
					<img width="75" height="75" src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
				<?php } else { ?>
					<i class="fa fa-camera img-fa"></i>
				<?php } ?>
				</a>
			</td>
			<td><?php echo stripslashes($list[$i]['it_name']); ?></td>
			<td class="text-center"><?php echo $list[$i]['wi_time']; ?></td>
			<td class="text-center"><a href="./wishupdate.php?w=d&amp;wi_id=<?php echo $list[$i]['wi_id']; ?>">삭제</a></td>
		</tr>
	<?php } ?>
	<?php if ($i == 0) { ?>
		<tr><td colspan="5" class="text-center text-muted" height="150">보관함이 비었습니다.</td></tr>
	<?php } ?>
	</tr>
	</tbody>
	</table>
</div>
	</div>
</div>


<script>
	function request_img(it_id){
		if(!it_id) {
			alert("코드가 올바르지 않습니다.");
			return false;
		}

		console.log({ it_id: it_id });
		$.post("./fitting_request.php", { it_id: it_id }, function(res) {
			$('#me').attr('src', res);
		});

		return false;
	}

</script>
