<?php
if (!defined('ABSPATH')) {
  exit;
}
add_shortcode('my_product_top_ten', 'truemisha_shortcode_callback_top');

function truemisha_shortcode_callback_top($atts)
{
  if (!is_admin()) {

    // Получение объекта корзины
    $cart = WC()->cart;
    // Получение товаров в корзине
    $cart_items = $cart->get_cart();
    $product_id_in_cart = [];
    // Перебор товаров в корзине
    foreach ($cart_items as $cart_item) {
      // Получение ID товара
      $product_id_in_cart[] = $cart_item['product_id'];
    }


    $params = shortcode_atts(
      array(
        'title' => '',
      ),
      $atts
    );

    ob_start();

    // Получить категорию по слагу
    // $category_slug = $params['product_category'];
    // $category = get_term_by('slug', $category_slug, 'product_cat');
    // echo ($category) ? $category->name : 'Популярные пироги'; 

?>
    <div class="top_ten_box">
      <?php
      // if (isset($GLOBALS['id_pro_carrent'])) {
      // echo '<h2 class="top_ten_box_title">' . $params['title'] . '</h2>';
      // }
      ?>
      <h2 class="top_ten_box_title"><?= $params['title']; ?></h2>


      <ul class="topTenProduct product_block products columns-4">
        <?php
        wp_reset_postdata();

        $args = array(
          'post_type'      => 'product',
          'posts_per_page' => 10, // -1 для вывода всех товаров, можно указать конкретное количество
          // 'product_cat'    => $product_cat_vel, // Замените 'your-category-slug' на slug нужной категории
          'meta_key'       => 'total_sales', // Мета-ключ для количества продаж
          'orderby'        => 'meta_value_num', // Сортировка по числовому значению мета-ключа, meta_value_num : rand
        );

        $loop = new WP_Query($args);

        if ($loop->have_posts()) {
          while ($loop->have_posts()) : $loop->the_post(); ?>

            <?php
            $cheack_in_rat = false;
            foreach ($product_id_in_cart as $product_id_item) {
              if ($product_id_item == get_the_ID()) {
                $cheack_in_rat = true;
              }
            }
            if ($cheack_in_rat == true) {
              continue;
            }
            ?>

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
          echo __('No products found');
        }
        wp_reset_postdata();
        ?>
      </ul>
    </div>
<?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
  }
}
?>