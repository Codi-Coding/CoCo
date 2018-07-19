<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;
$colspan2 = 5;

if ($is_checkbox) { $colspan++; $colspan2++; }
if ($is_good) { $colspan++; $colspan2++; }
if ($is_nogood) { $colspan++; $colspan2++; }

$content_len = 160;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<?php if (!$wr_id) { ?><h1 id="bo_list_title"><?php echo _t($board['bo_subject']) ?></h1><?php } ?>

<!-- 게시판 목록 시작 -->
<div id="bo_list" style="width:<?php echo $width; ?>">

    <?php if ($is_category) { ?>
    <form name="fcategory" id="fcategory" method="get">
    <nav id="bo_cate">
        <h2><?php echo _t($board['bo_subject']) ?> <?php echo _t('카테고리'); ?></h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    </form>
    <?php } ?>

    <div class="bo_fx">
        <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?> <?php echo _t('건'); ?></span>
            <?php echo $page ?> <?php echo _t('페이지'); ?>
        </div>

        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01"><?php echo _t('RSS'); ?></a></li><?php } ?>
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin"><?php echo _t('관리자'); ?></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02"><?php echo _t('글쓰기'); ?></a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <table class="basic_tbl">
    <caption><?php echo _t($board['bo_subject']) ?> <?php echo _t('목록'); ?></caption>
    <thead>
    <tr>
        <th scope="col"></th>
        <th scope="col" class="th2" colspan=<?php echo $colspan2 ?>>
        <?php if ($is_checkbox) { ?>
            <span style="float:left;padding:0 10px 0 10px">
            <label for="chkall" class="sound_only"><?php echo _t('현재 페이지 게시물 전체'); ?></label>
            <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            </span>
        <?php } ?>
        <?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?><?php echo _t('날짜순'); ?></a>
        | <?php echo subject_sort_link('wr_hit', $qstr2, 1) ?><?php echo _t('조회순'); ?></a>
        <?php if ($is_good) { ?> | <?php echo subject_sort_link('wr_good', $qstr2, 1) ?><?php echo _t('추천순'); ?></a><?php } ?>
        <?php if ($is_nogood) { ?> | <?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?><?php echo _t('비추천순'); ?></a><?php } ?>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $i<count($list); $i++) {
     ?>
    <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?><?php if ($board[1]) echo "bo_sideview"; ?>">
        <td width="<?php echo $board['bo_gallery_width'] ?>">
            <a href="<?php echo $list[$i]['href'] ?>">
            <?php
            if ($list[$i]['is_notice']) { // 공지사항  ?>
                <strong style="width:<?php echo $board['bo_gallery_width'] ?>px;height:<?php echo $board['bo_gallery_height'] ?>px"><?php echo _t('공지'); ?></strong>
            <?php } else {
                $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height']);

                if($thumb['src']) {
                    $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'">';
                } else {
                    $img_content = '<span style="width:'.$board['bo_gallery_width'].'px;height:'.$board['bo_gallery_height'].'px">no image</span>';
                }

                echo $img_content;
            }
            ?>
            </a>
        </td>
        <td class="td_subject" colspan=<?php echo $colspan2; ?> valign="top">
            <p class="p1">
            <span style="float:left;padding:0 10px 0 10px">
            <?php
            if ($list[$i]['is_notice']) // 공지사항
                echo '<strong>'._t('공지').'</strong>';
            else if ($wr_id == $list[$i]['wr_id'])
                echo "<span class=\"bo_current\">"._t('열람중')."</span>";
            else
                echo $list[$i]['num'];
             ?>
            </span>
            <?php if ($is_checkbox) { ?>
            <span style="float:left;padding:0 10px 0 0">
                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            </span>
            <?php } ?>
            <span style="float:left">
            <?php
            echo $list[$i]['icon_reply'];
            if ($is_category && $list[$i]['ca_name']) {
             ?>
            <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
            <?php } ?>

            <a href="<?php echo $list[$i]['href'] ?>">
                <?php echo $list[$i]['subject'] ?>
                <?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only"><?php echo _t('댓글'); ?></span><?php echo $list[$i]['comment_cnt']; ?><span class="sound_only"><?php echo _t('개'); ?></span><?php } ?>
            </a>

            <?php
            // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
            // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

            if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
            if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
            if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
            if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
            if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];

            ?>
            </span>
            </p>
            <p class="p1a">
            <?php
            $mb_icon_path  = G5_DATA_PATH.'/member/'.substr($list[$i]['mb_id'],0,2).'/'.$list[$i]['mb_id'].'.gif';
            if ($config['cf_use_member_icon'] and file_exists($mb_icon_path)) {
                $mb_icon_url  = G5_DATA_URL.'/member/'.substr($list[$i]['mb_id'],0,2).'/'.$list[$i]['mb_id'].'.gif';
                echo '<img src="'.$mb_icon_url.'" alt="">';
            }
            ?>
            <?php echo $list[$i]['name'] ?>
            | <?php echo $list[$i]['datetime2'] ?>
            | <?php echo _t('조회'); ?>: <?php echo "<b>".$list[$i]['wr_hit']."</b>" ?>
            <?php if ($is_good) { ?><?php echo _t('추천'); ?>: <?php echo "<b>".$list[$i]['wr_good']."</b>" ?><?php } ?>
            <?php if ($is_nogood) { ?><?php echo _t('비추천'); ?>: <?php echo "<b>".$list[$i]['wr_nogood']."</b>" ?><?php } ?>
            </p>
            <p class="p2">
            <a href="<?php echo $list[$i]['href']?>">
            <?php echo mb_substr(strip_tags($list[$i]['content']), 0, $content_len, 'utf-8'); ?>
            <?php if(mb_strlen(strip_tags($list[$i]['content']), 'utf-8') > $content_len) echo " ....."; ?>
            </a>
            </p>
        </td>
    </tr>
    <?php } ?>
    <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">'._t('게시물이 없습니다.').'</td></tr>'; } ?>
    </tbody>
    </table>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <ul class="btn_bo_adm">
            <?php if ($list_href) { ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b01"> <?php echo _t('목록'); ?></a></li>
            <?php } ?>
            <?php if ($is_checkbox) { ?>
            <li><input type="submit" name="btn_submit" value="<?php echo _t('선택삭제'); ?>" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="<?php echo _t('선택복사'); ?>" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="<?php echo _t('선택이동'); ?>" onclick="document.pressed=this.value"></li>
            <?php } ?>
        </ul>

        <ul class="btn_bo_user">
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02"><?php echo _t('글쓰기'); ?></a></li><?php } ?>
        </ul>
    </div>
    <?php } ?>
    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p><?php echo _t('자바스크립트를 사용하지 않는 경우').'<br>'._t('별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.'); ?></p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $write_pages;  ?>

<fieldset id="bo_sch">
    <legend><?php echo _t('게시물 검색'); ?></legend>

    <form name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only"><?php echo _t('검색대상'); ?></label>
    <select name="sfl" id="sfl">
        <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>><?php echo _t('제목'); ?></option>
        <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>><?php echo _t('내용'); ?></option>
        <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>><?php echo _t('제목+내용'); ?></option>
        <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>><?php echo _t('회원아이디'); ?></option>
        <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>><?php echo _t('회원아이디(코)'); ?></option>
        <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>><?php echo _t('글쓴이'); ?></option>
        <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>><?php echo _t('글쓴이(코)'); ?></option>
    </select>
    <label for="stx" class="sound_only"><?php echo _t('검색어'); ?><strong class="sound_only"> <?php echo _t('필수'); ?></strong></label>
    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required  class="frm_input required" size="15" maxlength="20">
    <input type="submit" value="<?php echo _t('검색'); ?>" class="btn_submit">
    </form>
</fieldset>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "<?php echo _t('할 게시물을 하나 이상 선택하세요.'); ?>");
        return false;
    }

    if(document.pressed == "<?php echo _t('선택복사'); ?>") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "<?php echo _t('선택이동'); ?>") {
        select_copy("move");
        return;
    }

    if(document.pressed == "<?php echo _t('선택삭제'); ?>") {
        if (!confirm("<?php echo _t('선택한 게시물을 정말 삭제하시겠습니까?').'\n\n'._t('한번 삭제한 자료는 복구할 수 없습니다'); ?>"))
            return false;
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "<?php echo _t('복사'); ?>";
    else
        str = "<?php echo _t('이동'); ?>";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- 게시판 목록 끝 -->
