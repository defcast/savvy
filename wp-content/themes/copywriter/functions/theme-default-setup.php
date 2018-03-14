<?php
/*
 * Main Sidebar
 */
function copywriter_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Main Sidebar', 'copywriter'),
        'id' => 'main-sidebar',
        'description' => esc_html__('Main sidebar that appears on the right.', 'copywriter'),
        'before_widget' => '<aside class="side-area-post">',
        'after_widget' => '</aside>',
        'before_title' => '<div class="side-area-heading"><h4><b>',
        'after_title' => '</b></h4></div>',
    ));
}
add_action('widgets_init', 'copywriter_widgets_init');