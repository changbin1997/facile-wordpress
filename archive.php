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
            <?php if (get_theme_mod('enable_breadcrumbs', false)): ?>
                <nav aria-label="<?php _e('Breadcrumbs', 'facile'); ?>" class="breadcrumb-nav bg">
                    <?php custom_breadcrumbs(); ?>
                </nav>
            <?php endif; ?>
            <header class="archive-title mb-5">
                <h1>
                    <?php
                    $locale = get_locale(); // 获取当前 WordPress 语言环境

                    if (is_category()) {
                        echo sprintf(__('Posts under the category %s', 'facile'), single_cat_title('', false));
                    } elseif (is_tag()) {
                        echo sprintf(__('Posts tagged %s', 'facile'), single_tag_title('', false));
                    } elseif (is_author()) {
                        echo sprintf(__('Posts by author %s', 'facile'), get_the_author());
                    } elseif (is_year()) {
                        if ($locale === 'zh_CN') {
                            $date_format = 'Y年';
                        } elseif (strpos($locale, 'en_') === 0) {
                            $date_format = 'Y';
                        } else {
                            $date_format = 'Y';
                        }
                        echo sprintf(__('Posts from %s', 'facile'), get_the_date($date_format));
                    } elseif (is_month()) {
                        if ($locale === 'zh_CN') {
                            $date_format = 'Y年n月';
                        } elseif (strpos($locale, 'en_') === 0) {
                            $date_format = 'F Y';
                        } else {
                            $date_format = 'Y-m';
                        }
                        echo sprintf(__('Posts from %s', 'facile'), get_the_date($date_format));
                    } elseif (is_day()) {
                        if ($locale === 'zh_CN') {
                            $date_format = 'Y年n月j日';
                        } elseif (strpos($locale, 'en_') === 0) {
                            $date_format = 'j M Y';
                        } else {
                            $date_format = 'Y-m-d';
                        }
                        echo sprintf(__('Posts from %s', 'facile'), get_the_date($date_format));
                    } else {
                        _e('Archives', 'facile');
                    }
                    ?>
                </h1>
                <span class="archive-description"><?php echo term_description(); ?></span>
            </header>
            <!--是否有文章-->
            <?php if (have_posts()): ?>
                <?php while (have_posts()): ?>
                    <?php the_post(); ?>
                    <?php get_template_part('content'); ?>
                <?php endwhile; ?>
            <?php else: ?>
                <article class="no-content">
                    <hr>
                    <h4 class="mb-3" role="alert"><?php _e('No posts found!', 'facile'); ?></h4 >
                </article>
            <?php endif; ?>
            <?php post_list_pagination(); ?>  
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>