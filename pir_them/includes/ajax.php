<?php
if (!defined('ABSPATH')) {
  exit;
}

add_action('wp_ajax_search-ajax', 'search_ajax_action_callback');
add_action('wp_ajax_nopriv_search-ajax', 'search_ajax_action_callback');

function search_ajax_action_callback()
{

  if (!wp_verify_nonce($_POST['nonce'], 'search-nonce')) {
    wp_die('Данные отправлены с левого адреса!!!');
  }

  $arg  = array(
    'post_type' => array('post', 'product'),
    'post_status' => 'publish',
    's' => $_POST['s']
  );

  $query_ajax = new WP_Query($arg);
  // $json_data['out'] = ob_start(PHP_OUTPUT_HANDLER_CLEANABLE);
  ob_start();
?>
  <div class="search_box">
    <ul class="cearch_product product_block products columns-4">
      <?php
      if ($query_ajax->have_posts()) {
        while ($query_ajax->have_posts()) : $query_ajax->the_post(); ?>
          <li class="product">
            <div class="product_item">
              <div class="product_img">
                <a href="<?php the_permalink(); ?>">
                  <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail(); ?>
                  <?php else : ?>
                    <img width="50px" src="<?php echo get_template_directory_uri() ?>/assets/img/nonebg.png">
                  <?php endif; ?>
                  <?php
                  // global $product;
                  // $total_sales = $product->get_total_sales();
                  // echo "Количество продаж товара: " . $total_sales . '<br>';
                  ?>
                </a>
              </div>
              <div class="product_left">
                <h2 class="woocommerce-loop-product__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php woocommerce_template_single_excerpt(); ?>
                <div class="product_bottom">
                  <?php
                  woocommerce_template_loop_price();
                  woocommerce_template_loop_add_to_cart();
                  ?>
                </div>
              </div>
            </div>
          </li>
      <?php
        endwhile;
      } else {
        echo __('<p calss="dont_found_product_element">Товаров не найдено</p>');
      }
      ?>
    </ul>
  </div>
<?php

  $json_data = ob_get_contents();
  ob_end_clean();
  echo $json_data;
  wp_die();
}
