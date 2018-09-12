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
include_once(G5_LIB_PATH.'/coco.lib.php');

// 헤더 출력
if($header_skin)
	include_once('./header.php');

$coco_photo = getEncPath($member['coco_photo']);
?>


<form name="frmcartlist" id="sod_bsk_list" method="post" action="/shop/cartupdate.php" class="form" role="form">
	
	<div class="row">
		<div class="col-xs-6">
			<div class="fit_wrapper">
				<?php if($pre_codi_url != NULL) { ?>
					<img id="coco" src="<?php echo ($pre_codi_url);?>" width="100%" height="100%"/>
				<?php } else { ?>
					<i class="fa fa-user"></i>
					<img id="coco" src="<?php echo ($coco_photo);?>" width="100%" height="100%"/>
				<?php } ?>
				<div class="back_modal" id="loader">
					<div class="loader"></div>
				</div>
			</div>
		</div>
		<div class="col-xs-6">


			<a class="btn btn-default" role="button" onclick="show_item_list()">아이템 목록</a>
			<a class="btn btn-default" role="button" onclick="show_codi_list()">코디</a>
			<div class="row" id="item_list">
				<?php 

				for($i=0; $i < count($list);$i++) { 

					$list[$i]['img'] = apms_it_thumbnail($list[$i], 40, 40, false, true);	
				?>
				<div class="col-xs-6">
					<a onclick="request_fitting(<?php echo(strval($list[$i]['it_id']).",".strval($list[$i]['ca_id2']));?>)">
					<img width="75" height="75" src="<?php echo($list[$i]['img']['src']);?>" alt="<?php echo $list[$i]['img']['alt'];?>">
					</a>
					<input type="hidden" name="it_name[<?php echo $i; ?>]" value="<?php echo get_text($list[$i]['it_name']); ?>">
					<input type="hidden" name="io_type[<?php echo $list[$i]['it_id']; ?>][]" value="0">
					<input type="hidden" name="io_id[<?php echo $list[$i]['it_id']; ?>][]" value="">
					<input type="hidden" name="io_value[<?php echo $list[$i]['it_id']; ?>][]" value="<?php get_text($list[$i]['it_name']); ?>">
					<input type="hidden" name="ct_qty[<?php echo  $list[$i]['it_id']; ?>][]" value="1" id="ct_qty_<?php echo $i; ?>">
					<input type="hidden" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked"/>
				</div>

				<?php } ?>
			</div>
			<!-- Codi List -->
			<div class="wishlist-skin" id="codi_list" style="display:none;">
				<h1>test</h1>
			</div>
		</div>
	</div>
	<input type="hidden" name="url" value="./orderform.php"/>
	<input type="hidden" name="records" value="<?php echo $i; ?>"/>
	<input type="hidden" name="act" value="">
	<input type="hidden" name="sw_direct" value="1">
	
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
	var my_codi = '<?php echo($codi);?>';
	var t_codi = {};

	if(my_codi.length == 0){
		my_codi = [];
	}
	else{
		my_codi = JSON.parse(my_codi);
	}

	function sleep(ms) {
	  return new Promise(resolve => setTimeout(resolve, ms));
	}

	function isEmpty(obj) {
		for(var prop in obj) {
			if(obj.hasOwnProperty(prop))
				return false;
		}

		return JSON.stringify(obj) === JSON.stringify({});
	}


	async function request_fitting(it_id, ca_id){
		if(!it_id) {
			alert("코드가 올바르지 않습니다.");
			return false;
		}


		$('#loader').css("display", "block");  


		$.post("./fitting_request.php", { it_id: it_id }, function(res) {
			t_codi[ca_id] = it_id;
			var result = JSON.parse(res);
			if(result['result'])
				$('#coco').attr('src', result['src']);
			console.log(result);
			console.log(t_codi);
		});

		await sleep(1000);
		
		
		// $('#coco').attr('src', img);
		$('#loader').hide();  

		return true;
	}

	function request_buy() {
		var f = document.frmcartlist;
		var cnt = f.records.value;

		if($("input[name^=ct_chk]:checked").size() < 1) {
			alert("주문하실 상품을 하나이상 선택해 주십시오.");
			return false;
		}

		// f.act.value = "buy";
		console.log(f);
		f.submit();

		return true;
	}

	function request_save_cody(){
		if(isEmpty(t_codi)){
			alert("코디가 없습니다.");
			return false;
		}

		my_codi.push($.extend({}, t_codi));


		$.post("./fitting_save_codi.php", { codi: JSON.stringify(my_codi)}, function(res) {
			// var result = JSON.parse(res);
			// console.log(res);
			alert("코디 저장 완료");
			t_codi = {};
		});

	}

	function show_codi_list(){
		console.log('here');
		$('#item_list').hide();
		$('#codi_list').show();
	}

	function show_item_list(){
		$('#item_list').show();
		$('#codi_list').hide();
	}
	



</script>
