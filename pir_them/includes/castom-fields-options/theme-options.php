<?php
if (!defined('ABSPATH')) {
  exit;
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;


$category_options = [];

$categories = get_terms();
foreach ($categories as $category) {
  if ($category->taxonomy == 'product_cat') {
    $category_options[$category->slug] = $category->name;
  }
}
// echo '<pre>';
// var_dump($category_options);
// echo '</pre>';


$employees_labels = array(
  'plural_name' => 'Баннер',
  'singular_name' => 'Баннер',
);

Container::make('theme_options', __('Наши акции'))
  ->add_tab(__('Баннер'), array(
    // ->add_fields(array(
    Field::make('complex', 'crb_slider', __('Наши акции'))
      // ->setup_labels($employees_labels)
      ->set_classes('crb_slider_day_box')
      ->add_fields(array(
        Field::make('text', 'title', __('Наименование акции'))
          ->set_classes('crb_slider_day_box_ittle')
          ->set_width(20),
        Field::make('date', 'crb_event_date', __('Дата'))
          ->set_classes('crb_slider_day_box_date')
          ->set_attribute('placeholder', __('Укажите дату'))
          ->set_help_text('Если оставить поле даты пустым, акция будет отображаться всегда.')
          ->set_storage_format('d.m.Y')
          ->set_width(5),
        Field::make('complex', 'crb_slide', __('Баннеры'))
          ->set_classes('crb_slider_day_box_complex')
          ->set_help_text('Если баннер один, то рекомендуется его продублировать для корректной работы слайдера.')
          ->setup_labels($employees_labels)
          ->add_fields(array(
            Field::make('image', 'photo', __('Slide Photo'))
              ->set_classes('crb_slider_day_box_photo')
              ->set_value_type('url')
              ->set_width(50),
            Field::make('select', 'crb_set_discount_to_term', __('Акция для категории:'))
              ->set_options($category_options)
              ->set_width(24)
              ->set_help_text('Укажите категорию товаров, для которых действует акция'),
            Field::make('text', 'crb_set_discount_procent', __('Процент:'))
              ->set_width(10),
            Field::make('text', 'link', __('Ссылка на страницу акционной категории'))
              ->set_width(24),
          ))
          ->set_collapsed(true)
          ->set_width(60),
      )),
  ))
  ->add_tab(__('Общие акции'), array(
    Field::make('text', 'crb_set_registration_bonus', __('Подарочные бонусы за регистрацию'))
      ->set_width(24),

    Field::make('text', 'crb_set_percentage_for_pickup', __('Процент за самовывоз'))
      ->set_width(24),
    Field::make('separator', 'crb_separator_quantity', __('Скидка за сет'))
      ->set_width(49),
    Field::make('text', 'crb_set_percentage_for_birthday', __('Процент за день рождения'))
      ->set_width(24),
    Field::make('separator', 'crb_separator_bell', __(''))
      ->set_width(24),

    Field::make('text', 'crb_set_quantity_products', __('Колличество товара'))
      ->set_width(24),
    Field::make('text', 'crb_set_procent_discount_on_quantity', __('Процент скидки'))
      ->set_width(24),
    Field::make('separator', 'crb_separator_volume', __('Скидки за объем')),
    Field::make('complex', 'crb_volume', __('Скидки на сумму заказа'))
      ->add_fields(array(
        Field::make('text', 'crb_volume_sum', __('Сумма заказа'))
          ->set_width(24),
        Field::make('text', 'crb_volume_procent_discount', __('Процент скидки'))
          ->set_width(24),
      )),
  ));



Container::make('theme_options', __('Настройки сайта'))
  // ->add_tab(__('Акции'), array(
  // // Field::make('text', 'crb_set_discount_to_term', __('Акция для категорий:'))
  // // ->set_width(50)
  // // ->set_help_text('Укажите ярлык категории товаров, для которых действует скидка 5% (если акция действует для нескольких категорий, укажите их через запятую)'),
  // Field::make('complex', 'crb_slider', __('Slider'))
  // // ->setup_labels($employees_labels)
  // ->add_fields(array(
  // Field::make('date', 'crb_event_date', __('Дата'))
  // ->set_attribute('placeholder', __('Укажите дату'))
  // ->set_storage_format('d.m.Y'),
  // Field::make('complex', 'crb_slide', __('Slides'))
  // // ->setup_labels($employees_labels)
  // ->add_fields(array(
  // // Field::make('text', 'title', __('Заголовок')),
  // Field::make('text', 'link', __('Ссылка на страницу акционной категории')),
  // Field::make('image', 'photo', __('Slide Photo'))
  // ->set_value_type('url')
  // ->set_width(24),
  // Field::make('text', 'crb_set_discount_to_term', __('Акция для категории:'))
  // ->set_width(24)
  // ->set_help_text('Укажите ярлык категории товара, для которого действует скидка'),
  // Field::make('text', 'crb_set_discount_procent', __('Процент:'))
  // ->set_width(24),
  // )),
  // )),

  // ))
  // ->add_tab(__('Основная информация'), array(
  ->add_fields(array(
    Field::make('image', 'crb_logo', __('Логотип'))
      ->set_width(24)
      ->set_value_type('url'),
    Field::make('text', 'crb_phone_number', __('Номер телефона'))
      ->set_attribute('placeholder', '*(***)***-**-**')
      ->set_width(24),
    Field::make('text', 'crb_schedule', __('График работы'))
      ->set_width(24),
    Field::make('text', 'crb_email', __('Email'))
      ->set_width(24),
    Field::make('text', 'crb_address_header', __('Адрес в шапке'))
      ->set_width(50),
    Field::make('text', 'crb_address_footer', __('Адрес в подвале'))
      ->set_width(50),
    Field::make('text', 'crb_address_telegram', __('Telegram'))
      ->set_width(24),
    Field::make('text', 'crb_address_whatsapp', __('WhatsApp'))
      ->set_width(24),
    Field::make('text', 'crb_address_viber', __('Viber'))
      ->set_width(24),
    // Field::make('text', 'crb_home_product', __('Товары на главной странице'))
    // ->set_width(100)
    // ->set_help_text('Укажите ярлык категории товаров, которые необходимо вывести на главной странице'),
    Field::make('text', 'crb_bottom_footer_inn', __('ИНН:'))
      ->set_width(50),
    Field::make('text', 'crb_bottom_footer_ogrn', __('ОГРН:'))
      ->set_width(50),
    Field::make('text', 'crb_bottom_footer_copy', __('Копирайт')),
    Field::make('text', 'crb_bottom_footer_policy', __('Политики конфиденциальности'))
      ->set_width(40)
      ->set_help_text('Укажите ссылку на страницу политики конфиденциальности'),
    Field::make('text', 'crb_bottom_footer_terms', __('Пользовательское соглашение'))
      ->set_width(40)
      ->set_help_text('Укажите ссылку на страницу пользовательского соглашения'),
    // )

    Field::make('html', 'custom_field_html')
      ->set_html('
      <p style="color: gray;">API Категории товаров</p>
      <input type="text" style="width:40%;" id="carbon-copy-input-categories" value="https://ohpirogi24.ru/wp-json/custom/v1/product-categories/" />
      <button type="button" class="button button-primary" id="carbon-copy-button-categories">Копировать</button>
      <br>
      <br>
      <p style="color: gray;">API Товары</p>
      <input type="text" style="width:40%;" id="carbon-copy-input-products" value="https://ohpirogi24.ru/wp-json/custom/v1/products/" />
      <button type="button" class="button button-primary" id="carbon-copy-button-products">Копировать</button>
      <br>
      <br>
      <p style="color: gray;">API: список id заказов отправленных в CRM</p>
      <input type="text" style="width:40%;" id="carbon-copy-input-orders" value="https://ohpirogi24.ru/wp-json/ohpir/v1/log_order/" />
      <button type="button" class="button button-primary" id="carbon-copy-button-orders">Копировать</button>
    '),
  ));


Container::make('post_meta', __('Дополнительные опции товара'))
  ->where('post_type', '=', 'product')
  ->add_tab(__('Состав'), array(
    // ->show_on_post_type('product')
    // ->add_fields(array(
    Field::make('text', 'crb_product_ccal', ('ККАЛ'))
      ->set_width(24),
    Field::make('text', 'crb_product_belki', ('Белки'))
      ->set_width(24),
    Field::make('text', 'crb_product_zhiri', ('Жиры'))
      ->set_width(24),
    Field::make('text', 'crb_product_uglev', ('Углеводы'))
      ->set_width(24),
  ))
  ->add_tab(__('Слайдер'), array(
    Field::make('text', 'crb_product_slider_title', ('Заголовок для сдайдера')),
    // ->set_width(24),
    Field::make('text', 'crb_product_short_slider', ('Шорткод для сдайдера')),
    // ->set_width(24),
  ));
// ));


// Container::make('term_meta', 'Какие-то настройки таксономии')
// ->add_fields(array(
// Field::make('text', 'crb_set_discount_to_term', __('Акция для категорий:'))
// ->set_width(50),
// ));



// Container::make('post_swioer', __('Слайдер'))
// // ->show_on_post_type('product')
// ->add_fields(array(
// Field::make('text', 'crb_product_short_slider', ('Шорткод для сдайдера'))
// ->set_width(24),
// ));