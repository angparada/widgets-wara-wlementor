<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor reddyWidgetTwo Widget.
 * 
 * TThis widget shows the list of products belonging to the set.
 *
 * @since 1.0.0
 */
class Elementor_Reddy_WidgetTwo extends \Elementor\Widget_Base
{
	private const CHILD_THEME_FILE = 'hello-elementor-child';

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style( 'reddy-widget-2', get_theme_root_uri() . '/' . self::CHILD_THEME_FILE . '/widgets/assets/css/reddy-widget-2.css');

        wp_register_script('reddy-widgets-2', get_theme_root_uri() . '/' . self::CHILD_THEME_FILE . '/widgets/assets/js/reddy-widgets-2.js', [ 'elementor-frontend' ], false, true );

        wp_localize_script('reddy-widgets-2','dcms_vars',['ajaxurl'=>admin_url('admin-ajax.php')]);
    }

    public function get_style_depends() {
        return [ 'reddy-widget-2' ];
    }

    public function get_script_depends() {
        return [ 'reddy-widgets-2' ];
    }

    public function get_name() {
		return 'reddy_widget_two';
	}
	
	public function get_title() {
		return esc_html__( 'Product gallery', 'elementor-reddy-widget' );
	}
	
	public function get_icon() {
		return 'eicon-code';
	}
	
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}
	
	public function get_categories() {
		return [ 'general' ];
	}
	
	public function get_keywords() {
		return [ 'categories', 'products', 'list', 'group' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'General', 'elementor-reddy-widget' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'element_thumbnail_height',
			[
				'label' => esc_html__( 'Thumbnail Height', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 511,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-row .element-thumbnail-swiper' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'element_preview_image_height',
			[
				'label' => esc_html__( 'Preview image height', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 511,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-row .element-image-swiper' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'preview_button_options',
			[
				'label' => esc_html__( 'Button Options', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'preview_button_title',
			[
				'label' => esc_html__( 'Title', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'See description', 'elementor-reddy-widget' ),
				'placeholder' => esc_html__( 'Type your title here', 'elementor-reddy-widget' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'gallery_product_style',
			[
				'label' => esc_html__( 'Style', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'preview_button_style',
			[
				'label' => esc_html__( 'Button style', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_preview_typography',
				'selector' => '{{WRAPPER}} .elementor-row .element-image-swiper .elementor-button .elementor-button-text',
			]
		);

		$this->start_controls_tabs(
			'preview_button_tabs'
		);

		$this->start_controls_tab(
			'preview_button_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'elementor-reddy-widget' ),
			]
		);

		$this->add_control(
			'preview_button_text_color',
			[
				'label' => esc_html__( 'Color', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-row .element-image-swiper .elementor-button .elementor-button-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'preview_button_background',
			[
				'label' => esc_html__( 'Background', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-row .element-image-swiper .elementor-button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'preview_button_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'elementor-reddy-widget' ),
			]
		);

		$this->add_control(
			'preview_button_text_hover_color',
			[
				'label' => esc_html__( 'Color', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-row .element-image-swiper .elementor-button .elementor-button-text:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'preview_button_hover_background',
			[
				'label' => esc_html__( 'Background', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-row .element-image-swiper .elementor-button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		if (! is_product()) {
			return;
		}

		$object = get_queried_object();
		?>
		<?php if ( $object) : ?>

			<?php if (isset($object->post_type) && $object->post_type === 'product') : ?>

				<?php $product = wc_get_product($object->ID); ?>
				<?php if ($product) : ?>

					<?php if ( $product->get_type() === 'woosb' ): ?>

						<?php $bundles = $product->get_items(); ?>
						<?php if ($bundles) : ?>

							<div class="elementor-row">
							  <div class="element-thumbnails-col">
							    <!-- Swiper -->
							    <div thumbsSlider="" class="swiper mySwiper element-thumbnail-swiper">
							      <div class="swiper-wrapper">
							      	<?php foreach ($bundles as $bundle) : ?>
							      		<?php $bundle_id = $bundle['id'] ?? 0; ?>
							      		<?php $bundle_product = wc_get_product($bundle_id); ?>
								        <div class="thumbnail-swiper-slide swiper-slide">
								        	<?php if ($bundle_product) : ?>
								          		<?php echo $bundle_product->get_image(); ?>
								          	<?php endif; ?>
								        </div>
							        <?php endforeach; ?>
							      </div>
							    </div>
							    <div class="swiper mySwiper2 element-image-swiper">
							      <div class="swiper-wrapper">
							      	<?php foreach ($bundles as $bundle) : ?>
										<?php $bundle_id = $bundle['id'] ?? 0; ?>
										<?php $bundle_product = wc_get_product($bundle_id); ?>
								        <div class="preview-swiper-slide swiper-slide">
								        	<?php if ($bundle_product) : ?>
								        		<?php $product_image = get_the_post_thumbnail( $bundle_product->get_id(), 'large', array( 'class' => 'product-image' ) ); ?>
								        		<?php if ( $product_image ): ?>
								        			<?php echo $product_image; ?>
								        		<?php else: ?>
													<img loading="lazy" width="800" height="800" src="" class="product-image wp-post-image" alt="<?php echo __('Product Image', ''); ?>" decoding="async" srcset="https://placehold.co/1024x1024.webp  1024w, https://placehold.co/300x300.webp  300w, https://placehold.co/150x150.webp 150w, https://placehold.co/768x768.webp 768w, https://placehold.co/1536x1536.webp 1536w, https://placehold.co/2048x2048.webp 2048w, https://placehold.co/600x600.webp 600w, https://placehold.co/100x100.webp 100w" sizes="(max-width: 800px) 100vw, 800px">
												<?php endif; ?>
									          	<div class="swiper-slide-content">
													<a class="elementor-button elementor-button-link" href="#" aria-label="<?php echo __('Product link', 'elementor-reddy-widget'); ?>" data-product="<?php echo $bundle_product->get_id(); ?>">
														<span class="elementor-button-text"><?php echo $settings['preview_button_title']; ?></span>
													</a>
									          	</div>
								          	<?php endif; ?>
								        </div>
							        <?php endforeach; ?>
							      </div>
							    	<div class="swiper-button-next">
							    		<svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M11.3536 4.35355C11.5488 4.15829 11.5488 3.84171 11.3536 3.64645L8.17157 0.464466C7.97631 0.269204 7.65973 0.269204 7.46447 0.464466C7.2692 0.659728 7.2692 0.976311 7.46447 1.17157L10.2929 4L7.46447 6.82843C7.2692 7.02369 7.2692 7.34027 7.46447 7.53553C7.65973 7.7308 7.97631 7.7308 8.17157 7.53553L11.3536 4.35355ZM0 4.5H11V3.5H0V4.5Z" fill="#696969"></path></svg>
							    	</div>
							    	<div class="swiper-button-prev">
							    		<svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M0.646446 3.64645C0.451184 3.84171 0.451184 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.97631 4.7308 0.659728 4.53553 0.464465C4.34027 0.269203 4.02369 0.269203 3.82843 0.464465L0.646446 3.64645ZM12 3.5L1 3.5L1 4.5L12 4.5L12 3.5Z" fill="#696969"></path></svg>
							    	</div>
							    </div>
							      <div class="swiper-pagination"></div>
							  </div>
							</div>

						<?php else: ?>
							<?php $attachment_ids = $product->get_gallery_image_ids(); ?>
							<?php if ( !empty( $attachment_ids ) ) : ?>
							<div class="elementor-row">
								<div class="element-thumbnails-col">
									<!-- Swiper -->
									<div thumbsSlider="" class="swiper mySwiper element-thumbnail-swiper">
										<div class="swiper-wrapper">
											<?php foreach ( $attachment_ids as $attachment_id ) : ?>
												<?php $product_image = wp_get_attachment_image( $attachment_id, 'thumbnail', array( 'class' => 'product-image' ) ); ?>
												<div class="thumbnail-swiper-slide swiper-slide">
								    				<?php if ( $product_image ): ?>
								    					<?php echo $product_image; ?>
								    				<?php endif; ?>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
									<div class="swiper mySwiper2 element-image-swiper">
								    	<div class="swiper-wrapper">
								    		<?php foreach ( $attachment_ids as $attachment_id ) : ?>
								    			<?php $product_image = wp_get_attachment_image( $attachment_id, 'large', array( 'class' => 'product-image' ) ); ?>
								    			<div class="preview-swiper-slide swiper-slide">
								    				<?php if ( $product_image ): ?>
								    					<?php echo $product_image; ?>
									        		<?php else: ?>
														<img loading="lazy" width="800" height="800" src="" class="product-image wp-post-image" alt="<?php echo __('Product Image', ''); ?>" decoding="async" srcset="https://placehold.co/1024x1024.webp  1024w, https://placehold.co/300x300.webp  300w, https://placehold.co/150x150.webp 150w, https://placehold.co/768x768.webp 768w, https://placehold.co/1536x1536.webp 1536w, https://placehold.co/2048x2048.webp 2048w, https://placehold.co/600x600.webp 600w, https://placehold.co/100x100.webp 100w" sizes="(max-width: 800px) 100vw, 800px">
								    				<?php endif; ?>
								    			</div>
								    		<?php endforeach; ?>
								    	</div>
								    	<div class="swiper-button-next">
								    		<svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M11.3536 4.35355C11.5488 4.15829 11.5488 3.84171 11.3536 3.64645L8.17157 0.464466C7.97631 0.269204 7.65973 0.269204 7.46447 0.464466C7.2692 0.659728 7.2692 0.976311 7.46447 1.17157L10.2929 4L7.46447 6.82843C7.2692 7.02369 7.2692 7.34027 7.46447 7.53553C7.65973 7.7308 7.97631 7.7308 8.17157 7.53553L11.3536 4.35355ZM0 4.5H11V3.5H0V4.5Z" fill="#696969"></path></svg>
								    	</div>
								    	<div class="swiper-button-prev">
								    		<svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M0.646446 3.64645C0.451184 3.84171 0.451184 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.97631 4.7308 0.659728 4.53553 0.464465C4.34027 0.269203 4.02369 0.269203 3.82843 0.464465L0.646446 3.64645ZM12 3.5L1 3.5L1 4.5L12 4.5L12 3.5Z" fill="#696969"></path></svg>
								    	</div>
									</div>
									<div class="swiper-pagination"></div>
								</div>
							</div>
							<?php endif; ?>

						<?php endif; // Si $bundles no esta vacio ?>

					<?php else: ?>
						<?php $attachment_ids = $product->get_gallery_image_ids(); ?>
						<?php if ( !empty( $attachment_ids ) ) : ?>
							<div class="elementor-row">
							  	<div class="element-thumbnails-col">
								    <!-- Swiper -->
								    <div thumbsSlider="" class="swiper mySwiper element-thumbnail-swiper">
								    	<div class="swiper-wrapper">
								    		<?php foreach ( $attachment_ids as $attachment_id ) : ?>
								    			<?php $product_image = wp_get_attachment_image( $attachment_id, 'thumbnail', array( 'class' => 'product-image' ) ); ?>
								    			<div class="thumbnail-swiper-slide swiper-slide">
								    				<?php if ( $product_image ): ?>
								    					<?php echo $product_image; ?>
								    				<?php endif; ?>
								    			</div>
								    		<?php endforeach; ?>
								    	</div>								    	
								    </div>
								    <div class="swiper mySwiper2 element-image-swiper">
								    	<div class="swiper-wrapper">
								    		<?php foreach ( $attachment_ids as $attachment_id ) : ?>
								    			<?php $product_image = wp_get_attachment_image( $attachment_id, 'large', array( 'class' => 'product-image' ) ); ?>
								    			<div class="preview-swiper-slide swiper-slide">
								    				<?php if ( $product_image ): ?>
								    					<?php echo $product_image; ?>
									        		<?php else: ?>
														<img loading="lazy" width="800" height="800" src="" class="product-image wp-post-image" alt="<?php echo __('Product Image', ''); ?>" decoding="async" srcset="https://placehold.co/1024x1024.webp  1024w, https://placehold.co/300x300.webp  300w, https://placehold.co/150x150.webp 150w, https://placehold.co/768x768.webp 768w, https://placehold.co/1536x1536.webp 1536w, https://placehold.co/2048x2048.webp 2048w, https://placehold.co/600x600.webp 600w, https://placehold.co/100x100.webp 100w" sizes="(max-width: 800px) 100vw, 800px">
								    				<?php endif; ?>
								    			</div>
								    		<?php endforeach; ?>
								    	</div>
								    	<div class="swiper-button-next">
								    		<svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M11.3536 4.35355C11.5488 4.15829 11.5488 3.84171 11.3536 3.64645L8.17157 0.464466C7.97631 0.269204 7.65973 0.269204 7.46447 0.464466C7.2692 0.659728 7.2692 0.976311 7.46447 1.17157L10.2929 4L7.46447 6.82843C7.2692 7.02369 7.2692 7.34027 7.46447 7.53553C7.65973 7.7308 7.97631 7.7308 8.17157 7.53553L11.3536 4.35355ZM0 4.5H11V3.5H0V4.5Z" fill="#696969"></path></svg>
								    	</div>
								    	<div class="swiper-button-prev">
								    		<svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M0.646446 3.64645C0.451184 3.84171 0.451184 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.97631 4.7308 0.659728 4.53553 0.464465C4.34027 0.269203 4.02369 0.269203 3.82843 0.464465L0.646446 3.64645ZM12 3.5L1 3.5L1 4.5L12 4.5L12 3.5Z" fill="#696969"></path></svg>
								    	</div>
								    </div>
								    	<div class="swiper-pagination"></div>
							  	</div>
							</div>
						<?php endif; ?>
					<?php endif; // Si el producto es de tipo = woosb  ?>

				<?php endif; // Comprobamos Existe un producto con id = $object->ID ?>

			<?php endif; // Comprobamos si el post_type = product ?>

		<?php endif; // Comprobamos si existe  get_queried_object() ?>

		<?php if ( $object) : ?>

			<?php if (isset($object->post_type) && $object->post_type === 'product') : ?>
				<?php $product = wc_get_product($object->ID); ?>
				<?php if ($product) : ?>
					<div class="elementor-widget-product-gallery-modal elementor-modal-dialog dialog-widget dialog-lightbox-widget dialog-type-buttons dialog-type-lightbox elementor-popup-modal" aria-modal="true" role="document" tabindex="0" style="display: none;">
						<div class="dialog-widget-content dialog-lightbox-widget-content animated">
							<a role="button" tabindex="0" aria-label="Close" href="#" class="dialog-close-button dialog-lightbox-close-button">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><mask id="mask0_1633_1884" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24"><rect width="24" height="24" fill="#D9D9D9"/></mask><g mask="url(#mask0_1633_1884)"><path d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z" fill="white"/></g></svg>
							</a>
							<div class="dialog-message dialog-lightbox-message">
								<div class="element-grid">
									<div class="element-grid-image">
										<div class="swiper element-grid-swiper">
											<div class="swiper-wrapper">
												<div class="swiper-slide">
													<img loading="lazy" width="800" height="800" src="" class="product-image wp-post-image" alt="<?php echo __('Product Image', ''); ?>" decoding="async" srcset="https://placehold.co/1024x1024.webp  1024w, https://placehold.co/300x300.webp  300w, https://placehold.co/150x150.webp 150w, https://placehold.co/768x768.webp 768w, https://placehold.co/1536x1536.webp 1536w, https://placehold.co/2048x2048.webp 2048w, https://placehold.co/600x600.webp 600w, https://placehold.co/100x100.webp 100w" sizes="(max-width: 800px) 100vw, 800px">
												</div>
												<div class="swiper-slide">
													<img loading="lazy" width="800" height="800" src="" class="product-image wp-post-image" alt="<?php echo __('Product Image', ''); ?>" decoding="async" srcset="https://placehold.co/1024x1024.webp  1024w, https://placehold.co/300x300.webp  300w, https://placehold.co/150x150.webp 150w, https://placehold.co/768x768.webp 768w, https://placehold.co/1536x1536.webp 1536w, https://placehold.co/2048x2048.webp 2048w, https://placehold.co/600x600.webp 600w, https://placehold.co/100x100.webp 100w" sizes="(max-width: 800px) 100vw, 800px">
												</div>
											</div>
											<div class="swiper-button-prev"></div>
											<div class="swiper-button-next"></div>
										</div>
									</div>
									<div class="element-grid-content">
										<h4 class="elementor-heading-text"><?php echo $product->get_name(); ?></h4>
										<div class="element-description">
											<?php echo $product->get_description(); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>

		<?php endif; ?>
		<?php
	}
}
