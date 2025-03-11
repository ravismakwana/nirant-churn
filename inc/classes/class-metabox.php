<?php
/**
 * Register Custom Meta box
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;

class MetaBox {
	use Singleton;

	protected function __construct() {
		$this->setup_hooks();
	}

	protected function setup_hooks() {
		// actions and filters
		add_action( 'add_meta_boxes', [ $this, 'add_custom_meta_box' ] );
		add_action( 'save_post', [ $this, 'save_meta_data' ] );
		add_action( 'woocommerce_product_after_variable_attributes', [ $this, 'add_variation_custom_fields' ], 10, 3 );
		add_action( 'woocommerce_save_product_variation', [ $this, 'save_variation_custom_fields' ], 10, 2 );
	}

	public function add_custom_meta_box( $post ) {
		$screens = [ 'post' ];
		foreach ( $screens as $screen ) {
			add_meta_box(
				'_hide_page_title',
				__( 'Custom Meta Box Title', 'asgard' ),
				[ $this, 'custom_meta_box_hide_page_title' ],
				$screen,
				'side',
				'high'
			);
		}
	}

	public function custom_meta_box_hide_page_title( $post ) {
		$value = get_post_meta( $post->ID, '_hide_page_title', true );
		wp_nonce_field( plugin_basename(__FILE__), 'hide_title_meta_box_nonce' );
		?>
		<label for="asgard-field"><?php esc_html_e( 'Hide Page Title?', 'asgard' ); ?></label>
		<select name="asgard_page_title_hide_field" id="asgard-field" class="">
			<option value=""><?php esc_html_e( 'Select', 'asgard' ); ?></option>
			<option value="yes" <?php selected( $value, 'yes' ); ?>><?php esc_html_e( 'Yes', 'asgard' ); ?></option>
			<option value="no" <?php selected( $value, 'no' ); ?>><?php esc_html_e( 'No', 'asgard' ); ?></option>
		</select>
		<?php
	}

	public function save_meta_data( $post_id ) {
		if(! current_user_can('edit_post', $post_id) ) {
			return;
		}
		if(!isset($_POST['hide_title_meta_box_nonce']) ||
			!wp_verify_nonce($_POST['hide_title_meta_box_nonce'], plugin_basename(__FILE__))) {
			return;
		}
		if ( array_key_exists( 'asgard_page_title_hide_field', $_POST ) ) {
			update_post_meta(
				$post_id,
				'_hide_page_title',
				$_POST['asgard_page_title_hide_field']
			);
		}
	}

	public function add_variation_custom_fields( $loop, $variation_data, $variation ) {
		woocommerce_wp_text_input([
			'id' => "_product_pack_variation[$loop]",
			'label' => __( 'Pack Information', 'asgard' ),
			'value' => get_post_meta( $variation->ID, '_product_pack_variation', true ),
			'wrapper_class' => 'form-row form-row-full',
		]);

		woocommerce_wp_text_input([
			'id' => "_product_best_results_variation[$loop]",
			'label' => __( 'Best Results Information', 'asgard' ),
			'value' => get_post_meta( $variation->ID, '_product_best_results_variation', true ),
			'wrapper_class' => 'form-row form-row-full',
		]);
	}

	public function save_variation_custom_fields( $variation_id, $i ) {
		if ( isset( $_POST['_product_pack_variation'][$i] ) ) {
			update_post_meta( $variation_id, '_product_pack_variation', sanitize_text_field( $_POST['_product_pack_variation'][$i] ) );
		}

		if ( isset( $_POST['_product_best_results_variation'][$i] ) ) {
			update_post_meta( $variation_id, '_product_best_results_variation', sanitize_text_field( $_POST['_product_best_results_variation'][$i] ) );
		}
	}
}