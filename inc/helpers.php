<?php

// 评论日期时间格式化
function format_comment_date($option, $timestamp) {
    switch ($option) {
        case 'format_standard':
            return date_i18n('Y年m月d日 H:i', $timestamp);

        case 'format_iso':
            return date('Y-m-d H:i', $timestamp);

        case 'format_english':
            return date_i18n('F jS, Y \a\t h:i a', $timestamp);

        case 'format_time_ago':
            $current_time = current_time('timestamp');
            $diff = $current_time - $timestamp;

            if ($diff < 60) {
                return sprintf(_n('%s second ago', '%s seconds ago', $diff, 'facile'), $diff);
            } elseif ($diff < 3600) {
                $minutes = round($diff / 60);
                return sprintf(_n('%s minute ago', '%s minutes ago', $minutes, 'facile'), $minutes);
            } elseif ($diff < 86400) {
                $hours = round($diff / 3600);
                return sprintf(_n('%s hour ago', '%s hours ago', $hours, 'facile'), $hours);
            } else {
                $days = round($diff / 86400);
                return sprintf(_n('%s day ago', '%s days ago', $days, 'facile'), $days);
            }

        default:
            return date_i18n('Y-m-d H:i', $timestamp);
    }
}

// 获取文章内的第一张图片
function get_first_image_url($content) {
    // 创建一个 DOMDocument 对象
    $doc = new DOMDocument();

    // 禁用错误报告，因为 HTML 可能不是完全有效的
    libxml_use_internal_errors(true);

    // 加载 HTML
    $doc->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

    // 恢复错误报告
    libxml_clear_errors();

    // 创建一个 DOMXPath 对象
    $xpath = new DOMXPath($doc);

    // 查找所有不在 code 标签内的 img 标签
    $imgs = $xpath->query('//img[not(ancestor::code)]');

    // 如果找到了图片
    if ($imgs->length > 0) {
        // 返回第一张图片的 src 属性
        return $imgs->item(0)->getAttribute('src');
    }

    // 如果没有找到图片，返回 null
    return null;
}

// 面包屑导航
function custom_breadcrumbs() {
    // 不在首页时才显示面包屑
    if (!is_front_page()) {
        echo '<ol class="breadcrumb m-0 pl-0 pr-0 pt-0 border-0">';

        // 首页链接
        echo '<li class="breadcrumb-item"><a href="' . home_url() . '">' . __('Home', 'facile') . '</a></li>';

        if (is_archive()) {
            if (is_category()) {
                $category = get_queried_object();
                if ($category->parent != 0) {
                    $parents = get_ancestors($category->term_id, 'category');
                    foreach (array_reverse($parents) as $parent) {
                        echo '<li class="breadcrumb-item"><a href="' . get_category_link($parent) . '">' . get_cat_name($parent) . '</a></li>';
                    }
                }
                echo '<li class="breadcrumb-item">' . single_cat_title('', false) . '</li>';
            } elseif (is_tag()) {
                echo '<li class="breadcrumb-item">' . __('Tag: ', 'facile') . single_tag_title('', false) . '</li>';
            } elseif (is_author()) {
                echo '<li class="breadcrumb-item">' . __('Author: ', 'facile') . get_the_author() . '</li>';
            } elseif (is_day()) {
                echo '<li class="breadcrumb-item">' . get_the_date() . '</li>';
            } elseif (is_month()) {
                echo '<li class="breadcrumb-item">' . get_the_date('Y年n月') . '</li>';
            } elseif (is_year()) {
                echo '<li class="breadcrumb-item">' . get_the_date('Y年') . '</li>';
            } else {
                echo '<li class="breadcrumb-item">' . __('Archive', 'facile') . '</li>';
            }
        } elseif (is_search()) {
            echo '<li class="breadcrumb-item">' . __('Search Results: ', 'facile') . get_search_query() . '</li>';
        } elseif (is_page()) {
            $ancestors = get_post_ancestors(get_the_ID());
            if ($ancestors) {
                $ancestors = array_reverse($ancestors);
                foreach ($ancestors as $ancestor) {
                    echo '<li class="breadcrumb-item"><a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                }
            }
            echo '<li class="breadcrumb-item">' . get_the_title() . '</li>';
        } elseif (is_single()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                echo '<li class="breadcrumb-item"><a href="' . get_post_type_archive_link(get_post_type()) . '">' . $post_type->labels->name . '</a></li>';
            } else {
                $category = get_the_category();
                if ($category) {
                    $parents = get_ancestors($category[0]->term_id, 'category');
                    foreach (array_reverse($parents) as $parent) {
                        echo '<li class="breadcrumb-item"><a href="' . get_category_link($parent) . '">' . get_cat_name($parent) . '</a></li>';
                    }
                    echo '<li class="breadcrumb-item"><a href="' . get_category_link($category[0]->term_id) . '">' . $category[0]->name . '</a></li>';
                }
            }
            echo '<li class="breadcrumb-item">' . get_the_title() . '</li>';
        }

        echo '</ol>';
    }
}

// 根据语言显示文章日期格式
function posted_on() {
    $locale = get_locale();

    if (strpos($locale, 'zh') === 0) {
        // 中文日期格式
        $date_format = 'Y年n月j日';
    } elseif (strpos($locale, 'en') === 0) {
        // 英文日期格式
        $date_format = 'j M Y';
    } else {
        // 其他语言使用国际通用格式
        $date_format = 'Y-m-d';
    }

    echo '<time datetime="' . esc_attr(get_the_date(DATE_W3C)) . '">' . esc_html(get_the_date($date_format)) . '</time>';
}