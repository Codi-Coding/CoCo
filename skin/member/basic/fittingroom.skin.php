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

include_once(G5_LIB_PATH.'/aes_encrypt.php');
include_once(G5_DATA_PATH.'/CoCo_config.php');

$coco_photo = getEncPath($member['coco_photo'], IMAGE_KEY);
?>


<form name="frmcartlist" id="sod_bsk_list" method="post" action="/shop/cartupdate.php" class="form" role="form">
	
	<div class="row">
		<div class="col-xs-6">
			<?php if($member['photo']) { ?>
				<img id="coco" src="<?php echo ($coco_photo);?>" width="100%" height="100%"/>
			<?php } else { ?>
				<i class="fa fa-user"></i>
				<img id="coco" src="<?php echo ($coco_photo);?>" width="100%" height="100%"/>
			<?php } ?>
				<div class="loader" id="loader"></div>
		</div>
		<div class="col-xs-6">
			<a class="btn btn-default" role="button">List</a>
			<!-- <a class="btn btn-default" role="button">검색</a> -->
			<div class="wishlist-skin">
				<table class="div-table table bg-white">
					<tbody>
						<?php 
						for($i=0; $i < count($list);$i++) { 
							$list[$i]['img'] = apms_it_thumbnail($list[$i], 40, 40, false, true);	
						?>
							<tr>
								<td class="text-center">
									<input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['it_id']; ?>">
									<input type="hidden" name="it_name[<?php echo $i; ?>]" value="<?php echo get_text($list[$i]['it_name']); ?>">
								</td>
								<td class="text-center"
									<label for="ct_chk_<?php echo $i; ?>" class="sound_only"></label>
									<input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked"/>
								</td>
								<td class="text-center">
									<a class="btn btn-default" onclick="request_fitting(<?php echo(strval($list[$i]['it_id']).",".strval($list[$i]['ca_id2']));?>)" role="button">착용</a>
								</td>
								<td class="text-center">
									<a onclick="request_fitting(<?php echo(strval($list[$i]['it_id']).",".strval($list[$i]['ca_id2']));?>)">
									<?php if($list[$i]['img']['src']) {?>
										<img width="75" height="75" src="<?php echo($list[$i]['img']['src']);?>" alt="<?php echo $list[$i]['img']['alt'];?>">
									<?php } else { ?>
										<i class="fa fa-camera img-fa"></i>
									<?php } ?>
									</a>
								</td>
								<td><?php echo stripslashes($list[$i]['it_name']); ?></td>
								<td class="text-center"><?php echo $list[$i]['wi_time']; ?></td>
								<td class="text-center"><a href="./fitting_update.php?w=d&amp;fitting_cart_id=<?php echo $list[$i]['fitting_cart_id']; ?>">삭제</a></td>
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
	<input type="hidden" name="url" value="./orderform.php"/>
	<input type="hidden" name="records" value="<?php echo $i; ?>"/>
	<input type="hidden" name="act" value="">
</form>
<br/>
<div class="row">
	<div class="col-xs-6">
		<div class="text-center">
			<a class="btn btn-default btn-block" role="button" width="100%" height="100%" onclick="request_save_cody();">코디 저장</a>
		</div>
	</div>
	<div class="col-xs-6">
		<div class="text-center">
			<div class="col-xs-6">
				<a class="btn btn-default fitting-button" role="button" onclick="request_buy()">바로구매</a>
			</div>
			<div class="col-xs-6">
				<a class="btn btn-default fitting-button" role="button">장바구니</a>
			</div>
		</div>
	</div>
</div>


<script>
	var my_codi = {};

	function isEmpty(obj) {
		for(var prop in obj) {
			if(obj.hasOwnProperty(prop))
				return false;
		}

		return JSON.stringify(obj) === JSON.stringify({});
	}


	function request_fitting(it_id, ca_id){
		if(!it_id) {
			alert("코드가 올바르지 않습니다.");
			return false;
		}


		$('#loader').show();

		$.post("./fitting_request.php", { it_id: it_id }, function(res) {
			my_codi[ca_id] = it_id;
			var result = JSON.parse(res);
			if(result['result'])
				$('#coco').attr('src', result['src']);
			console.log(result);
			console.log(my_codi);
		});

		// $('#myModal').modal('hide');

		return true;
	}

	function request_buy() {
		var f = document.frmcartlist;
		var cnt = f.records.value;

		if($("input[name^=ct_chk]:checked").size() < 1) {
			alert("주문하실 상품을 하나이상 선택해 주십시오.");
			return false;
		}

		f.act.value = "buy";
		console.log(f);
		f.submit();

		return true;
	}

	function request_save_cody(){
		if(isEmpty(my_codi)){
			alert("코디가 없습니다.");
			return false;
		}


		$.post("./fitting_save_codi.php", { codi: JSON.stringify(my_codi)}, function(res) {
			// var result = JSON.parse(res);
			console.log(res);
		});

	}
	



</script>
