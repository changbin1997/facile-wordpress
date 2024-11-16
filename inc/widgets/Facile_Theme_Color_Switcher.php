<?php

class Facile_Theme_Color_Switcher extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'theme_color_switcher',
            __('Facile Theme Color Mode Switcher', 'facile'),
            array( 'description' => __('Allows users to manually switch the color mode. The next time the user visits the site, their selected color mode will be displayed.', 'facile') )
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        // 如果有标题就输出标题
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        ?>
        <ul aria-label="<?php _e('Theme Color', 'facile'); ?>">
            <li>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input change-theme-color" type="radio" name="color" id="light-color">
                    <label class="custom-control-label" for="light-color"><?php _e('Light Theme', 'facile'); ?></label>
                </div>
            </li>
            <li>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input change-theme-color" type="radio" name="color" id="dark-color">
                    <label class="custom-control-label" for="dark-color"><?php _e('Dark Theme', 'facile'); ?></label>
                </div>
            </li>
        </ul>
        <?php

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (Leave blank to hide)', 'facile'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}