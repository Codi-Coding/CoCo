<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<section id="sod_frm_pay" style="margin-bottom:0px;">
	<div class="panel panel-default">
		<div class="panel-heading"><strong><i class="fa fa-user fa-lg"></i> 개인결제정보</strong></div>
		<div class="panel-body">
            <?php if(trim($pp['pp_content'])) { ?>
				<div class="form-group">
					<label class="col-sm-2 control-label hidden-xs"><b>상세내용</b></label>
					<div class="col-sm-8">
						<div class="well" style="margin-bottom:0px;"><?php echo conv_content($pp['pp_content'], 0); ?></div>
					</div>
				</div>
			<?php } ?>
			<div class="form-group">
				<label class="col-sm-2 control-label"><b>결제금액</b></label>
				<label class="col-sm-4 control-label" style="text-align:left;">
					<b><?php echo display_price($pp['pp_price']); ?></b>
				</label>
			</div>
			<div class="form-group has-feedback">
				<label class="col-sm-2 control-label" for="pp_name"><b>이름</b><strong class="sound_only">필수</strong></label>
				<div class="col-sm-4">
					<input type="text" name="pp_name" value="<?php echo $pp['pp_name']; ?>" id="pp_name" required class="form-control input-sm">
					<span class="fa fa-check form-control-feedback"></span>
				</div>
			</div>
			<div class="form-group has-feedback">
				<label class="col-sm-2 control-label" for="pp_email"><b>이메일</b><strong class="sound_only">필수</strong></label>
				<div class="col-sm-4">
					<input type="text" name="pp_email" value="<?php echo $member['mb_email']; ?>" id="pp_email" required class="form-control input-sm">
					<span class="fa fa-envelope form-control-feedback"></span>
				</div>
			</div>
			<div class="form-group has-feedback">
				<label class="col-sm-2 control-label" for="pp_hp"><b>휴대폰</b></label>
				<div class="col-sm-4">
					<input type="text" name="pp_hp" value="<?php echo $member['mb_hp']; ?>" id="pp_hp" class="form-control input-sm">
					<span class="fa fa-phone form-control-feedback"></span>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label"><b>결제방법</b></label>
				<div class="col-sm-9 radio-line">
					<?php if($is_none) { ?>
						<label class="control-label"><b>결제할 방법이 없습니다.</b> 운영자에게 알려주시면 감사하겠습니다.</label>
					<?php } else { ?>
						<?php if($is_vbank) { ?>
							<label><input type="radio" id="pp_settle_vbank" name="pp_settle_case" value="가상계좌"> <?php echo $escrow_title;?>가상계좌</label><?php } ?>

						<?php if($is_iche) { ?>
							<label><input type="radio" id="pp_settle_iche" name="pp_settle_case" value="계좌이체"> <?php echo $escrow_title;?>계좌이체</label>
						<?php } ?>

						<?php if($is_hp) { ?>
							<label><input type="radio" id="pp_settle_hp" name="pp_settle_case" value="휴대폰"> 휴대폰</label>
						<?php } ?>

						<?php if($is_card) { ?>
							<label><input type="radio" id="pp_settle_card" name="pp_settle_case" value="신용카드"> 신용카드</label>
						<?php } ?>
					<?php } ?>
				</div>
			</div>

		</div>
	</div>
</section>
