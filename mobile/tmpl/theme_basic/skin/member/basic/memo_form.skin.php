<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div id="memo_write" class="new_win mbskin">
    <h1 id="win_title"><?php echo _t('쪽지보내기'); ?></h1>

    <ul class="win_ul">
        <li><a href="./memo.php?kind=recv"><?php echo _t('받은쪽지'); ?></a></li>
        <li><a href="./memo.php?kind=send"><?php echo _t('보낸쪽지'); ?></a></li>
        <li><a href="./memo_form.php"><?php echo _t('쪽지쓰기'); ?></a></li>
    </ul>

    <form name="fmemoform" action="./memo_form_update.php" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption><?php echo _t('쪽지쓰기'); ?></caption>
        <tbody>
        <?php if ($config['cf_memo_send_point']) { ?>
        <tr>
            <td colspan="2">
                <strong><?php echo _t('쪽지 보낼때 회원당'); ?> <?php echo number_format($config['cf_memo_send_point']); ?><?php echo _t('점의 포인트를 차감합니다.'); ?></strong>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <th scope="row"><label for="me_recv_mb_id"><?php echo _t('받는 회원아이디'); ?><strong class="sound_only"><?php echo _t('필수'); ?></strong></label></th>
            <td>
                <input type="text" name="me_recv_mb_id" value="<?php echo $me_recv_mb_id ?>" id="me_recv_mb_id" required class="frm_input required">
                <span class="frm_info"><?php echo _t('여러 회원에게 보낼때는 컴마(,)로 구분하세요.'); ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="me_memo"><?php echo _t('내용'); ?></label></th>
            <td><textarea name="me_memo" id="me_memo" required><?php echo $content ?></textarea></td>
        </tr>
        <tr>
            <th scope="row"><?php echo _t('자동등록방지'); ?></th>
            <td>
                <?php echo captcha_html(); ?>
            </td>
        </tr>
        </tbody>
        </table>
    </div>

    <div class="win_btn">
        <input type="submit" value="보내기" id="btn_submit" class="btn_submit">
        <button type="button" onclick="window.close();"><?php echo _t('창닫기'); ?></button>
    </div>
    </form>
</div>

<script>
function fmemoform_submit(f)
{
    <?php echo chk_captcha_js(); ?>

    return true;
}
</script>
