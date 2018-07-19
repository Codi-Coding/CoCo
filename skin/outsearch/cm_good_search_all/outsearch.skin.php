<?php // 굿빌더 ?>
<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

$q_string = $GLOBALS['q_string'];
$q        = $GLOBALS['q'];
$stx      = $GLOBALS['stx'];

if($q) $q_string = $q;
else if($stx) $q_string = $stx;

$sfl = $GLOBALS['sfl'];
$bbs_search = $GLOBALS['bbs_search'];
?>
<link rel="stylesheet" href="<?php echo $outsearch_skin_url ?>/style.css">

<section id="sch_all_aside">
    <div>
        <fieldset>
        <legend><?php echo _t('전체 검색'); ?></legend>
        <form name="fsearchbox" action="<?php echo G5_BBS_URL; ?>/cm_search_all.php" onsubmit="return search_submit(this);">
	<input type=radio name=bbs_search value=0<?php if(!$bbs_search && !$sfl) echo ' checked'; else echo ''; ?>><?php echo _t('컨텐츠'); ?>
	<input type=radio name=bbs_search value=1<?php if($bbs_search || $sfl) echo ' checked'; else echo ''; ?>><?php echo _t('게시판'); ?>
        <br/>
        <label for="sch_all_aside_stx" class="sound_only"><?php echo _t('검색어'); ?><strong class="sound_only"> <?php echo _t('필수'); ?></strong></label>
        <input type="text" name="q_string" value="<?php echo stripslashes(get_text(get_search_string($q_string))); ?>" id="sch_all_aside_stx" required>
        <input type="submit" value="<?php echo _t('검색'); ?>" id="sch_all_aside_submit">
        </form>
        <script>
        function search_submit(f) {
            if (f.q_string.value.length < 2) {
                alert("<?php echo _t('검색어는 두글자 이상 입력하십시오.'); ?>");
                f.q_string.select();
                f.q_string.focus();
                return false;
            }

            return true;
        }
        </script>
        </fieldset>
    </div>
</section>
