<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

?>
<div class="woocommerce-products-header header_prod">
	<div class="header_prod_titel_wrapper">
		<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
			<h1 class="woocommerce-products-header__title page-title product_title"><?php echo woocommerce_page_title(); ?></h1>
			<?php
			global $post;

			// $post_object = get_queried_object();
			// $GLOBALS["category_id_min_pir"] = (isset($post_object->term_taxonomy_id) ? $post_object->term_taxonomy_id : false);

			// global $post;
			// $post_slug = 'ok';
			// $post_slug = $post->post_name;




			
			// // Получение объекта корзины
			// $cart = WC()->cart;
			// // Получение товаров в корзине
			// $cart_items = $cart->get_cart();

			// $prod_in_cart_arr = [];

			// // Перебор товаров в корзине
			// foreach ($cart_items as $cart_item_key => $cart_item) {
			// 	// Получение ID товара
			// 	$product_id = $cart_item['product_id'];

			// 	// Получение количества товара
			// 	$quantity = $cart_item['quantity'];

			// 	if (array_key_exists($product_id, $prod_in_cart_arr)) {
			// 		$prod_in_cart_arr[$product_id] += $quantity;
			// 	} else {
			// 		$prod_in_cart_arr += [$product_id => $quantity];
			// 	}

			// 	// Делайте что-то с полученными данными, например, выводите их
			// 	// echo 'ID товара: ' . $product_id . ', Количество: ' . $quantity . '<br>';
			// }
			// echo '<pre>';
			// print_r($prod_in_cart_arr);
			// echo '</pre>';






			// // Получаем объект корзины WooCommerce
			// $woocommerce = WC();

			// // Получаем ID товара, для которого нужно получить количество
			// $product_id = 1546;

			// // Получаем количество товара в корзине
			// $quantity = $woocommerce->cart->get_cart_item_quantities();
			// 					// echo '<pre>';
			// 					// print_r($woocommerce->cart);
			// 					// echo '</pre>';
			// // Проверяем, есть ли указанный товар в корзине
			// if (array_key_exists($product_id, $quantity)) {
			//     // Выводим количество товара в корзине
			//     echo 'Количество товара с ID ' . $product_id . ' в корзине: ' . $quantity[$product_id];
			// } else {
			//     // Если товара нет в корзине, выводим сообщение об отсутствии
			//     echo 'Товар с ID ' . $product_id . ' отсутствует в корзине';
			// }

			// // ================================================================================================
			// // Получаем объект корзины WooCommerce
			// $woocommerce = WC();

			// // Получаем объект корзины
			// $cart = $woocommerce->cart;

			// // Получаем массив элементов корзины
			// $cart_items = $cart->get_cart();

			// // Создаем массив для хранения ID товаров
			// $product_ids = array();

			// // Проходимся по каждому элементу корзины
			// foreach ($cart_items as $cart_item_key => $cart_item) {
			//     // Получаем ID товара из элемента корзины
			//     $product_id = $cart_item['product_id'];
			//     // Добавляем ID товара в массив
			//     $product_ids[] = $product_id;
			// }

			// // Выводим список ID товаров в корзине
			// echo 'ID товаров в корзине: ' . implode(', ', $product_ids);


			// // ================================================================================================



			// 			function woo_in_cart($product_id)
			// 			{
			// 				global $woocommerce;
			// 				foreach ($woocommerce->cart->get_cart() as $key => $val) {
			// 					// echo '<pre>';
			// 					// print_r($val['data']);
			// 					// echo '</pre>';
			// 					$_product = $val['data'];
			// 					echo $product_id;

			// 					if ($product_id == $_product->id) {
			// 						$quantity = $woocommerce->cart->get_cart_item_quantities();
			// 						return true;
			// 					}
			// 				}
			// 				return false;
			// 			}
			?>
		<?php endif; ?>
	</div>
	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action('woocommerce_archive_description');
	?>
</div>
<?php
if (woocommerce_product_loop()) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action('woocommerce_before_shop_loop');

	woocommerce_product_loop_start();

	if (wc_get_loop_prop('total')) {
		while (have_posts()) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action('woocommerce_shop_loop');

			wc_get_template_part('content', 'product');
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action('woocommerce_after_shop_loop');
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action('woocommerce_no_products_found');
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');
