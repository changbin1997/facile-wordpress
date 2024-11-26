<?php

// 为文章和页面启用特色图片支持
function theme_setup() {
    add_theme_support('post-thumbnails', array('post', 'page'));
}
add_action('after_setup_theme', 'theme_setup');

// 注册侧边栏
function theme_register_sidebar() {
    register_sidebar(array(
        'name' => '侧边栏',
        'id' => 'sidebar',
        'description' => __('Add widgets to the sidebar', 'facile'),
        'before_widget' => '<section id="%1$s" class="ml-xl-4 ml-lg-3 mb-5 %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title mb-4">',
        'after_title' => '</h3>',
    ));
}
add_action( 'widgets_init', 'theme_register_sidebar' );

// 在 head 区域生成标签
add_theme_support('title-tag');

// 生成 RSS
add_theme_support('automatic-feed-links');

// 菜单
function facile_register_menus() {
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'facile'),
        'footer-menu'  => __('Footer Menu', 'facile'),
    ));
}
add_action('after_setup_theme', 'facile_register_menus');