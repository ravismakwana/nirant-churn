<?php
/**
 * Woocommerce Hooks Customization
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;

class Asgard_Shortcodes {
	use Singleton;

	protected function __construct() {
		$this->setup_hooks();
	}

	protected function setup_hooks() {
		// shortcodes
		add_shortcode( 'display_mega_menu', [ $this, 'mega_menu_function' ] );
		add_shortcode( 'current_year', [ $this, 'asgard_current_year' ] );
		add_shortcode( 'instagram_reels_popup', [ $this, 'asgard_fetch_instagram_reels_with_popup' ] );
		add_shortcode( 'countdown_timer', [ $this, 'asgard_countdown_timer_shortcode' ] );
		add_shortcode('full_product_template', [$this, 'display_full_product_template']);
		add_shortcode('asgard_homepage_gallery_slider', [$this, 'render_asgard_homepage_gallery_slider']);
	}

	public function get_worldcollection_category_tree( $cat ) {
		$next = get_categories( 'taxonomy=product_cat&depth=2&hide_empty=0&orderby=title&order=ASC&parent=' . $cat );
		if ( $next ) :
			foreach ( $next as $cat ) {
				global $allCount;
				$allCount ++;
				$this->get_worldcollection_category_tree( $cat->term_id );
			}
		endif;
	}

	public function mega_menu_function() {
		/**
		 * Display Mega Menu On home page hover on all categories.
		 * Use shortcode: [display_mega_menu]
		 */
		global $allCount;
		$product_cat = '';

		$this->get_worldcollection_category_tree( 0 );

		$args        = array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'parent'     => 0
		);
		$product_cat = get_terms( $args );

		$countchildren               = count( $product_cat );
		$totalCategoryInSingleColumn = (int)$allCount / 4;
		$cnt                         = 1;
		$total                       = 0;
		ob_start();
		echo '<div class="col-sm-3 single-menu-column p-3">';

		foreach ( $product_cat as $parent_product_cat ) {
			$total = $cnt % (int)$totalCategoryInSingleColumn;

			if ( $total == 0 ) {
				echo '</div><div class="col-sm-3 single-menu-column p-3">';
			}
			echo '<ul class="parent-category list-unstyled m-0 ' . $cnt ++ . '===' . $totalCategoryInSingleColumn . '==' . $total . '">
                        <li><a href="' . get_term_link( $parent_product_cat->term_id ) . '" class="parent-category-a text-decoration-none text-primary p-1 position-relative lh-2 d-inline-block text-left w-100">' . $parent_product_cat->name . '<span class="arrow-menu"></span></a>
                      <ul class="list-unstyled my-1">';

			$child_args         = array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
				'parent'     => $parent_product_cat->term_id
			);
			$child_product_cats = get_terms( $child_args );
			foreach ( $child_product_cats as $child_product_cat ) {
				$total = $cnt % (int)$totalCategoryInSingleColumn;
				echo '<li class="' . $cnt ++ . '===' . $totalCategoryInSingleColumn . '==' . $total . '"><a href="' . get_term_link( $child_product_cat->term_id ) . '" class="text-decoration-none text-primary p-1 position-relative lh-1 d-inline-block text-left w-100 fw-200">' . $child_product_cat->name . '</a></li>';

				if ( $total == 0 ) {
					echo '</ul></div><div class="col-sm-3 single-menu-column p-3"><ul class="list-unstyled my-1 sub-categories">';
				}
			}
			echo '</ul>
                </li>
              </ul>';
		}
		echo '</div>';
		$data     = ob_get_clean();
		$allCount = 0;
		wp_reset_query();

		return $data;
	}

	public function asgard_current_year(){
		return date_i18n ('Y');
	}
	public function asgard_fetch_instagram_reels_with_popup() {
		// $access_token = 'IGAAPNuiDJa69BZAE5CeEctOTRnVGpoT012ZAFMzVmlueE44RWFEMG96ZAVFyUVNHNmNlNmJHRVBOX0szYkRsS2JSUnhZAUS1LazZA5RzRoS1RqaTVCWEpyOWVLUUk4THlpUUo3LV9sMG1mOWpXWWFfd0lkSVhn'; // Replace with your Instagram access token
		// $user_id = '17841471064384817'; // Replace with your Instagram User ID
		// $limit = 5; // Number of reels to fetch
	
		// $url = "https://graph.instagram.com/{$user_id}/media?fields=id,media_type,media_url,permalink,thumbnail_url&access_token={$access_token}&limit={$limit}";
	
		// $response = wp_remote_get($url);
	
		// if (is_wp_error($response)) {
		// 	return '<p>Unable to fetch Instagram Reels.</p>';
		// }
	
		// $body = wp_remote_retrieve_body($response);
		// $data = json_decode($body, true);
	
		// if (empty($data['data'])) {
		// 	return '<p>No Reels found.</p>';
		// }
	
		$html = '<div class="instagram-reels-container d-flex align-items-center justify-content-center flex-wrap">';
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// foreach ($data['data'] as $reel) {
		// 	if ($reel['media_type'] == 'VIDEO') {
		// 		$thumbnail = isset($reel['thumbnail_url']) ? $reel['thumbnail_url'] : $reel['media_url'];
		// 		$video_url = esc_url($reel['media_url']); 
	
		// 		$html .= '<div class="reel-item p-2">';
        //         $html .= '<a href="' . $video_url . '" class="popup-video bg-white d-block rounded-circle p-1 border border-3 border-primary">';
        //         $html .= '<img src="' . $thumbnail . '" class="reel-thumbnail rounded-circle" alt="Instagram Reel" height="60" width="60">';
        //         $html .= '</a>';
        //         $html .= '</div>';
		// 	}
		// }
	
		$html .= '</div>';
		return $html;
	}

	public function asgard_countdown_timer_shortcode($atts) {
		global $product;
		$custom_end_date = get_theme_mod('countdown_timer_end_date');
		$product_end_date = $product->get_meta('countdown_timer');
		$end_date = $product_end_date ? $product_end_date : $custom_end_date;
		$limited_offer_title = get_theme_mod('countdown_timer_title', 'Limited Time Offer');
		$unique_id = uniqid('countdown_');
	
		// Ensure end date always expires at 11:59:59 PM
		$end_date = date('Y-m-d 23:59:59', strtotime($end_date));
	
		// Check if end date is today and not yet passed midnight
		if (strtotime($end_date) < time()) {
			// Reset to 5-day timer starting from next midnight
			$end_date = date('Y-m-d 23:59:59', strtotime('+5 days'));
		}
	
		ob_start();
		if ($end_date) {
		?>
		<div id="<?php echo esc_attr($unique_id); ?>" class="count-down-single-product text-center pb-2 d-flex">
			<div class="bg-light rounded d-inline-block">
				<div class="bg-primary-subtle">
					<h5 class="text-success fs-14 py-2 mb-0 text-uppercase"><?php echo $limited_offer_title; ?></h5>
				</div>
				<div class="countdown p-3 d-flex justify-content-between gap-3">
					<div>
						<h3 class="text-success fs-4 fw-bold mb-0 days">00</h3>
						<p class="fs-6 fw-bold mb-0 text-success">days</p>
					</div>
					<div>
						<h3 class="text-success fs-4 fw-bold mb-0 hours">00</h3>
						<p class="fs-6 fw-bold mb-0 text-success">hours</p>
					</div>
					<div>
						<h3 class="text-success fs-4 fw-bold mb-0 minutes">00</h3>
						<p class="fs-6 fw-bold mb-0 text-success">minutes</p>
					</div>
					<div>
						<h3 class="text-success fs-4 fw-bold mb-0 seconds">00</h3>
						<p class="fs-6 fw-bold mb-0 text-success">seconds</p>
					</div>
				</div>
			</div>
		</div>
	
		<script>
			(function($) {
				function startCountdown(endDate, container) {
					const end = new Date(endDate).getTime();
	
					const timer = setInterval(function() {
						const now = new Date().getTime();
						const distance = end - now;
	
						if (distance < 0) {
							clearInterval(timer);
							container.hide();
							return;
						}
	
						const days = Math.floor(distance / (1000 * 60 * 60 * 24));
						const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
						const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
						const seconds = Math.floor((distance % (1000 * 60)) / 1000);
	
						container.find('.days').text(String(days).padStart(2, '0'));
						container.find('.hours').text(String(hours).padStart(2, '0'));
						container.find('.minutes').text(String(minutes).padStart(2, '0'));
						container.find('.seconds').text(String(seconds).padStart(2, '0'));
					}, 1000);
				}
	
				$(document).ready(function() {
					const container = $('#<?php echo esc_js($unique_id); ?>');
					startCountdown('<?php echo esc_js($end_date); ?>', container);
				});
			})(jQuery);
		</script>
		<?php
		}
		return ob_get_clean();
	}
	

public function display_full_product_template($atts) {
	// Prevent running in the WordPress block editor
	if (is_admin() && function_exists('get_current_screen') && get_current_screen()->is_block_editor()) {
					return '<p>Product display only visible on the frontend.</p>';
	}

	$atts = shortcode_atts([
					'id' => '',
	], $atts);

	if (empty($atts['id'])) {
					return '<p>No product ID provided.</p>';
	}

	$product = wc_get_product($atts['id']);

	if (!$product || !is_a($product, 'WC_Product')) {
					return '<p>Product not found or invalid product.</p>';
	}

	// Save the original global $post and $product
	global $post;
	$original_post = $post;
	$original_product = isset($GLOBALS['product']) ? $GLOBALS['product'] : null;

	// Set the product post and product object
	$post = get_post($product->get_id());
	setup_postdata($post);
	$GLOBALS['product'] = $product;

	// Start output buffering
	ob_start();

	// Load the full single product template
	wc_get_template_part('content', 'single-product');

	// Clean up
	wp_reset_postdata();
	$post = $original_post;
	$GLOBALS['product'] = $original_product;

	return ob_get_clean();
}

public function render_asgard_homepage_gallery_slider() {
	$images = wp_is_mobile() ? [
		esc_url(get_theme_mod('mobile_slide_1', '')),
		esc_url(get_theme_mod('mobile_slide_2', '')),
		esc_url(get_theme_mod('mobile_slide_3', ''))
] : [
		esc_url(get_theme_mod('desktop_slide_1', '')),
		esc_url(get_theme_mod('desktop_slide_2', '')),
		esc_url(get_theme_mod('desktop_slide_3', ''))
];

ob_start();
?>
<div class="gallery-slider" id="gallery-container">
		<?php foreach ($images as $image) : ?>
						<?php if (!empty($image)) : ?>
										<div><img src="<?php echo esc_url($image); ?>" alt="Gallery Image" loading="lazy"></div>
						<?php endif; ?>
		<?php endforeach; ?>
</div>
<?php
return ob_get_clean();
}

}
