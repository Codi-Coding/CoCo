/* ================================================================= */
/* Thema Setup
====================================================================== */

function switcher_background(type, fid, cid, url) {
	if(type == "html") {
		$("body").css("background-image", "url('" + url + "')");
	} else {
		$("." + cid).attr("style", "background-image:url('" + url + "')");
	}
	$("#" + fid).val(url);
	return false;
}

function switcher_bgcolor(color) {
	$("body").css("background-color", color.toHexString());
	return false;
}

jQuery(document).ready(function($) {

	//Switcher Open & Close
	$(".layout-setup").click(function(e){
		e.preventDefault();
		var div = $("#style-switcher");
		if (div.css("left") === "-206px") {
			$("#style-switcher").animate({
				left: "0px"
			}); 
		} else {
			$("#style-switcher").animate({
				left: "-206px"
			});
		}
	});

	//ColorSet Style
	$("#colorset-style").change(function(e){
		var new_colorset = $(this).val();
		$(".thema-colorset" ).attr("href", sw_url + "/colorset/" + new_colorset + "/colorset.css");
		return false;
	});

	$("#font-style").click(function(){
		if($(this).is(":checked")) {
			$(".wrapper").removeClass("ko");
			$(".wrapper").addClass("en");
		} else {
			$(".wrapper").removeClass("en");
			$(".wrapper").addClass("ko");
		}
	});

	//Layout Style
	$("#layout-style").change(function(e){
		if($(this).val() == "boxed"){
			$(".wrapper").addClass("boxed");
		} else{
			$(".wrapper").removeClass("boxed"); 
		}
	});

	//PC Style
	$("#pc-style").change(function(e){
		if($(this).val()) {
			$(".thema-mode").attr("href", sw_url + "/assets/bs3/css/bootstrap-apms.min.css");
			$("body").removeClass("responsive");
			$("body").addClass("no-responsive");
		} else {
			$(".thema-mode").attr("href", sw_url + "/assets/bs3/css/bootstrap.min.css");
			$("body").removeClass("no-responsive");
			$("body").addClass("responsive");
		}
	});

	//Background Style
	$("#back-style").change(function(e){
		$("body").removeClass("body-background-top");
		$("body").removeClass("body-background-bottom");
		$("body").removeClass("body-background-center");
		$("body").removeClass("body-background-fixed");
		$("body").removeClass("body-background-pattern");
		$("body").addClass('body-background-' + $(this).val());
	});

    $('.switcher-win').click(function() {
		var new_win = window.open(this.href, 'win_switcher', 'left=100,top=100,width=600, height=600, scrollbars=1');
		new_win.focus();
        return false;
    });

});