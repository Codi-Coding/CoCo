<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<!-- end of body -->
<!-- tail -->
    </div>

    <div class="container">
      <footer>
        <div class="row">
          <div class="col-md-12">
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
            <!--<p class="footer-address"><?php echo $config['cf_title']?>, <?php echo $config2w_def['cf_site_addr']?>
              <br><?php echo $config2w_def['cf_site_owner']?>, <?php echo $config2w_def['cf_biz_num']?>, <?php echo $config2w_def['cf_tel']?>, <?php echo $config2w_def['cf_fax']?>, <?php echo $config2w_def['cf_email']?>
              <br><?php echo $config2w_def['cf_copyright']?>
            </p>-->
            <p class="footer-address">
              <?php echo $default['de_admin_company_addr']; ?>,
              <?php echo _t('전화'); ?>: <?php echo $default['de_admin_company_tel']; ?>,
              <?php echo _t('팩스'); ?>: <?php echo $default['de_admin_company_fax']; ?><!--,
              <?php echo _t('운영자'); ?>: <?php echo _t($admin['mb_name']); ?>--><br>
              <?php echo _t('사업자 등록번호'); ?>: <?php echo $default['de_admin_company_saupja_no']; ?>,
              <?php echo _t('대표'); ?>: <?php echo $default['de_admin_company_owner']; ?>,
              <?php echo _t('개인정보 보호책임자'); ?>: <?php echo $default['de_admin_info_name']; ?><br>
              <?php echo _t('통신판매업신고번호'); ?>: <?php echo $default['de_admin_tongsin_no']; ?>,
              <?php if ($default['de_admin_buga_no']) echo _t('부가통신사업신고번호').': '.$default['de_admin_buga_no'].''; ?><br>
              Copyright &copy; 2001-2013 <?php echo $default['de_admin_company_name']; ?>. <?php echo _t('All rights reserved.'); ?>
            </p>
            <?php } ?>
          </div>
        </div>
      </footer>
      <div class="row">
        <div class="col-md-8">
          <!--<p class="footer-address"><?php echo $config['cf_title']?>, <?php echo $config2w_def['cf_site_addr']?>
            <br><?php echo $config2w_def['cf_site_owner']?>, <?php echo $config2w_def['cf_biz_num']?>, <?php echo $config2w_def['cf_tel']?>, <?php echo $config2w_def['cf_fax']?>, <?php echo $config2w_def['cf_email']?>
            <br><?php echo $config2w_def['cf_copyright']?>
          </p>-->
          <p class="footer-address">
            <?php echo $default['de_admin_company_addr']; ?>,
            <?php echo _t('전화'); ?>: <?php echo $default['de_admin_company_tel']; ?>,
            <?php echo _t('팩스'); ?>: <?php echo $default['de_admin_company_fax']; ?><!--,
            <?php echo _t('운영자'); ?>: <?php echo $admin['mb_name']; ?>--><br>
            <?php echo _t('사업자 등록번호'); ?>: <?php echo $default['de_admin_company_saupja_no']; ?>,
            <?php echo _t('대표'); ?>: <?php echo $default['de_admin_company_owner']; ?>,
            <?php echo _t('개인정보 보호책임자'); ?>: <?php echo $default['de_admin_info_name']; ?><br>
            <?php echo _t('통신판매업신고번호'); ?>: <?php echo $default['de_admin_tongsin_no']; ?>,
            <?php if ($default['de_admin_buga_no']) echo _t('부가통신사업신고번호').': '.$default['de_admin_buga_no'].''; ?><br>
            Copyright &copy; 2001-2013 <?php echo $default['de_admin_company_name']; ?>. <?php echo _t('All rights reserved.'); ?>
          </p>
        </div>
        <div class="col-md-4">
        </div>
      </div>
    </div>
<!-- end of tail -->

<?php
echo ('<link rel="stylesheet" href="'.$g5['tmpl_url'].'/css/'.$boot_change.'.css" >');
include_once(G5_TMPL_PATH."/tail.sub.php");
?>
