<?php
$sub_menu = '300900';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$html_title = "외부페이지";
$g5['title'] = $html_title.' 관리';

if ($w == "u")
{
    $html_title .= " 수정";
    $readonly = " readonly";

    $sql = " select * from {$g5['opage_table']} where op_id = '$op_id' ";
    $op = sql_fetch($sql);
    if (!$op['op_id'])
        alert('등록된 자료가 없습니다.');
}
else
{
    $html_title .= ' 입력';
    $op['include_head'] = './_head.php';
    $op['include_tail'] = './_tail.php';
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="frmopageform" action="./opage_form_update.php" onsubmit="return frmopageform_check(this);" method="post" enctype="MULTIPART/FORM-DATA" >
<input type="hidden" name="w" value="<?php echo $w; ?>">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="op_id">ID</label></th>
        <td>
            <?php echo help('20자 이내의 영문자, 숫자, _ 만 가능합니다.'); ?>
            <input type="text" value="<?php echo $op['op_id']; ?>" name="op_id" id ="op_id" required <?php echo $readonly; ?> class="required <?php echo $readonly; ?> frm_input" size="20" maxlength="20">
            <?php if ($w == 'u') { ?><a href="<?php echo G5_BBS_URL; ?>/opage.php?op_id=<?php echo $op_id; ?>" class="btn_frmline">내용확인</a><?php } ?>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="subject">제목</label></th>
        <td><input type="text" name="subject" value="<?php echo htmlspecialchars2($op['subject']); ?>" id="subject" required class="frm_input required" size="90"></td>
    </tr>
    <tr>
        <th scope="row"><label for="mobile_subject">모바일 제목</label></th>
        <td><input type="text" name="mobile_subject" value="<?php echo htmlspecialchars2($op['mobile_subject']); ?>" id="mobile_subject" class="frm_input" size="90"></td>
    </tr>
    <tr>
        <th scope="row"><label for="gr_id">그룹<strong class="sound_only">필수</strong></label></th>
        <td colspan="2">
            <?php echo help("그룹 체크는 메뉴 기능 제작하실때 인식 연동에 도움을 줍니다."); ?>
            <?php echo get_group_select('gr_id', $op['gr_id'], 'required'); ?>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="read_level">외부페이지 보기 권한</label></th>
        <td colspan="2">
            <?php echo help('권한 1은 비회원, 2 이상 회원입니다. 권한은 10 이 가장 높습니다.') ?>
            <?php echo get_member_level_select('read_level', 1, 10, $op['read_level']) ?>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="content_include">외부 페이지 경로</label></th>
        <td>
            <?php echo help("설정값이 없으면 본문에 빈화면만 보입니다.<br>[알림] 타 사이트 까지 외부 페이지로 불러올수는 있으나 그에 대한 책임은 플러그인 사용자에게 있으며, 제작자는 책임 지지 않습니다."); ?>
            <input type="text" name="content_include" value="<?php echo htmlspecialchars2($op['content_include']); ?>" id="content_include" class="frm_input" size="90"></td>
    </tr>
    <tr>
        <th scope="row"><label for="mobile_content_include">모바일 외부 페이지 경로</label></th>
        <td>
            <?php echo help("설정값이 없으면 본문에 빈화면만 보입니다.<br>[알림] 타 사이트 까지 외부 페이지로 불러올수는 있으나 그에 대한 책임은 플러그인 사용자에게 있으며, 제작자는 책임 지지 않습니다."); ?>
            <input type="text" name="mobile_content_include" value="<?php echo htmlspecialchars2($op['mobile_content_include']); ?>" id="mobile_content_include" class="frm_input" size="90"></td>
    </tr>
    <tr>
        <th scope="row"><label for="include_head">상단 파일 경로</label></th>
        <td>
            <?php echo help("설정값이 없으면 기본 상단 파일을 사용합니다."); ?>
            <input type="text" name="include_head" value="<?php echo $op['include_head']; ?>" id="include_head" class="frm_input" size="60">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="include_tail">하단 파일 경로</label></th>
        <td>
            <?php echo help("설정값이 없으면 기본 하단 파일을 사용합니다."); ?>
            <input type="text" name="include_tail" value="<?php echo $op['include_tail']; ?>" id="include_tail" class="frm_input" size="60">
        </td>
    </tr>
    </tbody>
    </table>
</div>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./contentlist.php">목록</a>
</div>

</form>

<script>
function frmopageformcheck(f)
{
    errmsg = "";
    errfld = "";

    check_field(f.url, "ID를 입력하세요.");

    if (errmsg != "") {
        alert(errmsg);
        errfld.focus();
        return false;
    }
    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
