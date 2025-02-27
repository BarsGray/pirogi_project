<?php
add_filter('woocommerce_add_to_cart_fragments', 'ohpirogi_woocommerce_cart_link_fragment');

if (!function_exists('ohpirogi_woocommerce_cart_link')) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function ohpirogi_woocommerce_cart_link()
	{
?>
		<a class="icon cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'ohpirogi'); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n('%d', '%d', WC()->cart->get_cart_contents_count(), 'ohpirogi'),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="cart_img"></span>
			<img src="<?php bloginfo('template_url') ?>/assets/images/mobile/shopping.png" alt="">
			<?php
			if ($item_count_text > 0) {
			?>
				<span class="count"><?php echo esc_html($item_count_text); ?></span>
				<span class="amount">
					<?php
					$cost_len = strlen(wp_kses_data(WC()->cart->get_cart_subtotal()));

					if ($cost_len == 17) {
						echo substr(wp_kses_data(WC()->cart->get_cart_subtotal()), 0, 1) . ' ' . substr(wp_kses_data(WC()->cart->get_cart_subtotal()), 1, -1);
					} else if ($cost_len == 18) {
						echo substr(wp_kses_data(WC()->cart->get_cart_subtotal()), 0, 2) . ' ' . substr(wp_kses_data(WC()->cart->get_cart_subtotal()), 2, -1);
					} else {
						echo wp_kses_data(WC()->cart->get_cart_subtotal());
					}
					?>
				</span>
			<?php
			} else {
				echo '<span class="amount amount_cart">Корзина</span>';
			}
			?>
		</a>


	<?php
	}
}
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

if (!function_exists('ohpirogi_woocommerce_cart_link_footer')) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function ohpirogi_woocommerce_cart_link_footer()
	{
	?>
		<!-- <div class="mobile_card_btn"> -->
			<a class="icon mobile_card_btn cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'ohpirogi'); ?>">
				<?php
				$item_count_text = sprintf(
					/* translators: number of items in the mini cart. */
					_n('%d', '%d', WC()->cart->get_cart_contents_count(), 'ohpirogi'),
					WC()->cart->get_cart_contents_count()
				);
				?>
				<!-- <span class="cart_img"></span> -->
				<?php
				if ($item_count_text > 0) {
				?>
					<!-- <span class="count"><?php // echo esc_html($item_count_text); ?></span> -->
					<!-- <span class="amount">
						<?php
						// $cost_len = strlen(wp_kses_data(WC()->cart->get_cart_subtotal()));

						// if ($cost_len == 17) {
						// 	echo substr(wp_kses_data(WC()->cart->get_cart_subtotal()), 0, 1) . ' ' . substr(wp_kses_data(WC()->cart->get_cart_subtotal()), 1, -1);
						// } else if ($cost_len == 18) {
						// 	echo substr(wp_kses_data(WC()->cart->get_cart_subtotal()), 0, 2) . ' ' . substr(wp_kses_data(WC()->cart->get_cart_subtotal()), 2, -1);
						// } else {
						// 	echo wp_kses_data(WC()->cart->get_cart_subtotal());
						// }
						?>
					</span> -->
				<?php
				}
				?>
				<img src="<?php bloginfo('template_url') ?>/assets/images/mobile/shopping.png" alt="">
			</a>
		<!-- </div> -->
		<p class="mobile_name"><?php echo ($item_count_text > 0) ? wp_kses_data(WC()->cart->get_cart_subtotal()) : 'Корзина'; ?></p>


	<?php
	}
}
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

if (!function_exists('ohpirogi_woocommerce_header_cart')) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function ohpirogi_woocommerce_header_cart()
	{
		if (is_cart()) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
	?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr($class); ?>">
				<?php ohpirogi_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget('WC_Widget_Cart', $instance);
				?>
			</li>
		</ul>
<?php
	}
}
