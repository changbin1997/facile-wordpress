<?php
/**
 * @package WordPress
 * @subpackage Facile
 * @since Facile 1.0
 */
?>
<div class="mb-5 pb-3">
    <article <?php post_class(); ?>>
        <?php
        $imgUrl = null;  // 存储文章头图
        // 根据设置获取文章头图
        if (get_theme_mod('show_thumbnail_in_list', true)) {
            if (has_post_thumbnail()) {
                $imgUrl = esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full'));
            }elseif (get_theme_mod('use_first_image_as_thumbnail', true)) {
                $imgUrl = get_first_image_url(get_the_content());
            }
        }
        ?>
        <?php if (get_theme_mod('header_image_style', 'large') == 'large' && $imgUrl != null): ?>
            <div class="featured-image mb-4">
                <a href="<?php the_permalink(); ?>" class="rounded" style="background-image: url(<?php echo $imgUrl; ?>)" aria-hidden="true" aria-label="featured image" tabindex="-1"></a>
            </div>
        <?php endif; ?>
        <header>
            <h2 class="post-title">
                <a rel="bookmark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <!--文章信息区域-->
            <div class="post-info mt-2">
                <span class="ml-1">
                    <i class="icon-calendar mr-2" aria-hidden="true"></i>
                    <a data-toggle="tooltip" data-placement="top" title="<?php _e('Publication Date', 'facile'); ?>" href="<?php echo esc_url(get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d'))); ?>">
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
        </header>
        <?php if (get_theme_mod('header_image_style', 'large') == 'small' && $imgUrl != null && get_theme_mod('post_list_options', 'excerpt') == 'excerpt'): ?>
            <!--小头图模式-->
            <div class="post-content mt-4 row header-image-small">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-8 col-7 content-box">
                    <div class="summary-box">
                        <p class="text-color">
                            <?php
                            if (has_excerpt()) {
                                the_excerpt();
                            }else {
                                echo wp_trim_words(get_the_content(), get_theme_mod('post_excerpt_count', '120'));
                            }
                            ?>
                        </p>
                    </div>
                    <div class="more-link-wrapper">
                        <div>
                            <a class="btn btn-sm mr-3 read-more" href="<?php the_permalink(); ?>">
                                <?php _e('Read More', 'facile'); ?>
                                <i class="icon-arrow-right2"></i>
                            </a>
                            <a href="<?php the_permalink(); ?>#comments" class="comment-count d-none d-sm-inline d-sm-inline d-lg-inline d-xl-inline">
                                <i class="icon-bubble mr-1"></i>
                                <b><?php printf(_n('%s Comment', '%s Comments', get_comments_number(), 'facile'), get_comments_number()); ?></b>
                            </a>
                        </div>
                        <?php if (is_user_logged_in()): ?>
                            <div class="d-none d-sm-block d-md-block d-lg-block d-xl-block">
                                <a href="<?php echo get_edit_post_link(); ?>" class="float-right edit-link">
                                    <i class="icon-pencil mr-1"></i>
                                    <b><?php _e('Edit', 'facile'); ?></b>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-5 mini-header-image pl-0">
                    <a href="<?php the_permalink(); ?>" class="rounded" style="background-image: url('<?php echo $imgUrl; ?>" aria-hidden="true" aria-label="featured image" tabindex="-1"></a>
                </div>
            </div>
        <?php else: ?>
            <!--大头图模式-->
            <div class="post-content mt-4 header-image-large">
                <?php if (get_theme_mod('post_list_options', 'excerpt') == 'full'): ?>
                    <!--文章全文输出-->
                    <div class="full"><?php the_content(); ?></div>
                <?php else: ?>
                    <!--文章摘要-->
                    <p class="text-color">
                        <?php
                        if (has_excerpt()) {
                            the_excerpt();
                        }else {
                            echo wp_trim_words(get_the_content(), get_theme_mod('post_excerpt_count', '120'));
                        }
                        ?>
                    </p>
                <?php endif; ?>
                <div class="more-link-wrapper">
                    <div>
                        <a class="btn btn-sm mr-3 read-more" href="<?php the_permalink(); ?>">
                            <?php _e('Read More', 'facile'); ?>
                            <i class="icon-arrow-right2"></i>
                        </a>
                        <a href="<?php the_permalink(); ?>#comments" class="comment-count">
                            <i class="icon-bubble mr-1"></i>
                            <b><?php printf(_n('%s Comment', '%s Comments', get_comments_number(), 'facile'), get_comments_number()); ?></b>
                        </a>
                    </div>
                    <?php if (is_user_logged_in()): ?>
                        <div class="d-none d-sm-block d-md-block d-lg-block d-xl-block">
                            <a href="<?php echo get_edit_post_link(); ?>" class="float-right edit-link">
                                <i class="icon-pencil mr-1"></i>
                                <b><?php _e('Edit', 'facile'); ?></b>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </article>
</div>