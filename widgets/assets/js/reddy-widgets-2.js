class ProductGallerySlider extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.elementor-widget-reddy_widget_two',
				thumbnailContainer: '.elementor-row .element-thumbnail-swiper',
				previewContainer: '.elementor-row .element-image-swiper',
				thumbnailSlide: '.thumbnail-swiper-slide',
				thumbnailSlide: '.preview-swiper-slide',
			}
		}
	}

	getDefaultElements() {
		const selectors = this.getSettings('selectors');
		const elements = {
			$container: this.$element.find(selectors.container),
			$thumbnail: this.$element.find(selectors.thumbnailContainer),
			$preview: this.$element.find(selectors.previewContainer)
		};

		return elements;
	}

	async initSlider() {
		const $thumbnailSlider = this.elements.$thumbnail;
		const $previewSlider = this.elements.$preview;
		const $modalSlider = this.$element.find('.element-grid-swiper');
		const Swiper = elementorFrontend.utils.swiper;

		if($thumbnailSlider.length === 0) {
			return;
		}

		this.swiper = await new Swiper($thumbnailSlider, {
			direction: "vertical",
			spaceBetween: 11,
			slidesPerView: 6,
			freeMode: true,
			watchSlidesProgress: true,
		});

		$thumbnailSlider.data('swiper', this.swiper);

		this.swiper = await new Swiper($previewSlider, {
			spaceBetween: 0,
			effect: "fade",
			navigation: {
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			},
			pagination: {
				el: ".swiper-pagination",
				type: "fraction",
			},
			thumbs: {
				swiper: this.swiper,
			},
		});

		$previewSlider.data('swiper', this.swiper);

		this.swiper = await new Swiper($modalSlider, {
			spaceBetween: 0,
			navigation: {
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			}
		});

		$modalSlider.find('.element-grid-swiper').data('swiper', this.swiper);
	}

	onInit() {
		elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
		this.initSlider();
	}

	bindEvents() {
    	this.elements.$preview.find('.elementor-button').on( 'click', this.onButtonClick.bind( this ) );
    	this.elements.$container.find('.dialog-close-button').on( 'click', this.onCloseButtonClick.bind( this ) );
	}

	onButtonClick ( event ) {
		event.preventDefault();

		const button = event.currentTarget;
	    const productData = button.getAttribute('data-product');

	    if (productData> 0) {
	    	this.getRequestAjaxProduct(productData)
	    }
	}

	onCloseButtonClick (event) {
		event.preventDefault();
		const $modal = this.$element.find('.elementor-widget-product-gallery-modal');
		$modal.fadeOut();
	}

	getRequestAjaxProduct(id) {
		const $modal = this.$element.find('.elementor-widget-product-gallery-modal');
		const self = this;
		jQuery.ajax({
			url : dcms_vars.ajaxurl,
			type: 'post',
			data: {
				action : 'product_ajax_request',
				product_id: id
			},
			beforeSend: function(){
				//link.html('Cargando ...');
			},
			success: function(result){
				$modal.find('.dialog-message').html(result);
				//$modal.fadeIn('fast');
				$modal.css("display", "flex");

				const swiper = new Swiper('.element-grid-swiper', {
					spaceBetween: 15,
					navigation: {
						nextEl: ".swiper-button-next",
						prevEl: ".swiper-button-prev",
					},
				});
			}

		});

		$modal.on('click', '.dialog-close-button', function (event) {
		    event.preventDefault();
		    $modal.fadeOut();
		});

	}
}

jQuery( window ).on( 'elementor/frontend/init', () => {
   const addHandler = ( $element ) => {
       elementorFrontend.elementsHandler.addHandler( ProductGallerySlider, {
           $element,
       } );
   };

   elementorFrontend.hooks.addAction( 'frontend/element_ready/reddy_widget_two.default', addHandler );
} );
