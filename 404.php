<?php
/**
 * @package WordPress
 * @subpackage Facile
 * @since Facile 1.0
 */

get_header();
?>

<div class="container main page-404" id="page-404">
    <div class="mt-5" role="alert" aria-labelledby="page-title" aria-describedby="page-info">
        <h1 class="text-404 text-center" id="page-title">404</h1>
        <h3 class="text-center" id="page-info"><?php _e('The page you are looking for does not exist!', 'facile'); ?></h3>
    </div>
    <div class="mt-5 row">
        <div class="col-xl-6 offset-xl-3 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">
            <form action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="<?php _e('Search', 'facile'); ?>" required name="s">
                    <div class="input-group-append">
                        <button class="btn btn-primary my-sm-0" type="submit" aria-label="<?php _e('Search', 'facile'); ?>" title="<?php _e('Search', 'facile'); ?>" data-toggle="tooltip" data-placement="bottom">
                            <i class="icon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center mt-3">
        <a href="<?php echo esc_url(home_url()); ?>" class="btn btn-outline-primary" id="back-home-page"><?php _e('Go back to homepage', 'facile'); ?></a>
    </div>
</div>

<?php get_footer(); ?>