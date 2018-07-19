<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_CONTENTS_SKIN_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 상품 사용후기 시작 { -->
<section id="cit_use_list">
    <h3><?php echo _t('등록된 사용후기'); ?></h3>

    <?php
    $thumbnail_width = 500;

    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $is_num     = $total_count - ($page - 1) * $rows - $i;
        $is_star    = cm_get_star($row['is_score']);
        $is_name    = get_text($row['is_name']);
        $is_subject = conv_subject($row['is_subject'],50,"…");
        $is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);
        $is_time    = substr($row['is_time'], 2, 8);
        $is_href    = './itemuselist.php?bo_table=itemuse&amp;wr_id='.$row['wr_id'];

        $hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);

        if ($i == 0) echo '<ol id="cit_use_ol" class="cit_ol">';
    ?>

        <li class="cit_use_li">
            <button type="button" class="sit_use_li_title"><b><?php echo $is_num; ?>.</b> <?php echo $is_subject; ?></button>
            <dl class="cit_use_dl">
                <dt><?php echo _t('작성자'); ?></dt>
                <dd><?php echo $is_name; ?></dd>
                <dt><?php echo _t('작성일'); ?></dt>
                <dd><?php echo $is_time; ?></dd>
                <dt><?php echo _t('평점'); ?><dt>
                <dd class="cit_use_star"><img src="<?php echo G5_CONTENTS_URL; ?>/img/s_star<?php echo $is_star; ?>.png" alt="<?php echo _t('별'); ?><?php echo $is_star; ?><?php echo _t('개'); ?>"></dd>
            </dl>

            <div id="cit_use_con_<?php echo $i; ?>" class="sit_use_con">
                <div class="cit_use_p">
                    <?php echo $is_content; // 사용후기 내용 ?>
                </div>

                <?php if ($is_admin || $row['mb_id'] == $member['mb_id']) { ?>
                <div class="cit_use_cmd">
                    <a href="<?php echo $itemuse_form."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="itemuse_form btn01" onclick="return false;"><?php echo _t('수정'); ?></a>
                    <a href="<?php echo $itemuse_formupdate."&amp;is_id={$row['is_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemuse_delete btn01"><?php echo _t('삭제'); ?></a>
                </div>
                <?php } ?>
            </div>
        </li>

    <?php }

    if ($i > 0) echo '</ol>';

    if (!$i) echo '<p class="cit_empty">'._t('사용후기가 없습니다.').'</p>';
    ?>
</section>

<?php
echo itemuse_page($config['cf_write_pages'], $page, $total_page, "./itemuse.php?it_id=$it_id&amp;page=", "");
?>

<div id="cit_use_wbtn" class="cit_wbtn">
    <a href="<?php echo $itemuse_form; ?>" class="btn02 itemuse_form"><?php echo _t('사용후기 쓰기'); ?><span class="sound_only"> <?php echo _t('새 창') ;?></span></a>
    <a href="<?php echo $itemuse_list; ?>" class="btn01 itemuse_list"><?php echo _t('더보기'); ?></a>
</div>

<script>
$(function(){
    $(".itemuse_form").click(function(){
        window.open(this.href, "itemuse_form", "width=810,height=680,scrollbars=1");
        return false;
    });

    $(".itemuse_delete").click(function(){
        if (confirm("<?php echo _t('정말 삭제 하시겠습니까?').'\n\n'._t('삭제후에는 되돌릴수 없습니다.'); ?>")) {
            return true;
        } else {
            return false;
        }
    });

    $(".sit_use_li_title").click(function(){
        var $con = $(this).siblings(".sit_use_con");
        if($con.is(":visible")) {
            $con.slideUp();
        } else {
            $(".sit_use_con:visible").hide();
            $con.slideDown(
                function() {
                    // 이미지 리사이즈
                    $con.viewimageresize2();
                }
            );
        }
    });

    $(".pg_page").click(function(){
        $("#itemuse").load($(this).attr("href"));
        return false;
    });

    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });
});
</script>
<!-- } 상품 사용후기 끝 -->
