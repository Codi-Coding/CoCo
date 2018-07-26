<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<h1><i class="fa fa-cube"></i> Profit Item Inbox</h1>

<div class="well" style="padding-bottom:3px;">
	<form class="form" role="form" name="flist">
	<input type="hidden" name="ap" value="<?php echo $ap;?>">
		<div class="row">
			<div class="col-sm-2 col-xs-6">
				<div class="form-group">
					<label for="sca" class="sr-only">분류선택</label>
					<select name="sca" id="sca" class="form-control input-sm">
						<option value="">카테고리</option>
						<?php echo $category_options;?>
					</select>
				</div>
			</div>
			<div class="col-sm-2 col-xs-6">
				<div class="form-group">
					<label for="sfl" class="sr-only">검색옵션</label>
					<select name="sfl" id="sfl" class="form-control input-sm">
						<option value="it_name"<?php echo get_selected($sfl, 'it_name');?>>상품명</option>
						<option value="it_id"<?php echo get_selected($sfl, 'it_id');?>>상품코드</option>
						<option value="it_basic"<?php echo get_selected($sfl, 'it_basic');?>>기본설명</option>
						<option value="it_explan"<?php echo get_selected($sfl, 'it_explan');?>>상세설명</option>
					</select>
				</div>
			</div>
			<div class="col-sm-4 col-xs-12">
				<div class="form-group">
					<div class="form-group">
					    <label for="stx" class="sound_only">검색어</label>
					    <input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="form-control input-sm" placeholder="검색어">
					</div>
				</div>
			</div>
			<div class="col-sm-2 col-xs-6">
				<div class="form-group">
					<button type="submit" class="btn btn-danger btn-sm btn-block"><i class="fa fa-search"></i> 검색</button>
				</div>
			</div>
			<div class="col-sm-2 col-xs-6">
				<div class="form-group">
					<a href="./?ap=<?php echo $ap;?>" class="btn btn-primary btn-sm btn-block"><i class="fa fa-refresh"></i> 리셋</a>
				</div>
			</div>
		</div>
	</form>
	<script>
		document.getElementById("sca").value = "<?php echo $sca; ?>";
	</script>
</div>

<h3>
	<i class="fa fa-cubes"></i> <?php echo number_format($total_count); ?> Items
</h3>

<style>
.share-url {
	padding:12px; 
	line-height:22px;
	border:1px solid #ddd;
	background:#f5f5f5;
}
.share-icon img { 
	width:42px; border-radius:50%; margin:12px 2px 0px;
}
</style>
<script>
	function share_act(id) {
		$('#share_content').html($('#' + id).html());
		$('#share_modal').modal('show')
	}
</script>
<div class="table-responsive">
	<table class="table tbl bg-white">
	<tbody>
	<tr class="bg-black">
		<th width="60" class="text-center" scope="col">번호</a></th>
		<th width="60" class="text-center" scope="col"><?php echo subject_sort_link('it_use', 'ap='.$ap.'&amp;sca='.$sca); ?>판매</a></th>
		<th width="60" class="text-center" scope="col"><?php echo subject_sort_link('it_soldout', 'ap='.$ap.'&amp;sca='.$sca); ?>품절</a></th>
		<th width="120" class="text-right" scope="col"><?php echo subject_sort_link('it_price', 'ap='.$ap.'&amp;sca='.$sca); ?>판매가격(원)</a></th>
		<th width="100" class="text-right" scope="col"><?php echo subject_sort_link('it_point', 'ap='.$ap.'&amp;sca='.$sca); ?>포인트</a></th>
		<th width="100" class="text-right" scope="col"><?php echo subject_sort_link('pt_marketer', 'ap='.$ap.'&amp;sca='.$sca); ?>적립(수익)율</a></th>
		<th width="60" class="text-center" scope="col">공유</a></th>
		<th width="60" class="text-center" scope="col">이미지</th>
		<th class="text-center" scope="col"><?php echo subject_sort_link('it_name', 'ap='.$ap.'&amp;sca='.$sca); ?>제목</a></th>
		<th class="text-center" scope="col">비고</th>
	</tr>
	<?php for ($i=0; $i < count($list); $i++) { 
		$list[$i]['img'] = apms_it_thumbnail(apms_it($list[$i]['it_id']), 40, 40, false, true);
	?>
	<tr>
		<td class="text-center">
			<?php echo $list[$i]['num'];?>
		</td>
		<td class="text-center">
			<?php echo ($list[$i]['it_use'] ? '판매' : '중단'); ?>
		</td>
		<td class="text-center">
			<?php echo ($list[$i]['it_soldout'] ? '품절' : '판매'); ?>
		</td>
		<td class="text-right">
			<?php echo number_format($list[$i]['it_price']); ?>
		</td>
		<td class="text-right">
			<?php echo ($list[$i]['it_point_type']) ? $list[$i]['it_point'].'%' : number_format($list[$i]['it_point']); ?>
		</td>
		<td class="text-right">
			<b><?php echo number_format($list[$i]['pt_marketer']);?></b>%
		</td>
		<td class="text-center">
			<div class="btn-group dropup">
				<button type="button" class="btn btn-default" onclick="share_act('myshare<?php echo $i;?>');">
					Share <span class="caret"></span>
				</button>
				<div class="sr-only">
					<div id="myshare<?php echo $i;?>" >
						<div class="share-url">
							<b><?php echo $list[$i]['it_name'];?></b>
							<br/>
							<?php echo $list[$i]['href']; ?>&mkt=<?php echo $member['mb_id'];?>
						</div>
						<div class="share-icon">
							<?php echo apms_sns_share_icon($list[$i]['href'].'&mkt='.$member['mb_id'], $list[$i]['it_name'], $list[$i]['img']['org']);?>
						</div>
					</div>
				</div>
			</div>
		</td>
		<td class="text-center">
			<a href="<?php echo $list[$i]['href']; ?>">
				<?php if($list[$i]['img']['src']) {?>
					<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
				<?php } else { ?>
					<i class="fa fa-camera img-fa"></i>
				<?php } ?>				
			</a>
		</td>
		<td>
			<a href="<?php echo $list[$i]['href']; ?>"><b><?php echo $list[$i]['it_name'];?></b></a>
			<div class="text-muted" style="margin-top:4px;">
				<?php echo apms_pt_it($list[$i]['pt_it'],1);?>
				<?php echo ($list[$i]['ca_name1']) ? ' / '.$list[$i]['ca_name1'] : '';?>
				<?php echo ($list[$i]['ca_name2']) ? ' / '.$list[$i]['ca_name2'] : '';?>
				<?php echo ($list[$i]['ca_name3']) ? ' / '.$list[$i]['ca_name3'] : '';?>
			</div>
		</td>
		<td><?php echo get_text($list[$i]['it_basic']);?></td>
	</tr>
	<?php } ?>
	<?php if ($i == 0) { ?>
		<tr><td colspan="11" class="text-center">등록된 자료가 없습니다.</td></tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<div class="text-center">
	<ul class="pagination pagination-sm en">
		<?php echo apms_paging($write_pages, $page, $total_page, $list_page); ?>
	</ul>
</div>

<div id="share_modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div id="share_content"></div>
			</div>
			<div class="modal-footer" style="margin-top:0px;">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>