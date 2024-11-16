<?php

class Facile_Recent_Comments extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'Facile_Recent_Comments',
            __('Facile Recent Comments', 'facile'),
            array( 'description' => __( 'Displays the specified number of recent comments.', 'facile' ), )
        );
    }

    public function widget( $args, $instance ) {
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;

        echo $args['before_widget'];
        // 如果有标题就输出标题
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $comments = get_comments(array(
            'number' => $number,
            'status' => 'approve',
            'post_status' => 'publish'
        ));

        if ($comments) {
            ?>
            <ul class="facile-latest-comment" aria-label="<?php echo __('Recent Comments', 'facile'); ?>">
            <?php foreach ($comments as $comment): ?>
                <li class="media mb-2">
                    <img class="avatar" src="<?php echo get_avatar_url($comment->comment_author_email, 42); ?>" alt="<?php echo get_comment_author($comment); ?>">
                    <div class="media-body">
                        <h5 class="mb-0 text-truncate">
                            <a data-toggle="tooltip" data-placement="top" title="<?php printf(__('Comment on %s', 'facile'), get_the_title($comment->comment_post_ID)); ?>" href="<?php echo get_comment_link($comment->comment_ID); ?>"><?php echo get_comment_author($comment); ?></a>
                        </h5>
                        <p class="m-0"><?php echo get_comment_excerpt($comment->comment_ID); ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
            </ul>
            <?php
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (Leave blank to hide)', 'facile'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of comments to display', 'facile'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}