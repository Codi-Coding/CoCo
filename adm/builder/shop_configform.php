<?php
$sub_menu = '350890';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '쇼핑몰 해외 PG 설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
<li><a href="#anc_scf_payment">해외 PG 설정</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

///goodbuilder 
///paypal
if(!isset($default['de_paypal_use'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` 
                    ADD `de_paypal_use` tinyint(4) NOT NULL default '0',
                    ADD `de_paypal_test` tinyint(4) NOT NULL default '0',
                    ADD `de_paypal_mid` varchar(255) NOT NULL default '',
                    ADD `de_paypal_currency_code` varchar(10) NOT NULL default '',
                    ADD `de_paypal_exchange_rate` varchar(20) NOT NULL default '' ", true);
}

///alipay
if(!isset($default['de_alipay_use'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` 
                    ADD `de_alipay_use` tinyint(4) NOT NULL DEFAULT '0', 
                    ADD `de_alipay_test` tinyint(4) NOT NULL DEFAULT '0',
                    ADD `de_alipay_service_type` VARCHAR(30) NOT NULL DEFAULT '',
                    ADD `de_alipay_partner` VARCHAR(60) NOT NULL DEFAULT '',
                    ADD `de_alipay_key` VARCHAR(120) NOT NULL DEFAULT '',
                    ADD `de_alipay_seller_id` VARCHAR(60) NOT NULL DEFAULT '',
                    ADD `de_alipay_seller_email` VARCHAR(120) NOT NULL DEFAULT '',
                    ADD `de_alipay_currency` VARCHAR(10) NOT NULL DEFAULT '',
                    ADD `de_alipay_exchange_rate` VARCHAR(20) NOT NULL DEFAULT '' ", true);
}

///authorize.net
if(!isset($default['de_anet_use'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` 
                    ADD `de_anet_use` tinyint(4) NOT NULL default '0',
                    ADD `de_anet_test` tinyint(4) NOT NULL default '0',
                    ADD `de_anet_id` varchar(255) NOT NULL default '',
                    ADD `de_anet_key` varchar(255) NOT NULL default '',
                    ADD `de_anet_test_mode` tinyint(4) NOT NULL default '0',
                    ADD `de_anet_exchange_rate` varchar(20) NOT NULL default '' ", true);
}

///Eximbay
if(!isset($default['de_eximbay_use'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}` 
                    ADD `de_eximbay_use` tinyint(4) NOT NULL default '0',
                    ADD `de_eximbay_test` tinyint(4) NOT NULL default '0',
                    ADD `de_eximbay_mid` varchar(255) NOT NULL default '',
                    ADD `de_eximbay_key` varchar(255) NOT NULL default '',
                    ADD `de_eximbay_currency` VARCHAR(10) NOT NULL DEFAULT '',
                    ADD `de_eximbay_exchange_rate` varchar(20) NOT NULL default '',
                    ADD `de_eximbay_lang` varchar(10) NOT NULL default '' ", true);
}

///shop table
$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_order_table']}` LIKE 'od_status_detail' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = " ALTER TABLE `{$g5['g5_shop_order_table']}` ADD `od_status_detail` VARCHAR(255) NOT NULL DEFAULT '' ";
    sql_query($sql, true);
}

$sql = " SHOW COLUMNS FROM `{$g5['g5_shop_cart_table']}` LIKE 'ct_status_detail' ";
$row = sql_fetch($sql);
if(!isset($row['Field'])) {
    $sql = " ALTER TABLE `{$g5['g5_shop_cart_table']}` ADD `ct_status_detail` VARCHAR(255) NOT NULL DEFAULT '' ";
    sql_query($sql, true);
}
///--goodbuilder--
?>

<form name="fconfig" action="./shop_configformupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">

<section id ="anc_scf_payment">
    <h2 class="h2_frm">PG 설정</h2>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>PG 설정 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <!--goodbuilder-->
        <tr>
            <th scope="row"><label for="de_paypal_use">페이팔 사용</label></th>
            <td>
                <?php echo help("사용시 페이팔 계정, 통화 코드, 적용 환율 등을 입력하여 주십시오.", 50); ?>
                <select id="de_paypal_use" name="de_paypal_use">
                    <option value="0" <?php echo get_selected($default['de_paypal_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_paypal_use'], 1); ?>>사용</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_paypal_info">페이팔 연동 정보</label></th>
            <td>
                테스트 결제:  
                <select name="de_paypal_test" id="de_paypal_test" required class="required">
                    <option value="0" <?php echo get_selected($default['de_paypal_test'], '0'); ?>>실제 결제</option>
                    <option value="1" <?php echo get_selected($default['de_paypal_test'], '1'); ?>>테스트 결제</option>
                </select>
                <br>페이팔 계정: <input type="text" name="de_paypal_mid" value="<?php echo $default[de_paypal_mid]?>" class="frm_input" size="15" style="margin-top:5px">
                <br>통화 코드:&nbsp;&nbsp; <input type="text" name="de_paypal_currency_code" value="<?php echo $default[de_paypal_currency_code]?>" class="frm_input" size="5" style="margin-top:5px"> (기본: USD)
                <br>적용 환율:&nbsp;&nbsp; <input type="text" name="de_paypal_exchange_rate" value="<?php echo $default[de_paypal_exchange_rate]?>" class="frm_input" size="10" style="margin-top:5px"> (기본: 1)
                <br>&nbsp;(예) 1달러 = 1184 원 (상품이 원화로 등록되어 있을땐 이처럼 환율을 대입하고, 상품이 달러화로 등록되어 있다면 1 을 대입)
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_alipay_use">알리페이 사용</label></th>
            <td>
                <?php echo help("사용시 알리페이 파트너 아이디, 보안 키, 판매자 아이디, 판매자 이메일, 통화 코드 등을 입력하여 주십시오.", 50); ?>
                <select id="de_alipay_use" name="de_alipay_use">
                    <option value="0" <?php echo get_selected($default['de_alipay_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_alipay_use'], 1); ?>>사용</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_alipay_info">알리페이 연동 정보</label></th>
            <td>
                테스트 결제:&nbsp;&nbsp; 
                <select name="de_alipay_test" id="de_alipay_test" required class="required">
                    <option value="0" <?php echo get_selected($default['de_alipay_test'], '0'); ?>>실제 결제</option>
                    <option value="1" <?php echo get_selected($default['de_alipay_test'], '1'); ?>>테스트 결제</option>
                </select>
                <br>연동 형태:&nbsp;&nbsp;&nbsp;&nbsp; 
                <select name="de_alipay_service_type" id="de_alipay_service_type" required class="required">
                    <option value="direct" <?php echo get_selected($default['de_alipay_service_type'], 'direct'); ?>>Direct Pay</option>
                    <option value="forex" <?php echo get_selected($default['de_alipay_service_type'], 'forex'); ?>>Create Forex Trade</option>
                    <option value="partner" <?php echo get_selected($default['de_alipay_service_type'], 'partner'); ?>>Create Partner Trade</option>
                </select>
                <br>파트너 아이디: <input type="text" name="de_alipay_partner" value="<?php echo $default['de_alipay_partner']?>" class="frm_input" size="15" style="margin-top:5px">
                <br>보안 키:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="de_alipay_key" value="<?php echo $default['de_alipay_key']?>" class="frm_input" size="15" style="margin-top:5px">
                <br>판매자 아이디: <input type="text" name="de_alipay_seller_id" value="<?php echo $default['de_alipay_seller_id']?>" class="frm_input" size="15" style="margin-top:5px"> (* Direct Pay인 경우)
                <br>판매자 이메일: <input type="text" name="de_alipay_seller_email" value="<?php echo $default['de_alipay_seller_email']?>" class="frm_input" size="15" style="margin-top:5px"> (* Direct Pay인 경우)
                <br>통화 코드:&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="de_alipay_currency" value="<?php echo $default['de_alipay_currency']?>" class="frm_input" size="15" style="margin-top:5px"> (* Create Forex Trade인 경우) (기본: USD)
                <br>적용 환율:&nbsp;&nbsp; <input type="text" name="de_alipay_exchange_rate" value="<?php echo $default[de_alipay_exchange_rate]?>" class="frm_input" size="10" style="margin-top:5px"> (기본: 1)
                <br>&nbsp;(예) 1달러 = 1184 원 (상품이 원화로 등록되어 있을땐 이처럼 환율을 대입하고, 상품이 달러화 또는 위완화로 등록되어 있다면 1 을 대입)
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_anet_use">Authorize.Net 사용</label></th>
            <td>
                <?php echo help("사용시 Authorize.Net API LOGIN ID, TRANSACTION KEY 등을 입력하여 주십시오.", 50); ?>
                <select id="de_anet_use" name="de_anet_use">
                    <option value="0" <?php echo get_selected($default['de_anet_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_anet_use'], 1); ?>>사용</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_anet_info_">Authorize.Net 연동 정보</label></th>
            <td>
                테스트 결제:  
                <select name="de_anet_test" id="de_anet_test" required class="required">
                    <option value="0" <?php echo get_selected($default['de_anet_test'], '0'); ?>>실제 결제</option>
                    <option value="1" <?php echo get_selected($default['de_anet_test'], '1'); ?>>테스트 결제</option>
                </select>
                <br>Authorize.Net API LOGIN ID: <input type="text" name="de_anet_id" value="<?php echo $default[de_anet_id]?>" class="frm_input" size="15" style="margin-top:5px">
                <br>Authorize.Net TRANSACTION KEY: <input type='text' name='de_anet_key' value='<?php echo $default[de_anet_key]?>' class="frm_input" size="15" style="margin-top:5px">
                <br>Authorize.Net 테스트 모드:
                <select id=de_anet_test_mode name=de_anet_test_mode style="margin-top:5px">
                <option value='0'>NO
                <option value='1'>YES
                </select>
                <br>적용 환율:&nbsp;&nbsp; <input type="text" name="de_anet_exchange_rate" value="<?php echo $default[de_anet_exchange_rate]?>" class="frm_input" size="10" style="margin-top:5px"> (기본: 1)
                <br>&nbsp;(예) 1달러 = 1184 원 (상품이 원화로 등록되어 있을땐 이처럼 환율을 대입하고, 상품이 달러화로 등록되어 있다면 1 을 대입)
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_eximbay_use">Eximbay 사용</label></th>
            <td>
                <?php echo help("사용시 Eximbay 계정(아이디), 보안키, 통화 코드, 적용 환율, 언어 등을 입력하여 주십시오.", 50); ?>
                <select id="de_eximbay_use" name="de_eximbay_use">
                    <option value="0" <?php echo get_selected($default['de_eximbay_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_eximbay_use'], 1); ?>>사용</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_eximbay_info">Eximbay 연동 정보</label></th>
            <td>
                테스트 결제:  
                <select name="de_eximbay_test" id="de_eximbay_test" required class="required">
                    <option value="0" <?php echo get_selected($default['de_eximbay_test'], '0'); ?>>실제 결제</option>
                    <option value="1" <?php echo get_selected($default['de_eximbay_test'], '1'); ?>>테스트 결제</option>
                </select>
                <br>Eximbay 계정: <input type="text" name="de_eximbay_mid" value="<?php echo $default[de_eximbay_mid]?>" class="frm_input" size="15" style="margin-top:5px">
                <br>보안 키:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="de_eximbay_key" value="<?php echo $default['de_eximbay_key']?>" class="frm_input" size="15" style="margin-top:5px">
                <br>통화 코드:&nbsp;&nbsp; <input type="text" name="de_eximbay_currency_code" value="<?php echo $default[de_eximbay_currency_code]?>" class="frm_input" size="5" style="margin-top:5px"> (기본: USD)
                <br>적용 환율:&nbsp;&nbsp; <input type="text" name="de_eximbay_exchange_rate" value="<?php echo $default[de_eximbay_exchange_rate]?>" class="frm_input" size="10" style="margin-top:5px"> (기본: 1)
                <br>&nbsp;(예) 1달러 = 1184 원 (상품이 원화로 등록되어 있을땐 이처럼 환율을 대입하고, 상품이 달러화로 등록되어 있다면 1 을 대입)
                <br>언어:&nbsp;&nbsp; <input type="text" name="de_eximbay_lang" value="<?php echo $default[de_eximbay_lang]?>" class="frm_input" size="10" style="margin-top:5px"> (기본: EN) (선택: EN, KR, JP, CN)
            </td>
        </tr>
        <!--///goodbuilder-->
        <!--goodbuilder-->
        <tr>
            <th scope="row"><label for="de_pg_service">결제대행사</label></th>
            <td>
                <?php echo help('쇼핑몰에서 사용할 결제대행사를 선택합니다.'); ?>
                <select id="de_pg_service" name="de_pg_service">
                    <option value="kcp" <?php echo get_selected($default['de_pg_service'], 'kcp'); ?>>NHN KCP</option>
                    <option value="lg" <?php echo get_selected($default['de_pg_service'], 'lg'); ?>>LG유플러스</option>
                    <option value="inicis" <?php echo get_selected($default['de_pg_service'], 'inicis'); ?>>KG이니시스</option>
                    <option value="global" <?php echo get_selected($default['de_pg_service'], 'global'); ?>>Global</option>
                </select>
                <?php echo help('<br>* 글로벌 결제(Paypal, Alipay, Authorize.Net, Eximbay 등)만 이용할 경우에는 Global 선택, 그렇지 않을 경우에는 국내 해당 결제사 선택'); ?>
                <?php echo help('* 페이팔, 알리페이, Authorize.net, Eximbay 등은 결제사에 관계없이 이용 가능. 복수 이용 가능'); ?>
            </td>
        </tr>
        </tbody>
        </table>
        <script>
        $('#scf_cardtest_tip').addClass('scf_cardtest_tip');
        $('<button type="button" class="scf_cardtest_btn btn_frmline">테스트결제 팁 더보기</button>').appendTo('.scf_cardtest');

        $(".scf_cardtest").addClass("scf_cardtest_hide");
        $(".<?php echo $default['de_pg_service']; ?>_cardtest").removeClass("scf_cardtest_hide");
        $("#<?php echo $default['de_pg_service']; ?>_cardtest_tip").removeClass("scf_cardtest_tip_adm_hide");
        </script>
    </div>
</section>

<?php echo $frm_submit; ?>

<?php if (file_exists($logo_img) || file_exists($logo_img2) || file_exists($mobile_logo_img) || file_exists($mobile_logo_img2)) { ?>
<script>
$(".banner_or_img").addClass("scf_img");
$(function() {
    $(".scf_img_view").bind("click", function() {
        var sit_wimg_id = $(this).attr("id").split("_");
        var $img_display = $("#"+sit_wimg_id[1]);

        $img_display.toggle();

        if($img_display.is(":visible")) {
            $(this).text($(this).text().replace("확인", "닫기"));
        } else {
            $(this).text($(this).text().replace("닫기", "확인"));
        }

        if(sit_wimg_id[1].search("mainimg") > -1) {
            var $img = $("#"+sit_wimg_id[1]).children("img");
            var width = $img.width();
            var height = $img.height();
            if(width > 700) {
                var img_width = 700;
                var img_height = Math.round((img_width * height) / width);

                $img.width(img_width).height(img_height);
            }
        }
    });
    $(".sit_wimg_close").bind("click", function() {
        var $img_display = $(this).parents(".banner_or_img");
        var id = $img_display.attr("id");
        $img_display.toggle();
        var $button = $("#cf_"+id+"_view");
        $button.text($button.text().replace("닫기", "확인"));
    });
});
</script>
<?php } ?>

<script>
function byte_check(el_cont, el_byte)
{
    var cont = document.getElementById(el_cont);
    var bytes = document.getElementById(el_byte);
    var i = 0;
    var cnt = 0;
    var exceed = 0;
    var ch = '';
    var limit_num = (jQuery("#cf_sms_type").val() == "LMS") ? 1500 : 80;

    for (i=0; i<cont.value.length; i++) {
        ch = cont.value.charAt(i);
        if (escape(ch).length > 4) {
            cnt += 2;
        } else {
            cnt += 1;
        }
    }

    //byte.value = cnt + ' / 80 bytes';
    bytes.innerHTML = cnt + ' / ' + limit_num +' bytes';

    if (cnt > limit_num) {
        exceed = cnt - limit_num;
        alert('메시지 내용은 ' + limit_num +' 바이트를 넘을수 없습니다.\r\n작성하신 메세지 내용은 '+ exceed +'byte가 초과되었습니다.\r\n초과된 부분은 자동으로 삭제됩니다.');
        var tcnt = 0;
        var xcnt = 0;
        var tmp = cont.value;
        for (i=0; i<tmp.length; i++) {
            ch = tmp.charAt(i);
            if (escape(ch).length > 4) {
                tcnt += 2;
            } else {
                tcnt += 1;
            }

            if (tcnt > limit_num) {
                tmp = tmp.substring(0,i);
                break;
            } else {
                xcnt = tcnt;
            }
        }
        cont.value = tmp;
        //byte.value = xcnt + ' / 80 bytes';
        bytes.innerHTML = xcnt + ' / ' + limit_num +' bytes';
        return;
    }
}
</script>

</form>

<script>
function fconfig_check(f)
{
    <?php echo get_editor_js('de_baesong_content'); ?>
    <?php echo get_editor_js('de_change_content'); ?>
    <?php echo get_editor_js('de_guest_privacy'); ?>

    return true;
}

$(function() {
    //$(".pg_info_fld").hide();
    $(".pg_vbank_url").hide();
    <?php if($default['de_pg_service']) { ?>
    //$(".<?php echo $default['de_pg_service']; ?>_info_fld").show();
    $("#<?php echo $default['de_pg_service']; ?>_vbank_url").show();
    <?php } else { ?>
    $(".kcp_info_fld").show();
    $("#kcp_vbank_url").show();
    <?php } ?>
    $(".de_pg_tab").on("click", "a", function(e){

        var pg = $(this).attr("data-value"),
            class_name = "tab-current";
        
        $("#de_pg_service").val(pg);
        $(this).parent("li").addClass(class_name).siblings().removeClass(class_name);

        //$(".pg_info_fld:visible").hide();
        $(".pg_vbank_url:visible").hide();
        //$("."+pg+"_info_fld").show();
        $("#"+pg+"_vbank_url").show();
        $(".scf_cardtest").addClass("scf_cardtest_hide");
        $("."+pg+"_cardtest").removeClass("scf_cardtest_hide");
        $(".scf_cardtest_tip_adm").addClass("scf_cardtest_tip_adm_hide");
        $("#"+pg+"_cardtest_tip").removeClass("scf_cardtest_tip_adm_hide");
    });

    $("#de_pg_service").on("change", function() {
        var pg = $(this).val();
        $(".pg_info_fld:visible").hide();
        $(".pg_vbank_url:visible").hide();
        $("."+pg+"_info_fld").show();
        $("#"+pg+"_vbank_url").show();
        $(".scf_cardtest").addClass("scf_cardtest_hide");
        $("."+pg+"_cardtest").removeClass("scf_cardtest_hide");
        $(".scf_cardtest_tip_adm").addClass("scf_cardtest_tip_adm_hide");
        $("#"+pg+"_cardtest_tip").removeClass("scf_cardtest_tip_adm_hide");
    });

    $(".scf_cardtest_btn").bind("click", function() {
        var $cf_cardtest_tip = $("#scf_cardtest_tip");
        var $cf_cardtest_btn = $(".scf_cardtest_btn");

        $cf_cardtest_tip.toggle();

        if($cf_cardtest_tip.is(":visible")) {
            $cf_cardtest_btn.text("테스트결제 팁 닫기");
        } else {
            $cf_cardtest_btn.text("테스트결제 팁 더보기");
        }
    });

    $(".get_shop_skin").on("click", function() {
        if(!confirm("현재 테마의 쇼핑몰 스킨 설정을 적용하시겠습니까?"))
            return false;

        $.ajax({
            type: "POST",
            url: "../theme_config_load.php",
            cache: false,
            async: false,
            data: { type: "shop_skin" },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                var field = Array('de_shop_skin', 'de_shop_mobile_skin');
                var count = field.length;
                var key;

                for(i=0; i<count; i++) {
                    key = field[i];

                    if(data[key] != undefined && data[key] != "")
                        $("select[name="+key+"]").val(data[key]);
                }
            }
        });
    });

    $(".shop_pc_index, .shop_mobile_index, .shop_etc").on("click", function() {
        if(!confirm("현재 테마의 스킨, 이미지 사이즈 등의 설정을 적용하시겠습니까?"))
            return false;

        var type = $(this).attr("class");
        var $el;

        $.ajax({
            type: "POST",
            url: "../theme_config_load.php",
            cache: false,
            async: false,
            data: { type: type },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                $.each(data, function(key, val) {
                    if(key == "error")
                        return true;

                    $el = $("#"+key);

                    if($el[0].type == "checkbox") {
                        $el.attr("checked", parseInt(val) ? true : false);
                        return true;
                    }
                    $el.val(val);
                });
            }
        });
    });
});
</script>

<?php
// 결제모듈 실행권한 체크
if($default['de_iche_use'] || $default['de_vbank_use'] || $default['de_hp_use'] || $default['de_card_use']) {
    // kcp의 경우 pp_cli 체크
    if($default['de_pg_service'] == 'kcp') {
        if(!extension_loaded('openssl')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("PHP openssl 확장모듈이 설치되어 있지 않습니다.\n모바일 쇼핑몰 결제 때 사용되오니 openssl 확장 모듈을 설치하여 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        if(!extension_loaded('soap') || !class_exists('SOAPClient')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("PHP SOAP 확장모듈이 설치되어 있지 않습니다.\n모바일 쇼핑몰 결제 때 사용되오니 SOAP 확장 모듈을 설치하여 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        $is_linux = true;
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            $is_linux = false;

        $exe = '/kcp/bin/';
        if($is_linux) {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe .= 'pp_cli';
            else
                $exe .= 'pp_cli_x64';
        } else {
            $exe .= 'pp_cli_exe.exe';
        }

        echo module_exec_check(G5_SHOP_PATH.$exe, 'pp_cli');

        // shop/kcp/log 디렉토리 체크 후 있으면 경고
        if(is_dir(G5_SHOP_PATH.'/kcp/log') && is_writable(G5_SHOP_PATH.'/kcp/log')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("웹접근 가능 경로에 log 디렉토리가 있습니다.\nlog 디렉토리를 웹에서 접근 불가능한 경로로 변경해 주십시오.\n\nlog 디렉토리 경로 변경은 SIR FAQ를 참고해 주세요.")'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }
    }

    // LG의 경우 log 디렉토리 체크
    if($default['de_pg_service'] == 'lg') {
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

    // 이니시스의 경우 log 디렉토리 체크
    if($default['de_pg_service'] == 'inicis') {
        if (!function_exists('xml_set_element_handler')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("XML 관련 함수를 사용할 수 없습니다.\n서버 관리자에게 문의해 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        if (!function_exists('openssl_get_publickey')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("OPENSSL 관련 함수를 사용할 수 없습니다.\n서버 관리자에게 문의해 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        if (!function_exists('socket_create')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("SOCKET 관련 함수를 사용할 수 없습니다.\n서버 관리자에게 문의해 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        if (!function_exists('mcrypt_module_open')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("MCRYPT 관련 함수를 사용할 수 없습니다.\n서버 관리자에게 문의해 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        $log_path = G5_SHOP_PATH.'/inicis/log';

        if(!is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(G5_PATH.'/', '', G5_SHOP_PATH).'/inicis 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        } else {
            if(!is_writable($log_path)) {
                echo '<script>'.PHP_EOL;
                echo 'alert("'.str_replace(G5_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
                echo '</script>'.PHP_EOL;
            }
        }
    }

    // 카카오페이의 경우 log 디렉토리 체크
    if($default['de_kakaopay_mid'] && $default['de_kakaopay_key'] && $default['de_kakaopay_enckey'] && $default['de_kakaopay_hashkey'] && $default['de_kakaopay_cancelpwd']) {
        $log_path = G5_SHOP_PATH.'/kakaopay/log';

        if(!is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(G5_PATH.'/', '', G5_SHOP_PATH).'/kakaopay 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
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
