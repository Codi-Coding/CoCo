<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 관련상품 전체 추출을 위해서 재세팅함
$rmods = 100;
$rrows = 1;

// 버튼컬러
$btn1 = (isset($wset['btn1']) && $wset['btn1']) ? $wset['btn1'] : 'black';
$btn2 = (isset($wset['btn2']) && $wset['btn2']) ? $wset['btn2'] : 'color';

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$item_skin_url.'/style.css" media="screen">', 0);

if($is_orderable) echo '<script src="'.$item_skin_url.'/shop.js"></script>'.PHP_EOL;

// 이미지처리
$j=0;
$thumbnails = array();
$item_image = '';
$item_image_href = '';
for($i=1; $i<=10; $i++) {
	if(!$it['it_img'.$i])
		continue;

	$thumb = get_it_thumbnail($it['it_img'.$i], 60, 60);

	if($thumb) {
		$org_url = G5_DATA_URL.'/item/'.$it['it_img'.$i];
		$img = apms_thumbnail($org_url, 600, 600, false, true);
		$thumb_url = ($img['src']) ? $img['src'] : $org_url;
		if($j == 0) {
			$item_image = $thumb_url; // 큰이미지
			$item_image_href = G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;ca_id='.$ca_id.'&amp;no='.$i; // 큰이미지 주소
		}
		$thumbnails[$j] = '<a data-href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;ca_id='.$ca_id.'&amp;no='.$i.'" data-ref="'.$thumb_url.'" class="thumb_item_image">'.$thumb.'<span class="sound_only"> '.$i.'번째 이미지 새창</span></a>';
		$j++;
	}
}

// 카운팅
$it_comment_cnt = ($it['pt_comment'] > 0) ? ' <b class="orangered en">'.number_format($it['pt_comment']).'</b>' : '';
$it_use_cnt = ($item_use_count > 0) ? ' <b class="orangered en">'.number_format($item_use_count).'</b>' : '';
$it_qa_cnt = ($item_qa_count > 0) ? ' <b class="orangered en">'.number_format($item_qa_count).'</b>' : '';

// 판매자
$is_seller = ($it['pt_id'] && $it['pt_id'] != $config['cf_admin']) ? true : false;

?>

<?php if($nav_title) { ?>
	<aside class="item-nav">
		<span class="page-nav pull-right text-muted">
			<i class="fa fa-home"></i> 홈
			<?php
				if($is_nav) {		
					$nav_cnt = count($nav);
					for($i=0;$i < $nav_cnt; $i++) { 
						$nav[$i]['cnt'] = ($nav[$i]['cnt']) ? '('.number_format($nav[$i]['cnt']).')' : '';
			?>
					>
					<a href="./list.php?ca_id=<?php echo $nav[$i]['ca_id'];?>">
						<span class="text-muted"><?php echo $nav[$i]['name'];?><?php echo $nav[$i]['cnt'];?></span>
					</a>
				<?php } ?>
			<?php } else {
				echo ($page_nav1) ? ' > '.$page_nav1 : '';
				echo ($page_nav2) ? ' > '.$page_nav2 : '';
				echo ($page_nav3) ? ' > '.$page_nav3 : '';
				} 
			?>
		</span>
		<h3 class="div-title-underbar">
			<span class="div-title-underbar-bold font-22 border-<?php echo (isset($wset['ncolor']) && $wset['ncolor']) ? $wset['ncolor'] : 'color';?>">
				<?php echo $nav_title;?>
			</span>
		</h3>
	</aside>
<?php } ?>

<?php echo $it_head_html; // 상단 HTML; ?>

<div class="item-head">
	<div class="row">
		<div class="col-sm-6">
			<div class="item-image">
				<a href="<?php echo $item_image_href;?>" id="item_image_href" class="popup_item_image" target="_blank" title="크게보기">
					<img id="item_image" src="<?php echo $item_image;?>" alt="">
				</a>
				<?php if($wset['shadow']) echo apms_shadow($wset['shadow']); //그림자 ?>
			</div>
			<div class="item-thumb text-center">
			<?php 
				for($i=0; $i < count($thumbnails); $i++) { 
					echo $thumbnails[$i]; 
				} 
			?>
			</div>
			<script>
				$(function(){
					$(".thumb_item_image").hover(function() {
						var img = $(this).attr("data-ref");
						var url = $(this).attr("data-href");
						$("#item_image").attr("src", img);
						$("#item_image_href").attr("href", url);
						return true;
					});
					// 이미지 크게보기
					$(".popup_item_image").click(function() {
						var url = $(this).attr("href");
						var top = 10;
						var left = 10;
						var opt = 'scrollbars=yes,top='+top+',left='+left;
						popup_window(url, "largeimage", opt);

						return false;
					});
				});
			</script>
			<div class="h30 visible-xs"></div>
		</div>
		<div class="col-sm-6">
			<h1><?php echo stripslashes($it['it_name']); // 상품명 ?></h1>
			<?php if($it['it_basic']) { // 기본설명 ?>
				<p class="help-block"><?php echo $it['it_basic']; ?></p>
			<?php } ?>
			<form name="fitem" method="post" action="<?php echo $action_url; ?>" class="form item-form" role="form" onsubmit="return fitem_submit(this);">
			<input type="hidden" name="it_id[]" value="<?php echo $it_id; ?>">
			<input type="hidden" name="it_msg1[]" value="<?php echo $it['pt_msg1']; ?>">
			<input type="hidden" name="it_msg2[]" value="<?php echo $it['pt_msg2']; ?>">
			<input type="hidden" name="it_msg3[]" value="<?php echo $it['pt_msg3']; ?>">
			<input type="hidden" name="sw_direct">
			<input type="hidden" name="url">

			<table class="div-table table">
			<col width="120">
			<tbody>
			<?php if ($it['it_use_avg']) { ?>
				<tr><th scope="row">고객평점</th><td><?php echo apms_get_star($it['it_use_avg'],'fa-lg red'); //평균별점 ?></td></tr>
			<?php } ?>
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
			<?php if($it['it_buy_min_qty']) { ?>
				<tr><th>최소구매수량</th><td><?php echo number_format($it['it_buy_min_qty']); ?> 개</td></tr>
			<?php } ?>
			<?php if($it['it_buy_max_qty']) { ?>
				<tr><th>최대구매수량</th><td><?php echo number_format($it['it_buy_max_qty']); ?> 개</td></tr>
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
			</tbody>
			</table>

			<div id="item_option">
				<?php if($option_item) { ?>
					<p>&nbsp; <b><i class="fa fa-check-square-o fa-lg"></i> 선택옵션</b></p>
					<table class="div-table table">
					<col width="120">
					<tbody>
					<?php echo $option_item; // 선택옵션	?>
					</tbody>
					</table>
				<?php }	?>

				<?php if($supply_item) { ?>
					<p>&nbsp; <b><i class="fa fa-check-square-o fa-lg"></i> 추가옵션</b></p>
					<table class="div-table table">
					<col width="120">
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

			<?php if ($is_orderable) { ?>
				<div style="text-align:center; padding:12px 0;">
					<ul class="item-buy-btn">
					<li><input type="submit" onclick="document.pressed=this.value;" value="바로구매" class="btn btn-<?php echo $btn2;?> btn-block"></li>
					<li><input type="submit" onclick="document.pressed=this.value;" value="장바구니" class="btn btn-<?php echo $btn1;?> btn-block"></li>
					<li><a href="#" class="btn btn-<?php echo $btn1;?> btn-block" onclick="apms_wishlist('<?php echo $it['it_id']; ?>'); return false;">위시리스트</a></li>
					<li><a href="#" class="btn btn-<?php echo $btn1;?> btn-block" onclick="apms_recommend('<?php echo $it['it_id']; ?>', '<?php echo $ca_id; ?>'); return false;">추천하기</a></li>
					</ul>
				</div>
				<?php if ($naverpay_button_js) { ?>
					<div style="margin-bottom:15px;"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
				<?php } ?>
			<?php } ?>
			<?php if(!$is_orderable && $it['it_soldout'] && $it['it_stock_sms']) { ?>
				<div style="text-align:center; padding:12px 0;">
					<button type="button" onclick="popup_stocksms('<?php echo $it['it_id']; ?>','<?php echo $ca_id; ?>');" class="btn btn-primary">재입고알림(SMS)</button>
				</div>
			<?php } ?>
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

				// Wishlist
				function apms_wishlist(it_id) {
					if(!it_id) {
						alert("코드가 올바르지 않습니다.");
						return false;
					}

					$.post("./itemwishlist.php", { it_id: it_id },	function(error) {
						if(error != "OK") {
							alert(error.replace(/\\n/g, "\n"));
							return false;
						} else {
							if(confirm("위시리스트에 담겼습니다.\n\n바로 확인하시겠습니까?")) {
								document.location.href = "./wishlist.php";
							}
						}
					});

					return false;
				}

				// Recommend
				function apms_recommend(it_id, ca_id) {
					if (!g5_is_member) {
						alert("회원만 추천하실 수 있습니다.");
					} else {
						url = "./itemrecommend.php?it_id=" + it_id + "&ca_id=" + ca_id;
						opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
						popup_window(url, "itemrecommend", opt);
					}
				}
			</script>

			<div class="pull-right">
				<?php include_once(G5_SNS_PATH."/item.sns.skin.php"); ?>
			</div>
			<div class="clearfix"></div>

			<?php if ($is_tag) { // 태그 ?>
				<p class="item-tag"><i class="fa fa-tags"></i> <?php echo $tag_list;?></p>
			<?php } ?>

		</div>
	</div>
</div>

<?php if($is_viewer || $is_link) { 
	// 보기용 첨부파일 확장자에 따른 FA 아이콘 - array(이미지, 비디오, 오디오, PDF)
	$viewer_fa = array("picture-o", "video-camera", "music", "file-powerpoint-o");
?>
	<?php echo apms_line('fa', 'fa-gift'); //라인 ?> 

	<div class="item-view-box">
		<?php if($is_link) { ?>
			<?php for($i=0; $i < count($link); $i++) { ?>
				<a href="<?php echo $link[$i]['url']; ?>" target="_blank" class="at-tip" title="<?php echo ($link[$i]['name']) ? $link[$i]['name'] : '관련링크'; ?>"><i class="fa fa-<?php echo ($link[$i]['fa']) ? $link[$i]['fa'] : 'link';?>"></i></a>
			<?php } ?>
		<?php } ?>

		<?php if($is_viewer) { ?>
			<?php for($i=0; $i < count($viewer); $i++) { $v = ($viewer[$i]['ext'] - 1); ?>
				<?php if($viewer[$i]['href_view']) { ?>
					<a href="<?php echo $viewer[$i]['href_view'];?>" class="view_win at-tip" title="<?php echo ($viewer[$i]['free']) ? '무료보기' : '바로보기';?>">
				<?php } else { ?>
					<a onclick="alert('구매한 회원만 볼 수 있습니다.');" class="at-tip" title="유료보기">
				<?php } ?>
					<i class="fa fa-<?php echo $viewer_fa[$v];?>"></i>
				</a>
			<?php } ?>
		<?php } ?>
		<script>
			var view_win = function(href) {
				var new_win = window.open(href, 'view_win', 'left=0,top=0,width=640,height=480,toolbar=0,location=0,scrollbars=0,resizable=1,status=0,menubar=0');
				new_win.focus();
			}
			$(function() {
				$(".view_win").click(function() {
					view_win(this.href);
					return false;
				});
			});
		</script>
	</div>
<?php } ?>

<?php // 비디오
	$item_video = apms_link_video($link_video);
	if($item_video) {
		echo apms_line('fa', 'fa-video-camera');
		echo $item_video;
	}
?>

<?php if($is_download) { // 다운로드 ?>
	<?php echo apms_line('fa', 'fa-download'); // 라인 ?> 
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-download"></i> Download</h3>
		</div>
		<div class="list-group">
			<?php for($i=0; $i < count($download); $i++) { ?>
				<a class="list-group-item break-word" href="<?php echo ($download[$i]['href']) ? $download[$i]['href'] : 'javascript:alert(\'구매한 회원만 다운로드할 수 있습니다.\');';?>">
					<?php if($download[$i]['free']) { ?>
						<?php if($download[$i]['guest_use']) { ?>
							<span class="label label-default label-item pull-right"><span class="font-11 en">Free</span></span> 
						<?php } else { ?>
							<span class="label label-primary label-item pull-right"><span class="font-11 en">Join</span></span> 
						<?php } ?>
					<?php } else { ?>
						<span class="label label-danger label-item pull-right"><span class="font-11 en">Paid</span></span> 
					<?php } ?>
					<i class="fa fa-download"></i> <?php echo $download[$i]['source'];?> (<?php echo $download[$i]['size'];?>)
				</a>
			<?php } ?>
			<?php if($i && $is_remaintime) { //이용기간 안내
				$remain_day = (int)(($is_remaintime - G5_SERVER_TIME) / 86400); //남은일수
			?>
				<a class="list-group-item" href="#">
					<i class="fa fa-bell"></i> <?php echo date("Y.m.d H:i", $is_remaintime);?>(<?php echo number_format($remain_day);?>일 남음)까지 이용가능합니다.
				</a>
			<?php } ?>
		</div>
	</div>
<?php } ?>

<?php if ($is_torrent) { // 토렌트 파일정보 ?>
	<?php echo apms_line('fa', 'fa-cube'); // 라인 ?> 
	<?php for($i=0; $i < count($torrent); $i++) { ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-cube"></i> <?php echo $torrent[$i]['name'];?></h3>
			</div>
			<div class="panel-body">
				<span class="pull-right hidden-xs text-muted en font-11"><i class="fa fa-clock-o"></i> <?php echo date("Y-m-d H:i", $torrent[$i]['date']);?></span>
				<?php if ($torrent[$i]['is_size']) { ?>
						<b class="en font-16"><i class="fa fa-cube"></i> <?php echo $torrent[$i]['info']['name'];?> (<?php echo $torrent[$i]['info']['size'];?>)</b>
				<?php } else { ?>
					<p><b class="en font-16"><i class="fa fa-cubes"></i> Total <?php echo $torrent[$i]['info']['total_size'];?></b></p>
					<div class="text-muted font-12">
						<?php for ($j=0;$j < count($torrent[$i]['info']['file']);$j++) { 
							echo ($j + 1).'. '.implode(', ', $torrent[$i]['info']['file'][$j]['name']).' ('.$torrent[$i]['info']['file'][$j]['size'].')<br>'."\n";
						} ?>
					</div>
				<?php } ?>
			</div>
			<ul class="list-group">
				<li class="list-group-item en font-14 break-word"><i class="fa fa-magnet"></i> <?php echo $torrent[$i]['magnet'];?></li>
				<li class="list-group-item break-word">
					<div class="text-muted" style="font-size:12px;">
						<?php for ($j=0;$j < count($torrent[$i]['tracker']);$j++) { ?>
							<i class="fa fa-tags"></i> <?php echo $torrent[$i]['tracker'][$j];?><br>
						<?php } ?>
					</div>
				</li>
				<?php if($torrent[$i]['comment']) { ?>
					<li class="list-group-item en font-14 break-word"><i class="fa fa-bell"></i> <?php echo $torrent[$i]['comment'];?></li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
<?php } ?>

<?php echo apms_line('fa'); // 라인 ?> 

<div class="item-explan">
	<?php if ($it['pt_explan']) { // 구매회원에게만 추가로 보이는 상세설명 ?>
		<div class="well"><?php echo apms_explan($it['pt_explan']); ?></div>
	<?php } ?>
	<?php echo apms_explan($it['it_explan']); ?>
</div>

<?php if ($is_good) { // 추천 ?>
	<div class="item-good-box">
		<span class="item-good">
			<a href="#" onclick="apms_good('<?php echo $it_id;?>', '', 'good', 'it_good'); return false;">
				<b id="it_good"><?php echo number_format($it['pt_good']) ?></b>
				<br>
				<i class="fa fa-thumbs-up"></i>
			</a>
		</span>
		<span class="item-nogood">
			<a href="#" onclick="apms_good('<?php echo $it_id;?>', '', 'nogood', 'it_nogood'); return false;">
				<b id="it_nogood"><?php echo number_format($it['pt_nogood']) ?></b>
				<br>
				<i class="fa fa-thumbs-down"></i>
			</a>
		</span>
	</div>
<?php } ?>

<?php if ($is_ccl) { // CCL ?>
	<div class="h20"></div>
	<div class="well">
		<img src="<?php echo $ccl_img;?>" alt="CCL" />  &nbsp; 본 자료는 <u><?php echo $ccl_license;?></u>에 따라 이용할 수 있습니다.
	</div>
<?php } ?>

<?php if($is_seller && $wset['seller']) { // 판매자 ?>
	<div class="panel panel-default item-seller">
		<div class="panel-heading">
			<h3 class="panel-title">
				<?php if($author['partner']) { ?>
					<a href="<?php echo $at_href['myshop'];?>?id=<?php echo $author['mb_id'];?>" class="pull-right">
						<span class="label label-primary"><span class="font-11 en">My Shop</span></span>
					</a>
				<?php } ?>
				Seller
			</h3>
		</div>
		<div class="panel-body">
			<div class="pull-left text-center auth-photo">
				<div class="img-photo">
					<?php echo ($author['photo']) ? '<img src="'.$author['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
				</div>
				<div class="btn-group" style="margin-top:-30px;white-space:nowrap;">
					<button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $author['mb_id'];?>', 'like', 'it_like'); return false;" title="Like">
						<i class="fa fa-thumbs-up"></i> <span id="it_like"><?php echo number_format($author['liked']) ?></span>
					</button>
					<button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $author['mb_id'];?>', 'follow', 'it_follow'); return false;" title="Follow">
						<i class="fa fa-users"></i> <span id="it_follow"><?php echo $author['followed']; ?></span>
					</button>
				</div>
			</div>
			<div class="auth-info">
				<div style="margin-bottom:4px;">
					<span class="pull-right">Lv.<?php echo $author['level'];?></span>
					<b><?php echo $author['name']; ?></b> &nbsp;<span class="text-muted font-11"><?php echo $author['grade'];?></span>
				</div>
				<div class="div-progress progress progress-striped no-margin">
					<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($author['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($author['exp_per']);?>%;">
						<span class="sr-only"><?php echo number_format($author['exp']);?> (<?php echo $author['exp_per'];?>%)</span>
					</div>
				</div>
				<p style="margin-top:10px;">
					<?php echo ($author['signature']) ? $author['signature'] : '등록된 서명이 없습니다.'; ?>
				</p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
<?php } ?>

<?php if ($is_relation) { ?>
	<div class="div-title-wrap">
		<div class="div-title" style="line-height:30px;">
			<i class="fa fa-cubes fa-lg lightgray"></i> <b>관련아이템</b>
		</div>
		<div class="div-sep-wrap">
			<div class="div-sep sep-bold"></div>
		</div>
	</div>
	<?php include_once('./itemrelation.php'); ?>
<?php } ?>

<?php // 위젯에서 해당글 클릭시 이동위치 : icv - 댓글, iuv - 후기, iqv - 문의 ?>
<div id="item-tab" class="div-tab tabs<?php echo ($wset['tabline']) ? '' : ' trans-top';?>">
	<ul class="nav nav-tabs nav-justified">
		<li class="active"><a href="#item-review" data-toggle="tab"><b>후기글<?php echo $it_use_cnt;?></b></a></li>
		<li><a href="#item-qa" data-toggle="tab"><b>문의글<?php echo $it_qa_cnt;?></b></a></li>
		<?php if($is_comment) { // 댓글 ?>
			<li><a href="#item-cmt" data-toggle="tab"><b>댓글<?php echo $it_comment_cnt;?></b></a></li>
		<?php } ?>
		<?php if($is_ii) { // 상품정보고시 ?>
			<li><a href="#item-info" data-toggle="tab"><b>필수표기정보</b></a></li>
		<?php } ?>
		<li><a href="#item-delivery" data-toggle="tab"><b>배송/교환/반품</b></a></li>
	</ul>
	<div class="tab-content" style="border:0px; padding:20px 0px;">
		<div class="tab-pane active" id="item-review">
			<div id="iuv"></div>
			<div id="itemuse">
				<?php include_once('./itemuse.php'); ?>
			</div>
		</div>
		<div class="tab-pane" id="item-qa">
			<div id="iqv"></div>
			<div id="itemqa">
				<?php include_once('./itemqa.php'); ?>
			</div>
		</div>
		<?php if($is_comment) { // 댓글 ?>
			<div class="tab-pane" id="item-cmt">
				<div id="icv"></div>
				<?php include_once('./itemcomment.php'); ?>
			</div>
		<?php } ?>
		<?php if($is_ii) { // 상품정보고시 ?>
			<div class="tab-pane" id="item-info">

				<div class="tbox-head no-line">
					<i class="fa fa-check-square fa-lg lightgray"></i> 상품요약정보 : <?php echo $item_info[$gubun]['title']; ?>
				</div>
				<div class="tbox-body">
					<div class="table-responsive">
						<table class="div-table table top-border">
						<caption>상품정보고시</caption>
						<tbody>
							<?php for($i=0; $i < count($ii); $i++) { ?>
								<tr>
									<th><?php echo $ii[$i]['title']; ?></th>
									<td><?php echo $ii[$i]['value']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
						</table>
					</div>
				</div>

				<div class="tbox-head no-line">
					<i class="fa fa-check-square fa-lg lightgray"></i> 거래조건에 관한 정보
				</div>
				<div class="tbox-body">
					<div class="table-responsive">
						<table class="div-table table top-border">
						<caption>거래조건</caption>
						<tbody>
							<tr>
								<th>재화 등의 배송방법에 관한 정보</th>
								<td>상품 상세설명페이지 참고</td>
							</tr>
							<tr>
								<th>주문 이후 예상되는 배송기간</th>
								<td>상품 상세설명페이지 참고</td>
							</tr>
							<tr>
								<th>제품하자가 아닌 소비자의 단순변심, 착오구매에 따른 청약철회 시 소비자가 부담하는 반품비용 등에 관한 정보</th>
								<td>배송ㆍ교환ㆍ반품 상세설명페이지 참고</td>
							</tr>
							<tr>
								<th>제품하자가 아닌 소비자의 단순변심, 착오구매에 따른 청약철회가 불가능한 경우 그 구체적 사유와 근거</th>
								<td>배송ㆍ교환ㆍ반품 상세설명페이지 참고</td>
							</tr>
							<tr>
								<th>재화등의 교환ㆍ반품ㆍ보증 조건 및 품질보증 기준</th>
								<td>소비자분쟁해결기준(공정거래위원회 고시) 및 관계법령에 따릅니다.</td>
							</tr>
							<tr>
								<th>재화등의 A/S 관련 전화번호</th>
								<td>상품 상세설명페이지 참고</td>
							</tr>
							<tr>
								<th>대금을 환불받기 위한 방법과 환불이 지연될 경우 지연에 따른 배상금을 지급받을 수 있다는 사실 및 배상금 지급의 구체적 조건 및 절차</th>
								<td>배송ㆍ교환ㆍ반품 상세설명페이지 참고</td>
							</tr>
							<tr>
								<th>소비자피해보상의 처리, 재화등에 대한 불만처리 및 소비자와 사업자 사이의 분쟁처리에 관한 사항</th>
								<td>소비자분쟁해결기준(공정거래위원회 고시) 및 관계법령에 따릅니다.</td>
							</tr>
							<tr>
								<th>거래에 관한 약관의 내용 또는 확인할 수 있는 방법</th>
								<td>상품 상세설명페이지 및 페이지 하단의 이용약관 링크를 통해 확인할 수 있습니다.</td>
							</tr>
						</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="tab-pane" id="item-delivery">
			<?php include_once($item_skin_path.'/item.delivery.php'); ?>
		</div>
	</div>							
</div>

<?php echo $it_tail_html; // 하단 HTML ?>

<div class="btn-group btn-group-justified">
	<?php if($prev_href) { ?>
		<a class="btn btn-<?php echo $btn1;?>" href="<?php echo $prev_href;?>" title="<?php echo $prev_item;?>"><i class="fa fa-chevron-circle-left"></i> 이전</a>
	<?php } ?>
	<?php if($next_href) { ?>
		<a class="btn btn-<?php echo $btn1;?>" href="<?php echo $next_href;?>" title="<?php echo $next_item;?>"><i class="fa fa-chevron-circle-right"></i> 다음</a>
	<?php } ?>
	<?php if($edit_href) { ?>
		<a class="btn btn-<?php echo $btn1;?>" href="<?php echo $edit_href;?>"><i class="fa fa-plus"></i><span class="hidden-xs"> 수정</span></a>
	<?php } ?>
	<?php if ($write_href) { ?>
		<a class="btn btn-<?php echo $btn1;?>" href="<?php echo $write_href;?>"><i class="fa fa-upload"></i><span class="hidden-xs"> 등록</span></a>
	<?php } ?>
	<?php if($item_href) { ?>
		<a class="btn btn-<?php echo $btn1;?>" href="<?php echo $item_href;?>"><i class="fa fa-th-large"></i><span class="hidden-xs"> 관리</span></a>
	<?php } ?>
	<?php if($setup_href) { ?>
		<a class="btn btn-<?php echo $btn1;?> win_memo" href="<?php echo $setup_href;?>"><i class="fa fa-cogs"></i><span class="hidden-xs"> 스킨설정</span></a>
	<?php } ?>
	<a class="btn btn-<?php echo $btn2;?>" href="<?php echo $list_href;?>"><i class="fa fa-bars"></i> 목록</a>
</div>

<div class="h30"></div>

<script>
$(function() {
	$("a.view_image").click(function() {
		window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
		return false;
	});
});
</script>

<?php include_once('./itemlist.php'); // 분류목록 ?>
