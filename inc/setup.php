<?php

add_action('after_setup_theme', function() {
    // 加载翻译
    load_theme_textdomain('facile', get_template_directory() . '/languages');

    // 为文章和页面启用特色图片支持
    add_theme_support('post-thumbnails', array('post', 'page'));

    // 菜单
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'facile'),
        'footer-menu'  => __('Footer Menu', 'facile')
    ));

    // 启用小部件的选择性刷新功能
    add_theme_support('customize-selective-refresh-widgets');

    // 启用编辑器样式
    add_editor_style(array());

    // 在 head 区域生成标签
    add_theme_support('title-tag');

    // 生成 RSS
    add_theme_support('automatic-feed-links');

    // 启用 HTML5 支持，使 WordPress 在输出评论表单、评论列表、图库和标题等时使用 HTML5 标签
    add_theme_support('html5', array('comment-form', 'comment-list', 'gallery', 'caption'));
});

// 注册侧边栏
add_action( 'widgets_init', function() {
    register_sidebar(array(
        'name' => '侧边栏',
        'id' => 'sidebar',
        'description' => __('Add widgets to the sidebar', 'facile'),
        'before_widget' => '<section id="%1$s" class="ml-xl-4 ml-lg-3 mb-5 %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title mb-4">',
        'after_title' => '</h3>',
    ));
});