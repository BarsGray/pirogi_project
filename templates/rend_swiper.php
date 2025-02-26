<?php
if (!defined('ABSPATH')) {
  exit;
}
add_shortcode('my_product_slider', 'truemisha_shortcode_callback');

function truemisha_shortcode_callback($atts)
{

  // Получение объекта корзины
  $cart = WC()->cart;
  // Получение товаров в корзине
  $product_id_in_cart = [];
  if ($cart) {

    $cart_items = $cart->get_cart();
    // Перебор товаров в корзине
    foreach ($cart_items as $cart_item) {
      // Получение ID товара
      $product_id_in_cart[] = $cart_item['product_id'];
    }
  }

  if (is_product()) {
    // Это страница товара
    $product_id_in_cart[] = get_the_ID();
  }

  $params = shortcode_atts(
    array(
      'product_category' => '',
      'order' => '',
      'autoplay' => '',
    ),
    $atts
  );

  ob_start();

  // Получить категорию по слагу
  // $category_slug = $params['product_category'];
  // $category = get_term_by('slug', $category_slug, 'product_cat');
  // echo ($category) ? $category->name : 'Популярные пироги'; 

?>
  <div class="rendSwiper_box">
    <?php
    if (isset($GLOBALS['id_pro_carrent'])) {
      echo '<h2 class="rendSwiper_title">' . carbon_get_post_meta((isset($GLOBALS['id_pro_carrent'])) ? $GLOBALS['id_pro_carrent'] : '', 'crb_product_slider_title') . '</h2>';
    }



    $categories_list = [];
    $id_posts_arr = [];

    $order_vel = $params['order'];
    $orderby_vel = 'meta_value_num';
    $product_cat_vel = $params['product_category'];

    if ($params['order'] == 0) {
      $order_vel = 'ASC';
    } else if ($params['order'] == 1) {
      $order_vel = 'DESC';
    } else if ($params['order'] == 2) {
      $order_vel = '';
      $orderby_vel = 'rand';
    }

    if ($params['order'] == 40 || $params['order'] == 41 || $params['order'] == 42) {

      $product_cat_vel = '';
      if ($params['order'] == 40) {
        $order_vel = 'ASC';
      } else if ($params['order'] == 41) {
        $order_vel = 'DESC';
      } else if ($params['order'] == 42) {
        $order_vel = '';
        $orderby_vel = 'rand';
      }


      $get_categories_product = get_terms('product_cat', [
        'orderby' => 'name', // Поле для сортировки
        'order' => 'ASC', // Направление сортировки
        'hide_empty' => 1, // Скрывать пустые (1 - да, 0 - нет)
      ]);

      if (count($get_categories_product) > 0) {
        foreach ($get_categories_product as $categories_item) {
          $categories_list[] = $categories_item->slug;
        }
      }

      foreach ($categories_list as $categories_list_get_item) {

        $args = array(
          'post_type'      => 'product',
          'posts_per_page' => 1, // -1 для вывода всех товаров, можно указать конкретное количество
          'product_cat'    => $categories_list_get_item, // Замените 'your-category-slug' на slug нужной категории
          'meta_key'       => 'total_sales', // Мета-ключ для количества продаж
          'orderby'        => 'meta_value_num', // Сортировка по числовому значению мета-ключа
        );

        $loop = new WP_Query($args);

        if ($loop->have_posts()) {
          while ($loop->have_posts()) : $loop->the_post();

            global $product;
            $id_posts_arr[$product->get_total_sales()] = get_the_ID();

          endwhile;
        } else {
          echo __('No products found');
        }
      }
    }
    ?>



    <div class="rendSwiper">
      <div class="swiper-wrapper">
        <?php
        wp_reset_postdata();

        $args = array(
          'post_type'      => 'product',
          'post__in'       => $id_posts_arr,
          'posts_per_page' => -1, // -1 для вывода всех товаров, можно указать конкретное количество
          'product_cat'    => $product_cat_vel, // Замените 'your-category-slug' на slug нужной категории
          'meta_key'       => 'total_sales', // Мета-ключ для количества продаж
          'orderby'        => $orderby_vel, // Сортировка по числовому значению мета-ключа, meta_value_num : rand
          'order'          => $order_vel, //  ASC : DESC
        );

        $loop = new WP_Query($args);

        if ($loop->have_posts()) {;
          while ($loop->have_posts()) : $loop->the_post();
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
            <div class="swiper-slide">
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
            </div>
        <?php
          endwhile;
        } else {
          echo __('No products found');
        }
        wp_reset_postdata();
        ?>
      </div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
    <script>
      jQuery(document).ready(function($) {
        var swiper = new Swiper(".rendSwiper", {
          slidesPerView: 4,
          // centeredSlides: false,
          // centeredSlidesBounds: false,
          spaceBetween: 40,
          slidesPerGroup: 4,
          loop: true,
          loopAddBlankSlides: true,
          navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
          },
          breakpoints: {
            992: {
              slidesPerView: 4,
              slidesPerGroup: 4,
            },
            768: {
              slidesPerView: 2,
              slidesPerGroup: 2,
            },
            320: {
              slidesPerView: 1,
              slidesPerGroup: 1,
            }
          },
          <?php
          if ($params['autoplay'] != '') {
            echo "
              autoplay: {
                delay: {$params['autoplay']}000,
                stopOnLastSlide: false,
                disableOnInteraction: false
              }";
          }
          ?>
        });
      });
    </script>
  </div>
<?php
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}
?>