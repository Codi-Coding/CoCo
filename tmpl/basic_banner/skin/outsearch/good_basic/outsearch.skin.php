<?php // 굿빌더 ?>
<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

$stx = $GLOBALS['stx'];
?>
<link rel="stylesheet" href="<?php echo $outsearch_skin_url ?>/style.css">

<section id="sch_all_aside">
    <div>
        <fieldset>
        <legend><?php echo _t('사이트 내 전체검색'); ?></legend>
        <form name="fsearchbox" method="get" onsubmit="return fsearchbox_submit(this);">
        <input type="hidden" name="sfl" value="wr_subject||wr_content">
        <input type="hidden" name="sop" value="and">
        <label for="sch_all_aside_stx" class="sound_only"><?php echo _t('검색어'); ?><strong class="sound_only"> <?php echo _t('필수'); ?></strong></label>
        <input id="sch_all_aside_stx"  name="stx" value="<?php echo stripslashes(get_text(get_search_string($stx))); ?>" type="text" maxlength=20 onclick="javascript:this.focus();">
        <input type="submit" id="sch_all_aside_submit" value="<?php echo _t('검색'); ?>">
        </form>
        </fieldset>
    </div>
</section>

<script language="JavaScript">
function fsearchbox_submit(f)
{
    if (f.stx.value.length < 2) {
        alert("<?php echo _t('검색어는 두글자 이상 입력하십시오.'); ?>");
       	f.stx.select();
        f.stx.focus();
        return false;
   	}

  	// 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
    var cnt = 0;
    for (var i=0; i<f.stx.value.length; i++) {
        if (f.stx.value.charAt(i) == ' ')
       	cnt++;
   	}

    if (cnt > 1) {
        alert("<?php echo _t('빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.'); ?>");
       	f.stx.select();
	f.stx.focus();
       	return false;
    }

    f.action = "<?php echo G5_BBS_URL ?>/search.php";
    return true;
}
</script>
