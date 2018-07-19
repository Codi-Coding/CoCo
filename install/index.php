<?php
@header('Content-Type: text/html; charset=utf-8');
@header('X-Robots-Tag: noindex');
include_once ('../config.php');
$title = GB_VERSION." 라이센스 확인 1/3";
include_once ('./install.inc.php');
?>

<?php
if ($exists_data_dir && $write_data_dir) {
    // 필수 모듈 체크
    require_once('./library.check.php');
?>
<form action="./install_config.php" method="post" onsubmit="return frm_submit(this);">

<div class="ins_inner">
    <p>
        <strong class="st_strong">라이센스(License) 내용을 반드시 확인하십시오.</strong><br>
        라이센스에 동의하시는 경우에만 설치가 진행됩니다.
    </p>

    <h3>굿빌더 라이센스 (Good Builder License)</h3>

    <div class="ins_ta ins_license">
        <textarea name="textarea" id="ins_license" readonly><?php echo implode('', file('../BUILDER_LICENSE.txt')); ?></textarea>
    </div>

    <?php if(0) { ?>
    <h3>그누보드5 라이센스 (GNU Board 5 License)</h3>

    <div class="ins_ta ins_license">
        <textarea name="textarea" id="ins_license" readonly><?php echo implode('', file('../LICENSE.txt')); ?></textarea>
    </div>

    <h3>그누보드4 라이센스 (GNU Board 4 License)</h3>

    <div class="ins_ta ins_license">
        <textarea name="textarea" id="ins_license" readonly><?php echo implode('', file('../LICENSE.g4/LICENSE')); ?></textarea>
    </div>

    <h3>그누보드 모바일1 라이센스 (GNU Board Mobile 1 License)</h3>

    <div class="ins_ta ins_license">
        <textarea name="textarea" id="ins_license" readonly><?php echo implode('', file('../LICENSE.gm1/__license.txt')); ?></textarea>
    </div>
    <?php } ?>

    <div id="ins_agree">
        <label for="agree">동의합니다.</label>
        <input type="checkbox" name="agree" value="동의함" id="agree">
    </div>

    <div class="inner_btn">
        <input type="submit" value="다음">
    </div>
</div>

</form>

<script>
function frm_submit(f)
{
    if (!f.agree.checked) {
        alert("라이센스 내용에 동의하셔야 설치가 가능합니다.");
        return false;
    }
    return true;
}
</script>
<?php
} // if
?>

<?php
include_once ('./install.inc2.php');
?>
