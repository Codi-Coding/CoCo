<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

if($header_skin)
	include_once('./header.php');

?>

<div class="mypage-skin">
	<div class="panel panel-default view-author">
		<div class="panel-heading">
			<h3 class="panel-title">My Profile</h3>
		</div>
		<div class="panel-body">
			<div class="pull-left text-center auth-photo">
				<div class="img-photo">
					<?php echo ($member['photo']) ? '<img src="'.$member['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; ?>
				</div>
				<div class="btn-group" style="margin-top:-30px;white-space:nowrap;">
					<button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $member['mb_id'];?>', 'like', 'it_like'); return false;" title="Like">
						<i class="fa fa-thumbs-up"></i> <span id="it_like"><?php echo number_format($member['liked']) ?></span>
					</button>
					<button type="button" class="btn btn-color btn-sm" onclick="apms_like('<?php echo $member['mb_id'];?>', 'follow', 'it_follow'); return false;" title="Follow">
						<i class="fa fa-users"></i> <span id="it_follow"><?php echo $member['followed']; ?></span>
					</button>
				</div>
			</div>
			<div class="auth-info">
				<div class="en font-14" style="margin-bottom:6px;">
					<span class="pull-right font-12">Lv.<?php echo $member['level'];?></span>
					<b><?php echo $member['name']; ?></b> &nbsp;<span class="text-muted en font-12"><?php echo $member['grade'];?></span>
				</div>
				<div class="div-progress progress progress-striped no-margin">
					<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($member['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($member['exp_per']);?>%;">
						<span class="sr-only"><?php echo number_format($member['exp']);?> (<?php echo $member['exp_per'];?>%)</span>
					</div>
				</div>
				<p style="margin-top:6px;">
					<?php echo ($mb_signature) ? $mb_signature : '등록된 서명이 없습니다.'; ?>
				</p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-7">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">My Info</h3>
				</div>
				<ul class="list-group">
					<li class="list-group-item">
						<a href="<?php echo $at_href['point'];?>" target="_blank" class="win_point">
							<span class="pull-right"><?php echo number_format($member['mb_point']); ?>점</span>
							<?php echo AS_MP;?>
						</a>
					</li>
					<?php if(IS_YC) { ?>
						<li class="list-group-item">
							<a href="<?php echo $at_href['coupon'];?>" target="_blank" class="win_point">
								<span class="pull-right"><?php echo number_format($cp_count); ?></span>
								보유쿠폰
							</a>
						</li>
					<?php } ?>
					<li class="list-group-item">
						<span class="pull-right"><?php echo ($member['mb_tel'] ? $member['mb_tel'] : '미등록'); ?></span>
						연락처
					</li>
					<li class="list-group-item">
						<span class="pull-right"><?php echo ($member['mb_email'] ? $member['mb_email'] : '미등록'); ?></span>
						E-Mail
					</li>
					<li class="list-group-item">
						<span class="pull-right"><?php echo $member['mb_today_login']; ?></span>
						최종접속일
					</li>
					<li class="list-group-item">
						<span class="pull-right"><?php echo $member['mb_datetime']; ?></span>
						회원가입일
					</li>
					<?php if($member['mb_addr1']) { ?>
						<li class="list-group-item">
							<?php echo sprintf("(%s-%s)", $member['mb_zip1'], $member['mb_zip2']).' '.print_address($member['mb_addr1'], $member['mb_addr2'], $member['mb_addr3'], $member['mb_addr_jibeon']); ?>
						</li>
					<?php } ?>
				</ul>
				<?php if($member['mb_profile']) { ?>
					<div class="panel-body">
						<?php echo conv_content($member['mb_profile'],0);?>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="col-sm-5">
			<div class="row">
				<?php if ($is_admin == 'super') { ?>
					<div class="col-xs-6">
						<div class="form-group">
							<a href="<?php echo G5_ADMIN_URL; ?>" class="btn btn-lightgray btn-sm btn-block">관리자</a>
						</div>
					</div>
				<?php } ?>
				<?php if (IS_YC && ($is_admin == 'super' || IS_PARTNER)) { ?>
					<div class="col-xs-6">
						<div class="form-group">
							<a href="<?php echo $at_href['myshop'];?>" class="btn btn-lightgray btn-sm btn-block">
								마이샵
							</a>		
						</div>
					</div>
				<?php } ?>
				<div class="col-xs-6">
					<div class="form-group">
						<a href="<?php echo $at_href['response'];?>" target="_blank" class="btn btn-lightgray btn-sm btn-block win_memo">
							내글반응
							<?php if ($member['response']) echo '('.number_format($member['response']).')'; ?>
						</a>		
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<a href="<?php echo $at_href['memo'];?>" target="_blank" class="btn btn-lightgray btn-sm btn-block win_memo">
							쪽지함
							<?php if ($member['memo']) echo '('.number_format($member['memo']).')'; ?>
						</a>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<a href="<?php echo $at_href['follow'];?>" target="_blank" class="btn btn-lightgray btn-sm btn-block win_memo">
							팔로우
						</a>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<a href="<?php echo $at_href['scrap'];?>" target="_blank" class="btn btn-lightgray btn-sm btn-block win_scrap">
							스크랩
						</a>
					</div>
				</div>
				<?php if(IS_YC) { ?>
					<div class="col-xs-6">
						<div class="form-group">
							<a href="<?php echo $at_href['coupon'];?>" target="_blank" class="btn btn-lightgray btn-sm btn-block win_point">
								마이쿠폰
							</a>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<a href="<?php echo $at_href['shopping'];?>" target="_blank" class="btn btn-lightgray btn-sm btn-block win_memo">
								쇼핑리스트
							</a>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<a href="<?php echo $at_href['wishlist'];?>" class="btn btn-lightgray btn-sm btn-block">
								위시리스트
							</a>
						</div>
					</div>
				<?php } ?>
				<div class="col-xs-6">
					<div class="form-group">
						<a href="<?php echo $at_href['mypost'];?>" target="_blank" class="btn btn-lightgray btn-sm btn-block win_memo">
							내글관리
						</a>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<a href="<?php echo $at_href['myphoto'];?>" target="_blank" class="btn btn-lightgray btn-sm btn-block win_memo">
							사진등록
						</a>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<a href="<?php echo $at_href['edit'];?>" class="btn btn-lightgray btn-sm btn-block">
							정보수정
						</a>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="form-group">
						<a href="<?php echo $at_href['leave'];?>" class="btn btn-lightgray btn-sm btn-block leave-me">
							탈퇴하기
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if(IS_YC) { // 영카트 ?>
		<br>
		<!-- 최근 주문내역 시작 { -->
		<section>
			<h4>최근 주문내역</h4>
			<?php
				// 최근 주문내역
			    $sql = " select * from {$g5['g5_shop_order_table']} where mb_id = '{$member['mb_id']}' order by od_id desc limit 0, 5 ";
			    $result = sql_query($sql);
			?>
			<div class="table-responsive">
				<table class="table mypage-tbl">			
				<thead>
				<tr>
					<th scope="col">주문서번호</th>
					<th scope="col">주문일시</th>
					<th scope="col">상품수</th>
					<th scope="col">주문금액</th>
					<th scope="col">입금액</th>
					<th scope="col">미입금액</th>
					<th scope="col">상태</th>
				</tr>
				</thead>
			    <tbody>
			    <?php 
				for ($i=0; $row=sql_fetch_array($result); $i++) {
			        $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);

					switch($row['od_status']) {
						case '주문' : $od_status = '입금확인중'; break;
						case '입금' : $od_status = '입금완료'; break;
						case '준비' : $od_status = '상품준비중'; break;
						case '배송' : $od_status = '상품배송'; break;
						case '완료' : $od_status = '배송완료'; break;
						default		: $od_status = '주문취소'; break;
					}
			    ?>
					<tr>
						<td>
							<input type="hidden" name="ct_id[<?php echo $i; ?>]" value="<?php echo $row['ct_id']; ?>">
							<a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>"><?php echo $row['od_id']; ?></a>
						</td>
						<td><?php echo substr($row['od_time'],2,14); ?> (<?php echo get_yoil($row['od_time']); ?>)</td>
						<td><?php echo $row['od_cart_count']; ?></td>
						<td><?php echo display_price($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?></td>
						<td><?php echo display_price($row['od_receipt_price']); ?></td>
						<td><?php echo display_price($row['od_misu']); ?></td>
						<td><?php echo $od_status; ?></td>
					</tr>
			    <?php } ?>
				<?php if ($i == 0) { ?>
					<tr><td colspan="7" class="empty_table">주문 내역이 없습니다.</td></tr>
				<?php } ?>
			    </tbody>
			    </table>
			</div>
			<p class="text-right">
				<a href="./orderinquiry.php"><i class="fa fa-arrow-right"></i> 주문내역 더보기</a>
			</p>
		</section>
		<!-- } 최근 주문내역 끝 -->

		<!-- 최근 위시리스트 시작 { -->
		<section>
			<h4>최근 위시리스트</h4>

			<div class="table-responsive">
				<table class="table mypage-tbl">			
				<thead>
				<tr>
					<th scope="col">이미지</th>
					<th scope="col">상품명</th>
					<th scope="col">보관일시</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$sql = " select * from {$g5['g5_shop_wish_table']} a, {$g5['g5_shop_item_table']} b where a.mb_id = '{$member['mb_id']}' and a.it_id  = b.it_id order by a.wi_id desc limit 0, 5 ";
				$result = sql_query($sql);
				for ($i=0; $row = sql_fetch_array($result); $i++) {
					$image = get_it_image($row['it_id'], 70, 70, true);
				?>
				<tr>
					<td><?php echo $image; ?></td>
					<td><a href="./item.php?it_id=<?php echo $row['it_id']; ?>"><?php echo stripslashes($row['it_name']); ?></a></td>
					<td><?php echo $row['wi_time']; ?></td>
				</tr>
				<?php } ?>
				<?php if ($i == 0) { ?>
					<tr><td colspan="3" class="empty_table">보관 내역이 없습니다.</td></tr>
				<?php } ?>
				</tbody>
				</table>
			</div>

			<p class="text-right">
				<a href="./wishlist.php"><i class="fa fa-arrow-right"></i> 위시리스트 더보기</a>
			</p>
		</section>
	<?php } ?>
</div>