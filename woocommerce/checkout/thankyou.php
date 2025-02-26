<?php

/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-order">

	<?php
	if ($order):

		do_action('woocommerce_before_thankyou', $order->get_id());
		?>

		<?php if ($order->has_status('failed')): ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
				<?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?>
			</p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>"
					class="button pay"><?php esc_html_e('Pay', 'woocommerce'); ?></a>
				<?php if (is_user_logged_in()): ?>
					<a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
						class="button pay"><?php esc_html_e('My account', 'woocommerce'); ?></a>
				<?php endif; ?>
			</p>

		<?php else: ?>

			<?php wc_get_template('checkout/order-received.php', array('order' => $order)); ?>

			<?php

			// $terms_all = [];
			// // Получение всех категорий товаров
			// $categories = get_terms(array(
			// 	'taxonomy' => 'product_cat',
			// 	'hide_empty' => true, // Если нужно скрыть пустые категории, установите true
			// ));
	
			// // Проверка, есть ли категории
			// if (!empty($categories) && !is_wp_error($categories)) {
			// 	foreach ($categories as $category) {
	
			// 		$terms_all[esc_html($category->slug)] = esc_html($category->name);
			// 		// echo get_term_link($category);
			// 		// echo esc_html($category->name);
			// 		// echo esc_html($category->slug);
			// 	}
			// }
	

			// echo '<pre>';
			// var_dump($order);
			// echo '</pre>';
	
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}

			$is_user_reg = 0;
			$new_user_id = '';
			if (!is_user_logged_in() && is_email($order->get_billing_email())) {

				$username = $order->get_billing_first_name();
				$email = $order->get_billing_email();
				$password = wp_generate_password(5, false);

				// Проверка, существует ли пользователь с таким email или именем пользователя
				if (!email_exists($email)) {

					// Создание нового пользователя
					$user_id = wp_create_user(explode('@', $email)[0], $password, $email);

					if (is_wp_error($user_id)) {
						// return 'Error in user creation: ' . $user_id->get_error_message();
					}

					// Установка роли пользователя как "customer" (клиент)
					$user = new WP_User($user_id);
					$user->set_role('customer');

					// Добавление дополнительных мета-данных пользователя, если нужно
					update_user_meta($user_id, 'first_name', $username);
					update_user_meta($user_id, 'billing_address_1', $order->get_billing_address_1());
					update_user_meta($user_id, 'billing_address_2', $order->get_billing_address_2());
					update_user_meta($user_id, 'billing_email', $email);
					update_user_meta($user_id, 'billing_first_name', $username);
					update_user_meta($user_id, 'billing_phone', $order->get_billing_phone());

					if ($order->get_meta('billing_deliverymethod') == 'samovivoz') {
						$percentage_for_pickup_on_thanks = (carbon_get_theme_option('crb_set_percentage_for_pickup')) ? carbon_get_theme_option('crb_set_percentage_for_pickup') : 0;
						update_user_meta($user_id, 'bonuss', ((carbon_get_theme_option('crb_set_registration_bonus')) ? carbon_get_theme_option('crb_set_registration_bonus') : 0) + $percentage_for_pickup_on_thanks / 100 * $order->get_total());
					} else {
						update_user_meta($user_id, 'bonuss', (carbon_get_theme_option('crb_set_registration_bonus')) ? carbon_get_theme_option('crb_set_registration_bonus') : 0);
					}

					update_user_meta($user_id, 'apartment', $order->get_meta('billing_apartment'));
					update_user_meta($user_id, 'floor', $order->get_meta('billing_floor'));
					update_user_meta($user_id, 'entrance', $order->get_meta('billing_entrance'));
					echo get_post_meta($order->get_id(), 'entrance', true);


					// Можно также отправить email пользователю с данными для входа
					// wp_new_user_notification($user_id, $password, 'user');
					wp_mail(
						$email,
						'Добро пожаловать в наш магазин!',
						// "Спасибо за регистрацию. Вот ваши данные для входа:\n\nЛогин: " . explode('@', $email)[0] . "\nПароль: $password\n\nВы можете войти здесь: " . get_permalink(get_option('woocommerce_myaccount_page_id'))
						"Спасибо за регистрацию. Вот ваши данные для входа:\n\nEmail: " . $email . "\nПароль: $password\n\nВы можете войти здесь: " . get_permalink(get_option('woocommerce_myaccount_page_id'))
					);
					// return 'User registration successful';
					$is_user_reg = 1;
					$new_user_id = $user_id;
					wp_set_current_user($user_id);
					wp_set_auth_cookie($user_id);


					if (!isset($_SESSION['reloaded'])) {
						$_SESSION['reloaded'] = true;
						$_SESSION['message'] = '<div class="thankyou_registr_text">Спасибо за регистрацию, логин и пароль для входа в личный кабинет были отправлены на ваш Email. ' . ((carbon_get_theme_option('crb_set_registration_bonus')) ? '<span class="text_registration_bonus">Вам начислено ' . carbon_get_theme_option('crb_set_registration_bonus') . ' бонусов.</span>' : '') . '</div>';
					}

					$order->set_customer_id($user_id);
					$order->save();
					wp_safe_redirect(esc_url_raw(add_query_arg([])));
				}
			}

			if ($is_user_reg == 0) {
				if (isset($_SESSION['message'])) {
					// Вывод сообщения
					echo $_SESSION['message'];
					// Удаление сообщения из сессии после отображения
					unset($_SESSION['message']);
					unset($_SESSION['reloaded']);
				}
			}

			// echo '<pre>';
			// var_dump($order);
			// echo '</pre>';
	


			// $user_id = get_current_user_id();
			$user_id = ($is_user_reg == 0) ? get_current_user_id() : $new_user_id;
			$bonuss_vel_on_product = 0;
			$bonus_price_sum = 0;
			$bonuss_on_next_oder = 0;
			$mini_product = 0;
			$product_count = 0;

			$total_price = $order->get_total();
			foreach (carbon_get_theme_option('crb_volume') as $item) {

				if ($total_price > (isset($item['crb_volume_sum']) ? $item['crb_volume_sum'] : 0)) {
					if ($bonuss_on_next_oder < (isset($item['crb_volume_procent_discount']) ? $item['crb_volume_procent_discount'] : 0)) {
						$bonuss_on_next_oder = $item['crb_volume_procent_discount'];
					}
				}
			}

			foreach ($order->get_items() as $item) {
				$product_id = $item->get_product_id();

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

			if ($product_count > ((carbon_get_theme_option('crb_set_quantity_products') == '') ? 0 : carbon_get_theme_option('crb_set_quantity_products') - 1)) {
				if ($bonuss_on_next_oder < ((carbon_get_theme_option('crb_set_procent_discount_on_quantity') == '') ? 0 : carbon_get_theme_option('crb_set_procent_discount_on_quantity'))) {
					$bonuss_on_next_oder = ((carbon_get_theme_option('crb_set_procent_discount_on_quantity') == '') ? 0 : carbon_get_theme_option('crb_set_procent_discount_on_quantity'));
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


			foreach ($order->get_items() as $item) {
				$product_id = $item->get_product_id();
				// echo '<pre>';
				// var_dump(wc_get_product($product_id));
				// var_dump(wc_get_product($item['variation_id'])->get_attribute_summary());
				// echo '</pre>';
	
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
											$bonus_price_sum += wc_get_product($item['variation_id'])->get_price() * $item['quantity'];
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
			}


			function get_last_order_id()
			{
				$statuses = array_keys(wc_get_order_statuses());
				$statuses = implode("','", $statuses);

				$arr_last_orders_id_numbers = [];
				$args = array(
					'posts_per_page' => 10,
					'post_type' => 'shop_order',
					'post_status' => $statuses,
					'orderby' => 'date',
					'order' => 'DESC'
				);

				$orders = get_posts($args);

				if ($orders) {
					foreach ($orders as $order) {
						$arr_last_orders_id_numbers[] = $order->ID;
					}
				}
				return $arr_last_orders_id_numbers;
			}

			// if ($order->get_meta('_billing_wooccm13') != '') {
			// update_user_meta($user_id, 'bonuss', sanitize_text_field(round($bonuss_on_next_oder / 100 * $order->get_total(), 2)));
			// update_user_meta($user_id, 'bonuss', sanitize_text_field(10));
			// } else {
			// update_user_meta($user_id, 'bonuss', sanitize_text_field($bonuss_on_next_oder));
			// }
			// var_dump($order->get_meta('_billing_wooccm13'));
	

			// echo '<br>test' . $order;
			// echo '<pre>';
			// var_dump($order);
			// var_dump($order->get_meta('billing_bonuss') != '');
			// echo '</pre>';
			// echo '<br>' . $order->get_meta('billing_bonuss');
			// echo '<br>Начислено бонусов за товары по акционным категорям - ' . $bonuss_vel_on_product;
			// echo '<br>Начислено бонусов за обьем или сет в зависимости от величины процента - ' . round(($bonuss_on_next_oder / 100 * ($order->get_total() - $bonus_price_sum)));
	
			$bonus_gets_total = round(($bonuss_vel_on_product + $bonuss_on_next_oder / 100 * ($order->get_total() - $bonus_price_sum)));
			$percentage_for_pickup_on_thanks = 0;
			// echo 'test';
			// echo $order->get_meta('billing_deliverymethod');
			if ($order->get_meta('billing_deliverymethod') == 'samovivoz') {
				$percentage_for_pickup_on_thanks = (carbon_get_theme_option('crb_set_percentage_for_pickup')) ? carbon_get_theme_option('crb_set_percentage_for_pickup') : 0;
				// $bonus_gets_total += $percentage_for_pickup_on_thanks / 100 * $order->get_total();
				$bonus_gets_total = $percentage_for_pickup_on_thanks / 100 * $order->get_total();
			}

			if ($bonus_gets_total > 0 && $order->get_meta('billing_bonuss') == '' || $bonus_gets_total > 0 && $order->get_total() > 2000 || $bonus_gets_total > 0 && $order->get_meta('billing_deliverymethod') == 'samovivoz') {
				// if ($bonus_gets_total > 0 && $order->get_total() < 2000) {
	
				echo '<p class="bonus_gets_total">Начислено бонусов - ' . $bonus_gets_total . '</p>';
			}
			// echo '<br>' . round(($bonuss_vel_on_product + $bonuss_on_next_oder / 100 * ($order->get_total() - $bonus_price_sum) + get_user_meta($user_id, 'bonuss', true)));
	
			if ($order->get_meta('billing_bonuss') == '' || $order->get_total() >= 2000) {
				if ($order->get_meta('order_bonus_check') == 0) {

					if ($order->get_meta('billing_deliverymethod') != 'samovivoz') {
						update_user_meta($user_id, 'bonuss', sanitize_text_field(round(($bonuss_vel_on_product + $bonuss_on_next_oder / 100 * ($order->get_total() - $bonus_price_sum) + ((get_user_meta($user_id, 'bonuss', true) == '') ? 0 : get_user_meta($user_id, 'bonuss', true))))));
					}
					// update_post_meta($order->get_id(), 'order_bonus_check', 1);
				}
			}
			if ($order->get_meta('order_bonus_check') == 0) {

				update_post_meta($order->get_id(), 'order_bonus_check', 1);
				wp_safe_redirect(home_url($_SERVER['REQUEST_URI']));
				exit;
			}

			// echo home_url($_SERVER['REQUEST_URI']) . '<br>';
			// echo $_SERVER['REQUEST_URI'];
			?>




			<h2 class="woocommerce-order-details__title">Информация о заказе</h2>

			<table>
				<tbody>
					<tr>
						<td>
							<p><?php esc_html_e('Order number:', 'woocommerce'); ?></p>
							<p><?php esc_html_e('Date:', 'woocommerce'); ?></p>
							<p><?php esc_html_e('Total:', 'woocommerce'); ?></p>
						</td>
						<td>
							<p><strong><?php echo $order->get_order_number(); ?></strong></p>
							<p><strong><?php echo wc_format_datetime($order->get_date_created()); ?></strong></p>
							<p><strong><?php echo $order->get_formatted_order_total(); ?></strong></p>
						</td>
					</tr>
					<tr>
						<td>
							<p>Имя:</p>
							<p>Телефон:</p>
							<?php
							if ($order->get_meta('billing_deliverymethod') == 'kurer') {
								echo '
								<p>Улица:</p>
								<p>Дом:</p>
								<p>Квартира:</p>
								<p>Этаж:</p>
								<p>Подъезд:</p>';
							}
							?>
							<p>Комментарий к заказу:</p>
						</td>
						<td>
							<p><strong><?php echo $order->get_billing_first_name(); ?></strong></p>
							<p><strong><?php echo $order->get_billing_phone(); ?></strong></p>
							<? if ($order->get_meta('billing_deliverymethod') == 'kurer'): ?>
								<p>
									<strong>
										<?php
										if ($order->get_billing_address_1() == '') {
											echo '&#8722';
										} else {
											echo $order->get_billing_address_1();
										}
										?>
									</strong>
								</p>
								<p>
									<strong>
										<?php
										if ($order->get_billing_address_2() == '') {
											echo '&#8722';
										} else {
											echo $order->get_billing_address_2();
										}
										?>
									</strong>
								</p>
								<p>
									<strong>
										<?php
										if ($order->get_meta('billing_apartment') == '') {
											echo '&#8722';
										} else {
											echo $order->get_meta('billing_apartment');
										}
										?>
									</strong>
								</p>
								<p>
									<strong>
										<?php
										if ($order->get_meta('billing_floor') == '') {
											echo '&#8722';
										} else {
											echo $order->get_meta('billing_floor');
										}
										?>
									</strong>
								</p>
								<p>
									<strong>
										<?php
										if ($order->get_meta('billing_entrance') == '') {
											echo '&#8722';
										} else {
											echo $order->get_meta('billing_entrance');
										}
										// if ($order->get_meta('_billing_wooccm11') == '') {
										// 	echo '&#8722';
										// } else {
										// 	echo $order->get_meta('_billing_wooccm11');
										// }
										?>
									</strong>
								</p>
							<?php endif; ?>
							<p>
								<strong>
									<?php
									if ($order->get_meta('billing_rev') == '') {
										echo '&#8722';
									} else {
										echo $order->get_meta('billing_rev');
									}
									?>
								</strong>
							</p>
						</td>
					</tr>
					<tr>
						<td>Способ доставки:</td>
						<td>
							<strong>
								<?php
								if ($order->get_meta('billing_deliverymethod') == 'kurer') {
									echo 'Курьер';
								} else if ($order->get_meta('billing_deliverymethod') == 'samovivoz') {
									echo 'Самовывоз (' . carbon_get_theme_option('crb_address_header') . ')';
								}
								?>
							</strong>
						</td>
					</tr>
					<tr>
						<td>
							<?php
							if ($order->get_meta('billing_deliverymethod') == 'kurer') {
								echo 'Время доставки:';
							} else if ($order->get_meta('billing_deliverymethod') == 'samovivoz') {
								echo 'Время самовывоза:';
							}
							?>
						</td>
						<td>
							<strong><?php echo $order->get_meta('billing_deliverymethod_date'); ?></strong>,
							<strong><?php echo $order->get_meta('billing_deliverymethod_time'); ?></strong>
						</td>
					</tr>
					<tr>
						<td>Способ оплаты:</td>
						<td>
							<strong>
								<?php
								if ($order->get_meta('billing_deliverymethod_date_pay1') == 'cash') {
									echo 'Наличными';
								} else if ($order->get_meta('billing_deliverymethod_date_pay1') == 'pay') {
									echo 'Картой';
								}
								?>
							</strong>
						</td>
					</tr>
				</tbody>
			</table>
		<?php endif; ?>

		<?php

		// function registr_user()
		// {
	
		// 	if (!is_user_logged_in()) {
	
		// 		$username = $order->get_billing_first_name();
		// 		$email = $order->get_billing_email();
		// 		$password = wp_generate_password();
	
		// 		// Проверка, существует ли пользователь с таким email или именем пользователя
		// 		if (username_exists($username) || email_exists($email)) {
		// 			return 'User already exists';
		// 		}
	
		// 		// Создание нового пользователя
		// 		$user_id = wp_create_user($username, $password, $email);
	
		// 		if (is_wp_error($user_id)) {
		// 			return 'Error in user creation: ' . $user_id->get_error_message();
		// 		}
	
		// 		// Установка роли пользователя как "customer" (клиент)
		// 		$user = new WP_User($user_id);
		// 		$user->set_role('customer');
	
		// 		// Добавление дополнительных мета-данных пользователя, если нужно
		// 		update_user_meta($user_id, 'first_name', $username);
		// 		update_user_meta($user_id, 'billing_address_1', $order->get_billing_address_1());
		// 		update_user_meta($user_id, 'billing_address_2', $order->get_billing_address_2());
		// 		update_user_meta($user_id, 'billing_email', $email);
		// 		update_user_meta($user_id, 'billing_first_name', $username);
		// 		update_user_meta($user_id, 'billing_phone', $order->get_billing_phone());
		// 		update_user_meta($user_id, 'bonuss', 200);
	
		// 		// Можно также отправить email пользователю с данными для входа
		// 		wp_new_user_notification($user_id, null, 'user');
		// 		return 'User registration successful';
		// 	}
		// }
	
		// // Автоматическая авторизация
		// wp_set_current_user($user_id);
		// wp_set_auth_cookie($user_id);
	
















		// function register_new_user($email, $username, $password)
		// {
		// 	// Проверка, существует ли пользователь с таким email или именем пользователя
		// 	if (username_exists($username) || email_exists($email)) {
		// 		return 'User already exists';
		// 	}
	
		// 	// Создание нового пользователя
		// 	$user_id = wp_create_user($username, $password, $email);
	
		// 	if (is_wp_error($user_id)) {
		// 		return 'Error in user creation: ' . $user_id->get_error_message();
		// 	}
	
		// 	// Установка роли пользователя как "customer" (клиент)
		// 	$user = new WP_User($user_id);
		// 	$user->set_role('customer');
	
		// 	// Добавление дополнительных мета-данных пользователя, если нужно
		// 	update_user_meta($user_id, 'first_name', 'John');
		// 	update_user_meta($user_id, 'last_name', 'Doe');
	
		// 	// Можно также отправить email пользователю с данными для входа
		// 	wp_new_user_notification($user_id, null, 'user');
	
		// 	return 'User registration successful';
		// }
	


		// // Пример использования функции
		// $email = 'example@example.com';
		// $username = 'exampleuser';
		// $password = 'examplepassword';
	
		// $registration_result = register_new_user($email, $username, $password);
		// echo $registration_result;
	
		// echo '<pre>';
// if (isset($_COOKIE['_ym_uid'])) {
// 	$ymUserID = $_COOKIE['_ym_uid']; // Считываем значение
// 	echo "UserID Яндекс.Метрики: " . htmlspecialchars($ymUserID);
// } else {
// 	echo "Cookie 'ym_uid' не установлена.";
// }
// echo '</pre>';
	

		if ($is_user_reg == 0) {

			$delivery_type = '';
			if ($order->get_meta('billing_deliverymethod') == 'kurer') {
				$delivery_type = 'Курьер';
			} else if ($order->get_meta('billing_deliverymethod') == 'samovivoz') {
				$delivery_type = 'Самовывоз (' . carbon_get_theme_option('crb_address_header') . ')';
			}

			$payment_type = '';
			if ($order->get_meta('billing_deliverymethod_date_pay1') == 'cash') {
				$payment_type = 'Наличными';
			} else if ($order->get_meta('billing_deliverymethod_date_pay1') == 'pay') {
				$payment_type = 'Картой';
			}

			$address = '';
			if ($order->get_billing_address_1() == '') {
				$address = $address . '- , ';
			} else {
				$address = $address . $order->get_billing_address_1() . ', ';
			}
			if ($order->get_billing_address_2() == '') {
				$address = $address . '- , ';
			} else {
				$address = $address . $order->get_billing_address_2() . ', ';
			}
			if ($order->get_meta('billing_apartment') == '') {
				$address = $address . '- , ';
			} else {
				$address = $address . $order->get_meta('billing_apartment') . ', ';
			}
			if ($order->get_meta('billing_floor') == '') {
				$address = $address . '- , ';
			} else {
				$address = $address . $order->get_meta('billing_floor') . ', ';
			}
			if ($order->get_meta('billing_entrance') == '') {
				$address = $address . '- ';
			} else {
				$address = $address . $order->get_meta('billing_entrance') . '';
			}

			$user_id = '';
			if (isset($_COOKIE['_ym_uid'])) {
				$ymUserID = $_COOKIE['_ym_uid'];
				$user_id = htmlspecialchars($ymUserID);
			}

			$meta_data = $order->get_meta_data();
			$source = '';
			$medium = '';
			$campaign = '';

			foreach ($meta_data as $meta) {
				if (strpos($meta->key, '_utm_source')) {
					$source = $meta->value;
				}
				if (strpos($meta->key, '_utm_medium')) {
					$medium = $meta->value;
				}
				if (strpos($meta->key, '_utm_campaign')) {
					$campaign = $meta->value;
				}
			}

			// echo '<pre>';
			// // print_r($order->get_meta_data());
			// // print_r(get_post_meta($order->get_id(), '_utm_source', true));
			// // print_r($order->get_meta_data());
			// $order_id = $product->get_id(); // ID заказа
			// // $order = wc_get_order($order_id);
			// // Получение всех метаданных заказа
			// $meta_data = $order->get_meta_data();
			// foreach ($meta_data as $meta) {
			// 	if (strpos($meta->key, '_utm_source') || strpos($meta->key, '_utm_medium') || strpos($meta->key, '_utm_campaign')) {
			// 		echo 'Ключ: ' . $meta->key . '<br>';
			// 		echo 'Значение: ' . $meta->value . '<br>';
			// 	}
			// }
			// echo '</pre>';

			// Формируем массив данных заказа
			$order_data = [
				'userid' => $user_id,
				'order_id' => $order->get_id(),
				'name' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
				'phone' => $order->get_billing_phone(),
				'email' => $order->get_billing_email(),
				'delivery_type' => $delivery_type,
				'address' => $address,
				'comment' => ($order->get_meta('billing_rev') != '') ? $order->get_meta('billing_rev') : '',
				'delivery_time' => $order->get_meta('billing_deliverymethod_date') . ', ' . $order->get_meta('billing_deliverymethod_time'),
				'payment_type' => $payment_type,
				'source' => $source,
				'medium' => $medium,
				'campaign' => $campaign,
				// 'total' => $order->get_total(),
				// 'currency' => $order->get_currency(),
				'basket' => [],
			];

			// Добавляем информацию о товарах
			foreach ($order->get_items() as $item_id => $item) {
				$product = $item->get_product();
				$order_data['basket'][] = [
					'id' => $product->get_id(),
					'name' => $product->get_title(),
					'price' => $item->get_subtotal(),
					'qty' => $item->get_quantity(),
					// 'total' => $item->get_total(),
				];
			}
			// echo '<pre>';
			// print_r($order->get_id());
			// echo '</pre>';




			// $response = wp_remote_post('https://webhook.site/9c3d88cb-1e46-45ff-9342-a5ffcb900c9e', [
			$response = wp_remote_post('https://business-tool.site/projects/ohpirogi/new.order.php', [
				'method' => 'POST',
				'body' => json_encode($order_data),
				'headers' => ['Content-Type' => 'application/json'],
			]);




			if (is_wp_error($response)) {
				error_log('Ошибка отправки: ' . $response->get_error_message());
			} else {
				error_log('Успешный ответ: ' . wp_remote_retrieve_body($response));
			}
		}









		?>

		<?php // do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); 
			?>
		<?php // do_action('woocommerce_thankyou', $order->get_id()); 
			?>

	<?php else: ?>

		<?php wc_get_template('checkout/order-received.php', array('order' => false)); ?>

	<?php endif; ?>

	<!--    Отправка данных в метрику о покупке-->

	<?php if ($order): ?>
		<script>
			var dataLayer = window.dataLayer || [];
			dataLayer.push({
				"ecommerce": {
					"currencyCode": "RUB",
					"purchase": {
						"actionField": {
							"id": "<?php echo $order->get_order_number(); ?>" // ID заказа
						},
						"products": [
							<?php foreach ($order->get_items() as $item):
								$product = $item->get_product(); ?> {
									"id": "<?php echo $product->get_id(); ?>",
									"name": "<?php echo $product->get_name(); ?>",
									"price": "<?php echo $product->get_price() ?>",
									"quantity": "<?php echo $item->get_quantity(); ?>"
								},
							<?php endforeach; ?>
						]
					}
				}
			});
		</script>
	<?php endif; ?>
	<!--    Отправка данных в метрику о покупке END-->

</div>