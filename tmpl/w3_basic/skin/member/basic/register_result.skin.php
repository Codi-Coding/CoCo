<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원가입결과 시작 { -->
<div id="reg_result" class="mbskin">

    <p>
        <strong><?php echo get_text($mb['mb_name']); ?></strong><?php echo _t('님의 회원가입을 진심으로 축하합니다.'); ?><br>
    </p>

    <?php if ($config['cf_use_email_certify']) {  ?>
    <p>
        <?php echo _t('회원 가입 시 입력하신 이메일 주소로 인증메일이 발송되었습니다.').'<br>'.
        _t('발송된 인증메일을 확인하신 후 인증처리를 하시면 사이트를 원활하게 이용하실 수 있습니다.'); ?>
    </p>
    <div id="result_email">
        <span><?php echo _t('아이디'); ?></span>
        <strong><?php echo $mb['mb_id'] ?></strong><br>
        <span><?php echo _t('이메일 주소'); ?></span>
        <strong><?php echo $mb['mb_email'] ?></strong>
    </div>
    <p>
        <?php echo _t('이메일 주소를 잘못 입력하셨다면, 사이트 관리자에게 문의해주시기 바랍니다.'); ?>
    </p>
    <?php }  ?>

    <p>
        <?php echo _t('회원님의 비밀번호는 아무도 알 수 없는 암호화 코드로 저장되므로 안심하셔도 좋습니다.').'<br>'.
        _t('아이디, 비밀번호 분실시에는 회원가입시 입력하신 이메일 주소를 이용하여 찾을 수 있습니다.'); ?>
    </p>

    <p>
        <?php echo _t('회원 탈퇴는 언제든지 가능하며 일정기간이 지난 후, 회원님의 정보는 삭제하고 있습니다.').'<br>'.
        _t('감사합니다.'); ?>
    </p>

    <?php if($default['de_member_reg_coupon_use'] && get_session('ss_member_reg_coupon') == 1) { ?>
    <p id="result_coupon">
        <?php echo $mb['mb_name']; ?><?php echo _t('님께 주문시 사용하실 수 있는'); ?> <strong><?php echo display_price($default['de_member_reg_coupon_price']); ?> <?php echo _t('할인'); ?><?php echo ($default['de_member_reg_coupon_minimum'] ? '('._t('주문금액').' '.display_price($default['de_member_reg_coupon_minimum'])._t('이상').')' : ''); ?> <?php echo _t('쿠폰'); ?></strong><?php echo _t('이 발행됐습니다.'); ?><br>
        <?php echo _t('발행된 할인 쿠폰 내역은 마이페이지에서 확인하실 수 있습니다.'); ?>
    </p>
    <?php } ?>

    <div class="btn_confirm">
        <a href="<?php echo G5_URL ?>/" class="btn02"><?php echo _t('메인으로'); ?></a>
    </div>

</div>
<!-- } 회원가입결과 끝 -->
