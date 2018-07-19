<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 목록헤드
if(isset($wset['ihead']) && $wset['ihead']) {
	add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/head/'.$wset['ihead'].'.css" media="screen">', 0);
	$head_class = 'list-head';
} else {
	$head_class = (isset($wset['icolor']) && $wset['icolor']) ? 'tr-head border-'.$wset['icolor'] : 'tr-head border-black';
}

// 헤더 출력
if($header_skin)
	include_once('./header.php');

?>

<div class="well well-sm">
	<i class="fa fa-bell fa-lg"></i> 주문서번호 링크를 누르시면 주문상세내역을 조회하실 수 있습니다.
</div>

<div class="table-responsive">
    <table class="div-table table bsk-tbl bg-white">
    <tbody>
    <tr class="<?php echo $head_class;?>">
        <th scope="col"><span>주문서번호</span></th>
        <th scope="col"><span>주문일시</span></th>
        <th scope="col"><span>상품수</span></th>
        <th scope="col"><span>주문금액</span></th>
        <th scope="col"><span>입금액</span></th>
        <th scope="col"><span>미입금액</span></th>
        <th scope="col"><span class="last">상태</span></th>
    </tr>
    <?php for ($i=0; $i < count($list); $i++) { ?>
		<tr<?php echo ($i == 0) ? ' class="tr-line"' : '';?>>
			<td class="text-center">
				<input type="hidden" name="ct_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['ct_id']; ?>">
				<a href="<?php echo $list[$i]['od_href']; ?>"><?php echo $list[$i]['od_id']; ?></a>
			</td>
			<td class="text-center"><?php echo substr($list[$i]['od_time'],2,14); ?> (<?php echo get_yoil($list[$i]['od_time']); ?>)</td>
			<td class="text-center"><?php echo $list[$i]['od_cart_count']; ?></td>
			<td class="text-right"><?php echo display_price($list[$i]['od_total_price']); ?></td>
			<td class="text-right"><?php echo display_price($list[$i]['od_receipt_price']); ?></td>
			<td class="text-right"><?php echo display_price($list[$i]['od_misu']); ?></td>
			<td class="text-center"><?php echo $list[$i]['od_status']; ?></td>
		</tr>
    <?php } ?>
	<?php if ($i == 0) { ?>
        <tr><td colspan="7" class="text-center">주문 내역이 없습니다.</td></tr>
	<?php } ?>
    </tbody>
    </table>
</div>

<div class="text-center">
	<ul class="pagination pagination-sm en">
		<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
	</ul>
</div>

<?php if($setup_href) { ?>
	<p class="text-center">
		<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
			<i class="fa fa-cogs"></i> 스킨설정
		</a>
	</p>
<?php } ?>