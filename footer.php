<?php
/**
 * Footer Template
 *
 * @package Asgard
 */

$domain = get_option('siteurl'); //or home
$domain = str_replace('https://www.', '', $domain);

$top_footer = ASGARD_THEME\Inc\Asgard_Customizer::get_top_footer_data();

?>
<div id="dropdownOverlay" class="dropdown-overlay"></div>
</div>
<?php if(!empty($top_footer)) { ?>
<div class="join-community container-fluid border-top border-5 border-secondary py-5 text-center bg-primary position-relative" style="background-image: url('<?php echo esc_url($top_footer['bg_image']); ?>');">
    <h5 class="join-community__title my-3 text-white h2 position-relative"><?php echo esc_html($top_footer['title']); ?></h5>
    <a class="join-community__link  my-3 btn btn-primary position-relative" href="<?php echo esc_url($top_footer['btn_link']); ?>" target="_blank"><?php echo esc_html($top_footer['btn_text']); ?></a>
</div>
<?php } ?>
<footer class="bg-secondary text-white">
<div class="footer-widget pt-sm-4 py-0 py-4 ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xl-4 col-12 pt-4 pt-md-5 pb-md-5 mb-4 mb-md-0">
					<?php if ( is_active_sidebar( 'footer-1' ) ) { ?>
						<?php dynamic_sidebar( 'footer-1' ); ?>
					<?php } ?>
                </div>
                <div class="col-lg-12 col-12 col-xl-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6 col-12 footer-menus">
                                    <div class="d-flex column-gap-5 pt-4 pt-lg-0 pt-xl-5 pb-md-5 mb-4 mb-md-0">
                                        <?php if ( is_active_sidebar( 'footer-2' ) ) { dynamic_sidebar( 'footer-2' ); } ?>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-6 col-12">
                                <div class="pt-4 pt-lg-0 pt-xl-5 pb-md-5 mb-4 mb-md-0">
                                    <?php if ( is_active_sidebar( 'footer-3' ) ) { dynamic_sidebar( 'footer-3' ); } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="pt-4 pt-md-0 pb-md-5 mb-4 mb-md-0"><?php if ( is_active_sidebar( 'footer-4' ) ) { dynamic_sidebar( 'footer-4' ); } ?></div>
                                </div>
                                    
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="pt-4 pt-md-0 pb-md-5 mb-4 mb-md-0"><?php if ( is_active_sidebar( 'footer-5' ) ) { dynamic_sidebar( 'footer-5' ); } ?></div>
                                </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <?php 
            wp_nav_menu( array(
                'menu'           => 'Project Nav', // Do not fall back to first non-empty menu.
                'theme_location' => 'asgard-footer-menu',
                'fallback_cb'    => false, // Do not fall back to wp_page_menu()
                'menu_class'	=> "m-0 p-0 d-flex justify-content-between list-unstyled flex-wrap",
            ) );
            ?>
        </div>
    </div>
    <div class="footer-copyright text-center text-white py-2 fs-14 text-center container-fluid">
        Copyright © <?php echo date( 'Y' ); ?> | <a href="<?php echo home_url(); ?>" class="text-white text-decoration-none"><?php echo get_option( 'blogname' ); ?></a>
    </div>
</footer>
</div>

<?php
wp_footer();
get_template_part('template-parts/content','svgs');
echo asgard_canvas_right_cart();
?>
<div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasSearch" aria-labelledby="offcanvasTopLabel">
  <div class="offcanvas-header">
    <h6 class="offcanvas-title" id="offcanvasTopLabel">Find anything you need</h6>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body pt-0">
    <?php
        if ( shortcode_exists( 'fibosearch' ) ) {
            echo do_shortcode( '[fibosearch]' );
        }
    ?>
  </div>
</div>
<a class="stickywhatsapp position-fixed bottom-50 common-css" target="_blank" href="https://api.whatsapp.com/send?phone=919104332327&text=Hello%2C%20I%20want%20more%20info%20about%20the%20B12%20Green%20Food"><img src="https://cdn.shopify.com/s/files/1/0606/9298/8070/files/wa-logo-120.png?v=1706167621" width="35" height="35"> Whatsapp us</a>
<a class="stickycall position-fixed common-css" target="_blank" href="tel:+919104332327"><img src="https://cdn.shopify.com/s/files/1/0606/9298/8070/files/phone-ringing.png?v=1706167621" width="30" height="30"> Call us</a>
</body>
</html>
