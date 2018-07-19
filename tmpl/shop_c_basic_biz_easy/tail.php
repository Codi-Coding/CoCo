<?php // 굿빌더 ?>
<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<?php if (!defined("_MAINPAGE_")) { ?>
<?php if (!defined("_SUBPAGE_")) { ?>
					</div><!-- div -->
				</div><!--  board -->
<?php } ?>
			</div><!--  content -->
			<?php if(!$g5['use_left_sidebox']) { ?>
			<?php if(!defined("_MODULE_")) { ?>
			<div class="sidebox">
                        <?
				echo outsearch("good_basic_no_top_pad");
                                include "$g5[tmpl_path]/subpage/sidebox.inc.html";
                                include "$g5[tmpl_path]/subpage/sidebox_consultcenter.inc.html";
                                include "$g5[tmpl_path]/subpage/sidebox_doc.inc.html";
                        ?>
			</div><!-- sidebox -->
			<?php } ?>
			<?php } /// if ?>
		</div><!-- mainpage/subpage -->
<?php } ?>
	</div><!-- body -->
	<div id="tail">
		<div class="content">
			<?php if(0) { ?>
			<p>
				<!--&copy; <?php echo $config2w_def['cf_copyright']?> <?php echo $config['cf_title']?> &nbsp;<b><?php echo _t('대표'); ?></b>: <?php echo $config2w_def['cf_site_owner']?> &nbsp;<b><?php echo _t('사업자 등록번호'); ?></b>: <?php echo $config2w_def['cf_biz_num']?> 
				<br>&nbsp;<b><?php echo _t('주소'); ?>:</b> <span> <?php echo $config2w_def['cf_site_addr']?></span>
				<br>&nbsp;<b><?php echo _t('전화'); ?>:</b> <span><?php echo $config2w_def['cf_tel']?></span>
				&nbsp;<b><?php echo _t('팩스'); ?>:</b> <span><?php echo $config2w_def['cf_fax']?></span>
				&nbsp;<b><?php echo _t('이메일'); ?>:</b> <span><?php echo $config2w_def['cf_email']?></span>-->
				<?php echo $config['cf_title']?>, <?php echo $config2w_def['cf_site_addr']?>, <?php echo $config2w_def['cf_tel']?>, <?php echo $config2w_def['cf_email']?><br>
				<?php echo $config2w_def['cf_copyright']?>
			</p>
			<?php } ?>
			<p>
				<span><?php echo $default['de_admin_company_addr']; ?></span>
				<span><b><?php echo _t('전화'); ?></b> <?php echo $default['de_admin_company_tel']; ?></span>
				<span><b><?php echo _t('팩스'); ?></b> <?php echo $default['de_admin_company_fax']; ?></span>
				<!--<span><b><?php echo _t('운영자'); ?></b> <?php echo _t($admin['mb_name']); ?></span>--><br>
				<span><b><?php echo _t('사업자 등록번호'); ?></b> <?php echo $default['de_admin_company_saupja_no']; ?></span>
				<span><b><?php echo _t('대표'); ?></b> <?php echo $default['de_admin_company_owner']; ?></span>
				<span><b><?php echo _t('개인정보 보호책임자'); ?></b> <?php echo $default['de_admin_info_name']; ?></span><br>
				<span><b><?php echo _t('통신판매업신고번호'); ?></b> <?php echo $default['de_admin_tongsin_no']; ?></span>
				<?php if ($default['de_admin_buga_no']) echo '<span><b>'._t('부가통신사업신고번호').'</b> '.$default['de_admin_buga_no'].'</span>'; ?><br>
				Copyright &copy; 2001-2013 <?php echo $default['de_admin_company_name']; ?>. <?php echo _t('All rights reserved.'); ?>
			</p>
			<ul>
				<li>
					<a href="<?php echo $g5['url']?>/etc/agree.php"><?php echo _t('서비스이용약관'); ?></a>
				</li>
				<li>
					<a href="<?php echo $g5['url']?>/etc/priv.php"><?php echo _t('개인정보처리방침'); ?></a>
				</li>
			</ul>
		</div>
		<br>
		<?php
		if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
		<a href="<?php echo get_device_change_url(); ?>" id="device_change"><?php echo _t('모바일 버전으로 보기'); ?></a>
		<?php
		}
		?>

		<?php if(defined('POWERED_BY') && POWERED_BY) { ?>
		<div id="powered_by">
		Powered by <a href="<?php echo BUILDER_HOME?>" target="_blank">Goodbuilder</a> 
		    <?php if(defined('DESIGNED_BY') && DESIGNED_BY) { ?>
			/ Designed by <a href="<?php echo BUILDER_HOME?>" target="_blank">Goodbuilder</a>
		    <?php } ?>
		</div>
		<?php } ?>

		<?php
		if ($config['cf_analytics']) {
		    echo $config['cf_analytics'];
		}
		?>
	</div>
<?
include_once(G5_TMPL_PATH."/tail.sub.php");
?>
