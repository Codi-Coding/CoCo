<div id="ins_ft">
    <strong>EYOOM BUILDER</strong>
    <p>FOR GPL! OPEN SOURCE GNUBOARD</p>
</div>

<script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
<script>
function check_form(f) {
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
		return false;
	}
}

function set_theme(data) {
	var f = document.installform;
	if(data.cm_key) {
		if (data.cm_key) f.cm_key.value = data.cm_key;
		if (data.cm_salt) f.cm_salt.value = data.cm_salt;
		if (data.tm_name) f.tm_name.value = data.tm_name;
		if (data.tm_shop) f.tm_shop.value = data.tm_shop;
		if (data.tm_community) f.tm_community.value = data.tm_community;
		if (data.tm_mainside) f.tm_mainside.value = data.tm_mainside;
		if (data.tm_subside) f.tm_subside.value = data.tm_subside;
		f.submit();
	} else {
		alert(data.msg);
		f.tm_key.focus();
		f.tm_key.select();
		return false;
	}
}
</script>

</body>
</html>