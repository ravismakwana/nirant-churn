<?php
/**
 * Template for post entry header
 *
 * @package Asgard
 */

$the_post_id        = get_the_ID();
$hide_page_title    = get_post_meta( $the_post_id, '_hide_page_title', true );
$has_post_thumbnail = get_the_post_thumbnail( $the_post_id );
$heading_class      = !empty( $hide_page_title ) && 'yes' == $hide_page_title ? 'hide' : '';
?>
<header class="entry-header">
	<?php
	// Featured image
	if ( $has_post_thumbnail ) {
        if(!is_single()) {
	        ?>
            <div class="entry-image mb-3">
                <a class="d-block" href="<?php echo esc_url( get_permalink() ); ?>">
                    <figure class="img-container">
				        <?php
				        the_post_custom_thumbnail(
					        $the_post_id,
					        'featured-thumbnail',
					        [
						        'sizes' => '(max-width: 350px) 350px, 233px ',
						        'class' => 'attachment-featured-large size-featured-image',
					        ]
				        )
				        ?>
                    </figure>
                </a>

            </div>
	        <?php
        } else {
	        ?>
            <div class="entry-image mb-3 d-block">
                <figure class="img-container">
                    <?php
                    the_post_custom_thumbnail(
                        $the_post_id,
                        'full',
                        [
                            'sizes' => '(min-width: 350px) 1440px',
                            'class' => 'attachment-featured-large size-featured-image img-fluid',
                        ]
                    )
                    ?>
                </figure>
            </div>
	        <?php
        }

	}
    if( is_single() || is_page()) {
        printf(
                '<h1 class="page-title text-dark %1$s">%2$s</h1>',
                esc_attr( $heading_class ),
                wp_kses_post( get_the_title() )
        );
    } else {
        printf(
                '<h2 class="entry-title mb-3"><a href="%1$s" class="text-dark text-decoration-none ">%2$s</a></h2>',
	            esc_url( get_the_permalink($the_post_id) ),
	            wp_kses_post( get_the_title() )
        );
    }
    ?>
</header>
<?php