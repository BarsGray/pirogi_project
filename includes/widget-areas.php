<?php
if (!defined('ABSPATH')) {
  exit;
}
add_action('widgets_init', 'ohpirogi_widgets_init');
function ohpirogi_widgets_init()
{
  register_sidebar(
    array(
      'name'          => esc_html__('Sidebar', 'ohpirogi'),
      'id'            => 'sidebar-1',
      'description'   => esc_html__('Add widgets here.', 'ohpirogi'),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );
}
