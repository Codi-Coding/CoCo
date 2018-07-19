/*
** 2010.03.12 : jQuery 로 대체하여 앞으로 사용하지 않습니다.
*/

if (typeof(KCAPTCHA_JS) == 'undefined') // 한번만 실행
{
    if (typeof g5_url == 'undefined')
        alert('g5_url 변수가 선언되지 않았습니다. js/kcaptcha.js');

    var KCAPTCHA_JS = true;

	var md5_norobot_key = '';

	function imageClick() {
		var url = g5_url+"/"+g5_bbs+"/kcaptcha_session.php";
		var para = "";
		var myAjax = new Ajax.Request(
			url, 
			{
				method: 'post', 
				asynchronous: true,
				parameters: para, 
				onComplete: imageClickResult
			});
	}

	function imageClickResult(req) { 
		var result = req.responseText;
		var img = document.createElement("IMG");
		img.setAttribute("src", g5_url+"/"+g5_bbs+"/kcaptcha_image.php?t=" + (new Date).getTime());
		document.getElementById('kcaptcha_image').src = img.getAttribute('src');

		md5_norobot_key = result;
	}

	Event.observe(window, "load", imageClick);
}
