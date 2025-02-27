<?php
if (!defined('ABSPATH')) {
  exit;
}
add_action('wp_enqueue_scripts', 'ohpirogi_style');
function ohpirogi_style()
{
  wp_enqueue_style('ohpirogi-style', get_stylesheet_uri(), array(), _S_VERSION);
  wp_style_add_data('ohpirogi-style', 'rtl', 'replace');
  wp_enqueue_style('swiper-bundle', '//cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css', array('ohpirogi-style'), null, 'all');
  wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/main.css', array('ohpirogi-style'), null, 'all');
  wp_enqueue_style('fonts', get_template_directory_uri() . '/assets/fonts/stylesheet.css', array('ohpirogi-style'), null, 'all');
}

add_action('wp_enqueue_scripts', 'ohpirogi_scripts');
function ohpirogi_scripts()
{
  // wp_deregister_script('jquery');
  // wp_register_script('jquery', get_template_directory_uri() . '/assets/libs/jquery-3.6.0.min.js', array(), null, true);
  // wp_enqueue_script('jquery');

  wp_enqueue_script('swiper', '//cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js' , array('jquery'), null, true);
  // wp_enqueue_script('maskedinput', '//cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js' , array('jquery'), null, true);
  wp_enqueue_script('maskedinput', '//unpkg.com/imask' , array('jquery'), null, true);
  wp_enqueue_script('ohpirogi-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), _S_VERSION, true);
  wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), null, true);
  // wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/js/slick.min.js', array('jquery'), null, true);
  wp_enqueue_script('scripts-navi', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), null, true);
  wp_enqueue_script('ajax-search', get_template_directory_uri() . '/assets/js/ajax-search.js', array('jquery', 'scripts'), null, true);
  wp_localize_script('ajax-search', 'search_form', array(
    'url' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('search-nonce')
  ));

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
