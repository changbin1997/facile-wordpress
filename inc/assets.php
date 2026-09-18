<?php

/**
 * 引入主题前端资源文件
 *
 * 注册并加载主题所需的样式表和脚本文件。包括主题基础样式、Bootstrap 框架、
 * 代码高亮库、剪贴板功能库以及主应用脚本。同时通过 wp_localize_script() 将
 * 多语言翻译内容传递给前端 JavaScript，以支持国际化字符串显示。
 *
 * 注册的资源包括：
 * - style: 主题 style.css 样式文件
 * - main-css: 主题编译后的 main.css 样式表
 * - jquery-js: 本地 jQuery 3.5.1 库
 * - bootstrap-js: Bootstrap 4 框架的 JavaScript 文件
 * - highlight-js: 代码高亮 highlight.pack.js 库
 * - clipboard-js: 剪贴板操作 clipboard.min.js 库
 * - app-js: 主题应用程序脚本文件
 *
 * @return void
 * @since 1.0.0
 */
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
    // 引入 app.js（以 ES Module 方式加载）
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
        'closeImage' => __('Close Image', 'facile'),
        'nextImage' => __('Next image (Right arrow key)'),
        'previousImage' => __('Previous image (Left arrow key)')
    );
    wp_localize_script('app-js', 'facileTranslations', $translation);

    // 主题路径
    wp_localize_script( 'app-js', 'themeConfig', array(
        'themeUri' => get_stylesheet_directory_uri()
    ));
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_assets' );

/**
 * 让 app.js 以 type="module" 的方式加载
 *
 * @param string $tag    渲染输出的 script 标签
 * @param string $handle 脚本句柄
 * @param string $src    脚本地址
 * @return string
 */
function facile_app_js_load_as_module( $tag, $handle, $src ) {
    if ( 'app-js' === $handle ) {
        $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'facile_app_js_load_as_module', 10, 3 );
