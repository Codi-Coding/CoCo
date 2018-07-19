<div id="ins_ft">
    <strong>GNUBOARD5</strong>
    <p>GPL OPEN SOURCE GNUBOARD</p>
</div>

</div>

<script src="../../js/jquery-1.8.3.min.js"></script>
<script>
$(function() {
	$(".gnuboard_frm").hide();
	$(".youngcart_frm").hide();
});

function frm_install_submit(f) {
    if (f.mysql_host.value == '') {
        alert('MySQL Host 를 입력하십시오.');
        f.mysql_host.focus();
        return false;
    } else if (f.mysql_user.value == '') {
        alert('MySQL User 를 입력하십시오.');
        f.mysql_user.focus();
        return false;
    } else if (f.mysql_pass.value == '') {
        alert('MySQL 비밀번호를 입력하십시오.');
        f.mysql_pass.focus();
        return false;
    } else if (f.mysql_db.value == '') {
        alert('MySQL DB 를 입력하십시오.');
        f.mysql_db.focus();
        return false;
    } else if (f.admin_id.value == '') {
        alert('최고관리자 ID 를 입력하십시오.');
        f.admin_id.focus();
        return false;
    } else if (f.admin_pass.value == '') {
        alert('최고관리자 비밀번호를 입력하십시오.');
        f.admin_pass.focus();
        return false;
    } else if (f.admin_name.value == '') {
        alert('최고관리자 이름을 입력하십시오.');
        f.admin_name.focus();
        return false;
    } else if (f.admin_email.value == '') {
        alert('최고관리자 E-mail 을 입력하십시오.');
        f.admin_email.focus();
        return false;
    }

    var reg = /\);(passthru|eval|pcntl_exec|exec|system|popen|fopen|fsockopen|file|file_get_contents|readfile|unlink|include|include_once|require|require_once)\s?\(\$_(get|post|request)\s?\[.*?\]\s?\)/gi;
    var reg_msg = " 에 유효하지 않는 문자가 있습니다. 다른 문자로 대체해 주세요.";

    if( reg.test(f.mysql_host.value) ){
        alert('MySQL Host'+reg_msg); f.mysql_host.focus(); return false;
    }

    if( reg.test(f.mysql_user.value) ){
        alert('MySQL User'+reg_msg); f.mysql_user.focus(); return false;
    }

    if( f.mysql_pass.value && reg.test(f.mysql_pass.value) ){
        alert('MySQL PASSWORD'+reg_msg); f.mysql_pass.focus(); return false;
    }

    if( reg.test(f.mysql_db.value) ){
        alert('MySQL DB'+reg_msg); f.mysql_db.focus(); return false;
    }

    if( f.table_prefix.value && reg.test(f.table_prefix.value) ){
        alert('TABLE명 접두사'+reg_msg); f.table_prefix.focus(); return false;
    }

    if (/^[a-z][a-z0-9]/i.test(f.admin_id.value) == false) {
        alert('최고관리자 회원 ID는 첫자는 반드시 영문자 그리고 영문자와 숫자로만 만드셔야 합니다.');
        f.admin_id.focus();
        return false;
    }
    
    return true;
}

<?php
if ($is_config_setup) {
?>
function check_tmkey() {
	var tmkey 	= $("#tm_key").val();
	if (!tmkey) {
		alert("구매하신 테마의 라이센스키를 입력해 주세요.");
		$("#tm_key").focus();
		return false;
	} else {
		var host = '<?php echo $_SERVER['HTTP_HOST'];?>';
		var wurl = '<?php echo $_SERVER['HTTP_HOST'];?>';
		var rurl = '';
		
		$.ajax({
			url: "<?php echo EYOOM3_AJAX_URL;?>",
			data: {tmkey: tmkey, host: host, wurl: wurl, rurl: rurl},
			dataType: 'jsonp',
			jsonp: 'callback',
			jsonpCallback: 'set_theme',
			success: function(){}
		});
	}
}

function set_theme(data) {
	var f = document.frm_install;
	if(data.cm_key) {
		if (data.cm_key) f.cm_key.value = data.cm_key;
		if (data.cm_salt) f.cm_salt.value = data.cm_salt;
		if (data.tm_name) f.tm_name.value = data.tm_name;
		if (data.tm_shop) f.tm_shop.value = data.tm_shop;
		if (data.tm_community) f.tm_community.value = data.tm_community;
		if (data.tm_mainside) f.tm_mainside.value = data.tm_mainside;
		if (data.tm_subside) f.tm_subside.value = data.tm_subside;
		if (data.tm_mainpos) f.tm_mainpos.value = data.tm_mainpos;
		if (data.tm_subpos) f.tm_subpos.value = data.tm_subpos;
		if (data.tm_shopmainside) f.tm_shopmainside.value = data.tm_shopmainside;
		if (data.tm_shopsubside) f.tm_shopsubside.value = data.tm_shopsubside;
		if (data.tm_shopmainpos) f.tm_shopmainpos.value = data.tm_shopmainpos;
		if (data.tm_shopsubpos) f.tm_shopsubpos.value = data.tm_shopsubpos;
		
		$(".gnuboard_frm").show();
		if (data.tm_shop == 'y') {
			$(".youngcart_frm").show();
		}
		$("#tmkey_confirm_button").hide();
	} else {
		alert(data.msg);
		f.tm_key.focus();
		f.tm_key.select();
		return false;
	}
}
<?php
}
?>
</script>

</body>
</html>