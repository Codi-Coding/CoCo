<?php
$sub_menu = "350903";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'w');

$html_title = '템플릿 게시판';

$required = "";
$readonly = "";

if ($w == '') {

    $html_title .= ' 추가';

    $required = 'required';
    $required_valid = 'alnum_';
    $sound_only = '<strong class="sound_only">필수</strong>';

}

if ($is_admin != 'super') {
    $group = get_group($board['gr_id']);
    $is_admin = is_admin($member['mb_id']);
}

$g5['title'] = $html_title;
include_once (G5_ADMIN_PATH.'/admin.head.php');

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./tmpl_board_list.php?'.$qstr.'">목록</a>'.PHP_EOL;
$frm_submit .= '</div>';
?>

<form name="fboardform" id="fboardform" action="./tmpl_board_form_update.php" onsubmit="return fboardform_submit(this)" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<!--<input type="hidden" name="cf_id" value="<?php echo $config2w_def['cf_templete'] ?>">-->
<input type="hidden" name="cf_id" value="<?php echo $g5['tmpl'] ?>">

<section id="anc_bo_design">
    <div style="float:right;margin-right:19px"><?php if($g5['work_tmpl']) echo "<span class='work_templete'>작업 템플릿: ".$g5['work_tmpl']."</span> | "; ?>현재 템플릿: <?php echo $config2w_def['cf_templete']?></div>
    <h2 class="h2_frm">템플릿 게시판 추가</h2>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>템플릿 게시판 추가</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_3">
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="bo_table">TABLE<?php echo $sound_only ?></label></th>
            <td colspan="2">
                <input type="text" name="bo_table" value="<?php echo $board['bo_table'] ?>" id="bo_table" <?php echo $required ?> <?php echo $readonly ?> class="frm_input <?php echo $reaonly ?> <?php echo $required ?> <?php echo $required_valid ?>" maxlength="20">
                <?php if ($w == '') { ?>
                    영문자, 숫자, _ 만 가능 (공백없이 20자 이내)
                <?php } else { ?>
                    <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $board['bo_table'] ?>" class="btn_frmline">게시판 바로가기</a>
                    <a href="./tmpl_board_list.php" class="btn_frmline">목록으로</a>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_skin">스킨 디렉토리<strong class="sound_only">필수</strong></label></th>
            <td colspan="2">
                <?php echo get_skin_select('board', 'bo_skin', 'bo_skin', $board['bo_skin'], 'required'); ?>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

</form>

<script>
function fboardform_submit(f)
{
    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
