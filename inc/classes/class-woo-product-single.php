<?php
/**
 * WooCommerce settings
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;

class Woo_Product_Single {
	use Singleton;
	protected function __construct(){
		if ( class_exists( 'WooCommerce' ) ) {
			$this->setup_hooks();
		}
	}

	protected function setup_hooks() {
		// actions and filters
		// add_filter( 'woocommerce_enqueue_styles', [ $this, 'asgard_remove_woocommerce_all_style' ] );
		add_action( 'woocommerce_before_single_product_summary', [	$this,	'asgard_single_product_images_and_summary_div_start'	], 5 );
		add_action( 'woocommerce_after_single_product_summary', [	$this,	'asgard_single_product_images_and_summary_div_end'	], 1 );
		add_action( 'woocommerce_before_single_product_summary', [ $this, 'asgard_woocommerce_show_product_images' ] );
		add_action( 'woocommerce_single_product_summary', [	$this,	'custom_single_product_add_to_cart'	], 30 );
		add_action( 'woocommerce_single_product_summary', [	$this,	'custom_single_product_excerpt'	], 35 );
		add_action( 'woocommerce_single_product_summary', [	$this,	'display_single_product_guarantee'	], 36 );
		add_action( 'comment_post_redirect', [	$this,	'asgard_comment_post_redirect'	], 10, 2 );
		add_action( 'woocommerce_after_single_product_summary', [	$this,	'asgard_seprate_description_review'	], 10 );
		add_filter( 'woocommerce_sale_flash', [	$this,	'custom_onsale_badge'	], 10, 3 );
		add_filter( 'body_class', [	$this,	'asgard_gallery_body_class'	], 10, 1 );

		// CountDown For Product 
		add_action('woocommerce_product_options_advanced', [$this, 'add_field']);
		add_action('woocommerce_admin_process_product_object', [$this, 'save_field']);
		add_action('admin_footer', [$this, 'add_datepicker_script']);

		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		add_action( 'asgard_show_product_sale_badge', 'woocommerce_show_product_sale_flash', 20 );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
		remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
		add_action( 'asgard_show_product_images_with_slider', 'woocommerce_show_product_images', 20 );

		// remove_action( 'woocommerce_single_product_summary', 'display_single_product_guarantee', 36 );
		if ( is_front_page() ) {
			remove_action( 'woocommerce_single_product_summary', [	$this,	'display_single_product_guarantee'	], 36 );
		}
		
	}

	public function custom_onsale_badge($html, $post, $product) {
		$html = '<span class="onsale py-1 px-2 text-uppercase start-0 fw-semibold">Sale!</span>';
		return $html;
	}

	public function asgard_comment_post_redirect($location, $comment) {
		$product = get_post($comment->comment_post_ID);
		return get_permalink($product->ID) . '#reviews';
	}

	public function asgard_single_product_images_and_summary_div_start() {
		echo '<div class="row product-image-plus-summary">';
	}

	public function asgard_single_product_images_and_summary_div_end() {
		echo '</div>';
	}

	public function asgard_woocommerce_show_product_images() {
		global $product;
		echo "<div class='col-lg-6 mt-4 mt-lg-0 order-2 order-lg-1 d-lg-block single-product-image'>";
		do_action('asgard_show_product_sale_badge');
		do_action('asgard_show_product_images_with_slider');
		echo "</div>";
	}

	public function custom_single_product_add_to_cart() {
		global $product;

		if (!$product) {
						return;
		}

		// Check if the product is a simple product
		if ($product->is_type('simple')) {
						?>
						<div class="custom-product-info">
										<div class="custom-price d-flex align-items-center gap-3 my-4">
														<span class="sale-price fs-2 text-danger fw-bold">
																		<?php echo wc_price($product->get_price()); ?>
														</span>
														<?php if ($product->get_regular_price() && $product->get_price() !== $product->get_regular_price()) : ?>
																		<span class="regular-price text-muted fw-bold fs-5">
																						<s><?php echo wc_price($product->get_regular_price()); ?></s>
																		</span>
														<?php endif; ?>
										</div>

										<form class="cart mb-0" method="post" enctype='multipart/form-data'>
														<input type="hidden" name="quantity" value="1" />
														<button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt w-100 bg-primary rounded-5 py-3 px-4">
																		<?php echo esc_html($product->single_add_to_cart_text()); ?>
														</button>
										</form>

										<form method="post" action="<?php echo esc_url(wc_get_checkout_url()); ?>">
														<input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" />
														<input type="hidden" name="quantity" value="1" />
														<button type="submit" class="buy-now-button button alt w-100 mt-3 mb-4 bg-primary rounded-5 py-3 px-4">
																		Buy It Now
														</button>
										</form>
						</div>
						<?php
						return;
		}

		// Handle variable products
		if (!$product->is_type('variable')) {
						return;
		}

		// Get available variations
		$available_variations = $product->get_available_variations();
		$attribute_name = 'quantity';
		$variations = [];

		foreach ($available_variations as $variation) {
						$variation_data = $variation['attributes']['attribute_' . $attribute_name] ?? '';
						if (!empty($variation_data)) {
										$variations[$variation_data] = [
														'id' => $variation['variation_id'],
														'price' => $variation['display_price'],
														'regular_price' => !empty($variation['display_regular_price']) ? $variation['display_regular_price'] : null
										];
						}
		}

		// Default selected variation
$default_variation = !empty($variations) && is_array($variations) ? reset($variations) : null;

$show_price = $default_variation && !empty($default_variation['price']) && $default_variation['price'] !== $default_variation['regular_price']
				? $default_variation['price']
				: ($default_variation['regular_price'] ?? '');
		?>

		<div class="custom-product-info">
						<div class="custom-price d-flex align-items-center gap-3 my-4">
										<span id="sale-price" class="sale-price fs-2 text-danger fw-bold">
														<?php echo wc_price($show_price); ?>
										</span>
										<?php //if (!empty($default_variation['regular_price']) && $default_variation['price'] !== $default_variation['regular_price']) : ?>
														<span id="regular-price" class="regular-price text-muted fw-bold fs-5">
																		<s><?php echo wc_price($default_variation['regular_price']); ?></s>
														</span>
										<?php //endif; ?>
						</div>

						<div class="custom-quantity pb-4">
										<p>Quantity - <strong id="selected-quantity"><?php echo key($variations); ?></strong></p>
										<div class="quantity-options">
														<?php foreach ($variations as $label => $variation) : ?>
																		<button 
																						data-variation-id="<?php echo esc_attr($variation['id']); ?>" 
																						data-price="<?php echo esc_attr($variation['price']); ?>" 
																						data-regular-price="<?php echo esc_attr($variation['regular_price'] ?? ''); ?>"
																						data-label="<?php echo esc_attr($label); ?>"
																						class="py-1 px-3 rounded-5 <?php echo $label === key($variations) ? 'active' : ''; ?>">
																						<?php echo esc_html($label); ?>
																		</button>
														<?php endforeach; ?>
										</div>
						</div>

						<?php echo do_shortcode('[countdown_timer]'); ?>
						<div class="price-revert-back pb-4">
										<?php $revert_back_price = get_theme_mod('countdown_revert_text'); ?>
										<p class="mb-0 text-muted fs-14 fw-semibold"><?php echo $revert_back_price; ?></p>
						</div>

						<form class="cart mb-0" method="post" enctype='multipart/form-data'>
										<input type="hidden" name="variation_id" id="selected-variation" value="<?php echo esc_attr($default_variation['id']); ?>" />
										<input type="hidden" name="quantity" value="1" />
										<button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt w-100 bg-primary rounded-5 py-3 px-4">
														<?php echo esc_html($product->single_add_to_cart_text()); ?>
										</button>
						</form>

						<form method="post" action="<?php echo esc_url(wc_get_checkout_url()); ?>">
										<input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" />
										<input type="hidden" name="variation_id" id="buy-now-variation" value="<?php echo esc_attr($default_variation['id']); ?>" />
										<input type="hidden" name="quantity" value="1" />
										<button type="submit" class="buy-now-button button alt w-100 mt-3 mb-4 bg-primary rounded-5 py-3 px-4">
														Buy It Now
										</button>
						</form>
		</div>
		<?php
}



public function custom_single_product_excerpt() {
	if ( is_product() ) {
		global $product;
		if ( $product->get_short_description() ) : ?>
			<div class="accordion productAccordion" id="productAccordion">
				<div class="accordion-item border-end-0 border-start-0 bg-transparent shadow-none">
					<h2 class="accordion-header border-0" id="headingOne">
						<button class="accordion-button border-0 rounded-0 fs-16 fw-medium bg-transparent shadow-none text-primary py-4 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Description</button>
					</h2>
					<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#productAccordion">
						<div class="accordion-body">
							<?php echo wp_kses_post( $product->get_short_description() ); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif;
	}
	}

	public function display_single_product_guarantee() {
		if ( is_product() ) {
			$single_product_guaranteed_text = get_theme_mod('single_product_guaranteed_text');
			$single_product_payment_logo = get_theme_mod('single_product_payment_logo');
			
			if ($single_product_guaranteed_text || $single_product_payment_logo) {
							echo '<ul class="single-product-guarantee list-unstyled p-0 m-0 pt-4">';
							
							if ($single_product_guaranteed_text) {
											echo '<li class="d-flex align-items-center gap-3 pb-3">';
											echo '<svg width="24" height="24" fill="#489950"><use href="#icon-shield"></use></svg>';
											echo '<p class="text-uppercase text-black fs-16 mb-0 fw-medium">' . esc_html($single_product_guaranteed_text) . '</p>';
											echo '</li>';
							}
							
							if ($single_product_payment_logo) {
											echo '<li>';
											echo '<img src="' . esc_url($single_product_payment_logo) . '" alt="' . esc_attr($single_product_guaranteed_text) . '">';
											echo '</li>';
							}
							
							echo '</ul>';
			}
		}
		
	}

	public function asgard_seprate_description_review() {
		if ( is_product() ) {
			global $post;

			echo '<div class="product-description pt-5 pb-4">';
			the_content();
			echo '</div>';
	
			// Display the reviews below the description
			comments_template();
		}
	}

	public function add_field() {
		global $post;
		$selected_date = get_post_meta($post->ID, 'countdown_timer', true);
		woocommerce_wp_text_input([
			'id' => 'countdown_timer',
			'label' => __('Countdown Timer', 'woocommerce'),
			'placeholder' => 'YYYY-MM-DD 00:00:00',
			'desc_tip' => true,
			'description' => __('Set the countdown timer in format YYYY-MM-DD 00:00:00', 'woocommerce'),
			'value' => $selected_date
		]);
}

public function save_field($product) {
		if (isset($_POST['countdown_timer'])) {
				$product->update_meta_data('countdown_timer', sanitize_text_field($_POST['countdown_timer']));
		}
}

public function add_datepicker_script() {
		global $post;
		if ('product' !== $post->post_type) return;
		?>
		<script>
				jQuery(function($) {
						$('#countdown_timer').datepicker({
								dateFormat: 'yy-mm-dd',
								timeFormat: 'HH:mm:ss'
						});
				});
		</script>
		<?php
}


public function asgard_gallery_body_class($classes) {
	if (is_product()) {
		global $post;
		$product = wc_get_product($post->ID);

		if ($product && is_a($product, 'WC_Product')) {
						$gallery_images = $product->get_gallery_image_ids();

						if (!empty($gallery_images)) {
										$classes[] = 'product-has-gallery';
						}
		}
}
return $classes;
}
}