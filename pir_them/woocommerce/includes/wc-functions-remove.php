<?php
if (!defined('ABSPATH')) {
  exit;
}

add_filter('woocommerce_enqueue_styles', '__return_empty_array');
// remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
// remove_all_filters('woocommerce_after_single_product_summary'); 
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
// remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
// remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
// remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

// Удалить описание товара из карточки товара
// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
// Удалить описание товара из карточки товара на странице магазина

remove_action('woocommerce_before_cart', 'woocommerce_output_all_notices', 10);
