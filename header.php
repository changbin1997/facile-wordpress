<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php
        if (is_home()) {
            echo get_bloginfo('name') . ' - ' . get_bloginfo('description');
        } else {
            echo get_the_title() . ' - ' . get_bloginfo('name');
        }
        ?>
    </title>
    <?php wp_head(); ?>
    <?php echo wp_kses_post(get_theme_mod('custom_head_html', '')); ?>
</head>
<body <?php body_class(); ?> data-codehighlight="<?php echo esc_attr(get_theme_mod('enable_code_highlight', true)); ?>">
<?php wp_body_open(); ?>
<header role="banner" class="sticky-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <?php if (get_theme_mod('navbar_logo', '') != ''): ?>
                <a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>" title="<?php bloginfo('name'); ?>">
                    <img height="<?php echo esc_attr(get_theme_mod('navbar_logo_height', '30')); ?>" src="<?php echo esc_url(get_theme_mod('navbar_logo', '')); ?>" alt="<?php bloginfo('name'); ?>">
                </a>
            <?php else: ?>
                <a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('name'); ?></a>
            <?php endif; ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php _e('Toggle navigation menu', 'facile'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php if (has_nav_menu('primary-menu')): ?>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary-menu',
                        'menu_class' => 'navbar-nav mr-auto',
                        'container' => false,
                        'depth' => 2,
                        'walker' => new Facile_Nav_Walker()
                    ));    
                    ?>
                <?php else: ?>    
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item <?php if (is_home()) echo 'active'; ?>">
                            <a <?php if (is_home()) echo 'aria-current="page"'; ?>  href="<?php echo esc_url(home_url()); ?>" class="nav-link"><?php _e('Home', 'facile'); ?></a>
                        </li>
                        <?php $pages = get_pages(array('sort_column' => 'menu_order',)); ?>
                        <?php foreach ($pages as $page): ?>
                            <li class="nav-item <?php if (is_page($page->ID)) echo 'active'; ?>">
                                <a <?php if (is_page($page->ID)) echo 'aria-current="page"'; ?> href="<?php echo get_page_link($page->ID); ?>" class="nav-link"><?php echo $page->post_title; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <!--搜索-->
                <form role="search" class="form-inline my-2 my-lg-0" action="<?php echo esc_url(home_url('/')); ?>" method="get" >
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="<?php _e('Search', 'facile'); ?>" name="s" value="<?php echo get_search_query(); ?>" required>
                        <div class="input-group-append">
                            <button class="btn btn-primary my-sm-0" type="submit" data-toggle="tooltip" data-placement="bottom" title="<?php _e('Search', 'facile'); ?>" aria-label="<?php _e('Search', 'facile'); ?>">
                                <i class="icon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </nav>
</header>