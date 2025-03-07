<?php
/**
 * WooCommerce settings
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;

class Woo_Product_Archive {
	use Singleton;
	protected function __construct(){
		if ( class_exists( 'WooCommerce' ) ) {
			$this->setup_hooks();
		}
	}

	protected function setup_hooks() {
		// actions and filters
		// add_filter( 'woocommerce_enqueue_styles', [ $this, 'asgard_remove_woocommerce_all_style' ] );
		// add_filter( 'woocommerce_add_notice', [ $this, 'asgard_woocommerce_message_bootstrap_classes' ], 10, 3 );
		// add_filter( 'woocommerce_add_error', [ $this, 'asgard_woocommerce_message_bootstrap_classes' ], 10, 3 );
		// add_filter( 'woocommerce_add_success', [ $this, 'asgard_woocommerce_message_bootstrap_classes' ], 10, 3 );

		// remove actions
		remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
		remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
		add_action( 'woocommerce_after_shop_loop', [ $this, 'asgard_woocommerce_pagination' ],10 );

		add_action( 'woocommerce_before_shop_loop', [ $this, 'asgard_set_result_and_order_dropdown' ] );
		add_action( 'woocommerce_shop_loop_item_title', [ $this, 'asgard_woocommerce_template_loop_product_title' ],10 );
		add_filter('woocommerce_show_page_title', '__return_false'); // Hide default title
  		add_action('woocommerce_before_shop_loop', [$this, 'custom_archive_title'], 5);

	}
	
	
	public function asgard_woocommerce_message_bootstrap_classes( $classes, $message, $type ) {
		// Default WooCommerce message classes
		$woo_classes = array(
						'woocommerce-message' => 'alert alert-success d-flex align-items-center justify-content-between', // Success messages
						'woocommerce-error'   => 'alert alert-danger d-flex align-items-center justify-content-between',  // Error messages
						'woocommerce-info'    => 'alert alert-info d-flex align-items-center justify-content-between'     // Info messages
		);

		// Replace WooCommerce classes with Bootstrap 5 alert classes
		foreach ( $woo_classes as $woo_class => $bootstrap_class ) {
						$classes = str_replace( $woo_class, $bootstrap_class, $classes );
		}

		return $classes;
}


	public function asgard_set_result_and_order_dropdown(){
		?>
		<div class="d-flex justify-content-between align-items-end flex-wrap mb-3">
			<?php
				woocommerce_result_count();
				woocommerce_catalog_ordering();
			?>
		</div>
		<?php
	}

	public function asgard_woocommerce_template_loop_product_title(){
		?>
		<h3 class="woocommerce-loop-product__title product-title fw-normal fs-6">
			<?php the_title(); ?>
		</h3>
		<?php
	}

	public function asgard_woocommerce_pagination() {
		echo asgard_pagination();
	}

	public function custom_archive_title() {
		$title = $this->get_dynamic_title();
		echo '<h1 class="woocommerce-products-header__title page-title h3">' . esc_html($title) . '</h1>';
}

private function get_dynamic_title() {
		if (is_shop()) {
						return get_the_title(wc_get_page_id('shop')); // Shop page title
		}
		return 'Our Products';
}
}