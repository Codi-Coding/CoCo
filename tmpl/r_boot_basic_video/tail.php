<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<!-- end of body -->
<!-- tail -->
    </div>

    <div class="container">
      <footer>
        <div class="row">
          <div class="col-lg-12">
            <ul class="list-unstyled footer-ul">
              <li class="pull-right footer-li"><a href="#top"><?php echo _t('맨 위로'); ?></a></li>
              <li class="footer-li"><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company"><?php echo _t('회사소개'); ?></a></li>
              <li class="footer-li"><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy"><?php echo _t('개인정보처리방침'); ?></a></li>
              <li class="footer-li"><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision"><?php echo _t('서비스이용약관'); ?></a></li>
            </ul>
            <?php if(defined('POWERED_BY') && POWERED_BY) { ?>
            <span id="powered_by">
                Powered by <a href="<?php echo BUILDER_HOME?>" target="_blank">Goodbuilder</a> 
                <?php if(defined('DESIGNED_BY') && DESIGNED_BY) { ?>
                / Designed by <a href="<?php echo BUILDER_HOME?>" target="_blank">Goodbuilder</a>
                <?php } ?>
            </span>
            <?php } ?>
            <?php if(0) { ?>
            <p class="footer-address"><?php echo $config['cf_title']?>, <?php echo $config2w_def['cf_site_addr']?>
              <br><?php echo $config2w_def['cf_site_owner']?>, <?php echo $config2w_def['cf_biz_num']?>, <?php echo $config2w_def['cf_tel']?>, <?php echo $config2w_def['cf_fax']?>, <?php echo $config2w_def['cf_email']?>
              <br><?php echo $config2w_def['cf_copyright']?>
            </p>
            <?php } ?>
          </div>
        </div>
      </footer>
      <div class="row">
        <div class="col-md-8">
          <p class="footer-address"><?php echo $config['cf_title']?>, <?php echo $config2w_def['cf_site_addr']?>
            <br><?php echo $config2w_def['cf_site_owner']?>, <?php echo $config2w_def['cf_biz_num']?>, <?php echo $config2w_def['cf_tel']?>, <?php echo $config2w_def['cf_fax']?>, <?php echo $config2w_def['cf_email']?>
            <br><?php echo $config2w_def['cf_copyright']?>
          </p>
        </div>
        <div class="col-md-4">
        </div>
      </div>
    </div>
<!-- end of tail -->

<?php
include_once(G5_TMPL_PATH."/tail.sub.php");
?>
