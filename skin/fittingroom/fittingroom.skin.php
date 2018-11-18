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
	<div style="display:flex; width:100%; height:100%;">
		<div class="" style="display:flex; flex-direction: column; flex: 0 0 50%;">
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
			<div class="fit_wrapper">
				<a class="btn btn-default btn-block" role="button" width="100%" height="100%" onclick="request_save_cody();">코디 저장</a>
				<a class="btn btn-default fitting-button" role="button" onclick="request_buy()">바로구매</a>
				<a class="btn btn-default fitting-button" role="button" onclick="reset_cart()">피팅카트 초기화</a>
			</div>
		</div>
		<div style="display:flex; flex-direction: column; flex: 0 0 50%;">
			<div>
				<a class="btn btn-default" role="button" onclick="show_item_list()">아이템 목록</a>
				<a class="btn btn-default" role="button" onclick="show_codi_list()">코디</a>
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
						<label for="ct_chk_<?php echo $i; ?>">
							<span><?php echo($list[$i]['it_name']);?></span>
						</label>
						<div>
							<label for="ct_chk_<?php echo $i; ?>"><?php echo($list[$i]['it_price']);?>원</label>
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
				<div id="codi_list" style="display:none;">
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
	var MD5 = function(d){result = M(V(Y(X(d),8*d.length)));return result.toLowerCase()};function M(d){for(var _,m="0123456789ABCDEF",f="",r=0;r<d.length;r++)_=d.charCodeAt(r),f+=m.charAt(_>>>4&15)+m.charAt(15&_);return f}function X(d){for(var _=Array(d.length>>2),m=0;m<_.length;m++)_[m]=0;for(m=0;m<8*d.length;m+=8)_[m>>5]|=(255&d.charCodeAt(m/8))<<m%32;return _}function V(d){for(var _="",m=0;m<32*d.length;m+=8)_+=String.fromCharCode(d[m>>5]>>>m%32&255);return _}function Y(d,_){d[_>>5]|=128<<_%32,d[14+(_+64>>>9<<4)]=_;for(var m=1732584193,f=-271733879,r=-1732584194,i=271733878,n=0;n<d.length;n+=16){var h=m,t=f,g=r,e=i;f=md5_ii(f=md5_ii(f=md5_ii(f=md5_ii(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_ff(f=md5_ff(f=md5_ff(f=md5_ff(f,r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+0],7,-680876936),f,r,d[n+1],12,-389564586),m,f,d[n+2],17,606105819),i,m,d[n+3],22,-1044525330),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+4],7,-176418897),f,r,d[n+5],12,1200080426),m,f,d[n+6],17,-1473231341),i,m,d[n+7],22,-45705983),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+8],7,1770035416),f,r,d[n+9],12,-1958414417),m,f,d[n+10],17,-42063),i,m,d[n+11],22,-1990404162),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+12],7,1804603682),f,r,d[n+13],12,-40341101),m,f,d[n+14],17,-1502002290),i,m,d[n+15],22,1236535329),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+1],5,-165796510),f,r,d[n+6],9,-1069501632),m,f,d[n+11],14,643717713),i,m,d[n+0],20,-373897302),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+5],5,-701558691),f,r,d[n+10],9,38016083),m,f,d[n+15],14,-660478335),i,m,d[n+4],20,-405537848),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+9],5,568446438),f,r,d[n+14],9,-1019803690),m,f,d[n+3],14,-187363961),i,m,d[n+8],20,1163531501),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+13],5,-1444681467),f,r,d[n+2],9,-51403784),m,f,d[n+7],14,1735328473),i,m,d[n+12],20,-1926607734),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+5],4,-378558),f,r,d[n+8],11,-2022574463),m,f,d[n+11],16,1839030562),i,m,d[n+14],23,-35309556),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+1],4,-1530992060),f,r,d[n+4],11,1272893353),m,f,d[n+7],16,-155497632),i,m,d[n+10],23,-1094730640),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+13],4,681279174),f,r,d[n+0],11,-358537222),m,f,d[n+3],16,-722521979),i,m,d[n+6],23,76029189),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+9],4,-640364487),f,r,d[n+12],11,-421815835),m,f,d[n+15],16,530742520),i,m,d[n+2],23,-995338651),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+0],6,-198630844),f,r,d[n+7],10,1126891415),m,f,d[n+14],15,-1416354905),i,m,d[n+5],21,-57434055),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+12],6,1700485571),f,r,d[n+3],10,-1894986606),m,f,d[n+10],15,-1051523),i,m,d[n+1],21,-2054922799),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+8],6,1873313359),f,r,d[n+15],10,-30611744),m,f,d[n+6],15,-1560198380),i,m,d[n+13],21,1309151649),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+4],6,-145523070),f,r,d[n+11],10,-1120210379),m,f,d[n+2],15,718787259),i,m,d[n+9],21,-343485551),m=safe_add(m,h),f=safe_add(f,t),r=safe_add(r,g),i=safe_add(i,e)}return Array(m,f,r,i)}function md5_cmn(d,_,m,f,r,i){return safe_add(bit_rol(safe_add(safe_add(_,d),safe_add(f,i)),r),m)}function md5_ff(d,_,m,f,r,i,n){return md5_cmn(_&m|~_&f,d,_,r,i,n)}function md5_gg(d,_,m,f,r,i,n){return md5_cmn(_&f|m&~f,d,_,r,i,n)}function md5_hh(d,_,m,f,r,i,n){return md5_cmn(_^m^f,d,_,r,i,n)}function md5_ii(d,_,m,f,r,i,n){return md5_cmn(m^(_|~f),d,_,r,i,n)}function safe_add(d,_){var m=(65535&d)+(65535&_);return(d>>16)+(_>>16)+(m>>16)<<16|65535&m}function bit_rol(d,_){return d<<_|d>>>32-_}
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
					try{
						var data = JSON.parse(response);
						if(data["result"]){
							$('#coco-fitting').attr('src', data["src"]);
							t_codi["codi_url"] = data["src"];
						}
					}
					catch{


					}
					isFitting = false;
					console.log(response);
				}, 3000);
				},
				error:function(){
					alert("error");
				}
		});
		
		return true;
	}

	function appendCodi(upper, lower){
		console.log("here");
		$('#codi_list').append('<h3>'+ codi_index +'번째 코디</h3>');
		var wrapper_div = $('<div class="fitting-wrapper"/>');
		if(upper != "000000"){
			upper = Number(upper);
			wrapper_div.prepend('<img class="theImg" src="'+image[upper]+'" />');
			console.log(image[upper]);
		}
		if(lower != "000000"){
			lower = Number(lower);
			wrapper_div.prepend('<img class="theImg" src="'+image[lower]+'" />');
			console.log(image[lower]);
		}
		console.log(wrapper_div);
		wrapper_div.prepend('<h3>'+ codi_index +'번째 코디</h3>');
		wrapper_div = wrapper_div.wrap('<a onclick="select_codi(' + codi_index-1 +')"></a>"').parent();
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

		if(isEmpty(t_codi)){
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
		$('#coco').attr('src', my_codi[index]['codi_url']);
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
