<?php

require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/comments.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/widgets/index.php';
require_once get_template_directory() . '/inc/post.php';
require_once get_template_directory() . '/inc/Facile_Nav_Walker.php';

function welcome_content() {
    $screen = get_current_screen();
    if (isset($screen->id) && $screen->id == 'themes'):
    ?>
    <div class="notice notice-success is-dismissible">
        <h1><?php _e('Welcome to Facile', 'facile'); ?></h1>
        <p>
            <a href="#" target="_blank" style="margin-right: 8px;"><?php _e('View Documentation', 'facile'); ?></a>
            <a href="#" target="_blank" style="margin-right: 8px;"><?php _e('Visit Github', 'facile'); ?></a>
            <a href="https://www.misterma.com/" target="_blank" style="margin-right: 8px;"><?php _e('Visit the Developer\'s Blog', 'facile'); ?></a>
        </p>
        <p>
            <?php _e('If you encounter any issues, feel free to leave a message on my blog or report them on GitHub Issues.', 'facile'); ?>
        </p>
    </div>
    <?php
    endif;
}
add_action('admin_notices', 'welcome_content');