<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;
$GLOBALS['id_pro_carrent'] = $post->ID;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div class="info_btn_kbzu">
	<div class="table_kbzu_wrapper">
		<table class="table_kbzu">
			<caption>Энергетическая ценность (на 100 грамм)</caption>
			<tbody>
				<tr class="table_kbzu_row">
					<th class="table_kbzu_td_head">Калорийность</th>
					<td class="table_kbzu_td"><?php echo carbon_get_post_meta($GLOBALS['id_pro_carrent'], 'crb_product_ccal'); ?></td>
				</tr>
				<tr class="table_kbzu_row">
					<th class="table_kbzu_td_head">Белки</th>
					<td class="table_kbzu_td"><?php echo carbon_get_post_meta($GLOBALS['id_pro_carrent'], 'crb_product_belki'); ?></td>
				</tr>
				<tr class="table_kbzu_row">
					<th class="table_kbzu_td_head">Жиры</th>
					<td class="table_kbzu_td"><?php echo carbon_get_post_meta($GLOBALS['id_pro_carrent'], 'crb_product_zhiri'); ?></td>
				</tr>
				<tr class="table_kbzu_row">
					<th class="table_kbzu_td_head">Углеводы</th>
					<td class="table_kbzu_td"><?php echo carbon_get_post_meta($GLOBALS['id_pro_carrent'], 'crb_product_uglev'); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<img class="product_information" src="<?php bloginfo('template_url'); ?>/assets/images/product/information.svg" alt="information">
</div>

<div class="btn-back-holder">
	<a class="btn-back" href="<?php echo (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : home_url() . '/catalog/'; ?>"></a>
</div>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('product_display', $product); ?>>
	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action('woocommerce_before_single_product_summary');
	?>

	<div class="summary entry-summary about_product">
		<?php $GLOBALS['id_pro_carrent'] = $post->ID;

		?>
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action('woocommerce_single_product_summary');
		?>
	</div>
</div>

<?php
/**
 * Hook: woocommerce_after_single_product_summary.
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */
// echo '</div>';
do_action('woocommerce_after_single_product_summary');
?>

<?php do_action('woocommerce_after_single_product'); ?>