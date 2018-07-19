<?php
$sub_menu = "350205";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '통화 설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="'.G5_URL.'/">메인으로</a>
</div>';

echo '<script src="'.G5_JS_URL.'/trans.js"></script>'.PHP_EOL;

$lang_currency_list_tmp = explode('|', $config2w_def['lang_currency_list']);
for($i = 0; $i < count($lang_currency_list_tmp); $i++) {
    $tmp = explode(':', $lang_currency_list_tmp[$i]);
    $lang_currency_list[$tmp[0]] = $tmp[1];
}
?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="<?php echo $token ?>" id="token">

<section id="anc_cf_basic">
    <h2 class="h2_frm">언어별 통화 설정</h2>
    <?php echo $pg_anchor ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>언어별 통화 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="current_currency">기본 통화<strong class="sound_only">필수</strong></label></th>
            <td colspan="3">
            <select name="currency">
            <?php for($i = 0; $i < count($g5['currency_list_all']); $i++) { $currency = $g5['currency_list_all'][$i]; ?>
            <option value="<?php echo $currency; ?>"<?php if($currency == $g5['def_currency']) echo ' selected'; else echo ''; ?>><?php echo $currency.' ('.$g5['currency_name_list'][$currency].')'.PHP_EOL; ?>
            <?php } ?>
            </select>
            </td>
        </tr>
        <tr>
            <th scope="row" valign="top"><label for="support_currency">언어별 통화<strong class="sound_only">필수</strong></label></th>
            <td colspan="3">
            <div style="width:100%">
            <?php for($i = 0; $i < count($g5['lang_list']); $i++) { $lang = $g5['lang_list'][$i]; $flag = $g5['flag_list'][$lang]; ?>
            <div style="width:200px;height:30px;clear:both;float:left">
            <img src="<?php echo G5_LOCALE_IMG_URL."/flag/".$flag.".png"; ?>" alt="<?php echo $g5['lang_name_list'][$lang]; ?>" title="<?php echo $g5['lang_name_list'][$lang]; ?>"> <?php echo $g5['lang_name_list'][$lang]; ?> 
            </div>
            <select style="float:left" name="currency_<?php echo $lang; ?>">
            <option value="">== 선택 ==
            <?php for($j = 0; $j < count($g5['currency_list_all']); $j++) { $currency = $g5['currency_list_all'][$j]; ?>
            <option value="<?php echo $currency; ?>"<?php if($currency == $lang_currency_list[$lang]) echo ' selected'; else echo ''; ?>><?php echo $currency.' ('. $g5['currency_name_list'][$currency].')'.PHP_EOL; ?>
            <?php } ?>
            </select>
            <?php } ?>
            </div>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

</form>

<script>
$(function(){
    <?php
    if(!$config['cf_cert_use'])
        echo '$(".cf_cert_service").addClass("cf_cert_hide");';
    ?>
    $("#cf_cert_use").change(function(){
        switch($(this).val()) {
            case "0":
                $(".cf_cert_service").addClass("cf_cert_hide");
                break;
            default:
                $(".cf_cert_service").removeClass("cf_cert_hide");
                break;
        }
    });
});

function fconfigform_submit(f)
{
    f.action = "./currency_config_form_update.php";
    return true;
}
</script>

<?php
// 본인확인 모듈 실행권한 체크
if($config['cf_cert_use']) {
    // kcb일 때
    if($config['cf_cert_ipin'] == 'kcb' || $config['cf_cert_hp'] == 'kcb') {
        // 실행모듈
        if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe = G5_OKNAME_PATH.'/bin/okname';
            else
                $exe = G5_OKNAME_PATH.'/bin/okname_x64';
        } else {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe = G5_OKNAME_PATH.'/bin/okname.exe';
            else
                $exe = G5_OKNAME_PATH.'/bin/oknamex64.exe';
        }

        echo module_exec_check($exe, 'okname');
    }

    // kcp일 때
    if($config['cf_cert_hp'] == 'kcp') {
        if(PHP_INT_MAX == 2147483647) // 32-bit
            $exe = G5_KCPCERT_PATH . '/bin/ct_cli';
        else
            $exe = G5_KCPCERT_PATH . '/bin/ct_cli_x64';

        echo module_exec_check($exe, 'ct_cli');
    }

    // LG의 경우 log 디렉토리 체크
    if($config['cf_cert_hp'] == 'lg') {
        $log_path = G5_LGXPAY_PATH.'/lgdacom/log';

        if(!is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(G5_PATH.'/', '', G5_LGXPAY_PATH).'/lgdacom 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        } else {
            if(!is_writable($log_path)) {
                echo '<script>'.PHP_EOL;
                echo 'alert("'.str_replace(G5_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
                echo '</script>'.PHP_EOL;
            }
        }
    }
}

include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
