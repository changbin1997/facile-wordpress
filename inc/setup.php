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

add_theme_support('title-tag');

add_theme_support('automatic-feed-links');