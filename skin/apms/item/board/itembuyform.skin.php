<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<!-- Modal -->
<div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-labelledby="buyModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="buyModalLabel"><?php echo stripslashes($it['it_name']); // 상품명 ?></h4>
			</div>
			<div class="modal-body">
				<?php if($it['it_basic']) { // 기본설명 ?>
					<p class="help-block"><?php echo $it['it_basic']; ?></p>
				<?php } ?>

				<form name="fitem" method="post" action="<?php echo $action_url; ?>" class="form" role="form" onsubmit="return fitem_submit(this);">
				<input type="hidden" name="it_id[]" value="<?php echo $it_id; ?>">
				<input type="hidden" name="it_msg1[]" value="<?php echo $it['pt_msg1']; ?>">
				<input type="hidden" name="it_msg2[]" value="<?php echo $it['pt_msg2']; ?>">
				<input type="hidden" name="it_msg3[]" value="<?php echo $it['pt_msg3']; ?>">
				<input type="hidden" name="sw_direct">
				<input type="hidden" name="url">

				<table class="div-table table item-table">
				<tbody>
				<?php if ($it['it_maker']) { ?>
					<tr><th scope="row">제조사</th><td><?php echo $it['it_maker']; ?></td></tr>
				<?php } ?>
				<?php if ($it['it_origin']) { ?>
					<tr><th scope="row">원산지</th><td><?php echo $it['it_origin']; ?></td></tr>
				<?php } ?>
				<?php if ($it['it_brand']) { ?>
					<tr><th scope="row">브랜드</th><td><?php echo $it['it_brand']; ?></td></tr>
				<?php } ?>

				<?php if ($it['it_model']) { ?>
					<tr><th scope="row">모델</th><td><?php echo $it['it_model']; ?></td></tr>
				<?php } ?>

				<?php if (!$it['it_use']) { // 판매가능이 아닐 경우 ?>
					<tr><th scope="row">판매가격</th><td>판매중지</td></tr>
				<?php } else if ($it['it_tel_inq']) { // 전화문의일 경우 ?>
					<tr><th scope="row">판매가격</th><td>전화문의</td></tr>
				<?php } else { // 전화문의가 아닐 경우?>
					<?php if ($it['it_cust_price']) { ?>
						<tr><th scope="row">시중가격</th><td><?php echo display_price($it['it_cust_price']); ?></td></tr>
					<?php } // 시중가격 끝 ?>
					<tr><th scope="row">판매가격</th><td>
							<?php echo display_price(get_price($it)); ?>
							<input type="hidden" id="it_price" value="<?php echo get_price($it); ?>">
					</td></tr>
				<?php } ?>
				<?php if($it['pt_day'] > 0) { ?>
					<tr><th scope="row">이용기간</th><td>
						구매 후 <?php echo number_format($it['pt_day']);?>일간 이용가능
					</td></tr>
				<?php } ?>
				<?php
					/* 재고 표시하는 경우 주석 해제
					<tr><th scope="row">재고수량</th><td><?php echo number_format(get_it_stock_qty($it_id)); ?> 개</td></tr>
					*/
				?>
				<?php if ($config['cf_use_point']) { // 포인트 사용한다면 ?>
					<tr>
					<th scope="row">포인트</th>
					<td>
						<?php
							if($it['it_point_type'] == 2) {
								echo '구매금액(추가옵션 제외)의 '.$it['it_point'].'%';
							} else {
								$it_point = get_item_point($it);
								echo number_format($it_point).'점';
							}
						?>
					</td>
					</tr>
				<?php } ?>
				<?php
					$ct_send_cost_label = '배송비결제';

					if($it['it_sc_type'] == 1)
						$sc_method = '무료배송';
					else {
						if($it['it_sc_method'] == 1)
							$sc_method = '수령후 지불';
						else if($it['it_sc_method'] == 2) {
							$ct_send_cost_label = '<label for="ct_send_cost">배송비결제</label>';
							$sc_method = '<select name="ct_send_cost" id="ct_send_cost" class="form-control input-sm">
											  <option value="0">주문시 결제</option>
											  <option value="1">수령후 지불</option>
										  </select>';
						}
						else
							$sc_method = '주문시 결제';
					}
				?>
				<tr>
					<th><?php echo $ct_send_cost_label; ?></th><td><?php echo $sc_method; ?></td>
				</tr>
				<?php if($it['it_buy_min_qty']) { ?>
					<tr><th>최소구매수량</th><td><?php echo number_format($it['it_buy_min_qty']); ?> 개</td></tr>
				<?php } ?>
				<?php if($it['it_buy_max_qty']) { ?>
					<tr><th>최대구매수량</th><td><?php echo number_format($it['it_buy_max_qty']); ?> 개</td>
					</tr>
				<?php } ?>
				</tbody>
				</table>

				<div id="item_option">
					<?php if($option_item) { ?>
						<p>&nbsp; <b><i class="fa fa-check-square-o fa-lg"></i> 선택옵션</b></p>
						<table class="div-table table item-table">
						<tbody>
						<?php echo $option_item; // 선택옵션	?>
						</tbody>
						</table>
					<?php }	?>

					<?php if($supply_item) { ?>
						<p>&nbsp; <b><i class="fa fa-check-square-o fa-lg"></i> 추가옵션</b></p>
						<table class="div-table table item-table">
						<tbody>
						<?php echo $supply_item; // 추가옵션 ?>
						</tbody>
						</table>
					<?php }	?>

					<?php if ($is_orderable) { ?>
						<div id="it_sel_option">
							<?php
							if(!$option_item) {
								if(!$it['it_buy_min_qty'])
									$it['it_buy_min_qty'] = 1;
							?>
								<ul id="it_opt_added" class="list-group">
									<li class="it_opt_list list-group-item">
										<input type="hidden" name="io_type[<?php echo $it_id; ?>][]" value="0">
										<input type="hidden" name="io_id[<?php echo $it_id; ?>][]" value="">
										<input type="hidden" name="io_value[<?php echo $it_id; ?>][]" value="<?php echo $it['it_name']; ?>">
										<input type="hidden" class="io_price" value="0">
										<input type="hidden" class="io_stock" value="<?php echo $it['it_stock_qty']; ?>">
										<div class="row">
											<div class="col-sm-7">
												<label>
													<span class="it_opt_subj"><?php echo $it['it_name']; ?></span>
													<span class="it_opt_prc"><span class="sound_only">(+0원)</span></span>
												</label>
											</div>
											<div class="col-sm-5">
												<div class="input-group">
													<label for="ct_qty_<?php echo $i; ?>" class="sound_only">수량</label>
													<input type="text" name="ct_qty[<?php echo $it_id; ?>][]" value="<?php echo $it['it_buy_min_qty']; ?>" id="ct_qty_<?php echo $i; ?>" class="form-control input-sm" size="5">
													<div class="input-group-btn">
														<button type="button" class="it_qty_plus btn btn-lightgray btn-sm"><i class="fa fa-plus-circle fa-lg"></i><span class="sound_only">증가</span></button>
														<button type="button" class="it_qty_minus btn btn-lightgray btn-sm"><i class="fa fa-minus-circle fa-lg"></i><span class="sound_only">감소</span></button>
													</div>
												</div>
											</div>
										</div>
										<?php if($it['pt_msg1']) { ?>
											<div style="margin-top:10px;">
												<input type="text" name="pt_msg1[<?php echo $it_id; ?>][]" class="form-control input-sm" placeholder="<?php echo $it['pt_msg1'];?>">
											</div>
										<?php } ?>
										<?php if($it['pt_msg2']) { ?>
											<div style="margin-top:10px;">
												<input type="text" name="pt_msg2[<?php echo $it_id; ?>][]" class="form-control input-sm" placeholder="<?php echo $it['pt_msg2'];?>">
											</div>
										<?php } ?>
										<?php if($it['pt_msg3']) { ?>
											<div style="margin-top:10px;">
												<input type="text" name="pt_msg3[<?php echo $it_id; ?>][]" class="form-control input-sm" placeholder="<?php echo $it['pt_msg3'];?>">
											</div>
										<?php } ?>
									</li>
								</ul>
								<script>
								$(function() {
									price_calculate();
								});
								</script>
							<?php } ?>
						</div>
						<!-- 총 구매액 -->
						<h4 style="text-align:center; margin-bottom:15px;">
							총 금액 : <span id="it_tot_price">0원</span>
						</h4>
					<?php } ?>
				</div>

				<?php if($is_soldout) { ?>
					<p id="sit_ov_soldout">재고가 부족하여 구매할 수 없습니다.</p>
				<?php } ?>

				<div style="text-align:center; padding:15px 0;">
					<?php if ($is_orderable) { ?>
						<input type="submit" onclick="document.pressed=this.value;" value="바로구매" class="btn btn-<?php echo $btn2;?> btn-lg">
						<input type="submit" onclick="document.pressed=this.value;" value="장바구니" class="btn btn-<?php echo $btn1;?> btn-lg">
						<?php if ($naverpay_button_js) { ?>
							<div style="margin-top:20px;"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
						<?php } ?>
					<?php } ?>
					<?php if(!$is_orderable && $it['it_soldout'] && $it['it_stock_sms']) { ?>
						<button type="button" onclick="popup_stocksms('<?php echo $it['it_id']; ?>','<?php echo $ca_id; ?>');" class="btn btn-primary">재입고알림(SMS)</button>
					<?php } ?>
				</div>
				</form>

				<script>
					// BS3
					$(function() {
						$("select.it_option").addClass("form-control input-sm");
						$("select.it_supply").addClass("form-control input-sm");
					});

					// 재입고SMS 알림
					function popup_stocksms(it_id, ca_id) {
						url = "./itemstocksms.php?it_id=" + it_id + "&ca_id=" + ca_id;
						opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
						popup_window(url, "itemstocksms", opt);
					}

					// 바로구매, 장바구니 폼 전송
					function fitem_submit(f) {

						f.action = "<?php echo $action_url; ?>";
						f.target = "";

						if (document.pressed == "장바구니") {
							f.sw_direct.value = 0;
						} else { // 바로구매
							f.sw_direct.value = 1;
						}

						// 판매가격이 0 보다 작다면
						if (document.getElementById("it_price").value < 0) {
							alert("전화로 문의해 주시면 감사하겠습니다.");
							return false;
						}

						if($(".it_opt_list").size() < 1) {
							alert("선택옵션을 선택해 주십시오.");
							return false;
						}

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

						if (document.pressed == "장바구니") {
							$.post("./itemcart.php", $(f).serialize(), function(error) {
								if(error != "OK") {
									alert(error.replace(/\\n/g, "\n"));
									return false;
								} else {
									if(confirm("장바구니에 담겼습니다.\n\n바로 확인하시겠습니까?")) {
										document.location.href = "./cart.php";
									}
								}
							});
							return false;
						} else {
							return true;
						}
					}
				</script>

				<div class="h15"></div>

				<?php if($is_ii) { // 상품정보고시 ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">
								<i class="fa fa-microphone fa-lg"></i> <b>상품정보고시</b>
							</div>
						</div>
						<ul class="list-group">
							<?php for($i=0; $i < count($ii); $i++) { ?>
								<li class="list-group-item">
									<b class="list-group-item-heading"><?php echo $ii[$i]['title']; ?></b>
									<p class="list-group-item-text"><?php echo $ii[$i]['value']; ?></p>
								</li>
							<?php } ?>
						</ul>
					</div>
				<?php } ?>

				<?php if ($default['de_baesong_content']) { // 배송정보 내용이 있다면 ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">
								<i class="fa fa-truck fa-lg"></i> <b>배송안내</b>
							</div>
						</div>
						<div class="list-group">
							<div class="list-group-item">
								<?php echo conv_content($default['de_baesong_content'], 1); ?>
							</div>
						</div>
					</div>
				<?php } ?>

				<?php if ($default['de_change_content']) { // 교환/반품 내용이 있다면 ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">
								<i class="fa fa-refresh fa-lg"></i> <b>교환/반품 안내</b>
							</div>
						</div>
						<div class="list-group">
							<div class="list-group-item">
						<?php echo conv_content($default['de_change_content'], 1); ?>
							</div>
						</div>
					</div>
				<?php } ?>

				<p class="text-center">
					<button type="button" class="btn btn-<?php echo $btn1;?> btn-sm" data-dismiss="modal">닫기</button>
				</p>
			</div>
		</div>
	</div>
</div>
