<?php
/**
 * Plugin Name: Contact information
 * Plugin URI: http://webcontrive.in/
 * Description: This plugin shows your contact information with icons. 
 * Version: 1.0
 * Author: Prakash
 * Author URI: https://profiles.wordpress.org/kp99925
 * Requires at least: 1.1
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: contact-information
 */

/**
 * add enqueue scripts and styles
 */
function kp_contact_widget_scripts() {

    wp_enqueue_style('job_fonts', 'http://fontawesome.io/assets/font-awesome/css/font-awesome.css', array(), '', false);
    wp_enqueue_style('job_fonts');
    wp_enqueue_style('contact_css', plugins_url('css/contact.css', __FILE__), array(), '', false);
    wp_enqueue_style('contact_css');
}

add_action('wp_enqueue_scripts', 'kp_contact_widget_scripts');

// Register and load the widget
function kp_load_widget() {
    register_widget('kp_contact_widget');
}

add_action('widgets_init', 'kp_load_widget');

// Creating the widget 
class kp_contact_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                // Base ID of your widget
                'kp_contact_widget',
                // Widget name will appear in UI
                __('Contact informatoion', 'kp_contact_widget'),
                // Widget description
                array('description' => __('This plugin shows your contact information with icons', 'kp_contact_widget'),)
        );
    }

// widget form creation
    function form($instance) {

        // Check values
        if ($instance) {
            $title = empty(esc_attr($instance['title'])) ? '' : esc_attr($instance['title']);
            $name = esc_attr($instance['name']);
            $email = strip_tags($instance['email']);
            $phone = strip_tags($instance['phone']);
            $fax = strip_tags($instance['fax']);
            $detail = strip_tags($instance['detail']);
        } else {
            $title = '';
            $name = '';
            $email = '';
            $phone = '';
            $fax = '';
            $detail = '';
        }
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Name:', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" type="text" value="<?php echo $name; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone:', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo $phone; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('fax'); ?>"><?php _e('Fax:', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" type="text" value="<?php echo $fax; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('detail'); ?>"><?php _e('Address:', 'wp_widget_plugin'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('detail'); ?>" name="<?php echo $this->get_field_name('detail'); ?>"><?php echo $detail; ?></textarea>
        </p>

        <?php
    }

    // update widget
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['name'] = strip_tags($new_instance['name']);
        $instance['email'] = strip_tags($new_instance['email']);
        $instance['phone'] = strip_tags($new_instance['phone']);
        $instance['fax'] = strip_tags($new_instance['fax']);
        $instance['detail'] = strip_tags($new_instance['detail']);
        return $instance;
    }

    // display widget
    function widget($args, $instance) {
        extract($args);
        // these are the widget options
        $title = apply_filters('widget_title', $instance['title']);
        $name = $instance['name'];
        $email = $instance['email'];
        $phone = $instance['phone'];
        $fax = $instance['fax'];
        $detail = $instance['detail'];


        echo $before_widget;
        // Display the widget
        echo '<ul class="contact-info">';

        // Check if title is set
        if ($title) {
            echo $before_title . $title . $after_title;
        }

        // Check if text is set
        if ($name) {
            echo '<li><i class="fa fa-user" aria-hidden="true"></i> ' . $name . '</li>';
        }
        // Check if text is set
        if ($email) {
            echo '<li><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:' . $email . '">' . $email . '</a></li>';
        }
        // Check if text is set
        if ($phone) {
            echo '<li><i class="fa fa-mobile" aria-hidden="true"></i> <a href="tel:' . $phone . '">' . $phone . '</a></li>';
        }
        // Check if text is set
        if ($fax) {
            echo '<li><i class="fa fa-fax" aria-hidden="true"></i> ' . $fax . '</li>';
        }
        // Check if text is set
        if ($detail) {
            echo '<li><i class="fa fa-address-card" aria-hidden="true"></i> ' . $detail . '</li>';
        }

        echo '</ul>';
        echo $after_widget;
    }

}

// ends