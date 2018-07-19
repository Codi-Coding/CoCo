<?php
$gmnow = gmdate('D, d M Y H:i:s').' GMT';
header('Expires: 0'); // rfc2616 - Section 14.21
header('Last-Modified: ' . $gmnow);
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Pragma: no-cache'); // HTTP/1.0

$g5_path['path'] = "../../../..";
include_once ('../../../../config.php');
include_once ('../../../../data/dbconfig.php');
$title = "쇼핑몰 초기환경설정 2/3";
include_once ('./install.inc.php');

if (!isset($_POST['agree']) || $_POST['agree'] != '동의함') {
    echo "<div class=\"ins_inner\"><p>라이센스(License) 내용에 동의하셔야 설치를 계속하실 수 있습니다.</p>".PHP_EOL;
    echo "<div class=\"inner_btn\"><a href=\"./\">뒤로가기</a></div></div>".PHP_EOL;
    exit;
}

if(!file_exists(G5_PATH.'/install/sql_buildershop.sql')) {
    echo "<div class=\"ins_inner\"><p>쇼핑몰 설치 화일이 존재하지 않습니다.</p>".PHP_EOL;
    exit;
}
?>


<form id="frm_install" method="post" action="./install_db.php" autocomplete="off" onsubmit="return frm_install_submit(this)">
<input name="table_prefix" type="hidden" value="<?php echo G5_TABLE_PREFIX; ?>" id="table_prefix">

<div class="ins_inner">
    <table class="ins_frm">
    <caption>MySQL 정보입력</caption>
    <colgroup>
        <col style="width:150px">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="">쇼핑몰TABLE명 접두사</label></th>
        <td>
            <span>가능한 변경하지 마십시오.</span>
            <input name="g5_shop_prefix" type="text" value="g5_shop_" id="g5_shop_prefix">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="">쇼핑몰설치</label></th>
        <td>
            <input name="g5_shop_install" type="checkbox" value="1" id="g5_shop_install" checked="checked">설치
        </td>
    </tr>
    </tbody>
    </table>

    <p>
        <strong class="st_strong">주의! 이미 쇼핑몰이 존재한다면 쇼핑몰 DB 자료가 망실되므로 주의하십시오.</strong><br>
        주의사항을 이해했으며, 쇼핑몰 설치를 계속 진행하시려면 다음을 누르십시오.
    </p>

    <div class="inner_btn">
        <input type="submit" value="다음">
    </div>
</div>

<script>
function frm_install_submit(f)
{
    if (f.g5_shop_install.checked == false)
    {
        alert('쇼핑몰 설치에 체크해 주십시요.'); f.g5_shop_install.focus(); return false;
    }
    return true;
}
</script>

<?php
include_once ('./install.inc2.php');
?>
