<?php

/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
$user_id = get_current_user_id();
// $phone_number = get_user_meta($user_id, 'billing_phone', true);
$user_meta = get_user_meta($user_id);
?>

<?php do_action('woocommerce_edit_account_form_start'); ?>

<div class="my_account_data_wrapper">

	<table class="my_account_data_table">
		<thead>
			<tr>
				<th>Личные данные</th>
				<th>
					<a href="<?php echo esc_url(wc_get_endpoint_url('edit-address', 'billing')); ?>" class="edit"><?php echo wc_get_account_formatted_address('billing') ? esc_html__('Edit', 'woocommerce') : esc_html__('Add', 'woocommerce'); ?></a>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr class="my_account_bonuses">
				<td>Ваши бонусы</td>
				<td><?php echo get_user_meta($user_id, 'bonuss', true) ? get_user_meta($user_id, 'bonuss', true) : '&mdash;'; ?></td>
			</tr>
			<tr class="my_account_registered_date">
				<td>Дата регистрации</td>
				<td><?php echo date('d.m.Y', strtotime($current_user->user_registered)); ?></td>
				</t>
			<tr class="my_account_first_name">
				<td>Имя</td>
				<td><?php echo esc_attr($current_user->first_name); ?></td>
				<?php
				// echo '<pre>';
				// var_dump(get_user_meta($user_id));
				// echo '</pre>';
				?>
				<!-- <td><?php // echo get_user_meta($user_id, 'billing_name', true) ? get_user_meta($user_id, 'billing_name', true) : '&mdash;'; 
									?></td> -->
			</tr>
			<tr class="my_account_phone">
				<td>Телефон</td>
				<td><?php echo get_user_meta($user_id, 'billing_phone', true) ? get_user_meta($user_id, 'billing_phone', true) : '&mdash;'; ?></td>
			</tr>
			<tr class="my_account_my_email">
				<td>E-mail</td>
				<td><?php echo esc_attr($current_user->user_email); ?></td>
			</tr>
			<tr class="my_account_my_date">
				<td>Дата рождения</td>
				<td><?php echo (get_user_meta($user_id, 'date_of_birth', true)) ? get_user_meta($user_id, 'date_of_birth', true) : '&mdash;'; ?></td>
			</tr>
			<tr class="my_account_street">
				<td>Улица</td>
				<td><?php echo (get_user_meta($user_id, 'billing_address_1', true)) ? get_user_meta($user_id, 'billing_address_1', true) : '&mdash;'; ?></td>
			</tr>
			<tr class="my_account_home">
				<td>Дом</td>
				<td><?php echo (get_user_meta($user_id, 'billing_address_2', true)) ? get_user_meta($user_id, 'billing_address_2', true) : '&mdash;'; ?></td>
			</tr>
			<tr class="my_account_appartment_number">
				<td>Квартира</td>
				<td><?php echo (get_user_meta($user_id, 'apartment', true)) ? get_user_meta($user_id, 'apartment', true) : '&mdash;'; ?></td>
			</tr>
			<tr class="my_account_number_entrance">
				<td>Подъезд</td>
				<td><?php echo (get_user_meta($user_id, 'entrance', true)) ? get_user_meta($user_id, 'entrance', true) : '&mdash;'; ?></td>
			</tr>
			<tr class="my_account_number_floor">
				<td>Этаж</td>
				<td><?php echo (get_user_meta($user_id, 'floor', true)) ? get_user_meta($user_id, 'floor', true) : '&mdash;'; ?></td>
			</tr>
			<!-- <tr class="my_account_method_delivery">
				<td>Способ доставки</td>
				<td><?php // echo 'Курьер'; 
						?></td>
			</tr>
			<tr class="my_account_method_billing">
				<td>Способ оплаты</td>
				<td><?php // echo 'Наличными'; 
						?></td>
			</tr> -->
		</tbody>
	</table>

</div>


<pre>
	<?php // var_dump($current_user); 
	?>
</pre>
<pre>
	<?php // var_dump($user_meta); 
	?>
</pre>




<?php

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);
?>

<!-- <p>
	<?php
	// printf(
	// 	/* translators: 1: user display name 2: logout url */
	// 	wp_kses(__('Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce'), $allowed_html),
	// 	'<strong>' . esc_html($current_user->display_name) . '</strong>',
	// 	esc_url(wc_logout_url())
	// );
	?>
</p>

<p>
	<?php
	// /* translators: 1: Orders URL 2: Address URL 3: Account URL. */
	// $dashboard_desc = __('From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">billing address</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce');
	// if (wc_shipping_enabled()) {
	// 	/* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
	// 	$dashboard_desc = __('From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce');
	// }
	// printf(
	// 	wp_kses($dashboard_desc, $allowed_html),
	// 	esc_url(wc_get_endpoint_url('orders')),
	// 	esc_url(wc_get_endpoint_url('edit-address')),
	// 	esc_url(wc_get_endpoint_url('edit-account'))
	// );
	?>
</p> -->

<?php
/**
 * My Account dashboard.
 *
 * @since 2.6.0
 */
do_action('woocommerce_account_dashboard');

/**
 * Deprecated woocommerce_before_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_before_my_account');

/**
 * Deprecated woocommerce_after_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_after_my_account');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
