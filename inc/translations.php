<?php

// 加载翻译
function facile_load_theme_textdomain() {
    load_theme_textdomain('facile', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'facile_load_theme_textdomain');