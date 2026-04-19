<?php

/**
 * Facile 主题颜色模式切换小部件
 *
 * 继承 WP_Widget，用于在主题中提供主题颜色模式切换功能。允许用户手动
 * 选择亮色或暗黑主题，所选主题将保存到用户浏览器，下次访问会自动
 * 显示用户上次的主题选择。
 *
 * @package Facile
 * @subpackage Widgets
 * @since 1.0.0
 */
class Facile_Theme_Color_Switcher extends WP_Widget {

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
            'theme_color_switcher',
            __('Facile Theme Color Mode Switcher', 'facile'),
            array( 'description' => __('Allows users to manually switch the color mode. The next time the user visits the site, their selected color mode will be displayed.', 'facile') )
        );
    }

    /**
     * 输出小部件内容
     *
     * 渲染主题颜色模式切换界面。显示两个自定义引频选抹按钮，分别
     * 用于选择亮色主题和暗黑主题。每个选抹按钮按电台、无障碍网页标冶
     * 排列。并提供正确的 ARIA 事项以曦无障碍网页访问。支持自定义小部件标题显示。
     *
     * @param array $args     小部件容器参数，包含 before_widget、after_widget、
     *                        before_title、after_title 等标签。
     * @param array $instance 小部件实例数据，通常包含 'title' 索引。
     *
     * @return void
     */
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

    /**
     * 输出小部件后台设置表单
     *
     * 生成小部件在 WordPress 后台小部件管理界面中的设置表单。包括一个标题
     * 输入字段。
     *
     * @param array $instance 小部件实例数据，包含当前保存的设置值。
     *
     * @return void
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (Leave blank to hide)', 'facile'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    /**
     * 保存小部件设置
     *
     * 处理小部件表单提交的数据。对用户输入进行验证和清理，确保数据安全。
     * 标题使用 sanitize_text_field() 清理。返回清理后的数据用于保存到数据库。
     *
     * @param array $new_instance 新提交的小部件实例数据。
     * @param array $old_instance 之前保存的小部件实例数据。
     *
     * @return array 经过验证和清理后的小部件实例数据。
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}