<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 쪽지 목록 시작 { -->
<div id="memo_list" class="new_win mbskin">
    <h1 id="win_title"><?php echo $g5['title'] ?></h1>

    <ul class="win_ul">
        <li><a href="./memo.php?kind=recv"><?php echo _t('받은쪽지'); ?></a></li>
        <li><a href="./memo.php?kind=send"><?php echo _t('보낸쪽지'); ?></a></li>
        <li><a href="./memo_form.php"><?php echo _t('쪽지쓰기'); ?></a></li>
    </ul>

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption>
            <?php echo _t('전체'); ?> <?php echo $kind_title ?><?php echo _t('쪽지'); ?> <?php echo $total_count ?> <?php echo _t('통'); ?><br>
        </caption>
        <thead>
        <tr>
            <th scope="col"><?php echo  ($kind == "recv") ? _t("보낸사람") : _t("받는사람");  ?></th>
            <th scope="col"><?php echo _t('보낸시간'); ?></th>
            <th scope="col"><?php echo _t('읽은시간'); ?></th>
            <th scope="col"><?php echo _t('관리'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i=0; $i<count($list); $i++) {  ?>
        <tr>
            <td><?php echo $list[$i]['name'] ?></td>
            <td class="td_datetime"><a href="<?php echo $list[$i]['view_href'] ?>"><?php echo $list[$i]['send_datetime'] ?></a></td>
            <td class="td_datetime"><a href="<?php echo $list[$i]['view_href'] ?>"><?php echo $list[$i]['read_datetime'] ?></a></td>
            <td class="td_mng"><a href="<?php echo $list[$i]['del_href'] ?>" onclick="del(this.href); return false;"><?php echo _t('삭제'); ?></a></td>
        </tr>
        <?php }  ?>
        <?php if ($i==0) { echo '<tr><td colspan="4" class="empty_table">'._t('자료가 없습니다.').'</td></tr>'; }  ?>
        </tbody>
        </table>
    </div>

    <p class="win_desc">
        <?php echo _t('쪽지 보관일수는 최장'); ?> <strong><?php echo $config['cf_memo_del'] ?></strong><?php echo _t('일 입니다.'); ?>
    </p>

    <div class="win_btn">
        <button type="button" onclick="window.close();"><?php echo _t('창닫기'); ?></button>
    </div>
</div>
<!-- } 쪽지 목록 끝 -->
