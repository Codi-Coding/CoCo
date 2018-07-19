<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_CONTENTS_CSS_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 상품 정보 시작 { -->
<?php echo pg_anchor('inf'); ?>
<section id="cit_inf" class="cit_if">
    <h2><?php echo _t('상품 정보'); ?></h2>

    <?php if ($it['it_basic']) { // 상품 기본설명 ?>
    <h3><?php echo _t('상품 기본설명'); ?></h3>
    <div id="cit_inf_basic">
         <?php echo _t($it['it_basic']); ?>
    </div>
    <?php } ?>

    <?php if ($it['it_explan']) { // 상품 상세설명 ?>
    <h3><?php echo _t('상품 상세설명') ;?></h3>
    <div id="cit_inf_explan">
        <?php echo conv_content(_t($it['it_explan']), 1); ?>
    </div>
    <?php } ?>
</section>
<!-- } 상품 정보 끝 -->

<!-- 사용후기 시작 { -->
<?php echo pg_anchor('use'); ?>
<section id="cit_use" class="cit_if">
    <h2><?php echo _t('사용후기'); ?></h2>

    <div id="itemuse"><?php include_once(G5_CONTENTS_PATH.'/itemuse.php'); ?></div>
</section>
<!-- } 사용후기 끝 -->

<!-- 상품문의 시작 { -->
<?php echo pg_anchor('qa'); ?>

<section id="cit_qa" class="cit_if">
    <h2><?php echo _t('상품문의'); ?></h2>

    <div id="itemqa"><?php include_once(G5_CONTENTS_PATH.'/itemqa.php'); ?></div>
</section>
<!-- } 상품문의 끝 -->

<?php if ($setting['de_rel_list_use']) { ?>

<!-- 관련상품 시작 { -->
<?php echo pg_anchor('rel'); ?>
<section id="cit_rel" class="cit_if">
    <h2><?php echo _t('관련상품'); ?></h2>

    <div class="cct_wrap">
        <?php
        $rel_skin_file = $skin_dir.'/'.$setting['de_rel_list_skin'];
        if(!is_file($rel_skin_file))
            $rel_skin_file = G5_CONTENTS_SKIN_PATH.'/'.$setting['de_rel_list_skin'];

        $sql = " select b.* from {$g5['g5_contents_item_relation_table']} a left join {$g5['g5_contents_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it['it_id']}' and b.it_use='1' ";
        $list = new cm_item_list($rel_skin_file, $setting['de_rel_list_mod'], 0, $setting['de_rel_img_width'], $setting['de_rel_img_height']);
        $list->set_query($sql);
        $list->set_view('it_price', ture);
        $list->set_view('it_sum_qty', true);
        $list->set_view('it_wish_qty', true);
        echo $list->run();
        ?>
    </div>
</section>
<!-- } 관련상품 끝 -->
<?php } ?>

<script>
$(window).on("load", function() {
    $("#cit_inf_explan").viewimageresize2();
});
</script>
