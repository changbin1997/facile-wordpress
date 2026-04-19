<?php

/**
 * Facile 主题导航菜单 Walker 类
 *
 * 自定义导航菜单 Walker，用于生成符合 Bootstrap 4 框架的导航菜单 HTML 结构。
 * 支持下级菜单的展开和隐藏，以及响应式设备的适配。
 *
 * @package Facile
 * @subpackage Walkers
 * @since 1.0.0
 */
class Facile_Nav_Walker extends Walker_Nav_Menu {
    /**
     * 二级菜单 ID
     *
     * @var string
     */
    protected $submenu_id;

    /**
     * 启动菜单级别输出
     *
     * 生成下级菜单的开始 HTML 标签。根据菜单深度缩进，并为菜单容器添加
     * data-show 属性和唯一的 ID 标识符，方便 JavaScript 控制菜单展开隐藏。
     *
     * @param string $output 累积输出字符串，通过引用传递。
     * @param int    $depth  当前菜单深度，默认为 0。
     * @param array  $args   菜单参数数组，包含 Walker 实例等信息，默认为空数组。
     *
     * @return void
     */
    public function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul data-show=\"false\" id=\"{$this->submenu_id}\" class=\"dropdown-menu\">\n";
    }

    /**
     * 结束菜单级别输出
     *
     * 生成下级菜单的结束 HTML 标签。关闭上级菜单容器的 </ul> 标签。
     *
     * @param string $output 累积输出字符串，通过引用传递。
     * @param int    $depth  当前菜单深度，默认为 0。
     * @param array  $args   菜单参数数组，默认为空数组。
     *
     * @return void
     */
    public function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * 启动菜单单项输出
     *
     * 生成单个菜单项的 HTML 结构。处理菜单项的 CSS 类、链接属性、下级菜单切换按钮等。
     * 一级菜单添加 dropdown 相关类和切换按钮；二级菜单添加 dropdown-item 类。
     * 支持菜单高亮、ARIA 属性、关闭菜单按钮等功能。
     *
     * @param string      $output 累积输出字符串，通过引用传递。
     * @param object      $item   菜单项对象，包含 ID、标题、URL 等属性。
     * @param int         $depth  当前菜单项深度，默认为 0。
     * @param array       $args   菜单参数数组，包含 Walker 实例、before/after 标签等，默认为空数组。
     * @param int         $id     菜单项在菜单中的唯一 ID，默认为 0，当前未被使用。
     *
     * @return void
     */
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

    /**
     * 结束菜单单项输出
     *
     * 生成菜单项的结束 HTML 标签。关闭菜单项的 </li> 标签。
     *
     * @param string $output 累积输出字符串，通过引用传递。
     * @param object $item   菜单项对象，默认为 null（当前未使用）。
     * @param int    $depth  当前菜单项深度，默认为 0。
     * @param array  $args   菜单参数数组，默认为空数组。
     *
     * @return void
     */
    public function end_el(&$output, $item, $depth = 0, $args = array()) {
        $output .= "</li>\n";
    }
}