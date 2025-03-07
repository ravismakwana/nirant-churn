<?php
/**
 * Customizer options
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;
use \WP_Customize_Image_Control;

class Asgard_Customizer {
    use Singleton;

    protected function __construct() {
        $this->setup_hooks();
    }

    protected function setup_hooks() {
        add_action('customize_register', [$this, 'register_customizer_settings']);
    }

    public function register_customizer_settings($wp_customize) {
        $this->add_top_footer_section($wp_customize);
    }

    private function add_top_footer_section($wp_customize) {
        // Add Section
        $wp_customize->add_section('top_footer_section', [
            'title'    => __('Top Footer', 'asgard'),
            'priority' => 130,
        ]);

        // Background Image
        $this->add_image_control($wp_customize, 'top_footer_bg', 'Background Image', 'top_footer_section');

        // Title
        $this->add_text_control($wp_customize, 'top_footer_title', 'Title', 'top_footer_section', 'Secret of good health with ayurveda');
        
        // Button Link
        $this->add_url_control($wp_customize, 'top_footer_btn_link', 'Button Link', 'top_footer_section', 'https://whatsapp.com/channel/0029Vay2r2z5Ejxrq9xqYM0D');

        // Button Text
        $this->add_text_control($wp_customize, 'top_footer_btn_text', 'Button Text', 'top_footer_section', 'Join Now');

        
    }

    private function add_image_control($wp_customize, $id, $label, $section) {
        $wp_customize->add_setting($id, [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $id, [
            'label'    => __($label, 'asgard'),
            'section'  => $section,
            'settings' => $id,
        ]));
    }

    private function add_url_control($wp_customize, $id, $label, $section, $default) {
        $wp_customize->add_setting($id, [
            'default'           => $default,
            'sanitize_callback' => 'esc_url_raw',
        ]);

        $wp_customize->add_control($id, [
            'label'    => __($label, 'asgard'),
            'section'  => $section,
            'type'     => 'url',
        ]);
    }

    private function add_text_control($wp_customize, $id, $label, $section, $default) {
        $wp_customize->add_setting($id, [
            'default'           => $default,
            'sanitize_callback' => 'sanitize_text_field',
        ]);

        $wp_customize->add_control($id, [
            'label'    => __($label, 'asgard'),
            'section'  => $section,
            'type'     => 'text',
        ]);
    }

    

    public static function get_top_footer_data() {
        return [
            'bg_image' => get_theme_mod('top_footer_bg', ''),
            'title'    => get_theme_mod('top_footer_title', 'Secret of good health with ayurveda'),
            'btn_text' => get_theme_mod('top_footer_btn_text', 'Join Now'),
            'btn_link' => get_theme_mod('top_footer_btn_link', 'https://whatsapp.com/channel/0029Vay2r2z5Ejxrq9xqYM0D'),
        ];
    }
}