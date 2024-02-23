class ProductCategorySlider extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				slidesContainer: '.elementor-widget-container-wrapper .elementor-element-wrapper',
				slide: '.swiper-slide',
			}
		}
	}

	getDefaultElements() {
		const selectors = this.getSettings('selectors');
		const elements = {
			$swContainer: this.$element.find(selectors.slidesContainer)
		};

		return elements;
	}

	async initSlider() {
		const $sliders = this.elements.$swContainer;
		
		if ($sliders.length > 1) {

			$sliders.each( async function( index, element ) {
				const $current = jQuery(this);

				if ($current.find('.swiper-slide').length <= 2) {
					$current.addClass('no-slide')
				}
				const Swiper = elementorFrontend.utils.swiper;
				this.swiper = await new Swiper($current.find('.elementor-main-swiper'), {
					slidesPerView: 2,
					spaceBetween: 5,
					pagination: {
    					el: $current.find('.swiper-pagination')[0],
    					type: "fraction",
  					},
					navigation: {
						nextEl: $current.find('.swiper-button-next')[0],
					    prevEl: $current.find('.swiper-button-prev')[0],
					},
					scrollbar: {
						el: '.swiper-scrollbar',
					},
					breakpoints: {
						10: {
							slidesPerView: 1,
							spaceBetween: 5,
						},
						768: {
							slidesPerView: 1,
							spaceBetween: 5,
						},
						1024: {
							slidesPerView: 2,
							spaceBetween: 5,
						}
					}
				});

				$current.find('.elementor-main-swiper').data('swiper', this.swiper);

				$current.find('.navigation-prev')[0].addEventListener('click', function () {
					const swiper = $current.find('.elementor-main-swiper').data('swiper');
					if (swiper) {
						swiper.slidePrev();
					}
				});

				$current.find('.navigation-next')[0].addEventListener('click', function () {
					const swiper = $current.find('.elementor-main-swiper').data('swiper');
					if (swiper) {
						swiper.slideNext();
					}
				});

				this.swiper.on('slideChangeTransitionStart', function () {
			      //console.log('slideChangeTransitionStart....');
			    });

			    this.swiper.on('slideChangeTransitionEnd', function () {
			    	//console.log('slideChangeTransitionEnd....');
			    });
			});
		} else {

			if ($sliders.find('.elementor-main-swiper').length === 0) {
				return;
			}
			const Swiper = elementorFrontend.utils.swiper;
			this.swiper = await new Swiper($sliders.find('.elementor-main-swiper'), {
				slidesPerView: 2,
				spaceBetween: 5, 
				pagination: {
					el: $sliders.find('.swiper-pagination')[0],
					type: "fraction",
					},
				navigation: {
					nextEl: $sliders.find('.swiper-button-next')[0],
				    prevEl: $sliders.find('.swiper-button-prev')[0],
				},
				scrollbar: {
					el: '.swiper-scrollbar',
				},
				breakpoints: {
					10: {
						slidesPerView: 1,
						spaceBetween: 5,
					},
					768: {
						slidesPerView: 1,
						spaceBetween: 5,
					},
					1024: {
						slidesPerView: 2,
						spaceBetween: 5,
					}
				}
			});

			$sliders.find('.elementor-main-swiper').data('swiper', this.swiper);

			$sliders.find('.navigation-prev')[0].addEventListener('click', function () {
				const swiper = $sliders.find('.elementor-main-swiper').data('swiper');
				if (swiper) {
					swiper.slidePrev();
				}
			});

			$sliders.find('.navigation-next')[0].addEventListener('click', function () {
				const swiper = $sliders.find('.elementor-main-swiper').data('swiper');
				if (swiper) {
					swiper.slideNext();
				}
			});
		}
	}

	onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
		this.initSlider();
	}
}

jQuery( window ).on( 'elementor/frontend/init', () => {
   const addHandler = ( $element ) => {
       elementorFrontend.elementsHandler.addHandler( ProductCategorySlider, {
           $element,
       } );
   };

   elementorFrontend.hooks.addAction( 'frontend/element_ready/reddy_widget_one.default', addHandler );
} );
