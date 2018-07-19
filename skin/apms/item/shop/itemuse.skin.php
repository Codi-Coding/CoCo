<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!$wset['ucont']) $wset['ucont'] = 60;

$list_cnt = count($list);

?>

<div class="use-media<?php echo (G5_IS_MOBILE) ? ' use-mobile' : '';?>">	
	<?php for ($i=0; $i < $list_cnt; $i++) { ?>
		<div class="div-title-wrap">
			<div class="div-title">
				<strong>
					<a href="#" onclick="more_is('more_is_<?php echo $i; ?>'); return false;">
						<?php echo $list[$i]['is_num']; ?>.<?php echo $list[$i]['is_subject']; ?>
					</a>
				</strong>
			</div>
			<div class="div-sep-wrap">
				<div class="div-sep sep-thin"></div>
			</div>
		</div>

		<div class="media">
			<div class="pull-left">
				<a href="#" onclick="more_is('more_is_<?php echo $i; ?>'); return false;">
					<?php echo ($list[$i]['is_photo']) ? '<img src="'.$list[$i]['is_photo'].'" alt="" class="normal circle">' : '<i class="fa fa-user normal circle"></i>'; ?>
				</a>
			</div>
			<div class="media-body">
				<div class="media-info text-muted">
					<?php echo apms_get_star($list[$i]['is_score'],'red font-14'); //별점 ?>
					<span class="sp"></span>
					<i class="fa fa-user"></i>
					<?php echo $list[$i]['is_name']; ?>
					<span class="sp"></span>
					<i class="fa fa-clock-o"></i>
					<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$i]['is_time']) ?>"><?php echo apms_date($list[$i]['is_time'], 'orangered', 'before');?></time>
				</div>
				<div class="media-desc">
					<a href="#" onclick="more_is('more_is_<?php echo $i; ?>'); return false;">
						<span class="text-muted"><?php echo apms_cut_text($list[$i]['is_content'], $wset['ucont'], '… <span class="font-11 text-muted">더보기</span>'); ?></span>
					</a>
				</div>
			</div>
			<div class="clearfix media-content" id="more_is_<?php echo $i; ?>" style="display:none;">
				<?php echo get_view_thumbnail($list[$i]['is_content'], $default['pt_img_width']); // 후기 내용 ?>
				<?php if ($list[$i]['is_btn']) { ?>
					<div class="print-hide media-btn text-right">
						<a href="#" onclick="apms_form('itemuse_form', '<?php echo $list[$i]['is_edit_href'];?>'); return false; ">
							<span class="text-muted"><i class="fa fa-plus"></i> 수정</span>
						</a>
						&nbsp;
						<a href="#" onclick="apms_delete('itemuse', '<?php echo $list[$i]['is_del_href'];?>', '<?php echo $list[$i]['is_del_return'];?>'); return false; ">
							<span class="text-muted"><i class="fa fa-times"></i> 삭제</span>
						</a>
					</div>
				<?php } ?>
				<?php if ($list[$i]['is_reply']) { 
					//답글제목 : $list[$i]['is_reply_subject']
					//답글작성 : $list[$i]['is_reply_name']
				?>
					<div class="well well-sm">
						<?php echo get_view_thumbnail($list[$i]['is_reply_content'], $default['pt_img_width']); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
</div>

<div class="print-hide well text-center"> 
	<?php if ($is_free_write) { ?>
		구매와 상관없이 후기를 등록할 수 있습니다.
	<?php } else { ?>
		구매하신 분만 후기를 등록할 수 있습니다.
	<?php } ?>
</div>

<div class="print-hide use-btn">
	<div class="use-page pull-left">
		<ul class="pagination pagination-sm en">
			<?php echo apms_ajax_paging('itemuse', $write_pages, $page, $total_page, $list_page); ?>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="pull-right">
		<div class="btn-group">
			<button type="button" class="btn btn-<?php echo $btn2;?> btn-sm" onclick="apms_form('itemuse_form', '<?php echo $itemuse_form; ?>');">
				<i class="fa fa-pencil"></i> 후기쓰기<span class="sound_only"> 새 창</span>
			</button>
			<a class="btn btn-<?php echo $btn1;?> btn-sm" href="<?php echo $itemuse_list; ?>"><i class="fa fa-plus"></i> 더보기</a>
			<?php if($admin_href) { ?>
				<a class="btn btn-<?php echo $btn1;?> btn-sm" href="<?php echo $admin_href; ?>"><i class="fa fa-th-large"></i><span class="hidden-xs"> 관리</span></a>
			<?php } ?>
		</div>
		<div class="h30"></div>
	</div>
	<div class="clearfix"></div>
</div>

<script>
function more_is(id) {
	$("#" + id).toggle();
}
</script>