<?php
if (!defined('ABSPATH')) {
  exit;
}

// add_action('woocommerce_before_single_product', 'pir_wrapper_product_start', 5);

function pir_wrapper_product_start()
{
  ?>
  <!-- <div class="container"> -->
  <?php
}

// add_action('woocommerce_after_single_product', 'pir_wrapper_product_end', 5);

function pir_wrapper_product_end()
{
  ?>
  <!-- </div> -->
  <?php
}

add_action('woocommerce_before_single_product_summary', 'pir_wrapper_product_entry_start', 30);

function pir_wrapper_product_entry_start()
{
  ?>
  <div class="product_display_right">

    <?php
}

add_action('woocommerce_after_single_product_summary', 'pir_wrapper_product_entry_end', 5);

function pir_wrapper_product_entry_end()
{
  ?>
  </div>
  <?php
}

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price_custom', 25);
function woocommerce_template_single_price_custom()
{
  global $product;
  if (!($product && $product->is_type('variable'))) {
    ?>
    <div class="regular_price">
      <?php woocommerce_template_single_price(); ?>
    </div>
    <?php
  }
}

function theme_remove_quantity_field($return, $product)
{
  if (is_product()) {
    $return = true;
  }
  return $return;
}
add_filter('woocommerce_is_sold_individually', 'theme_remove_quantity_field', 10, 2);

add_action('woocommerce_before_shop_loop_item', 'opr_product_link_open', 5);
function opr_product_link_open()
{
  ?>
  <div class="product_item">
    <div class="product_img">
      <?php
}

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

add_action('woocommerce_after_shop_loop_item_title', 'opr_product_link_bottom_box', 25);
function opr_product_link_bottom_box()
{
  ?>
    </div>
    <?php
}
add_action('woocommerce_after_shop_loop_item', 'opr_product_link_close', 25);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

function opr_product_link_close()
{
  ?>
    <div class="product_left">
      <?php
      // woocommerce_template_loop_product_title();
      echo '<h2 class="woocommerce-loop-product__title"><a href=' . get_permalink() . '>' . get_the_title() . '</a></h2>';
      woocommerce_template_single_excerpt();
      ?>
      <div class="product_bottom">
        <?php
        woocommerce_template_loop_price();
        woocommerce_template_loop_add_to_cart();
        ?>
      </div>
    </div>
  </div>
  <?php
}




function add_full_description_in_product_categories()
{
  global $product;
  if (!$product->post->post_content)
    return;

  echo '<div class="cat_shop_full_description">';
  echo '<div class="opisanie">Описание:</div>';
  echo '<p class="cat_shop_full_description_text">';

  $full_description = $product->post->post_content; //обрезаем текст до 300 символов
  // $full_description = substr($product->post->post_content, 0, 300); //обрезаем текст до 300 символов
  // $full_description = rtrim($full_description, "!,.-"); //обрезаем знаки
  // $full_description = substr($full_description, 0, strrpos($full_description, ' ')); //обрезаем по последний пробел
  // $full_description = $full_description . ' ...'; //ставим троеточие
  echo apply_filters('woocommerce_description', $full_description);
  echo '</p>';
  echo '</div>';
}




add_action('woocommerce_single_product_summary', function () {
  echo '<div class="sostav">Состав:</div>';
}, 15);

add_action('woocommerce_checkout_before_customer_details', 'pir_customer_details_start');

function pir_customer_details_start()
{
  ?>
  <div class="row_order_detali">
    <?php
}

add_action('woocommerce_checkout_before_order_review_heading', 'pir_before_order_review_start');

function pir_before_order_review_start()
{
  ?>
    <div class="your_order_wrap">
      <?php
}


add_action('woocommerce_checkout_after_order_review', 'pir_after_order_review_close');

function pir_after_order_review_close()
{
  ?>
    </div>
    <?php
}


add_filter('woocommerce_billing_fields', 'true_add_custom_billing_field', 25);
function true_add_custom_billing_field($fields)
{
  $arr_time = [];
  $arr_date = [];

  $manth_names = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
  $now_manth = date('n');
  // $now_manth = 1;
  $now_day = date('j', strtotime('+' . 0 . ' day'));


  for ($i = 0; $i < 14; $i++) {
    $have_manth = '';
    if (date('j', strtotime('+' . $i . ' day')) < $now_day) {
      if ($now_manth != 12) {
        $have_manth = $manth_names[$now_manth];
      } else {
        $have_manth = $manth_names[0];
      }
    } else {
      $have_manth = $manth_names[$now_manth - 1];
    }

    $item_date = date('d', strtotime('+' . $i . ' day')) . ' ' . $have_manth;
    $arr_date[$item_date] = $item_date;
  }

  //  echo '<pre>';
//  print_r($arr_date);
//  print_r($manth_names[date('n')]);
//  echo date("F j, Y, g:i a");
//  echo current_datetime()->format('g') . '<br>';
//  echo date('d');
//  echo '</pre>';

  // $h_time_now = date('G', strtotime('+' . 1 . ' hours'));
  $h_time_now = current_datetime()->format('G');
  // echo $h_time_now;r

  // if (($h_time_now < 21 && $h_time_now > 4) && date('d') == (current_datetime()->format('d'))) {
  if (($h_time_now < 19 && $h_time_now > 4)) {
    for ($i = 0; $i < 24; $i++) {
      if (($h_time_now + $i) > 9 && ($h_time_now + $i) < 21 && ($h_time_now + $i) - 2 >= $h_time_now) {
        // $h_time = date('H', strtotime('+' . 9 + $i . ' hours')) . ":00 - " . date('H', strtotime('+' . 11 + $i . ' hours')) . ":00";
        $h_time = ($h_time_now + 0) + $i . ":00 - " . ($h_time_now + 2) + $i . ":00";

        $arr_time[$h_time] = $h_time;
      }
    }

    //  echo '<pre>';
//  print_r($arr_time);
//  echo '</pre>';


  } else {
    array_shift($arr_date);
    for ($k = 0; $k <= 10; $k++) {
      $h_time = 10 + $k . ":00 - " . 12 + $k . ":00";
      $arr_time[$h_time] = $h_time;
    }
  }

  // массив нового поля
  $new_field = array(
    'billing_deliverymethod' => array(
      'type' => 'radio', // text, textarea, select, radio, checkbox, password
      'required' => false, // по сути только добавляет значок "*" и всё
      'class' => array('true-field', 'form-row-wide'), // массив классов поля
      'label' => 'Способ доставки',
      'label_class' => 'true-label', // класс лейбла
      'priority' => 40,
      'options' => array( // options for  or
        'kurer' => 'Курьер', // 'значение'=>'заголовок'
        'samovivoz' => 'Самовывоз'
      )
    )
  );
  // массив нового поля
  $new_field1 = array(
    'billing_deliverymethod_time' => array(
      'type' => 'select', // text, textarea, select, radio, checkbox, password
      'required' => false, // по сути только добавляет значок "*" и всё
      'class' => array('true-field', 'form-row-wide', 'select_date_box'), // массив классов поля
      'label' => 'Время доставки',
      'label_class' => 'true-label', // класс лейбла
      'priority' => 100,
      'options' => $arr_time
    )
  );
  // массив нового поля
  $new_field2 = array(
    'billing_deliverymethod_date' => array(
      'type' => 'select', // text, textarea, select, radio, checkbox, password
      'required' => false, // по сути только добавляет значок "*" и всё
      'class' => array('true-field', 'form-row-wide', 'select_date_box'), // массив классов поля
      'label' => 'Дата',
      'label_class' => 'true-label', // класс лейбла
      'priority' => 100,
      'options' => $arr_date
    )
  );
  $new_field3 = array(
    'billing_deliverymethod_date_pay1' => array(
      'type' => 'radio', // text, textarea, select, radio, checkbox, password
      'required' => false, // по сути только добавляет значок "*" и всё
      'class' => array('true-field', 'form-row-wide', 'select_date_box'), // массив классов поля
      'label' => 'Способ оплаты',
      'label_class' => 'true-label', // класс лейбла
      'priority' => 100,
      'options' => array( // options for  or
        'cash' => 'Наличными', // 'значение'=>'заголовок'
        'pay' => 'Картой'
      )
    )
  );
  $new_field_rev = array(
    'billing_rev' => array(
      'type' => 'textarea', // text, textarea, select, radio, checkbox, password
      'required' => false, // по сути только добавляет значок "*" и всё
      'class' => array('true-field', 'form-row-wide', 'select_date_box'), // массив классов поля
      'label' => 'Комментарий к заказу',
      'label_class' => 'true-label', // класс лейбла
      'priority' => 110
      // 'options'       => array( // options for  or
      //   'cash'        => 'Наличными курьеру', // 'значение'=>'заголовок'
      //   'pay'         => 'Картой курьеру'
      // )
    )
  );

  $new_field_apartment = array(
    'billing_apartment' => array(
      'type' => 'text', // text, textarea, select, radio, checkbox, password
      'required' => false, // по сути только добавляет значок "*" и всё
      'class' => array('true-field', 'form-row-wide', 'select_date_box'), // массив классов поля
      'label' => 'Квартира',
      'label_class' => 'true-label', // класс лейбла
      'priority' => 110,
      'default' => get_user_meta(get_current_user_id(), 'apartment', true)
      // 'options'       => array( // options for  or
      //   'cash'        => 'Наличными курьеру', // 'значение'=>'заголовок'
      //   'pay'         => 'Картой курьеру'
      // )
    )
  );
  $new_field_floor = array(
    'billing_floor' => array(
      'type' => 'text', // text, textarea, select, radio, checkbox, password
      'required' => false, // по сути только добавляет значок "*" и всё
      'class' => array('true-field', 'form-row-wide', 'select_date_box'), // массив классов поля
      'label' => 'Этаж',
      'label_class' => 'true-label', // класс лейбла
      'priority' => 110,
      'default' => get_user_meta(get_current_user_id(), 'floor', true)
      // 'options'       => array( // options for  or
      //   'cash'        => 'Наличными курьеру', // 'значение'=>'заголовок'
      //   'pay'         => 'Картой курьеру'
      // )
    )
  );
  $new_field_entrance = array(
    'billing_entrance' => array(
      'type' => 'text', // text, textarea, select, radio, checkbox, password
      'required' => false, // по сути только добавляет значок "*" и всё
      'class' => array('true-field', 'form-row-wide', 'select_date_box'), // массив классов поля
      'label' => 'Подъезд',
      'label_class' => 'true-label', // класс лейбла
      'priority' => 110,
      'default' => get_user_meta(get_current_user_id(), 'entrance', true)
      // 'placeholder'         => get_the_author_meta('entrance')
      // 'placeholder' 		    => get_user_meta(get_current_user_id(), 'entrance', true),
      // 'placeholder'   => (get_user_meta($user_id, 'entrance', true)) ? get_user_meta($user_id, 'entrance', true) : 0
      // 'options'       => array( // options for  or
      //   'cash'        => 'Наличными курьеру', // 'значение'=>'заголовок'
      //   'pay'         => 'Картой курьеру'
      // )
    )
  );

  $new_field_birthday = array(
    'date_of_birth' => array(
      'type' => 'text', // text, textarea, select, radio, checkbox, password
      'required' => false, // по сути только добавляет значок "*" и всё
      'class' => array('true-field', 'form-row-wide', 'select_date_box'), // массив классов поля
      'label' => 'Дата рождения',
      'label_class' => 'true-label', // класс лейбла
      'priority' => 110,
      'default' => get_user_meta(get_current_user_id(), 'date_of_birth', true)
      // 'placeholder'         => get_the_author_meta('entrance')
      // 'placeholder' 		    => get_user_meta(get_current_user_id(), 'entrance', true),
      // 'placeholder'   => (get_user_meta($user_id, 'entrance', true)) ? get_user_meta($user_id, 'entrance', true) : 0
      // 'options'       => array( // options for  or
      //   'cash'        => 'Наличными курьеру', // 'значение'=>'заголовок'
      //   'pay'         => 'Картой курьеру'
      // )
    )
  );

  $new_field_input_bonuss = array(
    'billing_bonuss' => array(
      'type' => 'text', // text, textarea, select, radio, checkbox, password
      'required' => false, // по сути только добавляет значок "*" и всё
      'class' => array('true-field', 'form-row-wide'), // массив классов поля
      'label' => '<span class="bonuss_wrapper">Бонусов: <span class="p-coin"></span>' . '<span class="input_bonus_box">' . ((get_user_meta(get_current_user_id(), 'bonuss', true) != '') ? get_user_meta(get_current_user_id(), 'bonuss', true) : 0) . '</span></span>' . ((WC()->cart->total / 2 <= get_user_meta(get_current_user_id(), 'bonuss', true)) ? '(Доступно к списанию ' . WC()->cart->total / 2 . ')' : '(Доступно к списанию ' . ((get_user_meta(get_current_user_id(), 'bonuss', true) != '') ? get_user_meta(get_current_user_id(), 'bonuss', true) : 0) . ')'),
      // 'label'         => '<span class="bonuss_wrapper">Бонусов: <span class="p-coin"></span>' . '<span class="input_bonus_box">' . get_user_meta(get_current_user_id(), 'bonuss', true) . '</span></span>' . ((WC()->cart->total / 2 <= get_user_meta(get_current_user_id(), 'bonuss', true)) ? '<span class="available_bonus">(Доступно к списанию ' . WC()->cart->total / 2 . ')</span>' : ''),
      'label_class' => 'true-label', // класс лейбла
      'priority' => 110,
      'default' => 0
      // 'placeholder'         => get_the_author_meta('entrance')
      // 'placeholder' 		    => get_user_meta(get_current_user_id(), 'entrance', true),
      // 'placeholder'   => (get_user_meta($user_id, 'entrance', true)) ? get_user_meta($user_id, 'entrance', true) : 0
      // 'options'       => array( // options for  or
      //   'cash'        => 'Наличными курьеру', // 'значение'=>'заголовок'
      //   'pay'         => 'Картой курьеру'
      // )
    )
  );

  // объединяем поля
  $fields = array_slice($fields, 0, 3, true) + $new_field_birthday + $new_field + $new_field1 + $new_field2 + $new_field3 + $new_field_rev + $new_field_apartment + $new_field_floor + $new_field_entrance + array_slice($fields, 2, NULL, true) + $new_field_input_bonuss;

  return $fields;
}

// add_action('wp_enqueue_scripts', 'remove_aria_hidden_from_checkout_descriptions');

// function remove_aria_hidden_from_checkout_descriptions()
// {
//   if (is_checkout()) {
//     wp_add_inline_script('jquery', '
//           jQuery(document).ready(function($) {
//               $("#billing_deliverymethod_date_pay_bonuss-description").attr("class", "descriptions");
//           });
//       ');
//   }
// }



add_action('woocommerce_checkout_update_order_meta', 'true_save_field', 25);
function true_save_field($order_id)
{
  $user_id = get_current_user_id();
  if (!empty($_POST['billing_deliverymethod'])) {
    update_post_meta($order_id, 'billing_deliverymethod', sanitize_text_field($_POST['billing_deliverymethod']));
  }
  if (!empty($_POST['billing_deliverymethod_time'])) {
    update_post_meta($order_id, 'billing_deliverymethod_time', sanitize_text_field($_POST['billing_deliverymethod_time']));
  }
  if (!empty($_POST['billing_deliverymethod_date'])) {
    update_post_meta($order_id, 'billing_deliverymethod_date', sanitize_text_field($_POST['billing_deliverymethod_date']));
  }
  if (!empty($_POST['billing_deliverymethod_date_checkbox'])) {
    update_post_meta($order_id, 'billing_deliverymethod_date_checkbox', sanitize_text_field($_POST['billing_deliverymethod_date_checkbox']));
  }
  if (!empty($_POST['billing_deliverymethod_date_pay1'])) {
    update_post_meta($order_id, 'billing_deliverymethod_date_pay1', sanitize_text_field($_POST['billing_deliverymethod_date_pay1']));
  }
  if (!empty($_POST['billing_rev'])) {
    update_post_meta($order_id, 'billing_rev', sanitize_text_field($_POST['billing_rev']));
  }
  if (!empty($_POST['billing_apartment'])) {
    update_post_meta($order_id, 'billing_apartment', sanitize_text_field($_POST['billing_apartment']));
    update_user_meta($user_id, 'apartment', sanitize_text_field($_POST['billing_apartment']));
  }
  if (!empty($_POST['billing_floor'])) {
    update_post_meta($order_id, 'billing_floor', sanitize_text_field($_POST['billing_floor']));
    update_user_meta($user_id, 'floor', sanitize_text_field($_POST['billing_floor']));
  }
  if (!empty($_POST['billing_entrance'])) {
    update_post_meta($order_id, 'billing_entrance', sanitize_text_field($_POST['billing_entrance']));
    update_user_meta($user_id, 'entrance', sanitize_text_field($_POST['billing_entrance']));
  }
  if (!empty($_POST['billing_bonuss'])) {
    update_post_meta($order_id, 'billing_bonuss', sanitize_text_field($_POST['billing_bonuss']));
  }
  update_post_meta($order_id, 'order_bonus_check', 0);
}

add_action('woocommerce_admin_order_data_after_billing_address', 'true_print_field_value', 25);
function true_print_field_value($order)
{
  $user_id = get_current_user_id();
  $method_delilv_trigger = get_post_meta($order->get_id(), 'billing_deliverymethod', true);


  if ($method = get_post_meta($order->get_id(), 'billing_apartment', true)) {
    echo '<p><strong>Квартира</strong><br>' . esc_html($method) . '</p>';
  }
  if ($method = get_post_meta($order->get_id(), 'billing_floor', true)) {
    echo '<p><strong>Этаж</strong><br>' . esc_html($method) . '</p>';
  }
  if ($method = get_post_meta($order->get_id(), 'billing_entrance', true)) {
    echo '<p><strong>Подъезд</strong><br>' . esc_html($method) . '</p>';
  }



  if ($method = get_post_meta($order->get_id(), 'billing_deliverymethod', true)) {

    $method_delivery = '';

    switch ($method) {
      case 'kurer':
        $method_delivery = 'Курьер';
        break;
      case 'samovivoz':
        $method_delivery = 'Самовывоз';
        break;
    }

    echo '<p><strong>Предпочтительный метод доставки:</strong><br>' . $method_delivery . '</p>';
  }
  if (($method = get_post_meta($order->get_id(), 'billing_deliverymethod_time', true)) && ($method_delilv_trigger == 'kurer')) {
    echo '<p><strong>Предпочтительное время доставки:</strong><br>' . esc_html($method) . '</p>';
  }
  if (($method = get_post_meta($order->get_id(), 'billing_deliverymethod_date', true)) && ($method_delilv_trigger == 'kurer')) {
    echo '<p><strong>Предпочтительный день доставки:</strong><br>' . esc_html($method) . '</p>';
  }
  if ($method = get_post_meta($order->get_id(), 'billing_deliverymethod_date_checkbox', true)) {
    echo '<p><strong>Ближайшее время</strong><br>' . esc_html($method) . '</p>';
  }

  if ($method = get_post_meta($order->get_id(), 'billing_deliverymethod_date_pay1', true)) {

    $method_pay = '';

    switch ($method) {
      case 'cash':
        $method_pay = 'Наличными';
        break;
      case 'pay':
        $method_pay = 'Картой';
        break;
    }

    echo '<p><strong>Метод оплаты</strong><br>' . esc_html($method_pay) . '</p>';
  }
  if ($method = get_post_meta($order->get_id(), 'billing_rev', true)) {
    echo '<p><strong>Комментарий к заказу</strong><br>' . esc_html($method) . '</p>';
  }

  if (get_user_meta(get_current_user_id(), 'date_of_birth', true) != '') {
    $date_clients = explode(".", get_user_meta(get_current_user_id(), 'date_of_birth', true));

    for ($i = -3; $i <= 3; $i++) {
      $for_date = (new DateTime(current_time('d.m.Y')))->modify($i . ' days')->format('d.m');
      if ($for_date == ($date_clients[0] . '.' . $date_clients[1])) {
        if ($i == 0) {
          echo '<p><strong>С наступающим днём рождения !!!</strong></p>';
        } elseif ($i < 0) {
          echo '<p><strong>С днём рождения !!!</strong></p>';
        } elseif ($i > 0) {
          echo '<p><strong>С прошедшим днём рождения !!!</strong></p>';
        }
      }
    }
  }
}

add_action('woocommerce_single_product_summary', function () {
  ?>
    <div class="box_price_add_to_cart">
      <?php
}, 20);
add_action('woocommerce_single_product_summary', function () {
  ?>
    </div>
    <?php
}, 35);


add_action('woocommerce_after_main_content', function () {
  echo '<div>';
}, 10);

add_filter('woocommerce_account_menu_items', 'pir_account_menu_items', 10, 1);

function pir_account_menu_items($items)
{
  unset($items['downloads']);
  unset($items['edit-address']);

  // Измените названия вкладок здесь
  $items['dashboard'] = 'Личные данные'; // Панель
  $items['orders'] = 'История заказов'; // Заказы
  // $items['edit-address'] = 'Адреса'; // Адреса
  $items['edit-account'] = 'Данные для входа'; // Детали аккаунта
  $items['customer-logout'] = 'Выйти'; // Выйти

  return $items;
}


function wpb_woo_endpoint_title($title, $id)
{

  if (is_wc_endpoint_url('orders') && in_the_loop()) {
    $title = "История заказов";
  } elseif (is_wc_endpoint_url('edit-address') && in_the_loop()) {
    $title = "Изменить личные данные";
  } elseif (is_wc_endpoint_url('edit-account') && in_the_loop()) {
    $title = "Данные для входа";
  }
  return $title;
}
add_filter('the_title', 'wpb_woo_endpoint_title', 10, 2);





add_filter('woocommerce_my_account_my_orders_actions', 'true_order_again', 25, 2);

function true_order_again($actions, $order)
{
  // мы добавляем эту кнопку только для выполненных заказов
  if ($order->has_status('completed')) {

    $actions['order-again'] = array(
      'url' => wp_nonce_url(
        add_query_arg(
          'order_again',
          $order->get_id(),
          wc_get_cart_url()
        ),
        'woocommerce-order_again'
      ),
      'name' => __('Повторить', 'woocommerce'),
    );
  }
  return $actions;
}


// Добавляем форму изменения имени пользователя и адреса на страницу "Мой аккаунт"
// add_action('woocommerce_edit_account_form', 'add_custom_username_and_address_form');
function add_custom_username_and_address_form()
{
  $user = wp_get_current_user();
  // $first_name = get_user_meta($user->ID, 'first_name', true);
  $billing_address_1 = get_user_meta($user->ID, 'billing_address_1', true);
  $billing_address_2 = get_user_meta($user->ID, 'billing_address_2', true);
  ?>
    <!-- <h3><?php // _e('Change Username and Address', 'woocommerce'); 
      ?></h3> -->
    <form method="post" id="change-username-address-form">
      <?php wp_nonce_field('save_custom_username_address', 'custom_username_address_nonce'); ?>
      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="username"><?php _e('Имя', 'woocommerce'); ?> <span class="required">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="first_name" id="first_name"
          value="<?php echo esc_attr($user->first_name); ?>" required />
      </p>
      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="billing_address_1"><?php _e('Улица', 'woocommerce'); ?></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_address_1"
          id="billing_address_1" value="<?php echo esc_attr($billing_address_1); ?>" />
      </p>
      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="billing_address_2"><?php _e('Дом', 'woocommerce'); ?></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_address_2"
          id="billing_address_2" value="<?php echo esc_attr($billing_address_2); ?>" />
      </p>
      <p>
        <button type="submit" class="woocommerce-Button button" name="save_username_address"
          value="<?php esc_attr_e('Save Changes', 'woocommerce'); ?>"><?php esc_html_e('Сохранить', 'woocommerce'); ?></button>
      </p>
    </form>
    <?php
}

// // Обработка и сохранение изменений имени пользователя и адреса
// add_action('template_redirect', 'save_custom_username_and_address');
// function save_custom_username_and_address()
// {
//   if (isset($_POST['save_username_address']) && isset($_POST['custom_username_address_nonce']) && wp_verify_nonce($_POST['custom_username_address_nonce'], 'save_custom_username_address')) {
//     if (!is_user_logged_in()) {
//       return;
//     }

//     $user_id = get_current_user_id();
//     $first_name = sanitize_text_field($_POST['first_name']);
//     $billing_address_1 = sanitize_text_field($_POST['billing_address_1']);
//     $billing_address_2 = sanitize_text_field($_POST['billing_address_2']);
//     // $billing_postcode = sanitize_text_field($_POST['billing_postcode']);
//     // $billing_country = sanitize_text_field($_POST['billing_country']);

//     // Проверка и сохранение имени пользователя
//     if (!empty($first_name) && $first_name !== wp_get_current_user()->first_name) {
//       if (!username_exists($first_name)) {
//         wp_update_user(array(
//           'ID'            => $user_id,
//           'first_name'    => $first_name
//         ));
//         // wc_add_notice(__('Username changed successfully.', 'woocommerce'), 'success');
//       } else {
//         // wc_add_notice(__('This username is already taken. Please choose another one.', 'woocommerce'), 'error');
//       }
//     }

//     // Сохранение адреса пользователя
//     update_user_meta($user_id, 'billing_address_1', $billing_address_1);
//     update_user_meta($user_id, 'billing_address_2', $billing_address_2);
//     // update_user_meta($user_id, 'billing_postcode', $billing_postcode);
//     // update_user_meta($user_id, 'billing_country', $billing_country);

//     wc_add_notice(__('Address changed successfully.', 'woocommerce'), 'success');
//   }
// }

// add_action('woocommerce_account_edit-account_endpoint', 'custom_password_change_form');

function custom_password_change_form()
{
  ?>
    <h3><?php _e('Change Password', 'woocommerce'); ?></h3>
    <form method="post" id="change-password-form">
      <?php wp_nonce_field('save_password', 'save_password_nonce'); ?>
      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="password_current"><?php _e('Current Password', 'woocommerce'); ?> <span
            class="required">*</span></label>
        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_current"
          id="password_current" required />
      </p>
      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="password_1"><?php _e('New Password', 'woocommerce'); ?> <span class="required">*</span></label>
        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_1"
          id="password_1" required />
      </p>
      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="password_2"><?php _e('Confirm New Password', 'woocommerce'); ?> <span
            class="required">*</span></label>
        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_2"
          id="password_2" required />
      </p>
      <p>
        <button type="submit" class="woocommerce-Button button" name="save_password"
          value="<?php esc_attr_e('Save Password', 'woocommerce'); ?>"><?php esc_html_e('Save Password', 'woocommerce'); ?></button>
      </p>
    </form>
    <?php
}

add_action('template_redirect', 'custom_save_password');

function custom_save_password()
{
  if (isset($_POST['save_password']) && isset($_POST['save_password_nonce']) && wp_verify_nonce($_POST['save_password_nonce'], 'save_password')) {
    if (!is_user_logged_in()) {
      return;
    }

    $user_id = get_current_user_id();
    $current_password = sanitize_text_field($_POST['password_current']);
    $new_password = sanitize_text_field($_POST['password_1']);
    $confirm_password = sanitize_text_field($_POST['password_2']);

    // Проверка текущего пароля
    if (!wp_check_password($current_password, wp_get_current_user()->user_pass, $user_id)) {
      wc_add_notice(__('Current password is incorrect', 'woocommerce'), 'error');
      return;
    }

    // Проверка совпадения нового пароля и подтверждения
    if ($new_password !== $confirm_password) {
      wc_add_notice(__('New passwords do not match', 'woocommerce'), 'error');
      return;
    }

    // Обновление пароля
    wp_set_password($new_password, $user_id);
    wc_add_notice(__('Password changed successfully', 'woocommerce'), 'success');

    // Перезагрузка страницы после изменения пароля
    wp_safe_redirect(wc_get_account_endpoint_url('edit-account'));
    exit;
  }
}

// Сохранение имени при регистрации
add_action('woocommerce_created_customer', 'save_name_field_on_registration');

function save_name_field_on_registration($customer_id)
{
  if (isset($_POST['billing_first_name'])) {
    // Сохранение имени пользователя
    update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
    update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
  }
}




// когда пользователь сам редактирует свой профиль
add_action('show_user_profile', 'true_show_profile_fields');
// когда чей-то профиль редактируется админом например
add_action('edit_user_profile', 'true_show_profile_fields');

function true_show_profile_fields($user)
{

  // выводим заголовок для наших полей
  echo '<h3>Дополнительная информация</h3>';

  // поля в профиле находятся в рамметке таблиц <table>
  echo '<table class="form-table">';

  // добавляем поле
  $user_date_of_birth = get_the_author_meta('date_of_birth', $user->ID);
  echo '<tr><th><label for="date_of_birth">Дата рождения</label></th>
  <td><input type="text" name="date_of_birth" id="date_of_birth" value="' . esc_attr($user_date_of_birth) . '" class="regular-text" /></td>
	</tr>';

  $user_apartment = get_the_author_meta('apartment', $user->ID);
  echo '<tr><th><label for="apartment">Квартира</label></th>
  <td><input type="text" name="apartment" id="apartment" value="' . esc_attr($user_apartment) . '" class="regular-text" /></td>
	</tr>';

  $user_floor = get_the_author_meta('floor', $user->ID);
  echo '<tr><th><label for="floor">Этаж</label></th>
  <td><input type="text" name="floor" id="floor" value="' . esc_attr($user_floor) . '" class="regular-text" /></td>
  </tr>';

  $user_entrance = get_the_author_meta('entrance', $user->ID);
  echo '<tr><th><label for="entrance">Подъезд</label></th>
  <td><input type="text" name="entrance" id="entrance" value="' . esc_attr($user_entrance) . '" class="regular-text" /></td>
	</tr>';

  $user_bonuss = get_the_author_meta('bonuss', $user->ID);
  echo '<tr><th><label for="bonuss">Бонусы</label></th>
  <td><input type="text" name="bonuss" id="bonuss" value="' . esc_attr($user_bonuss) . '" class="regular-text" /></td>
	</tr>';

  echo '</table>';
}

// когда пользователь сам редактирует свой профиль
add_action('personal_options_update', 'true_save_profile_fields');
// когда чей-то профиль редактируется админом например
add_action('edit_user_profile_update', 'true_save_profile_fields');

function true_save_profile_fields($user_id)
{

  update_user_meta($user_id, 'date_of_birth', sanitize_text_field($_POST['date_of_birth']));
  update_user_meta($user_id, 'apartment', sanitize_text_field($_POST['apartment']));
  update_user_meta($user_id, 'entrance', sanitize_text_field($_POST['entrance']));
  update_user_meta($user_id, 'floor', sanitize_text_field($_POST['floor']));
  update_user_meta($user_id, 'bonuss', sanitize_text_field($_POST['bonuss']));
}





add_action('woocommerce_cart_calculate_fees', 'apply_discount_based_on_checkbox');

function apply_discount_based_on_checkbox()
{
  if (is_checkout()) {

    $user_id = get_current_user_id();

    if (is_admin() && !defined('DOING_AJAX'))
      return;
    $apply_discount = 0;
    $billing_bonuss_input = 0;
    // $is_user_birthday = 0;

    // if (substr(get_user_meta($user_id, 'date_of_birth', true), 0, 5) == current_datetime()->format('d.m')) {
    //   $is_user_birthday = 1;
    //   // echo 'ok';
    // } else {
    //   // echo 'no';
    // }
    // echo substr(get_user_meta($user_id, 'date_of_birth', true), 0, 5);
    // echo current_datetime()->format('d.m');

    // Проверяем, отмечен ли чекбокс
    if (isset($_POST['billing_bonuss'])) {
      $billing_bonuss_input = $_POST['billing_bonuss'];
    }
    if (isset($_POST['billing_deliverymethod'])) {
      if ($_POST['billing_deliverymethod'] == 'samovivoz') {
        $apply_discount = 1;
      }
    }


    $discount = 0; // Замените на необходимый процент скидки
    // $birs
    $percentage_for_pickup = (carbon_get_theme_option('crb_set_percentage_for_pickup')) ? carbon_get_theme_option('crb_set_percentage_for_pickup') : 0;


    // if ($is_user_birthday == 1 && (carbon_get_theme_option('crb_set_percentage_for_birthday') ? carbon_get_theme_option('crb_set_percentage_for_birthday') : 0) > $percentage_for_pickup) {
    //   // echo carbon_get_theme_option('crb_set_percentage_for_birthday');
    //   $percentage_for_pickup = carbon_get_theme_option('crb_set_percentage_for_birthday');
    //   // echo 'ok';
    //   // echo $percentage_for_pickup;
    // }

    $cart_total = WC()->cart->get_cart_contents_total();
    $proc_samovivoz = ($apply_discount == '1') ? $percentage_for_pickup / 100 * $cart_total : 0;

    if ($billing_bonuss_input > 0) {
      $prec50 = 50 / 100 * $cart_total;
      $bonus = get_user_meta($user_id, 'bonuss', true) ? get_user_meta($user_id, 'bonuss', true) : 0;

      if ($bonus >= $billing_bonuss_input) {
        if ($prec50 <= $billing_bonuss_input) {
          $discount = $prec50;
          update_user_meta($user_id, 'bonuss', sanitize_text_field($bonus - $prec50));
        } else {
          $discount = $billing_bonuss_input;
          update_user_meta($user_id, 'bonuss', sanitize_text_field($bonus - $billing_bonuss_input));
        }
      }
    }

    $bonus = get_user_meta($user_id, 'bonuss', true);

    if ($apply_discount == '1') {
      if ($billing_bonuss_input > 0) {
        update_user_meta($user_id, 'bonuss', sanitize_text_field($bonus + ($percentage_for_pickup / 100 * ($cart_total - $discount))));
      } else {
        update_user_meta($user_id, 'bonuss', sanitize_text_field($bonus + $proc_samovivoz));
      }
    }
    // Добавляем скидку
    WC()->cart->add_fee(__('Percentage Discount', 'woocommerce'), -$discount);
  }
}


add_action('user_register', 'save_bonus_user_registration', 10, 1);
function save_bonus_user_registration($user_id)
{
  update_user_meta($user_id, 'bonuss', (carbon_get_theme_option('crb_set_registration_bonus')) ? carbon_get_theme_option('crb_set_registration_bonus') : 0);
}






/*allow weak passwords*/
function wc_ninja_remove_password_strength()
{
  if (wp_script_is('wc-password-strength-meter', 'enqueued')) {
    wp_dequeue_script('wc-password-strength-meter');
  }
}
add_action('wp_print_scripts', 'wc_ninja_remove_password_strength', 100);






// Регистрация AJAX-обработчиков
add_action('wp_ajax_custom_login_check', 'custom_login_check_callback');
add_action('wp_ajax_nopriv_custom_login_check', 'custom_login_check_callback');

function custom_login_check_callback()
{
  if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];

    // Проверка логина
    $user = wp_authenticate($email, $password);

    if (is_wp_error($user)) {
      wp_send_json_error(array('error_message' => 'Неверный email или пароль.'));
    } else {
      // Успешная аутентификация, логиним пользователя
      wp_set_current_user($user->ID);
      wp_set_auth_cookie($user->ID, true);
      do_action('wp_login', $user->user_login, $user);
      // Если вход успешен, перенаправляем пользователя
      wp_send_json_success(array('redirect_url' => get_permalink(get_option('woocommerce_myaccount_page_id'))));
      // wp_send_json_success(array('redirect_url' => home_url()));
    }
  } else {
    wp_send_json_error(array('error_message' => 'Ошибка в запросе.'));
  }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

function enqueue_custom_scripts()
{
  wp_enqueue_script('custom-login-script', get_template_directory_uri() . '/assets/js/custom-login.js', array('jquery'), null, true);

  // Локализация скрипта
  wp_localize_script('custom-login-script', 'wc_login_params', array(
    'ajax_url' => admin_url('admin-ajax.php')
  ));
}











// add_action('woocommerce_checkout_process', 'register_new_customer_on_checkout');

// function register_new_customer_on_checkout()
// {
//   if (!is_user_logged_in()) {
//     $checkout = WC()->checkout();
//     $email = $checkout->get_value('billing_email');
//     $first_name = $checkout->get_value('billing_first_name');
//     // $last_name = $checkout->get_value('billing_last_name');

//     if (email_exists($email) == false) {
//       $password = wp_generate_password();
//       $user_id = wc_create_new_customer($email, $email, $password);

//       if (is_wp_error($user_id)) {
//         wc_add_notice(__('Registration error: ', 'woocommerce') . $user_id->get_error_message(), 'error');
//       } else {
//         //       // Optional: send an email with the password
//         // wp_new_user_notification($user_id, null, 'user');

//         //       // Update first and last name
//         // update_user_meta($user_id, 'first_name', $first_name);
//         // update_user_meta($user_id, 'last_name', $last_name);
//         // update_user_meta($user_id, 'bonuss', '200');
//         //       // Log the new user in
//         // wc_set_customer_auth_cookie($user_id);
//       }
//     }
//   }  
// }



// add_action('woocommerce_checkout_process', 'register_user_at_checkout');
// function register_user_at_checkout() {
//     if (!is_user_logged_in()) {
//         $checkout = WC()->checkout();
//         $email = sanitize_email($_POST['billing_email']);
//         $first_name = sanitize_text_field($_POST['billing_first_name']);
//         $last_name = sanitize_text_field($_POST['billing_last_name']);
//         $last_name = sanitize_text_field($_POST['billing_last_name']);

//         // Ensure email isn't already registered
//         if (email_exists($email)) {
//             wc_add_notice(__('An account is already registered with your email address. Please log in.', 'woocommerce'), 'error');
//             return;
//         }

//         // Create new user
//         $random_password = wp_generate_password();
//         $user_id = wc_create_new_customer($email, $email, $random_password);

//         if (is_wp_error($user_id)) {
//             wc_add_notice(__('Registration error. Please try again.', 'woocommerce'), 'error');
//             return;
//         }

//         // Update first and last name
//         update_user_meta($user_id, 'first_name', $first_name);
//         update_user_meta($user_id, 'last_name', $last_name);

//         // Automatically log in the user
//         wp_set_current_user($user_id);
//         wc_set_customer_auth_cookie($user_id);
//         WC()->session->init_session_cookie();
//     }
// }

// add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
// function custom_override_checkout_fields($fields) {
//     if (!is_user_logged_in()) {
//         $fields['account']['account_username'] = array(
//             'type' => 'hidden',
//             'label' => __('Username', 'woocommerce'),
//             'required' => false,
//             'default' => '',
//         );
//         $fields['account']['account_password'] = array(
//             'type' => 'hidden',
//             'label' => __('Password', 'woocommerce'),
//             'required' => false,
//             'default' => '',
//         );
//     }
//     return $fields;
// }





// function action_woocommerce_thankyou($order_id)
// {
//   // Определяет, является ли текущий посетитель вошедшим в систему пользователем.
//   if (is_user_logged_in()) return;

//   // Получить объект $order
//   $order = wc_get_order($order_id);

//   // Получить адрес электронной почты пользователя из заказа
//   $order_email = $order->get_billing_email();

//   // Проверьте, есть ли пользователи с адресом электронной почты для выставления счетов в качестве пользователя или адреса электронной почты.
//   $email = email_exists($order_email);
//   $user = username_exists($order_email);

//   // Если UID равен нулю, то это гостевая проверка (новый пользователь).
//   if ($user == false && $email == false) {
//     // Случайный пароль из 12 символов
//     $random_password = wp_generate_password();

//     // Имя
//     $first_name = $order->get_billing_first_name();

//     // Фамилия
//     $last_name = $order->get_billing_last_name();

//     // Роль
//     $role = 'customer';

//     // Создайте нового пользователя с адресом электронной почты в качестве имени пользователя, вновь созданным паролем и ролью пользователя.      
//     $user_id = wp_insert_user(
//       array(
//         'user_email' => $order_email,
//         'user_login' => $order_email,
//         'user_pass'  => $random_password,
//         'first_name' => $first_name,
//         'last_name'  => $last_name,
//         'role'       => $role,
//       )
//     );

//     // Получить все объекты электронной почты WooCommerce из экземпляра объекта WC_Emails.
//     $emails = WC()->mailer()->get_emails();

//     // Отправьте WooCommerce уведомление по электронной почте «Новая учетная запись клиента» с паролем.
//     $emails['WC_Email_Customer_New_Account']->trigger($user_id, $random_password, true);

//     // (Optional) WC guest customer identification
//     //update_user_meta( $user_id, 'guest', 'yes' );

//     // Платежные данные пользователя
//     update_user_meta($user_id, 'billing_address_1', $order->get_billing_address_1());
//     update_user_meta($user_id, 'billing_address_2', $order->get_billing_address_2());
//     update_user_meta($user_id, 'billing_city', $order->get_billing_city());
//     update_user_meta($user_id, 'billing_company', $order->get_billing_company());
//     update_user_meta($user_id, 'billing_country', $order->get_billing_country());
//     update_user_meta($user_id, 'billing_email', $order_email);
//     update_user_meta($user_id, 'billing_first_name', $order->get_billing_first_name());
//     update_user_meta($user_id, 'billing_last_name',  $order->get_billing_last_name());
//     update_user_meta($user_id, 'billing_phone', $order->get_billing_phone());
//     update_user_meta($user_id, 'billing_postcode', $order->get_billing_postcode());
//     update_user_meta($user_id, 'billing_state', $order->get_billing_state());

//     // Данные о доставке пользователя
//     update_user_meta($user_id, 'shipping_address_1', $order->get_shipping_address_1());
//     update_user_meta($user_id, 'shipping_address_2', $order->get_shipping_address_2());
//     update_user_meta($user_id, 'shipping_city', $order->get_shipping_city());
//     update_user_meta($user_id, 'shipping_company', $order->get_shipping_company());
//     update_user_meta($user_id, 'shipping_country', $order->get_shipping_country());
//     update_user_meta($user_id, 'shipping_first_name', $order->get_shipping_first_name());
//     update_user_meta($user_id, 'shipping_last_name', $order->get_shipping_last_name());
//     update_user_meta($user_id, 'shipping_method', $order->get_shipping_method());
//     update_user_meta($user_id, 'shipping_postcode', $order->get_shipping_postcode());
//     update_user_meta($user_id, 'shipping_state', $order->get_shipping_state());

//     // Свяжите прошлые заказы с этим вновь созданным клиентом
//     wc_update_new_customer_past_orders($user_id);

//     // Автоматическая авторизация
//     wp_set_current_user($user_id);
//     wp_set_auth_cookie($user_id);
//   }
// }
// add_action('woocommerce_thankyou', 'action_woocommerce_thankyou', 10, 1);

// function filter_woocommerce_thankyou_order_received_text($str, $order)
// {
//   // Определяет, является ли текущий посетитель вошедшим в систему пользователем.
//   if (is_user_logged_in()) return $str;

//   // Получить адрес электронной почты пользователя из заказа
//   $order_email = $order->get_billing_email();

//   // Проверьте, есть ли пользователи с адресом электронной почты для выставления счетов в качестве пользователя или адреса электронной почты.
//   $email = email_exists($order_email);
//   $user = username_exists($order_email);

//   // Если UID равен нулю, то это гостевая проверка (новый пользователь).
//   if ($user == false && $email == false) {
//     // Link
//     $link = get_permalink(get_option('woocommerce_myaccount_page_id'));

//     // Format
//     $format_link = '<a href="' . $link . '">logged in</a>';

//     // Добавить к исходной строке
//     $str .= sprintf(__(' An account has been automatically created for you and you are now %s. You will receive an email about this.', 'woocommerce'), $format_link);
//   }

//   return $str;
// }
// add_filter('woocommerce_thankyou_order_received_text', 'filter_woocommerce_thankyou_order_received_text', 10, 2);

// обьединение товаров корзине
add_action('woocommerce_before_cart', 'merge_duplicate_cart_items_on_cart_page');

function merge_duplicate_cart_items_on_cart_page()
{
  $cart = WC()->cart->get_cart();
  $new_cart = array();

  foreach ($cart as $cart_item_key => $cart_item) {
    $product_id = $cart_item['product_id'];
    $variation_id = $cart_item['variation_id'];

    $found = false;

    foreach ($new_cart as $new_cart_item_key => $new_cart_item) {
      if ($new_cart_item['product_id'] == $product_id && $new_cart_item['variation_id'] == $variation_id) {
        $new_cart[$new_cart_item_key]['quantity'] += $cart_item['quantity'];
        $found = true;
        break;
      }
    }

    if (!$found) {
      $new_cart[$cart_item_key] = $cart_item;
    }
  }

  WC()->cart->empty_cart();

  foreach ($new_cart as $new_cart_item) {
    WC()->cart->add_to_cart(
      $new_cart_item['product_id'],
      $new_cart_item['quantity'],
      isset($new_cart_item['variation_id']) ? $new_cart_item['variation_id'] : 0,
      isset($new_cart_item['variation']) ? $new_cart_item['variation'] : array(),
      isset($new_cart_item['cart_item_data']) ? $new_cart_item['cart_item_data'] : ''
    );
  }
}



function custom_save_address()
{
  if ('POST' !== strtoupper($_SERVER['REQUEST_METHOD'])) {
    return;
  }

  if (empty($_POST['action']) || 'edit_address' !== $_POST['action']) {
    return;
  }

  // Проверка nonce поля для безопасности
  if (!isset($_POST['woocommerce-edit-address-nonce']) || !wp_verify_nonce($_POST['woocommerce-edit-address-nonce'], 'woocommerce-edit_address')) {
    wc_add_notice(__('Nonce verification failed', 'woocommerce'), 'error');
    return;
  }

  // Сохранение адреса
  $user_id = get_current_user_id();
  $load_address = isset($_POST['load_address']) ? sanitize_text_field($_POST['load_address']) : 'billing';

  if ($user_id) {
    $address_fields = WC()->countries->get_address_fields(get_user_meta($user_id, $load_address . '_country', true), $load_address . '_');

    foreach ($address_fields as $key => $field) {
      if (isset($_POST[$key])) {
        if ($key == 'billing_floor' || $key == 'billing_apartment' || $key == 'billing_entrance') {
          update_user_meta($user_id, str_replace('billing_', '', $key), wc_clean(wp_unslash($_POST[$key])));
        } else {
          update_user_meta($user_id, $key, wc_clean(wp_unslash($_POST[$key])));
          if ($key == 'billing_first_name' && wc_clean(wp_unslash($_POST[$key])) != '') {
            update_user_meta($user_id, 'first_name', wc_clean(wp_unslash($_POST[$key])));
          }
        }
      }
    }

    wc_add_notice(__('Address updated successfully', 'woocommerce'));
    wp_safe_redirect(wc_get_endpoint_url('edit-address/billing/', '', wc_get_page_permalink('myaccount')));
    exit;
  }
}

add_action('template_redirect', 'custom_save_address');

add_action('woocommerce_after_order_notes', 'custom_add_address_field');

function custom_add_address_field($checkout)
{
  echo '<div id="custom_address_field"><h2>' . __('Custom Address Field') . '</h2>';

  woocommerce_form_field('custom_field', array(
    'type' => 'text',
    'class' => array('custom-field-class form-row-wide'),
    'label' => __('Custom Field'),
    'placeholder' => __('Enter custom data'),
  ), $checkout->get_value('custom_field'));

  echo '</div>';
}

function update_cart_button()
{
  // Получение количества товаров в корзине
  $cart_count = WC()->cart->get_cart_contents_count();
  // $cart_total = WC()->cart->get_cart_total();
  $cart_total = WC()->cart->get_cart_subtotal();
  // $cart_url = wc_get_cart_url();
  $cost_len = strlen(wp_kses_data(WC()->cart->get_cart_subtotal()));

  if ($cost_len == 17) {
    $cart_total = substr(wp_kses_data(WC()->cart->get_cart_subtotal()), 0, 1) . ' ' . substr(wp_kses_data(WC()->cart->get_cart_subtotal()), 1, -1);
  } else if ($cost_len == 18) {
    $cart_total = substr(wp_kses_data(WC()->cart->get_cart_subtotal()), 0, 2) . ' ' . substr(wp_kses_data(WC()->cart->get_cart_subtotal()), 2, -1);
  } else {
    $cart_total = wp_kses_data(WC()->cart->get_cart_subtotal());
  }
  // Формирование ответа
  $response = array(
    'cart_count' => $cart_count,
    'cart_total' => $cart_total,
    // 'cart_url' => $cart_url
  );

  // Отправка JSON ответа
  wp_send_json($response);
}
add_action('wp_ajax_update_cart_button', 'update_cart_button');
add_action('wp_ajax_nopriv_update_cart_button', 'update_cart_button');


add_filter('woocommerce_thankyou_order_received_text', 'custom_order_received_text', 10, 2);

function custom_order_received_text($text, $order)
{
  return 'Ваш заказ принят. Для подтверждения заказа в течении ближайшего времени с вами свяжется оператор. <br> Внимание только подтверждённый с оператором заказ принимается в работу.'; // Укажите нужный текст
}




// фильтор yoast
add_filter('wc_product_post_type_link_product_cat', function ($term, $terms, $post) {

  // Get the primary term as saved by Yoast
  $primary_cat_id = get_post_meta($post->ID, '_yoast_wpseo_primary_product_cat', true);

  // If there is a primary and it's not currently chosen as primary
  if ($primary_cat_id && $term->term_id != $primary_cat_id) {

    // Find the primary term in the term list
    foreach ($terms as $term_key => $term_object) {

      if ($term_object->term_id == $primary_cat_id) {
        // Return this as the primary term
        $term = $terms[$term_key];
        break;
      }
    }
  }

  return $term;
}, 10, 3);













// add_action('woocommerce_thankyou', function () {
//   $response = wp_remote_post('https://webhook.site/9c3d88cb-1e46-45ff-9342-a5ffcb900c9e', [
//     'method' => 'POST',
//     'body' => json_encode(['test' => 'data']),
//     'headers' => ['Content-Type' => 'application/json'],
//   ]);

//   if (is_wp_error($response)) {
//     error_log('Ошибка отправки: ' . $response->get_error_message());
//   } else {
//     error_log('Успешный ответ: ' . wp_remote_retrieve_body($response));
//   }
// }, 10, 1);




// add_action('init', function() {
// add_action('woocommerce_order_status_completed', function() {
//   $response = wp_remote_post('https://webhook.site/9c3d88cb-1e46-45ff-9342-a5ffcb900c9e', [
//   // $response = wp_remote_post('https://business-tool.site/projects/ohpirogi/new.order.php', [
//       'method'  => 'POST',
//       'body'    => json_encode(['test' => 'data']),
//       'headers' => ['Content-Type' => 'application/json'],
//   ]);

//   if (is_wp_error($response)) {
//       error_log('Ошибка отправки: ' . $response->get_error_message());
//   } else {
//       error_log('Успешный ответ: ' . wp_remote_retrieve_body($response));
//   }
// });



// add_action('init', function() {
//   // Данные, которые нужно записать в файл
//   $data = [
//       'test' => 'data',
//       'example' => 'value'
//   ];

//   // Путь для сохранения файла
//   $file_path = ABSPATH . 'wp-content/uploads/test-file.json';

//   // Запись данных в файл JSON
//   file_put_contents($file_path, json_encode($data));

//   // Теперь отправим этот файл через POST-запрос
//   // $response = wp_remote_post('https://webhook.site/9c3d88cb-1e46-45ff-9342-a5ffcb900c9e', [
//   $response = wp_remote_post('https://business-tool.site/projects/ohpirogi/new.order.php', [
//       'method'    => 'POST',
//       'body'      => [
//           'file' => new CURLFile($file_path, 'application/json', 'test-file.json')
//       ],
//   ]);

//   // Проверка на ошибки
//   if (is_wp_error($response)) {
//       error_log('Ошибка отправки: ' . $response->get_error_message());
//   } else {
//       error_log('Успешный ответ: ' . wp_remote_retrieve_body($response));
//   }

//   // (Опционально) Удалите файл после отправки
//   // unlink($file_path);
// });







// add_action('woocommerce_thankyou', 'send_order_data_to_external_url', 10, 1);

// function send_order_data_to_external_url($order_id) {
//     if (!$order_id) return;

//     // Получить данные заказа
//     $order = wc_get_order($order_id);

//     // Формируем массив данных заказа
//     $order_data = [
//         'order_id'      => $order->get_id(),
//         'total'         => $order->get_total(),
//         'currency'      => $order->get_currency(),
//         'customer_name' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
//         'customer_email'=> $order->get_billing_email(),
//         'items'         => [],
//     ];

//     // Добавляем информацию о товарах
//     foreach ($order->get_items() as $item_id => $item) {
//         $product = $item->get_product();
//         $order_data['items'][] = [
//             'product_id'   => $product->get_id(),
//             'name'         => $item->get_name(),
//             'quantity'     => $item->get_quantity(),
//             'subtotal'     => $item->get_subtotal(),
//             'total'        => $item->get_total(),
//         ];
//     }

//     // Укажите URL, на который отправлять данные
//     $endpoint_url = 'https://webhook.site/c67fdb75-ad81-4e08-bb4d-a84fb88c0fc2'; // Используйте https://webhook.site для тестирования

//     // Отправляем данные через cURL
//     $response = wp_remote_post($endpoint_url, [
//         'method'    => 'POST',
//         'body'      => json_encode($order_data),
//         'headers'   => [
//             'Content-Type' => 'application/json',
//         ],
//     ]);

//     // Лог ошибок (опционально)
//     if (is_wp_error($response)) {
//         error_log('Ошибка при отправке данных заказа: ' . $response->get_error_message());
//     }
// }






// // Функция для отправки данных заказа в формате JSON
// function send_order_data_to_external_server($order_id)
// {
//   $order = wc_get_order($order_id);

//   // if ( ! $order ) {
//   //     return;
//   // }

//   // Подготовка данных заказа
//   $order_data = array(
//     'order_id' => $order->get_id(),
//     'order_date' => $order->get_date_created()->format('Y-m-d H:i:s'),
//     'total' => $order->get_total(),
//     'status' => $order->get_status(),
//     'billing' => array(
//       'first_name' => $order->get_billing_first_name(),
//       'last_name' => $order->get_billing_last_name(),
//       'email' => $order->get_billing_email(),
//       'phone' => $order->get_billing_phone(),
//       'address' => $order->get_billing_address_1(),
//       'city' => $order->get_billing_city(),
//       'postcode' => $order->get_billing_postcode(),
//     ),
//     'shipping' => array(
//       'first_name' => $order->get_shipping_first_name(),
//       'last_name' => $order->get_shipping_last_name(),
//       'address' => $order->get_shipping_address_1(),
//       'city' => $order->get_shipping_city(),
//       'postcode' => $order->get_shipping_postcode(),
//     ),
//     'items' => array(),
//   );

//   // Добавляем товары в заказ
//   foreach ($order->get_items() as $item_id => $item) {
//     $order_data['items'][] = array(
//       'product_id' => $item->get_product_id(),
//       'name' => $item->get_name(),
//       'quantity' => $item->get_quantity(),
//       'price' => $item->get_total(),
//     );
//   }

//   // Преобразуем данные в JSON
//   $json_data = wp_json_encode($order_data);

//   // URL внешнего сервера, куда отправляем данные
//   $external_url = 'https://webhook.site/9c3d88cb-1e46-45ff-9342-a5ffcb900c9e';

//   // Отправляем данные на внешний сервер
//   $response = wp_remote_post($external_url, array(
//     'method' => 'POST',
//     'body' => $json_data,
//     'headers' => array(
//       'Content-Type' => 'application/json',
//     ),
//   ));

//   // Проверяем ответ
//   if (is_wp_error($response)) {
//     $error_message = $response->get_error_message();
//     // Логирование ошибки (по необходимости)
//     error_log('Error sending order data: ' . $error_message);
//   } else {
//     // Логирование успешной отправки данных (по необходимости)
//     error_log('Order data sent successfully.');
//   }
// }

// // Подключаем функцию к хуку завершения заказа
// add_action('woocommerce_order_status_completed', 'send_order_data_to_external_server', 10, 1);
















function get_product_categories_json()
{
  $categories = get_terms(array(
    'taxonomy' => 'product_cat', // Таксономия категорий товаров в WooCommerce
    'hide_empty' => false,         // Показывать пустые категории
  ));

  if (is_wp_error($categories)) {
    wp_send_json_error('Ошибка получения категорий');
  }

  $result = array();

  foreach ($categories as $category) {
    $result[] = array(
      'id' => $category->term_id,
      'name' => $category->name,
      'parent' => $category->parent, // ID родительской категории
    );
  }

  wp_send_json($result);
}

// Добавляем кастомный REST API endpoint
add_action('rest_api_init', function () {
  register_rest_route('custom/v1', '/product-categories/', array(
    'methods' => 'GET',
    'callback' => 'get_product_categories_json',
    'permission_callback' => '__return_true' // Разрешаем доступ без авторизации
  ));
});




function get_products_with_variations_json() {
  $args = array(
      'post_type'      => 'product',
      'posts_per_page' => -1, // Получить все товары
      'post_status'    => 'publish',
  );

  $products = get_posts($args);
  $result   = array();

  foreach ($products as $product_post) {
      $product_id = $product_post->ID;
      $product    = wc_get_product($product_id);

      // Получаем ID категорий
      $categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'ids'));

      // Данные товара
      $product_data = array(
          'id'         => $product_id,
          'name'       => $product->get_name(),
          'price'      => $product->get_price(), // Основная цена товара
          'categories' => $categories, // Массив ID категорий
          'variations' => array(), // Сюда добавим вариации
      );

      // Проверяем, является ли товар вариативным
      if ($product->is_type('variable')) {
          $product_data['price'] = null; // Основной товар не имеет фиксированной цены

          $variations = $product->get_children(); // Получаем ID вариаций

          foreach ($variations as $variation_id) {
              $variation = wc_get_product($variation_id);
              $product_data['variations'][] = array(
                  'id'    => $variation_id,
                  'price' => $variation->get_price(),
                  'attributes' => $variation->get_attributes(), // Атрибуты вариации
              );
          }
      }

      $result[] = $product_data;
  }

  wp_send_json($result);
}

// Регистрируем API endpoint
add_action('rest_api_init', function () {
  register_rest_route('custom/v1', '/products/', array(
      'methods'  => 'GET',
      'callback' => 'get_products_with_variations_json',
      'permission_callback' => '__return_true'
  ));
});














function enqueue_admin_scripts() {
  wp_add_inline_script('jquery', "
      jQuery(document).ready(function($) {
          $('#carbon-copy-button-categories').on('click', function() {
              var copyTextСategories = $('#carbon-copy-input-categories');
              copyTextСategories.select();
              document.execCommand('copy');
              alert('Скопировано: ' + copyTextСategories.val());
          });
          $('#carbon-copy-button-products').on('click', function() {
              var copyTextProducts = $('#carbon-copy-input-products');
              copyTextProducts.select();
              document.execCommand('copy');
              alert('Скопировано: ' + copyTextProducts.val());
          });
      });
  ");
}
add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');
?>