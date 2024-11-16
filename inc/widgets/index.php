<?php

require_once get_template_directory() . '/inc/widgets/Facile_Recent_Comments.php';
require_once get_template_directory() . '/inc/widgets/Facile_Tag_Cloud.php';
require_once get_template_directory() . '/inc/widgets/Facile_Theme_Color_Switcher.php';

// 注册侧边栏的自定义小工具
function register_custom_widgets() {
    register_widget('Facile_Recent_Comments');
    register_widget('Facile_Tag_Cloud');
    register_widget('Facile_Theme_Color_Switcher');
}
add_action('widgets_init','register_custom_widgets');