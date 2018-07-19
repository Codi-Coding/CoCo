<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

?>
<div id="mod_option_form">
	<form name="foption" class="form" role="form" method="post" action="<?php echo $action_url; ?>" onsubmit="return formcheck(this);">
		<input type="hidden" name="act" value="optionmod">
		<input type="hidden" name="it_id[]" value="<?php echo $option['it_id']; ?>">
		<input type="hidden" name="it_msg1[]" value="<?php echo $it['pt_msg1']; ?>">
		<input type="hidden" name="it_msg2[]" value="<?php echo $it['pt_msg2']; ?>">
		<input type="hidden" name="it_msg3[]" value="<?php echo $it['pt_msg3']; ?>">
		<input type="hidden" id="it_price" value="<?php echo $option['ct_price']; ?>">
		<input type="hidden" name="ct_send_cost" value="<?php echo $option['ct_send_cost']; ?>">
		<input type="hidden" name="sw_direct">
		<?php if($option_1) { ?>
			<p>&nbsp; <b><i class="fa fa-check-square-o fa-lg"></i> 선택옵션</b></p>
			<table class="opt-tbl">
			<tbody>
			<?php echo $option_1; // 선택옵션 ?>
			</tbody>
			</table>
		<?php } ?>

		<?php if($option_2) { ?>
			<p>&nbsp; <b><i class="fa fa-check-square-o fa-lg"></i> 추가옵션</b></p>
			<table class="opt-tbl">
			<tbody>
			<?php echo $option_2; // 추가옵션 ?>
			</tbody>
			</table>
		<?php } ?>

		<div id="it_sel_option">
			<ul id="it_opt_added" class="list-group">
				<?php for($i=0; $i < count($io); $i++) { ?>
					<li class="it_<?php echo $io[$i]['cls']; ?>_list list-group-item">
						<input type="hidden" name="io_type[<?php echo $it['it_id']; ?>][]" value="<?php echo $io[$i]['io_type']; ?>">
						<input type="hidden" name="io_id[<?php echo $it['it_id']; ?>][]" value="<?php echo $io[$i]['io_id']; ?>">
						<input type="hidden" name="io_value[<?php echo $it['it_id']; ?>][]" value="<?php echo $io[$i]['ct_option']; ?>">
						<input type="hidden" class="io_price" value="<?php echo $io[$i]['io_price']; ?>">
						<input type="hidden" class="io_stock" value="<?php echo $io[$i]['it_stock_qty']; ?>">
						<div class="row">
							<div class="col-sm-7">
								<label>
									<span class="it_opt_subj"><?php echo $io[$i]['ct_option']; ?></span>
									<span class="it_opt_prc"><?php echo $io[$i]['io_display_price']; ?></span>
								</label>
							</div>
							<div class="col-sm-5">
								<div class="input-group">
									<label for="ct_qty_<?php echo $i; ?>" class="sound_only">수량</label>
									<input type="text" name="ct_qty[<?php echo $it['it_id']; ?>][]" value="<?php echo $io[$i]['ct_qty']; ?>" id="ct_qty_<?php echo $i; ?>" class="form-control input-sm" size="5">
									<div class="input-group-btn">
										<button type="button" class="it_qty_plus btn btn-black btn-sm"><i class="fa fa-plus-circle fa-lg"></i><span class="sound_only">증가</span></button>
										<button type="button" class="it_qty_minus btn btn-black btn-sm"><i class="fa fa-minus-circle fa-lg"></i><span class="sound_only">감소</span></button>
										<button type="button" class="it_opt_del btn btn-black btn-sm"><i class="fa fa-times-circle fa-lg"></i><span class="sound_only">삭제</span></button>
									</div>
								</div>
							</div>
						</div>
						<?php if($it['pt_msg1']) { ?>
							<div style="margin-top:10px;">
								<input type="text" name="pt_msg1[<?php echo $it['it_id']; ?>][]" class="form-control input-sm" placeholder="<?php echo $it['pt_msg1'];?>" value="<?php echo $io[$i]['pt_msg1'];?>">
							</div>
						<?php } ?>
						<?php if($it['pt_msg2']) { ?>
							<div style="margin-top:10px;">
								<input type="text" name="pt_msg2[<?php echo $it['it_id']; ?>][]" class="form-control input-sm" placeholder="<?php echo $it['pt_msg2'];?>" value="<?php echo $io[$i]['pt_msg2'];?>">
							</div>
						<?php } ?>
						<?php if($it['pt_msg3']) { ?>
							<div style="margin-top:10px;">
								<input type="text" name="pt_msg3[<?php echo $it['it_id']; ?>][]" class="form-control input-sm" placeholder="<?php echo $it['pt_msg3'];?>" value="<?php echo $io[$i]['pt_msg3'];?>">
							</div>
						<?php } ?>
					</li>
				<?php } ?>
			</ul>
		</div>

		<h4 style="text-align:center; margin-bottom:20px;">
			<div id="it_tot_price"></div>
		</h4>

		<p></p>

		<div class="text-center">
			<button type="submit" class="btn btn-color btn-sm">적용</button>
			<button type="button" id="mod_option_close" class="btn btn-black btn-sm">닫기</button>
		</div>
	</form>
</div>

<script>
	// BS3
	$(function() {
		$("select.it_option").addClass("form-control input-sm");
		$("select.it_supply").addClass("form-control input-sm");
	});

	function formcheck(f) {
		var val, io_type, result = true;
		var sum_qty = 0;
		var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
		var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
		var $el_type = $("input[name^=io_type]");

		$("input[name^=ct_qty]").each(function(index) {
			val = $(this).val();

			if(val.length < 1) {
				alert("수량을 입력해 주십시오.");
				result = false;
				return false;
			}

			if(val.replace(/[0-9]/g, "").length > 0) {
				alert("수량은 숫자로 입력해 주십시오.");
				result = false;
				return false;
			}

			if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
				alert("수량은 1이상 입력해 주십시오.");
				result = false;
				return false;
			}

			io_type = $el_type.eq(index).val();
			if(io_type == "0")
				sum_qty += parseInt(val);
		});

		if(!result) {
			return false;
		}

		if(min_qty > 0 && sum_qty < min_qty) {
			alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
			return false;
		}

		if(max_qty > 0 && sum_qty > max_qty) {
			alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
			return false;
		}

		return true;
	}
</script>
