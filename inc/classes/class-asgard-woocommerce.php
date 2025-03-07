<?php

/**
 * WooCommerce settings
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;

class Asgard_Woocommerce
{
	use Singleton;
	protected function __construct()
	{
		if (class_exists('WooCommerce')) {
			$this->setup_hooks();
		}
	}

	protected function setup_hooks()
	{
		// actions and filters
		add_action('woocommerce_add_to_cart_fragments', [$this, 'asgard_woocommerce_header_add_to_cart_fragment']);
		add_action('wp_ajax_product_remove', [$this, 'asgard_ajax_product_remove']);
		add_action('wp_ajax_nopriv_product_remove', [$this, 'asgard_ajax_product_remove']);
		add_action('woocommerce_cart_fragments', [$this, 'asgard_custom_cart_fragments']);
		add_action('woocommerce_thankyou', [$this, 'asgard_display_thankyou_popup'], 10);

		add_filter('woocommerce_cart_item_thumbnail', [$this, 'asgard_woocommerce_add_class_to_cart_item_thumbnail'], 10, 3);
		add_filter('use_block_editor_for_post_type', [$this, 'asgard_use_block_editor_for_post_type'], 10, 2);
		add_filter('woocommerce_blocks_product_grid_item_html', [$this,	'asgard_custom_render_product_block'], 10, 3);
	}

	public function asgard_woocommerce_header_add_to_cart_fragment()
	{
		ob_start();
		?>
		<a id="cart_badge" class="mini-cart" href="#offcanvasCart"
			class="m-0 d-flex text-decoration-none align-items-center" data-bs-toggle="offcanvas" aria-controls="offcanvasCart">
			<div class="position-relative p-0 cart-icon-button d-flex justify-content-center align-items-center h-auto w-auto">
				<svg width="24" height="24" fill="#000">
					<use href="#icon-basket"></use>
				</svg>
				<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary fw-normal">
					<?php echo esc_html(WC()->cart->cart_contents_count); ?>
					<span class="visually-hidden">New alerts</span>
				</span>
			</div>
		</a>
	<?php
		
		$fragments['.mini-cart'] = ob_get_clean();
		ob_start();
	?>
		<div class="offcanvas-header" id="offcanvasCartHeader">
			<h6 class="offcanvas-title text-black" id="offcanvasCartLabel">
				Your cart (<?php echo WC()->cart->get_cart_contents_count(); ?>)
			</h6>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<?php
		$fragments['.offcanvas-header'] = ob_get_clean();
		ob_start();
		?>
		<div class="right_cart-subtotal-right fw-semibold">
			<span class="woocommerce-Price-amount amount">
				<?php echo WC()->cart->get_cart_subtotal(); ?>
			</span>
		</div>
		<?php
		$fragments['.right_cart-subtotal-right'] = ob_get_clean();

		ob_start();
		?>
		<div class="offcanvas-body p-0" id="offcanvasCartBody">
			<div class="right_cart-main d-flex flex-column justify-content-between h-100">
				<div class="right_cart-up offcanvas-body-inner">
					<?php if (WC()->cart->get_cart_contents_count() > 0) : ?>
						<ul class="mini-products-list list-unstyled mb-0 position-relative ms-0" id="cart-sidebar">
							<?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
								<?php
								$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
								if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) :
									$product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
									$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
									$product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
									$product_permalink = $_product->is_visible() ? $_product->get_permalink($cart_item) : '';
									$product_id = $_product->get_id();
								?>
									<li class="item d-inline-block p-3 w-100">
										<div class="item-inner d-flex">
											<a class="product-image flex-shrink-0 border-1 border-primary border-opacity-25"
												href="<?php echo esc_url($product_permalink); ?>"
												title="<?php echo esc_html($product_name); ?>">
												<?php echo wp_kses_post($thumbnail); ?>
											</a>
											<div class="product-details flex-grow-1 ms-3 position-relative">
												<div class="access d-flex justify-content-end position-absolute top-0 end-0">
													<a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>"
														title="<?php esc_attr_e('Remove This Item', 'asgard'); ?>"
														class="btn-remove"
														data-product_id="<?php echo esc_attr($product_id); ?>"
														data-product_sku="<?php echo esc_attr($_product->get_sku()); ?>"
														data-cart_item_key="<?php echo esc_attr($cart_item_key); ?>">
														<svg class="icon-close" width="16" height="16" fill="#000">
															<use href="#icon-trash"></use>
														</svg>
													</a>
												</div>


												<a class="product-name mb-1 d-block text-decoration-none link-secondary pe-3 lh-sm fw-semibold"
													href="<?php echo esc_url($product_permalink); ?>"
													title="<?php echo esc_html($product_name); ?>">
													<?php echo esc_html($product_name); ?>
												</a>
												<span class="fw-semibold"><?php echo esc_html($cart_item['quantity']); ?></span> x <span class="price fw-semibold"><?php echo wp_kses_post($product_price); ?></span>
											</div>
											<?php echo wc_get_formatted_cart_item_data($cart_item); ?>
										</div>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					<?php else: ?>
						<div class="a-center noitem p-2 text-center">
							<svg class="d-block mx-auto m-3" width="130" height="130" fill="#686363">
								<use href="#icon-bag"></use>
							</svg>
							<p class="fw-medium"><?php esc_attr_e('Your cart is empty', 'asgard'); ?></p>
							<a href="<?php echo wc_get_page_permalink('shop'); ?>" class="btn btn-primary"><?php esc_attr_e('Check out our offering', 'asgard'); ?></a>
						</div>
					<?php endif; ?>
					
				</div>

			</div>
		</div>
		<?php
		$fragments['#offcanvasCartBody'] = ob_get_clean();

		return $fragments;
	}
	public function asgard_woocommerce_add_class_to_cart_item_thumbnail($thumbnail, $cart_item, $cart_item_key)
	{
		// Get the attachment ID from the thumbnail URL
		$thumbnail_url = '';
		if (preg_match('/<img.*?src=["\'](.*?)["\'].*?>/i', $thumbnail, $matches)) {
			$thumbnail_url = $matches[1];
		}

		// Add classes to the <img> tag
		$classes = 'img-fluid img-thumbnail mx-auto d-block rounded-5 border border-0 attachment-thumbnail size-thumbnail p-0';
		$img_tag = '<img src="' . esc_url($thumbnail_url) . '" class="' . esc_attr($classes) . '" alt="' . esc_attr__('Product thumbnail', 'woocommerce') . '" width="80" height="80" />';

		return $img_tag;
	}

	public function asgard_ajax_product_remove()
	{

		// Check if the cart item key is provided

		check_ajax_referer('asgard_cart_nonce', 'nonce');

		$cart_item_key = sanitize_text_field($_POST['cart_item_key']);

		if (isset($_POST['cart_item_key'])) {
			$cart_item_key = sanitize_text_field($_POST['cart_item_key']);

			if (isset(WC()->cart->cart_contents[$cart_item_key])) {
				WC()->cart->remove_cart_item($cart_item_key);
				WC()->cart->calculate_totals();

				wp_send_json_success([
					'fragments' => $this->asgard_custom_cart_fragments(),
				]);
			}
		}

		wp_send_json_error();
	}

	public function asgard_custom_cart_fragments()
	{
		// Update cart fragment for mini cart
		ob_start();
		asgard_mini_cart();
		$mini_cart_counter = ob_get_clean();

		ob_start();
	?>
		<div class="offcanvas-header" id="offcanvasCartHeader">
			<h6 class="offcanvas-title text-black" id="offcanvasCartLabel">
				Your cart (<?php echo WC()->cart->get_cart_contents_count(); ?>)
			</h6>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<?php
		$cart_header = ob_get_clean();

		ob_start();
		?>
		<div class="right_cart-subtotal-right fw-semibold">
			<span class="woocommerce-Price-amount amount">
				<?php echo WC()->cart->get_cart_subtotal(); ?>
			</span>
		</div>
		<?php
		$cart_subtotal = ob_get_clean();

		ob_start();
		?>
		<div class="offcanvas-body p-0" id="offcanvasCartBody">
			<div class="right_cart-main d-flex flex-column justify-content-between h-100">
				<div class="right_cart-up offcanvas-body-inner">
					<?php if (WC()->cart->get_cart_contents_count() > 0) : ?>
						<ul class="mini-products-list list-unstyled mb-0 position-relative ms-0" id="cart-sidebar">
							<?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
								<?php
								$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
								if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) :
									$product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
									$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
									$product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
									$product_permalink = $_product->is_visible() ? $_product->get_permalink($cart_item) : '';
									$product_id = $_product->get_id();
								?>
									<li class="item d-inline-block p-3 w-100">
										<div class="item-inner d-flex">
											<a class="product-image flex-shrink-0 border-1 border-primary border-opacity-25"
												href="<?php echo esc_url($product_permalink); ?>"
												title="<?php echo esc_html($product_name); ?>">
												<?php echo wp_kses_post($thumbnail); ?>
											</a>
											<div class="product-details flex-grow-1 ms-3 position-relative">
												<div class="access d-flex justify-content-end position-absolute top-0 end-0">
													<a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>"
														title="<?php esc_attr_e('Remove This Item', 'asgard'); ?>"
														class="btn-remove"
														data-product_id="<?php echo esc_attr($product_id); ?>"
														data-product_sku="<?php echo esc_attr($_product->get_sku()); ?>"
														data-cart_item_key="<?php echo esc_attr($cart_item_key); ?>">
														<svg class="icon-close" width="16" height="16" fill="#000">
															<use href="#icon-trash"></use>
														</svg>
													</a>
												</div>


												<a class="product-name mb-1 d-block text-decoration-none link-secondary pe-3 lh-sm fw-semibold"
													href="<?php echo esc_url($product_permalink); ?>"
													title="<?php echo esc_html($product_name); ?>">
													<?php echo esc_html($product_name); ?>
												</a>
												<span class="fw-semibold"><?php echo esc_html($cart_item['quantity']); ?></span> x <span class="price fw-semibold"><?php echo wp_kses_post($product_price); ?></span>
											</div>
											<?php echo wc_get_formatted_cart_item_data($cart_item); ?>
										</div>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					<?php else: ?>
						<div class="a-center noitem p-2 text-center">
							<svg class="d-block mx-auto m-3" width="130" height="130" fill="#686363">
								<use href="#icon-bag"></use>
							</svg>
							<p class="fw-medium"><?php esc_attr_e('Your cart is empty', 'asgard'); ?></p>
							<a href="<?php echo wc_get_page_permalink('shop'); ?>" class="btn btn-primary"><?php esc_attr_e('Check out our offering', 'asgard'); ?></a>
						</div>
					<?php endif; ?>
					
				</div>

			</div>
		</div>
		<?php
		$offcanvasCartBody = ob_get_clean();

		return [
			'.mini-cart-counter'   => $mini_cart_counter,
			'#offcanvasCartHeader' => $cart_header,
			'#offcanvasCartBody' => $offcanvasCartBody,
			'.right_cart-subtotal-right' => $cart_subtotal,
		];
	}

	public function asgard_use_block_editor_for_post_type($post_type, $use_block_editor)
	{
		if ($post_type === 'product') {
			return true;
		}
		return $use_block_editor;
	}
	public function asgard_display_thankyou_popup($order_id)
	{
		if (is_wc_endpoint_url('order-received')) {
			$order = wc_get_order($order_id);
		?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					<?php if ($order->has_status('failed')) { ?>
						$('#order-failed-popup').modal('show');
					<?php } else { ?>
						$('#thankyou-popup').modal('show');
					<?php } ?>
				});
			</script>
			<div class="modal fade" id="thankyou-popup" tabindex="-1" role="dialog"
				aria-labelledby="thankyou-popup-label" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-body">
							<div class="d-flex justify-content-center align-items-center py-3 py-sm-5 flex-column">

								<div class="mb-4 text-center">
									<svg width="75" height="75" fill="var(--bs-primary)">
										<use href="#icon-circle-check"></use>
									</svg>
								</div>
								<div class="text-center">
									<h1>Thank You !</h1>
									<p>Your order has been received. We've send the link to your inbox.</p>
									<button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
								</div>

							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="order-failed-popup" tabindex="-1" role="dialog"
					aria-labelledby="order-failed-popup-label" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-body">
								<div class="d-flex justify-content-center align-items-center py-3 py-sm-5 flex-column">

									<div class="mb-4 text-center">
										<svg width="75" height="75" fill="var(--bs-danger)">
											<use href="#icon-close"></use>
										</svg>
									</div>
									<div class="text-center">
										<h1>Ohh, Order failed !</h1>
										<p>Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.</p>
										<button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
									</div>

								</div>
							</div>
						</div>
					</div>
		<?php
		}
	}

	public function asgard_custom_render_product_block($html, $data, $post)
	{
		$badge_html = '';
		if (!empty($data->badge)) {
			$badge_html = '<span class="custom-onsale py-1 px-2 position-absolute rounded-pill text-uppercase text-white text-decoration-none fw-semibold">' . $data->badge . '</span>';
		}

		return '<li class="wc-block-grid__product px-2">
										<div class="card h-100">
										<a href="' . $data->permalink . '" class="wc-block-grid__product-link text-decoration-none">
														' . $data->image . '
														' . $badge_html . '
										</a>
										<div class="card-body p-3">
										<a href="' . $data->permalink . '" class="wc-block-grid__product-link text-decoration-none">
														<h3 class="fs-14 text-decoration-none text-primary">' . $data->title . '</h3>
														<div class="data-rating d-none">' . $data->rating . '</div>
														<div class="product-price fw-bold fs-14 pb-3 d-block">' . $data->price . '</div>
										</a>
										<a href="' . $data->permalink . '" class="button product_type_variable add_to_cart_button" aria-label="view detail button">View detail</a>
										</div>
										</div>
						</li>';
	}
}
