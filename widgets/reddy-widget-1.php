<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor reddyWidgetOne Widget.
 * 
 * This widget shows the list of products grouped by categories.
 * 
 * @since 1.0.0
 */
class Elementor_Reddy_WidgetOne extends \Elementor\Widget_Base
{
    private const CHILD_THEME_FILE = 'hello-elementor-child';
    
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style( 'reddy-widget-1', get_theme_root_uri() . '/' . self::CHILD_THEME_FILE . '/widgets/assets/css/reddy-widget-1.css');
        wp_register_script('reddy-widgets', get_theme_root_uri() . '/' . self::CHILD_THEME_FILE . '/widgets/assets/js/reddy-widgets.js', [ 'elementor-frontend' ], false, true );
    }

    public function get_style_depends() {
        return [ 'reddy-widget-1' ];
    }

    public function get_script_depends() {
        return [ 'reddy-widgets' ];
    }
    
    public function get_name() {
		return 'reddy_widget_one';
	}
	
	public function get_title() {
		return esc_html__( 'List products by Category', 'elementor-reddy-widget' );
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
			'reddy_widget_direction',
			[
				'label' => esc_html__( 'Direction', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => esc_html__( 'Row - Horizontal', 'elementor-reddy-widget' ),
						'icon' => 'eicon-arrow-right',
					],
					'row-reverse' => [
						'title' => esc_html__( 'Row - Reversed', 'elementor-reddy-widget' ),
						'icon' => 'eicon-arrow-left',
					],
				],
				'default' => 'row',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .child-category .e-con-inner' => 'flex-direction: {{VALUE}};',
				],
			]
		);	
		
		$this->start_controls_tabs(
	        'reddy_widget_elementor_columns_tabs'
        );
        
        $this->start_controls_tab(
        	'reddy_widget_elementor_column_left_tab',
        	[
        		'label' => esc_html__( 'Left', 'textdomain' ),
        	]
        );
		
		$this->add_responsive_control(
			'reddy_widget_elementor_left_width',
			[
				'label' => esc_html__( 'Width', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .child-category .elementor-element-left' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_tab();
        
        $this->start_controls_tab(
        	'reddy_widget_elementor_column_right_tab',
        	[
        		'label' => esc_html__( 'Right', 'textdomain' ),
        	]
        );
		
		$this->add_responsive_control(
			'reddy_widget_elementor_right_width',
			[
				'label' => esc_html__( 'Width', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .child-category .elementor-element-right' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->add_responsive_control(
			'column_gap',
			[
				'label' => esc_html__( 'Column gap', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 600,
				'step' => 1,
				'default' => 20,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container-wrapper' => 'column-gap: {{SIZE}}px;',
				],
			]
		);
		
		$this->add_responsive_control(
			'row_gap',
			[
				'label' => esc_html__( 'Row gap', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 600,
				'step' => 1,
				'default' => 20,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container-wrapper' => 'row-gap: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'query_options',
			[
				'label' => esc_html__( 'Query', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		if ( class_exists( 'WooCommerce' ) ) {
			$product_types = wc_get_product_types();
			$product_type_options = [];
			foreach ($product_types as $type => $label) {
			    $product_type_options[$type] = $label;
			}
		} else {
			$product_types = [];
			$product_type_options = [];
		}
		
		$this->add_control(
			'product_type_list',
			[
				'label' => esc_html__( 'Product type', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $product_type_options,
				'default' => $product_types,
			]
		);

		$this->add_control(
			'product_not_item_description',
			[
				'label' => esc_html__( 'Description', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => esc_html__( 'There are no items available to display.', 'elementor-reddy-widget' ),
				'placeholder' => esc_html__( 'Type your description here', 'elementor-reddy-widget' ),
			]
		);

		$this->end_controls_section();

	    $this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Category title', 'elementor-reddy-widget' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .elementor-element-left .elementor-heading-title',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Color', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-element-left .elementor-heading-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'style_price_options',
			[
				'label' => esc_html__( 'Price', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_price_typography',
				'selector' => '{{WRAPPER}} .elementor-element-right .swiper-slide .woocommerce-Price-amount.amount',
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Color', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-element-right .swiper-slide .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'style_card_options',
			[
				'label' => esc_html__( 'Slider style', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'card_heading_typography',
				'selector' => '{{WRAPPER}} .elementor-element-right .swiper-slide-content-heading',
			]
		);

		$this->add_control(
			'card_heading_color',
			[
				'label' => esc_html__( 'Color', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-element-right .swiper-slide-content-heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'style_button_options',
			[
				'label' => esc_html__( 'Button', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'card_button_typography',
				'selector' => '{{WRAPPER}} .swiper-slide-content-button .elementor-button .elementor-button-text',
			]
		);
		
		$this->start_controls_tabs(
			'button_style_tabs'
		);

		$this->start_controls_tab(
			'button_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'elementor-reddy-widget' ),
			]
		);

		$this->add_control(
			'button_normal_color',
			[
				'label' => esc_html__( 'Color', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-content-button .elementor-button .elementor-button-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_normal_background',
			[
				'label' => esc_html__( 'Background', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-content-button .elementor-button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'elementor-reddy-widget' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => esc_html__( 'Color', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-content-button .elementor-button .elementor-button-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_hover_background',
			[
				'label' => esc_html__( 'Background', 'elementor-reddy-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-content-button .elementor-button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}
	
	protected function render() {
	    $settings = $this->get_settings_for_display();

	    if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
	        $object = get_queried_object();
	    } else {
	        $object = get_queried_object();
	    }
	    
	    if ($object && isset($object->taxonomy)): ?>
	    <div class="elementor-widget-container-wrapper">
        <?php 
            $taxonomies = get_terms( ['taxonomy' => $object->taxonomy, 'parent' => $object->term_taxonomy_id, 'hide_empty' => true]);

            if ($taxonomies):
	            foreach($taxonomies as $taxonomy) :
	            $query = new WC_Product_Query([
	                'limit' => 10,
	                'status' => 'publish',
	                'product_category_id' => [ $taxonomy->term_id ],
	                'type' => $settings['product_type_list'],
	                'tax_query' => [
				        [
				            'taxonomy' => 'catalog-status',
				            'field'    => 'slug',
				            'terms'    => 'add-on',
				            'operator' => 'NOT IN',
				        ],
	                ]
	            ]); 
	            
	            ?>
	            <div id="elementor-element-<?php echo esc_attr( $taxonomy->term_id); ?>" class="elementor-element  elementor-element-wrapper elementor-element-<?php echo $this->get_id(); ?> e-flex e-con-boxed e-con e-parent child-category category-<?php echo esc_attr( $taxonomy->term_id); ?>">
	                <div class="e-con-inner">
	                    <div class="elementor-element-left elementor-element elementor-element-<?php echo $this->get_id(); ?> e-con-full e-flex e-con e-child elementor-element-child-category">
	                        <h2 class="elementor-heading-title elementor-size-default"><?php echo esc_attr( $taxonomy->name ); ?></h2>
	                        
	                        <div class="elementor-element-navigation-pagination">
	                            <div class="pagination">
	                                <div class="swiper-pagination"></div>
	                            </div>
	                            <div class="navigation">
	                                <button class="navigation-prev">
	                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M0.646446 3.64645C0.451184 3.84171 0.451184 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.97631 4.7308 0.659728 4.53553 0.464465C4.34027 0.269203 4.02369 0.269203 3.82843 0.464465L0.646446 3.64645ZM12 3.5L1 3.5L1 4.5L12 4.5L12 3.5Z" fill="#696969"/></svg>
	                                </button>
	                                <button class="navigation-next">
	                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M11.3536 4.35355C11.5488 4.15829 11.5488 3.84171 11.3536 3.64645L8.17157 0.464466C7.97631 0.269204 7.65973 0.269204 7.46447 0.464466C7.2692 0.659728 7.2692 0.976311 7.46447 1.17157L10.2929 4L7.46447 6.82843C7.2692 7.02369 7.2692 7.34027 7.46447 7.53553C7.65973 7.7308 7.97631 7.7308 8.17157 7.53553L11.3536 4.35355ZM0 4.5H11V3.5H0V4.5Z" fill="white"/></svg>
	                                </button>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="elementor-element-right elementor-element elementor-element-<?php echo $this->get_id(); ?> e-con-full e-flex e-con e-child">
	                        <?php if ($query->get_products()): ?>
	                        <!-- Slider main container -->
	                        <div class="elementor-main-swiper swiper">
	                          <!-- Additional required wrapper -->
	                          <div class="swiper-wrapper elementor-slides">
	                            <!-- Slides -->
	                            <?php foreach($query->get_products() as $product): ?>
	                            <div class="swiper-slide">
	                                <?php $product_image = get_the_post_thumbnail( $product->get_id(), 'large', array( 'class' => 'product-image' ) ); ?>
	                                <div class="product-image-container">
	                                <?php if ($product_image): ?>
	                                    <?php echo $product_image; ?>
	                                <?php else: ?>
	                                    <img loading="lazy" width="800" height="800" src="" class="product-image wp-post-image" alt="<?php echo __('Product Image', ''); ?>" decoding="async" srcset="https://placehold.co/1024x1024.webp  1024w, https://placehold.co/300x300.webp  300w, https://placehold.co/150x150.webp 150w, https://placehold.co/768x768.webp 768w, https://placehold.co/1536x1536.webp 1536w, https://placehold.co/2048x2048.webp 2048w, https://placehold.co/600x600.webp 600w, https://placehold.co/100x100.webp 100w" sizes="(max-width: 800px) 100vw, 800px">
	                                <?php endif; ?>
	                                </div>
	                                <div class="swiper-slide-content element-content">
	                                    <h4 class="swiper-slide-content-heading"><?php echo $product->get_name(); ?></h4>
	                                    <div class="swiper-slide-content-info">
	                                        <div class="swiper-slide-content-price">
	                                            <?php echo $product->get_price_html(); ?>
	                                        </div>
	                                        <div class="swiper-slide-content-button">
	                                            <a href="<?php echo get_permalink( $product->get_id() ); ?>" class="elementor-button elementor-button-link" aria-label="Button link"><span class="elementor-button-text"><?php echo __('See set', ''); ?></span></a>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                            <?php endforeach; ?>
	                          </div>
	                          <!-- If we need navigation buttons -->
	                          <div class="swiper-button-prev">
	                           		<svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M0.646446 3.64645C0.451184 3.84171 0.451184 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.97631 4.7308 0.659728 4.53553 0.464465C4.34027 0.269203 4.02369 0.269203 3.82843 0.464465L0.646446 3.64645ZM12 3.5L1 3.5L1 4.5L12 4.5L12 3.5Z" fill="#696969"/></svg>
	                          </div>
	                          <div class="swiper-button-next">
	                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none"><path d="M11.3536 4.35355C11.5488 4.15829 11.5488 3.84171 11.3536 3.64645L8.17157 0.464466C7.97631 0.269204 7.65973 0.269204 7.46447 0.464466C7.2692 0.659728 7.2692 0.976311 7.46447 1.17157L10.2929 4L7.46447 6.82843C7.2692 7.02369 7.2692 7.34027 7.46447 7.53553C7.65973 7.7308 7.97631 7.7308 8.17157 7.53553L11.3536 4.35355ZM0 4.5H11V3.5H0V4.5Z" fill="#696969"/></svg>
	                          </div>
	                        
	                          <!-- If we need scrollbar -->
	                          <div class="swiper-scrollbar"></div>
	                        </div>
	                        <?php endif; ?>
	                    </div>
	                </div>
	            </div>
	            <?php endforeach; ?>
        	<?php else: ?>
        		<?php $taxonomy = get_term_by( 'id', $object->term_taxonomy_id, $object->taxonomy ); ?>
	        	<?php if ($taxonomy): ?>
	        		<?php $query = new WC_Product_Query([
	                'limit' => 10,
	                'status' => 'publish',
	                'product_category_id' => [ $taxonomy->term_id ] ]);  ?>
					<div id="elementor-element-<?php echo esc_attr( $taxonomy->term_id); ?>" class="elementor-element elementor-element-wrapper elementor-element-<?php echo $this->get_id(); ?> e-flex e-con-boxed e-con e-parent parent-category category-<?php echo esc_attr( $taxonomy->term_id); ?>">
						<div class="e-con-inner">
					        <div class="elementor-element-left elementor-element elementor-element-<?php echo $this->get_id(); ?> e-con-full e-flex e-con e-child">
					            <h2 class="elementor-heading-title elementor-size-default"><?php echo esc_attr( $taxonomy->name ); ?></h2>
					        </div>
					        <div class="elementor-element-right elementor-element elementor-element-<?php echo $this->get_id(); ?> e-con-full e-flex e-con e-child">
					        	<?php if ($query->get_products()): ?>
									<?php foreach($query->get_products() as $product): ?>
										<article <?php post_class( 'product-item' ); ?>>
											<?php $product_image = get_the_post_thumbnail( $product->get_id(), 'large', array( 'class' => 'product-image' ) ); ?>
			                                <div class="product-image-container">
			                                <?php if ($product_image): ?>
			                                    <?php echo $product_image; ?>
			                                <?php else: ?>
			                                    <img loading="lazy" width="800" height="800" src="" class="product-image wp-post-image" alt="<?php echo __('Product Image', ''); ?>" decoding="async" srcset="https://placehold.co/1024x1024.webp  1024w, https://placehold.co/300x300.webp  300w, https://placehold.co/150x150.webp 150w, https://placehold.co/768x768.webp 768w, https://placehold.co/1536x1536.webp 1536w, https://placehold.co/2048x2048.webp 2048w, https://placehold.co/600x600.webp 600w, https://placehold.co/100x100.webp 100w" sizes="(max-width: 800px) 100vw, 800px">
			                                <?php endif; ?>
			                                </div>
			                                <div class="element-content">
			                                	<h4 class="content-heading"><a href="<?php echo get_permalink( $product->get_id() ); ?>" aria-label="product link"><?php echo $product->get_name(); ?></a></h4>
			                                	<?php echo $product->get_price_html(); ?>
			                                </div>
										</article>
									<?php endforeach; ?>
								<?php else: ?>
									<p class="element-paragraph-notice"><?php echo $settings['product_not_item_description']; ?></p>
					        	<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
            <?php endif; ?>
        </div>
	    <?php endif;
	}
}
