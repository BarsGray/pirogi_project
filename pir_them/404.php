<?php

/*
Plugin Name: XML WooCommerce Import by ID
Description: Импорт товаров из XML с русскими тегами, используя <Ид> как SKU
Version: 1.1
Author: Your Name
*/

if (!defined('ABSPATH')) exit;

// ==================== Функция импорта ====================
function xml_woo_import_run() {

    $file = WP_CONTENT_DIR . '/uploads/products.xml';

    if (!file_exists($file)) {
        wp_die('Файл XML не найден!');
    }

    libxml_use_internal_errors(true);
    $xml = simplexml_load_file($file);

    if (!$xml) {
        wp_die('Ошибка загрузки XML');
    }

    foreach ($xml->Товары->Товар as $item) {

        // ===== 1. Основные поля =====
        $sku = (string)$item->{'Ид'}; // используем Ид как SKU
        $name = (string)$item->{'наименование'};
        $description = (string)$item->{'Описание'};
        $weight = (string)$item->{'вес'};
        $length = (string)$item->{'Длина'};
        $width = (string)$item->{'Ширина'};
        $height = (string)$item->{'высота'};

        if (empty($sku)) continue; // пропускаем если нет Ид

        // ===== 2. Проверка существующего товара =====
        $product_id = wc_get_product_id_by_sku($sku);

        if ($product_id) {
            $product = wc_get_product($product_id);
        } else {
            $product = new WC_Product_Simple();
            $product->set_sku($sku);
        }

        $product->set_name($name ?: 'Товар');
        $product->set_description($description ?: '');
        $product->set_status('publish');

        // ===== 3. Размеры и вес =====
        if ($weight) $product->set_weight($weight);
        if ($length) $product->set_length($length);
        if ($width) $product->set_width($width);
        if ($height) $product->set_height($height);

        // ===== 4. Категории =====
        foreach ($item->группы->Ид as $group) {
            $cat_name = (string)$group;
            if (!$cat_name) continue;

            $term = term_exists($cat_name, 'product_cat');
            if (!$term) $term = wp_insert_term($cat_name, 'product_cat');
            if (!is_wp_error($term)) {
                wp_set_object_terms($product->get_id(), (int)$term['term_id'], 'product_cat', true);
            }
        }

        // ===== 5. Атрибуты =====
        $attributes = [];

        if (isset($item->значениеСвойств->значениеСвойства)) {
            foreach ($item->значениеСвойств->значениеСвойства as $prop) {
                $attr_name = (string)$prop->ид; // или <Наименование>
                $attr_value = (string)$prop->значение;
                if ($attr_name && $attr_value) $attributes[$attr_name] = $attr_value;
            }
        }

        if ($attributes) {
            $product_attributes = [];
            foreach ($attributes as $attr_name => $attr_value) {
                $taxonomy = 'pa_' . sanitize_title($attr_name);

                if (!taxonomy_exists($taxonomy)) {
                    register_taxonomy(
                        $taxonomy,
                        'product',
                        [
                            'label' => $attr_name,
                            'public' => true,
                            'hierarchical' => true,
                            'show_ui' => true,
                            'query_var' => true,
                        ]
                    );
                }

                wp_set_object_terms($product->get_id(), $attr_value, $taxonomy);
                $product_attributes[$taxonomy] = [
                    'name' => $taxonomy,
                    'value' => $attr_value,
                    'is_visible' => 1,
                    'is_variation' => 0,
                    'is_taxonomy' => 1
                ];
            }

            $product->set_attributes($product_attributes);
        }

        // ===== 6. Изображение =====
        if (isset($item->{'картинка'}) && !empty((string)$item->{'картинка'})) {
            $image_url = (string)$item->{'картинка'};

            require_once ABSPATH . 'wp-admin/includes/media.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/image.php';

            $image_id = media_sideload_image($image_url, $product->get_id(), null, 'id');
            if (!is_wp_error($image_id)) {
                $product->set_image_id($image_id);
            }
        }

        $product->save();
    }

    echo 'Импорт завершён!';
}

// ==================== Защищённый запуск через админку ====================
add_action('admin_post_run_xml_import', 'xml_woo_import_run');

<?php
get_footer();
























<?php
/*
Plugin Name: XML Import 1C WooCommerce
*/

if (!defined('ABSPATH')) exit;

function xml_woo_import_1c() {

    $file = WP_CONTENT_DIR . '/uploads/products.xml';

    if (!file_exists($file)) {
        wp_die('XML не найден');
    }

    $xml = simplexml_load_file($file);

    if (!$xml) {
        wp_die('Ошибка XML');
    }

    foreach ($xml->Предложения->Предложение as $offer) {

        // ===== 1. SKU (Ид предложения) =====
        $sku = (string)$offer->{'Ид'};
        if (!$sku) continue;

        // ===== 2. Название =====
        $name = (string)$offer->{'Наименование'};

        // ===== 3. Размеры =====
        $width  = (string)$offer->{'Ширина'};
        $length = (string)$offer->{'Длина'};
        $height = (string)$offer->{'Высота'};

        // ===== 4. Картинка =====
        $image = (string)$offer->{'Картинка'};

        // ===== 5. Проверка товара =====
        $product_id = wc_get_product_id_by_sku($sku);

        if ($product_id) {
            $product = wc_get_product($product_id);
        } else {
            $product = new WC_Product_Simple();
            $product->set_sku($sku);
        }

        $product->set_name($name ?: 'Товар');
        $product->set_status('publish');

        // ===== 6. Размеры =====
        if ($width)  $product->set_width($width);
        if ($length) $product->set_length($length);
        if ($height) $product->set_height($height);

        // ===== 7. Атрибуты (Характеристики) =====
        $attributes = [];

        // <ХарактеристикиТовара>
        if (isset($offer->ХарактеристикиТовара->ХарактеристикаТовара)) {
            foreach ($offer->ХарактеристикиТовара->ХарактеристикаТовара as $attr) {
                $attr_name = (string)$attr->Наименование;
                $attr_value = (string)$attr->Значение;

                if ($attr_name && $attr_value) {
                    $attributes[$attr_name] = $attr_value;
                }
            }
        }

        // <ЗначенияСвойств>
        if (isset($offer->ЗначенияСвойств->ЗначенияСвойства)) {
            foreach ($offer->ЗначенияСвойств->ЗначенияСвойства as $prop) {
                $attr_name = (string)$prop->Ид;
                $attr_value = (string)$prop->Значение;

                if ($attr_name && $attr_value) {
                    $attributes[$attr_name] = $attr_value;
                }
            }
        }

        // ===== 8. Запись атрибутов =====
        if ($attributes) {

            $product_attributes = [];

            foreach ($attributes as $attr_name => $attr_value) {

                $taxonomy = 'pa_' . sanitize_title($attr_name);

                if (!taxonomy_exists($taxonomy)) {
                    register_taxonomy(
                        $taxonomy,
                        'product',
                        [
                            'label' => $attr_name,
                            'public' => true,
                            'hierarchical' => true,
                            'show_ui' => true
                        ]
                    );
                }

                wp_set_object_terms($product->get_id(), $attr_value, $taxonomy);

                $product_attributes[$taxonomy] = [
                    'name' => $taxonomy,
                    'value' => $attr_value,
                    'is_visible' => 1,
                    'is_variation' => 0,
                    'is_taxonomy' => 1
                ];
            }

            $product->set_attributes($product_attributes);
        }

        // ===== 9. Сохраняем =====
        $product->save();

        // ===== 10. Картинка =====
        if ($image) {

            require_once ABSPATH . 'wp-admin/includes/media.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/image.php';

            $image_id = media_sideload_image($image, $product->get_id(), null, 'id');

            if (!is_wp_error($image_id)) {
                $product->set_image_id($image_id);
                $product->save();
            }
        }

        error_log("Импорт: {$sku}");
    }

    echo 'Импорт завершён';
}

// запуск
add_action('admin_post_run_xml_import', 'xml_woo_import_1c');


😎










// ===== Атрибуты (ПРАВИЛЬНО) =====
$attributes = [];

if (isset($item->значениеСвойств->значениеСвойства)) {

    foreach ($item->значениеСвойств->значениеСвойства as $prop) {

        $attr_name = (string)$prop->ид; // или Наименование
        $attr_value = (string)$prop->значение;

        if (!$attr_name || !$attr_value) continue;

        $slug = wc_sanitize_taxonomy_name($attr_name);

        // ===== создаём глобальный атрибут если нет =====
        $attribute_id = wc_attribute_taxonomy_id_by_name($slug);

        if (!$attribute_id) {
            $attribute_id = wc_create_attribute([
                'name' => $attr_name,
                'slug' => $slug,
                'type' => 'select',
                'order_by' => 'menu_order',
                'has_archives' => false,
            ]);

            delete_transient('wc_attribute_taxonomies');
        }

        $taxonomy = 'pa_' . $slug;

        // регистрируем таксономию если ещё нет
        if (!taxonomy_exists($taxonomy)) {
            register_taxonomy(
                $taxonomy,
                'product',
                [
                    'hierarchical' => true,
                    'show_ui' => false,
                    'query_var' => true,
                    'rewrite' => false,
                ]
            );
        }

        // добавляем значение
        wp_set_object_terms($product->get_id(), $attr_value, $taxonomy, true);

        $attributes[$taxonomy] = [
            'name' => $taxonomy,
            'value' => '',
            'is_visible' => 1,
            'is_variation' => 0,
            'is_taxonomy' => 1,
        ];
    }

    $product->set_attributes($attributes);
}😎
























function clean_duplicate_products() {

    $products = get_posts([
        'post_type' => 'product',
        'numberposts' => -1,
    ]);

    $by_sku = [];
    $by_name = [];

    foreach ($products as $post) {

        $product = wc_get_product($post->ID);
        $sku = $product->get_sku();
        $name = $post->post_title;

        // ===== 1. Удаляем без SKU =====
        if (!$sku) {
            wp_delete_post($post->ID, true);
            continue;
        }

        // ===== 2. Дубли по SKU =====
        if (isset($by_sku[$sku])) {
            wp_delete_post($post->ID, true);
            continue;
        }

        $by_sku[$sku] = $post->ID;

        // ===== 3. Дубли по названию =====
        if (isset($by_name[$name])) {
            // если уже есть товар с таким именем — удаляем
            wp_delete_post($post->ID, true);
            continue;
        }

        $by_name[$name] = $post->ID;
    }

    echo "Очистка завершена";
}