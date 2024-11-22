<?php

// 主题设置
function mytheme_customize_register($wp_customize) {
    // 外观相关的设置页
    $wp_customize->add_section('theme_color_scheme_section', array(
        'title' => __('Theme Color Scheme', 'facile')
    ));

    // 主题配色设置
    $wp_customize->add_setting('theme_color_scheme', array(
        'default'   => 'auto-color',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_key'
    ));
    // 默认的主题配色选择
    $wp_customize->add_control('theme_color_scheme_control', array(
        'label'    => __('Select Theme Color Scheme', 'facile'),
        'section'  => 'theme_color_scheme_section',
        'settings' => 'theme_color_scheme',
        'type'     => 'radio',
        'choices'  => array(
            'light-color' => __('Light Theme', 'facile'),
            'dark-color'  => __('Dark Theme', 'facile'),
            'auto-color'  => __('Follow System Theme', 'facile')
        ),
        'description' => __('The default color scheme of the theme when users visit the website. The "Follow System Theme" option will automatically switch between light and dark based on the user\'s system preferences. You can also add a color scheme toggle widget in the sidebar to allow users to manually select their preferred theme.', 'facile')
    ));


    // 导航栏设置页
    $wp_customize->add_section('navbar_options_section', array(
        'title'    => __('Navbar Settings', 'facile'),
        'description' => __('Settings related to the top navbar and breadcrumb navigation.', 'facile')
    ));

    // 面包屑导航开关
    $wp_customize->add_setting('enable_breadcrumbs', array(
        'default'   => false,
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_checkbox'
    ));
    // 面包屑导航开关的复选框
    $wp_customize->add_control('enable_breadcrumbs_control', array(
        'label'    => __('Enable Breadcrumb Navigation', 'facile'),
        'section'  => 'navbar_options_section',
        'settings' => 'enable_breadcrumbs',
        'type'     => 'checkbox',
        'description' => __('When enabled, breadcrumb navigation will appear below the navbar to help users understand the page hierarchy and their current location.', 'facile')
    ));

    // 网站Logo设置
    $wp_customize->add_setting('navbar_logo', array(
        'default'   => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_url'
    ));
    // 网站Logo选择按钮
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'navbar_logo_control', array(
        'label'    => __('Navbar Logo Image', 'facile'),
        'section'  => 'navbar_options_section',
        'settings' => 'navbar_logo',
        'description' => __('Upload or select an image to use as the logo in the navbar. By default, the site name will be used as the logo.', 'facile')
    )));

    // Logo高度限制
    $wp_customize->add_setting('navbar_logo_height', array(
        'default'   => '30',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_integer'
    ));
    // Logo高度限制的 input
    $wp_customize->add_control('navbar_logo_height_control', array(
        'label'       => __('Navbar Logo Height Limit', 'facile'),
        'section'     => 'navbar_options_section',
        'settings'    => 'navbar_logo_height',
        'type'        => 'number',
        'description' => __('Adjust the height of the logo in the navbar (in pixels) to avoid overly large or small logos. Enter the number directly without adding px.', 'facile')
    ));

    // 文章相关的设置页
    $wp_customize->add_section('post_options_section', array(
        'title'    => __('Post Settings', 'facile'),
        'description' => __('Settings related to the post list and post content.', 'facile')
    ));

    // 文章列表显示设置
    $wp_customize->add_setting('post_list_options', array(
        'default'   => 'excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_key'
    ));
    // 文章列表显示设置
    $wp_customize->add_control('post_list_options_control', array(
        'label'    => __('Post List Display', 'facile'),
        'section'  => 'post_options_section',
        'settings' => 'post_list_options',
        'type'     => 'radio',
        'choices'  => array(
            'full' => __('Display full post in list', 'facile'),
            'excerpt'  => __('Display post excerpt in list', 'facile')
        )
    ));

    // 文章摘要字数设置
    $wp_customize->add_setting('post_excerpt_count', array(
        'default'   => '120',
        'transport' => 'refresh',
        'sanitize_callback' => 'absint'
    ));
    // 文章摘要字数设置
    $wp_customize->add_control('post_excerpt_count_control', array(
        'label'    => __('Post Excerpt Length (Characters or Words)', 'facile'),
        'section'  => 'post_options_section',
        'settings' => 'post_excerpt_count',
        'type'     => 'number',
        'description' => __('Sets the number of characters or words for post excerpts in the list. If WordPress is in Chinese, it will count characters; if in English, it will count words. Manually set excerpts on the post edit page are not affected by this limit.', 'facile')
    ));

    // 文章列表文章头图开关
    $wp_customize->add_setting('show_thumbnail_in_list', array(
        'default'   => true,
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_checkbox'
    ));
    // 文章列表文章头图开关的复选框
    $wp_customize->add_control('show_thumbnail_in_list_control', array(
        'label'    => __('Show Featured Image in Post List', 'facile'),
        'section'  => 'post_options_section',
        'settings' => 'show_thumbnail_in_list',
        'type'     => 'checkbox',
        'description' => __('Global setting to show or hide featured images in the post list. If disabled, no featured images will be displayed in the list.', 'facile')
    ));
    // 文章页头图开关
    $wp_customize->add_setting('show_thumbnail_in_single', array(
        'default'   => true,
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_checkbox'
    ));
    // 文章页头图开关的复选框
    $wp_customize->add_control('show_thumbnail_in_single_control', array(
        'label'    => __('Show Featured Image on Single Post Page', 'facile'),
        'section'  => 'post_options_section',
        'settings' => 'show_thumbnail_in_single',
        'type'     => 'checkbox',
        'description' => __('Global setting to show or hide featured images on individual post pages. If disabled, no featured images will be shown on post pages.', 'facile')
    ));

    // 使用文章内的第一张图片作为文章头图
    $wp_customize->add_setting('use_first_image_as_thumbnail', array(
        'default'   => true,
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_checkbox'
    ));
    // 使用文章内的第一张图片作为文章头图的复选框
    $wp_customize->add_control('use_first_image_as_thumbnail_control', array(
        'label'    => __('Use First Image in Post as Featured Image', 'facile'),
        'section'  => 'post_options_section',
        'settings' => 'use_first_image_as_thumbnail',
        'type'     => 'checkbox',
        'description' => __('If no featured image is set, the first image in the post will be used as the default featured image. If no image is found, no featured image will be displayed.', 'facile')
    ));

    // 文章列表头图样式
    $wp_customize->add_setting('header_image_style', array(
        'default'   => 'large',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_key'
    ));
    // 文章列表头图样式的 radio
    $wp_customize->add_control('header_image_style_control', array(
        'label'    => __('Post List Featured Image Style', 'facile'),
        'section'  => 'post_options_section',
        'settings' => 'header_image_style',
        'type'     => 'radio',
        'choices'  => array(
            'large' => __('Large (Image above title and excerpt)', 'facile'),
            'small' => __('Small (Excerpt on the left, image on the right)', 'facile')
        ),
        'description' => __('Large images have a 18:9 aspect ratio, and small images have a 4:3 aspect ratio. Images that do not fit these ratios will be automatically cropped to match.', 'facile')
    ));

    // 代码高亮开关
    $wp_customize->add_setting('enable_code_highlight', array(
        'default'   => true,
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_checkbox'
    ));
    // 代码高亮开关的复选框
    $wp_customize->add_control('enable_code_highlight_control', array(
        'label'    => __('Enable Code Block Highlighting', 'facile'),
        'section'  => 'post_options_section',
        'settings' => 'enable_code_highlight',
        'type'     => 'checkbox',
        'description' => __('Supports syntax highlighting for over 30 languages, using the VS2015 theme. Disable this if you plan to use another plugin or do not need this feature.', 'facile')
    ));

    // 文章阅读量统计和显示开关
    $wp_customize->add_setting('enable_post_view_count', array(
        'default'   => false,
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_checkbox'
    ));
    // 文章阅读量复选框
    $wp_customize->add_control('enable_post_view_count_control', array(
        'label'    => __('Post View Count', 'facile'),
        'section'  => 'post_options_section',
        'settings' => 'enable_post_view_count',
        'type'     => 'checkbox',
        'description' => __('Enable this option to display the view count on both the post list and individual post pages. The view count will increase each time a user visits the post. A cookie will also be set in the user\'s browser, ensuring that repeated visits within a short period of time from the same user will count as a single view.', 'facile')
    ));

    // 评论相关的设置页
    $wp_customize->add_section('comment_options_section', array(
        'title'    => __('Comment Section Settings', 'facile'),
        'description' => __('Settings related to the comment list and comment form.', 'facile')
    ));
    // 评论日期格式显示
    $wp_customize->add_setting('comment_date_format', array(
        'default'   => 'format_iso',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_key'
    ));
    // 评论日期格式显示设置的 radio
    $wp_customize->add_control('comment_date_format_control', array(
        'label'    => __('Comment Date and Time Display Format', 'facile'),
        'section'  => 'comment_options_section',
        'settings' => 'comment_date_format',
        'type'     => 'radio',
        'choices'  => array(
            'format_standard' => __('2020年04月23日 13:09', 'facile'),
            'format_iso'     => __('2020-04-23 13:09', 'facile'),
            'format_english' => __('April 23rd, 2020 at 01:09 pm', 'facile'),
            'format_time_ago' => __('Time Ago (3 days ago)', 'facile')
        ),
        'description' => __('The "Time Ago" format will dynamically update based on the elapsed time: for under a minute, it will show seconds; for under an hour, it will show minutes; for under a day, it will show hours; and for over a day, it will show days.', 'facile')
    ));

    // 评论表单位置设置
    $wp_customize->add_setting('comment_form_position', array(
        'default'   => 'below',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_key'
    ));
    // 评论表单位置设置的 radio
    $wp_customize->add_control('comment_form_position_control', array(
        'label'    => __('Comment Form Position', 'facile'),
        'section'  => 'comment_options_section',
        'settings' => 'comment_form_position',
        'type'     => 'radio',
        'choices'  => array(
            'above' => __('Comment form above the comment list', 'facile'),
            'below' => __('Comment form below the comment list', 'facile'),
        ),
        'description' => __('Choose the position of the comment form: the comment form is where users submit new comments, while the comment list displays published comments.', 'facile'),
    ));

    // 开发者设置页
    $wp_customize->add_section('developer_options_section', array(
        'title'    => __('Developer Settings', 'facile'),
        'description' => __('Custom code output settings.', 'facile'),
    ));

    // 添加自定义 head 区域输出的 HTML 设置
    $wp_customize->add_setting('custom_head_html', array(
        'default'   => '',
        'transport' => 'postMessage', // 实时预览关闭，需刷新页面
        'sanitize_callback' => 'wp_kses_post' // 仅允许安全的 HTML 标签
    ));
    // 自定义 head 区域 HTML 的输入框
    $wp_customize->add_control('custom_head_html_control', array(
        'label'    => __('Custom HTML Output for the Head Section', 'facile'),
        'section'  => 'developer_options_section',
        'settings' => 'custom_head_html',
        'type'     => 'textarea',
        'description' => __('HTML in the head section will be output inside the head tag. This can be used for analytics JS or custom JS code.', 'facile'),
    ));

    // 添加自定义 body 底部输出的 HTML 设置
    $wp_customize->add_setting('custom_footer_html', array(
        'default'   => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'wp_kses_post'
    ));
    // 自定义 body 底部 HTML 的输入框
    $wp_customize->add_control('custom_footer_html_control', array(
        'label'    => __('Custom HTML Output for the Footer Section', 'facile'),
        'section'  => 'developer_options_section',
        'settings' => 'custom_footer_html',
        'type'     => 'textarea',
        'description' => __('HTML at the bottom of the body will be output after the footer and before the closing body tag. This can be used for analytics JS or custom JS code.', 'facile'),
    ));
}
add_action('customize_register', 'mytheme_customize_register');

// 在 body class 输出主题配色的 class
function theme_body_classes($classes) {
    // facile-theme-color cookie 是否存在
    if (isset($_COOKIE['facile-theme-color'])) {
        // 使用 cookie 中的值作为主题配色
        $color = $_COOKIE['facile-theme-color'];
        if ($color != 'light-color' && $color != 'dark-color') $color = 'light-color';
        $classes[] = $color;
    }else {
        // 获取默认的主题配色
        $color = get_theme_mod('theme_color_scheme', 'auto-color');
        // 是否是 IE
        if (preg_match('/MSIE|Trident/', $_SERVER['HTTP_USER_AGENT']) && $color == 'auto-color') {
            $color = 'light-color';
        }
        $classes[] = $color;
    }
    return $classes;
}
add_filter('body_class', 'theme_body_classes');

// 检查复选框设置
function sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}