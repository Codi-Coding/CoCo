<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<script type="text/javascript">
function checkFrm(obj) {
    if(obj.wr_6.checked == false) {
        alert('<?php echo _t('개인 정보 처리 방침 동의에 체크해 주세요.'); ?>');
        obj.wr_6.focus();
        return false;
    }
}
</script>

<section id="bo_w">
    <h2 id="container_title"><?php echo $board['bo_subject'] ?></h2>
    
    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" method=post action="<?php echo $g5['url']?>/bbs/write_update.php" onsubmit="return checkFrm(this);">
    <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="wr_subject" value="상담 신청">
    
    <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';
        if ($is_notice) {
            $option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">'._t('공지').'</label>';
        }

        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">html</label>';
            }
        }

        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">'._t('비밀글').'</label>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }

        if ($is_mail) {
            $option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">'._t('답변메일받기').'</label>';
        }
    }

    echo $option_hidden;
    ?>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <tbody>
        <tr>
            <th scope="row"><div align="center"><label for="wr_name"><?php echo _t('이름'); ?><strong class="sound_only"><?php echo _t('필수'); ?></strong></label></div></th>
            <td class="wr_name">
                <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name2" required class="frm_input required" size="15" maxlength="15">            </td>
        </tr>
        <tr>
            <th scope="row"><div align="center"><label for="wr_email"><?php echo _t('이메일'); ?><strong class="sound_only"><?php echo _t('필수'); ?></strong></label></div></th>
            <td class="wr_email">
                <input name="wr_email" value="<?php echo $write['wr_email']; ?>" type="text" required class="frm_input required" size="15" maxlength="15" itemname="<?php echo _t('이메일'); ?>"/></td>
        </tr>
        <tr>
            <th scope="row"><div align="center"><label for="wr_subject"><?php echo _t('제목'); ?><strong class="sound_only"><?php echo _t('필수'); ?></strong></label></div></th>
            <td class="wr_subject">
                <input name="wr_subject" value="<?php echo $write['wr_subject']; ?>" type="text" required class="frm_input required" size="50" maxlength="255" itemname="<?php echo _t('제목'); ?>"/></td>
        </tr>
        <tr>
            <th scope="row"><div align="center"><label for="wr_content"><?php echo _t('내용'); ?><strong class="sound_only"><?php echo _t('필수'); ?></strong></label></div></th>
            <td class="wr_content">
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc"><?php echo _t('이 게시판은 최소'); ?> <strong><?php echo $write_min; ?></strong><?php echo _t('글자 이상, 최대'); ?> <strong><?php echo $write_max; ?></strong><?php echo _t('글자 이하까지 글을 쓰실 수 있습니다.'); ?></p>
                <?php } ?>
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span><?php echo _t('글자'); ?></div>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><div align="center"><label for="wr_1"><?php echo _t('상태'); ?></label></div></th>
            <td>
                <select name="wr_1">
                <option value="답변 대기"<?php if($write['wr_1'] == '답변 대기') echo 'selected'; ?>><?php echo _t('답변 대기'); ?>
                <option value="답변 완료"<?php if($write['wr_1'] == '답변 완료') echo 'selected'; ?>><?php echo _t('답변 완료'); ?>
                </select>
            </td>
        </tr>
        <tr align="center">
            <td height="57" colspan="2"><br><span> * <?php echo _t('고객님의 정보는 상담을 위해서만 사용됩니다.'); ?></span><br><br>
                <input name="wr_6" type="checkbox" value="1" <?php if($write['wr_6'] == '1') echo 'checked'; ?> required >
                <?php echo _t('동의합니다'); ?> (<a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy" target="_blank"><?php echo _t('개인 정보 처리 방침'); ?></a>)
            </td>
        </tr>
        <?php if ($is_guest) { //자동등록방지  ?>
        <tr>
            <th scope="row"><?php echo _t('자동등록방지'); ?></th>
            <td>
                <?php echo $captcha_html ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>

    <div class="btn_confirm">
        <input type="submit" value="<?php echo _t('작성완료'); ?>" id="btn_submit" accesskey="s" class="btn_submit">
        <a href="javascript:history.back();" class="btn_cancel"><?php echo _t('취소'); ?></a>
    </div>
    </form>

    <script>
    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>
    </script>
   
</section>
<!-- } 게시물 작성/수정 끝 -->
