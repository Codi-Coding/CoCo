<?php // 굿빌더 ?>
<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

$q = $GLOBALS['q'];
?>
<link rel="stylesheet" href="<?php echo $outsearch_skin_url ?>/style.css">

<section id="sch_all_aside">
    <div>
        <fieldset>
        <legend><?php echo _t('상품 검색'); ?></legend>
        <form name="fsearchbox" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">
        <label for="sch_all_aside_stx" class="sound_only"><?php echo _t('검색어'); ?><strong class="sound_only"> <?php echo _t('필수'); ?></strong></label>
        <input type="text" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_all_aside_stx" required>
        <input type="submit" value="<?php echo _t('검색'); ?>" id="sch_all_aside_submit">
        </form>
        <script>
        function search_submit(f) {
            if (f.q.value.length < 2) {
                alert("<?php echo _t('검색어는 두글자 이상 입력하십시오.'); ?>");
                f.q.select();
                f.q.focus();
                return false;
            }

            return true;
        }
        </script>
        </fieldset>
    </div>
</section>
