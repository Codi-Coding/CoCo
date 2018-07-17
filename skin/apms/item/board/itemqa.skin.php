<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!$wset['qcont']) $wset['qcont'] = 60;

$list_cnt = count($list);

?>

<div class="qa-media<?php echo (G5_IS_MOBILE) ? ' qa-mobile' : '';?>">	
	<?php for ($i=0; $i < $list_cnt; $i++) { ?>
		<div class="div-title-wrap">
			<div class="div-title">
				<strong>
					<a href="#" onclick="more_iq('more_iq_<?php echo $i; ?>'); return false;">
						<?php echo $list[$i]['iq_num']; ?>.<?php echo $list[$i]['iq_subject']; ?>
					</a>
				</strong>
			</div>
			<div class="div-sep-wrap">
				<div class="div-sep sep-thin"></div>
			</div>
		</div>

		<div class="media">
			<div class="pull-left">
				<a href="#" onclick="more_iq('more_iq_<?php echo $i; ?>'); return false;">
					<?php echo ($list[$i]['iq_photo']) ? '<img src="'.$list[$i]['iq_photo'].'" alt="" class="normal circle">' : '<i class="fa fa-user normal circle"></i>'; ?>
				</a>
			</div>
			<div class="media-body">
				<div class="media-info text-muted">
					<?php echo ($list[$i]['iq_answer']) ? '<span class="red">답변완료</span>' : '답변대기';?>
					<span class="sp"></span>
					<i class="fa fa-user"></i>
					<?php echo $list[$i]['iq_name']; ?>
					<span class="sp"></span>
					<i class="fa fa-clock-o"></i>
					<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$i]['iq_time']) ?>"><?php echo apms_date($list[$i]['iq_time'], 'oranered', 'before');?></time>
				</div>
				<div class="media-desc">
					<a href="#" onclick="more_is('more_iq_<?php echo $i; ?>'); return false;">
						<?php if($list[$i]['iq_secret']) { ?>
							<img src="<?php echo $item_skin_url;?>/img/icon_secret.gif" alt="">
						<?php } ?>
						<span class="text-muted"><?php echo apms_cut_text($list[$i]['iq_question'], $wset['qcont'], '… <span class="font-11 text-muted">더보기</span>'); ?></span>
					</a>
				</div>
			</div>
			<div class="clearfix" id="more_iq_<?php echo $i; ?>" style="display:none;">
				<div class="media-content">
					<?php echo get_view_thumbnail($list[$i]['iq_question'], $default['pt_img_width']); // 문의 내용 ?>
					<?php if ($list[$i]['iq_btn']) { ?>
						<div class="print-hide media-btn text-right">
							<a href="#" onclick="apms_form('itemqa_form', '<?php echo $list[$i]['iq_edit_href'];?>'); return false; ">
								<span class="text-muted"><i class="fa fa-plus"></i> 수정</span>
							</a>
							&nbsp;
							<a href="#" onclick="apms_delete('itemqa', '<?php echo $list[$i]['iq_del_href'];?>', '<?php echo $list[$i]['iq_del_return'];?>'); return false; ">
								<span class="text-muted"><i class="fa fa-times"></i> 삭제</span>
							</a>
							<?php if(!$list[$i]['iq_answer']) { ?>
								&nbsp;
								<a href="#" onclick="apms_form('itemans_form', '<?php echo $list[$i]['iq_ans_href'];?>'); return false; ">
									<span class="text-muted"><i class="fa fa-comment"></i> 답변</span>
								</a>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
				<?php if($list[$i]['answer']) { ?>
					<div class="div-title-wrap">
						<h5 class="div-title"><i class="fa fa-comment lightgray"></i> Answer</h5>
						<div class="div-sep-wrap">
							<div class="div-sep sep-thin"></div>
						</div>
					</div>
					<div class="media-ans">
						<?php echo get_view_thumbnail($list[$i]['iq_answer'], $default['pt_img_width']); ?>
						<?php if($list[$i]['iq_btn'] && $list[$i]['iq_answer']) { ?>
							<div class="print-hide media-btn text-right">
								<a href="#" onclick="apms_form('itemans_form', '<?php echo $list[$i]['iq_ans_href'];?>'); return false; ">
									<span class="text-muted"><i class="fa fa-plus"></i> 수정</span>
								</a>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
</div>

<div class="print-hide well text-center"> 
	결제, 배송 등과 관련된 문의는 <a href="<?php echo $at_href['secret'];?>"><b>1:1 문의</b></a>로 등록해 주세요.
</div>

<div class="print-hide qa-btn">
	<div class="qa-page pull-left">
		<ul class="pagination pagination-sm en">
			<?php echo apms_ajax_paging('itemqa', $write_pages, $page, $total_page, $list_page); ?>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="pull-right">
		<div class="btn-group">
			<button type="button" class="btn btn-<?php echo $btn2;?> btn-sm" onclick="apms_form('itemqa_form', '<?php echo $itemqa_form; ?>');">
				<i class="fa fa-pencil"></i> 문의쓰기<span class="sound_only"> 새 창</span>
			</button>
			<a class="btn btn-<?php echo $btn1;?> btn-sm" href="<?php echo $itemqa_list; ?>"><i class="fa fa-plus"></i> 더보기</a>
			<?php if($admin_href) { ?>
				<a class="btn btn-<?php echo $btn1;?> btn-sm" href="<?php echo $admin_href; ?>"><i class="fa fa-th-large"></i><span class="hidden-xs"> 관리</span></a>
			<?php } ?>
		</div>
		<div class="h30"></div>
	</div>
	<div class="clearfix"></div>
</div>

<script>
function more_iq(id) {
	$("#" + id).toggle();
}
</script>