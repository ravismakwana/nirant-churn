<?php
/**
 * Gets the thumbnail with Lazy Load.
 * Should be called in the WordPress Loop.
 *
 * @param int|null $post_id Post ID.
 * @param string $size The registered image size.
 * @param array $additional_attributes Additional attributes.
 *
 * @return string
 */
function get_the_post_custom_thumbnail( $post_id, $size = 'featured-thumbnail', $additional_attributes = [] ) {
	$custom_thumbnail = '';

	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	if ( has_post_thumbnail( $post_id ) ) {
		$default_attributes = [
			'loading' => 'lazy'
		];

		$attributes = array_merge( $additional_attributes, $default_attributes );

		$custom_thumbnail = wp_get_attachment_image(
			get_post_thumbnail_id( $post_id ),
			$size,
			false,
			$attributes
		);
	}

	return $custom_thumbnail;
}

/**
 * Renders Custom Thumbnail with Lazy Load.
 *
 * @param int $post_id Post ID.
 * @param string $size The registered image size.
 * @param array $additional_attributes Additional attributes.
 */
function the_post_custom_thumbnail( $post_id, $size = 'featured-thumbnail', $additional_attributes = [] ) {
	echo get_the_post_custom_thumbnail( $post_id, $size, $additional_attributes );
}

/**
 * Shows the published date and modified date of posts
 */
/**
 * Prints HTML with meta information for the current post-date/time.
 *
 * @return void
 */
function asgard_posted_on() {

	$year                        = get_the_date( 'Y' );
	$month                       = get_the_date( 'n' );
	$day                         = get_the_date( 'j' );
	$post_date_archive_permalink = get_day_link( $year, $month, $day );

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	// Post is modified ( when post published time is not equal to post modified time )
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_attr( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_attr( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'asgard' ),
		'<a href="' . esc_url( $post_date_archive_permalink ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on text-secondary">' . $posted_on . '</span>';
}
function asgard_posted_on_show_only_updated(){
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	// Post is modified
	if(get_the_time( 'U') !== get_the_modified_time( 'U')) {
		$time_string = '<time class="entry-date updated" datetime="%1$s">%2$s</time>';
	}
	$time_string = sprintf($time_string,
		esc_attr(get_the_modified_date( DATE_W3C)),
		esc_attr(get_the_modified_date()),
	);
	$posted_on = sprintf(
		esc_html_x('Posted on %s', 'post date', 'asgard'),
		'<a href="'.esc_url( get_permalink() ).'" rel="bookmark">'. $time_string .'</a>'
	);
	echo '<span class="posted-on text-secondary">'. $posted_on .'</span>';
}
/**
 * Show Author of post
 */
function asgard_posted_by(){
	$byline = sprintf(
		esc_html_x(' by %s', 'post author', 'asgard'),
		'<span class="author vcard"><a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID') ) ).'">'. esc_html(get_the_author()) .'</a></span>'
	);
	echo '<span class="byline text-secondary">'. $byline .'</span>';
}

/**
 * Get the trimmed version of post excerpt.
 *
 * This is for modifing manually entered excerpts,
 * NOT automatic ones WordPress will grab from the content.
 *
 * It will display the first given characters ( e.g. 100 ) characters of a manually entered excerpt,
 * but instead of ending on the nth( e.g. 100th ) character,
 * it will truncate after the closest word.
 *
 * @param int $trim_character_count Charter count to be trimmed
 *
 * @return bool|string
 */
function asgard_the_excerpt( $trim_character_count = 0 ) {
	$post_ID = get_the_ID();

	if ( empty( $post_ID ) ) {
		return null;
	}
	if ( has_excerpt() || 0 === $trim_character_count ) {
		the_excerpt();

		return;
	}
	$excerpt = wp_html_excerpt( get_the_excerpt( $post_ID ), $trim_character_count, '[...]' );
	echo $excerpt;
}

function asgard_excerpt_more() {
	if ( ! is_single() ) {
		$more = sprintf( '<a class="asgard-read-more text-white mt-3 btn btn-info" href="%1$s">%2$s</a>',
			get_permalink( get_the_ID() ),
			__( 'Read more', 'asgard' )
		);
	}

	return $more;
}

function asgard_pagination(){
	$allowed_tags = [
		'span' => [
			'class' => []
		],
		'ul'    =>[
			'class' => [],
		],
		'li'    =>[
			'class' => [],
		],
		'a'    => [
			'class' => [],
			'href'  => [],
		],
	];
	$args  =   [
		'type'      => 'array',
		'prev_next' => true,
		'prev_text' => __('« Prev'),
		'next_text' => __('Next »'),
	];
	$pages = paginate_links($args);
	$pagination ='';
	if (is_array($pages)) {
		$pagination = '<ul class="pagination justify-content-center">';
		foreach ($pages as $page) {
			$current_class = strpos($page, 'current') ? 'active' : '';
			$pagination .= '<li class="page-item '.$current_class.'">' . str_replace('page-numbers', 'page-link', $page) . '</li>';
		}
		$pagination .= '</ul>';
	}
	printf('<nav class="asgard-pagination">%s</nav>', wp_kses($pagination, $allowed_tags));
}
/**
 * Display Post pagination with prev next, first last, to, from
 *
 * @param $current_page_no
 * @param $posts_per_page
 * @param $article_query
 * @param $first_page_url
 * @param $last_page_url
 * @param bool $is_query_param_structure
 */
function asgard_the_post_pagination( $current_page_no, $posts_per_page, $article_query, $first_page_url, $last_page_url, bool $is_query_param_structure = true ) {
	$prev_posts = ( $current_page_no - 1 ) * $posts_per_page;
	$from       = 1 + $prev_posts;
	$to         = count( $article_query->posts ) + $prev_posts;
	$of         = $article_query->found_posts;
	$total_pages = $article_query->max_num_pages;

	$base = ! empty( $is_query_param_structure ) ? add_query_arg( 'page', '%#%' ) :  get_pagenum_link( 1 ) . '%_%';
	$format = ! empty( $is_query_param_structure ) ? '?page=%#%' : 'page/%#%';

	?>
	<div class="mt-0 md:mt-10 mb-10 lg:my-5 flex items-center justify-end posts-navigation">
		<?php
		if ( 1 < $total_pages && !empty( $first_page_url ) ) {
			printf(
				'<span class="mr-2">Showing %1$s - %2$s Of %3$s</span>',
				$from,
				$to,
				$of
			);
		}


		// First Page
		if ( 1 !== $current_page_no && ! empty( $first_page_url ) ) {
			printf( '<a class="first-pagination-link btn border border-secondary mr-2" href="%1$s" title="first-pagination-link">%2$s</a>', esc_url( $first_page_url ), __( 'First', 'asgard' ) );
		}

		echo paginate_links( [
			'base'      => $base,
			'format'    => $format,
			'current'   => $current_page_no,
			'total'     => $total_pages,
			'prev_text' => __( 'Prev', 'asgard' ),
			'next_text' => __( 'Next', 'asgard' ),
		] );

		// Last Page
		if ( $current_page_no < $total_pages && !empty( $last_page_url ) ) {

			printf( '<a class="last-pagination-link btn border border-secondary ml-2" href="%1$s" title="last-pagination-link">%2$s</a>', esc_url( $last_page_url ), __( 'Last', 'asgard' ) );
		}

		?>
	</div>
	<?php
}

/**
 * Checks to see if the specified user id has a uploaded the image via wp_admin.
 *
 * @return bool  Whether or not the user has a gravatar
 */
function asgard_is_uploaded_via_wp_admin( $gravatar_url ) {

	$parsed_url = wp_parse_url( $gravatar_url );

	$query_args = ! empty( $parsed_url['query'] ) ? $parsed_url['query'] : '';

	// If query args is empty means, user has uploaded gravatar.
	return empty( $query_args );

}

/**
 * If the gravatar is uploaded returns true.
 *
 * There are two things we need to check, If user has uploaded the gravatar:
 * 1. from WP Dashboard, or
 * 2. or gravatar site.
 *
 * If any of the above condition is true, user has valid gravatar,
 * and the function will return true.
 *
 * 1. For Scenario 1: Upload from WP Dashboard:
 * We check if the query args is present or not.
 *
 * 2. For Scenario 2: Upload on Gravatar site:
 * When constructing the URL, use the parameter d=404.
 * This will cause Gravatar to return a 404 error rather than an image if the user hasn't set a picture.
 *
 * @param $user_email
 *
 * @return bool
 */
function asgard_has_gravatar( $user_email ) {

	$gravatar_url = get_avatar_url( $user_email );

	if ( asgard_is_uploaded_via_wp_admin( $gravatar_url ) ) {
		return true;
	}

	$gravatar_url = sprintf( '%s&d=404', $gravatar_url );

	// Make a request to $gravatar_url and get the header
	$headers = @get_headers( $gravatar_url );

	// If request status is 200, which means user has uploaded the avatar on gravatar site
	return preg_match( "|200|", $headers[0] );
}

function is_blog () {
	return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}

function asgard_mini_cart(){
	?>
		<a id="cart_badge" class="mini-cart" href="#offcanvasCart"
			class="m-0 d-flex text-decoration-none align-items-center" data-bs-toggle="offcanvas" aria-controls="offcanvasCart">
			<div class="position-relative p-0 cart-icon-button d-flex justify-content-center align-items-center h-auto w-auto">
				<svg width="24" height="24" fill="#000"><use href="#icon-basket"></use></svg>
				<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary fw-normal">
					<?php echo esc_html( WC()->cart->cart_contents_count ); ?>
					<span class="visually-hidden">New alerts</span>
				</span>
			</div>
		</a>
	<?php
}

if ( ! function_exists ( 'asgard_canvas_right_cart' ) ) {
	function asgard_canvas_right_cart() {
		?>
		<div class="offcanvas offcanvas-end asgard_canvas_right_cart-main" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
			
				<div class="offcanvas-header" id="offcanvasCartHeader">
					<h6 class="offcanvas-title text-black" id="offcanvasCartLabel">Your cart <?php echo (WC()->cart->cart_contents_count > 0) ? "(".esc_html( WC()->cart->cart_contents_count ).")" : '' ; ?></h6>
					<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
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
															data-product_id="<?php echo esc_attr( $product_id ); ?>"
															data-product_sku="<?php echo esc_attr( $_product->get_sku() ); ?>" 
															data-cart_item_key="<?php  echo esc_attr( $cart_item_key ); ?>">
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
									<a href="<?php echo wc_get_page_permalink( 'shop' ); ?>" class="btn btn-primary">Check out our offering</a>
								</div>
								
							<?php endif; ?>
							
						</div>

					</div>
				</div>
				<div class="offcanvas-footer right_cart-down pb-3">
					<div class="right_cart-subtotal d-flex justify-content-start align-items-center p-3">
						<h6 class="right_cart-subtotal-left text-black fw-semibold mb-0">
							<?php esc_html_e('Total:&nbsp;', 'asgard'); ?>
						</h6>
						<div class="right_cart-subtotal-right fw-semibold">
							<?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?>
						</div>
					</div>
					<div class="actions d-flex justify-content-center px-3 flex-column gap-2">
						<a class="btn-checkout btn btn-primary text-white text-decoration-none fw-semibold"
								title="<?php esc_attr_e('Checkout', 'asgard'); ?>"
								type="button"
								href="<?php echo esc_js(wc_get_checkout_url()); ?>">
							<span><?php esc_attr_e('Checkout', 'asgard'); ?></span>
						</a>
						<a class="view-cart btn btn-link text-primary text-decoration-none fw-semibold"
						href="<?php echo esc_js(wc_get_cart_url()); ?>">
							<span class="text-secondary"><?php esc_attr_e('View cart', 'asgard'); ?></span>
						</a>
					</div>
				</div>
			
		</div>
		<?php
	}
}

function removeSpacesFromNumber($number) {
    return str_replace(' ', '', $number);
}
function asgard_woocommerce_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	?>
    <li <?php comment_class( 'd-flex align-items-start' ); ?> id="comment-<?php comment_ID(); ?>">
        <div class="flex-shrink-0">
            <img class="mr-3 rounded-circle img-fluid img-thumbnail border border-primary border-opacity-25"
                 src="<?php echo get_avatar_url( $comment, [ 'size' => '60' ] ); ?>"
                 alt="<?php echo esc_attr( get_comment_author() ); ?>">
        </div>
        <div class="flex-grow-1 ms-3 p-3 border border-primary border-opacity-25">
            <h5 class="mt-0 text-capitalize lh-1"><?php echo get_comment_author(); ?></h5>
            <p class="comment-metadata lh-1">
                <small class="text-muted"><?php printf( '%1$s at %2$s', get_comment_date(), get_comment_time() ); ?></small>
            </p>
			<?php if ( $comment->comment_approved == '0' ) : ?>
                <p class="comment-awaiting-moderation alert alert-info"><?php _e( 'Your comment is awaiting moderation.', 'woocommerce' ); ?></p>
			<?php endif; ?>
            <div class="comment-content">
				<?php comment_text(); ?>
            </div>
            <div class="comment-reply d-flex">
				<?php edit_comment_link( '(Edit)', '<span class="edit-link me-3">', '</span>' ); ?>
				<?php comment_reply_link( array_merge( $args, array( 'depth'     => $depth,
				                                                     'max_depth' => $args['max_depth']
				) ) ); ?>
            </div>
        </div>
    </li>
	<?php
}
function asgard_wc_display_item_meta( $item, $args = array() ) {
	$strings = array();
	$html    = '';
	$args    = wp_parse_args(
		$args,
		array(
			'before'       => '<ul class="wc-item-meta ms-0 ps-0"><li>',
			'after'        => '</li></ul>',
			'separator'    => '</li><li>',
			'echo'         => true,
			'autop'        => false,
			'label_before' => '<strong class="wc-item-meta-label">',
			'label_after'  => ':</strong> ',
		)
	);

	foreach ( $item->get_all_formatted_meta_data() as $meta_id => $meta ) {
		$value     = $args['autop'] ? wp_kses_post( $meta->display_value ) : wp_kses_post( make_clickable( trim( $meta->display_value ) ) );
		$strings[] = $args['label_before'] . wp_kses_post( $meta->display_key ) . $args['label_after'] . $value;
	}

	if ( $strings ) {
		$html = $args['before'] . implode( $args['separator'], $strings ) . $args['after'];
	}

	$html = apply_filters( 'woocommerce_display_item_meta', $html, $item, $args );

	if ( $args['echo'] ) {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $html;
	} else {
		return $html;
	}
}