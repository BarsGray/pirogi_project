<?php

/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if (!defined('ABSPATH')) {
	exit;
}

function remove_product_category_breadcrumb($crumbs)
{
	foreach ($crumbs as $key => $crumb) {
		if (str_contains($crumb[1], '/pirogi/')) {

			unset($crumbs[$key]);
		}
	}
	return $crumbs;
}


if (!empty($breadcrumb)) {
	$breadcrumb_b = remove_product_category_breadcrumb($breadcrumb);

	echo $wrap_before;
	foreach ($breadcrumb_b as $key => $crumb) {
		echo $before;

		if (!empty($crumb[1]) && sizeof($breadcrumb) !== $key + 1) {
			echo '<a href="' . esc_url($crumb[1]) . '">' . esc_html($crumb[0]) . '</a>';
		} else {
			echo esc_html($crumb[0]);
		}
		echo $after;

		if (sizeof($breadcrumb) !== $key + 1) {
			echo $delimiter;
		}
		// echo '<pre>';
		// var_dump($breadcrumb);
		// echo '</pre>';
	}
	echo $wrap_after;
}
