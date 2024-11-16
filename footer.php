<footer>
    <div class="container py-3">
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
        <nav class="text-center">
            Powered by
            <a class="mx-1" href="https://wordpress.org/" target="_blank">WordPress</a>
            Theme by
            <a class="ml-1" href="https://www.misterma.com/" target="_blank">Facile</a>
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