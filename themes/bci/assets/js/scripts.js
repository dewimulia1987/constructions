var themeScripts = bci(function($){
	
	'use strict';
	
	var siteSetup = function() {
		var toggleClick = function() {
			$('a.toggle[data-toggle]').on('click', bciScripts.toggle);
		}
		
		var thumbviewitemsHeight = function() {

			if(bciScripts.isExist('.thumbview[data-column]') > 0) {
				$(window).on('load resize', function() {
					fixitemsHeight();
					bciScripts.elementHeight($('h4.title'));
                    bciScripts.elementHeight($('div.descriptions'));
				}).trigger('resize');
			}
	
		}

		var itemsSlider = function() {
	
			var items = '.bci-slider';
			
			if(bciScripts.isExist(items) > 0) {
				$(items).each(function() {
					var margin		= 20,
						responsive	= {
							0 : { 
								items		: 1,
								rewind		: true,
								nav			: false,
								dots		: true
							},
							480 : { 
								items		: 2,
								slideBy		: 'page',
								rewind		: true,
								nav			: false,
								dots		: true
							},
							640 : { 
								items		: 3,
								slideBy		: 'page',
								rewind		: true,
								nav			: false,
								dots		: true
							},
							1024 : { 
								items		: $(this).attr('data-column'),
								slideBy		: 'page',
								rewind		: true,
								nav			: false,
								dots		: true
							},
							1250 : { 
								items		: $(this).attr('data-column'),
								slideBy		: 'page',
								rewind		: true,
								nav			: true,
								dots		: false
							}
						};
					bciScripts.setCarousel($('.owl-carousel', this), responsive, margin);
				});
			}
	
		};
		
		var productGallery = function() {
		
			var gallery 	 = '#post-image .owl-carousel',
				galleryImage = '#photo_url',
				galleryDot	 = '#post-image .owl-carousel .owl-dot';
			
			if(bciScripts.isExist(gallery) > 0) {
				var margin		= 0,
					navText		= ['<i class="icon ti-angle-left"></i>','<i class="icon ti-angle-right"></i>'],
					responsive	= {
						0 : { 
							items				: 1,
							autoplay			: true,
							rewind				: true,
							nav					: true,
							dots				: true,
							onInitialized		: bciScripts.setCarouselThumbnails(jQuery(galleryImage).val(), galleryDot)
						},
						1250 : { 
							items				: 1,
							autoplay			: true,
							rewind				: true,
							nav					: true,
							dots				: true,
							autoplayHoverPause	: true,
							onInitialized		: bciScripts.setCarouselThumbnails(jQuery(galleryImage).val(), galleryDot)
						}
					}
				bciScripts.setCarousel(gallery, responsive, margin, '', navText);
			}
			
			/*
			var gallery 	 = '#gallery-slideshow';
			
			if(bciScripts.isExist(gallery) > 0) {

				slideInit();

				// Slide with thumbnail
				const gallery_slide_thumb_dom = '.single-slideshow-w-thumb';
				const main_gallery_slide_thumb_dom = '.main-slider';
				const main_gallery_single_thumb_container = main_gallery_slide_thumb_dom + ' .carousel';
				const main_single_thumb_nav = main_gallery_slide_thumb_dom + ' .slider-nav';

				const thumb_slide_dom = '.thumbnail-slider';
				const thumb_container = thumb_slide_dom + ' .carousel';
				const thumb_nav = thumb_slide_dom + ' .slider-nav';

				let responsive_thumb = {};

				// Slide with Thumbnail
				if ($(gallery_slide_thumb_dom).length) {
					tns({
						container: main_gallery_single_thumb_container,
						navContainer: thumb_container,
						navAsThumbnails: true,
						items: 1,
						center: true,
						mouseDrag: 'true',
						autoplay: false,
						loop: false,
						autoplayButtonOutput: false,
						controlsContainer: main_single_thumb_nav,
					});

					switch ($(thumb_slide_dom).data('slide')) {
						case 'three':
							responsive_thumb = {0: {items: 3}};
							break;
						case 'four':
							responsive_thumb = {0: {items: 3}, 993:{items: 4}};
							break;
						case 'five':
							responsive_thumb = {0: {items: 3}, 993:{items: 4}, 1024:{items: 5}};
							break;
						default:
							responsive_thumb = {0: {items: 2}};
							break;
					}

					tns({
						container: thumb_container,
						controlsContainer: thumb_nav,
						loop: false,
						responsive: responsive_thumb,
						mouseDrag: true,
						gutter: 30,
					});
				}
			}
			*/
		};
		
		return {

			init: function() {
				toggleClick();
				thumbviewitemsHeight();
				itemsSlider();
				productGallery();
			}

		}
		
	}();
	
	var header = function() {
		
		var animate = function() {

			var
			target		= 'body',
			header		= '#header',
			nav			= '#header .utilities',
			className	= 'onscroll',
			reference	= $(header).outerHeight(true) - $(nav).outerHeight(true),
			targetClass = function() {
				if($(window).scrollTop() > reference) {
					$(target).addClass(className);
				} else {
					$(target).removeClass(className);
				}
			},
			animateIt	= function() {
				$(document).on('ready scroll', function() {
					targetClass();
				});
			}
			return (
				animateIt()
			)

		}
		
		var navigation = function() {

			var findSubmenu = function() {
					$('#menu ul.menu li').each(function() {
						if($('.sub-menu',this).length) {
							$('<span class="toggle-submenu hidden"><i class="icon fa fa-angle-down"></i></span>').appendTo($('> a',this));
						}
					});
				},
				expandSubmenu = function() {
					$('.toggle-submenu').on('click', function(e){
						e.preventDefault();
						$('#menu li').not($(this).parents('li')).removeClass('expand');
						$(this).closest('li').toggleClass('expand');
					});
				}
			return (
				findSubmenu(),
				expandSubmenu()
			)

		}
		
		var shopping_cart = function() {
			if(bciScripts.isExist('.cart-menu a') > 0) {
				if(cart == '1'){
					jQuery('.cart-menu a').html('<i class="icon ti-shopping-cart-full color-red color-red-hover"></i>');					
				}
				else{
					jQuery('.cart-menu a').html('<i class="icon ti-shopping-cart"></i>');
				}
			}
			jQuery('#add-to-cart-btn').click(function() {
				var id = jQuery(this).attr('data-id');
				var data = {
					'action': 'add_to_cart',
					'id': id
				};
				jQuery.post(ajax_object.ajax_url, data, function( response ) {
					if ( response ) {
						if(cart == '0')jQuery('.cart-menu a').html('<i class="icon ti-shopping-cart-full color-red color-red-hover"></i>');
						jQuery('.success_message').html('<em>Successfully added to cart</em>');
					}
				});
			});
			jQuery('.delete-btn').click(function() {
				var id = jQuery(this).attr('data-id');
				jQuery(this).parent().parent().remove();
				var data = {
					'action': 'remove_from_cart',
					'delete_all': 1,
					'id': id
				};
				jQuery.post(ajax_object.ajax_url, data, function( response ) {
					if ( response == '0' ) {
						calculate_cart();
					}
					else
						jQuery('.shopping-cart').html('<p class="error text-center color-red font-weight-500"><em>Your cart is empty</em></p>');
				});
			});
			jQuery('.plus-btn').click(function() {
				var id = jQuery(this).attr('data-id');
				
				var $this = jQuery(this);
				var $input = $this.closest('div').find('input');
				var value = parseInt($input.val());
				
				value = value + 1;
				$input.val(value);
				jQuery(this).parent().parent().attr('data-qty',value);

				var data = {
					'action': 'add_to_cart',
					'id': id
				};
				jQuery.post(ajax_object.ajax_url, data, function( response ) {
					if ( response ) {
						calculate_cart();
					}
					else {
						jQuery('.shopping-cart').html('<p class="error text-center color-red font-weight-500"><em>Your cart is empty</em></p>');
					}
				});
			});
			jQuery('.minus-btn').click(function() {	
				var id = jQuery(this).attr('data-id');
				
				var $this = jQuery(this);
				var $input = $this.closest('div').find('input');
				var value = parseInt($input.val());

				if (value > 1) {
					value = value - 1;
					$input.val(value);
					jQuery(this).parent().parent().attr('data-qty',value);
				} else {
					value = 0;
					jQuery(this).parent().parent().remove();
				}				
				
				var data = {
					'action': 'remove_from_cart',
					'id': id
				};
				jQuery.post(ajax_object.ajax_url, data, function( response ) {
					if ( response ) {
						calculate_cart();
					}
					else {
						jQuery('.shopping-cart').html('<p class="error text-center color-red font-weight-500"><em>Your cart is empty</em></p>');
					}
				});
			});
		}
		
		var load_more_product = function() {
			jQuery('#load-more-product').click(function() {
				var category = jQuery(this).attr('data-category');
				var page = jQuery(this).attr('data-page');
				var max = jQuery(this).attr('data-max');
				page = parseInt(page) + 1;
				
				if(page == max)jQuery(this).parent().remove();
				
				var data = {
					'action': 'load_product',
					'category': category,
					'page': page
				};
				
				jQuery.post(ajax_object.ajax_url, data, function( response ) {
					if ( response ) {
						jQuery('#product_list').append(response.html);
					}
				});
			});
		}
		
		return {

			init: function() {
				animate();
				navigation();
				shopping_cart();
				load_more_product();
			}

		}
		
	}();
	
	var pages = function() {
		var pageHome = function() {

			if(bciScripts.isExist('#page.homepage') > 0) {
				var itemsCarousel = function() {
					$(window).on('load resize', function(){
						$('.bci-slider').each(function() {
                            bciScripts.elementHeight($('h4.title', this));
                            bciScripts.elementHeight($('div.descriptions', this));
                        });
					});
				};
				return (
					itemsCarousel()
				);
			}

		}
	return {

			init: function() {
				pageHome();
			}

		}
		
	}();
		
	function fixitemsHeight() {
		
		var items	= '.thumbview[data-column] .items:visible',
			target	= 'h3.title',
			columns	= $(items).closest('div[data-column]').attr('data-column'),
			child	= '',
			fixIt 	= function() {
				bciScripts.thumbnailHeight(items, target, columns, child);
			};
		return (
			fixIt()
		)
			
	}
	
	function calculate_cart(){
		var total_price = 0;
		jQuery('.shopping-cart .item').each(function(){
			var price = jQuery(this).attr('data-price');
			var qty = jQuery(this).attr('data-qty');
			if(price && qty)total_price += parseInt(price) * parseInt(qty) ;
			
		});
		jQuery('#total-price').html(parseInt(total_price).formatMoney());
	}
	
	Number.prototype.formatMoney = function(n, x) {
		var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
		return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
	}
	
	
	return {

		init: function() {
			siteSetup.init();
			header.init();
			pages.init();
		},

	}
	
}(jQuery));

