function bci(module){
	
	jQuery(function() {
		if (module.init ) {
			module.init();
		}
	});
	
	return module;

}

var bciScripts = bci(function($){

	'use strict';
	
	var mpLightbox = function() {

		if(isElementExist('[class*="mfp-"]') > 0) {
			$('.mfp-inline').magnificPopup({
				type: 'inline',
			});
			$('.mfp-ajax').magnificPopup({
				type: 'ajax',
			});
			$('.mfp-iframe').magnificPopup({
				type: 'iframe',
			});
			$('.mfp-gallery').each(function() {
				$(this).magnificPopup({
					delegate: 'a',
					type: 'image',
					tLoading: 'Loading image #%curr%...',
					mainClass: 'mfp-image',
					gallery: {
					  enabled: true
					},
					image: {
						verticalFit: false
					}
				});
			});
		}

	}

	function isElementExist(element) {
		
		return (
			$(element).length
		)
		
	}
	
	function fixHeight(thumbnail, target, rowColumns, child) {
		
		var viewportWidth	 = document.body.clientWidth,
			viewportHeight	 = document.body.clientHeight,
			changeHeight	 = function() {
				if(viewportWidth >= 768 || (viewportWidth < 768 && (viewportWidth > viewportHeight))) {
					$(thumbnail).removeAttr('data-row').find(target).removeAttr('style');
					if(child.length) $(thumbnail).find(child).removeAttr('style');
					var i			= 0,
						j			= 0,
						items		= $(thumbnail).length,
						colperrow	= (viewportWidth < 1024) ? 2 : rowColumns,
						totalrow	= items / colperrow;
					for(i = 0; i < items; i++) {
						$(thumbnail).eq(i).attr('data-row', j);
						if(i % colperrow == colperrow - 1) j++;
					}
					for(i = 0; i< totalrow; i++) {
						var a = 0;
						$(thumbnail + '[data-row="'+i+'"] ' + target).each(function() {
							if($(this).outerHeight() > a) a = $(this).outerHeight();
						}).css('height', a);
						if(child.length) {
							var b = 0;
							$(thumbnail + '[data-row="'+i+'"] ' + child).each(function() {
								if($(this).outerHeight() > b) b = $(this).outerHeight();
							}).css('height', b);
						}
					}
				} else {
					$(thumbnail).removeAttr('data-row').find(target).removeAttr('style');
					if(child.length) $(thumbnail).find(child).removeAttr('style');
				}
			};
		return (
			changeHeight()
		)
	
	}
	
	function fixElementHeight(target) {
		
		var height	= 0,
			fixIt	= function() {
				target.css('min-height', '').each(function() {
					if($(this).outerHeight(true) > height)
						height = $(this).outerHeight(true)
				}).css('min-height', height);
			}
		return(
			fixIt()
		)
			
	}
	
	function carousel(tag, responsive, margin, animateOut, navText) {
		
		var tag			= tag,
			responsive	= (responsive) ? responsive : false,
			margin		= (margin) ? margin : 0,
			animateOut	= (animateOut) ? animateOut : false,
			navText		= (navText) ? navText : ['<i class="icon ti-angle-left"></i>','<i class="icon ti-angle-right"></i>'];
		
		var owlIt = function() {
			$(tag).owlCarousel({
				loop        : true,
				responsive	: responsive,
				margin		: margin,
				animateOut	: animateOut,
				navText		: navText,
			});
		};
		
		return (
			owlIt()
		)
		
	}
	
	function carouselThumbnails(image, dot) {
		
		var setThumbnails = function() {
			$(window).on('load', function() {
				var photos = image.split(",");
				photos.forEach(function (item, index) {
					if(item){
						index += 1;
						$(dot + ':nth-child(' + index + ') span').attr('style', 'background-image:url(' + item + ');');
					}
				});	
			});
		};
		
		return (
			setThumbnails()
		)
		
	}
	
	function toggling(e) {

		e.preventDefault();
		var active			= $(this).attr('data-toggle'),
			wasActive		= $('a.toggle.active').attr('data-toggle'),
			toggleItems		= 'a.toggle[data-toggle]',
			//toggleContent	= 'div[data-toggle]',
			toggleContent	= 'div[data-toggle="' + active + '"]',
			activateItem	= function() {
				$(toggleItems).each(function() {
					if($(this).attr('data-toggle') == active) {
						$(this).toggleClass('active');
						$('body').toggleClass('expand-' + active);
					} else
						$(this).removeClass('active');
				});
			},
			/*activateContent = function() {
				$(toggleContent).each(function() {
					if($(this).attr('data-toggle') == active)
						$(this).toggleClass('collapse');
					else
						$(this).addClass('collapse');
				});
			},*/
			activateContent = function() {
				$(toggleContent).toggleClass('collapse');
			},
			clearBodyClass = function() {
				if(typeof wasActive !== typeof undefined) {
					$('body').removeClass('expand-' + wasActive);
				}
			};
		return (
			activateItem(),
			activateContent(),
			clearBodyClass()
		)

	}
	
	return {
		
		init: function() {
			mpLightbox();
		},
		
		isExist					: isElementExist,
		thumbnailHeight			: fixHeight,
		elementHeight			: fixElementHeight,
		setCarousel				: carousel,
		setCarouselThumbnails	: carouselThumbnails,
		toggle					: toggling,
		
	}

}(jQuery));