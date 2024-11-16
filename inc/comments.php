<?php

// 自定义评论回调函数
function custom_comments_callback($comment, $args, $depth) {
    // 获取评论日期格式设置
    $date_format_option = get_theme_mod('comment_date_format', 'format_iso');
    ?>
    <li <?php comment_class('comment-item'); ?> id="comment-<?php comment_ID(); ?>">
        <article class="comment-box">
            <div class="comment-author clearfix">
                <?php echo get_avatar($comment, 42); ?>
                <div class="comment-info float-left">
                    <?php printf('<b class="author">%s</b>', get_comment_author_link()); ?>
                    <?php if (get_the_author_meta('ID') == $comment->user_id): ?>
                        <span class="badge badge-dark"><?php _e('Author', 'facile'); ?></span>
                    <?php endif; ?>
                    <?php if ($comment->comment_approved == '0'): ?>
                        <span data-placement="top" data-toggle="tooltip" title="<?php _e('Only you can see this comment. It will be visible to others once approved.', 'facile'); ?>" class="badge badge-dark"><?php _e('Pending Review', 'facile'); ?></span>
                    <?php endif; ?>
                    <?php $parent_comment = $comment->comment_parent ? get_comment($comment->comment_parent) : null; ?>
                    <?php if ($parent_comment): ?>
                        <span class="mx-2"><?php _e('Reply', 'facile'); ?></span>
                        <b>
                            <a data-parent="<?php echo $parent_comment->comment_ID; ?>" class="parent" href="<?php echo get_comment_link($parent_comment); ?>">
                                <?php comment_author($parent_comment); ?>
                            </a>
                        </b>
                    <?php endif; ?>
                    <time class="comment-time" datetime="<?php echo get_comment_time('c'); ?>">
                        <?php echo format_comment_date($date_format_option, get_comment_time('U')); ?>
                    </time>
                </div>
                <span class="comment-reply float-right">
                    <?php
                    if ('1' == $comment->comment_approved) :
                        comment_reply_link(array_merge($args, array(
                            'depth' => $depth,
                            'max_depth' => $args['max_depth'],
                            'reply_text' => '<i class="icon-undo2 mr-1"></i><span>' . __('Reply', 'facile') . '</span>',
                        )));
                    endif;
                    ?>
                </span>
            </div>
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
        </article>
    </li>
    <?php
}

// 自定义评论表单
function custom_comment_form_fields($fields) {
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');

    // 姓名
    $fields['author'] = '<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' .
        '<label for="author" class="d-block">' .__('Name', 'facile') . ($req ? ' <span class="required">*</span>' : '') . '</label>' .
        '<input type="text" class="form-control" placeholder="' . __('Enter your name or nickname', 'facile') . '" name="author" id="author" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' required>' .
        '</div>';

    // 邮箱地址
    $fields['email'] = '<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' .
        '<label for="email" class="d-block">' . __('Email Address', 'facile') . ($req ? ' <span class="required">*</span>' : '') . '</label>' .
        '<input type="email" class="form-control" placeholder="' . __('Enter your email address (will not be published)', 'facile') .
        '" name="email" id="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' required>' .
        '</div>';

    // 网站URL
    $fields['url'] = '<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">' .
        '<label for="url" class="d-block">' . __('Website', 'facile') . '</label>' .
        '<input type="url" class="form-control" placeholder="' . __('Enter your website or blog URL', 'facile') . '" name="url" id="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30">' .
        '</div>';

    // 保存 cookie 的复选框
    $fields['cookies'] = '<div class="col-12">' .
        '<div class="custom-control custom-checkbox mb-0">' .
        '<input type="checkbox" class="custom-control-input" name="wp-comment-cookies-consent" id="wp-comment-cookies-consent" value="yes"' . (empty($commenter['comment_author_email']) ? '' : ' checked="checked"') . ' />' .
        '<label for="wp-comment-cookies-consent" class="custom-control-label">' . __('Save my name, email, and website for the next time I comment.', 'facile') . '</label>' .
        '</div>' .
        '</div>';

    return $fields;
}
add_filter('comment_form_default_fields', 'custom_comment_form_fields');

// 自定义评论表单
function custom_comment_form($args) {
    // 评论表单的标题
    $args['title_reply'] = '<h2>' . __('Leave a Comment', 'facile'); '</h2>';

    // 评论内容
    $args['comment_field'] = '<div class="col-12">' .
        '<label for="comment-content" class="d-block">' . __('Comment Content', 'facile') . '</label>' .
        '<textarea name="comment" id="comment-content" placeholder="' . __('Enter your comment here', 'facile') . '" class="form-control" required></textarea>' .
        '</div>';

    // 登录用户的链接
    $args['logged_in_as'] = '<div class="col-12" id="logged-in-as">' . $args['logged_in_as'] . '</div>';

    $args['title_reply_before'] = '<h2 id="reply-title" class="comment-reply-title">';
    $args['title_reply_after'] = '</h2>';

    // 提交按钮
    $args['submit_button'] = '<div class="col-12">' .
        '<button type="submit" class="btn btn-primary" id="submit-comment">' . __('Submit Comment', 'facile') . '</button>' .
        '</div>';

    // 隐藏一些提示信息
    $args['comment_notes_before'] = '';

    // 包装 HTML
    $args['fields'] = apply_filters('comment_form_default_fields', $args['fields']);
    $args['format'] = 'html5'; // 确保表单为 HTML5 格式
    $args['class_form'] = 'comment-form row'; // 添加 Bootstrap 样式的 class

    return $args;
}
add_filter('comment_form_defaults', 'custom_comment_form');

// 评论分页
function comment_pagination() {
    if (get_comment_pages_count() <= 1) {
        return;
    }

    echo '<nav class="page-nav my-5" aria-label="' . __('Pagination', 'facile') . '">';
    echo '<ul class="pagination justify-content-center">';

    // 上一页链接
    $prev_link = get_previous_comments_link('<i class="icon-chevron-left"></i>');
    if ($prev_link) {
        echo '<li class="page-item">';
        echo str_replace('<a', '<a data-toggle="tooltip" data-placement="top" title="' . __('Previous Page', 'facile') . '" aria-label="' . __('Previous Page', 'facile') . '" class="page-link"', $prev_link);
        echo '</li>';
    }

    // 获取当前页码和总页数
    $current_page = get_query_var('cpage') ? get_query_var('cpage') : 1;
    $total_pages = get_comment_pages_count();

    // 确定要显示的页码范围
    $range = 2; // 当前页码前后显示的页码数
    $showitems = ($range * 2) + 1;

    // 显示页码
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($total_pages != 1 && 
            ($i == 1 || $i == $total_pages || 
             abs($i - $current_page) <= $range)) {
            
            if ($i == $current_page) {
                echo '<li class="page-item active"><span class="page-link">' . $i . '<span class="sr-only">(current)</span></span></li>';
            } else {
                $link = get_comments_pagenum_link($i);
                echo '<li class="page-item"><a class="page-link" href="' . esc_url($link) . '">' . $i . '</a></li>';
            }
        } elseif ($i == $current_page - $range - 1 || $i == $current_page + $range + 1) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }

    // 下一页链接
    $next_link = get_next_comments_link('<i class="icon-chevron-right"></i>');
    if ($next_link) {
        echo '<li class="page-item">';
        echo str_replace('<a', '<a data-toggle="tooltip" data-placement="top" title="' . __('Next Page', 'facile') . '" aria-label="' . __('Next Page', 'facile') . '" class="page-link"', $next_link);
        echo '</li>';
    }

    echo '</ul>';
    echo '</nav>';
}