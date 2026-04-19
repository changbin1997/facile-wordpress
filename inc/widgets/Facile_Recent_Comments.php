<?php

/**
 * Facile 最近评论小部件
 *
 * 继承 WP_Widget，用于在主题中显示最近的评论。支持自定义显示数量和小部件标题，
 * 采用 Bootstrap 媒体对象样式展示评论者头像、名称和评论摘要。
 *
 * @package Facile
 * @subpackage Widgets
 * @since 1.0.0
 */
class Facile_Recent_Comments extends WP_Widget {

    /**
     * 构造函数
     *
     * 初始化小部件，注册小部件 ID、标题和描述。设置小部件选项包括
     * 小部件可以有的自定义样式类等。
     *
     * @return void
     */
    public function __construct() {
        parent::__construct(
            'Facile_Recent_Comments',
            __('Facile Recent Comments', 'facile'),
            array( 'description' => __( 'Displays the specified number of recent comments.', 'facile' ), )
        );
    }

    /**
     * 输出小部件内容
     *
     * 从数据库获取指定数量的已批准评论，并按照 Bootstrap 媒体对象样式渲染
     * 评论列表。每条评论显示评论者头像、名称和评论摘要。支持自定义标题显示。
     *
     * @param array $args     小部件容器参数，包含 before_widget、after_widget、
     *                        before_title、after_title 等标签。
     * @param array $instance 小部件实例数据，通常包含 'title' 和 'number' 两个索引。
     *
     * @return void
     */
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

    /**
     * 输出小部件后台设置表单
     *
     * 生成小部件在 WordPress 后台小部件管理界面中的设置表单。包括标题和
     * 要显示的评论数量两个输入字段。允许用户在后台自定义这些参数。
     *
     * @param array $instance 小部件实例数据，包含当前保存的设置值。
     *
     * @return void
     */
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

    /**
     * 保存小部件设置
     *
     * 处理小部件表单提交的数据。对用户输入进行验证和清理，确保数据安全。
     * 评论数量使用 absint() 转换为正整数，标题使用 sanitize_text_field() 清理。
     *
     * @param array $new_instance 新提交的小部件实例数据。
     * @param array $old_instance 之前保存的小部件实例数据。
     *
     * @return array 经过验证和清理后的小部件实例数据。
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}