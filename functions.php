<?php
/**
 * Theme Functions
 *
 * @package Asgard
 */

if(!defined('ASGARD_DIR_PATH')) {
	define('ASGARD_DIR_PATH', untrailingslashit( get_template_directory() ));
}
if(!defined('ASGARD_DIR_URI')) {
	define('ASGARD_DIR_URI', untrailingslashit( get_template_directory_uri() ));
}

if(!defined('ASGARD_BUILD_DIR_URI')) {
	define('ASGARD_BUILD_DIR_URI', untrailingslashit( get_template_directory_uri() ).'/assets/build');
}
if(!defined('ASGARD_BUILD_LIB_URI')) {
	define('ASGARD_BUILD_LIB_URI', untrailingslashit( get_template_directory_uri() ).'/assets/build/library');
}
if(!defined('ASGARD_BUILD_DIR_PATH')) {
	define('ASGARD_BUILD_DIR_PATH', untrailingslashit( get_template_directory() ).'/assets/build');
}
if(!defined('ASGARD_BUILD_JS_URI')) {
	define('ASGARD_BUILD_JS_URI', untrailingslashit( get_template_directory_uri() ).'/assets/build/js');
}
if(!defined('ASGARD_BUILD_JS_DIR_PATH')) {
	define('ASGARD_BUILD_JS_DIR_PATH', untrailingslashit( get_template_directory() ).'/assets/build/js');
}
if(!defined('ASGARD_BUILD_IMG_URI')) {
	define('ASGARD_BUILD_IMG_URI', untrailingslashit( get_template_directory_uri() ).'/assets/build/src/img');
}
if(!defined('ASGARD_BUILD_CSS_URI')) {
	define('ASGARD_BUILD_CSS_URI', untrailingslashit( get_template_directory_uri() ).'/assets/build/css');
}
if(!defined('ASGARD_BUILD_CSS_DIR_PATH')) {
	define('ASGARD_BUILD_CSS_DIR_PATH', untrailingslashit( get_template_directory() ).'/assets/build/css');
}
if(!defined('ASGARD_ARCHIVE_POST_PER_PAGE')) {
	define('ASGARD_ARCHIVE_POST_PER_PAGE', 12);
}
if(!defined('ASGARD_SEARCH_RESULTS_POST_PER_PAGE')) {
	define('ASGARD_SEARCH_RESULTS_POST_PER_PAGE', 10);
}

// Helper folder includes
require_once ASGARD_DIR_PATH .'/inc/helpers/autoloader.php';
require_once ASGARD_DIR_PATH .'/inc/helpers/template-tags.php';


function asgard_get_theme_instance(){

	\ASGARD_THEME\Inc\ASGARD_THEME::get_instance();
}
asgard_get_theme_instance();

// To check Blocks attributes
//$my_post = get_post(2);
//$parsed_blocks = parse_blocks($my_post->post_content);
//echo '<pre>';
//print_r($parsed_blocks);
//wp_die();
//Remove Gutenberg Block Library CSS from loading on the frontend
function asgard_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
} 
// add_action( 'wp_enqueue_scripts', 'asgard_remove_wp_block_library_css', 100 );

