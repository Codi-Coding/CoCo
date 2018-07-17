<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

</form><?php // 결제폼 닫기 - 삭제하면 안됨 ?>

<br>

<?php if ($escrow_info) { ?>
	<div class="well">
		<?php echo $escrow_info;?>
	</div>
<?php } ?>

<?php if($setup_href) { ?>
	<p class="text-center">
		<a class="btn btn-color btn-sm win_memo" href="<?php echo $setup_href;?>">
			<i class="fa fa-cogs"></i> 스킨설정
		</a>
	</p>
<?php } ?>

<script>
$(function() {
	// BS3
	$("#display_pay_button input").removeClass("btn_submit");
	$("#display_pay_button input").addClass("btn btn-color btn-lg");
	$("#display_pay_button a").removeClass("btn01");
	$("#display_pay_button a").removeClass("btn_cancel");
	$("#display_pay_button a").addClass("btn btn-black btn-lg");
});
</script>