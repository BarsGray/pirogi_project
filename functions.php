<?php
// include 'archive-product.php';
add_action('after_setup_theme', 'crb_load');
function crb_load()
{
  require_once('includes/carbon-fields/vendor/autoload.php');
  \Carbon_Fields\Carbon_Fields::boot();
}

add_action('carbon_fields_register_fields', 'ohpirogi_register_custom_fields');
function ohpirogi_register_custom_fields()
{
  require get_template_directory() . '/includes/castom-fields-options/theme-options.php';
  require get_template_directory() . '/includes/castom-fields-options/metabox.php';
}

require get_template_directory() . '/includes/theme-settings.php';
require get_template_directory() . '/includes/widget-areas.php';
require get_template_directory() . '/includes/enqueue_script_style.php';
require get_template_directory() . '/includes/custom-header.php';
require get_template_directory() . '/includes/template-tags.php';
require get_template_directory() . '/includes/template-functions.php';
require get_template_directory() . '/includes/customizer.php';
require get_template_directory() . '/includes/my-walker-nav-classes.php';
require get_template_directory() . '/includes/ajax.php';
require get_template_directory() . '/templates/rend_swiper.php';
require get_template_directory() . '/templates/top_ten_product.php';

if (defined('JETPACK__VERSION')) {
  require get_template_directory() . '/includes/jetpack.php';
}

if (class_exists('WooCommerce')) {
  require get_template_directory() . '/includes/woocommerce.php';
  require get_template_directory() . '/woocommerce/includes/wc-functions-remove.php';
  require get_template_directory() . '/woocommerce/includes/wc-functions.php';
  require get_template_directory() . '/woocommerce/includes/wc-functions-archive.php';
  require get_template_directory() . '/woocommerce/includes/wc_functions_cart.php';
}

function them_register_nav_menu()
{
  register_nav_menu('top', 'Меню в шапке');
  register_nav_menu('submenu_top', 'Верхнее подменю в шапке');
  register_nav_menu('submenu_bottom1', 'Нижнее подменю блок 1');
  register_nav_menu('submenu_bottom2', 'Нижнее подменю блок 2');
  register_nav_menu('footer_menu', 'Меню в подвале');
  register_nav_menu('footer_nav', 'Навигация в подвале');
  register_nav_menu('mobile_menu', 'Мобильное меню');
}

add_action('after_setup_theme', 'them_register_nav_menu');

add_filter('upload_mimes', 'svg_upload_allow');
function svg_upload_allow($mimes)
{
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}

add_filter('wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5);
function fix_svg_mime_type($data, $file, $filename, $mimes, $real_mime = '')
{
  if (version_compare($GLOBALS['wp_version'], '5.1.0', '>=')) {
    $dosvg = in_array($real_mime, ['image/svg', 'image/svg+xml']);
  } else {
    $dosvg = ('.svg' === strtolower(substr($filename, -4)));
  }
  if ($dosvg) {
    if (current_user_can('manage_options')) {
      $data['ext'] = 'svg';
      $data['type'] = 'image/svg+xml';
    } else {
      $data['ext'] = false;
      $data['type'] = false;
    }
  }
  return $data;
}

// Add to cart 
add_filter('woocommerce_product_single_add_to_cart_text', 'tb_woo_custom_cart_button_text');
add_filter('woocommerce_product_add_to_cart_text', 'tb_woo_custom_cart_button_text');
function tb_woo_custom_cart_button_text()
{
  return __('В корзину', 'woocommerce');
  // return __('<span class="shopping_img"></span>', 'woocommerce');
}


$GLOBALS["category_id_min_pir"] = '';

add_filter('woocommerce_variable_price_html', 'truemisha_variation_price', 20, 2);


global $post;


// $post_object = get_queried_object();
// $GLOBALS["category_id_min_pir"] = (isset($post_object->term_taxonomy_id) ? $post_object->term_taxonomy_id : false);
function truemisha_variation_price($price, $product)
{
  $min_regular_price = $product->get_variation_regular_price('min', true);
  $min_sale_price = $product->get_variation_sale_price('min', true);
  $max_regular_price = $product->get_variation_regular_price('max', true);
  $max_sale_price = $product->get_variation_sale_price('max', true);

  if (!($min_regular_price == $max_regular_price && $min_sale_price == $max_sale_price)) {

    if ($min_sale_price < $min_regular_price && $GLOBALS["category_id_min_pir"] == 'mini-pirogi') {

      $price = sprintf('<del>%1$s</del><ins>%2$s</ins>', wc_price($min_regular_price), wc_price($min_sale_price));
    } else if ($max_sale_price < $max_regular_price && $GLOBALS["category_id_min_pir"] != 'mini-pirogi') {

      $price = sprintf('<del>%1$s</del><ins>%2$s</ins>', wc_price($max_regular_price), wc_price($max_sale_price));
    } else if ($GLOBALS["category_id_min_pir"] == 'mini-pirogi') {

      $price = sprintf('%1$s', wc_price($min_regular_price));
    } else {

      $price = sprintf('%1$s', wc_price($max_regular_price));
    }
  }
  return $price;
}


add_filter('woocommerce_get_myaccount_page_link', 'custom_myaccount_page_link');
function custom_myaccount_page_link($link)
{
  $redirect_url = add_query_arg('redirect', '1', wc_get_page_permalink('myaccount'));
  return $redirect_url;
}

add_filter('single_product_archive_thumbnail_size', 'true_catalog_size');
function true_catalog_size($size)
{
  return 'single';
}




if (function_exists('add_image_size')) {
  add_image_size('cart-thumb', '280');
}

add_filter('woocommerce_cart_item_thumbnail', 'change_image_size_in_cart', 10, 2);

function change_image_size_in_cart($product_image, $cart_item)
{

  if (is_cart()) {
    $product = $cart_item['data'];

    $product_image = $product->get_image('cart-thumb');
  }

  return $product_image;
}


// add_filter('woocommerce_cart_item_thumbnail', 'change_image_size_in_cart', 10, 2);

// function change_image_size_in_cart($product_image, $cart_item)
// {

//   if (is_cart()) {
//     $product = $cart_item['data'];

//     $product_image = $product->get_image('woocommerce_single');
//   }

//   return $product_image;
// }








remove_theme_support('wc-product-gallery-zoom');

add_action('after_setup_theme', 'remove_zoom_theme_support', 100);
function remove_zoom_theme_support()
{
  remove_theme_support('wc-product-gallery-zoom');
}

add_filter('woocommerce_form_field-args', function ($fields) {
  return $fields;
});



add_filter('loop_shop_per_page', 'truemisha_products_per_page', 20);
function truemisha_products_per_page($per_page)
{
  $per_page = -1;
  return $per_page;
}
remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);




add_filter('woocommerce_checkout_fields', 'remove_email_field_unregistered_users');
function remove_email_field_unregistered_users($fields)
{
  if (!is_user_logged_in()) {
    unset($fields['billing']['billing_email']); // Убираем поле email для незарегистрированных пользователей
  }
  return $fields;
}


$product_id = 123; // Замените 123 на ID вашего товара
$new_sales_count = 50; // Новое количество продаж

// // Обновляем значение метаполя total_sales для товара
// update_post_meta( 1745, 'total_sales', 7258 );
// update_post_meta( 1587, 'total_sales', 7088 );
// update_post_meta( 1774, 'total_sales', 5625 );
// update_post_meta( 1626, 'total_sales', 4453 );
// update_post_meta( 1783, 'total_sales', 3885 );
// update_post_meta( 1739, 'total_sales', 2492 );
// update_post_meta( 1682, 'total_sales', 2323 );
// update_post_meta( 1556, 'total_sales', 2217 );
// update_post_meta( 1574, 'total_sales', 2217 );
// update_post_meta( 1754, 'total_sales', 1951 );
// update_post_meta( 1688, 'total_sales', 1948 );
// update_post_meta( 1583, 'total_sales', 1735 );
// update_post_meta( 1760, 'total_sales', 1648 );
// update_post_meta( 1692, 'total_sales', 1500 );
// update_post_meta( 1571, 'total_sales', 1390 );
// update_post_meta( 1630, 'total_sales', 1344 );
// update_post_meta( 1647, 'total_sales', 1333 );
// update_post_meta( 1661, 'total_sales', 1135 );
// update_post_meta( 1777, 'total_sales', 1034 );
// update_post_meta( 1780, 'total_sales', 1034 );
// update_post_meta( 1733, 'total_sales', 798 );
// update_post_meta( 1733, 'total_sales', 798 );
// update_post_meta( 1705, 'total_sales', 707 );
// update_post_meta( 1711, 'total_sales', 499 );
// update_post_meta( 1695, 'total_sales', 431 );
// update_post_meta( 1591, 'total_sales', 306 );
// update_post_meta( 1773, 'total_sales', 186 );
// update_post_meta( 1639, 'total_sales', 95 );
// update_post_meta( 1640, 'total_sales', 28 );

// update_post_meta( 1640, 'total_sales', 28 );
// update_post_meta( 1725, 'total_sales', 13970 );
// update_post_meta( 1644, 'total_sales', 9445 );
// update_post_meta( 1717, 'total_sales', 6163 );
// update_post_meta( 1620, 'total_sales', 5868 );
// update_post_meta( 1764, 'total_sales', 5779 );
// update_post_meta( 1641, 'total_sales', 5618 );
// update_post_meta( 1702, 'total_sales', 4092 );
// update_post_meta( 1656, 'total_sales', 3894 );
// update_post_meta( 1729, 'total_sales', 3708 );
// update_post_meta( 1751, 'total_sales', 3601 );
// update_post_meta( 1611, 'total_sales', 3204 );
// update_post_meta( 1617, 'total_sales', 2515 );
// update_post_meta( 1580, 'total_sales', 2275 );
// update_post_meta( 1636, 'total_sales', 2273 );
// update_post_meta( 1677, 'total_sales', 2200 );
// update_post_meta( 1565, 'total_sales', 1674 );
// update_post_meta( 1559, 'total_sales', 1559 );
// update_post_meta( 1590, 'total_sales', 1354 );
// update_post_meta( 1568, 'total_sales', 1151 );
// update_post_meta( 1748, 'total_sales', 1135 );
// update_post_meta( 1653, 'total_sales', 958 );
// update_post_meta( 1699, 'total_sales', 891 );
// update_post_meta( 1714, 'total_sales', 846 );
// update_post_meta( 1736, 'total_sales', 767 );
// update_post_meta( 1685, 'total_sales', 706 );
// update_post_meta( 1608, 'total_sales', 533 );
// update_post_meta( 1732, 'total_sales', 487 );
// update_post_meta( 1552, 'total_sales', 441 );
// update_post_meta( 1681, 'total_sales', 345 );
// update_post_meta( 1665, 'total_sales', 328 );
// update_post_meta( 1680, 'total_sales', 300 );
// update_post_meta( 1555, 'total_sales', 255 );
// update_post_meta( 1549, 'total_sales', 234 );
// update_post_meta( 1696, 'total_sales', 14 );
// update_post_meta( 1691, 'total_sales', 14 );

// update_post_meta( 1598, 'total_sales', 251 );
// update_post_meta( 1601, 'total_sales', 248 );
// update_post_meta( 1603, 'total_sales', 180 );
// update_post_meta( 1602, 'total_sales', 153 );
// update_post_meta( 1604, 'total_sales', 123 );
// update_post_meta( 1600, 'total_sales', 43 );
// update_post_meta( 1599, 'total_sales', 40 );

// update_post_meta( 1586, 'total_sales', 1473 );
// update_post_meta( 1664, 'total_sales', 1290 );
// update_post_meta( 1728, 'total_sales', 733 );
// update_post_meta( 1786, 'total_sales', 655 );
// update_post_meta( 1594, 'total_sales', 632 );
// update_post_meta( 1629, 'total_sales', 391 );
// update_post_meta( 1660, 'total_sales', 126 );

// update_post_meta( 1668, 'total_sales', 3748 );
// update_post_meta( 1757, 'total_sales', 1956 );
// update_post_meta( 1742, 'total_sales', 1682 );
// update_post_meta( 1614, 'total_sales', 1674 );
// update_post_meta( 1671, 'total_sales', 1418 );
// update_post_meta( 1605, 'total_sales', 1156 );

// update_post_meta( 1623, 'total_sales', 1239 );
// update_post_meta( 1674, 'total_sales', 1183 );
// update_post_meta( 1767, 'total_sales', 879 );
// update_post_meta( 1562, 'total_sales', 781 );
// update_post_meta( 1595, 'total_sales', 685 );
// update_post_meta( 1577, 'total_sales', 594 );
// update_post_meta( 1650, 'total_sales', 552 );
// update_post_meta( 1763, 'total_sales', 250 );

// update_post_meta( 1723, 'total_sales', 2568 );
// update_post_meta( 1722, 'total_sales', 2073 );
// update_post_meta( 1724, 'total_sales', 1745 );
// update_post_meta( 1720, 'total_sales', 1451 );
// update_post_meta( 1721, 'total_sales', 818 );


add_action('woocommerce_after_single_product', 'add_short_slider');

function add_short_slider()
{
  echo do_shortcode(carbon_get_post_meta($GLOBALS['id_pro_carrent'], 'crb_product_short_slider'));
}


// function custom_ajax_add_to_cart() {
//     $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
//     $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
//     $variation_id = absint($_POST['variation_id']);
//     $variation = isset($_POST['variation']) ? (array) json_decode(stripslashes($_POST['variation'])) : array();

//     $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
//     $product_status = get_post_status($product_id);

//     if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation) && 'publish' === $product_status) {
//         do_action('woocommerce_ajax_added_to_cart', $product_id);

//         if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
//             wc_add_to_cart_message(array($product_id => $quantity), true);
//         }

//         WC_AJAX::get_refreshed_fragments();
//     } else {
//         $data = array(
//             'error' => true,
//             'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
//         );
//         echo wp_send_json($data);
//     }
//     wp_die();
// }

// add_action('wp_ajax_nopriv_custom_add_to_cart', 'custom_ajax_add_to_cart');
// add_action('wp_ajax_custom_add_to_cart', 'custom_ajax_add_to_cart');

function custom_ajax_add_to_cart()
{
  $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
  $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
  $variation_id = empty($_POST['variation_id']) ? '' : absint($_POST['variation_id']);
  $variation = empty($_POST['variation']) ? array() : $_POST['variation'];

  $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variation);
  $product_status = get_post_status($product_id);

  if ($passed_validation && 'publish' === $product_status) {
    $cart_item_data = array();
    if ($variation_id) {
      $cart_item_data['variation_id'] = $variation_id;
      $cart_item_data['variation'] = $variation;
    }

    if (WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation, $cart_item_data)) {
      do_action('woocommerce_ajax_added_to_cart', $product_id);

      if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
        wc_add_to_cart_message(array($product_id => $quantity), true);
      }

      WC_AJAX::get_refreshed_fragments();
    } else {
      $data = array(
        'error' => true,
        'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
      );
      echo wp_send_json($data);
    }
  } else {
    $data = array(
      'error' => true,
      'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
    );
    echo wp_send_json($data);
  }
  wp_die();
}

add_action('wp_ajax_nopriv_custom_add_to_cart', 'custom_ajax_add_to_cart');
add_action('wp_ajax_custom_add_to_cart', 'custom_ajax_add_to_cart');




// Функция для получения изображения в полном размере
// function get_full_size_image($size)
// {
//   return 'full';
// }

// // // Подключение функции к фильтрам для получения различных размеров изображений
// // add_filter('woocommerce_get_image_size_thumbnail', 'get_full_size_image');
// add_filter('woocommerce_get_image_size_shop_thumbnail', 'get_full_size_image');
// add_filter('woocommerce_get_image_size_shop_catalog', 'get_full_size_image');
// add_filter('woocommerce_get_image_size_shop_single', 'get_full_size_image');

// // Подключение функции к фильтру вывода миниатюр в корзине
// add_filter('woocommerce_cart_item_thumbnail', 'custom_woocommerce_cart_item_full_image', 10, 3);

// function custom_woocommerce_cart_item_full_image($thumbnail, $cart_item, $cart_item_key)
// {
//   $product = $cart_item['data'];
//   $image_size = 'full';
//   $thumbnail = $product->get_image($image_size);
//   return $thumbnail;
// }




// add_filter('woocommerce_get_image_size_single', 'true_single_image_size'); // woocommerce_single

// function true_single_image_size($size_options)
// {

//   return array(
//     'width' => 550,
//     'height' => 550,
//     'crop' => 0, // 1 – жёсткая обрезка, 0 – сохранение пропорций
//   );
// }

// add_filter('woocommerce_get_image_size_thumbnail','add_thumbnail_size',1,10);
// function add_thumbnail_size($size){

//     $size['width'] = 250;
//     $size['height'] = 300;
//     $size['crop']   = 0;
//     return $size;
// }\

add_action('admin_head', 'my_custom_styles');
function my_custom_styles()
{
  echo '<style>
.crb_slider_day_box .cf-complex__group-body {
  display: grid;
  grid-template-columns: 0.3fr 1fr;
}

.crb_slider_day_box_complex .cf-complex__group-body {
  display: flex;
}

.crb_slider_day_box_photo .cf-field__body,
.crb_slider_day_box_photo .cf-file__inner {
  width: 100%;
}

.crb_slider_day_box_ittle,
.crb_slider_day_box_date {
  grid-column: 1/2;
}

.crb_slider_day_box_complex {
  grid-column: 2/3;
  grid-row: 1/4;
}

  </style>';
}


