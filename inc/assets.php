<?php

// 引入文件
function theme_enqueue_assets() {
    // 引入 style.css 文件
    wp_enqueue_style('style', get_stylesheet_uri());

    // 引入主题样式 scss 生成的 main.css
    wp_enqueue_style('main-css', get_template_directory_uri() . '/css/main.css');

    // 引入本地的 jQuery 文件
    wp_enqueue_script('jquery-js', get_template_directory_uri() . '/js/jquery-3.5.1.min.js', null, false, true);

    // 引入本地的 Bootstrap JS 文件
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', null, false, true);

    // 引入代码高亮的 highlight.pack.js
    wp_enqueue_script('highlight-js', get_template_directory_uri() . '/js/highlight.pack.js', null, false, true);

    // 引入用于拷贝代码的 clipboard.min.js
    wp_enqueue_script('clipboard-js', get_template_directory_uri() . '/js/clipboard.min.js', null, false, true);

    // 引入 app.js
    wp_enqueue_script('app-js', get_template_directory_uri() . '/js/app.js', null, false, true);

    // 一些通过 JS 显示的翻译内容
    $translation = array(
        // 拷贝代码
        'copyCodeBtn' => __('Copy Code', 'facile'),
        'copySuccess' => __('Copy Success', 'facile'),
        'copyError' => __('Copy Error', 'facile'),
        // 图片灯箱
        'zoomIn' => __('Zoom In', 'facile'),
        'zoomOut' => __('Zoom Out', 'facile'),
        'rotateLeft' => __('Rotate Left 90 Degrees', 'facile'),
        'rotateRight' => __('Rotate Right 90 Degrees', 'facile'),
        'closeImage' => __('Close Image', 'facile')
    );
    wp_localize_script('app-js', 'facileTranslations', $translation);
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_assets' );