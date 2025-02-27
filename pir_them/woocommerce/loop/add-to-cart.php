<?php

/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if (!defined('ABSPATH')) {
	exit;
}

global $prod_in_cart_arr;
global $wp;

// Получаем URL текущей страницы
$current_url = home_url($wp->request);


global $product;


// Получение объекта корзины
$cart = WC()->cart;
// Получение товаров в корзине

if (isset($cart)) $cart_items = $cart->get_cart();
// $cart_items = $cart->get_cart();

$prod_in_cart_arr = [];

// Перебор товаров в корзине
foreach ($cart_items as $cart_item_key => $cart_item) {
	// Получение ID товара
	$product_id = $cart_item['product_id'];

	// Получение количества товара
	$quantity = $cart_item['quantity'];

	if (array_key_exists($product_id, $prod_in_cart_arr)) {
		$prod_in_cart_arr[$product_id] += $quantity;
	} else {
		$prod_in_cart_arr += [$product_id => $quantity];
	}

	// Делайте что-то с полученными данными, например, выводите их
	// echo 'ID товара: ' . $product_id . ', Количество: ' . $quantity . '<br>';
}
// echo '<pre>';
// print_r($prod_in_cart_arr);
// echo '</pre>';



// // Проверяем, является ли товар вариативным
// if ($product->is_type('variable')) {
// 	// Получаем все вариации товара
// 	$variations = $product->get_available_variations();

// 	// Проверяем, есть ли вариации и больше ли их одной
// 	if (!empty($variations) && count($variations) > 1) {
// 		// Получаем вторую вариацию
// 		$second_variation = $variations[1];

// 		// Получаем URL второй вариации
// 		$variation_url = get_permalink($second_variation['variation_id']);
// 	}
// }



$variation_id = '';
$variation_data_id = '';

// Проверяем, является ли товар вариативным
if ($product->is_type('variable')) {
	// Получаем все вариации товара
	$variations = $product->get_available_variations();

	// Проверяем, есть ли вариации
	if (!empty($variations) && count($variations) > 1) {
		// Получаем первую вариацию
		$first_variation = reset($variations);
		$second_variation = $variations[1];
		// if ($current_url == 'https://ohpirogi24.ru/catalog/mini-pirogi') {
		if (strpos($current_url, '/mini-pirogi')) {
			$variation_id = $current_url . '/?add-to-cart=' . $second_variation['variation_id'];
			$variation_data_id = 'data-product_id="' . $second_variation['variation_id'] . '"';
		} else {
			$variation_id = $current_url . '/?add-to-cart=' . $first_variation['variation_id'];
			$variation_data_id = 'data-product_id="' . $first_variation['variation_id'] . '"';
		}
	}
} else {
	$variation_id = isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '';
	$variation_data_id = isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '';
}
// 'data-product_id="' . $first_variation['variation_id'] . '"',



$curr_prod = '';
$curr_prod = $product->get_id();
$curr_prod_vel = (array_key_exists($curr_prod, $prod_in_cart_arr)) ? $prod_in_cart_arr[$curr_prod] : '';



echo apply_filters(
	'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
	sprintf(
		// '<a href="%s" data-quantity="%s" class="product_btn %s" %s><span class="shopping_img">%s</span></a>',
		'<a href="%s" data-quantity="%s" class="%s" %s><span class="shopping_img"></span>%s</a>',
		esc_url($variation_id),
		esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
		esc_attr('prod_btn button product_type_simple add_to_cart_button ajax_add_to_cart'),
		$variation_data_id,
		(($curr_prod_vel != '') ? '<span class="item_count_vip">' . $curr_prod_vel . '</span>' : '')
		// esc_html($product->add_to_cart_text())
	),
	$product,
	$args
);


// echo apply_filters(
// 	'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
// 	sprintf(
// 		'<a href="%s" data-quantity="%s" class="product_btn %s" %s>%s</a>',
// 		esc_url( $product->add_to_cart_url() ),
// 		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
// 		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
// 		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
// 		esc_html( $product->add_to_cart_text() )
// 	),
// 	$product,
// 	$args
// );
