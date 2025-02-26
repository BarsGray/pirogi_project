<?php

/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
?>
<div class="woocommerce-billing-fields">
	<?php if (wc_ship_to_billing_address_only() && WC()->cart->needs_shipping()) : ?>

		<h3><?php esc_html_e('Billing &amp; Shipping', 'woocommerce'); ?></h3>

	<?php else : ?>

		<!-- <h3><?php // esc_html_e('Billing details', 'woocommerce'); 
							?></h3> -->

	<?php endif; ?>

	<?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

	<div class="top_fields_box">
		<?php
		$fields = $checkout->get_checkout_fields('billing');

		foreach ($fields as $key => $field) {

			if ($key == 'billing_wooccm13') {
		?>
				<p class="form-row woocommerce_checkout_our_address billing_wooccm13" data-priority="25">
					<span>Скидка на заказ 10%</span>
				</p>
			<?php
			}

			$is_user_log_in = (is_user_logged_in()) ? 1 : 0;
			if ($key == 'billing_email' && is_user_logged_in()) continue;
			if ($key == 'date_of_birth') continue;


			if ($key == 'billing_bonuss' && $is_user_log_in == 0) continue;

			woocommerce_form_field($key, $field, $checkout->get_value($key));

			if ($key == 'billing_rev') {
				echo '<div class="house_data_box">';
			}
			if ($key == 'billing_entrance') {
				echo '</div>';
				if ($is_user_log_in == 1) echo '<div class="bonuss_field_wrapp">';
			}
			if ($key == 'billing_bonuss' && $is_user_log_in == 1) {
				echo '<button class="bonuss_field_button" type="button">Применить</button>';
				echo '</div>';
			}
			if ($key == 'billing_email') {
				echo '<div class="email_description">Укажите свой Email для регистрации и получите ' . ((carbon_get_theme_option('crb_set_registration_bonus')) ? carbon_get_theme_option('crb_set_registration_bonus') : 0) . ' бонусов на счет</div>';
			}



			// if ($key == 'billing_entrance') {
			// 	echo '</div>';
			// }
			// if ($key == 'billing_entrance') {
			// 	echo '</div>';
			// }



			if ($key == 'billing_wooccm12') {
			?>
				<p class="form-row woocommerce_checkout_our_address" data-priority="30">
					<span>Где забрать:</span>
					<span>
						<?php echo carbon_get_theme_option('crb_address_header'); ?>
					</span>
				</p>
				<div class="select_date_wrapper">
					<div class="select_date_wrapper_items">
				<?php
			}
		}
				?>
				<div class="box_date_check_wrapper">
					<h5>Время доставки</h5>
					<p class="box_date_check">
						<label for="date_check">
							<input name="to_time" id="date_check" type="radio">
							Ближайшее
						</label>
						<label for="date_check_to_time">
							<input name="to_time" id="date_check_to_time" type="radio">
							Ко времени
						</label>
					</p>
				</div>
					</div>
				</div>
	</div>
</div>
<?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>

<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
	<div class="woocommerce-account-fields">
		<?php if (!$checkout->is_registration_required()) : ?>

			<p class="form-row form-row-wide create-account">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true); ?> type="checkbox" name="createaccount" value="1" /> <span><?php esc_html_e('Create an account?', 'woocommerce'); ?></span>
				</label>
			</p>

		<?php endif; ?>

		<?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

		<?php if ($checkout->get_checkout_fields('account')) : ?>

			<div class="create-account">
				<?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
					<?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>

		<?php endif; ?>

		<?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
	</div>
<?php endif; ?>
<div class="woocommerce_total_price">
	<span>Сумма к оплате</span>
	<span>
		<?php
		global $woocommerce;

		echo $woocommerce->cart->get_total();
		?>
	</span>
</div>
<div class="info_on_bonuss_box" data-samovivoz="<?php echo (carbon_get_theme_option('crb_set_percentage_for_pickup')) ? carbon_get_theme_option('crb_set_percentage_for_pickup') : 0 ?>">
	<?php
	$cart = WC()->cart->cart_contents;

	// echo '<pre>';
	// var_dump($cart);
	// echo '</pre>';
	// foreach ($cart as $item) {
	// 	$product_id = $item['product_id'];
	// 	if (wc_get_product($product_id)->is_type('variable')) {
	// 		// echo 'yes';
	// 	} else {
	// 		// echo 'no';
	// 	}
	// 	// echo '<pre>';
	// 	// var_dump($item['product_id']);
	// 	// echo '</pre>';
	// }










	$user_id = get_current_user_id();
	$bonuss_vel_on_product = 0;
	$bonus_price_sum = 0;
	$bonuss_on_next_oder = 0;
	$mini_product = 0;
	$product_count = 0;
	$prod_proc_select = 0;

	$total_price = $woocommerce->cart->total;
	foreach (carbon_get_theme_option('crb_volume') as $item) {

		if ($total_price > (isset($item['crb_volume_sum']) ? $item['crb_volume_sum'] : 0)) {
			if ($bonuss_on_next_oder < (isset($item['crb_volume_procent_discount']) ? $item['crb_volume_procent_discount'] : 0)) {
				$bonuss_on_next_oder = $item['crb_volume_procent_discount'];
			}
		}
	}

	foreach ($cart as $item) {
		$product_id = $item['product_id'];

		if (wc_get_product($product_id)->is_type('variable')) {

			foreach (get_the_terms($product_id, 'product_cat') as $item_term) {
				if (strpos($item_term->slug, 'mini') === 0) {
					if (wc_price(wc_get_product($item['variation_id'])->get_price()) == wc_price(wc_get_product($product_id)->get_price())) {
						$mini_product++;
					}
				}
			}
		}

		$product_count++;
	}
	$product_count -= $mini_product;

	if ($product_count >= ((carbon_get_theme_option('crb_set_quantity_products') == '') ? 0 : carbon_get_theme_option('crb_set_quantity_products'))) {
		// if ((WC()->cart->get_cart_contents_count() - $mini_product) > ((carbon_get_theme_option('crb_set_quantity_products') == '') ? 0 : carbon_get_theme_option('crb_set_quantity_products') - 1)) {
		if ($bonuss_on_next_oder < ((carbon_get_theme_option('crb_set_procent_discount_on_quantity') == '') ? 0 : carbon_get_theme_option('crb_set_procent_discount_on_quantity'))) {
			$bonuss_on_next_oder = (carbon_get_theme_option('crb_set_procent_discount_on_quantity') == '') ? 0 : carbon_get_theme_option('crb_set_procent_discount_on_quantity');
		}
	}

	$terms = [];
	$arr_discounts_for_terms = [];

	$terms_on_discount = [];
	foreach (carbon_get_theme_option('crb_slider') as $item) {
		if ($item['crb_event_date'] != current_time('d.m.Y')) {
			continue;
		}
		foreach ($item['crb_slide'] as $item_slide) {
			$terms_on_discount[] = $item_slide['crb_set_discount_to_term'];
			$arr_discounts_for_terms[$item_slide['crb_set_discount_to_term']] = $item_slide['crb_set_discount_procent'];
		}
	}


	foreach ($cart as $item) {
		$product_id = $item['product_id'];

		if (wc_get_product($product_id)->is_type('variable')) {

			foreach ($terms_on_discount as $item_dis_term_variable) {

				if (strpos($item_dis_term_variable, 'mini') === 0) {
					if (wc_price(wc_get_product($item['variation_id'])->get_price()) == wc_price(wc_get_product($product_id)->get_price())) {
						$get_terms_discount = get_the_terms($product_id, 'product_cat');

						foreach ($get_terms_discount as $item_dis_term) {
							if ($item_dis_term->slug == trim($item_dis_term_variable)) {
								if (((isset($arr_discounts_for_terms[$item_dis_term_variable])) ? $arr_discounts_for_terms[$item_dis_term_variable] : 0) > $bonuss_on_next_oder) {

									$bonuss_vel_on_product += round($arr_discounts_for_terms[$item_dis_term_variable] / 100 * wc_get_product($item['variation_id'])->get_price() * $item['quantity']);
									$bonus_price_sum += wc_get_product($item['variation_id'])->get_price() * $item['quantity'];
									$terms[][] = $item_dis_term;
								}
							}
						}
					}
				} else {
					if (wc_price(wc_get_product($item['variation_id'])->get_price()) != wc_price(wc_get_product($product_id)->get_price())) {
						$get_terms_discount = get_the_terms($product_id, 'product_cat');


						foreach ($get_terms_discount as $item_dis_term) {

							if ($item_dis_term->slug == trim($item_dis_term_variable)) {
								if (((isset($arr_discounts_for_terms[$item_dis_term_variable])) ? $arr_discounts_for_terms[$item_dis_term_variable] : 0) > $bonuss_on_next_oder) {



									$bonuss_vel_on_product += round($arr_discounts_for_terms[$item_dis_term_variable] / 100 * wc_get_product($item['variation_id'])->get_price() * $item['quantity']);

									// echo $bonuss_vel_on_product . '<br>';
									// echo $bonus_price_sum . '<br>';
									$bonus_price_sum += wc_get_product($item['variation_id'])->get_price() * $item['quantity'];
									// echo $bonus_price_sum . '<br>';
									$terms[][] = $item_dis_term;
								}
							}
						}
					}
				}
			}
		} else {
			$get_terms_discount = get_the_terms($product_id, 'product_cat')[0]->slug;
			if (((isset($arr_discounts_for_terms[$get_terms_discount])) ? $arr_discounts_for_terms[$get_terms_discount] : 0) > $bonuss_on_next_oder) {

				$bonuss_vel_on_product += round($arr_discounts_for_terms[$get_terms_discount] / 100 * wc_get_product($product_id)->get_price() * $item['quantity']);
				$bonus_price_sum += wc_get_product($product_id)->get_price() * $item['quantity'];
				$terms[] = get_the_terms($product_id, 'product_cat');
			}
		}




		// echo $prod_proc_select . '<br>';
		// $bonuss_vel_on_product += $prod_proc_select;
		// $prod_proc_select = 0;
	}


	// echo '<br>' . $product_count . '<br>';
	// echo '<br>' . $mini_product . '<br>';
	// echo '<br>' . WC()->cart->get_cart_contents_count() . '<br>';
	// echo '<br>' . $bonuss_on_next_oder . '<br>';
	// echo '<br>' . $bonus_price_sum . '<br>';
	// echo '<br>' . $bonuss_vel_on_product . '<br>';
	// echo '<br>' . $woocommerce->cart->total . '<br>';

	// echo '<pre>';
	// var_dump($woocommerce->cart->total);
	// echo '</pre>';

	// echo '<br><br>Начислено бонусов за товары по акционным категорям - ' . $bonuss_vel_on_product;
	// echo '<br><br>Начислено бонусов за обьем или сет в зависимости от величины процента - ' . round($bonuss_on_next_oder / 100 * ($woocommerce->cart->total - $bonus_price_sum));
	// echo '<br><br>Начислено бонусов всего - ' . round($bonuss_vel_on_product + $bonuss_on_next_oder / 100 * ($woocommerce->cart->total - $bonus_price_sum));
	?>
	<?php if ($is_user_log_in == 1) : ?>
		<span>
			<?php echo 'Будет начислено бонусов на следующий заказ '; ?>
		</span>
		<span class="bonus_vel_box">
			<span class="p-coin"></span>
			<span class="bonus_sum">
				<?php echo round($bonuss_vel_on_product + $bonuss_on_next_oder / 100 * ($woocommerce->cart->total - $bonus_price_sum)) . ' &#8381;'; ?>
				<?php // echo round($bonuss_vel_on_product + $bonuss_on_next_oder / 100 * ($woocommerce->cart->total)) . ' &#8381;'; 
				?>
			</span>
		</span>
		<?php
		// echo $bonus_price_sum . '<br>';
		// echo $bonuss_on_next_oder . '<br>';
		// echo $bonuss_vel_on_product . '<br>';
		// echo $bonuss_on_next_oder / 100 * $woocommerce->cart->total;
		?>
	<?php endif; ?>

	<?php
















	// $tot = WC()->session->get('cart_totals');
	// foreach ($tot as $elem => $vel) {
	// 	if ($vel == '3580') {
	// 		$tot[$elem] = '666';
	// 	}
	// }

	// WC()->session->set('cart_totals', $tot);

	// echo '<pre>';
	// // var_dump($tot);
	// var_dump(WC()->session->get('cart_totals'));
	// echo '</pre>';
	?>
</div>