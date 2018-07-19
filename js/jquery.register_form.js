var reg_mb_id_check = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: g5_bbs_url+"/ajax.mb_id.php",
        data: {
            "reg_mb_id": encodeURIComponent($("#reg_mb_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
    return result;
}


// 추천인 검사
var reg_mb_recommend_check = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: g5_bbs_url+"/ajax.mb_recommend.php",
        data: {
            "reg_mb_recommend": encodeURIComponent($("#reg_mb_recommend").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
    return result;
}


var reg_mb_nick_check = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: g5_bbs_url+"/ajax.mb_nick.php",
        data: {
            "reg_mb_nick": ($("#reg_mb_nick").val()),
            "reg_mb_id": encodeURIComponent($("#reg_mb_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
    return result;
}


var reg_mb_email_check = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: g5_bbs_url+"/ajax.mb_email.php",
        data: {
            "reg_mb_email": $("#reg_mb_email").val(),
            "reg_mb_id": encodeURIComponent($("#reg_mb_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
    return result;
}


var reg_mb_hp_check = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: g5_bbs_url+"/ajax.mb_hp.php",
        data: {
            "reg_mb_hp": $("#reg_mb_hp").val(),
            "reg_mb_id": encodeURIComponent($("#reg_mb_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
    return result;
}


$(function() {
    $(document).on("click", "form[name=fregisterform] input:submit, form[name=fregisterform] button:submit, form[name=fregisterform] input:image", function() {
        var f = this.form;
        var token = get_write_token('register');

        if(!token) {
            alert(aslang[41]); //토큰 정보가 올바르지 않습니다.
            return false;
        }

        var $f = $(f);

        if(typeof f.token === "undefined")
            $f.prepend('<input type="hidden" name="token" value="">');

        $f.find("input[name=token]").val(token);

        return true;
    });
});