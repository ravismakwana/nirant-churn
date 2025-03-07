<?php
/**
 * Single Product Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();
// echo $rating_count;

if ( $rating_count > 0 ) : ?>

	<div class="woocommerce-product-rating mb-2 d-flex align-items-center gap-2">
		<div class="custom-star-rating">
			<?php
			echo wc_get_rating_html( $average, $review_count );
			?>
		</div>
		<?php if ( comments_open() ) : ?>
			<a href="#reviews" class="woocommerce-review-link text-black text-decoration-none" rel="nofollow">
				| <?php printf( _n( '%s review', '%s reviews', $review_count, 'woocommerce' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>
			</a>
		<?php endif; ?>
	</div>

<?php endif; ?>
