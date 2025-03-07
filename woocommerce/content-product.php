<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerceTemplates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
// Extra post classes
$classes = array();
if(is_shop() || is_product_category() ) {
	$classes[] = 'item col-lg-3 col-md-4 col-sm-6 col-6 mb-4';
} else {
	$classes[] = 'item col-lg-3 col-md-4 col-sm-6 col-6 mb-4';
}
?>
<div <?php wc_product_class($classes, $product); ?>>
    <div class="card h-100">
        
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action('woocommerce_before_shop_loop_item');
        ?>

        <?php if (has_post_thumbnail()) : ?>
            <img src="<?php echo get_the_post_thumbnail_url($product->get_id(), 'medium'); ?>" class="card-img-top" alt="<?php the_title(); ?>">
            <?php
            if ($product->is_on_sale()) {
                echo '<span class="custom-onsale py-1 px-2 position-absolute rounded-pill text-uppercase text-white text-decoration-none fw-semibold">Sale!</span>';
            }
            ?>
        <?php endif; ?>

        <div class="card-body">
            <?php
            /**
             * Hook: woocommerce_shop_loop_item_title.
             *
             * @hooked woocommerce_template_loop_product_title - 10
             */
            do_action('woocommerce_shop_loop_item_title');

            /**
             * Hook: woocommerce_after_shop_loop_item_title.
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action('woocommerce_after_shop_loop_item_title');
            
			/**
             * Hook: woocommerce_after_shop_loop_item.
             *
             * @hooked woocommerce_template_loop_product_link_close - 5
             * @hooked woocommerce_template_loop_add_to_cart - 10
             */
            do_action('woocommerce_after_shop_loop_item');
            ?>
        </div>
    </div>
</div>