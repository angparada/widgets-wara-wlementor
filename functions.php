<?php
/**
 * Registering Widgets Elementor
 * 
 * @param object $widgets_manager
 * @return void
 */
function register_new_widgets( $widgets_manager ) {
    require_once( __DIR__ . '/widgets/reddy-widget-1.php' );
    require_once( __DIR__ . '/widgets/reddy-widget-2.php' );
    
    // Register a new widget
    $widgets_manager->register( new \Elementor_Reddy_WidgetOne() );
    $widgets_manager->register( new \Elementor_Reddy_WidgetTwo() );
}
add_action( 'elementor/widgets/register', 'register_new_widgets' );


add_action('wp_ajax_nopriv_product_ajax_request','get_product_info');
add_action('wp_ajax_product_ajax_request','get_product_info');

function get_product_info()
{

	$product_id = $_POST['product_id'] ?? 0;

	if ( $product_id ) {
		$product = wc_get_product($product_id);
		if ( $product ) {
			$attachment_ids = $product->get_gallery_image_ids();
			echo '<div class="element-grid">';		
				echo '<div class="element-grid-image">';
					if ( !empty( $attachment_ids ) ) :
						echo '<div class="swiper element-grid-swiper">';
							echo '<div class="swiper-wrapper">';
							foreach ( $attachment_ids as $attachment_id ) :
								$product_image = wp_get_attachment_image( $attachment_id, 'large', array( 'class' => 'product-image' ) );
								echo '<div class="swiper-slide">';
								if ( $product_image ):
									echo $product_image;
								else:
									echo '<img loading="lazy" width="800" height="800" src="" class="product-image wp-post-image" alt="' . __('Product Image', '') . '" decoding="async" srcset="https://placehold.co/1024x1024.webp  1024w, https://placehold.co/300x300.webp  300w, https://placehold.co/150x150.webp 150w, https://placehold.co/768x768.webp 768w, https://placehold.co/1536x1536.webp 1536w, https://placehold.co/2048x2048.webp 2048w, https://placehold.co/600x600.webp 600w, https://placehold.co/100x100.webp 100w" sizes="(max-width: 800px) 100vw, 800px">';
								endif;
								echo '</div>';
							endforeach;
							echo '</div>';
							echo '<div class="swiper-button-prev"></div>';
							echo '<div class="swiper-button-next"></div>';
						echo '</div>';
					else:
						$product_image = get_the_post_thumbnail( $product->get_id(), 'large', array( 'class' => 'product-image' ) );
						echo '<div class="swiper element-grid-swiper">';
							echo '<div class="swiper-wrapper">';
								echo '<div class="swiper-slide">';
								if ( $product_image ):
									echo $product_image;
								else:
									echo '<img loading="lazy" width="800" height="800" src="" class="product-image wp-post-image" alt="' . __('Product Image', '') . '" decoding="async" srcset="https://placehold.co/1024x1024.webp  1024w, https://placehold.co/300x300.webp  300w, https://placehold.co/150x150.webp 150w, https://placehold.co/768x768.webp 768w, https://placehold.co/1536x1536.webp 1536w, https://placehold.co/2048x2048.webp 2048w, https://placehold.co/600x600.webp 600w, https://placehold.co/100x100.webp 100w" sizes="(max-width: 800px) 100vw, 800px">';
								endif;
								echo '</div>';
							echo '</div>';
							echo '<div class="swiper-button-prev"></div>';
							echo '<div class="swiper-button-next"></div>';
						echo '</div>';
					endif;
				echo '</div>';
				echo '<div class="element-grid-content">';
					echo '<h4 class="elementor-heading-text">' . $product->get_name() . '</h4>';
					echo '<div class="element-description">';
						echo $product->get_description(); 
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	}

	wp_die();
}
