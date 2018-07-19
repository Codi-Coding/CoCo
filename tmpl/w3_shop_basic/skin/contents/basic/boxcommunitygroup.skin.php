<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_CONTENTS_SKIN_URL.'/style.css">', 0);
?>

<!-- 컨텐츠몰 커뮤니티 시작 { -->
<aside id="scomm">
    <h2><?php echo _t('컨텐츠몰 커뮤니티'); ?></h2>

    <ul>

    <?php
    if($g5['is_db_trans'] && file_exists($g5['locale_path'].'/include/skin.contents.boxcommunitygroup.skin.inc.php')) {
        include_once $g5['locale_path'].'/include/skin.contents.boxcommunitygroup.skin.inc.php';
    } else {
        $hsql = " select bo_table, bo_subject from {$g5['board_table']} where gr_id = '{$box_gr_id}' and (bo_10 = '' or bo_10 = '{$g5['tmpl']}') order by bo_table ";
    }
    $hresult = sql_query($hsql);
    for ($i=0; $row=sql_fetch_array($hresult); $i++)
    {
        echo '<li><a href="'.G5_BBS_URL.'/board.php?bo_table='.$row['bo_table'].'">'._t($row['bo_subject']).'</a></li>'.PHP_EOL;
    }

    if ($i==0)
        echo '<li id="scomm_empty">'._t('커뮤니티 준비 중').'</li>'.PHP_EOL;
    ?>
    </ul>

</aside>
<!-- } 컨텐츠몰 커뮤니티 끝 -->
