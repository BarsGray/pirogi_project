<?php

/**
 * Single variation cart button
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

global $prod_in_cart_arr;
global $product;

// Получение объекта корзины
$cart = WC()->cart;
// Получение товаров в корзине
$cart_items = $cart->get_cart();

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

$curr_prod = '';
$curr_prod = $product->get_id();
$curr_prod_vel = (array_key_exists($curr_prod, $prod_in_cart_arr)) ? $prod_in_cart_arr[$curr_prod] : '';
$in_basket = '';
$in_basket_text = 'Добавить в корзину';
$in_basket_img = 'shopping-cart.svg';


if ($curr_prod_vel != '') {
	$in_basket = 'in_basket';
	$in_basket_text = 'Товар в корзине';
	$in_basket_img = 'shopping-cart-black.png';
}

?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action('woocommerce_before_add_to_cart_button'); ?>

	<?php
	do_action('woocommerce_before_add_to_cart_quantity');

	woocommerce_quantity_input(
		array(
			'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
			'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
			'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		)
	);

	do_action('woocommerce_after_add_to_cart_quantity');
	?>

	<button type="submit" class="single_add_to_cart_button button alt add_basket <?php echo $in_basket; echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>">
		<img src="<?php bloginfo('template_url') ?>/assets/images/product/<?php echo $in_basket_img; ?>" alt="shopping-cart">
		<span class="add_to_cart_btn_text"><?php echo $in_basket_text; ?></span>
		<?php
		echo ($curr_prod_vel != '') ? '<span class="item_count_vip">' . $curr_prod_vel . '</span>' : '';
		?>
	</button>

	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>