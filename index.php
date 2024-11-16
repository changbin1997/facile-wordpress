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
            <nav class="page-nav my-5" aria-label="<?php _e('Pagination', 'facile'); ?>">
                <!--bootstrap4分页-->
                <?php
                global $wp_query;
                $total_pages = $wp_query->max_num_pages;
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                if ($total_pages > 1):
                ?>
                <ul class="pagination justify-content-center">
                    <?php if ($paged > 1): ?>
                        <li class="page-item">
                            <a title="<?php _e('Previous Page (Left Arrow Key)', 'facile'); ?>" aria-label="<?php _e('Previous Page', 'facile'); ?>" data-toggle="tooltip" data-placement="top" class="page-link previous-page-link" href="<?php echo get_pagenum_link($paged - 1); ?>">
                                <i class="icon-chevron-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php if ($i == $paged) echo 'active'; ?>">
                            <a <?php if ($i == $paged) echo 'aria-current="page"'; ?> class="page-link" href="<?php echo get_pagenum_link($i); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($paged < $total_pages): ?>
                        <li class="page-item">
                            <a title="<?php _e('Next Page (Right Arrow Key)', 'facile'); ?>" aria-label="<?php _e('Next Page', 'facile'); ?>" data-toggle="tooltip" data-placement="top" class="page-link next-page-link" href="<?php echo get_pagenum_link($paged + 1); ?>">
                                <i class="icon-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php endif; ?>
            </nav>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>