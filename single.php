<?php

/**
 * 单篇文章模板
 * 
 * @package WordPress
 * @subpackage Facile
 * @since Facile 1.0
 */
get_header();
?>

<div class="container main post-page" id="post-page">
    <div class="row my-4">
        <main class="col-xl-8 col-lg-8 post-page mb-5 mb-sm-5 mb-md-5 mb-lg-0 mb-xl-0">
            <?php if (get_theme_mod('enable_breadcrumbs', false)): ?>
                <nav aria-label="<?php _e('Breadcrumbs', 'facile'); ?>" class="breadcrumb-nav bg">
                    <?php custom_breadcrumbs(); ?>
                </nav>
            <?php endif; ?>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article <?php post_class(); ?>>
                        <header>
                            <h1 class="post-title m-0">
                                <a rel="bookmark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h1>
                        </header>
                        <?php if (get_theme_mod('show_thumbnail_in_single', true)): ?>
                            <?php
                            $imgUrl = null;  // 存储文章头图
                            // 根据设置获取文章头图
                            if (has_post_thumbnail()) {
                                $imgUrl = esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full'));
                            } elseif (get_theme_mod('use_first_image_as_thumbnail', true)) {
                                $imgUrl = get_first_image_url(get_the_content());
                            }
                            ?>
                            <?php if ($imgUrl != null): ?>
                                <div class="featured-image mb-3 mt-4">
                                    <a href="<?php the_permalink(); ?>" class="rounded" style="background-image: url(<?php echo $imgUrl; ?>);" aria-hidden="true" aria-label="featured image" tabindex="-1"></a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="post-info mt-2">
                            <span class="ml-1">
                                <i class="icon-calendar mr-2" aria-hidden="true"></i>
                                <a title="<?php _e('Publication Date', 'facile'); ?>" data-toggle="tooltip" data-placement="top" href="<?php echo esc_url(get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d'))); ?>">
                                    <?php posted_on(); ?>
                                </a>
                            </span>
                            <span class="ml-2">
                                <i class="icon-user mr-2" aria-hidden="true"></i>
                                <a title="<?php _e('Author', 'facile'); ?>" data-toggle="tooltip" data-placement="top" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                    <?php the_author(); ?>
                                </a>
                            </span>
                            <?php if (get_theme_mod('enable_post_view_count', false)): ?>
                                <span class="ml-2" title="<?php _e('Views', 'facile'); ?>" data-toggle="tooltip" data-placement="top">
                                    <i class="icon-eye mr-2"></i>
                                    <?php echo display_post_views(); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="post-content mt-4">
                            <?php the_content(); ?>
                        </div>
                        <?php
                        wp_link_pages(array(
                            'before' => '<nav class="post-content-pagination my-4 clearfix" aria-label="' . __('Pagination', 'facile') . '">',
                            'after' => '</nav>',
                            'next_or_number' => 'number',
                            'separator' => '',
                            'pagelink' => '%',
                            'echo' => 1,
                            'current' => max(1, get_query_var('page')),
                        ));
                        ?>
                        <div class="category-and-tag clearfix my-4">
                            <div class="post-category float-left" role="group" aria-label="<?php _e('Post Categories', 'facile'); ?>">
                                <i class="icon-folder-open mr-1" aria-hidden="true"></i>
                                <?php $categories = get_the_category(); ?>
                                <?php if (count($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php printf(__('Click to view posts in the %s category', 'facile'), esc_html($category->name)); ?>" href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                            <?php echo esc_html($category->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span><?php _e('No categories selected', 'facile'); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="post-tag float-right" role="group" aria-label="<?php _e('Tags', 'facile'); ?>">
                                <i class="icon-price-tag mr-1" aria-hidden="true"></i>
                                <?php $tags = get_the_tags(); ?>
                                <?php if ($tags != false): ?>
                                    <?php foreach ($tags as $tag): ?>
                                        <a class="badge badge-dark" data-toggle="tooltip" data-placement="top" title="<?php printf(__('Click to view posts with the %s tag', 'facile'), esc_html($tag->name)); ?>" href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                                            <?php echo esc_html($tag->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span><?php _e('No tags added', 'facile'); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                    <!--上一篇和下一篇文章的导航区域-->
                    <div class="post-navigation border-top border-bottom py-4">
                        <nav class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 previous">
                                <div id="previous-post-text"><?php _e('Previous Post', 'facile'); ?></div>
                                <div class="text-truncate">
                                    <?php $previous_post = get_previous_post(); ?>
                                    <?php if (!empty($previous_post)): ?>
                                        <a href="<?php echo get_permalink($previous_post->ID); ?>" rel="prev" aria-describedby="previous-post-text">
                                            <?php echo esc_html($previous_post->post_title); ?>
                                        </a>
                                    <?php else: ?>
                                        <span><?php _e('None', 'facile'); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 next">
                                <div id="next-post-text" class="text-lg-right text-xl-right text-md-right"><?php _e('Next Post', 'facile'); ?></div>
                                <div class="text-lg-right text-xl-right text-md-right next-box text-truncate">
                                    <?php $next_post = get_next_post(); ?>
                                    <?php if (!empty($next_post)): ?>
                                        <a href="<?php echo get_permalink($next_post->ID); ?>" rel="next" aria-describedby="next-post-text">
                                            <?php echo esc_html($next_post->post_title); ?>
                                        </a>
                                    <?php else: ?>
                                        <span><?php _e('None', 'facile'); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <?php comments_template(); ?>
            <?php endwhile;
            endif; ?>
        </main>
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>