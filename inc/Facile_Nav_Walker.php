<?php

class Facile_Nav_Walker extends Walker_Nav_Menu {
    protected $submenu_id;  // 二级菜单id

    // 二级菜单的HTML标签
    public function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul data-show=\"false\" id=\"{$this->submenu_id}\" class=\"dropdown-menu\">\n";
    }

    // 二级菜单的HTML结尾标签
    public function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        // 添加 class
        if ($depth === 0) {
            $classes[] = 'nav-item';
            if ($args->walker->has_children) {
                $classes[] = 'dropdown';
            }
        }
        
        // 当前菜单项高亮
        $active_class = in_array('current-menu-item', $classes) ? ' active' : '';
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . $active_class . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        $this->submenu_id = 'submenu-' . $item->ID;

        $output .= $indent . '<li' . $id . $class_names . '>';

        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        $show_submenu = '';
        
        // 添加二级菜单相关的属性
        if ($depth === 0) {
            $atts['class'] = 'nav-link';
            // 如果当前链接包含二级菜单
            if ($args->walker->has_children) {
                $atts['class'] .= ' dropdown-toggle';
                $atts['aria-expanded'] = 'false';
                $atts['aria-haspopup'] = 'true';
                $atts['aria-controls'] = $this->submenu_id;
                $show_submenu = '<button aria-label="' . __('Open Submenu', 'facile') . '" aria-expanded="false" aria-controls="' . $this->submenu_id . '" class="dropdown-toggle ml-1 show-submenu btn btn-sm btn-outline-secondary float-right d-block d-sm-block d-md-block d-lg-none d-xl-none" tabindex="0"></button>';
            }
        } else {
            $atts['class'] = 'dropdown-item';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            
        $item_output .= $show_submenu . '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    // 菜单项的结尾标签
    public function end_el(&$output, $item, $depth = 0, $args = array()) {
        $output .= "</li>\n";
    }
}