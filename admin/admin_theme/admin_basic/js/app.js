var App = function () {

    function handleViewport(){
		$("input, textarea, select, button, i, div.note-editing-area, span.select2-selection, .calendar-time, ul.tag-editor, div.asSpinner-control").on({ 'touchstart' : function() {
			zoomDisable();
		}});
		$("input, textarea, select, button, i, div.note-editing-area, span.select2-selection, .calendar-time, ul.tag-editor, div.asSpinner-control").on({ 'touchend' : function() {
			setTimeout(zoomEnable, 500);
		}});
		function zoomDisable(){
			$('head meta[name=viewport]').remove();
			$('head').prepend('<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">');
		}
		function zoomEnable(){
			$('head meta[name=viewport]').remove();
			$('head').prepend('<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1">');
		}
	}

	function handleLayout(){
		(function($,sr){
		    var debounce = function (func, threshold, execAsap) {
		      var timeout;

		        return function debounced () {
		            var obj = this, args = arguments;
		            function delayed () {
		                if (!execAsap)
		                    func.apply(obj, args);
		                timeout = null;
		            }

		            if (timeout)
		                clearTimeout(timeout);
		            else if (execAsap)
		                func.apply(obj, args);

		            timeout = setTimeout(delayed, threshold || 100);
		        };
		    };
		    jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
		})(jQuery,'smartresize');

		var $WRAPPER = $('.wrapper'),
		    $TOPBAR_TOGGLE = $('#topbar-toggle'),
		    $SIDEBAR_MENU = $('#sidebar-menu'),
		    $SIDEBAR_FOOTER = $('.sidebar-footer'),
		    $LEFT_AREA = $('.left-area'),
		    $RIGHT_AREA = $('.right-area'),
		    $TOPBAR_NAV = $('.topbar-nav'),
		    $FOOTER = $('.footer');

		$(document).ready(function() {
		    var setContentHeight = function () {
		        $RIGHT_AREA.css('min-height', $(window).height());
		        var wrapperHeight = $WRAPPER.outerHeight(),
		            footerHeight = $WRAPPER.hasClass('footer-fixed') ? -10 : $FOOTER.height(),
		            leftAreaHeight = $LEFT_AREA.eq(1).height() + $SIDEBAR_FOOTER.height(),
		            contentHeight = wrapperHeight < leftAreaHeight ? leftAreaHeight : wrapperHeight;

		        contentHeight -= $TOPBAR_NAV.height() + footerHeight;
		        $RIGHT_AREA.css('min-height', contentHeight);
		    };

	        if ($WRAPPER.hasClass('sidebar-expand')) {
		        if ($SIDEBAR_MENU.find('li').is('.active')) {
			        $SIDEBAR_MENU.find('li.active ul').slideDown(function() {
		                setContentHeight();
		            });
		        }
	        } else {
		        if ($SIDEBAR_MENU.find('li').is('.active')) {
			        $SIDEBAR_MENU.find('li.active').addClass('active-min').removeClass('active');
			    }
	        }

		    $SIDEBAR_MENU.find('a').on('click', function() {
		        var $li = $(this).parent();
		        if ($li.is('.active')) {
		            $li.removeClass('active');
		            $('ul:first', $li).slideUp(function() {
		                setContentHeight();
		            });
		        } else {
		            if (!$li.parent().is('.sidebar-submenu')) {
		                $SIDEBAR_MENU.find('li').removeClass('active');
		                $SIDEBAR_MENU.find('li ul').slideUp();
		            }
		            $li.addClass('active');
		            $('ul:first', $li).slideDown(function() {
		                setContentHeight();
		            });
		        }
		    });

		    $TOPBAR_TOGGLE.on('click', function() {
		        if ($WRAPPER.hasClass('sidebar-expand')) {
		            $SIDEBAR_MENU.find('li.active ul').hide();
		            $SIDEBAR_MENU.find('li.active').addClass('active-min').removeClass('active');
		        } else {
		            $SIDEBAR_MENU.find('li.active-min ul').show();
		            $SIDEBAR_MENU.find('li.active-min').addClass('active').removeClass('active-min');
		        }
		        $WRAPPER.toggleClass('sidebar-expand sidebar-min');
		        setContentHeight();
		    });

		    $(window).smartresize(function(){
		        setContentHeight();
		    });
		    setContentHeight();

		    if ($.fn.mCustomScrollbar) {
		        $('.side-fixed').mCustomScrollbar({
		            autoHideScrollbar: true,
		            theme: 'minimal',
		            mouseWheel:{ preventDefault: true }
		        });
		    }
		});
	}

	function handleIEFixes(){
        //fix html5 placeholder attribute for ie7 & ie8
        if (jQuery.browser.msie && jQuery.browser.version.substr(0, 1) < 9) { // ie7&ie8
            $('input[placeholder], textarea[placeholder]').each(function () {
                var input = jQuery(this);
                $(input).val(input.attr('placeholder'));
                $(input).focus(function () {
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                });
                $(input).blur(function () {
                    if (input.val() == '' || input.val() == input.attr('placeholder')) {
                        input.val(input.attr('placeholder'));
                    }
                });
            });
        }
    }

    function handleBootstrap(){
        /*Tooltips*/
        $('.tooltips').tooltip();
        $('.tooltips-show').tooltip('show');
        $('.tooltips-hide').tooltip('hide');
        $('.tooltips-toggle').tooltip('toggle');
        $('.tooltips-destroy').tooltip('destroy');
        /*Popovers*/
        $('.popovers').popover();
        $('.popovers-show').popover('show');
        $('.popovers-hide').popover('hide');
        $('.popovers-toggle').popover('toggle');
        $('.popovers-destroy').popover('destroy');
    }

    function handleToggle(){
        $('.list-toggle').on('click', function() {
            $(this).toggleClass('active');
        });
    }

	function handleBackToTop(){
		jQuery(document).ready(function () {
			$(".back-to-top").addClass("hidden-top");
				$(window).scroll(function () {
				if ($(this).scrollTop() === 0) {
					$(".back-to-top").addClass("hidden-top")
				} else {
					$(".back-to-top").removeClass("hidden-top")
				}
			});

			$('.back-to-top').click(function () {
				$('body,html').animate({scrollTop:0}, 1200);
				return false;
			});
		});
	}

    function handleWaves(){
		Waves.init();
	}

    function handleScreenFull(){
		$('.screenfull').on('click', function(){
		    if (screenfull.enabled) {
		        screenfull.toggle();
		    }
		});
	}

    return {
        init: function(){
	        handleViewport();
	        handleLayout();
	        handleIEFixes();
            handleBootstrap();
            handleToggle();
            handleBackToTop();
            handleWaves();
            handleScreenFull();
        },
    };

}();