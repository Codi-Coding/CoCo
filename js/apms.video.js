/*!
 * AMINA YouTube Video Modal Player
 * http://amina.co.kr/
 * Copyright 2013-2015, AMINA
 * Released under the APMS Licenses
 *
 * Date: May 27 2015
 */

function apms_video(videoID, videoContent, videoSize){

	if(!videoSize) videoSize = '56.25%'

	$("#apmsVideoWrap").css('padding-bottom', videoSize);
	$('#apmsVideoPlayer').attr('src', 'https://www.youtube.com/embed/' + videoID + '?autohide=1&autoplay=1&vq=hd720&loop=1');
	$('#apmsVideoContent').html(videoContent);
	$('#apmsVideoModal').modal('show')

	return false;
}

$(function(){
	$('#apmsVideoModal').on('hidden.bs.modal', function () {
		$('#apmsVideoPlayer').attr('src', '');
		$('#apmsVideoContent').text('');
	});
});
