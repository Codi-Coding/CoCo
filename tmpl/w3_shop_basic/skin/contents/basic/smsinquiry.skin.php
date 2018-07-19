<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_CONTENTS_SKIN_URL.'/style.css">', 0);
?>

<div class="sideMenu">
    <div id="msg">
        <header><?php echo _t('문의하기'); ?></header>
        <form name="fsmsinquiry" method="post" action="<?php echo $action_url; ?>" onsubmit="return fsubmit_check(this);" autocomplete="off">
        <fieldset>
            <label for="s_content" class="lb_text"><?php echo _t('문의내용'); ?></label>
            <textarea name="s_content" id="s_content" class="sms_relf"></textarea>
            <div id="c_p">
                <label for="s_tel" class="lb_num"><?php echo _t('연락처'); ?></label>
                <input type="text" name="s_tel" id="s_tel"  class="ipt_gr sms_relf" >
            </div>
            <div id="c_n">
                <label for="s_name" class="lb_name"><?php echo _t('성함'); ?></label>
                <input type="text" name="s_name" id="s_name" class="ipt_gr sms_relf">
            </div>
            <input type="submit" id="c_send" value="<?php echo _t('전송'); ?>">
        </fieldset>
        </form>
    </div>
</div>

<script>
$(function() {
    $(".sms_relf").on("focus", function() {
        $("label[for='"+this.id+"']").css('visibility','hidden');
    });

    $(".sms_relf").on("blur", function() {
        var txt = $.trim($(this).val());

        if(txt == "")
            $("label[for='"+this.id+"']").css('visibility','visible');
    });
});

function fsubmit_check(f)
{
    var content, tel, name;
    var action_url = f.action;

    content = $.trim(f.s_content.value);
    tel     = $.trim(f.s_tel.value);
    name    = $.trim(f.s_name.value);

    if(!content) {
        alert("<?php echo _t('문의내용을 입력해 주십시오.'); ?>");
        return false;
    }

    if(content.length > 40) {
        alert("<?php echo _t('문의내용을 40자 이내로 입력해 주십시오.'); ?>");
        return false;
    }

    if(!tel) {
        alert("<?php echo _t('연락처를 입력해 주십시오.'); ?>");
        return false;
    }

    if(!name) {
        alert("<?php echo _t('성함을 입력해 주십시오.'); ?>");
        return false;
    }

    $.post(
        action_url,
        { content: content, tel: tel, name:name, ajax: 1 },
        function(data) {
            if(data == "Fail") {
                alert("<?php echo _t('SMS 설정 오류로 문의내용을 전송할 수 없습니다.').'\n\n'._t('사이트 관리자에게 문의해 주십시오.'); ?>");
                document.location.reload();
                return false;
            } else if(data == "OK") {
                f.s_content.value = "";
                f.s_tel.value = "";
                f.s_name.value = "";
                $(f).find("label").css('visibility','visible');

                alert("<?php echo _t('고객님의 문의가 정상적으로 접수되었습니다.'); ?>");
            } else {
                alert(data);
                return false;
            }
        }
    );

    return false;
}
</script>
