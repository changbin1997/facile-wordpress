<?php

// 在文章页面记录浏览量的函数
function record_post_views($post_id) {
    if (!is_single() || empty($post_id)) {
        return;
    }

    $cookie_name = 'post_views_' . $post_id;

    if (!isset($_COOKIE[$cookie_name])) {
        $views = (int) get_post_meta($post_id, 'post_views', true);
        $views++;
        update_post_meta($post_id, 'post_views', $views);
        setcookie($cookie_name, '1', time() + 3600, COOKIEPATH, COOKIE_DOMAIN);
    }
}

// 在单篇文章页面调用记录浏览量的函数
add_action('wp', 'track_post_views');
function track_post_views() {
    if (is_single()) {
        global $post;
        record_post_views($post->ID);
    }
}

// 获取文章浏览量的函数
function get_post_views($post_id) {
    $views = (int) get_post_meta($post_id, 'post_views', true);
    return $views ? $views : 0;
}

// 在 content.php 中显示浏览量
function display_post_views() {
    global $post;
    $views = get_post_views($post->ID);
    return esc_html($views);
}

// 删除文章后同时删除阅读量
function delete_post_views($post_id) {
    if ('post' == get_post_type($post_id)) {
        delete_post_meta($post_id, 'post_views');
    }
}
add_action('before_delete_post', 'delete_post_views');

// 调整文章密码输入表单
function custom_password_form($output) {
    global $post;
    
    // 定义表单的自定义结构
    $custom_form = '<form class="custom-password-form" method="post" action="' . esc_url($_SERVER['REQUEST_URI']) . '">
        <p id="password-message">' . __('This post is password protected. Enter the password to view it.', 'facile') . '</p>    
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <label for="password">' . __('Password:', 'facile') . '</label>
                <input placeholder="' . __('Enter your password', 'facile') . '" aria-describedby="password-message" autofocus required class="password-input form-control" type="password" name="post_password" id="password" class="password" />
                <button class="btn btn-primary" type="submit">' . __('Submit', 'facile') . '</button>
            </div>
        </div>
    </form>';

    // 返回自定义的表单内容
    return $custom_form;
}
add_filter('the_password_form', 'custom_password_form');