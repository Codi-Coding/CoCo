function kakaolink_send(text, url, img, img_w, img_h) {

	if(img == '') img = '';
	if(img_w == '') img_w = 300;
	if(img_h == '') img_h = 200;

    // 카카오톡 링크 버튼을 생성합니다. 처음 한번만 호출하면 됩니다.
	if(img) {
		Kakao.Link.sendTalkLink({
		  label: String(text),
		  image: {
			src: img,
			width: img_w,
			height: img_h
		  },
		  webButton: {
			text: String('자세히 보기'), //카톡 링크시 타이틀
			url : url // 앱 설정의 웹 플랫폼에 등록한 도메인의 URL이어야 합니다.
		  }
		});
	} else {
		Kakao.Link.sendTalkLink({
		  label: String(text),
		  webButton: {
			text: String('자세히 보기'), //카톡 링크시 타이틀
			url : url // 앱 설정의 웹 플랫폼에 등록한 도메인의 URL이어야 합니다.
		  }
		});
	}
}