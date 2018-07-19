$(document).ready(function() {

	var allPanels = $('.apms-accordion > dd').hide();

	$('.apms-accordion > dd.active').show();

	$('.apms-accordion > dt > a').click(function() {
		$this = $(this);
		$target =  $this.parent().next();

		if(!$target.hasClass('active')){
			allPanels.removeClass('active').slideUp('fast');
			$('.apms-accordion > dt').removeClass('open');
			$target.addClass('active').slideDown('fast');
			$this.parent().addClass('open');
			$('.apms-accordion > dt > a > span').removeClass().addClass('plus');
			$this.children('span').addClass('minus');
		}

		return false;
	});
});	