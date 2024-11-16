<div id="comments">
    <?php if (comments_open()): ?>
        <?php if (post_password_required()): ?>
            <div class="comment-list">
                <h2><?php _e('You must enter the post password to view and submit comments.', 'facile'); ?></h2>
            </div>
        <?php else: ?>    
            <?php if (get_theme_mod('comment_form_position', 'below') == 'above'): ?>
                <div class="comment-input"><?php comment_form(); ?></div>
            <?php endif; ?>
            <?php if (have_comments()) : ?>
                <div class="comment-list">
                    <h2><?php printf(_n('%s Comment', 'There are %1$s comments', get_comments_number(), 'facile'), number_format_i18n(get_comments_number())); ?></h2>
                    <ul>
                        <?php
                        wp_list_comments(array('callback' => 'custom_comments_callback'));
                        ?>
                    </ul>
                    <?php comment_pagination(); ?>
                </div>
            <?php endif; ?>
            <?php if (get_theme_mod('comment_form_position', 'below') == 'below'): ?>
                <div class="comment-input"><?php comment_form(); ?></div>
            <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
        <div class="comment-list">
            <h2><?php _e('Comments are closed', 'facile'); ?></h2>
        </div>
    <?php endif; ?>
</div>