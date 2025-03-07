<?php
/**
 * Woocommerce Hooks Customization
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;
use WP_Widget;
use ASGARD_THEME\Inc\Traits\Singleton;

class Store_Information extends WP_Widget {
    use Singleton;

    private $widget_fields = array(
		array(
            'label' => 'Company Name 1',
            'id'    => 'company_name_1',
            'type'  => 'text',
        ),
        array(
            'label' => 'Company Name 2',
            'id'    => 'company_name_2',
            'type'  => 'text',
        ),
        array(
            'label' => 'Address',
            'id'    => 'shop_address',
            'type'  => 'textarea',
        ),
		array(
			'label' => 'Google Map URL',
			'id'    => 'google_map_url',
			'type'  => 'text',
		),
		array(
            'label' => 'Phone Number',
            'id'    => 'phonenumber_text',
            'type'  => 'text',
        ),
        array(
            'label' => 'Email Address',
            'id'    => 'emailaddress_text',
            'type'  => 'text',
        ),
        // array(
        //     'label' => 'Monday to Friday',
        //     'id'    => 'mondaytofriday_textarea',
        //     'type'  => 'text',
        // ),
        // array(
        //     'label' => 'Saturday to Sunday',
        //     'id'    => 'saturday_sunday_timing',
        //     'type'  => 'text',
        // ),
        // array(
        //     'label' => 'Time Zone',
        //     'id'    => 'timezone_text',
        //     'type'  => 'text',
        // ),
        
    );

    public function __construct() {
        parent::__construct(
            'storeinformation_widget',
            esc_html__('Store Information', 'asgard'),
            array('description' => esc_html__('Displays store information like phone, address, and office hours.', 'asgard'))
        );
        add_action('widgets_init', [ $this, 'register_widget' ]);
    }

    public function register_widget() {
        register_widget(__CLASS__);
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        echo '<div class="store-info-section text-white">';
        if (!empty($instance['company_name_1'])) {
            $companyName1 = ($instance['company_name_1']);
            echo '<p class="text-white text-decoration-none d-flex align-items-center lh-base mb-0"><span class="fw-normal"> ' . esc_html($instance['company_name_1']) . '</span></p>';
        }
        if (!empty($instance['company_name_2'])) {
            $companyName2 = ($instance['company_name_2']);
            echo '<p class="text-white text-decoration-none d-flex align-items-center lh-1 mb-3"><span class="fw-normal"> ' . esc_html($instance['company_name_2']) . '</span></p>';
        }
        if (!empty($instance['shop_address'])) {
			$googleMapUrl = ( ! empty( $instance['google_map_url'] ) ) ? $instance['google_map_url'] : 'javascript:void(0);';
            $address = wp_kses($instance['shop_address'], array('br' => array()));
            echo '<p><a href="'.esc_url($googleMapUrl).'" class="text-white text-decoration-none d-flex location">' . $address . '<br/>(Click Here For The Location)</a></p>';
        }
        if (!empty($instance['phonenumber_text'])) {
            $phoneNumber = ($instance['phonenumber_text']);
            echo '<p><a href="tel:' . removeSpacesFromNumber($phoneNumber) . '" class="text-white text-decoration-none d-flex align-items-center lh-1" target="_blank"><svg class="me-2" width="32" height="32" fill="#fff"><use href="#icon-phone"></use></svg><span class="fw-bold"> ' . esc_html($instance['phonenumber_text']) . '</span></a></p>';
        }
		if (!empty($instance['emailaddress_text'])) { 
            echo '<p><a href="mailto:' . esc_attr($instance['emailaddress_text']) . '" class="text-white text-decoration-none d-flex align-items-center lh-1"><svg class="me-2" width="32" height="32" fill="#fff"><use href="#icon-email"></use></svg><span class="fw-bold"> ' . esc_html($instance['emailaddress_text']) . '</span></a></p>';
        }
        
        // if (!empty($instance['mondaytofriday_textarea']) || !empty($instance['saturday_sunday_timing'])) {
        //     echo '<p><strong class="office-hours">Hours of Operation</strong></p><ul>';
        //     if (!empty($instance['mondaytofriday_textarea'])) {
        //         echo '<li><span>Monday to Friday</span><span class="fw-200">' . esc_html($instance['mondaytofriday_textarea']) . '</span></li>';
        //     }
        //     if (!empty($instance['saturday_sunday_timing'])) {
        //         echo '<li><span>Saturday to Sunday</span><span class="fw-200">' . esc_html($instance['saturday_sunday_timing']) . '</span></li>';
        //     }
        //     if (!empty($instance['timezone_text'])) {
        //         echo '<li><span class="fw-200">' . esc_html($instance['timezone_text']) . '</span></li>';
        //     }
        //     echo '</ul>';
        // }
        
        
        
        echo '</div>' . $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'asgard'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
        $this->field_generator($instance);
    }

    public function field_generator($instance) {
        foreach ($this->widget_fields as $widget_field) {
            $value = !empty($instance[$widget_field['id']]) ? $instance[$widget_field['id']] : '';
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id($widget_field['id'])); ?>"><?php echo esc_html($widget_field['label']); ?>:</label>
                <?php if ($widget_field['type'] === 'textarea') : ?>
                    <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id($widget_field['id'])); ?>" name="<?php echo esc_attr($this->get_field_name($widget_field['id'])); ?>" rows="4"><?php echo esc_textarea($value); ?></textarea>
                <?php else : ?>
                    <input class="widefat" id="<?php echo esc_attr($this->get_field_id($widget_field['id'])); ?>" name="<?php echo esc_attr($this->get_field_name($widget_field['id'])); ?>" type="<?php echo esc_attr($widget_field['type']); ?>" value="<?php echo esc_attr($value); ?>">
                <?php endif; ?>
            </p>
            <?php
        }
    }

    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        foreach ($this->widget_fields as $widget_field) {
            $instance[$widget_field['id']] = !empty($new_instance[$widget_field['id']]) ? strip_tags($new_instance[$widget_field['id']]) : '';
        }
        return $instance;
    }
}