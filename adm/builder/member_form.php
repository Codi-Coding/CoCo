<?php
$sub_menu = "350204";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

if ($w == 'u')
{
    $mb = get_member($mb_id);
    if (!$mb['mb_id'])
        alert('존재하지 않는 회원자료입니다.');

    if ($is_admin != 'super' && $mb['mb_level'] >= $member['mb_level'])
        alert('자신보다 권한이 높거나 같은 회원은 수정할 수 없습니다.');

    $required_mb_id = 'readonly';
    $required_mb_password = '';
    $html_title = '수정';

    $mb['mb_name'] = get_text($mb['mb_name']);
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');

if ($mb['mb_intercept_date']) $g5['title'] = "차단된 ";
else $g5['title'] .= "";
$g5['title'] .= '회원 '.$html_title;
include_once('../admin.head.php');
?>

<form name="fmember" id="fmember" action="./member_form_update.php" onsubmit="return fmember_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="mb_id">아이디<?php echo $sound_only ?></label></th>
        <td>
            <input type="text" name="mb_id" value="<?php echo $mb['mb_id'] ?>" id="mb_id" <?php echo $required_mb_id ?> class="frm_input <?php echo $required_mb_id_class ?>" size="15" minlength="3" maxlength="20">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_icon">회원 이미지</label></th>
        <td colspan="3">
            <?php echo help('이미지는 jpg 형태로 해주세요.') ?>
            <input type="file" name="mb_icon" id="mb_icon">
            <br><br>
            <?php
            $mb_dir = substr($mb['mb_id'],0,2);
            $icon_file = G5_DATA_PATH.'/member/'.$mb_dir.'/'.$mb['mb_id'].'.jpg';
            if (file_exists($icon_file)) {
                $icon_url = G5_DATA_URL.'/member/'.$mb_dir.'/'.$mb['mb_id'].'.jpg';
                echo '<img src="'.$icon_url.'" alt=""> ';
                echo '<input type="checkbox" id="del_mb_icon" name="del_mb_icon" value="1">삭제';
            }
            ?>
        </td>
    </tr>

    </tbody>
    </table>
</div>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey='s'>
    <a href="./member_list.php?<?php echo $qstr ?>">목록</a>
</div>
</form>

<script>
function fmember_submit(f)
{
    if (!f.mb_icon.value.match(/\.jpg$/i) && f.mb_icon.value) {
        alert('아이콘은 jpg 파일만 가능합니다.');
        return false;
    }

    return true;
}
</script>

<?php
include_once('../admin.tail.php');
?>
