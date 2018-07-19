<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$sct_sort_href = $_SERVER['SCRIPT_NAME'].'?';
if($ca_id)
    $sct_sort_href .= 'ca_id='.$ca_id;
else if($ev_id)
    $sct_sort_href .= 'ev_id='.$ev_id;
if($skin)
    $sct_sort_href .= '&amp;skin='.$skin;
$sct_sort_href .= '&amp;sort=';

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_CONTENTS_CSS_URL.'/style.css">', 0);
?>

<!-- 상품 정렬 선택 시작 { -->
<section id="sort_list">
    <h2 class="accessibility"><?php echo _t('상품 정렬'); ?></h2>

    <ul id="ssch_sort">
        <li class="sort_first"><a href="<?php echo $sct_sort_href; ?>it_sum_qty&amp;sortodr=desc" class="btn01"><?php echo _t('판매많은순'); ?></a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_price&amp;sortodr=asc" class="btn01"><?php echo _t('낮은가격순'); ?></a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_price&amp;sortodr=desc" class="btn01"><?php echo _t('높은가격순'); ?></a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_use_avg&amp;sortodr=desc" class="btn01"><?php echo _t('평점높은순'); ?></a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_use_cnt&amp;sortodr=desc" class="btn01"><?php echo _t('후기많은순'); ?></a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_update_time&amp;sortodr=desc" class="btn01"><?php echo _t('최근등록순'); ?></a></li>
    </ul>
</section>





<!-- } 상품 정렬 선택 끝 -->
