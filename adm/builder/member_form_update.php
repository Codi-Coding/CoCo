<?php
$sub_menu = "350204";
include_once("./_common.php");
include_once(G5_LIB_PATH."/register.lib.php");

if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

$mb_id = trim($_POST['mb_id']);

if ($w == 'u')
{
    $mb = get_member($mb_id);
    if (!$mb['mb_id'])
        alert('존재하지 않는 회원자료입니다.');

    if ($is_admin != 'super' && $mb['mb_level'] >= $member['mb_level'])
        alert('자신보다 권한이 높거나 같은 회원은 수정할 수 없습니다.');

    if ($is_admin !== 'super' && is_admin($mb['mb_id']) === 'super' ) {
        alert('최고관리자의 비밀번호를 수정할수 없습니다.');
    }

    if ($_POST['mb_id'] == $member['mb_id'] && $_POST['mb_level'] != $mb['mb_level'])
        alert($mb['mb_id'].' : 로그인 중인 관리자 레벨은 수정 할 수 없습니다.');

    $mb_dir = substr($mb_id,0,2);

    // 회원 아이콘 삭제
    if ($del_mb_icon)
        @unlink(G5_DATA_PATH.'/member/'.$mb_dir.'/'.$mb_id.'.jpg');

    // 아이콘 업로드
    if (is_uploaded_file($_FILES['mb_icon']['tmp_name'])) {
        if (!preg_match("/(\.jpg)$/i", $_FILES['mb_icon']['name'])) {
            alert($_FILES['mb_icon']['name'] . '은(는) jpg 파일이 아닙니다.');
        }

        if (preg_match("/(\.jpg)$/i", $_FILES['mb_icon']['name'])) {
            @mkdir(G5_DATA_PATH.'/member/'.$mb_dir, G5_DIR_PERMISSION);
            @chmod(G5_DATA_PATH.'/member/'.$mb_dir, G5_DIR_PERMISSION);

            $dest_path = G5_DATA_PATH.'/member/'.$mb_dir.'/'.$mb_id.'.jpg';

            move_uploaded_file($_FILES['mb_icon']['tmp_name'], $dest_path);
            chmod($dest_path, G5_FILE_PERMISSION);
        }
    }
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');

goto_url('./member_form.php?'.$qstr.'&amp;w=u&amp;mb_id='.$mb_id, false);
?>
