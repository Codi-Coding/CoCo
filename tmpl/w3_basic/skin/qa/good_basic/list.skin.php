<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>

<h2 id="container_title"><?php echo $qaconfig['qa_title'] ?><span class="sound_only"> <?php echo _t('목록'); ?></span></h2><!-- w3 -->

<div id="bo_list">
    <?php if ($category_option) { ?>
    <!-- 카테고리 시작 { -->
    <nav id="bo_cate">
        <h2><?php echo $qaconfig['qa_title'] ?> <?php echo _t('카테고리'); ?></h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <!-- } 카테고리 끝 -->
    <?php } ?>

     <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div class="bo_fx">
        <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?> <?php echo _t('건'); ?></span>
            <?php echo $page ?> <?php echo _t('페이지'); ?>
        </div>

        <?php if ($admin_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin"><?php echo _t('관리자'); ?></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02"><?php echo _t('문의등록'); ?></a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <form name="fqalist" id="fqalist" action="./qadelete.php" onsubmit="return fqalist_submit(this);" method="post">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="sca" value="<?php echo $sca; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption><?php echo $board['bo_subject'] ?> <?php echo _t('목록'); ?></caption>
        <thead>
        <tr>
            <th scope="col"><?php echo _t('번호'); ?></th>
            <?php if ($is_checkbox) { ?>
            <th scope="col">
                <label for="chkall" class="sound_only"><?php echo _t('현재 페이지 게시물 전체'); ?></label>
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            </th>
            <?php } ?>
            <th scope="col"><?php echo _t('분류'); ?></th>
            <th scope="col"><?php echo _t('제목'); ?></th>
            <th scope="col"><?php echo _t('글쓴이'); ?></th>
            <th scope="col"><?php echo _t('상태'); ?></th>
            <th scope="col"><?php echo _t('등록일'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $i<count($list); $i++) {
        ?>
        <tr>
            <td class="td_num"><?php echo $list[$i]['num']; ?></td>
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
                <label for="chk_qa_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject']; ?></label>
                <input type="checkbox" name="chk_qa_id[]" value="<?php echo $list[$i]['qa_id'] ?>" id="chk_qa_id_<?php echo $i ?>">
            </td>
            <?php } ?>
            <td class="td_category"><?php echo $list[$i]['category']; ?></td>
            <td class="td_subject">
                <a href="<?php echo $list[$i]['view_href']; ?>">
                    <?php echo $list[$i]['subject']; ?>
                </a>
                <?php echo $list[$i]['icon_file']; ?>
            </td>
            <td class="td_name"><?php echo $list[$i]['name']; ?></td>
            <td class="td_stat <?php echo ($list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($list[$i]['qa_status'] ? _t('답변완료') : _t('답변대기')); ?></td>
            <td class="td_date"><?php echo $list[$i]['date']; ?></td>
        </tr>
        <?php
        }
        ?>

        <?php if ($i == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">'._t('게시물이 없습니다.').'</td></tr>'; } ?>
        </tbody>
        </table>
    </div>

    <div class="bo_fx">
        <?php if ($is_checkbox) { ?>
        <ul class="btn_bo_adm">
            <li><input type="submit" name="btn_submit" value="<?php echo _t('선택삭제'); ?>" onclick="document.pressed=this.value"></li>
        </ul>
        <?php } ?>

        <ul class="btn_bo_user">
            <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn_b01"><?php echo _t('목록'); ?></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02"><?php echo _t('문의등록'); ?></a></li><?php } ?>
        </ul>
    </div>
    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p><?php echo _t('자바스크립트를 사용하지 않는 경우').'<br>'._t('별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.'); ?></p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $list_pages;  ?>

<!-- 게시판 검색 시작 { -->
<fieldset id="bo_sch">
    <legend><?php echo _t('게시물 검색'); ?></legend>

    <form name="fsearch" method="get">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <label for="stx" class="sound_only"><?php echo _t('검색어'); ?><strong class="sound_only"> <?php echo _t('필수'); ?></strong></label>
    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" required  class="frm_input required" size="15" maxlength="15">
    <input type="submit" value="<?php echo _t('검색'); ?>" class="btn_submit">
    </form>
</fieldset>
<!-- } 게시판 검색 끝 -->

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}

function fqalist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "<?php echo _t('할 게시물을 하나 이상 선택하세요.'); ?>");
        return false;
    }

    if(document.pressed == "<?php echo _t('선택삭제'); ?>") {
        if (!confirm("<?php echo _t('선택한 게시물을 정말 삭제하시겠습니까?').'\n\n'._t('한번 삭제한 자료는 복구할 수 없습니다'); ?>"))
            return false;
    }

    return true;
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
