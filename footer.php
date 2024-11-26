<footer>
    <div class="container py-3">
        <?php if (has_nav_menu('footer-menu')): ?>
            <nav class="text-center mb-1">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer-menu',
                    'menu_class' => 'footer-menu',
                    'depth' => 1
                ));
                ?>
            </nav>
        <?php endif; ?>

        <?php
        $cn_icp = get_option('cn_icp');  // 获取ICP备案号
        $cn_ga = get_option('cn_ga');  // 获取公安备案号
        ?>
        <?php if (!empty($cn_icp) or !empty($cn_ga)): ?>
            <nav class="text-center mb-1">
                <?php if (!empty($cn_icp)): ?>
                    <span class="mx-1"><?php echo $cn_icp; ?></span>
                <?php endif;?>
                <?php if (!empty($cn_ga)): ?>
                    <span class="mx-1"><?php echo $cn_ga; ?></span>
                <?php endif;?>
            </nav>
        <?php endif;?>
        
        <nav class="text-center" aria-label="Copyright">
            <a class="mx-1" href="https://github.com/changbin1997/facile-wordpress" target="_blank">Facile</a>
            by
            <a class="ml-1" href="https://www.misterma.com/" target="_blank">Mr. Ma</a>
        </nav>
    </div>
</footer>

<button class="btn text-primary rounded-circle d-none" id="to-top-btn" type="button" aria-label="<?php _e('Scroll to Top', 'facile'); ?>" title="<?php _e('Scroll to Top', 'facile'); ?>">
    <i class="icon-arrow-up"></i>
</button>

<?php wp_footer(); ?>
<?php echo wp_kses_post(get_theme_mod('custom_footer_html', '')); ?>

</body>
</html>