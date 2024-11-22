<?php
/**
 * @package WordPress
 * @subpackage Facile
 * @since Facile 1.0
*/
get_header();
?>

<div class="container main" id="main">
    <div class="row mt-4">
        <div class="col-xl-8 col-lg-8 post-list">
            <?php if (have_posts()): ?>
                <?php while (have_posts()): ?>
                    <?php the_post(); ?>
                    <?php get_template_part('content'); ?>
                <?php endwhile; ?>
            <?php else: ?>
                <p><?php _e('No posts found!', 'facile'); ?></p>
            <?php endif; ?>
            <?php post_list_pagination(); ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>