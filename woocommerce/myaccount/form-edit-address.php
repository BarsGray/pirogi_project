<?php

/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

$page_title = ('billing' === $load_address) ? esc_html__('Billing address', 'woocommerce') : esc_html__('Shipping address', 'woocommerce');

do_action('woocommerce_before_edit_account_address_form'); ?>

<?php if (!$load_address) : ?>
	<?php wc_get_template('myaccount/my-address.php'); ?>
<?php else : ?>

	<form class="edit_my_addres_form" method="post">

		<h3>Изменить личные данные</h3>
		<?php // echo get_user_meta(get_current_user_id(), 'entrance', true); 
		?>

		<div class="woocommerce-address-fields woocommerce-billing-fields">
			<?php do_action("woocommerce_before_edit_address_form_{$load_address}"); ?>

			<div class="woocommerce-address-fields__field-wrapper">
				<?php
				foreach ($address as $key => $field) {
					if ($key == 'billing_rev' || $key == 'billing_deliverymethod' || $key == 'billing_deliverymethod_date_pay1' || $key == 'billing_country' || $key == 'billing_deliverymethod_time' || $key == 'billing_deliverymethod_date'  || $key == 'billing_wooccm12' || $key == 'billing_bonuss' || $key == 'billing_email') {
						continue;
					}
					if ($key == 'billing_floor') {
						$field['value'] = $field['default'];
					}
					if ($key == 'billing_entrance') {
						$field['value'] = $field['default'];
					}
					if ($key == 'billing_apartment') {
						$field['value'] = $field['default'];
					}
					if ($key == 'date_of_birth' && get_user_meta(get_current_user_id(), 'date_of_birth', true) != '') {
						// if (get_user_meta(get_current_user_id(), 'billing_birthday', true) != '') {
						continue;
						// }
					}
					if ($key == 'billing_address_2') {
						$field['label_class'] = '';
					}
					woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value']));
					// echo $key . '<br>';
					// echo $field . '<br>';
				}
				?>
			</div>

			<?php do_action("woocommerce_after_edit_address_form_{$load_address}"); ?>

			<p>
				<!-- <button type="submit" class="button<?php // echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); 
																								?>" name="save_address" value="<?php // esc_attr_e('Save address', 'woocommerce'); 
																																								?>"><?php // esc_html_e('Save address', 'woocommerce'); 
																																										?></button> -->
				<button type="submit" class="woocommerce-Button button" name="save_username_address" value="<?php esc_attr_e('Save Changes', 'woocommerce'); ?>"><?php esc_html_e('Сохранить', 'woocommerce'); ?></button>
				<?php wp_nonce_field('woocommerce-edit_address', 'woocommerce-edit-address-nonce'); ?>
				<input type="hidden" name="action" value="edit_address" />
			</p>
		</div>

	</form>
	<?php
	// $user = wp_get_current_user();
	// $billing_address_1 = get_user_meta($user->ID, 'billing_address_1', true);
	// $billing_address_2 = get_user_meta($user->ID, 'billing_address_2', true);
	?>
	<!-- 
	<h3><?php // _e('Change Username and Address', 'woocommerce'); 
			?></h3>
	<form method="post" id="change-username-address-form">
		<?php // wp_nonce_field('save_custom_username_address', 'custom_username_address_nonce'); 
		?>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="username"><?php // _e('Username', 'woocommerce'); 
														?> <span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php // echo esc_attr($user->user_login); 
																																																														?>" required />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="billing_address_1"><?php // _e('Улица', 'woocommerce'); 
																			?></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_address_1" id="billing_address_1" value="<?php // echo esc_attr($billing_address_1); 
																																																																							?>" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="billing_address_2"><?php // _e('Квартира', 'woocommerce'); 
																			?></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_city" id="billing_city" value="<?php // echo esc_attr($billing_address_2); 
																																																																		?>" />
		</p>
		<p>
			<button type="submit" class="woocommerce-Button button" name="save_username_address" value="<?php // esc_attr_e('Save Changes', 'woocommerce'); 
																																																	?>"><?php // esc_html_e('Save Changes', 'woocommerce'); 
																																																			?></button>
		</p>
	</form> -->

<?php endif; ?>

<?php do_action('woocommerce_after_edit_account_address_form'); ?>