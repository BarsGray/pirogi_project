<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>
<div class="cart_content_wrapper">
	<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
		<?php do_action('woocommerce_before_cart_table'); ?>

		<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
			<!-- <thead>
			<tr>
				<th class="product-remove"><span class="screen-reader-text"><?php // esc_html_e('Remove item', 'woocommerce'); 
				?></span></th>
				<th class="product-thumbnail"><span class="screen-reader-text"><?php // esc_html_e('Thumbnail image', 'woocommerce'); 
				?></span></th>
				<th class="product-name"><?php // esc_html_e('Product', 'woocommerce'); 
				?></th>
				<th class="product-price"><?php // esc_html_e('Price', 'woocommerce'); 
				?></th>
				<th class="product-quantity"><?php // esc_html_e('Quantity', 'woocommerce'); 
				?></th>
				<th class="product-subtotal"><?php // esc_html_e('Subtotal', 'woocommerce'); 
				?></th>
			</tr>
		</thead> -->
			<?php try { ?>
				<tbody>
					<?php do_action('woocommerce_before_cart_contents'); ?>

					<?php
					// WC()->cart->empty_cart();
					$GLOBALS['bonus_sum_in_cart'] = 0;
					$prod_mini_in_cart = 0;
					$product_count_in_cart = 0;


					foreach (WC()->cart->get_cart() as $item) {
						$product_id = $item['product_id'];

						if (wc_get_product($product_id)->is_type('variable')) {

							foreach (get_the_terms($product_id, 'product_cat') as $item_term) {
								if (strpos($item_term->slug, 'mini') === 0) {
									if (wc_price(wc_get_product($item['variation_id'])->get_price()) == wc_price(wc_get_product($product_id)->get_price())) {
										$prod_mini_in_cart++;
									}
								}
							}
						}

						$product_count_in_cart++;
					}

					foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {

						$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
						$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
						/**
						 * Filter the product name.
						 *
						 * @since 2.1.0
						 * @param string $product_name Name of the product in the cart.
						 * @param array $cart_item The product in the cart.
						 * @param string $cart_item_key Key for the product in the cart.
						 */
						$product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

						if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
							$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
							?>
							<tr
								class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

								<td class="product-thumbnail product_thumbnail_in_cart">
									<?php


									$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

									// echo '<pre>';
									// var_dump($_product->get_short_description());
									// echo '</pre>';
						
									if (!$product_permalink) {
										echo $thumbnail; // PHPCS: XSS ok.
									} else {
										printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
									}
									?>
								</td>

								<td class="product_data">

									<?php
									$is_mini = 0;

									if (wc_get_product($product_id)->is_type('variable')) {

										foreach (get_the_terms($product_id, 'product_cat') as $item_term) {
											if (strpos($item_term->slug, 'mini') === 0) {
												if (wc_price(wc_get_product($cart_item['variation_id'])->get_price()) == wc_price(wc_get_product($product_id)->get_price())) {
													// echo 'mini';
													$is_mini = 1;
												}
											}
										}
									} else {
										foreach (get_the_terms($product_id, 'product_cat') as $item_term) {
											if (strpos($item_term->slug, 'mini') === 0) {
												$is_mini = 1;
											}
										}
									}
									?>

									<div class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>" <?php echo ($is_mini == 1) ? 'data-mini="' . $cart_item['quantity'] . '"' : ''; ?>>
										<?php
										if (!$product_permalink) {
											echo wp_kses_post($product_name . '&nbsp;');
										} else {
											/**
											 * This filter is documented above.
											 *
											 * @since 2.1.0
											 */
											echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_title()), $cart_item, $cart_item_key));
										}

										do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

										// Meta data.
										echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.
							
										// Backorder notification.
										if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
											echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
										}
										?>
									</div>
									<div class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
										<?php
										// echo '<pre>';
										// var_dump($_product->get_attributes());
										// var_dump($_product);
										// var_dump($product_id);
										// var_dump($_product->get_attributes());
										// echo '</pre>';
										// echo $_product->get_attribute_summary();
							

										$id_pron_now = 0;

										if (wc_get_product($product_id)->is_type('variable')) {
											$id_pron_now = $cart_item['variation_id'];
										} else {
											$id_pron_now = $product_id;
										}

										// echo $cart_item['variation_id'];
							
										// echo wc_get_product($id_pron_now)->get_price();
										// echo $product_id;
										// echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
										echo apply_filters('woocommerce_cart_item_price', wc_get_product($id_pron_now)->get_price() * $cart_item['quantity'], $cart_item, $cart_item_key) . ' &#8381;'; // PHPCS: XSS ok.
							
										?>
										<div class="info_on_bonuss_box_in_cart">
											<span class="bonus_vel_box">
												<?php




												$disc_on_next_order = 0;
												$arr_discounts_for_terms = [];
												$terms_on_discount = [];


												if (($product_count_in_cart - $prod_mini_in_cart) >= ((carbon_get_theme_option('crb_set_quantity_products') == '') ? 0 : carbon_get_theme_option('crb_set_quantity_products'))) {
													if ($disc_on_next_order < ((carbon_get_theme_option('crb_set_procent_discount_on_quantity') == '') ? 0 : carbon_get_theme_option('crb_set_procent_discount_on_quantity'))) {
														$disc_on_next_order = ((carbon_get_theme_option('crb_set_procent_discount_on_quantity') == '') ? 0 : carbon_get_theme_option('crb_set_procent_discount_on_quantity'));
													}
												}

												$total_price = WC()->cart->total;
												foreach (carbon_get_theme_option('crb_volume') as $item) {

													if ($total_price > (isset($item['crb_volume_sum']) ? $item['crb_volume_sum'] : 0)) {
														if ($disc_on_next_order < (isset($item['crb_volume_procent_discount']) ? $item['crb_volume_procent_discount'] : 0)) {
															$disc_on_next_order = $item['crb_volume_procent_discount'];
														}
													}
												}



												foreach (carbon_get_theme_option('crb_slider') as $item) {
													if ($item['crb_event_date'] != current_time('d.m.Y')) {
														continue;
													}
													foreach ($item['crb_slide'] as $item_slide) {
														$terms_on_discount[] = $item_slide['crb_set_discount_to_term'];
														$arr_discounts_for_terms[$item_slide['crb_set_discount_to_term']] = $item_slide['crb_set_discount_procent'];
													}
												}


												if (wc_get_product($product_id)->is_type('variable')) {

													foreach (get_the_terms($product_id, 'product_cat') as $item_term) {
														if (strpos($item_term->slug, 'mini') === 0) {
															if (wc_price(wc_get_product($cart_item['variation_id'])->get_price()) == wc_price(wc_get_product($product_id)->get_price())) {

																foreach ($terms_on_discount as $item_term_var) {

																	if ($item_term->slug == $item_term_var) {
																		if ($disc_on_next_order < $arr_discounts_for_terms[$item_term_var]) {
																			$disc_on_next_order = $arr_discounts_for_terms[$item_term_var];

																			if (($product_count_in_cart - $prod_mini_in_cart) >= ((carbon_get_theme_option('crb_set_quantity_products') == '') ? 0 : carbon_get_theme_option('crb_set_quantity_products'))) {
																				if ($disc_on_next_order < ((carbon_get_theme_option('crb_set_procent_discount_on_quantity') == '') ? 0 : carbon_get_theme_option('crb_set_procent_discount_on_quantity'))) {
																					$disc_on_next_order = ((carbon_get_theme_option('crb_set_procent_discount_on_quantity') == '') ? 0 : carbon_get_theme_option('crb_set_procent_discount_on_quantity'));
																				}
																			}
																		}
																	}
																}
															}
														} else {
															if (wc_price(wc_get_product($cart_item['variation_id'])->get_price()) != wc_price(wc_get_product($product_id)->get_price())) {

																foreach ($terms_on_discount as $item_term_var) {

																	if ($item_term->slug == $item_term_var) {
																		if ($disc_on_next_order < $arr_discounts_for_terms[$item_term_var]) {
																			$disc_on_next_order = $arr_discounts_for_terms[$item_term_var];

																			if (($product_count_in_cart - $prod_mini_in_cart) >= ((carbon_get_theme_option('crb_set_quantity_products') == '') ? 0 : carbon_get_theme_option('crb_set_quantity_products'))) {
																				if ($disc_on_next_order < ((carbon_get_theme_option('crb_set_procent_discount_on_quantity') == '') ? 0 : carbon_get_theme_option('crb_set_procent_discount_on_quantity'))) {
																					$disc_on_next_order = ((carbon_get_theme_option('crb_set_procent_discount_on_quantity') == '') ? 0 : carbon_get_theme_option('crb_set_procent_discount_on_quantity'));
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}


												if ($disc_on_next_order != 0) {
													?>
													<span class="p-coin"></span>
													<span
														class="bonus_sum"><?php echo round($disc_on_next_order / 100 * $_product->get_price() * $cart_item['quantity'], 0, PHP_ROUND_HALF_DOWN); ?></span>
													<?php
													$GLOBALS['bonus_sum_in_cart'] += round($disc_on_next_order / 100 * $_product->get_price() * $cart_item['quantity'], PHP_ROUND_HALF_DOWN);
												}

												// echo $product_count_in_cart - $prod_mini_in_cart;
												// echo $cart_item['quantity'];
												// echo $cart_item['product_id'];
												?>
											</span>
										</div>
									</div>
									<div class="short_description">
										<p>
											<?php
											echo $_product->get_short_description();
											?>
										</p>
									</div>
									<div class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
										<div class="quantity_selector">
											<button class="minus product_quantity_button">-</button>
											<?php
											if ($_product->is_sold_individually()) {
												$min_quantity = 1;
												$max_quantity = 1;
											} else {
												$min_quantity = 1;
												$max_quantity = $_product->get_max_purchase_quantity();
											}

											$product_quantity = woocommerce_quantity_input(
												array(
													'input_name' => "cart[{$cart_item_key}][qty]",
													'input_value' => $cart_item['quantity'],
													'max_value' => $max_quantity,
													'min_value' => $min_quantity,
													'product_name' => $product_name,
												),
												$_product,
												false
											);

											echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
											?>
											<button class="plus product_quantity_button">+</button>
										</div>
									</div>
									<!-- <div class="product-subtotal" data-title="<?php // esc_attr_e('Subtotal', 'woocommerce'); 
												?>">
									<?php
									// echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
									?>
								</div> -->


									<div class="product-remove">
										<?php
										echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											'woocommerce_cart_item_remove_link',
											sprintf(
												'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">Удалить товар</a>',
												// '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
												esc_url(wc_get_cart_remove_url($cart_item_key)),
												/* translators: %s is the product name */
												esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
												esc_attr($product_id),
												esc_attr($_product->get_sku())
											),
											$cart_item_key
										);
										?>
									</div>
								</td>
							</tr>
							<?php
						}
					}
					?>

					<?php do_action('woocommerce_cart_contents'); ?>

					<tr>
						<td colspan="6" class="actions">

							<?php if (wc_coupons_enabled()) { ?>
								<div class="coupon">
									<label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
									<input type="text" name="coupon_code" class="input-text" id="coupon_code" value=""
										placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" /> <button type="submit"
										class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
										name="apply_coupon"
										value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply coupon', 'woocommerce'); ?></button>
									<?php do_action('woocommerce_cart_coupon'); ?>
								</div>
							<?php } ?>

							<button type="submit"
								class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
								name="update_cart"
								value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

							<?php do_action('woocommerce_cart_actions'); ?>

							<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
						</td>
					</tr>

					<?php do_action('woocommerce_after_cart_contents'); ?>
				</tbody>

				<?php
			} catch (\Throwable $th) {
				WC()->cart->empty_cart();
				wp_redirect(wc_get_cart_url());
				exit;
			} ?>

		</table>
		<?php do_action('woocommerce_after_cart_table'); ?>

	</form>

	<?php do_action('woocommerce_before_cart_collaterals'); ?>

	<div class="cart-collaterals">
		<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action('woocommerce_cart_collaterals');
		?>
	</div>
</div>

<?php do_action('woocommerce_after_cart'); ?>