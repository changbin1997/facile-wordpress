<?php

class Facile_Tag_Cloud extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'facile_tag_cloud',
            __('Facile Tag Cloud', 'facile'),
            array( 'description' => __('Displays a specified number of colored tags, with random tag colors.', 'facile') )
        );
    }

    public function widget($args, $instance) {
        $number = !empty($instance['number']) ? absint($instance['number']) : 0;

        $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => $number));

        if (!$tags) {
            return;
        }

        $badgeClass = array(
            'badge-primary',
            'badge-success',
            'badge-info',
            'badge-warning',
            'badge-danger',
            'badge-dark'
        );

        echo $args['before_widget'];
        // 如果有标题就输出标题
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        ?>

        <div class="tagcloud clearfix" role="group" aria-label="<?php _e('Tag Cloud', 'facile'); ?>">
            <?php foreach ($tags as $tag): ?>
                <?php $tag_link = get_tag_link($tag->term_id) ?>
                <a role="listitem" data-toggle="tooltip" data-placement="top" title="<?php printf(__('%s posts', 'facile'), $tag->count); ?>" class="p-1 float-left m-1 badge <?php echo $badgeClass[array_rand($badgeClass)]; ?>" href="<?php echo esc_url($tag_link); ?>">
                    <?php echo esc_html($tag->name); ?>(<?php echo $tag->count; ?>)
                </a>
            <?php endforeach; ?>
        </div>

        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $number = !empty($instance['number']) ? absint($instance['number']) : 0;
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (Leave blank to hide)', 'facile'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Limit number of tags (0 for no limit)', 'facile'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="0" value="<?php echo $number; ?>" size="3">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 0;
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}