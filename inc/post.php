<?php

/**
 * 记录单篇文章的浏览次数
 *
 * 当用户访问单篇文章时，通过 Cookie 判断是否已记录过浏览，
 * 未记录过则增加文章的浏览量计数。
 *
 * @param int $post_id 文章 ID
 * @return void
 */
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

/**
 * 钩子回调函数：记录文章浏览量
 *
 * 挂载到 'wp' 钩子，在 WordPress 加载完毕后调用，
 * 用于统计单篇文章的浏览次数。
 *
 * @return void
 */
add_action('wp', 'track_post_views');
function track_post_views() {
    if (is_single()) {
        global $post;
        record_post_views($post->ID);
    }
}

/**
 * 获取文章的浏览次数
 *
 * 从文章元数据中获取存储的浏览量，如果未设置则返回 0。
 *
 * @param int $post_id 文章 ID
 * @return int 文章的浏览次数
 */
function get_post_views($post_id) {
    $views = (int) get_post_meta($post_id, 'post_views', true);
    return $views ? $views : 0;
}

/**
 * 输出文章浏览次数
 *
 * 获取当前全局文章对象的浏览次数，并过滤输出以增强安全性。
 *
 * @return string 文章的浏览次数字符串
 */
function display_post_views() {
    global $post;
    $views = get_post_views($post->ID);
    return esc_html($views);
}

/**
 * 钩子回调函数：删除文章时清除浏览次数数据
 *
 * 挂载到 'before_delete_post' 钩子，当删除文章类型的内容时，
 * 同时删除对应的浏览量元数据。
 *
 * @param int $post_id 文章 ID
 * @return void
 */
function delete_post_views($post_id) {
    if ('post' == get_post_type($post_id)) {
        delete_post_meta($post_id, 'post_views');
    }
}
add_action('before_delete_post', 'delete_post_views');

/**
 * 自定义受密码保护文章的输入表单
 *
 * 替换 WordPress 默认的密码表单，使用 Bootstrap 样式类和
 * 更好的用户体验设计。
 *
 * @param string $output 原始的密码输入表单 HTML
 * @return string 自定义的密码输入表单 HTML
 */
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

/**
 * 输出文章列表分页导航
 *
 * 根据文章总页数和当前页码生成分页导航，包含选项提示和键盘快捷键说明，
 * 使用 Bootstrap 分页样式。
 *
 * @return void
 */
function post_list_pagination() {
    global $wp_query;
    $total_pages = $wp_query->max_num_pages;
    $current_page = max(1, get_query_var('paged'));

    if ($total_pages <= 1) {
        return;
    }

    echo '<nav class="page-nav my-5 post-list-pagination" aria-label="' . __('Pagination', 'facile') . '">';
    echo '<ul class="pagination justify-content-center">';

    // 上一页
    if ($current_page > 1) {
        echo '<li class="page-item prev">';
        echo '<a aria-label="' . __('Previous Page', 'facile') . '" data-toggle="tooltip" data-placement="top" title="' . __('Previous Page (Left Arrow Key)', 'facile') . '" class="page-link previous-page-link" href="' . get_pagenum_link($current_page - 1) . '" aria-label="Previous">';
        echo '<i class="icon-chevron-left"></i>';
        echo '</a></li>';
    }

    // 第一页
    echo '<li' . ($current_page == 1 ? ' class="active page-item"' : '') . '>';
    echo '<a class="page-link" href="' . get_pagenum_link(1) . '">1</a></li>';

    // 计算需要显示的页码范围
    $start = max(2, $current_page - 1);
    $end = min($total_pages - 1, $current_page + 1);

    // 省略部分链接
    if ($start > 2) {
        echo '<li class="page-item"><a class="page-link">...</a></li>';
    }

    // 中间页码
    for ($i = $start; $i <= $end; $i++) {
        echo '<li' . ($current_page == $i ? ' class="active page-item"' : ' class="page-item"') . '>';
        echo '<a class="page-link" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
    }

    // 省略部分链接
    if ($end < $total_pages - 1) {
        echo '<li class="page-item"><a class="page-link">...</a></li>';
    }

    // 最后一页
    if ($total_pages > 1) {
        echo '<li' . ($current_page == $total_pages ? ' class="active page-item"' : ' class="page-item"') . '>';
        echo '<a class="page-link" href="' . get_pagenum_link($total_pages) . '">' . $total_pages . '</a></li>';
    }

    // 下一页
    if ($current_page < $total_pages) {
        echo '<li class="page-item next">';
        echo '<a aria-label="' . __('Next Page', 'facile') . '" data-toggle="tooltip" data-placement="top" title="' . __('Next Page (Right Arrow Key)', 'facile') . '" class="page-link next-page-link" href="' . get_pagenum_link($current_page + 1) . '" aria-label="Next">';
        echo '<i class="icon-chevron-right"></i>';
        echo '</a></li>';
    }

    echo '</ul>';
    echo '</nav>';
}

/**
 * 为文章中的表格添加 Bootstrap 4 样式
 *
 * @param string $html 原始文章 HTML
 * @return string 处理后的 HTML
 */
function addBootstrapTableClasses($html) {
    // 没有表格直接返回原内容
    if (empty($html) || strpos($html, '<table') === false) {
        return $html;
    }

    // 创建 DOMDocument 并加载 HTML
    $dom = new DOMDocument();
    // 抑制因不标准 HTML 产生的警告
    libxml_use_internal_errors(true);
    // 添加 XML 声明确保 UTF-8 编码正确解析
    $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
    libxml_clear_errors();

    // 获取所有表格元素
    $tables = $dom->getElementsByTagName('table');
    foreach ($tables as $table) {
        // 合并现有的 class 属性
        $oldClass = $table->getAttribute('class');
        $classes = array_filter(explode(' ', $oldClass));
        $classes = array_merge($classes, ['table', 'table-striped', 'table-bordered', 'table-hover']);
        $classes = array_unique($classes);
        $table->setAttribute('class', implode(' ', $classes));

        // 创建外层响应式容器 div
        $div = $dom->createElement('div');
        $div->setAttribute('class', 'table-responsive');

        // 将表格替换为 div，并将表格移入 div
        $table->parentNode->replaceChild($div, $table);
        $div->appendChild($table);
    }

    // 提取 body 内的所有内容（去除自动添加的 doctype/html/body 标签）
    $body = $dom->getElementsByTagName('body')->item(0);
    $newHtml = '';
    foreach ($body->childNodes as $child) {
        $newHtml .= $dom->saveHTML($child);
    }

    return $newHtml;
}
add_filter('the_content', 'addBootstrapTableClasses');