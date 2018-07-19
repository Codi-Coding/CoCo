function apms_colorset(t_id, s_id, c_id, size) {
	$.get("./apms.colorset.php?t_id="+t_id+"&c_id="+c_id+"&size="+size, function (data) {
		$("#"+s_id).html(data);
	});
}

function apms_token(url) {
	var token = get_ajax_token();
	var href = url.replace(/&token=.+$/g, "");
	if(!token) {
		alert("토큰 정보가 올바르지 않습니다.");
		return false;
	} else {
		href = href+"&token="+token;
	    document.location.href = encodeURI(href);
	}
	return false;
}

function apms_open(id) {
	var oid = $("#" + id);
	if(oid.is(":visible")){
		oid.hide();
	} else {
		oid.show();
	}
	return false;
}

$(function(){
    $(".apms-del").click(function() {
	    if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
		    document.location.href = encodeURI(this.href);
		}
        return false;
    });
    $(".apms-confirm").click(function() {
		apms_token(this.href);
		return false;
    });
});
