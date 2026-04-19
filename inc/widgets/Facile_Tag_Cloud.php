<?php

/**
 * Facile 标签云小部件
 *
 * 继承 WP_Widget，用于在主题中显示标签云。支持自定义显示的标签数量，
 * 采用 Bootstrap badge 样式展示，每个标签随机分配不同的颜色。显示每个标签的文章数量，
 * 并支持点击标签跳转到该标签的存档页面。
 *
 * @package Facile
 * @subpackage Widgets
 * @since 1.0.0
 */
class Facile_Tag_Cloud extends WP_Widget {

    /**
     * 构造函数
     *
     * 初始化小部件，注册小部件 ID、标题和描述。使用 WP_Widget 父类的构造函数
     * 完成小部件的注册，使其可在 WordPress 后台小部件管理中使用。
     *
     * @return void
     */
    public function __construct() {
        parent::__construct(
            'facile_tag_cloud',
            __('Facile Tag Cloud', 'facile'),
            array( 'description' => __('Displays a specified number of colored tags, with random tag colors.', 'facile') )
        );
    }

    /**
     * 输出小部件内容
     *
     * 从数据库获取指定数量的标签，并按文章数量降序排列。使用 Bootstrap badge 样式
     * 渲染标签，每个标签随机分配一种颜色。显示标签名称、文章数量，以及 Tooltip 提示。
     * 支持自定义小部件标题显示。
     *
     * @param array $args     小部件容器参数，包含 before_widget、after_widget、
     *                        before_title、after_title 等标签。
     * @param array $instance 小部件实例数据，通常包含 'title' 和 'number' 两个索引。
     *
     * @return void
     */
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

    /**
     * 输出小部件后台设置表单
     *
     * 生成小部件在 WordPress 后台小部件管理界面中的设置表单。包括标题和标签数量限制
     * 两个输入字段。允许用户在后台自定义这些参数，其中标签数量为 0 表示显示所有标签。
     *
     * @param array $instance 小部件实例数据，包含当前保存的设置值。
     *
     * @return void
     */
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

    /**
     * 保存小部件设置
     *
     * 处理小部件表单提交的数据。对用户输入进行验证和清理，确保数据安全。
     * 标签数量使用 absint() 转换为正整数，标题使用 sanitize_text_field() 清理。
     * 返回清理后的数据用于保存到数据库。
     *
     * @param array $new_instance 新提交的小部件实例数据。
     * @param array $old_instance 之前保存的小部件实例数据。
     *
     * @return array 经过验证和清理后的小部件实例数据。
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 0;
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}