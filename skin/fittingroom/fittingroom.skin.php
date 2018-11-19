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

$coco_photo = $member['coco_photo'];
$pre_codi_url = null;
if($pre_codi_url != null)
	$coco_photo = $pre_codi_url;
$item_url = Array();

$mb_id = $member['mb_id'];
$sql = sql_fetch_array(sql_query("select mb_memo from `CoCo_member` where mb_id = '{$mb_id}'"));
$imageid = $sql["mb_memo"];
?>

<div style="margin-top: 23px; width: 100%; height: 100%; display:flex; flex-direction: column; margin: 0 auto;">
	<!-- <div style="height: 75px;">
			<span>폴더</span>
		<div class="coco-codi-scroll">
			<div class="coco-codi">test</div>
			<div class="coco-codi">test</div>
			<div class="coco-codi">test</div>
			<div class="coco-codi">test</div>
			<div class="coco-codi">test</div>
			<div class="coco-codi">test</div>
		</div>
	</div> -->

				<form name="frmcartlist" id="sod_bsk_list" method="post" action="/shop/cartupdate.php" class="form" role="form">
	<div style="margin-top: 10px;">
	</div>
	<div style="display:flex;width:100%;height:100%;justify-content: space-evenly;">
		<div class="" style="display:flex; flex-direction: column; flex: 0 0 48%;     margin-top: 31px;">
			<div class="fit_wrapper">
				<?php if($coco_photo) { ?>
					<img id="coco-fitting" src="<?php echo ($coco_photo);?>" width="100%" height="100%"/>
				<?php } else { ?>
					<h1>사진 등록이 필요합니다</h1>
				<?php } ?>
				<div class="back_modal" id="loader">
					<div class="loader"></div>
				</div>
				<div style="min-height: 30px;display:flex;position: absolute;width: 100%;justify-content: space-between;z-index: 5;top: calc(100% - 40px);">
					<div>
						<a onclick="reset()">
							<img src="/img/coco/reset.png" style="width: 40xp; height:40px;"/>
						</a>
					</div>
					<div>
						<a href="/guideline.php">
							<img src="/img/coco/change.png" style="width: 40xp; height:40px;"/>
						</a>
					</div>
				</div>
			</div>
			<div class="fit_wrapper" style="margin-top: 8px;">
				<a onclick="request_buy()">
					<img src="/img/coco/fitting1.png" style="width: 100%; height: 30px; margin: 5px 0px;"/>
				</a>
				<a onclick="request_save_cody();">
					<img src="/img/coco/fitting2.png"  style="width: 100%; height: 30px; margin: 5px 0px;"/>
				</a>
				<a class="btn btn-danger" onclick="reset_cart()" style="width: 100%;height: 26px;border-radius: 9px !important;margin: 5px 0px;font-size: 11px;">
					피팅카트 초기화
				</a>
			</div>
		</div>
		<div style="display:flex; flex-direction: column; flex: 0 0 48%;">
			<div style="display:flex;">
				<a onclick="show_item_list()">
					<div class="coco-fitting-nav">
					아이템 목록
					</div>
				</a>
				<a onclick="show_codi_list()">
					<div class="coco-fitting-nav">
						코디
					</div>
				</a>
			</div>
			<div class="item_wrapper">
				<div id="item_list">
					<?php 
					for($i=0; $i < count($list);$i++) { 

						$list[$i]['img'] = apms_it_thumbnail($list[$i], 70, 70, false, true);
						$item_url["{$list[$i]['it_id']}"] = $list[$i]['img']['src'];
					?>
					<div class="coco-fitting-item">
						<a class="coco-fitting-wrap">
						<img class="coco-item-image" item-id="<?php echo($list[$i]['it_id']);?>" cate-id="<?php echo($list[$i]['ca_id2']);?>" src="<?php echo($list[$i]['img']['src']);?>">
						<label class="coco-label" for="ct_chk_<?php echo $i; ?>">
							<span style="font-size: 11px;"><?php echo($list[$i]['it_name']);?></span>
						</label>
						<div>
							<label class="coco-label" for="ct_chk_<?php echo $i; ?>"  style="font-size: 8px;"><?php echo($list[$i]['it_price']);?>원</label>
							<input type="checkbox" name="chk_it_id[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>">
						</div>
						
						</a>
						<input type="hidden" name="it_id[]" value="<?php echo $list[$i]['it_id']; ?>">
						<input type="hidden" name="io_type[<?php echo $list[$i]['it_id']; ?>][]" value="0">
						<input type="hidden" name="io_id[<?php echo $list[$i]['it_id']; ?>][]" value="">
						<input type="hidden" name="io_value[<?php echo $list[$i]['it_id']; ?>][]" value="<?php get_text($list[$i]['it_name']); ?>">
						<input type="hidden" name="ct_qty[<?php echo  $list[$i]['it_id']; ?>][]" value="1" id="ct_qty_<?php echo $i; ?>">
					</div>
					<?php } ?>
					<input type="hidden" name="url" value="./orderform.php"/>
					<input type="hidden" name="records" value="<?php echo $i; ?>"/>
					<input type="hidden" name="sw_direct" value="1">
					<input type="hidden" name="act" value="multi">
				</div>
				<!-- Codi List -->
				<div id="codi_list" style="display: none;flex-direction: column;width: 100%;padding-left: 10%;/* align-items: center; */">
				</div>
			</div>
		</div>
	</div>
</div>
</form>

<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="/js/jquery.ui.touch-punch.js"></script>
<script src="/js/coco.js"></script>
<script>
	var my_codi = '<?php echo($codi);?>';
	var t_codi = {'lowerid' : '000000', 'upperid': '000000'};
	var image = '<?php echo(json_encode($item_url)); ?>';
	var user_id = '<?php echo($member['mb_id']) ?>';
	var isFitting = false;
	var imageid = "<?php echo($imageid); ?>"
	var codi_index = 1;
	var temp_act = {};

	image = JSON.parse(image);


	if(my_codi.length == 0){
		my_codi = [];
	}
	else{
		my_codi = JSON.parse(my_codi);
	}

	function reset(){
		$('div .item-active').removeClass("item-active")

		temp_act["lowerid"] = null;
		temp_act["upperid"] = null;

		$('#coco-fitting').attr('src', "/data/apms/photo/"+user_id+"/"+user_id+"_large.jpg");

		t_codi["lowerid"] = "000000";
		t_codi["upperid"] = "000000";
	}

	function isEmpty(obj) {
		for(var prop in obj) {
			if(obj.hasOwnProperty(prop))
				return false;
		}

		return JSON.stringify(obj) === JSON.stringify({});
	}

	function reset_cart(){
		$.ajax({
			url:"/reset_fitting_cart.php ",
			type:"GET",
			success:function(response) {
				console.log(response);
				alert("초기화 완료");
				$("#item_list").empty();
				
			},
				error:function(){
					alert("error");
				}
		});
	}


	function request_fitting(it_id, ca_id){
		var data = {
			"userid" : user_id ,
			"isupper" : 0,
			"imageid" : imageid,
			"category" : ca_id,
		};


		var cate_code = getCateCode(ca_id);
		console.log(cate_code);

		if(cate_code == "upperid"){
			data["isupper"] = 1;
		}

		t_codi[cate_code] = it_id;

		if(t_codi["upperid"] == t_codi["lowerid"]){
			$('#coco-fitting').attr('src', "/data/apms/photo/"+user_id+"/"+user_id+"_large.jpg");
			return 0;
		}

		$('#loader').show();  

		data["upperid"] = t_codi["upperid"];
		data["lowerid"] = t_codi["lowerid"];
		

		isFitting = true;

		$.ajax({
			url:"/shop/fitting_request.php ",
			type:"POST",
			data: data,
			success:function(response) {
				setTimeout(() => {
					$('#loader').hide();  
					var data = JSON.parse(response);
					console.log(data);
					if(data["result"] == 1){
						$('#coco-fitting').attr('src', data["src"]);
						t_codi["codi_url"] = data["src"];
					}
					isFitting = false;
				}, 3000);
				},
				error:function(){
					alert("error");
				}
		});
		
		return true;
	}

	function appendCodi(upper, lower){
		var wrapper_div = $('<div class="fitting-wrapper"/>');
		wrapper_div.append('<h3>'+ codi_index +'번째 코디</h3>');
			console.log(upper);
		if(upper != "000000"){
			upper = Number(upper);
			console.log(upper);
			wrapper_div.append('<img class="theImg" src="'+image[upper]+'" />');
		}
		if(lower != "000000"){
			lower = Number(lower);
			wrapper_div.append('<img class="theImg" src="'+image[lower]+'" />');
			console.log(image[lower]);
		}
		wrapper_div = wrapper_div.wrap('<a onclick="select_codi(' + (codi_index-1) +')"></a>').parent();
		$('#codi_list').append(wrapper_div);
		codi_index += 1;
	}

	function request_buy() {
		var f = document.frmcartlist;
		var cnt = f.records.value;

		if($("input[name^=chk_it_id]:checked").size() < 1) {
			alert("주문하실 상품을 하나이상 선택해 주십시오.");
			return false;
		}

		// f.act.value = "buy";
		console.log(f);
		f.submit();

		return true;
	}

	function request_save_cody(){
		var flag = true;

		if(t_codi["upperid"] == "000000" && t_codi["lowerid"] == "000000"){
			alert("코디가 없습니다.");
			return false;
		}

		for(var i in my_codi){
			if(JSON.stringify(my_codi[i]) == JSON.stringify(t_codi)){
				flag = false;
			}
		}

		if(!flag){
			alert("중복된 코디입니다.");
			return;
		}
			
		my_codi.push($.extend({}, t_codi));

		$.post("/shop/fitting_save_codi.php", { codi: JSON.stringify(my_codi)}, function(res) {
			// var result = JSON.parse(res);
			// console.log(res);
			appendCodi(t_codi["upperid"], t_codi["lowerid"]);
			alert("코디 저장 완료");
		});
	}

	function show_codi_list(){
		$('#item_list').css("display", "none");
		$('#codi_list').css("display", "flex");
	}

	function show_item_list(){
		$('#item_list').css("display", "flex");
		$('#codi_list').css("display", "none");
	}

	function select_codi(index){
		console.log(index);
		$('#coco-fitting').attr('src', my_codi[index]['codi_url']);
	}

	function delete_codi(index){
		my_codi.splice(index, 1);
		request_buy();
	}

	$(function(){
		$("#item_list div img").draggable({
			start: function(event, ui){
				if(!isFitting)
					$(this).draggable("option", "revert", true);
				else {
					event.preventDefault();
					alert("합성중입니다!");
				}
			}
		});
		
		$("#coco-fitting").droppable({
			drop: function(event, ui){
				var parent = ui.draggable.parent();
				var cate = ui.draggable.attr("cate-id");
				var item = ui.draggable.attr("item-id");
				if(temp_act[getCateCode(cate)])
					temp_act[getCateCode(cate)].removeClass("item-active");

				temp_act[getCateCode(cate)] = parent;
				parent.addClass("item-active");
				request_fitting(item, cate);
			}
		});

		$('body').on("click", ".coco-fitting-wrap.item-active", function(){
			var img = $(this).children().first();
			var cate = img.attr("cate-id");
			temp_act[getCateCode(cate)] = null;
			$(this).removeClass("item-active");
			request_fitting("000000", cate);
			console.log(cate);
		});
		for (var i in my_codi){
			appendCodi(my_codi[i]["upperid"], my_codi[i]["lowerid"]);
		};

	});
</script>
