<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$nick = get_sideview($mb['mb_id'], $mb['mb_nick'], $mb['mb_email'], $mb['mb_homepage']);
if($kind == "recv") {
    $kind_str = _t("보낸");
    $kind_date = _t("받은");
}
else {
    $kind_str = _t("받는");
    $kind_date = _t("보낸");
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div id="memo_view" class="new_win mbskin">
    <h1 id="win_title"><?php echo $g5['title'] ?></h1>

    <ul class="win_ul">
        <li><a href="./memo.php?kind=recv"><?php echo _t('받은쪽지'); ?></a></li>
        <li><a href="./memo.php?kind=send"><?php echo _t('보낸쪽지'); ?></a></li>
        <li><a href="./memo_form.php"><?php echo _t('쪽지쓰기'); ?></a></li>
    </ul>

    <article id="memo_view_contents">
        <header>
            <h1><?php echo _t('쪽지 내용'); ?></h1>
        </header>
        <ul id="memo_view_ul">
            <li class="memo_view_li">
                <span class="memo_view_subj"><?php echo $kind_str ?><?php echo _t('사람'); ?></span>
                <strong><?php echo $nick ?></strong>
            </li>
            <li class="memo_view_li">
                <span class="memo_view_subj"><?php echo $kind_date ?><?php echo _t('시간'); ?></span>
                <strong><?php echo $memo['me_send_datetime'] ?></strong>
            </li>
        </ul>
        <p>
            <?php echo conv_content($memo['me_memo'], 0) ?>
        </p>
    </article>

    <div class="win_btn">
        <?php if($prev_link) { ?>
        <a href="<?php echo $prev_link ?>"><?php echo _t('이전쪽지'); ?></a>
        <?php } ?>
        <?php if($next_link) { ?>
        <a href="<?php echo $next_link ?>"><?php echo _t('다음쪽지'); ?></a>
        <?php } ?>
        <?php if ($kind == 'recv') { ?><a href="./memo_form.php?me_recv_mb_id=<?php echo $mb['mb_id'] ?>&amp;me_id=<?php echo $memo['me_id'] ?>" class="btn01"><?php echo _t('답장'); ?></a><?php } ?>
        <a href="<?php echo $list_link ?>"><?php echo _t('목록보기'); ?></a>
        <button type="button" onclick="window.close();"><?php echo _t('창닫기'); ?></button>
    </div>
</div>
