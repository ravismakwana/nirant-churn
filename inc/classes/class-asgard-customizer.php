<?php
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
        $this->add_countdown_timer_section($wp_customize);
        $this->add_single_product_section($wp_customize);
        $this->add_homepage_slider_panel($wp_customize);
    }

    private function add_top_footer_section($wp_customize) {
        $wp_customize->add_section('top_footer_section', [
            'title'    => __('Top Footer', 'asgard'),
            'priority' => 130,
        ]);

        $this->add_image_control($wp_customize, 'top_footer_bg', 'Background Image', 'top_footer_section');
        $this->add_text_control($wp_customize, 'top_footer_title', 'Title', 'top_footer_section', 'Secret of good health with ayurveda');
        $this->add_url_control($wp_customize, 'top_footer_btn_link', 'Button Link', 'top_footer_section', 'https://whatsapp.com/channel/0029Vay2r2z5Ejxrq9xqYM0D');
        $this->add_text_control($wp_customize, 'top_footer_btn_text', 'Button Text', 'top_footer_section', 'Join Now');
    }

    private function add_countdown_timer_section($wp_customize) {
        $wp_customize->add_section('countdown_timer_section', [
            'title' => __('Countdown Timer Settings', 'asgard'),
            'priority' => 140,
        ]);

        $default_end_date = gmdate('Y-m-d\TH:i', strtotime('+5 days'));

        $this->add_datetime_control($wp_customize, 'countdown_timer_end_date', 'End Date and Time (YYYY-MM-DD HH:MM:SS)', 'countdown_timer_section', $default_end_date);
        $this->add_text_control($wp_customize, 'countdown_timer_title', 'Countdown Title', 'countdown_timer_section', 'LIMITED TIME OFFER');

        $wp_customize->add_setting('countdown_revert_text', [
            'default'           => 'The price of this item will revert back to Rs. at the end of this countdown.',
            'sanitize_callback' => 'wp_kses_post',
        ]);

        $wp_customize->add_control('countdown_revert_text', [
            'label'    => __('Countdown Revert Back Text', 'asgard'),
            'section'  => 'countdown_timer_section',
            'type'     => 'textarea',
        ]);
    }

    private function add_single_product_section($wp_customize) {
        $wp_customize->add_section('single_product_section', [
            'title'    => __('Single Product Settings', 'asgard'),
            'priority' => 150,
        ]);

        $this->add_text_control($wp_customize, 'single_product_guaranteed_text', 'Guaranteed Text', 'single_product_section', 'Guaranteed Safe Checkout');
        $this->add_image_control($wp_customize, 'single_product_payment_logo', 'Payment Logo', 'single_product_section');

        // Adding Delivery Box Images
        for ($i = 1; $i <= 4; $i++) {
            $this->add_image_control($wp_customize, "single_product_delivery_box_$i", "Delivery Box $i", 'single_product_section');
            $this->add_text_control($wp_customize, "single_product_delivery_box_desc_$i", "Delivery Box $i Description", 'single_product_section', "Description for Delivery Box $i");
        }
    }

    private function add_homepage_slider_panel($wp_customize) {
        $wp_customize->add_panel('homepage_slider_panel', [
            'title'    => __('Homepage Slider', 'asgard'),
            'priority' => 160,
        ]);

        $wp_customize->add_section('desktop_slides_section', [
            'title'    => __('Desktop Slides', 'asgard'),
            'priority' => 161,
            'panel'    => 'homepage_slider_panel',
        ]);

        $this->add_image_control($wp_customize, 'desktop_slide_1', 'Desktop Slide 1', 'desktop_slides_section');
        $this->add_image_control($wp_customize, 'desktop_slide_2', 'Desktop Slide 2', 'desktop_slides_section');
        $this->add_image_control($wp_customize, 'desktop_slide_3', 'Desktop Slide 3', 'desktop_slides_section');

        $wp_customize->add_section('mobile_slides_section', [
            'title'    => __('Mobile Slides', 'asgard'),
            'priority' => 162,
            'panel'    => 'homepage_slider_panel',
        ]);

        $this->add_image_control($wp_customize, 'mobile_slide_1', 'Mobile Slide 1', 'mobile_slides_section');
        $this->add_image_control($wp_customize, 'mobile_slide_2', 'Mobile Slide 2', 'mobile_slides_section');
        $this->add_image_control($wp_customize, 'mobile_slide_3', 'Mobile Slide 3', 'mobile_slides_section');
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

    private function add_datetime_control($wp_customize, $id, $label, $section, $default) {
        $wp_customize->add_setting($id, [
            'default'           => $default,
            'sanitize_callback' => 'sanitize_text_field',
        ]);

        $wp_customize->add_control($id, [
            'label'    => __($label, 'asgard'),
            'section'  => $section,
            'type'     => 'datetime-local',
            'input_attrs' => [
                'min' => gmdate('Y-m-d\TH:i')
            ]
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