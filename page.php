<?php

/**
 * 独立页
 *
 * @package WordPress
 * @subpackage Facile
 * @since Facile 1.0
 */
get_header();
?>

<div class="container main page-page" id="page-page">
    <div class="row my-4">
        <main class="col-xl-8 col-lg-8 post-page mb-5 mb-sm-5 mb-md-5 mb-lg-0 mb-xl-0">
            <?php if (get_theme_mod('enable_breadcrumbs', false)): ?>
                <nav aria-label="<?php _e('Breadcrumbs', 'facile'); ?>" class="breadcrumb-nav bg">
                    <?php custom_breadcrumbs(); ?>
                </nav>
            <?php endif; ?>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="mb-4 border-bottom">
                    <header>
                        <h1 class="post-title m-0">
                            <a rel="bookmark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h1>
                    </header>
                    <div class="post-info mt-2">
                        <span class="ml-1" title="<?php _e('Publication Date', 'facile'); ?>" data-toggle="tooltip" data-placement="top">
                            <i class="icon-calendar mr-2" aria-hidden="true"></i>
                            <?php posted_on(); ?>
                        </span>
                        <span class="ml-2">
                            <i class="icon-user mr-2" aria-hidden="true"></i>
                            <a title="<?php _e('Author', 'facile'); ?>" data-toggle="tooltip" data-placement="top" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                <?php the_author(); ?>
                            </a>
                        </span>
                    </div>
                    <div class="post-content mt-4">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php comments_template(); ?>
            <?php endwhile; endif; ?>
        </main>
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>