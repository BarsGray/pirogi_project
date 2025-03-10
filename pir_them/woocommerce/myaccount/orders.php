<?php

/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.5.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_orders', $has_orders); ?>

<?php if ($has_orders) : ?>

	<!-- <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table"> -->
	<!-- <thead>
			<tr>
				<?php foreach (wc_get_account_orders_columns() as $column_id => $column_name) : ?>
					
					<?php
					if ($column_id == 'order-status') {
						continue;
					}
					?>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr($column_id); ?>"><span class="nobr"><?php echo esc_html($column_name); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead> -->
	<!-- <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
			<tbody> -->
	<?php
	foreach ($customer_orders->orders as $customer_order) {
	?>
		<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
			<tbody>
				<?php
				$order      = wc_get_order($customer_order); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				$item_count = $order->get_item_count() - $order->get_item_count_refunded();

				// echo '<pre>';
				// var_dump($has_orders);
				// var_dump($order);
				// echo $order->get_order_number() . '<br>';

				// echo '</pre>';

				// break;

				?>
				<tr class="your_order_number_row">
					<th>Ваш заказ:</th>
					<td></td>
					<td></td>
					<td><?php echo esc_html(_x('#', 'hash before order number', 'woocommerce') . $order->get_order_number()); ?></td>
				</tr>
				<tr class="your_order_date">
					<td>Доставка / Самовывоз:</td>
					<td></td>
					<td></td>
					<td><?php echo esc_html(wc_format_datetime($order->get_date_created(), 'd F G:i')); ?></td>
				</tr>
				<tr class="your_order_title_columns">
					<th>Фото</th>
					<th>Наименование</th>
					<th>Кол-во</th>
					<th>Сумма</th>
				</tr>
				<?php
				foreach ($order->get_items() as $item) {
					$product_name_full = $item->get_name();
					$product_id = $item->get_product_id();
					// $product_variation_id = $item->get_variation_id();
					// echo $product_variation_id . '<br>';

					// var_dump($item->get_quantity());
				?>
					<tr class="your_order_item_row">
						<td><img width="200" src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail')[0]; ?>" alt=""></td>
						<td>
							<?php
							if (strpos($product_name_full, "-")) {
								echo substr($product_name_full, 0, strpos($product_name_full, "-"));
							} else {
								echo $product_name_full;
							}
							?>
						</td>
						<td><?php echo $item->get_quantity(); ?></td>
						<td><?php echo wc_price($item->get_total()); ?></td>
					</tr>
				<?php
				}
				?>
				<!-- <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr($order->get_status()); ?> order">
					<?php foreach (wc_get_account_orders_columns() as $column_id => $column_name) : ?>
						<?php
						if ($column_id == 'order-status') {
							continue;
						}
						?>
						<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr($column_id); ?>" data-title="<?php echo esc_attr($column_name); ?>">
							<?php if (has_action('woocommerce_my_account_my_orders_column_' . $column_id)) : ?>
								<?php do_action('woocommerce_my_account_my_orders_column_' . $column_id, $order); ?>

							<?php elseif ('order-number' === $column_id) : ?>
								<a href="<?php echo esc_url($order->get_view_order_url()); ?>">
									<?php echo esc_html(_x('#', 'hash before order number', 'woocommerce') . $order->get_order_number()); ?>
								</a>

							<?php elseif ('order-date' === $column_id) : ?>
								<time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></time>

								<?php // elseif ( 'order-status' === $column_id ) : 
								?>
								<?php // echo esc_html( wc_get_order_status_name( $order->get_status() ) ); 
								?>

							<?php elseif ('order-total' === $column_id) : ?>
								<?php
								/* translators: 1: formatted order total 2: total order items */
								echo wp_kses_post(sprintf(_n('%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce'), $order->get_formatted_order_total(), $item_count));
								?>

							<?php elseif ('order-actions' === $column_id) : ?>
								<?php
								// $actions = wc_get_account_orders_actions($order);

								// if (!empty($actions)) {
								// 	foreach ($actions as $key => $action) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
								// 		if ($key == 'view') continue;
								// 		echo '<a href="' . esc_url($action['url']) . '" class="woocommerce-button' . esc_attr($wp_button_class) . ' button ' . sanitize_html_class($key) . '">' . esc_html($action['name']) . '</a>';
								// 	}
								// }
								?>
							<?php endif; ?>
						</td>
					<?php endforeach; ?>
				</tr> -->
				<tr class="your_order_total_sum_row">
					<td>Сумма заказа</td>
					<td></td>
					<td></td>
					<td><?php echo $order->get_formatted_order_total(); ?></td>
				</tr>
				<tr class="your_order_btn">
					<td></td>
					<td></td>
					<td></td>
					<td>
						<?php
						$actions = wc_get_account_orders_actions($order);

						if (!empty($actions)) {
							foreach ($actions as $key => $action) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
								if ($key == 'view') continue;
								echo '<a href="' . esc_url($action['url']) . '" class="woocommerce-button' . esc_attr($wp_button_class) . ' button ' . sanitize_html_class($key) . '">' . esc_html($action['name']) . '</a>';
							}
						}
						?>
					</td>
				</tr>

			</tbody>
		</table>
	<?php
		// break;
	}
	?>
	<!-- </tbody>
	</table> -->

	<?php do_action('woocommerce_before_account_orders_pagination'); ?>

	<?php if (1 < $customer_orders->max_num_pages) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if (1 !== $current_page) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button<?php echo esc_attr($wp_button_class); ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>"><?php esc_html_e('Previous', 'woocommerce'); ?></a>
			<?php endif; ?>

			<?php if (intval($customer_orders->max_num_pages) !== $current_page) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button<?php echo esc_attr($wp_button_class); ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>"><?php esc_html_e('Next', 'woocommerce'); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>

	<?php wc_print_notice(esc_html__('No order has been made yet.', 'woocommerce') . ' <a class="woocommerce-Button wc-forward button' . esc_attr($wp_button_class) . '" href="' . esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))) . '">' . esc_html__('Browse products', 'woocommerce') . '</a>', 'notice'); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment 
	?>

<?php endif; ?>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>