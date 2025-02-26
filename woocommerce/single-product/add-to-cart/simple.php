<?php

/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
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


if (!$product->is_purchasable()) {
	return;
}

$max_regular_price = $product->get_regular_price('max', true);
$max_sale_price = $product->get_sale_price('max', true);

if ($max_regular_price != '' && $max_sale_price != '') {
?>
	<div class="simple_price_dont_sale">
		<div class="simple_price_dont_sale_text">Цена без акции: <?php echo '<span>' . $max_regular_price . ' ' . get_woocommerce_currency_symbol() . '</span>'; ?></div>
	</div>
<?php
}

echo wc_get_stock_html($product); // WPCS: XSS ok.

if ($product->is_in_stock()) : ?>

	<?php do_action('woocommerce_before_add_to_cart_form'); ?>


	<form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>

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
		<a href="?add-to-cart=<?php echo esc_attr($product->id); ?>" data-quantity="1" class="add_basket button add_to_cart_button ajax_add_to_cart <?php echo $in_basket; ?>" data-product_id="<?php echo esc_attr($product->id); ?>" aria-label="<?php echo esc_attr($product->add_to_cart_description()); ?>" rel="nofollow">
			<img src="<?php bloginfo('template_url') ?>/assets/images/product/<?php echo $in_basket_img; ?>" alt="shopping-cart">
			<span class="add_to_cart_btn_text"><?php echo $in_basket_text; ?></span>
			<?php
			echo ($curr_prod_vel != '') ? '<span class="item_count_vip">' . $curr_prod_vel . '</span>' : '';
			?>
		</a>

		<?php do_action('woocommerce_after_add_to_cart_button'); ?>
	</form>

	<?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>