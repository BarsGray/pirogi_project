<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Документ без названия</title>
</head>

<body>
	<table
		style="color:#1d1d1f;font-family:'roboto condensed' , 'verdana' , sans-serif; width:100%; font-size: 20px; padding: 0; margin: 0; line-height: 1">
		<tbody>
			<tr>
				<td style="vertical-align: top; padding: 0;">
					<table>
						<tr>
							<td bgcolor="#3a393e" style="color:#fff; font-size: 20px; padding: 10px 20px; margin: 0; line-height: 1">
								Заказ #<?php echo $order->get_order_number(); ?></td>
							<td align="right" bgcolor="#3a393e"
								style="color:#fff; font-size: 20px; padding: 10px 20px; margin: 0; line-height: 1">
								<?php echo $order->get_date_created()->date('d.m.Y ( H:i )'); ?>
							</td>
						</tr>
						<tr>
							<td colspan="2" bgcolor="#37b5c4" style="padding: 0;">
								<p style="color:#fff; font-size: 30px; padding: 10px 20px 0; margin: 0; line-height: 1">
									<?php echo $order->get_billing_first_name(); ?>
								</p>
								<p
									style="color:#fff; font-size: 30px; padding: 0px 20px 10px; margin: 0; line-height: 1; font-weight: bold">
									<?php echo $order->get_billing_phone(); ?>
								</p>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding: 0;">

								<table border="0" align="left"
									style="font-size: 20px; padding: 0; margin: 20px 0; line-height: 1; width: 530px">
									<tbody>
										<tr>
											<th align="left"
												style="font-size: 20px; padding: 10px 10px 10px 0; margin: 0; line-height: 1; text-align: left">
												Тип доставки</th>
											<td align="left"
												style="font-size: 20px; padding: 10px 0px; margin: 0; line-height: 1; text-align: left">
												<?php
												if ($order->get_meta('billing_deliverymethod') == 'kurer') {
													echo 'Курьер';
												} else if ($order->get_meta('billing_deliverymethod') == 'samovivoz') {
													echo 'Самовывоз';
													// echo 'Самовывоз (' . carbon_get_theme_option('crb_address_header') . ')';
												}
												?>
											</td>
										</tr>
										<?php if ($order->get_meta('billing_deliverymethod') == 'kurer'): ?>
											<tr>
												<th align="left"
													style="font-size: 20px; padding: 10px 10px 10px 0; margin: 0; line-height: 1; text-align: left; width: 190px">
													Адрес доставки</th>
												<td align="left"
													style="font-size: 20px; padding: 10px 0px; margin: 0; line-height: 1; text-align: left">
													<?php echo $order->get_billing_address_1(); ?>, д.
													<?php echo $order->get_billing_address_2(); ?>
													<?php
													echo ($order->get_meta('billing_apartment') != '') ? ', кв.' . $order->get_meta('billing_apartment') : '';
													echo ($order->get_meta('billing_floor') != '') ? ', эт.' . $order->get_meta('billing_floor') : '';
													echo ($order->get_meta('billing_entrance') != '') ? ', подъезд ' . $order->get_meta('billing_entrance') : '';
													?>
												</td>
											</tr>
										<?php elseif ($order->get_meta('billing_deliverymethod') == 'samovivoz'): ?>
											<tr>
												<th align="left"
													style="font-size: 20px; padding: 10px 10px 10px 0; margin: 0; line-height: 1; text-align: left; width: 190px">
													Адрес получения</th>
												<td align="left"
													style="font-size: 20px; padding: 10px 0px; margin: 0; line-height: 1; text-align: left">
													<?php echo carbon_get_theme_option('crb_address_header'); ?>
												</td>
											</tr>
										<?php endif; ?>
										<tr>
											<th align="left"
												style="font-size: 20px; padding: 10px 0px; margin: 0; line-height: 1; text-align: left">Время
												<?php
												if ($order->get_meta('billing_deliverymethod') == 'kurer') {
													echo 'доставки';
												} else if ($order->get_meta('billing_deliverymethod') == 'samovivoz') {
													echo 'cамовывоза';
												}
												?>
											</th>
											<td align="left"
												style="font-size: 20px; padding: 10px 0px; margin: 0; line-height: 1; text-align: left">
												<?php echo $order->get_meta('billing_deliverymethod_date'); ?>,
												<?php echo $order->get_meta('billing_deliverymethod_time'); ?>
											</td>
										</tr>
										<tr>
											<th align="left"
												style="font-size: 20px; padding: 10px 10px 10px 0; margin: 0; line-height: 1; text-align: left">
												Способ оплаты</th>
											<td align="left"
												style="font-size: 20px; padding: 10px 0px; margin: 0; line-height: 1; text-align: left">
												<?php
												if ($order->get_meta('billing_deliverymethod_date_pay1') == 'cash') {
													echo 'Наличными';
												} else if ($order->get_meta('billing_deliverymethod_date_pay1') == 'pay') {
													echo 'Картой';
												}
												?>
											</td>
										</tr>
										<tr>
											<th align="left"
												style="font-size: 25px; padding: 10px 0px; margin: 0; line-height: 1; text-align: left">
												Комментарий</th>
											<td align="left"
												style="font-size: 25px; padding: 10px 10px; margin: 0; line-height: 1; text-align: left">
												<?php echo ($order->get_meta('billing_rev')) ? $order->get_meta('billing_rev') : '&#8722'; ?>
											</td>
										</tr>
									</tbody>
								</table>




							</td>
						</tr>
						<tr>
							<td style="font-size: 19px; padding: 0 20px 7px;">

								<?php

								$order_price_real = 0;
								$order_price_spisanie = 0;

								foreach ($order->get_items() as $itemx) {
									$product_idx = $itemx->get_product_id();

									if (wc_get_product($product_idx)->is_type('variable')) {
										$order_price_real += $itemx['quantity'] * wc_get_product($itemx['variation_id'])->get_price();
									} else {
										$order_price_real += $itemx['quantity'] * wc_get_product($product_idx)->get_price();
									}
								}

								$order_price_spisanie = $order_price_real - $order->get_total();
								echo ($order_price_spisanie > 0) ? 'К оплате: <strong>' . $order_price_real . ' руб.</strong>' : '';
								?>

							</td>
						</tr>
						<tr>
							<td style="font-size: 19px; padding: 7px 20px 15px;">
								<?php
								echo ($order_price_spisanie > 0) ? 'Списано бонусов: <strong>' . $order_price_spisanie . ' руб.</strong>' : '';
								?>
							</td>
						</tr>
						<tr>
							<td colspan="2" bgcolor="#FFF974"
								style="font-size: 30px; padding: 10px 20px; margin: 20px 0 0; line-height: 1">Итого:
								<strong><?php echo $order->get_total(); ?> руб.</strong>
							</td>
						</tr>
					</table>










					<table border="0" style="margin-top:20px">
						<tbody>
							<?php foreach ($order->get_items() as $item) {
								$mini_cheack = 0;
								$product_id = $item->get_product_id();
								?>
								<tr>
									<td
										style="vertical-align: middle; text-align: center; font-size: 60px; border-bottom: 1px solid #1d1d1f; padding: 10px 20px">
										<?php echo $item['quantity']; ?>
										<!-- 1 -->
									</td>
									<td style="vertical-align: middle; border-bottom: 1px solid #1d1d1f; padding: 0">
										<!-- <img style="display:block;" src="https://ohpirogi.ru/wp-content/uploads/2024/05/bolgarskij-pirog.webp"> -->
										<?php
										// echo apply_filters('woocommerce_cart_item_thumbnail', wc_get_product($product_id)->get_image(), $item);
										// echo wc_get_product($product_id)->get_image();
										
										$image_id_now_product = wc_get_product($product_id)->get_image_id();
										$image_url = wp_get_attachment_url($image_id_now_product);
										
										echo '<img width="250" height="155" src="' . esc_url($image_url) . '" class="v1attachment-woocommerce_thumbnail v1size-woocommerce_thumbnail" style="border: none; display: inline-block; font-size: 14px; font-weight: bold; height: auto; outline: none; text-decoration: none; text-transform: capitalize; vertical-align: middle; margin-right: 10px; max-width: 100%" border="0">';
										?>
									</td>
									<td style="vertical-align: top; border-bottom: 1px solid #1d1d1f; padding: 0">
										<table width="100%" border="0">
											<tbody>
												<tr>
													<td style="font-size: 20px; padding: 0">
														<?php

														if (wc_get_product($product_id)->is_type('variable')) {

															foreach (get_the_terms($product_id, 'product_cat') as $item_term) {
																if (strpos($item_term->slug, 'mini') === 0) {
																	if (wc_price(wc_get_product($item['variation_id'])->get_price()) == wc_price(wc_get_product($product_id)->get_price())) {
																		$mini_cheack = 1;
																	}
																} else {
																	if (wc_price(wc_get_product($item['variation_id'])->get_price()) != wc_price(wc_get_product($product_id)->get_price())) {
																		$mini_cheack = 0;
																	}
																}
															}
														}
														if ($mini_cheack == 1) {
															echo '<span style="background: #f00; padding: 10px 20px; color: #fff; font-weight: bold;margin:0 20px 0 0; display: inline-block">МИНИ</span>';
														}
														echo wc_get_product($product_id)->get_name();
														?>
													</td>
												</tr>
												<tr>
													<td style="font-size: 16px; padding: 10px 0 20px">
														<?php
														if (wc_get_product($product_id)->is_type('variable')) {
															echo wc_get_product($item['variation_id'])->get_attribute_summary();
														}
														?>
														<!-- 16 см. 400 гр. -->
													</td>
												</tr>
												<tr>
													<td style="font-size: 20px; padding: 0">
														<?php
														if (wc_get_product($product_id)->is_type('variable')) {
															echo wc_price(wc_get_product($item['variation_id'])->get_price());
														} else {
															echo wc_price(wc_get_product($product_id)->get_price());
														}
														?>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							<?php } ?>




							<!-- <tr>
								<td style="vertical-align: middle; text-align: center; font-size: 60px; border-bottom: 1px solid #1d1d1f; padding: 10px 20px">2</td>
								<td style="vertical-align: middle; border-bottom: 1px solid #1d1d1f"><img width="300px" src="https://ohpirogi.ru/wp-content/uploads/2024/05/bolgarskij-pirog.webp"></td>
								<td style="vertical-align: top; border-bottom: 1px solid #1d1d1f">


									<table width="100%" border="0">
										<tbody>
											<tr>
												<td style="font-size: 30px">Болгарский пирог</td>
											</tr>
											<tr>
												<td style="font-size: 16px; padding: 10px 0 20px">26 см. 1000 гр.
												</td>
											</tr>
											<tr>
												<td style="font-size: 30px">930 ₽</td>
											</tr>
										</tbody>
									</table>



								</td>
							</tr>
							<tr>
								<td style="vertical-align: middle; text-align: center; font-size: 60px; border-bottom: 1px solid #1d1d1f; padding: 10px 20px">1</td>
								<td style="vertical-align: middle; border-bottom: 1px solid #1d1d1f"><img width="300px" src="https://ohpirogi.ru/wp-content/uploads/2024/05/bolgarskij-pirog.webp"></td>
								<td style="vertical-align: top; border-bottom: 1px solid #1d1d1f">


									<table width="100%" border="0">
										<tbody>
											<tr>
												<td style="font-size: 30px">Болгарский пирог</td>
											</tr>
											<tr>
												<td style="font-size: 16px; padding: 10px 0 20px">26 см. 1000 гр.
												</td>
											</tr>
											<tr>
												<td style="font-size: 30px">930 ₽</td>
											</tr>
										</tbody>
									</table>



								</td>
							</tr> -->
						</tbody>
					</table>



				</td>
				<td style="vertical-align:top; padding: 0;">


				</td>
			</tr>
		</tbody>
	</table>
</body>

</html>